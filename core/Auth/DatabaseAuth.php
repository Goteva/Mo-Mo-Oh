<?php

namespace Core\Auth;

use Core\Database\MysqlDatabase;

class DatabaseAuth
{
    private $db;

    public function __construct(MysqlDatabase $db)
    {
        $this->db = $db;
    }

    public function getSessionByIdUser()
    {
        if($this->logged()){
            return $_SESSION['auth'];
        }
        return false;
    }

    public function login($username, $password)
    {
        $user = $this->db->prepare('SELECT * FROM users WHERE users_login = ?', [$username], null, false);
        if($user){
            if($user->users_password === sha1($password)){
                $_SESSION['auth'][$user->id_users] = $user->users_login;
                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        if(isset($_SESSION['auth'])){
            unset($_SESSION['auth']);
        }
    }


    public function logged()
    {
        return isset($_SESSION['auth']);
    }
}
