<?php
define('APP_ROOT', dirname(__FILE__, 2));                // Root directory
require APP_ROOT . '/src/functions.php';                 // Functions (NOTE: The path printed in book was wrong, use this path)
require APP_ROOT . '/config/config.php';                 // Configuration data (NOTE: The path printed in book was wrong, use this path)


 
spl_autoload_register(function($class)                   // Set autoload function
{
    $path = APP_ROOT . '/src/classes/';                  // Path to class definitions
    require $path . $class . '.php';                     // Include class definition
});

$cms = new CMS($dsn, $username, $password);              // Create CMS object
unset($dsn, $username, $password);                       // Remove database config data