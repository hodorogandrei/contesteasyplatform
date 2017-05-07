<?php
    require_once('libraries/mobile_device_detect.php');

    $_SESSION['redirectat'] = 'Nu';
    if(isset($_SERVER["HTTP_REFERER"]))
        if (strstr($_SERVER["HTTP_REFERER"], 'http://'.$_SERVER["SERVER_NAME"].'/oni-2012/mobile')) $_SESSION['redirectat'] = 'Da';
        if($_SESSION['redirectat'] == 'Nu')
        mobile_device_detect(true,true,true,true,true,true,true,'http://'.$_SERVER['SERVER_NAME'].'/oni-2012/mobile/',false);

    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }

    ob_start('callback');

    include_once("include/header.php");

    $titlu="Autentificare";

?>
<div id="pagecontent">
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu ;?>
        </div>
        <div id="continut2">
            <br/>
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
                            <tr>   
                                <td colspan="3">
                                    <br/>
                                    <script type="text/javascript" src="js/config-captcha.js"></script>
                                    <script type="text/javascript"
                                        src="http://www.google.com/recaptcha/api/challenge?k=6LczbtQSAAAAAIdZlEVia6ets0dcsNPMIUB9qVhQ">
                                    </script>
                                </td>
                            </tr>
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
                        <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LczbtQSAAAAAIdZlEVia6ets0dcsNPMIUB9qVhQ"
                            height="250" width="500" frameborder="0"></iframe>
                        <textarea name="recaptcha_challenge_field" rows="3" cols="40">
                        </textarea>
                        <input type="hidden" name="recaptcha_response_field"
                            value="manual_challenge">
                        <input class="submitbutton" value="" type="submit" title="Login"/>
                    </form>
                </div>
                <br/><br/><br/>
            </div>
        </div>
    </div>
</div>
<link type="text/css" rel="stylesheet" href="css/login.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">#bgadmin_nojs {display: none;} #loginform {display: block;} #loginformnojs {display: none;}</style>');
                //]]>
            </script>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>