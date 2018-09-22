<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName='products';
$products = new Module();
$products->table_name = $tableName;
$uid = $_SESSION['uid'];
$target='';

$frmData = array();
if ($_POST) {
    if(empty($_POST['productName']) || empty($_POST['productCode'])){
        echo "Product name and Product code is required....";
    }else{
        $frmData['productName'] = ucfirst($_POST['productName']);
        $frmData['title'] = $_POST['title'];
        $frmData['description'] = $_POST['description'];
        $frmData['product_size'] = $_POST['productSize'];        
        $frmData['cid'] = $_POST['cid'];
        $frmData['metaTag'] = $_POST['metaTag'];
        $frmData['metaDescription'] = $_POST['metaDescription'];
        $frmData['materialId'] = $_POST['mid'];
        $frmData['flatdiscount'] = (isset($_POST['flatdiscount']) && !empty($_POST['flatdiscount']) )?$_POST['flatdiscount']:0;
        $frmData['status'] = $_POST['status'];
       

        $productId=(int)$_POST['pid']?$_POST['pid']:"";
        if(!empty($productId)){
            $frmData['updateAt'] = date('Y-m-d H:i:s');
            $where = " WHERE id = ".$productId;
            $result=$products->updateData($frmData,$where);
        }else{
             $frmData['createdAt'] = date('Y-m-d H:i:s');
			 $random = substr(number_format(time() * mt_rand(),0,'',''),0,10);
			 $frmData['product_code']=$_POST['productCode'];
            $result = $products->insertData($frmData);
        }
        
//        header("location: product.php");
//        exit;
    }
}
if(isset($_REQUEST['id'])){
    $column = array('cid','materialId', 'productName','title','description','metaDescription','flatdiscount','metaTag','status');
    $id=($_REQUEST['id']%2==0 or $_REQUEST['id']%2==1 )?(int)$_REQUEST['id']:0;
    $where = " where id=".$id;
    $productDetail = $products->selectData($column, $where);
    //print_r($productDetail);
}


######## Get category ######
$column = array('id', 'categoryName');
$where = " where pid=0 and status ='1'";//pid = parent id
$categories = new Module();
$categories->table_name = "categories";
$category = $categories->selectData($column, $where);
//print_r($category);
######## Get Material ######
$column = array('id', 'material');
$where = " where status = '1'";
$materials = new Module();
$materials ->table_name = "material";
$material = $materials->selectData($column, $where);
//print_r($material);
//die;
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Product</title>

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
                <h1 class="page-header">Product</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form role="form" name="frmProduct" id="frmProduct" method="post" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="pid" value="<?php echo $id=isset($_GET['id'])?$_GET['id']:'';?>">
                    <div class="panel panel-default width450">
                        <div class="panel-heading">
                            <input type="submit" value="Save" name="smtsave" id="smtsave" class="btn btn-primary btn-sm"> 
								   <a class="btn btn-primary btn-sm" href="product.php">Cancel</a>
								   
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="form-group">
                                        <label>Product Title</label>
                                        <input class="form-control" name="title" id="title"
                                               placeholder="Enter text" value="<?php echo $cat=isset($productDetail[0]['title'])?$productDetail[0]['title']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input class="form-control" name="productName" id="productName"
                                               placeholder="Enter text" value="<?php echo $cat=isset($productDetail[0]['productName'])?$productDetail[0]['productName']:'';?>">
                                    </div>
                                    
                                     <div class="form-group">
                                        <label>Product Code</label>
                                        <input class="form-control" name="productCode" id="productCode"
                                               placeholder="Enter text" value="<?php echo $cat=isset($productDetail[0]['productCode'])?$productDetail[0]['productCode']:'';?>">
                                    </div>
                                    
                                      <div class="form-group">
                                        <label>Product Size</label>
                                        <input class="form-control" name="productSize" id="productSize"
                                               placeholder="Enter text" value="<?php echo $cat=isset($productDetail[0]['productSize'])?$productDetail[0]['productSize']:'';?>">
                                     </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="description"
                                                  rows="3"><?php echo $cat=isset($productDetail[0]['description'])?$productDetail[0]['description']:'';?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Metatag Description</label>
                                        <textarea class="form-control" name="metaDescription" id="metaDescription"
                                                  rows="3"><?php echo $cat=isset($productDetail[0]['metaDescription'])?$productDetail[0]['metaDescription']:'';?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Metatag KeyWord</label>
                                        <input class="form-control" name="metaTag" id="metaTag"
                                               placeholder="Enter text" value="<?php echo $cat=isset($productDetail[0]['metaTag'])?$productDetail[0]['metaTag']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                       <select class="form-control" name="cid" id="cid">
                                            <option value='0'>Select category</option>
                                           <?php if(!empty($category)){
                                                foreach ($category as $key => $cat) {
                                                    print_r($cat);
                                                    if(isset($cat['id']) && isset($productDetail[0]['cid']) && $cat['id']==$productDetail[0]['cid']){
                                                        echo "<option value='" . $cat['id'] . "' selected=selected >" . $cat['categoryName'] . "</option>";
                                                    }else{
                                                        echo "<option value='" .  $cat['id'] . "' >" . $cat['categoryName'] . "</option>";
                                                    }
                                                }
                                            }?>
                                        </select>
                                    </div>

                                     <div class="form-group">
                                        <label>Material</label>
                                        <select class="form-control" name="mid" id="mid">
                                            <option value='0'>Select material</option>
                                            <?php if(!empty($material)){
                                                foreach ($material as $key => $mat) {
                                                    if(isset($mat['id']) && $mat['id']==$productDetail[0]['materialId']){
                                                        echo "<option value='" . $mat['id'] . "' selected=selected >" . $mat['material'] . "</option>";
                                                    }else{
                                                        echo "<option value='" . $mat['id'] . "' >" . $mat['material'] . "</option>";
                                                    }
                                                }
                                            }?>
                                        </select>
                                    </div>

                                    
									
									<div class="form-group">
                                        <label>Flat Discount</label>
                                        <input class="form-control" type="text" name="flatdiscount" id="flatdiscount" value="<?php if(isset($productDetail[0]['flatdiscount'])){ echo $productDetail[0]['flatdiscount']; } ?>">

                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($productDetail[0]['status'])){?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" <?php if(isset($productDetail[0]['status']) && $productDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="0" <?php if(isset($productDetail[0]['status']) && $productDetail[0]['status']==0){ echo "checked";}?> >Deactive
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
