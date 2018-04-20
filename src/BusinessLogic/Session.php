<?php
    namespace BusinessLogic;

    final class Session {
        public function __construct() {
            session_start();
        }

        public function hasValue($key) {
            return isset($_SESSION[$key]);
        }

        public function getValue($key, $defaultValue = null) {
            return $this->hasValue($key) ? $_SESSION[$key] : $defaultValue;
        }

        public function storeValue($key, $value) {
            $_SESSION[$key] = $value;
        }

        public function deleteValue($key) {
            unset($_SESSION[$key]);
        }
    }
