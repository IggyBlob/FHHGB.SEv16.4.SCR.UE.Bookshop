<?php
    namespace Controllers;

    class Order extends \Framework\Controller {

        const PARAM_NAME_ON_CARD = 'noc';
        const PARAM_CARD_NUMBER = 'cn';
        const PARAM_ORDER_ID = 'oid';

        private $dataLayer;
        private $shoppingCart;
        private $authenticationManager;

        public function __construct(\DataLayer\DataLayer $dataLayer, \BusinessLogic\ShoppingCart $shoppingCart, \BusinessLogic\AuthenticationManager $authenticationManager) {
            $this->dataLayer = $dataLayer;
            $this->shoppingCart = $shoppingCart;
            $this->authenticationManager = $authenticationManager;
        }

        public function GET_Create() {

            // TODO: ensure that user is logged in

            $cartSize = $this->shoppingCart->size();
            if ($cartSize == 0) {
                return $this->renderView('orderFormEmptyCart', array(
                    'user' => $this->authenticationManager->getAuthenticatedUser()
                ));
            }

            return $this->renderView('orderForm', array(
                'user' => $this->authenticationManager->getAuthenticatedUser(),
                'cartSize' => $cartSize,
                'nameOnCard' => $this->getParam(self::PARAM_NAME_ON_CARD), 
                'cardNumber' => $this->getParam(self::PARAM_CARD_NUMBER)
            ));
        }

        public function POST_Create() {

            // TODO: ensure that user is logged in

            $cartSize = $this->shoppingCart->size();
            if ($cartSize == 0) {
                return $this->renderView('orderFormEmptyCart', array(
                    'user' => $this->authenticationManager->getAuthenticatedUser()
                ));
            }

            $errors = array();
            $nameOnCard = $this->hasParam(self::PARAM_NAME_ON_CARD) ? 
                trim($this->getParam(self::PARAM_NAME_ON_CARD)) : 
                null;
            if ($nameOnCard == null || strlen($nameOnCard) == 0) {
                $errors[] = 'Invalid name on card.';
            }
            $cardNumber = $this->hasParam(self::PARAM_CARD_NUMBER) ? 
                str_replace(' ', '', $this->getParam(self::PARAM_CARD_NUMBER)) : 
                null;
            if ($cardNumber == null || strlen($cardNumber) != 16 || !ctype_digit($cardNumber)) {
                $errors[] = 'Invalid card number. Card number must contain sixteen digits.';
            }

            if (count($errors) > 0) {
                return $this->renderView('orderForm', array(
                    'user' => $this->authenticationManager->getAuthenticatedUser(),
                    'cartSize' => $cartSize,
                    'nameOnCard' => $nameOnCard,
                    'cardNumber' => $cardNumber,
                    'errors' => $errors
                ));
            }

            $userId = $this->authenticationManager->getAuthenticatedUser()->getId();
            $orderId = $this->dataLayer->createOrder($userId, $this->shoppingCart->getAll(), $nameOnCard, $cardNumber);
            if ($orderId === false) {
                return $this->renderView('orderForm', array(
                    'user' => $this->authenticationManager->getAuthenticatedUser(),
                    'cartSize' => $cartSize,
                    'nameOnCard' => $nameOnCard,
                    'cardNumber' => $cardNumber,
                    'errors' => array('Input Error: Could not create order.')
                ));
            }

            $this->shoppingCart->clear();
            return $this->redirect('ShowSummary', 'Order', array(
                self::PARAM_ORDER_ID => $orderId
            ));
        }

        public function GET_ShowSummary() {
            return $this->renderView('orderSummary', array(
                'user' => $this->authenticationManager->getAuthenticatedUser(),
                'orderId' => $this->getParam(self::PARAM_ORDER_ID)
            ));
        }
    }