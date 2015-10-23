<?php
namespace Model;

/**
 * Holds session information.
 *
 * @author Thomas Eynon
 */
class UserSession {
    public $UID;
    public $Token;
    public $IsValid;
    public $Expires;
    public $DateCreated;
    public $LastModified;
    
    public function __construct() {
        
    }
    
    public function IsValid() {
        $result = $this->IsValid;
        
        if ($result) {
            // Check the expiration date.
            if (strtotime($this->Expires) < time()) {
                $result = false;
            }
        }
        
        return $result;
    }
}
