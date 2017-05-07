jQuery(document).ready(function($) {
$.ajaxSetup ({  
        cache: false
    });  
var ajax_load = "C&#259;utare &icirc;n curs, v&#259; rug&#259;m a&#351;tepta&#355;i...";  

var loadUrl = "async-db/get_rezultate.php"; 
var loadUrl2 = "async-db/get_part.php";   
$("#displayrez").click(function(){  
    $("#elevi_content")  
        .html(ajax_load)  
        .load(loadUrl, {clasa: $("#clasa").val(), judet: $("#judet").val(), sort: $("#sort").val()});  
});

$("#displaypart").click(function(){  
    $("#elevi_content")  
        .html(ajax_load)  
        .load(loadUrl2, {clasa: $("#clasa").val(), judet: $("#judet").val(), sort: $("#sort").val()});  
});

});