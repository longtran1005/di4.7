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

global $cat_template;

$cat_template                   = $mp_weeklynews['_mp_searchpage_template'];
$cat_sidebar_template           = $mp_weeklynews['_mp_searchpage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_searchpage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_searchpage_sidebar_source_middle'];
$page_pagination                = $mp_weeklynews['_mp_searchpage_pagination'];
$page_type                      = $mp_weeklynews['_mp_searchpage_advanced'];

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

            <!-- start:search-page -->
            <section id="search-page">

                <?php
                    get_template_part( 'elements/parts/'. $page_type );

//                    locate_template('loop.php', true);

                /* Huong edit to display search follow new template */
                    locate_template('di-search.php', true);
                /* Huong end edit *?
                    get_template_part('elements/parts/'. $page_pagination );
                ?>

            </section>
            <!-- end:search-page -->

        </div>
        <!-- end:main -->

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
