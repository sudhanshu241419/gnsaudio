<?php

session_start();
require("config/config.php");
$addtocart = new AddToCart();
$session = new Session();
$userId = $session->getUserId();
$guiestsession = new Guiestsession();
$guiestId = $guiestsession->getUserId();
$product = new Product();
$sessionId = session_id();

//Update cart
if (isset($_POST['action']) && $_POST['action'] == "qtyupdate") {
    $itemid = isset($_POST['itemid']) ? (int) $_POST['itemid'] : 0;
    $qty = isset($_POST['qty']) ? (int) $_POST['qty'] : 0;
    $removeprice = 0;
    $updateprice = 0;
    $grandprice = 0;
    $dataqty = 0;
    if (isset($qty) && $qty > 0) {
        $where = " WHERE sessionId='" . $sessionId . "' and status='pendding'";
        $column = array();
        $myCartData = $addtocart->getData($column, $where);
        $totalprice = 0;
        foreach ($myCartData as $key => $val) {
            if ($val['id'] == $itemid) {
                $removeprice = $val['itemPrice'] * $val['qty'];
                $updateprice = $val['itemPrice'] * $qty;
                $removeqty = $val['qty'];
            }
            $totalprice = $totalprice + ($val['itemPrice'] * $val['qty']);
            $dataqty = $dataqty + $val['qty'];
        }

        $grandprice = $totalprice - $removeprice;
        $grandprice = $grandprice + $updateprice;
        $dataqty = $dataqty - $removeqty;
        $dataqty = $dataqty + $qty;

        $w = " WHERE sessionId='" . $sessionId . "' and status='pendding' and id=" . $itemid;
        $c = array('qty' => $qty);
        $addtocart->updateTempMyCart($c, $w);
        $response = array("error" => "0", "grandtotal" => $grandprice, "subtotal" => $updateprice, 'dataqty' => $dataqty);
    } else {
        $response = array("error" => "1", "msg" => "Quantity is not valid");
    }
    echo json_encode($response);
    exit;
}


//Delete cart
if (isset($_POST['action']) && $_POST['action'] === "delete") {
    $itemid = isset($_POST['itemid']) ? $_POST['itemid'] : 0;

    $where = " WHERE sessionId='" . $sessionId . "' and status='pendding'";
    $column = array();
    $myCartData = $addtocart->getData($column, $where);
    $dataqty = 0;
//    foreach ($myCartData as $key => $val) {
//        if ($val['id'] == $itemid) {
//            $removeqty = $val['qty'];
//        }
//        $dataqty = $dataqty + $val['qty'];
//    }
//    $dataqty = $dataqty - $removeqty;

    $where = " where id =".$itemid . " and sessionId ='" . $sessionId . "' and status = 'pendding'";
    $result = $addtocart->deleteItem($where);
    echo json_encode(array("msg" => "yes", "itemid" => $itemid));
    exit;
}
//print_r($_POST);
//die;
$pid = isset($_POST['productid']) ? $_POST['productid'] : "";
$qty = isset($_POST['quantity']) ? $_POST['quantity'] : "";
$pcode = isset($_POST['productcode']) ? $_POST['productcode'] : "";
$productName = isset($_POST['productName']) ? $_POST['productName'] : "";
$price = isset($_POST['price']) ? $_POST['price'] : "";
$description = isset($_POST['description']) ? $_POST['description'] : "";
$image = isset($_POST['image']) ? $_POST['image'] : "";
$createdAt = date("Y-m-d H:i:s");
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$data = array();
$data['productId'] = $pid;
$data['product_code'] = $pcode;
$data['qty'] = $qty;
$data['sessionId'] = $sessionId;
$data['status'] = "pendding";
$data['createdAt'] = $createdAt;
$data['ip'] = $ip;
$data['itemPrice'] = $price;
$data['productName'] = $productName;
$data['description'] = $description;
$data['image'] = $image;
$data['userType'] = "Guiest";
$data['totalAmount'] = $price * $qty;
$data['comment'] = "";

if (isset($userId) && !empty($userId)) {
    $data['userid'] = $userId;
    $data['userType'] = 'u';
} elseif (isset($guiestId) && !empty($guiestId)) {
    $data['userid'] = $guiestId;
    $data['userType'] = 'g';
}


//Checking product already in cart, if yes, now update qantity
$chkExistingPro = array();
$where = " WHERE sessionId='" . $sessionId . "' and status='pendding' and productId='" . $pid . "' and product_code='" . $pcode . "'";
$columnqty = array('qty');
$alreadyProduct = $addtocart->getData($columnqty, $where);

if ($alreadyProduct) {
    $qty = $alreadyProduct[0]['qty'] + $qty;
    $ucolumn = array("qty" => $qty);
    $uwhere = " WHERE sessionId='" . $sessionId . "' and status='pendding' and productId='" . $pid . "'";
    $addtocart->updateTempMyCart($ucolumn, $uwhere);
} else {
    if (!empty($data['product_code'])) {
        $addtocart->insertTempMyCart($data);
        $insertedID = $addtocart->insertedId();
    }
}

//Show my cart


$productIdArray = array();
$where = " WHERE sessionId='" . $sessionId . "' and status='pendding'";
$column = array();
$myCartData = $addtocart->getData($column, $where);

if (!empty($myCartData)) {
    $i = 0;
    $grandTotal = 0;
    foreach ($myCartData as $key => $pd) {
        $subtotal = $myCartData[$i]['itemPrice'] * $myCartData[$i]['qty'];
        $pdata[$i]['pid'] = $myCartData[$i]['id'];
        $pdata[$i]['productName'] = $myCartData[$i]['productName'];
        $pdata[$i]['price'] = $myCartData[$i]['itemPrice'];
        $pdata[$i]['qty'] = $myCartData[$i]['qty'];
        $pdata[$i]['subTotal'] = $myCartData[$i]['itemPrice'] * $myCartData[$i]['qty'];
        $pdata[$i]['deliveryTime'] = "With in week";
        $pdata[$i]['image'] = $myCartData[$i]['image'];
        $i++;
    }

    echo json_encode($pdata);
} else {
    echo "no";
}
?>