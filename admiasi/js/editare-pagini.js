
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
$(document).ready(function(){

$('#validate').validationEngine();

$('a.delete-link').click(function (e) {
	e.preventDefault();
	var del_id = $(this).attr("id");
	var currdiv = $(this);
	confirm("Sunteti sigur(a) ca doriti sa stergeti definitiv aceasta pagina?", function () {
		$.ajax({
			url: 'editare-pagini.php?sterge='+del_id,
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
	confirm("Sunteti sigur(a) ca doriti sa stergeti definitiv paginile selectate?", function () {
		var data = { 'checkbox[]' : []};
		$(":checked").each(function() {
		  data['checkbox[]'].push($(this).val());
		  $(this).closest('tr').find('td').fadeOut('slow', 
			function(){ 
				$(this).parents('tr:first').remove();                    
			});
		});
		$.post("async-db/delete-pagini.php", data, function(data){
            if(data=='gol')
                window.location = 'editare-pagini.php';
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
  $('#usrfile').keyup(function(){
    $('#admfile').val('editare-' + $(this).val());
  });
  $.validationEngine.settings={};
  $("#submit").click(function(){
	$(".formError").hide();
  });
  $("#validate").validationEngine();
   $("#mytable").tablesorter({  
        headers: { 
			4: { 
                sorter: false 
            },
			0: { 
                sorter: false 
            },
        } 
    }); 
});