<?php
    namespace DataLayer;

    interface DataLayer {
        public function getCategories();
        public function getBooksForCategory($categoryId);
        public function getBooksForSearchCriteria($title);
        public function createOrder($bookIds, $nameOnCard, $cardNumber);
    }