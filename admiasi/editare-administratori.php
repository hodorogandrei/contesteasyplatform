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
            $sql = "SELECT * FROM usrs2012 where id='$setid'";
            $result = mysql_query($sql);
            
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_array($result);
                $global = $rand['global'];
            }
            
            if($global!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/logout.php');


        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = "SELECT * FROM usrs2012 where id = ".$_GET['id']."";
            $result = mysql_query($sql);
            $rand = mysql_fetch_array($result);
            $user = $rand['username'];
            $global2 = $rand['global'];

            $sql = "SELECT * FROM usrperm where id_user = ".$_GET['id']."";
            $result = mysql_query($sql);
            while($rand = mysql_fetch_array($result))
            {
                $perm[$rand['pagina']] = $rand['permisiune'];
            }
        }


        if(isset($_POST['submit']))
        {
            if(is_valid($_POST['username']))
            {
                $id = make_safe($_GET['id']);
                $username = make_safe($_POST['username']);
                $sql = "UPDATE `usrs2012` SET username='$username' WHERE id='$id'";
                mysql_query($sql);
            }
            if(is_valid($_POST['password']))
            {
                if(strlen($_POST['password'])>=6)
                {
                    $sql="UPDATE `usrs2012` SET pass = '".(scrypt($_POST['password']))."' where id = '$id'";
                    mysql_query($sql);
                }
                else
                    $mesaj = "Parola trebuie s&#259; con&#355;in&#259; minimum 6 caractere. Celelalte date au fost actualizate!";
            }
            $global=make_safe($_POST['global']);
            $sql="UPDATE `usrs2012` set global = '$global' WHERE id = '$id'";
            if(!isset($mesaj))
                $mesaj = "Datele au fost actualizate!";
            mysql_query($sql);
            $nr = 0;
            $sql = "SELECT * FROM `pagini`";
            $result = mysql_query($sql);
            while($rand = mysql_fetch_object($result))
            {
                $nr++;
                $v[$nr] = $rand->id;
            }
            for($i=1; $i<=$nr; $i++)
            {
                $a = $v[$i];
                foreach($_POST['perm'.$a.''] as $permisiuni)
                {
                    $sql="UPDATE `usrperm` SET  `permisiune` = ".$permisiuni." WHERE `id_user` = ".make_safe($_GET['id'])." AND `pagina` = ".$a." ";
                    mysql_query($sql);
                }
            } 
        }
        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            if($_GET['id']==1)
            {
                $mesaj2 = "Nu puteti opera modificari asupra administratorului implicit.";
                $cont=0;
            }
            else if($_GET['id']==$_SESSION['userid'])
                {
                    $mesaj2 = "Nu v&#259; pute&#355;i modifica singuri permisiunile.";
                    $cont = 0;
                }
                else if($_GET['id']==$_SESSION['createdby_id'])
                    {
                        $mesaj2 = "Nu v&#259; pute&#355;i modifica permisiunile administratorului care v-a creat contul.";
                        $cont = 0;
                    }
                    else
                    {
                        $sql = "SELECT * FROM usrs2012 where id = ".$_GET['id']."";
                        $result = mysql_query($sql);
                        $rand = mysql_fetch_array($result);
                        $user = $rand['username'];
                        $global = $rand['global'];

                        $sql = "SELECT * FROM usrperm where id_user = ".$_GET['id']."";
                        $result = mysql_query($sql);
                        while($rand = mysql_fetch_array($result))
                        {
                            $perm[$rand['pagina']] = $rand['permisiune'];
                        }
            }
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
                        <?php display_message($mesaj2); ?>
                        <?php if(!isset($cont)) {?>

                            <b>Editare administrator:</b><br/><br/>
                            <?php display_message($mesaj); ?>
                            <form  enctype="multipart/form-data" action="editare-administratori.php?id=<?php echo make_safe($_GET['id']); ?>" method="post" id="validate">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                    <td>
                                        Username: 
                                    </td>
                                    <td>
                                        &nbsp;<input type="text" name="username" value="<?php echo $user ?>" class="stfield" data-validation-engine="validate[required,minSize[5]]"/>
                                    </td>
                                    <tr>
                                    <tr><td colspan="2" style="line-height: 0.5;">&nbsp;</td></tr>
                                    <tr>
                                        <td>
                                            Parola:
                                        </td>
                                        <td>
                                            &nbsp;<input type="password" name="password" class="passmet" data-validation-engine="validate[required,minSize[6]]"/>
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td><br/>
                                            <img src="images/key_global.png" class="midalign" />&nbsp;Acces global:
                                        </td>
                                        <td><br/>
                                            <input class="globclick2" name="global" type="radio" value="1" 
                                            <?php if($global2 == 1) echo'checked="checked"'; ?>/>
                                            <img src="images/tick.png" /> 
                                            | 
                                            <input class="globclick" id="button" name="global" type="radio" value="0" 
                                            <?php if($global2 == 0) echo'checked="checked"'; ?>/>
                                            <img src="images/collapse.png" />
                                        </td>
                                    </tr>
                                </table>
                                <br/>
                                <div class="otherperm">
                                    <table>
                                        <?php
                                            $sql = "SELECT * FROM `pagini`";
                                            $result = mysql_query($sql);
                                            while($rand = mysql_fetch_array($result))
                                            {
                                                if($perm[$rand['id']]==1) $var = 'checked';
                                                else $var='';
                                                if($perm[$rand['id']]==0) $var2 = 'checked';
                                                else $var2='';
                                                echo'<tr>
                                                    <td>'.$rand['pagina'].':</td> 
                                                    <td>
                                                        <input name="perm'.$rand['id'].'[]" type="radio" value="1" '.$var.' />
                                                        <img src="images/tick.png" /> 
                                                        | <input name="perm'.$rand['id'].'[]" type="radio" value="0" '.$var2.' />
                                                        <img src="images/collapse.png" />
                                                    </td>
                                                </tr>';
                                            }
                                        ?>
                                    </table>
                                </div>
                                <input name="submit" type="submit" value="Actualizare" />
                            </form>
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>

            
            <script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
            <?php if($global2 == 1) {?>
                <script type="text/javascript">
                    //<![CDATA[
                    document.write('<style type="text/css">.otherperm {display: none;}</style>');
                    //]]>
                </script>
                <?php } ?>
            <script type="text/javascript" src="js/editare-administratori.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js"  charset="utf-8"></script>
        </body>
    </html>
    <?php
    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>