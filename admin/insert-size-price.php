<?php

session_start();
include_once 'config/config.php';
$user = new User();
$tableName = 'size_price';
$size = new Module();
$size->table_name = $tableName;
$uid = $_SESSION['uid'];

if (!$user->get_session()) {
    header("location:login.php");
}
$pid = $_POST['id'];
$sid = $_POST['sid'];

if (isset($_POST['submit'])) {
    if (isset($_POST['size']) && isset($_POST['price']) && isset($_POST['id']) && !empty($_POST['id']) && !empty($_POST['size']) && !empty($_POST['price'])) {
        $column = array('pid' => $_POST['id'], 'size' => $_POST['size'], 'price' => $_POST['price'], 'quantity' => $_POST['quantity']);
        if (isset($_POST['sid']) && !empty($_POST['sid'])) {
            $where = " where id ='" . $_POST['sid'] . "'";
            $size->updateData($column, $where);
        } else {
            $c = array();
            $w = " WHERE size='" . $_POST['size'] . "' and pid='" . $_POST['id'] . "'";
            $existSize = $size->selectData($c, $w);
            if ($existSize) {
                
            } else {               
                $size->insertData($column);               
            }
        }
    }
}
header("location:product-size-price.php?id=" . $pid);
?>