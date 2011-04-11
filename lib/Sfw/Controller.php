<?php

class Sfw_Controller
{
    static protected $_alias = array();

    static public function init()
    {
        $autoloader = 'Sfw_Controller::autoload';
        spl_autoload_register($autoloader);
    }

    static public function route()
    {
        $request = new Sfw_Request_Http($_SERVER['REQUEST_URI']);
        foreach (array('_POST', '_GET', '_COOKIE', '_FILES') as $type) {
            eval("\$value = \$$type;");
            foreach ($value as $k => $v) {
                $request->setParam($type, $k, $v);
            }
        }

        $route = $request->getRoute();
        $instance = new self;
        $nodeClass = $route['class'];
        $node = new $nodeClass($request, $instance);
        $action = $route['action'];

        $callback = array($node, $action);
        if (in_array($action, get_class_methods($node)) && is_callable($callback)) {
            call_user_func($callback);
            return (string) $node;
        }

        usort(self::$_alias, 'Sfw_Controller::_cmpLength');
        foreach (self::$_alias as $alias) {
            if (!$request->matches($alias['uri'])) {
                continue;
            }

            $nodeClass = $alias['node'];
            $node = new $nodeClass($request, $instance);
            $callback = array($node, $alias['action']);
            if (is_callable($callback)) {
                call_user_func($callback);
                return (string) $node;
            }

            break;
        }

        header('HTTP/' . $_SERVER['SERVER_PROTOCOL'] . ' 404');
        echo 'Not found';
    }

    static public function addAlias($path)
    {
        $filename = DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'alias.xml';

        if (is_readable($filename)) {
            $xml = new SimpleXMLElement(
                file_get_contents($filename)
            );

            foreach ($xml->alias as $alias) {
                $attr = $alias->attributes();
                self::$_alias[] = array(
                    'uri' => (string) $attr['uri'],
                    'node' => (string) $attr['node'] . 'Node',
                    'action' => (string) $attr['action'],
                );
            }
        }
    }

    static protected function _cmpLength($a, $b)
    {
        $a = strlen($a['uri']);
        $b = strlen($b['uri']);

        return ($a < $b) ? -1 : 1;
    }

    static public function autoload($classname)
    {
        $filename = str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        require_once $filename;
    }
}