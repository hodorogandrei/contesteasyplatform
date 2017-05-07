function loadElevi2(){
var content = $('elevi_content2');
content.update("Cautare in curs. Va rugam asteptati ...");
new Ajax.Request('get_part_admin.php', {
method: 'get',
parameters: 'judet='+$F("judet")+'&clasa='+$F("clasa")+'&sort='+$F("sort"),
onSuccess: function(transport) {
	var content = $('elevi_content2');
	if (transport.responseText.match("EROARE"))
	  content.update('Eroare');
	else {
	  content.update(transport.responseText);
	  }
  }
});
} 