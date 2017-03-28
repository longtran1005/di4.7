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

global $curr_cat_id, $curr_cat_obj, $cat_template, $cat_template_chars, $curr_sidebar_source, $curr_sidebar_source_middle, $cat_banner_show, $cat_banner_count, $cat_sidebar_template, $page_show_posts_num, $cat_quicklinks_menu;

$curr_cat_id                = get_query_var('cat');
$curr_parent_id             = $curr_cat_id; // default: set to this cat
$curr_cat_obj               = get_category($curr_cat_id);

// check for root category
if ( $curr_cat_obj->category_parent != 0 ) {
    $cat_temp_id  = $curr_cat_id;
    $cat_temp_obj = $curr_cat_obj;
    while ($cat_temp_id) {
        $cat            = get_category($cat_temp_id); // get the object for the catid
        $cat_temp_id    = $cat->category_parent; // assign parent ID (if exists) to $cat_temp_id
        if ( isset($mp_weeklynews['_mp_cat_'. $cat_temp_id .'_set_for_children']) && (bool)$mp_weeklynews['_mp_cat_'. $cat_temp_id .'_set_for_children'] ) {
            $curr_parent_id = $cat_temp_id;
        }
    }
}

//get page template
$cat_template               = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template'] != '') )                                 ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template']                 : (isset($mp_weeklynews['_mp_cat_template_default']) ? $mp_weeklynews['_mp_cat_template_default'] : '');
$cat_template_chars         = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template_chars']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template_chars'] != 0) )                      ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_template_chars']           : (isset($mp_weeklynews['_mp_cat_template_default_chars']) ? $mp_weeklynews['_mp_cat_template_default_chars'] : '');
$cat_sidebar_template       = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_template']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_template'] != '') )                 ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_template']         : (isset($mp_weeklynews['_mp_cat_sidebar_template']) ? $mp_weeklynews['_mp_cat_sidebar_template'] : '');
$curr_sidebar_source        = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source'] != '') )                     ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source']           : (isset($mp_weeklynews['_mp_cat_sidebar_source']) ? $mp_weeklynews['_mp_cat_sidebar_source'] : '');
$curr_sidebar_source_middle = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source_middle']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source_middle'] != '') )       ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_sidebar_source_middle']    : (isset($mp_weeklynews['_mp_cat_sidebar_source_middle']) ? $mp_weeklynews['_mp_cat_sidebar_source_middle'] : '');
$cat_show_title             = ( isset($mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title']) && ($mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title'] != '') )                                   ? $mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title']               : (isset($mp_weeklynews['_mp_cat_show_title']) ? $mp_weeklynews['_mp_cat_show_title'] : '');
$cat_pagination             = isset($mp_weeklynews['_mp_cat_pagination'])                                                                                                                             ? $mp_weeklynews['_mp_cat_pagination']                                  : 'post-pagination-1';
$page_show_posts_num        = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number'] > 0) )                           ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number']             : (isset($mp_weeklynews['_mp_cat_posts_number']) ? $mp_weeklynews['_mp_cat_posts_number'] : '');
$cat_quicklinks_menu        = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_header_quicklinks_menu']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_header_quicklinks_menu'] != '') )     ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_header_quicklinks_menu']   : (isset($mp_weeklynews['_mp_cat_header_quicklinks_menu']) ? $mp_weeklynews['_mp_cat_header_quicklinks_menu'] : '');

//get category layout banners
$cat_banner_show            = ( isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner']) && ($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner'] != '') )               ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner']        : (isset($mp_weeklynews['_mp_ads_cat_layout_banner']) ? $mp_weeklynews['_mp_ads_cat_layout_banner'] : '');
$cat_banner_count           = ( isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner']) && ($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner'] != '') )               ? ( ( isset($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner_count']) && ($mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner_count'] != '') )   ? $mp_weeklynews['_mp_ads_cat_'. $curr_cat_id .'_layout_banner_count']  : (isset($mp_weeklynews['_mp_ads_cat_layout_banner_count']) ? $mp_weeklynews['_mp_ads_cat_layout_banner_count'] : '') ) : (isset($mp_weeklynews['_mp_ads_cat_layout_banner_count']) ? $mp_weeklynews['_mp_ads_cat_layout_banner_count'] : 0);

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

            <!-- start:section -->
            <?php
                // check if archive template
                if ( $cat_template == 'loop-cat-8' ) {
                     echo '<section id="archive-page" class="module-timeline section-'. esc_attr($curr_cat_id) .'">';
                }
                else {
                    echo '<section class="section-'. esc_attr($curr_cat_id) .'">';
                }
            ?>

                <?php
                    if ( $cat_show_title ) {
                        if ( $cat_show_title == '1' )  {
                ?>
                    <header>
                        <h2><?php echo $curr_cat_obj->name; ?></h2>
                        <span class="borderline"></span>
                    </header>
                <?php
                        } else if ( $cat_show_title == '2' )  {

                            $cat_show_title_image  = ( isset($mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title_image']['url']) && ($mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title_image']['url'] != '') )                             ? $mp_weeklynews['_mp_cat_'. $curr_cat_id .'_show_title_image']['url']               : (isset($mp_weeklynews['_mp_cat_show_title_image']['url']) ? $mp_weeklynews['_mp_cat_show_title_image']['url'] : '');

                            if ( $cat_show_title_image != '' ) {
                ?>
                    <header>
                        <img src="<?php echo $cat_show_title_image; ?>" class="intro img-responsive" alt="<?php echo $curr_cat_obj->name; ?>" />
                    </header>
                <?php
                            }
                        }
                    }

                    locate_template('loop.php', true);












                    get_template_part('elements/parts/'. $cat_pagination );

                ?>

            </section>
            <!-- end:section -->

        </div>
        <!-- end:main -->

    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    //load footer
    get_footer();
?>
