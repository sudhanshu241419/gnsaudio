<?php
require("header.php");
$order = new Userorder();
$column=array();
if($userId || $guiestId){
	if($userId){
		$where = " WHERE userid=$userId and userType='u'";
	}elseif($guiestId){
		$where = " WHERE userid=$guiestId and userType='g'";
	}
	$myorder = $order->select($column,$where);
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
              <li><a href="my-coupons.php">My Signup Coupons</a></li>
              <li class="sitenav_active"><a href="order.php">Orders</a></li>
            </ul>


</div>

<div class="col-lg-9 col-sm-8">
<div class="clearfix"></div>

<h4>My Signup Coupons</h4>
<div class="accc_orderbox">
<table class="table table-bordered couptable">
<?php if(!empty($myorder)){ ?>
	<tr>
	
	<th>Transaction Id</th>
	<th>Order Id</th>
	<th>Payment Mode</th>
	
	<th>Product</th>
	<th>Product Image</th>
	<th>Product code</th>
	<th>Quantity</th>
	<th>Price</th>
	<th>Grand Total</th>
	<th>Purchase Date</th>
	<th>Status</th>
	</tr>
	<?php
	foreach($myorder as $key =>$val){
	?>
		<tr>
		
		<td><?php echo (isset($val['txnid']))?$val['txnid']:"Pending";?></td>
		<td><?php echo (isset($val['payuMoneyId']))?$val['payuMoneyId']:"Pending";?></td>
		<td><?php echo (isset($val['mode']))?$val['mode']:"Pending";?></td>
		
		<td><?php echo $val['productName'];?></td>
		<td><?php echo "<img src='".$val['image']."' width='80' height='80'>";?> </td>
		<td><?php echo $val['product_code'];?></td>
		<td><?php echo $val['qty'];?></td>
		<td><img src="images/r.jpg"><?php echo $val['itemPrice'];?></td>
		<td><img src="images/r.jpg"><?php echo $val['totalAmount'];?></td>
		<td><?php echo $val['createdAt'];?></td>
		<td><?php echo $val['status'];?></td>
		</tr>
<?php }
 }else{
 ?>
 <tr><td>You have not placed order</td></tr>
 <?php
 }?>
</table>
</div>
<a href="#">&laquo; Back</a>

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