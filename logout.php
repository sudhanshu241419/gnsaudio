<?php
session_start();
require("config/config.php");
$session = new Session();
$guiestsession = new Guiestsession();
$session->logout();
$guiestsession->logout();
header("location:index.php");