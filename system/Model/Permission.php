<?php

namespace Model;

/**
 * Basic Permission
 *
 * @author Thomas Eynon
 */
class Permission {
    public $ID;
    public $Parent;
    public $MachineKey;
    public $Description;
    public $DateCreated;
    public $LastModified;
    public $IsDeleted;
    
    public function __construct() {
        
    }
}
