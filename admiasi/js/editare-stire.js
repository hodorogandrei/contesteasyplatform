$('a.delete-link').click(function (e) {
	e.preventDefault();
	var targetUrl = $(this).attr("href");
	confirm("Sunteti sigur(a) ca doriti sa stergeti imaginea asociata acestei stiri?", function () {
		window.location.href = targetUrl;
	});
});


$('a.reset-link').click(function (e) {
	e.preventDefault();
	var targetUrl = $(this).attr("href");
	confirm("Sunteti sigur(a) ca doriti sa resetati numarul de vizualizari aferent acestei stiri?", function () {
		window.location.href = targetUrl;
	});
});


$("#validate").validationEngine();