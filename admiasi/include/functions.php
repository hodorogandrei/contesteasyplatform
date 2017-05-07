<?php

    error_reporting(E_ERROR | E_PARSE);
    //VERIFICARE TIMP SUBMIT SI TOKEN
    if(isset($_POST['token']))
    {
        if ($_POST['token'] !== $_SESSION['token']) 
        {
            die('Token invalid! Probabil a&#355;i ap&#259;sat butonul de refresh al navigatorului web. V&#259; pute&#355;i &icirc;ntoarce la pagina principal&#259; <a href="index.php">aici</a>, sau pute&#355;i s&#259; v&#259; <a href="logout.php">deloga&#355;i</a>.');
        }
        if((time() - $_SESSION['time']) < 5) 
        {
            die('Timpul de procesare al formularului a fost prea scurt. A&#351;tepta&#355;i minim 5 secunde &icirc;nainte de submit. V&#259; pute&#355;i &icirc;ntoarce la pagina principal&#259; <a href="index.php">aici</a>, sau pute&#355;i s&#259; v&#259; <a href="logout.php">deloga&#355;i</a>.');
        }
    }
    //VERIFICARE USER AGENT
    if (isset($_SESSION['HTTP_USER_AGENT']))
    {
        if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
        {
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/logout.php');
            exit;
        }
    }
    //VERIFICARE ULTIMUL IP
    if (isset($_SESSION['last_ip']))
    {
        if ($_SESSION['last_ip'] != get_ip())
        {
            session_start();
            session_destroy();
            session_unset();
            echo 'IP-ul a fost schimbat!. Este necesar s&#259; v&#259; <a href="index.php">reloga&#355;i</a>!';
        }
    }
    else
    {
        $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
    }

    function toAscii($str, $replace=array(), $delimiter='-') {
        if( is_valid($replace) ) 
        {
            $str = str_replace((array)$replace, ' ', $str);
        }
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        return $clean;
    }

    function convertToEntities($astr) {
        $bstr = '';
        for($i=0;$i<strlen($astr);$i++) {
            if (ord($astr[$i])>127) {
                $cstr = ord($astr[$i]);
                while (strlen($cstr)<4) {
                    $cstr .= '0';
                }
                $bstr .= '&#'.$cstr.';';
            }
            else {
                $bstr .= $astr[$i];
            }
        }
        return $bstr;
    }

    function firstnwords($string, $wordsreturned)
    {
        $retval = $string;
        $array = explode(" ", $string);
        if(count($array)<=$wordsreturned)
        {
            $retval = $string;
        }
        else
        {
            array_splice($array, $wordsreturned);
            $retval = implode(" ", $array)." ...";
        }
        return $retval;
    }

    function make_safe($value)
    {
        $value = trim($value);
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
        $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
        $value = strip_tags($value);
        $value = mysql_real_escape_string($value);
        $value = htmlspecialchars ($value);
        return $value;
    }


    function addentities($data){
        if(trim($data) != ''){
            $data = htmlentities($data, ENT_QUOTES);
            return str_replace('\\', '&#92;', $data);
        } else return $data;
    }

    //functie fara mysql_real_escape_string
    function make_safe_lite($value)
    {
        $value = trim($value);
        if (get_magic_quotes_gpc())
        {
            $value = stripslashes($value);
        }
        $value = strtr($value,array_flip(get_html_translation_table(HTML_ENTITIES)));
        $value = strip_tags($value);
        $value = htmlspecialchars ($value);
        return $value;
    }

    function validateURL($URL) {
        $v = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        return (bool)preg_match($v, $URL);
    }

    function full_url()
    {
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    }
    $actual_link = full_url();

    function is_valid($str)
    {
        if((!ctype_space($str)) && (!empty($str)))
            return 1;
        return 0;
    }

    function display_message($mesaj)
    {							
        if(isset($mesaj))
        {
            echo '<div class="smalltitle_red">';
            echo $mesaj;
            echo '</div><br/>';
        }
    }

    function display_message_inline($mesaj)
    {							
        if(isset($mesaj))
        {
            echo '<span class="smalltitle_red">';
            echo $mesaj;
            echo '</span>';
        }
    }

    function print_var_value($var) {
        foreach($GLOBALS as $var_name => $value) {
            if ($var_name == $var) {
                return $value;
            }
        }
        return false;
    }

    function check_isset($str)
    {
        if(!isset($_POST[''.$str.''])) echo print_var_value($str); else echo $_POST[''.$str.''];
    }

    function check_field($okvar, $fieldname)
    {
        if((isset($okvar)) && ($okvar==0) && (!is_valid($_POST[''.$fieldname.''])))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function check_field_fileb($okvar)
    {
        if((isset($okvar)) && ($okvar==0))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function valid_name($value)
    {
        if(preg_match("/^[a-z-]+$/", $value))
            return 1;
        return 0;
    }

    function check_field_name($okvar, $fieldname)
    {
        if((isset($okvar)) && ($okvar==0) && (!valid_name($_POST[''.$fieldname.''])))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function check_field_file($okvar)
    {
        if((isset($okvar)) && ($okvar==0) && (!$_POST['admfile']!='editare-'))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function check_field_clasa($okvar)
    {
        if((isset($okvar)) && ($okvar==0) && (!is_valid($_POST['clasa'])))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function check_field_judet($okvar)
    {
        if((isset($okvar)) && ($okvar==0) && (!is_valid($_POST['judet'])))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
    }

    function noscript_text($str)
    {
        echo '<noscript><img src="images/stop.png" class="midalign" />&nbsp;<span class="smalltitle_grey"><i>'.$str.'</i></span></noscript>';
    }

    function noscript_text_default()
    {
        echo '<noscript><img src="images/stop.png" class="midalign" />&nbsp;<span class="smalltitle_grey"><i>Nu se poate edita dec&acirc;t cu Javascript activat.</i></span></noscript>';
    }

    function scrypt($password)
    {
        $salt = sha1("contesteasyplatform");
        $salt = substr($salt, 0, 4);
        $hash = base64_encode( sha1($password . $salt, true) . $salt );
        return $hash;
    }

    function check_perm($str)
    {
        $sql = 'SELECT * FROM `usrperm` WHERE id_user = '.$_SESSION['userid'].'';
        $result = mysql_query($sql);
        while($rand = mysql_fetch_array($result))
            if($rand['permisiune'] == 1)
            {
                $result2 = mysql_query('SELECT * FROM pagini WHERE id = '.$rand['pagina'].'');
                while($rand2 = mysql_fetch_array($result2))
                {
                    if(!strcmp($rand2['pagina'],$str))
                        return 1;
                }
            }
            return 0;
    }

    function show_login_info()
    {
        echo'
        <img src="images/userlog.png" class="midalign" />&nbsp;Sunte&#355;i logat(&#259;) ca: <span style=""><b><i><a href="pagina-personala.php">'; 
        echo $_SESSION['nume'];
        echo'</a></i></b></span><br/><br/>
        <img src="images/clock.png" class="midalign" />&nbsp;Ultima autentificare: <i>'; 
        if(isset($_SESSION['last_login']) && !empty($_SESSION['last_login'])) { echo $_SESSION['last_login']; } else echo 'niciodat&#259;';
        echo'</i><br/><br/>
        <a href="logout.php" title="Logout"><img src="images/logout.png" class="midalign" border="0"/></a>&nbsp;<a href="logout.php">Delogare</a>
        ';
    }

    function get_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
            $ip=$_SERVER['HTTP_CLIENT_IP'];

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

        else
            $ip=$_SERVER['REMOTE_ADDR'];

        return $ip;
    }

    function iptocountry($ip) {   
        $numbers = preg_split( "/\./", $ip);   
        include("ip2country_files/".$numbers[0].".php");
        $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);   
        foreach($ranges as $key => $value){
            if($key<=$code){
                if($ranges[$key][0]>=$code){$country=$ranges[$key][1];break;}
            }
        }
        if ($country==""){$country="unkown";}
        return $country;
    }

    function check_ext_img($ext)
    {
        $arr = array('jpg','jpeg','png','gif','bmp','JPG','JPEG');
        if(in_array($ext, $arr) ? $ok = 1 : $ok = 0);
        return $ok;
    }

    function link_oras($idoras)
    {
        $doSQL = "SELECT * FROM `orase` WHERE id='".$idoras."'"; 
        $rezultat = mysql_query($doSQL);
        $rand = mysql_fetch_object($rezultat);
        $oras = $rand->nume;
        return $oras;
    }

    function link_oras2($idoras)
    {
        $doSQL = "SELECT * FROM `orase` WHERE id='".$idoras."'"; 
        $rezultat = mysql_query($doSQL);
        $rand = mysql_fetch_object($rezultat);
        $oras = $rand -> nume2;
        return $oras;
    }

    function get_all_string_between($string, $start, $end)
    {
        $string = " ".$string;
        $offset = 0;
        while(true)
        {
            $ini = strpos($string,$start,$offset);
            if ($ini == 0)
                break;
            $ini += strlen($start);
            $len = strpos($string,$end,$ini) - $ini;
            $result = substr($string,$ini,$len);
            $offset = $ini+$len;
        }
        return $result;
    }

    function link_judet($str)
    {
        $sql = "SELECT * FROM `judete` WHERE judet='".$str."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $id = $row['id'];
        return $id;
    }

    function link_judet_rev($str)
    {
        $sql = "SELECT * FROM `judete` WHERE id='".$str."'";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $judet = $row['judet'];
        return $judet;
    }
    
    function test_control_number($cnp) {
        if((int) strlen($cnp) !== (int) 13) return FALSE;
        $test_key = 279146358279;
        $cnp_tst = substr($cnp, 0, 12);
        $cnp_ctrl = (int) substr($cnp, 12, 1);
        $response = '';
        for($x = 0; $x < 12; $x++) {
            $response = $response + ((int) substr($test_key, $x, 1) * (int) substr($cnp_tst, $x, 1));
        }
        return ((int) $response%11 === $cnp_ctrl) ? TRUE : FALSE;
    }

    function test_cnp($cnp) {
        if((int) strlen($cnp) !== (int) 13) return FALSE;
        if((int) substr($cnp, 3, 2) > 12) return FALSE;
        if((int) substr($cnp, 5, 2) > 31) return FALSE;
        return test_control_number($cnp);
    }

    include("chat.php");

?>