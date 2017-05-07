<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    require_once("libraries/phpuploader/include_phpuploader.php");

    error_reporting(E_ERROR | E_PARSE);

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


        $sql = "SELECT * FROM `onipag` WHERE id=4"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $titlu  =$rand -> title;


        if(isset($_POST['submit2']))
        {
            $titlu = make_safe($_POST['titlu']);
            if(is_valid($titlu))
            {
                $sql ="UPDATE `onipag` SET title='$titlu' WHERE id=4";
                mysql_query($sql);
            }
            else
            {
                $ok=0;
                $mesaj2 = "C&acirc;mpurile marcate cu * sunt obligatorii.";
            }
        }


        if(isset($_POST['submit']))
        {
            $galt = make_safe($_POST['galt']);
            if(!validateURL($_POST['slink']))
                $mesaj = "Adres&#259; web invalid&#259;.";
            else if(!empty($_FILES['uploadedfile']['tmp_name']))
                {
                    $slink = $_POST['slink'];
                    $filename=basename( $_FILES['uploadedfile']['name']);
                    $ext = end(explode('.', $filename));
                    $ext = substr(strrchr($filename, '.'), 1);
                    $ext = substr($filename, strrpos($filename, '.') + 1);
                    $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                    $exts = split("[/\\.]", $filename);
                    $n = count($exts)-1;
                    $ext = $exts[$n];
                    if(check_ext_img($ext)==1) 
                        $ok=1;
                    else
                    {
                        $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Formate permise: .bmp, .png, .jpeg, .jpg, .gif";
                    }
                    //incarcarea imaginii, daca exista
                    if(isset($ok) && $ok==1)
                    {
                        $target_path = "../images/sponsori/";
                        $target_path = $target_path . basename($_FILES['uploadedfile']['name']);
                        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
                        {
                            $mesaj = "Imagine ad&#259;ugat&#259;! Imaginea <span class=\"smalltitle\">".  basename( $_FILES['uploadedfile']['name'])."</span> a fost inc&#259;rcat&#259;.";
                            $link = $_FILES['uploadedfile']['name'];
                            list($width, $height, $type, $attr) = getimagesize('../images/sponsori/'.$link.'');
                            include('../libraries/simpleImage.php');
                            $image = new SimpleImage();
                            $image->load('../images/sponsori/'.$link.'');
                            $image->resizeToWidth(210);
                            $image->save('../images/sponsori/'.$link.'');
                            if(is_valid($link))
                                $link = make_safe($link);
                            $doSQL = "INSERT INTO `sponsori` (`gfile`, `galt`, `link`) VALUES ('$link', '$galt', '$slink')";
                        mysql_query($doSQL);
                    } 
                }
                else
                {
                    $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Formate permise: .bmp, .png, .jpeg, .jpg, .gif";
                }
            }
            else
            {
                $mesaj = "Nu a&#355;i selectat niciun fi&#351;ier!";
            }
        }


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "SELECT * FROM `sponsori` WHERE id=".$_GET['sterge']."";
            $result = mysql_query($sql);
            $rand = mysql_fetch_object($result);
            $delfile = $rand->gfile;
            unlink('../images/sponsori/'.$delfile.'');

            $sql = "DELETE FROM `sponsori` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);

            $mesaj = "Sponsorul a fost &#351;ters!";
        }


        if($_POST['delete'])
        {
            $mesaj = "Sponsorii selecta&#355;i au fost &#351;ter&#351;i! V&#259; rug&#259;m a&#351;tepta&#355;i!";
            echo '<meta http-equiv="refresh" content="2;URL=editare-sponsori.php">';
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <style type="text/css">
                #pagecontent ul { width:900px; list-style-type: none; margin:0px; padding:0px; }
                #pagecontent li { float:left; width:150px; height:55px; }
                #pagecontent li div { width:100px; height:51px; border:solid 1px black; background-color:#E0E0E0; text-align:center; }
                .placeHolder div { background-color:white!important; border:dashed 1px gray !important; }
            </style>
            <link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
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
                        <a href="editare-pagini.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="editare-pagini.php">&Icirc;napoi la lista de pagini editabile</a>
                        <br/><br/>
                        <?php display_message($mesaj2);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <?php check_field($ok, "titlu"); ?><b>Titlu pagin&#259;:</b><br/><br/>
                            <input type="text" id="titlu" name="titlu" value="<?php echo $titlu;?>" class="stfield" data-validation-engine="validate[required]"/>&nbsp;
                            <input name="submit2" type="submit" value="Actualizare"/>
                        </form><br/><br/>
                        <b>Ad&#259;ugare imagine sponsor:</b><br/><br/>
                        <?php display_message($mesaj);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <div class="hiddendiv">
                                <?php

                                    $uploader=new PhpUploader();
                                    $uploader->MaxSizeKB=10240;
                                    $uploader->MultipleFilesUpload=true;
                                    $uploader->Name="myuploader";
                                    $uploader->InsertText="Alege&#355;i mai multe fi&#351;iere (Maximum 10MB)";
                                    $uploader->AllowedFileExtensions="*.jpg,*.png,*.bmp,*.jpeg,*.gif";	
                                    $uploader->SaveDirectory="../images/sponsori/";
                                    $uploader->Render();

                                    $files=array();

                                    $processedlist=@$_POST['processedlist'];
                                    if($processedlist)
                                    {
                                        $guidlist=explode("/",$processedlist);
                                        foreach($guidlist as $fileguid)
                                        {
                                            $mvcfile=$uploader->GetUploadedFile($fileguid);
                                            if($mvcfile)
                                            {
                                                array_push($files,$mvcfile);
                                            }
                                        }
                                    }
                                    $fileguidlist=@$_POST['myuploader'];
                                    if($fileguidlist)
                                    {
                                        $guidlist=explode("/",$fileguidlist);
                                        foreach($guidlist as $fileguid)
                                        {
                                            $mvcfile=$uploader->GetUploadedFile($fileguid);
                                            if($mvcfile)
                                            {
                                                $doSQL = "INSERT INTO `sponsori`(`gfile`) VALUES ('".$mvcfile->FileName."')";
                                                mysql_query($doSQL);
                                                if($processedlist)
                                                    $processedlist= $processedlist . "/" . $fileguid;
                                                else
                                                    $processedlist= $fileguid;

                                                array_push($files,$mvcfile);
                                            }
                                        }
                                    }

                                    if(count($files)>0)
                                    {
                                        echo("<table border='0' cellspacing='0' cellpadding='2'>");
                                        foreach($files as $mvcfile)
                                        {
                                            echo("<tr>");
                                            echo("<td>");echo("<img src='include/libraries/phpuploader/resources/circle.png' border='0' />");echo("</td>");
                                            echo("<td>");echo($mvcfile->FileName);echo("</td>");
                                            echo("<td>");echo($mvcfile->FileSize);echo("</td>");
                                            echo("</tr>");
                                        }
                                        echo("</table>");
                                    }
                                ?>
                            </div>
                            <noscript>
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                                Text alternativ: <input type="text" name="galt" class="stfield"/><br/><br/>
                                Adres&#259; sponsor: <input type="text" name="slink" class="stfield" /><br/><br/>
                                Fi&#537;ier: <input type="file" name="uploadedfile" id="file"/>
                                <input name="submit" type="submit" value="Ad&#259;ugare sponsor" id="submit"/>
                            </noscript>
                        </form>
                        <br/><b>Administrare imagini sponsori:</b><br/><br/>
                        <?php
                            $sql = "SELECT * FROM `sponsori` ORDER BY ordine ASC"; 
                            $result = mysql_query($sql);
                            $count=mysql_num_rows($result);
                            if(mysql_num_rows($result)>0)
                            {
                            ?>
                            <form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <img src="images/arrow_ltr_v.png" style="vertical-align: middle;" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                <table width="100%" cellspacing="2" id="mytable" class="tablesorter" style="text-align: center;">
                                    <thead>
                                        <tr class="part_header">
                                            <th width="2%">&nbsp;

                                            </th>
                                            <th width="1%">Ordine</th>
                                            <th>Nume fi&#351;ier imagine</th>
                                            <th>Text alternativ imagine</th>
                                            <th>Adres&#259; web</th>
                                            <th width="110">Previzualizare</th>
                                            <th width="4%">Ac&#355;iuni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($rand = mysql_fetch_object($result))
                                            {
                                                echo'<tr>
                                                <td><input class="chkbox" name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$rand->id.'"/></td>
                                                <td class="separate">'.$rand->ordine.'</td>
                                                <td class="separate">'.$rand->gfile.'</td>
                                                <td class="separate">'.$rand->galt.'</td>
                                                <td class="separate">'.$rand->link.'</td>
                                                <td class="separate"><center><a href="../images/sponsori/'.$rand->gfile.'" class="highslide" onclick="return hs.expand(this);"><img src="../images/sponsori/'.$rand->gfile.'" alt="'.$rand->galt.'" width="100" height="51" /></a></center></td>
                                                <td class="separate"><a href="editare-sponsor.php?id='.$rand->id.'"><img src="images/edit.png" border="0" /></a>&nbsp;<a class="delete-link" href="editare-sponsori.php?sterge='.$rand->id.'" id="'.$rand->id.'"><img src="images/del.png" border="0" /></a></td>
                                                </tr>
                                                ';
                                            }
                                            if($_POST['delete'])
                                            {
                                                $checkbox = $_POST['checkbox'];
                                                for($i=0;$i<$count;$i++)
                                                {
                                                    $del_id = $checkbox[$i];

                                                    $sql = "SELECT * FROM `sponsori` WHERE id=".$del_id."";
                                                    $result = mysql_query($sql);

                                                    $row=mysql_fetch_array($result);
                                                    $delfile = $row['gfile'];
                                                    unlink('../images/sponsori/'.$delfile.'');
                                                }

                                                $sql = "DELETE FROM `sponsori` WHERE id IN (".implode(',',$_POST['checkbox']).")";
                                                mysql_query($sql);
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <table width="100%">
                                    <tr class="part_header">
                                        <td colspan="5">&nbsp;

                                        </td>
                                    </tr>
                                </table>
                                <img src="images/arrow_ltr.png" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                            </form>
                            <br/>Ordinea &icirc;n pagin&#259; <i>(actualizarea se va realiza automat)</i>:<br/><br/>
                            <ul id="sponsori" class="hiddendiv">
                                <?php
                                    $sql = "SELECT * FROM `sponsori` ORDER BY ordine ASC"; 
                                    $result = mysql_query($sql);
                                    while($rand = mysql_fetch_array($result)) 
                                    {
                                        echo "<li data-itemid='" .$rand['id']. "' id='" .$rand['id']. "'>\n";
                                        echo '<div><img src="../images/sponsori/'.$rand['gfile'].'" alt="'.$rand['galt'].'" width="100" height="51" /></div>';
                                        echo "\n";
                                        echo "\n</li>";
                                    }
                                ?>
                            </ul>
                            <?php noscript_text("Nu pute&#355;i edita dec&acirc;t cu Javascript activat!");
                            } else echo "Nu exist&#259; imagini asociate sponsorilor.";?>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/jquery.dragsort-0.5.1.min.js"></script> 
            <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/editare-sponsori.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js"  charset="utf-8"></script>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">.hiddendiv {display: block;}</style>');
                //]]>
            </script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>
