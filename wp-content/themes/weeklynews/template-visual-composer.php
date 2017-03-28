<?php
/**
 * Template Name: Visual Composer Page
 */

global $page_template,
       $category,
       $page_sidebar_pos,
       $featured_video_url,
       $curr_sidebar_source,
       $curr_sidebar_source_middle,
       $page_quicklinks_menu;

$page_slider                = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_top_slider_enable');
$page_template              = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single')                  ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_layout_single')                  : $mp_weeklynews['_mp_page_layout'];
$page_sidebar_pos           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_position_single')        : $mp_weeklynews['_mp_page_sidebar_position'];
$curr_sidebar_source        = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single')          ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single')          : $mp_weeklynews['_mp_page_sidebar_source'];
$curr_sidebar_source_middle = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single_middle')   ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_sidebar_source_single_middle')   : $mp_weeklynews['_mp_page_sidebar_source_middle'];
$featured_video_url         = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_featured_video');
$breaking_news              = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_breakingnews_enable');
$page_quicklinks_menu       = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_header_quicklinks_menu')         ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_page_header_quicklinks_menu')         : '';

get_header(); ?>

<?php
    if ( $page_slider == 1 ) locate_template( '/elements/'. $mp_weeklynews['_mp_page_top_slider_display'] .'.php' , true);
    if ( $page_slider == 2 ) echo do_shortcode( $mp_weeklynews['_mp_page_top_slider_shortcode'] );
?>

<!-- start:ad-top-banner -->
<?php get_template_part('elements/ad-top-banner'); ?>
<!-- end:ad-top-banner -->

<!-- start:container -->
<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="<?php echo $page_sidebar_pos; if ( (bool)$breaking_news && isset($mp_weeklynews['_mp_breakingnews_enable']) && (bool)$mp_weeklynews['_mp_breakingnews_enable'] ) echo ' has-breaking-news'; ?>">

        <?php
            //include cover header
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
        <div id="main">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();

                    // only content value - output is visual composer
                    the_content();

                endwhile;
            endif;
        ?>
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
