<?php

class Sfw_Request
{
    static protected $_instance;
    static protected $_requestUri;
    protected $_params = array();

    static public function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    protected function __construct()
    {
        self::$_requestUri = $_SERVER['REQUEST_URI'];
    }

    public function getUri()
    {
        return self::$_requestUri;
    }

    public function matches($regex)
    {
        if (preg_match($regex, self::$_requestUri, $matches)) {
            $this->_params = $matches;

            return true;
        }

        return false;
    }

    public function getParam($index, $default = null)
    {
        if (array_key_exists($index, $this->_params)) {
            return $this->_params[$index];
        }

        return $default;
    }
}