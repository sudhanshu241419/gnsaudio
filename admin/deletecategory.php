<?php
 session_start();
    include_once 'config/config.php';
    $user = new User();
    $tableName='categories';
    $category = new Module();
    $category->table_name = $tableName;
    $uid = $_SESSION['uid'];

    if (!$user->get_session()){
       header("location:login.php");
    }

    $id_array = $_POST['data']; // return array
    $id_count = count($_POST['data']); // count array
   
    for($i=0; $i < $id_count; $i++) {
        $id = $id_array[$i];
        //delete category image
        $c=array();
        $w=" Where id='".$id."'";
        $cat=$category->selectData($c,$w);
        if(file_exists("../".$cat[0]['image']))
                unlink("../".$cat[0]['image']);
        #######################################
        //Delete category
        $result=$category->deleteData($id);
        #######################################
        if($result){
            $tableName='products';
            $products = new Module();
            $products->table_name = $tableName;
            $column = array();
            $where = " where cid='".$id."'";
            $product=$products->selectData($column,$where);

            foreach($product as $k=>$val){
                $query="select * from products_image where pid='".$val['id']."'";
                $image=$category->queryParser($query);
                if(file_exists("../".$image[0]['image_small'])){
                        unlink("../".$image[0]['image_small']);
                }
                if(file_exists("../".$image[0]['image_large'])){
                        unlink("../".$image[0]['image_large']);
                }	
             $category->deleteData($val['id']);
            }	

        $category->deleteData($id);


    }
  }
	header("Location: category.php"); // redirent after deleting
    
?>