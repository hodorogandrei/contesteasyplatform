<?php
    $sql = "SELECT * FROM `general` WHERE id=1";
    $result = mysql_query($sql);
    while($rand = mysql_fetch_object($result))
    {
        $compname = $rand -> name;
        $compaddr = $rand -> compaddr;
    }
                                                       
    $rss = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" xmlns:tagcontesteasyplatform="'.$compaddr.'" >
    <channel>
    <title>'.$compname.' RSS Feed</title>
    <link>'.$compaddr.'</link>
    <description>'.$compname.' RSS Feed</description>
    ';
    $sql = 'SELECT * FROM `stiri` ORDER BY id DESC LIMIT 0,20';
    $result = mysql_query($sql);
    while($rand = mysql_fetch_object($result))
    {
        $rss .='<item>
        <title>'.$rand -> title.'</title>
        <link>'.$compaddr.'stire_'.$rand -> id.'_'.$rand -> permalink.'.html</link>
        <description>'.$rand -> title.'</description>
        </item>';
    }
    $rss .= '</channel>
    </rss>';

    $fisier = fopen('../rss.xml', 'w') or die("Eroare la deschiderea fisierului rss.xml.");
    fwrite($fisier, $rss);
    fclose($fisier);
?>