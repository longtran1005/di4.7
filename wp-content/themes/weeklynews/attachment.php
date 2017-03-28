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

//get page template
$cat_sidebar_template                   = 'right-sidebar';

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

            <!-- start:article-post -->
            <article class="article-post clearfix">
            <?php
                if (have_posts()) {
                    while ( have_posts() ) : the_post();

                        $att_url = '';
                        $att_alt = '';

                        if ( wp_attachment_is_image( $post->id ) ) {
                            $att_img_src = wp_get_attachment_image_src( $post->id, 'full');

                            if (!empty($att_img_src[0])) {
                                $att_url = $att_img_src[0];
                            }

                            if (empty($att_img_src[0])) {
                                $att_img_src[0] = '';
                            }

                            $att_img_data = MipTheme_Util::get_image_attachment_data($post->post_parent);
                            if (!empty($att_img_data->alt)) {
                                $att_alt = $att_img_data->alt;
                            }

            ?>

            <header itemscope="" itemtype="http://schema.org/Article">
                <?php get_template_part('elements/parts/breadcrumb'); ?>
                <h1 itemprop="name"><?php the_title(); ?></h1>
            </header>

            <a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment">
                <img class="thumbnail" src="<?php echo esc_url($att_url); ?>" alt="<?php echo esc_attr($att_alt) ?>" />
            </a>

            <p>
                <?php the_content(); ?>
            </p>
            <?php
                        }
                    endwhile; //end loop
                } else {
                    _e('No posts.', THEMENAME);
                }
            ?>
            </article>
            <!-- end:article-post -->

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
