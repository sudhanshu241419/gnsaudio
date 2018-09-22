<?php
session_start();
include_once 'config/config.php';
$user = new User();
$tableName='users';
$customer = new Module();
$customer->table_name = $tableName;
$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("location:login.php");
}
$records = array();
$columns = array();
$where = " WHERE 1=1 order by createdAt";
$records = $customer->selectData($columns,$where);
$contact = "";
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Customer</title>
	
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
                <h1 class="page-header">Customer</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
						<form action="deletecustomer.php" method="post" name="myform" id="myform">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
									<th>User Name</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Contact No.</th>
                                    <th>Primary Address</th>
                                    
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($records)){
                                    foreach ($records as $key => $value) {
                                           
                                        ?>
                                        <tr class="odd">
                                            <td><input type="checkbox" name="data[]" id="data" value="<?php echo $value['uid'];?>"></td>
											 <td><?php echo $value['uname']; ?></td>
											 <td><?php echo $value['first_name']; ?></td>
                                            <td><?php echo $value['last_name']; ?></td>
                                            <td><?php echo $value['uemail'];?></td>
                                            <td><?php 
                                                        $contact=(isset($value['telephone']))?$value['telephone']:"";
                                                        $contact=$contact.(isset($value['mobile']))?", ".$value['mobile']:"";
                                                        echo $contact;
                                            ?></td>
                                            <td><?php echo $value['address1'];?></td>
                                            
                                            <td class="center">
												<div class="btn btn-primary btn-xs" onclick="window.location='customerdetail.php?id=<?php echo $value['uid'];?>'">View Detail</div>
												<div class="btn btn-primary btn-xs" id="assigncoupon">Assign Coupon</div>
                                               



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
<a href="#" class="btn" id="openBtn">Open modal</a>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">�</button>
			<h3>Dialog</h3>
	</div>
	<div class="modal-body">
      <iframe src="" style="zoom:0.60" height="250" width="99.6%" frameborder="0"></iframe>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal">OK</button>
	</div>
</div>
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
		
		var frameSrc = "/login";

$('#openBtn').click(function(){
    $('#myModal').on('show', function () {

        $('iframe').attr("src",frameSrc);
      
	});
    $('#myModal').modal({show:true})
});
    });
    </script>
</body>

</html>
