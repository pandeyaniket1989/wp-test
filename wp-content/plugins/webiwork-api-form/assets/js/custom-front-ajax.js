jQuery( function() {
    if(jQuery( "#expiration_date" ).length > 0)
    {
        jQuery( "#expiration_date" ).datepicker({
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            changeYear: true, 
        });
    }
});
jQuery(document).ready(function(){ 


    var numberReg = /^[0-9]+$/;

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    var passWordReg = /^[a-zA-Z0-9]{6,15}$/;
    var passWordReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,15}$/;
 
    // Australian phone number regex pattern
    var australianRegex = /^(?:\+61|0)[2-478](?:[ -]?[0-9]){8}$/; 

    var passportVali = /^(?!^0+$)[a-zA-Z0-9]{3,20}$/; 
    var passportVali = /^[A-Za-z]{1,2}[0-9]{7}$/; 

    var drivRegex = /^[A-Za-z0-9]{8,11}$/;

    var companuRegex = /^.{2,50}$/;

    var companuRegex2 = /^.{2,30}$/;

    var addRegex = /^.{2,250}$/;

    var currentRequest = null;  

    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.pdf)$/i;

    jQuery(document).on('submit', '#ccpc_custom_form', function(e)

    {   
        e.preventDefault();  

        var company_name = jQuery('#company_name').val();

        var contact_name = jQuery('#contact_name').val(); 

        var mobile_number = jQuery('#mobile_number').val();

        var email = jQuery('#bb-email').val();

        var password = jQuery('#password').val(); 

        var address = jQuery('#address').val(); 

        var documentFile = jQuery('#document').val(); 

        var passport = jQuery('#passport').val(); 

        var driver_license = jQuery('#driver_license').val(); 

        var expiration_date = jQuery('#expiration_date').val();  

        var documentFile = $('#document')[0].files[0];

        var passportDocument = $('#passport_document')[0].files[0];


        var form_errors = 0; 

        if(currentRequest != null) {
            clearTimeout(currentRequest);
        } 
        currentRequest = setTimeout(function() {
            jQuery('.form_errors').remove(); 
             console.log('remove');
        },3000);

       jQuery('.form_errors').remove();  

        if(company_name == '')

        {

            jQuery('#company_name').after('<p class="form_errors">Please enter company name.</p>');

            form_errors = 1;

        }else if(!companuRegex.test(company_name)){

            form_errors=1; 

            jQuery('#company_name').after('<p class="form_errors">Please enter must be between 2 and 50 characters</p>');

        }

        if(contact_name == '')

        {

            jQuery('#contact_name').after('<p class="form_errors">Please enter contact name.</p>');

            form_errors = 1;

        }else if(!companuRegex2.test(contact_name)){

            form_errors=1; 

            jQuery('#contact_name').after('<p class="form_errors">Please enter must be between 2 and 30 characters</p>');

        }

        if(email == '')

        {

            jQuery('#bb-email').after('<p class="form_errors">Please enter email.</p>');

            form_errors = 1;

        } else if(!emailReg.test(email)){

            form_errors=1; 

            jQuery('#bb-email').after('<p class="form_errors">Please enter a valid email</p>');

        }



        if(mobile_number == '')

        {

            jQuery('#mobile_number').after('<p class="form_errors">Please enter mobile number.</p>');

            form_errors = 1;

        }else if(!australianRegex.test(mobile_number)){

            form_errors=1; 

            jQuery('#mobile_number').after('<p class="form_errors">Please enter a valid australian phone number</p>');

        }

        if(password == '' || password == 0)

        {

            jQuery('#password').after('<p class="form_errors">Please enter password.</p>');

            form_errors = 1;

        }else if(!passWordReg.test(password)){

            form_errors=1; 

           // jQuery('#password').after('<p class="form_errors">Password must be between 8 and 15 characters</p>');
            jQuery('#password').after('<div class="form_errors "><ul style=" font-size: 10px; "> <li id="length" class="red">Include at least 8 digits and three special characters</li> <li id="uppercase" class="red">Include at least one upper case characters (A-Z)</li> <li id="lowercase" class="red">Include at least one lower case character (a-z)</li> <li id="numbers" class="red">Include a number (0-9)</li> <li id="symbols" class="red">Include a symbol (!, #, $,@,%,*,?,&amp;, etc.)</li> </ul></div>');

        }

        if(address != '' && !addRegex.test(address)){

            form_errors=1; 

            jQuery('#address').after('<p class="form_errors">Please enter must be between 2 and 150 characters</p>');


        }
 
        if(passport != '' && !passportVali.test(passport)){

            form_errors=1; 

            jQuery('#passport').after('<p class="form_errors">Passport number is invalid</p>');
        }

        if(driver_license != '' && !drivRegex.test(driver_license)){

            form_errors=1; 

            jQuery('#driver_license').after('<p class="form_errors">Invalid license number</p>');
        }

        if (typeof documentFile !== 'undefined' && documentFile !== '' && documentFile !== null)
        {
            if (!allowedExtensions.exec(documentFile.name)) {
                jQuery('#document').after('<p class="form_errors">Invalid file type. You can only upload : jpg, jpeg, png, pdf</p>');
                form_errors = 1;
            } 
        }

       if (typeof passportDocument !== 'undefined' && passportDocument !== '' && passportDocument !== null)
       {
            if (!allowedExtensions.exec(passportDocument.name)) {
                jQuery('#passport_document').after('<p class="form_errors">Invalid file type. You can only upload : jpg, jpeg, png, pdf</p>');
                form_errors = 1;
            } 
        }



        if(form_errors == 0)

        {



            var $this = jQuery(this);

            var fd = new FormData($this[0]); 

            var $this = jQuery(this);  

            var ajaxurl = profileManagement.ajax_site_url+'/wp-json/v1/profile'; 



            $.ajax({

                url: ajaxurl,

                type: "POST",  

                data: fd,  

                beforeSend: function(request) {

                    request.setRequestHeader("X-Auth-Key", 'A54dsNLNLfd4ADLBDJBasiasab42adA2ADCSdad');

                    jQuery('#ccpc_custom-loader').show();

                },

                processData: false,

                contentType: false,

                success: function(res) { 

                    jQuery('#ccpc_custom-loader').hide();

                    jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="color:green">User registered Successfully</p>');
                     
                    window.location.href = profileManagement.ajax_site_url+'/login/';

                },

                error: function(xhr, status, error) {
 

                    jQuery('#ccpc_custom-loader').hide(); 

                   jQuery('#ccpc_custom_formbtn').after('<p class="form_errors">'+xhr.responseJSON.message+'</p>');



                }

            })

        }else{

            return false;

        }

                                    

    });

    

    jQuery(document).on('submit', '#ccpc_custom_login_form', function(e)

    {  

        e.preventDefault();



        var email = jQuery('#user-email').val();

        var password = jQuery('#password').val();  

        var otp = jQuery('#mobile-otp').val();  

        var userVerify = parseInt(jQuery('#user-verify').val());  

        var optReg = /^[0-9]{4}$/;


        var form_errors = 0;

        jQuery('.form_errors').remove();

        if(currentRequest != null) {
            clearTimeout(currentRequest);
        } 
        currentRequest = setTimeout(function() {
            jQuery('.form_errors').remove(); 
             console.log('remove');
        },3000);



        if(email == '')

        {

            jQuery('#user-email').after('<p class="form_errors">Please enter email.</p>');

            form_errors = 1;

        }   

 

        if(password == '' || password == 0)

        {

            jQuery('#password').after('<p class="form_errors">Please enter password.</p>');

            form_errors = 1;

        } 



        if(userVerify == 1)

        {

            if(otp == '')

            {

                jQuery('#mobile-otp').after('<p class="form_errors">Please enter OTP.</p>');

                form_errors = 1;

            }else if(!optReg.test(otp)){

                form_errors=1; 

                jQuery('#mobile-otp').after('<p class="form_errors">OTP must be 4 digit</p>');

            }

        }



        if(form_errors == 0)

        {

            var security = profileManagement.ajax_nonce;

            var ajaxurl = profileManagement.ajax_url;

 

            var form_data= {

                action   : 'ccp_company_profile_login',

                email    : email,

                password : password,

                userVerify : userVerify,

                otp : otp,

                security : security,

            }

            $.ajax({

                url: ajaxurl,

                type: "POST",  

                data: form_data,  

                dataType: 'json', 

                beforeSend: function() { 

                    jQuery('#ccpc_custom-loader').show();

                }, 

                success: function(res) { 

                    jQuery('#ccpc_custom-loader').hide();

                    if(res.status == 2)

                    { 

                        if(res.opt == 1)

                        {

                            jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="color:green;font-size:12px">'+res.message+'</p>');

                            window.location.href = res.wp_redirect;                            

                        }else{

                            jQuery('.mobile-otp-verify').show();

                            jQuery('#password').prop('readonly', true);

                            jQuery('#user-email').prop('readonly', true);

                            jQuery('#user-verify').val(1);



                        }

                        

                    }else{

                        jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="font-size:12px">'+res.message+'</p>');

                    }  

                },

                error: function(xhr, status, error) { 
 

                    jQuery('#ccpc_custom-loader').hide(); 

                   jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="font-size:12px">'+xhr.responseJSON.message+'</p>');



                }

            })

        }else{

            return false;

        }



    });



    jQuery(document).on('submit', '#ccpc_profile_manage_form', function(e)

    {  

        e.preventDefault(); 

 

        var company_name = jQuery('#company_name').val();

        var contact_name = jQuery('#contact_name').val(); 

        var mobile_number = jQuery('#mobile_number').val(); 

        var password = jQuery('#password').val(); 

        var address = jQuery('#address').val(); 

        var passport  = jQuery('#passport ').val(); 

        var address = jQuery('#address').val(); 

        var documentFile = jQuery('#document').val(); 

        var passport = jQuery('#passport').val(); 

        var driver_license = jQuery('#driver_license').val(); 

        var expiration_date = jQuery('#expiration_date').val(); 

        var documentFile = $('#document')[0].files[0];

        var passportDocument = $('#passport_document')[0].files[0];

        var form_errors = 0; 



       jQuery('.form_errors').remove(); 

 
       if(currentRequest != null) {
            clearTimeout(currentRequest);
        } 
        currentRequest = setTimeout(function() {
            jQuery('.form_errors').remove(); 
             console.log('remove');
        },3000);

        if(company_name == '')

        {

            jQuery('#company_name').after('<p class="form_errors">Please enter company name.</p>');

            form_errors = 1;

        }else if(!companuRegex.test(company_name)){

            form_errors=1; 

            jQuery('#company_name').after('<p class="form_errors">Please enter must be between 2 and 50 characters</p>');

        }

        if(contact_name == '')

        {

            jQuery('#contact_name').after('<p class="form_errors">Please enter contact name.</p>');

            form_errors = 1;

        }else if(!companuRegex2.test(contact_name)){

            form_errors=1; 

            jQuery('#contact_name').after('<p class="form_errors">Please enter must be between 2 and 30 characters</p>');

        }  



        if(mobile_number == '')

        {

            jQuery('#mobile_number').after('<p class="form_errors">Please enter mobile number.</p>');

            form_errors = 1;

        }else if(!australianRegex.test(mobile_number)){

            form_errors=1; 

            jQuery('#mobile_number').after('<p class="form_errors">Please enter a valid australian phone number</p>');

        }



        if(passport != '' && !passportVali.test(passport)){

            form_errors=1; 

            jQuery('#passport').after('<p class="form_errors">Passport number is invalid</p>');

        }

        if(driver_license != '' && !drivRegex.test(driver_license)){

            form_errors=1; 

            jQuery('#driver_license').after('<p class="form_errors">Invalid license number</p>');

        }

        if(address != '' && !addRegex.test(address)){

            form_errors=1; 

            jQuery('#address').after('<p class="form_errors">Please enter must be between 2 and 250 characters</p>');

        }

        if (typeof documentFile !== 'undefined' && documentFile !== '' && documentFile !== null)
        {
            if (!allowedExtensions.exec(documentFile.name)) {
                jQuery('#document').after('<p class="form_errors">Invalid file type. You can only upload : jpg, jpeg, png, pdf</p>');
                form_errors = 1;
            } 
        }

       if (typeof passportDocument !== 'undefined' && passportDocument !== '' && passportDocument !== null)
       {
            if (!allowedExtensions.exec(passportDocument.name)) {
                jQuery('#passport_document').after('<p class="form_errors">Invalid file type. You can only upload : jpg, jpeg, png, pdf</p>');
                form_errors = 1;
            } 
        }



        if(form_errors == 0)

        {



            var $this = jQuery(this);

            var fd = new FormData($this[0]); 

            var $this = jQuery(this);  

            var ajaxurl = profileManagement.ajax_site_url+'/wp-json/v1/profile/update'; 



            $.ajax({

                url: ajaxurl,

                type: "POST",  

                data: fd,  

                beforeSend: function(request) {

                    request.setRequestHeader("X-Auth-Key", 'A54dsNLNLfd4ADLBDJBasiasab42adA2ADCSdad');

                    jQuery('#ccpc_custom-loader').show();

                },

                processData: false,

                contentType: false,

                success: function(res) { 

                    jQuery('#ccpc_custom-loader').hide();

                    jQuery('#ccpc_custom_formbtn').after('<p class="form_errors" style="color:green">User data updated Successfully</p>');

                    location.reload(true);

                },

                error: function(xhr, status, error) { 

                    jQuery('#ccpc_custom-loader').hide(); 

                   jQuery('#ccpc_custom_formbtn').after('<p class="form_errors">'+xhr.responseJSON.message+'</p>');



                }

            })

        }else{

            return false;

        }

                                    

    });

});



jQuery(document).ready(function(){

        var pending = jQuery('.panel-wrap1').data('total');

        var complete = jQuery('.panel-wrap2').data('total');

        var Inactive = jQuery('.panel-wrap3').data('total');



        jQuery('#slidebytpMenu').find('.blink-number').text(pending);

        jQuery('#slidebytpMenu2').find('.blink-numbers').text(complete);

        jQuery('#slidebytpMenu3').find('.blink-number').text(Inactive);



        var idleMax = 3;  

        var idleTime = 0;

        setCookie('autoLogOutTime', 0, 1);

        console.log('login idleTime', idleTime);



        var idleInterval = setInterval(function(){

        console.log('inter'); timerIncrement() }, 60000);  // 1 minute interval    

        $( "body" ).mousemove(function( event ) {

            setCookie('autoLogOutTime', 0, 1);// reset to zero

        });



        // count minutes

        function timerIncrement() {

            var idleTime = parseInt(getCookie('autoLogOutTime'));

            console.log('idleTime', idleTime);

            idleTime = parseInt(idleTime + 1);

            if (idleTime > idleMax) { 

                 console.log('logout idleTime', idleTime);

                setCookie('autoLogOutTime', idleTime, 1);



                var baseUrl = profileManagement.ajax_site_url;

                window.location=baseUrl+"/?auto-logout=1";

            }

            setCookie('autoLogOutTime', idleTime, 1);

        }       

    });



function setCookie(cname, cvalue, exdays) {

    const d = new Date();

    d.setTime(d.getTime() + (exdays*24*60*60*1000));

    let expires = "expires="+ d.toUTCString();

    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

}



function getCookie(cname) {

  let name = cname + "=";

  let decodedCookie = decodeURIComponent(document.cookie);

  let ca = decodedCookie.split(';');

  for(let i = 0; i <ca.length; i++) {

    let c = ca[i];

    while (c.charAt(0) == ' ') {

      c = c.substring(1);

    }

    if (c.indexOf(name) == 0) {

      return c.substring(name.length, c.length);

    }

  }

  return "";

}