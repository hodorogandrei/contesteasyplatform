<?php	
    require_once("include/config.php");
    require_once("include/functions.php");
    require_once("libraries/recaptchalib.php");
    $privatekey = "6LczbtQSAAAAAGJY3Ezv0bP94rwmbt2H5vs1l5br";
    $resp = recaptcha_check_answer ($privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) { echo 'Cod CAPTCHA incorect!'; }
    else
    {
        $user = make_safe($_POST['user']);
        $pass = make_safe($_POST['pass']);

        $_SESSION['logat_user'] = 'Nu';
        $sql = "SELECT * FROM `users` WHERE username='".$user."' AND pass='".scrypt($pass)."'";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) > 0)
        {
            $rand = mysql_fetch_array($result);
            if($rand['aprobat']==1)
            {
                $_SESSION['logat_user'] = 'Da';
                $_SESSION['nume_user'] = $user;
                $_SESSION['token_user'] = uniqid(md5(microtime()), true);
                $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

                echo 1;
                if(isset($_POST['js_disabled']) && $_POST['js_disabled']==1)
                    echo '<meta http-equiv="refresh" content="0;URL=index.php">';    
            }
            else
                echo 'Contul nu a fost aprobat!';
        }
        else
        {
            echo 0;
            if(isset($_POST['js_disabled']) && $_POST['js_disabled']==1)
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
    }
?>