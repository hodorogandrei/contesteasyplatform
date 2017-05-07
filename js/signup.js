$(function(){
    // Verificare nume utiliator
    $('#username').live({
        keyup: function(){
            $.post('async-db/checkUser.php', $("#register").serialize(), function(data) {
                $('#msg_username').html(data);
            });
        }
    });
    $('#username').change(function(){
        $.post('async-db/checkUser.php', $("#register").serialize(), function(data) {
            $('#msg_username').html(data);
        });
    });
    //Verificare adresa e-mail
    $('#email').live({
        keyup: function(){
            $.post('async-db/checkEmail.php', $("#register").serialize(), function(data) {
                $('#msg_email').html(data);
            });
        }
    });
    $('#email').change(function(){
        $.post('async-db/checkEmail.php', $("#register").serialize(), function(data) {
            $('#msg_email').html(data);
        });
    });
    //Verificare cnp
    $('#cnp').live({
        keyup: function(){
            $.post('async-db/checkCNP.php', $("#register").serialize(), function(data) {
                $('#msg_cnp').html(data);
            });
        }
    });
    $('#cnp').change(function(){
        $.post('async-db/checkCNP.php', $("#register").serialize(), function(data) {
            $('#msg_cnp').html(data);
        });
    });

    //valori originale campuri
    var field_values = {
        //id        :  value
        'username'  : 'username',
        'password'  : 'password',
        'cpassword' : 'password',
        'nume'  : 'nume',
        'prenume'  : 'prenume',
        'cnp'  : 'CNP',
        'email'  : 'email'
    };


    //inputfocus
    $('input#username').inputfocus({ value: field_values['username'] });
    $('input#password').inputfocus({ value: field_values['password'] });
    $('input#cpassword').inputfocus({ value: field_values['cpassword'] }); 
    $('input#prenume').inputfocus({ value: field_values['prenume'] });
    $('input#nume').inputfocus({ value: field_values['nume'] });
    $('input#email').inputfocus({ value: field_values['email'] }); 
    $('input#cnp').inputfocus({ value: field_values['cnp'] }); 




    //resetare bara pgores
    $('#progress').css('width','0');
    $('#progress_text').html('0% Completat');
    var invaliduser = 1;
    //primul pas
    $('form').submit(function(){ return false; });
    $('#submit_first').click(function(){
        //demarcare clase
        $('#first_step input').removeClass('error').removeClass('valid');

        //verificare campuri goale
        var fields = $('#first_step input[type=text], #first_step input[type=password]');
        var error = 0;
        fields.each(function(){
            var value = $(this).val();
            if( value.length<4 || value==field_values[$(this).attr('id')] ) {
                $(this).removeClass('valid');
                $(this).addClass('error');
                $(this).effect("shake", { times:3 }, 150);

                error++;
            } else {
                $(this).addClass('valid');
            }
        });        
        if($('#first_step input[type=text]').val()!='username' && $('#first_step input[type=text]').val().length>0)
        {
            $.post('async-db/checkUser.php', $("#register").serialize(), function(data) {
                if(data=='<img src="images/collapse.png" style="vertical-align: middle;"/>Nume de utilizator deja existent')
                    {
                    error++;
                    $('#msg_username').html(data);
                    $('#username').removeClass('valid');
                    $('#username').addClass('error');
                    $('#username').effect("shake", { times:3 }, 150);
                    invaliduser++;
                }
                else
                {
                    if(data=='<img src="images/tick.png" style="vertical-align: middle;" />Nume disponibil')
                    {
                        $('#username').addClass('valid');
                        invaliduser = 0;    
                    }
                }
            });
        }
        if(!error && !invaliduser) {
            if( $('#password').val() != $('#cpassword').val() ) {
                $('#first_step input[type=password]').each(function(){
                    $(this).removeClass('valid').addClass('error');
                    $(this).effect("shake", { times:3 }, 150);
                });

                return false;
            } else {   
                //actualizare bara progres
                $('#progress_text').html('33% Completat');
                $('#progress').css('width','113px');

                //efecte slide
                $('#first_step').slideUp();
                $('#second_step').slideDown();     
            }               
        } else return false;
    });

    var invalidaddr = 1;
    $('#submit_second').click(function(){
        //demarcare clase
        $('#second_step input').removeClass('error').removeClass('valid');

        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
        var fields = $('#second_step input[type=text]');
        var error = 0;
        fields.each(function(){
            $.post('async-db/checkEmail.php', $("#register").serialize(), function(data) {
                if(data=='<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;Adres&#259; deja existent&#259;')
                    {
                    error++;
                    $('#msg_email').html(data);
                    $('#email').removeClass('valid');
                    $('#email').addClass('error');
                    $('#email').effect("shake", { times:3 }, 150);
                    invalidaddr++;
                }
                else
                {
                    if(data=='<img src="images/tick.png" style="vertical-align: middle;"/>&nbsp;Adres&#259; disponibil&#259;')
                    {
                        $('#email').addClass('valid');
                        invalidaddr = 0;    
                    }
                }
            });
            var value = $(this).val();
            if( value.length<1 || value==field_values[$(this).attr('id')] || ( $(this).attr('id')=='email' && !emailPattern.test(value) ) || invalidaddr==1) {
                $(this).addClass('error');
                $(this).effect("shake", { times:3 }, 150);

                error++;
            } else {
                $(this).addClass('valid');
            }
        });
            
        
        if(!error && !invalidaddr) {
            //actualizare bara progres
            $('#progress_text').html('66% Completat');
            $('#progress').css('width','226px');

            //efecte slide
            $('#second_step').slideUp();
            $('#third_step').slideDown();     
        } else return false;

    });

    var invalidcnp = 1;
    $('#submit_third').click(function(){
        var error = 0;
        
        if($('#clasa option:selected').val().length<1)
            {
            error++;
            $('#clasa').removeClass('valid');
            $('#clasa').addClass('error');
            $('#msg_clasa').html('<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;Nicio clas&#259; selectat&#259;!');
            $('#clasa').effect("shake", { times:3 }, 150);
        }
        else
            {
            $('#clasa').addClass('valid');
            $('#msg_clasa').html('<img src="images/tick.png" />');
        }
        if($('#judet option:selected').val().length<1)
            {
            error++;
            $('#judet').removeClass('valid');
            $('#judet').addClass('error');
            $('#msg_judet').html('<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;Niciun jude&#355; selectat!');
            $('#judet').effect("shake", { times:3 }, 150);
        }
        else
            {
            $('#judet').addClass('valid');
            $('#msg_judet').html('<img src="images/tick.png" />');
        }
        
        var cnp = $('#cnp').val();
        if(cnp.length<1 || cnp=='CNP')
            {
            error++;
            $('#cnp').removeClass('valid');
            $('#cnp').addClass('error');
            $('#cnp').effect("shake", { times:3 }, 150); 
            $('#msg_cnp').html('<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;Introduce&#355;i un CNP!'); 
        } 
        else
        {
            $.post('async-db/checkCNP.php', $("#register").serialize(), function(data) {
                if(data=='<img src="images/collapse.png" style="vertical-align: middle;" />&nbsp;CNP invalid')
                    {
                    error++;
                    $('#msg_cnp').html(data);
                    $('#cnp').removeClass('valid');
                    $('#cnp').addClass('error');
                    $('#cnp').effect("shake", { times:3 }, 150);
                    invalidcnp++;
                }
                else
                {
                    if(data=='<img src="images/tick.png" style="vertical-align: middle;"/>&nbsp;CNP valid')
                    {
                        $('#cnp').addClass('valid');
                        invalidcnp = 0;    
                    }
                }
            });
        }
        if(!error && !invalidcnp) {
            //actualizare bara progres
            $('#progress_text').html('100% Completat');
            $('#progress').css('width','339px');

            //pregatire pentru pasul patru
            var fields = new Array(
            $('#username').val(),
            $('#email').val(),
            $('#nume').val() + ' ' + $('#prenume').val(),
            $('#clasa option:selected').text(),
            $('#judet option:selected').text(),
            $('#cnp').val()                       
            );
            var tr = $('#fourth_step tr');
            tr.each(function(){
//                            alert( fields[$(this).index()] )
                $(this).children('td:nth-child(2)').html(fields[$(this).index()]);
            });

            //efecte slide
            $('#third_step').slideUp();
            $('#fourth_step').slideDown();
        } else return false;            
    });


    $('#submit_fourth').click(function(){
        //trimiterea informatiilor catre server
        $.post('async-db/registration.php', $("#register").serialize(), function(data) {
            $('#fourth_step').html(data);
        });
    });

});