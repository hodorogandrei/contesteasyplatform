$(document).ready(function() { 
    $('a.delete-link').click(function (e) {
        e.preventDefault();
        var targetUrl = $(this).attr("href");
        confirm("Sunteti sigur(a) ca doriti sa goliti arhiva chat-ului?", function () {
            window.location.href = targetUrl;
        });
    });

    $("table.tablesorter tr:nth-child(even)").addClass("part_tr_gri");
    $("table.tablesorter tr:nth-child(odd)").addClass("part_tr");
    $("#mytable")
    .tablesorter({ widthFixed: true})
    .tablesorterPager({container: $("#pager"), positionFixed: false }); 
});