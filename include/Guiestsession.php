<?php
/**
 * Created by PhpStorm.
 * User: sud
 * Date: 7/12/14
 * Time: 6:20 PM
 */

class Guiestsession {
    public function setSession($guest){
        $_SESSION['guiestId']=$guest[0]['gid'];
        $_SESSION['guiestName']=$guest[0]['gname'];
        $_SESSION['guiestEmail']=$guest[0]['gemail'];

        return true;
    }

    public function getSession($key){
        if(isset($_SESSION[$key]))
            return true;
        else
            return false;
    }

    public function getUserId(){
        if(isset($_SESSION['guiestId'])){
            return $_SESSION['guiestId'];
        }else{
            return false;
        }
    }

    public function getUserDetail(){
        return $_SESSION;
    }
    public function logout(){
        if(isset($_SESSION['guiestId'])){
            unset($_SESSION['guiestId']);
            unset($_SESSION['guiestName']);
            unset($_SESSION['guiestEmail']);
        }
        return true;
    }
    
    public function destroySession(){
        if(isset($_SESSION['guiestId'])){
            unset($_SESSION['guiestId']);
            unset($_SESSION['guiestName']);
            unset($_SESSION['guiestEmail']);
        }
        session_destroy();
    }
} 