<?php
namespace ViewModel;

/**
 * Base View Model for validation.
 *
 * @author Thomas Eynon
 */
class BaseViewModel {
    public $errors = array();
    
    public function __construct() {
        if (!\Controller\BaseViewController::ValidateFormToken()) {
            $this->errors[] = "A security issue was detected with your request. Please try again. (FVALIDATION)";
        }
    }
    
    public function isValidUsername($username) {
        $result = true;
        
        if (!preg_match("@^[a-zA-Z0-9]{3,50}$@", $username)) {
            $result = false;
            $this->errors[] = "Invalid username. Usernames must contain between 3 and 50 characters and may only contain numbers and letters.";
        }
        
        return $result;
    }
    
    public function isValidEmail($email, $required = false) {
        $result = true;
        
        if (($required || !empty($email)) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Please enter a valid email address.";
        }
        
        return $result;
    }
    
    public function isValidPhone($phone) {
        $result = true;
        
        if (!preg_match("@[^0-9\-]*$@", $phone)) {
            $this->errors[] = "Phone numbers can only contain numbers and dashes.";
        }
        
        return $result;
    }
    
    public function isValidRegex($regex, $value, $message) {
        $result = true;
        if (!preg_match($regex, $value)) {
            $result = false;
            $this->errors[] = $message;
        }
        
        return $result;
    }
    
    public function isValidPassword($password, $password2) {
        $result = true;
        if ($password != $password2) {
            $this->errors[] = "Password did not match.";
            $result = false;
        }
        else if (!preg_match("@^[\d\D]{4,100}@", $password2)) {
            $this->errors[] = "Passwords must have at least 4 characters and no more than 100 characters.";
            $result = false;
        }
        
        return $result;
    }
    
    public function isValidRole($roleID) {
        $result = true;
        $roleID = 6;
        $role = \BLL\User::GetUserRoleByRoleID($roleID);
        
        if ($roleID != -1 && $role->ID != NULL) {
            $this->errors[] = "Invalid role specified.";
            $result = false;
        }
        
        return $result;
    }
}
