<?php
session_start();
include_once 'config/config.php';
$user = new User();
$products = new Module();
$products->table_name = 'products_image';
$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("location:login.php");
}
$records = array();
$query = "SELECT p.id as pid,p.productName,pi.* from products as p left join products_image as pi on p.id=pi.pid";
$records = $products->leftJoin($query);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Product</title>

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
                <h1 class="page-header">Product Image</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <a class="btn btn-primary btn-sm" href="product.php" >Product</a> 
					   <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
						<form action="deleteproductimage.php" method="post" name="myform" id="myform">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
                                    <th>Product Name</th>
                                    <th>Product Small Image</th>
                                    <th>Product Large Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($records)){
                                    foreach ($records as $key => $value) {
                                           if($value['image_small'] && $value['image_large']){
                                        ?>
                                        <tr class="odd">
                                            <td><input type="checkbox" name="data[]" id="data" value="<?php echo $value['id'];?>"></td>
                                            <td><?php echo $value['productName']; ?></td>
                                            <td><img src="../<?php echo $value['image_small'];?>" width="80" height="80"></td>
                                            <td><img src="../<?php echo $value['image_large'];?>" width="100" height="100"></td>
                                                <td class="center"><!--<button class="btn btn-primary btn-xs" onclick="window.location='insert-image.php?id=<?php echo $value['id'];?>'">Edit</button>-->
                                                <div class="btn btn-primary btn-xs" onclick="window.location='insert-image.php?id=<?php echo $value['pid'];?>'">Add Image</div>
                                            </td>
                                        </tr>
                                    <?php
										}
                                    }
                                }else{
                                    ?>
                                    <tr class="odd"><td colspan="5">Products Image Not Found</td></tr>
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
