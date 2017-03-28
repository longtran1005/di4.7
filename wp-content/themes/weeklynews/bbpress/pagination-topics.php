<?php
/**
 * Pagination for pages of topics (when viewing a forum)
 *
 * @package bbPress
 * @subpackage WeeklyNews Theme
 */

if (!function_exists('miptheme_bbp_forum_pagination_links_custom')) {
    function miptheme_bbp_forum_pagination_links_custom($comments) {
        $comments = str_replace('&rarr;', __('Next page <i class="fa fa-chevron-right"></i>', THEMENAME), $comments);
        $comments = str_replace('&larr;', __('<i class="fa fa-chevron-left"></i> Previous page', THEMENAME), $comments);
        return $comments;
    }
    add_filter( 'bbp_get_forum_pagination_links', 'miptheme_bbp_forum_pagination_links_custom');
}

?>
<?php do_action( 'bbp_template_before_pagination_loop' ); ?>

<div class="post-pagination clearfix">
    <?php bbp_forum_pagination_links(); ?>
</div>

<?php do_action( 'bbp_template_after_pagination_loop' ); ?>
