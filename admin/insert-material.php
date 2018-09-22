<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName='material';
$materials = new Module($tableName);
$uid = $_SESSION['uid'];
$target='';

$frmData = array();
if ($_POST) {
    if(empty($_POST['material'])){
        echo "Material name is required....";
    }else{
        $frmData['material'] = ucfirst($_POST['material']);
        $frmData['description'] = $_POST['description'];
        $frmData['status'] = $_POST['status'];
       $materialId=(int)$_POST['mid']?$_POST['mid']:"";
       
        if(!empty($materialId)){
            $frmData['updatedAt'] = date('Y-m-d H:i:s');
            $where = " WHERE id = ".$materialId;
            $result=$materials->update($frmData,$where);
            
        }else{
            $frmData['createdAt'] = date('Y-m-d H:i:s');
            $result = $materials->insert($frmData);
        }
        header("location: material.php");
        exit;
    }
}
if(isset($_REQUEST['id'])){
    $column = array('id', 'material','description','status');
    $id=($_REQUEST['id']%2==0 or $_REQUEST['id']%2==1 )?(int)$_REQUEST['id']:0;
    $where = " where id=".$id;
    $materialDetail = $materials->select($column, $where);
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Product Material</title>

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
                <h1 class="page-header">Product Material</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form role="form" name="frmProduct" id="frmProduct" method="post" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="mid" value="<?php echo $id=isset($_GET['id'])?$_GET['id']:'';?>">
                    <div class="panel panel-default width450">
                        <div class="panel-heading">
                            <input type="submit" value="Save" name="smtsave" id="smtsave"
                                   class="btn btn-primary btn-sm"> <a class="btn btn-primary btn-sm"
                                                                      href="material.php">Cancel</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">


                                    <div class="form-group">
                                        <label>Product Material</label>
                                        <input class="form-control" name="material" id="material"
                                               placeholder="Enter text" value="<?php echo $cat=isset($materialDetail[0]['material'])?$materialDetail[0]['material']:'';?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="description"
                                                  rows="3"><?php echo $cat=isset($materialDetail[0]['description'])?$materialDetail[0]['description']:'';?></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($materialDetail[0]['status'])){ ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" <?php if(isset($materialDetail[0]['status']) && $materialDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="option2" <?php if(isset($materialDetail[0]['status']) && $materialDetail[0]['status']==0){ echo "checked";}?> >Deactive
                                        </label>
                                        <?php } else {?>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="1" checked >Active
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="status" id="status" value="option2">Deactive
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
