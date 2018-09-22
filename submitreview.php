<?php
include("config/config.php");
$review = new Review();

$param = isset($_POST['param'])?base64_decode($_POST['param']):0;
$reviewData = explode("||",$param);
$userid = $reviewData[0];
$productid = $reviewData[1];
$usertype = $reviewData[2];
if(isset($_POST['reviewsmt'])){
	$reviewComment = $_POST['content'];
	$column = array('userid'=>$userid,'usertype'=>$usertype,'productid'=>$productid,'content'=>$reviewComment,'status'=>'0');
	if(isset($_POST['reviewid']) && !empty($_POST['reviewid'])){
		$column ['updatedAt']=date("Y-m-d H:i:s");
		$where = " WHERE id=".$_POST['reviewid'];
		$review->update($column,$where);
		$message="updated";
	}else{
		$column ['createdAt']=date("Y-m-d H:i:s");
		$review->insert($column);
		$rid = $review->insertedId();
		$message="inserted";
	}
}
header("location:review.php?review=".$_POST['param']."&rid=".$rid);
?>