<?php
    global $mp_weeklynews;
    
    if (is_home()) {
        if ( isset($mp_weeklynews['_mp_ads_home_top']) && ( $mp_weeklynews['_mp_ads_home_top'] != '') ) {
            $banner_id    = $mp_weeklynews['_mp_ads_home_top'];
            
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
    
    } else if (function_exists('is_woocommerce') && is_woocommerce()) {

        $banner_id    = isset($mp_weeklynews['_mp_ads_woocommerce_top']) ? $mp_weeklynews['_mp_ads_woocommerce_top'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (is_single()) {

        $banner_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_top_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_top_single')      : (isset($mp_weeklynews['_mp_ads_posts_top']) ? $mp_weeklynews['_mp_ads_posts_top'] : '');
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (is_page()) {
       
        $banner_id      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_top_single')      ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_page_top_single')      : (isset($mp_weeklynews['_mp_ads_page_top']) ? $mp_weeklynews['_mp_ads_page_top'] : ''); 
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (is_category()) {
        
        $curr_cat_id    = get_query_var('cat');        
        $banner_id      = (isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_top'])&&($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_top'] != ''))      ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_top']      : (isset($mp_weeklynews['_mp_ads_cat_top']) ? $mp_weeklynews['_mp_ads_cat_top'] : ''); 

        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (is_author()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_author_top']) ? $mp_weeklynews['_mp_ads_author_top'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (is_archive()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_archive_top']) ? $mp_weeklynews['_mp_ads_archive_top'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    } else if (function_exists('is_bbpress') && is_bbpress()) {
        
        $banner_id    = isset($mp_weeklynews['_mp_ads_bbpress_top']) ? $mp_weeklynews['_mp_ads_bbpress_top'] : '';
        
        if ( $banner_id ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$banner_id;
            // display ad unit
            echo $ad_unit->formatTopAd();
        }
        
    }
    
?>