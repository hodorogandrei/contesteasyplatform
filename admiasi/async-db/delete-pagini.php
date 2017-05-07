<?php
	require_once('../include/config.php');
	if($_POST)
	{
		$checkbox = $_POST['checkbox'];
		$countCheck = count($_POST['checkbox']);
		for($i=0;$i<$countCheck;$i++)
		{
			$del_id = $checkbox[$i];
			$sql = 'SELECT * FROM onipag WHERE id='.$del_id.'';
			$result = mysql_query($sql);
			$rand = mysql_fetch_object($result);
			unlink('../'.$rand->userfile.'');
			unlink('../'.$rand->admfile.'');
			
			$sql = "DELETE FROM onipag WHERE id=".$del_id."";
			mysql_query($sql);
		}
        $sql = 'SELECT * FROM `onipag`';
        if(mysql_num_rows(mysql_query($sql))==5)
            echo 'gol';
	}
?>