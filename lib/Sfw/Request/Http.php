<?php

class Sfw_Request_Http implements Sfw_Request_Interface
{
    const NOT_FOUND_NODE = 'NotFound';
    const NO_ACTION = 'NoAction';

    protected $_uri;
    protected $_parts = array();
    protected $_params = array();
    protected $_method;

    public function __construct($uri = null)
    {
        $this->setMethod($_SERVER['REQUEST_METHOD']);
        $this->setUri($uri);
    }

    public function matches($uri)
    {
        if (strlen($uri) >= strlen($this->getUri())) {
            return (0 === strpos($this->getUri(), $uri));
        }

        return false;
    }

    public function getRoute()
    {
        return array(
            'class' => 'Sfw_' . $this->_getPart(0, self::NOT_FOUND_NODE) . 'Node',
            'action' => $this->_getPart(1, self::NO_ACTION),
        );
    }

    public function setUri($uri)
    {
        $this->_uri = $uri;
        $this->_parts = explode('/', $uri);

        return $this;
    }

    public function getUri()
    {
        return $this->_uri;
    }

    public function setMethod($method)
    {
        $this->_method = $method;

        return $this;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function getParam($type, $name, $default = null)
    {
        if (array_key_exists($type, $this->_params)) {
            if (array_key_exists($name, $this->_params[$type])) {
                return $this->_params[$type][$name];
            }
        }

        return $default;
    }

    public function setParam($type, $name, $value)
    {
        if (!array_key_exists($type, $this->_params)) {
            $this->_params[$type] = array();
        }
        $this->_params[$type][$name] = $value;

        return $this;
    }

    protected function _getPart($index, $default)
    {
        if (array_key_exists($index, $this->_parts)) {
            return $this->_parts[$index];
        }

        return $default;
    }
}