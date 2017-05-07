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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Editare pagini"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_POST['submit']))
        {
            $id = make_safe($_GET['id']);
            $galt = make_safe($_POST['galt']);
            $link = $_POST['link'];
            if(!validateURL($link))
                $mesaj = "Adres&#259; web invalid&#259;.";
            else
            {
                $sql="UPDATE `gallery` SET galt='$galt', link='$link' WHERE id='$id'";
                mysql_query($sql);
                $mesaj = "Datele au fost actualizate!";
            }
        }


        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = "SELECT * FROM `gallery` WHERE id=".$_GET['id']."";
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $id = $rand -> id;
                $galt = $rand -> galt;
                $link = $rand -> link;
            }
            else
                $nuexista = 1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/editare-sponsori.php');
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
                        <?php if(!isset($nuexista)) 
                            {
                            ?>
                            <br/>
                            <a href="editare-galerie.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="editare-galerie.php">&Icirc;napoi la pagina de administrare a galeriei foto</a>
                            <br/><br/>
                            <?php
                                display_message($mesaj);
                            ?>
                            <b>Editare imagine galerie foto:</b><br/><br/> 
                            <form action="editare-foto.php?id=<?php echo $_GET['id'];?>" method="post" id="validate">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                Text alternativ imagine:
                                <input name="galt" type="text" value="<?php if(isset($galt)) echo $galt?>" class="stfield"/>
                                <br/><br/>
                                Link imagine:
                                <input name="link" type="text" value="<?php if(isset($link)) echo $link?>" class="stfield" data-validation-engine="validate[custom[url]]"/>
                                <br /><br />
                                <input name="submit" type="submit" value="Actualizare imagine" />
                            </form>
                            <? } else {?>
                            Comentariul pe care a&#355;i &icirc;ncercat s&#259; &icirc;l accesa&#355;i nu exist&#259;!
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>

            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#validate").validationEngine();
                });
            </script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>