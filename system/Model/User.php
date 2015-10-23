<?php

namespace Model;

/**
 * General User Class
 *
 * @author Thomas Eynon
 */
class User {
    public $ID;
    public $Username;
    public $SchoolID;
    public $Password;
    public $First;
    public $Middle;
    public $Last;
    public $PrimaryPhone;
    public $SecondaryPhone;
    public $PrimaryEmail;
    public $SecondaryEmail;
    public $DateCreated;
    public $LastLogin;
    public $LastModified;
    public $IsDeleted;
    
    public $Roles = null;
    public $SubordinateRoles = null;
    public $Permissions = null;
    
    public function __construct() {
        
    }
    
    public function HasPermission($permission) {
        foreach ($this->Permissions as $p) {
            if ($p->MachineKey == $permission) {
                return true;
            }
        }
        
        return false;
    }
    
    public function IsSuperior(User $user) {
        foreach ($this->SubordinateRoles as $role) {
            foreach ($user->Roles as $srole) {
                if ($srole->ID == $role->ID) return true;
            }
        }
        
        return false;
    }
    
    public function IsSuperiorToRoleID($roleid) {
        foreach ($this->SubordinateRoles as $role) {
            if ($role->ID == $roleid) {
                return true;
            }
        }
        
        return false;
    }
}
