<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName = 'products_image';
$images = new Module();
$images->table_name = $tableName;
$uid = $_SESSION['uid'];
$target = '';
$error = array();
$frmData = array();
$common = new Common();
if ($_POST) {
    if (empty($_FILES['image']['name'])) {
        $error = array("0" => "Product small image is required....");
    } elseif (empty($_FILES['image1']['name'])) {
        $error = array("1" => "Product large image is required....");
    } else {
        $type = $common->checkImageType($_FILES['image']['type']);
        $type1 = $common->checkImageType($_FILES['image1']['type']);
        if ($type && $type1) {
            if ($_FILES['image']['error'] == 0) {
                $imageName = $_FILES['image']['name'];
                $tmpName = $_FILES['image']['tmp_name'];
                $target = $common->uploadImage(PRO_IMAGEPATH, $imageName, $tmpName);
            } else {
                $error = array("2" => "Product small image is not valid");
            }
            if ($_FILES['image1']['error'] == 0) {
                $imageName = $_FILES['image1']['name'];
                $tmpName = $_FILES['image1']['tmp_name'];
                $target1 = $common->uploadLargeImage(PRO_IMAGEPATH, $imageName, $tmpName);
            } else {
                $error = array("2" => "Product large image is not valid");
            }
            $tableName = 'products';
            $products = new Module();
            $products->table_name = $tableName;
            $column = array('image_small', 'image_large');
            $id = (isset($_POST['pid']) && !empty($_POST['pid'])) ? (int) $_POST['pid'] : 0;
            $where = " where id=" . $id;
            
            $productDetail = $products->selectData($column, $where);
            
            $main_image = 0;
            if (empty($productDetail[0]['image_small']) && empty($productDetail[0]['image_large'])) {
                $proimg = array('image_small' => $target, 'image_large' => $target1);
                $products->updateData($proimg, $where);
                $main_image = 1;
            }

            $description = $_POST['description'];
            $status = $_POST['status'];
            $pid = $_POST['pid'];
            $imgcolumn = array('pid' => $pid, 'image_small' => $target, 'image_large' => $target1, 'main_image' => $main_image, 'description' => $description, 'status' => $status, 'createdAt' => date('Y-m-d H:i:s'));
            $images->insertData($imgcolumn);
        } else {
            $error = array("2" => "Image is not valid");
        }
    }
}
if (isset($_REQUEST['id'])) {
    $column = array('pid', 'image_small', 'image_large', 'description', 'status');
    $id = ($_REQUEST['id'] % 2 == 0 or $_REQUEST['id'] % 2 == 1 ) ? (int) $_REQUEST['id'] : 0;
    $where = " where id=" . $id;
    $imageDetail = $images->selectData($column, $where);
    //print_r($productDetail);
}
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ADMIN : Insert Product Image</title>

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
                        <h1 class="page-header">Product Image</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" name="frmProduct" id="frmProduct" method="post" action=""
                              enctype="multipart/form-data">
                            <input type="hidden" name="pid" value="<?php echo $id = isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                            <div class="panel panel-default width450">
                                <div class="panel-heading">
                                    <input type="submit" value="Save" name="smtsave" id="smtsave" class="btn btn-primary btn-sm"> 
                                    <a class="btn btn-primary btn-sm" href="product.php">Cancel</a>
                                    <a class="btn btn-primary btn-sm" href="product-image.php">Product Image</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
<?php if (!empty($error)) { ?>
                                                <div class="form-group">
                                                    <ul style="color:red">
                                                <?php foreach ($error as $k => $e) { ?>
                                                            <li><?php echo $e; ?></li>
    <?php } ?>
                                                    </ul>
                                                </div>
                                                    <?php } ?>	
                                            <div class="form-group">
                                                <label>Product Image Small</label>
                                                <input  name="image" id="image" type="file">
                                            </div>
                                            <div class="form-group">
                                                <label>Product Image large</label>
                                                <input  name="image1" id="image1" type="file">
                                            </div>

                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" id="description"
                                                          rows="3"><?php echo $cat = isset($productDetail[0]['description']) ? $productDetail[0]['description'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
<?php if (isset($productDetail[0]['status'])) { ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" <?php if (isset($productDetail[0]['status']) && $productDetail[0]['status'] == 1) {
        echo "checked";
    } ?> >Active
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="option2" <?php if (isset($productDetail[0]['status']) && $productDetail[0]['status'] == 0) {
                                                    echo "checked";
                                                } ?> >Deactive
                                                    </label>
                                                <?php } else { ?>
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
