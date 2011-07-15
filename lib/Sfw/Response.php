<?php

namespace SBFW;

class Response
{
    protected $_payload;

    public function emitPayload()
    {
        echo $this->_payload;
    }
}