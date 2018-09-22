<?php
if(!isset($_GET['catid'])){
   header("location:index.php");
}

require_once("header.php");
$catId = (int)$_GET['catid'];
$column = array();

$products = new Product();
$query = "SELECT p.id, 	p.cid, p.materialId, p.product_code,p.productName,p.title,p.instruction,p.description,p.metaTag,p.metaDescription,p.flatdiscount,p.image_small,p.image_large,sp.id as sid,sp.price,sp.size,sp.quantity FROM products as p left join size_price as sp on p.id=sp.pid";
$where = " WHERE p.status='1' and p.cid=".$catId;
$query=$query.$where;


/*Code for Pagination*/
$total=$products->totalRecords($query);
$adjacents = 3;
$targetpage = "product.php"; //your file name
$limit = 6; //how many items to show per page
$page = (isset($_GET['page']))?(int)$_GET['page']:1;

if($page){ 
$start = ($page - 1) * $limit; //first item to display on this page
}else{
$start = 0;
}

/* Setup page vars for display. */
if ($page == 0) $page = 1; //if no page var is given, default to 1.
$prev = $page - 1; //previous page is current page - 1
$next = $page + 1; //next page is current page + 1
$lastpage = ceil($total/$limit); //lastpage.
$lpm1 = $lastpage - 1; //last page minus 1
#################
//$query = $query." limit ".$start.",".$limit;

$product = $products->leftJoin($query);

$priceObj = new Price();
$where = " where 1=1";
$sprice = $priceObj->getPrice($column,$where);

$materialObj = new Material();
$smaterial = $materialObj->getMaterial($column,$where);


/* CREATE THE PAGINATION */
$counter=0;
$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<div class='pagination1'> <ul>";
if ($page > $counter+1) {
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$prev\">prev</a></li>"; 
}

if ($lastpage < 7 + ($adjacents * 2)) 
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$counter\">$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
{
//close to beginning; only hide later pages
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$lastpage\">$lastpage</a></li>"; 
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$counter\">$counter</a></li>"; 
}
$pagination.= "<li>...</li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$lpm1\">$lpm1</a></li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$lastpage\">$lastpage</a></li>"; 
}
//close to end; only hide early pages
else
{
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=1\">1</a></li>";
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=2\">2</a></li>";
$pagination.= "<li>...</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
$counter++)
{
if ($counter == $page)
$pagination.= "<li><a href='#' class='active'>$counter</a></li>";
else
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$counter\">$counter</a></li>"; 
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<li><a href=\"$targetpage?catid=$catId&page=$next\">next</a></li>";
else
$pagination.= "";
$pagination.= "</ul></div>\n"; 
}

?>

<!--start page title-->

<div class="container">

    <div class="row">

        <div class="col-lg-12">

            <div class="pagetilte" style="margin-top: 35px">Home   >  Home Decor   >  

                <?php
                if (isset($categories) && !empty($categories)) {

                    foreach ($categories as $key => $cname) {

                        if ($cname['id'] == $catId) {

                            echo $cname['categoryName'];
                        }
                    }
                }
                ?>

            </div>

        </div>

    </div>

</div>

<!--start page title-->



<!--start serarch option-->

<!--<div class="container">

    <div class="row prdserbox">-->

<!--        <div class="col-lg-3 col-sm-3">
            <div class="prodt_titlename">

                <?php
                if (isset($categories) && !empty($categories)) {



                    foreach ($categories as $key => $cname) {

                        if ($cname['id'] == $catId) {

                            echo $cname['categoryName'];
                        }
                    }
                }
                ?>

            </div> 

            <div class="prdtitle_tag">
                Try to use these on a limited basis and avoid creating entirely different versions of the same site. 
            </div>

        </div>-->

	<!--<form name="searchfrm" id="searchfrm" method="post" action="">

        <div class="col-lg-3 col-sm-3">

            <div class="prdserchopton_box">

                <div class="prdsername">Price</div>

                <div class="prdserch_details">

				<select name="sprice" id="sprice" class="form-control">

				<option value="">Select Price</option>

				<?php if(isset($sprice) && !empty($sprice)){

					foreach($sprice as $key=>$price){

				?>

				<option value="<?php echo $price['price']?>"><?php echo $price['price'];?></option>

				<?php }} ?>

				</select>

                   

                </div>

            </div>

        </div>



        <div class="col-lg-3 col-sm-3">

            <div class="prdserchopton_box">

                <div class="prdsername">Size</div>

                <div class="prdserch_details">

                    <select name="ssize" id="ssize" class="form-control">

					<option value="">Select Size</option>

					<?php 

					if(isset($product) && !empty($product)){
						$sizeArray = array();
						$k=0;
						foreach($product as $key =>$s){
							$sizeArray[$k]=$s['size'];
							$k++;
						}
						$psize = array_unique($sizeArray);
						foreach($psize as $key =>$size){
					?>

					<option value="<?php echo $size;?>"><?php echo $size;?></option>

					<?php } }?>

					</select>

					

					<!--<a href="#">12" (50)</a><br>-->

          <!--      </div>

            </div>

        </div>



        <div class="col-lg-3 col-sm-3">

            <div class="prdserchopton_box">

                <div class="prdsername">Material</div>

                <div class="prdserch_details">

					<select name="smaterial" id="smaterial" class="form-control">

					<option value="">Select Material</option>

					<?php 

					if(isset($smaterial) && !empty($smaterial)){

						foreach($smaterial as $key =>$material){

					?>

					<option value="<?php echo $material['id']?>"><?php echo $material['material'];?></option>

					<?php

						}

					}

					?>

					</select>

					<input type = "hidden" id="catid" value="<?php echo $_GET['catid'];?>">

                    <!--<a href="#">Poly Taffeta(6)</a><br>-->

                    
<!--
                </div>

            </div>

        </div>

</form>-->

<!--<div class="container">

    <div class="row">

<?php if($categories){ ?>

        <div class="col-lg-4 col-sm-4">

            <div class="prdbox">

                <div class="prdimg inprdimg"><a href="product.php?catid=<?php echo $categories[2]['id'];?>"><img src="<?php echo $categories[2]['image'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $categories[2]['categoryName'];?></div>

                    <div class="prdqut">

                        <?php

                        $where = " WHERE  cid =".$categories[2]['id'];

                        $rows = $products->mysqlNumRows($where);

                        if($rows){

                            echo $rows." Items";

                        }else{

                            echo "0 Items";

                        }

                        ?>

                    </div>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

    </div>

</div>-->



<!--end Product Cat -->



<!--start Product Cat-->

<div class="container">

    <div class="row" id="product">

		<?php 

		if(isset($product) && !empty($product)){
				$size = "";
			foreach($product as $key => $val){
				if(isset($val['size']) && $val['size']!="")
					$size = "&size=".$val['size'];
		?>

			<div class="col-lg-4 col-sm-4 productbox">

				<div class="prdimg min_prdimg">
				<a href="product-detail.php?pid=<?php echo $val['id'];?><?php echo $size;?>"><img src="<?php echo $val['image_small'];?>" class="img-responsive" ></a>
				
				</div>
				<?php if($val['quantity']=="" || $val['quantity']==0){ ?><div style=""><img src="images/soldout.jpg"></div><?php }?>
				<div class="ptitle"><?php echo $val['title'];?></div>

				<div class="prddetl_box">
                                       <?php if(isset($val['price']) && !empty($val['price'])){?>
					<div class="prdzoom"><a href="#" data-toggle="modal" data-target=".bs-example-modal-productdetail" id="pdetailonzoomicon_<?php echo $val['id'];?>" relid="<?php echo $val['id'];?>"><img src="images/zoom-icon.png" ></a></div>
                                       <?php } ?>
					<?php if($val['quantity']=="" || $val['quantity'] == 0){ ?><div class="prdprice">
						<a href="#" id="notyfyme_<?php echo $val['id'];?>" rel_notifyme="<?php echo $val['id'];?>" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-notyfyme">Notify Me</a>
					</div>
					<?php } else{ ?>
					<div class="prdprice">Starts From <br /><span>Rs. <?php echo $val['price'];?></span></div>
					
					<?php }	?>
                                        <?php if(isset($val['price']) && !empty($val['price'])){?>
                                        <div class="prdpbyn"><a href="product-detail.php?pid=<?php echo $val['id'];?><?php echo $size;?>">Buy Now</a></div>
                                        <?php } ?>
				</div>

			</div>

		<?php

			}//end foreach
			echo $pagination;
         ?>
		
		<?php }else{ ?>

			<div class="col-lg-4 col-sm-4 productbox">There is no product available right now.</div>

		<?php }?>

    </div>

</div>

<!--end Product Cat -->

<?php 
require_once("footer.php");
?>