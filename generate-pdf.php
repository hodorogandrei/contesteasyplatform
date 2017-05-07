<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    require_once("libraries/mpdf/mpdf.php");
    
    if(isset($_POST['html2pdf']))
    {
        $html = '<link rel="stylesheet" type="text/css" href="css/style.css" />';
        $html .= stripslashes($_POST['pdfcontent']);
        $filename = $_POST['filename'];
        $mpdf=new mPDF();
        /*$mpdf->WriteHTML('<style type="text/css">');
        $stylesheet = file_get_contents('css/style.css');
        $mpdf->WriteHTML($stylesheet,1);
        $mpdf->WriteHTML('</style');*/
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
?>