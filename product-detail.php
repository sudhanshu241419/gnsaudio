<?php
require_once("header.php");
if (!isset($_GET['pid'])) {
    header("location:index.php");
}
$psize = (isset($_GET['size'])) ? $_GET['size'] : 0;
$pId = (isset($_GET['pid'])) ? (int) $_GET['pid'] : 0;
$column = array();
//$materialObj = new Material();
//$where = " where 1=1";
//$smaterial = $materialObj->getMaterial($column, $where);
//$where = " where pid='" . $pId . "'";
//$sizeObj = new Size();
//$ssize = $sizeObj->getSize($column, $where);

$products = new Product();
$query = "SELECT p.id, 	p.cid, p.materialId, p.product_code,p.productName,p.title,p.instruction,p.description,p.metaTag,p.metaDescription,p.flatdiscount,p.image_small,p.image_large,sp.id as sid,sp.price,sp.size,sp.quantity FROM products as p left join size_price as sp on p.id=sp.pid";
$where = " WHERE p.id =" . $pId;
$products->query = $query . $where;

$product = $products->joinLeft();

$productImage = new Productimage();
$where = " WHERE pid =" . $pId;
$productImages = $productImage->getImages($column, $where);
//print_r($productImages);
//Get Related Product
if ($product) {
    $relatedProducts = '';
    $query = "SELECT p.id,p.title,p.image_small,p.image_large,sp.size FROM products as p left join size_price as sp on p.id=sp.pid";
    $where = " WHERE p.id!=" . $pId . " and p.cid=" . $product[0]['cid'] . " ORDER BY RAND() limit 0, 6";
    $query = $query . $where;
    $products->query = $query;
    $relatedProducts = $products->joinLeft();
}
//GetReview
$review = array();
$where = " WHERE productid=" . $pId . " and status='1' order by createdAt desc";
$reviewObj = New Review();
$review = $reviewObj->selectData($column, $where);

$userReview = array();

if (!empty($review)) {
    foreach ($review as $key => $r) {
        if ($r['userType'] == 'u') {
            $where = " WHERE r.userid=" . $r['userid'] . " and r.productid=" . $pId;
            $query = "select r.content,r.createdAt,u.first_name from user_review as r left join users as u on r.userid=u.uid " . $where;
            $data = $products->joinLeft($query);
            if (!empty($data)) {
                $userReview[$key]['username'] = isset($data[0]['first_name']) ? $data[0]['first_name'] : '';
                $userReview[$key]['content'] = isset($data[0]['content']) ? $data[0]['content'] : '';
                $userReview[$key]['createdAt'] = isset($data[0]['createdAt']) ? $data[0]['createdAt'] : '';
            }
        } elseif ($r['userType'] == 'g') {
            $where = " WHERE r.userid=" . $r['userid'] . " and r.productid=" . $pId;
            $query = "select r.content,r.createdAt,g.first_name from user_review as r left join guiest as g on r.userid=g.gid " . $where;
            $data = $products->joinLeft($query);
            if (!empty($data)) {
                $userReview[$key]['username'] = isset($data[0]['first_name']) ? $data[0]['first_name'] : '';
                $userReview[$key]['content'] = isset($data[0]['content']) ? $data[0]['content'] : '';
                $userReview[$key]['createdAt'] = isset($data[0]['createdAt']) ? $data[0]['createdAt'] : '';
            }
        }
    }
}
?>


<!--start Product detail-->
<div class="container">
    <?php if ($product) { ?>
        <div class="row productdetail_box">
            <!--start product zoom-->
            <div class="col-lg-5 col-sm-5 col-md-5">
                <div style=" padding:10px;">
                  <!--<img src="<?php //echo $product[0]['image'];    ?>" class="img-responsive">-->
                    <div>
                        <a id="zoom01" class="cloud-zoom" href="<?php echo $product[0]['image_large']; ?>" rel="position:'right', adjustX:25, adjustY:-3, tint:'#FFFFFF', softFocus:1, smoothMove:5, tintOpacity:0.8, zoomWidth:500, zoomHeight:500">
                            <img src="<?php echo $product[0]['image_small']; ?>" alt="" class="img-responsive" />
                        </a>

                    </div>

                    <?php if (!empty($productImages)) { ?>
                        <div >
                            <?php
                            foreach ($productImages as $key => $pimg) {
                                ?>
                                <div class="zoomsmal_box">      
                                    <a class="cloud-zoom-gallery" href="<?php echo $pimg['image_large']; ?>" rel="useZoom: 'zoom01', smallImage: '<?php echo $pimg['image_small']; ?>'">
                                        <img src="<?php echo $pimg['image_small']; ?>" width="70" height="70"/>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?> 

                </div>
            </div>




            <!--end product zoom-->

            <!--start product detail-->
            <div class="col-lg-7 col-sm-7 col-md-7" style="margin-top:5px;">
                <form name="productDetailFrm" id="productDetailFrm" method="post">
                    <div class="prddtailp_name"><?php echo $product[0]['title']; ?></div>
                    <div class="prddtailp_price">Rs <?php echo $product[0]['price']; ?><?php if ($product[0]['quantity'] == "" || $product[0]['quantity'] == 0) { ?><span style="margin-left:350px"><img src="images/soldout.jpg"></span><?php } ?></div>
                    <div class="prddtailp_cont"><?php echo $product[0]['description']; ?></div>
                    <div class="row prddtailp_sizebox">
                        <?php // if ($psize > 0) { ?>
                        <!--                            <div class="col-lg-2 col-sm-3 col-sm-2 col-xs-3 prddtailp_sizename">Size</div>
                                                    <div class="col-lg-3 col-sm-5 col-sm-3 col-xs-5 prddtailp_sizeslect">-->

                                    <!--<select name="ssize" id="ssize" class="form-control" onchange="chageSize(<?php echo $_GET['pid'] ?>, this.value);">-->
                        <?php
//                                    if (isset($ssize) && !empty($ssize)) {
//                                        foreach ($ssize as $key => $size) {
                        ?>
    <!--                                            <option value="<?php echo $size['size']; ?>" <?php
                        if ($size['size'] == $psize) {
                            echo "selected=selected";
                        }
                        ?>><?php echo $size['size']; ?></option>-->
                        <?php
                        // }
//        }
                        ?>
                        <!--</select>-->

                        <!--                            </div>-->
    <?php // }  ?>

                        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 prddtailp_sizename">Quantity</div>
                        <div class="col-lg-3 col-sm-3 col-md-3">
                            <div class="prdaddboxn">
                                <div class="prdaddopt" id="minusOne" style="cursor:pointer">-</div>
                                <div class="prdaddopt_int"><input type="text" value="50" id="qty"></div>
                                <div class="prdaddopt" id="plus0ne" style="cursor:pointer">+</div>
                            </div>
                        </div>



                    </div>

                    <div class="row prddtailp_addbox">

                        <div class="col-lg-4 col-sm-4 col-md-4 rdaddcart">
                            <?php if ($product[0]['quantity'] == "" || $product[0]['quantity'] == 0) { ?>
                                <a href="#" id="notyfyme" rel_notifyme="<?php echo $product[0]['id']; ?>" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-notyfyme">Notify Me</a>
                            <?php } else { ?>
                                <a href="#" id="addcart" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-mycart">Add to Cart</a>
    <?php } ?>
                        </div>
    <!--                        <div class="col-lg-4 col-sm-4 col-md-4 prdaddcart"><a href="#" id="wishlist" wishlist="<?php echo $product[0]['id']; ?>" class="button">Add to Wishlist</a></div>
                        <div class="col-lg-5 col-sm-5 col-md-5 prdaddcart"><a href="#" id="emailtofriend" emailtofriend="<?php echo $product[0]['id']; ?>" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-emailtofriend">Email To Friend</a></div>-->
                    </div>

                    <div class="col-lg-4 col-sm-4 col-md-4 prdaddcart" style="padding-right: 5px;padding-left: 0px;margin-top: 32px;"><a href="#" id="notyfyme" rel_notifyme="<?php echo $product[0]['id']; ?>" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-enquiry">Enquiry</a></div>

                    <!--                    <div class="row prddtailp_addbox">
                                            
                                        </div>-->


                    <!--                    <div class="row" style="clear:both; padding-top:20px;">
                                            <div class="col-md-3">
                                                <div class="fb-like" data-href="<?php echo curPageURL(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                            </div> 
                                            <div class="col-md-3"> 
                                                <a class="twitter-share-button" href="https://twitter.com/share" data-url="<?php echo curPageURL(); ?>" data-via="<?php echo $product[0]['title']; ?>">Tweet</a>
                                            </div>
                                            <div class="col-md-3"><g:plus action="share" annotation="bubble"></g:plus></div>
                                            <div class="col-md-3"><a href="http://www.pinterest.com/pin/create/button/ ?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F
                                                                     &media=http%3A%2F%2F<?php echo $product[0]['image_small']; ?>
                                                                     &description=<?php echo $product[0]['title']; ?>"
                                                                     data-pin-do="buttonPin"
                                                                     data-pin-config="above">
                                                    <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" />
                                                </a>
                                            </div>
                                        </div>-->



                    <div class="row prd_spc" >
                        <h4>Product Specifications</h4>
                        <div class="prddtailp_codbox">
                            Code : <?php echo $product[0]['size'] ?> - <?php echo $product[0]['product_code'] ?>
                        </div>

                        <div class="prddtailp_codbox">
                            Material : <?php
                            if (isset($smaterial) && !empty($smaterial)) {
                                foreach ($smaterial as $key => $material) {
                                    if ($material['id'] == $product[0]['materialId'])
                                        echo $material['material'];
                                }
                            }
                            ?> 
                        </div>

                        <div class="prddtailp_codbox">
                            Care Instruction : <?php echo $product[0]['instruction'] ?>
                        </div>

                    </div>

                    <div class="pshlinkbox">
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#payments"><img src="images/cod-icon.png">Cash on Delivery</a></div>
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#ship"><img src="images/ship-icon.png">Free Shipping</a></div>
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#returnpolicy"><img src="images/policy-icon.png">Easy Return Policy</a></div>            
                    </div>

                    <input type="hidden" id="pid" value="<?php echo $product[0]['id']; ?>">
                    <input type="hidden" id = "productName" value="<?php echo $product[0]['productName']; ?>">
                    <input type="hidden" id = "price" value="<?php echo $product[0]['price']; ?>">
                    <input type="hidden" id = "description" value="<?php echo $product[0]['description']; ?>">
                    <input type="hidden" id = "image" value="<?php echo $product[0]['image_small']; ?>">

                    <input type="hidden" id="pcode" value="<?php echo $product[0]['size'] ?> - <?php echo $product[0]['product_code'] ?>">
                </form>

            </div>
            <!--end product detail-->



        </div>

        <!--end Product detail -->
<?php } ?>
</div>
<!--start product review box-->
<div class="container pdescripton_box">
<?php if ($product) { ?>
        <div class="row">

            <!--start product right-->
            <div class="col-lg-5 col-sm-5 col-md-5">


                <div class="prdtagbox">
                    <div class="prdtag_name">Product Tags</div>
                    <?php
                    $tag = explode(",", $product[0]['metaTag']);
                    foreach ($tag as $key => $tags) {
                        ?>
                        <a href="#"><?php echo ucfirst($tags); ?></a>  
    <?php } ?>
                </div>
            </div>
            <!--end product right-->


            <div class="col-lg-7 col-sm-7 col-md-7">

                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#description" role="tab" data-toggle="tab"> Description</a></li>
                    <li><a href="#reviews" role="tab" data-toggle="tab">Reviews</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="description">
    <?php echo $product[0]['description'] ?>
                    </div>

                    <div class="tab-pane fade" id="reviews">
                        <?php
                        if (!empty($userReview)) {
                            foreach ($userReview as $key => $val) {
                                $reviewon = date("d M, Y", strtotime($val['createdAt']));
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div style="float:left;width:auto;font-weight:bold;margin-right:10px;"><?php echo $val['username']; ?>:</div>
                                        <div style="width:550px;text-align:justify;"><?php echo $val['content']; ?></div>
                                        <div style="width:auto;font-weight:bold;margin-right:10px;">Created On: <?php echo $reviewon; ?></div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>

                </div>


            </div>
        </div>
    </div>
    <!--end product review box-->
<?php } ?>



<!--start Related Product-->
<div class="container relptd_box">
<?php if ($product) { ?>
        <div class="row">
            <h3 class="line"> Related Product </h3>

            <?php
            if ($relatedProducts) {
                foreach ($relatedProducts as $key => $val) {
                    ?>
                    <div class="col-lg-2 col-sm-4 productbox">
                        <div class="prdimg"><a href="product-detail.php?pid=<?php echo $val['id']; ?>&size=<?php echo $val['size']; ?>"><img src="<?php echo $val['image_small']; ?>" class="img-responsive" style="max-height: 200px;max-width: 200px;"></a></div>
                        <div class="pname"><?php echo $val['title']; ?> </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="col-lg-2 col-sm-4 productbox">There is no related product available</div>                

            </div>
        </div>
    <?php } ?>

    <!--end Related Product-->
    <?php
}
if (!$product) {
    echo "<h2><img src='images/error.jpg' width='60' >Product not found</h2>";
}
require_once("footer.php");
?>
    