<?php

namespace DAL;

/**
 * Manages data from the database.
 *
 * @author Thomas Eynon
 */
class User {
    public function __construct() {
        
    }
    
    /**
     * Get the user by username.
     * @param type $username
     * @param type $includePassword Include the password? (Default: False)
     * @return \Model\User
     */
    public static function GetUserByUsername($username, $includePassword = false) {
        $result = false;
        
        $sql = "SELECT * FROM asct_users WHERE `Username` = ?";
        $values = array($username);
        
        $results = DAL::Prepared($sql, $values);
        if ($results->rowCount() > 0) {
            $row = $results->fetch(\PDO::FETCH_ASSOC);
            
            $result = new \Model\User();
            DAL::MapToObject($row, $result);
            
            if (!$includePassword) $result->Password = null;
        }
        
        return $result;
    }
    
    /**
     * Get the user by User ID.
     * @param type $uid
     * @param bool $includePassword Include the password? (Default: False)
     * @return \Model\User
     */
    public static function GetUserByID($uid, $includePassword = false) {
        $result = false;
        
        $sql = "SELECT * FROM asct_users WHERE `ID` = ?";
        $results = DAL::Prepared($sql, array($uid));
        if ($results->rowCount() > 0) {
            $row = $results->fetch(\PDO::FETCH_ASSOC);
            
            $result = new \Model\User();
            DAL::MapToObject($row, $result);
            
            if (!$includePassword) $result->Password = null;
        }
        
        return $result;
    }
    
    /**
     * Update the last login time and create a session token.
     * @param type $userID User ID
     * @return string Session Token
     */
    public static function LoginUser($userID) {
        $sql = "UPDATE asct_users SET LastLogin = now() WHERE `ID` = ?";
        DAL::Prepared($sql, array($userID));
        
        $token = \Helpers\Security::getToken(50);
        $sql = "INSERT INTO asct_usersessions (UID, Token, IsValid, Expires, DateCreated) VALUES (?, ?, 1, now() + INTERVAL 8 HOUR, now())";
        DAL::Prepared($sql, array($userID, $token));
        
        return $token;
    }
    
    /**
     * Get the user session specified.
     * @param type $userid
     * @param type $token
     * @return \Model\UserSession
     */
    public static function GetUserSession($userid, $token) {
        $session = false;
        
        $sql = "SELECT * FROM asct_usersessions WHERE UID = ? AND Token = ?";
        $results = DAL::Prepared($sql, array($userid, $token));
        
        if ($results->rowCount() > 0) {
            $data = $results->fetch(\PDO::FETCH_ASSOC);
            $session = new \Model\UserSession();
            DAL::MapToObject($data, $session);
        }
        return $session;
    }
    
    /**
     * Update the database to invalidate a session.
     * @param type $userid User ID
     * @param type $token Session Token
     */
    public static function InvalidateSession($userid, $token) {
        $sql = "UPDATE asct_usersessions SET IsValid = 0 WHERE UID = ? AND Token = ?";
        $results = DAL::Prepared($sql, array($userid, $token));
    }
    
    /**
     * Gets the roles assigned to the user.
     * @param type $uid User ID
     * @return array[\Model\Role]
     */
    public static function GetUserRoles($uid) {
        $roles = array();
        
        $sql = "SELECT
                    ORG.ID as `ORGID`,
                    ROLES.*
                FROM asct_user_role_organization_relation as RELATION
                INNER JOIN asct_roles AS ROLES ON (RELATION.RID = ROLES.ID)
                INNER JOIN asct_organizations AS ORG ON (RELATION.OID = ORG.ID)
                WHERE 
                    RELATION.UID = ?";
        
        $results = DAL::Prepared($sql, array($uid));
        
        if ($results->rowCount() > 0) {
            foreach ($results->fetchAll(\PDO::FETCH_ASSOC) as $data) {
                $role = new \Model\Role();
                DAL::MapToObject($data, $role);
                $roles[] = $role;
            }
        }
        
        return $roles;
    }
    
    /**
     * Get permissions the user has.
     * @param type $uid User ID
     * @return array[\Model\Permission] List of permissions
     */
    public static function GetUserPermissions($uid) {
        $permissions = array();
        
        // If no roles specified, get the current users roles.
        $roleList = self::GetUserRoles($uid);
        $roles = array();
        foreach ($roleList as $role) {
            $roles[] = $role->ID;
        }
        
        // Build the prepared statement for the "IN" clause
        $role_in = implode(",", array_fill(0, count($roles), "?"));
        
        $sql = "SELECT
                    PERMISSIONS.*
                FROM asct_permission_role_relation as ROLEREL
                INNER JOIN asct_permissions as PERMISSIONS ON (PERMISSIONS.ID = ROLEREL.PID)
                WHERE
                    PERMISSIONS.IsDeleted = 0 AND
                    ROLEREL.IsDeleted = 0 AND
                    ROLEREL.RID IN ({$role_in})";
                    
        $results = DAL::Prepared($sql, $roles);
        
        if ($results->rowCount() > 0) {
            foreach ($results->fetchAll(\PDO::FETCH_ASSOC) as $data) {
                $permission = new \Model\Permission();
                DAL::MapToObject($data, $permission);
                $permissions[] = $permission;
            }
        }
        
        return $permissions;
    }
    
    /**
     * Get the list of active users.
     * @return array[\Model\User]
     */
    public static function GetUsers() {
        $users = array();
        $sql = "SELECT * FROM asct_users WHERE IsDeleted = 0";
        
        $results = DAL::Query($sql);
        if ($results->rowCount() > 0) {
            foreach ($results->fetchAll(\PDO::FETCH_ASSOC) as $data) {
                $user = new \Model\User();
                DAL::MapToObject($data, $user);
                $users[] = $user;
            }
        }
        
        return $users;
    }
    
    /**
     * Update users password.
     * @param type $uid
     * @param type $password
     * @return boolean result
     */
    public static function UpdatePassword($uid, $password) {
        $sql = "UPDATE asct_users SET `Password` = ? WHERE `ID` = ?";
        DAL::Prepared($sql, array($password, $uid));
        return true;
    }
    
    /**
     * Update User Properties
     * @param type $uid
     * @param type $bannerid
     * @param type $first
     * @param type $middle
     * @param type $last
     * @param type $primaryemail
     * @param type $secondaryemail
     * @param type $primaryphone
     * @param type $secondaryphone
     */
    public static function UpdateUser($uid, $bannerid, $first, $middle, $last,
                $primaryemail, $secondaryemail, $primaryphone, $secondaryphone) {
        $sql = "UPDATE asct_users "
                . "SET `SchoolID` = ?, `First` = ?, `Middle` = ?, `Last` = ?, "
                . "`PrimaryPhone` = ?, `SecondaryPhone` = ?, `PrimaryEmail` = ?, `SecondaryEmail` = ? WHERE ID = ?";
        DAL::Prepared($sql, array($bannerid, $first, $middle, $last, $primaryphone, $secondaryphone, $primaryemail, $secondaryemail, $uid));
    }
    
    /**
     * Delete user.
     * @param type $uid
     */
    public static function DeleteUser($uid) {
        $sql = "UPDATE asct_users SET `IsDeleted` = 1 WHERE `ID` = ?";
        DAL::Prepared($sql, array($uid));
    }
    
    /**
     * Create User.
     * @param type $username
     * @param type $bannerid
     * @param type $first
     * @param type $middle
     * @param type $last
     * @param type $primaryemail
     * @param type $secondaryemail
     * @param type $primaryphone
     * @param type $secondaryphone
     * @param type $password
     * @return boolean User ID
     */
    public static function CreateUser($username, $bannerid, $first, $middle, $last,
            $primaryemail, $secondaryemail, $primaryphone, $secondaryphone, $password) {
        $sql = "INSERT INTO asct_users (`Username`, `SchoolID`, `Password`, `First`, `Middle`, `Last`, `PrimaryPhone`, `SecondaryPhone`, `PrimaryEmail`, `SecondaryEmail`, `DateCreated`) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, now())";
        $insertID = false;
        DAL::Prepared($sql, array($username, $bannerid, $password, $first, $middle, $last, $primaryphone, $secondaryphone, $primaryemail, $secondaryemail), $insertID);
        
        return $insertID;
    }
    
    public static function SetUserRole($uid, $role) {
        $sql = "DELETE FROM asct_user_role_relation WHERE UID = ?";
        DAL::Prepared($sql, array($uid));
        
        $sql = "INSERT INTO asct_user_role_relation (RID, UID) VALUES (?, ?)";
        DAL::Prepared($sql, array($role, $uid));
    }
    
    public static function GetSubordinateRoles($uid) {
        $roles = self::GetUserRoles($uid);
        $roleids = array();
        
        foreach ($roles as $role) {
            $roleids[] = $role->ID;
        }
        
        $roles = array();
        
        $param = implode(",", array_fill(0, count($roleids), "?"));
        
        $sql = "SELECT
                    ROLES.*
                FROM asct_roles_subordinates AS SUBS
                INNER JOIN asct_roles AS ROLES on (SUBS.SUBORDINATEID = ROLES.ID)
                WHERE	SUBS.PARENTID IN ({$param})
                GROUP BY ROLES.ID";
        $results = DAL::Prepared($sql, $roleids);
        
        if ($results->rowCount() > 0) {
            foreach ($results->fetchAll(\PDO::FETCH_ASSOC) as $data) {
                $role = new \Model\Role();
                DAL::MapToObject($data, $role);
                $roles[] = $role;
            }
        }
        
        return $roles;
    }
    
    public static function GetUserRoleByRoleID($roleID) {
        $sql = "SELECT * FROM asct_roles WHERE ID = ?";
        $results = DAL::Prepared($sql, array($roleID));
        $role = new \Model\Role();
        DAL::MapToObject($results->fetch(\PDO::FETCH_ASSOC), $role);
        return $role;
    }
}
