<?php
session_start();
include_once 'config/config.php';
$user = new User();
$products = new Module();
$products->table_name = 'products';
$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("location:login.php");
}
$records = array();
$query = "SELECT p.*,m.material,c.categoryName from products as p left join material as m on p.materialId=m.id left join categories as c on p.cid=c.id";
$records = $products->leftJoin($query);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>G N S Mics Audios : Product</title>

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
                <h1 class="page-header">Product</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a class="btn btn-primary btn-sm" href="insert-product.php" >Insert</a> <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
						<form action="deleteproduct.php" method="post" name="myform" id="myform">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
									<th>Product Code</th>
                                    <th>Product Name</th>
                                    <th>Size</th>                                    
                                    <th>Material</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($records)){
                                    foreach ($records as $key => $value) {
                                           
                                        ?>
                                        <tr class="odd">
                                            <td><input type="checkbox" name="data[]" id="data" value="<?php echo $value['id'];?>"></td>
											 <td><?php echo $value['product_code']; ?></td>
                                            <td><?php echo $value['productName']; ?></td>
                                            <td><?php echo $value['product_size'];?></td>
                                            <td class="center"><?php echo $value['material']; ?></td>
                                            <td class="center"><?php echo $value['categoryName']; ?></td>
                                            <td class="center">
                                                <div class="btn btn-primary btn-xs" style = "margin:4px 4px 4px 4px; padding:5px 5px 5px 5px" onclick="window.location='insert-product.php?id=<?php echo $value['id'];?>'">Edit</div>
                                                <div class="btn btn-primary btn-xs" style = "margin:4px 4px 4px 4px; padding:5px 5px 5px 5px" onclick="window.location='insert-image.php?id=<?php echo $value['id'];?>'">Add Image</div>
                                                <div class="btn btn-primary btn-xs" style = "margin:4px 4px 4px 4px; padding:5px 5px 5px 5px" onclick="window.location='product-size-price.php?id=<?php echo $value['id'];?>'">Add Size, Quantity & Price</div>
                                            </td>
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
