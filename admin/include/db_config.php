<?php
/*define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'abc@123');
define('DB_DATABASE', 'tp_akam');*/

define('DB_SERVER', 'localhost');
/*define('DB_USERNAME', 'demoweb_ecom');
define('DB_PASSWORD', 'ecom@1234');*/
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'demoweb_ecom');

class DB_con {

    function __construct() {
        $connection = mysql_connect('localhost','root','') or die('Oops connection error -> ' . mysql_error());
        mysql_select_db(DB_DATABASE, $connection) or die('Database error -> ' . mysql_error());
    }

}
?>
