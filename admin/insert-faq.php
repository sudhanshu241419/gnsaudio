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
$tableName='static_page_faq';
$faq = new Module($tableName);
$faqFrmData = array();


if ($_POST) {
    if(empty($_POST['answer'])){
        $errorArray['0'] = "Faq answer is required....";
     }elseif($_POST['title_id']==0){
         $errorArray['1'] = "Select title....";
     }else{
        $faqFrmData['question'] = mysql_real_escape_string($_POST['question']);
        $faqFrmData['answer'] = $_POST['answer'];
        $faqFrmData['title_id'] = $_POST['title_id'];
        $faqFrmData['status'] = $_POST['status'];
        $faqId=(int)$_POST['fid']?$_POST['fid']:"";
        if(!empty($faqId)){
            $faqFrmData['updated_on']=date("Y-m-d H:i:s");
            $where = " WHERE id = ".$faqId;           
            $result=$faq->update($faqFrmData,$where);
        }else{
            $faqFrmData['created_on']=date("Y-m-d H:i:s");
            $result = $faq->insert($faqFrmData);
        }
        header("location: faq.php");
        exit;
    }
}

    //get faq title detail
    $tableName='static_page_title';
    $faqtitle = new Module($tableName);
    $column = array('id', 'title','status');
    $where = " where status='1'";
    $faqTitleDetail = $faqtitle->select($column, $where);

    //get faq detail
    if(isset($_GET['id'])){
    $column = array('id', 'title_id','question','answer','status');
    $id=($_GET['id']%2==0 or $_GET['id']%2==1 )?(int)$_GET['id']:0;
    $where = " where id=".$id;
    $faqDetail = $faq->select($column, $where);
   }

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Insert Faq </title>

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
                <h1 class="page-header">Faq</h1>
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
                                                                      href="faq.php">Cancel</a>
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
                                        <label>Faq Title</label>
                                        <select class="form-control" name="title_id" id="inputError">
                                            <option value='0'>Select Faq Title</option>
                                            <?php foreach ($faqTitleDetail as $key => $title) {
                                                if(isset($title['id']) && $title['id']==$faqDetail[0]['title_id']){
                                                    echo "<option value='" . $title['id'] . "' selected=selected >" . $title['title'] . "</option>";
                                                }else{
                                                     echo "<option value='" . $title['id'] . "' >" . $title['title'] . "</option>";
                                                }
                                            }?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Faq Question</label>
                                        <input class="form-control" name="question" id="question"
                                               placeholder="Enter question" value="<?php echo $cat=(isset($faqDetail[0]['question']))?$faqDetail[0]['question']:'';?>">
                                    </div>
                                   <div class="form-group">
                                        <label>Faq Answer</label>
                                        <textarea class="form-control" name="answer" id="answer"><?php echo $cat=isset($faqDetail[0]['answer'])?$faqDetail[0]['answer']:'';?></textarea>
                                              
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if(isset($faqDetail[0]['status'])){ ?>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="1" <?php if(isset($faqDetail[0]['status']) && $faqDetail[0]['status']==1){ echo "checked"; } ?> >Active
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="status" id="status" value="0" <?php if(isset($faqDetail[0]['status']) && $faqDetail[0]['status']==0){ echo "checked";}?> >Deactive
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
