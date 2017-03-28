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

if ( ! class_exists( 'MipTheme_VCExtendAddonClass_Carousel1' ) ) {

	class MipTheme_VCExtendAddonClass_Carousel1 {

		function __construct() {
			// We safely integrate with VC with this hook
			add_action( 'init', array( $this, 'integrateWithVC' ) );

			// Use this when creating a shortcode addon
			add_shortcode( 'mp_carousel_1', array( $this, 'renderMyCarousel1' ) );

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
				"name" => __("Photo carousel", 'vc_extend'),
				"base" => "mp_carousel_1",
				"class" => "",
				"controls" => "full",
				"icon" => 'mp_icon', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
				"category" => __('Content', 'vc_extend'),
				"params" => array(

					array(
				'type' => 'textfield',
				'heading' => __( 'Carousel title', 'vc_extend' ),
				'param_name' => 'carousel_title',
				'description' => __( 'Enter text which will be used as carousel title. Leave blank if no title is needed.', 'vc_extend' )
			),
			array(
				'type' => 'attach_images',
				'heading' => __( 'Select images', 'vc_extend' ),
				'param_name' => 'carousel_images',
				'value' => '',
				'description' => __( 'Select images from media library.', 'vc_extend' )
			),
					array(
				'type' => 'dropdown',
				'heading' => __( 'Auto Start', 'vc_extend' ),
				'param_name' => 'carousel_start',
				'value' => array(
					__( 'Yes', 'vc_extend' ) => 'true',
					__( 'No', 'vc_extend' ) => 'false'
				),
				'description' => __( 'Do you want the carousel to start automatically?', 'vc_extend' )
			),

				)
			) );
		}

		/*
		Shortcode logic how it should be rendered
		*/
		public function renderMyCarousel1( $atts, $content = null ) {

			global $post, $mp_weeklynews;

			extract( shortcode_atts( array(
				'carousel_title' => '',
				'carousel_images' => '',
				'carousel_start' => '',
			), $atts ) );

			$output                 = '';

			if ( $carousel_images != '' ) :

				$carousel_images    = explode( ',', $carousel_images );
				$carousel_id        = MipTheme_Util::getCarouselIndex();

				$output             .=  '<aside id="module-carousel-'. $carousel_id .'" class="widget module-carousel">
										'. ( ( $carousel_title != '' ) ? '<header><h2>'. $carousel_title .'</h2><span class="borderline"></span></header>' : '' ) .'
											<div class="wrapper">';

				$page_sidebar_pos   = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        	? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        : $mp_weeklynews['_mp_page_sidebar_position'];
				$page_sidebar_pos   = ( $page_sidebar_pos == 'multi-sidebar mid-left' )                                         ? 'multi-sidebar' : $page_sidebar_pos;
	            $page_sidebar_pos   = ( ($page_sidebar_pos == 'left-sidebar') || ($page_sidebar_pos == 'right-sidebar') )       ? 'sidebar' : $page_sidebar_pos;

				$first_image_attr   = new MipTheme_ImageCat();
        		$first_image        = $first_image_attr->get_image_attr_carousel($page_sidebar_pos .'-1');

				$image_post_format_thumb    = $first_image[0];
				$image_post_first_width     = $first_image[1];
				$image_post_first_height    = $first_image[2];


				foreach ( $carousel_images as $attachment_id ):

					$attachment = get_post( $attachment_id );

					$att_img_src_thumb          = wp_get_attachment_image_src( $attachment->ID, $image_post_format_thumb);
					$att_img_src_zoom           = wp_get_attachment_image_src( $attachment->ID, 'full');

					$url_thumb                  = $att_img_src_thumb[0];
					$url_zoom                   = $att_img_src_zoom[0];

						$output     .= '<div style="float:left;height:'. $image_post_first_height .'px;"><figure>
											<a class="pix" href="'. esc_url($url_zoom) .'" title="'. esc_attr( $attachment->post_title ) .'"><img src="'. $url_thumb .'" width="'. $image_post_first_width .'" height="'. $image_post_first_height .'" alt="'. esc_attr( $attachment->post_title ) .'" class="img-responsive"><div class="zoomix"><i class="fa fa-search"></i></div></a>
											<figcaption>
												<span class="car-index">'. ( (is_rtl()) ? '<strong>'. count($carousel_images) .'</strong> '. __('of', THEMENAME) .' <strong class="index">1</strong>' : '<strong class="index">1</strong> '. __('of', THEMENAME) .' <strong>'. count($carousel_images) .'</strong>' ) .'</span>
												<span class="car-title">'. $attachment->post_title .'</span>
												<span class="nav">
													<a class="prev" href="#"><i class="fa fa-chevron-left"></i></a>
													<a class="pix" href="#"><i class="fa fa-expand"></i></a>
													<a class="next" href="#"><i class="fa fa-chevron-right"></i></a>
												</span>
											</figcaption>
										</figure></div>';

				endforeach;

			$output             .= '    </div>
									</aside>
									<script>
										"use strict";
										var initModuleCarousel  = true;
										var modCarHeight        = '. $image_post_first_height .';
										var modCarAutoStart     = '. (($carousel_start == '') ? 'true' : 'false') .';
									</script>';

			endif;


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
	new MipTheme_VCExtendAddonClass_Carousel1();

}
