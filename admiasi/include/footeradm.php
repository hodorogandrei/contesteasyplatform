<?php
    $doSQL = 'SELECT * FROM `general` WHERE id=1'; 
    $rezultat = mysql_query($doSQL);
    while($rand = mysql_fetch_array($rezultat))
    {
        $foottitle = $rand['foottitle'];
    }

    //Chat, doar pentru utilizatorii autentificati
    if($_SESSION['logat'] == 'Da')
    {
    ?>


                            <script type="text/javascript" src="js/jquery.min-164.js"></script>
                            <script type="text/javascript" src="js/effect.js"></script>
                            <script type="text/javascript" src="js/onlinewidget.js"></script>
                            <script type="text/javascript" src="js/chat.js"></script>
                            <div class="onlineWidget">
                                <div class="panel">
                                    <?php 
                                        $sql = "SELECT * FROM `usrs2012` WHERE online='1' AND username!='".$_SESSION['nume']."'";
                                        $result = mysql_query($sql);
                                        $nr = mysql_num_rows($result);
                                        if($nr > 0)
                                        {
                                            echo '<b>Discut&#259; cu:</b><br/><br/>';
                                            while($row = mysql_fetch_object($result))
                                            {
                                                echo "<a href=\"javascript:void(0)\" onclick=\"javascript:chatWith('".$row -> username."')\"><i>".$row -> username."</i></a><br/>";
                                            }
                                        }

                                        else
                                            echo 'Nu exist&#259; al&#355;i administratori online.';

                                    ?>
                                </div>

                                <div class="count"><?php echo $nr;?></div>
                                <div class="label">admini on</div>
                                <?php if($nr > 0) 
                                        echo '<div class="arrow"></div>'; 
                                    else
                                        echo '<div class="arrow_off"></div>';
                                ?>
                            </div>

                            <?php } ?>

                            <div id="footerbg">
                                <div id="footercontent">
                                    <div id="footertext">
                                        <center>
                                            Copyright&copy; <?php echo $foottitle;?>. <br/>Based on ContestEasyPlatform&reg; by <a href="http://www.andreihodorog.com/" target="_blank">Andrei Hodorog</a> .<br/>
                                        </center>
                                    </div>

                                </div>
                            </div>
        