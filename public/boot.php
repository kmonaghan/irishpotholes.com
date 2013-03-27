<?php
date_default_timezone_set('Europe/Dublin');

define('MYSQLI_HOST', 'localhost');
define('MYSQL_PORT', 3306);
define('MYSQL_DATABASE', 'potholes');
define('MYSQL_USER', 'USERNAME');
define('MYSQL_PASSWORD', 'PASSWORD');

define('MAX_DIMENSION', 1024);
define('UPLOAD_DIR', '/home/irishpotholes.com/public/uploads');

define('VERSION', 6);

function __autoload($class_name) {
	include '/home/irishpotholes.com/Classes/' . strtolower($class_name) . '.class.php';
}
