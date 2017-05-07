<?php
    require_once("../include/config.php");
    require_once("../include/functions.php");
    
    $height = make_safe($_REQUEST['height']);
    $idd = make_safe($_REQUEST['id']);
    $left = make_safe($_REQUEST['left']);
    $text = make_safe($_REQUEST['text']);
    $top = make_safe($_REQUEST['top']);
    $width = make_safe($_REQUEST['width']);
    
    $sql = "DELETE FROM `harta` WHERE 
    idd='".$idd."' AND
    text='".$text."'";
    mysql_query($sql);
    echo $sql;
?>