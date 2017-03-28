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

if ( ! class_exists( 'MipTheme_VCExtendAddonClass_AdsSystem' ) ) { 

    class MipTheme_VCExtendAddonClass_AdsSystem {
        function __construct() {
            // We safely integrate with VC with this hook
            add_action( 'init', array( $this, 'integrateWithVC' ) );
     
            // Use this when creating a shortcode addon
            add_shortcode( 'mp_ads_system', array( $this, 'renderMyAdsSystem' ) );
    
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
                "name" => __("Advertisement - Ads System", 'vc_extend'),
                "base" => "mp_ads_system",
                "class" => "",
                "controls" => "full",
                "icon" => 'mp_icon', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
                "category" => __('Content', 'js_composer'),
                "params" => array(
                    
                    array(
                        "param_name" => "ads_system_select",
                        "type" => "dropdown",
                        "value" => MipTheme_Util::get_adssystem_array(),
                        "heading" => __("Ad source", 'vc_extend') .':',
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    )
    
                )
            ) );
        }
        
        /*
        Shortcode logic how it should be rendered
        */
        public function renderMyAdsSystem( $atts, $content = null ) {
            
            extract( shortcode_atts( array(
                'ads_system_select' => ''
            ), $atts ) );
    
            
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$ads_system_select;
            // display ad unit
            return $ad_unit->formatLayoutAd();
        }
    
        /*
        Show notice if your plugin is activated but Visual Composer is not
        */
        public function showVcVersionNotice() {
            $plugin_data = get_plugin_data(__FILE__);
            echo '
            <div class="updated">
              <p>'.sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'vc_extend'), $plugin_data['Name']).'</p>
            </div>';
        }
    }
    // Finally initialize code
    new MipTheme_VCExtendAddonClass_AdsSystem();
    
}