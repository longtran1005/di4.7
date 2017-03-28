<?php
    global $curr_cat_id, $curr_cat_obj, $post_counter, $cat_banner_show, $cat_banner_count, $cat_banner_embed, $cat_sidebar_template, $page_show_posts_num;

    //set counter
    $post_counter = 1;
    $post_article                                   = new MipTheme_Article();

    // set unique posts if enabled
    if ( (bool)MipTheme_UniquePosts::$unique_posts_enabled ) {
        $args = array_merge($wp_query->query_vars, array('post__not_in' => MipTheme_UniquePosts::$unique_posts_ids));
        query_posts( $args );
    }

    $page_sidebar_pos           = ( $cat_sidebar_template == 'multi-sidebar mid-left' )                                         ? 'multi-sidebar' : $cat_sidebar_template;
    $page_sidebar_pos           = ( ($page_sidebar_pos == 'left-sidebar') || ($page_sidebar_pos == 'right-sidebar') )       ? 'sidebar' : $page_sidebar_pos;

    $startTime = microtime(true);

    $first_image_attr           = new MipTheme_ImageCat();
    $first_image                = $first_image_attr->get_image_attr_cat01($page_sidebar_pos .'-1');

    $second_image_attr          = new MipTheme_ImageCat();
    $second_image                = $second_image_attr->get_image_attr_cat01($page_sidebar_pos .'-2');

    $image_post_format_first    = $first_image[0];
    $image_post_format_second   = $second_image[0];
    $image_post_first_width     = $first_image[1];
    $image_post_first_height    = $first_image[2];
    $image_post_second_width    = $second_image[1];
    $image_post_second_height   = $second_image[2];
    $shorten_text_chars         = $second_image[3];

    $image_post_dummy_first = ''. $image_post_first_width .'x'. $image_post_first_height .'';
    $image_post_dummy_second = ''. $image_post_second_width .'x'. $image_post_second_height .'';


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
        $post_article->article_content                  = $post->post_content;
        $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
        $post_article->article_comments_count           = $post->comment_count;

        //check if first post
        if ( $post_counter == 1 ) {

            // display banner
            if ( $cat_banner_show && ( $cat_banner_count == 0 ) ) {
                $ad_unit        = new MipTheme_Ad();
                $ad_unit->id    = (int)$cat_banner_show;
                echo $ad_unit->formatLayoutAd();
            }
            $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_first);
            $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $image_post_dummy_first );

            // format output
            echo $post_article->formatArticleStyle1($image_post_first_width, $image_post_first_height);

        //else - if not first post
        } else {
            $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_second);
            $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $image_post_dummy_second );

            if ( $post_counter%2 == 0 ) {

                // display banner
                if ( $cat_banner_show && ( $post_counter/2 == $cat_banner_count ) ) {
                    $ad_unit        = new MipTheme_Ad();
                    $ad_unit->id    = (int)$cat_banner_show;

                    if ( $post_counter > 2 ) {
                        echo $ad_unit->formatLayoutAd('col-md-12 ad ad-cat');
                    } else {
                        echo $ad_unit->formatLayoutAd();
                    }
                }

                if ( $post_counter > 2 ) echo '</div><!-- end:row -->';
                echo '<!-- start:row --><div class="row">';
            }

            // format output
            echo $post_article->formatArticleStyle3($image_post_second_width, $image_post_second_height);

        //end - if not first post
        }

    $post_counter++;
    endwhile;
    //end loop

    if ( $post_counter > 2 ) echo '</div><!-- end:row -->';
?>
