<?php
    global $r, $include_categories, $cat_display, $slider_summary;

    $post_counter = 1;
    while ( $r->have_posts() ) :
        $r->the_post();
        apply_filters("miptheme_unique_posts_filter", $post);
        
        $cats       = MipTheme_Util::return_category( $post->ID, $include_categories, $cat_display );
        
        $post_article                                   = new MipTheme_Article();
        $post_article->cat_ID                           = $cats[0];
        $post_article->cat_name                         = $cats[1];
        $post_article->article_link                     = $post->ID;
        $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
        $post_article->article_title                    = $r->post->post_title;
        $post_article->article_review                   = redux_post_meta('mp_weeklynews', $post->ID, '_mp_enable_review_post');
        //$post_article->article_review_score             = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_score');
        $post_article->article_show_summary             = $slider_summary;
        
        if ( $post_counter == 1 ) echo '<div class="row">';
        
        //check if first post
        if ( $post_counter == 1 ) {
            
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), array(585,480));
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '585x480' );
    
            // format output
?>
    
        <!-- start:col -->
        <div class="col-sm-6">
            
            <?php echo $post_article->formatArticleStyle8(584,479); ?>
    
        </div>
        <!-- end:col -->
        <!-- start:col -->
        <div class="col-sm-6">
            <div class="row">
    
<?php
        } else if ( $post_counter < 6 ) {
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), array(292,240));
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '292x240' );
            
            // format output
            echo '<div class="col-sm-6">'. $post_article->formatArticleStyle6(291,239) .'</div>';

        }

        if ( $post_counter == 5 ) {
            echo '</div></div></div>';
            $post_counter = 0;
        }
        
        $post_counter++;
    endwhile;
    
    if ( ($post_counter <= 5)&&($post_counter > 1) ) {
        echo '</div></div></div>';
    }
?>