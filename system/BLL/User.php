<?php
namespace BLL;

/**
 * Handles business logic for users.
 *
 * @author Thomas Eynon
 */
class User {
    public function __construct() {
        
    }
    
    public static function Login($username, $password) {
        $result = false;
        
        // See if user exists.
        $user = \DAL\User::GetUserByUsername($username, true);
        
        if ($user != false && password_verify($password, $user->Password)) {
            // User is valid, login user.
            $_SESSION[\Controller\RootViewController::SESSIONTOKENNAME] = \DAL\User::LoginUser($user->ID);
            $_SESSION[\Controller\RootViewController::SESSIONUSERID] = $user->ID;
            $result = true;
        }
        
        return $result;
    }
    
    public static function ValidateSession($userid, $token) {
        $usersession = \DAL\User::GetUserSession($userid, $token);
        return $usersession->IsValid();
    }
    
    public static function InvalidateSession($userid, $token) {
        $usersession = \DAL\User::InvalidateSession($userid, $token);
    }
    
    public static function GetUserByID($uid) {
        return \DAL\User::GetUserByID($uid);
    }
    
    public static function GetUserRoles($uid) {
        return \DAL\User::GetUserRoles($uid);
    }
    
    public static function GetSubordinateRoles($uid) {
        return \DAL\User::GetSubordinateRoles($uid);
    }
    
    public static function GetUserPermissions($uid) {
        return \DAL\User::GetUserPermissions($uid);
    }
    
    public static function GetUsers() {
        return \DAL\User::GetUsers();
    }
    
    public static function ValidateUserPassword($uid, $password) {
        $user = \DAL\User::GetUserByID($uid, true);
        return password_verify($password, $user->Password);
    }
    
    public static function CreateUser(\ViewModel\AddUserViewModel $userModel) {
       $user =  \DAL\User::CreateUser($userModel->username, $userModel->bannerid, 
                $userModel->first, $userModel->middle, $userModel->last, 
                $userModel->primaryemail, $userModel->secondaryemail,
                $userModel->primaryphone, $userModel->secondaryphone,
                password_hash($userModel->newpassword, PASSWORD_DEFAULT));
       
       // Add user role.
       \DAL\User::SetUserRole($user, $userModel->role);
        
        return $user;
    }
    
    public static function UpdatePassword($uid, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        return \DAL\User::UpdatePassword($uid, $password);
    }
    
    public static function UpdateUser($uid, \ViewModel\EditUserViewModel $editUserViewModel) {
        \DAL\User::UpdateUser($uid, $editUserViewModel->bannerid, 
                $editUserViewModel->first, $editUserViewModel->middle, $editUserViewModel->last,
                $editUserViewModel->primaryemail, $editUserViewModel->secondaryemail,
                $editUserViewModel->primaryphone, $editUserViewModel->secondaryphone);
        
        if ($editUserViewModel->role != -1) {
            \DAL\User::SetUserRole($uid, $editUserViewModel->role);
        }
    }
    
    public static function DeleteUser($uid) {
        \DAL\User::DeleteUser($uid);
    }
    
    public static function CheckUsername($username) {
        $user = \DAL\User::GetUserByUsername($username);
        
        return ($user === false);
    }
    
    public static function GetUserRoleByRoleID($roleID) {
        return \DAL\User::GetUserRoleByRoleID($roleID);
    }
}
