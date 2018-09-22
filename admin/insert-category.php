<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName = 'categories';
$categories = new Module();
$categories->table_name = $tableName;
$common = new Common();
$common->imageType = $imageType;
$uid = $_SESSION['uid'];
$target = '';

######## Get parent category ######
$column = array('id', 'categoryName');
$where = " where pid=0";
$parentCategory = $categories->selectData($column, $where);
$error = array();
$categoryFrmData = array();
if ($_POST) {
    if (empty($_POST['categoryName'])) {
        $error = array("0" => "Category name is required");
    } else {
       
        $categoryFrmData['categoryName'] = ucfirst(strtolower($_POST['categoryName']));
        $categoryFrmData['pid'] = isset($_POST['pid'])?:0;
        $categoryFrmData['metatagDescription'] = $_POST['metatagDescription'];
        $categoryFrmData['description'] = $_POST['description'];
        $categoryFrmData['metatagKeyword'] = $_POST['metatagKeyword'];
        $categoryFrmData['shortOrder'] = $_POST['shortOrder'];
        $categoryFrmData['status'] = $_POST['status'];
        $categoryFrmData['createdAt'] = date('Y-m-d H:i:s');
        $categoryFrmData['updatedAt'] = date('Y-m-d H:i:s');

        if ($_FILES['image']['error'] == 0) {
            $imageName = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            $target = $common->uploadImage(CAT_IMAGEPATH, $imageName, $tmpName);
            $categoryFrmData['image'] = $target;
        } 

        $categoryId = (int) $_POST['cid'] ? $_POST['cid'] : "";
        if (!empty($categoryId)) {
            $where = " WHERE id = " . $categoryId;
            $image = array('image');
            $imagePath = $categories->selectData($image, $where);
            if ($_FILES['image']['error'] == 0) {
                if (file_exists("../" . $imagePath['0']['image'])) {
                    $common->deleteFile("../" . $imagePath['0']['image']);
                }
            }
            $result = $categories->updateData($categoryFrmData, $where);
        } else {
            $result = $categories->insertData($categoryFrmData);
        }
       // header("location: category.php");
       // exit;
    }
}
if (isset($_REQUEST['id'])) {
    $column = array('pid', 'categoryName', 'description', 'metatagDescription', 'metatagKeyword', 'image', 'shortOrder', 'status');
    $id = ($_REQUEST['id'] % 2 == 0 or $_REQUEST['id'] % 2 == 1 ) ? $_REQUEST['id'] : 0;
    $where = " where id=" . $id;
    $categoryDetail = $categories->selectData($column, $where);
}
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ADMIN : Insert Category</title>

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
                        <h1 class="page-header">Category</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <form role="form" name="frmcategory" id="frmcategory" method="post" action="" enctype="multipart/form-data">
                            <input type="hidden" name="cid" value="<?php echo $id = isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                            <div class="panel panel-default width450">
                                <div class="panel-heading">
                                    <input type="submit" value="Save" name="smtsave" id="smtsave"
                                           class="btn btn-primary btn-sm"> <a class="btn btn-primary btn-sm"
                                           href="category.php">Cancel</a>
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?php if (!empty($error)) { ?>
                                                <div class="form-group">
                                                    <?php
                                                    echo "<ul style='color:red'>";
                                                    foreach ($error as $key => $e) {
                                                        echo "<li>" . $e . "</li>";
                                                    }
                                                    echo "</ul>";
                                                    ?>   
                                                </div>
                                                <?php } ?>

                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input class="form-control" name="categoryName" id="categoryName"
                                                       placeholder="Enter text" value="<?php echo $cat = isset($categoryDetail[0]['categoryName']) ? $categoryDetail[0]['categoryName'] : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" name="description" id="description"
                                                          rows="3"><?php echo $cat = isset($categoryDetail[0]['description']) ? $categoryDetail[0]['description'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Metatag Description</label>
                                                <textarea class="form-control" name="metatagDescription" id="metatagDescription"
                                                          rows="3"><?php echo $cat = isset($categoryDetail[0]['metatagDescription']) ? $categoryDetail[0]['metatagDescription'] : ''; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Metatag KeyWord</label>
                                                <input class="form-control" name="metatagKeyword" id="metatagKeyword"
                                                       placeholder="Enter text" value="<?php echo $cat = isset($categoryDetail[0]['metatagKeyword']) ? $categoryDetail[0]['metatagKeyword'] : ''; ?>">
                                            </div>
                                            <!--<div class="form-group">
                                                <label>Parent Category</label>
                                                <select class="form-control" name="pid" id="pid">
                                                    <option value='0'>Select Category</option>
<?php /* foreach ($parentCategory as $key => $categories) {
  if(isset($categoryDetail[0]['pid'])&&$categoryDetail[0]['pid']==$categories['id']){
  echo "<option value='" . $categories['id'] . "' selected=selected >" . $categories['categoryName'] . "</option>";
  }else{
  echo "<option value='" . $categories['id'] . "' >" . $categories['categoryName'] . "</option>";
  }
  } */ ?>
                                                </select>
                                            </div>-->

                                            <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" name="image" id="image">
<?php if (isset($categoryDetail[0]['image'])) { ?>
                                                    <img src="<?php echo "../" . $categoryDetail[0]['image']; ?>" width="100" height="100">
                                                <?php } ?>
                                            </div>

                                            <div class="form-group">
                                                <label>Short Order</label>
                                                <input class="form-control" name="shortOrder" id="shortOrder"
                                                       placeholder="Enter text" value="<?php echo $cat = isset($categoryDetail[0]['shortOrder']) ? $categoryDetail[0]['shortOrder'] : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
<?php if (isset($categoryDetail[0]['status'])) { ?>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="1" <?php if (isset($categoryDetail[0]['status']) && $categoryDetail[0]['status'] == 1) {
        echo "checked";
    } ?> >Active
                                                    </label>
                                                    <label class="radio-inline">
                                                        <input type="radio" name="status" id="status" value="0" <?php if (isset($categoryDetail[0]['status']) && $categoryDetail[0]['status'] == 0) {
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
