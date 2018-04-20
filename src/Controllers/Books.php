<?php
    namespace Controllers;

    class Books extends \Framework\Controller {

        const PARAM_CATEGORY_ID = 'cid';
        const PARAM_TITLE = 'title';

        private $dataLayer;

        public function __construct(\DataLayer\DataLayer $dataLayer) {
            $this->dataLayer = $dataLayer;
        }
        
        public function GET_Index() {
            return $this->renderView('booklist', array(
                'categories' => $this->dataLayer->getCategories(),
                'selectedCategoryId' => $this->getParam(self::PARAM_CATEGORY_ID),
                'books' => $this->hasParam(self::PARAM_CATEGORY_ID) ?
                    $this->dataLayer->getBooksForCategory($this->getParam(self::PARAM_CATEGORY_ID)) : null
            ));
        }

        public function GET_Search() {
            return $this->renderView('bookSearch', array());
        }
    }