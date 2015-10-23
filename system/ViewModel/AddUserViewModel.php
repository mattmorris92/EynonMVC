<?php

namespace ViewModel;

/**
 * Description of AddUserViewModel
 *
 * @author Thomas Eynon
 */
class AddUserViewModel extends BaseViewModel {
    
    public $username;
    public $bannerid;
    public $first;
    public $middle;
    public $last;
    public $primaryemail;
    public $secondaryemail;
    public $primaryphone;
    public $secondaryphone;
    public $newpassword;
    public $newpassword2;
    public $role;
    
    public function __construct() {
        parent::__construct();
        if (!empty($_POST)) {
            $this->username = $_POST['username'];
            $this->bannerid = $_POST['bannerid'];
            $this->first = $_POST['first'];
            $this->middle = $_POST['middle'];
            $this->last = $_POST['last'];
            $this->primaryemail = $_POST['primaryemail'];
            $this->secondaryemail = $_POST['secondaryemail'];
            $this->primaryphone = $_POST['primaryphone'];
            $this->secondaryphone = $_POST['secondaryphone'];
            $this->newpassword = $_POST['newpassword'];
            $this->newpassword2 = $_POST['newpassword2'];
            $this->role = $_POST['role'];
        }
    }
    
    public function IsValid() {
        $this->isValidUsername($this->username);
        $this->isValidRegex("@^[a-zA-Z]*@", $this->first, "Names may only contain letters");
        $this->isValidRegex("@^[a-zA-Z]*@", $this->middle, "Names may only contain letters");
        $this->isValidRegex("@^[a-zA-Z]*@", $this->last, "Names may only contain letters");
        $this->isValidEmail($this->primaryemail);
        $this->isValidEmail($this->secondaryemail);
        $this->isValidPhone($this->primaryphone);
        $this->isValidPhone($this->secondaryphone);
        $this->isValidPassword($this->newpassword, $this->newpassword2);
        $this->isValidRole($this->role);
        
        return empty($this->errors);
    }
}
