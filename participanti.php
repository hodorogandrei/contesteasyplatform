<?php
    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }

    ob_start('callback');

    include_once("include/header.php");
    
    $titlu="Participan&#355;i";
?>
<script src="js/globalscript.js" type="text/javascript"></script>
<div id="pagecontent">
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu;?>
        </div>
        <div id="continut2">
            <form id="form" onsubmit="this.pdfcontent.value = document.getElementById('elevi_content').innerHTML;" action="generate-pdf.php" method="post">
                <div id="zoomzone">
                    <a href="#" class="zoomin" title="Zoom In"></a>
                    <a href="#" class="zoomout" title="Zoom Out"></a>
                    <a href="#" class="resetFont" title="Resetare"></a>
                    <input type="submit" value="" name="html2pdf" id="generatepdf" title="Generare PDF"/>
                    <div id="qrcode">
                        <?php
                            $urlToEncode=$actual_link;
                            generateQRwithGoogle($urlToEncode);
                            function generateQRwithGoogle($url,$widthHeight ='70',$EC_level='L',$margin='0') {
                                $url = urlencode($url); 
                                echo '<img src="http://chart.apis.google.com/chart?chs='.$widthHeight.
                                'x'.$widthHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.
                                '&chl='.$url.'" alt="QR code" widthHeight="'.$widthHeight.
                                '" widthHeight="'.$widthHeight.'"/>';
                            }
                        ?>
                    </div>
                </div>

                <input type="hidden" name="pdfcontent" value="" />
                <input type="hidden" name="filename"   value="participanti" />
                <div id="tzone">
                    <span class="smalltitle_blue">Op&#355;iuni</span> <span class="smalltitle_grey">c&#259;utare:</span><br/><br/>
                    <form enctype="text/plain" method="post">
                        <table cellpadding="0" cellspacing="5">
                            <tr>
                                <td>Jude&#355;: </td>
                                <td>
                                    <select id="judet" class="part_select">
                                        <option selected="selected" value="Toate">Toate</option>
                                        <option value="Alba">Alba</option>
                                        <option value="Arad">Arad</option>
                                        <option value="Arges">Arges</option>
                                        <option value="Bacau">Bacau</option>
                                        <option value="Bihor">Bihor</option>
                                        <option value="Bistrita-Nasaud">Bistrita-Nasaud</option>
                                        <option value="Botosani">Botosani</option>
                                        <option value="Braila">Braila</option>
                                        <option value="Brasov">Brasov</option>
                                        <option value="Bucuresti">Bucuresti</option>
                                        <option value="Buzau">Buzau</option>
                                        <option value="Calarasi">Calarasi</option>
                                        <option value="Caras-Severin">Caras-Severin</option>
                                        <option value="Cluj">Cluj</option>
                                        <option value="Constanta">Constanta</option>
                                        <option value="Covasna">Covasna</option>
                                        <option value="Dambovita">Dambovita</option>
                                        <option value="Dolj">Dolj</option>
                                        <option value="Galati">Galati</option>
                                        <option value="Giurgiu">Giurgiu</option>
                                        <option value="Gorj">Gorj</option>
                                        <option value="Harghita">Harghita</option>
                                        <option value="Hunedoara">Hunedoara</option>
                                        <option value="Ialomita">Ialomita</option>
                                        <option value="Iasi">Iasi</option>
                                        <option value="Ilfov">Ilfov</option>
                                        <option value="Maramures">Maramures</option>
                                        <option value="Mehedinti">Mehedinti</option>
                                        <option value="Mures">Mures</option>
                                        <option value="Neamt">Neamt</option>
                                        <option value="Olt">Olt</option>
                                        <option value="Prahova">Prahova</option>
                                        <option value="Salaj">Salaj</option>
                                        <option value="Satu-Mare">Satu-Mare</option>
                                        <option value="Sibiu">Sibiu</option>
                                        <option value="Suceava">Suceava</option>
                                        <option value="Teleorman">Teleorman</option>
                                        <option value="Timis">Timis</option>
                                        <option value="Tulcea">Tulcea</option>
                                        <option value="Valcea">Valcea</option>
                                        <option value="Vaslui">Vaslui</option>
                                        <option value="Vrancea">Vrancea</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Clasa: </td>
                                <td>
                                    <select id="clasa" class="part_select">
                                        <option selected="selected" value="9-12">9-12</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="5-8">5-8</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Sortat dup&#259;: </td>
                                <td>
                                    <select id="sort" class="part_select">
                                        <option selected="selected" value="numele">Nume</option>
                                        <option value="clasa">Clasa</option>
                                        <option value="judet">Judet</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="button" value="Afi&#351;are" id="displaypart"/></td>
                            </tr>
                        </table>
                    </form>
                    <br/><span class="smalltitle_blue">Elevi</span> <span class="smalltitle_grey">g&#259;si&#355;i:</span><br/><br/>
                    <div id="elevi_content">	
                    </div>
                </div>
                <noscript>
                    <br/><br/>
                    <?php
                        $sql = 'SELECT * FROM participanti ORDER BY clasa, numele';
                        $rezultat = mysql_query($sql);
                        if(mysql_num_rows($rezultat)>0)
                        {
                        ?>
                        <table align="center" width="100%" cellspacing="2" cellpadding="2" border="0">
                            <tr class="part_header">
                                <td>Nume</td>
                                <td style="text-align: center;">Clasa</td>
                                <td style="text-align: center;">Jude&#355;</td>
                                <td style="text-align: center;">Unitatea &#351;colar&#259;</td>
                                <td style="text-align: center;">Centru cazare</td>
                                <td style="text-align: center;">Centru concurs</td>
                            </tr>
                            <?php
                                $numar=0;
                                while($rand = mysql_fetch_array($rezultat))
                                {
                                    $numar++;
                                    if($numar % 2 == 0)
                                    {
                                        echo '<tr class="part_tr">';
                                        echo '<td style="text-align: left;">' . $rand -> numele. '</td>';
                                        echo '<td>' . $rand -> clasa . '</td>';
                                        echo '<td>' . $rand -> judet . '</td>';
                                        echo '<td>' . $rand -> unitatea . '</td>';
                                        echo '<td>' . $rand -> cazare . '</td>';
                                        echo '<td>' . $rand -> concurs . '</td>';
                                        echo '</tr>';
                                    }
                                    else
                                    {
                                        echo '<tr class="part_tr_gri">';
                                        echo '<td style="text-align: left;">' . $rand -> numele. '</td>';
                                        echo '<td>' . $rand -> clasa . '</td>';
                                        echo '<td>' . $rand -> judet . '</td>';
                                        echo '<td>' . $rand -> unitatea . '</td>';
                                        echo '<td>' . $rand -> cazare . '</td>';
                                        echo '<td>' . $rand -> concurs . '</td>';
                                        echo '</tr>';
                                    }
                                }
                            ?>
                        </table>
                        <?php
                        }
                        else
                        {
                        ?>
                        <center><span class="smalltitle_red">Nu exist&#259; elevi de afisat</span></center>
                        <?php } ?>
                </noscript>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    //<![CDATA[
    document.write('<style type="text/css">#tzone {display: block;}</style>');
    //]]>
</script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/load-rez.js"></script>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>
