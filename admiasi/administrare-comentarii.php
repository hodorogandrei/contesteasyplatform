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
            if($_SESSION['global'] ? $acces = 1 : $acces = check_perm("Comentarii"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        $ok=0;

        if(isset($_GET['aprobat']) && is_numeric($_GET['aprobat']) ? $aprobat = $_GET['aprobat'] :  $aprobat = 0) ;

        
        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "DELETE FROM `comentarii` WHERE id=".$_GET['sterge']."";
            mysql_query($sql);
        }
        
        
        if($_POST['delete'])
        {
            $sql = "DELETE FROM `comentarii` WHERE id IN (".implode(',',$_POST['checkbox']).")";
            $result = mysql_query($sql);
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link type="text/css" href="css/confirm.css" rel="stylesheet" media="screen" />
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <table width="100%" border="0">
                            <tr>
                                <td width="100%" valign="top"><h3>Administrare comentarii
                                        <?php if(isset($_GET['aprobat'])) if($_GET['aprobat']==1) echo ' - comentarii aprobate'; else echo ' - comentarii neaprobate';?>
                                    </h3>
                                    <hr/>
                                    <p><a href="administrare-comentarii.php?aprobat=0">Comentarii neaprobate</a> | <a href="administrare-comentarii.php?aprobat=1">Comentarii aprobate</a></p>

                                    <?php
                                        $sql = "SELECT * FROM `comentarii` WHERE aprobat = '$aprobat' ORDER BY id DESC"; 
                                        $result = mysql_query($sql);
                                        $count=mysql_num_rows($result);
                                        if(mysql_num_rows($result)>0)
                                        {
                                            $disp=1;
                                        ?>
                                        <form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?aprobat=<?php echo $aprobat;?>" id="target">
                                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                            <img src="images/arrow_ltr_v.png" style="vertical-align: middle;" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                            <table width="100%" cellspacing="2" id="mytable" class="tablesorter">
                                                <thead>
                                                    <tr class="part_header">
                                                        <th width="2%">&nbsp;

                                                        </th>
                                                        <th>Nume</th>
                                                        <th>Conmentariu</th>
                                                        <th width="17%">Data</th>
                                                        <th width="2%">Ac&#355;iuni</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $numar=0;
                                                        while($rand = mysql_fetch_object($result))
                                                        {
                                                            $numar++;
                                                            echo'<tr>
                                                            <td><input class="chkbox" name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$rand -> id.'"/></td>
                                                            <td class="separate">'.$rand -> nume.'</td>
                                                            <td class="separate">'.$rand -> comentariu.'</td>
                                                            <td class="separate"><center><i>'.$rand -> data.'</i></center></td>
                                                            <td class="separate">
                                                            <a title="Editare" href="editare-comentariu.php?id='.$rand -> id.'">
                                                            <img src="images/edit.png" border="0" /></a>
                                                            <a title="Stergere" class="delete-link" href="administrare-comentarii.php?sterge='.$rand -> id.'" id="'.$rand -> id.'">
                                                            <img src="images/del.png" border="0" />
                                                            </a>
                                                            </td>
                                                            </tr>
                                                            ';
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <table width="100%">
                                                <tr class="part_header">
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                            <img src="images/arrow_ltr.png" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                        </form>
                                        <?php } else echo "Nu exista comentarii in aceasta categorie.";?>
                                </td>
                                <td width="11%" style="height: 455px;"></td>
                            </tr>
                        </table>
                        </form>
                        <?php
                            if($disp==1)
                            {
                            ?>
                            <div id="pager" class="pager" >
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
                            </div>
                            <?php } ?>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>

            
            <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/pager.js"></script> 
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/administrare-comentarii.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>