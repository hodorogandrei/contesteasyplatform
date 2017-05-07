<?php
    require_once("../include/config.php");
    require_once("../include/functions.php");

    $doSQL = "SELECT * FROM `general` WHERE id=1"; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_object($rezultat))
    {
        $partpub = $rand -> partpub;
    }
    
    
    if($partpub==1)
    {
        $judet=make_safe($_POST['judet']);
        $clasa=make_safe($_POST['clasa']);
        $sort=make_safe($_POST['sort']);

        if($clasa=="9-12" && $judet=="Toate")
            $sql="SELECT * FROM `participanti` WHERE `clasa` BETWEEN 9 AND 12 ORDER BY ".$sort."";
        else if($clasa=="5-8" && $judet=="Toate")
                $sql="SELECT * FROM `participanti` WHERE `clasa` BETWEEN 5 AND 8 ORDER BY ".$sort."";
            else if ($clasa=="5-8")
                    $sql="SELECT * FROM `participanti` WHERE `clasa` BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY ".$sort." ";
                else if ($clasa=="9-12")
                        $sql="SELECT * FROM `participanti` WHERE `clasa` BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY ".$sort." ";
                    else if ($judet=="Toate")
                            $sql="SELECT * FROM `participanti` WHERE `clasa` = '".$clasa."' ORDER BY ".$sort." ";
                        else
                            $sql="SELECT * FROM `participanti` WHERE `judet` = '".$judet."' AND clasa = '".$clasa."' ORDER BY ".$sort." ";
        $rezultat = mysql_query($sql);
        if(mysql_num_rows($rezultat)>0)
        {
        ?>
        <table align="center" width="665" cellspacing="2" cellpadding="2" border="0">
            <tr class="part_header">
                <td style="text-align: left;">Nume</td>
                <td style="text-align: center;">Clasa</td>
                <td style="text-align: center;">Jude&#355;</td>
                <td style="text-align: center;">Unitatea &#351;colar&#259;</td>
                <td style="text-align: center;">Centrul de cazare</td>
                <td style="text-align: center;">Centrul de concurs</td>
            </tr>
            <?php
                $numar=0;
                while($rand = mysql_fetch_object($rezultat))
                {
                    $numar++;
                    if($numar % 2 == 0)
                    {
                        echo '<tr class="part_tr">';
                        echo '<td style="text-align: left;">' . $rand -> numele. '</td>';
                        echo '<td>' . $rand -> clasa . '</td>';
                        echo '<td>' . $rand -> judet . '</td>';
                        echo '<td>' . $rand -> unitatea . '</td>';
                        echo '<td>' . $rand -> cazare . '</td>';
                        echo '<td>' . $rand -> concurs . '</td>';
                        echo '</tr>';
                    }
                    else
                    {
                        echo '<tr class="part_tr_gri">';
                        echo '<td style="text-align: left;">' . $rand -> numele. '</td>';
                        echo '<td>' . $rand -> clasa . '</td>';
                        echo '<td>' . $rand -> judet . '</td>';
                        echo '<td>' . $rand -> unitatea . '</td>';
                        echo '<td>' . $rand -> cazare . '</td>';
                        echo '<td>' . $rand -> concurs . '</td>';
                        echo '</tr>';
                    }
                }
            ?>
        </table>
        <br/>Au fost g&#259;si&#355;i <b><?php echo mysql_num_rows($rezultat);?> elevi</b> dup&#259; criteriile specificate.
        <?php
        }
        else
        {
        ?>
        <center><span class="smalltitle_red">Nu au fost g&#259;si&#355;i elevi dup&#259; criteriile specificate.</span></center>
        <?php }
    }
    else
    {
    ?>
    <center><span class="smalltitle_red">Lista de participan&#355;i nu a fost &icirc;nc&#259; f&#259;cut&#259; public&#259;.</span></center>
    <?php } ?>