<?php
    
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }
    ob_start('callback');
    
    include_once("include/header.php"); 
    
    $titlu="Toate &#351;tirile";

?>
<div id="pagecontent">
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php
                echo $titlu;
            ?>
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
                    <br/><br/><br/><br/><br/>  
                    <?php 
                        $sql = "SELECT * FROM `stiri` ORDER BY id DESC";
                        $result = mysql_query($sql);
                        if(mysql_num_rows($result) > 0)
                        {
                            while($rand = mysql_fetch_array($result))
                            {
                                echo'
                                <div class="news">
                                <div align="left" style="float: left;"><img src="images/news.png" class="thumb"/>&nbsp;<span class="news_date"><b>'.$rand['title'].'</b></span> (<i><b>Postat de:</b> '.$rand['postby'].'</i>)</div>
                                <div align="right" style="float: right;"><img src="images/clock.png" class="thumb"/>&nbsp;<span class="news_date"><b>La data de:</b> '.$rand['date'].'</span></div>
                                <br/><br/>
                                <div class="news_text2">
                                '.firstnwords($rand['content'],15).'<br/>					
                                </div>
                                <div class="news_more"><a class="news_more" href="stire_'.$rand['id'].'_'.$rand['permalink'].'.html"><img border="0" src="images/news-more.png"/>  mai mult</a></div>
                                <!--<div class="news_more"><a class="news_more" href="news.php?id='.$rand['id'].'"><img border="0" src="images/news-more.png" style="vertical-align: middle;"/>mai mult</a></div>-->
                                </div>
                                <hr align="left" style="width: 100%;" size="1" color="#999999" />
                                ';
                            }
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