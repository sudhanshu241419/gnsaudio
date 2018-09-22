<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include_once 'config/config.php';
$user = new User();
if (!$user->get_session()) {
    header("location:login.php");
}
$uid = $_SESSION['uid'];

######## Get parent category ######
$errorArray = array();
$tableName='staticpage';
$staticpage= new Module($tableName);
$staticFrmData = array();


if ($_POST) {
$pagename=trim(preg_replace('/[\s\t\n\r\s]+/', '', $_POST['pagename']));
$title = trim($_POST['title']);
    if(empty($pagename)){
        $errorArray['0'] = "Page name is required";
     }elseif(empty($title)){
         $errorArray['1'] = "Page title is required";
     }else{
        $staticFrmData['pagename'] = mysql_real_escape_string(strtolower($pagename));
        $staticFrmData['title'] = mysql_real_escape_string(ucfirst($title));
        $staticFrmData['content'] = mysql_real_escape_string($_POST['content']);
        $staticFrmData['status'] = $_POST['status'];
        $pageId=(int)$_POST['sid']?$_POST['sid']:"";
        if(!empty($pageId)){
            $faqFrmData['updated_on']=date("Y-m-d H:i:s");
            $where = " WHERE id = ".$pageId;           
            $result=$staticpage->update($staticFrmData,$where);
        }else{
            $faqFrmData['created_on']=date("Y-m-d H:i:s");
			$where = " WHERE pagename='".$staticFrmData['pagename']."'";
			$column = array();
			$existpage = $staticpage->select($column,$where);
			if(isset($existpage[0]['pagename']) && !empty($existpage[0]['pagename']) && strlen($existpage[0]['pagename'])>0){
				$errorArray['1'] = "Page alredy exist";
			}else{
            $result = $staticpage->insert($staticFrmData);
			}
        }
        header("location: staticpage.php");
        exit;
    }
}

    

    //get faq detail
    if(isset($_GET['id'])){
    $column = array('id', 'pagename','title','content','status');
    $id=($_GET['id']%2==0 or $_GET['id']%2==1 )?(int)$_GET['id']:0;
    $where = " where id=".$id;
    $staticDetail = $staticpage->select($column, $where);
   }

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Static Page </title>

    <!-- Core CSS - Include with every page -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">
    <link href="assets/css/custome.css" rel="stylesheet">
    <script type="text/javascript" src="editor/tinymce.min.js"></script>
	<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons template paste textcolor colorpicker textpattern"
			],
			toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
			toolbar2: "print preview media | forecolor backcolor emoticons",
			image_advtab: true,
			templates: [
				{title: 'Test template 1', content: 'Test 1'},
				{title: 'Test template 2', content: 'Test 2'}
			]
		});
	</script>
    
</head>

<body>

<div id="wrapper">

    <?php Include('navigation.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Static Page</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <form role="form" name="frmcategory" id="frmcategory" method="post" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="sid" value="<?php echo $id=isset($_GET['id'])?$_GET['id']:'';?>">
                    <div class="panel panel-default width450">
                        <div class="panel-heading">
                            <input type="submit" value="Save" name="smtsave" id="smtsave"
                                   class="btn btn-primary btn-sm"> <a class="btn btn-primary btn-sm"
                                                                      href="staticpage.php">Cancel</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                <?php if(!empty($errorArray)){ ?>
                                <div>
                                <ul style="color:red;">
                                    <?php foreach($errorArray as $key =>$error){ 
                                        echo "<li>".$error."</li>";
                                     } ?>   
                                    </ul>
                                </div>
                                <?php } ?>
                                    <div class="form-group">
                                        <label>Page Name</label>
                                        <input class="form-control" name="pagename" id="pagename"
                                               placeholder="Enter Title" value="<?php echo $cat=(isset($staticDetail[0]['pagename']))?$staticDetail[0]['pagename']:'';?>" <?php if(isset($_GET['id'])) echo "readonly"; ?>>
                                    
                                    </div>

                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" name="title" id="title"
                                               placeholder="Enter Title" value="<?php echo $cat=(isset($staticDetail[0]['title']))?$staticDetail[0]['title']:'';?>">
                                    </div>
                                   <div class="form-group">
                                        <label>Content</label>
                                        <textarea class="form-control" name="content" id="content"><?php echo $cat=isset($staticDetail[0]['content'])?$staticDetail[0]['content']:'';?></textarea>
                                              
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($staticDetail[0]['status'])){ ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="1" <?php if(isset($staticDetail[0]['status']) && $staticDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="0" <?php if(isset($staticDetail[0]['status']) && $staticDetail[0]['status']==0){ echo "checked";}?> >Deactive
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
