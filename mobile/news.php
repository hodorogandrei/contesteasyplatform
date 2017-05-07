<?php
    include_once("include/counter.php");

    initCounter();

    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }

    ob_start('callback');

    include_once("include/header.php");

    $sql = 'SELECT * FROM stiri WHERE id='.(int)($_GET['id']).'';
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0)
    {
        while($rand = mysql_fetch_array($result))
        {	
            $titlu=$rand['title'];
            $content=$rand['content'];
            $picture=$rand['picture'];
            $date=$rand['date'];
            $vizualizari=$rand['vizualizari'];
        }
        $vizualizari++;
        $sql = "UPDATE stiri SET vizualizari='.$vizualizari.' WHERE id='".(int)($_GET['id'])."'";
        mysql_query($sql);
    }
    else
    {
        $titlu = "&#350;tire inexistent&#259;";
        $nuexista=1;
    }
?>
<div id="pagecontent">
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu;?>
        </div>
        <div id="continut2">
            <?php if(!isset($nuexista)) 
                {?>
                <?php if(!empty($picture) && $picture!='newsimg/') {?>
                    <img src="../<?php echo $picture; ?>" border="0" align="right" style="margin: 5px;" />
                    <?php } echo $content; 
                ?>
                <br/>Aceast&#259; &#351;tire are <b><?php echo $vizualizari; ?> vizualiz&#259;ri</b>, dintre care <b><?php echo getCounter('unique');?> unice.</b>
                <?php } else  
                { ?>
                &#350;tirea pe care a&#355;i &icirc;ncercat s&#259; o accesa&#355;i nu exist&#259;!
                <? }?>
        </div>
    </div>
</div>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>