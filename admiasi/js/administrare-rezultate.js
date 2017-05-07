jQuery(document).ready(function($) {

    $('a.delete-link').click(function (e) {
        e.preventDefault();
        var del_id = $(this).attr("id");
        var currdiv = $(this);
        confirm("Sunteti sigur(a) ca doriti sa stergeti acest participant?", function () {
            $.ajax({
                url: 'administrare-rezultate.php?sterge='+del_id,
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
    var loadUrl = "async-db/get_rezultate_admin.php"; 

    $("#displayrez").click(function(){  
        $("#elevi_content")  
        .html(ajax_load)  
        .load(loadUrl, {clasa: $("#clasa").val(), judet: $("#judet").val(), sort: $("#sort").val()});  
    });

    $("#validate").validationEngine();

    $.fn.autosugguest({
        className: 'ausu-suggest',
        methodType: 'POST',
        minChars: 2,
        dataFile: 'async-db/suggest2.php'
    });
});


//INLINE TABLE

$(".edit_tr").click(function()
{
    var ID=$(this).attr('id');
    $("#numele_"+ID).hide();
    $("#clasa_"+ID).hide();
    $("#judet_"+ID).hide();
    $("#total_"+ID).hide();
    $("#observatii_"+ID).hide();
    $("#premiu_"+ID).hide();
    $("#medalie_"+ID).hide();

    $("#numele_input_"+ID).show();
    $("#clasa_input_"+ID).show();
    $("#judet_input_"+ID).show();
    $("#total_input_"+ID).show();
    $("#observatii_input_"+ID).show();
    $("#premiu_input_"+ID).show();
    $("#medalie_input_"+ID).show();
}).change(function()
{
    var ID=$(this).attr('id');
    var numele=$("#numele_input_"+ID).val();
    var clasa=$("#clasa_input_"+ID).val();
    var judet=$("#judet_input_"+ID).val();
	var judet2 = $("#judet_input_"+ID+" option:selected").text();
    var total=$("#total_input_"+ID).val();
    var observatii=$("#observatii_input_"+ID).val();
    var premiu=$("#premiu_input_"+ID).val();
    var medalie=$("#medalie_input_"+ID).val();

    var dataString = 'id='+ ID 
    +'&numele='+ numele
    +'&clasa='+ clasa
    +'&judet='+ judet 
    +'&total=' + total 
    +'&observatii=' + observatii 
    +'&premiu=' + premiu 
    +'&medalie='+ medalie;
	
	if(numele.length>0 && 
    clasa.length>0 && 
    judet.length>0) 
    {
        $.ajax({
            type: "POST",
            url: "async-db/update-rezultate.php",
            data: dataString,
            cache: false,
            success: function(html)
            {
                $("#numele_"+ID).html(numele);
                $("#clasa_"+ID).html(clasa);
                $("#judet_"+ID).html(judet2);
                $("#total_"+ID).html(total);
                $("#observatii_"+ID).html(observatii);
                $("#premiu_"+ID).html(premiu);
                $("#medalie_"+ID).html(medalie);
            }
        });
    }
    else
    {
        alert('Campurile aferente numelui, clasei si judetului sunt obligatorii.'); 
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
