function loadElevi(){
var content = $('elevi_content');
content.update("Cautare in curs. Va rugam asteptati ...");
new Ajax.Request('get_rezultate_admin.php', {
method: 'get',
parameters: 'judet='+$F("judet")+'&clasa='+$F("clasa")+'&sort='+$F("sort"),
onSuccess: function(transport) {
	var content = $('elevi_content');
	if (transport.responseText.match("EROARE"))
	  content.update('Eroare');
	else {
	  content.update(transport.responseText);
	  }
  }
});
}