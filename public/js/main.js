$(window).on('load',function(){
    try {
        griwpcOnloadCallback();
    }
    catch(err) {
        console.log('No Recaptcha');
    }
    console.log('onload 2')
});

$(document).ready(function ($) {
    $.ajax({
        type:"POST",
        url:'https://www.contabilsef.md/wp-admin/admin-ajax.php',
        data:{
            action: 'ip'
        },
        success: function(results){
            $('[name="ip-address"]').val(results)
        }
    });
    setInterval(function(){
        if($('[name="ip-address"]').val() == '')
        {
            $.ajax({
                type:"POST",
                url:'https://www.contabilsef.md/wp-admin/admin-ajax.php',
                data:{
                    action: 'ip'
                },
                success: function(results){
                    $('[name="ip-address"]').val(results)
                }
            });
        }

    },1500)



    $( document).on('submit','#primaryPostForm', function(e){
        $(this).find('.required input').each(function(){
            if($(this).val() == ''){
                $(this).addClass('has-error');
            }else{
                $(this).removeClass('has-error');
            }
        });
        $(this).find('.required select').each(function(){
            if($(this).val() == ''){
                $(this).addClass('has-error');
            }else{
                $(this).removeClass('has-error');
            }
        });
        $(this).find('.required textarea').each(function(){
            if($(this).val() == ''){
                $(this).addClass('has-error');
            }else{
                $(this).removeClass('has-error');
            }
        });

        if($(this).find('.has-error').length > 0){
            e.preventDefault();
        }
    });

    $( document).on('click','.close',function(){
        console.log('CLOSE');
        $('.wpcf7-response-output').text('');
        $('.wpcf7-response-output').removeClass('wpcf7-mail-sent-ng');
        $('.wpcf7-response-output').removeClass('wpcf7-mail-sent-ok');
        $(this).parents('.popUp_contPersonal').removeClass('add-display-activee');
        $(this).parents('.popUp_contPersonal').removeAttr('style');
    });

    $( document).on('click','.add-image',function(e){
        e.preventDefault();
        e.stopPropagation();
        $('.close__all_elements').remove();
        $('[type="file"]').trigger('click');

        return false
    });

    if($('.no-image').length > 0){
        $('.no-image').html('<input type="button" class="button add-image" value="Adaugă imagine">');
    }

    $('#textareaAddQuestion').on('click', function(){
        if($('#textareaAddQuestion').length == 1){
            $('.tooltip1').addClass('active1');
            $('#textareaAddQuestion').attr('id','QQQQQQQQQ');
        }
    });
    if (typeof eventData !== 'undefined') {
        $("#my-calendar-2").zabuto_calendar({
            data: eventData,
            language : 'ro',
            nav_icon: {
                prev: '<i class="fa fa-chevron-circle-left"></i>',
                next: '<i class="fa fa-chevron-circle-right"></i>'
            },
            today: true,
        });
    }

    $('form#login').on('submit', function (e) {
        $('form#login p.status').show();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: $(this).attr('action'),
            data: {
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #username').val(),
                'password': $('form#login #password').val(),
                'security': $('form#login #security').val(),
                'remember': $('form#login input[name="remember"]').is(':checked')?1:0
            },
            success: function (data) {
                if (data.loggedin == true) {
                    $('form#login p.status').text(data.message).css({
                        color:'green',
                    });
                }
                if (data.loggedin == false) {
                    $('form#login p.status').text(data.message).css({
                        color:'red',
                    });
                }

                if (data.loggedin == true) {
                    if($('[name="redirectLogin"]').length > 0){
                        document.location.href = $('[name="redirectLogin"]').val();
                    }else{
                        document.location.href = $('form#login #redirect').val();
                    }

                }
            }
        });
        e.preventDefault();
    });

    $( document).on('click','.close',function(){
        $('html').removeClass('no_overflow');
    });

    $('#registrationForm').on('submit',function(e){
        e.preventDefault();
        var ms = '';
        $(this).find('.required').each(function(){
            if($(this).val() == ''){
                $(this).addClass('has-error');
                ms = 'Toate cîmpurile sunt obligatorii';
            }else{
                $(this).removeClass('has-error');
            }
            if($(this).hasClass('email') &&  !is_email( $(this).val() ) ){
                $(this).addClass('has-error');
                if(ms =='')ms = 'Email incorect';
            }else if($(this).hasClass('email') && is_email( $(this).val() ) ){
                $(this).removeClass('has-error');
            }
            if($(this).attr('type') == 'password' &&  $(this).val().length <= 5  ){
                $(this).addClass('has-error');
                if(ms =='')ms = 'Parola prea scurta';
            }else if($(this).hasClass('email') && is_email( $(this).val() ) ){
                $(this).removeClass('has-error');
            }
        });
        if($(this).find('.has-error').length > 0){
            $('.register-message').text(ms).show().css({
                color:'red',
            });
            return false;
        }else{
            $('.register-message').text('').hide();
        }

        $.ajax({
            type:"POST",
            url:$(this).attr('action'),
            data: $(this).serializeArray(),
            success: function(results){

                $('.pls-container').remove();
                

                console.log('asdfasdf');
                results = JSON.parse(results);
                if(results.status == 'success'){
                    $('.inregistrare .content').html('<span class="close"><i class="fa fa-times"></i></span><h1 style=" font-size: 30px; padding: 50px 50px">În scurt timp veți primi un mesaj la adresa electronică indicată. Vă rugăm să deschideți mesajul și să apăsați pe linkul de activare a contului Dvs.</h1>');
                    $('.inregistrare .content').css('max-width','550px');

                    // $('.register-message').text(results.message).show().css({
                    //     color:'green',
                    // });
                    // $('#registrationForm')[0].reset();
                    //window.location.href = window.location.origin + '/';
                }else{
                    $('.register-message').text(results.message).show().css({
                        color:'red',
                    });
                }
				grecaptcha.reset('g-recaptcha-registration');

            },
            error: function(results) {
            }
        });
    });


    //$('#forgot_password').on('submit', function(e){
    $('.ajax-form').on('submit', function(e){
        e.preventDefault();
        var this_form = $(this);
        $(this).find('.required').each(function(){
            if($(this).val() == ''){
                $(this).addClass('has-error');
            }else{
                $(this).removeClass('has-error');
            }

            if($(this).hasClass('email') &&  !is_email( $(this).val() ) ){
                $(this).addClass('has-error');
            }else if($(this).hasClass('email') && is_email( $(this).val() ) ){
                $(this).removeClass('has-error');
            }
        });
        if($(this).find('.has-error').length > 0){
            this_form.find('.message').text('All field is required').show().css({
                color:'red',
            });
            return false;
        }else{
            this_form.find('.message').text('').hide();
        }
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serializeArray(),
            success: function(data){
                data = JSON.parse(data);
                console.log(data);
                if(data.status == 'error'){
                    this_form.find('.message').show().text(data.message).css({color:'red'});
                }else if(data.status == 'success'){
                    if(data.reset_form){
                        this_form[0].reset();
                    }
                    this_form.find('.message').show().text(data.message).css({color:'green'});
                }

            }
        });
    });
    $('#deleteProfile').on('submit', function(e){

        e.preventDefault();
        $(this).find('.message').hide();
        var txt;
        var r = confirm("Doriți să ștergeți profilul dvs. de pe pagina contabilsef.md? Veți pierde toate datele și serviciile la care sînteți abonați!");
        if (r == true) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serializeArray(),
                success: function (data) {
                    window.location.href = data;
                }
            });
        } else {}

    });

    $('#forgot_password').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: {
                'action': 'ajaxforgotpassword',
                'user_login': $('#user_login').val(),
                'security': $('#forgotsecurity').val(),
            },
            success: function(data){
                data = JSON.parse(data);
                if(data.loggedin == false){
                    $('.status-send').show().text(data.message).css({color:'red'});
                }else if(data.loggedin == true){
                    $('#forgot_password')[0].reset();
                    $('.status-send').show().text(data.message).css({color:'green'});
                }

            }
        });
    });
	
	$(document).on('click','.banner_wrapper',function(){
	
		var url = $(this).attr('data-ajax-url');
		$.ajax({
			type: 'GET',
			url: url,
			data: {},
			success: function(data){}
		});
	})
});
function is_email( email ) {
    var pattern = new RegExp( /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i );
    return pattern.test( email );
}
