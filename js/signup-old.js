var exists;

$(document).ready(function(){
    // Smart Wizard     	
    $('#wizard').smartWizard({transitionEffect:'slideleft',onLeaveStep:leaveAStepCallback,onFinish:onFinishCallback,enableFinishButton:true});

    function leaveAStepCallback(obj){
        var step_num= obj.attr('rel');
        return validateSteps(step_num);
    }

    function onFinishCallback(){
        if(validateAllSteps()){
            $('form').submit();
        }
    }

    // Verificare nume utiliator
    $('#username').live({

        keyup: function(){
            $.post('async-db/checkUser.php', $("#register").serialize(), function(data) {
                $('#msg_username').html(data);
            });
        }

    });

    $('#email').live({

        keyup: function(){
            $.post('async-db/checkEmail.php', $("#register").serialize(), function(data) {
                $('#msg_email').html(data);
            });
        }

    });

    $('#password').pstrength();

});

function validateStep1(){
    var isValid = true; 
    // Validate Username
    var un = $('#username').val();
    if(!un && un.length <= 0){
        isValid = false;
        $('#msg_username').html('<img src="images/collapse.png" />&nbsp;V&#259; rug&#259;m introduce&#355;i un nume de utilizator').show();
    }else{
        isValid = true;
        $.post('async-db/checkUser.php', $("#register").serialize(), function(datad) {
            exists = datad;
        });
        if(exists!='<img src="images/tick.png" />&nbsp;Nume disponibil')
            {
            isValid = false;
        }
    }
    // validate password
    var pw = $('#password').val();
    if(!pw && pw.length <= 0){
        isValid = false;
        $('#msg_password').html('<img src="images/collapse.png" />&nbsp;V&#259; rug&#259;m introduce&#355;i parola').show();         
    }else{
        $('#msg_password').html('').hide();
    }

    // validate confirm password
    var cpw = $('#cpassword').val();
    if(!cpw && cpw.length <= 0){
        isValid = false;
        $('#msg_cpassword').html('<img src="images/collapse.png" />&nbsp;Va rugam confirmati parola').show();         
    }else{
        $('#msg_cpassword').html('').hide();
    }  

    // validate password match
    if(pw && pw.length > 0 && cpw && cpw.length > 0){
        if(pw != cpw){
            isValid = false;
            $('#msg_cpassword').html('<img src="images/collapse.png" />&nbsp;Parolele nu se potrivesc').show();            
        }else{
            $('#msg_cpassword').html('').hide();
        }
    }
    return isValid;
}

function validateStep2(){
    var isValid = true; 
    // Validate Username
    var un = $('#username').val();
    if(!un && un.length <= 0){
        isValid = false;
        $('#msg_username').html('<img src="images/collapse.png" />&nbsp;V&#259; rug&#259;m introduce&#355;i un nume de utilizator').show();
    }
    return isValid;
}

function validateStep3(){
    var isValid = true;    
    //validate email  email
    var email = $('#email').val();
    if(email.length > 0){
        if(!isValidEmailAddress(email)){
            isValid = false;
            $('#msg_email').html('<img src="images/collapse.png" />&nbsp;Adres&#259; invalid&#259;').show();           
        }else{
            $('#msg_email').html('').hide();
        }
    }else{
        isValid = false;
        $('#msg_email').html('<img src="images/collapse.png" />&nbsp;V&#259; rug&#259;m introduce&#355;i o adres&#259; de email').show();
    }       
    return isValid;
}

// Email Validation
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
} 

function validateAllSteps(){
    var isStepValid = true;

    if(validateStep1() == false){
        isStepValid = false;
        $('#wizard').smartWizard('setError',{stepnum:1,iserror:true});         
    }else{
        $('#wizard').smartWizard('setError',{stepnum:1,iserror:false});
    }

    if(validateStep2() == false){
        isStepValid = false;
        $('#wizard').smartWizard('setError',{stepnum:2,iserror:true});         
    }else{
        $('#wizard').smartWizard('setError',{stepnum:2,iserror:false});
    }

    if(validateStep3() == false){
        isStepValid = false;
        $('#wizard').smartWizard('setError',{stepnum:3,iserror:true});         
    }else{
        $('#wizard').smartWizard('setError',{stepnum:3,iserror:false});
    }

    if(!isStepValid){
        $('#wizard').smartWizard('showMessage','Corectati erorile si continuati');
    }

    return isStepValid;
} 	


function validateSteps(step){
    var isStepValid = true;
    // validate step 1
    if(step == 1){
        if(validateStep1() == false ){
            isStepValid = false; 
            $('#wizard').smartWizard('showMessage','Corectati erorile de la pasul '+step+ '.');
            $('#wizard').smartWizard('setError',{stepnum:step,iserror:true});
        }else{
            $('#wizard').smartWizard('setError',{stepnum:step,iserror:false});
        }
    }

    // validate step3
    if(step == 3){
        if(validateStep3() == false ){
            isStepValid = false; 
            $('#wizard').smartWizard('showMessage','Va rugam corectati erorile.');
            $('#wizard').smartWizard('setError',{stepnum:step,iserror:true});         
        }else{
            $('#wizard').smartWizard('setError',{stepnum:step,iserror:false});
        }
    }

    return isStepValid;
}

	
	