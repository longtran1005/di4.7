<?php
    global  $category,
            $featured_video_url,
            $featured_audio_embed,
            $review_post,
            $review_post_position,
            $enable_postmeta,
            $enable_breadcrumbs,
            $ads_post_section_one,
            $ads_post_section_two,
            $featured_video_embed;
            
    $curr_post_img  = '';
    $format         = get_post_format();
?>

<?php
    // ads sextion one
    if ( $ads_post_section_one ) {
        $ad_unit        = new MipTheme_Ad();
        $ad_unit->id    = (int)$ads_post_section_one;
        // display ad unit
        echo $ad_unit->formatLayoutAd();
    }
?>

<?php
    //include header title
    get_template_part('elements/parts/post-header-title');
?>

<?php  
    if ( $featured_video_url ) :
?>

<!-- start:cover video -->
<div class="head-video relative">
    <?php
        $featured_video = new MipTheme_Video();
        echo $featured_video->renderVideo( $featured_video_url );
    ?>
</div>
<!-- end:cover video -->

<?php
    elseif ( $featured_video_embed != '' ) :
?>

<!-- start:cover video -->
<div class="head-video relative">
    <?php
        echo $featured_video_embed;
    ?>
</div>
<!-- end:cover video -->

<?php
    //check for post format - audio
    elseif ( ($format == 'audio')&&($featured_audio_embed != '') ) :
?>

<!-- start:cover audio -->
<div class="head-video relative">
    <?php
        echo $featured_audio_embed;
    ?>
</div>
<!-- end:cover audio -->

<?php
    endif;
    
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