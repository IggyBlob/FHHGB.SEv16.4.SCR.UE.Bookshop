<?php
    namespace BusinessLogic;

    final class ShoppingCart {
        private $session;

        public function __construct(\BusinessLogic\Session $session){
            $this->session = $session;
        }

        const SESSION_CART = 'cart';

        private function getCart() {
            return $this->session->getValue(self::SESSION_CART, array());
        }

        private function storeCart($cart) {
            $this->session->storeValue(self::SESSION_CART, $cart);
        }

        public function add($bookId) {
            $c = $this->getCart();
            $c[$bookId] = $bookId;  // pretty strange, instead of storing the id twice the number of items would be a better choice
            $this->storeCart($c);
        }

        public function remove($bookId) {
            $c = $this->getCart();
            unset($c[$bookId]);
            $this->storeCart($c);
        }

        public function contains($bookId) {
            return array_key_exists($bookId, $this->getCart());
        }

        public function clear() {
            $this->storeCart(array());
        }

        public function size() {
            return sizeof($this->getCart());
        }

        public function getAll() {
            return $this->getCart();
        }
    }