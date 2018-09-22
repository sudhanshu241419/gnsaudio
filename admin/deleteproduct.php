<?php
 session_start();
    include_once 'config/config.php';
    $user = new User();
	$tableName='products';
	$products = new Module($tableName);
    $uid = $_SESSION['uid'];

    if (!$user->get_session()){
       header("location:login.php");
    }

    $id_array = $_POST['data']; // return array
	$id_count = count($_POST['data']); // count array
	
	//product image
	$column = array('pid','image_small','image_large');
	$tableName="products_image";
	$productimg = new Module($tableName);
	
	for($i=0; $i < $id_count; $i++) {
		$id = $id_array[$i];
		$where = " WHERE pid=".$id;
		$p = $productimg->select($column,$where);
		//Delete product image from products_image
		$query = "DELETE FROM products_image WHERE pid=".$id;
		if(file_exists("../".$p[0]['image_small']))
		unlink("../".$p[0]['image_small']);
		if(file_exists("../".$p[0]['image_large']))
		unlink("../".$p[0]['image_large']);
		$productimg->queryParser($query);	
		//End delete image
		//delete product
		$products->delete($id);
		
	}
	header("Location: product.php"); // redirent after deleting
    
?>