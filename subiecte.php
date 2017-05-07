<?php


    function callback($content)
    {
        global $titlu;
        return str_replace("#titlu#",$titlu, $content);
    }
    ob_start('callback');
    include_once("include/header.php");
    $titlu="Subiecte";

?>
<div id="pagecontent">
    <?php include("include/sidebar.php")?>
    <div id="continut">
        <div id="pagetitle">
            <?php echo $titlu; ?>
        </div>
        <div id="continut2">
            <form id="form" onsubmit="this.pdfcontent.value = document.getElementById('pdfcontent2').innerHTML;" action="generate-pdf.php" method="post">
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
                <input type="hidden" name="filename"   value="<?php echo $titlu;?>" />
                <div id="pdfcontent2">
                    <br/>
                    <u><b>Clasa a 5-a:</b></u><br/><br/>
                    <ul>
                        <li><b>culegere:</b>&nbsp;<a href="0doc/subiecte/5/enunt_culegere.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/sol_culegere.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/teste_culegere.zip">teste</a></li>
                        <li><b>culori:</b>&nbsp;<a href="0doc/subiecte/5/enunt_culori.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/sol_culori.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/teste_culori.zip">teste</a></li>
                        <li><b>stele:</b>&nbsp;<a href="0doc/subiecte/5/enunt_stele.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/sol_stele.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/5/teste_stele.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasa a 6-a:</b></u><br/><br/>
                    <ul>
                        <li><b>cartier:</b>&nbsp;<a href="0doc/subiecte/6/enunt_cartier.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/sol_cartier.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/teste_cartier.zip">teste</a></li>
                        <li><b>medalion:</b>&nbsp;<a href="0doc/subiecte/6/enunt_medalion.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/sol_medalion.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/teste_medalion.zip">teste</a></li>
                        <li><b>numar:</b>&nbsp;<a href="0doc/subiecte/6/enunt_numar.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/sol_numar.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/6/teste_numar.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasa a 7-a:</b></u><br/><br/>
                    <ul>
                        <li><b>bile:</b>&nbsp;<a href="0doc/subiecte/7/enunt_bile.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/enunt_bile_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/sol_bile.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/teste_bile.zip">teste</a></li>
                        <li><b>proiecte:</b>&nbsp;<a href="0doc/subiecte/7/enunt_proiecte.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/enunt_proiecte_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/sol_proiecte.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/teste_proiecte.zip">teste</a></li>
                        <li><b>zigzag:</b>&nbsp;<a href="0doc/subiecte/7/enunt_zigzag.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/enunt_zigzag_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/sol_zigzag.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/7/teste_zigzag.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasa a 8-a:</b></u><br/><br/>
                    <ul>
                        <li><b>alune:</b>&nbsp;<a href="0doc/subiecte/8/enunt_alune.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/sol_alune.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/teste_alune.zip">teste</a></li>
                        <li><b>cuburi:</b>&nbsp;<a href="0doc/subiecte/8/enunt_cuburi.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/sol_cuburi.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/teste_cuburi.zip">teste</a></li>
                        <li><b>optim:</b>&nbsp;<a href="0doc/subiecte/8/enunt_optim.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/sol_optim.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/8/teste_optim.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasa a 9-a:</b></u><br/><br/>
                    <ul>
                        <li><b>7segmente:</b>&nbsp;<a href="0doc/subiecte/9/enunt_7segmente.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/enunt_7segmente_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_7segmente.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_7segmente.zip">teste</a></li>
                        <li><b>copaci:</b>&nbsp;<a href="0doc/subiecte/9/enunt_copaci.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/enunt_copaci_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_copaci.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_copaci.zip">teste</a></li>
                        <li><b>intersectii:</b>&nbsp;<a href="0doc/subiecte/9/enunt_intersectii.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/enunt_intersectii_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_intersectii.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_intersectii.zip">teste</a></li>
                        <li><b>palindrom:</b>&nbsp;<a href="0doc/subiecte/9/enunt_palindrom.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_palindrom.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_palindrom.zip">teste</a></li>
                        <li><b>sstabil:</b>&nbsp;<a href="0doc/subiecte/9/enunt_sstabil.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_sstabil.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_sstabil.zip">teste</a></li>
                        <li><b>unuzero:</b>&nbsp;<a href="0doc/subiecte/9/enunt_unuzero.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/sol_unuzero.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/9/teste_unuzero.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasa a 10-a:</b></u><br/><br/>
                    <ul>
                        <li><b>cutie:</b>&nbsp;<a href="0doc/subiecte/10/enunt_cutie.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_cutie.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_cutie.zip">teste</a></li>
                        <li><b>gheizere:</b>&nbsp;<a href="0doc/subiecte/10/enunt_gheizere.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_gheizere.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_gheizere.zip">teste</a></li>
                        <li><b>plus:</b>&nbsp;<a href="0doc/subiecte/10/enunt_plus.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_plus.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_plus.zip">teste</a></li>
                        <li><b>amedie:</b>&nbsp;<a href="0doc/subiecte/10/enunt_amedie.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_amedie.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_amedie.zip">teste</a></li>
                        <li><b>drept:</b>&nbsp;<a href="0doc/subiecte/10/enunt_drept.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_drept.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_drept.zip">teste</a></li>
                        <li><b>poly:</b>&nbsp;<a href="0doc/subiecte/10/enunt_poly.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/sol_poly.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/10/teste_poly.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Clasele 11-12:</b></u><br/><br/>
                    <ul>
                        <li><b>search:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_search.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_search_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_search.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/teste_search.zip">teste</a></li>
                        <li><b>urat:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_urat.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_urat_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_urat.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/teste_urat.zip">teste</a></li>
                        <li><b>zlego:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_zlego.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_zlego_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_zlego.zip">solutie</a>&nbsp;|&nbsp;<a href="http://www.andreihodorog.com/teste_zlego.zip">teste</a></li>
                        <li><b>drumuri:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_drumuri.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_drumuri_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_drumuri.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/teste_drumuri.zip">teste</a></li>
                        <li><b>minerale:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_minerale.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_minerale_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_minerale.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/teste_minerale.zip">teste</a></li>
                        <li><b>tarabe:</b>&nbsp;<a href="0doc/subiecte/11-12/enunt_tarabe.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/enunt_tarabe_lma.doc">enunt limba maghiara</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/sol_tarabe.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/11-12/teste_tarabe.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Baraj gimnaziu:</b></u><br/><br/>
                    <ul>
                        <li><b>cifreco:</b>&nbsp;<a href="0doc/subiecte/baraj/enunt_cifreco.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/sol_cifreco.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/teste_cifreco.zip">teste</a></li>
                        <li><b>patru:</b>&nbsp;<a href="0doc/subiecte/baraj/enunt_patru.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/sol_patru.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/teste_patru.zip">teste</a></li>
                        <li><b>puncte:</b>&nbsp;<a href="0doc/subiecte/baraj/enunt_puncte.doc">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/sol_puncte.zip">solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj/teste_puncte.zip">teste</a></li>
                    </ul>
                    <br/><br/>
                    <u><b>Baraj liceu:</b></u><br/><br/>
                    <ul>
                        <li><b>insula:</b>&nbsp;<a href="0doc/subiecte/baraj-liceu/enunt_insula.pdf">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/sol_insula.pdf">descriere solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/surse_insula.zip">surse</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/teste_insula.zip">teste</a></li>
                        <li><b>kmalloc:</b>&nbsp;<a href="0doc/subiecte/baraj-liceu/enunt_kmalloc.pdf">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/sol_kmalloc.pdf">descriere solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/surse_kmalloc.zip">surse</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/teste_kmalloc.zip">teste</a></li>
                        <li><b>teroristi:</b>&nbsp;<a href="0doc/subiecte/baraj-liceu/enunt_teroristi.pdf">enunt</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/sol_teroristi.pdf">descriere solutie</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/surse_teroristi.zip">surse</a>&nbsp;|&nbsp;<a href="0doc/subiecte/baraj-liceu/teste_teroristi.zip">teste</a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<?php
    include_once("include/footer.php");
    ob_end_flush();
?>