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

global $cat_template, $page_show_posts_num;

//get page template
$cat_template                   = $mp_weeklynews['_mp_authorpage_template'];
$cat_sidebar_template           = $mp_weeklynews['_mp_authorpage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_authorpage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_authorpage_sidebar_source_middle'];
$page_pagination                = $mp_weeklynews['_mp_authorpage_pagination'];
$page_show_posts_num            = $mp_weeklynews['_mp_authorpage_posts_number'];
$curauth                        = (get_query_var('author_name'))                                        ? get_user_by('slug', get_query_var('author_name'))                     : get_userdata(get_query_var('author'));

//get page template
//$cat_template = 'loop-author-1';

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
            <section id="author-page">

                <!-- start:author-box -->
                <div class="author-box">
                    <?php echo get_avatar( $curauth->ID, 115 ); ?>
                    <p class="name"><?php echo $curauth->display_name; ?></p>
                    <?php
                        // display author actions info
                        if ( isset( $mp_weeklynews['_mp_authorpage_show_author_actions'] ) && (bool)$mp_weeklynews['_mp_authorpage_show_author_actions'] ) :
                    ?>
                    <div class="author-actions">

                        <?php
                            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['posts'] ) {
                        ?>
                        <span class="fa-file-text-o"><?php echo count_user_posts($curauth->ID). ' '  . __('posts', THEMENAME); ?></span>
                        <?php
                            }

                            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['comments'] ) {
                                // get author views
                                if ( !(isset($mp_weeklynews['_mp_post_facebook_comments_enable']) && (bool)$mp_weeklynews['_mp_post_facebook_comments_enable']) ) {
                                    $author_comments = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS author_comment_counts FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %d", $curauth->ID));
                                    echo '<span class="fa-comments">'. $author_comments . ' '  . __('comments', THEMENAME) .'</span>';
                                }
                            }


                            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['views'] ) {
                                // get author views
                                $author_posts   = new WP_Query( 'author='. $curauth->ID .'&posts_per_page=-1' );
                                $view_counter   = 0;
                                if ($author_posts->have_posts()) :
                                    while ( $author_posts->have_posts() ) :
                                        $author_posts->the_post();
                                        $views = absint( MipTheme_Post_Views::get_post_views($post->ID) );
                                        $view_counter += $views;
                                    endwhile;
                                endif;
                        ?>
                        <span class="fa-eye"><?php echo $view_counter . ' '  . __('views', THEMENAME); ?></span>
                        <?php
                                wp_reset_postdata();
                            }
                        ?>
                    </div>
                    <?php
                        // display author actions info
                        endif;
                    ?>
                    <p class="desc"><?php echo $curauth->description; ?></p>
                    <p class="follow">
                    <?php
                        if ( get_the_author_meta('user_url', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('user_url', $curauth->ID)) .'"><i class="fa fa-home fa-lg"></i></a>';
                        if ( get_the_author_meta('twitter', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('twitter', $curauth->ID)) .'"><i class="fa fa-twitter fa-lg"></i></a>';
                        if ( get_the_author_meta('facebook', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('facebook', $curauth->ID)) .'"><i class="fa fa-facebook-square fa-lg"></i></a>';
                        if ( get_the_author_meta('linkedin', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('linkedin', $curauth->ID)) .'"><i class="fa fa-linkedin-square fa-lg"></i></a>';
                        if ( get_the_author_meta('gplus', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('gplus', $curauth->ID)) .'"><i class="fa fa-google-plus-square fa-lg"></i></a>';
                        if ( get_the_author_meta('vimeo', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('vimeo', $curauth->ID)) .'"><i class="fa fa-vimeo-square fa-lg"></i></a>';
                        if ( get_the_author_meta('flickr', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('flickr', $curauth->ID)) .'"><i class="fa fa-flickr fa-lg"></i></a>';
                        if ( get_the_author_meta('tumblr', $curauth->ID) ) echo '<a href="'. esc_url(get_the_author_meta('tumblr', $curauth->ID)) .'"><i class="fa fa-tumblr-square fa-lg"></i></a>';
                    ?>
                    </p>
                </div>
                <!-- end:author-box -->

                <?php

                    if ( isset( $mp_weeklynews['_mp_authorpage_title'] ) && ( $mp_weeklynews['_mp_authorpage_title'] != '' ) ) echo '<header><h2>'. $mp_weeklynews['_mp_authorpage_title'] .'</h2><span class="borderline"></span></header>';

                    locate_template('loop.php', true);

                    require_once('elements/parts/'. $page_pagination .'.php');
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
