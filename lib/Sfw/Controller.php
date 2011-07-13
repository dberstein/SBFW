<?php

namespace Sfw;

class Controller
{
    protected $_page;
    protected $_request;

    public function render()
    {
        //
    }

    public function setRequest(\Sfw\Request $request)
    {
        $this->_request = $request;

        return $this;
    }

    public function getRequest()
    {
        return $this->_request;
    }

    public function getName()
    {
        $class = get_class($this);
        $name = $class;
        if (preg_match('/^Sfw[^\w]Controller[^\w](.+)$/', $class, $matches)) {
            $name = $matches[1];
        }

        return $name;
    }

    public function getPage()
    {
        if (!($this->_page instanceof \Sfw\Page)) {
            $this->_page = new \Sfw\Page;
        }

        return $this->_page;
    }
}