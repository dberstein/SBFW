<?php

/**
 * Adjust require to absolute path of bootstrap class.
 *
 * @see \SBFW\Bootstrap
 */
require_once dirname(__FILE__) . '/../../Bootstrap.php';
SBFW\Bootstrap::setup();

$home = new \SBFW\Controller\Home;
$table = new \SBFW\Controller\Table;

$r1 = new SBFW\Route($home, '#^/$#', 'home');
$r2 = new SBFW\Route($table, '#/table/(?P<table>[^/\?]*)#', 'table');

$router = SBFW\Router::getInstance();

$router->add($r1);
$router->add($r2);

$controller = $router->route();
$page = $controller->render();
$page->emit();