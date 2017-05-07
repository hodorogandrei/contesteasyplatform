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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare stiri"));
            if($acces==0) $accespart=check_perm("Adaugare stire");
            if($acces!=1 && isset($accespart) && $accespart!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_GET['sterge']) && is_numeric($_GET['sterge']))
        {
            $sql = "SELECT * FROM `stiri` WHERE id=".$_GET['sterge']."";
            $result = mysql_query($sql);
            $rand = mysql_fetch_object($result);
            if($rand -> picture != 'newsimg/')
                unlink('../'.$rand->picture.'');


            $sql = "DELETE FROM `stiri` where id=".$_GET['sterge']."";
            mysql_query($sql);
            
            include_once("rss.php");
        }


        if($_POST['delete'])
        {
            $checkbox = make_safe($_POST['checkbox']);
            $sql = "DELETE FROM `stiri` WHERE id IN (".implode(',',$_POST['checkbox']).")";
            mysql_query($sql);
            
            for($i=0;$i<$count;$i++)
            {
                $del_id = $checkbox[$i];
                $sql = "SELECT * FROM `stiri` WHERE id='$del_id'";
                $result = mysql_query($sql);
                $row=mysql_fetch_object($result);
                $delfile = $row -> picture;
                
                if($delfile!='newsimg/')
                    unlink('../'.$delfile.'');
            }
            include_once("rss.php");
            echo '<meta http-equiv="Refresh" content="0; URL="'.$actual_link.'" />';
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
                                <td width="100%" valign="top">
                                    <br/>
                                    <b>Administrare &#351;tiri:</b>
                                    <br/><br/>
                                    <?php
                                        if(isset($accespart) && $accespart=1)
                                        {
                                            $curuser = $_SESSION['nume'];
                                            $sql = "SELECT * FROM `stiri` WHERE postby='$curuser' ORDER BY id DESC";
                                            $result = mysql_query($sql);
                                        }
                                        else
                                        {
                                            $sql = "SELECT * FROM `stiri` ORDER BY id DESC";
                                            $result = mysql_query($sql);
                                        }
                                        $count=mysql_num_rows($result);
                                        if(mysql_num_rows($result)>0)
                                        {
                                        ?>
                                        <form name="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                            <img src="images/arrow_ltr_v.png" style="vertical-align: middle;" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                            <table width="100%" cellspacing="2" id="mytable" class="tablesorter">
                                                <thead>
                                                    <tr class="part_header">
                                                        <th width="2%">&nbsp;

                                                        </th>
                                                        <th width="24%">Titlu &#351;tire</th>
                                                        <th>Con&#355;inut</th>
                                                        <th>Autor</th>
                                                        <th width="13%">Data</th>
                                                        <th width="2%">Ac&#355;iuni</th>
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
                                                            <td class="separate">'.firstnwords(strip_tags($rand['content']),8).'</td>
                                                            <td class="separate">
                                                            <i>'.$rand['postby'].'</i>
                                                            </td>
                                                            <td class="separate">
                                                            <i>'.$rand['date'].'</i>
                                                            </td>
                                                            <td class="separate">
                                                            <a title="Editare" href="editare-stire.php?id='.$rand['id'].'">
                                                            <img src="images/edit.png" border="0" />
                                                            </a>
                                                            <a title="Stergere" class="delete-link" href="administrare-stiri.php?sterge='.$rand['id'].'" id="'.$rand['id'].'">
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
                                                    <td>&nbsp;

                                                    </td>
                                                </tr>
                                            </table>
                                            <img src="images/arrow_ltr.png" /><input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', true);" value="Selectare total&#259;"/>&nbsp;<input type="button" onclick="SetAllCheckBoxes('form', 'checkbox[]', false);" value="Deselecteare total&#259;" />&nbsp;<input type="submit" name="delete" id="delete" value="&#350;tergere selectate" class="delete-link-more"/>
                                        </form>
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
                                        <?php } else 
                                            if(isset($accespart))
                                                echo "Nu exist&#259; &#351;tiri postate de dumneavoastr&#259;.";
                                            else
                                                echo "Nu exist&#259; &#351;tiri postate.";
                                    ?>
                                </td>
                                <td width="11%" style="height: 455px;"></td>
                            </tr>
                        </table>

                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>
            
            
            <script type="text/javascript" src="js/tablesorter.min.js"></script> 
            <script type="text/javascript" src="js/pager.js"></script> 
            <script type="text/javascript" src="js/administrare-stiri.js"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');

    }

?>