<?php

namespace SBFW\Controller;

class Home extends \SBFW\Controller
{
    public function render()
    {
        $page = $this->getPage();
        $page->setPayload('home');

        return $page;
    }
}