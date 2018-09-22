<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('DIR_INCLUDE', 'include/');
define('CAT_IMAGEPATH', '../assets/category/');
define("CATEGORY_IMAGE", "assets/category/");
define('HOST', $_SERVER['HTTP_HOST']);
define('WEBSITE_URL', HOST . "/asit");
define("IMAGE_TYPE", ['image/png', 'image/gif', 'image/jpeg']);
define("PRODUCT_IMAGE", "assets/product");
define("FACEBOOK_APPID", "1945145789038845");
define("FACEBOOK_SECRETKEY", "c3cd6a831a67ae5f866c194c1f00cd13");
define("COUPONDISCRIPTION", "1st website Signup Rs 300 OFF");
define("COUPONCODE", "signup300");
define("COUPONVALUE", "300");
define("MINIMUMPURCHASE", "1500");
define("SITE_URL","http://www.gnsaudios.com/");
define("SITE_NAME","G N S Audios");
/*
 * support@akam.in
 * akam
 * Akam-India
 * http://akam.in/
 * akam-logo.png
 */

$CONFIG = array(
    "database" => array(
        "host" => 'localhost',
        "database" => 'asit',
        "username" => 'root',
        "password" => 'abc@123'
    )
);

function __autoload($class_name) {
   // echo DIR_INCLUDE . $class_name . ".php";
   require_once DIR_INCLUDE . $class_name . ".php";
}
