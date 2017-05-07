<?php
function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}

ob_start('callback');

include_once("include/header.php");

$titlu="Toate &#351;tirile";

?>
		<div id="pagecontent">
			<div id="continut">
				<div id="pagetitle">
						<?php
								echo $titlu;
						?>
				</div>
				<div id="continut2">
				<br/>
					<?php 
					$sql = 'SELECT * FROM stiri ORDER BY id DESC';
					$result = mysql_query($sql);
					if(mysql_num_rows($result)>0)
					{
						while($rand = mysql_fetch_array($result))
						{
							echo'
							<div class="news">
								<div align="left" style="float: left;"><img src="images/news.png" class="thumb"/>&nbsp;<span class="news_date"><b>'.$rand['title'].'</b></span></div>
								<div align="right" style="float: right;"><img src="images/clock.png" class="thumb"/>&nbsp;<span class="news_date"><b>La data de:</b> '.$rand['date'].'</span></div>
								<br/><br/>
								<div class="news_text">
										'.firstnwords($rand['content'],15).'<br/>					
								</div>
								<!--<div class="news_more"><a class="news_more" href="stire_'.$rand['id'].'_'.$rand['permalink'].'.html"><img border="0" src="images/news-more.png"/>  mai mult</a></div>-->
								<div class="news_more"><a class="news_more" href="news.php?id='.$rand['id'].'"><img border="0" src="images/news-more.png" style="vertical-align: middle;"/>mai mult</a></div>
							</div>
							<hr align="left" style="width: 100%;" size="1" color="#999999" />
							';
						}
					}
					?>
				</div>
			</div>
		</div>
<?php

include_once("include/footer.php");

ob_end_flush();

?>