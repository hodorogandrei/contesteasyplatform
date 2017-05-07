<?php
    require_once('../include/config.php');
    require_once('../include/functions.php');
    error_reporting(0);

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
    if($_POST)
    {
        if(test_cnp($_POST['cnp'])=='TRUE')
            echo '<img src="images/tick.png" style="vertical-align: middle;"/>&nbsp;CNP valid';
        else
            echo '<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;CNP invalid';

    }
?>