<?php
session_start();
require("config/config.php");
$session = new Session();
$auth = new Auth();
$userId=$session->getUserId();
if($userId){
	$oldpassword = md5($_POST['oldpassword']);
	$newpassword = $_POST['newpassword'];
	$confirmpassword=$_POST['confirmpassword'];
	
$column = array("uid","uname","first_name","uemail");
$where = " WHERE uid='".$userId."' and upass='".$oldpassword."'";
$user = $auth->authentication($column,$where);
	if(!empty($user)){
		if($newpassword==$confirmpassword){
			$newpassword=md5($newpassword);
			$date = date('Y-m-d H:i:s');
			$columns = array('upass'=>$newpassword,'updateAt'=>$date);
			$where = " WHERE uid='".$userId."'";
			$auth->update($columns,$where);
			$result = array("msg"=>"success");
		}else{
			$result = array("msg"=>"New password and confirm password is not matching");
		}
	}else{
		$result = array("msg"=>"Old password is not valid! Try again..");
	}
}else{
$result = array("msg"=>"You have not login");
}

echo json_encode($result);
?>