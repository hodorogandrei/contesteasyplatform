<?php
include('dbconnect.php');

// fetch all tags
$sql = "SELECT * FROM image_tag WHERE pic_id = '".$pic_id."'";
$qry = mysql_query($sql);
$rs = mysql_fetch_array($qry);

if ($rs){
  do{
    echo '<div class="tagview" style="left:'.$rs['pic_x'].'px;top:'.$rs['pic_y'].'px;" id="view_'.$rs['id'].'"></div>';
  }while($rs = mysql_fetch_array($qry));
}

?>