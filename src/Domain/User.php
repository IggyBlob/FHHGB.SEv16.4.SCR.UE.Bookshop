<?php
    namespace Domain;

    class User extends Entity {

        private $userName;

        public function __construct($id, $userName) {
            parent::__construct($id);
            $this->userName =  $userName;
        }
        
        public function getUserName(){
            return $this->userName;
        }
    }