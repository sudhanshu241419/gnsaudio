<?php
session_start();
require("config/config.php");
$session = New Session();
$email = $_POST['email'];
$password= md5($_POST['password']);
$auth = new Auth();
$column = array("uid","uname","first_name","uemail");
$where = " WHERE uemail='".$email."' and upass='".$password."'";
$user = $auth->authentication($column,$where);
if(!empty($user)){
    $session->setSession($user);
    echo 'yes';
}else{
    echo 'no';
}