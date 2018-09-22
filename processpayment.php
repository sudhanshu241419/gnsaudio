<?php
session_start();
require("config/config.php");
$subtotal = 0;
$shipingCharge=0;
$sessionId = session_id();
$session = new Session();
$guiestsession = new Guiestsession();
$uId = $session->getUserId();
$gId=$guiestsession->getUserId();

$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
######## Get Cart Information #####################
$addtocart = new AddToCart();
$column = array();
$where = " WHERE sessionId ='".$sessionId."' and status = 'pendding'";
$mycart = $addtocart->getData($column,$where);
$userdetails = $_POST['userdetail'];
$comment = $_POST['comment'];
$shipingCharge = $_POST['shipping'];
$_POST['paymentmethod'] = "cod";
$cartId = "";
$userData = json_decode($userdetails,1);

if($_POST['paymentmethod']==="cod"){
foreach($mycart as $key => $val){
    $subtotal = $subtotal+($val['qty']*$val['itemPrice']);
    $cartId .= $val['id']."|";
}
$amount = $shipingCharge+$subtotal;
$cartId = substr($cartId,0,-1);
?>
<html>
  <head>
  <script>
     function submitPayuForm() {
      var codfrm = document.forms.codfrm;
      codfrm.submit();
    }
  </script>
  </head>
  
<body onload="submitPayuForm()">
<div style="text-align:center;margin-top:100px;">Don't refresh page. We are in progress...<br><img src="images/loading.gif"></div>
<form name="codfrm" method="post" action="paymentsuccess.php?ordid=<?php echo $txnid;?>">
<input type="hidden" name="paymentmethod" value="cod"> 
<input type="hidden" name="txnid" value="<?php echo $txnid;?>">
<input type="hidden" name="udf1" value = "<?php echo $cartId;?>">
<input type="hidden" name="udf2" value = "<?php echo $comment;?>">
<input type="hidden" name="amount" value = "<?php echo $amount;?>">
<input type = "hidden" name="guest" value="<?php echo $userData['data']['guest'];?>">
<input type = "hidden" name="firstname" value="<?php echo $userData['data']['firstname'];?>">
<input type = "hidden" name="lastname" value="<?php echo $userData['data']['lastname'];?>">
<input type = "hidden" name="company" value="<?php echo $userData['data']['company'];?>">
<input type = "hidden" name="email" value="<?php echo $userData['data']['email'];?>">
<input type = "hidden" name="address1" value="<?php echo $userData['data']['address1'];?>">
<input type = "hidden" name="address2" value="<?php echo $userData['data']['address2'];?>">
<input type = "hidden" name="city" value="<?php echo $userData['data']['city'];?>">
<input type = "hidden" name="country" value="<?php echo $userData['data']['country'];?>">
<input type = "hidden" name="zip" value="<?php echo $userData['data']['zip'];?>">
<input type = "hidden" name="telephone" value="<?php echo $userData['data']['telephone'];?>">
<input type = "hidden" name="mobile" value="<?php echo $userData['data']['mobile'];?>">
<input type = "hidden" name="news" value="<?php echo $userData['data']['news'];?>">
<input type = "hidden" name="sameaddress" value="<?php echo $userData['data']['sameaddress'];?>">

</form>
</body>
</html>

<?php
}else{
// Merchant key here as provided by Payu
$MERCHANT_KEY = "B2wm6M";//"JBZaLc";//

// Merchant Salt as provided by Payu
$SALT = "rLKflEmk";//"GQs7yium";

// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://secure.payu.in/_payment";//"https://test.payu.in/_payment";

$action = '';
$_POST['key']='B2wm6M';//'JBZaLc';
$_POST['txnid']=$txnid;

//$_POST['productinfo']=json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));

$_POST['surl']='<?php echo SITE_URL?>paymentsuccess.php';
$_POST['furl']='<?php echo SITE_URL?>paymentsuccess.php';
$_POST['curl']='<?php echo SITE_URL?>paymentsuccess.php';
$_POST['service_provider']="payu_paisa";
$_POST['hash']="";
$posted = array();

######## Get User Information #####################
if(isset($gId) || isset($uId)){
  $column=array();
  if(isset($gId) and !empty($gId)){
    $guiestobj = new Guiest();
    $where = " WHERE gid=".$gId;
    $guiestDetail = $guiestobj->select($column,$where);
    $_POST['firstname']=$guiestDetail[0]['first_name'];
    $_POST['email']=$guiestDetail[0]['gemail'];
    if(isset($guiestDetail[0]['telephone']) && !empty($guiestDetail[0]['telephone'])){
      $_POST['phone']=$guiestDetail[0]['telephone'];
    }elseif(isset($guiestDetail[0]['mobile']) && !empty($guiestDetail[0]['mobile'])){
       $_POST['phone']=$guiestDetail[0]['mobile'];
    }  
    /*$last_name=$guiestDetail[0]['last_name'];   
    $country=$guiestDetail[0]['country'];   
    $state=$guiestDetail[0]['state'];   
    $zipcode=$guiestDetail[0]['zipcode'];   
    $city=$guiestDetail[0]['city'];  
    $address1=$guiestDetail[0]['address1'];  
    $address2=$guiestDetail[0]['address2']; 
    $news_subscribe=$guiestDetail[0]['news_subscribe'];
    */
   
    
  }elseif(isset($uId) && !empty($uId)){
    $userObj = new Auth();
    $where = " WHERE uid=".$uId;
    $userDetail = $userObj->getUser($column,$where);
    
    $_POST['firstname']=$userDetail[0]['first_name'];  
    $_POST['email']=$userDetail[0]['uemail'];  
    if(isset($userDetail[0]['telephone']) && !empty($userDetail[0]['telephone'])){
      $_POST['phone']=$userDetail[0]['telephone'];
    }elseif(isset($userDetail[0]['mobile']) && !empty($userDetail[0]['mobile'])){
       $_POST['phone']=$userDetail[0]['mobile'];
    }  

    /*$last_name=$userDetail[0]['last_name'];   
    $country=$userDetail[0]['country'];   
    $state=$userDetail[0]['state'];   
    $zipcode=$userDetail[0]['zipcode'];  
    $city=$userDetail[0]['city'];  
    $address1=$userDetail[0]['address1'];  
    $address2=$userDetail[0]['address2']; 
    $news_subscribe=$userDetail[0]['news_subscribe'];  
    $uname==$userDetail[0]['uname'];*/

  }
}else{
  header("location:one-step-checkout.php");
}

$productInfo = array();
$productInfoDetail = "";
$cartId = "";
foreach($mycart as $key => $val){
  $productInfo[$key]['productId']=$val['productId'];
  $productInfo[$key]['productName']=$val['productName'];
  $productInfo[$key]['itemPrice']=$val['itemPrice'];
  $productInfo[$key]['description']=$val['description'];
  $productInfo[$key]['product_code']=$val['product_code'];
  $productInfo[$key]['qty']=$val['qty'];
  $productInfo[$key]['sessionId']=$val['sessionId'];
  $productInfo[$key]['isRequired']="false";

  $subtotal = $subtotal+($val['qty']*$val['itemPrice']);
  $cartId .= $val['id']."|";
}
$_POST['amount']=$shipingCharge+$subtotal;
$_POST['productinfo'] = json_encode($productInfo);
$cartId = substr($cartId,0,-1);
$_POST['udf1']=$cartId;
$_POST['udf2']=$comment;
//print_r($_POST['productinfo']);

$posted = array();
if(!empty($_POST)) {
    //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 
  
  }
}

$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}
$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
      || empty($posted['service_provider']) || empty($posted['udf1'])
	  
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
    $hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';  
  foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}

?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  
  <body onload="submitPayuForm()">
      
    <?php if($formError) { ?>
      <span style="color:red">There is error try again...</span>
      
    <?php }else{?>
      <div style="text-align:center;margin-top:100px;">Don't refresh page. We are in progress...<br><img src="images/loading.gif"></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <input type="hidden" name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
      <input  type="hidden" name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" />
      <input type="hidden" name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" />
      <input type="hidden" name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" />
      <textarea name="productinfo" style="display:none;"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea>
      <input type="hidden" name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" />
      <input type="hidden" name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" />
      <input type="hidden" name="service_provider" value="<?php echo (empty($posted['service_provider'])) ? '' : $posted['service_provider'] ?>" size="64" />
      <input type="hidden" name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
      <input type="hidden" name="curl" value="" />
      <input type="hidden" name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
      <input type="hidden" name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
      <input type="hidden" name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
      <input type="hidden" name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
      <input type="hidden" name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" />
      <input type="hidden" name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
      <input type="hidden" name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />
      <input type="hidden" name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
      <input type="hidden" name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
      <input type="hidden" name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
      <input type="hidden" name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
      <input type="hidden" name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" />
      <?php if(!$hash) { ?>
           <input type="submit" value="Submit" />
     <?php } ?>
       
      
    </form>
  </body>
</html>
<?php } ?>
