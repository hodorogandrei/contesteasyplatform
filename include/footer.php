<?php
$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_array($rezultat))
{
	$foottitle = $rand['foottitle'];
	$oras = $rand['oras'];
	$deadline = $rand['datainc'];
}
?>
		<br/>
		<div id="footerbg">
			<div id="footercontent">
				<div id="footertext">
					<center>
						Copyright&copy; <?php echo $foottitle;?>. <br/>Based on ContestEasyPlatform&reg; by <a href="http://www.andreihodorog.com/" target="_blank">Andrei Hodorog</a> .<br/>
					</center>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="preLoader" class="hiddendiv"><img src="images/loading.png" class="midalign" />&nbsp;<i>Galeria se &icirc;ncarc&#259;. V&#259; rug&#259;m a&#351;tepta&#355;i...</i></div>
<script type="text/javascript" src="js/jquery-ui.min.js" ></script>
<!-- Roundabout Plugin --->
<script src="js/roundabout.js" type="text/javascript"></script>
<!-- Easing Plugin -->
<script src="js/easing.js" type="text/javascript"></script>
<!-- UItoTop plugin -->
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>
<!-- jQuery countdown -->
<script src="js/jquery.countdown.js"></script>
<!-- jQuery weather -->
<script src="js/jquery.zweatherfeed.js" type="text/javascript"></script>

<script type="text/javascript">
var ts = new Date(<?php echo $deadline;?>);
var wcity = '<?php echo $oras; ?>';
</script>
<script src="js/globalscript.js" type="text/javascript"></script>
<!-- No-Javascript Alert -->
<script type="text/javascript">
 //<![CDATA[
  document.write('<style type="text/css"> #countdown {display: inline;} #noscriptalert {display: none;} #main #headerbg {height: 359px;} #preLoader, #zoomzone, form#newsletter {display: block;} span.trigger {display:inline-block;} form#newsletter_nojs {display: none;}</style>');
 //]]>
</script>
</body>
</html>