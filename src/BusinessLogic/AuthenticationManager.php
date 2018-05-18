<?php
    namespace BusinessLogic;

    final class AuthenticationManager {

        private $dataLayer;
        private $session;

        const SESSION_USER_ID = 'userId';

        public function __construct(\DataLayer\DataLayer $dataLayer, \BusinessLogic\Session $session) {
            $this->dataLayer = $dataLayer;
            $this->session = $session;
        }

        public function authenticate($userName, $password) {
            $user = $this->dataLayer->getUserForUserNameAndPassword($userName, $password);
            if ($user != null) {
                $this->session->storeValue(self::SESSION_USER_ID, $user->getId());
                return true;
            }
            self::signOut();
            return false;
        }

        public function signOut() {
            $this->session->deleteValue(self::SESSION_USER_ID);
        }

        public function isAuthenticated() {
            return $this->session->hasValue(self::SESSION_USER_ID);
        }

        public function getAuthenticatedUser() {
            return $this->isAuthenticated() ? $this->dataLayer->getUser($this->session->getValue(self::SESSION_USER_ID)) : null;
        }
    }