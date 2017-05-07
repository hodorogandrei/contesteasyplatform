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
            $sql = 'SELECT * FROM usrs2012 WHERE id='.$setid.'';
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
                while($rand = mysql_fetch_object($result))
                {	
                    $numele = $rand->username;
                    $curpass = $rand->pass;
            }
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
            
            
        if(isset($_POST['submit']))
        {
            if(is_valid($_POST['oldpass']) && is_valid($_POST['password']))
            {
                if(strlen($_POST['password'])>=6)
                {
                    if(strcmp($_POST['password'], $_POST['password2'])==0)
                    {
                        $oldpass = scrypt($_POST['oldpass']);
                        if(strcmp($oldpass, $curpass)==0)
                        {
                            $password = scrypt(make_safe_lite($_POST['password']));
                            
                            $sql="UPDATE usrs2012 SET pass = '$password' WHERE id = '$setid'";
                            mysql_query($sql);
                            
                            $mesaj = "Datele au fost actualizate.";
                        }
                        else
                            $mesaj = "Parola curent&#259; incorect&#259;! Nu au fost operate modific&#259;ri.";
                    }
                    else
                        $mesaj = "Parola nou&#259; confirmat&#259; incorect.";
                }
                else
                    $mesaj = "Parola introdus&#259; trebuie s&#259; con&#355;in&#259; minimum 6 caractere.";
            }
            else
                $mesaj = "Nu au fost operate modific&#259;ri.";
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/><?php display_message($mesaj); ?>
                        <img src="images/user.png" class="midalign"/>&nbsp;<b>Bine ai venit,</b> <i><?php echo $numele;?></i> :
                        <br/><br/>
                        <img src="images/perm.png" class="midalign"/>&nbsp;<b>Permisiuni:</b>
                        <?php
                            if($_SESSION['global'] == '1')
                                echo'permisiuni globale';
                            else
                            {
                                $sql = 'SELECT * FROM usrperm WHERE id_user = '.$_SESSION['userid'].'';
                                $result = mysql_query($sql);
                                $nr=0;
                                while($rand = mysql_fetch_object($result))
                                {
                                    if($rand->permisiune == 1)
                                    {
                                        $result2 = mysql_query('SELECT * FROM pagini WHERE id = '.$rand->pagina.'');
                                        while($rand2 = mysql_fetch_object($result2))
                                        {
                                            $nr++;
                                            if($nr==1)
                                                echo $rand2->pagina;
                                            else
                                                echo ' | '.$rand2->pagina;
                                        }
                                    }
                                }
                                echo '<br/><br/>Orice &icirc;ncercare de accesare a unei pagini nepermise v&#259; va redirec&#355;iona c&#259;tre <a href="index.php">pagina principal&#259;</a>.';
                            }
                        ?>
                        <?php if($_SESSION['createdby']!='administrator implicit') {?>
                            (cont creat de <i><?php echo $_SESSION['createdby'];?></i>)
                            <?php } ?>
                        <br/><br/>
                        <b>Editare parol&#259;:</b><Br/><Br/>
                        <form action="pagina-personala.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <table>
                                <tr>
                                    <td>
                                        Parola curent&#259;: 
                                    </td>
                                    <td>
                                        <input type="password" name="oldpass"   class="stfield" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Parola nou&#259;: 
                                    </td>
                                    <td>
                                        <input type="password" name="password" class="passmet" id="password" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Confirmare parola nou&#259;: 
                                    </td>
                                    <td>
                                        <input type="password" name="password2"  class="stfield" id="password-check" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="submit" name="submit" id="submit" value="Actualizare date" />
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>
            
            
            <script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
            <script type="text/javascript" src="js/pagina-personala.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>