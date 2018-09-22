<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 6:20 PM
 */

class Session {
    public function setSession($user){
        $_SESSION['userId']=$user[0]['uid'];
        $_SESSION['userName']=$user[0]['uname'];
        $_SESSION['email']=$user[0]['uemail'];

        return true;
    }

    public function getSession($key){
        if(isset($_SESSION[$key]))
            return true;
        else
            return false;
    }

    public function getUserId(){
        if(isset($_SESSION['userId'])){
            return $_SESSION['userId'];
        }else{
            return false;
        }
    }

    public function getUserDetail(){
        return $_SESSION;
    }
    public function logout(){
       if(isset($_SESSION['userId'])){
        unset($_SESSION['userId']);
        unset($_SESSION['userName']);
        unset($_SESSION['email']);
    }
        return true;
    }
} 