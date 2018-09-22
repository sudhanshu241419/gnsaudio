<?php
session_start();
include_once("config/config.php");
$session = new Session();
$guiestsession = new Guiestsession();
$uId = $session->getUserId();
$gId=$guiestsession->getUserId();
$result = array();
if($uId || $gId){
	$coupon = $_POST['coupon'];
	$totalAmount = $_POST['totalAmount'];
	$column = array();
	if($coupon == "signup300"){
		$coupon = New Coupons();
		$where = " where userid=".$uId." and status = '1'";
		$couponData = $coupon->select($column,$where);
		if($couponData){
			if($totalAmount >= $couponData[0]['minimumpurchase']){
				$couponAmount = $couponData[0]['value'];
				$amount = $totalAmount-$couponAmount;
				$result=array("valid"=>"1","amount"=>$amount);
			}else{
				$msg="Your total amount should be greater or equal to ".$couponData[0]['minimumpurchase'];
				$result=array("valid"=>"0","msg"=>$msg);
			}
		}else{
			$result=array("valid"=>"0","msg"=>'Invalid Coupon');
		}
	}else{
			$akamCoupons = new AkamCoupons();
			$where = " coupon_code='".$coupon."'";
			$akamCoupon = $akamCoupons->select($column,$where);
			if($akamCoupon){
				$couponid = $akamCoupon[0]['id'];
				$assignCoupons = new AssignCoupons();
				$currentDate = date("Y-m-d H:i:s");
				if($uId){
					$uType="u";
					$userid = $uId;
				}elseif($gId){
					$uType = "g";
					$userid = $gId;
				}
				$where = " WHERE couponid='".$couponid."' and validDate>='".$currentDate."' and user_type='".$uType."' and userid=".$userid." and status = '1'";
				$aCoupon = $assignCoupons->select($column,$where);
				if($aCoupon){
					if($totalAmount >= $aCoupon[0]['minimum_purchase_amount']){
						$amount = $totalAmount - $aCoupon[0]['minimum_purchase_amount'];
						$result=array("valid"=>"1","amount"=>$amount);
					}else{
						$msg="Your total amount should be greater or equal to ".$aCoupon[0]['minimum_purchase_amount'];
						$result=array("valid"=>"0","msg"=>$msg);
					}
				}else{
					$result=array("valid"=>"0","msg"=>'Invalid Coupon');
				}
			}else{
				$result=array("valid"=>"0","msg"=>'Invalid Coupon');
			}
		}
}else{
	$result=array("valid"=>"0","msg"=>'Invalid Coupon');
}
echo json_encode($result);
?>