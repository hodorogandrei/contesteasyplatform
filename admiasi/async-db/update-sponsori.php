<?php
    require_once('../include/config.php');
	require_once('../include/functions.php');
	if ($_POST) {
		$ids = $_POST["ids"];
		for ($idx = 0; $idx < count($ids); $idx++) {
			$id = $ids[$idx];
			$ordinal = make_safe($idx);
			$query="UPDATE `sponsori` SET ordine='$ordinal' WHERE id='$id'";
			mysql_query($query);
		}
		
		
		$checkbox = $_POST['checkbox'];
		$countCheck = count($_POST['checkbox']);
		for($i = 0; $i < $countCheck; $i++)
		{
			$del_id = $checkbox[$i];
			
			$sql = "SELECT * FROM `sponsori` WHERE id=".$del_id."";
			$result = mysql_query($sql);
			
			$row=mysql_fetch_array($result);
			$delfile = $row['gfile'];
			unlink('../../images/sponsori/'.$delfile.'');
		}
		
		$sql = "DELETE FROM `sponsori` WHERE id IN (".implode(',',$_POST['checkbox']).")";
		mysql_query($sql);
        
        $sql = 'SELECT * FROM `sponsori`';
        if(mysql_num_rows(mysql_query($sql))==0)
            echo 'gol';
		
	}
?>
