<?php

class Sfw_Controller
{
    static protected $_root;
    static protected $_alias = array();

    /**
     * Initializes controller instance. Thing done:
     * - Sets applicaton's root directory to $root
     * - Sets {@see Sfw_Controller::autoload} as autoloder
     *
     * @param string $root
     */
    static public function init($root = null)
    {
        self::setRoot($root);
        $autoloader = 'Sfw_Controller::autoload';
        spl_autoload_register($autoloader);
    }

    /**
     * Sets $root as application's root
     *
     * @param string $root
     */
    static public function setRoot($root)
    {
        self::$_root = $root;
    }

    /**
     * Returns application's root directory
     *
     * @return string
     */
    static public function getRoot()
    {
        return self::$_root;
    }

    /**
     * Routes incoming request and returns result as string.
     *
     * @return string
     */
    static public function route()
    {
        $request = new Sfw_Request_Http($_SERVER['REQUEST_URI']);
        $value = array();
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

        $node = new Sfw_Node_NotFound($request, $instance);
        $node->notFound();

        return (string) $node;
    }

    /**
     * Setups aliases from XML document at file $filename. If parameter $relative
     * is true, the path is treated as relative to application's root directory.
     *
     * @param string $filename
     * @param bool   $relative
     */
    static public function addAlias($filename, $relative = true)
    {
        if ($relative) {
            $filename = rtrim(self::getRoot(), DIRECTORY_SEPARATOR)
                      . DIRECTORY_SEPARATOR
                      . $filename;
        }

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

    /**
     * Autoloader
     *
     * @param string $classname
     */
    static public function autoload($classname)
    {
        $filename = str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
        require_once $filename;
    }

    /**
     * Compares two routes and return integer value of which is longer.
     *
     * @param array $a
     * @param array $b
     */
    static protected function _cmpLength($a, $b)
    {
        $a = strlen($a['uri']);
        $b = strlen($b['uri']);

        return ($a < $b) ? -1 : 1;
    }
}