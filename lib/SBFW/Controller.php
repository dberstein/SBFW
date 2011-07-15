<?php

namespace SBFW;

class Controller
{
    protected $_page;
    protected $_request;

    public function render()
    {
        //
    }

    public function setRequest(\SBFW\Request $request)
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
        if (preg_match('/^SBFW[^\w]Controller[^\w](.+)$/', $class, $matches)) {
            $name = $matches[1];
        }

        return $name;
    }

    public function getPage()
    {
        if (!($this->_page instanceof \SBFW\Page)) {
            $this->_page = new \SBFW\Page;
        }

        return $this->_page;
    }
}