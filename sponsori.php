<?php
    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }
    ob_start('callback');

    include_once("include/header.php");

    $doSQL = "SELECT * FROM `onipag` WHERE id=4"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $titlu = $rand -> title;
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
                    <?php 
                        $sql = "SELECT * FROM `sponsori` ORDER BY ordine ASC"; 
                        $rezultat = mysql_query($sql);
                        while($rand = mysql_fetch_array($rezultat))
                        {
                            echo '<a href="'.$rand['link'].'" target="_blank"><img src="images/sponsori/'.$rand['gfile'].'" alt="'.$rand['galt'].'" border="0" /></a>';
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="js/jquery.js"></script>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>