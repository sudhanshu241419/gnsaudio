<?php
require('header.php');
$staticpages = new Staticpage();
$column = array();
?>

<!--start Product Cat-->




<div class="container">

    <div class="row">


<?php if($categories){ ?>
        <div class="col-lg-8 col-sm-8">
			
            <div class="prdbox">

                <div class="prdimg"><a href="product.php?catid=<?php echo $categories[0]['id'];?>"><img src="<?php echo $categories[0]['image'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $categories[0]['categoryName'];?></div>

                    <div class="prdqut">

                        <?php

                        $where = " WHERE  cid =".$categories[0]['id'];

                        $rows = $product->countRow($where);

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


        <div class="col-lg-4 col-sm-4">

            <div class="prdbox">
                <?php if(isset($categories) && !empty($categories)){
                                    foreach($categories as $key => $cat){
                                        ?>
                <div style="margin: 0 0 10px 25px; font-size: 12px;"><a href="product.php?catid=<?=$cat['id']?>"><strong><?= strtoupper($cat['categoryName'])?></strong></a></div>

                                    <?php }
                                } ?>

            </div>

        </div>
        
        
         <div class="col-lg-4 col-sm-4">

            <div class="prdbox">
               

                <div class="prdimg"><a href="product.php?catid=<?php echo $categories[1]['id'];?>"><img src="<?php echo $categories[1]['image'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $categories[1]['categoryName'];?></div>

                    <div class="prdqut">

                        <?php

                        $where = " WHERE  cid =".$categories[1]['id'];

                        $rows = $product->countRow($where);

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

<!--end Product Cat -->



<!--start Product Cat-->

<div class="container">

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

                        $rows = $product->countRow($where);

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



        <div class="col-lg-4 col-sm-4">

            <div class="prdbox">

                <div class="prdimg inprdimg"><a href="product.php?catid=<?php echo $categories[3]['id'];?>"><img src="<?php echo $categories[3]['image'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $categories[3]['categoryName'];?></div>

                    <div class="prdqut">

                        <?php

                        $where = " WHERE  cid =".$categories[3]['id'];

                        $rows = $product->countRow($where);

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



        <div class="col-lg-4 col-sm-4">

            <div class="prdbox">

                <div class="prdimg inprdimg"><a href="product.php?catid=<?php echo $categories[4]['id'];?>"><img src="<?php echo $categories[4]['image'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $categories[4]['categoryName'];?></div>

                    <div class="prdqut">

                        <?php

                        $where = " WHERE  cid =".$categories[4]['id'];

                        $rows = $product->countRow($where);

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

<!--end Product Cat -->







<!--start arrivals-->

<!--<div class="container arrival_box">

    <div class="row">

		<?php 

		if(!empty($newArrivalProduct)){

			foreach($newArrivalProduct as $key=>$newpro){

		?>

        <div class="col-lg-4 col-sm-4">

            <div class="prdbox">
<div class="arrival_title"> New Arrivals</div>
                <div class="prdimg inprdimg"><a href="product-detail.php?pid=<?php echo $newpro['id'];?>"><img src="<?php echo $newpro['image_small'];?>" class="img-responsive"></a></div>

                <div class="prdname_box">

                    <div class="prdname"><?php echo $newpro['productName'];?></div>

                    <div class="prdqut">Rs. <?php echo $newpro['price'];?></div>

                </div>

            </div>

        </div>

	<?php } } ?>

			

       

    </div>

</div>-->

<!--end arrivals -->









<!--start service-->

<!--<div class="container ser_box">

    <div class="row">



        <div class="col-lg-4 col-sm-4">

            <div class="bottom_box">

                <img src="images/story-akam.jpg " class="img-responsive">

                <div class="ser_cont">
					 <?php 
				   $where = " WHERE status='1' and pagename='story'";
				   $staticpage = $staticpages->select($column,$where);
				   if($staticpage){
				   echo $staticpage['0']['content'];
				   }else{
					echo "Comming soon....";
				   }
				   ?>
                  
                </div>

            </div>

        </div>



        <div class="col-lg-4 col-sm-4">

            <div class="bottom_box">

                <img src="images/Pyament.jpg" class="img-responsive">

                <div class="ser_cont">
					 <?php 
				   $where = " WHERE status='1' and pagename='payment'";
				   $staticpage = $staticpages->select($column,$where);
				   if($staticpage){
				   echo $staticpage['0']['content'];
				   }else{
					echo "Comming soon....";
				   }
				   ?>
                </div>

            </div>

        </div>



        <div class="col-lg-4 col-sm-4">

            <div class="bottom_box">

                <img src="images/Shipping-and-delivery.jpg" class="img-responsive">

                <div class="ser_cont">

                   <?php 
				   $where = " WHERE status='1' and pagename='shipping'";
				   $staticpage = $staticpages->select($column,$where);
				   if($staticpage){
				   echo $staticpage['0']['content'];
				   }else{
					echo "Coming soon....";
				   }
				   ?>

                </div>

            </div>

        </div>

    </div>

</div>-->

<!--end service -->













<!--start future-->

<div class="container futurebox">

    <div class="row">

        <div class="col-lg-4 col-sm-4">

            <div class="fut_box sky">

                <h4 class="fut_title"><img src="images/Free-Shipping-icon.png"> Free Shipping</h4>

                G N S  Orders over $49 ship free. DESIGNER DIRECT items ship directly from our global network of designers and incur a small shipping charge.

            </div>

        </div>



        <div class="col-lg-4 col-sm-4">

            <div class="fut_box parpal">

                <h4 class="fut_title"><img src="images/Smile-icon.png"> Smile Guarantee</h4>

                We promise you'll love it. <br>

                If you don't, we'll fix it.

            </div>

        </div>





        <div class="col-lg-4 col-sm-4">

            <div class="fut_box orng">

                <h4 class="fut_title"><img src="images/Free-Returns-icon.png">Free Returns</h4>

                We want you to love your purchase. If you don't, send it back (for free) and get your money back. No questions asked. </div>

        </div>







    </div>

</div>

<!--end future-->

<?php require('footer.php');?>