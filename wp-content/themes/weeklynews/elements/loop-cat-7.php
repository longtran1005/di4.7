<?php
    global $curr_cat_id, $curr_cat_obj, $cat_template_chars, $post_counter, $cat_banner_show, $cat_banner_count, $cat_banner_embed, $cat_sidebar_template, $page_show_posts_num;

    //set counter
    $post_counter   = 0;
    $post_article                                   = new MipTheme_Article();

    // set unique posts if enabled
    if ( (bool)MipTheme_UniquePosts::$unique_posts_enabled ) {
        $args = array_merge($wp_query->query_vars, array('post__not_in' => MipTheme_UniquePosts::$unique_posts_ids));
        query_posts( $args );
    }

    $page_sidebar_pos           = ( $cat_sidebar_template == 'multi-sidebar mid-left' )                                         ? 'multi-sidebar' : $cat_sidebar_template;
    $page_sidebar_pos           = ( ($page_sidebar_pos == 'left-sidebar') || ($page_sidebar_pos == 'right-sidebar') )       ? 'sidebar' : $page_sidebar_pos;

    $first_image_attr           = new MipTheme_ImageCat();
    $first_image                = $first_image_attr->get_image_attr_cat07($page_sidebar_pos .'-1');

    $image_post_format_first    = $first_image[0];
    $image_post_format_second   = '';
    $image_post_first_width     = $first_image[1];
    $image_post_first_height    = $first_image[2];
    $image_post_second_width    = 0;
    $image_post_second_height   = 0;
    $shorten_text_chars         = ($cat_template_chars != 0) ? $cat_template_chars : $first_image[3];

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
        $post_article->article_content                  = get_the_content( __('Read more', THEMENAME) );
        $post_article->article_more                     = strpos($post->post_content, '<!--more');
        $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
        $post_article->article_comments_count           = $post->comment_count;
        $post_article->article_author                   = get_the_author_meta('display_name');
        $post_article->article_author_url               = get_author_posts_url( get_the_author_meta( 'ID' ) );

        if ( has_post_format( 'gallery' )) {
            $post_article->article_post_type    = 'gallery';
        } else if (has_post_format('video')) {
            $post_article->article_post_type    = 'video';
        } else if (has_post_format('image')) {
            $post_article->article_post_type    = 'image';
        } else if (has_post_format('quote')) {
            $post_article->article_post_type    = 'quote';
        } else if (has_post_format('audio')) {
            $post_article->article_post_type    = 'audio';
        } else {
            $post_article->article_post_type    = 'standard';
        }

        $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_first);
        $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $image_post_dummy_first );

        // display banner
        if ( $cat_banner_show && ( $post_counter == $cat_banner_count ) ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$cat_banner_show;
            echo $ad_unit->formatLayoutAd();
        }


        // format output
        echo $post_article->formatArticleStyleBlog($image_post_first_width, $image_post_first_height, $shorten_text_chars);

        $post_counter++;

    endwhile;
    //end loop

?>
