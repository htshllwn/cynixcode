(function($){
    $.fn.scrollingTo = function( opts ) {
        var defaults = {
            animationTime : 1000,
            easing : '',
            callbackBeforeTransition : function(){},
            callbackAfterTransition : function(){}
        };

        var config = $.extend( {}, defaults, opts );

        $(this).click(function(e){
            var eventVal = e;
            e.preventDefault();

            var $section = $(document).find( $(this).data('section') );
            if ( $section.length < 1 ) {
                return false;
            };

            if ( $('html, body').is(':animated') ) {
                $('html, body').stop( true, true );
            };

            var scrollPos = $section.offset().top;

            if ( $(window).scrollTop() == scrollPos ) {
                return false;
            };

            config.callbackBeforeTransition(eventVal, $section);

            $('html, body').animate({
                'scrollTop' : (scrollPos+'px' )
            }, config.animationTime, config.easing, function(){
                config.callbackAfterTransition(eventVal, $section);
            });
        });
    };

    /* ========================================================================= */
    /*   Contact Form Validating
    /* ========================================================================= */

    $('#login-form').validate({
        rules: {
            enroll: {
                required: true, rangelength:[12,12]
            }
            , pass: {
                required: true
            }
            , 
        }
        , messages: {
            enroll: {
                required: "Enrollment No. is required", rangelength: "Please Enter correct Enrollment Number"
            }
            , pass: {
                required: "Please enter your Password",
            }
            , 
        }
        , submitHandler: function(form) {
            var enroll = document.getElementById("enroll").value;
            var pass = document.getElementById("pass").value;
            //var base_url =  window.location.href;
            //console.log(pass);
            
                $("#loader").fadeIn("fast");
                
    
                $.post( window.location.href,
                {
                    enroll: enroll, 
                    pass: pass
                },
                function(data, status){
                    console.log(data);
                    console.log("Data: " + data.roll_no + "\nStatus: " + status);
                    //console.log(data.split("\n"));
                    //output = data.split("\n");
                    
                    //for(var i = 0; i < output.length; i++){
                    //    $("#output").append(output[i]+"<br>");
                    //}
                    $("#loader").fadeOut("fast");
                });
                
            


            /*
            $(form).ajaxSubmit( {
                type:"POST", data: {
                    enroll: enroll,
                    pass: pass
                }, url: window.location.href, success: function() {
                    //console.log(enroll);
                    $('#login-form #success').fadeIn();
                }
                , error: function() {
                    $('#login-form #error').fadeIn();
                }
            }
            );
            */
        }
    });


}(jQuery));



jQuery(document).ready(function(){
	"use strict";
	new WOW().init();


(function(){
 jQuery('.smooth-scroll').scrollingTo();
}());

});




$(document).ready(function(){

    $(window).scroll(function () {
        if ($(window).scrollTop() > 50) {
            $(".navbar-brand a").css("color","#fff");
            $("#top-bar").removeClass("animated-header");
        } else {
            $(".navbar-brand a").css("color","inherit");
            $("#top-bar").addClass("animated-header");
        }
    });

    $("#clients-logo").owlCarousel({
 
        itemsCustom : false,
        pagination : false,
        items : 5,
        autoplay: true,

    });


});



// fancybox
$(".fancybox").fancybox({
    padding: 0,

    openEffect : 'elastic',
    openSpeed  : 450,

    closeEffect : 'elastic',
    closeSpeed  : 350,

    closeClick : true,
    helpers : {
        title : { 
            type: 'inside' 
        },
        overlay : {
            css : {
                'background' : 'rgba(0,0,0,0.8)'
            }
        }
    }
});






 




