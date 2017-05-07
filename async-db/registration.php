<?php
require_once("../include/config.php");
require_once("../include/functions.php");
require_once("class.phpmailer.php");

error_reporting(0);

    if($_POST)
    {
        $username = make_safe($_POST['username']);
//        echo $username.'<br/>';
        $password = scrypt($_POST['password']);
//        echo $password.'<br/>';
        $nume = make_safe($_POST['nume']);
//        echo $nume.'<br/>';
        $prenume = make_safe($_POST['prenume']);
//        echo $prenume.'<br/>';
        $clasa = make_safe($_POST['clasa']);
//        echo $clasa.'<br/>';
        $email = make_safe($_POST['email']);
//        echo $email.'<br/>';
        $cnp = make_safe($_POST['cnp']);
//        echo $cnp.'<br/>';
        $clasa = make_safe($_POST['clasa']);
//        echo $clasa.'<br/>';
        $judet = link_judet_rev(make_safe($_POST['judet'])); 
//        echo $judet.'<br/>';
        if(is_valid($username) && is_valid($password) && is_valid($nume) && is_valid($prenume) && is_valid($email) && is_valid($cnp) && is_valid($judet) && is_valid($clasa))
        {
            $sql = "SELECT * FROM `users` WHERE username='$username'";
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
                    $cod = get_rand_id(25);
                    $sql = "INSERT INTO `users` (`username`, `pass`, `nume`, `prenume`, `email`, `cnp`, `judet`, `clasa`, `cod`) 
                    VALUES ('".$username."', 
                    '".$password."', 
                    '".$nume."',
                    '".$prenume."',
                    '".$email."', 
                    '".$cnp."', 
                    '".$judet."', 
                    '".$clasa."', 
                    '".$cod."')";
                    mysql_query($sql);
                    echo '<br/>';
                    $mesaj = "<div style=\"margin: 10px;\"><strong>Contul dumneavoastr&#259; a fost creat. V&#259; rug&#259;m s&#259; a&#351;tepta&#355;i aprobarea de c&#259;tre un administrator. De asemenea, v&#259; rug&#259;m s&#259; v&#259; verifica&#539;i Inbox-ul pentru validarea adresei de e-mail.</strong></div>";

                    $msg='Acest mail a fost trimis automat intrucat ati solicitat crearea unui cod pe site-ul competitiei.<br/>

                    Pentru activarea contului dumneavoastra, click pe urmatorul link: <a href="http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'" target="_blank">http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.'</a><br/>

                    In cazul in care nu ati solicitat inregistrarea, ignorati acest mail.

                    ';    

                    $mail = new PHPMailer();
                    $mail->IsMail();
                    $mail->AddReplyTo('noreply@'.$_SERVER['SERVER_NAME'].'', 'noreply@'.$_SERVER['SERVER_NAME'].'');
                    $mail->AddAddress($email);
                    $mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'].'', 'noreply@'.$_SERVER['SERVER_NAME'].'');
                    $mail->Subject = "Confirmare E-Mail";
                    $mail->MsgHTML($msg);
                    $mail->Send();
                    echo $mesaj;
                }
                else
                {
                    $mesaj = 'Adres&#259; de e-mail invalid&#259;!';
                    echo $mesaj;
                }
            }
        }
        else
        {
            $ok=0;
            $mesaj = 'Toate c&acirc;mpurile sunt obligatorii!';
            echo $mesaj;
        }
    }
?>