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

global $cat_template, $page_show_posts_num, $cat_show_title;

//get page template
$cat_template                   = $mp_weeklynews['_mp_tagpage_template'];
$cat_sidebar_template           = $mp_weeklynews['_mp_tagpage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_tagpage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_tagpage_sidebar_source_middle'];
$cat_pagination                 = $mp_weeklynews['_mp_tagpage_pagination'];
$page_show_posts_num            = $mp_weeklynews['_mp_tagpage_posts_number'];
$cat_show_title                 = 1;

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

            <!-- start:author-page -->
            <section id="tag-page">

                <header>
                    <h2><?php echo __('Posts tagged with', THEMENAME) .' "'. single_tag_title( '', false ) .'"'; ?></h2>
                    <span class="borderline"></span>
                </header>

                <?php
                    locate_template('loop.php', true);

                    get_template_part('elements/parts/'. $cat_pagination );
                ?>

            </section>
            <!-- end:author-page -->

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
