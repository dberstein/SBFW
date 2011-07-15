<?php

namespace SBFW\Process;

class Result
{
    protected $_status;
    protected $_pipes;

    public function __construct($status, Pipes $pipes)
    {
        $this->_status = $status;
        $this->_pipes = $pipes;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function get($pipe = Pipes::STDOUT)
    {
        return $this->_pipes->get($pipe);
    }
}