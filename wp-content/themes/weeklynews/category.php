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

get_header(); 


?>

<div class="scroll-area">
    <div class="container">
        <div class="row">
            <div class="section col-lg-6 col-md-8 col-xs-12">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        $row_link = get_permalink($post->ID);
                        $thumbnail = get_post_thumbnail_id( $post->ID );
                        $thumb_img = get_post( $thumbnail );
                        $type_display = get_field('type_display_on_home_page', $post->ID);
                        
                        $image_src = "";
                        $font_size_class = "";
                        
                        $title = $post->post_title;
                        $headline_font_size = get_field('headline_font_size', $post->ID);
                        $font_size_class = MipTheme_Util::getHeadlineFontSize($headline_font_size, $type_display, $post->post_title);


                        ?>
                        <div class="lp_row1">
                            <div class="spteaser">
                                <?php
                                if ($type_display == "image-left" || $type_display == "image-right") {
                                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-2');
                                    $class = $type_display == "image-left" ? "imgleft" : "imgright";
                                                    
                                    ?>
                                    <div class="widget <?php  echo $class;?>">
                                        <a href="<?php  echo $row_link;?>">
                                            <span class="gate">
                                                <img src="<?php  echo $image_src[0];?>" width="256" height="144">
                                                <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                    <var>
                                                        <span><?php echo $thumb_img->post_content ?></span>
                                                        <span><?php echo $thumb_img->post_excerpt ?></span>
                                                    </var>
                                                <?php endif; ?>
                                            </span>
                                        </a>
                                        <h2>
                                            <a href="<?php  echo $row_link;?>">
                                                <span class="<?php echo $font_size_class;?>">
                                                    <?php echo $title; ?>
                                                </span>
                                            </a>
                                        </h2>
                                        <p>
                                            <a href="<?php  echo $row_link;?>">
                                                <?php  echo get_field("summary", $post->ID);?>
                                            </a>
                                        </p>
                                    </div>
                                    <?php
                                } else {
                                    $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-wide');
                                    $class = "full-width";
                                    
                                    ?>
                                    <div class="widget <?php  echo $class;?>">
                                        <?php if ($image_src) {
                                            ?>
                                            <a href="<?php  echo $row_link?>">
                                                <span class="gate imgtopic bigfoto">
                                                    <img src="<?php  echo $image_src[0];?>" width="532" height="130">
                                                    <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                        <var>
                                                            <span><?php echo $thumb_img->post_content ?></span>
                                                            <span><?php echo $thumb_img->post_excerpt ?></span>
                                                        </var>
                                                    <?php endif; ?>
                                                </span>
                                            </a>
                                        <?php } ?>
                                        <h2>
                                            <a href="<?php  echo get_permalink($post->ID);?>">
                                                <span class="<?php echo $font_size_class;?>"><?php echo $title?><br></span>
                                            </a>
                                        </h2>
                                        <p>
                                            <a href="<?php  echo get_permalink($post->ID);?>">
                                                <?php  echo get_field("summary", $post->ID);?>
                                            </a>
                                        </p>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    } //endwhile;
                    get_template_part('elements/parts/'. $cat_pagination );
                    ?>
                <?php
                }else{
                    echo "No Post.";
                }
                ?>
            </div>
            
            <div class="aside col-lg-3 col-md-4 col-xs-12">
                <a class="secondcol-prenumerera skip-frame-reload" href="http://www.di.se/pren/digital-paketering/digitalpaper/">Prenumerera</a>
                <?php get_sidebar('mid') ?>
            </div>
            
            <div class="sidebar col-lg-2 col-md-12 col-xs-12">
            </div>
            
            <div class="fourthcol col-lg-2 col-md-12 col-xs-12">
            </div>
        </div>
    </div>
</div>




<!-- end:container -->

<?php
    //load footer
    get_footer();
?>
