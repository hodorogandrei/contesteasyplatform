<?php
    require_once("include/config.php");
    require_once("include/functions.php");
    
    error_reporting(E_ERROR | E_PARSE);
    
    if(!isset($_SESSION['logat'])) $_SESSION['logat'] = 'Nu';
    if($_SESSION['logat'] == 'Da')
    {
        if(isset($_SESSION['nume']) && ctype_alnum($_SESSION['nume']))
            $setid = $_SESSION['userid'];
        if(isset($setid))
        {
            if($_SESSION['global']==1 ? $acces=1 : $acces=check_perm("Informatii generale"));
            if($acces!=1)
                header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
        }
        else
            header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');

            
        $sql = "SELECT * FROM `general` WHERE id=1"; 
        $rezultat = mysql_query($sql);
        $rand = mysql_fetch_object($rezultat);
        $compname = $rand->name;
        $deadline = $rand -> datainc;
        $endm = $rand -> endm;
        $organiser = $rand -> organiser;
        $compaddr = $rand -> compaddr;
        $organiserweb = $rand -> organiserweb;
        $headtitle = $rand -> headtitle;
        $foottitle = $rand -> foottitle;
        $nw = $rand -> nw;
        $begdate = $rand -> begdate;
        $enddate = $rand -> enddate;
        $picture = $rand -> picture;
        $oras2 = $rand -> oras;
        $colorheader = $rand -> colorheader;
        $colorfooter = $rand -> colorfooter;
        $colortitle = $rand -> colortitle;
        $wafis = $rand -> wafis;
        $mp3file = $rand -> mp3file;


        if(isset($_POST['submit_general']))
        {
            $ok=0;
            $nw = make_safe($_POST['checkbox']);
            $compname = make_safe_lite($_POST['compname']);
            $deadline = make_safe($_POST['datainc']);
            $begdate = make_safe($_POST['begdate']);
            $enddate = make_safe($_POST['enddate']);
            $colorheader = make_safe($_POST['colorheader']);
            $colorfooter = make_safe($_POST['colorfooter']);
            $colortitle = make_safe($_POST['colortitle']);
            $organiser = make_safe_lite($_POST['organiser']);
            $compaddr = make_safe_lite($_POST['compaddr']);
            $organiserweb = make_safe_lite($_POST['organiserweb']);
            $headtitle = make_safe_lite($_POST['headtitle']);
            $foottitle = make_safe_lite($_POST['foottitle']);
            $wafis = make_safe($_POST['wafis']);
            
            if(is_valid($_POST['compname']) && 
            is_valid($_POST['datainc']) && 
            is_valid($_POST['organiser']) && 
            is_valid($_POST['compaddr']) && 
            is_valid($_POST['organiserweb']) && 
            is_valid($_POST['headtitle']) && 
            is_valid($_POST['foottitle']) && 
            is_valid($_POST['oras']) && 
            is_valid($_POST['begdate']) && 
            is_valid($_POST['enddate']))
            {
                $ok=1;
                if(!validateURL($_POST['organiserweb']))
                    $mesaj4 = "Adres&#259; web invalid&#259;.";
                elseif(!validateURL($_POST['compaddr'])) 
                    $mesaj5 = "Adres&#259; web invalid&#259;.";
                else
                {
                    if(!empty($_FILES['mp3file']['tmp_name']))
                    {
                        if($mp3file!='mp3/')
                            unlink('../'.$mp3file.'');
                        $filename=basename( $_FILES['mp3file']['name']);
                        $ext = end(explode('.', $filename));
                        $ext = substr(strrchr($filename, '.'), 1);
                        $ext = substr($filename, strrpos($filename, '.') + 1);
                        $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                        $exts = split("[/\\.]", $filename);
                        $n = count($exts)-1;
                        $ext = $exts[$n];
                        
                        if(strcmp($ext,'mp3')==0) $ok2=1;
                        if($ok2==1)
                        {
                            $link = 'mp3/'.$_FILES['mp3file']['name'].'';
                            //incarcarea imaginii, daca exista
                            $target_path = "../mp3/";
                            $target_path = $target_path . basename( $_FILES['mp3file']['name']); 
                            if(move_uploaded_file($_FILES['mp3file']['tmp_name'], $target_path)) 
                            {
                                $mesaj2 = "Fi&#351;ierul <span class=\"smalltitle\">".  basename( $_FILES['mp3file']['name'])."</span> a fost inc&#259;rcat.";
                            } 
                            $mp3file = 'mp3/'.$filename;
                        }
                        else
                        {
                            $mesaj2 = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. Singurul format permis este MP3. ";
                        }
                    }
                    
                    $sql="UPDATE `general` SET 
                    name='$compname', 
                    datainc='$deadline', 
                    endm='$endm', 
                    organiser='$organiser', 
                    compaddr='$compaddr', 
                    organiserweb='$organiserweb', 
                    headtitle='$headtitle', 
                    nw='$nw',
                    foottitle='$foottitle', 
                    begdate='$begdate', 
                    enddate='$enddate', 
                    oras='".link_oras(make_safe($_POST['oras']))."', 
                    colorheader='$colorheader', 
                    colorfooter='$colorfooter', 
                    colortitle='$colortitle', 
                    wafis='$wafis', 
                    mp3file='$mp3file' 
                    WHERE id=1";
                    mysql_query($sql);
                    
                    $mesaj= "Datele au fost actualizate.";
                }
            }
            if($ok==0)
            {
                $mesaj = "C&acirc;mpurile marcate cu * sunt obligatorii.";
            }
        }
        if(isset($_POST['submit_logo']))
        {
            if(is_valid($_FILES['uploadedfile']['tmp_name']))
            {
                $filename=basename( $_FILES['uploadedfile']['name']);
                $ext = end(explode('.', $filename));
                $ext = substr(strrchr($filename, '.'), 1);
                $ext = substr($filename, strrpos($filename, '.') + 1);
                $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $filename);
                $exts = split("[/\\.]", $filename);
                $n = count($exts)-1;
                $ext = $exts[$n];
                
                if(strcmp($ext,'jpg')==0 || 
                strcmp($ext,'jpeg')==0 || 
                strcmp($ext,'png')==0 || 
                strcmp($ext,'bmp')==0 || 
                strcmp($ext,'gif')==0) $ok=1;
                else $ok=0;
                
                if($ok==1)
                {
                    //sterge imaginea veche
                    if($picture!='images/')
                        unlink('../'.$picture.'');
                }
                else
                {
                    $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. 
                    Formate permise: .bmp, .png, .jpeg, .jpg, .png, .gif";
                }
            }
            //incarcarea imaginii, daca exista
            if((isset($ok) && $ok==1) || empty($_FILES['uploadedfile']['tmp_name']))
            {
                $target_path = "../images/";
                $target_path = $target_path . basename($_FILES['uploadedfile']['name']);
                if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) 
                {
                    $mesaj = "Logo actualizat! Imaginea <span class=\"smalltitle\">".  basename( $_FILES['uploadedfile']['name'])."</span> a fost inc&#259;rcat&#259;.";
                } 
                else
                {
                    $mesaj = "Nu a&#355;i selectat niciun fi&#351;ier!";
                }
                if(is_valid($_FILES['uploadedfile']['tmp_name']))
                    $link = 'images/'.$_FILES['uploadedfile']['name'].'';
                else
                    $link = $picture;
                if(is_valid($_FILES['uploadedfile']['tmp_name']))
                {
                    list($width, $height, $type, $attr) = getimagesize('../'.$link.'');
                    if($height>155)
                    {
                        include('../libraries/simpleImage.php');
                        $image = new SimpleImage();
                        $image->load('../'.$link.'');
                        $image->resizeToHeight(155);
                        $image->save('../'.$link.'');
                    }
                }
                if(is_valid($link))
                    $link = make_safe($link);
                    
                $sql = "UPDATE `general` SET picture='$link' WHERE id=1";
                mysql_query($sql);
            }
            else
            {
                $mesaj = "Tipul de fi&#351;ier selectat (<span class=\"smalltitle\">".$ext."</span>) nu este permis. 
                Formate permise: .bmp, .png, .jpeg, .jpg, .png, .gif";
            }
        }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head profile="http://gmpg.org/xfn/11">
            <?php include("include/headerinfoadm.php");?>
            <link rel="stylesheet" type="text/css" href="css/jscal2.css" />
            <link rel="stylesheet" type="text/css" href="css/border-radius.css" />
            <link rel="stylesheet" type="text/css" href="css/steel/steel.css" />
            <link rel="stylesheet" type="text/css" href="css/farbtastic.css"  />   
            <link rel="stylesheet" type="text/css" href="js/fileuploader.css"  />
            <link rel="stylesheet" type="text/css" href="js/formValidator/validationEngine.jquery.css" /> 
            
            <script type="text/javascript" src="js/jquery.min-164.js"></script>
            <script type="text/javascript" src="js/jscal2.js"></script>
            <script type="text/javascript" src="js/lang/ro.js"></script>
        </head>
        <body>
            <div id="contain">
                <div id="main">
                    <?php include("include/headeradm.php");?>
                    <div id="pagecontent">
                        <div id="pcontent_f"></div>
                        <br/>
                        <b>Informa&#355;ii generale despre eveniment:</b>
                        <br/>
                        <?php display_message($mesaj); ?>
                        <?php display_message($mesaj2); ?>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="submit_logo" enctype="multipart/form-data" id="validate1">
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                            <table>
                                <?php
                                    if((is_valid($picture)) && ($picture!='newsimg/'))
                                    {
                                    ?>
                                    <tr>
                                        <td>Logo asociat curent: </td>
                                        <td>
                                            <img src="../<?php echo $picture;?>" />
                                        </td>
                                    </tr>
                                    <?php
                                    } else {?>
                                    <tr>
                                        <td colspan="2"><div class="smalltitle_black">Nu exist&#259; niciun logo asociat.</div></td>
                                    </tr>
                                    <?php
                                    }
                                ?>
                                <tr>
                                    <td>Logo asociat: </td>
                                    <td><input name="uploadedfile" type="file" data-validation-engine="validate[required]" />
                                        <br />
                                    </td>
                                </tr>
                                <?php if((is_valid($picture)) && ($picture!='newsimg/')) 
                                    {?>
                                    <tr>
                                        <td colspan="2">
                                            <div class="smalltitle_red">(Aten&#355;ie! Logo-ul vechi va fi &#351;ters!)</div><br/>
                                            <input name="submit_logo" type="submit" value="Actualizare Logo" class="no-warn" />
                                        </td>
                                    </tr>
                                    <?php } ?>
                            </table>
                        </form>
                        <br/>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" id="validate">
                            <input type="hidden" name="MAX_FILE_SIZE" value="10000000000000" />
                            <input type="hidden" name="token" value="<?php echo $_SESSION['token'] ?>" />
                            <?php check_field($ok, "compname"); ?>Numele evenimentului:<br/><br/>
                            <input type="text" name="compname" value="<?php echo $compname;?>" class="stfield" size="100" onkeyup="countChar2(this)" data-validation-engine="validate[required]" />&nbsp;<span id="charNum2"></span>
                            <br/><br/>

                            <table width="100%">
                                <tr>
                                    <td>
                                        <?php check_field($ok, "datainc"); ?>Ora &#351;i data expir&#259;rii timer-ului: <i>(face&#355;i selec&#355;ia &icirc;n aceast&#259; ordine)</i><br/><br/>
                                        <input type="text" name="datainc" value="<?php echo $deadline;?>" class="stfield" id="f_date1" size="15" readonly="readonly"/><button id="f_btn1">...</button>
                                        <script type="text/javascript">//<![CDATA[
                                            Calendar.setup({
                                                inputField : "f_date1",
                                                trigger    : "f_btn1",
                                                onSelect   : function() { this.hide() },
                                                showTime: 24,
                                                dateFormat : "%Y,%m,%d,%I,%M,0"
                                            });
                                            //]]></script>

                                        <?php noscript_text_default();?>
                                        <br/><br/>
                                    </td>
                                    <td>
                                        <?php check_field($ok, "begdate"); ?>Data &icirc;nceperii evenimentului:<br/><br/>
                                        <input type="text" name="begdate" value="<?php echo $begdate;?>" class="stfield" id="f_date2" size="15" readonly="readonly"/><button id="f_btn2">...</button>
                                        <script type="text/javascript">//<![CDATA[
                                            Calendar.setup({
                                                inputField : "f_date2",
                                                trigger    : "f_btn2",
                                                onSelect   : function() { this.hide() },
                                                dateFormat : "%e %b"
                                            });
                                            //]]></script>

                                        <?php noscript_text_default();?>
                                        <br/><br/>
                                    </td>
                                    <td>
                                        <?php check_field($ok, "enddate"); ?>Data sf&acirc;r&#351;itului evenimentului:<br/><br/>
                                        <input type="text" name="enddate" value="<?php echo $enddate;?>" class="stfield" id="f_date3" size="15" readonly="readonly"/><button id="f_btn3">...</button>
                                        <script type="text/javascript">//<![CDATA[
                                            Calendar.setup({
                                                inputField : "f_date3",
                                                trigger    : "f_btn3",
                                                onSelect   : function() { this.hide() },
                                                dateFormat : "%e %b"
                                            });
                                            //]]></script>

                                        <?php noscript_text_default();?>
                                        <br/><br/>
                                    </td>
                                </tr>
                            </table>

                            <table cellspacing="5" width="100%" border="0">
                                <tr>
                                    <td width="33%">
                                        <img src="images/color.png" />&nbsp;Culoare header:<br/>
                                        <input type="text" id="color" name="colorheader" value="<?php echo $colorheader;?>" data-validation-engine="validate[required]" />
                                        <div id="colorpicker_header"></div>
                                    </td>
                                    <td width="33%">
                                        <img src="images/color.png"  />&nbsp;Culoare titlu pagin&#259;:<br/>
                                        <input type="text" id="color2" name="colortitle" value="<?php echo $colortitle;?>" data-validation-engine="validate[required]"/>
                                        <div id="colorpicker_title"></div>
                                    </td>
                                    <td width="33%">
                                        <img src="images/color.png" />&nbsp;Culoare footer:<br/>
                                        <input type="text" id="color3" name="colorfooter" value="<?php echo $colorfooter;?>" data-validation-engine="validate[required]"/>
                                        <div id="colorpicker_footer"></div>
                                    </td>
                                </tr>
                            </table>
                            <br/>

                            <img src="images/city.png" class="midalign"/>&nbsp;Ora&#351; pentru afi&#351;area vremii:
                            <br/><br/>


                            <?php check_field($ok, "oras"); ?>
                            <select name="oras" class="stselect">
                                <?php if(!isset($_POST['oras'])) { 
                                        $doSQL = 'SELECT * FROM `general` WHERE id=1'; 
                                        $rezultat = mysql_query($doSQL);
                                        
                                        while($rand = mysql_fetch_object($rezultat))
                                        {
                                            $tempor = $rand -> oras;
                                            
                                            $doSQL2 = "SELECT * FROM `orase` WHERE nume='$tempor'"; 
                                            $rezultat2 = mysql_query($doSQL2);
                                            $rand2 = mysql_fetch_object($rezultat2);
                                            $oras3 = $rand2 -> nume2;
                                            $oras4 = $rand2 -> id;
                                        }
                                    ?>
                                    <option selected="selected" value="<?php echo $oras4;?>"><?php echo $oras3;?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $_POST['oras'];?>" selected="selected"><?php echo link_oras2($_POST['oras']);?></option>
                                    <?php } ?>
                                <option value="1">Braila</option>
                                <option value="2">Brasov</option>
                                <option value="3">Bucuresti</option>
                                <option value="4">Buzau</option>
                                <option value="5">Campina</option>
                                <option value="7">Craiova</option>
                                <option value="8">Focsani</option>
                                <option value="9">Galati</option>
                                <option value="10">Giurgiu</option>
                                <option value="11">Pitesti</option>
                                <option value="12">Ploiesti</option>
                                <option value="13">Rosiori de Vede</option>
                                <option value="14">Sibiu</option>
                                <option value="15">Slatina</option>
                                <option value="16">Slobozia</option>
                                <option value="17">Sighetu Marmatiei</option>
                                <option value="18">Botosani</option>
                                <option value="19">Oradea</option>
                                <option value="20">Iasi</option>
                                <option value="21">Ceahlau Toaca</option>
                                <option value="22">Cluj-Napoca</option>
                                <option value="23">Bacau</option>
                                <option value="24">Arad</option>
                                <option value="25">Vf. Omu</option>
                                <option value="26">Caransebes</option>
                                <option value="28">Rimnicu Vilcea</option>
                                <option value="30">Sulina</option>
                                <option value="31">Drobeta Tr. Severin</option>
                                <option value="32">Calarasi</option>
                                <option value="34">Constanta</option>
                                <option value="35">Gheorgheni</option>
                                <option value="36">Petrosani</option>
                                <option value="37">Prundu</option>
                                <option value="38">Satu Mare</option>
                                <option value="39">Talmaciu</option>
                                <option value="40">Timisoara</option>
                                <option value="41">Tirgoviste</option>
                                <option value="42">Calafat</option>
                                <option value="43">Targu-Mures</option>
                                <option value="44">Sebes</option>
                                <option value="45">Sase Martie</option>
                                <option value="46">Suceava</option>
                                <option value="47">Baia-Mare</option>
                            </select>
                            <input name="wafis" type="checkbox" id="checkbox" value="1" style="vertical-align: middle;" <?php if($wafis==1) {?> checked="checked" <?}?>/><span class="smalltitle"><b>Afi&#351;eaz&#259; vremea</span></b>
                            <br/><br/>
                            <table width="100%">
                                <tr>
                                    <td>
                                        <?php check_field($ok, "organiser"); ?>Organizator:<br/><br/>
                                        <input type="text" name="organiser" value="<?php echo $organiser;?>" class="stfield" size="15" onkeyup="countChar3(this)" data-validation-engine="validate[required]"/>&nbsp;<span id="charNum3"></span>

                                    </td>
                                    <td>
                                        <img src="images/webad.png" class="midalign"/><?php check_field($ok, "organiserweb"); ?>&nbsp;Adres&#259; web organizator (incluz&acirc;nd <i>http://</i>):&nbsp;<br/><br/>
                                        <input data-validation-engine="validate[required,custom[url]]" type="text" name="organiserweb" value="<?php echo $organiserweb;?>" class="stfield" size="60"/><input name="checkbox" type="checkbox" id="checkbox" value="1" style="vertical-align: middle;" <?php if($nw==1) {?> checked="checked" <?}?>/><span class="smalltitle">Deschidere &icirc;n fereastr&#259; nou&#259;</span>&nbsp;<?php display_message_inline($mesaj4); ?>

                                    </td>
                                </tr>
                            </table>
                            <br/><br/>
                            <img src="images/webad.png" class="midalign"/><?php check_field($ok, "compaddr"); ?>&nbsp;Adres&#259; web competi&#355;ie (incluz&acirc;nd <i>http:// - folosit&#259; pentru completarea RSS feed-ului</i>): &nbsp;<br/><br/><?php display_message($mesaj5); ?>
                            <input data-validation-engine="validate[required, custom[url]]" type="text" name="compaddr" value="<?php echo $compaddr;?>" class="stfield" size="60"/>

                            <br/><br/>
                            <table width="100%">
                                <tr>
                                    <td>
                                        <?php check_field($ok, "headtitle"); ?>Titlu header:<br/><br/>
                                        <input data-validation-engine="validate[required]" type="text" name="headtitle" value="<?php echo $headtitle;?>" class="stfield" size="50" onkeyup="countChar4(this)"/>&nbsp;<span id="charNum4"></span>

                                    </td>
                                    <td>
                                        <?php check_field($ok, "foottitle"); ?>Titlu footer:<br/><br/>
                                        <input data-validation-engine="validate[required]" type="text" name="foottitle" value="<?php echo $foottitle;?>" class="stfield" size="50" onkeyup="countChar5(this)"/>&nbsp;<span id="charNum5"></span>

                                    </td>
                                </tr>
                            </table>
                            <br/>
                            <img src="images/mp3.png" class="midalign"/>&nbsp;Fi&#351;ier MP3:
                            <br/><br/>
                            <div id="file-uploader">
                                <noscript>
                                    <input type="file" name="mp3file" />
                                </noscript>
                            </div>
                            <br/>
                            <input name="submit_general" type="submit" value="Actualizare Date" class="no-warn"/>
                        </form>
                    </div>
                    <?php include("include/footeradm.php");?>
                </div>
            </div>
            <script type="text/javascript">
                //<![CDATA[
                document.write('<style type="text/css">#f_date1, #f_date2, #f_date3, #f_btn1, #f_btn2, #f_btn3 {display: inline;}</style>');
                //]]>
            </script>
            
                                                                                                         
            <script type="text/javascript" src="js/leavewarn.js"></script>
            <script type="text/javascript" src="js/wcount.js"></script>
            <script type="text/javascript" src="js/farbtastic.js"></script>
            <script type="text/javascript" src="js/fileuploader.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine.js"></script>
            <script type="text/javascript" src="js/formValidator/jquery.validationEngine-ro.js" charset="utf-8"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#colorpicker_header').farbtastic('#color');
                    $('#colorpicker_title').farbtastic('#color2');
                    $('#colorpicker_footer').farbtastic('#color3');
                    $("#validate").validationEngine();
                    $("#validate1").validationEngine();
                    var uploader = new qq.FileUploader({
                        element: document.getElementById('file-uploader'),
                        allowedExtensions: ['mp3'],
                        action: 'server/mp3_upload.php',
                        multiple: false,
                        maxConnections: 1,
                        debug: false,
                        sizeLimlit: 2048,
                        fileTemplate: '<li>' +
                        '<span class="qq-upload-file"></span>' +
                        '<span class="qq-upload-spinner"></span>' +
                        '<span class="qq-upload-size"></span>' +
                        '<a class="qq-upload-cancel" href="#">Abandon</a>' +
                        '<span class="qq-upload-success"></span>' +
                        '<span class="qq-upload-failed-text">E&#351;uat. Extensie invalid&#259;?</span>' +
                        '</li>',
                    });
                });
            </script>
        </body>
    </html>
    <?php

    } else {

        header('Location: http://'.$_SERVER["SERVER_NAME"].'/admiasi/index.php');
    }
?>