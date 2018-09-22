<?php
session_start();

require("config/config.php");
$category = new Category();
$product = new Product();
$session = new Session();
$guiestsession = new Guiestsession();
$cart = new AddToCart();

$column = array("id","categoryName","description","metatagDescription","metatagKeyword","image","shortOrder","status");
$where = " WHERE status = '1' order by shortOrder";
$categories = $category->getCategory($column,$where);

$userId = $session->getUserId();
$guiestId=$guiestsession->getUserId();

############# Get cart data ###########################
$sessionId = session_id();
$query = "SELECT sessionId, sum( qty ) AS totalqty, sum( itemPrice ) AS itemprice FROM temp_mycart WHERE sessionId = '".$sessionId."' and status='pendding' GROUP BY sessionId";
$row = $cart->execureQuery($query);

################## new arival product #################
$arrivalWhere = " WHERE 1=1 order by p.createdAt desc limit 0,3";
$query = "SELECT p.id,p.productName,p.image_small,p.image_large,sp.price,sp.size,sp.quantity from products as p left join size_price as sp on p.id=sp.pid".$arrivalWhere;
$newArrivalProduct = $product->leftJoin($query);

?>
<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--  <link rel="shortcut icon" href="ico/favicon.png">-->

    <title>Akam</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <script src="js/jquery-1.10.2.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    
    <link href="css/pagination.css" rel="stylesheet">
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


    <!-- END -->


    <!--menu-->
    <script src="js/functions.js"></script>
    <link rel="stylesheet" type="text/css" href="css/menu.css" media="all" />
    <link href="style.css" rel="stylesheet">
    <script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>
<!--<script src="https://apis.google.com/js/plusone.js"></script>-->

    <!--end menu-->

</head>
<?php if(!isset($_GET['pid']) && !isset($_GET['catid']) && $_SERVER['SCRIPT_URL']!="/one-step-checkout.php" && !(isset($_GET['ordid']))){ ?>
<body style="background: #f3f7f8;background-image: url('images/djstand.jpg');background-position: right top;background-repeat: no-repeat;position: relative; z-index: 999999">
<?php }else{ ?>
    <body >
<?php } ?>
    <div id="fb-root"></div>

<!--start topheader-->
<div class="topheader">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 col-md-6">
                    <ul class="topheader_sec1">
                        <li><i class="fa fa-phone-square" aria-hidden="true"></i>Need Help? +91-80-48795730</li>
                        <li>Country : India&nbsp; &nbsp;<img src="images/flags/flags/16/India.png">&nbsp; &nbsp;INR</li>
                    </ul>
                </div>
           
            
<!--            <div class="col-sm-12 col-md-6">
                <ul class="topheader_sec2">
                    <li class="">Hi 
                        <?php 
                                if($session->getSession('userName')){ 
                                        echo $_SESSION['userName'];
                                }elseif($guiestsession->getSession('guiestName')){
                                        echo $_SESSION['guiestName'];
                                }else{
                                        echo "User";
                                }?>
                    </li>
                <?php if($userId || $guiestId){ ?>
                    <li class=""><a href="logout.php">Logout &nbsp;</a></li>
                  <?php }else{ ?>
               
                    <?php } ?>
                    <li class="">
<?php 
                    if($userId){ 
                    ?>
                            <a href="account.php">My Account</a>
                    <?php
                    }elseif($guiestId){
                    ?>						
                            <a href="account.php">My Account</a>
                    <?php

                    }else{
                    ?>
                            <a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >My Account</a>
                    <?php }?>
                    &nbsp; | &nbsp; </a> <a href="trackorder.php">Trackorder</a>
                    </li>
                     <li class="">
                    <a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >Login | &nbsp;</a> 
                    <a href="#" data-toggle="modal" data-target=".bs-example-modal-registration">Register</a>
                </li>
                </ul>
            </div>-->
            </div>
        </div>

    </div>
</div>
<!--end topheader-->


<!--start Header-->
<div class="header">
    <div class="container">
        
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 col-md-7 logo">
                    <a href="<?php echo SITE_URL;?>">
                        <h1>GNS GUPTA & SONS</h1><br>
                        <h6>Mics Audios</h6> 
                    </a> 
                </div>

                <div class="col-sm-12 col-md-5">
                   
                      <?php if(!$userId || !$guiestId){ ?>
                        <div class="col-sm-8 hide" id="flogin">
                           <img src="images/connect-with-facebook.png" >
                        </div>
                        <?php } ?>
                        <div class="col-sm-4 pull-right">
<!--                            <a href="#" class="mycartqty" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-mycart" data-qty="<?php echo  isset($row['totalqty'])?$row['totalqty']:0;?>" data-total='<?php echo (isset($row["totalqty"]) && isset($row["itemprice"]))?$row["totalqty"]*$row["itemprice"]:"0.00";?>'>
                                <div class="col-lg-2 col-sm-5 crtb">-->
                                    <div class="cartbox">
                                        
                                        <div class="cart_cont">Cart </div>
                                        <div class="cart_qty"><?php echo  isset($row['totalqty'])?$row['totalqty']:0;?></div>
                                    </div>
<!--                                </div>
                            </a>-->
                        </div>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="">
                    <div class="shlink"><a href="faqs.php#returnpolicy"><img src="images/policy-icon.png">Easy Return Policy</a></div>
                    <div class="shlink"><a href="faqs.php#ship"><img src="images/ship-icon.png">Free Shipping</a></div>
                    <div class="shlink"><a href="faqs.php#payments"><img src="images/cod-icon.png">Cash on Delivery</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end Header-->

<!--start menu-->
<!--<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="hmenu">
                <div id="navigation">-->
                    <div  style="color: #999999;font-size: 14px;width: 79.5%;margin-left: 123px; font-weight: bold; text-align: center;line-height: 30px;" >
                        
                            
                                <?php if(isset($categories) && !empty($categories)){
                                    foreach($categories as $key => $cat){
                                        ?>
                                        <div style="color: #999999;display: inline;padding: 10px; height:50px; margin-top: 5px;"><a href="product.php?catid=<?=$cat['id']?>"><?=$cat['categoryName']?></a></div>

                                    <?php }
                                } ?>
                            
                        
                    </div>


<!-- <div class="cn" style="position: relative; min-height: 115px;padding-right: 15px;padding-left: 15px;width: 79.5%; opacity: 2.3; margin-left:122px;border:0px solid;margin-top: 15px; background-color: rgba(107, 28, 176, 0.5);">
 </div>-->

<!--<div style=" position: relative;
    top: 0;
    left: 0;    
    height: 25%;
    z-index: 10;
    min-height: 115px;
    padding-right: 15px;
    padding-left: 15px;
    width: 79.5%; 
    margin-left:122px;
    border:0px solid #000;
    margin-top: 15px; 
    background-color: rgba(107, 28, 176, 0.5);"></div>-->
<!--<div class="prdbox" style="width:60%;border:0px solid;margin-left: 230px;margin-top: -92px;opacity: 2.3;filter: alpha(opacity=30);">-->
<?php if(!isset($_GET['pid']) && !isset($_GET['catid']) && $_SERVER['SCRIPT_URL'] !="/one-step-checkout.php" && !isset($_GET['ordid'])){
  ?>
<div style="background: rgba(0, 0, 0, -0.4);
  border-radius: 5px;
  box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.2); 
  width:79.6%;  
  margin-left: 120px;
  margin-top:35px;
  padding: 5px 20px 20px 20px;
  z-index: 10;
  text-align: justify;
  color: #ef400c;
  text-align: center;
  opacity: 0.0 - 1.0;
  font-size: 22px;
  background-image: url('assets/product/1532019008.jpg');
  background-repeat: no-repeat;
  background-position: left top;
  ">
               <strong>About us</strong> <br/><br/>
               We laid the foundation of our organization in the year 2001. “Gupta Sons”, is engaged in Manufacturing an array of Trumpet Horn, 
               Microphone Stand, Reflex Horn, Trumpet Tepar Nali etc. Our offered products are highly admired by the customers for their 
               flawless quality, low maintenance and longer service life. Apart from this, one can avail these products within the limited 
               period of time at reasonable prices.  We are backed by a competent and industrious team, which works hard for satisfying the v
               aried demands of our clients. <br>

               Under the unhindered guidance of our mentor, Mr. Asit Gupta, we set foot towards the pinnacle of success. His commitment to 
               provide the most advanced solutions to our clients on a continued basis is the motivation for us. Owing to his experience and 
               deep knowledge, we are increasing our reach in this domain.

            </div>
<?php } ?>
<!--                     #menu END-->
<!--                </div>
            </div>
        </div>
    </div>
</div>-->
<!--<div class="homebgblack" style="position: fixed;right: 0;bottom: 0;min-width: 100%;min-height: 100%;">
<iframe src="https://player.vimeo.com/video/234795466?background=1" width="100%" class="homepagevideo wow fadeIn hide-tablet" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" style="visibility: visible; animation-name: fadeIn;"></iframe>
</div>-->
<!--start menu-->