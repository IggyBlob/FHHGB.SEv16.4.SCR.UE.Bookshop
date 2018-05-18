<?php
    namespace Framework;

    final class Injector {
        private function __construct() {}

        private static $instances;
        private static $singletonFlags;
        private static $classNames;
        private static $ctorParameters;

        public static function register($serviceName, $isSingleton = false, $className = null, $ctorParameters = null) {
            self::$singletonFlags[$serviceName] = $isSingleton;
            self::$classNames[$serviceName] = $className;
            self::$ctorParameters[$serviceName] = $ctorParameters;
        }

        public static function resolve($serviceName) {
            if (isset(self::$instances[$serviceName])) {
                return self::$instances[$serviceName];
            }

            $className = isset(self::$classNames[$serviceName]) && self::$classNames[$serviceName] != null ? self::$classNames[$serviceName] : $serviceName;

            $actualParams = array();
            $rClass = (new \ReflectionClass($className));
            if ($rClass == null) {
                die("Cannot find class '$className'.");
            }
            $rCtor = $rClass->getConstructor();
            if ($rCtor != null) {
                foreach ($rCtor->getParameters() as $rParam) {
                    if (isset(self::$ctorParameters[$serviceName]) && isset(self::$ctorParameters[$serviceName][$rParam->getName()])) {
                        $actualParams[] = self::$ctorParameters[$serviceName][$rParam->getName()];
                    }
                    else if ($rParam->isOptional()) {
                        $actualParams[] = $rParam->getDefaultValue();
                    } 
                    else if ($rParam->getClass() != null) {
                        $actualParams[] = self::resolve($rParam->getClass()->name);
                    }
                    else {
                        die("Cannot resolve constructor parameter '{$rParam->getName()}' for class '$className'.");
                    }
                }
            }

            $instance = new $className(...$actualParams);
            if (isset(self::$singletonFlags[$serviceName]) && self::$singletonFlags[$serviceName] == true) {
                self::$instances[$serviceName] = $instance;
            }
            return $instance;
        }
    }