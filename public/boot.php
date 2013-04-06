<?php
date_default_timezone_set('Europe/Dublin');

define('MYSQLI_HOST', 'localhost');
define('MYSQL_PORT', 3306);
define('MYSQL_DATABASE', 'potholes');
define('MYSQL_USER', 'USERNAME');
define('MYSQL_PASSWORD', 'PASSWORD');

define('MAX_DIMENSION', 1024);
define('UPLOAD_DIR', realpath('uploads'));

define('VERSION', time());

require_once realpath('../vendor/htmlpurifier/library/HTMLPurifier.auto.php');

function __autoload($class)
{
    if (HTMLPurifier_Bootstrap::autoload($class)) return true;
    return include realpath('../Classes/' . strtolower($class) . '.class.php');
}
