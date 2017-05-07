<?php
    require_once("../include/config.php");
    require_once("../include/functions.php");

    $judet = make_safe($_POST['judet']);
    $clasa = make_safe($_POST['clasa']);
    $sort  = make_safe($_POST['sort']);
	
    $sql = "SELECT * FROM `participanti` ";
    if($clasa=="9-12" && $judet=="Toate")
        $where = "WHERE `clasa` BETWEEN 9 AND 12 ORDER BY ".$sort."";
    elseif($clasa=="5-8" && $judet=="Toate")
        $where = "WHERE `clasa` BETWEEN 5 AND 8 ORDER BY ".$sort."";
    elseif ($clasa=="5-8")
        $where="WHERE `clasa` BETWEEN 5 AND 8 AND judet = '".$judet."' ORDER BY ".$sort." ";
    elseif ($clasa=="9-12")
        $where ="WHERE `clasa` BETWEEN 9 AND 12 AND judet = '".$judet."' ORDER BY ".$sort." ";
    elseif ($judet=="Toate")
        $where = "WHERE `clasa` = '".$clasa."' ORDER BY ".$sort." ";
    else
        $where = "WHERE `judet` = '".$judet."' AND `clasa` = '".$clasa."' ORDER BY ".$sort." ";

    $sql .= $where;
    $rezultat = mysql_query($sql);
    if(mysql_num_rows($rezultat) > 0)
    {
    ?>

    <link type="text/css" href="css/confirm.css" rel="stylesheet" media="screen" />

    <script type="text/javascript" src="js/jquery.min-164.js"></script>
    <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
    <script type="text/javascript" src="js/confirm.js"></script>
    <script type="text/javascript" src="js/administrare-participanti.js"></script> 

    <table align="center" width="100%" cellspacing="2" cellpadding="2" border="0" class="tablesorter" id="mytable">
        <thead>
            <tr class="part_header">
                <th style="text-align: left;">Nume</th>
                <th>Clasa</th>
                <th>Jude&#355;</th>
                <th>Unitatea &#351;colar&#259;</th>
                <th>Centru cazare</th>
                <th>Centru concurs</th>
                <th>Ac&#355;iuni</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $numar=0;
                while($rand = mysql_fetch_array($rezultat))
                {
                    $numar++;
                    if($numar%2==0)
                    {
                        echo '
                        <tr class="part_tr edit_tr" id="'.$rand['id'].'">';       
                        echo '
                        <td class="edit_td" style="text-align: left;">
                        <span id="numele_'.$rand['id'].'" class="text">'.$rand['numele'].'</span>
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
                        <span id="unitatea_'.$rand['id'].'" class="text">' . $rand['unitatea'] . '</span>
                        <input type="text" value="'.$rand['unitatea'].'" class="editbox" id="unitatea_input_'.$rand['id'].'"/> 
                        </td>';
                        echo '
                        <td class="edit_td">
                        <span id="cazare_'.$rand['id'].'" class="text">' . $rand['cazare'] . '</span>
                        <input type="text" value="'.$rand['cazare'].'" class="editbox" id="cazare_input_'.$rand['id'].'"/>
                        </td>';
                        echo '
                        <td class="edit_td">
                        <span id="concurs_'.$rand['id'].'" class="text">' . $rand['concurs'] . '</span>
                        <input type="text" value="'.$rand['concurs'].'" class="editbox" id="concurs_input_'.$rand['id'].'"/>
                        </td>'; 
                        echo '<td><a title="Stergere" class="delete-link" href="administrare-participanti.php?sterge='.$rand['id'].'" id="'.$rand['id'].'"><img src="images/del.png" border="0" /></a>&nbsp;<a title="Editare" href="editare-participant.php?id='.$rand['id'].'"><img src="images/edit.png" border="0" /></a></span></td>';
                        echo '
                        </tr>';
                    }
                    else
                    {
                        echo '
                        <tr class="part_tr_gri edit_tr" id="'.$rand['id'].'">';
                        echo '
                        <td class="edit_td" style="text-align: left;">
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
                        <span id="unitatea_'.$rand['id'].'" class="text">' . $rand['unitatea'] . '</span>
                        <input type="text" value="'.$rand['unitatea'].'" class="editbox" id="unitatea_input_'.$rand['id'].'"/>
                        </td>';
                        echo '
                        <td class="edit_td">
                        <span id="cazare_'.$rand['id'].'" class="text">' . $rand['cazare'] . '</span>
                        <input type="text" value="'.$rand['cazare'].'" class="editbox" id="cazare_input_'.$rand['id'].'"/>
                        </td>';
                        echo '
                        <td class="edit_td">
                        <span id="concurs_'.$rand['id'].'" class="text">' . $rand['concurs'] . '</span>
                        <input type="text" value="'.$rand['concurs'].'" class="editbox" id="concurs_input_'.$rand['id'].'"/>
                        </td>';
                        echo '<td><a title="Stergere" href="administrare-participanti.php?sterge='.$rand['id'].'" id="'.$rand['id'].'" class="delete-link"><img src="images/del.png" border="0" /></a>&nbsp;<a title="Editare" href="editare-participant.php?id="'.$rand['id'].'"><img src="images/edit.png" border="0" /></a></td>';
                        echo '
                        </tr>';
                    }
                }
            ?>
        </tbody>
    </table>
    <table width="100%">
        <tr class="part_header">
            <td>
                &nbsp;
            </td>
        </tr>
    </table>

    <?php
        include("../include/popup.php");
    }
    else
    {
    ?>
    <center><span class="smalltitle_red">Nu exist&#259; elevi cu aceste caracteristici</span></center>
    <?php } ?>
