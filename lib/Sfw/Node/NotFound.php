<?php

class Sfw_Node_NotFound extends Sfw_Node
{
    public function __call($name, $args)
    {
        $this->_add(
            'Path <b>' . htmlentities($this->_request->getUri()) . '</b> was not found.',
            404
        );
    }
}