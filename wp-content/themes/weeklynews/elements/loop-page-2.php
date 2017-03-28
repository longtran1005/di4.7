<?php
    global  $category,
            $page_sidebar_pos,
            $featured_video_url,
            $featured_video_embed,
            $featured_audio_embed,
            $curr_post_img,
            $review_post,
            $review_post_position,
            $enable_postmeta,
            $enable_breadcrumbs,
            $show_category_feat_img,
            $featured_image_height_limit,
            $ads_post_section_one,
            $ads_post_section_two,
            $mp_weeklynews;

    $curr_post_img  = '';
    $format = get_post_format();

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
    else :
        //check for thumbnail
        if ( has_post_thumbnail() ) :

            $featured_image             = new MipTheme_Image();
            $featured_image_attr        = $featured_image->get_image_loop_page_1($page_sidebar_pos, $featured_image_height_limit);
            $curr_post_img              = $featured_image_attr[0];

            $img_attr = array(
                'class' => "entry-thumb img-responsive",
                'alt'   => trim( strip_tags( get_the_title() ) )
            );

?>
<div class="head-image thumb-wrap">
    <?php
        if ( $format == 'image' ) {
            $att_img_zoom       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
            $post_feat_image    = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumb-1' );
            $img_zoom           = $att_img_zoom[0];
            echo    '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <div class="zoom-photo"><a href="'. esc_url($img_zoom) .'">'. get_the_post_thumbnail( $post->ID, $curr_post_img, $img_attr ) .'<div class="zoomix"><i class="fa fa-search"></i></div></a></div>
                        <meta itemprop="url" content="' .  $post_feat_image[0] . '">
                        <meta itemprop="width" content="770">
                        <meta itemprop="height" content="470">
                    </div>';
        } else {
            $post_feat_image    = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumb-1' );
            echo    '<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        '. get_the_post_thumbnail( $post->ID, $curr_post_img, $img_attr ) .'
                        <meta itemprop="url" content="' .  $post_feat_image[0] . '">
                        <meta itemprop="width" content="770">
                        <meta itemprop="height" content="470">
                    </div>';
        }

        if ( $show_category_feat_img ) echo '<a href="'. get_category_link( $category[0]->term_id ) .'" class="theme">'. $category[0]->name .'</a>';
    ?>
</div>
<?php
        if ( get_post_meta( get_the_ID(), '_mp_featured_image_caption', true ) ) {
            echo '<div class="featured-caption">'. get_post_meta( get_the_ID(), '_mp_featured_image_caption', true ) .'</div>';
        }

        endif;
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
