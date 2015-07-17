$('#faq-questions li a').each( function() {
    $(this).click( function(){
        $('#faq-questions li div.faq-current').removeClass('faq-current');
        $(this).parent().children('div.hidden:hidden').show('fast').addClass('faq-current');
        $('#faq-questions li div.hidden:visible:not(.faq-current)').hide('fast');
        return false;
     });
});
