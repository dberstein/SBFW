<?php

namespace Sfw\Response;

class Http extends \Sfw\Response
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