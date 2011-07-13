<?php

namespace Sfw;

class Bootstrap
{
    static protected $_root;

    static public function setup()
    {
         // Calculate root absolute path
        $root = self::_getRoot();

        // Setup include_path
        set_include_path(
            $root . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' . DIRECTORY_SEPARATOR . 'DBAL' .
            PATH_SEPARATOR .
            $root . DIRECTORY_SEPARATOR . 'lib' .
            PATH_SEPARATOR .
            get_include_path()
        );

        // Initilize routines (autoloader, etc)
        $autoloader = 'Sfw\Bootstrap::autoload';
        spl_autoload_register($autoloader);

        // Doctrine ClassLoader
        require_once 'Doctrine/Common/ClassLoader.php';
        $classLoader = new \Doctrine\Common\ClassLoader('Doctrine');
        $classLoader->register();
    }

    /**
     * Returns absolute path to application root
     *
     * @return string
     */
    static protected function _getRoot()
    {
        if (!self::$_root) {
            self::$_root = realpath(
                dirname(__FILE__) .
                DIRECTORY_SEPARATOR .
                '..' .
                DIRECTORY_SEPARATOR .
                '..'
            );
        }

        return self::$_root;
    }

    /**
     * Autoloader
     *
     * @param string $classname
     */
    static public function autoload($classname)
    {
        $filename = str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename);

        require_once $filename;
    }
}