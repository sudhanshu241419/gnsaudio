<?php
session_start();
include_once 'config/config.php';
$user = new User();

$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("location:login.php");
}
$userIdOrderId = $_POST['reviewDetal'];
$review = base64_encode($userIdOrderId);
if(!empty($userIdOrderId)){
	$data = explode("||",$userIdOrderId);
	$column=array();
	if($data[2]=='g'){
		$tableName='guiest';
		$userDetail = new Module($tableName);
		$where = " WHERE gid=".$data[0];
		$record=$userDetail->select($column,$where);
		$email = $record['0']['gemail'];
	}elseif($data[2]=="u"){
		$tableName='users';
		$userDetail = new Module($tableName);
		$where = " WHERE uid=".$data[0];
		$record=$userDetail->select($column,$where);
		$email = $record['0']['uemail'];
	}
}else{
	echo "fail";
	die();
}
$to = $email;
//define the subject of the email
$subject = 'G N S Audios: Review on product';
//define the headers we want passed. Note that they are separated with \r\n
$headers = "From: akam <support@akam.in>\r\nReply-To: support@akam.in";
$headers .= "Return-Path: support@akam.in\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
//define the body of the message.
$message="";
$message="<html><body><table>";
$message .= "<tr><td>Hi,</td></tr>";
$message.="<tr><td>Thank you for order on the G N S Audios.in</td></tr><tr><td>Click on link <a href='http://akam.in/review.php?review=".$review."'>Click Here</a> to review on product.</td></tr>";
$message .="<tr><td>OR</td></tr>";
$message .="<tr><td>Copy and paste follwong URL in address war for review</td></tr>";
$message .="<tr><td>http://akam.in/review.php?review=".$review."</td></tr>";
$message .="<tr><td>&nbsp;</td></tr>";
$message .="<tr><td>Regards,</td></tr><tr><td> Team G N S Audios</td></tr></table></body></html>";
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
if($mail_sent)
echo "success";
else
echo "fail";
?>