<?php 
require("header.php");
   
	$addtocart = new AddToCart();
	$sessionId = session_id();
	$cartId="";
        
	if(isset($_POST['paymentmethod']) && $_POST['paymentmethod']==="cod" && $_POST['amount'] > 0){
                $userdetails = json_encode($_POST,1);
		$column=array('user_details'=>$userdetails,'totalAmount'=>$_POST['amount'],'txnid'=>$_POST['txnid'],'mihpayid'=>'','mode'=>$_POST['paymentmethod'],'payuMoneyId'=>'','comment'=>$_POST['udf2'],'status'=>'success');
		$cartIdArray = explode("|",$_POST['udf1']);
                
		foreach($cartIdArray as $key =>$cId){
			$where = " WHERE id='".$cId."'";
			$addtocart->updateTempMyCart($column,$where);
			$cartId .=$cId.","; 
		}
		$_POST['status'] = "success";
		$_POST['payuMoneyId'] = $_POST['txnid'];
	}elseif(isset($_POST['txnid']) && $_POST['amount'] > 0){
            print_R($_POST['txnid']);
            die;
		$column=array('totalAmount'=>$_POST['amount'],'txnid'=>$_POST['txnid'],'mihpayid'=>$_POST['mihpayid'],'mode'=>$_POST['mode'],'payuMoneyId'=>$_POST['payuMoneyId'],'comment'=>$_POST['udf2'],'status'=>$_POST['status']);
		$cartIdArray = explode("|",$_POST['udf1']);
		foreach($cartIdArray as $key =>$cId){
			$where = " WHERE id='".$cId."'";
			$addtocart->updateTempMyCart($column,$where);
			$cartId .=$cId.",";
		}
        }
//        else{
//            @header('Location:'.SITE_URL);
//            die();
//        }
        $guiestsession = new Guiestsession();
        $guiestsession->destroySession();
?>
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="accountinfo_tilte">Order Status</div>
</div>
</div>
</div>
<div class="container">
    <div class="row">
    	<?php 
		$txnid = isset($_GET['ordid'])?$_GET['ordid']:0;
    	if(isset($_POST['status']) && $_POST['status'] === "success"){
			if($txnid >0)
    		echo "You order has been successfull. Your Order Id is : ".$_POST['payuMoneyId'];
    	}elseif(isset($_POST['status']) && ($_POST['status']=="cancel" || $_POST['status']=="fail")){
    		echo "You order has been ".$_POST['status'];
    		}
			$cartid = substr($cartId,0,-1);
			$c=array();
			
			$where = " WHERE txnid='".$txnid."'";
			$myorder = $addtocart->getData($c,$where);
    	?>
	 </div>
	 <div class="accc_orderbox">
<table class="table table-bordered couptable">
<?php if(!empty($myorder)){ ?>
	<tr>
	
	
	<th>Order Id</th>
	<th>Product</th>
	<th>Product Image</th>
	<th>Product code</th>
	<th>Quantity</th>
	<th>Price</th>	
	<th>Purchase Date</th>
	<th>Status</th>
	</tr>
	<?php
	foreach($myorder as $key =>$val){
	$totalAmount = $val['totalAmount'];
	?>
		<tr>			
		<td>
			<?php 
				if(isset($val['payuMoneyId'])&&!empty($val['payuMoneyId']))
					echo $val['payuMoneyId'];
				else
					echo strtoupper($val['txnid']);
			?>
		</td>
		<td><?php echo $val['productName'];?></td>
		<td><?php echo "<img src='".$val['image']."' width='80' height='80'>";?> </td>
		<td><?php echo $val['product_code'];?></td>
		<td><?php echo $val['qty'];?></td>
		<td><img src="images/r.jpg"><?php echo $val['itemPrice'];?></td>
		
		<td><?php echo $val['createdAt'];?></td>
		<td><?php echo $val['status'];?></td>
		</tr>
<?php } ?> 
<tr><td colspan="7"align="right">Total Amount(With Shipping Rs 99/=)</td><td><?php echo $totalAmount;?></td></tr>
<?php
 }else{
 ?>
 <tr><td>You have not placed order</td></tr>
 <?php
 }?>
</table>
</div>
</div>

<?php require("footer.php");?>