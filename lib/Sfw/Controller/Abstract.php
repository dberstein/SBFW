<?php

class Sfw_Controller_Abstract implements Sfw_Controller_Interface
{
    protected $_page;
    protected $_request;

    public function render()
    {
        //
    }

    public function setRequest(Sfw_Request $request)
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
        if (preg_match('/^Sfw_Controller_(.+)$/', $class, $matches)) {
            $name = $matches[1];
        }

        return $name;
    }

    public function getPage()
    {
        if (!($this->_page instanceof Sfw_Page)) {
            /**
             * @see Sfw_Page
             */
            require_once 'Sfw/Page.php';

            $this->_page = new Sfw_Page;
        }

        return $this->_page;
    }
}