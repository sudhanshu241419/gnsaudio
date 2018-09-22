<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName='coupons';
$coupons = new Module($tableName);
$uid = $_SESSION['uid'];
$target='';

$frmData = array();
if ($_POST) {
    if(empty($_POST['coupon_code'])){
        echo "Coupon code is required....";
    }else{
        $frmData['coupon_code'] = strtoupper($_POST['coupon_code']);
        $frmData['description'] = $_POST['description'];
        $frmData['validity_date'] = $_POST['validity_date'];
        $frmData['discount_amount'] = $_POST['discount_amount'];
        $frmData['createdBy'] = "Admin";
        $frmData['status'] = $_POST['status'];
		$frmData['minimum_purchase_amount']=$_POST['minp'];

        $couponId=(int)$_POST['cid']?$_POST['cid']:"";
        if(!empty($couponId)){
             $frmData['updatedAt'] = date('Y-m-d H:i:s');
            $where = " WHERE id = ".$couponId;
            $result=$coupons->update($frmData,$where);
        }else{
             $frmData['createdAt'] = date('Y-m-d H:i:s');
			
			 $result = $coupons->insert($frmData);
        }
        header("location: coupon.php");
        exit;
    }
}
if(isset($_REQUEST['id'])){
    $column = array();
    $id=($_REQUEST['id']%2==0 or $_REQUEST['id']%2==1 )?(int)$_REQUEST['id']:0;
    $where = " where id=".$id;
    $couponDetail = $coupons->select($column, $where);
    
}


?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Coupon</title>

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
                <h1 class="page-header">Coupon</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form role="form" name="frmCoupon" id="frmCoupon" method="post" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="cid" value="<?php echo $id=isset($_GET['id'])?$_GET['id']:'';?>">
                    <div class="panel panel-default width450">
                        <div class="panel-heading">
                            <input type="submit" value="Save" name="smtsave" id="smtsave" class="btn btn-primary btn-sm"> 
								   <a class="btn btn-primary btn-sm" href="coupon.php">Cancel</a>
								   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="form-group">
                                        <label>Coupon code</label>
                                        <input class="form-control" name="coupon_code" id="coupon_code"
                                               placeholder="Enter coupon code" value="<?php echo $cat=isset($couponDetail[0]['coupon_code'])?$couponDetail[0]['coupon_code']:strtoupper(substr(hash('sha256', mt_rand() . microtime()), 0, 10));?>" readonly>
                                    </div>
                                   
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="description"
                                                  rows="3"><?php echo $cat=isset($couponDetail[0]['description'])?$couponDetail[0]['description']:'';?></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Validity Date</label>
                                        <input type="datetime" class="form-control" name="validity_date" id="validity_date"
                                                placeholder="Enter date (YYYY-mm-dd H:m:s)" value="<?php echo $cat=isset($couponDetail[0]['validity_date'])?$couponDetail[0]['validity_date']:'';?>">
                                    </div>
                                     

                                    <div class="form-group">
                                        <label>Discount Amount</label>
                                        <input class="form-control" type="text" name="discount_amount" id="discount_amount" value="<?php if(isset($couponDetail[0]['discount_amount'])){echo $couponDetail[0]['discount_amount']; } ?>">

                                    </div>
									
									<div class="form-group">
                                        <label>Minimum Purchase Amount</label>
                                        <input class="form-control" type="text" name="minp" id="minp" value="<?php if(isset($couponDetail[0]['minimum_purchase_amount'])){echo $couponDetail[0]['minimum_purchase_amount']; } ?>">

                                    </div>


                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($couponDetail[0]['status'])){?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" <?php if(isset($couponDetail[0]['status']) && $couponDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="0" <?php if(isset($couponDetail[0]['status']) && $couponDetail[0]['status']==0){ echo "checked";}?> >Deactive
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
