<?php
require("header.php");
$review = new Review();
$param = isset($_GET['review'])?base64_decode($_GET['review']):0;
$reviewData = explode("||",$param);
$userid = $reviewData[0];
$productid = $reviewData[1];
$usertype = $reviewData[2];
$w=" WHERE userid=".$userid." and usertype='".$usertype."' and productid=".$productid;
$c=array();
$reviewData = $review->select($c,$w);
?>
<!--start page title-->
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="accountinfo_tilte">User Review</div>
</div>
</div>
</div>
<!--start page title-->



<!--start Product Cat-->
<div class="container">
<div class="row">
<div class="col-lg-5">
<h2 class="checkout_title">Review</h2>
<div class="row billing_addbox">
<?php if(!isset($_GET['rid']) && empty($reviewData)){ ?>
<form role="form" name="onestepcheckoutfrm" id="onestepcheckoutfrm" action="submitreview.php" method="post">
<input type="hidden" value="<?if(isset($_GET['review'])) echo $_GET['review'];?>" name="param">
<input type="hidden" id="reviewid" name="reviewid" value="<?php if(isset($_GRT['rid'])) echo $_GET['rid'];?>">
<input type="hidden" id="userid" name="userid" value="<?php echo $userid;?>">
<input type="hidden" id="usertype" name="usertype" value="<?php echo $usertype;?>">
<input type="hidden"  id="productid" name="productid" value="<?php echo $productid;?>">
 <div class="col-sm-12 cupbox continueToPayment">
   <textarea class="form-control" name="content"><?php if(isset($reviewComment)) echo $reviewComment;?></textarea><br>
   <input type="submit" name="reviewsmt" value="Submit">
    
  </div> 
</form>
 <?php 
 }elseif(isset($_GET['rid'])){ 
	echo "<ul style='font-weight:bold;padding-left:20px'><li>You has been submited review successfully.</li></ul>";
 }elseif(!empty($reviewData)){
	echo "<ul style='font-weight:bold;padding-left:20px'><li>You have already submited review.</li></ul>";
 }?>
</div>
</div>
</div>
</div>

<!--end Product Cat -->
<?php require("footer.php");?>