<?php

function callback($content)
{
	global $titlu;
	return str_replace("#titlu#",$titlu, $content);
}

ob_start('callback');

include_once("include/header.php");

$titlu="Participanti";

?>
		<div id="pagecontent">
			<div id="continut">
				<div id="pagetitle">
					<?php echo $titlu;?>
				</div>
				<div id="continut2">
					<br/>
					<span class="smalltitle_blue">Op&#355;iuni</span> <span class="smalltitle_grey">c&#259;utare:</span><br/><br/>
					<form enctype="text/plain">
						<table cellpadding="0" cellspacing="5">
							<tr>
								<td>Jude&#355;: </td>
								<td>
									<select id="judet" class="part_select">
										<option selected="selected" value="Toate">Toate</option>
										<option value="Alba">Alba</option>
										<option value="Arad">Arad</option>
										<option value="Arges">Arges</option>
										<option value="Bacau">Bacau</option>
										<option value="Bihor">Bihor</option>
										<option value="Bistrita-Nasaud">Bistrita-Nasaud</option>
										<option value="Botosani">Botosani</option>
										<option value="Braila">Braila</option>
										<option value="Brasov">Brasov</option>
										<option value="Bucuresti">Bucuresti</option>
										<option value="Buzau">Buzau</option>
										<option value="Calarasi">Calarasi</option>
										<option value="Caras-Severin">Caras-Severin</option>
										<option value="Cluj">Cluj</option>
										<option value="Constanta">Constanta</option>
										<option value="Covasna">Covasna</option>
										<option value="Dambovita">Dambovita</option>
										<option value="Dolj">Dolj</option>
										<option value="Galati">Galati</option>
										<option value="Giurgiu">Giurgiu</option>
										<option value="Gorj">Gorj</option>
										<option value="Harghita">Harghita</option>
										<option value="Hunedoara">Hunedoara</option>
										<option value="Ialomita">Ialomita</option>
										<option value="Iasi">Iasi</option>
										<option value="Ilfov">Ilfov</option>
										<option value="Maramures">Maramures</option>
										<option value="Mehedinti">Mehedinti</option>
										<option value="Mures">Mures</option>
										<option value="Neamt">Neamt</option>
										<option value="Olt">Olt</option>
										<option value="Prahova">Prahova</option>
										<option value="Salaj">Salaj</option>
										<option value="Satu-Mare">Satu-Mare</option>
										<option value="Sibiu">Sibiu</option>
										<option value="Suceava">Suceava</option>
										<option value="Teleorman">Teleorman</option>
										<option value="Timis">Timis</option>
										<option value="Tulcea">Tulcea</option>
										<option value="Valcea">Valcea</option>
										<option value="Vaslui">Vaslui</option>
										<option value="Vrancea">Vrancea</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Clasa: </td>
								<td>
									<select id="clasa" class="part_select">
										<option selected="selected" value="9-12">9-12</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="5-8">5-8</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Sortat dup&#259;: </td>
								<td>
									<select id="sort" class="part_select">
										<option selected="selected" value="numele">Nume</option>
										<option value="clasa">Clasa</option>
										<option value="judet">Judet</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><input type="button" id="displaypart" value="Afi&#351;are" /></td>
							</tr>
							</table>
						</form>
					<br/><span class="smalltitle_blue">Elevi</span> <span class="smalltitle_grey">g&#259;si&#355;i:</span><br/><br/>
					<div id="elevi_content">	
					</div>
				</div>
			</div>
		</div>
        
        
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/load-rez.js"></script>
<?php

include_once("include/footer.php");

ob_end_flush();

?>