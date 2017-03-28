<?php
global  $curr_cat_id,
        $cat_template,
        $cat_template_chars,
        $page_show_posts_num,
        $page_type;

$curr_cat_id                    = 0;
$page_pagination                = isset($mp_weeklynews['_mp_homepage_pagination'])          ? $mp_weeklynews['_mp_homepage_pagination']                 : 'post-pagination-1';
$page_show_posts_num            = $mp_weeklynews['_mp_homepage_posts_number'];
$page_type                      = 'homepage';

get_header(); ?>

<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="<?php echo esc_attr($cat_sidebar_template); if ( (bool)$breaking_news && isset($mp_weeklynews['_mp_breakingnews_enable']) && (bool)$mp_weeklynews['_mp_breakingnews_enable'] ) echo ' has-breaking-news'; ?>">

        <!-- start:tbl-row -->
        <div class="tbl-row">

        <?php
            //get sidebar
            if ( ($cat_sidebar_template != 'hide-sidebar')&&($cat_sidebar_template == 'left-sidebar')&&(!wp_is_mobile()) ) get_sidebar();

            // get sidebar-mid
            if ( ($cat_sidebar_template == 'multi-sidebar mid-left')&&(!wp_is_mobile()) ) get_sidebar( 'mid' );
        ?>

        <!-- start:main -->
        <div id="main">

            <?php
                // check if archive template
                if ( $cat_template == 'loop-cat-8' ) {
                     echo '<section id="archive-page" class="module-timeline">';
                }

                locate_template('loop.php', true);

                if ( $page_pagination ) require_once('elements/parts/'. $page_pagination .'.php');

                // check if archive template
                if ( $cat_template == 'loop-cat-8' ) {
                     echo '</section>';
                }
            ?>

        </div>
        <!-- end:main -->

        <?php
            // get sidebar-mid
            if ( ($cat_sidebar_template == 'multi-sidebar')||($cat_sidebar_template == 'multi-sidebar mid-left')&&(wp_is_mobile()) ) get_sidebar( 'mid' );

            //get sidebar
            if ( ($cat_sidebar_template == 'multi-sidebar')||($cat_sidebar_template == 'right-sidebar')||($cat_sidebar_template == 'multi-sidebar mid-left')||(($cat_sidebar_template != 'hide-sidebar')&&($cat_sidebar_template == 'left-sidebar')&&(wp_is_mobile())) ) get_sidebar();
        ?>

        </div>
        <!-- end:tbl-row -->

    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    get_footer();
?>
