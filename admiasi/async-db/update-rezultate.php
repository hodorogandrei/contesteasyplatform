<?php
    require_once('../include/config.php');
    require_once('../include/functions.php');
    
    error_reporting(0);

    if ($_POST) {
        $id = make_safe($_POST['id']);           
        $numele = make_safe($_POST['numele']);           
        $clasa = make_safe($_POST['clasa']);
        $judet = make_safe($_POST['judet']);
        $total = make_safe($_POST['total']);
        $observatii = make_safe($_POST['observatii']);
        $premiu = make_safe($_POST['premiu']);
        $medalie = make_safe($_POST['medalie']);
                   
        $sql = "UPDATE `rezultate` SET 
        numele='$numele',
        clasa='$clasa',
        judet='$judet',
        total='$total',
        observatii='$observatii',
        premiu='$premiu' ,
        medalie='$medalie'
        WHERE id='$id'";
        mysql_query($sql);
        echo $sql;
    }
?>