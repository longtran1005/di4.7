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

global $page_template;

if (have_posts()) : the_post();
?>
    <?php
        get_template_part( 'elements/'. $page_template .'' );
        /*if ( has_post_thumbnail() ) :
            get_template_part( 'elements/'. $page_template .'' );
        else :
            get_template_part( 'elements/loop-page-5' );
        endif;*/
    ?>
<?php
else :
    
    _e('No posts.', THEMENAME);
    
endif;