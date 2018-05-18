<?php
    namespace Controllers;

    class User extends \Framework\Controller {
    
        private $authenticationManager;

        const PARAM_USER_NAME = 'un';
        const PARAM_PASSWORD = 'pwd';

        public function __construct(\BusinessLogic\AuthenticationManager $authenticationManager) {
            $this->authenticationManager = $authenticationManager;
        }
    
        public function GET_LogIn() {
            if ($this->authenticationManager->isAuthenticated()) {
                return $this->redirect('Index', 'Home');
            }
            return $this->renderView('login', array(
                'user' => $this->authenticationManager->getAuthenticatedUser(),
                'userName' => $this->getParam(self::PARAM_USER_NAME)
            ));
        }

        public function POST_LogIn() {
            if (!$this->authenticationManager->authenticate(
                $this->getParam(self::PARAM_USER_NAME), 
                $this->getParam(self::PARAM_PASSWORD)
                )) {
                return $this->renderView('login', array(
                    'user' => $this->authenticationManager->getAuthenticatedUser(),
                    'userName' => $this->getParam(self::PARAM_USER_NAME),
                    'errors' => array('Invalid user name or password.')
                ));
            }
            return $this->redirect('Index', 'Home');
        }

        public function POST_LogOut() {
            $this->authenticationManager->signOut();
            return $this->redirect('Index', 'Home');
        }
    }
