<?php
    error_reporting(E_ERROR  | E_PARSE);

    require_once("libraries/class.phpmailer.php");


    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }
    ob_start('callback');

    include_once("include/header.php"); 

    $titlu = '&Icirc;nregistrare';

    $doSQL = 'SELECT * FROM `general` WHERE id=1'; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_array($rezultat))
    {
        $compname = $rand['name'];
        $compaddr = $rand['compaddr'];
    }

    //activare e-mail
    if(isset($_GET['activation']))
    {
        $cod = $_GET['activation'];
        $query="UPDATE users SET validmail=1 where cod='$cod'";
        mysql_query($query);
        $mesaj = 'Adresa dumneavoastr&#259; de e-mail a fost validat&#259;. Va rug&#259;m s&#259; a&#351;tepta&#355;i aprobarea contului de c&#259;tre un administrator.';
        echo'<meta http-equiv="refresh" content="3;url=index.php" />';
    }	  
    //sfarsit activare e-mail

    if(isset($_POST['submit']))
    {
        $username = make_safe($_POST['username']);
        $password = scrypt($_POST['password']);
        $nume = make_safe($_POST['nume']);
        $prenume = make_safe($_POST['prenume']);
        $email = make_safe($_POST['email']);
        $cnp = make_safe($_POST['cnp']);
        if(is_valid($username) && is_valid($password) && is_valid($nume) && is_valid($prenume) && is_valid($email) && is_valid($cnp))
        {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());;
            if(mysql_num_rows($result)>0)
            {
                $mesaj = "<strong>Numele de utilizator specificat deja exist&#259;!.</strong>";
            }
            else
            {
                $sql = "SELECT * FROM `users` WHERE email='$email'";
                $result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());;
                if(mysql_num_rows($result)>0)
                {
                    $mesaj = "<strong>Adresa de e-mail specificat&#259; deja exist&#259;!.</strong>";
                }
                elseif(filter_var($email, FILTER_VALIDATE_EMAIL)) 
                {
                    //TOTUL VALID:
                    $cod = generatecode(25);
                    $sql = "INSERT INTO `users` (`username`, `pass`, `nume`, `prenume`, `email`, `cnp`, `cod`) 
                    VALUES ('".$username."', 
                    '".$password."', 
                    '".$nume."',
                    '".$prenume."',
                    '".$email."', 
                    '".$cnp."', 
                    '".$cod."')";
                    mysql_query($sql);

                    $mesaj = "<strong>Contul dumneavoastr&#259; a fost creat. V&#259; rug&#259;m s&#259; a&#351;tepta&#355;i aprobarea de c&#259;tre un administrator. De asemenea, v&#259; rug&#259;m s&#259; v&#259; verifica&#539;i Inbox-ul pentru validarea adresei de e-mail.</strong>";

                    $msg='Acest mail a fost trimis automat intrucat ati solicitat crearea unui cod pe site-ul competitiei.<br/>

                    Pentru activarea contului dumneavoastra, click pe urmatorul link: <a href="http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'" target="_blank">http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'</a><br/>

                    In cazul in care nu ati solicitat inregistrarea, ignorati acest mail.
                    ';    

                    $mail = new PHPMailer();
                    $mail->IsMail();
                    $mail->AddReplyTo('noreply@'.$_SERVER['SERVER_NAME'].'', $compname);
                    $mail->AddAddress($email);
                    $mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'].'', $compname);
                    $mail->Subject = "Confirmare E-Mail";
                    $mail->MsgHTML($msg);
                    $mail->Send();
                }
                else
                {
                    $mesaj = 'Adres&#259; de e-mail invalid&#259;!';
                }
            }
        }
        else
        {
            $ok=0;
            $mesaj = 'C&acirc;mpurile marcate cu * sunt obligatorii!';
        }
    }

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
            <br/>
            <?php display_message($mesaj);?>
            <?php
                if(!isset($_SESSION['logat_user']))
                {
                ?>
                <div id="container">
                    <form action="#" method="post" id="register">

                        <!-- #first_step -->
                        <div id="first_step">

                            <div class="form">
                                <h2>Datele contului t&#259;u</h2>
                                <input type="text" name="username" id="username" value="username" />
                                <label for="username" id="msg_username">Alege un nume de utilizator de cel pu&#355;in 4 caractere.</label>

                                <input type="password" name="password" id="password" value="password" />
                                <label for="password">Alege o parol&#259; de cel pu&#355;in 4 caractere.</label>

                                <input type="password" name="cpassword" id="cpassword" value="password" />
                                <label for="cpassword">Confirm&#259; parola.</label>
                            </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
                            <input class="submit" type="submit" name="submit_first" id="submit_first" value="" />
                        </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


                        <!-- #second_step -->
                        <div id="second_step">

                            <div class="form">
                                <h2>Date personale</h2>
                                <input type="text" name="nume" id="nume" value="nume" />
                                <label for="nume">Numele t&#259;u. </label>
                                <input type="text" name="prenume" id="prenume" value="prenume" />
                                <label for="prenume">Prenumele t&#259;u. </label>
                                <input type="text" name="email" id="email" value="email" />
                                <label for="email" id="msg_email">Adresa ta de e-mail, prin intermediul c&#259;reia vei comunica cu administratorii &#351;i comisia.</label>                    
                            </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
                            <input class="submit" type="submit" name="submit_second" id="submit_second" value="" />
                        </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


                        <!-- #third_step -->
                        <div id="third_step">

                            <div class="form">
                                <h2>Date de identificare</h2>
                                <select id="clasa" name="clasa">
                                    <option value="">Selecteaz&#259; o clas&#259;</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                </select>
                                <label for="clasa" id="msg_clasa">Clasa la care participi &icirc;n competi&#355;ie.</label> <!-- clearfix --><div class="clear"></div><!-- /clearfix -->

                                <select name="judet" id="judet">
                                    <option selected="selected" value="">Selecteaz&#259; un jude&#355;</option>
                                    <?php 
                                        $sql = "SELECT * FROM `judete`";
                                        $result = mysql_query($sql);
                                        while($rand = mysql_fetch_object($result))
                                        {
                                            echo '<option value="'.$rand -> id.'">'.$rand -> judet.'</option>';
                                            echo "\n";
                                        }
                                    ?>
                                </select>
                                <label for="judet" id="msg_judet">Jude&#355;ul t&#259;u.</label> <!-- clearfix --><div class="clear"></div><!-- /clearfix -->

                                <input id="cnp" name="cnp" type="text" value="CNP"/>
                                <label for="cnp" id="msg_cnp">Codul numeric personal. </label> <!-- clearfix --><div class="clear"></div><!-- /clearfix -->

                            </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
                            <input class="submit" type="submit" name="submit_third" id="submit_third" value="" />

                        </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


                        <!-- #fourth_step -->
                        <div id="fourth_step">

                            <div class="form">
                                <h2>Toate datele tale</h2>

                                <table>
                                    <tr><td>Nume utilizator</td><td></td></tr>
                                    <tr><td>Email</td><td></td></tr>
                                    <tr><td>Nume, Prenume</td><td></td></tr>
                                    <tr><td>Clas&#259;</td><td></td></tr>
                                    <tr><td>Jude&#355;</td><td></td></tr>
                                    <tr><td>CNP</td><td></td></tr>
                                </table>
                            </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
                            <input class="send submit" type="submit" name="submit_fourth" id="submit_fourth" value="" />            
                        </div>

                    </form>
                </div>
                <div id="progress_bar">
                    <div id="progress"></div>
                    <div id="progress_text">0% Completat</div>
                </div>
            </div>
            <?php
            }
            else
            {
            ?>
            <br/><br/><center>Pentru a crea un nou cont este necesar mai intai sa va delogati!</center>
            <?php } ?>
    </div>
</div>             

<link href="css/smart_wizard2.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/inputfocus.js"></script>
<script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
<script type="text/javascript" src="js/signup.js" charset="utf-8"></script>

<?php
    include_once("include/footer.php");
    ob_end_flush();
?>