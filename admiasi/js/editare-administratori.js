$(function() {
$('.passmet').pstrength();
$("#validate").validationEngine();
$('input[type="radio"]').click(function(){
    if ($(this).hasClass('globclick')) {
      $(this).parents('form').children(".otherperm").show('slow');
    } else if ($(this).hasClass('globclick2')) {
      $(this).parents('form').children(".otherperm").hide('slow');
	  $('.otherperm input[value="1"]').attr('checked', false);
	  $('.otherperm input[value="0"]').attr('checked', true);
    }
});
});