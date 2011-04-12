<?php

// Calculate root absolute path
$root = realpath(
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR .
    '..' .
    DIRECTORY_SEPARATOR
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

// Setup aliases
$filename = 'conf' . DIRECTORY_SEPARATOR . 'alias.xml';
Sfw_Controller::addAlias(
    $filename
);

// Route, dispatch and output generated HTML
echo Sfw_Controller::route();