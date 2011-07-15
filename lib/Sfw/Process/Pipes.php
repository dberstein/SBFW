<?php

namespace SBFW\Process;

class Pipes
{
    const STDIN = 0;
    const STDOUT = 1;
    const STDERR = 2;

    protected $_pipes = array();

    public function set($pipe, $data)
    {
        $this->_pipes[$pipe] = $data;

        return $this;
    }

    public function get($pipe, $default = null)
    {
        if (array_key_exists($pipe, $this->_pipes)) {
            $default = $this->_pipes[$pipe];
        }

        return $default;
    }
}