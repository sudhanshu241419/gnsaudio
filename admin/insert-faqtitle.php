<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$tableName='static_page_title';
$faqtitle = new Module($tableName);
$uid = $_SESSION['uid'];
$target='';

######## Get parent category ######

$faqFrmData = array();
if ($_POST) {
    if(empty($_POST['title'])){
        echo "Faq title is required....";
     }else{
        $faqFrmData['title'] = mysql_real_escape_string(ucfirst(strtolower($_POST['title'])));
        $faqFrmData['link'] = mysql_real_escape_string(strtolower($_POST['link']));
        $faqFrmData['orderby'] =(int)$_POST['order']?$_POST['order']:0;
        $faqFrmData['status'] = ucfirst(strtolower($_POST['status']));
        $faqTitleId=(int)$_POST['fid']?$_POST['fid']:"";
        if(!empty($faqTitleId)){
            $faqFrmData['updated_on']=date("Y-m-d H:i:s");
            $where = " WHERE id = ".$faqTitleId;           
            $result=$faqtitle->update($faqFrmData,$where);
        }else{
            $faqFrmData['created_on']=date("Y-m-d H:i:s");
            $result = $faqtitle->insert($faqFrmData);
        }
        header("location: faqtitle.php");
        exit;
    }
}
if(isset($_GET['id'])){
    $column = array('id', 'title','link','orderby','status');
    $id=($_GET['id']%2==0 or $_GET['id']%2==1 )?(int)$_GET['id']:0;
    $where = " where id=".$id;
    $faqTitleDetail = $faqtitle->select($column, $where);
   }
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Faq Title</title>

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
                <h1 class="page-header">Faq Title</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form role="form" name="frmcategory" id="frmcategory" method="post" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="fid" value="<?php echo $id=isset($_GET['id'])?$_GET['id']:'';?>">
                    <div class="panel panel-default width450">
                        <div class="panel-heading">
                            <input type="submit" value="Save" name="smtsave" id="smtsave"
                                   class="btn btn-primary btn-sm"> <a class="btn btn-primary btn-sm"
                                                                      href="faqtitle.php">Cancel</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label>Faq Title</label>
                                        <input class="form-control" name="title" id="title"
                                               placeholder="Enter text" value="<?php echo $cat=isset($faqTitleDetail[0]['title'])?$faqTitleDetail[0]['title']:'';?>">
                                    </div>
                                     <div class="form-group">
                                        <label>Link</label>
                                        <input class="form-control" name="link" id="link"
                                               placeholder="Enter text" value="<?php echo $cat=isset($faqTitleDetail[0]['link'])?$faqTitleDetail[0]['link']:'';?>">
                                    </div>
                                   <div class="form-group">
                                        <label>Order By</label>
                                        <input class="form-control" name="order" id="order"
                                               placeholder="Enter text" value="<?php echo $cat=isset($faqTitleDetail[0]['orderby'])?$faqTitleDetail[0]['orderby']:'';?>"><font size="1" color="green">(It should be number like 1,2,...)</font>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($faqTitleDetail[0]['status'])){ ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="1" <?php if(isset($faqTitleDetail[0]['status']) && $faqTitleDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="0" <?php if(isset($faqTitleDetail[0]['status']) && $faqTitleDetail[0]['status']==0){ echo "checked";}?> >Deactive
                                            </label>
                                        <?php }else{ ?>
                                                <label class="radio-inline">
                                                    <input type="radio" name="status" id="status" value="1"  checked="checked" >Active
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
