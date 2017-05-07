<?php
    require_once('../include/config.php');
	require_once('../include/functions.php');
    error_reporting(0);
	if ($_POST) {
		$ids = $_POST["ids"];
		for ($idx = 0; $idx < count($ids); $idx++) {
			$id = $ids[$idx];
			$ordinal = $idx;
			$query="UPDATE `gallery` SET ordine='$ordinal' WHERE id='$id'";
			mysql_query($query);
		}
	
		$checkbox = $_POST['checkbox'];
		$countCheck = count($_POST['checkbox']);
		for($i=0;$i<$countCheck;$i++)
		{
			$del_id = $checkbox[$i];
			$sql = "SELECT * FROM `gallery` WHERE id=".$del_id."";
			$result = mysql_query($sql);
			
			
			$row=mysql_fetch_object($result);
			$filename = $row->gfile;
			$delfile = "../../images/gallery/".$filename;
			unlink($delfile);
		}
		
		$sql = "DELETE FROM `gallery` WHERE id IN (".implode(',',$_POST['checkbox']).")";
		mysql_query($sql); 
        
        $sql = 'SELECT * FROM `gallery`';
        if(mysql_num_rows(mysql_query($sql))==0)
            echo 'gol';
	}
?>