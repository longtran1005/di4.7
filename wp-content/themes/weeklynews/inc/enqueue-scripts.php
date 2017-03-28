<?php
if ( ! function_exists( 'miptheme_scripts' ) ) {
    function miptheme_scripts() {
        global $mp_weeklynews;

        wp_enqueue_style( 'miptheme-oldstyle-css-1', get_template_directory_uri() . '/vendor/css/desktopStyles1.css', '', THEMEVERSION, 'all');
        wp_enqueue_style( 'miptheme-oldstyle-css-2', get_template_directory_uri() . '/vendor/css/desktopStyles2.css', '', THEMEVERSION, 'all');
        wp_enqueue_style( 'miptheme-bootstrap', get_template_directory_uri() . '/vendor/css/bootstrap.min.css', '', THEMEVERSION, 'all');
        wp_enqueue_style( 'miptheme-newstyle', get_template_directory_uri() . '/vendor/css/custom.css', '', THEMEVERSION, 'all');

        // Load js scripts
        if ( !is_admin() && isset($mp_weeklynews['_mp_js_jquery_footer']) && (bool)$mp_weeklynews['_mp_js_jquery_footer'] ) {
            wp_deregister_script('jquery');
            wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.11.1', true);
            wp_enqueue_script('jquery');
        }

        // Ajax pagination
        wp_localize_script( 'miptheme-functions', 'miptheme_ajax_url', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' )
        ));
    }
}


if ( ! function_exists( 'miptheme_dynamic_css' ) ) {
    function miptheme_dynamic_css() {
        require(get_template_directory().'/assets/css/dynamic.css.php');
        exit;
    }
}

if ( ! function_exists( 'miptheme_admin_css' ) ) {
    function miptheme_admin_css() {
        wp_enqueue_style('miptheme-admin-css', get_template_directory_uri() . '/wp-admin/css/admin.css', false, THEMEVERSION, 'all' );
        wp_enqueue_script('miptheme-admin-js', get_template_directory_uri() . '/wp-admin/js/admin.js', false, THEMEVERSION, 'all' );
    }
}

if ( ! function_exists( 'miptheme_add_editor_styles' ) ) {
    function miptheme_add_editor_styles() {
        add_editor_style( get_template_directory_uri() . '/wp-admin/css/editor-style.css');
    }
}

// google analytics
if ( ! function_exists( 'miptheme_analytics_code' ) ) {
    function miptheme_analytics_code() {
        global $mp_weeklynews;
        if ( isset($mp_weeklynews['_mp_ga_code']) ) echo '<script>'. stripslashes( $mp_weeklynews['_mp_ga_code'] ) .'</script>';
    }
}

// custom js header
if ( ! function_exists( 'miptheme_custom_js_code_header' ) ) {
    function miptheme_custom_js_code_header() {
        global $mp_weeklynews;
        if ( isset($mp_weeklynews['_mp_js_code_header']) ) echo '<script>'. stripslashes( $mp_weeklynews['_mp_js_code_header'] ) .'</script>';
    }
}

// custom js
if ( ! function_exists( 'miptheme_custom_js_code' ) ) {
    function miptheme_custom_js_code() {
        global $mp_weeklynews;
        if ( isset($mp_weeklynews['_mp_js_code']) ) echo '<script>'. stripslashes( $mp_weeklynews['_mp_js_code'] ) .'</script>';
    }
}
