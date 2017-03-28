<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Ajax' ) ) {

    class MipTheme_Ajax {

        // init var
        public $ajax_query                  = '';
        public $post_id                     = '';
        public $post_block_type             = '';
        public $image_post_format_first     = '';
        public $image_post_format_second    = '';
        public $image_post_first_width      = '';
        public $image_post_first_height     = '';
        public $image_post_second_width     = '';
        public $image_post_second_height    = '';
        public $shorten_text_chars          = '';
        public $category_multiple_id        = '';
        public $category_display            = '';
        public $post_limit                  = '';
        public $post_offset                 = '';
        public $post_tag_slug               = '';
        public $post_sort                   = '';
        public $post_index                  = '';
        public $image_post_dummy_first      = '';
        public $image_post_dummy_second     = '';
        public $layout_columns              = 1;
        public $layout_type                 = '';
        public $article_no_ajax_call        = true;


        public function __construct() {
            if( isset($_POST) && count($_POST) > 0 ) {
                $this->post_block_type            = ( isset($_POST['data_block']) ? $_POST['data_block'] : '');
                $this->image_post_format_first    = ( isset($_POST['data_img_format_1']) ? $this->checkImgBfi($_POST['data_img_format_1']) : '');
                $this->image_post_format_second   = ( isset($_POST['data_img_format_2']) ? $this->checkImgBfi($_POST['data_img_format_2']) : '');
                $this->image_post_first_width     = ( isset($_POST['data_img_width_1']) ? $_POST['data_img_width_1'] : '');
                $this->image_post_first_height    = ( isset($_POST['data_img_height_1']) ? $_POST['data_img_height_1'] : '');
                $this->image_post_second_width    = ( isset($_POST['data_img_width_2']) ? $_POST['data_img_width_2'] : '');
                $this->image_post_second_height   = ( isset($_POST['data_img_height_2']) ? $_POST['data_img_height_2'] : '');
                $this->shorten_text_chars         = ( isset($_POST['data_text']) ? $_POST['data_text'] : '');
                $this->category_multiple_id       = ( isset($_POST['data_cat']) ? $_POST['data_cat'] : '');
                $this->category_display           = ( isset($_POST['data_display']) ? $_POST['data_display'] : '');
                $this->post_limit                 = ( isset($_POST['data_count']) ? $_POST['data_count'] : '');
                $this->post_offset                = ( isset($_POST['data_offset']) ? $_POST['data_offset'] : '');
                $this->post_tag_slug              = ( isset($_POST['data_tag']) ? $_POST['data_tag'] : '');
                $this->post_sort                  = ( isset($_POST['data_sort']) ? $_POST['data_sort'] : '');
                $this->post_index                 = ( isset($_POST['data_index']) ? $_POST['data_index'] : '');
                $this->layout_columns             = ( isset($_POST['data_columns']) ? $_POST['data_columns'] : '');
                $this->layout_type                = ( isset($_POST['data_layout']) ? $_POST['data_layout'] : '');
                $this->article_no_ajax_call       = false;
            }
        }

        private function setDummyImages() {
            $this->image_post_format_first    = $this->checkImgBfi($this->image_post_format_first);
            $this->image_post_format_second   = $this->checkImgBfi($this->image_post_format_second);
            $this->image_post_dummy_first     = ''. $this->image_post_first_width .'x'. $this->image_post_first_height .'';
            $this->image_post_dummy_second    = ''. $this->image_post_second_width .'x'. $this->image_post_second_height .'';
        }

        public static function checkImgBfi( $sValue ) {
            if (is_array($sValue)) {
                return $sValue;
            } else {
                $pos_value = strrpos($sValue, "_bfi_");
                if ($pos_value === false) {
                    return $sValue;
                } else {
                    $img_dim = explode("_bfi_", $sValue);
                    //return array(intval($img_dim[0]),intval($img_dim[1]), 'quality' => BFI_QUALITY, 'bfi_thumb' => true);
                    return array(intval($img_dim[0]),intval($img_dim[1]));
                }
            }
        }

        public static function mipthemeAjaxBlock() {

            global $post;
            $post_ajax                              = new MipTheme_Ajax();

            $args   = array(
                        'cat'                   => $post_ajax->category_multiple_id,
                        'posts_per_page'        => $post_ajax->post_limit,
                        'offset'                => $post_ajax->post_offset + (($post_ajax->post_index-1)*$post_ajax->post_limit),
                        'tag'                   => $post_ajax->post_tag_slug,
                        'no_found_rows'         => true,
                        'post_status'           => 'publish',
                        'ignore_sticky_posts'   => true,
                        //'orderby'               => $post_ajax->post_sort,
                        'orderby'               => ( (in_array($post_ajax->post_sort, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? 'meta_value_num' : $post_ajax->post_sort ),
                        'meta_key'              => ( (in_array($post_ajax->post_sort, array('mip_post_views_count', '_mip_post_views_count_7_day_total', '_mip_post_views_count_24_hours_total'))) ? $post_ajax->post_sort : '' ),
                        'paged'                 => $post_ajax->post_index
                    );

            // add review meta
            if ( $post_ajax->post_block_type == 'block-07' ) $args = array_merge($args, array('meta_key' => '_mp_review_post_total_score'));

            // add video meta
            if ( $post_ajax->post_block_type == 'block-video' ) $args = array_merge($args, array('tax_query' => array(array('taxonomy' => 'post_format','field' => 'slug','terms' => array( 'post-format-video'))) ));

            // add gallery meta
            if ( $post_ajax->post_block_type == 'block-gallery' ) $args = array_merge($args, array('tax_query' => array(array('taxonomy' => 'post_format','field' => 'slug','terms' => array( 'post-format-gallery'))) ));

            // add audio meta
            if ( $post_ajax->post_block_type == 'block-audio' ) $args = array_merge($args, array('tax_query' => array(array('taxonomy' => 'post_format','field' => 'slug','terms' => array( 'post-format-audio'))) ));

            // set unique posts if enabled
            // if ( (bool)MipTheme_UniquePosts::$unique_posts_enabled ) $args = array_merge($args, array('post__not_in' => MipTheme_UniquePosts::$unique_posts_ids));

            $r = new WP_Query( apply_filters( 'block_ajax_posts_args', $args ) );

            $output = '';

            if ($r->have_posts()) :

                $post_ajax->ajax_query                  = $r;
                $post_ajax->post_id                     = $r->post->ID;

                switch ( $post_ajax->post_block_type ) {
                    case 'block-01':
                        $output .= $post_ajax->formatBlock1();
                    break;
                    case 'block-02':
                        $output .= $post_ajax->formatBlock2();
                    break;
                    case 'block-03':
                        $output .= $post_ajax->formatBlock3();
                    break;
                    case 'block-04':
                        $output .= $post_ajax->formatBlock4();
                    break;
                    case 'block-05':
                        $output .= $post_ajax->formatBlock5();
                    break;
                    case 'block-06':
                        $output .= $post_ajax->formatBlock6();
                    break;
                    case 'block-07':
                        $output .= $post_ajax->formatBlock7();
                    break;
                    case 'block-08':
                        $output .= $post_ajax->formatBlock8();
                    break;
                    case 'block-09':
                        $output .= $post_ajax->formatBlock9();
                    break;
                    case 'block-10':
                        $output .= $post_ajax->formatBlock10();
                    break;
                    case 'block-11':
                        $output .= $post_ajax->formatBlock11();
                    break;
                    case 'block-video':
                        $output .= $post_ajax->formatBlockPostFormat();
                    break;
                    case 'block-gallery':
                        $output .= $post_ajax->formatBlockPostFormat();
                    break;
                    case 'block-audio':
                        $output .= $post_ajax->formatBlockPostFormat();
                    break;
                    case 'block-12':
                        $output .= $post_ajax->formatBlock12();
                    break;
                    case 'block-13':
                        $output .= $post_ajax->formatBlock13();
                    break;
                    case 'block-14':
                        $output .= $post_ajax->formatBlock14();
                    break;
                    case 'block-15':
                        $output .= $post_ajax->formatBlock15();
                    break;
                }

            endif;
            wp_reset_postdata();

            echo $output;
            die();

        }


        public function formatBlock1() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 1;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter == 1 ) {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output .= $post_article->formatArticleStyle1($this->image_post_first_width, $this->image_post_first_height);

                //else - check if first post
                } else {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    // format output
                    $output .= $post_article->formatArticleStyle2($this->image_post_second_width, $this->image_post_second_height, $this->shorten_text_chars);

                //end - check if first post
                }

                $post_counter++;
            endwhile;

            return $output;
        }


        public function formatBlock2() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                // format output
                $output .= $post_article->formatArticleStyle2($this->image_post_first_width, $this->image_post_first_height, $this->shorten_text_chars);
            endwhile;
            //end loop

            return $output;
        }


        public function formatBlock3() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 1;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter == 1 ) {

                    $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output .= $post_article->formatArticleStyle1($this->image_post_first_width, $this->image_post_first_height);

                //else - if not first post
                } else {
                    $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    if ( $post_counter%2 == 0 ) {
                        if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';
                        $output .= '<!-- start:row --><div class="row">';
                    }

                    // format output
                    $output .= $post_article->formatArticleStyle3($this->image_post_second_width, $this->image_post_second_height);

                //end - if not first post
                }

                $post_counter++;
            endwhile;
            if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock4() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%2 == 0 ) {
                    if ( $post_counter > 1 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row clearfix">';
                }

                // format output
                    $output .= $post_article->formatArticleStyle3($this->image_post_first_width, $this->image_post_first_height);

                $post_counter++;
            endwhile;

            if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock5() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);
                //$category = get_the_category();

                $post_article                                   = new MipTheme_Article();
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                // format output
                $output .= $post_article->formatArticleStyle4(100, 80, $this->shorten_text_chars);

                $post_counter++;
            endwhile;

            return $output;
        }


        public function formatBlock6() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '<div class="row">';
            $post_counter   = 1;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->article_link                     = $post->ID;
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter%3 == 1 ) {
                    $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output .= $post_article->formatArticleStyle5($this->image_post_first_width, $this->image_post_first_height);

                //else - check if first post
                } else {
                    $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    if ( $post_counter%3 == 2 ) {
                        $output .= '<!-- start:col --><div class="col-sm-5">';
                    }

                    // format output
                    $output .= $post_article->formatArticleStyle6($this->image_post_second_width, $this->image_post_second_height);

                    if ( $post_counter%3 == 0 ) {
                        $output .= '</div><!-- end:col -->';
                    }

                //end - check if first post
                }

                $post_counter++;
            endwhile;
            $output .= '</div>';

            return $output;
        }


        public function formatBlock7() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $category = get_the_category();

                $post_article                                   = new MipTheme_Article();
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_review_score             = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_score');
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%4 == 0 ) {
                    if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row">';
                }

                $output .= '<div class="col-xs-6 col-sm-3">';
                // format output
                $output .= $post_article->formatArticleReview1($this->image_post_first_width, $this->image_post_first_height);

                $output .= '</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock8() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%3 == 0 ) {
                    if ( $post_counter > 1 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row clearfix">';
                }

                // format output
                $output .= '<div class="col-sm-4">'. $post_article->formatArticleStyle10($this->image_post_first_width, $this->image_post_first_height) .'</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock9() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 2;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter == 2 ) {

                    $att_img_src                 = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output .= $post_article->formatArticleStyle1($this->image_post_first_width, $this->image_post_first_height);

                //else - if not first post
                } else {
                    $att_img_src                 = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    if ( $post_counter%3 == 0 ) {
                        if ( $post_counter > 3 ) $output .= '</div><!-- end:row -->';
                        $output .= '<!-- start:row --><div class="row">';
                    }

                    // format output
                    $output .= '<div class="col-sm-4">'. $post_article->formatArticleStyle10($this->image_post_second_width, $this->image_post_second_height) .'</div>';

                //end - if not first post
                }

                $post_counter++;
            endwhile;
            if ( $post_counter > 3 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock10() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                // format output
                $output .=  $post_article->formatArticleTimeline( $this->image_post_first_width, $this->image_post_first_height, $this->shorten_text_chars );
            endwhile;
            //end loop

            return $output;
        }


        public function formatBlock11() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb                    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%4 == 0 ) {
                    if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row">';
                }

                $output .= '<div class="col-xs-6 col-sm-3">';
                // format output
                $output .= $post_article->formatArticleStyle11($this->image_post_first_width, $this->image_post_first_height);

                $output .= '</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 2 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlockPostFormat() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = $r->post->post_content;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%3 == 0 ) {
                    if ( $post_counter > 1 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row clearfix">';
                }

                // format output
                $output .= '<div class="col-sm-4">'. $post_article->formatArticleStyle6($this->image_post_first_width, $this->image_post_first_height) .'</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock12() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            $Layout_col_per_rows    = $this->layout_columns;
            $layout_columns         = MipTheme_Util::getColumnClass( $Layout_col_per_rows );

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%$Layout_col_per_rows == 0 ) {
                    if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row clearfix">';
                }

                // format output
                $output .= '<div class="'. $layout_columns .'">'. $post_article->formatArticleTextOnly( $this->layout_type, $this->shorten_text_chars ) .'</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        public function formatBlock13() {

            global $post;

            $r              = $this->ajax_query;
            $output_left    = '';
            $output_right   = '';
            $post_counter   = 1;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter == 1 ) {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output_left .= $post_article->formatArticleStyle13_1($this->image_post_first_width, $this->image_post_first_height, $this->shorten_text_chars);

                //else - check if first post
                } else {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    // format output
                    $output_right .= $post_article->formatArticleStyle13_2($this->image_post_second_width, $this->image_post_second_height, $this->shorten_text_chars);

                //end - check if first post
                }

                $post_counter++;
            endwhile;

            return '<div class="row">
                        <div class="col-sm-6">'. $output_left .'</div>
                        <div class="col-sm-6">'. $output_right .'</div>
                    </div>';
        }


        public function formatBlock14() {

            global $post;

            $r              = $this->ajax_query;
            $output_top     = '';
            $output_bottom  = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                //check if first post
                if ( $post_counter < 2 ) {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                    // format output
                    $output_top .= '<div class="col-sm-6">'. $post_article->formatArticleStyle13_1($this->image_post_first_width, $this->image_post_first_height, $this->shorten_text_chars) .'</div>';

                //else - check if first post
                } else {
                    $att_img_src = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_second);
                    $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_second );

                    if ( $post_counter%2 == 0 ) {
                        if ( $post_counter > 2 ) $output_bottom .= '</div><!-- end:row -->';
                        $output_bottom .= '<!-- start:row --><div class="row">';
                    }

                    // format output
                    $output_bottom .= '<div class="col-sm-6">'. $post_article->formatArticleStyle13_2($this->image_post_second_width, $this->image_post_second_height, $this->shorten_text_chars) .'</div>';

                //end - check if first post
                }

                $post_counter++;
            endwhile;
            if ( $post_counter > 2 ) $output_bottom .= '</div><!-- end:row -->';

            return '<div class="row">'. $output_top .'</div>'. $output_bottom;
        }


        public function formatBlock15() {

            global $post;

            $r              = $this->ajax_query;
            $output         = '';
            $post_counter   = 0;

            while ( $r->have_posts() ) :
                $r->the_post();
                $this->setDummyImages();
                apply_filters("miptheme_unique_posts_filter", $post);

                $cats       = MipTheme_Util::return_category( $post->ID, explode(',', $this->category_multiple_id), $this->category_display );

                $post_article                                   = new MipTheme_Article();
                $post_article->cat_ID                           = $cats[0];
                $post_article->cat_name                         = $cats[1];
                $post_article->article_link                     = $post->ID;
                $post_article->article_title                    = $r->post->post_title;
                $post_article->article_content                  = ( empty( $r->post->post_excerpt ) ) ? $r->post->post_content : $r->post->post_excerpt;
                $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
                $post_article->article_comments_count           = $r->post->comment_count;
                $post_article->article_no_ajax_call             = $this->article_no_ajax_call;

                $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $this->image_post_format_first);
                $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( $this->image_post_dummy_first );

                if ( $post_counter%2 == 0 ) {
                    if ( $post_counter > 1 ) $output .= '</div><!-- end:row -->';
                    $output .= '<!-- start:row --><div class="row clearfix">';
                }

                // format output
                $output .= '<div class="col-sm-6">'. $post_article->formatArticleStyle13_1($this->image_post_first_width, $this->image_post_first_height, $this->shorten_text_chars) .'</div>';

                $post_counter++;
            endwhile;
            if ( $post_counter > 0 ) $output .= '</div><!-- end:row -->';

            return $output;
        }


        static function setAjaxNav( $data_container, $pos = 'ajax-nav-footer', $layout_columns = '', $layout_type = '' ) {
            return '<div class="paging mip-ajax-nav '. $pos .'">
                        <a class="prev disabled" data-container="'. $data_container .'" data-index="0" data-columns="'. $layout_columns .'" data-layout="'. $layout_type .'" href="#"></a>
                        <a class="next" data-container="'. $data_container .'" data-index="2" data-columns="'. $layout_columns .'" data-layout="'. $layout_type .'" href="#"></a>
                    </div>';
        }

    }

}


/**
 * Update the view counter for single post page
 */
function miptheme_ajax_update_views() {

    if (!empty($_POST['post_ids'])) {
        $post_id = json_decode(stripslashes($_POST['post_ids']));

        if (empty($post_id[0])) {
            $post_id[0] = 0;
        }

        $current_post_count = MipTheme_Post_Views::get_post_views($post_id[0]);
        $new_post_count     = $current_post_count + 1;

        // update the counter
        update_post_meta($post_id[0], MipTheme_Post_Views::$post_views_counter_key, $new_post_count);

        die(json_encode(array($post_id[0]=>$new_post_count)));
    }
}
add_action( 'wp_ajax_nopriv_miptheme_ajax_update_views', 'miptheme_ajax_update_views' );
add_action( 'wp_ajax_miptheme_ajax_update_views', 'miptheme_ajax_update_views' );
