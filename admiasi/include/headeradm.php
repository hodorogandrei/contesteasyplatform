<?php
require_once("include/config.php"); 
//if(($_SESSION['logat'] == 'Da') && ($_SERVER['HTTP_REFERER'] != $_SERVER['SERVER_NAME']))
//    header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/logout.php');

$_SESSION['time'] = time();

$doSQL = "SELECT * FROM `general` WHERE id=1"; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_object($rezultat))
{
	$picture = $rand -> picture;
}

if($_SESSION['global']==1 ? $global=1 : $global=0);
?>
<div id="linkhelp">
<a href="../help.pdf" target="_blank"><img src="../images/help.png" />Help</a>
</div>
<div id="noscriptalert">
	<center>
		<p style="font-weight: bold; font-size: 14px; background: #fff;"><img src="../images/disabledjs.png" border="0" alt="" style="position: relative; margin-bottom: -7px;"/>&nbsp;<i>Pentru a beneficia de toate functionalit&#259;&#355;ile acestui site, este necesar s&#259; activa&#355;i Javascript! Mai multe informatii reg&#259;si&#355;i <a href="../activare-javascript.php">aici</a> .</i></p>
	</center>
</div>
		<div id="headerbg">
			<div id="logo">
				<a class="home" href="index.php"></a>
				<div id="sigla"><center><img src="../<?php echo $picture;?>" /></center></div>
				<div id="titlu"><img src="images/logo_contest.png" class="midalign"/>&nbsp;<i>ContestEasyPlatform&reg;</i> - Panou de administrare</div>
				<div id="secmenu">
					<?php show_login_info();?>
				</div>

				<div id="menuright">
					<ul class="topmenu">
						<?php if($global==1 || check_perm("Adaugare stire") || check_perm("Administrare stiri") || check_perm("Newsletter")) {?>
						<li class="topfirst"><a href="#" style="height:18px;line-height:18px;"><span>&#350;tiri</span></a>
						<ul>
							<?php if($global==1 || check_perm("Adaugare stire")) {?><li><a href="adaugare-stire.php">Adaugare &#351;tire</a></li><? }?>
							<?php if($global==1 || check_perm("Administrare stiri") || check_perm("Adaugare stire")) {?><li><a href="administrare-stiri.php">Administrare &#351;tiri</a></li><? }?>
                            <?php if($global==1 || check_perm("Newsletter")) {?><li><a href="newsletter.php">Newsletter</a></li><? }?>
						</ul></li>
						<? }?>
						<?php if($global==1) { ?><li class="topmenu"><a href="administratori.php" style="height:18px;line-height:18px;">Administratori</a></li><?}?>
						<?php if($global==1 || check_perm("Editare pagini")) { ?><li class="topmenu"><a href="liveedit/index.php" target="_blank" style="height:18px;line-height:18px;">Live Editor</a></li><?}?>
						<?php if($global==1 || check_perm("Date SEO")) {?>
						<li class="topmenu"><a href="date-seo.php" style="height:18px;line-height:18px;">SEO</a></li>
						<? }?>
						<?php if($global==1 || check_perm("Statistici")) {?>
						<li class="toplast"><a href="statistici.php" style="height:18px;line-height:18px;">Stats</a></li>
						<? }?>
					</ul>
				</div>
				<div id="menuleft">
					<ul class="topmenu">
						<?php if($global==1 || check_perm("Editare pagini") || check_perm("Informatii generale") || check_perm("Editare galerie")) {?>
						<li class="topfirst"><a href="#" style="height:18px;line-height:18px;"><span>General</span></a>
						<ul>
							<?php if($global==1 || check_perm("Editare pagini")) {?><li><a href="editare-pagini.php">Editare pagini</a></li><? }?>
							<?php if($global==1 || check_perm("Informatii generale")) {?><li><a href="informatii-generale.php">Informa&#355;ii generale</a></li><? }?>
							<?php if($global==1 || check_perm("Editare galerie")) {?><li><a href="editare-galerie.php">Editare galerie</a></li><? }?>
						</ul></li>
						<? }?>
						
						<?php if($global==1 || check_perm("Comentarii")) {?>
						<li class="topmenu"><a href="administrare-comentarii.php" style="height:18px;line-height:18px;">Comentarii</a></li>
						<? }?>
						<?php if($global==1 || check_perm("Administrare participanti") || check_perm("Import participanti") || check_perm("Administrare conturi")) {?>
						<li class="topmenu"><a href="#" style="height:18px;line-height:18px;"><span>Participan&#355;i</span></a>
						<ul>
							<?php if($global==1 || check_perm("Administrare participanti")) {?><li><a href="administrare-participanti.php">Administrare participan&#355;i</a></li><? }?>
							<?php if($global==1 || check_perm("Import participanti")) {?><li><a href="import_participanti.php">Import participan&#355;i</a></li><? }?>
                            <?php if($global==1 || check_perm("Administrare conturi")) {?><li><a href="conturi.php">Conturi utilizatori</a></li><? }?>
						</ul></li>
						<? }?>
						<?php if($global==1 || check_perm("Administrare rezultate") || check_perm("Import rezultate")) {?>
						<li class="toplast"><a href="#" style="height:18px;line-height:18px;"><span>Rezultate</span></a>
						<ul>
							<?php if($global==1 || check_perm("Administrare rezultate")) {?><li><a href="administrare-rezultate.php">Administrare rezultate</a></li><?}?>
							<?php if($global==1 || check_perm("Import rezultate")) {?><li><a href="import_rezultate.php">Import rezultate</a></li><?}?>
						</ul></li>
						<? }?>
					</ul>
				</div>
			</div>
		</div>
        
        