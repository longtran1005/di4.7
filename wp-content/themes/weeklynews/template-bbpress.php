<?php
/**
 * Template Name: bbPress forum
 */

global $cat_template, $page_show_posts_num;

//get page template
$cat_sidebar_template           = $mp_weeklynews['_mp_bbpresspage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_bbpresspage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_bbpresspage_sidebar_source_middle'];

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


            <?php while ( have_posts() ) : the_post(); ?>
            <!-- start:bbpress-page -->
            <section id="bbpress-page">

                <header>
                    <h2><?php the_title(); ?></h2>
                    <span class="borderline"></span>
                </header>

                <!-- start:bbp-listings -->
                <div class="bbp-listings">
                    <?php echo do_shortcode('[bbp-forum-index]'); ?>
                </div>
                <!-- end:bbp-listings -->

            </section>
            <!-- end:bbpress-page -->
            <?php endwhile;?>

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
