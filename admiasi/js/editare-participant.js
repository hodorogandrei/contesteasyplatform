jQuery(document).ready(function($) {
	$('.delete-link').click(function (e) {
		e.preventDefault();
		var targetUrl = $(this).attr("href");
		confirm("Sunteti sigur(a) ca doriti sa stergeti acest participant?", function () {
			window.location.href = targetUrl;
		});
	});
	$("#validate").validationEngine();
});