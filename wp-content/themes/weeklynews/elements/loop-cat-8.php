<?php
    global $curr_cat_id, $curr_cat_obj, $cat_template_chars, $post_counter, $cat_banner_show, $cat_banner_count, $cat_banner_embed, $cat_sidebar_template, $page_show_posts_num;

    //set counter
    $post_counter = 0;
    $post_article                                   = new MipTheme_Article();

    // set unique posts if enabled
    if ( (bool)MipTheme_UniquePosts::$unique_posts_enabled ) {
        $args = array_merge($wp_query->query_vars, array('post__not_in' => MipTheme_UniquePosts::$unique_posts_ids));
        query_posts( $args );
    }

    $image_post_format_first    = 'post-thumb-3';
    $image_post_first_width     = '265';
    $image_post_first_height    = '160';

    switch ($cat_sidebar_template) {
        case 'multi-sidebar':
            $shorten_text_chars         = 150;
        break;
        case 'hide-sidebar':
            $shorten_text_chars         = 550;
        break;
        default:
            $shorten_text_chars         = 250;
        break;
    }
    $shorten_text_chars     = ($cat_template_chars != 0) ? $cat_template_chars : $shorten_text_chars;

    $image_post_dummy_first = ''. $image_post_first_width .'x'. $image_post_first_height .'';

    //start the loop
    while ( have_posts() ) : the_post();

        $cat_label              = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_category_label') ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_category_label') : 0;

        if ( $cat_label && !$curr_cat_id ) {
            $curr_cat_id_tmp        = $cat_label;
            $curr_cat_obj           = get_category($curr_cat_id_tmp);
        } else {
            if (!$curr_cat_id) {
                $curr_cat           = get_the_category();
                $curr_cat_id_tmp    = $curr_cat[0]->cat_ID;
                //$curr_cat_id_tmp    = MipTheme_Util::get_category_top_parent_id($curr_cat[0]->term_id);
                $curr_cat_obj       = get_category($curr_cat_id_tmp);
            } else {
                $curr_cat_id_tmp    = $curr_cat_id;
            }
        }

        $post_article->cat_ID                           = $curr_cat_id_tmp;
        $post_article->cat_name                         = $curr_cat_obj->name;
        $post_article->article_link                     = $post->ID;
        $post_article->article_title                    = $post->post_title;
        $post_article->article_content                  = ( empty( $post->post_excerpt ) ) ? $post->post_content : $post->post_excerpt;
        $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
        $post_article->article_comments_count           = $post->comment_count;

        $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_first);
        $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $image_post_dummy_first );

        // display banner
        if ( $cat_banner_show && ( $cat_banner_count == $post_counter ) ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$cat_banner_show;

            echo $ad_unit->formatLayoutAd();
        }

        // format output
        echo $post_article->formatArticleTimeline( $image_post_first_width, $image_post_first_height, $shorten_text_chars );

        $post_counter++;
    endwhile;
    //end loop
?>
