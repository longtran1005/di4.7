<?php
/**
 * WeeklyNews Theme
 *
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 *
 * File Date: 08/18/14
 */

global $page_template,
        $category,
        $page_sidebar_pos,
        $featured_video_url,
        $curr_sidebar_source,
        $curr_sidebar_source_middle,
        $enable_breadcrumbs,
        $content_width,
        $featured_image_height_limit,
        $page_type,
        $page_quicklinks_menu;

$page_slider                    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_enable');
$page_template                  = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single')                  ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single')                  : $mp_weeklynews['_mp_page_layout'];
$featured_image_height_limit    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single_image_height')     ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single_image_height')     : ( isset($mp_weeklynews['_mp_page_layout_image_height'] ) ? $mp_weeklynews['_mp_page_layout_image_height'] : 0);
$page_sidebar_pos               = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        : $mp_weeklynews['_mp_page_sidebar_position'];
$curr_sidebar_source            = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single')          ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single')          : $mp_weeklynews['_mp_page_sidebar_source'];
$curr_sidebar_source_middle     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single_middle')   ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single_middle')   : $mp_weeklynews['_mp_page_sidebar_source_middle'];
$featured_video_url             = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_featured_video');
$enable_breadcrumbs             = $mp_weeklynews['_mp_pages_enable_breadcrumbs'];
$breaking_news                  = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_breakingnews_enable');
$page_type                      = 'page';
$page_quicklinks_menu           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_header_quicklinks_menu')         ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_header_quicklinks_menu')         : '';

// Content Width for Jetpack
if ( $page_sidebar_pos == 'hide-sidebar' ) $content_width = 1120;

get_header(); ?>

<?php
    if ( $page_slider ) locate_template( '/elements/'. $mp_weeklynews['_mp_page_top_slider_display'] .'.php' , true);
?>

<!-- start:ad-top-banner -->
<?php get_template_part('elements/ad-top-banner'); ?>
<!-- end:ad-top-banner -->

<!-- start:container -->
<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="<?php echo esc_attr($page_sidebar_pos); if ( (bool)$breaking_news && isset($mp_weeklynews['_mp_breakingnews_enable']) && (bool)$mp_weeklynews['_mp_breakingnews_enable'] ) echo ' has-breaking-news'; ?>">

        <?php
            // include cover header
            if ( $page_template == 'loop-page-3' ) get_template_part('elements/parts/post-cover');
            if ( $page_template == 'loop-page-4' ) get_template_part('elements/parts/post-cover-parallax');

            //include breaking news
            if ( (bool)$breaking_news ) get_template_part('elements/parts/breaking-news');
        ?>

        <!-- start:tbl-row -->
        <div class="tbl-row">

        <?php
            //get sidebar
            if ( ($page_sidebar_pos != 'hide-sidebar')&&($page_sidebar_pos == 'left-sidebar')&&(!wp_is_mobile()) ) get_sidebar();

            // get sidebar-mid
            if ( ($page_sidebar_pos == 'multi-sidebar mid-left')&&(!wp_is_mobile()) ) get_sidebar( 'mid' );
        ?>

        <!-- start:main -->
        <div id="main" class="article">

            <!-- start:article-post -->
            <article class="article-post">

                <?php locate_template('loop-single.php', true);?>

            </article>
            <!-- end:article-post -->

        </div>
        <!-- end:main -->

        <?php
            // get sidebar-mid
            if ( ($page_sidebar_pos == 'multi-sidebar')||($page_sidebar_pos == 'multi-sidebar mid-left')&&(wp_is_mobile()) ) get_sidebar( 'mid' );

            //get sidebar
            if ( ($page_sidebar_pos == 'multi-sidebar')||($page_sidebar_pos == 'right-sidebar')||($page_sidebar_pos == 'multi-sidebar mid-left')||(($page_sidebar_pos != 'hide-sidebar')&&($page_sidebar_pos == 'left-sidebar')&&(wp_is_mobile())) ) get_sidebar();
        ?>

        </div>
        <!-- end:tbl-row -->

    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    //load footer
    get_footer();
?>
