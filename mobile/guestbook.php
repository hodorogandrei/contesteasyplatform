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
                $doSQL = "INSERT INTO `comentarii` (`nume`, `comentariu`, `data`, `aprobat`) VALUES ('".make_safe($_POST['nume'])."', '".make_safe($_POST['comentariu'])."', '".Date("d-m-Y H:i:s")."', 0)";
                mysql_query($doSQL);
                $mesaj = 'Comentariul va fi afisat dupa aprobarea de catre administrator.<br/> Iti multumim!';
                unset($_SESSION['rand_code']);
            }
            else
                $mesaj = 'Cod de verificare invalid!';
        }
        else
        {
            $mesaj = 'Toate campurile sunt obligatorii!';
        }
    }
?>
<div id="pagecontent">
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu;?>
        </div>
        <div id="continut2">
            <form action="guestbook.php" method="post">
                <table width="500" align="center" cellpadding="0" cellspacing="2">
                    <tr>
                        <td>&nbsp;</td>
                        <td>
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
                            <img src="captcha.php" alt="CAPTCHA image" align="top" />
                        </td>
                    </tr>
                    <tr><td colspan="2"><div align="center"><input type="submit" name="submit" value="Trimite"></div></td></tr>
                </table>
            </form>
            <?php 
                $sql = "SELECT * FROM comentarii WHERE aprobat = 1 ORDER by id desc"; 
                $result = mysql_query($sql);
                while($rand = mysql_fetch_array($result))
                    echo'
                    <div align="left" style="float: left;"><img src="images/post.png" class="thumb"/>&nbsp;<span class="smalltitle_blue">Postat de:</span>&nbsp;'.$rand['nume'].'</div>
                    <div align="right" style="float: right;"><img src="images/clock.png" class="thumb"/>&nbsp;<span class="smalltitle_black">La data:</span>&nbsp;'.$rand['data'].'</div>
                    <br/><br/>'.$rand['comentariu'].'
                    <hr align="left" style="width: 100%;" size="1" color="#999999" />';
            ?>
        </div>
    </div>
</div>
<?php

    include_once("include/footer.php");

    ob_end_flush();

?>