<?php
	require_once("include/config.php");
    
	$doSQL = "SELECT * FROM `general` WHERE id=1"; 
	$rezultat = mysql_query($doSQL);
	while($rand = mysql_fetch_object($rezultat))
	{
		$nwstxt = $rand -> nwstxt;
		$toolstxt = $rand -> toolstxt;
		$mp3file = $rand -> mp3file;
	}
?>
		<div id="sidebar">
                    
                    <div id="player">
                        <object type="application/x-shockwave-flash" data="player_mp3_maxi.swf" width="30" height="30" style="float: left;">
                            <param name="wmode" value="transparent" />
                            <param name="movie" value="player_mp3_maxi.swf" />
                            <param name="FlashVars" value="mp3=<?php echo $mp3file;?>&width=30&height=30&sliderwidth=30&sliderheight=8&buttonwidth=30&bgcolor=cccc99&bgcolor1=9e8941&bgcolor2=3045b3" />
                        </object>
                        &nbsp;<span id="countdown"></span>
                    </div>
                    
                    <a href="rss.xml" target="_blank" title="Subscribe"><img src="images/rss.png" class="rss" border="0"/></a>
                    <br/><br/><div id="msg_newsletter" class="smalltitle_red"></div>
                    Abonare newsletter:<br/>
                    <form id="newsletter">
                        <input type="text" name="email" id="email">
                        <input type="button" value="Abonare" id="subscribenws">
                    </form>
                    
                    <form method="post" action="newsletter.php" id="newsletter_nojs">
                        <input type="text" name="email" id="email">
                        <input type="submit" value="Abonare" id="">
                    </form>
                                                                                                                  
					<br/>
                    <img src="images/news-ico.png" class="thumb" />&nbsp;<span style="color: #3045b3; font-size: 26px;"><?php echo $nwstxt;?></span>
					<br/><br/>
					<?php 
					$sql = "SELECT * FROM `stiri` ORDER BY id DESC LIMIT 0,5";
					$result = mysql_query($sql);
					if(mysql_num_rows($result)>0)
					{
						while($rand = mysql_fetch_object($result))
						{
							echo'
							<br/>
							<div class="news">
								<span class="news_date"><img src="images/news.png" style="vertical-align: bottom;"/> 
								'.$rand -> date.'</span> - <span class="news_title"><i>'.$rand -> title.'</i></span>&nbsp;<span class="trigger"></span>
								<div class="news_text">
										'.firstnwords(strip_tags($rand -> content),10).'<br/>					
								</div>
								<div class="news_more"><a class="news_more" href="stire_'.$rand -> id.'_'.$rand -> permalink.'.html"><img border="0" src="images/news-more.png"/>  mai mult</a></div>
							</div>
							';
						}
						echo '<a href="stiri.php" class="info_content_a">Vizualiza&#355;i toate &#351;tirile</a><br/><br/>';
					}
					else
						echo "&Icirc;n cur&acirc;nd...<br/><br/>";
					?>
					<img src="images/tools.png" class="thumb" width="26" height="26" />&nbsp;<span style="color: #3045b3; font-size: 26px;"><?php echo $toolstxt;?></span><br/>
					<div class="info">
						<div class="info_title"><img width="6" height="6" src="images/bullet.png" />&nbsp;&nbsp;link-uri utile:&nbsp;</div>
						<div class="info_content">
							<a href="http://olimpiada.info" target="_blank" class="info_content_a">olimpiada.info</a><br />
							<a href="http://www.isjiasi.ro" target="_blank" class="info_content_a">www.isjiasi.ro</a><br />
							<a href="http://www.edu.ro" target="_blank" class="info_content_a">www.edu.ro</a><br />
						</div>
					</div>
		</div>