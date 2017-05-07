<?php
require_once("include/config.php");
require_once("include/functions.php");
require_once("libraries/dompdf2/dompdf_config.inc.php");

if(isset($_POST['html2pdf']))
{
	$html = $_POST['pdfcontent'];
	$filename = $_POST['filename'];
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->render();
	$dompdf->stream("".$filename.".pdf");
}
?>