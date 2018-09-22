<?php

session_start();
include_once 'config/config.php';
$user = new User();
$tableName = 'size_price';
$faq = new Module();
$faq->table_name = $tableName;
$uid = $_SESSION['uid'];

if (!$user->get_session()) {
    header("location:login.php");
}
$pid = $_POST['pid'];
$id_array = $_POST['data']; // return array
$id_count = count($_POST['data']); // count array

for ($i = 0; $i < $id_count; $i++) {
    $id = $id_array[$i];
    $result = $faq->deleteData($id);
}
header("Location: product-size-price.php?id=" . $pid); // redirent after deleting
?>