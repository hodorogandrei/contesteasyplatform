<?php

    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }
    ob_start('callback');

    include_once("include/header.php");

    $titlu="Guestbook";

    if(isset($_POST['submit']))
    {
        $rand_code = make_safe($_SESSION['rand_code']);
        //echo $rand_code;
        if(!empty($_POST['nume'])&&!empty($_POST['comentariu'])&&!empty($_POST['validator']))
        {
            if($_POST['validator'] == $rand_code)
            {
                $doSQL = "INSERT INTO `comentarii` (`nume`, `comentariu`, `data`) VALUES ('".make_safe_lite($_POST['nume'])."', '".make_safe_lite($_POST['comentariu'])."', '".Date("d-m-Y H:i:s")."')";
                mysql_query($doSQL);
                $mesaj = 'Comentariul va fi afi&#351;at dup&#259; aprobarea de c&#259;tre administrator.<br/> &Icirc;&#355;i multumim!';
                unset($_SESSION['rand_code']);
            }
            else
                $mesaj = 'Cod de verificare invalid!';
        }
        else
        {
            $mesaj = 'Toate c&acirc;mpurile sunt obligatorii!';
        }
    }
?>
<script type="text/javascript">
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=413783705319594";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div id="pagecontent">
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu;?>
        </div>
        <div id="continut2">
            <br/><br/>
            <form action="guestbook.php" method="post">
                <table width="500" align="center" cellpadding="0" cellspacing="2">
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: left;">
                            <div class="smalltitle_red">
                                <?php 										
                                    if(!empty($mesaj))
                                        echo $mesaj;
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="75"><div align="left" class="smalltitle">Numele: &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                        <td width="400" valign="top"><input name="nume" type="text" class="smalltitle" maxlength="50" value="<?php if(isset($_POST['nume'])) echo make_safe($_POST['nume']);?>"></td>
                    </tr>
                    <tr>
                        <td valign="top"><div align="left" class="smalltitle">Mesajul: &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                        <td valign="top"><textarea name="comentariu" cols="40" rows="5" class="smalltitle"><?php if(isset($_POST['comentariu'])) echo make_safe($_POST['comentariu']);?></textarea></td>
                    </tr>
                    <tr>
                        <td valign="top"><div align="left" class="smalltitle">Cod verificare: &nbsp;&nbsp;&nbsp;&nbsp;</div></td>
                        <td valign="top">
                            <input type="text" name="validator" id="validator" size="5" style="height: 35px;" />
                            <img src="libraries/captcha.php" alt="CAPTCHA image" align="top" />
                        </td>
                    </tr>
                    <tr><td colspan="2"><div align="center"><input type="submit" name="submit" value="Trimite"></div></td></tr>
                </table>
            </form>
            <form id="form" onsubmit="this.pdfcontent.value = document.getElementById('pdfcontent2').innerHTML;" action="generate-pdf.php" method="post">
                <div id="zoomzone" style="position: absolute;">
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
                <input type="hidden" name="filename"   value="guestbook" />
                <br/><br/>
                <div id="pdfcontent2">
                    <div class="fb-comments" data-href="http://contesteasyplatform.web2012.infoeducatie.ro/guestbook.php" data-num-posts="2" data-width="660"></div>
                    <br/><br/>
                    <?php 
                        $sql = "SELECT * FROM comentarii WHERE aprobat = 1 ORDER by id desc"; 
                        $result = mysql_query($sql);
                        while($rand = mysql_fetch_array($result))
                            echo'
                            <div align="left" style="float: left;"><img src="/images/post.png" class="thumb" width="15" height="15"/>&nbsp;<span class="smalltitle_blue">Postat de:</span>&nbsp;'.$rand['nume'].'</div>
                            <div align="right" style="float: right;"><img src="/images/clock.png" class="thumb" width="15" height="15"/>&nbsp;<span class="smalltitle_black">La data:</span>&nbsp;'.$rand['data'].'</div>
                            <br/><br/>'.$rand['comentariu'].'
                            <hr align="left" style="width: 100%;" size="1" color="#999999" />';
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