<?php
require_once('../include/config.php');
require_once('../include/functions.php');

$data   =   @$_POST['data'];       
 
$query  = "SELECT *
		  FROM rezultate
		  WHERE numele LIKE '%$data%'
		  LIMIT 5";

$result = mysql_query($query);

$dataList = array();

while ($row = mysql_fetch_array($result))
{
	$toReturn   = $row['numele'];
	$dataList[] = '<li id="' .$row['id'] . '"><a href="editare-rezultat.php?id='.$row['id'].'">'.convertToEntities($toReturn). '</a></li>';
}

if (count($dataList)>=1)
{
	$dataOutput = join("\r\n", $dataList);
	echo $dataOutput;
}
else
{
	echo '<li><a href="">Niciun rezultat</a></li>';
}
?>