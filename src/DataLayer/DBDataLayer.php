<?php
    namespace DataLayer;

    use \Domain\Book;
    use \Domain\Category;
    use \Domain\User;

    class DBDataLayer implements DataLayer {

        private $server;
        private $userName;
        private $password;
        private $database;

        public function __construct($server, $userName, $password, $database) {
            $this->server = $server;
            $this->userName = $userName;
            $this->password = $password;
            $this->database = $database;
        }

        private function getConnection() {
            $conn = new \mysqli($this->server, $this->userName, $this->password, $this->database);
            if (!$conn) {
                die('Unable to connect to database: ' . mysqli_connect_error());
            }
            return $conn;
        }

        private function executeQuery($connection, $query) {
            $result = $connection->query($query);
            if (!$result) {
                die('Error in query `$query`: ' . $connection->error);
            }
            return $result;
        }

        private function executeStatement($connection, $query, $bindFunc) {
            $statement = $connection->prepare($query);
            if (!$statement) {
                die('Error in prepared statement `$query`: ' . $connection->error);
            }
            $bindFunc($statement);
            if (!$statement->execute()) {
                die('Error executing prepared statement `$query`: ' . $connection->error);
            }
            return $statement;
        }

        public function getCategories() {
            $categories = array();
            
            $conn = $this->getConnection();
            $res = $this->executeQuery($conn, 'SELECT id, name FROM categories');
            while ($cat = $res->fetch_object()) {
                $categories[] = new Category($cat->id, $cat->name);
            }
            $res->close();
            $conn->close();

            return $categories;
        }
    
        public function getBooksForCategory($categoryId) {
            $books = array();

            $conn = $this->getConnection();
            $stat = $this->executeStatement(
                $conn, 
                'SELECT id, categoryId, title, author, price FROM books WHERE categoryId = ?',
                function($s) use ($categoryId) {
                    $s->bind_param('i', $categoryId);
                }
            );
            $stat->bind_result($id, $categoryId, $title, $author, $price);
            while ($stat->fetch()) {
                $books[] = new Book($id, $categoryId, $title, $author, $price);
            }
            $stat->close();
            $conn->close();

            return $books;
        }
    
        public function getBooksForSearchCriteria($title) {
            $title = "%$title%";
            $books = array();

            $conn = $this->getConnection();
            $stat = $this->executeStatement(
                $conn,
                'SELECT id, categoryId, title, author, price FROM books WHERE title LIKE ?',
                function($s) use ($title) {
                    $s->bind_param('s', $title);
                }
            );
            $stat->bind_result($id, $categoryId, $title, $author, $price);

            while ($stat->fetch()) {
                $books[] = new Book($id, $categoryId, $title, $author, $price);
            }

            $stat->close();
            $conn->close();

            return $books;
        }
    
        public function createOrder($userId, $bookIds, $nameOnCard, $cardNumber) {
            $conn = $this->getConnection();
            $conn->autocommit(false);

            $stat = $this->executeStatement(
                $conn,
                'INSERT INTO orders (userId, creditCardHolder, creditCardNumber) VALUES (?, ?, ?)',
                function($s) use ($userId, $nameOnCard, $cardNumber) {
                    $s->bind_param('iss', $userId, $nameOnCard, $cardNumber);
                }
            );
            $orderId = $stat->insert_id;
            $stat->close();

            foreach($bookIds as $bookId) {
                $this->executeStatement($conn,
                    'INSERT INTO orderedBooks (orderId, bookId) VALUES(?, ?)',
                    function($s) use ($orderId, $bookId) {
                        $s->bind_param('ii', $orderId, $bookId);
                    }
                )->close();
            }

            $conn->commit();
            $conn->close();

            return $orderId;
        }
    
        public function getUser($id) {
            $user = null;
            
            $conn = $this->getConnection();
            $stat = $this->executeStatement(
                $conn,
                'SELECT id, userName FROM users WHERE id = ?',
                function($s) use ($id) {
                    $s->bind_param('i', $id);
                }
            );
            $stat->bind_result($id, $userName);

            if ($stat->fetch()) {
                $user = new User($id, $userName);
            }

            $stat->close();
            $conn->close();

            return $user;
        }
    
        public function getUserForUserNameAndPassword($userName, $password) {
            $user = null;

            $conn = $this->getConnection();
            $stat = $this->executeStatement(
                $conn,
                'SELECT id, passwordHash FROM users WHERE userName = ?',
                function($s) use ($userName) {
                    $s->bind_param('s', $userName);
                }
            );
            $stat->bind_result($id, $passwordHash);
            
            if ($stat->fetch()  && password_verify($password, $passwordHash)) {
                $user = new User($id, $userName);
            }

            $stat->close();
            $conn->close();

            return $user;
        }
    }