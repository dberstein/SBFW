<?php

namespace Sfw;

class Response
{
    protected $_payload;

    public function emitPayload()
    {
        echo $this->_payload;
    }
}