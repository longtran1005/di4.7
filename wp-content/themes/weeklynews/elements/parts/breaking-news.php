<?php
    global $mp_weeklynews;

    if ( (bool)$mp_weeklynews['_mp_breakingnews_enable'] ) :

        $breaking_title             = ( isset($mp_weeklynews['_mp_breakingnews_title']) && ( $mp_weeklynews['_mp_breakingnews_title'] != '') ) ?  $mp_weeklynews['_mp_breakingnews_title'] : '';
        $breaking_title_link        = ( isset($mp_weeklynews['_mp_breakingnews_title_link']) && ( $mp_weeklynews['_mp_breakingnews_title_link'] != '') ) ?  $mp_weeklynews['_mp_breakingnews_title_link'] : '';
        $posts_filter_by_category   = ( isset($mp_weeklynews['_mp_breakingnews_filter_cats']) && ( $mp_weeklynews['_mp_breakingnews_filter_cats'] != '') ) ?  $mp_weeklynews['_mp_breakingnews_filter_cats'] : '';
        $posts_filter_by_tags       = ( isset($mp_weeklynews['_mp_breakingnews_filter_tags']) && ( $mp_weeklynews['_mp_breakingnews_filter_tags'] != '') ) ?  $mp_weeklynews['_mp_breakingnews_filter_tags'] : '';

        $r = new WP_Query(
            apply_filters( 'breakingnews_args', array(
                    'category__in'          => $posts_filter_by_category,
                    'posts_per_page'        => $mp_weeklynews['_mp_breakingnews_posts_count'],
                    'tag__in'               => $posts_filter_by_tags,
                    'no_found_rows'         => true,
                    'post_status'           => 'publish',
                    'ignore_sticky_posts'   => true
                )
            )
        );

        if ($r->have_posts()) :
?>
<!-- start:breaking-news -->
<div id="breaking-news">
    <?php
        if ( $breaking_title != '' ) echo '<a href="'. $breaking_title_link .'" class="theme theme-title">'. $breaking_title .'</a>';
    ?>
    <div class="wrapper">
        <div id="breaking-news-carousel">
        <?php
            while ( $r->have_posts() ) :
                $r->the_post();
                $post_cat_display   = ( isset($mp_weeklynews['_mp_breakingnews_cat_display']) && ( $mp_weeklynews['_mp_breakingnews_cat_display'] != '') ) ?  $mp_weeklynews['_mp_breakingnews_cat_display'] : 'root';
                $post_cat           = (bool)$mp_weeklynews['_mp_breakingnews_cat_enable'] ? MipTheme_Util::return_category( $r->post->post_ID, $posts_filter_by_category, $post_cat_display ) : '';
                $post_date          = (bool)$mp_weeklynews['_mp_breakingnews_date_enable'] ? ' <span class="published">'. get_the_time(MIPTHEME_DATE_DEFAULT) .'</span>' : '';
                $post_cat_link      = ( !empty($post_cat) ) ? '<a href="'. get_category_link($post_cat[0]) .'" class="theme cat-'. $post_cat[0] .' hidden-xs">'. $post_cat[1] .'</a> ' : '';
        ?>
            <div class="item">
                <h3><?php echo $post_cat_link; ?><a href="<?php echo get_permalink($r->post->post_ID); ?>"><?php echo MipTheme_Util::ShortenText($r->post->post_title, 90) . $post_date; ?></a></h3>
            </div>
        <?php
            endwhile;
        ?>
        </div>
    </div>
</div>
<script>
    "use strict";
    var initBreakingNews      = true;
</script>
<!-- end:breaking-news -->
<?php
        endif;
        wp_reset_postdata();
    endif;
?>
