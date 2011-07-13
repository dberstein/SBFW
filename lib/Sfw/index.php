<?php

/**
 * Adjust require to absolute path of bootstrap class.
 *
 * @see \Sfw\Bootstrap
 */
require_once dirname(__FILE__) . '/Bootstrap.php';
Sfw\Bootstrap::setup();

$home = new \Sfw\Controller\Home;
$table = new \Sfw\Controller\Table;

$r1 = new Sfw\Route($home, '#^/$#', 'home');
$r2 = new Sfw\Route($table, '#/table/(?P<table>[^/\?]*)#', 'table');

$router = Sfw\Router::getInstance();

$router->add($r1);
$router->add($r2);

$controller = $router->route();
$page = $controller->render();
$page->emit();