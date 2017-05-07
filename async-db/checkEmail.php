<?php
require_once('../include/config.php');
require_once('../include/functions.php');
error_reporting(0);   
$sql  = 'SELECT * FROM users WHERE email = "'.make_safe($_REQUEST['email']).'"';
$result = mysql_num_rows(mysql_query($sql));

if($result > 0)
	echo '<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;Adres&#259; deja existent&#259;';
else
	echo '<img src="images/tick.png" style="vertical-align: middle;"/>&nbsp;Adres&#259; disponibil&#259;';
?>