<?php
    require_once("include/config.php");
    require_once("include/functions.php");

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {	
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Comentarii"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_POST['submit']))
        {
            $id = make_safe($_GET['id']);
            $nume = make_safe($_POST['nume']);
            $comentariu = make_safe($_POST['comentariu']);
            $aprobat = make_safe($_POST['aprobat']);
            $query="UPDATE `comentarii` SET nume='$nume', comentariu='$comentariu', aprobat='$aprobat' where id='$id'";
            mysql_query($query);
        }


        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = "SELECT * FROM `comentarii` WHERE id=".$_GET['id']."";
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $id = $rand -> id;
                $nume = $rand -> nume;
                $comentariu = $rand -> comentariu;
                $aprobat = $rand -> aprobat;
            }
            else
                $nuexista = 1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-comentarii.php');
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
                        <?php if(!isset($nuexista)) 
                            {
                            ?>
                            <br/>
                            <a href="administrare-comentarii.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="administrare-comentarii.php">&Icirc;napoi la pagina de administrare comentarii</a>
                            <br/><br/>
                            <b>Editare comentariu:</b><br/><br/> 
                            <form action="editare-comentariu.php?id=<?php echo make_safe($_GET['id']); ?>" method="post">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                Nume:
                                <input name="nume" type="text" value="<?php if(isset($nume)) echo $nume?>" class="stfield"/>
                                <br /><br />
                                <div style="vertical-align:top;">Comentariu:</div>
                                <textarea cols="80" name="comentariu" rows="10"><?php if(isset($comentariu)) echo $comentariu;?></textarea>
                                <br /><br />
                                Aprobat:
                                <select name="aprobat" class="stselect">
                                    <?php if($aprobat==1) { ?>
                                        <option value="1">Aprobat</option>
                                        <option value="0">Neaprobat</option>
                                        <?php } else { ?>
                                        <option value="0">Neaprobat</option>
                                        <option value="1">Aprobat</option>
                                        <?php } ?>
                                </select>
                                <input name="submit" type="submit" value="Actualizare comentariu" />
                            </form>
                            <? } else {?>
                            Comentariul pe care a&#355;i &icirc;ncercat s&#259; &icirc;l accesa&#355;i nu exist&#259;!
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>