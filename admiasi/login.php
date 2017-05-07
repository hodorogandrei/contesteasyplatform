<?php	
    require_once("include/config.php");
    require_once("include/functions.php");
	/*
    require_once("libraries/recaptchalib.php");
    $privatekey = "6LczbtQSAAAAAGJY3Ezv0bP94rwmbt2H5vs1l5br";
    $resp = recaptcha_check_answer ($privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) { echo 'Cod CAPTCHA incorect!'; }
    else
    {
	*/
        $user = make_safe($_POST['user']);
        $pass = make_safe($_POST['pass']);

        $_SESSION['logat'] = 'Nu';
        $sql = "SELECT * FROM `usrs2012` WHERE username='".$user."' AND pass='".scrypt($pass)."'";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) > 0)
        {

            $rand = mysql_fetch_array($result);
            $_SESSION['logat'] = 'Da';
            $_SESSION['userid'] = $rand['id'];
            $_SESSION['nume'] = $user;
            $_SESSION['token'] = uniqid(md5(microtime()), true);
            $_SESSION['global'] = $rand['global'];
            $_SESSION['createdby'] = $rand['createdby'];
            $_SESSION['createdby_id'] = $rand['createdby_id'];
            $_SESSION['last_login'] = $rand['last_login'];
            $_SESSION['last_ip'] = get_ip();
            $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

            $sql = "UPDATE 
            `usrs2012` 
            SET
            online='1'
            WHERE id = '".$_SESSION['userid']."'";
            mysql_query($sql);

            echo 1;
            if(isset($_POST['js_disabled']) && $_POST['js_disabled']==1)
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
        else
        {
            echo 0;
            if(isset($_POST['js_disabled']) && $_POST['js_disabled']==1)
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
   // }
?>