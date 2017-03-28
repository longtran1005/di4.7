<?php

if ( ! function_exists( 'miptheme_shortcodes_css_class' ) ) {
    function miptheme_shortcodes_css_class($class_string, $tag) {
        if ($tag=='vc_row' || $tag=='vc_row_inner') {
            $class_string = str_replace('vc_row-fluid', 'row-fluid', $class_string);
        }

        if ($tag=='vc_column' || $tag=='vc_column_inner') {
            $class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);
        }

        return $class_string;
    }
}

if (function_exists('vc_disable_frontend')) {
    vc_disable_frontend();
}

if (function_exists('vc_remove_element')) {
    //remove unused styles and visual composer scripts
    add_action( 'wp_print_scripts', 'miptheme_remove_visual_composer_assets', 100 );
}
//end delete code visual composer

function miptheme_remove_visual_composer_assets() {
    global $wp_styles;
    wp_deregister_style('js_composer_front');
}

// add custom templates
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-1.php'); // Block 01
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-2.php'); // Block 02
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-3.php'); // Block 03
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-4.php'); // Block 04
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-9.php'); // Block 05
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-8.php'); // Block 06
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-6.php'); // Block 07
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-5.php'); // Block 08
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-10.php'); // Block 09
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-11.php'); // Block 10
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-12.php'); // Text Block
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-7.php'); // Review Block
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-13.php'); // Block 13
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-14.php'); // Block 14
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-15.php'); // Block 15
require_once(dirname( __FILE__ ) . '/vc/vc-template-block-ads-system.php');
require_once(dirname( __FILE__ ) . '/vc/vc-template-carousel-1.php');

// add custom woocommerce templates
if ( class_exists( 'woocommerce' ) ) {
    require_once(dirname( __FILE__ ) . '/vc/vc-template-wc-block-1.php');
    require_once(dirname( __FILE__ ) . '/vc/vc-template-wc-block-2.php');
    require_once(dirname( __FILE__ ) . '/vc/vc-template-wc-block-3.php');
}
