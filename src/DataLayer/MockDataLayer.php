<?php
namespace DataLayer;

use \Domain\Book;
use \Domain\Category;
//use \Domain\User;

class MockDataLayer implements DataLayer {
  private $__categories;
	private $__books;
	//private $__users;

	public function __construct() {
		$this->__categories = array(1 => new Category(1, "Mobile & Wireless Computing"),
			2 => new Category(2, "Functional Programming"),
			3 => new Category(3, "C / C++"),
			4 => new Category(4, "<< New Publications >>"));

		$this->__books = array(1 => new Book(1, 1, "Hello, Android:\nIntroducing Google's Mobile Development Platform", "Ed Burnette", 19.97),
			2 => new Book(2, 1, "Android Wireless Application Development", "Shane Conder, Lauren Darcey", 31.22),
			5 => new Book(5, 1, "Professional Flash Mobile Development", "Richard Wagner", 19.90),
			7 => new Book(7, 1, "Mobile Web Design For Dummies", "Janine Warner, David LaFontaine", 16.32),
			11 => new Book(11, 2, "Introduction to Functional Programming using Haskell", "Richard Bird", 74.75),
			//book with bad title to show scripting attack - add for scripting attack demo only
			12 => new Book(12, 2, "Scripting (Attacks) for Beginners - <script type=\"text/javascript\">alert('All your base are belong to us!');</script>", "John Doe", 9.99),
			14 => new Book(14, 2, "Expert F# (Expert's Voice in .NET)", "Antonio Cisternino, Adam Granicz, Don Syme", 47.64),
			16 => new Book(16, 3, "C Programming Language\n(2nd Edition)", "Brian W. Kernighan, Dennis M. Ritchie", 48.36),
			27 => new Book(27, 3, "C++ Primer Plus\n(5th Edition)", "Stephan Prata", 36.94),
			29 => new Book(29, 3, "The C++ Programming Language", "Bjarne Stroustrup", 67.49));

		//$this->__users = array(1 => new User(1, "scr4"));
	}

	public function getCategories() {
		return $this->__categories;
	}

	public function getBooksForCategory($categoryId) {
		$res = array();
		foreach ($this->__books as $book) {
			if ($book->getCategoryId() == $categoryId) {
				$res[] = $book;
			}
		}
		return $res;
	}

	public function getBooksForSearchCriteria($title) {
		$res = array();
		foreach ($this->__books as $book) {
			$titleOk = $title == '' || stripos($book->getTitle(), $title) !== false;
			if($titleOk) {
				$res[] = $book;
			}
		}
		return $res;
	}

	public function createOrder($bookIds, $nameOnCard, $cardNumber) {
		return rand();
	}
}