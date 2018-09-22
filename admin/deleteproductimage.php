<?php

session_start();
include_once 'config/config.php';
$user = new User();
$tableName = 'products_image';
$productimg = new Module();
$productimg->table_name = $tableName;
$uid = $_SESSION['uid'];
print_R("hello");
die;
if (!$user->get_session()) {
    header("location:login.php");
}

$id_array = $_POST['data']; // return array
$id_count = count($_POST['data']); // count array
$tableName = "products";
$product = new Module();
$product->table_name = $tableName;
for ($i = 0; $i < $id_count; $i++) {
    $id = $id_array[$i];
    $where = " WHERE id=" . $id;
    $column = array('pid', 'main_image', 'image_small', 'image_large');
    $p = $productimg->selectData($column, $where);
    print_r($p);
    if ($p[0]['main_image'] == 1) {
        $where = " WHERE id=" . $p[0]['pid'];
        $column = array('image_small' => '', 'image_large' => '');
        $product->updateData($column, $where);
    }
    $productimg->deleteData($id);
    if ($p[0]['image_small'])
        unlink("../" . $p[0]['image_small']);
    if ($p[0]['image_large'])
        unlink("../" . $p[0]['image_large']);
}
//header("Location: product-image.php"); // redirent after deleting
?>