ts = ts - 2678400000;
if((new Date()) > ts){
	ts = (new Date()).getTime() - 10*24*60*60*1000;
	newYear = false;
}
jQuery(document).ready(function($) {

function changeFooterPosition() {   
  $('#warning').css('top', window.innerHeight + window.scrollY - 50 + "px");
}

$(document).bind('scroll', function() {
  changeFooterPosition();
});

$(function(){
    // setup common ajax setting
    $.ajaxSetup({ 
        url: 'live_backend.php', 
        type: 'POST',
        async: false,
        timeout: 500
    });

    // call inlineEdit
    $('.editable').inlineEdit({
        value: $.ajax({ data: { 'action': 'get' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save', 'value': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.editable2').inlineEdit({
        value: $.ajax({ data: { 'action': 'get2' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save2', 'value2': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.begdate-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-begdate' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-begdate', 'value-begdate': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.enddate-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-enddate' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-enddate', 'value-enddate': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.foot-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-foot' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-foot', 'value-foot': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.nwstxt-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-nwstxt' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-nwstxt', 'value-nwstxt': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.toolstxt-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-toolstxt' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-toolstxt', 'value-toolstxt': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
	
	$('.partpages-edit').inlineEdit({
        value: $.ajax({ data: { 'action': 'get-partpages' } }).responseText,
        save: function(event, data) {
            var html = $.ajax({
                data: { 'action': 'save-partpages', 'value-partpages': data.value }
            }).responseText;
            
            return html === 'OK' ? true : false;
        }
    });
});


$('.editable').inlineEdit();
$('.editable2').inlineEdit();
$('.begdate-edit').inlineEdit();
$('.enddate-edit').inlineEdit();
$('.foot-edit').inlineEdit();
$('.toolstxt-edit').inlineEdit();
$('.nwstxt-edit').inlineEdit();
$('.partpages-edit').inlineEdit();

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
  var originalFontSize = $('html').css('font-size');
  $(".resetFont").click(function(){
  $('html').css('font-size', originalFontSize);
  });
  // Increase Font Size
  $(".increaseFont").click(function(){
  	var currentFontSize = $('html').css('font-size');
 	var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*1.2;
	$('html').css('font-size', newFontSize);
	return false;
  });
  // Decrease Font Size
  $(".decreaseFont").click(function(){
  	var currentFontSize = $('#continut2').css('font-size');
 	var currentFontSizeNum = parseFloat(currentFontSize, 10);
    var newFontSize = currentFontSizeNum*0.8;
	$('#continut2').css('font-size', newFontSize);
	return false;
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
});