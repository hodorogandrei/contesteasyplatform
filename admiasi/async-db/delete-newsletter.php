<?php
	require_once("../include/config.php");
	if($_POST)
	{
		$sql = "DELETE FROM `newsletter` WHERE id IN (".implode(',',$_POST['checkbox']).")";
		mysql_query($sql);
        
        $sql = 'SELECT * FROM `newsletter`';
        if(mysql_num_rows(mysql_query($sql))==0)
            echo 'gol';
	}
?>