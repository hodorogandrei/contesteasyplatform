<?php
    require_once("include/config.php");
    require_once("include/functions.php");

    error_reporting(E_ERROR | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {

        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/logout.php');


        $sql = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $compname = $rand -> name;

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");
            ?>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/><br/>
                        <center>Bun venit la panoul de administrare al evenimentului <i><b>&quot;<?php echo $compname;?>&quot;</b></i>! <br/> Alege&#355;i una dintre op&#355;iunile de administrare din meniul din partea de sus!</center>
                        <br/><center><b>Ave&#355;i acces la paginile:</b><br/>
                            <?php
                                if($_SESSION['global'] == 1)
                                    echo'permisiuni globale';
                                else
                                {
                                    echo '<br/>';
                                    $sqlwel = 'SELECT * FROM `usrperm` WHERE id_user = '.$_SESSION['userid'].'';
                                    $resultwel = mysql_query($sqlwel);
                                    $nr=0;
                                    while($rand = mysql_fetch_array($resultwel))
                                    {
                                        if($rand['permisiune'] == 1)
                                        {
                                            $resultwel2 = mysql_query('SELECT * FROM pagini WHERE id = '.$rand['pagina'].'');
                                            while($rand2 = mysql_fetch_array($resultwel2))
                                            {
                                                $nr++;
                                                if($nr==1)
                                                    echo $rand2['pagina'];
                                                else
                                                    echo ' | '.$rand2['pagina'];
                                            }
                                        }
                                    }
                                    echo '<br/><br/>Orice &icirc;ncercare de accesare a unei pagini nepermise v&#259; va redirec&#355;iona c&#259;tre aceast&#259; pagin&#259;.';
                                }
                            ?>
                            <?php if($_SESSION['createdby']!='administrator implicit') {?>
                                <br/><br/><center><b>Contul v-a fost creat de c&#259;tre:</b><br/>
                                    <?php echo $_SESSION['createdby'];?>
                                </center>
                                <?php } ?>
                            <img src="images/logo_contest2.png" width="500" height="234" border="0" usemap="#map" class="map"/>
                            <map name="map" id="map">
                                <area shape="poly" coords="329,206,350,200,353,199,374,191,360,170,355,169,350,170,345,171,341,174,324,163,325,160,334,153,334,148,332,144,327,142,320,141,315,142,310,143,309,147,306,148,307,153,317,160,317,164,306,165,303,165,303,169,298,170,297,175,301,177,294,180,294,185,314,199,325,198" href="administrare-rezultate.php" title="Administrare Rezultate"/>
                                <area shape="poly" coords="140,191,174,191,178,189,180,184,181,181,180,178,180,148,140,147" href="administrare-comentarii.php" title="Administrare Comentarii" />
                                <area shape="poly" coords="248,117,252,117,253,114,253,112,255,111,256,103,257,99,260,94,260,89,260,86,263,81,267,75,270,69,270,63,270,56,267,50,264,45,260,41,254,40,249,38,244,38,239,40,234,42,231,46,228,50,226,55,225,60,225,65,227,70,229,76,233,81,235,86,235,89,236,92,238,97,238,101,240,102,240,105,239,107,239,109,240,111,242,112,243,113,243,116" href="administratori.php" title="Administratori" />
                                <area shape="poly" coords="397,96,432,92,432,96,435,99,440,98,443,98,447,98,451,97,449,95,451,92,443,84,442,48,392,49,392,95" href="statistici.php" title="Statistici"/>
                                <area shape="poly" coords="142,138,152,138,146,134,150,119,154,114,149,88,151,78,159,61,184,60,187,57,186,53,182,52,165,51,151,49,154,46,158,44,159,41,159,37,157,32,152,30,148,31,143,33,141,36,141,38,141,41,142,43,122,28,118,28,115,30,115,34,115,35,136,55,135,58,126,61,121,62,118,63,113,64,111,65,104,62,105,60,101,60,99,63,92,64,88,64,87,68,82,66,84,63,85,59,81,56,76,56,74,58,74,62,75,64,63,67,54,77,44,70,40,71,39,74,39,75,36,77,33,81,30,84,30,86,33,88,32,110,37,112,36,114,30,116" href="administrare-participanti.php" title="Administrare Participanti" />
                            </map>
                        </center> 
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>



            <script type="text/javascript" src="js/jquery.maphilight.min.js"></script>
            <script type="text/javascript" src="js/maphighlight.js"></script>
        </body>
    </html>
    <?php

    } else {

        $sql = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $picture = $rand -> picture;

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>ContestEasyPlatform - Panou de administrare</title>
            <meta name="publisher" content="contact@xprelfect.net" />
            <meta name="copyright" content="Copyright(C) ContestEasyPlatform 2012" />
            <meta name="author" content="Hodorog Andrei" />
            <link type="text/css" rel="stylesheet" href="css/style.css" />

        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <div id="noscriptalert">
                        <center>
                            <p style="font-weight: bold; font-size: 14px; background: #fff;"><img src="../images/disabledjs.png" border="0" alt="" style="position: relative; margin-bottom: -7px;"/>&nbsp;<i>Pentru a beneficia de toate functionalit&#259;&#355;ile acestui site, este necesar s&#259; activa&#355;i Javascript! Mai multe informatii reg&#259;si&#355;i <a href="activare-javascript.php">aici</a> .</i></p>
                        </center>
                    </div>
                    <div id="headerbg">
                        <div id="logo">
                            <div id="sigla"><center><img src="../<?php echo $picture;?>" /></center></div>
                            <div id="titlu"><img src="images/logo_contest.png" class="midalign"/>&nbsp;<i>ContestEasyPlatform&reg;</i> - Panou de administrare</div>
                        </div>
                    </div>
                    <div class="shake">
                        <div id="bgadmin">
                            <div id="lacattitlu"></div>
                            <center><div id="mesaj"></div></center>
                            <form method="POST" id="loginform">
                                <table border="0" cellspacing="0" cellpadding="0" style="text-align: right;">
                                    <tr>
                                        <td><B>Username:</b>&nbsp;</td>
                                        <td><div class="userleft"></div></td>
                                        <td><input name="user" type="text" class="field_username"/></td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td><b>Parola:</b>&nbsp;</td>
                                        <td><div class="passleft"></div></td>
                                        <td><input name="pass" type="password" class="field_parola"/></td>
                                    </tr>
                                    <!--
									<tr>   
                                        <td colspan="3">
                                            <br/>
                                            <script type="text/javascript" src="js/config-captcha.js"></script>
                                            <script type="text/javascript"
                                                src="http://www.google.com/recaptcha/api/challenge?k=6LczbtQSAAAAAIdZlEVia6ets0dcsNPMIUB9qVhQ">
                                            </script>
                                        </td>
                                    </tr>
									-->
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                        <td colspan="3"><input class="submitbutton" value="" id="submit" title="Login"/></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <div id="bgadmin_nojs">
                            <form method="POST" id="loginformnojs" action="login.php">
                                <input name="js_disabled" type="hidden" value="1">
                                <table border="0" cellspacing="0" cellpadding="0" >
                                    <tr>
                                        <td><B>Username:</b>&nbsp;</td>
                                        <td><div class="userleft"></div></td>
                                        <td><input name="user" type="text" class="field_username"/></td>
                                    </tr>
                                    <tr><td colspan="3">&nbsp;</td></tr>
                                    <tr>
                                        <td><b>Parola:</b>&nbsp;</td>
                                        <td><div class="passleft"></div></td>
                                        <td><input name="pass" type="password" class="field_parola"/></td>
                                    </tr>
                                </table>
								<!--
                                <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LczbtQSAAAAAIdZlEVia6ets0dcsNPMIUB9qVhQ"
                                    height="250" width="500" frameborder="0"></iframe>
                                <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                                </textarea>
                                <input type="hidden" name="recaptcha_response_field"
                                    value="manual_challenge">
								-->
                                <input class="submitbutton" value="" type="submit" title="Login"/>
                            </form>
                        </div>
                        <br/><br/><br/>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>

            <script type="text/javascript" src="js/jquery.min-164.js"></script>
            <script type="text/javascript" src="js/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/login.js"></script>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">#bgadmin_nojs {display: none;} #noscriptalert {display: none;} #loginform {display: block;} #loginformnojs {display: none;}</style>');
                //]]>
            </script>
        </body>
    </html>
    <?php 
    }
?>
