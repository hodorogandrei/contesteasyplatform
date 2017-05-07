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


        if(isset($_POST['sterge']) && is_numeric($_GET['id']))
        {
            $sql = "DELETE FROM `participanti` WHERE id=".$_GET['id']."";
            mysql_query($sql);
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-participanti.php');
        }


        if(isset($_POST['submit']))
        {
            $ok=1;
            $id=make_safe($_GET['id']);
            $numele=make_safe($_POST['numele']);
            $clasa=make_safe($_POST['clasa']);
            $unitatea = make_safe($_POST['unitatea']);
            $cazare = make_safe($_POST['cazare']);
            $concurs = make_safe($_POST['concurs']);
            if(is_valid($numele) && is_valid($clasa) && is_valid($unitatea))
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
                    $judet = $row -> judet;
                    $sql = "UPDATE `participanti` SET 
                    numele='$numele', 
                    clasa='$clasa', 
                    judet='$judet', 
                    unitatea='$unitatea', 
                    cazare='$cazare', 
                    concurs='$concurs' 
                    WHERE id='$id'";
                    mysql_query($sql);
                    $mesaj = "Datele participantului au fost actualizate!";
                }
                else
                    $mesaj = "A ap&#259;rut o eroare la selectarea jude&#539;ului sau a clasei!";
            }
            else
            {
                $ok=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii!";
            }
        }
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = "SELECT * FROM `participanti` where id=".$_GET['id']."";
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $id = $rand -> id;
                $numele = $rand -> numele;
                $clasa = $rand -> clasa;
                $judet = $rand -> judet;
                $unitatea = $rand -> unitatea;
                $cazare = $rand -> cazare;
                $concurs = $rand -> concurs;
            }
            else
                $nuexista = 1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-participanti.php');
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>

            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
            <link rel="stylesheet" type="text/css" href="css/confirm.css"  />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <?php if(!isset($nuexista)) 
                            {?>
                            <br/>
                            <a href="administrare-participanti.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="administrare-participanti.php">&Icirc;napoi la pagina de administrare participan&#355;i</a>
                            <br/><br/>
                            <b>Editare participant:</b>
                            <br/><br/>
                            <?php display_message($mesaj);?>
                            <form action="editare-participant.php?id=<?php echo $_GET['id'];?>" method="post" id="validate">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <table cellpadding="2" cellspacing="2">
                                    <tr>
                                        <td>Numele: </td>
                                        <td>
                                            <?php check_field($ok, "numele"); ?>
                                            <input name="numele" type="text" value="<?php check_isset("numele");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Clasa: </td>
                                        <td>
                                            <?php check_field_clasa($ok); ?>
                                            <select name="clasa" class="stselect">
                                                <option value="<?php echo $clasa;?>" selected="selected"><?php echo $clasa;?></option>
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
                                        <td>Jude&#355;: </td>
                                        <td>
                                            <?php check_field_judet($ok); ?>
                                            <select name="judet" class="stselect">
                                                <option value="<?php echo link_judet($judet);?>" selected="selected"><?php echo $judet;?></option>
                                                <?php
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
                                        <td>Unitatea &#351;colar&#259;: </td>
                                        <td><?php check_field($ok, "unitatea"); ?><input name="unitatea" type="text" value="<?php echo $unitatea;?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Centru de cazare: </td>
                                        <td><input name="cazare" type="text" value="<?php echo $cazare;?>" class="stfield" size="40"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Centru de concurs: </td>
                                        <td><input name="concurs" type="text" value="<?php echo $concurs;?>" class="stfield" size="40"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input name="submit" type="submit" value="Actualizare participant" />
                                        </td>
                                        <td>
                                            <input name="sterge" type="submit" value="&#350;tergere participant"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <?php } else {?>
                            Participantul pe care a&#355;i &icirc;ncercat s&#259; &icirc;l accesa&#355;i nu exist&#259;!
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/editare-participant.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>