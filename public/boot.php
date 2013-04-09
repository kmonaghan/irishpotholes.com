<?php
date_default_timezone_set('Europe/Dublin');

if(file_exists(realpath('../config/dbconf.php'))) {
    include_once(realpath('../config/dbconf.php'));
} else {
    echo "You don't have a dbconf.php in the config folder";
    exit();
}

if(MYSQL_USER=='USERNAME**') {
    echo "You need to change your MySQL user credentials";
    exit();
}

if(MYSQL_DATABASE=="DATABASE**") {
    echo "You need to set the correct Database name";
    exit();
}

include_once(realpath('../config/misc.php'));

require_once('../vendor/htmlpurifier/library/HTMLPurifier.auto.php');

spl_autoload_register(function ($class) {
    if (HTMLPurifier_Bootstrap::autoload($class)) return true;

    $pathToClass = str_replace('\\',DIRECTORY_SEPARATOR,$class);

	return include_once(realpath('../lib/'.$pathToClass.'.php'));
});
