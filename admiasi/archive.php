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
            $sql = "SELECT * FROM `usrs2012` where id='$setid'";
            $result = mysql_query($sql);
            if(mysql_num_rows($result) > 0)
                while($rand = mysql_fetch_array($result))
                {	
                    $global = $rand['global'];
            }
            if($global!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        if(isset($_GET['sterge']))
        {
            $sql = "TRUNCATE TABLE `chat`";
            mysql_query($sql);
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
                        <a href="administratori.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="administratori.php">&Icirc;napoi la pagina de administratorilor</a>
                        <br/><br/>
                        <a href="archive.php?sterge" class="delete-link">Gole&#351;te arhiva</a>
                        <br/><br/>
                        <table width="100%" id="mytable" class="tablesorter">
                            <thead>
                                <tr class="part_header">
                                    <th><center>Mesaj</center></th>
                                    <th><center>Trimis de</center></th>
                                    <th><center>Primit de</center></th>
                                    <th><center>Data &#351;i ora</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $numar=0;
                                    $sql = "SELECT * FROM `chat` ORDER BY sent DESC"; 
                                    $rezultat = mysql_query($sql);
                                    while($rand = mysql_fetch_array($rezultat))
                                    {
                                        echo '
                                        <tr>
                                        <td >'.$rand['message'].'</td>
                                        <td >'.$rand['from'].'</td>
                                        <td >'.$rand['to'].'</td>
                                        <td ><i>'.$rand['sent'].'</i></td>
                                        </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                        <br/><br/><br/>
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
                        </div>
                    </div>
                    <?php include("include/footeradm.php");?>
                    <?php include("include/popup.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/tablesorter.min.js"></script>
            <script type="text/javascript" src="js/archive.js"></script>
            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
            <script type="text/javascript" src="js/confirm.js"></script>
            <script type="text/javascript" src="js/pager.js"></script> 
        </body>
    </html>
    <?php

    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>