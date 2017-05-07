<?php
error_reporting(E_ERROR  | E_PARSE);

require_once("libraries/class.phpmailer.php");


function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}
ob_start('callback');

include_once("include/header.php"); 

$titlu = '&Icirc;nregistrare';

$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_array($rezultat))
{
	$compname = $rand['name'];
	$compaddr = $rand['compaddr'];
}

//activare e-mail
if(isset($_GET['activation']))
{
	$cod = $_GET['activation'];
	$query="UPDATE users SET validmail=1 where cod='$cod'";
	mysql_query($query);
	$mesaj = '';
	echo'<meta http-equiv="refresh" content="3;url=index.php" />';
}	  
//sfarsit activare e-mail

if(isset($_REQUEST['issubmit']) || isset($_POST['submit']))
{
	$username = make_safe($_POST['username']);
	$password = scrypt($_POST['password']);
	$nume = make_safe($_POST['nume']);
	$prenume = make_safe($_POST['prenume']);
	$email = make_safe($_POST['email']);
	$cnp = make_safe($_POST['cnp']);
	$mx = make_safe($_POST['mx']);
	$telefon = make_safe($_POST['telefon']);
	if(is_valid($username) && is_valid($password) && is_valid($nume) && is_valid($prenume) && is_valid($email) && is_valid($email) && is_valid($cnp) && is_valid($mx) && is_valid($telefon))
	{
		$sql = "SELECT * FROM users WHERE username='$username'";
		$result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());;
		if(mysql_num_rows($result)>0)
		{
			$mesaj = "<strong>Numele de utilizator specificat deja exist&#259;!.</strong>";
		}
		else
		{
			$sql = "SELECT * FROM users WHERE email='$email'";
			$result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());;
			if(mysql_num_rows($result)>0)
			{
				$mesaj = "<strong>Adresa de e-mail specificat&#259; deja exist&#259;!.</strong>";
			}
			elseif(filter_var($email, FILTER_VALIDATE_EMAIL)) 
			{
				//TOTUL VALID:
				$cod = generatecode(25);
				$sql = "INSERT INTO `users` (`username`, `pass`, `nume`, `prenume`, `email`, `cnp`, `mx`, `telefon`, `cod`) 
				VALUES ('".$username."', 
				'".$password."', 
				'".$nume."',
				'".$prenume."',
				'".$email."', 
				'".$cnp."', 
				'".$mx."', 
				'".$telefon."'
				'".$cod."')";
				mysql_query($sql);
				
				$mesaj = "<strong>Contul dumneavoastr&#259; a fost creat. V&#259; rug&#259;m s&#259; a&#351;tepta&#355;i aprobarea de c&#259;tre un administrator. De asemenea, v&#259; rug&#259;m s&#259; v&#259; verifica&#539;i Inbox-ul pentru validarea adresei de e-mail.</strong>";
			
				$msg='Acest mail a fost trimis automat intrucat ati solicitat crearea unui cod pe site-ul competitiei.<br/>

				Pentru activare, click pe urmatorul link: http://'.$_SERVER["SERVER_NAME"].'/signup.php?activation='.$cod.' <br/>

				In caz de nu ati solicitat abonarea, ignorati acest mail.

				';

				echo 'Va rog sa confirmati abonarea la newsletter. Pentru aceasta, v-am trimis un email cu un link de confirmare.';

				$mail = new PHPMailer();
				$mail->IsMail();
				$mail->AddReplyTo('noreply@'.$_SERVER['SERVER_NAME'].'', $compname);
				$mail->AddAddress($email);
				$mail->SetFrom('noreply@'.$_SERVER['SERVER_NAME'].'', $compname);
				$mail->Subject = "Confirmare E-Mail";
				$mail->MsgHTML($msg);
				$mail->Send();
			}
			else
			{
				$mesaj = 'Adres&#259; de e-mail invalid&#259;!';
			}
		}
	}
	else
	{
		$ok=0;
		$mesaj = 'C&acirc;mpurile marcate cu * sunt obligatorii!';
	}
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
					<br/>
					<?php display_message($mesaj);?>
					<table align="center" border="0" cellpadding="0" cellspacing="0">
					<tr><td>
					<form action="signup.php" method="POST" id="register">
					<input type='hidden' name="issubmit" value="1">
					<!-- Tabs -->
							<div id="wizard" class="swMain">
								<ul>
									<li><a href="#step-1">
									<label class="stepNumber">1</label>
									<span class="stepDesc">
									   Datale contului<br />
									   <small>Completa&#355;i datele contului</small>
									</span>
								</a></li>
									<li><a href="#step-2">
									<label class="stepNumber">2</label>
									<span class="stepDesc">
									   Date profil<br />
									   <small>Completa&#355;i detaliile profilului dumneavoastr&#259;</small>
									</span>
								</a></li>
									<li><a href="#step-3">
									<label class="stepNumber">3</label>
									<span class="stepDesc">
									   Detalii contact<br />
									   <small>Completa&#355;i datele de contact</small>
									</span>
								 </a></li>
								</ul>
								<div id="step-1">	
								<h2 class="StepTitle">Pasul 1: Datele contului</h2>
									<table cellspacing="3" cellpadding="3">
											<tr>
												<td align="center" colspan="3">&nbsp;</td>
											</tr>        
											<tr>
												<td align="right">Username:</td>
												<td align="left">
												  <?php check_field($ok, "username"); ?><input type="text" id="username" name="username" value="<?php check_isset("username");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_username"></span>&nbsp;</td>
											</tr>
											<tr>
												<td align="right">Parol&#259;:</td>
												<td align="left">
													<?php check_field($ok, "password"); ?><input type="password" id="password" name="password" value="<?php check_isset("password");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_password"></span>&nbsp;</td>
											</tr> 
											<tr>
												<td align="right">Confirmarea parolei:</td>
												<td align="left">
													<?php check_field($ok, "cpassword"); ?><input type="password" id="cpassword" name="cpassword" value="<?php check_isset("cpassword");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_cpassword"></span>&nbsp;</td>
											</tr>                                   			
									</table>          			
								</div>
								<div id="step-2">
								<h2 class="StepTitle">Pasul 2: Datele profilului</h2>	
									<table cellspacing="3" cellpadding="3">
											<tr>
												<td align="center" colspan="3">&nbsp;</td>
											</tr>        
											<tr>
												<td align="right">Nume:</td>
												<td align="left">
													<?php check_field($ok, "nume"); ?><input type="text" id="firstname" name="nume" value="<?php check_isset("nume");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_firstname"></span>&nbsp;</td>
											</tr>
											<tr>
												<td align="right">Prenume:</td>
												<td align="left">
													<?php check_field($ok, "prenume"); ?><input type="text" id="lastname" name="prenume" value="<?php check_isset("prenume");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_lastname"></span>&nbsp;</td>
											</tr>
											<tr>
												<td align="right">CNP:</td>
												<td align="left">
													<?php check_field($ok, "cnp"); ?><input type="text" id="cnp" name="cnp" value="<?php check_isset("cnp");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_lastname"></span>&nbsp;</td>
											</tr>
											<tr>
												<td align="right">Serie &#351;i num&#259;r buletin:</td>
												<td align="left">
													<?php check_field($ok, "mx"); ?>	<input type="text" id="mx" name="mx" value="<?php check_isset("mx");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_lastname"></span>&nbsp;</td>
											</tr>						
									</table>        
								</div>                      
								<div id="step-3">
								<h2 class="StepTitle">Pasul 3: Datele de contact</h2>	
									<table cellspacing="3" cellpadding="3">
											<tr>
												<td align="center" colspan="3">&nbsp;</td>
											</tr>        
											<tr>
												<td align="right">Email:</td>
												<td align="left">
													<?php check_field($ok, "email"); ?><input type="text" id="email" name="email" value="<?php check_isset("email");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_email"></span>&nbsp;</td>
											</tr>
											<tr>
												<td align="right">Telefon:</td>
												<td align="left">
													<?php check_field($ok, "telefon"); ?><input type="text" id="phone" name="telefon" value="<?php check_isset("telefon");?>" class="txtBox">
												</td>
												<td align="left"><span id="msg_phone"></span>&nbsp;</td>
											</tr>                       			
									</table>               				          
								</div>
							</div>
					<!-- End SmartWizard Content -->  
					<noscript><input type="submit" name="submit" value="&Icirc;nregistrare"/></noscript>
					</form> 
							
					</td></tr>
					</table> 
				</div>
			</div>
		</div>             
                                                   
<link href="css/smart_wizard.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard-2.0.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
<script type="text/javascript" src="js/signup.js" charset="utf-8"></script>
<script type="text/javascript">
 //<![CDATA[
  document.write('<style type="text/css"> #wizard > ul {display: block;}</style>');
 //]]>
</script>

<?php
include_once("include/footer.php");
ob_end_flush();
?>