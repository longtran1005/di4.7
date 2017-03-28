<?php
    global $mp_weeklynews;
    
    $related_box              = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_single')             ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_single')          : $mp_weeklynews['_mp_enable_related_box'];
    
    if ( is_single() && ($related_box == 'enable') ) :
    
        if (function_exists('is_bbpress') && is_bbpress()) {
            return;   
        }
    
        $related_box_float    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_float_single')       ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_float_single')     : $mp_weeklynews['_mp_enable_related_box_float'];
        $related_box_count    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_count_single')       ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_count_single')     : $mp_weeklynews['_mp_enable_related_box_count'];
        $related_box_string   = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_single')             ? '_single'                                                 : '';
?>

<!-- start:related-box -->
<aside class="related-box hidden-xs <?php echo esc_attr($related_box_float); ?>">

<?php
        // loop through sections
        for ( $i = 1; $i <= $related_box_count; $i++ ) {
            
            if ( (redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_single') == 'enable') && ( redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_count_single') != '' ) ) {
                $section_title      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_title_'. $i . $related_box_string);
                $section_filter     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_filter_'. $i . $related_box_string);
                $section_format     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_format_'. $i . $related_box_string);
                $section_sort       = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_sort_'. $i . $related_box_string);
                $section_count      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_count_'. $i . $related_box_string);
                $section_offset     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_box_offset_'. $i . $related_box_string);
            } else {
                $section_title      = $mp_weeklynews['_mp_enable_related_box_title_'. $i .''];
                $section_filter     = $mp_weeklynews['_mp_enable_related_box_filter_'. $i .''];
                $section_format     = $mp_weeklynews['_mp_enable_related_box_format_'. $i .''];
                $section_sort       = $mp_weeklynews['_mp_enable_related_box_sort_'. $i .''];
                $section_count      = $mp_weeklynews['_mp_enable_related_box_count_'. $i .''];
                $section_offset     = $mp_weeklynews['_mp_enable_related_box_offset_'. $i .''];
            }
            
            if ( !empty($section_title) ) echo '<h4>'. $section_title .'</h4>';
            
            // set args
            $args = array();
            
            if ( $section_filter == 'cat' ) {
                // if filter by cat
                $categories = get_the_category($post->ID);
                if ($categories) {
                    $category_ids = array();
                    foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                    $args = array(
                        'category__in'          => $category_ids,
                        'post__not_in'          => array($post->ID),
                        'posts_per_page'        => $section_count,
                        'ignore_sticky_posts'   => 1,
                        'orderby'               => $section_sort,
                        'offset'                => $section_offset,
                        'meta_key'              => ( ($section_sort == 'meta_value_num') ? 'mip_post_views_count' : '' ),
                    );
                }
            } else {
                // if filter by tags
                $tags = wp_get_post_tags($post->ID);
                if ($tags) {
                    $tag_ids    = array();
                    foreach($tags as $individual_tag) {
                        $tag_ids[] = $individual_tag->term_id;
                    }
                    $args=array(
                        'tag__in'               => $tag_ids,
                        'post__not_in'          => array($post->ID),
                        'posts_per_page'        => $section_count,
                        'ignore_sticky_posts '  => 1,
                        'orderby'               => $section_sort,
                        'offset'                => $section_offset,
                        'meta_key'              => ( ($section_sort == 'meta_value_num') ? 'mip_post_views_count' : '' ),
                    );
                }
            }
            
            $r = new WP_Query( $args );
            if( $r->have_posts() ) {
                
                echo '<section>';
                
                while ($r->have_posts()) : $r->the_post();
                
            
                    $post_article                                   = new MipTheme_Article();
                    $post_article->article_link                     = $post->ID;
                    $post_article->article_content                  = $r->post->post_content;
                    $post_article->article_title                    = $r->post->post_title;
                    $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                    
                    $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-3');
                    $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '265x160' );
                    
                    echo $post_article->formatArticleByStyle( $section_format );
                    
                endwhile;
                wp_reset_postdata();
                
                echo '</section>';
            }
            
            
        } // end loop through sections
?>

</aside>
<!-- end:related-box -->

<?php
    endif;
?>