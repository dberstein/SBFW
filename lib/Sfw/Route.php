<?php

namespace Sfw;

class Route
{
    protected $_regex;
    protected $_name;
    protected $_controller;

    public function __construct(
        Controller $controller,
        $regex,
        $name = null
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
        $request = Request::getInstance();

        if ($request->matches($this->_regex)) {
            return $this->_controller;
        }

        return false;
    }
}