<?php
    require_once("include/config.php");
    require_once("include/functions.php");

    error_reporting(E_ERROR | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Desfasurare"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `onipag` WHERE id=5"; 
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
                $query="UPDATE `onipag` SET content='$content', title='$titlu' WHERE id=5";
                mysql_query($query);
            }
            else
                $mesaj = "C&acirc;mpul aferent titlului este obligatoriu";
        }

        $doSQL = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($doSQL);
        while($rand = mysql_fetch_object($rezultat))
        {
            $map = $rand -> map;
        }

        
        if(isset($_POST['submit_logo']))
        {
            if(is_valid($_FILES['uploadedfile']['tmp_name']))
            {
                $filename = basename( $_FILES['uploadedfile']['name']);
                $ext = end(explode('.', $filename));
                $ext = substr(strrchr($filename, '.'), 1);
                $ext = substr($filename, strrpos($filename, '.') + 1);
                $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                $exts = split("[/\\.]", $filename);
                $n = count($exts)-1;
                $ext = $exts[$n];

                if(strcmp($ext,'jpg')==0 || 
                strcmp($ext,'jpeg')==0 || 
                strcmp($ext,'png')==0 || 
                strcmp($ext,'bmp')==0 || 
                strcmp($ext,'gif')==0) $ok=1;
                else $ok=0;

                if($ok==1)
                {
                    //sterge imaginea veche
                    if($map!='images/')
                        unlink('../'.$map.'');
                }
                else
                {
                    $mesaj2 = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. 
                    Formate permise: .bmp, .png, .jpeg, .jpg, .png, .gif";
                }
            }
            //incarcarea imaginii, daca exista
            if((isset($ok) && $ok==1) || empty($_FILES['uploadedfile']['tmp_name']))
            {
                $target_path = "../images/";
                $target_path = $target_path . basename($_FILES['uploadedfile']['name']);
                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
                {
                    $mesaj2 = "Hart&#259; actualizat&#259;! Imaginea <span class=\"smalltitle\">".  basename( $_FILES['uploadedfile']['name'])."</span> a fost inc&#259;rcat&#259;.";
                    //echo '<meta http-equiv="Refresh" content="5; URL=informatii-generale.php" />';
                } 
                else
                {
                    $mesaj2 = "Nu a&#355;i selectat niciun fi&#351;ier!";
                    //echo '<meta http-equiv="Refresh" content="5; URL=informatii-generale.php" />';
                }
                if(is_valid($_FILES['uploadedfile']['tmp_name']))
                    $link = 'images/'.$_FILES['uploadedfile']['name'].'';
                else
                    $link = $map;
                if(is_valid($_FILES['uploadedfile']['tmp_name']))
                {
                    list($width, $height, $type, $attr) = getimagesize('../'.$link.'');
                    if($height>155)
                    {
                        include('../libraries/simpleImage.php');
                        $image = new SimpleImage();
                        $image->load('../'.$link.'');
                        $image->resizeToWidth(660);
                        $image->save('../'.$link.'');
                    }
                }
                if(is_valid($link))
                    $link = make_safe($link);

                $sql = "UPDATE `general` SET map='$link' WHERE id=1";
                mysql_query($sql);
            }
            else
            {
                $mesaj2 = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. 
                Formate permise: .bmp, .png, .jpeg, .jpg, .png, .gif";
            }
        }

    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
            <link rel="stylesheet" type="text/css" href="css/annotation.css" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Modificare hart&#259; &#351;i marcaje:</b><br/><br/>
                        <?php display_message($mesaj2);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="submit_logo" enctype="multipart/form-data" id="validate1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                            <table>
                                <?php
                                    if((is_valid($map)) && ($map!='images/'))
                                    {
                                    ?>
                                    <tr>
                                        <td>Harta curent&#259;: </td>
                                        <td>
                                            <img src="../<?php echo $map;?>" id="toAnnotate" />
                                        </td>
                                    </tr>
                                    <?php
                                    } else {?>
                                    <tr>
                                        <td colspan="2"><div class="smalltitle_black">Nu exist&#259; nicio hart&#259;.</div></td>
                                    </tr>
                                    <?php
                                    }
                                ?>
                                <tr>
                                    <td>Harta noua: </td>
                                    <td><input name="uploadedfile" type="file" data-validation-engine="validate[required]" />
                                        <br />
                                    </td>
                                </tr>
                                <?php if((is_valid($map)) && ($map!='images/')) 
                                    {?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="smalltitle_red">(Aten&#355;ie! Harta veche va fi &#351;tears&#259;!)</div><br/>
                                            <input name="submit_logo" type="submit" value="Actualizare Hart&#259;" class="no-warn" />
                                        </td>
                                    </tr>
                                    <?php } ?>
                            </table>
                        </form>
                        <br/><br/>
                        <b>Modificare date pagin&#259;:</b><br/><br/>
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
                            <input name="submit" type="submit" value="Actualizare" class="no-warn"/>
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>

   
            <script type="text/javascript" src="js/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/jquery.annotate.js"></script>
            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="libraries/editor/ckeditor.js"></script>
            <script type="text/javascript" src="libraries/editor/_samples/sample.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script language="javascript">
                $(window).load(function() {
                    $("#toAnnotate").annotateImage({
                        getUrl: "async-db/get-places.php",
                        saveUrl: "async-db/save-place.php",
                        deleteUrl: "async-db/delete-place.php",
                    });
                });
                $("#validate").validationEngine();
                $("#validate1").validationEngine();
            </script>    
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>