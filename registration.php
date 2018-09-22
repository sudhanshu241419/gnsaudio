<?php
session_start();
require_once("config/config.php");
$auth = new Auth();
$session = new Session();
$coupon = New Coupons();
$user=array();
$user['uname'] = strip_tags($_POST['user_name']);
$user['uemail'] = strip_tags($_POST['email']);
if(isset($_POST['password']) && !empty($_POST['password'])){
    if($_POST['password']!=$_POST['password']){
        echo "pno";
        exit;
    }
    $user['upass'] = md5($_POST['password']);
}elseif(isset($_POST['fbUID'])&&!empty($_POST['fbUID'])){
    $where=" WHERE fbUserId='".$_POST['fbUID']."'";
    $column= array('uid','uname','uemail');
    $fbuser = $auth->getUser($column,$where);
    if(empty($fbuser)){
        $user['fbUserId']=$_POST['fbUID'];
      }else{
        $session->setSession($fbuser);
        echo "yes";
        exit;
    }
}else{
    echo "no";
    exit;
}
$user['createdAt']=date("Y-m-d H:i:s");	
$result = $auth->insertUser($user);
$insertedId = $auth->insertedId();
$data = array('userid'=>$insertedId,'description'=>COUPONDISCRIPTION,'code'=>COUPONCODE,'value'=>COUPONVALUE,'minimumpurchase'=>MINIMUMPURCHASE,'createdAt'=>date('Y-m-d H:i:s'),'status'=>'1');
$coupon->insert($data);

if($result == 1){
    if(isset($_POST['fbUID'])&&!empty($_POST['fbUID'])){
        $fbuserInSession = array(array('uid'=>$insertedId,'uname'=>$_POST['user_name'],'uemail'=>$_POST['email']));
        $session->setSession($fbuserInSession);
    }
	echo "yes";
}else{
	echo "no";
}
?>
