( function() {
    tinymce.PluginManager.add( 'mp_shortcodes', function( editor, url ) {

        editor.addCommand("mpPopup", function ( a, params )
        {
            var popup = params.identifier;
            tb_show("Shortcodes", url + "/popup.php?popup=" + popup + "&width=" + 800);
        });

        editor.addButton( 'mp_button_shortcodes', {
            type: 'listbox',
            text: 'Shortcodes',
            classes: 'mp_tinymce_shortcode_dropdown widget btn',
            icon: false,
            onselect: function(e) {
            },
            values: [
                {text: 'Alert',onclick:function(){
                    editor.execCommand("mpPopup", false, {title: 'Alert',identifier: 'miptheme_alert'})
                }},
                {text: 'Dropcap',onclick:function(){
                    editor.execCommand("mpPopup", false, {title: 'Dropcap',identifier: 'miptheme_dropcap'})
                }},
                {text: 'List',onclick:function(){
                    editor.execCommand("mpPopup", false, {title: 'List',identifier: 'miptheme_list'})
                }},
                {text: 'Quote',onclick:function(){
                    editor.execCommand("mpPopup", false, {title: 'Quote',identifier: 'miptheme_quote'})
                }},
                {text: 'Spacer',onclick:function(){
                    editor.execCommand("mpPopup", false, {title: 'Spacer',identifier: 'miptheme_spacer'})
                }},
                {text: 'Columns', classes: 'mp_tinymce_dropdown_title'},
                {text: '[1/1]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="1/1"]Add content here[/vc_column][/vc_row]');
                }},
                {text: '[1/2]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="1/2"]Add content here[/vc_column][vc_column width="1/2"]Add content here[/vc_column][/vc_row]');
                }},
                {text: '[1/3]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="1/3"]Add content here[/vc_column][vc_column width="1/3"]Add content here[/vc_column][vc_column width="1/3"]Add content here[/vc_column][/vc_row]');
                }},
                {text: '[2/3 - 1/3]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="2/3"]Add content here[/vc_column][vc_column width="1/3"]Add content here[/vc_column][/vc_row]');
                }},
                {text: '[1/3 - 2/3]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="1/3"]Add content here[/vc_column][vc_column width="2/3"]Add content here[/vc_column][/vc_row]');
                }},
                {text: '[1/4]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[vc_row][vc_column width="1/4"]Add content here[/vc_column][vc_column width="1/4"]Add content here[/vc_column][vc_column width="1/4"]Add content here[/vc_column][vc_column width="1/4"]Add content here[/vc_column][/vc_row]');
                }},
                {text: 'Reviews (only if enabled)', classes: 'mp_tinymce_dropdown_title'},
                {text: '[Add Review]', onclick : function() {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, '[review]');
                }},

            ]
        });

    } );

})(jQuery);
