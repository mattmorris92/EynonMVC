<?php
    error_reporting(E_ALL);
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    session_start();
    require_once "3rdParty/password.php";
    require_once "config.php";

    // Autoloader.
    function __autoload($class) {
        $file = dirname(__FILE__) . "/" . str_replace("\\", "/", $class) . ".php";
        
        if (file_exists($file)) {
            require_once($file);
        }
    }
    
    // Set up the database.
    \DAL\DAL::Init($db_server, $db_name, $db_user, $db_pass);
    
    \Controller\RootViewController::$root_url = $root_url;
    
    // Call the root view controller.
    $controller = new \Controller\RootViewController();
    echo $controller->ProcessView();