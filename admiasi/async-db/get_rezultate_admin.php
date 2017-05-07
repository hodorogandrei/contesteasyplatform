<?php
    require_once("../include/functions.php");
    require_once("../include/config.php");

    $judet=make_safe($_POST['judet']);
    $clasa=make_safe($_POST['clasa']);
    $sort=make_safe($_POST['sort']);

    if($sort=="total")
    {
        if($clasa=="9-12" && $judet=="Toate")
            $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 ORDER BY total desc";
        else if($clasa=="5-8" && $judet=="Toate")
                $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 ORDER BY total desc";
            else if ($clasa=="5-8")
                    $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY total desc";
                else if ($clasa=="9-12")
                        $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY total desc";
                    else if ($judet=="Toate")
                            $sql="SELECT * FROM rezultate WHERE clasa = '".$clasa."' ORDER BY total desc";
                        else
                            $sql="SELECT * FROM rezultate WHERE judet = '".$judet."' AND clasa = '".$clasa."' ORDER BY total desc";
    }
    else
    {
        if($clasa=="9-12" && $judet=="Toate")
            $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 ORDER BY ".$sort."";
        else if($clasa=="5-8" && $judet=="Toate")
                $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 ORDER BY ".$sort."";
            else if ($clasa=="5-8")
                    $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY ".$sort." ";
                else if ($clasa=="9-12")
                        $sql="SELECT * FROM rezultate WHERE clasa BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY ".$sort." ";
                    else if ($judet=="Toate")
                            $sql="SELECT * FROM rezultate WHERE clasa = '".$clasa."' ORDER BY ".$sort." ";
                        else
                            $sql="SELECT * FROM rezultate WHERE judet = '".$judet."' AND clasa = '".$clasa."' ORDER BY ".$sort." ";
    }
    $rezultat = mysql_query($sql);
    if(mysql_num_rows($rezultat)>0)
    {
    ?>


    <link type="text/css" href="css/confirm.css" rel="stylesheet" media="screen" />
    <script type="text/javascript" src="js/jquery.min-164.js"></script>
    <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
    <script type="text/javascript" src="js/confirm.js"></script>
    <script type="text/javascript" src="js/administrare-rezultate.js"></script>


    <table align="center" width="100%" cellspacing="2" cellpadding="2" border="0">
        <tr class="part_header">
            <td style="text-align: left;">Nume</td>
            <td>Clasa</td>
            <td>Jude&#355;</td>
            <td>Punctaj Total</td>
            <td>Observa&#355;ii</td>
            <td>Premiu</td>
            <td>Medalie</td>
            <td>Ac&#355;iuni</td>
        </tr>
        <?php
            $numar=0;
            while($rand = mysql_fetch_array($rezultat))
            {
                $numar++;
                if($numar % 2 == 0)
                {
                    echo '<tr class="part_tr edit_tr" id="'.$rand['id'].'">';
                    echo '
                    <td style="text-align: left;" class="edit_td">
                    <span id="numele_'.$rand['id'].'" class="text">' . $rand['numele'] . '</span>
                    <input type="text" value="'.$rand['numele'].'" class="editbox" id="numele_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="clasa_'.$rand['id'].'" class="text">' . $rand['clasa'] . '</span>
                    <select name="clasa" class="stselect editbox" id="clasa_input_'.$rand['id'].'">
                        <option value="'.$rand['clasa'].'" selected="selected">'.$rand['clasa'].'</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="judet_'.$rand['id'].'" class="text">' . $rand['judet'] . '</span>
                    <select id="judet_input_'.$rand['id'].'" class="stselect editbox">
                        <option selected="selected" value="'.$rand['judet'].'">'.$rand['judet'].'</option>';
                        $sql = "SELECT * FROM `judete`";
                        $result = mysql_query($sql);
                        while($rand2 = mysql_fetch_array($result))
                        {
                            echo '<option value="'.$rand2['judet'].'">'.$rand2['judet'].'</option>';
                            echo "\n";
                        }
                    echo'
                    </select>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="total_'.$rand['id'].'" class="text">' . $rand['total'] . '</span>
                    <input type="text" value="'.$rand['total'].'" class="editbox" id="total_input_'.$rand['id'].'" size="3"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="observatii_'.$rand['id'].'" class="text">' . $rand['observatii'] . '</span>
                    <input type="text" value="'.$rand['observatii'].'" class="editbox" id="observatii_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="premiu_'.$rand['id'].'" class="text">' . $rand['premiu'] . '</span>
                    <input type="text" value="'.$rand['premiu'].'" class="editbox" id="premiu_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="medalie_'.$rand['id'].'" class="text">' . $rand['medalie'] . '</span>
                    <input type="text" value="'.$rand['medalie'].'" class="editbox" id="medalie_input_'.$rand['id'].'"/>
                    </td>';
                    echo '<td><a title="Stergere" href="administrare-rezultate.php?sterge='.$rand['id'].'" id="'.$rand['id'].'" class="delete-link"><img src="images/del.png" border="0" /></a>&nbsp;<a title="Editare" href="editare-rezultat.php?id='.$rand['id'].'"><img src="images/edit.png" border="0" /></a></td>';
                    echo '</tr>';
                }
                else
                {
                    echo '<tr class="part_tr_gri edit_tr" id="'.$rand['id'].'">';
                    echo '
                    <td style="text-align: left;" class="edit_td">
                    <span id="numele_'.$rand['id'].'" class="text">' . $rand['numele'] . '</span>
                    <input type="text" value="'.$rand['numele'].'" class="editbox" id="numele_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="clasa_'.$rand['id'].'" class="text">' . $rand['clasa'] . '</span>
                    <select name="clasa" class="stselect editbox" id="clasa_input_'.$rand['id'].'">
                        <option value="'.$rand['clasa'].'" selected="selected">'.$rand['clasa'].'</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="judet_'.$rand['id'].'" class="text">' . $rand['judet'] . '</span>
                    <select id="judet_input_'.$rand['id'].'" class="stselect editbox">
                        <option selected="selected" value="'.$rand['judet'].'">'.$rand['judet'].'</option>';
                        $sql = "SELECT * FROM `judete`";
                        $result = mysql_query($sql);
                        while($rand2 = mysql_fetch_array($result))
                        {
                            echo '<option value="'.$rand2['judet'].'">'.$rand2['judet'].'</option>';
                            echo "\n";
                        }
                    echo'
                    </select>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="total_'.$rand['id'].'" class="text">' . $rand['total'] . '</span>
                    <input type="text" value="'.$rand['total'].'" class="editbox" id="total_input_'.$rand['id'].'" size="3"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="observatii_'.$rand['id'].'" class="text">' . $rand['observatii'] . '</span>
                    <input type="text" value="'.$rand['observatii'].'" class="editbox" id="observatii_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="premiu_'.$rand['id'].'" class="text">' . $rand['premiu'] . '</span>
                    <input type="text" value="'.$rand['premiu'].'" class="editbox" id="premiu_input_'.$rand['id'].'"/>
                    </td>';
                    echo '
                    <td class="edit_td">
                    <span id="medalie_'.$rand['id'].'" class="text">' . $rand['medalie'] . '</span>
                    <input type="text" value="'.$rand['medalie'].'" class="editbox" id="medalie_input_'.$rand['id'].'"/>
                    </td>';
                    echo '<td><a title="Stergere" href="administrare-rezultate.php?sterge='.$rand['id'].'" id="'.$rand['id'].'" class="delete-link"><img src="images/del.png" border="0" /></a>&nbsp;<a title="Editare" href="editare-rezultat.php?id='.$rand['id'].'"><img src="images/edit.png" border="0" /></a></td>';
                    echo '</tr>';
                }
            }
        ?>
    </table>


    <?php
        include("../include/popup.php");
    }
    else
    {
    ?>
    <center><span class="smalltitle_red">Nu exist&#259; elevi cu aceste caracteristici</span></center>
    <?php } ?>
