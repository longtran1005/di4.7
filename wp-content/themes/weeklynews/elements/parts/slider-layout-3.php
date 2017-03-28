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
        $post_article->article_comments_count           = $r->post->comment_count;
        
        
        if ( $post_counter == 1 ) echo '<div class="row">';

        // format output
        if ( $post_counter < 3 ) {
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), array(584,350));
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '584x350' );
        
            echo '<div class="col-sm-6">';
            echo $post_article->formatArticleStyle8(584,350);
            echo '</div>';
        } else {
            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), array(390,200));
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '390x200' );
        
            echo '<div class="col-sm-4">';
            echo $post_article->formatArticleStyle8(389,200);
            echo '</div>';
        }

        if ( $post_counter == 5 ) {
            echo '</div>';
            $post_counter = 0;
        }
        $post_counter++;
    endwhile;
    
    if ( ($post_counter <= 6)&&($post_counter > 1) ) {
        echo '</div>';
    }
?>