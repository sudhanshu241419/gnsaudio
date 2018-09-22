<?php
require("header.php");
if($userId || $guiestId){
$column = array();
	if($userId){
		$auth = new Auth();		
		$where = " WHERE uid='".$userId."'";
		$user = $auth->authentication($column,$where);
	}elseif($guiestId){
		$guiest = new Guiest();
		$where = " WHERE gid='".$guiestId."'";
		$user = $guiest->select($column,$where);
	}
//print_r($user);

?>

<!--start page title-->
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="accountinfo_tilte">My Account</div>
</div>
</div>
</div>
<!--start page title-->



<!--start Product Cat-->
<div class="container">
<div class="row">

<div class="col-lg-3">
<ul class="nav nav-list  affix-top visible-desktop sitenav">
              <li class="sitenav_active"><a href="account.php">Account Dashboard</a></li>
              <li><a href="account-information.php">Account Infromation</a></li>
              <li><a href="billing-shipping.php">Billing & Shipping</a></li>
              <li><a href="my-coupons.php">My Signup Coupons</a></li>
              <li><a href="order.php">Orders</a></li>
            </ul>


</div>

<div class="col-lg-9">
<div class="clearfix"></div>
<div class="actcont">
<h4>Dashboard </h4>
Hello <?php echo $user[0]['first_name'];?>!<br>

From yur My Account Dashboard your have the ability to view a snapshot of your recent account  activity and update your accoutn 
information . select a link below to view or edit information.
</div>

<div class="bdacount_info">
<h4>Account-information</h4>
<div class="col-lg-6">
<div class="panel panel-default">
  <div class="panel-heading">Contact Information</div>
  <div class="panel-body">
   <div class="actinf_cont">
<?php echo $user[0]['first_name'];?><br>
<?php echo (isset($user[0]['uemail']))?$user[0]['uemail']:$user[0]['gemail'];?> <br>
<?php if(empty($user[0]['fbUserId'])){ ?>
<a href="#" data-toggle="modal" data-target=".bs-example-modal-changepassword" >Change Password</a>
<?php } ?>
</div>
<a href="account-information.php" class="actilink_right">Edit</a>
</div>
</div>
</div>

<div class="col-lg-6">
<div class="panel panel-default">
  <div class="panel-heading">Newsletters</div>
  <div class="panel-body">
  <div class="actinf_cont">
You are currently not subscribed to and newsletter. 
</div>
<a href="#" class="actilink_right">Edit</a>
 </div>
</div>
</div>

<div class="clearfix"></div>

<h4>Address Book</h4>
<div class="col-lg-6">
<div class="panel panel-default">
  <div class="panel-heading">Default billing Address</div>
  <div class="panel-body">
   <div class="actinf_cont">
You have not set detault biilling adddress. 
</div>
<a href="billing-shipping.php" class="actilink_right">Edit</a>

 </div>
</div>
</div>

<div class="col-lg-6">
<div class="panel panel-default">
  <div class="panel-heading">Default Shipping Address</div>
  <div class="panel-body">
   <div class="actinf_cont">
Your have not set a default shipping address. 
</div>
<a href="billing-shipping.php" class="actilink_right">Edit</a>
</div>
</div>
</div>

</div>

</div>

</div>
</div>
<!--end Product Cat -->
<?php
require("footer.php");
}else{
header("location:index.php");
}
?>