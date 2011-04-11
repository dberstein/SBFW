<?php

// Setup include_path and autoinclude
$root = realpath(
    dirname(__FILE__) .
    DIRECTORY_SEPARATOR .
    '..' .
    DIRECTORY_SEPARATOR
);

set_include_path(
    $root . DIRECTORY_SEPARATOR . 'lib' .
    PATH_SEPARATOR .
    $root . DIRECTORY_SEPARATOR . 'app' .
    PATH_SEPARATOR .
    get_include_path()
);

require_once 'Sfw/Controller.php';
Sfw_Controller::init();

// Setup aliases
Sfw_Controller::addAlias($root . DIRECTORY_SEPARATOR . 'conf');
// '/abcd', 'index', 'index1');
// Sfw_Controller::addAlias('/', 'index', 'index2');

// Route, dispatch and output generated HTML
echo Sfw_Controller::route();