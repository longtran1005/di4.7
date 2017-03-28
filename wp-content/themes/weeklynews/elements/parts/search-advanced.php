<?php
global $mp_weeklynews;

$cats                           = get_categories();
$search_category                = '';
$search_year                    = '';
$search_month                   = '';
$search_filter                  = '';
$search_sort                    = '';

if (isset($_GET['category'])) {
    $search_category            = $_GET['category'];
}
if (isset($_GET['year'])) {
    $search_year                = (int)$_GET['year'];
}
if (isset($_GET['month'])) {
    $search_month               = (int)$_GET['month'];
}

if (isset($_GET['format'])) {
    $search_filter              = $_GET['format'];
}

if (isset($_GET['sortby'])) {
    $search_sort                = $_GET['sortby'];
}

$months = array (
    '1' => __('January', THEMENAME),
    '2' => __('February', THEMENAME),
    '3' => __('March', THEMENAME),
    '4' => __('April', THEMENAME),
    '5' => __('May', THEMENAME),
    '6' => __('June', THEMENAME),
    '7' => __('July', THEMENAME),
    '8' => __('August', THEMENAME),
    '9' => __('September', THEMENAME),
    '10' => __('October', THEMENAME),
    '11' => __('November', THEMENAME),
    '12' => __('December', THEMENAME)
);

$formats = get_theme_support( 'post-formats' );

global $wp_query;
$posts_per_page             = $mp_weeklynews['_mp_searchpage_posts_number'];

$format_arr[] = '';
if ( $search_filter ) :
    $format_arr[] = array(
        'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => 'post-format-'. $search_filter,
    );
endif;

$args = array_merge( $wp_query->query_vars,
            array(
                'posts_per_page'    => $posts_per_page,
                'post_type'         => ( $mp_weeklynews['_mp_searchpage_exclude_pages'] ? 'post' : array('post', 'page') ),
                'cat'               => $search_category,
                'year'              => $search_year,
                'monthnum'          => $search_month,
                'order'             => $search_sort,
                'tax_query'         => $format_arr,
                //'category__not_in ' => $exclude_cats,
            )
        );

query_posts( $args );

?>
<header>
    <h2><?php printf( __( 'Search Results for: <span>%s</span>', THEMENAME ), get_search_query() ); ?></h2>
    <span class="borderline"></span>
</header>

<form class="form-inline form-search section-full" role="search" method="get" action="<?php echo home_url('/'); ?>">
<div class="row">
    <div class="form-group col-sm-6 col-md-4">
        <label for="field-s"><?php _e( 'Search terms', THEMENAME ); ?>:</label><br />
        <input type="text" class="form-control control-full" id="field-s" name="s" value="<?php echo $s; ?>" placeholder="<?php _e( 'Enter Search terms', THEMENAME ); ?>">
    </div>
    <div class="form-group col-sm-6 col-md-4">
        <label for="field-cat"><?php _e( 'Category', THEMENAME ); ?>:</label><br />
        <select class="form-control control-full" id="field-cat" name="category">
            <option value=""><?php _e( 'All', THEMENAME ); ?></option>
            <?php
                foreach ( $cats as $cat ) :
                    echo '<option value="'. $cat->term_id .'"'. selected( $search_category, $cat->term_id ) .'>' . $cat->name . '</option>';
                endforeach;
            ?>
        </select>
    </div>
    <div class="form-group col-sm-6 col-md-4">
        <label for="field-year"><?php _e( 'Date', THEMENAME ); ?>:</label><br />
        <select class="form-control" id="field-year" name="year">
            <option value="">...</option>
            <?php
                $years = $wpdb->get_results( "SELECT YEAR(post_date) AS year FROM wp_posts WHERE post_type = 'post' AND post_status = 'publish' GROUP BY year DESC" );
                //  For each year, do the following
                foreach ( $years as $year ) {
                    echo '<option value="'. $year->year .'"'. selected( $search_year, $year->year ) .'>' . $year->year . '</option>';
                }
                wp_reset_postdata();
            ?>
        </select>
        <select class="form-control" id="field-month" name="month">
            <option value="">...</option>
            <?php
                foreach ( $months as $val => $name ) :
                    echo '<option value="'. $val .'"'. selected( $search_month, $val ) .'>' . $name . '</option>';
                endforeach;
            ?>
        </select>
    </div>
    <div class="form-group col-sm-6 col-md-4">
        <label for="field-format"><?php _e( 'Filter by', THEMENAME ); ?>:</label><br />
        <select class="form-control control-full" id="field-format" name="format">
            <option value=""><?php _e( 'All', THEMENAME ); ?></option>
            <?php
                foreach ( $formats[0] as $format ) :
                    echo '<option value="'. $format .'"'. selected( $search_filter, $format ) .'>' . get_post_format_string($format) . '</option>';
                endforeach;
            ?>
        </select>
    </div>
    <div class="form-group col-sm-6 col-md-4">
        <label for="field-sort"><?php _e( 'Sort by', THEMENAME ); ?>:</label><br />
        <select class="form-control control-full" id="field-sort" name="sortby">
                <option value="DESC" <?php selected( $search_sort, 'DESC' ); ?>><?php _e( 'Descending', THEMENAME ); ?></option>
                <option value="ASC" <?php selected( $search_sort, 'ASC' ); ?>><?php _e( 'Ascending', THEMENAME ); ?></option>
        </select>
    </div>

    <div class="form-group col-sm-12 text-center">
        <label>&nbsp;</label><br />
        <button class="btn"><?php _e( 'Search', THEMENAME ); ?></button>
    </div>

</div>
</form>
