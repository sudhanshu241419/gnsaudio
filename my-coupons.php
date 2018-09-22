<?php
require("header.php");
if($userId){
$coupons = New Coupons();
$column = array();
$where = " WHERE userid ='".$userId."'";
$userCoupons = $coupons->select($column,$where);
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

<div class="col-lg-3 col-sm-4">
<ul class="nav nav-list  affix-top visible-desktop sitenav">
               <li ><a href="account.php">Account Dashboard</a></li>
              <li><a href="account-information.php">Account Infromation</a></li>
               <li><a href="billing-shipping.php">Billing & Shipping</a></li>
              <li class="sitenav_active"><a href="my-coupons.php">My Signup Coupons</a></li>
              <li><a href="order.php">Orders</a></li>
            </ul>


</div>

<div class="col-lg-9 col-sm-8">
<div class="clearfix"></div>

<h4>My Signup Coupons</h4>
<div class="table-responsive">
<table class="table table-bordered couptable">
<?php if(!empty($userCoupons)){ ?>
	<tr>
	<th>Code Descripition</th>
	<th>Code</th>
	<th>Code Coupon Value</th>
	<th>Minimum Purchase</th>
	</tr>
	<?php
	foreach($userCoupons as $key =>$val){
	?>
		<tr>
		<td><?php echo $val['description'];?></td>
		<td><?php echo $val['code'];?> </td>
		<td><?php echo $val['value'];?></td>
		<td><?php echo $val['minimumpurchase'];?></td>
		</tr>
<?php }
 }else{
 ?>
 <tr><td>There is no any coupon</td></tr>
 <?php
 }?>
</table>
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