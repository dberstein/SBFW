<?php

namespace SBFW\Response;

class Http extends \SBFW\Response
{
    protected $_status;
    protected $_headers;

    public function emit()
    {
        $this->emitStatus();
        $this->emitHeaders();
        $this->emitPayload();
    }

    public function emitStatus()
    {
        //
    }

    public function emitHeaders()
    {
        //
    }
}