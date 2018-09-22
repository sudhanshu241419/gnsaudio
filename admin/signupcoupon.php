<?php
session_start();
include_once 'config/config.php';
$user = new User();
$tableName='user_coupons';
$coupons = new Module();
$coupons->table_name = $tableName;
$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("location:login.php");
}
$records = array();
$where = " where status='1'";
$column = array();
$query = "SELECT u.*,uc.*,uc.status as cstatus from user_coupons as uc left join users as u on uc.userid=u.uid";
$records = $coupons->leftJoin($query);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : User Coupon</title>

    <!-- Core CSS - Include with every page -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <?php Include('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Coupon</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
						<form action="deleteusercoupon.php" method="post" name="myform" id="myform">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
									<th>Coupon Code</th>
                                    <th>User</th>
									<th>value</th>
									<th>Description</th>
                                    <th>Minimum Purchase</th>
                                    <th>Created On</th>
                                    <th>Updated On</th>
                                    <th>Status</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($records)){
                                    foreach ($records as $key => $value) {
                                           
                                        ?>
                                        <tr class="odd">
                                            <td><input type="checkbox" name="data[]" id="data" value="<?php echo $value['id'];?>"></td>
											 <td><?php echo $value['code']; ?></td>
                                            <td><?php echo ($value['uname'])?$value['uname']:$value['first_name']; ?></td>
											<td><?php echo $value['value']; ?></td>
											<td><?php echo $value['description']; ?></td>
											<td><?php echo $value['minimumpurchase']; ?></td>
                                            <td><?php echo $value['createdAt'];?></td>
                                            <td><?php echo $value['updatedAt'];?></td>
                                            <td class="center"><?php echo ($value['cstatus']==0)?"Deactive coupon":"Active Coupon"; ?></td>
                                            
                                           
                                        </tr>
                                    <?php
                                    }
                                }else{
                                    ?>
                                   
                                <?php } ?>
                                </tbody>
                            </table>
							</form>
                        </div>
                        <!-- /.table-responsive -->
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
<script src="assets/js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<!-- SB Admin Scripts - Include with every page -->
<script src="assets/js/sb-admin.js"></script>

<!-- Page-Level Demo Scripts - Blank - Use for reference -->
 <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
</body>

</html>
