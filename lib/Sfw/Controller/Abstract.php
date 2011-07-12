<?php

class Sfw_Controller_Abstract implements Sfw_Controller_Interface
{
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
}