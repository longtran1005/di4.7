<?php
/**
 * Pagination for pages of replies (when viewing a topic)
 *
 * @package bbPress
 * @subpackage WeeklyNews Theme
 */

if (!function_exists('mip_bbp_topic_pagination_links_custom')) {
    function mip_bbp_topic_pagination_links_custom($comments) {
        $comments = str_replace('&rarr;', __('Next page <i class="fa fa-chevron-right"></i>', THEMENAME), $comments);
        $comments = str_replace('&larr;', __('<i class="fa fa-chevron-left"></i> Previous page', THEMENAME), $comments);
        return $comments;
    }
    add_filter( 'bbp_topic_pagination_links', 'mip_bbp_topic_pagination_links_custom');
}

?>
<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="post-pagination clearfix">
    <?php bbp_topic_pagination_links(); ?>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
