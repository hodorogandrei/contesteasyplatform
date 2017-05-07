<?php
require_once('../include/config.php');
require_once('../include/functions.php');
error_reporting(0);
$sql  = 'SELECT * FROM users WHERE username = "'.make_safe($_REQUEST['username']).'"';
$result = mysql_num_rows(mysql_query($sql));

if($result > 0)
	echo '<img src="images/collapse.png" style="vertical-align: middle;"/>Nume de utilizator deja existent';
else
	echo '<img src="images/tick.png" style="vertical-align: middle;" />Nume disponibil';
?>