<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('DIR_INCLUDE','include/');
define('CAT_IMAGEPATH','assets/category/');
define('PRO_IMAGEPATH','assets/product/');
$imageType = array('image/png','image/gif','image/jpeg','image/jpg');
$CONFIG = array(
    "database" => array(
        "host" => 'localhost',
        "database" => 'asit',
        "username" => 'root',
        "password" => 'abc@123'
    )
);

//set_include_path(DIR_INCLUDE);
//spl_autoload_extensions(".php");
spl_autoload_register('myAutoloader');
function myAutoloader($className)
{
    $path = DIR_INCLUDE;

    include $path.$className.'.php';
}
//if(!function_exists('spl_autoload_register')){
//function __autoload($class_name) 
//    {
//        //echo DIR_INCLUDE.$class_name.".php";
//        require_once DIR_INCLUDE.$class_name.".php";
//    }
//}else{
//    function my_autoloader($class_name) {
//        require_once DIR_INCLUDE.$class_name.".php";
//    }
    
//}