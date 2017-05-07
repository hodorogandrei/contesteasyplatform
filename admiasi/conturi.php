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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare conturi"));
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


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "DELETE FROM `users` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);
        }

        if(isset($_GET['cod']))
        {
            $cod = make_safe($_GET['cod']);

            $doSQL = "SELECT * FROM `users` WHERE cod='".$cod."'";  
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
            Acest mail a fost trimis automat intrucat ati solicitat crearea unui cod pe site-ul competitiei.<br/>

            Pentru activarea contului dumneavoastra, click pe urmatorul link: <a href="http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'" target="_blank">http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'</a><br/>

            In cazul in care nu ati solicitat inregistrarea, ignorati acest mail.
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
            $sql = "DELETE FROM `users` WHERE id IN (".implode(',',$_POST['checkbox']).")";
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
                        <!--TABEL-->
                        <br/>
                        <b>Administrare conturi:</b>
                        <br/><br/>
                        <?php
                            $sql = "SELECT * FROM `users`"; 
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
                                            <th>Username</th>
                                            <th>Nume</th>
                                            <th>Prenume</th>
                                            <th>Email</th>
                                            <th>Email confirmat</th>
                                            <th>CNP</th>
                                            <th>Clasa</th>
                                            <th>Jude&#355;</th>
                                            <th>Aprobat</th>
                                            <th width="8%">Ac&#355;iuni</th>
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
                                                <td class="separate"><center>'.$rand -> username.'</center></td>
                                                <td class="separate"><center>'.$rand -> nume.'</center></td>
                                                <td class="separate"><center>'.$rand -> prenume.'</center></td>
                                                <td class="separate"><center>'.$rand -> email.'</center></td>
                                                <td class="separate"><center>';
                                                if($rand -> validmail)
                                                    echo '<img src="images/tick.png" /> ';
                                                else
                                                    echo '<img src="images/collapse.png" /> ';
                                                echo '
                                                </center></td>
                                                <td class="separate"><center>'.$rand -> cnp.'</center></td>
                                                <td class="separate"><center>'.$rand -> clasa.'</center></td>
                                                <td class="separate"><center>'.$rand -> judet.'</center></td>
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
                                                <a title="Retrimitere Cod" href="conturi.php?cod='.$rand -> cod.'">
                                                <img src="images/resend.png" border="0" /></a>
                                                <a title="Editare" href="editare-cont.php?id='.$rand -> id.'">
                                                <img src="images/edit.png" border="0" /></a>
                                                <a title="Stergere" class="delete-link" href="conturi.php?sterge='.$rand -> id.'" id="'.$rand -> id.'">
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
                            <?php } else echo "Nu exista utilizatori &icirc;nregistra&#355;i.";?>
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
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/pager.js"></script>                    
            <script type="text/javascript" src="js/conturi.js"></script>                    
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>