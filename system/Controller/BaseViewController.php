<?php

namespace Controller;

/**
 * Base View Controller for view controllers.
 *
 * @author Thomas Eynon
 */
class BaseViewController {
    public $ViewData = array();
    protected $templateFile = "default.php";
    public $includes = array("CSS" => array("main.css", "mobile.css"), "JS" => array());
    public $navigation = array("primary" => array(), "header" => array());
    public $breadcrumb = array();
    public $errors = array();
    
    public function __construct() {
        $this->ViewData['templateDirectory'] = RootViewController::$templateDirectory;
        $this->ViewData['rootURL'] = RootViewController::$root_url;
            
        $this->breadcrumb[] = array("url" => "", "text" => "ASC-TUTORS");
        
        
        // Valid user.
        if (RootViewController::$user != null) {
        }
        else {
            // Default navigation
            $this->navigation['primary'][] = array("url" => "Services", "text" => "Services");
            $this->navigation['primary'][] = array("url" => "About", "text" => "About");
            $this->navigation['primary'][] = array("url" => "Contact", "text" => "Contact");

            //$this->navigation['header'][] = array("url" => "Login", "text" => "LOG IN");
        }
    }
    
    /**
     * Load the headers, footers, and content.
     */
    public function View($viewPath) {
        $this->ViewData['body'] = $this->PartialView($viewPath);
        
        // Output the base view.
        if (file_exists("system/View/Templates/" . RootViewController::$templateName . "/{$this->templateFile}")) {
            ob_start();
            include "system/View/Templates/" . RootViewController::$templateName . "/{$this->templateFile}";
            return ob_get_clean();
        }
        
        return false;
    }
    
    public function Redirect($path) {
        header("Location: " . RootViewController::$root_url . $path);
        return true;
    }
    
    public function PartialView($viewPath) {
        if (file_exists("system/View/Templates/" . RootViewController::$templateName . "/{$viewPath}.php")) {
            ob_start();
            include "system/View/Templates/" . RootViewController::$templateName . "/{$viewPath}.php";
            return ob_get_clean();
        }
        return false;
    }
    
    public function HeaderIncludes() {
        $response = "";
        
        foreach ($this->includes as $kind => $includes) {
            switch ($kind) {
                case "CSS":
                    foreach ($includes as $include) {
                        $response .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . RootViewController::$root_url . "system/View/Templates/" . RootViewController::$templateName . "/styles/{$include}\">";
                    }
                    break;
                case "JS":
                    foreach ($includes as $include) {
                        $response .= "<script type=\"text/javascript\" src=\"system/View/Templates/" . RootViewController::$templateName . "/script/{$include}\">";
                    }
                    break;
                default:
                    break;
            }
        }
        
        return $response;
    }
    
    public function Navigation($type = "primary") {
        $navigation = "";
        switch ($type) {
            default:
                if (!empty($this->navigation[$type])) {
                    $navigation = "<ul>";
                    foreach ($this->navigation[$type] as $navElement) {
                        $navigation .= "<li><a href=\"" . RootViewController::$root_url . "{$navElement['url']}\">{$navElement['text']}</a></li>";
                    }
                        
                }
                break;
        }
        
        return $navigation;
    }
    
    /**
     * Get the breadcrumb list for the current page.
     * @return Breadcrumb List
     */
    public function Breadcrumb() {
        
        $navigation = "";
        if (!empty($this->breadcrumb)) {
            $navigation = "<ul>";
            foreach ($this->breadcrumb as $navElement) {
                $navigation .= "<li><a href=\"" . RootViewController::$root_url . "{$navElement['url']}\">{$navElement['text']}</a></li>";
            }
            $navigation .= "</ul>";
        }
        
        return $navigation;
    }
    
    public function ShowErrors() {
        $output = "";
        
        if (!empty($this->errors)) {
            $output = "<div class=\"errors\"><ul><li>";
            $output .= implode("</li><li>", $this->errors);
            $output .= "</li></ul></div>";
        }
        
        return $output;
    }
    
    /**
     * Require that a user is logged in to view this page.
     */
    public function Authenticate() {
        if (empty(RootViewController::$user)) {
            $this->Unauthorized();
        }
    }
    
    public function RequirePermission($permission) {
        if (!RootViewController::$user->HasPermission($permission)) {
            $this->Unauthorized();
        }
    }
    
    public function Unauthorized() {
        header('HTTP/1.1 401 Unauthorized');
        echo $this->View("HTTP_401");
        exit;
    }
    
    /**
     * Redirect to 404 page.
     */
    public function PageNotFound() {
        // 404.
        header('HTTP/1.1 404 Not Found');
        echo $this->View("HTTP_404");
        exit;
    }
    
    /**
     * Generate a random token for validation on form submit to prevent cross site request forgery.
     * @return Form Input
     */
    public function FormToken() {
        if (!isset($_SESSION['token'])) $_SESSION['token'] = array();
        $token = \Helpers\Security::getToken(20);
        $_SESSION['token'][] = $token;
        return "<input type=\"hidden\" name=\"form_token\" value=\"{$token}\" />";
    }
    
    /**
     * Confirm the form token was valid.
     */
    public static function ValidateFormToken() {
        if (!empty($_POST['form_token']) && !empty($_SESSION['token']) && in_array($_POST['form_token'], $_SESSION['token'])) {
            // Consume the token.
            unset($_SESSION['token'][array_search($_POST['form_token'], $_SESSION['token'])]);
            return true;
        }
        
        return false;
    }
    
    public static function BuildSelect($role, $object, $key, $text, $selected = -1) {
        $output = "<select name=\"{$role}\">";
        foreach ($object as $obj) {
            $selectedText = "";
            if (is_array($obj)) {
                if ($obj[$key] == $selected) $selectedText = " selected";
                $output .= "<option value=\"{$obj[$key]}\"{$selectedText}>{$obj[$text]}</option>";
            }
            else {
                if ($obj->$key == $selected) $selectedText = " selected";
                $output .= "<option value=\"{$obj->$key}\"{$selectedText}>{$obj->$text}</option>";
            }
        }
        $output .= "</select>";
        
        return $output;
    }
}
