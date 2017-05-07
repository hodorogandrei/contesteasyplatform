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

var lastChecked = null;
$(document).ready(function() { 

    $('a.delete-link').click(function (e) {
        e.preventDefault();
        var del_id = $(this).attr("id");
        var currdiv = $(this);
        confirm("Sunteti sigur(a) ca doriti sa stergeti aceasta stire si imaginea asociata acesteia (daca exista)?", function () {
            $.ajax({
                url: 'administrare-stiri.php?sterge='+del_id,
                dataType: 'json'
            });
            currdiv.closest('tr').find('td').fadeOut('slow', 
            function(){ 
                currdiv.parents('tr:first').remove();                    
            });
        });
    });

    $('input.delete-link-more').click(function (e) {
        e.preventDefault();
        confirm("Sunteti sigur(a) ca doriti sa stergeti stirile selectate si imaginile asociate acestora (daca exista)?", function () {
            var data = { 'checkbox[]' : []};
            $(":checked").each(function() {
                data['checkbox[]'].push($(this).val());
                $(this).parent().parent().fadeOut('slow');
            });
            $.post("async-db/delete-stiri.php", data, function(data){
                if(data=='gol')
                    window.location = 'administrare-stiri.php';
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
            5: { 
                sorter: false 
            },
        } 
    })
    .tablesorterPager({container: $("#pager"), positionFixed: false });
});