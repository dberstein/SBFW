<?php

namespace Sfw;

class Layout
{
    static protected $_response;
    protected $_placeholder = array();
    protected $_layout;

    public function __construct($layout = null)
    {
        if (!is_null($layout)) {
            $this->setLayout($layout);
        }

        self::$_response = new Response\Http;
    }

    public function setLayout($layout)
    {
        $this->_layout = $layout;

        return $this;
    }

    public function getLayout()
    {
        return $this->_layout;
    }

    public function getResponse()
    {
        return self::$_response;
    }

    public function setPlaceholder($name, $value)
    {
        $this->_placeholder[$name] = $value;

        return $this;
    }

    public function emit()
    {
        $response = $this->getResponse();
        $layout = $this->getLayout();
        $payload = null;
        if (file_exists($layout)) {
            // Replace placeholders
            $placeholders = $this->_getPlaceholders()
            foreach ($placeholders as $name => $value) {
                $payload = preg_replace('/{' . preg_quote($name, '/') . '}/', $value);
            }
        }

        $response->setPayload($payload);

        return $response()->emit();
    }

    protected function _getPlaceholders()
    {
        return $this->_placeholder;
    }
}