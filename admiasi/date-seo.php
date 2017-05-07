<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    require_once("libraries/class.keywordDensity.php");

    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Date SEO"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `seo` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        while($rand = mysql_fetch_object($rezultat))
        {
            $keywords = $rand -> keywords;
            $description = $rand -> description;
        }


        if(isset($_POST['submit']))
        {
            $keywords = make_safe($_POST['keywords']);
            $description = make_safe($_POST['description']);
            if(is_valid($_POST['keywords']) && is_valid($_POST['description']))
            {
                $sql="UPDATE `seo` SET keywords='$keywords', description='$description' WHERE id=1";
                mysql_query($sql);
            }
            else
            {
                $ok=0;
                $mesaj = "Ambele c&acirc;mpuri sunt obligatorii!";
            }
        }

        if(isset($_POST['submit_kdc']))
        {
            if(is_valid($_POST['kdcheck']))
            {
                $domain = $_POST['kdcheck'];
                $obj = new KD();                                     
                $obj -> domain = 'http://'.$domain;
            }
            else
                $mesaj2 = "Nu a&#355;i selectat nicio pagin&#259;!";            
        }
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
                        <br/>
                        <b>Modificare date SEO:</b><br/>

                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate"><br/><br/>
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <table>
                                <tr>
                                    <td>
                                        <?php check_field($ok, "keywords");?>Keywords:
                                    </td>
                                    <td>
                                        <input name="keywords" type="text" value="<?php echo $keywords;?>" class="stfield" data-validation-engine="validate[required]" size="100"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php check_field($ok, "description");?>Description:
                                    </td>
                                    <td>
                                        <textarea name="description" rows="10" cols="30" data-validation-engine="validate[required]"><?php echo $description;?></textarea>
                                    </td>
                                </tr>
                            </table>
                            <input name="submit" type="submit" value="Actualizare Date" class="no-warn"/>
                        </form>

                        <br/><br/>
                        <b>Densitate cuvinte-cheie:</b><br/><br/>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="validate1">
                            <?php
                                display_message($mesaj2);
                            ?>
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            Pagin&#259; pentru verificare: <select name="kdcheck" class="stselect" data-validation-engine="validate[required]" data-prompt-position="topRight">
                                <?php if(!isset($_POST['chkpage'])) { ?>
                                    <option selected="selected" value="">Selecta&#355;i o pagin&#259;</option>
                                    <?php } else { ?>
                                    <option value="<?php echo $_POST['chkpage'];?>" selected="selected"><?php echo $chkpage_title;?></option>
                                    <?php } 

                                    $sql = "SELECT * FROM `onipag`";
                                    $result = mysql_query($sql);
                                    while($row = mysql_fetch_object($result))
                                    {
                                        $title = $row -> title;
                                        $usrfile = $row -> userfile;
                                        $chkurl = $_SERVER['SERVER_NAME'].'/'.$usrfile;

                                        echo '<option value="'.$chkurl.'">'.$title.'</option>';
                                        echo "\n";
                                    }                    
                                ?>
                            </select>
                            <input type="submit" value="Verificare" name="submit_kdc" class="no-warn">
                        </form>
                        <?php
                            if(isset($_POST['submit_kdc']))
                            {
                                $result = $obj -> result();
                                echo '
                                <table width="100%" class="tablesorter" id="mytable">
                                <thead>
                                <tr class="part_header">
                                <th>Keyword</th>
                                <th>Aparitii</th>
                                <th>Procent</th>
                                </tr>
                                </thead>
                                <tbody>
                                ';
                                foreach($result as $item){
                                    echo'
                                    <tr class="part_tr">
                                    <td>'.$item['keyword'].'</td>
                                    <td>'.$item['count'].'</td>
                                    <td>'.$item['percent'].'</td>
                                    </tr>';
                                }
                                echo'
                                </tbody>
                                </table>';
                                echo '<br/><br/>
                                <div id="pager" class="pager">
                                <form>
                                <img src="images/first.png" class="first"/>
                                <img src="images/prev.png" class="prev"/>
                                <input type="text" class="pagedisplay"/>
                                <img src="images/next.png" class="next"/>
                                <img src="images/last.png" class="last"/>
                                <select class="pagesize">
                                <option selected="selected"  value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                </select>
                                </form>
                                </div>'; 
                            }
                        ?> 
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script src="js/formValidator/jquery.validationEngine-ro.js" type="text/javascript" charset="utf-8"></script>
            <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/pager.js"></script> 
            <script type="text/javascript">
                $(document).ready(function() {
                    $("#validate").validationEngine(); 
                    $("#validate1").validationEngine(); 
                    $("table.tablesorter tr:nth-child(even)").addClass("part_tr_gri");
                    $("#mytable")
                    .tablesorter({ widthFixed: true})
                    .tablesorterPager({container: $("#pager"), positionFixed: false });
                });
            </script>
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>