<?php
    require_once("../include/config.php");
    require_once("include/functions.php"); 

    function initCounter() {

        $ip = $_SERVER['REMOTE_ADDR']; 
        $location = make_safe($_GET['id']);

        $create_log = mysql_query("INSERT INTO `counter` (ip,location) VALUES ('$ip', '$location')");
    }

    function getCounter($mode, $location = NULL) {

        if(is_null($location)) {
            $location = make_safe($_GET['id']);
        }

        if($mode == "unique") {
            $get_res = mysql_query("SELECT COUNT(DISTINCT ip) AS amt FROM counter WHERE location = '$location' ");
        }else{
            $get_res = mysql_query("SELECT COUNT(ip) AS amt FROM counter WHERE location = '$location' ");
        }

        $res = mysql_fetch_assoc($get_res);

        return $res['amt'];

    }

?>