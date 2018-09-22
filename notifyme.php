<?php
session_start();
require("config/config.php");
$notifyme = new Notifyme();

$notification=array();
$notification['contact'] = strip_tags($_POST['contact']);
$notification['email'] = strip_tags($_POST['email']);
$notification['description'] = strip_tags($_POST['description']);
$notification['product_id'] = $_POST['pid'];
$notification['createdAt']=date("Y-m-d H:i:s");	
if(empty($notification['email'])){
	echo "no";
	exit;
}
$result = $notifyme->create($notification);
$insertedId = $notifyme->lastInsertedId();

if($insertedId){
    echo "yes";
}else{
	echo "no";
}
?>
