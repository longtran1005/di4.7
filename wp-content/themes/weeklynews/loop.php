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
 * File Date: 08/19/14
 */

global $curr_cat_id, $curr_cat_obj, $cat_template, $post_counter;

if (have_posts()) :
?>
     
    <?php get_template_part( 'elements/'. $cat_template .'' ); ?>
 
<?php
else :
    
    _e('No posts.', THEMENAME);
    
endif;