<?php
    namespace DataLayer;

    interface DataLayer {
        public function getCategories();
        public function getBooksForCategory($categoryId);
    }