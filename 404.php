<?php
require_once('libraries/mobile_device_detect.php');

$_SESSION['redirectat'] = 'Nu';
if(isset($_SERVER["HTTP_REFERER"]))
	if (strstr($_SERVER["HTTP_REFERER"], 'http://'.$_SERVER["SERVER_NAME"].'/oni-2012/mobile')) $_SESSION['redirectat'] = 'Da';
if($_SESSION['redirectat'] == 'Nu')
mobile_device_detect(true,true,true,true,true,true,true,'http://'.$_SERVER['SERVER_NAME'].'/oni-2012/mobile/',false);

function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}

ob_start('callback');

include_once("include/header.php");

$titlu="Pagin&#259; inexistent&#259;";

?>
		<div id="pagecontent">
			<?php include("include/sidebar.php")?>
			<div id="continut">
				<div id="pagetitle">
						<?php echo $titlu ;?>
				</div>
				<div id="continut2">
						<br/><center><b>Pagina pe care a&#355;i &icirc;ncercat s&#259; o accesa&#355;i nu exist&#259;!</b></center>
				</div>
			</div>
		</div>
<script type="text/javascript" src="js/jquery.js"></script>
<?php
include_once("include/footer.php");
ob_end_flush();
?>