<?php
global $curr_cat_id;

if ($wp_query->max_num_pages > 1) : ?>
<div class="post-pagination cat-<?php echo esc_attr($curr_cat_id); ?> clearfix">
    <span class="next"><?php next_posts_link( __('Next page <i class="fa fa-chevron-right"></i>', THEMENAME) ) ?></span>
    <span class="previous"><?php previous_posts_link( __('<i class="fa fa-chevron-left"></i> Previous page', THEMENAME) ) ?></span>
</div>
<?php endif; ?>	