<?php

class Sfw_Node
{
    protected $_request;
    protected $_controller;
    protected $_content;
    protected $_status = 200;
    protected $_headers = array();

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

    public function _addHeader($name, $value = null)
    {
        if (empty($value)) {
            $this->_headers[] = $name;
        } else {
            $this->_headers[$name] = $value;
        }

        return $this;
    }

    protected function _status()
    {
        $proto = '1.0';
        if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
            $proto = $_SERVER['SERVER_PROTOCOL'];
        }

        $header = "HTTP/{$proto} {$this->_status}";
        $this->_addHeader($header);

        return $this;
    }

    protected function _unknownAction($name)
    {
        $this->_add(
            'Unknown action [' . get_class($this) . '->' . $name . '()]',
            403
        );
    }

    public function emitHeaders($withStatus = true)
    {
        if ($withStatus) {
            $this->_status();
        }

        // Cache control headers
        $this->_addHeader('Cache-Control', 'none');
        $this->_addHeader('Expires', date('r', time() - (3600 * 24)));

        // Informational headers
        $this->_addHeader('X-Framework', 'Sfw-' . Sfw_Version::getVersion());

        foreach ($this->_headers as $name => $value) {
            if (empty($name) || ctype_digit($name)) {
                header($value);
            } else if (empty($value)) {
                header($name);
            } else {
                header($name . ': ' . $value, true);
            }
        }

        return $this;
    }

    public function __toString()
    {
        $this->_status();
        return $this->_content;
    }
}