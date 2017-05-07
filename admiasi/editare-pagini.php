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


        if(isset($_POST['submit']))
        {
            $ok=1;
            if(is_valid($_POST['usrfile']) && is_valid($_POST['title']) && is_valid($_POST['admfile']) && $_POST['admfile']!='editare-')
            {
                $okchar=1;
                if(valid_name($_POST['usrfile']) && valid_name($_POST['admfile']))
                {
                    $okfile1=1;
                    $okfile2=1;
                    $file1 = '../'.$_POST['usrfile'].'.php';
                    $file2 = $_POST['admfile'].'.php';
                    if(!file_exists($file1) && !file_exists($file2))
                    {
                        $ourFileHandle = fopen($file1, 'w') or die("fi&#351;ierul nu a putut fi creat.");
                        fclose($ourFileHandle);

                        $ourFileHandle = fopen($file2, 'w') or die("fi&#351;ierul nu a putut fi creat.");
                        fclose($ourFileHandle);

                        $doSQL = "INSERT 
                        INTO 
                        `onipag` 
                        (`title`,
                        `userfile`, 
                        `admfile`) 
                        VALUES ('".make_safe($_POST['title'])."', 
                        '".make_safe($file1)."', 
                        '".make_safe($file2)."')";

                        mysql_query($doSQL);
                        //pagina utilizator
                        //aplicare template
                        $template = file('template.php');
                        file_put_contents($file1, $template);
                        //configurare template
                        $file = file_get_contents($file1);
                        //inlocuire date
                        $file = str_replace('WHERE id=1', 'WHERE id='.mysql_insert_id().'', $file);
                        //scrierea fisierului
                        file_put_contents($file1, $file);

                        //pagina administrator
                        //aplicare template
                        $template = file('template-admin.php');
                        file_put_contents($file2, $template);
                        //configurare template
                        $file = file_get_contents($file2);
                        //inlocuire date
                        $file = str_replace('WHERE id=1', 'WHERE id='.mysql_insert_id().'', $file);
                        //scrierea fisierului
                        file_put_contents($file2, $file);
                    }
                    else
                    {
                        if(file_exists($file1))
                            $okfile1=0;
                        if(file_exists($file2))
                            $okfile2=0;
                        $mesaj = "Un fi&#351;ier cu acest nume deja exist&#259;!";
                    }
                }
                else
                {
                    $okchar=0;
                    $mesaj = "C&acirc;mpurile marcate cu * trebuie s&#259; con&#355;in&#259; doar caractere alfa-numerice.";
                }
            }
            else
            {
                $ok=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii.";
            }
        }


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "SELECT * FROM `onipag` WHERE id=".$_GET['sterge']."";
            $result = mysql_query($sql);
            $rand = mysql_fetch_object($result);
            $usrfile = $rand->userfile;
            $admfile = $rand->admfile;
            unlink(''.$usrfile.'');
            unlink(''.$admfile.'');

            $sql = "DELETE FROM `onipag` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);

            $mesaj = "Pagina a fost &#351;tears&#259;!";

            $sql = 'SELECT * FROM `onipag`';
            if(mysql_num_rows(mysql_query($sql))==5)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/editare-pagini.php');
        }


        if($_POST['delete'])
        {
            $mesaj = "Paginile selectate au fost &#351;terse!";
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
                        <b>Alege&#355;i o pagin&#259; prefedinit&#259; pentru editare:</b><br/><br/>
                        <a href="editare-home.php">Home</a>&nbsp;|&nbsp;
                        <a href="editare-regulament.php">Regulament</a>&nbsp;|&nbsp;
                        <a href="editare-desfasurare.php">Desf&#259;&#351;urare</a>&nbsp;|&nbsp;
                        <a href="editare-sponsori.php">Sponsori</a>&nbsp;|&nbsp;
                        <a href="editare-contact.php">Contact</a>


                        <br/><br/>
                        <b>Ad&#259;ugare pagin&#259; nou&#259;:</b><br/><br/>


                        <?php display_message($mesaj);?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <?php check_field($ok, "title");?>Titlu pagin&#259;: <input type="text" name="title" data-validation-engine="validate[required,custom[onlyLetter]]" class="stfield" value="<?php check_isset("title");?>"/><br/><br/>
                            <?php check_field_fileb($okfile1); check_field($ok, "usrfile"); check_field_name($okchar, "usrfile");?>Nume fi&#351;ier utilizator: <input type="text" name="usrfile" data-validation-engine="validate[required,custom[onlyLetter]]" class="stfield" value="<?php check_isset("usrfile");?>" id="usrfile"/><br/><br/>
                            <?php check_field_fileb($okfile2); check_field_file($ok); check_field_name($okchar, "admfile");?>Nume fi&#351;ier administrator: <input type="text" name="admfile" data-validation-engine="validate[required]" class="stfield" value="editare-" id="admfile"/><br/><br/>
                            <input name="submit" type="submit" value="Ad&#259;ugare pagin&#259;"/>
                        </form>
                        <br/><b>Administrare pagini:</b><br/><br/>
                        <?php
                            $sql = "SELECT * FROM `onipag` where id > 5 ORDER BY id DESC"; 
                            $result = mysql_query($sql);
                            $count = mysql_num_rows($result);
                            if(mysql_num_rows($result) > 0)
                            {
                            ?>

                            <form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                <img src="images/arrow_ltr_v.png" style="vertical-align: middle;" /><input type="button"  onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                <table width="100%" cellspacing="2" id="mytable" class="tablesorter">
                                    <thead>
                                        <tr class="part_header">
                                            <th width="2%">&nbsp;

                                            </th>
                                            <th width="14%">TItlu pagin&#259;</th>
                                            <th>Nume fi&#351;ier pentru utilizator</th>
                                            <th>Nume fi&#351;ier pentru administrator</th>
                                            <th width="4%">Ac&#355;iuni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $numar=0;
                                            while($rand = mysql_fetch_array($result))
                                            {
                                                $numar++;
                                                echo'<tr>
                                                <td><input class="chkbox" name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$rand['id'].'"/></td>
                                                <td class="separate">'.$rand['title'].'</td>
                                                <td class="separate">'.substr($rand['userfile'],$rand['userfile']+3).'</td>
                                                <td class="separate">'.$rand['admfile'].'</td>
                                                <td class="separate"><a href="'.$rand['admfile'].'"><img src="images/edit.png" border="0" /></a>&nbsp;<a class="delete-link" href="editare-pagini.php?sterge='.$rand['id'].'" id="'.$rand['id'].'"><img src="images/del.png" border="0" /></a></td>
                                                </tr>
                                                ';
                                            }
                                            if($_POST['delete'])
                                            {
                                                $checkbox = $_POST['checkbox'];
                                                for($i=0;$i<$count;$i++)
                                                {
                                                    $del_id = $checkbox[$i];
                                                    $sql = "SELECT * FROM `onipag` WHERE id='$del_id'";
                                                    $result = mysql_query($sql);
                                                    $rand = mysql_fetch_object($result);
                                                    $usrfile = $rand -> userfile;
                                                    $admfile = $rand -> admfile;
                                                    unlink(''.$usrfile.'');
                                                    unlink(''.$admfile.'');
                                                }

                                                $sql = "DELETE FROM `onipag` WHERE id IN (".implode(',',$_POST['checkbox']).")";
                                                mysql_query($sql);

                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <table width="100%">
                                    <tr class="part_header">
                                        <td colspan="5">
                                            &nbsp;
                                        </td>
                                    </tr>
                                </table>
                                <img src="images/arrow_ltr.png" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                            </form>
                            <?php } else 
                                echo 'Nu exist&#259; pagini noi ad&#259;ugate.';?>
                    </div>
                    <?php 
                        include("include/footeradm.php");
                        include("include/popup.php");
                    ?>
                </div>
            </div>


            <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js"  charset="utf-8"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>                    
            <script type="text/javascript" src="js/editare-pagini.js"></script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>