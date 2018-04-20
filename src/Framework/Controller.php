<?php
    namespace Framework;

    class Controller {
        public final function hasParam($id) {
            return isset($_REQUEST[$id]);
        }

        public final function getParam($id, $defaultValue = null) {
            return isset($_REQUEST[$id]) ? $_REQUEST[$id] : $defaultValue;
        }
        
        public final function renderView($view, $model = array()) {
            ViewRenderer::renderView($view, $model);
        }
    }