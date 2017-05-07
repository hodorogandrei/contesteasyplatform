<?php
session_start();
set_time_limit(0);
header("Content-Type: text/html; charset=UTF-8");                                                     

 $db = "localhost";
 $userdb = "root";
 $passdb = "";
 $namedb = "oni2012";

 $conection = mysql_connect($db,$userdb,$passdb) or die("Nu pot crea o legatura cu serverul MySQL!");
 mysql_select_db($namedb, $conection) or die("Nu pot gasi baza de date!");
 
?>