<?php
session_start();
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$id = (int)$_GET['id'];
############ Review Detail ############
$tableName='user_review';
$review = new Module($tableName);
if(isset($_POST['reviewdmt'])){
	$status = $_POST['status'];
	if(isset($id)){
		$c=array('status'=>$status);
		$w=" WHERE id=".$id;
		$review->update($c,$w);
		
	}
}
$column = array();
$where = " WHERE id = ".$id;
$reviewDetail = $review->select($column,$where);
$content = $reviewDetail[0]['content'];
$status = $reviewDetail[0]['status'];
$createdAt =$reviewDetail[0]['createdAt'];  

########## Product Detail ###########
	$tableName = "products";
	$product = new Module($tableName);
	$where = " WHERE id=".$reviewDetail[0]['productid'];
	$productDetail = $product->select($column, $where);
	$productImage = $productDetail[0]['image_small'];
	$productName = $productDetail[0]['productName'];
	$status = $productDetail[0]['status'];

########## User Detail ##############
if($reviewDetail[0]['userType']=="u"){
	$tableName = "users";
	$customer = new Module($tableName);
	$where = " WHERE uid=".$reviewDetail[0]['userid'];
	$userDetail = $customer->select($column, $where);
	$firstname = $userDetail[0]['first_name'];
	$lastname = $userDetail[0]['last_name'];
	$email =  $userDetail[0]['uemail'];
	$mobile = $userDetail[0]['mobile'];
	$address1 = $userDetail[0]['address1'];
	$address2 = $userDetail[0]['address2'];
	$telephone = $userDetail[0]['telephone'];
	
}elseif($reviewDetail[0]['userType']=="g"){
	$tableName = "guiest";
	$guiest = new Module($tableName);
	$where = " WHERE gid=".$reviewDetail[0]['userid'];
	$guiestDetail = $guiest->select($column, $where);
	$firstname = $guiestDetail[0]['first_name'];
	$lastname = $guiestDetail[0]['last_name'];
	$email =  $guiestDetail[0]['gemail'];
	$mobile = $guiestDetail[0]['mobile'];
	$telephone = $guiestDetail[0]['telephone'];
	
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Review Detail</title>

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
                <h1 class="page-header">Review Detail</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form name="reviewfrm" action="" method="post">
				<input type="hidden" value="<?php echo $id;?>" name="reviewid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          <input type="submit" class="btn btn-primary btn-sm" name="reviewdmt" value="Submit">&nbsp;&nbsp;<a class="btn btn-primary btn-sm" href="review.php">Cancel</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
								<table border="1" width="700">
									<tr><td colspan="4" bgcolor="#cccccc"><strong>Customer Detail</strong></td></tr>
									<tr><td >Customer Name:</td> <td ><?php echo $firstname;?></td> <td >Last Name</td> <td ><?php echo $lastname;?></td></tr>
									<tr><td >Contac Number:</td> <td ><?php echo $mobile.", ".$telephone;?></td> <td >Email</td> <td ><?php echo $email;?></td></tr>
									<tr><td colspan="4" bgcolor="#cccccc"><strong>Product Detail</strong></td></tr>
									<tr><td >Product Name</td> <td ><?php echo $productName;?></td> <td >Image</td> <td ><img src="../<?php echo $productImage;?>" width="200" height="200"></td></tr>
									
									<tr><td colspan="4" bgcolor="#cccccc"><strong>Customer Review</strong></td></tr>
									<tr><td>Review</td> <td colspan="3"><?php echo $content;?></td> </tr>
									</table>
                                </div>
								<div class="form-group"  style="margin:0px 0px 0px 12px;">
                                        <label>Status</label>
                                        <?php if(isset($reviewDetail[0]['status'])){?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" <?php if(isset($reviewDetail[0]['status']) && $reviewDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="option2" <?php if(isset($reviewDetail[0]['status']) && $reviewDetail[0]['status']==0){ echo "checked";}?> >Deactive
                                        </label>
                                        <?php } else {?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" checked >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="0" >Deactive
                                        </label>
                                        <?php } ?>

                                    </div>
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
					</form>
              
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
