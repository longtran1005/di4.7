jQuery(document).ready( function($) {
    
    $('.color-picker').on('focus', function(){
        var parent = $(this).parent();
        $(this).wpColorPicker()
        parent.find('.wp-color-result').click();
    }); 
    
    // init color picker
    $('.mp-color-field').wpColorPicker();
    
    $('.edit-menu-item-articles-type').each(function() {
        if ($(this).val() === 'default') {
            $(this).parent().parent().parent().find('.articles-cats').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-tag').slideDown(250);
            $(this).parent().parent().parent().find('.articles-offset').slideDown(250);
        } else if (($(this).val() === 'custom')||($(this).val() === 'review')) {
            $(this).parent().parent().parent().find('.articles-cats').slideDown(250);
            $(this).parent().parent().parent().find('.articles-tag').slideDown(250);
            $(this).parent().parent().parent().find('.articles-offset').slideDown(250);
        } else {
            $(this).parent().parent().parent().find('.articles-cats').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-tag').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-offset').slideUp('fast');
        }
    });
    
    $('.edit-menu-item-articles-type').on('change', function() {
        if ($(this).val() === 'default') {
            $(this).parent().parent().parent().find('.articles-cats').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-tag').slideDown(250);
            $(this).parent().parent().parent().find('.articles-offset').slideDown(250);
        } else if (($(this).val() === 'custom')||($(this).val() === 'review')) {
            $(this).parent().parent().parent().find('.articles-cats').slideDown(250);
            $(this).parent().parent().parent().find('.articles-tag').slideDown(250);
            $(this).parent().parent().parent().find('.articles-offset').slideDown(250);
        } else {
            $(this).parent().parent().parent().find('.articles-cats').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-tag').slideUp('fast');
            $(this).parent().parent().parent().find('.articles-offset').slideUp('fast');
        }
    });


});
