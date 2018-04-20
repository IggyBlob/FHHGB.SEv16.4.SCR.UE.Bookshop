<?php
    namespace Framework;

    final class MVC {
        private function __construct() { }
        
        const PARAM_CONTROLLER = 'c';
        const PARAM_ACTION = 'a';

        const DEFAULT_CONTROLLER = 'Home';
        const DEFAULT_ACTION = 'Index';

        const CONTROLLER_NAMESPACE = '\\Controllers';

        private static $viewPath = 'views';

        public static function getViewPath() {
            return self::$viewPath;
        }

        public static function buildActionLink($action, $controller, $params) {
            $res = '?' . self::PARAM_ACTION . '=' . rawurlencode($action) . '&' . self::PARAM_CONTROLLER . '=' . rawurlencode($controller);
            if (is_array($params)) {
                foreach ($params as $name => $value) {
                    $res .= '&' . rawurlencode($name) . '=' . rawurlencode($value);
                }
            }
            return $res;
        }

        public static function handleRequest() {
            $controllerName = isset($_REQUEST[self::PARAM_CONTROLLER]) ? $_REQUEST[self::PARAM_CONTROLLER] : self::DEFAULT_CONTROLLER;
            $controller = self::CONTROLLER_NAMESPACE . "\\$controllerName";

            $method = $_SERVER['REQUEST_METHOD'];
            $action = isset($_REQUEST[self::PARAM_ACTION]) ? $_REQUEST[self::PARAM_ACTION] : self::DEFAULT_ACTION;

            $m = $method . '_' . $action;


            //(new $controller)->$m();
            \Framework\Injector::resolve($controller)->$m();
        }

    }