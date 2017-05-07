<?php
include 'class/class.keywordDensity.php';             // Include class  
$domain = ((empty ($_GET['url'])) ? 'news.cnet.com' : $_GET['url']);
$obj = new KD();                                      // New instance
$obj->domain = 'http://'.$domain;                     // Define Domain
?>
<p>Enter any URL you want to check <b>without leading http://</b></p>
<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="get">
<input type="text" name="url" value="">
<input type="submit" value="Check it!">
</form>
Result for <b><?php echo 'http://'.$domain?></b>:<br />
<?php
echo '<pre>';
print_r ($obj->result()); 
echo '</pre>';
?>
</body>
</html>