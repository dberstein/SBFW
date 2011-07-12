<?php

class Sfw_Controller_Home extends Sfw_Controller_Abstract
{
    public function render()
    {
        $page = $this->getPage();
        $page->setPayload('home');

        return $page;
    }
}