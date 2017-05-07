[
<?php
    require_once("../../include/config.php");
    
    $sql = "SELECT * FROM `harta`";
    $result = mysql_query($sql);
    $results = mysql_num_rows($result);
    
    $nr = 0;
    while($row = mysql_fetch_object($result))
    {
        $nr++;
        if($nr == $results)
            echo '
            { "top": '.$row -> top.', 
            "left": '.$row -> left.', 
            "width": '.$row -> width.', 
            "height": '.$row -> height.', 
            "text": "'.$row -> text.'", 
            "id": "'.$row -> idd.'", 
            "editable": true }';
            
        else
            echo '
            { "top": '.$row -> top.', 
            "left": '.$row -> left.', 
            "width": '.$row -> width.', 
            "height": '.$row -> height.', 
            "text": "'.$row -> text.'", 
            "id": "'.$row -> idd.'", 
            "editable": true },';
    } 
?>
]