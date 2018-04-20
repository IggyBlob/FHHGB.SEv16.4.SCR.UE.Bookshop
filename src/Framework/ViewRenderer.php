<?php
    namespace Framework;

    final class ViewRenderer {
        private function __construct() {
            
        }

        public static function renderView($view, $model) {
            require(MVC::getViewPath() . "/$view.inc");
        }

        private static function htmlOut($string) {
            echo(nl2br(htmlentities($string)));
        }

        private static function actionLink($content, $action, $controller, $params = null, $cssClass = null) {
            $cc = $cssClass != null ? " class=\"$cssClass\"" : "";
            $url = MVC::buildActionLink($action, $controller, $params);
            $link = <<<LINK
<a href="$url"$cc>
LINK;
            echo($link);
            echo($content);
            echo('</a>');
        }
    }