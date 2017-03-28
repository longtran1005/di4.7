<?php
/**
 * Template Name: Team Of Authors
 */

global $cat_template, $page_show_posts_num, $user_query;

//get page template
$cat_sidebar_template           = $mp_weeklynews['_mp_authorpage_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_authorpage_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_authorpage_sidebar_source_middle'];
$authors_exclude                = $mp_weeklynews['_mp_authorteampage_exclude'];
$authors_per_page               = ( isset($mp_weeklynews['_mp_authorteampage_authors_per_page']) && ( $mp_weeklynews['_mp_authorteampage_authors_per_page'] > 0  ) )    ? $mp_weeklynews['_mp_authorteampage_authors_per_page'] : 99999;
$authors_orderby                = ( isset($mp_weeklynews['_mp_authorteampage_authors_orderby']) )    ? $mp_weeklynews['_mp_authorteampage_authors_orderby']   : 'post_count';
$authors_order                  = ( isset($mp_weeklynews['_mp_authorteampage_authors_order']) )    ? $mp_weeklynews['_mp_authorteampage_authors_order']   : 'DESC';
$authors_roles                  = ( isset($mp_weeklynews['_mp_authorteampage_authors_roles']) && ($mp_weeklynews['_mp_authorteampage_authors_roles'] != ''))    ? $mp_weeklynews['_mp_authorteampage_authors_roles']   : array('Author');

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


            <?php
                while ( have_posts() ) : the_post();

                // Template
                $authorteampage_template    = ( isset( $mp_weeklynews['_mp_authorteampage_template'] ) && (bool)$mp_weeklynews['_mp_authorteampage_template'] )   ? $mp_weeklynews['_mp_authorteampage_template']  : 'authorteampage-1';
            ?>
            <!-- start:bbpress-page -->
            <section id="team-author-page" class="<?php echo $authorteampage_template; ?>">

                <header>
                    <h2><?php the_title(); ?></h2>
                    <span class="borderline"></span>
                </header>

                <?php the_content(); ?>

                <?php

                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    if($paged==1){
                      $offset=0;
                    }else {
                       $offset= ($paged-1)*$authors_per_page;
                    }

                    global $wpdb;
                    $blog_id = get_current_blog_id();
                    $meta_query = array(
                        'key' => $wpdb->get_blog_prefix($blog_id) . 'capabilities',
                        'value' => '"(' . implode('|', array_map('preg_quote', $authors_roles)) . ')"',
                        'compare' => 'REGEXP'
                    );

                    if ( $authors_orderby == 'post_views' ) { // sort by post views
                        if ( $paged == 1 ) {
                            $tmp_args = array(
                                'meta_query'=> array($meta_query),
                                'exclude'   => array( $authors_exclude ),
                                'orderby'   => $authors_orderby,
                                'order'     => $authors_order
                            );
                            $tmp_query      = new WP_User_Query( $tmp_args );
                            if ( ! empty( $tmp_query->results ) ) {
                                foreach ( $tmp_query->results as $tmp_user ) {
                                    $tmp_author_post_views = $wpdb->get_var($wpdb->prepare("SELECT SUM(meta_value) AS post_views, meta_key FROM $wpdb->postmeta WHERE meta_key = 'mip_post_views_count' AND post_id IN (SELECT ID from $wpdb->posts WHERE post_author = %d) GROUP BY meta_key", $tmp_user->ID));
                                    update_user_meta( $tmp_user->ID, 'mip_author_post_views', $tmp_author_post_views );
                                }
                            }
                        }

                        $args = array(
                            'meta_query'=> array($meta_query),
                            'exclude'   => array( $authors_exclude ),
                            'orderby'   => 'meta_value_num',
                            'meta_key'  => 'mip_author_post_views',
                            'order'     => $authors_order,
                            'number'    => $authors_per_page,
                            'offset'    => $offset // skip the number of users that we have per page
                        );
                    } else {
                        $args = array(
                            'meta_query'=> array($meta_query),
                            'exclude'   => array( $authors_exclude ),
                            'orderby'   => $authors_orderby,
                            'order'     => $authors_order,
                            'number'    => $authors_per_page,
                            'offset'    => $offset // skip the number of users that we have per page
                        );
                    }

                    // The Query
                    $user_query                 = new WP_User_Query( $args );

                    // Include template
                    get_template_part('elements/'. $authorteampage_template);


                    $total_user = $user_query->total_users;
                    $total_pages=ceil($total_user/$authors_per_page);

                    echo '<div class="post-pagination clearfix">';
                    echo paginate_links(array(
                        'base'      => get_pagenum_link(1) . '%_%',
                        'format'    => '?paged=%#%',
                        'current'   => $paged,
                        'total'     => $total_pages,
                        'prev_next' => false,
                        'type'      => 'plain',
                    ));
                    echo '</div>';

                ?>

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
