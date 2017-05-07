$(function() {
$('.passmet').pstrength();
$("#submit").click(function(){
        $(".error").hide();
        var hasError = false;
        var passwordVal = $("#password").val();
        var checkVal = $("#password-check").val();
        if (passwordVal == '') {
            $("#password").after('<span class="error">&nbsp;V&#259; rug&#259;m introduce&#355;i o parola!</span>');
            hasError = true;
        } else if (checkVal == '') {
            $("#password-check").after('<span class="error">&nbsp;V&#259; rug&#259;m confirma&#355;i parola!</span>');
            hasError = true;
        } else if (passwordVal != checkVal ) {
            $("#password-check").after('<span class="error">&nbsp;Parolele nu se potrivesc.</span>');
            hasError = true;
        }
        if(hasError == true) {return false;}
    });
});