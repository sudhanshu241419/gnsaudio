<?php
session_start();
require("config/config.php");
$emailtofriend = New Emailtofriend();
$products = New Product();
$productid = isset($_POST['pid'])?(int)$_POST['pid']:0;
$friendEmail = $_POST['email'];
if(isset($_POST['size']))
$size = "&size=".$_POST['size'];
$session = New Session();
$guiestsession = new Guiestsession();
$userId = $session->getUserId();
$guiestId=$guiestsession->getUserId();
if($userId)
$username =$_SESSION['userName'];
if($guiestId)
$username = $_SESSION['guiestName'];

if($userId || $guiestId){
	$query = "SELECT p.id, 	p.cid, p.materialId, p.product_code,p.productName,p.title,p.instruction,p.description,p.metaTag,p.metaDescription,p.flatdiscount,p.image_small,p.image_large,sp.id as sid,sp.price,sp.size,sp.quantity FROM products as p left join size_price as sp on p.id=sp.pid";
	$where = " WHERE p.id =".$productid;
	$query=$query.$where;
	$product = $products->joinLeft($query);
	$email = explode(",",$friendEmail);
		foreach($email as $key =>$val){		

		$to = $val;
		//define the subject of the email
		$subject = 'G N S Audios: Refered by friend'.$username;
		//define the headers we want passed. Note that they are separated with \r\n
		$headers = "From: akam <support@akam.in>\r\nReply-To: support@akam.in";
		$headers .= "Return-Path: support@akam.in\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		//define the body of the message.
		$message="";
		$message="<html><body><table border='0' bgcolor='#FBF0F0'>";
		$message .= "<tr><td>Hi,</td></tr>";
		$message.="<tr><td>Your friend ".$username." has reffered this product for you</td></tr>";
		$message.="<tr><td>";
		$message.="<table border='0'><tr>";
		$message.="<td><img src='http://akam.in/".$product[0]['image_small']."' width='317'></td>";
		$message.="<td>";
		$message.="<table><tr><td><h2>".$product[0]['title']."</h2></td></tr>";
		$message.="<tr><td><small>Price Per Unit </small><h2>RS ".$product[0]['price']."</h2></td></tr>";
		$message.="<tr><td>".$product[0]['description']."</td></tr>";
		$message.="</table></td>";
		$message.="</tr></table>";
		$message.="</td></tr>";
		$message .="<tr><td>Click to access the product <a href='http://akam.in/product-detail.php?pid=".$productid.$size."'>Click Here</a> to review on product.</td></tr>";
		$message .="<tr><td>OR</td></tr>";
		$message .="<tr><td>Copy and paste follwong URL in address war for product view</td></tr>";
		$message .="<tr><td>http://akam.in/product-detail.php?pid=".$productid.$size."</td></tr>";
		$message .="<tr><td>&nbsp;</td></tr>";
		$message .="<tr><td>Regards,</td></tr><tr><td> Team G N S Audios</td></tr></table></body></html>";
		
		//send the email
		$mail_sent = @mail( $to, $subject, $message, $headers );
		}
		echo "Thanks to send mail to friend.";
	}else{
		echo "Please login for mail to friend.";
	}
	?>