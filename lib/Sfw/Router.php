<?php

namespace Sfw;

class Router
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
    public function add(Route $route)
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
        $request = Request::getInstance();
        $uri = $request->getUri();

        foreach ($this->_routes as $route) {
            if ($match = $route->matches($uri)) {
                $controller = $match;
                break;
            }
        }

        if (!isset($controller)) {
            $controller = new Controller\NoRoute;
        }

        $controller->setRequest($request);
        $controller->getPage()->setHeader(
            'x sfw route',
            $controller->getName()
        );
        
        return $controller;
    }
}