<?php 
    include("include/headerinfo.php");

    $doSQL = "SELECT * FROM `general` WHERE id=1"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $endm = $rand -> endm;
        $organiser = $rand -> organiser;
        $organiserweb = $rand -> organiserweb;
        $headtitle = $rand -> headtitle;
        $nw = $rand -> nw;
        $begdate = $rand -> begdate;
        $enddate = $rand -> enddate;
        $picture = $rand -> picture;
        $wafis = $rand -> wafis;
        $partpages = $rand -> partpages;
    }
?>

<body>
<?php include("include/checkie6.php");?>

<div id="contain">
<div id="main">
<div id="linkhelp">
<a href="help.pdf" target="_blank"><img src="images/help.png" />Help</a>
</div>
<div id="noscriptalert">
    <br/>
    <center>
        <p style="font-weight: bold; font-size: 14px; background: #fff;"><img src="images/disabledjs.png" border="0" alt="" style="position: relative; margin-bottom: -7px;"/><i>Pentru a beneficia de toate functionalit&#259;&#355;ile acestui site, este necesar s&#259; activa&#355;i Javascript! Mai multe informatii reg&#259;si&#355;i <a href="activare-javascript.php">aici</a> .</i></p>
    </center>
</div>
<div id="headerbg">
    <div id="logo">
        <div id="sigla"><center><img src="<?php echo $picture;?>" /></center></div>
        <div id="titlu">
            <a href="<?php echo $organiserweb;?>" <?php if($nw == 1) echo 'target="_blank"';?> title="<?php echo $organiser;?>">
                <?php echo $organiser;?>
            </a> 
            - <?php echo $headtitle;?>
        </div>
        <div id="secmenu">
            <a href="guestbook.php" title="Guestbook">Guestbook</a>
            <a href="contact.php" title="Contact">Contact</a>
            <?php
                if(!isset($_SESSION['logat_user']))
                {
            ?>
            <a href="autentificare.php" title="Autentificare">Autentificare</a>
            <a href="signup.php" title="Inregistrare">&Icirc;nregistrare</a>
            <?php
                }
                else
                {
            ?>
             <a href="logout.php" title="Delogare">Delogare</a>
            <?php } ?>
        </div>
        <div id="menuright">
            <ul class="Menu Menum">
                <li class="Menui0"><a class="Menui0" href="regulament.php">Regulament</a></li>
                <li class="Menui0"><a class="Menui0" href="sponsori.php">Sponsori</a></li>
                <li class="Menui0"><a class="Menui0" href="participanti.php">Participan&#355;i</a></li>
                <li class="Menui0"><a class="Menui0" href="subiecte.php">Subiecte</a></li>

            </ul>
            <br/><br/>

            <?php if($wafis == 1) { ?>
                <div id="weather"></div>
                <?php } ?>

        </div>
        <div id="menuleft">
            <ul class="Menu Menum">
                <li class="Menui0"><a class="Menui0" href="index.php">Home</a></li>
                <li class="Menui0"><a class="Menui0" href="orientare.php">Desf&#259;&#351;urare</a>
                </li>
                <li class="Menui0"><a class="Menui0" href="#"><span><?php echo $partpages;?></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                    <ul class="Menum">
                        <?php
                            $sql = "SELECT * FROM `onipag` WHERE id > 5 ORDER BY id ASC"; 
                            $result = mysql_query($sql);
                            $nr=0;
                            while($rand = mysql_fetch_array($result))
                            {
                                $nr++;
                                if($nr==1)
                                    echo '<li class="Menui"><a class="Menui" href="'.$rand['userfile'].'">'.$rand['title'].'</a></li><li class="Menui">';
                                else if(($nr >= 2) && ($nr <= 6))
                                        echo '<a class="Menui" href="'.$rand['userfile'].'">'.$rand['title'].'</a></li><li class="Menui">';
                                    else if($nr > 6)
                                            echo '<a class="Menui" href="'.$rand['userfile'].'">'.$rand['title'].'</a>&nbsp;|';
                            }
                            if($nr > 3)
                                echo '</li>';
                        ?>
                    </ul>
                    <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
                <ul class="Menum">
                    <li class="Menui"><a class="Menui" href="http://www.liis.ro/~oniiasi/" target="_blank">Revista ONI 2012</a>
                </ul>
                <li class="Menui0"><a class="Menui0" href="rezultate.php">Rezultate</a></li>
                <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
            </ul>
        </div>
        <a class="home" href="index.php"></a>
    </div>
    <?php include("include/slide.php");?>
    <div id="headershadow"></div>
		</div>