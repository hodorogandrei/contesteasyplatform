$(document).ready(function() { 
	$('a.delete-link').click(function (e) {
		e.preventDefault();
		var del_id = $(this).attr("id");
		var currdiv = $(this);
		confirm("Sunteti sigur(a) ca doriti sa stergeti acest administrator?", function () {
			$.ajax({
				url: 'administratori.php?sterge='+del_id,
				dataType: 'json'
			});
			currdiv.closest('tr').find('td').fadeOut('slow', 
			function(){ 
				currdiv.parents('tr:first').remove();                    
			});
		});
	});
	
    $("#mytable").tablesorter({  
        headers: { 
			5: { 
                sorter: false 
            },
            3: { sorter:'customDate' },
        } 
    }); 
	$('.passmet').pstrength();
	$('input[type="radio"]').click(function(){
		if ($(this).hasClass('globclick')) {
		  $(".otherperm").slideToggle(1000);
		} else if ($(this).hasClass('globclick2')) {
		  $(".otherperm").slideToggle(1000);
		  $('.otherperm input[value="1"]').attr('checked', false);
		  $('.otherperm input[value="0"]').attr('checked', true);
		}
	});
	
  $("#validate").validationEngine();
});