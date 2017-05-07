<?php
    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }

    ob_start('callback');

    include_once("include/header.php");

    $doSQL = "SELECT * FROM `onipag` WHERE id=4"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $titlu = $rand -> title;
    }

?>
<div id="pagecontent">
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu; ?>
        </div>
        <div id="continut2">
            <?php 
                $sql = "SELECT * FROM `sponsori` ORDER BY ordine ASC"; 
                $rezultat = mysql_query($sql);
                while($rand = mysql_fetch_array($rezultat))
                {
                    echo '<a href="'.$rand['link'].'" target="_blank"><img src="../images/sponsori/'.$rand['gfile'].'" alt="'.$rand['galt'].'" border="0" /></a><br/><br/>';
                }
            ?>

        </div>
    </div>
</div>
<?php

    include_once("include/footer.php");

    ob_end_flush();

?>