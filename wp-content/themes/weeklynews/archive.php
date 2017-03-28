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
 * File Date: 09/15/14
 */

global $cat_template, $page_pagination;

//get page template
$cat_sidebar_template           = $mp_weeklynews['_mp_archivepage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_archivepage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_archivepage_sidebar_source_middle'];
$page_pagination                = $mp_weeklynews['_mp_archivepage_pagination'];

get_header(); ?>

<!-- start:ad-top-banner -->
<?php get_template_part('elements/ad-top-banner'); ?>
<!-- end:ad-top-banner -->

<!-- start:container -->
<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="<?php echo esc_attr($cat_sidebar_template); ?>">

        <?php
            //get sidebar
            if ( ($cat_sidebar_template != 'hide-sidebar')&&($cat_sidebar_template == 'left-sidebar')&&(!wp_is_mobile()) ) get_sidebar();

            // get sidebar-mid
            if ( ($cat_sidebar_template == 'multi-sidebar mid-left')&&(!wp_is_mobile()) ) get_sidebar( 'mid' );
        ?>

        <!-- start:main -->
        <div id="main">

            <!-- start:archive-page -->
            <section id="archive-page">

                <?php
                    get_template_part( 'elements/parts/archive-timeline' );
                ?>

            </section>
            <!-- end:archive-page -->

        </div>
        <!-- end:main -->

        <?php
            // get sidebar-mid
            if ( $cat_sidebar_template == 'multi-sidebar' ) get_sidebar( 'mid' );
        ?>

        <?php
            // get sidebar-mid
            if ( ($cat_sidebar_template == 'multi-sidebar')||($cat_sidebar_template == 'multi-sidebar mid-left')&&(wp_is_mobile()) ) get_sidebar( 'mid' );

            //get sidebar
            if ( ($cat_sidebar_template == 'multi-sidebar')||($cat_sidebar_template == 'right-sidebar')||($cat_sidebar_template == 'multi-sidebar mid-left')||(($cat_sidebar_template != 'hide-sidebar')&&($cat_sidebar_template == 'left-sidebar')&&(wp_is_mobile())) ) get_sidebar();
        ?>

    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    //load footer
    get_footer();
?>
