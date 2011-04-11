<?php

class Sfw_Node
{
    protected $_request;
    protected $_controller;
    protected $_content;

    public function __construct(Sfw_Request_Interface $request, Sfw_Controller $controller)
    {
        $this->_request = $request;
        $this->_controller = $controller;
    }

    public function __call($name, $args)
    {
        return $this->_unknownAction($name);
    }

    protected function _add($content)
    {
        $this->_content .= $content;

        return $this;
    }

    protected function _unknownAction($name)
    {
        header('HTTP/' . $_SERVER['SERVER_PROTOCOL'] . ' 403');
        $this->_add(
            'Unknown action [' . get_class($this) . '->' . $name . '()]'
        );
    }

    public function __toString()
    {
        return $this->_content;
    }
}