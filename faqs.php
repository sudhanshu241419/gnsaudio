<?php
include("header.php");
$faqtitle = new Faqtitle();
$column = array();
$where = " WHERE status='1' order by orderby";
$faqtitles = $faqtitle->get($column, $where);
?>
<!--start page title-->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="pagetilte">Home   >  FAQs </div>
        </div>
    </div>
</div>
<!--start page title-->
<!--start content page-->
<div class="container">
    <div class="row">
        <div class="col-lg-12 content">
            <div class="accountinfo_tilte">FAQs</div>

            <div class="col-lg-12">
                <div class="col-lg-2 col-sm-3"><img src="images/question.png" class="img-responsive"></div>
                <div class="col-lg-10 col-sm-9">
                    <ul class="faq_list">
                        <?php
                        if (!empty($faqtitles)) {
                            foreach ($faqtitles as $key => $valtitle) {
                                ?>
                                <li><a href="#<?php echo $valtitle['link']; ?>" ><?php echo $valtitle['title']; ?></a></li>
                            <?php }
                        } ?>
                    </ul>
                </div>
            </div>


            <div class="clearfix"></div>

            <br>
            <br>


            <?php
            $faq = new Faq();
            if (!empty($faqtitles)) {
                foreach ($faqtitles as $key => $value) {
                    $titleid = $value['id'];
                    $where = " WHERE status='1' and title_id='" . $titleid . "'";
                    $faqs = $faq->get($column, $where);
                    ?>
                    <h3 id="<?php echo $value['link']; ?>"><?php echo ucwords($value['title']); ?></h3>
                    <?php
                    foreach ($faqs as $k => $val) {
                        if ($val['question']) {
                            ?>
                            <div class="faqtitle"><?php echo $val['question']; ?></div>
                            <?php

                            }
                            echo $val['answer'];
                            }
                            }
                            ?>


                            <br>
                        <?php } ?>




        </div>
    </div>
</div>
<!--end content page-->
<?php include("footer.php");?>