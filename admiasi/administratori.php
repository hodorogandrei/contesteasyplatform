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
            $sql = "SELECT * FROM `usrs2012` where id='$setid'";
            $result = mysql_query($sql);
            if(mysql_num_rows($result) > 0)
                while($rand = mysql_fetch_array($result))
                {	
                    $global = $rand['global'];
                }
            if($global!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            if($_GET['sterge'] == 1)
                $mesaj = "Nu pute&#355;i opera modific&#259;ri asupra administratorului implicit.";
            elseif($_GET['sterge'] == $_SESSION['userid'])
                $mesaj = "Nu v&#259; pute&#355;i &#351;terge singur contul.";
            elseif($_GET['sterge'] == $_SESSION['createdby_id'])
                $mesaj = "Nu v&#259; pute&#355;i &#351;terge administratorul care v-a creat contul.";
                
            else
            {
                $mesaj = "Administratorul a fost &#351;ters.";
                $sql = "DELETE FROM `usrs2012` WHERE id=".$_GET['sterge']."";
                mysql_query($sql);
                $sql = "DELETE FROM `usrperm` WHERE id_user=".$_GET['sterge']."";
                mysql_query($sql);
            }
        }


        if(isset($_POST['submit']))
        {
            $ok=1;

            if(!empty($_POST['usernamenew']) && !empty($_POST['passwordnew']))
            {
                $usernamenew = $_POST['usernamenew'];
                $sql = "SELECT * FROM `usrs2012` WHERE username='$usernamenew'";
                $result = mysql_query($sql);
                $createdby = $_SESSION['nume'];
                $createdby_id = $_SESSION['userid'];
                
                if(mysql_num_rows($result) > 0)
                    $mesaj = "Exist&#259; deja un administrator cu acela&#351;i nume!";
                    
                else if(strlen($_POST['passwordnew'])>=6)
                    {
                        $sql = "INSERT INTO 
                        `usrs2012` 
                        (`username`, `pass`, `global`, `createdby`, `createdby_id`) 
                        VALUES ('".make_safe($_POST['usernamenew'])."',
                        '".(scrypt($_POST['passwordnew']))."',
                        '".make_safe($_POST['global'])."', 
                        '".make_safe($createdby)."', 
                        '".make_safe($createdby_id)."')";
                        mysql_query($sql);
                        
                        $mesaj = "Administrator ad&#259;ugat!";
                        
                        $sql = "SELECT * FROM `usrs2012` ORDER BY id DESC LIMIT 0,1";
                        $result = mysql_query($sql);
                        $rand = mysql_fetch_object($result);
                        $id_usr = $rand -> id;

                        $nr = 0;
                        $sql = "SELECT * FROM `pagini`";
                        $result = mysql_query($sql);
                        while($rand = mysql_fetch_object($result))
                        {
                            $nr++;
                            $v[$nr] = $rand -> id;
                        }
                        
                        
                        for($i=1; $i<=$nr; $i++)
                        {
                            $a = $v[$i];
                            foreach($_POST['perm'.$a.''] as $permisiuni)
                                mysql_query("INSERT INTO 
                                `usrperm` 
                                (`id_user`, `pagina`, `permisiune`) 
                                VALUES ('".($id_usr)."', 
                                '".($a)."', 
                                '".($permisiuni)."')");
                        }
                    }
                    else
                        $mesaj = "Parola trebuie s&#259; con&#355;in&#259; minimum 6 caractere!";
            }
            else
            {
                $ok=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii!";
            }
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
            <link rel="stylesheet" type="text/css" href="css/confirm.css" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
						<br/>
                        <b>Arhiv&#259; chat:</b>
                        <br/><br/>
						<a href="archive.php">Accesare arhiv&#259;</a>
                        <br/><br/>
                        <b>Administratori existen&#355;i:</b>
                        <br/><br/>
                        <table width="100%" id="mytable" class="tablesorter">
                            <thead>
                                <tr class="part_header">
                                    <th>Nume</th>
                                    <th>Permisiuni</th>
                                    <th><center>Creator</center></th>
                                    <th><center>Ultima autentificare</center></th>
                                    <th><center>Ultimul IP</center></th>
                                    <th>Ac&#355;iuni</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $numar=0;
                                    $sql = "SELECT * FROM `usrs2012` ORDER BY id ASC"; 
                                    $rezultat = mysql_query($sql);
                                    while($rand = mysql_fetch_array($rezultat))
                                    {
                                        $curglobal=0;
                                        if($rand['global']==1)
                                            $curglobal=1;
                                        echo'<tr>
                                        <td class="separate">'.$rand['username'].'</td>
                                        <td class="separate">';

                                        if(isset($curglobal) && $curglobal==1)
                                            echo '<img src="images/key_global.png" class="midalign" />&nbsp;permisiuni globale';
                                        else
                                        {
                                            $sql = "SELECT * FROM `usrperm` WHERE id_user = ".$rand['id']."";
                                            $result = mysql_query($sql);
                                            $nr=0;
                                            $row = mysql_fetch_object($result);
                                            if($rand->permisiune == 1)
                                            {
                                                $result2 = mysql_query('SELECT * FROM pagini WHERE id = '.$rand['pagina'].'');
                                                while($rand2 = mysql_fetch_array($result2))
                                                {
                                                    $nr++;
                                                    if($nr==1)
                                                        echo $rand2['pagina'];
                                                    else
                                                        echo '<br/>'.$rand2['pagina'];
                                                }
                                            }
                                        }
                                        
                                        
                                        echo '
                                        </td>
                                        <td class="separate"><center>'.$rand['createdby'].'</center></td>
                                        <td class="separate"><center><i>'.$rand['last_login'].'</i></center></td>
                                        <td class="separate"><center>';
                                        if(!empty($rand['last_ip']))
                                        {
                                            $countrycode="images/flags/".iptocountry($rand['last_ip']).".gif";
                                            if(file_exists($countrycode))
                                            {
                                                echo '<img src='.$countrycode.' width="30" height="15" class="midalign" />&nbsp;';
                                            }
                                            else
                                            {
                                                echo '<img src="images/flags/noflag.gif" width="30" height="15" class="midalign" />&nbsp;';
                                            }
                                            echo $rand['last_ip'];
                                        }
                                        else echo ' - ';
                                        echo '</center></td>
                                        <td class="separate">';
                                        echo '
                                        <a title="Modificare administrator" href="editare-administratori.php?id='.$rand['id'].'"><img src="images/edit.png" border="0" /></a><a title="&#350;tergere administrator" class="delete-link" id="'.$rand['id'].'" href="administratori.php?sterge='.$rand['id'].'"><img src="images/del.gif" border="0" /></a>
                                        ';
                                        echo '
                                        </td>
                                        </tr>';

                                    }

                                ?>
                            </tbody>
                        </table>
                        <hr />
                        <?php display_message($mesaj); ?>
                        <b>Ad&#259;ugare administrator:</b><br/><br/>
                        <form  enctype="multipart/form-data" action="administratori.php" method="post" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                <td>
                                    Username:
                                </td>
                                <td>
                                    &nbsp;<?php check_field($ok, "usernamenew");?><input type="text" name="usernamenew" value="<?php if(isset($_POST['usernamenew'])) echo $_POST['usernamenew'];?>" data-validation-engine="validate[required,minSize[5]]" class="stfield"/>
                                </td>
                                <tr>
                                <tr><td colspan="2" style="line-height: 0.5;">&nbsp;</td></tr>
                                <tr>
                                    <td>
                                        Parola:
                                    </td>
                                    <td>
                                        &nbsp;<?php check_field($ok, "passwordnew");?><input type="password" name="passwordnew" class="passmet" data-validation-engine="validate[required,minSize[6]]" />
                                    </td>
                                </tr>

                            </table>
                            <br/>
                            <table>
                                <tr>
                                    <td><br/>
                                        <img src="images/key_global.png" class="midalign"/>&nbsp;Acces global:
                                    </td>
                                    <td><br/>
                                        <input name="global" type="radio" value="1" checked="checked" class="globclick2" />da&nbsp;<img src="images/tick.png" /> | <input class="globclick" name="global" type="radio" value="0" /><img src="images/collapse.png" />&nbsp;nu
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
                                            echo'
                                            <tr>
                                                <td>'.$rand['pagina'].':</td> 
                                                <td>
                                                    <input name="perm'.$rand['id'].'[]" type="radio" value="1" />da&nbsp;
                                                    <img src="images/tick.png" /> 
                                                    | 
                                                    <input name="perm'.$rand['id'].'[]" type="radio" value="0" checked="checked" />
                                                    <img src="images/collapse.png" />&nbsp;nu&nbsp;&nbsp;
                                            '; 
                                            if(!empty($rand['mentiuni'])) 
                                                echo '<i>'.$rand['mentiuni'].'</i>'; 
                                            echo'</td>
                                            </tr>';
                                        }
                                    ?>
                                </table>
                            </div>
                            <input name="submit" type="submit" value="Ad&#259;ugare" />
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>

            
            <script type="text/javascript" src="js/tablesorter.min.js"></script>
            <script type="text/javascript" src="js/jquery.pstrength-min.1.2.js"></script>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">.otherperm {display: none;}</style>');
                //]]>
            </script>
            <script type="text/javascript" src="js/administratori.js"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>