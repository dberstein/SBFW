<?php

class Sfw_Page
{
    protected $_headers = array();
    protected $_payload;

    public function __construct($payload = null, array $headers = array())
    {
        $this->setPayload($payload);
        foreach ($headers as $name => $value) {
            $this->setHeader($name, $value);
        }
    }

    public function emitHeaders()
    {
        foreach ($this->getHeader() as $name => $value) {
            if ($name === 0 || ctype_digit($name)) {
                header($value);
            } else {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        header(
                            sprintf(
                                '%s: %s',
                                $name,
                                $v
                            ),
                            false
                        );
                    }
                } else {
                    header(
                        sprintf(
                            '%s: %s',
                            $name,
                            $value
                        ),
                        true
                    );
                }
            }
        }
    }

    public function setRawHeader($text)
    {
        $this->_headers[] = $text;

        return $this;
    }

    public function setHeader($name, $value = '', $replace = true)
    {
        $name = $this->_normalizeHeaderName($name);

        if ($replace && array_key_exists($name, $this->_headers)) {
            $tmp = $this->_headers[$name];
            if (!is_array($tmp)) {
                $tmp = array($tmp);
            }
            $tmp[] = $value;
            $value = $tmp;
        }

        $this->_headers[$name] = $value;

        return $this;
    }

    public function getHeader($name = null, $default = null)
    {
        $name = $this->_normalizeHeaderName($name);

        if (empty($name)) {
            return $this->_headers;
        }

        if (array_key_exists($name, $this->_headers)) {
            return $this->_headers[$name];
        }

        return $default;
    }

    public function setPayload($payload)
    {
        $this->_payload = $payload;

        return $this;
    }

    public function emit()
    {
        $this->emitHeaders();
        echo $this->getPayload();

        return $this;
    }

    public function getPayload(){
        return $this->_payload;
    }

    protected function _normalizeHeaderName($name)
    {
        $name = strtolower(
            preg_replace('/[^\w]/', '-', trim($name))
        );

        $name = explode('-', $name);
        foreach ($name as &$part) {
            $part = ucfirst($part);
        }

        return implode('-', $name);
    }
}