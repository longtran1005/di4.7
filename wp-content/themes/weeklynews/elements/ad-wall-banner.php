<?php
    global $mp_weeklynews;
    
    if (is_home()) {
        if ( isset($mp_weeklynews['_mp_ads_home_wall']) && ( $mp_weeklynews['_mp_ads_home_wall'] != '') ) {
            $banner_id    = $mp_weeklynews['_mp_ads_home_wall'];
            
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
    
    } else if (function_exists('is_woocommerce') && is_woocommerce()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_woocommerce_wall']) ? $mp_weeklynews['_mp_ads_woocommerce_wall'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (is_single()) {
        
        $banner_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_wall_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_wall_single')      : (isset($mp_weeklynews['_mp_ads_posts_wall']) ? $mp_weeklynews['_mp_ads_posts_wall'] : '');
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (is_page()) {
        
        $banner_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_wall_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_wall_single')      : (isset($mp_weeklynews['_mp_ads_page_wall']) ? $mp_weeklynews['_mp_ads_page_wall'] : '');
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (is_category()) {
        
        $curr_cat_id    = get_query_var('cat');        
        $banner_id      =(isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_wall'])&&($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_wall'] != ''))      ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_wall']      : (isset($mp_weeklynews['_mp_ads_cat_wall']) ? $mp_weeklynews['_mp_ads_cat_wall'] : '');

        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (is_author()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_author_wall']) ? $mp_weeklynews['_mp_ads_author_wall'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (is_archive()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_archive_wall']) ? $mp_weeklynews['_mp_ads_archive_wall'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    } else if (function_exists('is_bbpress') && is_bbpress()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_bbpress_wall']) ? $mp_weeklynews['_mp_ads_bbpress_wall'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatWallAd();
        }
        
    }
    
?>