<div class="container relative">
<?php
    global $mp_weeklynews;
    
    if (is_home()) {
        
        $banner_left_id      = isset($mp_weeklynews['_mp_ads_home_side_left']) ? $mp_weeklynews['_mp_ads_home_side_left'] : '';
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = isset($mp_weeklynews['_mp_ads_home_side_right']) ? $mp_weeklynews['_mp_ads_home_side_right'] : '';
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
    
    } else if (function_exists('is_woocommerce') && is_woocommerce()) {

        $banner_left_id      = isset($mp_weeklynews['_mp_ads_woocommerce_side_left']) ? $mp_weeklynews['_mp_ads_woocommerce_side_left'] : '';
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = isset($mp_weeklynews['_mp_ads_woocommerce_side_right']) ? $mp_weeklynews['_mp_ads_woocommerce_side_right'] : '';
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (is_single()) {

        $banner_left_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_side_left_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_side_left_single')      : (isset($mp_weeklynews['_mp_ads_posts_side_left']) ? $mp_weeklynews['_mp_ads_posts_side_left'] : '');
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_side_right_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_side_right_single')      : (isset($mp_weeklynews['_mp_ads_posts_side_right']) ? $mp_weeklynews['_mp_ads_posts_side_right'] : '');
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (is_page()) {
       
        $banner_left_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_side_left_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_side_left_single')      : (isset($mp_weeklynews['_mp_ads_page_side_left']) ? $mp_weeklynews['_mp_ads_page_side_left'] : '');
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_side_right_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_side_right_single')      : (isset($mp_weeklynews['_mp_ads_page_side_right']) ? $mp_weeklynews['_mp_ads_page_side_right'] : '');
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (is_category()) {
        
        $curr_cat_id    = get_query_var('cat');        
 
        $banner_left_id      = (isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_left'])&&($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_left'] != ''))      ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_left']      : (isset($mp_weeklynews['_mp_ads_cat_side_left']) ? $mp_weeklynews['_mp_ads_cat_side_left'] : ''); 
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = (isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_right'])&&($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_right'] != ''))      ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_side_right']      : (isset($mp_weeklynews['_mp_ads_cat_side_right']) ? $mp_weeklynews['_mp_ads_cat_side_right'] : ''); 
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (is_author()) {
        
        $banner_left_id      = isset($mp_weeklynews['_mp_ads_author_side_left']) ? $mp_weeklynews['_mp_ads_author_side_left'] : '';
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = isset($mp_weeklynews['_mp_ads_author_side_right']) ? $mp_weeklynews['_mp_ads_author_side_right'] : '';
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (is_archive()) {
        
        $banner_left_id      = isset($mp_weeklynews['_mp_ads_archive_side_left']) ? $mp_weeklynews['_mp_ads_archive_side_left'] : '';
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = isset($mp_weeklynews['_mp_ads_archive_side_right']) ? $mp_weeklynews['_mp_ads_archive_side_right'] : '';
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    } else if (function_exists('is_bbpress') && is_bbpress()) {
        
        $banner_left_id      = isset($mp_weeklynews['_mp_ads_bbpress_side_left']) ? $mp_weeklynews['_mp_ads_bbpress_side_left'] : '';
        if ( $banner_left_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_left_id;
            // display ad unit
            echo $ad_unit->formatLeftSideAd();
        }
        
        $banner_right_id      = isset($mp_weeklynews['_mp_ads_bbpress_side_right']) ? $mp_weeklynews['_mp_ads_bbpress_side_right'] : '';
        if ( $banner_right_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_right_id;
            // display ad unit
            echo $ad_unit->formatRightSideAd();
        }
        
    }
    
      
?>
</div>