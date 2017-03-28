<?php
/*
Plugin Name: Extend Visual Composer Plugin Example
Plugin URI: http://wpbakery.com/vc
Description: Extend Visual Composer with your own set of shortcodes.
Version: 0.1.1
Author: WPBakery
Author URI: http://wpbakery.com
License: GPLv2 or later
*/

class VCExtendAddonClass_Spacer {
    function __construct() {
        // We safely integrate with VC with this hook
        add_action( 'init', array( $this, 'integrateWithVC' ) );
 
        // Use this when creating a shortcode addon
        add_shortcode( 'mp_spacer', array( $this, 'renderMySpacer' ) );

        // Register CSS and JS
        //add_action( 'wp_enqueue_scripts', array( $this, 'loadCssAndJs' ) );
    }
 
    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
        /*
        Add your Visual Composer logic here.
        Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

        More info: http://kb.wpbakery.com/index.php?title=Vc_map
        */
        vc_map( array(
            "name" => __("Empty Spacer", 'vc_extend'),
            "description" => __("Give elements some space", 'vc_extend'),
            "base" => "mp_spacer",
            "class" => "",
            "controls" => "full",
            "icon" => 'mp_icon', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => __('Content', 'js_composer'),
            "params" => array(
                
                array(
                    "param_name" => "empty_spacer",
                    "type" => "textfield",
                    "value" => '',
                    "heading" => __("Set spacer height", 'vc_extend'),
                    "description" => "e.g.: 25; a integer number, used to give space (in px) between elements",
                    "holder" => "div",
                    "class" => ""
                )
                
            )
        ) );
    }
    
    /*
    Shortcode logic how it should be rendered
    */
    public function renderMySpacer( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'empty_spacer' => '0'
        ), $atts ) );
      
        if ( $empty_spacer && ($empty_spacer != 0) ) {
            $output = '<div class="clearfix" style="height:'. $empty_spacer .'px;"></div>';
        }
     
        return $output;
    }

    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
        </div>';
    }
}
// Finally initialize code
new VCExtendAddonClass_Spacer();