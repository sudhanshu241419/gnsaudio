<?php
require_once("config/config.php");
if(isset($_POST['productId'])){

$pId = (int)$_POST['productId'];

$column = array();
$products = new Product();
    $query = "SELECT p.id, p.cid, p.materialId, p.product_code,p.productName,p.title,p.instruction,p.description,p.metaTag,p.metaDescription,p.flatdiscount,p.image_small,p.image_large,sp.id as sid,sp.price,sp.size,sp.quantity FROM products as p left join size_price as sp on p.id=sp.pid";
    $where = " WHERE p.id =".$pId." group by p.id order by sp.size asc";
    $query=$query.$where;
    $product = $products->leftJoin($query);
$materialObj = new Material();
$where = " where id=".$product[0]['materialId'];
$materials = $materialObj->getMaterial($column,$where);

	$result = array("msg"=>"success",'id'=>$product[0]['id'],'cid'=>$product[0]['cid'],'materialId'=>$materials[0]['material'],'product_code'=>$product[0]['product_code'],'productName'=>$product[0]['productName'],'title'=>$product[0]['title'],'instruction'=>$product[0]['instruction'],'description'=>$product[0]['description'],'price'=>$product[0]['price'],'image'=>$product[0]['image_small'],'size'=>$product[0]['size']);
}else{
	$result = array("msg"=>"fail","error"=>"Product Not Found");
}
echo json_encode($result);
?>

