<?php
require_once("../../include/config.php");
require_once("../include/functions.php");

$judet=make_safe($_POST['judet']);
$clasa=make_safe($_POST['clasa']);
$sort=make_safe($_POST['sort']);

if($sort=="total")
{
	if($clasa=="9-12" && $judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 ORDER BY total desc";
	else if($clasa=="5-8" && $judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 ORDER BY total desc";
	else if ($clasa=="5-8")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY total desc";
	else if ($clasa=="9-12")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY total desc";
	else if ($judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa = '".$clasa."' ORDER BY total desc";
	else
		$sql="SELECT * FROM rezultate WHERE judet = '".$judet."' AND clasa = '".$clasa."' ORDER BY total desc";
}
else
{
	if($clasa=="9-12" && $judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 ORDER BY ".$sort."";
	else if($clasa=="5-8" && $judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 ORDER BY ".$sort."";
	else if ($clasa=="5-8")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY ".$sort." ";
	else if ($clasa=="9-12")
		$sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY ".$sort." ";
	else if ($judet=="Toate")
		$sql="SELECT * FROM rezultate WHERE clasa = '".$clasa."' ORDER BY ".$sort." ";
	else
		$sql="SELECT * FROM rezultate WHERE judet = '".$judet."' AND clasa = '".$clasa."' ORDER BY ".$sort." ";
}
//echo $sort;
$rezultat = mysql_query($sql);
if(mysql_num_rows($rezultat)>0)
{
?>
<table align="center" width="650" cellspacing="2" cellpadding="2" border="0">
<tr class="part_header">
<td>Nume</td>
<td style="text-align: center;">Clasa</td>
<td style="text-align: center;">Judet</td>
<td style="text-align: center;">Punctaj Total</td>
<td style="text-align: center;">Observatii</td>
<td style="text-align: center;">Premiu</td>
<td style="text-align: center;">Medalie</td>
</tr>
<?php
$numar=0;
while($rand = mysql_fetch_array($rezultat))
{
  $numar++;
  if($numar%2==0)
  {
	  echo "<tr class=\"part_tr\">";
	  echo "<td>" . $rand['numele'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['clasa'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['judet'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['total'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['observatii'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['premiu'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['medalie'] . "</td>";
	  echo "</tr>";
  }
  else
  {
	  echo "<tr class=\"part_tr_gri\">";
	  echo "<td>" . $rand['numele'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['clasa'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['judet'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['total'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['observatii'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['premiu'] . "</td>";
	  echo "<td style=\"text-align: center;\">" . $rand['medalie'] . "</td>";
	  echo "</tr>";
  }
}
?>
</table>
<br/><br/>Au fost g&#259;si&#355;i <b><?php echo mysql_num_rows($rezultat);?> elevi</b> dup&#259; criteriile specificate.
<?php
}
else
{
?>
<center><span class="smalltitle_red">Rezultatele finale vor fi facute publice dup&#259; solu&#355;ionarea contesta&#355;iilor</span></center>
<?php } ?>
