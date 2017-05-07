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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Editare pagini"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `onipag` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $titlu = $rand -> title;
        $content = $rand -> content;

        if(isset($_POST['submit']))
        {
            $content = $_POST['editor'];
            $titlu = strip_tags($_POST['titlu']);
            if(is_valid($_POST['titlu']))
            {
                $query="UPDATE `onipag` SET content='$content', title='$titlu' WHERE id=1";
                mysql_query($query);
            }
            else
                $mesaj = "C&acirc;mpul aferent titlului este obligatoriu";
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="libraries/editor/_samples/sample.css"  />
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <a href="editare-pagini.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="editare-pagini.php">&Icirc;napoi la lista de pagini editabile</a>
                        <br/><br/>
                        <b>Home:</b><br/><br/>
                        <?php display_message($mesaj);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            Titlu:<br/><br/>
                            <input type="text" id="titlu" name="titlu" value="<?php echo $titlu;?>" class="stfield" data-validation-engine="validate[required]"/>
                            <br/><br/>
                            Con&#355;inut:<br/><br/>
                            <textarea class="ckeditor" cols="80" id="editor" name="editor" rows="10">
                                <?php
                                    echo $content;
                                ?>
                            </textarea>
                            <br/>
                            <input name="submit" type="submit" value="Actualizare Home" class="no-warn"/>
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>
            
            
            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="libraries/editor/ckeditor.js"></script>
            <script type="text/javascript" src="libraries/editor/_samples/sample.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script src="js/formValidator/jquery.validationEngine-ro.js" type="text/javascript" charset="utf-8"></script>
            <script type="text/javascript">
                $("#validate").validationEngine();
            </script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>
