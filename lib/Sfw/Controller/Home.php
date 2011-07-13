<?php

namespace Sfw\Controller;

class Home extends \Sfw\Controller
{
    public function render()
    {
        $page = $this->getPage();
        $page->setPayload('home');

        return $page;
    }
}