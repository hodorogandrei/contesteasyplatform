<?php
    require_once("include/config.php");
    require_once("include/functions.php");

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare participanti"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $partpub = $rand -> partpub;


        if(isset($_POST['submit']))
        {
            $ok=1;
            if(
            is_valid($_POST['unitatea']) &&
            is_valid($_POST['numele']) && 
            is_numeric($_POST['clasa']) && 
            is_numeric($_POST['judet']))
            {
                if(isset($_POST['judet']) && 
                is_numeric($_POST['judet']) && 
                $_POST['judet'] >= 1 && 
                $_POST['judet'] <= 42

                &&

                isset($_POST['clasa']) &&
                is_numeric($_POST['clasa']) &&
                $_POST['clasa'] >= 5 &&
                $_POST['clasa'] <= 12)
                {
                    $sql = "SELECT `judet` FROM `judete` WHERE id=".$_POST['judet']."";
                    $result = mysql_query($sql);
                    $row = mysql_fetch_object($result);
                    $seljudet = $row -> judet;

                    $sql = "INSERT INTO 
                    `participanti`
                    (`numele`, 
                    `clasa`, 
                    `judet`, 
                    `unitatea`, 
                    `cazare`, 
                    `concurs`) 
                    VALUES 
                    ('".make_safe($_POST['numele'])."', 
                    '".$_POST['clasa']."', 
                    '".$seljudet."', 
                    '".make_safe_lite($_POST['unitatea'])."', 
                    '".make_safe($_POST['cazare'])."', 
                    '".make_safe($_POST['concurs'])."')";
                    mysql_query($sql);

                    $mesaj = "Participant ad&#259;ugat cu succes!";
                } 
                else
                    $mesaj = "A ap&#259;rut o eroare la selectarea jude&#539;ului &#351;i/sau a clasei!";
            }
            else 
            {
                $ok=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii!";
            }
        }


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $mesaj = "Participantul a fost &#351;ters!";
            $sql = "DELETE FROM `participanti` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);
        }


        if(isset($_POST['part_pub']))
        {
            if($_POST["checkbox"]!=1 ? $partpub=0 : $partpub=1);
            $query="UPDATE `general` SET partpub='$partpub' WHERE id=1";
            mysql_query($query);
            if($partpub==1)
                $mesaj= "Lista de participan&#355;i a fost f&#259;cut&#259; public&#259;.";
            else
                $mesaj= "Lista de participan&#355;i este acum vizibil&#259; doar din panoul de administrare.";
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Ad&#259;ugare participant:</b>
                        <br/><br/>
                        <?php display_message($mesaj);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <table cellpadding="2" cellspacing="2">
                                <tr>
                                    <td><?php check_field($ok, "numele");?>Numele: </td>
                                    <td><input name="numele" type="text" value="<?php if(isset($_POST['numele'])) echo $_POST['numele']?>" class="stfield"  data-validation-engine="validate[required]"/>
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td><?php check_field_clasa($ok);?>Clasa: </td>
                                    <td>
                                        <select name="clasa" class="stselect" data-validation-engine="validate[required]" data-prompt-position="topRight">
                                            <?php if(!isset($_POST['clasa'])) { ?>
                                                <option selected="selected" value="">Selectati o clasa</option>
                                                <?php } else { ?>
                                                <option value="<?php echo $_POST['clasa'];?>" selected="selected"><?php echo $_POST['clasa'];?></option>
                                                <?php } ?>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php check_field_judet($ok);?>Jude&#355;: </td>
                                    <td>
                                        <select name="judet" class="stselect" data-validation-engine="validate[required]" data-prompt-position="topRight">
                                            <?php if(!isset($_POST['judet'])) { ?>
                                                <option selected="selected" value="">Selectati un judet</option>
                                                <?php } else { ?>
                                                <option value="<?php echo $_POST['judet'];?>" selected="selected"><?php echo $seljudet;?></option>
                                                <?php } 

                                                $sql = "SELECT * FROM `judete`";
                                                $result = mysql_query($sql);
                                                while($rand = mysql_fetch_object($result))
                                                {
                                                    echo '<option value="'.$rand -> id.'">'.$rand -> judet.'</option>';
                                                    echo "\n";
                                                }
                                            ?>
                                        </select>
                                        <br />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php check_field($ok, "unitatea");?>Unitatea &#351;colar&#259;: </td>
                                    <td><input name="unitatea" type="text" value="<?php if(isset($_POST['unitatea'])) echo $_POST['unitatea'];?>" class="stfield" data-validation-engine="validate[required]"/>
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td>Centru de cazare: </td>
                                    <td><input name="cazare" type="text" value="<?php if(isset($_POST['cazare'])) echo $_POST['cazare'];?>" class="stfield"/>
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td>Centru de concurs: </td>
                                    <td><input name="concurs" type="text" value="<?php if(isset($_POST['concurs'])) echo $_POST['concurs'];?>" class="stfield"/>
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input name="submit" type="submit" value="Ad&#259;ugare participant" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br/><br/><b>Administrare participan&#355;i:</b><br/><br/>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <input name="checkbox" type="checkbox" value="1" style="vertical-align: middle;" <?php if($partpub==1) {?> checked="checked" <?}?>/><b>Lista de participan&#355;i este public&#259;</b>
                            &nbsp;<input name="part_pub" type="submit" value="Actualizare" />
                        </form>
                        <br/><span class="smalltitle_blue">C&#259;utare</span> <span class="smalltitle_grey">participant pentru editare:</span><br/><br/>
                        <div class="hiddendiv">
                            <div class="ausu-suggest">
                                <input type="text" size="25" value="" name="participant" id="participant" autocomplete="off" />
                            </div>
                        </div>
                        <?php noscript_text("Nu pute&#355;i c&#259;uta dec&acirc;t cu Javascript activat!");?>
                        <br/><br/><br/>
                        <span class="smalltitle_blue">Op&#355;iuni</span> <span class="smalltitle_grey">c&#259;utare</span><br/><br/>
                        <?php noscript_text("Nu pute&#355;i c&#259;uta dec&acirc;t cu Javascript activat!");?>
                        <div class="hiddendiv">
                            <form enctype="text/plain" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <table cellpadding="0" cellspacing="5">
                                    <tr>
                                        <td>Jude&#355;: </td>
                                        <td>
                                            <select id="judet" class="stselect">
                                                <option selected="selected" value="Toate">Toate</option>
                                                <?php
                                                    $sql = "SELECT * FROM `judete`";
                                                    $result = mysql_query($sql);
                                                    while($rand = mysql_fetch_array($result))
                                                    {
                                                        echo '<option value="'.$rand['judet'].'">'.$rand['judet'].'</option>';
                                                        echo "\n";
                                                    }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Clasa: </td>
                                        <td>
                                            <select id="clasa" class="stselect">
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
                                            <select id="sort" class="stselect">
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
                        <noscript>
                            <br/><br/>
                            <?php
                                $sql = "SELECT * FROM `participanti` ORDER BY clasa";
                                $rezultat = mysql_query($sql);
                                if(mysql_num_rows($rezultat)>0)
                                {
                                ?>
                                <table align="center" width="100%" cellspacing="2" cellpadding="2" border="0">
                                    <tr class="part_header">
                                        <td style="text-align: left;">Nume</td>
                                        <td>Clasa</td>
                                        <td>Jude&#355;</td>
                                        <td>Unitatea &#351;colar&#259;</td>
                                        <td>Centru cazare</td>
                                        <td>Centru concurs</td>
                                        <td>Ac&#355;iuni</td>
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
                                                echo '
                                                <td><a href="administrare-participanti.php?sterge='.$rand -> id.'">
                                                <img src="images/del.png" border="0" /></a>&nbsp;
                                                <a href="editare-participant.php?id='.$rand -> id.'">
                                                <img src="images/edit.png" border="0" />
                                                </a>
                                                </td>';
                                                echo "</tr>";
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
                                                echo '
                                                <td>
                                                <a href="administrare-participanti.php?sterge='.$rand -> id.'">
                                                <img src="images/del.png" border="0" /></a>&nbsp;
                                                <a href="editare-participant.php?id='.$rand -> id.'">
                                                <img src="images/edit.png" border="0" />
                                                </a>
                                                </td>';
                                                echo "</tr>";
                                            }
                                        }
                                    ?>
                                </table>
                                <?php
                                }
                                else
                                {
                                ?>
                                <center><span class="smalltitle_red">Nu exist&#259; elevi de afiÅŸat</span></center>
                                <?php } ?>
                        </noscript>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>



            <script type="text/javascript" src="js/autosuggest.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">.hiddendiv {display: block;}</style>');
                //]]>
            </script>
            <script type="text/javascript" src="js/administrare-participanti.js"></script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>