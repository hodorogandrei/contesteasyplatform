<?php

function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}
ob_start('callback');

include_once("include/header.php");

$doSQL = 'SELECT * FROM `onipag` WHERE id=3'; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_object($rezultat))
{
	$titlu = $rand -> title;
	$continut = $rand -> content;
}
?>
		<div id="pagecontent">
			<div id="continut">
				<div id="pagetitle">
						<?php
							echo $titlu;
						?>
				</div>
				<div id="continut2">
						<?php
							echo $continut;
						?>
				</div>
			</div>
		</div>
<?php
include_once("include/footer.php");
ob_end_flush();
?>