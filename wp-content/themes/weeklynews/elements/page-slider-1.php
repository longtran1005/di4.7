<?php
    global  $mp_weeklynews,
            $page_type,
            $r,
            $include_categories,
            $cat_display,
            $slider_summary;

    if ( $page_type == 'homepage' ) {
        $include_categories     = ( isset($mp_weeklynews['_mp_homepage_top_slider_categories']) && ($mp_weeklynews['_mp_homepage_top_slider_categories'] != '') )           ?   $mp_weeklynews['_mp_homepage_top_slider_categories']        : '';
        $slider_layout          = ( isset($mp_weeklynews['_mp_homepage_top_slider_layout']) && ($mp_weeklynews['_mp_homepage_top_slider_layout'] != '') )                   ?   $mp_weeklynews['_mp_homepage_top_slider_layout']            : '';
        $slider_summary         = ( isset($mp_weeklynews['_mp_page_top_slider_summary']) && ($mp_weeklynews['_mp_page_top_slider_summary'] != '') )                         ?   $mp_weeklynews['_mp_page_top_slider_summary']               : '';
        $cat_display            = ( isset($mp_weeklynews['_mp_page_top_slider_category_display']) && ($mp_weeklynews['_mp_page_top_slider_category_display'] != '') )       ?   $mp_weeklynews['_mp_page_top_slider_category_display']      : '';
        $posts_sorting          = ( isset($mp_weeklynews['_mp_homepage_top_slider_sort']) && ($mp_weeklynews['_mp_homepage_top_slider_sort'] != '') )                       ?   $mp_weeklynews['_mp_homepage_top_slider_sort']              : '';
        $posts_filter_by_tags   = ( isset($mp_weeklynews['_mp_homepage_top_slider_tags']) && ($mp_weeklynews['_mp_homepage_top_slider_tags'] != '') )                       ?   $mp_weeklynews['_mp_homepage_top_slider_tags']              : '';
        $slider_hide_mobile     = (bool)$mp_weeklynews['_mp_homepage_top_slider_mobile']                                                                                    ? ' hidden-xs'                                                  : '';
        $slider_autostart       = (bool)$mp_weeklynews['_mp_homepage_top_slider_autostart']                                                                                 ? true                                                          : false;
        $slider_autostart_delay = ( isset($mp_weeklynews['_mp_homepage_top_slider_autostart_delay']) && ($mp_weeklynews['_mp_homepage_top_slider_autostart_delay'] != '') ) ?   $mp_weeklynews['_mp_homepage_top_slider_autostart_delay']   : '';
    } else { // page
        $include_categories     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_categories');
        $slider_layout          = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_layout');
        $slider_summary         = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_summary');
        $cat_display            = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_category_display');
        $posts_sorting          = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_sort');
        $posts_filter_by_tags   = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_tags');
        $slider_hide_mobile     = (bool)redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_mobile') ? ' hidden-xs' : '';
        $slider_autostart       = (bool)redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_autostart');
        $slider_autostart_delay = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_autostart_delay');
    }

    if ( $include_categories ) :
?>

<!-- start:page slider -->
<div id="page-slider" class="<?php echo esc_attr($slider_layout) . esc_attr($slider_hide_mobile); ?> clearfix">

    <!-- start:container -->
    <div class="container relative">

        <!-- start:carousel -->
        <div id="slider-carousel">

<?php
        switch ($slider_layout) {
            case 'slider-layout-3':
                $posts_per_page = 5;
            break;
            case 'slider-layout-5':
                $posts_per_page = 5;
            break;
            case 'slider-layout-6':
                $posts_per_page = 1;
            break;
            default:
                $posts_per_page = 4;
        }
        //$posts_per_page         = ( ($slider_layout == 'slider-layout-3')||($slider_layout == 'slider-layout-5') ) ? 5 : 4;

        // go trough each category
        foreach ( $include_categories as &$cat ) {

            $r = new WP_Query(
                apply_filters( 'page_slider_one_args', array(
                        'cat'                   => $cat,
                        'posts_per_page'        => $posts_per_page, // fixed
                        //'offset'                => $post_offset,
                        'tag__in'               => $posts_filter_by_tags,
                        'no_found_rows'         => true,
                        'post_status'           => 'publish',
                        'ignore_sticky_posts'   => true,
                        'orderby'               => $posts_sorting,
                        'meta_key'              => '_thumbnail_id',
                    )
                )
            );

            if ($r->have_posts()) :
                // include layout
                get_template_part( 'elements/parts/'. $slider_layout );

                wp_reset_postdata();
            endif;

        } // end foreach
?>

        </div>
        <!-- end:slider-carousel -->

        <!-- start:slider-nav -->
        <div class="slider-nav">
            <a id="slider-prev" class="prev" href="#"><i class="fa fa-chevron-left"></i></a>
            <a id="slider-next" class="next" href="#"><i class="fa fa-chevron-right"></i></a>
        </div>
        <!-- end:slider-nav -->
    </div>
    <!-- end:container -->

</div>
<!-- end:page slider -->
<script>
    "use strict";
    var initCarouFredSel = true;
<?php
    if ( $slider_autostart ) {
?>
    var carouselStart    = true;
    var carouselDelay    = <?php echo $slider_autostart_delay; ?>;
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
    // end if include_categories
?>
