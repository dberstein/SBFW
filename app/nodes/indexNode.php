<?php

class IndexNode extends Sfw_Node
{
    public function index1()
    {
        $this->_add('xx1');
    }

    public function index2()
    {
        $this->_add($this->_request->getMethod() .'  yy2');
    }
}