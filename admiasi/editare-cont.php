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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare conturi"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_POST['sterge']) && is_numeric($_GET['id']))
        {
            $sql = "DELETE FROM `users` WHERE id=".$_GET['id']."";
            mysql_query($sql);
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/conturi.php');
        }


        if(isset($_POST['submit']))
        {
            $ok=1;
            $id=make_safe($_GET['id']);
            $username=make_safe($_POST['username']);
            $pass=scrypt($_POST['pass']);
            $nume=make_safe($_POST['nume']);
            $prenume=make_safe($_POST['prenume']);
            $email=make_safe($_POST['email']);
            $clasa=make_safe($_POST['clasa']);
            $judet=make_safe($_POST['judet']);
            $cnp=make_safe($_POST['cnp']);
            $aprobat=make_safe($_POST['aprobat']);
            if(is_valid($username)
            && is_valid($nume) 
            && is_valid($prenume) 
            && is_valid($email) 
            && is_valid($clasa) 
            && is_valid($judet) 
            && is_valid($cnp) 
            && is_numeric($aprobat)
            )
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
                    $sql = "SELECT * FROM `judete` WHERE id=".$_POST['judet']."";
                    $result = mysql_query($sql);
                    $row = mysql_fetch_object($result);
                    $judet = $row -> judet;
                    $sql = "UPDATE `users` SET 
                    nume='$nume', 
                    prenume='$prenume', 
                    username='$username',
                    judet='$judet',
                    clasa='$clasa',
                    aprobat='$aprobat'
                    WHERE id='$id'";
                    mysql_query($sql);
                    //verificare email
                    if(is_valid($email))
                    {
                        if(filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $sql="UPDATE `usrs2012` SET email = '".$email."' WHERE id = '$id'";
                            mysql_query($sql);   
                        }
                        else
                            $mesaj_email = "Adres&#259; email invalid&#259;!";
                    }
                    //verificare cnp
                    if(is_valid($cnp))
                    {
                        if(test_cnp($cnp))
                        {
                            $sql="UPDATE `usrs2012` SET cnp = '".$cnp."' WHERE id = '$id'";
                            mysql_query($sql);   
                        }
                        else
                            $mesaj_cnp = "CNP invalid!";
                    }
                    //verificare parola
                    if(is_valid($pass))
                    {
                        if(strlen($pass)>=6)
                        {
                            $sql="UPDATE `usrs2012` SET pass = '".(scrypt($pass))."' WHERE id = '$id'";
                            mysql_query($sql);
                        }
                        else
                            $mesaj_pass = "Parola trebuie s&#259; con&#355;in&#259; minimum 6 caractere. Celelalte date au fost actualizate!";
                    }
                    $mesaj = "Datele contului au fost actualizate!";
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
            $sql = "SELECT * FROM `users` where id=".$_GET['id']."";
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $id = $rand -> id;
                $username = $rand -> username;
                $nume = $rand -> nume;
                $prenume = $rand -> prenume;
                $judet = $rand -> judet;
                $clasa = $rand -> clasa;
                $cnp = $rand -> cnp;
                $email = $rand -> email;
                $aprobat = $rand -> aprobat;
            }
            else
                $nuexista = 1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/conturi.php');
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
                            <a href="conturi.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="conturi.php">&Icirc;napoi la pagina de administrare conturi</a>
                            <br/><br/>
                            <b>Editare participant:</b>
                            <br/><br/>
                            <?php display_message($mesaj_pass);?>
                            <?php display_message($mesaj_email);?>
                            <?php display_message($mesaj_cnp);?>
                            <?php display_message($mesaj);?>
                            <form action="editare-cont.php?id=<?php echo $_GET['id'];?>" method="post" id="validate">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <table cellpadding="2" cellspacing="2">
                                    <tr>
                                        <td>Username: </td>
                                        <td>
                                            <?php check_field($ok, "username"); ?>
                                            <input name="username" type="text" value="<?php check_isset("username");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Parol&#259;: </td>
                                        <td>
                                            <input name="pass" type="password" value="" class="stfield" size="40" />
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Nume: </td>
                                        <td>
                                            <?php check_field($ok, "nume"); ?>
                                            <input name="nume" type="text" value="<?php check_isset("nume");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Prenume: </td>
                                        <td>
                                            <?php check_field($ok, "prenume"); ?>
                                            <input name="prenume" type="text" value="<?php check_isset("prenume");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
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
                                        <td>CNP: </td>
                                        <td>
                                            <?php check_field($ok, "cnp"); ?>
                                            <input name="cnp" type="text" value="<?php check_isset("cnp");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Email: </td>
                                        <td>
                                            <?php check_field($ok, "email"); ?>
                                            <input name="email" type="text" value="<?php check_isset("email");?>" class="stfield" size="40" data-validation-engine="validate[required,custom[email]]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td>Aprobat: </td>
                                        <td>
                                            <select name="aprobat" class="stselect" data-validation-engine="validate[required]">
                                                <?php if($aprobat==1) { ?>
                                                    <option value="1">Aprobat</option>
                                                    <option value="0">Neaprobat</option>
                                                    <?php } else { ?>
                                                    <option value="0">Neaprobat</option>
                                                    <option value="1">Aprobat</option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input name="submit" type="submit" value="Actualizare date cont" />
                                        </td>
                                        <td>
                                            <input name="sterge" type="submit" value="&#350;tergere cont"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                            <?php } else {?>
                            Contul pe care a&#355;i &icirc;ncercat s&#259; &icirc;l accesa&#355;i nu exist&#259;!
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