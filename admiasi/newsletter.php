<?php        
    require_once("include/config.php");
    require_once("include/functions.php");

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    require_once("../libraries/class.phpmailer.php");

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Newsletter"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
            
        $doSQL = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($doSQL);
        while($rand = mysql_fetch_object($rezultat))
        {
            $compname2 = $rand -> name;
            $compaddr = $rand -> compaddr;
            $complogo = $rand -> picture;
        }

        $imgnws = 'http://'.$_SERVER['SERVER_NAME'].'/'.$complogo;

        if(isset($_POST['submitnum']))
        {
            if(!is_numeric($_POST['nwsnum']))
            {
                $mesaj = "V&#259; rug&#259;m introduce&#355;i un num&#259;r &icirc;ntreg de &#351;tiri!";
            }
            else
            {
                $nwsnum = $_POST['nwsnum'];

                $mail = new PHPMailer();
                $mail->IsMail();
                $mail->AddReplyTo('newsletter@'.$_SERVER['SERVER_NAME'], 'newsletter@'.$_SERVER['SERVER_NAME']);
                $mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'], 'newsletter@'.$_SERVER['SERVER_NAME']);
                $mail->IsHTML(true); 

                $doSQL = "SELECT * FROM `newsletter` WHERE aprobat=1";  
                $rezultat = mysql_query($doSQL);
                while($rand = mysql_fetch_array($rezultat))
                {
                    $mail2 = clone $mail;
                    $mail2->AddAddress($rand['email']);

                    $cod = $rand['cod'];

                    $sql = "SELECT * FROM `stiri` ORDER BY id DESC LIMIT 0,".$nwsnum."";
                    $result = mysql_query($sql);

                    $nr=0;
                    $content = '<table border="0">';
                    while($rand = mysql_fetch_array($result))
                    {    
                        $nr++;
                        if($nr==1)
                            $titlu_mail = $rand['title'];

                        $content .='<tr><td><a href="http://"'.$_SERVER['SERVER_NAME'].'/stire_'.$rand['id'].'_'.$rand['permalink'].'.html"><img src="http://'.$_SERVER['SERVER_NAME'].'/'.$rand['picture'].'" width="50px"/></a></td>
                        <td><a href="http://'.$_SERVER['SERVER_NAME'].'/stire_'.$rand['id'].'_'.$rand['permalink'].'.html">'.$rand['title'].'</a></td></tr>';
                    }
                    $content .= '</table>';                                   

                    $mail2->Subject = $titlu_mail;
                    $cbody = '
                    <style type="text/css">
                    .stylewh {color: #fff;}
                    </style>
                    <table width="790" border="0" cellpadding="0" cellspacing="0" style="background: #f1f1f1;">
                    <tr>
                    <td bgcolor="#f1f1f1" valign="middle"><img src="'.$imgnws.'" alt="'.$compname2.'" />
                    <p style="text-align:right; float:right; color:#000000; font-family: Myriad Pro; font-size:36px; margin-right: 10px; font-weight:bold;">Newsletter</p>
                    </td>
                    </tr>
                    <tr>
                    <td bgcolor="#0099FF">&nbsp;</td>
                    </tr>
                    <tr>
                    <td><div style="margin-left:20px"> '.$content.' </div></td>
                    </tr>
                    <tr>
                    <th bgcolor="#0099FF" align="center"><span class="stylewh">Copyright&copy; '.$compname2.' Newsletter.</span></th>
                    </tr>
                    </table>';  

                    $mail2->MsgHTML($cbody.'<br/>Dac&#259; nu dori&#355;i s&#259; mai recep&#355;iona&#355;i acest newsletter, v&#259; pute&#355;i dezabona acces&acirc;nd acest link: <a href="http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?dezabonare='.$cod.'">http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?dezabonare='.$cod.'</a>. Nu r&#259;spunde&#355;i la acest e-mail! Pentru a v&#259; asigura c&#259; newsletter-ul ajunge &icirc;n Inbox, &#351;i nu &icirc;n Bulk / Spam, pute&#355;i ad&#259;uga aceast&#259; adres&#259; &icirc;n lista de contacte.');
                    $mail2->AltBody="Nu se poate afisa decat textul, fara imagini.";
                    if(!$mail2->Send())
                    {
                        echo "A aparut o eroare: " . $mail2->ErrorInfo;
                    }
                    else
                    {
                        $nrsnd++;
                    }
                }



                if($nrsnd == mysql_num_rows($rezultat))
                {
                    $mesaj = "Ultimele ".$nwsnum." stiri au fost trimise cu succes.";
                }
            }
        }


        if(isset($_POST['submit']))
        {
            if(is_valid($_POST['subiect']) && is_valid($_POST['mesaj']))
            {                      
                $doSQL = "SELECT * FROM `newsletter` WHERE aprobat=1";  
                $rezultat = mysql_query($doSQL);
                while($rand = mysql_fetch_array($rezultat))
                {
                    $nr++;
                    $emails[$nr] = $rand['email'];
                    $coduri[$nr] = $rand['cod'];
                }

                $mail = new PHPMailer();
                $mail->IsMail();
                $mail->AddReplyTo('noreply@'.$_SERVER['SERVER_NAME'], 'newsleter@'.$_SERVER['SERVER_NAME']);
                for($i=1; $i<=$nr; $i++) 
                    $mail->AddBCC($emails[$i]);
                $mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'], 'newsleter@'.$_SERVER['SERVER_NAME']);
                $mail->IsHTML(true);


                $subject = $_POST['subiect'];
                $message = $_POST['mesaj'];

                $mail->Subject = $subject;
                $mail->Body = <<<EOT
$message
EOT;
                if(!$mail->Send())
                {
                    echo "A aparut o eroare la trimitere: " . $mail->ErrorInfo;
                }
                else
                    $mesaj2 = "Newsletter-ul a fost trimis cu succes.";
            }
            else
                $mesaj2 = "Ambele c&acirc;mpuri sunt obligatorii.";
        }

        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "DELETE FROM `newsletter` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);
        }

        if(isset($_GET['cod']))
        {
            $cod = make_safe($_GET['cod']);

            $doSQL = "SELECT * FROM `newsletter` WHERE cod='".$cod."'";  
            $rezultat = mysql_query($doSQL);
            $rand = mysql_fetch_array($rezultat);
            $email = $rand['email'];

            $mail = new PHPMailer();
            $mail->IsMail();
            $mail->AddReplyTo('noreply@'.$_SERVER['SERVER_NAME'], 'noreply@'.$_SERVER['SERVER_NAME']);
            $mail->AddAddress($email);
            $mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'], 'noreply@'.$_SERVER['SERVER_NAME']);
            $mail->IsHTML(true);

            $message = '
            Acest mail a fost trimis automat, &icirc;ntruc&acirc;t a&#355;i solicitat abonarea la newsletter.<br/>

            Pentru activare, v&#259; rug&#259;m executa&#355;i click pe urm&#259;torul link: <a href="http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?activation='.$cod.'">http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?activation='.$cod.'</a> <br/>

            &Icirc;n cazul &icirc;n care nu a&#355;i solicitat abonarea, v&#259; rug&#259;m ignora&#355;i acest mail.
            ';

            $mail->Subject = 'Activare e-mail newsletter';
            $mail->Body = <<<EOT
$message
EOT;
            if(!$mail->Send())
            {
                echo "A aparut o eroare la trimitere: " . $mail->ErrorInfo;
            }
            else
                $mesaj2 = "Codul a fost retrimis cu succes.";

        }


        if($_POST['delete'])
        {
            $sql = "DELETE FROM `newsletter` WHERE id IN (".implode(',',$_POST['checkbox']).")";
            $result = mysql_query($sql);
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="libraries/editor/_samples/sample.css"  />
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
            <link type="text/css" href="css/confirm.css" rel="stylesheet" media="screen" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>

                        <!--FORMULAR 1-->

                        <?php if(isset($mesaj)) echo '<span class="smalltitle_red">'.$mesaj.'</span><br/>';?><br/>

                        <b>Trimitere newsletter cu ultimele &#351;tiri:</b><br/><br/> 
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            Num&#259;r &#351;tiri de trimis: <input type="text" name="nwsnum" value="" class="stfield"  data-validation-engine="validate[required[custom[integer]]]"/>&nbsp;
                            <input type="submit" name="submitnum" value="Trimitere newsletter" class="no-warn"/>
                        </form>

                        <!--FORMULAR 2-->

                        <br/>
                        <b>Trimitere newsletter particularizat:</b><br/>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <br/> <?php if(isset($mesaj2)) echo '<span class="smalltitle_red">'.$mesaj2.'</span><br/>';?> <br/>

                            Subiect:<br/><br/>
                            <input name="subiect" type="text" class="stfield" data-validation-engine="validate[required]"/><Br/><br/>
                            Con&#355;inut:<br/><br/>
                            <textarea class="ckeditor" cols="80" id="editor" name="mesaj" rows="10">
                                <style type="text/css">
                                    .stylewh {color: #fff;}
                                </style>
                                <table width="790" border="0" cellpadding="0" cellspacing="0" style="background: #f1f1f1;">
                                    <tr>
                                        <td bgcolor="#f1f1f1" valign="middle"><img src="<?php echo $imgnws;?>" alt="<?php echo $compname2;?>" />
                                            <p style="text-align:right; float:right; color:#000000; font-family: Myriad Pro; font-size:36px; margin-right: 10px; font-weight:bold;">Newsletter</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#0099FF">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td><div style="margin-left:20px"><?php echo $content ?></div></td>
                                    </tr>
                                    <tr>
                                        <th bgcolor="#0099FF" align="center"><span class="stylewh">Copyright&copy; <?php echo $compname2; ?> Newsletter.</span></th>
                                    </tr>
                                </table>
                            </textarea>
                            <br/>
                            <input name="submit" type="submit" value="Trimitere" class="no-warn"/>
                        </form>

                        <!--TABEL-->
                        <br/><br/>
                        <?php
                            $sql = "SELECT * FROM `newsletter`"; 
                            $result = mysql_query($sql);
                            $count=mysql_num_rows($result);
                            if(mysql_num_rows($result)>0)
                            {
                                $disp=1;
                            ?>
                            <form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" id="target">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <img src="images/arrow_ltr_v.png" style="vertical-align: middle;" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                <table width="100%" cellspacing="2" id="mytable" class="tablesorter">
                                    <thead>
                                        <tr class="part_header">
                                            <th width="2%">&nbsp;

                                            </th>
                                            <th>Email</th>
                                            <th>Cod</th>
                                            <th>Email confirmat</th>
                                            <th width="2%">Ac&#355;iuni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $numar=0;
                                            while($rand = mysql_fetch_object($result))
                                            {
                                                $numar++;
                                                echo'<tr>
                                                <td><input class="chkbox" name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$rand -> id.'"/></td>
                                                <td class="separate"><center>'.$rand -> email.'</center></td>
                                                <td class="separate"><center>'.$rand -> cod.'</center></td>
                                                <td class="separate">
                                                <center>';
                                                if($rand -> aprobat)
                                                    echo '<img src="images/tick.png" /> ';
                                                else
                                                    echo '<img src="images/collapse.png" /> ';
                                                echo '
                                                </center>
                                                </td>
                                                <td class="separate">
                                                <a title="Retrimitere Cod" href="newsletter.php?cod='.$rand -> cod.'">
                                                <img src="images/resend.png" border="0" /></a>
                                                <a title="Stergere" class="delete-link" href="newsletter.php?sterge='.$rand -> id.'" id="'.$rand -> id.'">
                                                <img src="images/del.png" border="0" />
                                                </a>
                                                </td>
                                                </tr>
                                                ';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <table width="100%">
                                    <tr class="part_header">
                                        <td>
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <img src="images/arrow_ltr.png" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                            </form>
                            <?php } else echo "Nu exista abonati.";?>
                        </td>
                        <td width="11%" style="height: 455px;"></td>
                        </tr>
                        </table>
                        </form>
                        <?php
                            if($disp==1)
                            {
                            ?>
                            <div id="pager" class="pager" >
                                <form>
                                    <img src="images/first.png" class="first"/>
                                    <img src="images/prev.png" class="prev"/>
                                    <input type="text" class="pagedisplay"/>
                                    <img src="images/next.png" class="next"/>
                                    <img src="images/last.png" class="last"/>
                                    <select class="pagesize">
                                        <option selected="selected"  value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                    </select>
                                </form>
                            </div>
                            <?php } ?>

                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="libraries/editor/ckeditor.js"></script>
            <script type="text/javascript" src="libraries/editor/_samples/sample.js"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js"  charset="utf-8"></script>   <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/pager.js"></script>                    
            <script type="text/javascript" src="js/newsletter.js"></script>                    
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>