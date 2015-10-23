<?php
namespace Controller;

/**
 * Handles the routing of all requests.
 * 
 * URL FORMAT
 * Controller/View/Method/Parameter1/Parameter2/ParameterN
 *
 * @author Thomas Eynon
 */
class RootViewController {
    
    public static $root_url = "http://localhost:8080/ASC-TUTORS/";
    public static $templateName = "Default";
    public static $templateDirectory;
    public static $user = null;
    
    const SESSIONTOKENNAME = "LOGINTOKEN";
    const SESSIONUSERID = "LOGINUSERID";
    
    private $RequestedController;
    private $RequestedMethod;
    private $RequestedArguments;
    
    
    /*
     * This class is intended only to redirect the page to a view controller.
     */
    public function __construct() {
        self::$templateDirectory = self::$root_url . "system/View/Templates/" . self::$templateName . "/";
        
        $this->ValidateUser();
        
        // Check for the path variable. If not specified, then it is the default.
        if (empty($_GET['path'])) $_GET['path'] = "Home";
        
        $path = array();
        
        // The first part of the path may contain only letters and numbers
        preg_match_all("@([^\\/]+)@", $_GET['path'], $path);
        $path = $path[0];
        
        if (preg_match("@^[a-zA-Z0-9]+$@", $path[0])) {
            // Is it a View Controller?
            if ($path[0] != "Base" && class_exists("Controller\\{$path[0]}ViewController")) {
                $class = "Controller\\{$path[0]}ViewController";
                $this->RequestedController = new $class();
                
                array_shift($path);
            }
            else {
                $this->RequestedController = new \Controller\HomeViewController();
            }
            
            if (empty($path[0])) {
                if (get_class($this->RequestedController) == "Controller\HomeViewController" && self::$user != null) 
                    $path[0] = "Dashboard";
                else $path[0] = "Default";
            }

            // Make sure method has valid values.
            if (!empty($path[0]) && preg_match("@^[a-zA-Z0-9]+$@", $path[0])) {
                if (method_exists($this->RequestedController, $path[0] . "_" . $this->GetRequestMethod())) {
                    $this->RequestedMethod = $path[0] . "_" . $this->GetRequestMethod();
                }
                else {
                    $this->RequestedController->PageNotFound();
                }
            }
            else {
                $this->RequestedMethod = "Default_" . $this->GetRequestMethod();
            }

            array_shift($path);

            $this->RequestedArguments = $path;
        }
    }
    
    private function ValidateUser() {
        if (!empty($_SESSION[self::SESSIONUSERID]) && !empty($_SESSION[self::SESSIONTOKENNAME])) {
            if (\BLL\User::ValidateSession($_SESSION[self::SESSIONUSERID], $_SESSION[self::SESSIONTOKENNAME])) {
                self::$user = \BLL\User::GetUserByID($_SESSION[self::SESSIONUSERID]);
                self::$user->Roles = \BLL\User::GetUserRoles(self::$user->ID);
                self::$user->SubordinateRoles = \BLL\User::GetSubordinateRoles(self::$user->ID);
                self::$user->Permissions = \BLL\User::GetUserPermissions(self::$user->ID);
            }
            else {
                // Destroy the session.
                \BLL\User::InvalidateSession($_SESSION[self::SESSIONUSERID], $_SESSION[self::SESSIONTOKENNAME]);
                unset($_SESSION[self::SESSIONUSERID]);
                unset($_SESSION[self::SESSIONTOKENNAME]);
            }
        }
    }
    
    public function ProcessView() {
        return call_user_func_array(array($this->RequestedController, $this->RequestedMethod), $this->RequestedArguments);
    }
    
    private function GetRequestMethod() {
        switch ($_SERVER['REQUEST_METHOD']) {
            case "GET":
            case "POST":
            case "PUT":
            case "DELETE":
                return $_SERVER['REQUEST_METHOD'];
                break;
            default:
                return "GET";
                break;
        }
    }
}
