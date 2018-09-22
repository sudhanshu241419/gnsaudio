<?php
require("header.php");
if(isset($userId) || isset($guiestId)){
$billing = new Billing();
$billingguiest = new Guiestbilling();
$errormsg='';
if(isset($_POST['submit'])){
	$columns = array();
	$firstname=isset($_POST['firstname'])?trim($_POST['firstname']):'';
	$lastname=isset($_POST['lastname'])?trim($_POST['lastname']):'';
	$company=isset($_POST['company'])?trim($_POST['company']):'';
	$telephone=isset($_POST['telephone'])?trim($_POST['telephone']):'';
	$mobile=isset($_POST['mobile'])?trim($_POST['mobile']):'';
	$fax=isset($_POST['fax'])?trim($_POST['fax']):'';
	$street=isset($_POST['street'])?trim($_POST['street']):'';
	$city=isset($_POST['city'])?trim($_POST['city']):'';
	$state=isset($_POST['state'])?trim($_POST['state']):'';
	$zipcode=isset($_POST['zipcode'])?trim($_POST['zipcode']):'';
	$date=date("Y-m-d H:i:s");
	
	
	$billingId = isset($_POST['billingId'])?trim($_POST['billingId']):'';
	$columns = array('firstname'=>$firstname,'lastname'=>$lastname,'company'=>$company,'telephone'=>$telephone,'mobile'=>$mobile,'fax'=>$fax,'street'=>$street,'city'=>$city,'state'=>$state,'zipcode'=>$zipcode,'updatedAt'=>$date);
	if(isset($billingId)&&!empty($billingId)){
		$billingId = (int)$billingId;
		$where = " WHERE id=$billingId";
		if($guiestId){
			$billingguiest->update($columns,$where);
		}else{
			$billing->update($columns,$where);
		}
		$errormsg="<div style='background:#45Ab33;padding:5px;'><strong>Billing/Shiping information updated successfully</strong></div> ";
	}else{
		if($guiestId){
		$billingguiest->insert($columns);
		}else{
		$billing->insert($columns);
		}
		$errormsg="<div style='background:#45Ab33;padding:5px;'><strong>Billing/Shiping information saved successfully</strong></div> ";
	}
}
$columns = array();
if($guiestId){
$where = " WHERE guiestid = $guiestId";
$billingAdd = $billingguiest->select($columns,$where);
}else{
$where = " WHERE userid = $userId";
$billingAdd = $billing->select($columns,$where);
}
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
             <li class="sitenav_active"><a href="billing-shipping.php">Billing & Shipping</a></li>
              <li><a href="my-coupons.php">My Signup Coupons</a></li>
              <li><a href="order.php">Orders</a></li>
            </ul>


</div>

<div class="col-lg-9 col-sm-8">
<div class="clearfix"></div>
<form class="form-horizontal" role="form" name="billingfrm" id="billingfrm" method="post">
<input type="hidden" name="billingId" id="billingId" value="<?php echo (isset($billingAdd[0]['id']))?$billingAdd[0]['id']:'';?>">
<div class="row billfrm_box">
<h4 class="billtitle"><span>Contact Information </span></h4>
<?php if(isset($errormsg)&&!empty($errormsg)){ echo $errormsg;}?>
<br>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo (isset($billingAdd[0]['firstname']))?$billingAdd[0]['firstname']:'';?>">
    </div>
  </div>     
</div>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo (isset($billingAdd[0]['lastname']))?$billingAdd[0]['lastname']:'';?>">
    </div>
  </div>     
</div>



<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Company</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="company" id="company" value="<?php echo (isset($billingAdd[0]['company']))?$billingAdd[0]['company']:'';?>">
    </div>
  </div>     
</div>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Telephone </label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="telephone" id="telephone" value="<?php echo (isset($billingAdd[0]['telephone']))?$billingAdd[0]['telephone']:'';?>">
    </div>
  </div>     
</div>



<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Mobile</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo (isset($billingAdd[0]['mobile']))?$billingAdd[0]['mobile']:'';?>">
    </div>
  </div>     
</div>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Fax</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="fax" id="fax" value="<?php echo (isset($billingAdd[0]['fax']))?$billingAdd[0]['fax']:'';?>">
    </div>
  </div>     
</div>

</div>




<div class="row billfrm_box">
<h4 class="billtitle"><span>Address </span></h4>
<br>

<div class="col-lg-12">
<div class="form-group">
    <label class="col-sm-2 control-label">Street Address</label>
    <div class="col-sm-10">
    <textarea class="form-control" name="street" id="street"><?php echo (isset($billingAdd[0]['street']))?$billingAdd[0]['street']:'';?></textarea>
    </div>
  </div>     
</div>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">City</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="city" id="city" value="<?php echo (isset($billingAdd[0]['city']))?$billingAdd[0]['city']:'';?>">
    </div>
  </div>     
</div>



<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">State/Province</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="state" id="state" value="<?php echo (isset($billingAdd[0]['state']))?$billingAdd[0]['state']:'';?>">
    </div>
  </div>     
</div>

<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Zip/Postal Code </label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo (isset($billingAdd[0]['zipcode']))?$billingAdd[0]['zipcode']:'';?>">
    </div>
  </div>     
</div>



</div>

<div class="clearfix"></div>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9"> 
 <input  type="submit" value="Save" name="submit"> 
  </div>
  </div>

  
</form>





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