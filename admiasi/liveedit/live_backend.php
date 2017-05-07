<?php 
require_once('../include/config.php');
$action = $_POST['action'];

switch ($action) {

	// retrieve data
	case 'get':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$headtitle = $rand['headtitle'];
		}
		echo $headtitle;
		break;
		
	case 'get2':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$organiser = $rand['organiser'];
		}
		echo $organiser;
		break;
	
	case 'get-begdate':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$begdate = $rand['begdate'];
		}
		echo $begdate;
		break;
		
	case 'get-enddate':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$enddate = $rand['enddate'];
		}
		echo $enddate;
		break;
		
	case 'get-foot':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$foottitle = $rand['foottitle'];
		}
		echo $foottitle;
		break;
		
	case 'get-toolstxt':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$toolstxt = $rand['toolstxt'];
		}
		echo $toolstxt;
		break;
		
	case 'get-nwstxt':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$nwstxt = $rand['nwstxt'];
		}
		echo $nwstxt;
		break;
		
	case 'get-partpages':
		$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
		$rezultat = mysql_query($doSQL);
		while($rand = mysql_fetch_array($rezultat))
		{
			$partpages = $rand['partpages'];
		}
		echo $partpages;
		break;
	// save data
	case 'save':
			$headtitle = $_POST['value'];
			$sql = "UPDATE general SET headtitle='$headtitle' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
	case 'save2':
			$organiser = $_POST['value2'];
			$sql = "UPDATE general SET organiser='$organiser' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
			
	case 'save-begdate':
			$begdate = $_POST['value-begdate'];
			$sql = "UPDATE general SET begdate='$begdate' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
	
	case 'save-enddate':
			$enddate = $_POST['value-enddate'];
			$sql = "UPDATE general SET enddate='$enddate' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;

	case 'save-foot':
			$foottitle = $_POST['value-foot'];
			$sql = "UPDATE general SET foottitle='$foottitle' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
			
	case 'save-toolstxt':
			$toolstxt = $_POST['value-toolstxt'];
			$sql = "UPDATE general SET toolstxt='$toolstxt' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
			
	case 'save-nwstxt':
			$nwstxt = $_POST['value-nwstxt'];
			$sql = "UPDATE general SET nwstxt='$nwstxt' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;
	case 'save-partpages':
			$partpages = $_POST['value-partpages'];
			$sql = "UPDATE general SET partpages='$partpages' WHERE id=1";
			mysql_query($sql);
			echo "OK";
			break;

	// no action
	default:
		echo "ERROR: no action specified.";
		break;
}
?>