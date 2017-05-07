function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
    if(!document.forms[FormName])
        return;
    var objCheckBoxes = document.forms[FormName].elements[FieldName];
    if(!objCheckBoxes)
        return;
    var countCheckBoxes = objCheckBoxes.length;
    if(!countCheckBoxes)
        objCheckBoxes.checked = CheckValue;
    else
        // set the check value for all check boxes
        for(var i = 0; i < countCheckBoxes; i++)
        objCheckBoxes[i].checked = CheckValue;
}

function $import(src){
    var scriptElem = document.createElement('script');
    scriptElem.setAttribute('src',src);
    scriptElem.setAttribute('type','text/javascript');
    document.getElementsByTagName('head')[0].appendChild(scriptElem);
}

var delay = 2;
setTimeout("loadExtraFiles();", delay * 1000);

function loadExtraFiles()
{
    $import("highslide/highslide.js");
    $import("highslide/highslide.config.js"); 
    $import("js/jquery.simplemodal.js");
}


var lastChecked = null;
$(document).ready(function() {
    $("#gallery").dragsort({ dragSelector: "div", dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

    function saveOrder() {
        var data = $("#gallery li").map(function() { return $(this).data("itemid"); }).get();
        $.post("async-db/update-galerie.php", { "ids[]": data });
    };

    $('a.delete-link').click(function (e) {
        e.preventDefault();
        var del_id = $(this).attr("id");
        var currdiv = $(this);
        confirm("Sunteti sigur(a) ca doriti sa stergeti imaginea selectata?", function () {
            $.ajax({
                url: 'editare-galerie.php?sterge='+del_id,
                dataType: 'json'
            });
            currdiv.closest('tr').find('td').fadeOut('slow', 
            function(){ 
                currdiv.parents('tr:first').remove();                    
            });
            $('li#'+del_id).fadeOut('slow');

        });
    });


    $('input.delete-link-more').click(function (e) {
        e.preventDefault();
        confirm("Sunteti sigur(a) ca doriti sa stergeti imaginile selectate?", function () {
            var data = { 'checkbox[]' : []};
            $(":checked").each(function() {
                data['checkbox[]'].push($(this).val());
                $(this).closest('tr').find('td').fadeOut('slow', 
                function(){ 
                    $(this).parents('tr:first').remove();                    
                });
                $('li#'+ $(this).val()).fadeOut('slow');
            });
            $.post("async-db/update-galerie.php", data, function(data){
                if(data=='gol')
                    window.location = 'editare-galerie.php';
            });
        });
    });

    var $chkboxes = $('.chkbox');
    $chkboxes.click(function(event) {
        if(!lastChecked) {
            lastChecked = this;
            return;
        }

        if(event.shiftKey) {
            var start = $chkboxes.index(this);
            var end = $chkboxes.index(lastChecked);

            $chkboxes.slice(Math.min(start,end), Math.max(start,end)+ 1).attr('checked', lastChecked.checked);

        }

        lastChecked = this;
    });
    $("#mytable").tablesorter({  
        headers: { 
            0: { 
                sorter: false 
            }, 
            4: { 
                sorter: false 
            },
            6: { 
                sorter: false 
            },
        } 
    }); 
});
