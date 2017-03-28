<?php
/**
 * Hook in on activation
 */

/**
 * Define image sizes
 */
if ( ! function_exists( 'miptheme_woocommerce_image_dimensions' ) ) {
    function miptheme_woocommerce_image_dimensions() {
	global $pagenow;
    
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}
    
	$catalog = array(
	    'width' 	=> '170',	// px
	    'height'	=> '170',	// px
	    'crop'		=> 1 		// true
	);
    
	$single = array(
	    'width' 	=> '370',	// px
	    'height'	=> '370',	// px
	    'crop'		=> 1 		// true
	);
    
	$thumbnail = array(
	    'width' 	=> '114',	// px
	    'height'	=> '114',	// px
	    'crop'		=> 0 		// false
	);
    
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
    }
}

if ( ! function_exists( 'woo_related_products_limit' ) ) {
    function woo_related_products_limit() {
	global $product;
	    
	$args['posts_per_page'] = 4;
	return $args;
    }
}
