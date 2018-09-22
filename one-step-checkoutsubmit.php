<?php

session_start();
require("config/config.php");
$sessionId = session_id();
$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
$company = isset($_POST['company']) ? $_POST['company'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$address1 = isset($_POST['address1']) ? $_POST['address1'] : '';
$address2 = isset($_POST['address2']) ? $_POST['address2'] : '';
$city = isset($_POST['city']) ? $_POST['city'] : '';
$state = isset($_POST['state']) ? $_POST['state'] : '';
$zip = isset($_POST['zip']) ? $_POST['zip'] : '';
$country = isset($_POST['country']) ? $_POST['country'] : '';
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
$mobile = isset($_POST['mobile']) ? $_POST['mobile'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmpassword = isset($_POST['confirmpassword']) ? $_POST['confirmpassword'] : '';

$createdAt = date('Y-m-d H:i:s');

if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {    
    $msg = array("result" => "error", "msg" => "Invalid email format");
    echo json_encode($msg);
    die();
}
if (empty($firstname)) {
    $msg = array("result" => "error", "msg" => "First name is required");
    echo json_encode($msg);
     die();
} elseif (empty($email)) {
    $msg = array("result" => "error", "msg" => "Email is required");
    echo json_encode($msg);
     die();
} elseif (empty($address1)) {
    $msg = array("result" => "error", "msg" => "Address1 is required");
    echo json_encode($msg);
     die();
} elseif (empty($city)) {
    $msg = array("result" => "error", "msg" => "City is required");
    echo json_encode($msg);
     die();
} elseif (empty($state)) {
    $msg = array("result" => "error", "msg" => "State is required");
    echo json_encode($msg);
     die();
} elseif (empty($zip)) {
    $msg = array("result" => "error", "msg" => "Zip code is required");
    echo json_encode($msg);
     die();
} elseif (empty($mobile)) {
    $msg = array("result" => "error", "msg" => "Mobile is required");
    echo json_encode($msg);
     die();
} elseif (isset($_POST['guest']) && !empty($_POST['guest'])) {
    if ($_POST['guest'] === "g") {
        $guiestsession = new Guiestsession();
        $guiest = new Guiest();

        ####### Insert Guiest Detail ######
        $column = array('first_name' => $firstname, 'last_name' => $lastname, 'gemail' => $email, 'address1' => $address1, 'address2' => $address2, 'country' => $country, 'telephone' => $telephone, 'mobile' => $mobile, 'city' => $city, 'state' => $state, 'zipcode' => $zip, 'createdAt' => $createdAt);
        $guiest->create($column);
        $gId = $guiest->lastInsertedId();
        
        ####### Update cart with Guiest Id ######
        if ($gId) {
            $addtocart = new AddToCart();
            $column = array('userid' => $gId, 'userType' => 'g');
            $where = " WHERE sessionId='" . $sessionId . "'";
            $addtocart->updateTempMyCart($column, $where);
        }

        ###### Maintain Session with guiest detail #####
        $guiestData = array(array('gid' => $gId, 'gname' => $firstname, 'gemail' => $email));
        
        $guiestsession->setSession($guiestData);
        
        ##### Add Guiest Shipping address ###########
        if (isset($_POST['sameaddress'])) {
            $guiestbilling = new Guiestbilling();
            $column = array('guiestid' => $gId, 'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address1' => $address1, 'address2' => $address2, 'company' => $company, 'telephone' => $telephone, 'mobile' => $mobile, 'city' => $city, 'state' => $state, 'zipcode' => $zip, 'createdAt' => $createdAt, 'status' => '1');
            $guiestbilling->create($column);
        }
        $msg = array("result" => "success", "msg" => "Your registration is successfull.", "data" => $_POST);
        echo json_encode($msg);
    } elseif ($_POST['guest'] === "r") {
        $session = new Session();
        $auth = new Auth();
        if (!empty($password) && !empty($confirmpassword) && ($password == $confirmpassword)) {

            $c = array();
            $w = " WHERE uemail='" . $email . "'";
            $existUser = $auth->getUser($c, $w);
            if (!empty($existUser)) {
                $msg = array("result" => "error", "msg" => "Email is already register");
                echo json_encode($msg);
                die;
            }

            $column = array('upass' => md5($password), 'first_name' => $firstname, 'last_name' => $lastname, 'uemail' => $email, 'address1' => $address1, 'address2' => $address2, 'telephone' => $telephone, 'mobile' => $mobile, 'city' => $city, 'state' => $state, 'country' => $country, 'zipcode' => $zip, 'createdAt' => $createdAt);
            $auth->insertUser($column);
            $uId = $auth->insertedId();
            if ($uId) {
                $addtocart = new AddToCart();
                $column = array('userid' => $uId, 'userType' => 'u');
                $where = " WHERE sessionId='" . $sessionId . "'";
                $addtocart->updateTempMyCart($column, $where);
            }
            $userData = array(array('uid' => $uId, 'uname' => $firstname, 'uemail' => $email));
            $session->setSession($userData);
            if (isset($_POST['sameaddress'])) {
                $billing = new Billing();
                $column = array('userid' => $uId, 'firstname' => $firstname, 'lastname' => $lastname, 'address1' => $address1, 'address2' => $address2, 'company' => $company, 'telephone' => $telephone, 'mobile' => $mobile, 'city' => $city, 'state' => $state, 'zipcode' => $zip, 'createdAt' => $createdAt, 'status' => '1');
                $billing->insert($column);
            }
            $msg = array("result" => "success", "msg" => "Your registration is successfull.", "data" => $_POST);
            echo json_encode($msg);
        } else {
            $msg = array("result" => "error", "msg" => "Confirm password and password is not match. Try again..");
            echo json_encode($msg);
        }
    }
} else {
    $msg = array("result" => "error", "msg" => "You are not a valid user");
    echo json_encode($msg);
}