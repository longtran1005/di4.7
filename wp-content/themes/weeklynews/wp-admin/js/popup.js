// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var mipthemes = {
        loadVals: function()
        {
            var shortcode = $('#_miptheme_shortcode').text(),
                uShortcode = shortcode;

            // fill in the gaps eg {{param}}
            $('.miptheme-input').each(function() {
                var input = $(this),
                    id = input.attr('id'),
                    id = id.replace('miptheme_', ''),      // gets rid of the miptheme_ prefix
                    re = new RegExp("{{"+id+"}}","g");

                uShortcode = uShortcode.replace(re, input.val());
            });

            // adds the filled-in shortcode as hidden input
            $('#_miptheme_ushortcode').remove();
            $('#miptheme-popup-form-table').prepend('<div id="_miptheme_ushortcode" class="hidden">' + uShortcode + '</div>');
        },
        cLoadVals: function()
        {
            var shortcode = $('#_miptheme_cshortcode').text(),
                pShortcode = '';
                shortcodes = '';

            // fill in the gaps eg {{param}}
            $('.child-clone-row').each(function() {
                var row = $(this),
                    rShortcode = shortcode;

                $('.miptheme-cinput', this).each(function() {
                    var input = $(this),
                        id = input.attr('id'),
                        id = id.replace('miptheme_', '')       // gets rid of the miptheme_ prefix
                        re = new RegExp("{{"+id+"}}","g");

                    rShortcode = rShortcode.replace(re, input.val());
                });

                shortcodes = shortcodes + rShortcode + "\n";
            });

            // adds the filled-in shortcode as hidden input
            $('#_miptheme_cshortcodes').remove();
            $('.child-clone-rows').prepend('<div id="_miptheme_cshortcodes" class="hidden">' + shortcodes + '</div>');

            // add to parent shortcode
            this.loadVals();
            pShortcode = $('#_miptheme_ushortcode').text().replace('{{child_shortcode}}', shortcodes);

            // add updated parent shortcode
            $('#_miptheme_ushortcode').remove();
            $('#miptheme-popup-form-table').prepend('<div id="_miptheme_ushortcode" class="hidden">' + pShortcode + '</div>');
        },
        children: function()
        {
            // assign the cloning plugin
            $('.child-clone-rows').appendo({
                subSelect: '> div.child-clone-row:last-child',
                allowDelete: false,
                focusFirst: false
            });

            // remove button
            $('.child-clone-row-remove').live('click', function() {
                var btn = $(this),
                    row = btn.parent();

                if( $('.child-clone-row').size() > 1 )
                {
                    row.remove();
                }
                else
                {
                    alert('You need a minimum of one row');
                }

                return false;
            });

            // assign jUI sortable
            $( ".child-clone-rows" ).sortable({
                placeholder: "sortable-placeholder",
                items: '.child-clone-row'

            });
        },
        resizeTB: function()
        {
            var ajaxCont = $('#TB_ajaxContent'),
                tbWindow = $('#TB_window'),
                mipthemePopup = $('#miptheme-popup');

            tbWindow.css({
                height: mipthemePopup.outerHeight() + 50,
                width: mipthemePopup.outerWidth(),
                marginLeft: -(mipthemePopup.outerWidth()/2)
            });

            ajaxCont.css({
                paddingTop: 0,
                paddingLeft: 0,
                paddingRight: 0,
                height: (tbWindow.outerHeight()-47),
                overflow: 'auto', // IMPORTANT
                width: mipthemePopup.outerWidth()
            });

            $('#miptheme-popup').addClass('no_preview');
        },
        load: function()
        {
            var mipthemes = this,
                popup = $('#miptheme-popup'),
                form = $('#miptheme-popup-form', popup),
                shortcode = $('#_miptheme_shortcode', form).text(),
                popupType = $('#_miptheme_popup', form).text(),
                uShortcode = '';

            // resize TB
            mipthemes.resizeTB();
            $(window).resize(function() { mipthemes.resizeTB() });

            // initialise
            mipthemes.loadVals();
            mipthemes.children();
            mipthemes.cLoadVals();

            // update on children value change
            $('.miptheme-cinput', form).live('change', function() {
                mipthemes.cLoadVals();
            });

            // update on value change
            $('.miptheme-input', form).change(function() {
                mipthemes.loadVals();
            });

            // when insert is clicked
            $('.miptheme-insert', form).click(function() {
                if(parent.tinymce){
                    parent.tinymce.activeEditor.execCommand('mceInsertContent',false,$('#_miptheme_ushortcode', form).html());
                    tb_remove();
                }
            });
        }
    }

    // run
    $('#miptheme-popup').livequery( function() { mipthemes.load(); } );
});
