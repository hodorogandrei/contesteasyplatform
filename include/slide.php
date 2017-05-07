			
			<div id="welcomeline" class="hiddendiv">
				<div id="band">
					<div id="range">
						<?php 
							$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
							$rezultat = mysql_query($doSQL);
							while($rand = mysql_fetch_object($rezultat))
							{
								$begdate = $rand -> begdate;
								$enddate = $rand -> enddate;
							}
						?>
						Perioada de desf&#259;&#351;urare: <?php echo $begdate;?> - <?php echo $enddate;?>
					</div>
				</div>
				<ul>
					<?php 
							$doSQL = 'SELECT * FROM `gallery` ORDER BY `ordine` ASC'; 
							$rezultat = mysql_query($doSQL);
							if(mysql_num_rows($rezultat)>0)
								while($rand = mysql_fetch_object($rezultat))
									echo '<li><a href="'.$rand -> link.'" target="_blank" title="'.$rand -> galt.'"><img src="images/gallery/'.$rand -> gfile.'" alt="'.$rand -> galt.'" width="308" /></a></li>';
							else
								echo '<li><img src="images/gallery/noimages.png" /></li>';
					?>
				</ul>
			</div>