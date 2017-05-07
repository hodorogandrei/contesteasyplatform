<?php
    require_once("include/config.php");
    require_once("include/functions.php");

    error_reporting(E_ERROR | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = "Nu";
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global'] == 1 ? $acces=1 : $acces=check_perm("Adaugare stire"));
            if($acces != 1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_POST['submit_stire']))
        {
            if(is_valid($_POST['titlu']))
            {
                $permalink = toAscii($_POST['titlu']);
                $link = 'newsimg/';
                if(is_valid($_FILES['uploadedfile']['tmp_name']))
                {	
                    $widthimg = $_POST['widthimg'];
                    if(is_numeric($widthimg))
                    {
                        if($widthimg <= 500)
                        {
                            $filename = basename( $_FILES['uploadedfile']['name']);
                            $ext = end(explode('.', $filename));
                            $ext = substr(strrchr($filename, '.'), 1);
                            $ext = substr($filename, strrpos($filename, '.') + 1);
                            $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                            $exts = split("[/\\.]", $filename);
                            $n = count($exts)-1;
                            $ext = $exts[$n];


                            if(check_ext_img($ext) == 1)
                            {
                                $link = 'newsimg/'.$_FILES['uploadedfile']['name'].'';
                                //incarcarea imaginii, daca exista
                                $target_path = "../newsimg/";
                                $target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
                                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
                                {
                                    $mesaj = "&#350;tire adaugat&#259;! Imaginea asociat&#259; <span class=\"smalltitle\">".  basename( $_FILES['uploadedfile']['name'])."</span> a fost inc&#259;rcat&#259;";
                                } 
                                list($width, $height, $type, $attr) = getimagesize('../'.$link.'');
                                if($width>$widthimg)
                                {
                                    include("../libraries/simpleImage.php");
                                    $image = new SimpleImage();
                                    $image -> load('../'.$link.'');
                                    $image -> resizeToWidth($widthimg);
                                    $image -> save('../'.$link.'');
                                }
                            }
                            else
                                $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Formate permise: .bmp, .png, .jpeg, .jpg, .gif. ";
                        }
                        else
                            $mesaj = "L&#259;&#539;imea imaginii nu poate dep&#259;&#537;i 500 pixeli.";
                    } 
                    else
                        $mesaj = "C&acirc;mpul aferent l&#259;&#539;imii imaginii asociate trebuie s&#259; fie un num&#259;r &icirc;ntreg.";
                }
                else
                    $mesaj = "&#350;tire adaugat&#259;! Nu a fost inc&#259;rcat&#259; nicio imagine asociat&#259;.";

                $postby = $_SESSION['nume'];

                $sql = "INSERT INTO `stiri` (`title`, `content`, `date`, `picture`, `permalink`, `vizualizari`, `postby`) 
                VALUES ('".htmlentities($_POST['titlu'])."', 
                '".($_POST['adauga_stire'])."', 
                '".Date("d-m-Y H:i")."', 
                '".htmlentities($link)."', 
                '".($permalink)."', 
                0, 
                '".$postby."')";
                mysql_query($sql);

                $sql = "SELECT * FROM `stiri` ORDER by id DESC LIMIT 0,1";
                $result = mysql_query($sql);
                $rand = mysql_fetch_object($result);
                $mesajconf = '&#350;tirea poate fi vizualizat&#259; <a href="../news.php?id='.$rand -> id.'" target="_blank">aici</a>';

                include_once("rss.php");
            }
            else 
            {
                $ok=0;
                $mesaj = "Campurile marcate cu * sunt obligatorii!";
            }
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link type="text/css" rel="stylesheet"  href="libraries/editor/_samples/sample.css"/>
            <link type="text/css" rel="stylesheet"  href="js/formValidator/validationEngine.jquery.css"/>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Ad&#259;ugare &#351;tire:</b>
                        <br/>
                        <?php 										
                            if(is_valid($mesaj)) { ?>
                            <br/>
                            <span class="smalltitle_red">
                                <?php echo $mesaj;?>
                            </span>
                            <?php } ?>
                        <?php 										
                            if(is_valid($mesajconf)) { ?>
                            <span class="smalltitle">
                                <?php echo $mesajconf;?>
                            </span>
                            <?php } ?>
                        <br/><br/>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="add_news" enctype="multipart/form-data" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                            <table class="sample">
                                <tr>
                                    <td><?php check_field($ok, "titlu");?>Titlu: </td>
                                    <td><input name="titlu" type="text" value="<?php if(isset($_POST['titlu'])) echo $_POST['titlu']?>" class="stfield" data-validation-engine="validate[required]"/>
                                        <br /></td>
                                </tr>
                                <tr>
                                    <td><?php check_field($ok, "adauga_stire");?>Con&#355;inut: </td>
                                    <td><textarea class="ckeditor" cols="80" id="adauga_stire" name="adauga_stire" rows="10" >
                                            <?php if(isset($_POST['adauga_stire'])) echo $_POST['adauga_stire']?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Imaginea asociat&#259;: </td>
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
                                <tr>
                                <tr>
                                    <td colspan="2">
                                        <center>
                                            <input name="submit_stire" type="submit" value="Ad&#259;ugare &#351;tire" class="no-warn" />
                                        </center>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>



            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="libraries/editor/ckeditor.js"></script>
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