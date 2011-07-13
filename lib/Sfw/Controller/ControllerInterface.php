<?php

interface Sfw_Controller_Interface
{
    public function render();
    public function setRequest(Sfw_Request $request);
    public function getName();
}