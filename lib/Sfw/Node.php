<?php

class Sfw_Node
{
    protected $_request;
    protected $_controller;
    protected $_content;
    protected $_status = 200;

    public function __construct(Sfw_Request_Interface $request, Sfw_Controller $controller)
    {
        $this->_request = $request;
        $this->_controller = $controller;
    }

    public function __call($name, $args)
    {
        return $this->_unknownAction($name);
    }

    protected function _add($content, $status = null)
    {
        $this->_content .= $content;

        if ($status) {
            $this->_status = (int) $status;
        }

        return $this;
    }

    protected function _status()
    {
        $proto = '1.0';
        if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
            $proto = $_SERVER['SERVER_PROTOCOL'];
        }

        header("HTTP/{$proto} {$this->_status}");

        return $this;
    }

    protected function _unknownAction($name)
    {
        $this->_add(
            'Unknown action [' . get_class($this) . '->' . $name . '()]',
            403
        );
    }

    public function __toString()
    {
        $this->_status();
        return $this->_content;
    }
}