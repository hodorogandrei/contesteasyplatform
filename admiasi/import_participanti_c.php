<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    
    error_reporting(0);
    
    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Import participanti"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        if(isset($_POST['submit']))
        {
            if(!empty($_FILES['csvfile']['name']))
            {
                $checkbox = $_POST['checkbox'];
                //determinarea extensiei
                $filename=basename( $_FILES['csvfile']['name']);
                $ext = end(explode('.', $filename));
                $ext = substr(strrchr($filename, '.'), 1);
                $ext = substr($filename, strrpos($filename, '.') + 1);
                $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                $exts = split("[/\\.]", $filename);
                $n = count($exts)-1;
                $ext = $exts[$n];
                //testarea extensiei
                if(strcmp($ext,'csv')==0) 
                {
                    //upload
                    $target_path = "temp/";
                    $target_path = $target_path . basename( $_FILES['csvfile']['name']); 
                    if(move_uploaded_file($_FILES['csvfile']['tmp_name'], $target_path))
                    {
                        $mesaj = "Fisierul ".  basename( $_FILES['csvfile']['name'])." a fost importat cu succes.";
                    } 
                    else
                    {
                        $mesaj = "Eroare la importarea fi&#351;ierului CSV.";
                    }
                    //prelucrare
                    $file = file('temp/'.$filename.'');
                    //eliminarea primei linii (header-ul ramas din excel)
                    if($checkbox==1)
                    {
                        $file[0] = "";
                        $fp = fopen('temp/'.$filename.'', 'w');
                        fwrite($fp, implode($file)); 
                    }
                    //parcurgerea fisierului
                    $numar=0;
                    $size=sizeof($file);
                    //echo sizeof($file);
                    for($i=0;$i<$size;$i++)
                    {
                        $line = trim($file[$i]);
                        /*
                        $ult2c = substr($line, -2);
                        //echo $ult2c[0].' '.$ult2c[1].'<br/>';
                        if((ctype_alpha($ult2c[0]) && $ult2c[1]==',') || ($ult2c==',,'))
                        {
                        $line2 = substr($line, 0, -1);
                        $line = $line2;
                        }
                        */
                        $arr = explode(",", $line);
                        $sql = "INSERT 
                        INTO 
                        `participanti` 
                        (`id`,
                        `numele`,
                        `clasa`, 
                        `judet`,
                        `unitatea`, 
                        `cazare`, 
                        `concurs`) 
                        VALUES ('".$numar."','".implode("','",$arr)."')";
                        //echo "$sql<br/>";
                        mysql_query($sql);
                        $numar++;
                    }
                    //CURATAREA BAZEI DE DATE
                    $sql = "DELETE FROM `participanti` WHERE clasa=0";
                    mysql_query($sql);
                    //stergerea fisierului
                    unlink('temp/'.$filename.'');
                    $mesaj3 = $numar.' intr&#259;ri au fost introduse &icirc;n baza de date.';
                }
                else
                    $mesaj = "Singurul tip de fi&#351;ier permis pentru import este CSV.";
            }
            else
                $mesaj = "Nu a&#355;i selectat niciun fi&#351;ier!";
        }
        if(isset($_GET['goleste']))
        {
            $sql = "TRUNCATE TABLE `participanti`";
            mysql_query($sql);
            $mesaj = "Baz&#259; de date participan&#355;i golit&#259; cu succes.";
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <script type="text/javascript">
                $(function() {
                    $("a.delete-link").click(function() {
                        return confirm("Sunteţi sigur(ă) că doriţi să goliţi tabelul tabelul \"participanti\"?");
                    });
                });

            </script>
        </head>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Import participan&#355;i:</b><br/>
                        <?php echo '<br/>'; display_message($mesaj);
                            display_message($mesaj3);?>
                        <div id="file-uploader">
                            <form action="import_participanti_c.php" method="post" enctype="multipart/form-data" id="form1">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                                <input name="checkbox" type="checkbox" id="checkbox" value="1" style="vertical-align: middle;"/><span class="smalltitle">Fi&#351;ierul are un cap de tabel, pe care doresc s&#259; &icirc;l elimin</span><br/><br/>
                                Fi&#351;ier CSV: <input type="file" name="csvfile" />
                                <input type="submit" name="submit" value="Import" />
                            </form>
                            <br/>
                            <img src="images/delete.png" />&nbsp;<a class="delete-link" href="import_participanti.php?goleste">Golire baz&#259; de date cu participan&#355;i</a>
                        </div>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>
            
            
            <script type="text/javascript" src="js/jquery.js"></script>
            <script type="text/javascript" src="js/effect.js"></script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>