<?php
    namespace Domain;

    class Entity {
        private $id;

        public function getId() {
            return $this->id;
        }

        public function __construct($id) {
            $this->id = $id;
        }
    }