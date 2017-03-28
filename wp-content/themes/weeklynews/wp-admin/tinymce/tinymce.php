<?php

function miptheme_add_tinymce() {
    global $typenow;

    if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        return ;

    add_filter( 'mce_external_plugins', 'miptheme_add_tinymce_plugin' );
    add_filter( 'mce_buttons', 'miptheme_add_tinymce_button' );
}

function miptheme_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['mp_shortcodes'] = get_template_directory_uri() . '/wp-admin/tinymce/customcodes.js';
    return $plugin_array;
}

function miptheme_add_tinymce_button( $buttons ) {
    array_push( $buttons, 'mp_button_shortcodes' );
    return $buttons;
}

add_action( 'admin_head', 'miptheme_add_tinymce' );


function miptheme_add_formats( $init_array ) {
    $formats = array(

        array(
            'title' => 'lead content',
            'block' => 'div',
            'classes' => 'lead',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢ content ⇠',
            'block' => 'div',
            'classes' => 'padding-style-1',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢ content',
            'block' => 'div',
            'classes' => 'padding-style-1-left',
            'wrapper' => true,
        ),

        array(
            'title' => 'content ⇠',
            'block' => 'div',
            'classes' => 'padding-style-1-right',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢⇢ content ⇠⇠',
            'block' => 'div',
            'classes' => 'padding-style-2',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢⇢ content',
            'block' => 'div',
            'classes' => 'padding-style-2-left',
            'wrapper' => true,
        ),

        array(
            'title' => 'content ⇠⇠',
            'block' => 'div',
            'classes' => 'padding-style-2-right',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢⇢ content ⇠',
            'block' => 'div',
            'classes' => 'padding-style-3',
            'wrapper' => true,
        ),

        array(
            'title' => '⇢ content ⇠⇠',
            'block' => 'div',
            'classes' => 'padding-style-4',
            'wrapper' => true,
        ),

        array(
            'title' => 'Flex content',
            'block' => 'div',
            'classes' => 'flex-container',
            'wrapper' => true,
        ),

    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $formats );

    return $init_array;
}

add_filter( 'tiny_mce_before_init', 'miptheme_add_formats' );


function miptheme_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}

add_filter('mce_buttons_2', 'miptheme_mce_buttons_2');


/* Add Page Brak button */
add_filter( 'mce_buttons', 'miptheme_add_next_page_button', 1, 2 ); // 1st row
function miptheme_add_next_page_button( $buttons, $id ){

    /* only add this for content editor */
    if ( 'content' != $id )
        return $buttons;

    /* add next page after more tag button */
    array_splice( $buttons, 13, 0, 'wp_page' );

    return $buttons;
}

/* Add Scripts */
add_action('admin_init', 'admin_init_shortcodes_scripts');
function admin_init_shortcodes_scripts()
{
	wp_enqueue_style( 'miptheme-popup', get_template_directory_uri() . '/wp-admin/css/popup.css', false, '1.0', 'all' );
	wp_enqueue_script( 'miptheme-shortcodes', get_template_directory_uri() . '/wp-admin/js/shortcodes.min.js', false, '1.0', false );
}
