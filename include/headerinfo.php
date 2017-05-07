<?php 
require_once("include/config.php"); 
require_once("include/functions.php"); 

$doSQL = 'SELECT * FROM `general` WHERE id=1'; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_object($rezultat))
{
	$compname = $rand -> name;
	$colorheader = $rand -> colorheader;
	$colorfooter = $rand -> colorfooter;
	$colortitle = $rand -> colortitle;
}

$doSQL = 'SELECT * FROM `seo` WHERE id=1'; 
$rezultat = mysql_query($doSQL);
while($rand = mysql_fetch_object($rezultat))
{
	$description = $rand -> description;
	$keywords = $rand -> keywords;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<title><?php echo $compname;?> - #titlu#</title>
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="subjects" content="<?php echo $keywords; ?>" />
<meta name="rating" content="General" />
<meta name="language" content="romanian, RO" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="revisit-after" content="1 Days" />
<meta content="INDEX,FOLLOW" name="robots" />
<meta name="publisher" content="contact@andreihodorog.com" />
<meta name="copyright" content="Copyright(C) <?php echo $compname;?>" />
<meta name="author" content="Hodorog Andrei" />
<meta name="classification" content="olimpiade si concursuri romania" />

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/additional.css" /> 

<!-- Template -->
<style type="text/css">
#main #headerbg { background:<?php echo $colorheader;?> url(images/headerbg.png); }
#main #footerbg { background:<?php echo $colorfooter;?> url(images/footerbg2.png); }
#main #footerbg #footercontent { background:<?php echo $colorfooter;?> url(images/footerbg3.png) no-repeat; }
#main #pagecontent #continut #pagetitle { background:<?php echo $colortitle;?> url(images/pagetitle.png); }
</style>

</head>