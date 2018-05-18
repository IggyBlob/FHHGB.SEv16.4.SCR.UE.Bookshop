<?php
    namespace Controllers;

    class Books extends \Framework\Controller {

        const PARAM_CATEGORY_ID = 'cid';
        const PARAM_TITLE = 'title';
        
        private $dataLayer;
        private $shoppingCart;
        private $authenticationManager;

        public function __construct(\DataLayer\DataLayer $dataLayer, \BusinessLogic\ShoppingCart $shoppingCart, \BusinessLogic\AuthenticationManager $authenticationManager) {
            $this->dataLayer = $dataLayer;
            $this->shoppingCart = $shoppingCart;
            $this->authenticationManager = $authenticationManager;
        }
        
        public function GET_Index() {
            return $this->renderView('bookList', array(
                'user' => $this->authenticationManager->getAuthenticatedUser(),
                'categories' => $this->dataLayer->getCategories(),
                'selectedCategoryId' => $this->getParam(self::PARAM_CATEGORY_ID),
                'books' => $this->hasParam(self::PARAM_CATEGORY_ID) ?
                    $this->dataLayer->getBooksForCategory($this->getParam(self::PARAM_CATEGORY_ID)) : 
                    null, 'cart' => $this->shoppingCart->getAll(),
                    'context' => $this->buildActionLink('Index', 'Books', array(self::PARAM_CATEGORY_ID => $this->getParam(self::PARAM_CATEGORY_ID)))
            ));
        }

        public function GET_Search() {
            return $this->renderView('bookSearch', array(
                'user' => $this->authenticationManager->getAuthenticatedUser(),
                'title' => $this->getParam(self::PARAM_TITLE),
                'books' => $this->hasParam(self::PARAM_TITLE) ? 
                    $this->dataLayer->getBooksForSearchCriteria($this->getParam(self::PARAM_TITLE)) : 
                    null, 'cart' => $this->shoppingCart->getAll(),
                    'context' => $this->buildActionLink('Search', 'Books', array(self::PARAM_TITLE => $this->getParam(self::PARAM_TITLE)))
            ));
        }
    }