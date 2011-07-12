<?php

// Calculate root absolute path
$root = realpath(
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR .
    '..' .
    DIRECTORY_SEPARATOR .
    '..'
);

// Setup include_path
set_include_path(
    $root . DIRECTORY_SEPARATOR . 'lib' .
    PATH_SEPARATOR .
    $root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'nodes' .
    PATH_SEPARATOR .
    $root . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' .
    PATH_SEPARATOR .
    get_include_path()
);

/**
 * @see Sfw_Controller
 */
require_once 'Sfw/Controller.php';

// Initilize routines (autoloader, etc)
Sfw_Controller::init($root);

/**
 * @see Sfw_Controller_Home
 */
$home = new Sfw_Controller_Home;

/**
 * @see Sfw_Controller_Table
 */
$table = new Sfw_Controller_Table;

/**
 * @see Sfw_Route
 */
require_once 'Sfw/Route.php';
$r1 = new Sfw_Route($home, '#^/$#', 'home');
$r2 = new Sfw_Route($table, '#/table/(?P<table>[^/\?]*)#', 'table');

/**
 * @see Sfw_Router
 */
require_once 'Sfw/Router.php';
$router = Sfw_Router::getInstance();

$router->add($r1);
$router->add($r2);

$controller = $router->route();
$page = $controller->render();
$page->emit();