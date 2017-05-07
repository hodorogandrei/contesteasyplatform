<?php      
    require_once("include/config.php");
    require_once("include/functions.php"); 

    if(isset($_GET['activation']))
    {
        $cod = $_GET['activation'];
        $query="UPDATE `newsletter` SET aprobat=1 WHERE cod='$cod'";
        mysql_query($query);

        echo "Adresa dumneavoastr&#259; de e-mail a fost aprobat&#259;. V&#259; mul&#355;umim pentru abonare! <br/><br/><i>Ve&#355;i fi redirec&#355;ionat(&#259;) &icirc;n scurt timp...</i>";
        echo '<meta http-equiv="refresh" content="3;url=index.php" />';
    }


    if(isset($_GET['dezabonare']))
    {
        $cod = $_GET['dezabonare'];
        $query = "DELETE FROM `newsletter` WHERE cod='$cod'";
        mysql_query($query);

        echo "Dezabonare realizat&#259;! V&#259; mul&#355;umim pentru ineteresul acordat newsletter-ului! <br/><br/><i>Ve&#355;i fi redirec&#355;ionat(&#259;) &icirc;n scurt timp...</i>";
        echo '<meta http-equiv="refresh" content="3;url=index.php" />';
    }


    if(isset($_POST['email']))
    {
        if(empty($_POST['email']))
            echo "V&#259; rug&#259;m s&#259; introduce&#355;i o adres&#259; de email!";
        else
        {
            $ok=1;

            $query = "SELECT * FROM `newsletter`";
            $result = mysql_query($query);
            while($rand = mysql_fetch_array($result))
            {
                if($_POST['email'] == $rand['email'])
                    $ok=0;
            }
            if($ok == 0)
                echo "Aceast&#259; adres&#259; exist&#259; deja &icirc;n baza noastr&#259; de date.";


            elseif(checkEmail($_POST['email']))
            {
                $emailAddress = $_POST['email'];

                require "libraries/class.phpmailer.php";
                session_name("newsletter");

                $cod = get_rand_id(25);

                $doSQL = "INSERT INTO `newsletter` (`email`, `cod`)
                VALUES ('".$emailAddress."', '".$cod."')";
                mysql_query($doSQL);

                $msg='
                Acest mail a fost trimis automat, &icirc;ntruc&acirc;t a&#355;i solicitat abonarea la newsletter.<br/>

                Pentru activare, v&#259; rug&#259;m executa&#355;i click pe urm&#259;torul link: <a href="http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?activation='.$cod.'">http://'.$_SERVER["SERVER_NAME"].'/newsletter.php?activation='.$cod.'</a> <br/>

                &Icirc;n cazul &icirc;n care nu a&#355;i solicitat abonarea, v&#259; rug&#259;m ignora&#355;i acest mail.

                ';

                echo 'Va rugăm să confirmaţi abonarea la newsletter. Pentru aceasta, veţi primi în scurt timp un e-mail cu un link de confirmare.';

                $sql = "SELECT * FROM `general` WHERE id=1";
                $result = mysql_query($sql); 
                $rand = mysql_fetch_object($result);
                $compname = $rand -> name;

                $mail = new PHPMailer();
                $mail->IsMail();
                $mail->AddReplyTo('noreply@'.$_SERVER["SERVER_NAME"], 'noreply@'.$_SERVER["SERVER_NAME"]);
                $mail->AddAddress($emailAddress);
                $mail->SetFrom('noreply@'.$_SERVER["SERVER_NAME"], 'noreply@'.$_SERVER["SERVER_NAME"]);
                $mail->Subject = "Activare e-mail newsletter";
                $mail->MsgHTML($msg);
                $mail->Send();
            }
            else 
                echo 'Adresa "' .$_POST['email']. '" nu este valid&#259;.';
        } 
    }  
?>