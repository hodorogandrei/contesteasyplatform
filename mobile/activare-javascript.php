<?php
function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}

ob_start('callback');

include_once("include/header.php");

$titlu="Tutorial activare Javascript";

?>
		<div id="pagecontent">
			<div id="continut">
				<div id="pagetitle">
					<?php echo $titlu;?>
				</div>
				<div id="continut2">
						<h3>
							Google Chrome 15.0+</h3>
						<ol>
							<li>
								face&#355;i clic pe pictograma cheie din bara de instrumente a browserului;</li>
							<li>
								selecta&#355;i <strong>Op&#355;iuni</strong>;</li>
							<li>
								face&#355;i clic pe fila <strong>&Icirc;n culise</strong>;</li>
							<li>
								face&#355;i clic pe <strong>Set&#259;ri privind con&#355;inutul</strong> din sec&#355;iunea &bdquo;Confiden&#355;ialitate&rdquo;;</li>
							<li>
								selecta&#355;i op&#355;iunea <strong>Permite&#355;i tuturor site-urilor s&#259; ruleze JavaScript</strong> din sec&#355;iunea &bdquo;JavaScript&rdquo;.</li>
						</ol>
						<h3>
							Internet Explorer 6.0+</h3>
						<ol>
							<li>
								Face&#355;i clic pe meniul <strong>Tools (Instrumente)</strong>.</li>
							<li>
								Selecta&#355;i <strong>Internet Options (Op&#355;iuni de internet)</strong>.</li>
							<li>
								Face&#355;i clic pe fila <strong>Security (Securitate)</strong>.</li>
							<li>
								Face&#355;i clic pe butonul <strong>Custom Level (Nivel personalizat)</strong>.</li>
							<li>
								Derula&#355;i &icirc;n jos p&acirc;n&#259; c&acirc;nd observa&#355;i sec&#355;iunea &bdquo;Scripting&rdquo; (&bdquo;Scriptare&rdquo;). Selecta&#355;i butonul radio &bdquo;Enable&rdquo; (&bdquo;Activa&#355;i&rdquo;).</li>
							<li>
								Face&#355;i clic pe butonul <strong>OK</strong>.</li>
							<li>
								Dac&#259; observa&#355;i o fereastr&#259; de confirmare, face&#355;i clic pe butonul <strong>Yes (Da)</strong>.</li>
						</ol>
						<h3>
							Firefox 3.6+</h3>
						<ol>
							<li>
								Face&#355;i clic pe meniul <strong>Tools (Instrumente)</strong>.</li>
							<li>
								Selecta&#355;i<strong>Options (Op&#355;iuni)</strong>.</li>
							<li>
								Face&#355;i clic pe fila <strong>Content (Con&#355;inut)</strong>.</li>
							<li>
								Bifa&#355;i caseta de selectare &bdquo;Enable JavaScript&rdquo; (&bdquo;Activa&#355;i JavaScript&rdquo;).</li>
							<li>
								Face&#355;i clic pe butonul <strong>OK</strong>.</li>
						</ol>
						<h3>
							Safari 2 sau 3</h3>
						<ol>
							<li>
								Face&#355;i clic pe meniul <strong>Safari</strong>.</li>
							<li>
								Selecta&#355;i <strong>Preferences (Preferin&#355;e)</strong>.</li>
							<li>
								Face&#355;i clic pe fila <strong>Security (Securitate)</strong>.</li>
							<li>
								Bifa&#355;i caseta de selectare &bdquo;Enable JavaScript&rdquo; (&bdquo;Activa&#355;i JavaScript&rdquo;).</li>
						</ol>
						<a href="http://support.google.com/adsense/bin/answer.py?hl=ro&answer=12654">Sursa</a>
				</div>
			</div>
		</div>
<?php

include_once("include/footer.php");

ob_end_flush();

?>