$(document).ready(function(){
    $('#bgadmin').fadeIn(1500);
    $('#submit').click(function(){

        $.ajax({
            url: "login.php",
            type: "POST",
            data: $('#loginform').serialize(), 
            cache: false,
            success: function (html) {             
                if (html==1) {                 
                    window.location='index.php';
                } 
                else {
                    if(html=='Cod CAPTCHA incorect!') {
                        $(".shake").effect("shake", { times:4 }, 300);                                        
                        $("#mesaj").html("<img class=\"midalign\" src=\"images/error.png\" />Cod CAPTCHA incorect!");
                    }
                    else {
                        if(html=='Contul nu a fost aprobat!') {
                            $(".shake").effect("shake", { times:4 }, 300);                                        
                            $("#mesaj").html("<img class=\"midalign\" src=\"images/error.png\" />Contul nu a fost aprobat!");
                        }
                        else
                            {
                            $(".shake").effect("shake", { times:4 }, 300);
                            $("#mesaj").html("<img class=\"midalign\" src=\"images/error.png\" />Date de autentificare incorecte!");  
                        }
                    }
                }             
            }      
        });
    });
});