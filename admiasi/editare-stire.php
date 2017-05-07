<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    include_once("../include/counter.php");

    error_reporting(E_ERROR | E_PARSE);

    initCounter();

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare stiri"));
            if($acces==0) $accespart=check_perm("Adaugare stire");
            if($acces!=1 && isset($accespart) && $accespart!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        if(isset($_GET['id']) && is_numeric($_GET['id']))
            $setid = $_GET['id'];
        else if(isset($_GET['reset']) && is_numeric($_GET['reset']))
                $setid = $_GET['reset'];
            else if(isset($_GET['deletepic']) && is_numeric($_GET['deletepic']))
                    $setid = $_GET['deletepic'];


        if(isset($setid))
        {
            $sql = 'SELECT * FROM `stiri` WHERE id='.$setid.'';
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $postby = $rand -> postby;
                if(isset($accespart) && $postby!=$_SESSION['nume'])
                    header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');

                $id = $rand -> id;
                $titlu = $rand -> title;
                $continut = $rand -> content;
                $picturenws = $rand -> picture;
                $vizualizari = $rand -> vizualizari;
                $date = $rand -> date;
            }
            else
                $nuexista=1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-stiri.php');



        if(isset($_POST['submit_stire']))
        {
            if(is_valid($_POST['titlu']))
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
                    if(strcmp($ext,'jpg')==0 || strcmp($ext,'jpeg')==0 || strcmp($ext,'png')==0 || strcmp($ext,'gif')==0 || strcmp($ext,'bmp')==0 || strcmp($ext,'png')==0 ) $ok=1;
                    else $ok=0;
                    if($ok==1)
                    {
                        //sterge imaginea veche
                        if($picturenws!='newsimg/')
                            unlink('../'.$picturenws.'');
                        $permalink = toAscii($_POST['titlu']);
                    }
                    else
                    {
                        $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Formate permise: .bmp, .png, .jpeg, .jpg, .gif, .png";
                    }
                }
                //incarcarea imaginii, daca exista
                if((isset($ok) && $ok==1) || empty($_FILES['uploadedfile']['tmp_name']))
                {
                    $target_path = "../newsimg/";
                    $target_path = $target_path . basename($_FILES['uploadedfile']['name']);
                    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
                    {
                        $mesaj = "&#350;tire actualizat&#259;! Imaginea <span class=\"smalltitle\">".  basename( $_FILES['uploadedfile']['name'])."</span> a fost inc&#259;rcat&#259;. V&#259; rug&#259;m a&#351;tepta&#355;i...";
                        echo '<meta http-equiv="Refresh" content="5; URL=editare-stire.php?id='.$setid.'" />';
                    } 
                    else
                    {
                        $mesaj = "&#350;tire actualizat&#259;! Nu a fost &icirc;nc&#259;rcat&#259;/actualizat&#259; imaginea asociat&#259;. V&#259; rug&#259;m a&#351;tepta&#355;i...";
                        echo '<meta http-equiv="Refresh" content="5; URL=editare-stire.php?id='.$setid.'" />';
                    }
                    if(is_valid($_FILES['uploadedfile']['tmp_name']))
                        $link = 'newsimg/'.$_FILES['uploadedfile']['name'].'';
                    else
                        $link = $picturenws;
                    if(is_valid($_FILES['uploadedfile']['tmp_name']))
                    {
                        $widthimg = $_POST['widthimg'];
                        if(is_numeric($widthimg))
                        {
                            if($widthimg<=500)
                            {
                                list($width, $height, $type, $attr) = getimagesize('../'.$link.'');
                                if($width>$widthimg)
                                {
                                    include('../libraries/simpleImage.php');
                                    $image = new SimpleImage();
                                    $image -> load('../'.$link.'');
                                    $image -> resizeToWidth($widthimg);
                                    $image -> save('../'.$link.'');
                                }
                            }
                            else
                            {
                                $mesaj = "L&#259;&#539;imea imaginii nu poate dep&#259;&#537;i 500 pixeli.";
                            }
                        }
                        else
                        {
                            $mesaj = "C&acirc;mpul aferent l&#259;&#539;imii imaginii asociate trebuie s&#259; fie un num&#259;r &icirc;ntreg.";
                        }
                    }
                    $permalink = toAscii(strip_tags($_POST['titlu']));
                    $titlu = strip_tags($_POST['titlu']);
                    $continut = $_POST['editeaza_stire'];
                    if(is_valid($link))
                        $link = make_safe($link);
                    $date = make_safe($_POST['date']);

                    $sql = "UPDATE `stiri` SET 
                    title='$titlu', 
                    content='$continut', 
                    picture='$link', 
                    permalink='$permalink', 
                    date='$date'
                    WHERE id='$id'";
                    mysql_query($sql);
                    
                    include_once("rss.php");
                }
                else
                {
                    $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Formate permise: .bmp, .png, .jpeg, .jpg, .gif, .png";
                }
            }
            else 
            {
                $ok2=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii!";
            }
        }


        if(isset($_GET['reset']))
        {
            if(!is_numeric($_GET['reset']))
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-stiri.php');
            else
            {
                $id = $_GET['reset'];

                $sql = "UPDATE `stiri` SET vizualizari=0 WHERE id='$id'";
                mysql_query($sql);

                $sql = "DELETE FROM `counter` WHERE location='$id'";
                mysql_query($sql);

                $mesaj = "Numarul de vizualiz&#259;ri aferent acestei &#351;tiri a fost resetat la 0. V&#259; rug&#259;m a&#351;tepta&#355;i...";
                echo '<meta http-equiv="Refresh" content="5; URL=editare-stire.php?id='.$setid.'" />';
            }
        }


        if(isset($_GET['deletepic']))
        {
            if(!is_numeric($_GET['deletepic']))
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-stiri.php');
            else if($picturenws!='newsimg/')
                {
                    $id=$_GET['deletepic'];
                    unlink('../'.$picturenws.'');
                    $updatevalue = 'newsimg/';
                    $sql = "UPDATE `stiri` SET picture='$updatevalue' WHERE id='$id'";
                    mysql_query($sql);
                    $picturenws2=$picturenws;
                    $picturenws = 'newsimg/';
                    $mesaj = "Imaginea <span class=\"smalltitle\">".$picturenws2."</span> asociat&#259; acestei &#351;tiri a fost &#351;tears&#259;. V&#259; rug&#259;m a&#351;tepta&#355;i...";
                    echo '<meta http-equiv="Refresh" content="5; URL=editare-stire.php?id='.$setid.'" />';
                }
                else
                {
                    $mesaj = 'Aceast&#259; &#351;tire nu are nicio imagine asociat&#259;!';
            }
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="css/jscal2.css" />
            <link rel="stylesheet" type="text/css" href="css/border-radius.css" />
            <link rel="stylesheet" type="text/css" href="css/steel/steel.css" />
            <link rel="stylesheet" type="text/css" href="libraries/editor/_samples/sample.css"  />    
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" />
            <link rel="stylesheet" type="text/css" href="css/confirm.css" />
            
            <script type="text/javascript" src="js/jquery.min-164.js"></script>
            <script type="text/javascript" src="js/jscal2.js"></script>
            <script type="text/javascript" src="js/lang/ro.js"></script>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <?php if(!isset($nuexista)) 
                            {
                            ?>
                            <b>Editare &#351;tire:</b>
                            <br/><br/>
                            <?php display_message($mesaj);?>
                            <form action="editare-stire.php?id=<?php echo $setid;?>" method="post" name="edit_news" enctype="multipart/form-data" id="validate">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                                <table class="sample">
                                    <tr>
                                        <td><?php check_field($ok2, "titlu");?>Titlu: </td>
                                        <td>
                                            <input type="text" id="titlu" name="titlu" value="<?php echo $titlu;?>" class="stfield" data-validation-engine="validate[required]"/>
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td><?php check_field($ok2, "editeaza_stire");?>Con&#355;inut: </td>
                                        <td><textarea class="ckeditor" cols="80" id="editeaza_stire" name="editeaza_stire" rows="10">
                                                <?php echo $continut;?>
                                            </textarea>
                                        </td>
                                    </tr>
                                    <?php
                                        if((is_valid($picturenws)) && ($picturenws!='newsimg/'))
                                        {
                                        ?>
                                        <tr>
                                            <td>Imagine curent&#259;: </td>
                                            <td>
                                                <img src="../<?php echo $picturenws;?>" />
                                            </td>
                                        </tr>
                                        <?php
                                        } else {?>
                                        <tr>
                                            <td colspan="2"><div class="smalltitle_black">Aceast&#259; &#351;tire nu are nicio imagine asociat&#259;.</div></td>
                                        </tr>
                                        <?php
                                        }
                                    ?>
                                    <tr>
                                        <td>Imagine asociat&#259;: </td>
                                        <td><input name="uploadedfile" type="file" />
                                            <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>L&#259;&#539;imea imaginii asociate: </td>
                                        <td><input name="widthimg" type="text" value="250" class="stfield" data-validation-engine="validate[custom[integer]]"/>
                                            <br />
                                        </td>
                                    </tr>
                                    <?php if((is_valid($picturenws)) && ($picturenws!='newsimg/')) 
                                        {?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="smalltitle_red">(Aten&#355;ie! Imaginea asociat&#259; veche va fi &#351;tears&#259;!)</div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <tr>
                                        <td> Data: </td>
                                        <td><input type="text" name="date" id="f_date1" class="stfield" value="<?php echo $date;?>" readonly="readonly"/><button id="f_btn1">...</button>
                                            <script type="text/javascript">//<![CDATA[
                                                Calendar.setup({
                                                    inputField : "f_date1",
                                                    trigger    : "f_btn1",
                                                    onSelect   : function() { this.hide() },
                                                    showTime   : 12,
                                                    dateFormat : "%d-%m-%Y %I:%M"
                                                });
                                                //]]></script>
                                            <?php noscript_text_default();?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><center>
                                                <input name="submit_stire" type="submit" value="Actualizare &#351;tire" class="no-warn" />
                                            </center></td>
                                    </tr>
                                </table>
                            </form>
                            Num&#259;r vizualiz&#259;ri: <?php echo $vizualizari; ?><br/>
                            Num&#259;r vizualiz&#259;ri unice: <?php echo getCounter('unique'); ?><br/>
                            <img src="images/reset.png" />&nbsp;<a href="editare-stire.php?reset=<?php echo $setid;?>" class="reset-link no-warn" onclick="actafis();">Resetare num&#259;r vizualiz&#259;ri</a><br/>
                            <?php if((is_valid($picturenws)) && ($picturenws!='newsimg/')) 
                                {?>
                                <img src="images/delete.png" />&nbsp;<a href="editare-stire.php?deletepic=<?php echo $setid;?>" class="delete-link no-warn" onclick="actafis();">&#350;terge imaginea asociat&#259;</a>
                                <?php } ?>
                            <? } else {?>
                            <center><img src="images/error.png" class="midalign"/><b>&#350;tirea pe care a&#355;i &icirc;ncercat s&#259; o accesa&#355;i nu exist&#259;!</b></center>
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">#f_date1, #f_btn1 {display: inline;}</style>');
                //]]>
            </script>
            

            <script type="text/javascript" src="libraries/editor/ckeditor.js"></script>
            <script type="text/javascript" src="libraries/editor/_samples/sample.js"></script>
            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js"  charset="utf-8"></script>
            <script type='text/javascript' src='js/jquery.simplemodal.js'></script>
            <script type='text/javascript' src='js/confirm.js'></script>                  
            <script type="text/javascript" src="js/editare-stire.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>