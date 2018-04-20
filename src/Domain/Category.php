<?php
    namespace Domain;

    class Category extends Entity {
        
        private $name;

        public function getName() {
            return $this->name;
        }

        public function __construct($id, $name) {
            parent::__construct($id);
            $this->name = $name;
        }
        
    }