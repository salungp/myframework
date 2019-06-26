<?php
require_once 'core/config.php';

spl_autoload_register(function ($class) {
	require_once 'core/'.$class.'.php';
});