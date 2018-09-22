<?php
require("header.php");
if(isset($userId)||isset($guiestId)){
$auth = new Auth();
$guiest = new Guiest();
$column = array();
if(isset($_POST['submit'])){
$errormsg = '';
$firstname	= isset($_POST['firstname'])?$_POST['firstname']:'';
$lastname	= isset($_POST['lastname'])?$_POST['lastname']:'';
$email		= isset($_POST['email'])?$_POST['email']:'';
$country	= isset($_POST['country'])?$_POST['country']:'';
$state		= isset($_POST['state'])?$_POST['state']:'';
$zipcode	= isset($_POST['zipcode'])?$_POST['zipcode']:'';
$oldpassword= isset($_POST['oldpassword'])?trim($_POST['oldpassword']):'';
$newpassword= isset($_POST['newpassword'])?trim($_POST['newpassword']):'';
$confirmpassword= isset($_POST['confirmpassword'])?trim($_POST['confirmpassword']):'';
if(isset($userId)){
$where1 = " WHERE uid='".$userId."'";
$columns = array('first_name'=>$firstname,'last_name'=>$lastname,'uemail'=>$email,'state'=>$state,'country'=>$country,'zipcode'=>$zipcode);
}elseif(isset($guiestId)){
$where1 = " WHERE gid='".$guiestId."'";
$columns = array('first_name'=>$firstname,'last_name'=>$lastname,'gemail'=>$email,'state'=>$state,'country'=>$country,'zipcode'=>$zipcode);
}
if(!empty($oldpassword)&&!empty($newpassword)&&!empty($confirmpassword)){
 if(strlen($newpassword)>5){
	$oldpassword=md5($oldpassword);
	if($newpassword == $confirmpassword){
		$where = " WHERE uid='".$userId."' and upass='".$oldpassword."'";
		$user = $auth->authentication($column,$where);
		if(!empty($user)){
			$columns['upass']=md5($newpassword);
		}else{
			$errormsg = "<div style='background:#E80508;padding:5px;'><strong>Oldpassword is not valid</strong></div>";
		}
	}else{
		$errormsg = " <div style='background:#E80508;padding:5px;'><strong>New password and Confirm password should be same</strong></div>";
	}
 }else{
	$errormsg = "<div style='background:#E80508;padding:5px;'><strong>Password detail is not valid. <br> Password length should be greater than 5</strong></div>";
 }
}
	if(isset($userId)){
		if(empty($errormsg)){
			$auth->update($columns,$where1);
			$errormsg="<div style='background:#45Ab33;padding:5px;'><strong>Account information saved successfully</strong></div> ";
		}
	}elseif(isset($guiestId)){
		$guiest->update($columns,$where1);
		$errormsg="<div style='background:#45Ab33;padding:5px;'><strong>Account information saved successfully</strong></div> ";
	}
}
if(isset($userId)){
$where = " WHERE uid='".$userId."'";
$user = $auth->authentication($column,$where);
}elseif(isset($guiestId)){
$where = " WHERE gid='".$guiestId."'";
$user = $guiest->select($column,$where);
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
              <li class="sitenav_active"><a href="account-information.php">Account Infromation</a></li>
              <li><a href="billing-shipping.php">Billing & Shipping</a></li>
              <li><a href="my-coupons.php">My Signup Coupons</a></li>
              <li><a href="order.php">Orders</a></li>
            </ul>


</div>

<div class="col-lg-9 col-sm-8">
<div class="clearfix"></div>

<div class="account_edit">

<h4>Account Information </h4>

<?php if(isset($errormsg)&&!empty($errormsg)){ echo $errormsg;}?>
<br>

<form class="form-horizontal" role="form" name="accountfrm" id="accountfrm" method="post">
<strong>Customer Details</strong><br><br>

<div class="col-lg-6">
  <div class="form-group">
    <label class="col-sm-4 control-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="firstname" id="firsrname" value="<?php echo isset($user['0']['first_name'])?$user['0']['first_name']:'';?>">
    </div>
  </div>

<div class="form-group">
    <label class="col-sm-4 control-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo isset($user['0']['last_name'])?$user['0']['last_name']:'';?>">
    </div>
  </div>
  
<div class="form-group">
    <label class="col-sm-4 control-label">State/province</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="state" id="state" value="<?php echo isset($user['0']['state'])?$user['0']['state']:'';?>">
    </div>
  </div>     
  
</div>


<div class="col-lg-6">
<div class="form-group">
    <label class="col-sm-4 control-label">Email Address</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="email" id="email" value="<?php echo isset($user['0']['uemail'])?$user['0']['uemail']:'';?>">
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-4 control-label">Country</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="country" id="country" value="<?php echo isset($user['0']['country'])?$user['0']['country']:'';?>">
    </div>
  </div>
  
   <div class="form-group">
    <label class="col-sm-4 control-label">Zipcode</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="zipcode" id="zipcode" value="<?php echo isset($user['0']['zipcode'])?$user['0']['zipcode']:'';?>">
    </div>
  </div>

</div>

<div class="clearfix"></div>
<br>
<br>

<?php if(isset($userId)){ ?>
<div class="col-lg-7">
<strong>Change Password</strong><br><br>
<div class="form-group">
    <label class="col-sm-4 control-label">Current Password</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="oldpassword" id="oldpassword">
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-4 control-label">New Password</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="newpassword" id="newpassword">
    </div>
  </div>
  
    <div class="form-group">
    <label class="col-sm-4 control-label">Confirm Password</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="confirmpassword" id="conrmfipassword">
    </div>
  </div>
 
 <div class="form-group">
    <div class="col-sm-offset-4 col-sm-8"> 
 <input  type="submit" name="submit" value="Save"> 
  </div>
  </div>

</div>
<?php } ?>
</form>


</div>


</div>



</div>
</div>
<!--end Product Cat -->
<?php
require("footer.php");
}else{
header("index.php");
}
?>