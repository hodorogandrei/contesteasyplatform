<?php
    require_once('../include/config.php');
    error_reporting(0);
    if($_POST)
    {
        $checkbox = $_POST['checkbox'];
        $countCheck = count($_POST['checkbox']);	

        for($i=0;$i<$count;$i++)
        {
            $del_id = $checkbox[$i];
            $sql = "SELECT * FROM stiri WHERE id='$del_id'";
            $result = mysql_query($sql);

            $row=mysql_fetch_object($result);
            $delfile = $row->picture;
            if($delfile!='newsimg/')
                unlink('../../'.$delfile.'');
        }

        $sql = "DELETE FROM stiri WHERE id IN (".implode(',',$_POST['checkbox']).")";
        mysql_query($sql);

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
        $sql = 'SELECT * FROM stiri order by id desc limit 0,20';
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

        $fisier = fopen('../../rss.xml', 'w') or die("Eroare la deschiderea fisierului rss.xml.");
        fwrite($fisier, $rss);
        fclose($fisier);
        
        $sql = 'SELECT * FROM `stiri`';
        if(mysql_num_rows(mysql_query($sql))==0)
            echo 'gol';
    }
?>