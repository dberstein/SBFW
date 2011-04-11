<?php

interface Sfw_Request_Interface
{
    public function __construct($uri = null);
    public function getParam($type, $name, $default = null);
    public function setParam($type, $name, $value);
}