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

/*
This example/starter plugin can be used to speed up Visual Composer plugins creation process.
More information can be found here: http://kb.wpbakery.com/index.php?title=Category:Visual_Composer
*/

// don't load directly
if (!defined('ABSPATH')) die('-1');

if ( ! class_exists( 'MipTheme_VCExtendAddonClass_WcBlock1' ) ) { 

    class MipTheme_VCExtendAddonClass_WcBlock1 {
        
        function __construct() {
            // We safely integrate with VC with this hook
            add_action( 'init', array( $this, 'integrateWithVC' ) );
     
            // Use this when creating a shortcode addon
            add_shortcode( 'mp_wcblock_1', array( $this, 'renderMyWcBlock1' ) );
    
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
                "name" => __("WooCommerce Layout 1", 'vc_extend'),
                "base" => "mp_wcblock_1",
                "class" => "",
                "controls" => "full",
                "icon" => 'mp_icon', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
                "category" => __('WooCommerce', 'vc_extend'),
                "params" => array(
                    
                    array(
                        "param_name" => "section_title",
                        "type" => "textfield",
                        "value" => '',
                        "holder" => "div",
                        "heading" => __("Block Title:", 'vc_extend'),
                        "description" => __("This is an optional field", 'vc_extend'),
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "section_link",
                        "type" => "textfield",
                        "value" => '',
                        "holder" => "div",
                        "heading" => __("Block Title Link:", 'vc_extend'),
                        "description" => __("This is an optional field", 'vc_extend'),
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "category_id",
                        "type" => "dropdown",
                        "value" => MipTheme_Util::get_wc_categories_array(),
                        "heading" => __("Category filter", 'vc_extend') .':',
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "category_multiple_id",
                        "type" => "textfield",
                        "value" => '',
                        "heading" => __("Multiple categories filter:", 'vc_extend'),
                        "description" => "(e.g.: 5,12,27); One or more category ids separated by commas",
                        "holder" => "div",
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "section_style",
                        "type" => "dropdown",
                        "value" => array(
                            'Dark' => 'dark',
                            'Light' => 'light',
                        ),
                        "heading" => __("Section Style:", 'vc_extend'),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "add_to_cart_button",
                        "type" => "dropdown",
                        "value" => array(
                            'Show' => '1',
                            'Don\'t show' => '0',
                        ),
                        "heading" => __("Add to Cart Button", 'vc_extend'),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
                    
                    array(
                        "param_name" => "post_sort",
                        "type" => "dropdown",
                        "value" => array(
                            'Latest' => 'date',
                            'Random posts' => 'rand',
                            'By name' => 'name',
                            'Last Modified' => 'modified',
                            'Most Commented' => 'comment_count'
                        ),
                        "heading" => __("Sort order:", 'vc_extend'),
                        "description" => "",
                        "holder" => "div",
                        "class" => ""
                    ),
    
                    array(
                        "param_name" => "post_limit",
                        "type" => "textfield",
                        "value" => '4',
                        "heading" => __("Posts per page:", 'vc_extend'),
                        "description" => "e.g.: 4; a integer number, used to display the number of posts per page",
                        "holder" => "div",
                        "class" => ""
                    ),
    
                    array(
                        "param_name" => "post_offset",
                        "type" => "textfield",
                        "value" => '0',
                        "heading" => __("Offset:", 'vc_extend'),
                        "description" => "e.g.: 3; a integer number of post to displace or pass over",
                        "holder" => "div",
                        "class" => ""
                    ),
                    
                )
            ) );
        }
        
        /*
        Shortcode logic how it should be rendered
        */
        public function renderMyWcBlock1( $atts, $content = null ) {
            
            global $post, $mp_weeklynews;
            $page_sidebar_pos           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        : (isset($mp_weeklynews['_mp_page_sidebar_position']) ? $mp_weeklynews['_mp_page_sidebar_position'] : '');
            
            switch ($page_sidebar_pos) {
                case 'multi-sidebar':
                    //$image_post_format_first    = 'post-thumb-8';
                    $image_post_format_first    = array(118,118);
                    $image_post_first_width     = '118';
                    $image_post_first_height    = '118';
                break;
                default:
                    //$image_post_format_first    = 'post-thumb-8';
                    $image_post_format_first    = array(170,170);
                    $image_post_first_width     = '170';
                    $image_post_first_height    = '170';
                break;
            }
            
            $image_post_dummy_first = ''. $image_post_first_width .'x'. $image_post_first_height .'';
            
            extract( shortcode_atts( array(
                'category_id' => '',
                'category_multiple_id' => '',
                'post_sort' => 'date',
                'post_limit' => '4',
                'post_offset' => '0',
                'section_title' => '',
                'section_link' => '',
                'section_style' => '',
                'add_to_cart_button' => ''
            ), $atts ) );
          
            if (!empty($category_id) and empty($category_multiple_id)) {
                $category_multiple_id = $category_id;
            } else {
                $category_multiple_id = explode(',', $category_multiple_id);
            }
    
            $r = new WP_Query(
                apply_filters( 'block1_posts_args', array(
                        'post_type'         => 'product',
                        'tax_query' 	=> array(
                            array(
                                'taxonomy' 		=> 'product_cat',
                                'terms' 		=> $category_multiple_id,
                                'field' 		=> 'id',
                            )
                ),
                        'posts_per_page'        => $post_limit,
                        'offset'                => $post_offset,
                        'no_found_rows'         => true,
                        'post_status'           => 'publish',
                        'ignore_sticky_posts'   => true,
                        'orderby'               => $post_sort
                    )
                )
            );
    
            $output = '';
            
            if ($r->have_posts()) :
                $post_counter = 0;
                
                $section_style  = ( $section_style == 'dark' ) ? 'cat-products news-lay-2' : 'news-lay-4';
                
                $output .= '<section class="woocommerce section-full top-padding news-layout '. $section_style .'">'. ( ( $section_title != '' ) ? '<header><h2>'. ( ( $section_link != '' ) ? '<a href="'. $section_link .'">'. $section_title .'</a>' : $section_title ) .'</h2><span class="borderline"></span></header>' : '' );
                        
                while ( $r->have_posts() ) :
                    $r->the_post();
                    $category = get_the_category();
                
                    $product = get_product($r->post);
                
                    $post_article                                   = new MipTheme_Article();
                    $post_article->article_link                     = $post->ID;
                    $post_article->article_title                    = $r->post->post_title;
                    $post_article->article_price                    = $product->get_price_html();
                    $post_article->article_review_score             = $product->get_average_rating();
                    $post_article->article_add_to_cart              = $add_to_cart_button;
                    
                    $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_first);
                    $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $image_post_dummy_first );
    
                    if ( $post_counter%4 == 0 ) {
                        if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';
                        $output .= '<!-- start:row --><div class="row">';
                    }
                    
                    $output .= '<div class="col-xs-6 col-sm-3">';
                    // format output
                    $output .= $post_article->formatWooArticle1($image_post_first_width, $image_post_first_height);
                    
                    $output .= '</div>';
                    
                    $post_counter++;
                endwhile;
                if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';
                
                $output .= '</section>';
    
            endif;
            wp_reset_postdata();
         
            return $output;
        } 
        /*
        Load plugin css and javascript files which you may need on front end of your site
        */
        /*public function loadCssAndJs() {
          wp_register_style( 'vc_extend_style', plugins_url('assets/vc_extend.css', __FILE__) );
          wp_enqueue_style( 'vc_extend_style' );
    
          // If you need any javascript files on front end, here is how you can load them.
          //wp_enqueue_script( 'vc_extend_js', plugins_url('assets/vc_extend.js', __FILE__), array('jquery') );
        }*/
    
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
    new MipTheme_VCExtendAddonClass_WcBlock1();
    
}