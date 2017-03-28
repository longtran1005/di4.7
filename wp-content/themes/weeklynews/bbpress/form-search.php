<?php
/**
 * Search
 *
 * @package bbPress
 * @subpackage WeeklyNews Theme
 */
?>

<div class="bbp-search-wrap text-center">
    <form id="bbp-search-form" role="search" method="get" action="<?php bbp_search_url(); ?>">
        <input type="text" placeholder="<?php echo _e('Search the forum') ?>" name="bbp_search">
        <button><span class="glyphicon glyphicon-search"></span></button>
    </form>
</div>



