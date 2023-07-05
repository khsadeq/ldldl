 
 $(function () {
    
    'use strict';

//swiitch bettween login & signup 
       $('.login-page h1 span').click(function () {
         $(this).addClass('selected').siblings().removeClass('selected');
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);
    });

   

    //trigger the selectboxit
    $("select").selectBoxIt({
        autoWidth: false
    });
    

    $('[placeholder]').focus(function () {
        
        $(this).attr('data-text', $(this).attr('placeholder'));
        
        $(this).attr('placeholder', '');
        $(this).attr('', $(this).attr('data-text'));
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });



                $('input').each(function () {

                    if ($(this).attr('required') === 'required'){
                        
                        $(this).after('<span class="asterisk">*</span>');
                    }
                });




                    //confirmation message on button
                    $('.confirm').click(function () {

                            return confirm('Are You Sure?');
                            });
                            
                            $('.live').keyup(function (){
                              $($(this).data('class')).text($(this).val());
                        //    $('.live-preview .caption h3').text($(this).val());
                            });
                    //         $('.live-desc').keyup(function (){
                    //         //   console.log($(this).val());
                    //         $('.live-preview .caption p').text($(this).val());
                    //         });
                    //         $('.live-price').keyup(function (){
                    // //         // console.log($(this).val());
                    //         $('.live-preview .price-tag').text('$' + $(this).val());
                    //         });
                            
                            
                          //  $('.live').keyup(function (){
                            // ($(this).data('class')).text($(this).val());
                            //});


});






