<?php
require_once 'aplication/config/routes.php';
require_once 'aplication/config/database.php';
require_once 'system/core/Common.php';

define('CONTROLLER', ucfirst($routes['default_controller']));

// aplication folder
define('DIR', 'aplication');

// base url
define('BASEURL', $routes['base_url']);

// Database configuration
define('HOST', $database['host']);
define('USER', $database['user']);
define('PASS', $database['pass']);
define('NAME', $database['name']);