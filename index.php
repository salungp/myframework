<?php
session_start();

$system_dir = 'system';

require_once $system_dir.'/loader.php';

$app = new App();