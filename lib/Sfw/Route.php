<?php

class Sfw_Route
{
    protected $_regex;
    protected $_name;
    protected $_controller;

    public function __construct(
        Sfw_Controller_Interface $controller, $regex, $name = null
    )
    {
        $this->_controller = $controller;
        $this->_regex = $regex;
        $this->_name = $name;
    }

    public function getRegex()
    {
        return $this->_regex;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function matches($path)
    {
        /**
         * @see Sfw_Request
         */
        require_once 'Sfw/Request.php';
        $request = Sfw_Request::getInstance();

        if ($request->matches($this->_regex)) {
            return $this->_controller;
        }

        return false;
    }
}