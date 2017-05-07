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
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Administrare rezultate"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');



        if(isset($_POST['sterge']) && is_numeric($_GET['id']))
        {
            $sql = 'DELETE FROM rezultate WHERE id='.$_GET['id'].'';
            mysql_query($sql);
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-rezultate.php');
        }



        if(isset($_POST['submit']))
        {
            $ok=1;
            $id = make_safe($_GET['id']);
            $numele = make_safe($_POST['numele']);
            $clasa = make_safe($_POST['clasa']);
            $total = make_safe($_POST['total']);
            $observatii = make_safe($_POST['observatii']);
            $premiu = make_safe($_POST['premiu']);
            $medalie = make_safe($_POST['medalie']);
            if(is_valid($numele) && is_valid($clasa))
            {
                if(isset($_POST['judet']) && 
                is_numeric($_POST['judet']) && 
                $_POST['judet'] >= 1 && 
                $_POST['judet'] <= 42

                &&

                isset($_POST['clasa']) &&
                is_numeric($_POST['clasa']) &&
                $_POST['clasa'] >= 5 &&
                $_POST['clasa'] <= 12)
                {
                    $sql = "SELECT `judet` FROM `judete` WHERE id=".$_POST['judet']."";
                    $result = mysql_query($sql);
                    $row = mysql_fetch_object($result);
                    $judet = $row -> judet;
                    if(is_numeric($total) || empty($total))
                    {
                        $query="UPDATE `rezultate` SET
                        numele='$numele', 
                        clasa='$clasa', 
                        judet='$judet', 
                        total='$total', 
                        premiu='$premiu', 
                        observatii='$observatii', 
                        premiu='$premiu', 
                        medalie='$medalie' 
                        WHERE id='$id'";
                        mysql_query($query);
                        $mesaj = 'Datele participantului au fost actualizate!';
                    }
                    else 
                        $mesaj = "C&acirc;mpurile aferente punctajelor trebuie s&#259; fie numere &icirc;ntregi.";
                }
                else
                    $mesaj = "A ap&#259;rut o eroare la selectarea jude&#539;ului sau a clasei!";
            }
            else
            {
                $ok=0;
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii!";
            }

        }


        if(isset($_GET['id']) && is_numeric($_GET['id']))
        {
            $sql = 'SELECT * FROM rezultate where id='.$_GET['id'].'';
            $result = mysql_query($sql);
            if(mysql_num_rows($result)>0)
            {
                $rand = mysql_fetch_object($result);
                $id = $rand -> id;
                $numele = $rand -> numele;
                $clasa = $rand -> clasa;
                $judet = $rand -> judet;
                $total = $rand -> total;
                $observatii = $rand -> observatii;
                $premiu = $rand -> premiu;
                $medalie = $rand -> medalie;

                $sql = "SELECT * FROM `rezultate`";
                $result = mysql_query($sql);
                while($rand = mysql_fetch_object($result))
                {
                    $ptotal += $rand -> total;
                }                     
                $pmediu = $ptotal / mysql_num_rows($result);

                $ptotal = 0;
                $sql = "SELECT * FROM `rezultate` WHERE clasa=".$clasa."";
                $result = mysql_query($sql);

                while($rand = mysql_fetch_object($result))
                {
                    $ptotal += $rand -> total;
                }

                $pmediucl = $ptotal / mysql_num_rows($result);
            }
            else
                $nuexista=1;
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/administrare-rezultate.php');
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="js/jquery.jqplot.css" />
            <link rel="stylesheet" type="text/css" href="css/jqplot.css" />
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" /><style type="text/css">          
                #chart1 {width: 350px;}
            </style>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <?php if(!isset($nuexista))
                            {
                            ?>
                            <br/>
                            <a href="administrare-rezultate.php"><img src="images/back.png" class="midalign"/></a>&nbsp;<a href="administrare-rezultate.php">&Icirc;napoi la pagina de administrare rezultate</a>
                            <br/><br/>
                            <b>Editare participant:</b><br/><br/> 

                            <?php 	     
                                display_message($mesaj);
                                display_message($mesaj2);
                            ?>


                            <table>
                                <tr>
                                    <td valign="top">
                                        <form action="editare-rezultat.php?id=<?php echo $_GET['id'];?>" method="post" id="validate">
                                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                                            <table cellpadding="2" cellspacing="2">
                                                <tr>
                                                    <td>Numele: </td>
                                                    <td><?php check_field($ok, "numele"); ?><input name="numele" type="text" value="<?php check_isset("numele");?>" class="stfield" size="40" data-validation-engine="validate[required]"/>
                                                        <br /></td>
                                                </tr>
                                                <tr>
                                                    <td>Clasa: </td>
                                                    <td>
                                                        <?php check_field_clasa($ok); ?>
                                                        <select name="clasa" class="stselect">
                                                            <option value="<?php check_isset("clasa");?>" selected="selected"><?php check_isset("clasa");?></option>
                                                            <option value="5">5</option>
                                                            <option value="6">6</option>
                                                            <option value="7">7</option>
                                                            <option value="8">8</option>
                                                            <option value="9">9</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12">12</option>
                                                        </select>
                                                        <br />
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td>Jude&#355;: </td>
                                                    <td>
                                                        <?php check_field_judet($ok); ?>
                                                        <select name="judet" class="stselect">
                                                            <option value="<?php echo link_judet($judet);?>" selected="selected"><?php echo $judet;?></option>
                                                            <?php
                                                                $sql = "SELECT * FROM `judete`";
                                                                $result = mysql_query($sql);
                                                                while($rand = mysql_fetch_object($result))
                                                                {
                                                                    echo '<option value="'.$rand -> id.'">'.$rand -> judet.'</option>';
                                                                    echo "\n";
                                                                }
                                                            ?>
                                                        </select>
                                                        <br />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Punctaj Total: </td>
                                                    <td><input name="total" type="text" value="<?php check_isset("total");?>" size="2" class="stfield" data-validation-engine="validate[custom[integer]]"/>
                                                        <br /></td>
                                                </tr>
                                                <tr>
                                                    <td>Observa&#355;ii: </td>
                                                    <td><input name="observatii" type="text" value="<?php check_isset("observatii");?>" size="7" class="stfield"/>
                                                        <br /></td>
                                                </tr>
                                                <tr>
                                                    <td>Premiu: </td>
                                                    <td><input name="premiu" type="text" value="<?php check_isset("premiu");?>" size="7" class="stfield"/>
                                                        <br /></td>
                                                </tr>
                                                <tr>
                                                    <td>Medalie: </td>
                                                    <td><input name="medalie" type="text" value="<?php check_isset("medalie");?>" size="7" class="stfield" />
                                                        <br /></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input name="submit" type="submit" value="Actualizare rezultat participant" />
                                                    </td>
                                                    <td>
                                                        <input name="sterge" type="submit" value="&#350;tergere participant" onclick="return confirm('Sunteţi sigur(ă) ca doriţi să ştergeţi acest particpant?');" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                    <td>
                                        <div id="chart1"></div>
                                    </td>
                                </tr>
                            </table>

                            <?php } else {?>
                            Participantul pe care a&#355;i &icirc;ncercat s&#259; &icirc;l accesa&#355;i nu exist&#259;!
                            <?php } ?>

                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>


            <script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.barRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.pieRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.categoryAxisRenderer.min.js"></script>
            <script type="text/javascript" src="js/plugins/jqplot.pointLabels.min.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript">
                var s1 = [<?php echo $total;?>, <?php echo $pmediu;?>, <?php echo $pmediucl;?>, 300];
                var ticks = ['Punctaj\nparticipant', 'Punctaj\nmediu\nglobal', 'Punctaj\nmediu\nclasa <?php echo $clasa;?>', 'Punctaj\nmaxim'];
            </script>   
            <script type="text/javascript" src="js/editare-rezultat.js"></script>    
            <script type="text/javascript" src="js/create-imgbutton.js"></script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>