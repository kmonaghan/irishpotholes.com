<?php
date_default_timezone_set('Europe/Dublin');

define('HOST', 'localhost');
define('DATABASE', 'potholes');
define('DB_USER', 'USERNAME');
define('DB_PASSWORD', 'PASSWORD');

function __autoload($class_name) {
	include '/home/irishpotholes.com/Classes/' . strtolower($class_name) . '.class.php';
}