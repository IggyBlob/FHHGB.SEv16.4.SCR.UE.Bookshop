<?php
    namespace Controllers;

    class Order extends \Framework\Controller {

        const PARAM_NAME_ON_CARD = 'noc';
        const PARAM_CARD_NUMBER = 'cn';
        const PARAM_ORDER_ID = 'oid';

        private $dataLayer;
        private $shoppingCart;

        public function __construct(\DataLayer\DataLayer $dataLayer, \BusinessLogic\ShoppingCart $shoppingCart) {
            $this->dataLayer = $dataLayer;
            $this->shoppingCart = $shoppingCart;
        }

        public function GET_Create() {
            $cartSize = $this->shoppingCart->size();
            if ($cartSize == 0) {
                return $this->renderView('orderFormEmptyCart', array());
            }

            return $this->renderView('orderForm', array(
                'cartSize' => $cartSize,
                'nameOnCard' => $this->getParam(self::PARAM_NAME_ON_CARD), 
                'cardNumber' => $this->getParam(self::PARAM_CARD_NUMBER)
            ));
        }

        public function POST_Create() {

        }
    }