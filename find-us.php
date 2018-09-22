<?php 
include("header.php");
$staticpages = new Staticpage();
$column = array();
$where = " WHERE status='1' and pagename='findus'";
$staticpage = $staticpages->select($column,$where);
?>

<!--start page title-->
<?php if(!empty($staticpage)){ ?>
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="pagetilte">Home   >  <?php echo $staticpage[0]['title'];?> </div>
</div>
</div>
</div>
<!--start page title-->

<!--start content page-->
<div class="container">
<div class="row">
<div class="col-lg-12 content">
<div class="accountinfo_tilte"><?php echo $staticpage[0]['title'];?> </div>

<?php echo $staticpage[0]['content'];?>

</div>
</div>
</div>
<!--end content page-->
<?php } ?>
<?php include("footer.php");?>




