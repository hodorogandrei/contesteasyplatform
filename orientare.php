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
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu; ?>
        </div>
        <div id="continut2">
            <form id="form" onsubmit="this.pdfcontent.value = document.getElementById('pdfcontent2').innerHTML;" action="generate-pdf.php" method="post">
                <div id="zoomzone">

                    <a href="#" class="zoomin" title="Zoom In"></a>
                    <a href="#" class="zoomout" title="Zoom Out"></a>
                    <a href="#" class="resetFont" title="Resetare"></a>
                    <input type="submit" value="" name="html2pdf" id="generatepdf" title="Generare PDF"/>
                    <div id="qrcode">
                        <?php
                            $urlToEncode=$actual_link;
                            generateQRwithGoogle($urlToEncode);
                            function generateQRwithGoogle($url,$widthHeight ='70',$EC_level='L',$margin='0') {
                                $url = urlencode($url); 
                                echo '<img src="http://chart.apis.google.com/chart?chs='.$widthHeight.
                                'x'.$widthHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.
                                '&chl='.$url.'" alt="QR code" widthHeight="'.$widthHeight.
                                '" widthHeight="'.$widthHeight.'"/>';
                            }
                        ?>
                    </div>
                </div>
                <input type="hidden" name="pdfcontent" value="" />
                <input type="hidden" name="filename"   value="<?php echo $titlu;?>" />
                <div id="pdfcontent2">

                    <?php echo $continut;?>

                </div>
                Harta orientativ&#259; a loca&#355;iei:
                <br/><br/>
                <center>
                    <img id="toAnnotate" src="<?php echo $map;?>" />
                </center>
            </form>
        </div>
    </div>
</div>


<link rel="stylesheet" type="text/css" href="css/annotation.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.17.js"></script>
<script type="text/javascript" src="js/jquery.annotate.js"></script>
<script language="javascript">
    $(window).load(function() {
        $("#toAnnotate").annotateImage({
            getUrl: "async-db/get-places.php",
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