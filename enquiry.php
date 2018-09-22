<?php
session_start();
require("config/config.php");
$enquiry = new Enquiry();
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
$result = $enquiry->create($notification);
$insertedId = $enquiry->lastInsertedId();

if($insertedId){
    echo "yes";
}else{
	echo "no";
}
?>
