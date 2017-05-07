<?php
    function full_url()
    {
        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
        $protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
    }
    $actual_link = full_url();



    function display_message($mesaj)
    {							
        if(isset($mesaj))
        {
            echo '<div class="smalltitle_red">';
            echo $mesaj;
            echo '</div><br/>';
        }
    }



    function check_isset($str)
    {
        if(!isset($_POST[''.$str.''])) echo $$str; else echo $_POST[''.$str.''];
    }



    function check_field($okvar, $fieldname)
    {
        if((isset($okvar)) && ($okvar==0) && (!is_valid($_POST[''.$fieldname.''])))
        {
            echo '<span class="smalltitle_red">*</span>&nbsp;';
        }
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



    function is_valid($str)
    {
        if((!ctype_space($str)) && (!empty($str)))
            return 1;
        return 0;
    }



    function assign_rand_value($num)
    {
        // accepts 1 - 36
        switch($num)
        {
            case "1":
                $rand_value = "a";
                break;
            case "2":
                $rand_value = "b";
                break;
            case "3":
                $rand_value = "c";
                break;
            case "4":
                $rand_value = "d";
                break;
            case "5":
                $rand_value = "e";
                break;
            case "6":
                $rand_value = "f";
                break;
            case "7":
                $rand_value = "g";
                break;
            case "8":
                $rand_value = "h";
                break;
            case "9":
                $rand_value = "i";
                break;
            case "10":
                $rand_value = "j";
                break;
            case "11":
                $rand_value = "k";
                break;
            case "12":
                $rand_value = "l";
                break;
            case "13":
                $rand_value = "m";
                break;
            case "14":
                $rand_value = "n";
                break;
            case "15":
                $rand_value = "o";
                break;
            case "16":
                $rand_value = "p";
                break;
            case "17":
                $rand_value = "q";
                break;
            case "18":
                $rand_value = "r";
                break;
            case "19":
                $rand_value = "s";
                break;
            case "20":
                $rand_value = "t";
                break;
            case "21":
                $rand_value = "u";
                break;
            case "22":
                $rand_value = "v";
                break;
            case "23":
                $rand_value = "w";
                break;
            case "24":
                $rand_value = "x";
                break;
            case "25":
                $rand_value = "y";
                break;
            case "26":
                $rand_value = "z";
                break;
            case "27":
                $rand_value = "0";
                break;
            case "28":
                $rand_value = "1";
                break;
            case "29":
                $rand_value = "2";
                break;
            case "30":
                $rand_value = "3";
                break;
            case "31":
                $rand_value = "4";
                break;
            case "32":
                $rand_value = "5";
                break;
            case "33":
                $rand_value = "6";
                break;
            case "34":
                $rand_value = "7";
                break;
            case "35":
                $rand_value = "8";
                break;
            case "36":
                $rand_value = "9";
                break;
        }

        return $rand_value;
    }



    function get_rand_id($length)
    {
        if($length>0) 
        { 
            $rand_id="";
            for($i=1; $i<=$length; $i++)
            {
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,36);
                $rand_id .= assign_rand_value($num);
            }
        }
        return $rand_id;

    }



    function scrypt($str)
    {
        $salt = substr(str_replace('+', '.', base64_encode(sha1($str, true))), 0, 22);
        $hash = crypt($str, '$2a$12$' . $salt);
        return $hash;
    }




    function addentities($data){
        if(trim($data) != ''){
            $data = htmlentities($data, ENT_QUOTES);
            return str_replace('\\', '&#92;', $data);
        } else return $data;
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


    function checkEmail($str)
    {
        return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
    }

    function link_judet_rev($str)
    {
        $sql = "SELECT * FROM `judete` WHERE id=".$str."";
        $result = mysql_query($sql);
        $row = mysql_fetch_array($result);
        $judet = $row['judet'];
        return $judet;
    }
?>