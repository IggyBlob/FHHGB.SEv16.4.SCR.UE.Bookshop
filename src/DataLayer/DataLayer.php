<?php
    namespace DataLayer;

    interface DataLayer {
        public function getCategories();
        public function getBooksForCategory($categoryId);
        public function getBooksForSearchCriteria($title);
        public function createOrder($userId, $bookIds, $nameOnCard, $cardNumber);
        public function getUser($id);
        public function getUserForUserNameAndPassword($userName, $password);
    }