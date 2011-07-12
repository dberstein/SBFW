<?php

class Sfw_Router
{
    /**
     * Singleton instance
     *
     * @var Sfw_Router
     */
    static protected $_instance;

    /**
     * Array of Sfw_Route
     *
     * @var array
     */
    protected $_routes = array();

    /**
     * Return singleton instance
     *
     * @return self
     */
    static public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self::$_instance; 
    }

    /**
     * Protected constructor, use {self::getInstance()} instead.
     *
     * @return self
     */
    protected function __construct()
    {
        //
    }

    /**
     * Registers a route
     *
     * @param Sfw_Route $route
     */
    public function add(Sfw_Route $route)
    {
        $name = $route->getName();
        if (is_null($name)) {
            $this->_routes[] = $route;
        } else {
            $this->_routes[$name] = $route;
        }

        return $this;
    }

    public function route()
    {
        /**
         * @see Sfw_Request
         */
        require_once 'Sfw/Request.php';
        $request = Sfw_Request::getInstance();
        $uri = $request->getUri();

        foreach ($this->_routes as $route) {
            if ($match = $route->matches($uri)) {
                $controller = $match;
                break;
            }
        }

        if (!isset($controller)) {
            $controller = new Sfw_Controller_NoRoute;
        }

        $controller->setRequest($request);

        return $controller;
    }
}