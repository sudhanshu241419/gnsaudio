<?php

class User extends Database {

    public function __construct() {
        $this->tableName = "users";
        parent::__construct();
    }

    /*     * * for registration process ** */

    public function reg_user($name, $username, $password, $email) {
        //echo "k";

        $password = md5($password);

        //checking if the username or email is available in db
        $check = $this->querystr("SELECT * FROM admin WHERE uname='$username' OR uemail='$email'");
        //echo "k1";
        $count_row = $this->insertedId();

        //if the username is not in db then insert to the table
        if ($count_row == 0) {//echo "k3";
            $result = $this->query("INSERT INTO admin SET uname='$username', upass='$password', fullname='$name', uemail='$email'");
            //echo "k4";
            return $this->insertedId();
        } else {
            return false;
        }
    }

    /*     * * for login process ** */

    public function check_login($emailusername, $password) {

        $password = md5($password);
        //checking if the username is available in the table
        $result = $this->queryStr("SELECT uid from admin WHERE uemail='$emailusername' or uname='$emailusername' and upass='$password'");     
        if ($result) {
            $_SESSION['login'] = true; // this login var will use for the session thing
            $_SESSION['uid'] = $result['uid'];
            return true;
        } else {
            return false;
        }
    }

    /*     * * for showing the username or fullname ** */

    public function get_fullname($uid) {
        $result = $this->queryStr("SELECT fullname FROM admin WHERE uid = $uid");        
        echo $result['fullname'];
    }

    /*     * * starting the session ** */

    public function get_session() {

        return $_SESSION['login'];
    }

    public function user_logout() {
        $_SESSION['login'] = FALSE;
        session_destroy();
    }

}

?>