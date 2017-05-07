<?php
    error_reporting(0);
    
    require_once("include/config.php");
    require_once("include/functions.php");
    
    $sql = "UPDATE 
    `usrs2012` 
    SET last_login='".Date("d-m-Y H:i")."', 
    last_ip='".get_ip()."',
    online='0'
    WHERE id = '".$_SESSION['userid']."'";
    mysql_query($sql);
    
    session_start();
    session_destroy();
    session_unset();
?>
<meta http-equiv="refresh" content="0; url=index.php" />