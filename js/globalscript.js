ts = ts - 2678400000;
if((new Date()) > ts){
    // The new year is here! Count towards something else.
    // Notice the *1000 at the end - time must be in milliseconds
    ts = (new Date()).getTime() - 10*24*60*60*1000;
    newYear = false;
}

/*function $import(src){
var scriptElem = document.createElement('script');
scriptElem.setAttribute('src',src);
scriptElem.setAttribute('type','text/javascript');
document.getElementsByTagName('head')[0].appendChild(scriptElem);
}

var delay = 2;
setTimeout("loadExtraFiles();", delay * 1000);

function loadExtraFiles()
{
$import("js/facebook.js");
}    */

jQuery(document).ready(function($) {

    function preLoad() {
        $("#welcomeline").addClass("hiddendiv");
    }

    function loaded() {
        $("#welcomeline").removeClass("hiddendiv");
        $('div#preLoader').fadeOut(500);
    }

    window.onload=loaded;

    $('#welcomeline ul').roundabout();
    $().UItoTop({ easingType: 'easeOutQuart' });
    $(".news_text").hide();
    $("span.trigger").click(function(){
        $(this).toggleClass("active").next().slideToggle("slow");
    });

    $('#weather').weatherfeed(['' + wcity + '']);

    $('#countdown').countdown({
        timestamp	: ts,
        callback	: function(days, hours, minutes, seconds){
        }
    });

    // Reset Font Size
    var originalFontSize = $('#continut2').css('font-size');
    $(".resetFont").click(function(){
        $('#continut2').css('font-size', originalFontSize);
    });
    // Increase Font Size
    $(".zoomin").click(function(){
        var currentFontSize = $('#continut2').css('font-size');
        var currentFontSizeNum = parseFloat(currentFontSize, 10);
        var newFontSize = currentFontSizeNum*1.2;
        $('#continut2').css('font-size', newFontSize);
        return false;
    });
    // Decrease Font Size
    $(".zoomout").click(function(){
        var currentFontSize = $('#continut2').css('font-size');
        var currentFontSizeNum = parseFloat(currentFontSize, 10);
        var newFontSize = currentFontSizeNum*0.8;
        $('#continut2').css('font-size', newFontSize);
        return false;
    });
    $('#subscribenws').click(function(){
        $.post('newsletter.php', $("#newsletter").serialize(), function(data) {
            $('#msg_newsletter').html(data);
        });
    });
});