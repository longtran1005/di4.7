<?php
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
?>