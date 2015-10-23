<?php

namespace Model;

/**
 * Basic Role
 *
 * @author Thomas Eynon
 */
class Role {
    public $ID;
    public $RoleName;
    public $DateCreated;
    public $LastModified;
    public $IsDeleted;
    
    public function __construct() {
        
    }
}
