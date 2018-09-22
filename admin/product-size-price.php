<?php
session_start();
include_once 'config/config.php';
$user = new User();
$uid = $_SESSION['uid'];

if (!$user->get_session()) {
    header("location:login.php");
}

$records = array();
$sizePrice = array();
$column = array();
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $tableNamep = 'products';
    $product = new Module();
    $product->table_name = $tableNamep;
    $where = " where id='" . $id . "'";
    $records = $product->selectData($column, $where);
    //print_r($records);
    $tableName = 'size_price';
    $sizeDetail = new Module();
    $sizeDetail->table_name = $tableName;
    $where = " where pid='" . $id . "'";
    $sizePrice = $sizeDetail->selectData($column, $where);
    
    $productName = $records[0]['productName'];
    $productImage = $records[0]['image_small'];
    $productCode = $records[0]['product_code'];
}

if (isset($_GET['sid'])) {
    $sid = (int) $_GET['sid'];
    $column = array();
    $tableName = 'size_price';
    $size = new Module();
    $size->table_name = $tableName;
    $where = " where id='" . $sid . "'";
    $size = $size->selectData($column, $where);
}
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ADMIN : Product size and price</title>

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
                        <h1 class="page-header">Product Size, Quantity & Price</h1>
                    </div>
                </div>
                <!--Product Detail--->

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <a class="btn btn-primary btn-sm" href="product.php">Cancel</a> 
                                <span style="margin-left:50px;font-weight:bold">Product Name: <?php echo $productName; ?> </span>
                                <span style="margin-left:50px;font-weight:bold">Product Code: <?php echo $productCode; ?></span>
                                <span style="margin-left:50px;font-weight:bold">Product Image: <img src="../<?php echo $productImage; ?>" width="50" height="40"></span>
                            </div>

                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="page-header">Add Product Size, Quantity & Price</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form name="frmsizeprice" method="post" action="insert-size-price.php">
                                            <input type="hidden" name="sid" value="<?php echo (isset($_GET['sid'])) ? $_GET['sid'] : ""; ?>">
                                            <input type="hidden" name="id" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : ""; ?>">
                                            <table style="border:0px #cccccc solid; height:100px;">	
                                                <tr height="40px"> <td>Product Size</td><td>&nbsp;:&nbsp;</td> <td ><input type="text" name="size" value="<?php echo (isset($size[0]['size'])) ? $size[0]['size'] : ""; ?>"></td> </tr>
                                                <tr height="40px"><td >Product Price</td><td>&nbsp;:&nbsp;</td> <td><input type="text" name="price" value="<?php echo (isset($size[0]['price'])) ? $size[0]['price'] : ""; ?>"></td></tr>
                                                <tr height="40px"><td >Product Quantity</td> <td>&nbsp;:&nbsp;</td><td ><input type="text" name="quantity" value="<?php echo (isset($size[0]['quantity'])) ? $size[0]['quantity'] : ""; ?>"></td></tr>
                                                <tr height="40px"><td colspan="4"><input class="btn btn-primary btn-sm"  type="submit" name="submit" value="Submit" ></td></tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2 class="page-header">Product Size, Quantity & Price Detail</h2>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <form action="deletesizeprice.php" method="post" name="myform" id="myform">
                                                        <input type="hidden" name="pid" value="<?php echo (isset($_GET['id'])) ? $_GET['id'] : ""; ?>">
                                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">

                                                            <thead>
                                                                <tr>
                                                                    <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
                                                                    <th>Product Size</th>
                                                                    <th>Product Quantity</th>																
                                                                    <th>Product Price</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
<?php
if (!empty($sizePrice)) {
    foreach ($sizePrice as $key => $value) {
        ?>
        <tr class="odd">
            <td><input type="checkbox" name="data[]" id="data" value="<?php echo $value['id']; ?>"></td>
            <td><?php echo $value['size']; ?></td>
            <td><?php echo $value['quantity']; ?></td>
            <td><?php echo $value['price']; ?></td>
            <td class="center"><div class="btn btn-primary btn-xs" onclick="window.location = 'product-size-price.php?id=<?php echo ($_GET['id']) ? $_GET['id'] : 0; ?>&sid=<?php echo $value['id']; ?>'">Edit</div>

            </td>
        </tr>
        <?php
    }
} else {
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
                            <!-- /.panel-body -->
                        </div>

                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-----product detail End------>


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
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
        </script>
    </body>

</html>
