<?php
    require_once("../include/config.php"); 
    require_once("../include/functions.php");    

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1)
                $acces=1;
            else
            {
                $acces=check_perm("Editare pagini");
            }
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        while($rand = mysql_fetch_object($rezultat))
        {
            $compname = $rand -> name;
            $colorheader = $rand -> colorheader;
            $colorfooter = $rand -> colorfooter;
            $begdate = $rand -> begdate;
            $enddate = $rand -> enddate;
            $colortitle = $rand -> colortitle;
            $organiser = $rand -> organiser;
            $organiserweb = $rand -> organiserweb;
            $headtitle = $rand -> headtitle;
            $picture = $rand -> picture;
            $foottitle = $rand -> foottitle;
            $oras = $rand -> oras;
            $wafis = $rand -> wafis;
            $nwstxt = $rand -> nwstxt;
            $toolstxt = $rand -> toolstxt;
            $mp3file = $rand -> mp3file;
            $partpages = $rand -> partpages;
            $deadline = $rand -> datainc;
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <title>LIVE Editor - ContestEasyPlatform</title>
            <meta name="publisher" content="contact@xpreflect.net" />
            <meta name="copyright" content="Copyright(C) ContestEasyPlatform Live Editor" />
            <meta name="author" content="Hodorog Andrei" />
            <link rel="stylesheet" type="text/css" href="../../css/style.css" />

            <!-- UItoTop plugin -->
            <link rel="stylesheet" type="text/css" href="../../css/ui.totop.css" />
            <!-- jQuery countdown -->
            <link rel="stylesheet" href="../../css/jquery.countdown.css" />
            <!-- jQuery weather -->
            <link href="../../css/jquery.zweatherfeed.css" rel="stylesheet" type="text/css" />
            <script type="text/javascript" src="../../js/jquery.js"></script>

            <script type="text/javascript" src="../../js/jquery-ui.min.js" ></script>
            <script type="text/javascript" src="../../js/selectivizr-min.js"></script>
            <script type="text/javascript" src="edit.js"></script>
            <!--[if lt IE 9]>
            <script src="../../js/html5.js"></script>
            <![endif]-->
            <style type="text/css">
                #main #headerbg { background:<?php echo $colorheader;?> url(../../images/headerbg.png); }
                #main #footerbg { background:<?php echo $colorfooter;?> url(../../images/footerbg2.png); }
                #main #footerbg #footercontent { background:<?php echo $colorfooter;?> url(../../images/footerbg3.png) no-repeat; }
                #main #pagecontent #continut #pagetitle { background:<?php echo $colortitle;?> url(../../images/pagetitle.png); }
            </style>
            <style type="text/css">
                input[type="text"].stfield{
                    background: url("../images/input_bg.gif") repeat scroll 0 0 transparent;
                    border: 1px solid #AAAAAA;
                    border-radius: 2px 2px 2px 2px;
                    -moz-border-radius: 2px 2px 2px 2px;
                    -webkit-border-radius: 2px 2px 2px 2px;
                    box-shadow: 0 1px 2px #DDDDDD;
                    color: #555555;
                    padding: 4px;
                    text-align: left;
                    width:auto;
                }
                #contain {display: none;}

            </style>
        </head>
        <body>
            <?php include('../../include/checkie6.php');?>
            <div id="contain">
                <div id="main">
                    <div id="noscriptalert">
                        <br/>
                        <center>
                            <p style="font-weight: bold; font-size: 14px; background: #fff;"><img src="../../images/disabledjs.png" border="0" alt="" style="position: relative; margin-bottom: -7px;"/><i>Pentru a putea utiliza Live Editor-ul, este necesar s&#259; activa&#355;i Javascript! Mai multe informatii reg&#259;si&#355;i <a href="activare-javascript.php">aici</a> .</i></p>
                        </center>
                    </div>
                    <div id="warning">
                        <img src="../images/liveedit.png" class="midalign"/>&nbsp;Aten&#355;ie! V&#259; afla&#355;i &icirc;n Live Editor! Aceasta este o versiune de previzualizare a paginii.
                    </div>
                    <div id="headerbg">
                        <div id="logo">
                            <div id="sigla"><center><img src="../../<?php echo $picture;?>" /></center></div>
                            <div id="titlu"><span class="editable2"><?php echo $organiser;?></span> - <span class="editable"><?php echo $headtitle;?></span></div>
                            <div id="secmenu"><a href="guestbook.php" title="Guestbook">Guestbook</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" title="Contact">Contact</a></div>
                            <div id="menuright">
                                <ul class="Menu Menum">
                                    <li class="Menui0"><a class="Menui0" href="#">Comisie</a></li>
                                    <li class="Menui0"><a class="Menui0" href="#">Organizatori &amp; Sponsori</a></li>
                                    <li class="Menui0"><a class="Menui0" href="#">Participan&#355;i</a></li>
                                    <li class="Menui0"><a class="Menui0" href="#">Subiecte</a></li>

                                </ul>
                                <br/><br/>
                                <div class="fb-like" data-href="https://www.facebook.com/oni2012" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="tahoma"></div>
                                <div id="plus">
                                    <div id="plusone"></div>
                                </div>
                                <div id="weather">
                                </div>
                            </div>
                            <div id="menuleft">
                                <ul class="Menu Menum">
                                    <li class="Menui0"><a class="Menui0" href="#">Home</a></li>
                                    <li class="Menui0"><a class="Menui0" href="#">Desf&#259;&#351;urare</a>
                                    </li>
                                    <li class="Menui0"><a class="Menui0 nound"><span class="partpages-edit"><?php echo $partpages;?></span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
                                        <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
                                    <li class="Menui0"><a class="Menui0" href="#">Rezultate</a></li>
                                    <!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
                                </ul>
                            </div>
                            <a class="home" href="index.php"></a>
                        </div>
                        <div id="welcomeline" class="hiddendiv">
                            <div id="band">
                                <div id="range">
                                    Perioada de desf&#259;&#351;urare: <span class="begdate-edit"><?php echo $begdate;?></span> - <span class="enddate-edit"><?php echo $enddate;?></span>			
                                </div>
                            </div>
                            <ul>
                                <?php 
                                    $sql = "SELECT * FROM `gallery` ORDER BY ordine ASC"; 
                                    $rezultat = mysql_query($sql);
                                    while($rand = mysql_fetch_object($rezultat))
                                    {
                                        echo '<li><img src="../../images/gallery/'.$rand -> gfile.'" alt="'.$rand -> galt.'" /></li>';
                                    }
                                ?>
                            </ul>
                        </div>			<div id="headershadow"></div>
                    </div>		<div id="pagecontent">
                        <div id="sidebar">
                            <div id="player">
                                <object type="application/x-shockwave-flash" data="../../player_mp3_maxi.swf" width="30" height="30" style="float: left;">
                                    <param name="wmode" value="transparent" />
                                    <param name="movie" value="../../player_mp3_maxi.swf" />
                                    <param name="FlashVars" value="mp3=../../<?php echo $mp3file;?>&width=30&height=30&sliderwidth=30&sliderheight=8&buttonwidth=30&bgcolor=cccc99&bgcolor1=9e8941&bgcolor2=3045b3" />
                                </object>
                                &nbsp;<span id="countdown"></span>
                            </div>
                            <img src="../../images/news-ico.png" class="thumb" />&nbsp;<span style="color: #3045b3; font-size: 26px;" class="nwstxt-edit"><?php echo $nwstxt;?></span><br/><br/>
                            <?php 
                                $sql = "SELECT * FROM `stiri` ORDER BY id DESC LIMIT 0,5";
                                $result = mysql_query($sql);
                                if(mysql_num_rows($result) > 0)
                                {
                                    while($rand = mysql_fetch_object($result))
                                    {
                                        echo'
                                        <br/>
                                        <div class="news">
                                        <span class="news_date"><img src="../../images/news.png" style="vertical-align: bottom;"/> 
                                        '.$rand -> date.'</span> - <span class="news_title"><i>'.$rand -> title.'</i></span>&nbsp;<span class="trigger"></span>
                                        <div class="news_text">
                                        '.firstnwords(strip_tags($rand -> content),10).'<br/>					
                                        </div>
                                        <div class="news_more"><a class="news_more" href=#"><img border="0" src="../../images/news-more.png"/>  mai mult</a></div>
                                        </div>
                                        ';
                                    }
                                    echo '<a href="stiri.php" class="info_content_a">Vizualiza&#355;i toate &#351;tirile</a><br/><br/>';
                                }
                                else
                                    echo '&Icirc;n cur&acirc;nd...<br/><br/>';
                            ?>

                            <img src="../../images/tools.png" class="thumb" width="26" height="26" />&nbsp;<span style="color: #3045b3; font-size: 26px;" class="toolstxt-edit"><?php echo $toolstxt;?></span><br/>
                            <div class="info">
                                <div class="info_title"><img width="6" height="6" src="../../images/bullet.png" />&nbsp;&nbsp;telefoane:&nbsp;</div>
                                <div class="info_content">
                                    Stelian Hadimbu (Inspector):<br />
                                    &nbsp;&nbsp;&nbsp;&raquo;&nbsp;0745 305590<br />
                                </div>
                            </div>
                            <div class="info">
                                <div class="info_title"><img width="6" height="6" src="../../images/bullet.png" />&nbsp;&nbsp;link-uri utile:&nbsp;</div>
                                <div class="info_content">
                                    <a href="http://olimpiada.info" target="_blank" class="info_content_a">olimpiada.info</a><br />
                                    <a href="http://www.isjiasi.ro" target="_blank" class="info_content_a">www.isjiasi.ro</a><br />
                                    <a href="http://www.edu.ro" target="_blank" class="info_content_a">www.edu.ro</a><br />
                                </div>
                            </div>
                            <div class="info">
                                <div class="info_title"><img width="6" height="6" src="../../images/bullet.png" />&nbsp;&nbsp;tramvaie &amp; autobuze:&nbsp;</div>
                                <div class="info_content">
                                    <a href="http://www.ratp-iasi.ro" target="_blank" class="info_content_a">www.ratp-iasi.ro</a><br />
                                </div>
                            </div>
                            <div class="info">
                                <div class="info_title"><img width="6" height="6" src="../../images/bullet.png" />&nbsp;&nbsp;mersul trenurilor:&nbsp;</div>
                                <div class="info_content">
                                    <a href="http://www.mersultrenurilor.ro" target="_blank" class="info_content_a">www.mersultrenurilor.ro</a><br />
                                </div>
                            </div>
                            <div class="info">
                                <div class="info_title"><img width="6" height="6" src="../../images/bullet.png" />&nbsp;&nbsp;downloads:&nbsp;</div>
                                <div class="info_content">
                                    <a href="#" target="_blank" class="info_content_a">Program detaliat ONI 2012</a><br />
                                    <a href="#" target="_blank" class="info_content_a">Format tabele participanti</a><br />
                                    <a href="#" target="_blank" class="info_content_a">Adresa de Convocare ONI</a><br />
                                    <a href="#" target="_blank" class="info_content_a">Locatii Cazari Participanti</a><br />
                                    <a href="#" target="_blank" class="info_content_a">
                                        Regulament de desfasurare
                                    </a><br />
                                </div>
                            </div>
                        </div>			
                        <div id="continut">
                            <div id="pagetitle">
                                Titlu pagin&#259;				
                            </div>
                            <div id="continut2">
                                <p>
                                    <center>Con&#355;inut pagin&#259;</center>
                                </p>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div id="footerbg">
                        <div id="footercontent">
                            <div id="footertext">
                                <center>
                                    Copyright&copy; <span class="foot-edit"><?php echo $foottitle;?></span>. <br/>Based on ContestEasyPlatform&reg; by <a href="http://www.andreihodorog.com/" target="_blank">Andrei Hodorog</a> .<br/>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="preLoader" class="hiddendiv"><img src="../../images/loading.png" class="midalign" />&nbsp;<i>Live editor-ul se &icirc;ncarc&#259;. V&#259; rug&#259;m a&#351;tepta&#355;i...</i></div>
            <!-- Roundabout Plugin --->
            <script src="../../js/roundabout.js" type="text/javascript"></script>
            <!-- Easing Plugin -->
            <script src="../../js/easing.js" type="text/javascript"></script>
            <!-- UItoTop plugin -->
            <script src="../../js/jquery.ui.totop.js" type="text/javascript"></script>
            <!-- jQuery countdown -->
            <script src="../../js/jquery.countdown.js"></script>
            <!-- jQuery weather -->
            <script src="../../js/jquery.zweatherfeed.js" type="text/javascript"></script>
            <script type="text/javascript">
                var ts = new Date(<?php echo $deadline;?>);
                var wcity = '<?php echo $oras; ?>';
            </script>
            <script type="text/javascript" src="globalscript.js"></script>
            <style type="text/css">
                .hover { background-color: #ccc }
                .inlineEdit-placeholder { font-style: italic; color: #555; }
            </style>
            <script src="../../js/facebook.js" type="text/javascript"></script>
            <!-- No-Javascript Alert -->
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">#countdown {display: inline;} #noscriptalert {display: none;} #main #headerbg {height: 359px;} #preLoader {display: block;} #contain {display: block;}</style>');
                //]]>
            </script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>
</head>
</html>