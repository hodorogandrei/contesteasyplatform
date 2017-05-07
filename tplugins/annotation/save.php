<?php
    require_once("../../include/config.php");
    require_once("../../include/functions.php");

    $height = make_safe($_REQUEST['height']);
    $idd = make_safe($_REQUEST['id']);
    $left = make_safe($_REQUEST['left']);
    $text = make_safe($_REQUEST['text']);
    $top = make_safe($_REQUEST['top']);
    $width = make_safe($_REQUEST['width']);

    $sql = "SELECT * FROM `harta` WHERE idd='".$idd."'";
    if(mysql_num_rows(mysql_query($sql)) > 0)
    {
        $sqld = "UPDATE `harta` SET 
        `top`='".$top."',
        `left`='".$left."',
        `width`='".$width."',
        `height`='".$height."',
        `text`='".$text."'
        WHERE idd='".$idd."'";
        echo $sqld;
        mysql_query($sqld);
    }
    else
    {
        $sqld = "INSERT INTO `harta` (`top`, `left`, `width`, `height`, `text`, `idd`) 
        VALUES ('".$top."','".$left."','".$width."','".$height."','".$text."','".$idd."')";
        mysql_query($sqld);
    }
?>