<?php
require("header.php");
$addtocart = new AddToCart();
$sessionId = session_id();

$column = array();
$where = " WHERE sessionId ='".$sessionId."' and status = 'pendding'";
$mycart = $addtocart->getData($column,$where);
$session = new Session();
$userId = $session->getUserId();
$guiestsession = new Guiestsession();
$guiestId = $guiestsession->getUserId();
$sessionId = session_id();

  $column=array();
//  if($guiestId){
//    $guiestobj = new Guiest();
//    $where = " WHERE gid=".$guiestId;
//    $guiestDetail = $guiestobj->select($column,$where);
//    $uname=$guiestDetail[0]['gname'];
//    $first_name=$guiestDetail[0]['first_name'];
//    $uemail=$guiestDetail[0]['gemail'];
//    $last_name=$guiestDetail[0]['last_name'];   
//    $country=$guiestDetail[0]['country'];   
//    $state=$guiestDetail[0]['state'];   
//    $zipcode=$guiestDetail[0]['zipcode'];   
//    $city=$guiestDetail[0]['city'];  
//    $address1=$guiestDetail[0]['address1'];  
//    $address2=$guiestDetail[0]['address2'];  
//    $telephone=$guiestDetail[0]['telephone'];   
//    $mobile=$guiestDetail[0]['mobile'];  
//    $news_subscribe=$guiestDetail[0]['news_subscribe'];
//  }
  
//  elseif($userId){
//    $userObj = new Auth();
//    $where = " WHERE uid=".$userId;
//    $userDetail = $userObj->getUser($column,$where);
//    $uname==$userDetail[0]['uname'];
//    $first_name=$userDetail[0]['first_name'];  
//    $uemail=$userDetail[0]['uemail'];  
//    $last_name=$userDetail[0]['last_name'];   
//    $country=$userDetail[0]['country'];   
//    $state=$userDetail[0]['state'];   
//    $zipcode=$userDetail[0]['zipcode'];  
//    $city=$userDetail[0]['city'];  
//    $address1=$userDetail[0]['address1'];  
//    $address2=$userDetail[0]['address2'];  
//    $telephone=$userDetail[0]['telephone'];   
//    $mobile=$userDetail[0]['mobile'];  
//    $news_subscribe=$userDetail[0]['news_subscribe'];  
//
//
//  }


?>

<!--start page title-->
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="accountinfo_tilte">Check Out</div>
</div>
</div>
</div>
<!--start page title-->



<!--start Product Cat-->
<div class="container">
<div class="row">
<div class="col-lg-5">
<h2 class="checkout_title">Billing Address</h2>
<div class="row billing_addbox">
<div class="col-sm-12 blogin_title">Login as Guest (or) Register</div>
<form role="form" name="onestepcheckoutfrm" id="onestepcheckoutfrm" action="" method="post">
<?php //if(!$guiestId || !$userId){?>
<!--	<div class="col-sm-12 gust_opt">
		<label class="radio-inline">
		  <input type="radio" name="guest" id="guest" value="g" onclick="document.getElementById('p').style.display='none'; document.getElementById('cp').style.display='none';" checked=checked > Guest
		</label>
		<label class="radio-inline">
		  <input type="radio" name="guest" id="guest" value="r" onclick="document.getElementById('p').style.display='block'; document.getElementById('cp').style.display='block';"> Register
		</label>
	</div>-->
<?php //}else{  
//              if(isset($userId) && !empty($userId)){ ?>
<!--              <input type="hidden" name="guest" id="guest" value="r">-->
              <?PHP //}elseif(isset($gueistId) && !empty($gueistId)){ ?>
<!--              <input type="hidden" name="guest" id="guest" value="g">-->
              <?php //}?>


  <?php //} ?>
	
      <input type="hidden" name="guest" id="guest" value="g">
      <div class="col-sm-6">
        <div class="form-group">
        <label>First Name</label>
        <input type="text" value="<?php if(isset($first_name)) echo $first_name;?>" name="firstname" id="firstname" class="form-control">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
        <label>Last Name</label>
        <input type="text" value="<?php if(isset($last_name)) echo $last_name;?>" name="lastname" id="lastname" class="form-control">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
        <label>Shop/Company Name</label>
        <input type="text" value="<?php if(isset($company)) echo $company;?>" name="company" id="company" class="form-control">
        </div>
      </div>

      <div class="col-sm-6">
        <div class="form-group">
        <label>Email Address</label>
        <input type="email" value="<?php if(isset($uemail)) echo $uemail;?>" name="email" id="email" class="form-control">
        </div>
      </div> 

      <div class="col-sm-12">
        <div class="form-group">
        <label>Address Line 1</label>
        <input type="text" value="<?php if(isset($address1)) echo $address1;?>" name="address1" id="address1" class="form-control">
        </div>
      </div> 

      <div class="col-sm-12">
        <div class="form-group">
        <label>Address Line 2</label>
        <input type="text" value="<?php if(isset($address2)) echo $address2;?>" name="address2" id="address2" class="form-control">
        </div>
      </div> 

      <div class="col-sm-6">
        <div class="form-group">
        <label>City</label>
        <input type="text" value="<?php if(isset($city)) echo $city;?>" name="city" id="city" class="form-control">
        </div>
      </div> 

      <div class="col-sm-6">
        <div class="form-group">
        <label>State/Province</label>
        <input type="text" value="<?php if(isset($state)) echo $state;?>" name="state" id="state" class="form-control">
        </div>
      </div> 

      <div class="col-sm-6">
        <div class="form-group">
        <label>Zip/Postal code</label>
        <input type="text" value="<?php if(isset($zipcode)) echo $zipcode;?>" name="zip" id="zip" class="form-control">
        </div>
      </div> 

      <div class="col-sm-6">
        <div class="form-group">
        <label>Country</label>
        <input type="text" value="<?php if(isset($country)) echo $country;?>" name="country" id="country" class="form-control">
        </div>
      </div>  

      <div class="col-sm-6">
        <div class="form-group">
        <label>Telephone</label>
        <input type="phone" value="<?php if(isset($telephone)) echo $telephone;?>" name="telephone" id="telephone" class="form-control">
        </div>
      </div>  


      <div class="col-sm-6">
        <div class="form-group">
        <label>Mobile</label>
        <input type="phone" value="<?php if(isset($mobile)) echo $mobile;?>" name="mobile" id="mobile" class="form-control">
        </div>
      </div>  
  <?php //if(!$userId || !$guiestId){ ?>
<!--      <div class="col-sm-6" id="p" style="display:none;">
        <div class="form-group">
        <label>Create New Password</label>
        <input type="password" name="password" id="password" class="form-control">
        </div>
      </div>  


      <div class="col-sm-6" id="cp" style="display:none;">
        <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirmpassword" id="confirmpassword" class="form-control">
        </div>
      </div>  -->
  <?php //} ?>
      <div class="col-sm-12">
        <div class="checkbox">
        <label>
        <input type="checkbox" name="news" id="newsletter" value="1" checked="checked"> Sign Up for Newsletter
        </label>
        </div>
      </div>
  
      <div class="col-sm-12">
        <div class="checkbox">
        <label>
        <input type="checkbox" name="sameaddress" id="sameaddress" value="1" checked="checked"> Ship to same Address
        </label>
        </div>
      </div>
  <?php  //if((isset($guiestId) && !empty($guiestId)) || (isset($userId) && !empty($userId))){ } else {?> 
      <div class="col-sm-12">
        <div class="checkbox">
        <input type="button" name="submit" id="submitonestepcheckout" value="Submit">
        </div>
      </div>
   <?php// } ?>
  
</form>
 <div class="msgbox" style="margin:20px 200px 20px; color:red;font-weight:bold;font-size:14px; height:25px;width:200px;"></div>
</div>
</div>


<!--start payment methods-->
<div class="col-lg-3">

<!--<h2 class="checkout_title">Payment Methods</h2>
<div class="row billing_addbox">
<div class="col-lg-12 "><div class="pym_box"><input type="radio" name="paymentmethod" id="paymentmethod" value="cc" checked="checked">Credit Card/Debit Card/Internet Banking</div></div>
<div class="col-lg-12"><div class="pym_box"><input type="radio" name="paymentmethod" id="paymentmethod" value="cod">Cash on Delivery <br> Your will recieve a call regarding the confimation of your order shortly.</div></div>
<div class="col-lg-12"><div class="pym_box"><input type="radio" name="paymentmethod" id="paymentmethod" value="gv">Gift Voucher</div></div>
</div>-->

<h4>Shipping Methods</h4>

<div class="col-lg-12 shipm_box">
Select Shipping Method<br>
<input type="radio" name="shipping" id="shipping" value="99" checked="checked">Normal <strong>Rs 99.00</strong>
</div>


<h2 class="checkout_title">Customer Support</h2>
<div class="row billing_addbox">
<div class="col-sm-12 custsup">Call us on : <strong>+91-80-48795730</strong> <br>(Mon to Sat - 10am to 7pm)</div>
<div class="col-sm-12 custsup">Email us at :<strong> support@gnsaudios.in</strong></div>
</div>

</div>

<!--end payment methods-->

<!--Start Order Confirmation-->
<div class="col-lg-4">
<h2 class="checkout_title">Order Confirmation</h2>
<div class="row billing_addbox">
<div class="col-sm-12 blogin_title text-right">Forgot an Item? Edit Your Cart</div>
<div class="col-sm-12">
    
<table class="table ordtable">
<?php if(!empty($mycart)){ ?>
<tr>
    
<th>Product</th>
<th>Qty</th>
<th>Price</th>
</tr>
<?php 
$subtotal = 0;
$shipingCharge=99;
$productInfo = array();
$productInfoDetail = "";
foreach($mycart as $key => $val){
  $productInfo[$key]['productId']=$val['productId'];
  $productInfo[$key]['productName']=$val['productName'];
  $productInfo[$key]['itemPrice']=$val['itemPrice'];
  $productInfo[$key]['description']=$val['description'];
  $productInfo[$key]['product_code']=$val['product_code'];
  $productInfo[$key]['qty']=$val['qty'];
  $productInfo[$key]['image']=$val['image'];
  $productInfo[$key]['sessionId']=$val['sessionId'];
  $productInfo[$key]['createdAt']=$val['createdAt'];
  $productInfo[$key]['ip']=$val['ip'];
  $productInfo[$key]['txnid']=$val['txnid'];
 
$subtotal = $subtotal+($val['qty']*$val['itemPrice'])
?>
<tr>
<td class="ship_img"><img src="<?php echo $val['image'];?>" width="80" height="80"></td>
<td><?php echo $val['qty'];?></td>
<td><img src="images/r.jpg"> <?php echo $val['qty']*$val['itemPrice'];?></td>
<tr>
<?php 
} 
$productInfoDetail = json_encode($productInfo);
?>
<tr class="ordbold">
<td colspan="2" class="text-right">Subtotal</td>
<td><img src="images/r.jpg"> <?php echo $subtotal;?></td>
<tr>

<tr>
<td colspan="2">Shipping & Handing(Select Shipping Method-Normal)</td>
<td><img src="images/r.jpg"><?php echo $shipingCharge; ?></td>
<tr>

<tr>
<th colspan="2" class="text-right">Grand Total</th>
<th width="100"><img src="images/r.jpg"><?php $totalAmount=$shipingCharge+$subtotal; echo $totalAmount;?></th>
<tr>
<?php }else{ ?>
<tr><td>There is no product in cart.</td></tr>
<?php } ?>
</table>
</div>


<!--<div class="col-sm-5">Coupon code :</div>

  <div class="col-sm-7 cupbox">
    <input type="text" class="form-control" name="coupon"><br>
    <input type="submit" value="Apply Coupon">
  </div>-->
<form name="paymentprocessfrm" id="paymentfrm" method="post" action="processpayment.php">
  <div class="col-sm-12 cupbox continueToPayment">
    <label>Commets :</label>
    <input type="hidden" name="shipping" value="<?php echo $shipingCharge; ?>">
    <input type="hidden" name="userdetail" id="userdetail" value="">
    <textarea class="form-control" name="comment"></textarea><br>
    <?php if($guiestId || $userId){ ?>
      <input type="submit" value="Countinue to Payment">
    <?php } else{ ?>
    <input type="button" id="asktoregister" onclick="alert('First to register as guiest or user');" value="Countinue to Payment">
    <?php } ?>
    
  </div>

</form>



</div>

</div>
<!--end Order Confirmation-->


</div>

</div>
<!--end Product Cat -->
<?php require("footer.php");?>