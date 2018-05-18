<?php
    namespace Controllers;

    class Cart extends \Framework\Controller {

        const PARAM_BOOK_ID = 'bid';
        const PARAM_CONTEXT = 'ctx';

        private $shoppingCart;

        public function __construct(\BusinessLogic\ShoppingCart $shoppingCart) {
            $this->shoppingCart = $shoppingCart;
        }

        public function POST_Add() {
            $this->shoppingCart->add($this->getParam(self::PARAM_BOOK_ID));
            return $this->redirectToUrl($this->getParam(self::PARAM_BOOK_ID));
        }

        public function POST_Remove() {
            $this->shoppingCart->remove($this->getParam(self::PARAM_BOOK_ID));
            return $this->redirectToUrl($this->getParam(self::PARAM_BOOK_ID));
        }

    }