<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);

include_once("include/counter.php");

initCounter();

function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}
ob_start('callback');

include_once("include/header.php");

$sql = "SELECT * FROM `stiri` WHERE id='".(int)($_GET['id'])."'";
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0)
{
	while($rand = mysql_fetch_object($result))
	{	
		$titlu = $rand -> title;
		$content = $rand -> content;
		$picture = $rand -> picture;
		$postby = $rand -> postby;
		$permalink = $rand -> permalink;
		$date = $rand -> date;
		$vizualizari = $rand -> vizualizari;
	}
    
	$vizualizari++;
	$sql = "UPDATE `stiri` SET vizualizari='".$vizualizari."' WHERE id='".(int)($_GET['id'])."'";
	mysql_query($sql);
}
else
{
	$titlu = '&#350;tire inexistent&#259;';
	$nuexista=1;
}

?>
		<div id="pagecontent">
			<?php include("include/sidebar.php")?>
			<div id="continut">
				<div id="pagetitle">
					<?php echo $titlu;?>
				</div>
				<div id="continut2">
					<form id="form" onsubmit="this.pdfcontent.value = document.getElementById('nwscontent2').innerHTML;" action="generate-pdf.php" method="post">
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
				<?php if(!isset($nuexista)) 
				{?>
					
						<input type="hidden" name="pdfcontent" value="" />
						<input type="hidden" name="filename"   value="<?php echo $permalink;?>" />
						<div id="nwscontent2">
							<?php 
								if(!empty($picture) && $picture!='newsimg/') 
									echo '<img src="http://'.$_SERVER['SERVER_NAME'].'/'.$picture.'" border="0" align="right" style="margin: 5px; clear: both;"/>';
								echo $content; 
							?>
						<br/>
							<b><?php echo $titlu;?></b> (<i><b>Postat de:</b> <?php echo $postby;?></i>)<br/>
							<b>La data de: </b><i><?php echo $date;?></i><br/>
							Aceasta stire are <b><?php echo $vizualizari; ?> vizualizari</b>, dintre care <b><?php echo getCounter('unique');?> unice.</b>
						</div>
					</form>
				<?php } else  
				{ ?>
					<br/><center><b>&#350;tirea pe care a&#355;i &icirc;ncercat s&#259; o accesa&#355;i nu exist&#259;!</b></center>
				<? }?>
				</div>
			</div>
		</div>
<script type="text/javascript" src="js/jquery.js"></script>   
<?php
include_once("include/footer.php");
ob_end_flush();
?>
