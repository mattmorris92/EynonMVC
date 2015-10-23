<?php

namespace ViewModel;

/**
 * The View Model for the Edit User screen.
 *
 * @author Thomas Eynon
 */
class EditUserViewModel extends BaseViewModel {
    
    public $username;
    public $bannerid;
    public $first;
    public $middle;
    public $last;
    public $primaryemail;
    public $secondaryemail;
    public $primaryphone;
    public $secondaryphone;
    public $currentpassword;
    public $newpassword;
    public $newpassword2;
    public $role;
    
    public function __construct() {
        parent::__construct();
        $this->bannerid = $_POST['bannerid'];
        $this->first = $_POST['first'];
        $this->middle = $_POST['middle'];
        $this->last = $_POST['last'];
        $this->primaryemail = $_POST['primaryemail'];
        $this->secondaryemail = $_POST['secondaryemail'];
        $this->primaryphone = $_POST['primaryphone'];
        $this->secondaryphone = $_POST['secondaryphone'];
        $this->currentpassword = $_POST['currentpassword'];
        $this->newpassword = $_POST['newpassword'];
        $this->newpassword2 = $_POST['newpassword2'];
        $this->role = (isset($_POST['role'])) ? $_POST['role'] : -1;
    }
    
    public function IsValid() {
        $this->isValidRegex("@^[a-zA-Z]*@", $this->first, "Names may only contain letters");
        $this->isValidRegex("@^[a-zA-Z]*@", $this->middle, "Names may only contain letters");
        $this->isValidRegex("@^[a-zA-Z]*@", $this->last, "Names may only contain letters");
        $this->isValidEmail($this->primaryemail);
        $this->isValidEmail($this->secondaryemail);
        $this->isValidPhone($this->primaryphone);
        $this->isValidPhone($this->secondaryphone);
        $this->isValidRole($this->role);
        
        return empty($this->errors);
    }
}
