jQuery(document).ready(function($) {

    $('a.delete-link').click(function (e) {
        e.preventDefault();
        var del_id = $(this).attr("id");
        var currdiv = $(this);
        confirm("Sunteti sigur(a) ca doriti sa stergeti acest participant?", function () {
            $.ajax({
                url: 'administrare-participanti.php?sterge='+del_id,
                dataType: 'json'
            });
            currdiv.closest('tr').find('td').fadeOut('slow', 
            function(){ 
                currdiv.parents('tr:first').remove();                    
            });
        });
    });

    $.ajaxSetup ({  
        cache: false
    });  
    var ajax_load = "C&#259;utare &icirc;n curs, v&#259; rug&#259;m a&#351;tepta&#355;i...";  
    var loadUrl = "async-db/get_part_admin.php"; 
    $("#displaypart").click(function(){  
        $("#elevi_content")  
        .html(ajax_load)  
        .load(loadUrl, {clasa: $("#clasa").val(), judet: $("#judet").val(), sort: $("#sort").val()});  
    });

    $("#validate").validationEngine();

    $.fn.autosugguest({
        className: 'ausu-suggest',
        methodType: 'POST',
        minChars: 2,
        dataFile: 'async-db/suggest.php'
    });

});

//INLINE TABLE

$(".edit_tr").click(function()
{
    var ID=$(this).attr('id');
    $("#numele_"+ID).hide();
    $("#clasa_"+ID).hide();
    $("#judet_"+ID).hide();
    $("#unitatea_"+ID).hide();
    $("#cazare_"+ID).hide();
    $("#concurs_"+ID).hide();

    $("#numele_input_"+ID).show();
    $("#clasa_input_"+ID).show();
    $("#judet_input_"+ID).show();
    $("#unitatea_input_"+ID).show();
    $("#cazare_input_"+ID).show();
    $("#concurs_input_"+ID).show();
}).change(function()
{
    var ID=$(this).attr('id');
    var numele=$("#numele_input_"+ID).val();
    var clasa=$("#clasa_input_"+ID).val();
    var judet=$("#judet_input_"+ID).val();
    var judet2 = $("#judet_input_"+ID+" option:selected").text();
    var unitatea=$("#unitatea_input_"+ID).val();
    var cazare=$("#cazare_input_"+ID).val();
    var concurs=$("#concurs_input_"+ID).val();

    var dataString = 'id='+ ID 
    +'&numele='+ numele
    +'&clasa='+ clasa
    +'&judet='+ judet 
    +'&unitatea=' + unitatea 
    +'&cazare=' + cazare 
    +'&concurs='+ concurs;

    if(numele.length>0 && 
    clasa.length>0 && 
    judet.length>0 && 
    unitatea.length>0 && 
    cazare.length>0 && 
    concurs.length>0)
        {
        $.ajax({
            type: "POST",
            url: "async-db/update-participanti.php",
            data: dataString,
            cache: false,
            success: function(html)
            {
                $("#numele_"+ID).html(numele);
                $("#clasa_"+ID).html(clasa);
                $("#judet_"+ID).html(judet2);
                $("#unitatea_"+ID).html(unitatea);
                $("#cazare_"+ID).html(cazare);
                $("#concurs_"+ID).html(concurs);
            }
        });
    }
    else
        {
        alert('Va rugam introduceti o valoare.');
    }

});

$(".editbox").mouseup(function()
{
    return false
});
                       
$(document).mouseup(function()
{
    $(".editbox").hide();
    $(".text").show();
}); 
