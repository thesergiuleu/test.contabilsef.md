window.redirect_url = 'https://contabilsef.md';

var onloadCallback = function() {
    const reCaptchaDiv = document.getElementById('g-recaptcha');
    const data = $(reCaptchaDiv).data();
    if (typeof data !== "undefined") {
        grecaptcha.render(reCaptchaDiv, {
            'sitekey' : data.sitekey
        });
    }
};

ymaps.ready(init);

function init(){
    const mapDiv = document.getElementById("map");
    const data = $(mapDiv).data();

    if (typeof data !== "undefined") {
        // Creating the map.
        var myMap = new ymaps.Map("map", {
            // The map center coordinates.
            // Default order: “latitude, longitude”.
            // To not manually determine the map center coordinates,
            // use the Coordinate detection tool.
            center: [data.lat, data.long],
            // Zoom level. Acceptable values:
            // from 0 (the entire world) to 19.
            zoom: 18,
        });
        myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
            hintContent: 'ContabilSef',
            balloonContent: 'ContabilSef'
        }, {
            /**
             * Options.
             * You must specify this type of layout.
             */
            iconLayout: 'default#image',
            // Custom image for the placemark icon.
            iconImageHref: data.marker,
            // The size of the placemark.
            /**
             * The offset of the upper left corner of the icon relative
             * to its "tail" (the anchor point).
             */
        });
        myMap.geoObjects
            .add(myPlacemark);
    }
}
$(document).ready(function ($) {
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
                '_token': $('form#login #csrf_token').val(),
                'email': $('form#login #username').val(),
                'password': $('form#login #password').val(),
                'security': $('form#login #security').val(),
                'remember': $('form#login input[name="remember"]').is(':checked')?1:0
            },
            success: function (data) {
                if (data.status == 'success') {
                    location.reload();
                }
            },
            error: function (err) {
                if (err.status == 422) { // when status code is 422, it's a validation issue
                    // you can loop through the errors object and show it to the user
                    // display errors on each form field
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="'+i+'"]');
                        $(el).addClass('has-error')
                    });

                    $('.error_message').text(err.responseJSON.errors['email'][0]).show().css({
                        color:'red',
                    });
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
        $.ajax({
            type:"POST",
            url:$(this).attr('action'),
            data: $(this).serializeArray(),
            beforeSend: function(request) {
                request.setRequestHeader("Accept", 'application/json');
            },
            success: function(results){

                $('.pls-container').remove();


                console.log(results);
                // results = JSON.parse(results);
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
            error: function(err) {
                if (err.status == 422) { // when status code is 422, it's a validation issue
                    $('#success_message').fadeIn().html(err.responseJSON.message);

                    // you can loop through the errors object and show it to the user
                    // display errors on each form field
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="'+i+'"]');
                        $(el).addClass('has-error')
                    });
                    $('.register-message').text('Toate cîmpurile sunt obligatorii.').show().css({
                        color:'red',
                    });
                }
            }
        });
    });

    function handleErrors(form, field)
    {
        var el = $(form).find('[name="'+field+'"]');
        $(el).addClass('has-error');
        $(el).addClass('wpcf7-not-valid');
    }

    $('#contact-form').on('submit',function(e){
        e.preventDefault();
        const data = $(this).serializeArray();
        for (let i = 0; i < data.length; i++) {
            if (data[i].name === 'name' && data[i].value == '') {
                handleErrors(this, data[i].name)
                return;
            }
            if (data[i].name === 'email' && ( data[i].value == '' || !is_email(data[i].value))) {
                handleErrors(this, data[i].name)
                return;
            }
        }
        submitForm(this)
    });

    $('#newsletter-form').on('submit', function (e) {
        e.preventDefault();
        submitForm(this)
    });

    $('#pool-vote-form').on('submit', function (e){
       e.preventDefault();
       console.log('hakuna matata')
       submitForm(this);
    });

    $('#subscribe-form').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
    });
    $('#editProfileForm').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
    });
    $('#checkoutForm').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
    });
    $('#commentform').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
    });
    $('#offer-form').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
    });

    $('#instruire-register-form').on('submit', function (e){
        e.preventDefault();
        console.log('hakuna matata')
        submitForm(this);
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
                'email': $('#user_login').val(),
                '_token': $('form#login #csrf_token').val(),
            },
            success: function(data){
                location.reload();
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
    var pattern = new RegExp( /^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,9}$/i );
    return pattern.test( email );
}
function submitForm(form) {
    $('#subscription-submit-i').addClass('fa fa-spin fa-cog')
    $.ajax({
        type:$(form).attr('method'),
        url:$(form).attr('action'),
        data: $(form).serializeArray(),
        beforeSend: function(request) {
            request.setRequestHeader("Accept", 'application/json');
        },
        success: function(results){
            if(results.status == 'success'){

                window.redirect_url = results.redirect_url
                $('.popUp_contPersonal').removeClass('add-display-activee');
                $('.popUp_contPersonal').removeAttr('style');

                console.warn(results.message);
                $(form).find('div#response').css({
                    'display': 'block'
                }).html(results.message);
                $('#subscription-submit-i').removeClass('fa fa-spin fa-cog')
            }
        },
        error: function(err) {
            if (err.status == 422) { // when status code is 422, it's a validation issue
                $('#exampleModal').fadeIn().html(err.responseJSON.message);
                // you can loop through the errors object and show it to the user
                // display errors on each form field
                $.each(err.responseJSON.errors, function (i, error) {
                    console.log(i);
                    var el = $(form).find('[name="'+i+'"]');
                    $(el).addClass('has-error');
                    $(el).addClass('wpcf7-not-valid');
                });

                var size = Object.keys(err.responseJSON.errors).length;

                if ('terms' in err.responseJSON.errors && size === 1) {
                    $('#error-id').addClass('error_response_terms').html('Trebuie să accepți termenii și condițiile înainte de a trimite mesajul.');
                } else if ('g-recaptcha-response' in err.responseJSON.errors && size > 0) {
                    $('.recaptcha-error').css({
                        "color": "red"
                    }).html('reCaptcha a esuat.')
                } else {
                    $('#error-id').addClass('error_response').html('Unul sau mai multe câmpuri au o eroare. Te rog să verifici și să încerci din nou.');
                }
            }
            $('#subscription-submit-i').removeClass('fa fa-spin fa-cog')
        }
    });
}
function checkEmail(element) {
    if (element.value.length >= 1) {
        const url = $(element).data('url') + '?email=' + element.value
        $.ajax({
            type: 'GET',
            url: `${url}`,
            beforeSend: function(request) {
                request.setRequestHeader("Accept", 'application/json');
            },
            success: function(results) {
                $('#new-user-form').html(results.form)
            },
            error: function(err) {
                console.warn(err)
            }
        });
    }
}

function login(url) {
    const email = $('#email');
    const password = $('#password');

    if (!is_email(email.val())) {
        email.addClass('has-error');
    }

    if (!password.val() || password.val().length < 5) {
        password.addClass('has-error');
    }

    if (is_email(email.val()) && password.val().length > 5) {
        email.removeClass('has-error');
        password.removeClass('has-error');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            beforeSend: function(request) {
                request.setRequestHeader("Accept", 'application/json');
            },
            data: {
                '_token': $('#csrf_token').val(),
                'email': email.val(),
                'password': password.val(),
            },
            success: function (data) {
                if (data.status == 'success') {
                    location.reload();
                }
            },
            error: function (err) {
                if (err.status == 422) {
                    $.each(err.responseJSON.errors, function (i, error) {
                        var el = $(document).find('[name="'+i+'"]');
                        $(el).addClass('has-error')
                    });
                }
            }
        });
    }
}
