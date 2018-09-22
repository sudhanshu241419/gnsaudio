<?php
    session_start();
    include_once 'config/config.php';
    $user = new User();
    $tableName='staticpage';
    $staticpage = new Module();
    $staticpage->table_name = $tableName;
    $uid = $_SESSION['uid'];

    if (!$user->get_session()){
       header("location:login.php");
    }
    $records = array();
    $where=" where 1=1";
	$column = array();
    $records = $staticpage->selectData($column,$where);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ADMIN : Static Page</title>

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
                    <h1 class="page-header">Static Page</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a class="btn btn-primary btn-sm" href="insert-staticpage.php" >Insert</a> <button class="btn btn-primary btn-sm" id="delete">Delete</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                             <form action="deletestaticpage.php" method="post" name="myform" id="myform">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    
                                    <thead>
                                        <tr>
                                            <th class="col-md-1"><input type="checkbox" id="check_all" value=""></th>
                                            <th>Page Name</th>
                                            <th>Title</th>
                                            <th>Content</th>
											<th>Status</th>
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
                                            <td><?php echo $value['pagename']; ?></td>
                                            <td><?php echo $value['title']?></td>
                                            <td class="center"><?php echo stripslashes($value['content']);?></td>
											<td class="center"><?php echo $value['status']?></td>
                                            <td class="center"><div class="btn btn-primary btn-xs" onclick="window.location='insert-staticpage.php?id=<?php echo $value['id'];?>'">Edit</div> </td>
                                        </tr>
                                    <?php
                                            }
                                     }else{
                                   ?>
                                       <?php }?>
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
    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="assets/js/sb-admin.js"></script>
     <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>
