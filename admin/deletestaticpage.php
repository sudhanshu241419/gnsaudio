<?php
 session_start();
    include_once 'config/config.php';
    $user = new User();
    $tableName='staticpage';
    $faq = new Module($tableName);
    $uid = $_SESSION['uid'];

    if (!$user->get_session()){
       header("location:login.php");
    }

    $id_array = $_POST['data']; // return array
	$id_count = count($_POST['data']); // count array

	for($i=0; $i < $id_count; $i++) {
		$id = $id_array[$i];
		$faq->delete($id);
	}
	header("Location: staticpage.php"); // redirent after deleting
    
?>