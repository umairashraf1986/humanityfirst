/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

 (function ($) {

    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Sage = {
        // All pages
        'common': {
            init: function () {
                // JavaScript to be fired on all pages
            },
            finalize: function () {
                // JavaScript to be fired on all pages, after page specific JS is fired
            }
        },
        // Home page
        'home': {
            init: function () {
                // JavaScript to be fired on the home page
            },
            finalize: function () {
                // JavaScript to be fired on the home page, after the init JS
            }
        },
        // About us page, note the change from about-us to about_us.
        'about_us': {
            init: function () {
                // JavaScript to be fired on the about us page
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function (func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function () {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

    function calcSpeed(speed) {
      // Time = Distance/Speed
      var spanSelector = document.querySelector('.featured-campaign-slider');
      var spanLength = spanSelector.offsetWidth;
      var timeTaken = spanLength / speed;
      spanSelector.style.animationDuration = timeTaken + "s";
    }

    $(document).ready(function () {

        if($(".featured-campaigns-ticker").length) {
            calcSpeed(20);
        }
        
        $('.preloader').hide();

        var bLazy = new Blazy({
            // Options
        });

        // increment figures by on second telethon page
        var figurePlus = 100;
        window.setInterval(
            function () {
                figurePlus = figurePlus + 1;
                try {
                    document.getElementById("figurePlus").innerHTML = figurePlus;
                } catch (e) {
                }
            }, 2000);
        var figurePlus = 350;
        window.setInterval(
            function () {
                figurePlus = figurePlus + 1;
                try {
                    document.getElementById("figureadd").innerHTML = figurePlus;
                } catch (e) {
                }
            }, 1500);

        // $(function () {
        //     $(window).resize(function () {
        //         try {
        //             $('.full-height-fold').height($(window).height() - $('.full-height-fold').offset().top);
        //         } catch (e) {
        //         }
        //     });

        //     $(window).resize();
        // });

        var featuredCampaignSliderHeight = 0;

        if($('.featured-campaigns-ticker').length) {
            featuredCampaignSliderHeight = $('.featured-campaigns-ticker').height();
        }

        if ($(window).width() <= 767) {
            $(".scrollTo").on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: (($(target).offset().top) - 119) - featuredCampaignSliderHeight
                }, 1000);
            });
        } else if ($(window).width() >= 768 && $(window).width() <= 1024) {
            $(".scrollTo").on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: (($(target).offset().top) - 170) - featuredCampaignSliderHeight
                }, 1000);
            });
        } else {
            $(".scrollTo").on('click', function (e) {
                e.preventDefault();
                var target = $(this).attr('href');
                var addedScroll = 0;
                if(target == '#donations') {
                    addedScroll = 170;
                }
                $('html, body').animate({
                    scrollTop: (($(target).offset().top) - 120) - featuredCampaignSliderHeight - addedScroll
                }, 1000);
            });
        }

        $('.accordion a').on('click', function (e) {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).closest('.accordion').find('.content').removeClass('active');
            } else {
                $('.accordion a, .accordion .content').removeClass('active');
                $(this).addClass('active');
                $(this).closest('.accordion-item').find('.content').addClass('active');
            }
        });

        // 3D Slider for Team
        $('.three-dee-team-slider').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 4,
            arrows: true,
            prevArrow: '<span class="team-arrow team-prev-arrow"><i class="fa fa-chevron-left"></i></span>',
            nextArrow: '<span class="team-arrow team-next-arrow"><i class="fa fa-chevron-right"></i></span>',
            dots: true,
            autoplay: true,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
            ]
        });

        // 3D Slider for Programs
        $('.programs-slider, .ow-projects-slider, .generic-slider, .countries-slider').slick({
            centerMode: true,
            centerPadding: '60px',
            slidesToShow: 4,
            arrows: true,
            prevArrow: '<span class="team-arrow team-prev-arrow"><i class="fa fa-chevron-left"></i></span>',
            nextArrow: '<span class="team-arrow team-next-arrow"><i class="fa fa-chevron-right"></i></span>',
            dots: true,
            autoplay: true,
            responsive: [
            {
                breakpoint: 1080,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '40px',
                    slidesToShow: 1
                }
            }
            ]
        });

        // 3D Slider for Programs
        $('.ow-projects-inside-program-slider').slick({
            slidesToShow: 3,
            arrows: true,
            prevArrow: '<span class="team-arrow team-prev-arrow"><i class="fa fa-chevron-left"></i></span>',
            nextArrow: '<span class="team-arrow team-next-arrow"><i class="fa fa-chevron-right"></i></span>',
            dots: false,
            autoplay: true,
            responsive: [
            {
                breakpoint: 1080,
                settings: {
                    arrows: true,
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: 1
                }
            },
            ]
        });

        // Program Detail Page Sider
        $('.hero-img-wrapper').slick({
            autoplay: true,
            arrows: false,
            autoplaySpeed: 2000,
            fade: true,
            speed: 500,
            cssEase: 'ease-in'
        });

        // Speakers Detail Page Sider
        $('.hf-speakers-carosel').slick({
            autoplay: true,
            arrows: true,
            autoplaySpeed: 2000,
            slidesToShow: 4,
            prevArrow: '<span class="speakers-arrow speakers-prev-arrow"><i class="fa fa-angle-left"></i></span>',
            nextArrow: '<span class="speakers-arrow speakers-next-arrow"><i class="fa fa-angle-right"></i></span>',
            responsive: [
            {
                breakpoint: 991,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 1
                }
            }
            ]
        });

        $('.th-speaker-sponsor-carosel').slick({
            autoplay: true,
            arrows: true,
            autoplaySpeed: 2000,
            slidesToShow: 3,
            prevArrow: '<span class="speakers-arrow speakers-prev-arrow"><i class="fa fa-angle-left"></i></span>',
            nextArrow: '<span class="speakers-arrow speakers-next-arrow"><i class="fa fa-angle-right"></i></span>',
            responsive: [
            {
                breakpoint: 991,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '0',
                    slidesToShow: 1
                }
            }
            ]
        });
        //Event Venue Slider
        $('#venue-images').slick({
            dots: false,
            arrow: false,
            autoplay: true,
            slidesToShow: 1
        });

        $('.fs-trigger, .fs-overlay').click(function () {

            if ($('.featured-sidebar').hasClass('fs-opened')) {
                $('.featured-sidebar').removeClass('fs-opened');
                $('.featured-sidebar').addClass('fs-closed');
                $('.fs-overlay').css('left', '-100%');
                $('.fs-trigger-alerts').css('left', '-72px');
                $('.fs-trigger-campaigns').css('left', '-91px');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "auto");
                }

            } else {
                $('.featured-sidebar').removeClass('fs-closed');
                $('.featured-sidebar').addClass('fs-opened');
                $('.fs-overlay, .fs-trigger-alerts, .fs-trigger-campaigns').css('left', '0');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "hidden");
                }
            }

        });


        $('.fs-trigger-alerts,.fs-overlay-alerts').click(function () {

            if ($('.featured-sidebar-alerts').hasClass('fs-opened')) {
                $('.featured-sidebar-alerts').removeClass('fs-opened');
                $('.featured-sidebar-alerts').addClass('fs-closed');
                $('.fs-overlay-alerts').css('left', '-100%');
                $('.fs-trigger').css('left', '-74px');
                $('.fs-trigger-campaigns').css('left', '-91px');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "auto");
                }
            } else {
                $('.featured-sidebar-alerts').removeClass('fs-closed');
                $('.featured-sidebar-alerts').addClass('fs-opened');
                $('.fs-trigger, .fs-overlay-alerts, .fs-trigger-campaigns').css('left', '0');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "hidden");
                }
            }

        });


        $('.fs-trigger-campaigns,.fs-overlay-campaigns').click(function () {

            if ($('.featured-sidebar-campaigns').hasClass('fs-opened')) {
                $('.featured-sidebar-campaigns').removeClass('fs-opened');
                $('.featured-sidebar-campaigns').addClass('fs-closed');
                $('.fs-overlay-campaigns').css('left', '-100%');
                $('.fs-trigger').css('left', '-74px');
                $('.fs-trigger-alerts').css('left', '-72px');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "auto");
                }
            } else {
                $('.featured-sidebar-campaigns').removeClass('fs-closed');
                $('.featured-sidebar-campaigns').addClass('fs-opened');
                $('.fs-overlay-campaigns, .fs-trigger, .fs-trigger-alerts').css('left', '0');
                if(!$( 'body' ).hasClass( 'home' )){
                    $("body").css("overflow", "hidden");
                }
            }

        });

        // Event Sections Menu
        $('#event-sections-menu ul li').click(function () {
            $('#event-sections-menu ul li').removeClass('active');
            $(this).addClass('active');
        });

        // Select Event Sections Menu Links for Smooth Scrolling
        $('#event-sections-menu a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        // .click(function(event) {
        //   // On-page links
        //   if (
        //     location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
        //     &&
        //     location.hostname == this.hostname
        //     ) {
        //     // Figure out element to scroll to
        //   var target = $(this.hash);
        //   target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        //     // Does a scroll target exist?
        //     if (target.length) {
        //       // Only prevent default if animation is actually gonna happen
        //       event.preventDefault();
        //       $('html, body').animate({
        //         scrollTop: target.offset().top-80
        //       }, 1000, function() {
        //         // Callback after animation
        //         // Must change focus!
        //         var $target = $(target);
        //         $target.focus();
        //         if ($target.is(":focus")) { // Checking if the target was focused
        //           return false;
        //         } else {
        //           $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
        //           $target.focus(); // Set focus again
        //         };
        //       });
        //     }
        //   }
        // });


        // alert(ajax_object.ajaxurl);

        $('.btn-login-fb').on('click', function () {
            $(this).prop('disabled', true);
            $.post(ajax_object.ajaxurl, {
                action: 'fb_login_action'
            }, function (data) {
                window.location.replace(data);
            });
        });

        $('.btn-login-google').on('click', function (e) {
            $.post(ajax_object.ajaxurl, {
                action: 'google_login_action'
            }, function (data) {
                window.location.replace(data);
            });
        });

        $('.logout-link').on('click', function (e) {
            e.preventDefault();

            if ($(this).attr('name') == 'facebook-logout') {
                $.post(ajax_object.ajaxurl, {
                    action: 'end_facebook_session_action',
                    logoutUrl: $(this).attr('href')
                }, function (data) {
                    window.location.replace(data);
                });
            }

            //alert($(this).attr('href'));
            if ($(this).attr('name') == 'google-logout') {
                $.post(ajax_object.ajaxurl, {
                    action: 'end_google_session_action',
                    logoutUrl: $(this).attr('href')
                }, function (data) {
                    window.location.replace(data);
                });
            }
        });

        try {
            var stripe = Stripe(hf_stripe_publishable_key);
            var elements = stripe.elements();

            var card = elements.create('card', {
                hidePostalCode: true,
                style: {
                    base: {
                        iconColor: '#13c8fd',
                        color: '#32315E',
                        lineHeight: '48px',
                        fontWeight: 400,
                        fontFamily: '"Open Sans", "Helvetica Neue", "Helvetica", sans-serif',
                        fontSize: '15px',

                        '::placeholder': {
                            color: '#CFD7DF',
                        }
                    },
                }
            });
        } catch (e) {
        }

        try {
            // Add an instance of the card UI component into the `card-element` <div>
            card.mount('#card-element');

            card.addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            // Create a token when the form is submitted
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                createToken();
            });
        } catch (e) {
        }

        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
        }

        function createToken() {
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server
                    stripeTokenHandler(result.token);
                }
            });
        }

        $('#btn-paypal-checkout').on('click', function (e) {
            e.preventDefault();
            var d = new Date();
            var currentMonth = d.getMonth();
            var currentYear = d.getFullYear();
            if ($('#donorName').val() == "") {
                alert("Please enter Name!");
            } else if ($('#card_type').val() == "") {
                alert("Please select Card Type!");
            } else if ($('#card_number').val() == "") {
                alert("Please enter Card Number!");
            } else if ($('#cvc').val() == "") {
                alert("Please enter CVC!");
            } else if ($('#expiry_month').val() < currentMonth && $('#expiry_year').val() == currentYear) {
                alert("Please select correct Month!");
            } else {
                $('.paypal-custom-form').submit();
            }
            return;
        });


        function isValidPaymentAmount() {
            if ($('#donation_amount').val() == "" || $('#donation_amount').val() == 0) {
                return false;
            } else {
                return true;
            }
        }

        function onChangePaymentInputBox(handler) {
            document.querySelector('#donation_amount').addEventListener('change', handler);
        }

        function togglePaymentInput(actions) {
            return isValidPaymentAmount() ? actions.enable() : actions.disable();
        }


        try {

            if ($('#paypal-button').length) {

                var environment = 'sandbox';
                if (hf_paypal_environment == 'live') {
                    environment = 'production';
                }

                paypal.Button.render({
                    env: environment, // sandbox | production
                    style: {
                        label: 'paypal',
                        size: 'responsive',    // small | medium | large | responsive
                        shape: 'rect',     // pill | rect
                        color: 'blue',     // gold | blue | silver | black
                        tagline: false
                    },
                    // PayPal Client IDs - replace with your own
                    // Create a PayPal app: https://developer.paypal.com/developer/applications/create
                    client: {
                        sandbox: hf_paypal_client_id,
                        production: hf_paypal_client_id
                    },
                    validate: function (actions) {
                        togglePaymentInput(actions);
                        onChangePaymentInputBox(function () {
                            togglePaymentInput(actions);
                        });
                    },
                    onClick: function (event) {
                        event.preventDefault();
                        togglePaymentInput();
                    },
                    // Wait for the PayPal button to be clicked
                    payment: function (data, actions) {

                        return actions.payment.create({
                            payment: {
                                transactions: [{
                                    amount: {total: $('#donation_amount').val(), currency: 'USD'}
                                }]
                            }
                        });
                    },

                    // Wait for the payment to be authorized by the customer
                    onAuthorize: function (data, actions) {
                        return actions.payment.execute().then(function () {

                            var str = $('#programs_dropdown').val();
                            var arr = str.split("_");
                            var program_id = arr[0];
                            var program_name = arr[1];

                            $.post(ajax_object.ajaxurl, {
                                action: 'add_donation_action',
                                donation_type: 'donation',
                                program_id: program_id,
                                program_name: program_name,
                                donor_id: $('#donor_id').val(),
                                donor_name: $('#donor_name').val(),
                                donor_email: $('#donor_email').val(),
                                donor_phone: $('#donor_phone').val(),
                                donation_amount: $('#donation_amount').val(),
                                campaign_id: $('#campaign_id').val(),
                                pledge_promise_date: ''
                            }, function (data) {
                                window.location.replace(data);
                            });
                        });
                    }

                }, '#paypal-button');
            }
        } catch (e) {
        }

        $(function () {

            // Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("form[name='step-one-form']").validate({
                // Specify validation rules
                rules: {
                    // The key name on the left side is the name attribute
                    // of an input field. Validation rules are defined
                    // on the right side
                    firstname: "required",
                    lastname: "required",
                    entree: "required",
                    email: {
                        required: true,
                        // Specify that email should be validated
                        // by the built-in "email" rule
                        email: true
                    }
                },
                // Specify validation error messages
                messages: {
                    firstname: "Please enter your firstname",
                    lastname: "Please enter your lastname",
                    entree: "Please your entree choice",
                    email: "Please enter a valid email address"
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function (form) {
                    $('#changetabbutton').addClass('active');
                    var disabled = $("form[name='step-one-form']").find(':input:disabled').removeAttr('disabled');
                    var datastring = $("form[name='step-one-form']").serialize();
                    disabled.attr('disabled', 'disabled');
                    $.ajax({
                        url: ajax_object.ajaxurl,
                        method: "POST",
                        dataType: "json",
                        data: datastring + "&action=primary_booking_form_action"

                    }).success(function (data) {
                        $('#changetabbutton').removeClass('active');
                        $('#booking-total-sidebar').removeClass('hidden');
                        $('#first-tab,.nav-link.active').removeClass('active');
                        $("#third-tab, .nav-link[href='#first-tab']").addClass('selected');
                        $("#second-tab, .nav-link[href='#second-tab']").addClass('active');
                        $(".nav-link[href='#second-tab']").removeClass('disabled');
                        $('#booking-details-sidebar').html(data.content_cart);
                        if (data.boooking_exist && data.boooking_exist == true) {
                            $('#skip-guest-step').hide();
                        } else {
                            $('#skip-guest-step').show();
                        }
                        var is_dinner = $('#is_dinner').val();
                        var strVar = "";
                        if(data.guest_bookings.length > 0) {
                            var guest_bookings = data.guest_bookings;

                            for(var i=0; i<guest_bookings.length; ++i) {
                                if(i>0) {
                                    strVar += "<div class=\"extra-guest-div\">";
                                    strVar += " <div class=\"clearfix\"><\/div>";
                                    strVar += " <div class=\"col-sm-12 guest-separator\"><hr><\/div>";
                                    strVar += " <div class=\"clearfix\"><\/div>";
                                }
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left\">";
                                strVar += "<input placeholder=\"Email\" type=\"text\" class=\"form-control guest_email\" name=\"pre_guest_email[]\" value=\"" + guest_bookings[i]['email'] + "\" />";
                                strVar += "<input type=\"hidden\" name=\"pre_guest_booking_id[]\" value=\"" + guest_bookings[i]['id'] + "\" />";
                                strVar += "<input type=\"hidden\" name=\"is_dinner\" value=\"" + is_dinner + "\" id=\"is_dinner\">";
                                strVar += "<\/div>";
                                strVar += "<div class=\"clearfix\"><\/div>";
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"First Name *\" type=\"text\" class=\"form-control guest_firstname\" name=\"pre_guest_firstname[]\" value=\"" + guest_bookings[i]['first_name'] + "\" />";
                                strVar += "<\/div>";
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"Last Name *\" type=\"text\" class=\"form-control guest_lastname\" name=\"pre_guest_lastname[]\" value=\"" + guest_bookings[i]['last_name'] + "\" />";
                                strVar += "<\/div>";
                                strVar += "<div class=\"clearfix\"><\/div>";
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"Phone\" type=\"text\" class=\"form-control guest_phone\" name=\"pre_guest_phone[]\" value=\"" + guest_bookings[i]['phone'] + "\" />";
                                strVar += "<\/div>";
                                if(!is_dinner){
                                    strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                    strVar += "<input placeholder=\"Company\" type=\"text\" class=\"form-control guest_company\" name=\"pre_guest_company[]\" value=\"" + guest_bookings[i]['company'] + "\" />";
                                    strVar += "<\/div>";
                                    strVar += "<div class=\"clearfix\"><\/div>";
                                    strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                    strVar += "<input placeholder=\"Role\" type=\"text\" class=\"form-control guest_role\" name=\"pre_guest_role[]\" value=\"" + guest_bookings[i]['role'] + "\" />";
                                    strVar += "<\/div>";
                                }
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"Affiliated Organization\" type=\"text\" class=\"form-control guest_affiliated_org\" name=\"pre_guest_affiliated_org[]\" value=\"" + guest_bookings[i]['affiliated_org'] + "\" />";
                                strVar += "<\/div>";
                                strVar += "<div class=\"clearfix\"><\/div>";
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<select name=\"pre_guest_entree[]\" class=\"form-control guest_entree\">";
                                strVar += "<option value=\"\">Select Entree Option *</option>";
                                if( guest_bookings[i]['entree'] == 'Moroccan Chicken') {
                                    strVar += "<option value=\"Moroccan Chicken\" selected>Moroccan Chicken</option>";
                                } else {
                                    strVar += "<option value=\"Moroccan Chicken\">Moroccan Chicken</option>"; 
                                }
                                if( guest_bookings[i]['entree'] == 'Seared Tilapia') {
                                    strVar += "<option value=\"Seared Tilapia\" selected>Seared Tilapia</option>";
                                } else {
                                    strVar += "<option value=\"Seared Tilapia\">Seared Tilapia</option>";
                                }
                                if( guest_bookings[i]['entree'] == 'Vegetable Lasagna') {
                                    strVar += "<option value=\"Vegetable Lasagna\" selected>Vegetable Lasagna</option>";
                                } else {
                                    strVar += "<option value=\"Vegetable Lasagna\">Vegetable Lasagna</option>";
                                }
                                strVar += "<\/select>";
                                strVar += "<\/div>";
                                if(i>0) {
                                    strVar += "<\/div>";
                                }
                            }

                            $("#guest-infor-section").html(strVar);
                        }else{
                            strVar = "";
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left\">";
                            strVar += "<input placeholder=\"Email\" type=\"text\" class=\"form-control guest_email\" name=\"pre_guest_email[]\" value=\"\" />";
                            strVar += "<input type=\"hidden\" name=\"pre_guest_booking_id[]\" value=\"\" />";
                            strVar += "<input type=\"hidden\" name=\"is_dinner\" value=\"\" id=\"is_dinner\">";
                            strVar += "<\/div>";
                            strVar += "<div class=\"clearfix\"><\/div>";
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                            strVar += "<input placeholder=\"First Name *\" type=\"text\" class=\"form-control guest_firstname\" name=\"pre_guest_firstname[]\" value=\"\" />";
                            strVar += "<\/div>";
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                            strVar += "<input placeholder=\"Last Name *\" type=\"text\" class=\"form-control guest_lastname\" name=\"pre_guest_lastname[]\" value=\"\" />";
                            strVar += "<\/div>";
                            strVar += "<div class=\"clearfix\"><\/div>";
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                            strVar += "<input placeholder=\"Phone\" type=\"text\" class=\"form-control guest_phone\" name=\"pre_guest_phone[]\" value=\"\" />";
                            strVar += "<\/div>";
                            if(!is_dinner){
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"Company\" type=\"text\" class=\"form-control guest_company\" name=\"pre_guest_company[]\" value=\"\" />";
                                strVar += "<\/div>";
                                strVar += "<div class=\"clearfix\"><\/div>";
                                strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                                strVar += "<input placeholder=\"Role\" type=\"text\" class=\"form-control guest_role\" name=\"pre_guest_role[]\" value=\"\" />";
                                strVar += "<\/div>";
                            }
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                            strVar += "<input placeholder=\"Affiliated Organization\" type=\"text\" class=\"form-control guest_affiliated_org\" name=\"pre_guest_affiliated_org[]\" value=\"\" />";
                            strVar += "<\/div>";
                            strVar += "<div class=\"clearfix\"><\/div>";
                            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
                            strVar += "<select name=\"pre_guest_entree[]\" class=\"form-control guest_entree\">";
                            strVar += "<option value=\"\">Select Entree Option *</option>";

                                strVar += "<option value=\"Moroccan Chicken\">Moroccan Chicken</option>";


                                strVar += "<option value=\"Seared Tilapia\">Seared Tilapia</option>";

                                strVar += "<option value=\"Vegetable Lasagna\">Vegetable Lasagna</option>";

                            strVar += "<\/select>";
                            strVar += "<\/div>";
                            $("#guest-infor-section").html(strVar);
                        }
                        if (sessionStorage) {
                            sessionStorage.setItem("booking_total", data.total);
                        }

                    });

                }
            });


// Initialize form validation on the registration form.
            // It has the name attribute "registration"
            $("#coupon-code-form").validate({
                rules: {
                    coupon_code: "required"
                },
                messages: {
                    coupon_code: "Coupon code required!"
                },
                // Make sure the form is submitted to the destination defined
                // in the "action" attribute of the form when valid
                submitHandler: function (form) {
                    $('.coupon-code-wrap').addClass('active');
                    $('.coupon-btn').prop('disabled', true);
                    var datastring = $("#coupon-code-form").serialize();
                    $.ajax({
                        url: ajax_object.ajaxurl,
                        method: "POST",
                        dataType: "json",
                        data: datastring + "&action=coupon_code_form_action"
                    }).success(function (data) {

                        $('.coupon-code-wrap').removeClass('active');
                        if (data.coupon_amount && data.coupon_amount > 0) {
                            $('#booking-details-sidebar').html(data.content_cart);
                        }
                        if (data.total == 0) {
                            $('#pay-now-form .poc-inner').slideUp("slow");
                            $('#pay-now-btn .pay-now-label').html("Confirm Booking");
                        }

                        $('#coupon_code').prop('disabled', true);
                        $('.coupon-clear-btn').prop('disabled', false);

                        if (sessionStorage) {
                            sessionStorage.setItem("booking_total", data.total);
                        }
                    });

                }
            });

            $.validator.addMethod("guest_firstname", $.validator.methods.required,
                "Please enter your firstname");
            $.validator.addMethod("guest_lastname", $.validator.methods.required,
                "Please enter your lastname");
            $.validator.addMethod("guest_entree", $.validator.methods.required,
                "Please select your entree choice");

            $.validator.addClassRules("guest_firstname", {guest_firstname: true});
            $.validator.addClassRules("guest_lastname", {guest_lastname: true});
            $.validator.addClassRules("guest_entree", {guest_entree: true});

            $("#step-two-form").submit(function (event) {
                event.preventDefault();

                var validateFields = [];
                validateFields.push($('.guest_firstname').valid());
                validateFields.push($('.guest_firstname').valid());
                validateFields.push($('.guest_lastname').valid());
                validateFields.push($('.guest_entree').valid());

                function checkInvalidInput(validateField) {
                    return validateField == true;
                }


                setTimeout(function () {
                    $('#step-two-form input, #step-two-form select').each(function () {
                        if ($(this).hasClass("error")) {
                            var attr_name = $(this).attr("name");
                            if (attr_name == "guest_firstname[]") {
                                $(this).parent().find("label.error").html("Please enter your firstname").show();
                            } else if (attr_name == "guest_lastname[]") {
                                $(this).parent().find("label.error").html("Please enter your lastname").show();
                            } else if (attr_name == "guest_entree[]") {
                                $(this).parent().find("label.error").html("Please select your entree choice").show();
                            }
                        }
                    });
                }, 0);


                if (validateFields.every(checkInvalidInput)) {
                    $('#geust_form_btn').addClass('active');
                    var datastring = $("#step-two-form").serialize();
                    $.ajax({
                        url: ajax_object.ajaxurl,
                        method: "POST",
                        dataType: "json",
                        data: datastring + "&action=guest_booking_form_action"
                    }).success(function (data) {
                        $('#event-booking-summery').html(data.content);
                        $('#geust_form_btn').removeClass('active');
                        $('#second-tab,.nav-link.active').removeClass('active');
                        $("#third-tab, .nav-link[href='#first-tab']").addClass('selected');
                        $("#third-tab, .nav-link[href='#second-tab']").addClass('selected');
                        $("#third-tab, .nav-link[href='#third-tab']").addClass('active');
                        $('#booking-details-sidebar').html(data.content_cart);
                        if (data.event_tickets_available) {
                            $('#booking-tickets-availability').val(1);
                        }
                        if (sessionStorage) {
                            sessionStorage.setItem("booking_total", data.total);
                        }
                    });

                }

            });

            $("#pay-now-form").submit(function (event) {
                event.preventDefault();
                $('#pay-now-btn').addClass('active');
                var datastring = $("#pay-now-form").serialize();
                var booking_total = getBookingTotal();
                var result_token = "";
                var program_name = $('.ebps-sub-title h2').text();
                var email = $('#form-primary-booking #email').val();

                var booking_availability = $('#booking-tickets-availability').val();
                if (booking_availability != 1) {
                    //alert("Tickets for this events are no more available!");
                    $('#ticket-booked').modal('show');
                    $('#pay-now-btn').removeClass('active');
                    return false;
                }


                if (booking_total > 0) {
                    var payment_method = $("#pay-now-form #payment-option").val();
                    if (payment_method == 'stripe') {
                        // Stripe Checkout
                        var token = function (res) {
                            result_token = res.id;
                            confirmBooking(booking_total, result_token, "stripe", email);
                        };

                        var stripe_key = hf_stripe_publishable_key;

                        // var test_key = 'pk_test_qoBLH26qsuUweq96nUqzgzPW';
                        // var live_key = 'pk_live_abvdm74lqTklbGeLUBdG4hEW';
                        var domain_name = window.location.origin;

                        //alert(domain_name);
                        if (window.location.hostname == 'localhost') {
                            domain_name = domain_name + '/wpHF';
                        } else if (window.location.hostname == 'dev-beta.smart-is.com' || window.location.hostname == 'dev.smart-is.com') {
                            domain_name = domain_name + '/humanityfirst';
                        }

                        booking_total = booking_total * 100;

                        StripeCheckout.open({
                            key: stripe_key,
                            amount: booking_total,
                            name: program_name,
                            image: domain_name + '/wp-content/themes/hf/assets/images/hf-stripe-logo.png',
                            description: 'Event Booking payment for ' + program_name,
                            email: email,
                            token: token,
                            closed: function () {
                                /*   $('#stripe-button').prop('disabled', false); */
                            }
                        });

                    } else if (payment_method == 'paypal') {
                        $('#event-paypal-form input[name="amount"]').val(booking_total);
                        confirmBookingPaypal();
                    }
                } else {
                    confirmBooking(0, '', '', '');
                }
            });
        });
});


$('#stripe-button').on('click', function (e) {
    e.preventDefault();
    $(this).prop('disabled', true);

    if ($('#donation_amount').val() == "" || $('#donation_amount').val() == 0) {
        /*alert("Please enter Donation Amount!");*/
        $(this).prop('disabled', false);
        return false;
    }

    if (!$('#programs_dropdown').val()) {
        $('#programs_dropdown').addClass('error');
        return false;
    } else {
        $('#programs_dropdown').removeClass('error');
    }


        // Stripe Checkout
        var token = function (res) {
            var $id = $('<input type=hidden name=stripeToken id="stripeToken" />').val(res.id);
            var $email = $('<input type=hidden name=stripeEmail id="stripeEmail" />').val(res.email);
            $('#donation_form').append($id).append($email).submit();
        };

        var stripe_key = hf_stripe_publishable_key;
        // var test_key = 'pk_test_qoBLH26qsuUweq96nUqzgzPW';
        // var live_key = 'pk_live_abvdm74lqTklbGeLUBdG4hEW';

        var domain_name = window.location.origin;

        //alert(domain_name);
        if (window.location.hostname == 'localhost') {
            domain_name = domain_name + '/wpHF';
        } else if (window.location.hostname == 'dev-beta.smart-is.com' || window.location.hostname == 'dev.smart-is.com') {
            domain_name = domain_name + '/humanityfirst';
        }

        var str = $('#programs_dropdown').val();
        var arr = str.split("_");
        var program_name = arr[1];

        var amount = $("#donation_amount").val() * 100;

        StripeCheckout.open({
            key: stripe_key,
            amount: amount,
            name: program_name,
            image: domain_name + '/wp-content/themes/hf/assets/images/hf-stripe-logo.png',
            description: 'Donation for ' + program_name,
            email: $("#donor_email").val(),
            token: token,
            closed: function () {
                $('#stripe-button').prop('disabled', false);
            }
        });

        return false;
    });

$('#pledge_radio').closest('label').on('click', function (e) {
    $('#donation-btns').hide();
    $('#pledge-form').show();
});

$('#donate_radio').closest('label').on('click', function (e) {
    $('#pledge-form').hide();
    $('#donation-btns').show();
});

var dateToday = new Date();
$('#pledge_promise_date').datepicker({
    minDate: dateToday
});

$('#pledge-btn').on('click', function (e) {
    e.preventDefault();
    $(this).prop('disabled', true);
    if ($('#pledge_promise_date').length) {
        $pledge_promise_date = $('#pledge_promise_date').val();
    } else {
        $pledge_promise_date = '';
    }

    if ($pledge_promise_date == "") {
        $('#pledge_promise_date').addClass("error");
        $(this).prop('disabled', false);
        return false;
    } else {
        $('#pledge_promise_date').removeClass("error");
        var str = $('#programs_dropdown').val();
        var arr = str.split("_");
        var program_id = arr[0];
        var program_name = arr[1];

        $.post(ajax_object.ajaxurl, {
            action: 'add_donation_action',
            donation_type: 'pledge',
            program_id: program_id,
            program_name: program_name,
            donor_id: $('#donor_id').val(),
            donor_name: $('#donor_name').val(),
            donor_email: $('#donor_email').val(),
            donor_phone: $('#donor_phone').val(),
            donation_amount: $('#donation_amount').val(),
            pledge_promise_date: $pledge_promise_date,
            campaign_id: $('#campaign_id').val(),
        }, function (data) {
            $('#pledge-btn').prop('disabled', false);
            window.location.replace(data);
        });
    }
});

$('.search-icon a').click(function (event) {
    event.preventDefault();
    $('.hf-search-form').toggle();
});

$('.testimonials-list, .quotes-list').slick({
    dots: false,
    autoplay: true,
    rows: 0,
    fade: true,
    speed: 500,
    cssEase: 'ease-in',
    prevArrow: '<span class="fa-stack testimonial-left-handle fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-caret-left fa-stack-1x"></i></span>',
    nextArrow: '<span class="fa-stack testimonial-right-handle fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-caret-right fa-stack-1x"></i></span>',
});

$(document).click(function (e) {
    if ($(e.target).closest(".hf-search-form").length == 0 && $(e.target).closest(".search-icon").length == 0) {
        $('.hf-search-form').hide();
    }
});

$('#dropdownMenuButton').click(function () {
    $('.hf-search-form').hide();
    if ($('.hf-mini-cart-cnt').hasClass('active')) {
        $('.hf-mini-cart-cnt').removeClass('active');
    }
});

var registerHandler = function (e) {

    var eventType = "";
    var element_id = e.target.id;

    if (element_id == 'btn-register') {
        e.preventDefault();
        $('.ajax-loader').removeClass('hidden');
        $("#btn-register").prop("disabled", true);
        eventType = "click";
    }

    $.ajax({
        url: ajax_object.ajaxurl,
        method: "POST",
        dataType: "json",
        data: {
            action: 'register_action',
            mode: 'register_user',
            event_type: eventType,
            element_id: element_id,
            form_data: $('#pippin_registration_form').serializeArray()
        }

    }).success(function (data) {
            $('.register_form .field').removeClass('invalid');
            $('.register_form .error').html('').css('bottom', '-80px').hide();
            if (data != null) {
                if (!data.success) {
                    if (eventType == 'click') {
                        $('#' + data.fieldId).focus();
                    }
                    $('#' + data.fieldId).addClass('invalid');
                    $('.' + data.errorCode).show().css('bottom', '-65px').html(data.error);
                    $("#btn-register").prop("disabled", false);
                    $('.ajax-loader').addClass('hidden');
                } else {
                    window.location.replace(data.location);
                }
            }
        });
}

$('#btn-register').on('click', registerHandler);

$('.register_form .field').on('focusout', registerHandler);


$('.sections-wrapper').slick({
    autoplay: true,
    pauseOnHover: true,
    arrows: false,
    autoplaySpeed: 4000,
    infinite: true,
    lazyLoad: 'ondemand',
    cssEase: 'linear',
    pauseOnFocus: false,
    pauseOnDotsHover: true,
    dots: true,
    fade: true,
    speed: 500,
    cssEase: 'ease-in'
});

yourHeader = $('.event-detail-page').height();

$(window).scroll(function () {
    if ($(this).scrollTop() > yourHeader) {
        $("#sticky-nav").delay(500).addClass("sticky-navigation");
    } else {
        $("#sticky-nav").delay(500).removeClass("sticky-navigation");
    }
});

if ($(window).width() < 768) {
    $('.slick-dots li a').tooltip({placement: 'bottom'});
} else {
    $('.slick-dots li a').tooltip({placement: 'right'});
}


$(window).resize(function () {
    var viewport_device = $(window).width();
    if (viewport_device < 768) {
        $('.slick-dots li a').tooltip('dispose');
        $('.slick-dots li a').tooltip({placement: 'bottom'});
    } else {
        $('.slick-dots li a').tooltip('dispose');
        $('.slick-dots li a').tooltip({placement: 'right'});
    }
});


$('#tooltips1-0').attr('data-original-title', 'Home');
$('#tooltips1-1').attr('data-original-title', 'About Us');
$('#tooltips1-2').attr('data-original-title', 'Our Work');
$('#tooltips1-3').attr('data-original-title', 'Our Impact');
$('#tooltips1-4').attr('data-original-title', 'Current Happenings');
$('#tooltips1-5').attr('data-original-title', 'Multimedia');
$('#tooltips1-6').attr('data-original-title', 'Get Involved');

$('.large-header-navigation ul li').on('click', function(e) {
    e.stopPropagation();
});

if ($('body').hasClass("home")) {

    var slider = $('.sections-wrapper');

    var numOfSlides = $('.sections-wrapper .slick-track .slick-slide').length;

    $('.forInvolvedSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 1);
    });
    $('.forResourcesSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 2);
    });
    $('.forHappeningSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 3);
    });
    $('.forImpactSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 4);
    });
    $('.forWorkSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 5);
    });
    $('.forAboutSlide').click(function (e) {
        e.preventDefault();
        e.stopPropagation();
        slider.slick('slickGoTo', numOfSlides - 6);
    });
}

var domain_name = window.location.origin;

var numberOfSlides = ajax_object.numOfSlides;

    //alert(domain_name);
    if (window.location.hostname == 'localhost') {
        domain_name = domain_name + '/wpHF';
    } else if (window.location.hostname == 'dev-beta.smart-is.com' || window.location.hostname == 'dev.smart-is.com') {
        domain_name = domain_name + '/humanityfirst';
    }

    if (!$('body').hasClass("home")) {
        $('.forAboutSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 6);
        });

        $('.forWorkSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 5);
        });

        $('.forImpactSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 4);
        });

        $('.forHappeningSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 3);
        });

        $('.forResourcesSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 2);
        });
        $('.forInvolvedSlide').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.href = domain_name + "?slide=" + (numberOfSlides - 1);
        });
    }

    try {

        var urlParams;
        (window.onpopstate = function () {
            var match,
                pl = /\+/g,  // Regex for replacing addition symbol with a space
                search = /([^&=]+)=?([^&]*)/g,
                decode = function (s) {
                    return decodeURIComponent(s.replace(pl, " "));
                },
                query = window.location.search.substring(1);

                urlParams = {};
                while (match = search.exec(query))
                    urlParams[decode(match[1])] = decode(match[2]);
            })();

        // Show respective slide on clicking top navigation from inner pages
        if (!isEmpty(urlParams)) {
            if (urlParams['slide'] != "") {
                $('.sections-wrapper').slick('slickGoTo', parseInt(urlParams['slide']));
            }
        }

    } catch (e) {
        alert(e);
    }

    function isEmpty(obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop))
                return false;
        }

        return true;
    }

    $('#all-link-news').on('click', function () {
        $('.News').show();
    });
    $('#all-link-blog').on('click', function () {
        $('.Blog').show();
    });
    $('#all-link-events').on('click', function () {
        $('.Event').show();
    });
    $('#all-link-stories').on('click', function () {
        $('.Stories').show();
    });
    $('#featured-link').on('click', function () {
        $('.News, .Blog, .Event, .Stories').hide();
        $('.Featured').show();
    });
    $('#popular-link').on('click', function () {
        $('.News, .Blog, .Event, .Stories').hide();
        $('.Popular').show();
    });


    $('#form-primary-booking #email').on('blur change', function () {
        var user_email = $.trim($(this).val());
        var event_id = $("#booking_event_id").val();

        if (user_email) {

            $(this).parent('.form-group').addClass('active');

            $.ajax({
                url: ajax_object.ajaxurl,
                method: "POST",
                dataType: "json",
                data: {
                    action: 'validate_event_user_action',
                    user_email: user_email,
                    booking_event_id: event_id
                }

            }).success(function (data) {
                if (data.user_exist && data.user_exist == true) {
                    if (data.first_name) {
                        $('.step-one-form #firstname').val(data.first_name);
                    }
                    if (data.last_name) {
                        $('.step-one-form #lastname').val(data.last_name);
                    }
                    if (data.phone_number) {
                        $('.step-one-form #phone').val(data.phone_number);
                    }
                    if (data.primary_booking_role) {
                        $('.step-one-form #role').val(data.primary_booking_role);
                    }
                }

                if (data.boooking_exist && data.boooking_exist == true) {
                    $('.step-one-form #firstname').prop('disabled', true);
                    $('.step-one-form #lastname').prop('disabled', true);
                    $('.step-one-form #phone').prop('disabled', true);
                    $('.step-one-form #company').prop('disabled', true);
                    $('.step-one-form #role').prop('disabled', true);
                    if ($('#booking-already-exists').length == 0) {
                        $('#booking-already-exists label.error').show();
                        $('.step-one-form').append('<div class="col-lg-12 float-left" id="booking-already-exists"><label class="error">You already booked for this event. You can add guests.</label></div>');
                    }
                } else {
                    $('.step-one-form #firstname').prop('disabled', false);
                    $('.step-one-form #lastname').prop('disabled', false);
                    $('.step-one-form #phone').prop('disabled', false);
                    $('.step-one-form #company').prop('disabled', false);
                    $('.step-one-form #role').prop('disabled', false);
                }

                $('#form-primary-booking #email').parent('.form-group').removeClass('active');
            });
        }
    });


    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
    $(".open-share-list").click(function (event) {
        $(this).siblings('.share-icons-list').toggleClass("slide-in");
    });


    $(".nav-tabs a[data-toggle=tab]").on("click", function (e) {
        var tab_link = $(this).attr("href");
        if (tab_link == '#first-tab') {
            $(".nav-link[href='#second-tab']").removeClass('selected');
            $(".nav-link[href='#second-tab']").addClass('disabled');
            $("#third-tab").removeClass('active');
        }
        if (tab_link == '#second-tab') {
            $("#third-tab").removeClass('active');
        }
    });


    $("#step-two-form").on("click", ".remove-guest", function (e) {
        $(this).closest(".extra-guest-div").slideUp("fast", function () {
            $(this).remove();
        });
    });


    $("#skip-guest-step").click(function (event) {
        event.preventDefault();
        $(this).addClass('active');
        var datastring = $("#step-two-form").serialize();
        $.ajax({
            url: ajax_object.ajaxurl,
            method: "POST",
            dataType: "json",
            data: datastring + "&action=guest_booking_form_action&skip=1"
        }).success(function (data) {
            $('#event-booking-summery').html(data.content);
            $('#second-tab,.nav-link.active').removeClass('active');
            $("#skip-guest-step").removeClass('active');
            $("#third-tab, .nav-link[href='#first-tab']").addClass('selected');
            $("#third-tab, .nav-link[href='#second-tab']").addClass('selected');
            $("#third-tab, .nav-link[href='#third-tab']").addClass('active');
            $('#booking-details-sidebar').html(data.content_cart);
            if (sessionStorage) {
                sessionStorage.setItem("booking_total", data.total);
            }
            if (data.event_tickets_available == true) {
                $('#booking-tickets-availability').val(1);
            }
            $('#event-paypal-form input[name="amount"]').val(data.total);
        });
    });


    $("#add-more-guest").click(function () {

        var new_elem_id = 2;
        new_elem_id = $('.extra-guest-div').length + new_elem_id;

        var is_dinner = $('#is_dinner').val();

        var strVar = "";
        strVar += "<div class=\"extra-guest-div\">";
        strVar += " <div class=\"clearfix\"><\/div>";
        strVar += " <div class=\"col-sm-12 guest-separator\"><hr><\/div>";
        strVar += " <div class=\"clearfix\"><\/div>";
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 float-left\">";
        strVar += "<input placeholder=\"Email\" type=\"text\" class=\"form-control guest_email\" name=\"guest_email[]\"  id=\"guest_email-" + new_elem_id + "\">";
        strVar += "<\/div>";
        strVar += "<div class=\"clearfix\"><\/div>";
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "<input placeholder=\"First Name *\" type=\"text\" class=\"form-control guest_firstname\" name=\"guest_firstname[]\"  id=\"guest_firstname-" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "\">";
        strVar += "<\/div>";
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "<input placeholder=\"Last Name *\" type=\"text\" class=\"form-control guest_lastname\" name=\"guest_lastname[]\"  id=\"guest_lastname-" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "\">";
        strVar += "<\/div>";
        strVar += "<div class=\"clearfix\"><\/div>";
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "<input placeholder=\"Phone\" type=\"text\" class=\"form-control guest_phone\" name=\"guest_phone[]\"  id=\"guest_phone-" + new_elem_id + "" + new_elem_id + "" + new_elem_id + "\">";
        strVar += "<\/div>";
        if(!is_dinner){
            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
            strVar += "<input placeholder=\"Company\" type=\"text\" class=\"form-control guest_company\" name=\"guest_company[]\"  id=\"guest_company-" + new_elem_id + "" + new_elem_id + "\">";
            strVar += "<\/div>";
            strVar += "<div class=\"clearfix\"><\/div>";
            strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
            strVar += "<input placeholder=\"Role\" type=\"text\" class=\"form-control guest_role\" name=\"guest_role[]\"  id=\"guest_role-" + new_elem_id + "\">";
            strVar += "<\/div>";
        }
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "<input placeholder=\"Affiliated Organization\" type=\"text\" class=\"form-control guest_affiliated_org\" name=\"guest_affiliated_org[]\"  id=\"guest_affiliated_org-" + new_elem_id + "\">";
        strVar += "<\/div>";
        strVar += "<div class=\"clearfix\"><\/div>";
        strVar += "<div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "<select name=\"guest_entree[]\" id=\"guest_entree-" + new_elem_id + "\" class=\"form-control guest_entree\">";
        strVar += "<option value=\"\">Select Entree Option *</option>";
        strVar += "<option value=\"Moroccan Chicken\">Moroccan Chicken</option>";
        strVar += "<option value=\"Seared Tilapia\">Seared Tilapia</option>";
        strVar += "<option value=\"Vegetable Lasagna\">Vegetable Lasagna</option>";
        strVar += "<\/select>";
        strVar += "<\/div>";
        strVar += " <div class=\"form-group col-xs-12 col-sm-12 col-md-6 col-lg-6 float-left\">";
        strVar += "     <button type=\"button\" class=\"gray-form-button remove-guest\" id=\"\">";
        strVar += "          Remove";
        strVar += "     <\/button>";
        strVar += " <\/div>";
        strVar += "<\/div>";

        $("#guest-infor-section").append(strVar);

    });


    $('.btnPreviousTab').click(function () {
        $('.nav-tabs .nav-item > .active').parent().prev('li').find('a').trigger('click');
    });


    $("#coupon-code-form").on("click", "#coupon-clear-btn", function (e) {
        $("#coupon-code-form")[0].reset();
        $.ajax({
            url: ajax_object.ajaxurl,
            method: "POST",
            dataType: "json",
            data: "action=reset_coupon_code_action"
        }).success(function (data) {
            $('.coupon-btn').prop('disabled', false);
            $('#coupon_code').prop('disabled', false);
            $('#coupon-clear-btn').prop('disabled', true);
            if (data.content_cart) {
                $('#booking-details-sidebar').html(data.content_cart);
            }
            if (data.total > 0) {
                $('#pay-now-form .poc-inner').show();
                $('#pay-now-btn .pay-now-label').html("Pay Now");
            }
            if (sessionStorage) {
                sessionStorage.setItem("booking_total", data.total);
            }
        });
    });


    function getBookingTotal() {
        var total = 0;
        if (sessionStorage) {
            total = sessionStorage.getItem("booking_total");
        } else {
            $.ajax({
                url: ajax_object.ajaxurl,
                method: "POST",
                dataType: "json",
                async: false,
                data: "action=event_booking_total_action"
            }).success(function (data) {
                total = data.total;
            });
        }
        return total;
    }

    function confirmBooking(booking_total, result_token, charge_type, email) {
        $.ajax({
            url: ajax_object.ajaxurl,
            method: "POST",
            dataType: "json",
            data: "action=pay_booking_form_action&booking_total=" + booking_total + "&result_token=" + result_token + "&charge_type=" + charge_type + "&email=" + email
        }).success(function (data) {
            $('#pay-now-btn').removeClass('active');
            if (data.tickets_available == false) {
                alert("Tickets for this events are no more available!");
            }
            if (data.tickets_booked == true && data.redirect_url) {
                window.location = data.redirect_url;
            }
        }).error(function (jqXHR, textStatus, errorThrown) {
            $('#pay-now-btn').removeClass('active');
        });
    }

    function confirmBookingPaypal() {
        $.ajax({
            url: ajax_object.ajaxurl,
            method: "POST",
            dataType: "json",
            data: "action=pay_booking_form_action&charge_type=paypal"
        }).success(function (data) {
            if (data.tickets_available == false) {
                alert("Tickets for this events are no more available!");
            }
            if (data.tickets_booked == true && data.booking_details) {
                $('#event-paypal-form input[name="custom"]').val(data.booking_details);
                document.paypalForm.submit();
            }
        }).error(function (jqXHR, textStatus, errorThrown) {
            $('#pay-now-btn').removeClass('active');
        });
    }


    $("#myTopnav").on('click', '.nav-link', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 77
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });

    $('.t-map-section .interactive-map-container area').click(function () {
        $('.t-map-section .interactive-map-container area').removeClass('active');
        $(this).addClass('active');

    });


    $('.t-map-section .interactive-map-container area').click(function (e) {
        e.preventDefault();
        var hrefval = $(this).attr('href');
        var statetitle = $(this).attr('title');
        $('.hf-map-tooltip').hide();
        var state_donations_data = $('#state-donations').data('states-donations');
        var state_donation = '--';
        var state_pledge = '--';
        var state_id = hrefval.replace('#', '');

        if (state_donations_data[state_id] && state_donations_data[state_id]["Donation"]) {
            state_donation = '$' + state_donations_data[state_id]["Donation"];
        }
        if (state_donations_data[state_id] && state_donations_data[state_id]["Pledge"]) {
            state_pledge = '$' + state_donations_data[state_id]["Pledge"];
        }

        $(hrefval).html('<span class="state-title"><strong>' + statetitle + '</strong></span><span class="state-donation">Donations : ' + state_donation + '</span><span class="state-donation">Pledges : ' + state_pledge + '</span>');
        $(hrefval).show();
        var imgPos = $(this).offset();
        var coords = $(this).attr('coords').split(',');
        var box = {
            left: parseInt(coords[0], 10),
            top: parseInt(coords[1], 10),
            width: parseInt(coords[2], 10) - parseInt(coords[0], 10),
            height: parseInt(coords[3], 10) - parseInt(coords[1], 10)
        };
        var x = box.left - 70;
        var y = box.top - 80;
        var viewport = $(window).width();
        if ((x + 140) > viewport || (viewport - (x + 140) < 140)) {
            x = x - 140;
        }
        $('.hf-map-tooltip').css('left', x);
        $('.hf-map-tooltip').css('top', y);
    });


    $('#donation_form').on('change', '#donation_amount', function () {

        if ($.trim($('#donation_amount').val()) == "" || $('#donation_amount').val() <= 0 || !$.isNumeric($('#donation_amount').val())) {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });

    $('#donation_form').on('change', '#programs_dropdown', function () {
        if ($.trim($('#programs_dropdown').val()) == "") {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });
    $('#donation_form').on('change', '#pledge_promise_date', function () {
        if ($.trim($(this).val()) == "") {
            $(this).addClass('error');
        } else {
            $(this).removeClass('error');
        }
    });
    // var $grid_events = $('.hf-filter-grid').isotope({
    //     itemSelector: '.hf-grid-item',
    //     layoutMode: 'fitRows'
    // });

    // filter items on button click
    $('.hf-news-filter').on('click', 'a', function (event) {
        event.preventDefault();
        var filterValue = $(this).attr('data-filter');
        $grid_events.isotope({filter: filterValue});
    });

    $('#dropdownMenuCart').click(function (event) {
        event.preventDefault();
        $('.hf-mini-cart-cnt').toggleClass('active');
    });
    $(document).click(function (e) {
        if ($(e.target).parents(".hf-mini-cart-cnt").length == 0 && $(e.target).parents("#dropdownMenuCart").length == 0) {
            if ($('.hf-mini-cart-cnt').hasClass('active')) {
                $('.hf-mini-cart-cnt').removeClass('active');
            }
        }
    });

    $(document.body).on('added_to_cart removed_from_cart', function (event, fragments, cart_hash, $button) {

        if ($('#hf-cart-counter').length) {
            $('#hf-cart-counter').html(fragments.hf_cart_total);

            if (fragments.hf_cart_total === 0) {
                $('#hf-cart-counter').remove();
            }
        } else {
            $('.dropdown-toggle-cart').append('<span class="cart-qty" id="hf-cart-counter">' + fragments.hf_cart_total + '</span>');
        }

        $('.hf-mini-cart-cnt').addClass('active');
    });

    $(document.body).on('updated_wc_div updated_cart_totals', function () {
        if ($('#hf-cart-qty').length) {
            var items_in_cart = $('#hf-cart-qty').data('hf-cart-qty');
            if (items_in_cart) {
                $('#hf-cart-counter').html(items_in_cart);
            } else {
                $('#hf-cart-counter').remove();
            }
        } else {
            if ($('body').hasClass('woocommerce-cart')) {
                $('#hf-cart-counter').remove();
            }
        }
    });

    $('.woocommerce-review-link-custom').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $('.reviews_tab a').click();
        $('html, body').animate({
            scrollTop: (($(target).offset().top) - 320)
        }, 1000);
    });

    $('.products-telethon').slick({
        autoplay: true,
        arrows: true,
        autoplaySpeed: 2000,
        slidesToShow: 3,
        prevArrow: '<span class="speakers-arrow speakers-prev-arrow"><i class="fa fa-angle-left"></i></span>',
        nextArrow: '<span class="speakers-arrow speakers-next-arrow"><i class="fa fa-angle-right"></i></span>',
        responsive: [
        {
            breakpoint: 768,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 3
            }
        },
        {
            breakpoint: 480,
            settings: {
                arrows: false,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1
            }
        }
        ]
    });

    $('.home-bck-btn [data-toggle="tooltip"]').tooltip();

    $('.photo-gallery').on('click', '.hf_gallery_lightbox_cnt', function (event) {
        if ($(event.target).is(".close-gallery-light-box") || $(event.target).is(".fa-close")) {
            return;
        }
        event.preventDefault();
    });

    $("#hf-events-wrap").mCustomScrollbar({
        scrollButtons: {enable: true},
        theme: "3d",
        callbacks: {
            onTotalScroll: function () {
                $(".fs-events .hf-cssload-thecube.events-preloader").show();
                var offset = $('.featured-sidebar .fs-item').length;
                $.ajax({
                    url: ajax_object.ajaxurl,
                    method: "POST",
                    data: "action=hf_load_more_events&offset=" + offset
                }).success(function (data) {
                    $('.featured-sidebar .featured-sidebar-inner .mCSB_container').append(data);
                    $("#hf-events-wrap").mCustomScrollbar("update");

                }).always(function () {
                    $(".fs-events .hf-cssload-thecube.events-preloader").hide();
                });
            }
        }
    });


    $("#telethon-pledge-form").submit(function (event) {
        event.preventDefault();

        if (telethon_get_action()) {
            var submit_btn = $(this).find('button[type=submit]').addClass('active');
            var datastring = $(this).serialize();
            $.ajax({
                url: ajax_object.ajaxurl,
                method: "POST",
                data: datastring + "&action=action_add_pledge_record"
            }).success(function (data) {
                jQuery('.modal-body').addClass('ajax-response');
                jQuery('#server-response').html('<p>Thank you! Your pledge recorded successfully.</p>');
                jQuery('#telethon-pledge-form')[0].reset();
                submit_btn.removeClass('active');
            });
        }
    });


    $('#telethonPledgeModal').on('hidden.bs.modal', function () {
        jQuery('#server-response').html('');
        jQuery('#telethonPledgeModal .modal-body').removeClass('ajax-response');
    });

    function telethonRecaptchaCallback() {
        document.getElementById('telethon-pledge-captcha').innerHTML = "";
    }

    function telethon_get_action() {

        var v = grecaptcha.getResponse();
        if (v.length == 0) {
            document.getElementById('telethon-pledge-captcha').innerHTML = "You can't leave Captcha Code empty";
            return false;
        } else {
            document.getElementById('telethon-pledge-captcha').innerHTML = "";
            return true;
        }
    }

    $(document).ready(function () {
        $("#blog-load-more").on('click',function(){
            $(this).text("Loading...");
            $(this).attr('disabled','disabled');
            var limit = parseInt($(this).attr('data-offset'));
            var start = limit + 28;
            console.info(start);
            $.ajax({
                url: ajax_object.ajaxurl,
                type: 'GET',
                data: {
                    action: 'get-blog-posts',
                    offset: start
                },
                success:function (data) {
                    var $newItems = $(data.response);
                    $('.hf-filter-grid').isotope( 'insert', $newItems );
                    $("#blog-load-more").removeAttr('data-offset');
                    $("#blog-load-more").attr('data-offset', start);
                    $("#blog-load-more").text("Show More");
                    $("#blog-load-more").removeAttr('disabled');
                }
            })
        })
        $("#payment-option").on("change",function(){
            var paymentMethod = $(this).val();
            $("#paypal-logo, #stripe-logo").hide();
            if(paymentMethod == 'paypal'){
                $("#paypal-logo").show();
                $("#paypal-logo").css("display","flex");
                $("#pay-now-btn .pay-now-label").text("Pay Now with PayPal");
            }
            if(paymentMethod == 'stripe'){
                $("#stripe-logo").show();
                $("#stripe-logo").css("display","flex");
                $("#pay-now-btn .pay-now-label").text("Pay Now with CC");
            }
        });
        if($("#yikes-easy-mc-form-1-EMAIL").length > 0){
            $("#yikes-easy-mc-form-1-EMAIL").attr("autocomplete","off");
        }
    });

    // Product review form validation
    $('#commentform').submit(function() {
        var isError = false;
        $('.comment-form').prepend('<div class="error" style="color: red;"></div>');
        if(!$.trim($("#comment").val())) {
            isError = true;
            if(!$('.error .review').length) {
                $('.comment-form .error').append('<div class="review">Please enter Review.</div>');
            }
        } else {
            $('.error .review').remove();
        }
        if(!$.trim($("#author").val())) {
            isError = true;
            if(!$('.error .author').length) {
                $('.comment-form .error').append('<div class="author">Please enter Name.</div>');
            }
        } else {
            $('.error .author').remove();
        }
        if(!$.trim($("#email").val())) {
            isError = true;
            if(!$('.error .email').length) {
                $('.comment-form .error').append('<div class="email">Please enter Email.</div>');
            }
        } else {
            if(!isEmail($.trim($("#email").val()))) {
                isError = true;
                if(!$('.error .email').length) {
                    $('.comment-form .error').append('<div class="email">Please enter valid Email.</div>');
                } else {
                    $('.email').html('Please enter valid Email.');
                }
            } else {
                $('.error .email').remove();
            }
        }
        return !isError;
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('.agenda_details_outer.collapse').on('shown.bs.collapse', function () {
        $(this).parent().find(".fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }).on('hidden.bs.collapse', function () {
        $(this).parent().find(".fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
    });
    $('.footer-icon').on('click',function(){
        $(".home-footer").toggleClass("inactive");
        $('.fa-angle-down').toggle();
        $('.fa-angle-up').toggle();
    })

    var xhr = '';

    function ajaxCall(searchText) {
        xhr = $.ajax({
            method: "POST",
            url: ajax_object.ajaxurl,
            dataType: 'json',
            data: "search="+searchText+"&action=get_google_places"
        }).done(function( data ) {
            $('#loader').hide();
            $('#searchBtn').prop('disabled', false);
            $('#cancelBtn').prop('disabled', true);
            $(".places-wrapper > .container > .row > .col").html(data);
        });
    }

    $('#searchBtn').on('click', function(e) {
        e.preventDefault();
        $('#loader').show();
        $(this).prop('disabled', true);
        $('#cancelBtn').prop('disabled', false);
        $(".places-wrapper > .container > .row > .col").html('');
        var searchText = $('#searchPlace').val()+" "+$('#searchType').val()+" "+$('#searchText').val();

        ajaxCall(searchText);
    });

    $('#cancelBtn').on('click', function(e) {
        e.preventDefault();
        xhr.abort();
        $('#loader').hide();
        $('#searchBtn').prop('disabled', false);
        $(this).prop('disabled', true);
        $(".places-wrapper > .container > .row > .col").html('<div class="searchMessage"><em>Search results appear here</em></div>');     
    });

    $("body").on('click', ".place-wrapper", function(e) {
        e.preventDefault();
        e.stopPropagation();
        var newWindow = window.open('', '_blank');
        newWindow.document.body.innerHTML = "Loading...";
        var placeId = $(this).attr('id');

        $.ajax({
            method: "POST",
            url: ajax_object.ajaxurl,
            dataType: 'json',
            data: "placeId="+placeId+"&action=get_google_places"
        }).done(function( data ) {
            newWindow.location = data.result.url;
        });
    });

    if($('#container-maps').length) {
        var map_data = JSON.parse(covid_object.arrayCodes);
        console.log(map_data);

        var s_data = jQuery.parseJSON(covid_object.recordsData);
        console.log(s_data);
        jQuery.each(map_data, function () {
            this.code = this.code.toUpperCase();
            if(s_data[this.name] && s_data[this.name]["total"]){            
                this.total = s_data[this.name]["total"];
            }
            if(s_data[this.name] && s_data[this.name]["positive"]){
                this.positive = s_data[this.name]["positive"];
                this.value = s_data[this.name]["positive"];
            }
            if(s_data[this.name] && s_data[this.name]["negative"]){         
                this.negative = s_data[this.name]["negative"];
            }
            if(s_data[this.name] && s_data[this.name]["deaths"]){   
                this.deaths = s_data[this.name]["deaths"];
            }
            if(s_data[this.name] && s_data[this.name]["hospitalized"]){ 
                this.hospitalized = s_data[this.name]["hospitalized"];
            }
            if(s_data[this.name] && s_data[this.name]["lastUpdateEt"]){
                var str = s_data[this.name]["lastUpdateEt"];
                this.lastUpdateEt = str.replace("-", " ");
            }
        });

        Highcharts.mapChart('container-maps', {
            chart: {
                borderColor: '#0069b4',
                map: 'countries/us/us-all',
                borderWidth: 1
            },
            title: {
                text: ''
            },
            credits: {
                enabled:false
            },
            exporting: {
                enabled:false
            },
            legend: {
                title: {
                    text: 'Positive Cases',
                    style: {
                        color: ( // theme
                            Highcharts.defaultOptions &&
                            Highcharts.defaultOptions.legend &&
                            Highcharts.defaultOptions.legend.title &&
                            Highcharts.defaultOptions.legend.title.style &&
                            Highcharts.defaultOptions.legend.title.style.color
                            ) || 'black'
                    }
                },
                align: 'right',
                verticalAlign: 'top',
                floating: false,
                padding: 12,
                itemMarginBottom: 5,
                layout: 'vertical',
                alignColumns: true,
                valueDecimals: 0,
                backgroundColor: ( // theme
                    Highcharts.defaultOptions &&
                    Highcharts.defaultOptions.legend &&
                    Highcharts.defaultOptions.legend.backgroundColor
                    ) || 'rgba(255, 255, 255, 0.85)',
                symbolRadius: 0,
                symbolHeight: 14,
                shadow: {"color": "rgba(0, 0, 0, 0.2)", "offsetX": "0", "offsetY": "0", "width": "10"},
                symbolRadius: 7
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500,
                    },
                    chartOptions: {
                        legend: {
                            align: 'center',
                            layout: 'horizontal',
                            verticalAlign: 'bottom',
                        }
                    }
                }]
            },
            mapNavigation: {
                enabled: true
            },
            colors: ['rgba(0, 105, 180, 0.05)', 'rgba(0, 105, 180, 0.2)', 'rgba(0, 105, 180, 0.4)', 'rgba(0, 105, 180, 0.5)', 'rgba(0, 105, 180, 0.6)', 'rgba(0, 105, 180, 0.8)', 'rgba(0, 105, 180, 1)'],
            colorAxis: {
                dataClasses: [{
                    to: 0,
                    name: 'None'
                }, {
                    from: 1,
                    to: 50,
                    name: '1 - 50'
                }, {
                    from: 51,
                    to: 100,
                    name: '51 - 100'
                }, {
                    from: 101,
                    to: 500,
                    name: '101 - 500'
                }, {
                    from: 501,
                    to: 1000,
                    name: '501 - 1000'
                }, {
                    from: 1001,
                    to: 5000,
                    name: '1001 - 5000'
                }, {
                    from: 5000,
                    name: '5000 or more'
                }]
            },
            series: [{
                animation: {
                    duration: 1000
                },
                data: map_data,
                joinBy: ['postal-code', 'code'],
                states: {
                    hover: {
                        color: '#0069b4'
                    }
                },
                dataLabels: {
                    enabled: true,
                    color: '#FFFFFF',
                    format: '{point.code}'
                },
                name: 'Stats',
                tooltip: {
                    headerFormat: '',
                    pointFormat: '<b>{point.name}</b><br/><br/>Total: {point.total} <br/>Positive: {point.positive}  <br/>Negative: {point.negative} <br/>Deaths: {point.deaths} <br/>Hospitalized: {point.hospitalized} <br/>Last Updated: {point.lastUpdateEt}'
                }
            }]
        });
    }

    // Smooth Scroll
    $(function () {
        $('a[href*="#"]:not([href="#"])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 90
                    }, 1000);
                    return false;
                }
            }
        });
    });

    $('.media_full').hide();

    $('.hf-gl-item .hf-gl-item-img img, .hf-gl-item .hf-gl-item-heading').click(function (e) {
        e.stopPropagation();
        var currImg;
        if($(this).hasClass('hf-gl-item-heading')) {
            currImg = $(this).closest('.hf-gl-item').find('.hf-gl-item-img img');
        } else {
            currImg = $(this);
        }
        var src = $(currImg).attr('src');

        $('.media_full').fadeIn(500);
        $('.img_view img').attr('src', src);

        if($(currImg).closest('.hf-gl-item').find('.img-desc').length) {
            $('.media_full').find('.img-desc').html($(currImg).closest('.hf-gl-item').find('.img-desc').html()).show();
        } else {
            $('.media_full').find('.img-desc').html('').hide();
        }

        $('.prev').off('click').click(function () {
            if ($(currImg).closest('.img-col').prev().find('.hf-gl-item-img img').length) {
                $(currImg).closest('.img-col').prev().find('.hf-gl-item-img img').trigger('click');
            }
            else{
                $('.hf_gallery_thumb:last').trigger('click');
            }

        });

        $('.next').off('click').click(function () {
            if ($(currImg).closest('.img-col').next().find('.hf-gl-item-img img').length) {
                $(currImg).closest('.img-col').next().find('.hf-gl-item-img img').trigger('click');
            }
            else{
                $('.hf_gallery_thumb:first').trigger('click');
            }
        });

    });
    $('.view_close').click(function () {
        $('.media_full').fadeOut(500);
    });

})(jQuery); // Fully reference jQuery after this point.

