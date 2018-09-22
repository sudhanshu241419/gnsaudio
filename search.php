<?php
require_once("config/config.php");
$products = new Product();
$catId=$_POST['catid'];
$price = $_POST['price'];
$p=explode("-",$price);
$material = $_POST['material'];
$size = $_POST['size'];
$column = array();
$query = "select p.*, sp.* from products as p left join size_price as sp on p.id=sp.pid";
$where = " WHERE p.status='1' and p.cid=".$catId." ";
if(!empty($price)){
	$where .= "and sp.price between ".$p[0]." and ".$p[1]." ";
}
if(!empty($size)){
	$where .="and sp.size = ".$size." ";
}

if(!empty($material)){
	$where .="and p.materialId=".$material." ";	
}
$query = $query.$where;
$product = $products->joinLeft($query);
?>

<?php 
$str = "";
		if(isset($product) && !empty($product)){
			foreach($product as $key => $val){
		
				$str.='<div class="col-lg-4 col-sm-4 productbox">';
				$str.='<div class="prdimg"><a href="product-detail.php?pid='.$val['id'].'"><img src="'.$val['image_small'].'" class="img-responsive"></a></div>';
				$str.='<div class="ptitle">'.$val['title'].'</div>';
				$str.='<div class="prddetl_box">';
				$str.='<div class="prdzoom"><a onclick = "getProductDetailOnZoomIcon(\''.$val['id'].'\')" data-target=".bs-example-modal-productdetail" data-toggle="modal" href="#"><img src="images/zoom-icon.png"></a></div>';
				$str.='<div class="prdprice">Starts From <br /><span>Rs. '.$val['price'].'</span></div>';
				$str.='<div class="prdpbyn"><a href="product-detail.php?pid='.$val['id'].'">Buy Now</a></div>';
				$str.='</div>';
				$str.='</div>';
		
			}//end foreach
			echo json_encode(array('msg'=>'success','data'=>$str));
		}else{		
			echo json_encode(array('msg'=>'fail','error'=>'<div class="col-lg-4 col-sm-4 productbox">There is no product available right now.</div>'));	
		}
?>
	
