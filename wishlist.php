<?php
session_start();
require("config/config.php");
$wishlist = New Wishlist();
$productid = $_POST['productid'];
$session = New Session();
$guiestsession = new Guiestsession();
$userId = $session->getUserId();
$guiestId=$guiestsession->getUserId();
if($userId || $guiestId){
	$column=array();
	
$data = array("product_id"=>$productid,'createdAt'=>date("Y-m-d H:i:s"));
$column = array();
	if($userId){		
		$where = " where user_id='".$userId."' and product_id='".$productid."' and user_type='u'";
		$result = $wishlist->select($column,$where);
		if($result){
			echo "You have already added in wish list.";
			exit;
		}
		$data['user_type']="u";
		$data['user_id']=$userId;
		$wishlist->insert($data);
		
	}elseif($guiestId){
		$where = " where user_id='".$userId."' and product_id='".$productid."' and user_type='g'";
		$result = $wishlist->select($column,$where);
		if($result){
			echo "You have already added in wish list.";
			exit;
		}
		$data['user_type']="g";
		$data['user_id']=$guiestId;
		$wishlist->insert($data);
	}
	$insertedid = $wishlist->insertedId();
	if($insertedid){
		echo "Product has been added into your wish list";
	}else{
		echo "Product has not been added into your wish list";
	}
}else{
	echo "Please login to add product in wish list";
}
?>