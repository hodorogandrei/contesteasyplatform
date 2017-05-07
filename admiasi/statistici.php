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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Statistici"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');


        $sql = "SELECT * FROM `participanti` WHERE clasa BETWEEN 5 AND 8";
        $elevigim = mysql_num_rows(mysql_query($sql));

        $sql = "SELECT * FROM `participanti` WHERE clasa BETWEEN 9 AND 12";
        $elevilic = mysql_num_rows(mysql_query($sql));

        $sql = "SELECT * FROM `rezultate` WHERE total BETWEEN 0 AND 100";
        $p1 = mysql_num_rows(mysql_query($sql));

        $sql = "SELECT * FROM `rezultate` WHERE total BETWEEN 100 AND 200";
        $p2 = mysql_num_rows(mysql_query($sql));

        $sql = "SELECT * FROM `rezultate` WHERE total BETWEEN 200 AND 300";
        $p3 = mysql_num_rows(mysql_query($sql));
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>                                
            <link rel="stylesheet" type="text/css" href="js/jquery.jqplot.css" />
            <link rel="stylesheet" type="text/css" href="css/jqplot.css" />   
            <style type="text/css">          
                #chart1, #chart2 {text-align: left; width: 420px;}
                #chart3 {text-align: left; width: 890px;}
            </style>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Statistici participanti</b><br/>
                        <table width="100%">
                            <tr>
                                <td width="50%" valign="top">
                                    <div id="chart1"></div>
                                    <center>
                                        <table style="text-align: center;" class="mytable">
                                            <thead>
                                                <tr class="part_header">
                                                    <th>Clasa</th>
                                                    <th>Num&#259;r elevi &icirc;nscri&#537;i</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $elevi=array();
                                                    $sql="
                                                    SELECT clasa, COUNT(clasa) as count
                                                    FROM `participanti`
                                                    WHERE clasa BETWEEN 5 AND 12
                                                    GROUP BY clasa 
                                                    ";
                                                    $result = mysql_query($sql);
                                                    while($row = mysql_fetch_object($result))
                                                    {
                                                        echo '
                                                        <tr>
                                                        <td>a '.$row -> clasa.'-a</td>
                                                        <td>'.$row -> count.'</td>
                                                        </tr>	
                                                        ';
                                                        $elevi[$row -> clasa]=$row -> count;
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <b>Num&#259;r elevi &icirc;nscri&#537;i la gimnaziu:</b> <?php echo $elevigim;?><br/>
                                        <b>Num&#259;r elevi &icirc;nscri&#537;i la liceu:</b> <?php echo $elevilic;?>
                                    </center>
                                </td>
                                <td valign="top">
                                    <div id="chart2"></div>
                                    <table style="text-align: center;" class="mytable" align="center">
                                        <thead>
                                            <tr class="part_header">
                                                <th>Jude&#355;</th>
                                                <th>Num&#259;r elevi &icirc;nscri&#537;i</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $judete=array();
                                                $sql="
                                                SELECT judet, COUNT(judet) as count
                                                FROM `participanti`
                                                GROUP BY `judet` 
                                                ";
                                                $result = mysql_query($sql);
                                                while($row = mysql_fetch_object($result))
                                                {
                                                    echo '
                                                    <tr>
                                                    <td>'.$row -> judet.'</td>
                                                    <td>'.$row -> count.'</td>
                                                    </tr>	
                                                    ';
                                                    $judete[$row -> judet]=$row -> count;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <b>Statistici rezultate</b><br/>
                        <table width="100%" style="text-align: center;">
                            <tr>
                                <td valign="top">
                                    <div id="chart3"></div>
                                    <br/>
                                    <b>Num&#259;r elevi cu punctaj &icirc;ntre 0-100 puncte:</b> <?php echo $p1;?><br/>
                                    <b>Num&#259;r elevi cu punctaj &icirc;ntre 100-200 puncte:</b> <?php echo $p2;?><br/>
                                    <b>Num&#259;r elevi cu punctaj &icirc;ntre 200-300 puncte:</b> <?php echo $p3;?><br/>
                                </td>
                            </tr>
                        </table>
                        <br/><br/>
                        <b>Statistici conturi</b><br/><br/>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.pieRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.donutRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.barRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.pointLabels.min.js"></script>
            <script type="text/javascript" src="js/stats.js"></script>
            <script type="text/javascript">
                var data = [
                <?php
                    for($i=5;$i<=12;$i++)
                        echo "['Clasa a ".$i."-a',".$elevi[$i]."], ";
                ?>
                ];


                var data2 = [
                ['Elevi gimnaziu',<?php echo $elevigim;?>], ['Elevi liceu',<?php echo $elevilic;?>]
                ];


                var s1 = [<?php echo $p1.',',$p2.',',$p3;?>];
                var ticks = ['Punctaj 0-100','Punctaj 100-200', 'Punctaj 200-300'];
            </script>
            <script type="text/javascript" src="js/statistici.js"></script>     
            <script type="text/javascript" src="js/create-imgbutton.js"></script>
        </body>
    </html>
    <?php
    } else {
        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>