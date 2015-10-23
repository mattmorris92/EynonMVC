<?php
namespace ViewModel;
/**
 * Handles form model data and validation for the login screens.
 *
 * @author Thomas Eynon
 */
class LoginViewModel extends BaseViewModel {
    
    public $username;
    public $password;
    
    public function __construct() {
        parent::__construct();
        $this->username = $_POST['username'];
        $this->password = $_POST['password'];
    }
    
    public function IsValid() {
        $this->isValidUsername($this->username);
        
        return empty($this->errors);
    }
}
