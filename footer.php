<script src="js/bootstrap.min.js"></script>

<script src="js/registration.js"></script>

<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: 321934101297868,
            cookie: true, // enable cookies to allow the server to access
            // the session
            xfbml: true, // parse social plugins on this page
            version: 'v2.0' // use version 2.0
        });
    };

    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script>
    function chageSize(pid, size) {
        window.location = "product-detail.php?pid=" + pid + "&size=" + size;
    }

    /*Update cart*/
    function changeQuantity(itemid, qty) {

        if (qty == 0 || qty == "") {
            //alert("Quantity required");
            return false;
        } else {
            str = "";
            $.post("addtocart.php", {itemid: itemid, qty: qty, action: "qtyupdate", rand: Math.random()}, function (data) {
                response = JSON.parse(data);
                if (response.error == 0) {

                    $("#subtotala_" + itemid).replaceWith("<td class='mycarsubtotal' id='subtotala_" + itemid + "'>" + response.subtotal + "</td>");

                    str += '<div class="grandtotalbox">';
                    str += '<span class="grandtotalcont">Grand Total:</span>';
                    str += 'RS ' + response.grandtotal + '</div>';
                    $(".grandtotal .grandtotalbox").replaceWith(str);
                    $('.mycartqty').replaceWith("<a href='#' class='mycartqty' data-toggle='modal' data-dismiss='modal' data-target='.bs-example-modal-mycart' data-qty='" + parseInt(response.dataqty) + "' data-total='" + response.grandtotal + "'><div class='col-lg-2 col-sm-5 crtb'><div class='cartbox'><div class='cart_cont'>Cart </div><div class='cart_qty'>" + parseInt(response.dataqty) + "</div></div></div></a>");
                } else if (response.error == 1) {
                    alert(response.msg);
                }
            });
        }
    }
    /*delete Item from cart*/
    function deleteCartItem(pid, grandtotal, subtotal, qty) {

        if (confirm("Are you sure delete item")) {            
            $.post("addtocart.php", {itemid: pid, action: "delete", rand: Math.random()}, function (data) {
                response = JSON.parse(data);
                if (response.msg == "yes") {
                    var grandTotal = grandtotal - subtotal;
                    var totaldataqty = $(".mycartqty").attr("data-qty");
                    var dataqty = totaldataqty - qty;
                    $("div #mc_" + pid).remove();
                    $("div #sepreater_" + pid).remove();
                    $('.mycartqty').replaceWith("<a href='#' class='mycartqty' data-toggle='modal' data-dismiss='modal' data-target='.bs-example-modal-mycart' data-qty='" + parseInt(response.qty) + "' data-total='" + grandTotal + "'><div class='col-lg-2 col-sm-5 crtb'><div class='cartbox'><div class='cart_cont'>Cart </div><div class='cart_qty'>" + parseInt(response.qty) + "</div></div></div></a>");
                    $(".grandtotal .grandtotalbox").replaceWith("<div class='grandtotalbox'><span class='grandtotalcont'>Grand Total:</span>RS " + grandTotal + "</div>");
//                    if (grandTotal > 0) {
//                    } else {
//                        $(".mycartcheck").hide();
//                        $(".mycarttable").hide();
//                        $(".grandtotal").hide();
//                        $("#emptymsg").show();
//
//                    }


                } else {
                    alert("Item not deleted");
                }
            })
        }
    }
//After search data click on zoom icon for product detail
    function getProductDetailOnZoomIcon(productId) {
    
        if (productId) {
            $.post("getProductDetail.php", {productId: productId, rand: Math.random()}, function (data)
            {
                if (data) {
                    response = JSON.parse(data);

                    if (response.msg == "success") {
                        $('.pname').html(response.productName);
                        $('.moredetail').html('<a style="color:#333333;font-weight:bold;font-size:10px" href="product-detail.php?pid=' + response.id + '">+View More Detail</a>');
                        $('.pdescription').html('<div style="font-weight:bold;">Description </div><div style="margin-left:5px">' + response.description + "</div></div>");
                        $('.pprice').html("<div style='font-size:9px'>Price Per Unit</div><div style='font-size:25px;'> Rs " + response.price + "</div><div style='font-size:9px;'>Inc Tax</div>");
                        $('.proimg').html('<img src="' + response.image + '" width="317px" height="275px" class="img-responsive" />');
                        $('#pid').val(response.id);
                        $('#productName').val(response.productName);
                        $('#price').val(response.price);
                        $('#description').val(response.description);
                        $('#image').val(response.image);
                        $('#pcode').val(response.size + " - " + response.product_code)
                    } else {
                        $('.notfindproduct').html(response.error);
                    }

                }

            });
        } else {
            return false;
        }
    }

    (function ($) {
        $(function () {
            //News letter subscription Get it fast
            $("#getitfast").on("click", function () {
                var email = $("#subscriptionEmail").val();
                var atpos = email.indexOf("@");
                var dotpos = email.lastIndexOf(".");
                if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
                    $('.getItFastAlert').modal('show');
                    return false;
                }
                $.post("getitfast.php", {email: email, rand: Math.random()}, function (data)
                {
                    if (data == "success") {
                        $('.getItFastModal').modal('show');
                        $("#subscriptionEmail").val('');
                    } else {
                        $('.getItFastModalError').modal('show');
                    }
                })

            });

            //One step checkout Registration
            $("#submitonestepcheckout").on("click", function () {
                var data = $('#onestepcheckoutfrm').serialize() + "&rand=" + Math.random()+"";
                $.post("one-step-checkoutsubmit.php", data, function (data) {
                    response = JSON.parse(data);
                    if (response.result == "error") {
                        $(".msgbox").text("Error:" + response.msg);
                    } else if (response.result == "success") {
                        $(".msgbox").text("Success:" + response.msg);
                        $("#userdetail").val(data);
                        $("#asktoregister").remove();
                        $('<input type="submit" value="Countinue to Payment">').appendTo(".continueToPayment");
                    }
                })

            });

            //Product detail on zoom icon
            $('a[id^="pdetailonzoomicon"]').on("click", function () {
                var productId = $(this).attr("relid");
               
                $.post("getProductDetail.php", {productId: productId, rand: Math.random()}, function (data)
                {
                    if (data) {
                        response = JSON.parse(data);
                        
                        if (response.msg == "success") {
                           
                            $('.pname').html(response.productName);
                           // $('.moredetail').html('<a style="color:#333333;font-weight:bold;font-size:10px" href="product-detail.php?pid=' + response.id + '">+View More Detail</a>');
                            
                            $('.pprice').html("<span style='float:left;font-size:18px;'>Price Per Unit </span><span style='float:left;margin-left:10px;font-size:18px;'>: </span><span style='float:left;margin-left:10px;font-size:15px;'>Rs " + response.price + "</span>");
                            $('.proimg').html('<img src="' + response.image + '" width:200px;height:250px; class="img-responsive" />');
                            $('.despription').html("<span style='float:left; font-size:18px;'>Description</span><span style='float:left;margin-left:24px;margin-right:12px;font-size:18px;'> : </span><span style='float:left;font-size:15px;'>" + response.description + "</span>");
                            
                            $('#pid').val(response.id);
                            $('#productName').val(response.productName);
                            $('#price').val(response.price);
                            $('#description').val(response.description);
                            $('#image').val(response.image);
                            $('#pcode').val(response.size + " - " + response.product_code)
                        } else {
                            $('.notfindproduct').html(response.error);
                        }

                    }

                });
                //return false;
            });
            //End product detail on zoom icon

            //my cart increase quantity
            $("#plus0ne").on("click", function () {
                var qty = $("#qty").val();
                var x = 1;
                var totalQty = parseInt(qty) + parseInt(x);
                $("#qty").val(totalQty);
            });

            $("#minusOne").on("click", function () {
                var qty = $("#qty").val();
                if(qty > 50){
                    var x = 1;
                    var totalQty = qty - x;
                    $("#qty").val(totalQty);
                }
            });

            //change password
            $("#changepassword").submit(function () {

                var newpassword = $("#newpassword").val();
                var confirmpassword = $("#confirmpassword").val();
                var oldpassword = $("#oldpassword").val();

                $.post("changepassword.php", {newpassword: newpassword, confirmpassword: confirmpassword, oldpassword: oldpassword, rand: Math.random()}, function (data)
                {

                    if (data) {
                        response = JSON.parse(data);

                        if (response.msg == "success") {
                            $("#msgpassword").html("Your passsword has been changed successfully").css("color", "green");
                        } else {
                            $("#msgpassword").html(response.msg).css("color", "red");
                        }
                        $('#newpassword').val("");
                        $('#oldpassword').val("");
                        $('#confirmpassword').val("");
                    }

                });
                return false;
            });
            //End change password

            // if there is no item in cart
            $(".mycartqty").on("click", function () {
                var dataqty = $(this).attr('data-qty');
                if (dataqty == 0) {
                    $(".mycarttable").hide();
                    $(".mycartcheck").hide();
                    $(".grandtotal").hide();
                    $("#emptymsg").show();
                } else {
                    $.post("addtocart.php", {rand: Math.random()}, function (data)
                    {
                        //console.log(data);

                        if (data == "no") { //if correct login detail
                            $(".mycarttable").hide();
                            $(".mycartcheck").hide();
                            $(".grandtotal").hide();
                            $("#emptymsg").show();
                        } else {
                            var str = "";
                            //var dataObj = jQuery.parseJSON( data );
                            response = JSON.parse(data);
                            var grandTotal = 0;
                            var totalQty = 0;
                            $.each(response, function (i, item) {

                                grandTotal = parseInt(grandTotal) + parseInt(item.subTotal);
                                str += '<tr id="mc_' + item.pid + '">';
                                str += '<td class="mycartimg"><img src="' + item.image + '" /></td>';
                                str += '<td class=""><input type="text" id="qtyb_' + item.pid + '" style="width:40px" value="' + item.qty + '" onkeyup="changeQuantity(' + item.pid + ',this.value)"/></td>';
                                str += '<td class="mycartprice">' + item.price + '</td>';
                                str += '<td> <strong>Free</strong><br /> <span>Delivered in 2-3 business days.</span></td>';
                                str += '<td class="mycarsubtotal" id="subtotala_' + item.pid + '">' + item.subTotal + '</td>';
                                str += '<td class="mycarprdremove"><a href="#" onclick="deleteCartItem(' + item.pid + ',' + grandTotal + ',' + item.subTotal + ',' + item.qty + ')"><img src="images/delete.png"></a></td>';
                                str += '</tr>';
                                $('#mc_' + item.pid).remove();



                            });
                            $(str).appendTo(".mycartrecord");
                            $(".grandtotal .grandtotalbox").replaceWith("<div class='grandtotalbox'><span class='grandtotalcont'>Grand Total:</span>RS " + grandTotal + "</div>");
                            if (grandTotal > 0) {
                            } else {
                                $(".mycartcheck").hide();
                            }

                        }

                    });

                }//end if

            });

            //Add to cart
            //$('a[id^="addcart"]').on("click", function () {
            $("#addcart").on("click", function () {
                var qty = $("#qty").val();
                var pid = $("#pid").val();
                var pcode = $("#pcode").val();
             
                var productName = $("#productName").val();
                var itemPrice = $("#price").val();
                var description = $("#description").val();
                var image = $("#image").val();
                var str = '';
                //to show in header shoping cart
                cartsubtotal = parseInt(qty) * parseInt(itemPrice);
                var dataqty = $(".mycartqty").attr('data-qty');
                dataqty = parseInt(dataqty) + parseInt(qty);
                var datatotal = $(".mycartqty").attr('data-total');
                datatotal = parseInt(datatotal) + parseInt(cartsubtotal);
                $('.mycartqty').replaceWith("<a href='#' class='mycartqty' data-toggle='modal' data-dismiss='modal' data-target='.bs-example-modal-mycart' data-qty='" + dataqty + "' data-total='" + datatotal + "'><div class='col-lg-2 col-sm-5 crtb'><div class='cartbox'><div class='cart_cont'>Cart </div><div class='cart_qty'>" + dataqty + "</div></div></div></a>");

                $.post("addtocart.php", {productName: productName, price: itemPrice, description: description, image: image, quantity: qty, productid: pid, productcode: pcode, rand: Math.random()}, function (data)
                {
                    //console.log(data);

                    if (data == "no") { //if correct login detail
                        $(".mycarttable").hide();
                        $(".mycartcheck").hide();
                        $(".grandtotal").hide();
                        $("#emptymsg").show();
                    } else {
                        $(".mycartcheck").show();
                        $(".mycarttable").show();
                        $(".grandtotal").show();
                        $("#emptymsg").hide();
                        //var dataObj = jQuery.parseJSON( data );
                        response = JSON.parse(data);
                        var grandTotal = 0;
                        var totalQty = 0;
                        $.each(response, function (i, item) {
                            grandTotal = parseInt(grandTotal) + parseInt(item.subTotal);
                            str += '<tr id="mc_' + item.pid + '">';
                            str += '<td class="mycartimg"><img src="' + item.image + '" /></td>';
                            str += '<td class=""><input type="text" id="qtyb_' + item.pid + '" style="width:40px" value="' + item.qty + '" onkeyup="changeQuantity(' + item.pid + ',this.value)"/></td>';
                            str += '<td class="mycartprice">' + item.price + '</td>';
                            str += '<td> <strong>Free</strong><br /> <span>Delivered in 2-3 business days.</span></td>';
                            str += '<td class="mycarsubtotal" id="subtotala_' + item.pid + '">' + item.subTotal + '</td>';
                            str += '<td class="mycarprdremove"><a href="#" onclick="deleteCartItem(' + item.pid + ',' + grandTotal + ',' + item.subTotal + ',' + item.qty + ');"><img src="images/delete.png"></a></td>';
                            str += '</tr>';
                            $('#mc_' + item.pid).remove();




                        });
                        $(str).appendTo(".mycartrecord");
                        $(".grandtotal .grandtotalbox").replaceWith("<div class='grandtotalbox'><span class='grandtotalcont'>Grand Total:</span>RS " + grandTotal + "</div>");
                        if (grandTotal > 0) {
                        } else {
                            $(".mycartcheck").hide();
                        }

                    }

                });
            });
            //Beging search here
            $("#sprice").on("change", function () {
                var price = $(this).val();
                var currentUrl = $(location).attr('href');
                var size = $("#ssize").val();
                var material = $("#smaterial").val();
                var catid = $("#catid").val();
                $.post("search.php", {catid: catid, price: price, size: size, material: material, rand: Math.random()}, function (data)
                {
                    response = JSON.parse(data);
                    if (response.msg == "success") {
                        product = response.data;
                        $("#product").html(product);
                    } else if (response.msg == "fail") {
                        $("#product").html(response.error);
                    }
                });
            });
            $("#ssize").on("change", function () {
                var size = $(this).val();
                var currentUrl = $(location).attr('href');
                var price = $("#sprice").val();
                var material = $("#smaterial").val();
                var catid = $("#catid").val();
                $.post("search.php", {catid: catid, price: price, size: size, material: material, rand: Math.random()}, function (data)
                {
                    response = JSON.parse(data);
                    if (response.msg == "success") {
                        product = response.data;
                        $("#product").html(product);
                    } else if (response.msg == "fail") {
                        $("#product").html(response.error);
                    }
                });
            });
            $("#smaterial").on("change", function () {
                var material = $(this).val();
                var currentUrl = $(location).attr('href');
                var size = $("#ssize").val();
                var price = $("#sprice").val();
                var catid = $("#catid").val();
                $.post("search.php", {catid: catid, price: price, size: size, material: material, rand: Math.random()}, function (data)
                {
                    response = JSON.parse(data);
                    if (response.msg == "success") {
                        product = response.data;
                        $("#product").html(product);
                    } else if (response.msg == "fail") {
                        $("#product").html(response.error);
                    }
                });
            });
            //End search here

            //Facebook login
            $("#flogin img").on("click", function () {
                FB.login(function (response) {
                    if (response.authResponse) {
                        // console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me', function (response) {
                            //console.log(response);
                            //console.log('Good to see you, ' + response.name + response.email+response.first_name+response.id+'.');
                            $.post("registration.php", {user_name: response.first_name, email: response.email, fbUID: response.id, rand: Math.random()}, function (data)
                            {
                                if (data == 'yes') { //if correct login detail
                                    window.location = "http://www.gnsaudios.in/";
                                } else {
                                    alert("Your facebook login is suck! You have already register with web site... ");
                                }

                            });

                        });
                    } else {
                        alert('User cancelled login or did not fully authorize.');
                    }
                }, {scope: 'email,user_likes'});
            });
        });

    })(jQuery);

</script>
<script src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="js/cloud-zoom.1.0.3.min.js"></script>
<link href="css/cloud-zoom.css" type="text/css" rel="stylesheet" />
<!--start footer-->
<div class="footer hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-3 footerbox">
                <h3>Shop</h3>
                <ul class="list-unstyled flink">
                    <?php
                    if (isset($categories) && !empty($categories)) {
                        foreach ($categories as $key => $cat) {
                            ?>
                            <li><a href="product.php?catid=<?php echo $cat['id']; ?>"><?php echo $cat['categoryName']; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                    <!--<li><a href="#">Deals</a></li>-->
                </ul>
            </div>


            <div class="col-lg-2 col-sm-2 footerbox">
                <h3>Services</h3>
                <ul class="list-unstyled flink">
                    <li><a href="faqs.php">FAQ's</a></li>
                    <li><a class="jumper" href="faqs.php#ship">Shipping</a></li>
                    <li><a class="jumper" href="faqs.php#cancel">Cancellation</a></li>
                    <li><a class="jumper" href="faqs.php#returnpolicy">Returns</a></li>
                    <li><a class="jumper" href="faqs.php#privacypolicy">Privacy</a></li>
                    <li><a class="jumper" href="faqs.php#terms">Terms of Use</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-sm-3 footerbox">
                <h3>My Account</h3><?php if ($userId) { ?>
                    <ul class="list-unstyled flink">
                        <li><a href="account.php">Dashboard</a></li>
                        <li><a href="billing-shipping.php">Billing & Shipping</a></li>
                        <li><a href="my-coupons.php">My Coupons</a></li>
                        <li><a href="order.php">Orders</a></li>

                    </ul>
<?php } else { ?>
                    <ul class="list-unstyled flink">
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >Dashboard</a></li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >Billing & Shipping</a></li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >My Coupons</a></li>
                        <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-login" >Orders</a></li>

                    </ul>
<?php } ?>
            </div>

            <div class="col-lg-3 col-sm-3 footerbox hide">
                <h3>Payment Methods</h3>
                <img src="images/payment-option.png" class="img-responsive">
            </div>

            <div class="col-lg-3 col-sm-3 footerbox">
                <h3>Get It Fast</h3>
                You're just one step away from receiving
                fresh Happy Modern Designs and special
                offers in your inbox.
                <div class="subcrib">
                    <input type="text" class="form-control" id="subscriptionEmail" style="width:170px">
                    <input type="submit" id="getitfast">
                </div>
                <div style="padding:10px; clear:both;">
                    <div class="fb-like-box" data-href="https://www.facebook.com/pages/Akam-India/327408467419755" data-colorscheme="light" data-show-faces="false" data-header="true" data-stream="false" data-show-border="true"></div>                </div>
            </div>


        </div>


        <div class="clearfix"></div>
        <div class="row fgraybox">
            <div class="col-lg-8 col-sm-8 ">
                <ul class="grylink">
                    <li><a href="<?pph echo SITE_URL?>">Home</a></li>
                    <li><a href="about-us.php">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="find-us.php">Find us</a></li>
                    <li><a href="wholesale.php">Wholesale</a></li>
                    <li><a href="career.php">Career</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-sm-4 socialicon">
                Connect with
                <a href="https://www.facebook.com/people/Akam-India/100006391607292" target="_blank"><img src="images/facebook-icon.png"></a>
                <a href="#"><img src="images/twiiter-icon.png"></a>
                <a href="#"><img src="images/rss-icon.png"></a>
                <a href="#"><img src="images/youtub-con.png"></a>
            </div>

        </div>




    </div>
</div>
<!--end footer-->

<!--start footer copy-->
<div class="footercopy">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">Copyright &copy; 2014 G N S, All rights Reserved  </div>
        </div>
    </div>
</div>
<!--end footer copy-->

<!--Get it fast modal -->
<div class="poplogin_form">
    <div class="modal fade getItFastModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div style="text-align:center;font-weight:bold">Thank you for your subscription </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--get it fast error-->
<div class="poplogin_form">
    <div class="modal fade getItFastModalError" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div style="text-align:center;font-weight:bold">You are not register for subscription. Try again.. </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--Get it fast email alert error-->
<div class="poplogin_form">
    <div class="modal fade getItFastAlert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div style="text-align:center;font-weight:bold">Email is not valid </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--start login form-->

<div class="poplogin_form">
    <div class="modal fade bs-example-modal-login" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="mySmallModalLabel" class="modal-title text-center"><img src="images/djstand.jpg" height="200" width="150"> <br><span class="redfont">Shop at <?php echo SITE_URL; ?></span></h4>
                </div>
                <div class="loginbox">
                    <div class="logintitle">Login </div>
                    <!--<div class="loginface" id="flogin"><img src="images/login-facbook.png"><br>or </div>-->

                    <form role="form" name="loginfrm" id="loginfrm" action="" method="post">
                        <div id="msgboxl"></div>
                        <div class="form-group">
                            <input type="email" name="uemail" id="uemail" class="form-control" placeholder="Enter Your Email Address here">
                        </div>

                        <div class="form-group">
                            <input type="password" name="upassword" id="upassword" class="form-control" placeholder="Enter Your  Password here">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Login Now">
                        </div>

                    </form>

                    <a href="#" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-fpassword"><strong>Forgot Password</strong></a>&nbsp;|&nbsp;<a href="#" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-registration"><strong>Register</strong></a>
                </div>

            </div>
        </div>
    </div>

</div>

<!--end login form-->

<!--forgot Passsword-->
<div class="poplogin_form">
    <div class="modal fade bs-example-modal-fpassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="mySmallModalLabel" class="modal-title text-center"><img src="images/djstand.jpg" height="200" width="150"> <br><span class="redfont">Shop at <?php echo SITE_URL ?></span></h4>
                </div>
                <div class="loginbox">
                    <div class="logintitle">Forgot Password </div>


                    <form role="form" name="forgotpassfrm" id="forgotpassfrm" action="" method="post">
                        <div id="msgboxl"></div>
                        <div class="form-group">
                            <input type="email" name="fuemail" id="fuemail" class="form-control" placeholder="Enter Your Email Address here">
                        </div>



                        <div class="form-group">
                            <input type="submit" class="form-control" value="Submit">
                        </div>

                    </form>

                    Login now? <a href="#" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-login"><strong>Click Here</strong></a>
                </div>

            </div>
        </div>
    </div>

</div>


<!--End forgot password-->

<!--change Password-->
<div class="poplogin_form">
    <div class="modal fade bs-example-modal-changepassword" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="mySmallModalLabel" class="modal-title text-center"><img src="images/djstand.jpg" height="200" width="150"> <br><span class="redfont">Shop at <?php echo SITE_URL ?></span></h4>
                </div>
                <div class="loginbox">
                    <div class="logintitle">Change Password </div>


                    <form role="form" name="changepassword" id="changepassword" action="" method="post">
                        <div id="msgpassword"></div>
                        <div class="form-group">
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control" placeholder="Enter Your Old Password here">
                        </div>

                        <div class="form-group">
                            <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="Enter Your New Password here">
                        </div>

                        <div class="form-group">
                            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Enter Your Confirm Password here">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Submit">
                        </div>

                    </form>


                </div>

            </div>
        </div>
    </div>

</div>
<!--End changepassword>

<!--start register form-->

<div class="poplogin_form">
    <div class="modal fade bs-example-modal-registration" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="mySmallModalLabel" class="modal-title text-center"><img src="images/djstand.jpg" height="200" width="150"> 
                        <br><span class="redfont"> <h3>Shop at GNS GUPTA &amp; SONS</h1></span></h4>
                </div>
                <div class="loginbox">
<!--                    <div class="logintitle">Sign Up Now and Get <span class="redfont">Rs.1000</span> * Off </div>-->
<!--                    <div class="loginface" id="flogin"><img src="images/login-facbook.png"><br>or </div>-->

                    <form role="form" name ="registrationfrm" id="registrationfrm" method="post" action="" >
                        <div id="msgboxr"></div>
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name">
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email Address here">
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" id="password"  class="form-control" placeholder="Create Your  Password here">
                        </div>
                        
                        <div class="form-group">
                            <input type="password" name="cnfpassword" id="cnfpassword"  class="form-control" placeholder="Enter confirm password">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Sign up Now">
                        </div>

                    </form>

                    Already a member?<a href="#" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-login" ><strong>Login Now</strong></a>

                </div>

            </div>
        </div>
    </div>

</div>

<!--end register form-->

<!--Notify me--->
<div class="poplogin_form">
    <div class="modal fade bs-example-modal-notyfyme" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div class="logintitle">Notify Me </div>                    
                    <div id="notifymemsg"></div>
                    <form role="form" name ="notyfymefrm" id="notyfymefrm" method="post" action="" >
                        <input type="hidden" name="pid" id="notifypid" value="<?php echo (isset($_GET['pid'])) ? (int) $_GET['pid'] : ""; ?>">

                        <div class="form-group">
                            <input type="email" name="email" id="notifyemail" class="form-control" placeholder="Enter Your Email Address here">
                        </div>
                        <div class="form-group">
                            <input type="phone" name="contact" id="notifycontact" class="form-control" placeholder="Enter Your Contact Number">
                        </div>

                        <div class="form-group">
                            <textarea name="description" id="notifydescription" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Notify Me">
                        </div>

                    </form>



                </div>

            </div>
        </div>
    </div>

</div>

<!--End Notify me--->

<!--email to friend-->
<div class="poplogin_form">
    <div class="modal fade bs-example-modal-emailtofriend" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div class="logintitle">Email to friend </div>                    
                    <div id="emailtofriendmsg"></div>
                    <form role="form" name ="friendemailfrm" id="friendemailfrm" method="post" action="" >
                        <input type="hidden" name="pid" id="emailtofriendpid" value="<?php echo (isset($_GET['pid'])) ? (int) $_GET['pid'] : ""; ?>">
                        <input type="hidden" name="size" id="emailtofriendpsize" value="<?php echo (isset($_GET['size'])) ? (int) $_GET['size'] : ""; ?>">


                        <div class="form-group">
                            Friend Email
                        </div>

                        <div class="form-group">
                            <textarea name="friendemail" id="friendemail" class="form-control"></textarea><span style="color:#333333;font-size:10px;">Ex: email@gmail.com, abc@gmail.com</span>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Send Mail">
                        </div>

                    </form>



                </div>

            </div>
        </div>
    </div>

</div>

<!--End email to friend--->


<!--enquiry-->

<div class="poplogin_form">
    <div class="modal fade bs-example-modal-enquiry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">

                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>

                </div>
                <div class="loginbox">
                    <div class="logintitle">Enquiry </div>                    
                    <div id="enquirymsg"></div>
                    <form role="form" name ="enquiryfrm" id="enquiryfrm" method="post" action="" >
                        <input type="hidden" name="enquirypid" id="enquirypid" value="<?php echo (isset($_GET['pid'])) ? (int) $_GET['pid'] : ""; ?>">

                        <div class="form-group">
                            <input type="email" name="email" id="enquiryemail" class="form-control" placeholder="Enter Your Email Address here">
                        </div>
                        <div class="form-group">
                            <input type="phone" name="contact" id="enquirycontact" class="form-control" placeholder="Enter Your Contact Number">
                        </div>

                        <div class="form-group">
                            <textarea name="description" id="enquirydescription" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <input type="submit" class="form-control" value="Enquiry">
                        </div>

                    </form>



                </div>

            </div>
        </div>
    </div>

</div>

<!---End enquiry-->

<!--My Cart-->
<div class="mycartbox" >
    <div class="modal fade bs-example-modal-mycart" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm"  >
            <div class="modal-content">
                <div class="modal-header" style="height:50px;">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 id="mySmallModalLabel" class="modal-title">SHOPPING CART</h4>
                </div>

                <div class="mycarttable">
                    <div class="table-responsive">               
                        <table class="table table-bordered table-striped mycartrecord">
                            <tr>
                                <th width="15%">Item</th>
                                <th width="10%">Qty</th>
                                <th width="10%">Price</th>
                                <th width="25%">Delivery Details</th>
                                <th width="7%">Subtotal</th>
                                <th width="3%">Remove</th>
                            </tr>
                        </table>

                    </div></div>
                <div style="display:none;font-weight:bold;text-align:center;color:red;" id="emptymsg"><h2>There are no items in this cart.</h2></div>
                <div class="cartdata">
                    <div class="grandtotal">
                        <div class="grandtotalbox">
                            <span class="grandtotalcont">Grand Total:</span><span id="gtotal">RS 00.00</span>
                        </div>
                    </div>

                    <div class="mycartbtmbox">
                        <div class="col-lg-4 shopmore"><a href="<?php echo SITE_URL ?>" class="graybuttonbig">Shop More</a></div>
                        <div class="col-lg-3 mycartcheck"><a href="one-step-checkout.php" class="buttonbig">Checkout</a></div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<!--End cart-->

<!--Product Detail on Zoom Icon-->
<div class="prdzoom_icon">
    <div class="modal fade bs-example-modal-productdetail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="height:50px;">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>


                <div class="row">
                    <div class="col-lg-5" >
                        <div class="imglarg proimg" style="width:200px;height:250px;background: rgba(0, 0, 0, -0.4); border-radius: 5px;box-shadow: 0px 2px 18px 14px rgba(0,0,0,0.2); margin-left: 20px;"></div>
                    </div>
<!--                    
                        <div style="height:30px;margin-bottom: 8px;border-bottom: 1px solid #000000;width: 413px;">                           
                        <span style="float:left;margin-left:10px;font-size:15px;" class='pname'><?php echo $product[0]['productName']; ?></span></div>
                        <div style="float:left;height:30px;margin-bottom: 8px;border-bottom: 1px solid #000000;width: 413px;"><span style="float:left;font-size:18px;">Price </span><span style="float:left;margin-left:10px;font-size:18px;">: </span><span style="float:left;margin-left:10px;font-size:15px;">Rs. <?php echo $product[0]['price']; ?>/per</span></div>
                        <div style="float:left;height:30px;margin-bottom: 8px;width: 413px;"><span style="float:left; font-size:18px;">Description</span><span style="float:left;margin-left:10px;font-size:18px;"> : </span><span style="float:left;margin-left:10px;font-size:15px;"><?php echo $product[0]['description']; ?></span></div>
                        
                    </div>-->
                    <div style="margin-top: -4px; margin-bottom: 20px; width: 381px; margin-left: 300px; position: absolute;" >
                        <div class="pname" style="float:left;height:30px;margin-bottom: 8px;border-bottom: 0px solid #000000;width: 413px;"></div>
                        <div class="pprice" style="float:left;height:30px;margin-bottom: 8px;border-bottom: 0px solid #000000;width: 413px;"></div>
                        <div class="despription" style="float:left;height:30px;width: 413px;"></div>
                   </div>
                        
                    <div class="col-lg-7 col-sm-7 col-md-7" style="margin-top:205px;">                        
                        <div class="row prddtailp_sizebox" style="margin-left: 20px;">
                            <div class="col-lg-3 col-sm-3 col-md-3 col-xs-3 prddtailp_sizename">Quantity</div>
                            <div class="col-lg-3 col-sm-3 col-md-3">
                                <div class="prdaddboxn">
                                    <div class="prdaddopt" id="minusOne" style="cursor:pointer">-</div>
                                    <div class="prdaddopt_int"><input type="text" value="50" id="qty"></div>
                                    <div class="prdaddopt" id="plus0ne" style="cursor:pointer">+</div>
                                </div>
                            </div>
                        </div>

                        <div class="row prddtailp_addbox" style="margin-left: 10px;">
                            <div class="col-lg-6 col-sm-6 col-md-6 prdaddcart"><a href="#" class="button">Enquiry</a></div>
                            <div class="col-lg-6 col-sm-6 col-md-6 prdaddcart"><a href="#" id="addcart" class="button" data-toggle="modal" data-dismiss="modal" data-target=".bs-example-modal-mycart">Add to Cart</a></div>
                        </div>
                        <form name="productDetailFrm" id="productDetailFrm" method="post">
                            <input type="hidden" id="pid" value="<?php echo $product[0]['id']; ?>">
                            <input type="hidden" id = "productName" value="<?php echo $product[0]['productName']; ?>">
                            <input type="hidden" id = "price" value="<?php echo $product[0]['price']; ?>">
                            <input type="hidden" id = "description" value="<?php echo $product[0]['description']; ?>">
                            <input type="hidden" id = "image" value="<?php echo $product[0]['image_small']; ?>">
                            <input type="hidden" id="pcode" value="<?php echo $product[0]['size'] ?> - <?php echo $product[0]['product_code'] ?>">
                        </form>



                    </div>




                </div>


                <div class="row pshlinkbox">
                    <div class="col-lg-12">	
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#payments"><img src="images/cod-icon.png">Cash on Delivery</a></div>
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#ship"><img src="images/ship-icon.png">Free Shipping</a></div>
                        <div class="shlink p_shlink graybutton"><a href="faqs.php#returnpolicy"><img src="images/policy-icon.png">Easy Return Policy</a></div>

                    </div>

                </div>



            </div>
        </div>
    </div>

</div>

<!--End product detail on Zoom Icon-->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
