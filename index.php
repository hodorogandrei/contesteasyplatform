<?php
require_once("libraries/mobile_device_detect.php");

$_SESSION['redirectat'] = 'Nu';
if(isset($_SERVER["HTTP_REFERER"]))
	if (strstr($_SERVER["HTTP_REFERER"], 'http://'.$_SERVER["SERVER_NAME"].'/mobile/')) $_SESSION['redirectat'] = 'Da';
if($_SESSION['redirectat'] == 'Nu')
mobile_device_detect(true,true,true,true,true,true,true,'http://'.$_SERVER['SERVER_NAME'].'/mobile/',false);

function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}

ob_start('callback');

include_once("include/header.php");

$doSQL = "SELECT * FROM `onipag` WHERE id=1"; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_object($rezultat))
{
	$titlu = $rand -> title;
	$continut = $rand -> content;
}
?>
		<div id="pagecontent">
			<?php include("include/sidebar.php")?>
			<div id="continut">
				<div id="pagetitle">
						<?php
							echo $titlu;
						?>
				</div>
				<div id="continut2">
					<form id="form" onsubmit="this.pdfcontent.value = document.getElementById('pdfcontent2').innerHTML;" action="generate-pdf.php" method="post">
						<div id="zoomzone">
							<a href="#" class="zoomin" title="Zoom In"></a>
							<a href="#" class="zoomout" title="Zoom Out"></a>
							<a href="#" class="resetFont" title="Resetare"></a>
							<input type="submit" value="" name="html2pdf" id="generatepdf" title="Generare PDF"/>
							<div id="qrcode">
								<?php
								$urlToEncode=$actual_link;
								generateQRwithGoogle($urlToEncode);
								function generateQRwithGoogle($url,$widthHeight ='70',$EC_level='L',$margin='0') {
									$url = urlencode($url); 
									echo '<img src="http://chart.apis.google.com/chart?chs='.$widthHeight.
								'x'.$widthHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.
								'&chl='.$url.'" alt="QR code" widthHeight="'.$widthHeight.
								'" widthHeight="'.$widthHeight.'"/>';
								}
								?>
							</div>
						</div>
						<input type="hidden" name="pdfcontent" value="" />
						<input type="hidden" name="filename"   value="<?php echo $titlu;?>" />
						<div id="pdfcontent2">
							<?php
								echo $continut;
							?>
						</div>
					</form>
				</div>
			</div>
		</div>
<script type="text/javascript" src="js/jquery.js"></script>
<?php
include_once("include/footer.php");
ob_end_flush();
?>