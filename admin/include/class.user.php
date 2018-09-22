<?php

class User extends Database{

    public function __construct() {
       $this->tableName = "users";
       parent::__construct();
    }

    /*     * * for registration process ** */

    public function reg_user($name, $username, $password, $email) {
        //echo "k";

        $password = md5($password);

        //checking if the username or email is available in db
        $query = "SELECT * FROM users WHERE uname='$username' OR uemail='$email'";
        //echo "k1";
        $count_row = $this->mysql_num_rows($check);

        //if the username is not in db then insert to the table
        if ($count_row == 0) {//echo "k3";
            $this->data = ['uname'=>$username,'upass'=>$password,'fullname'=>$name,'uemail'=>$email];
            $result = $this->insert();
            //echo "k4";
            return $result;
        } else {
            return false;
        }
    }

    /*     * * for login process ** */

    public function check_login($emailusername, $password) {

        $password = md5($password);

        //checking if the username is available in the table
        $this->columns = ['uid'];
        $this->where = "WHERE uemail='$emailusername' or uname='$emailusername' and upass='$password'";
        $rows = $this->select();
        

        if ($rows) {
            $_SESSION['login'] = true; // this login var will use for the session thing
            $_SESSION['uid'] = $this->insertedId();
            return true;
        } else {
            return false;
        }
    }

    /*     * * for showing the username or fullname ** */

    public function get_fullname($uid) {
        $result = mysql_query("SELECT fullname FROM users WHERE uid = $uid");
        $user_data = mysql_fetch_array($result);
        echo $user_data['fullname'];
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