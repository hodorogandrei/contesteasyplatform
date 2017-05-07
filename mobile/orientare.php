<?php
    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }

    ob_start('callback');

    include_once("include/header.php");

    $doSQL = "SELECT * FROM `onipag` WHERE id=5"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $titlu = $rand -> title;
        $continut = $rand -> content;
    }

    $doSQL = "SELECT * FROM `general` WHERE id=1"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $map = $rand -> map;
    }

?>
<div id="pagecontent">
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu;?>
        </div>
        <div id="continut2">
            <?php
                echo $continut;
            ?>
            <br/><br/>
            Harta orientativ&#259; a loca&#355;iei:
            <br/><br/>
            <center>
                <img id="toAnnotate" src="../<?php echo $map;?>" />
            </center>
        </div>
    </div>
</div>


<link rel="stylesheet" type="text/css" href="../css/annotation.css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.17.js"></script>
<script type="text/javascript" src="../js/jquery.annotate.js"></script>
<script language="javascript">
    $(window).load(function() {
        $("#toAnnotate").annotateImage({
            getUrl: "../async-db/get-places.php",
            saveUrl: "",
            deleteUrl: "",
            editable: false
        });
    });
</script>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>