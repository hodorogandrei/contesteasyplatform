$(document).ready(function() {
    $(':input').one('change', function() {
        window.onbeforeunload = function() {
            return 'Modificarile operate nu vor fi salvate! Sunteti sigur(a) ca doriti sa parasiti aceasta pagina?';
        }
    });

    $('.no-warn-validate').click(function() {
        if (Page_ClientValidate == null || Page_ClientValidate()) { removeCheck(); }
    });

    $('.no-warn').click(function() { window.onbeforeunload = null; });
});