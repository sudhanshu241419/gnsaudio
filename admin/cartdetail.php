<?php
session_start();
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$id = $_GET['id'];

############ Cart Detail ############
$tableName='temp_mycart';
$cart = new Module();
$cart->table_name = $tableName;
$column = array();
$where = " WHERE id = ".$id;

$cartDetail = $cart->selectData($column,$where);

$txnid = $cartDetail[0]['txnid'];	
$orderid = $cartDetail[0]['id'];
$ordermode = $cartDetail[0]['mode'];
$payumoneyid = $cartDetail[0]['payuMoneyId'];
$productId =$cartDetail[0]['productId'];  	
$productName =$cartDetail[0]['productName'];
$itemPrice 	=$cartDetail[0]['itemPrice'];
$description =$cartDetail[0]['description'];
$product_code =$cartDetail[0]['product_code'];
$qty =$cartDetail[0]['qty'];
$image 	=$cartDetail[0]['image'];
$totalAmount =$cartDetail[0]['totalAmount'];
$userdata = json_decode($cartDetail[0]['user_details'],1);

$firstname = $userdata['firstname'];
$lastname = $userdata['lastname'];
$email =  $userdata['email'];
$mobile = $userdata['mobile'];
$address1 = $userdata['address1'];
$address2 = $userdata['address2'];
$telephone = $userdata['telephone'];
$country = $userdata['country'];
$city = $userdata['city'];
$zipcode = $userdata['zip'];
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Order Detail</title>

    <!-- Core CSS - Include with every page -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <link href="assets/css/custome.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <?php Include('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Order Detail</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <a class="btn btn-primary btn-sm" href="order.php">Cancel</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table border="1" width="700">
                                            <tr><td colspan="4" bgcolor="#cccccc"><strong>Customer Detail</strong></td></tr>
                                            <tr><td colspan="2" bgcolor="#cccccc"><strong>Transaction Id</strong></td><td colspan="2" bgcolor="#cccccc"><strong><?php echo $txnid;?></strong></td></tr>                                            
                                            <tr><td >Customer Name:</td> <td ><?php echo $firstname;?></td> <td >Last Name</td> <td ><?php echo $lastname;?></td></tr>
                                            <tr><td >Contact Number:</td> <td ><?php echo $mobile.", ".$telephone;?></td> <td >Email</td> <td ><?php echo $email;?></td></tr>
                                            <tr><td colspan="4" bgcolor="#cccccc"><strong>Shipping Detail</strong></td></tr>
                                            <tr><td >Address1</td> <td ><?php echo $address1;?></td> <td >Address2</td> <td ><?php echo $address2;?></td></tr>
                                            <tr><td >Country</td> <td ><?php echo $country;?></td> <td >City</td> <td ><?php echo $city;?></td></tr>
                                            <tr><td >State</td> <td ><?php //echo $state;?></td> <td >Zipcode</td> <td ><?php echo $zipcode;?></td></tr>
                                            
                                            <?php foreach($cartDetail as $key =>$value){?>
                                            <tr><td colspan="4" bgcolor="#cccccc"><strong>Product Detail</strong></td></tr>
                                            <tr><td >Product Name</td> <td ><?php echo $value['productName'];?></td> <td >Product Code</td> <td ><?php echo $value['product_code'];?></td></tr>
                                            <tr><td >Product Price</td> <td ><?php echo $value['itemPrice'];?></td> <td >Product Quantity</td> <td ><?php echo $value['qty'];?></td></tr>
                                            <tr><td >Product Image</td> <td colspan="4"><img src="../<?php echo $value['image'];?>" width="200" height="200"></td> </tr>
                                            <?php } ?> 
                                            <tr><td >Total Amount</td> <td colspan="4"><?php echo $totalAmount;?></td></tr>
                                            
                                            
                                            <tr><td colspan="4" bgcolor="#cccccc"><strong>Order Detail</strong></td></tr>
                                            <tr><td >Transaction Code</td><td ><?php echo $txnid;?></td> <td >Order Id</td><td ><?php echo $orderid;?></td></tr>
                                            <tr><td >PayUMoney Id</td><td ><?php echo $payumoneyid;?></td> <td >Payment Mode</td><td ><?php echo $ordermode;?></td></tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
              
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Core Scripts - Include with every page -->
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>

<!-- SB Admin Scripts - Include with every page -->
<script src="assets/js/sb-admin.js"></script>

<!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>
