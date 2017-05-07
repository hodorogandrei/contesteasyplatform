<?php
    require_once('../include/config.php');
    require_once('../include/functions.php');
    
    error_reporting(0);

    if ($_POST) {
        $id = make_safe($_POST['id']);           
        $numele = make_safe($_POST['numele']);           
        $clasa = make_safe($_POST['clasa']);
        $judet = make_safe($_POST['judet']);
        $unitatea = make_safe_lite($_POST['unitatea']);
        $cazare = make_safe($_POST['cazare']);    
        $concurs = make_safe($_POST['concurs']);
                   
        $sql = "UPDATE `participanti` SET 
        numele='$numele',
        clasa='$clasa',
        judet='$judet',
        unitatea='$unitatea',
        cazare='$cazare' ,
        concurs='$concurs'
        WHERE id='$id'";
        mysql_query($sql);
        echo $sql;
    }
?>