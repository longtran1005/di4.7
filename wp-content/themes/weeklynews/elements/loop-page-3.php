<?php
    
    global  $category,
            $page_sidebar_pos,
            $featured_video_url,
            $featured_audio_embed,
            $format,
            $review_post,
            $review_post_position,
            $enable_postmeta,
            $ads_post_section_one,
            $ads_post_section_two,
            $mp_weeklynews;
    
    $curr_post_img  = '';
    
    if ( ($featured_video_url)||( ($format == 'audio')&&($featured_audio_embed != '') ) ) :
?>

<?php
    //include header title
    get_template_part('elements/parts/post-header-title');
?>

<?php
    endif;
?>

<?php
    // ads sextion two
    if ( $ads_post_section_two ) {
        $ad_unit        = new MipTheme_Ad();
        $ad_unit->id    = (int)$ads_post_section_two;
        // display ad unit
        echo $ad_unit->formatLayoutAd();
    }
?>

<?php
    //include related box
    get_template_part('elements/parts/post-related-box');
    
    //include review
    if ( ($review_post == 'enable')&&($review_post_position == 'top') ) get_template_part('elements/parts/post-review');

    echo '<div class="article-post-content">';
    the_content();
    echo '</div>';

    miptheme_custom_wp_link_pages();
    
    //include related box
    if ( ($review_post == 'enable')&&($review_post_position == 'bottom') ) get_template_part('elements/parts/post-review');
    
    
    //include share buttons and author box
    get_template_part('elements/parts/post-author-box');
?>
