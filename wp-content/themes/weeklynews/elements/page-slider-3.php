<?php

    $include_categories     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_categories');
    $posts_sorting          = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_sort');
    $posts_filter_by_tags   = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_tags');
    $posts_count            = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_slides');
    $slider_layout          = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_layout');
    $slider_summary         = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_summary');
    $cat_display            = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_category_display');
    
    $slider_hide_mobile     = (bool)redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_mobile') ? ' hidden-xs' : '';
    
    $post_id                = $post->ID;
    
    $r = new WP_Query(
        apply_filters( 'cat_posts_args', array(
                'category__in'               => $include_categories,
                'posts_per_page'        => $posts_count,
                //'offset'                => $post_offset,
                'tag__in'               => $posts_filter_by_tags,
                'no_found_rows'         => true,
                'post_status'           => 'publish',
                'ignore_sticky_posts'   => true,
                'orderby'               => $posts_sorting
            )
        )
    );
    
    if ($r->have_posts()) :
?>

<!-- start:page slider -->
<div id="page-slider" class="<?php echo esc_attr($slider_layout) . esc_attr($slider_hide_mobile); ?> clearfix">
    
    <!-- start:container -->
    <div class="container">
        
        <!-- start:carousel -->
        <div id="slider-carousel">



<?php

    $post_counter = 1;
    while ( $r->have_posts() ) :

        $r->the_post();
        
        if (!$cat) {
            $category   = get_the_category();
            $cat_id     = $category[0]->cat_ID;
            $cat_name   = $category[0]->cat_name;
            $cats       = MipTheme_Util::return_category( $post->ID, array(), $cat_display );
        } else {
            $cat_id     = $cat;
            $cat_name   = MipTheme_Util::cat_id_to_slug( $cat );
            $cats       = MipTheme_Util::return_category( $post->ID, explode('.', $cat_id), $cat_display );
        }
        
        $post_article                                   = new MipTheme_Article();
        $post_article->cat_ID                           = $cats[0];
        $post_article->cat_name                         = $cats[1];
        $post_article->article_link                     = $post->ID;
        $post_article->article_content                  = $r->post->post_content;
        $post_article->article_title                    = $r->post->post_title;
        $post_article->article_review                   = redux_post_meta('mp_weeklynews', $post->ID, '_mp_enable_review_post');
        //$post_article->article_review_score             = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_score');
        $post_article->article_show_summary             = $slider_summary;
        
        //if ( $post_counter == 1 ) echo '<div class="row">';
        
        //check if first post
        if ( $post_counter == 1 ) {
            
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'slider-big');
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '819x452' );
    
            // format output
?>
    
        <!-- start:col -->
        <div class="item" style="width:819px;">
            
            <?php echo $post_article->formatArticleStyle8(); ?>
    
        </div>
        <!-- end:col -->
        <!-- start:col -->
        <div class="item" style="width:350px;">
    
<?php
        //else - check if first post
        } else {
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'slider-thumb-2');
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '350x150' );
            
            // format output
            echo $post_article->formatArticleStyle6(300,150);
            
        //end - check if first post
        }

        if ( $post_counter == 4 ) {
            echo '</div>';
            $post_counter = 0;
        }
        
        $post_counter++;
    endwhile;
    
    if ( ($post_counter <= 4)&&($post_counter > 1) ) {
        echo '</div>';
    }
?>
        

        </div>
        <!-- end:slider-carousel -->
        
    </div>
    <!-- end:container -->
    
</div>
<!-- end:page slider -->
<script>
    "use strict";
    var initOwlCarousel = true;
<?php
    if ( redux_post_meta(THEMEREDUXNAME, $post_id, '_mp_page_top_slider_autostart') ) {
?>
    var carouselStart    = true;
    var carouselDelay    = <?php echo redux_post_meta(THEMEREDUXNAME, $post_id, '_mp_page_top_slider_autostart_delay'); ?>;
<?php
    } else {
?>
    var carouselStart    = false;
    var carouselDelay    = 0;
<?php
    }
?>    
</script>

<?php        
    endif;
            
    wp_reset_postdata();
?>