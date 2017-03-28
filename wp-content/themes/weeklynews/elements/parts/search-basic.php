<?php

global $wp_query, $mp_weeklynews;
$posts_per_page             = $mp_weeklynews['_mp_searchpage_posts_number'];

$args = array_merge( $wp_query->query_vars,
            array(
                'posts_per_page'    => $posts_per_page,
                'post_type'         => ( $mp_weeklynews['_mp_searchpage_exclude_pages'] ? 'post' : array('post', 'page') ),
            )
        );

query_posts( $args );

?>

<header>
    <h2><?php printf( __( 'Search Results for: <span>%s</span>', THEMENAME ), get_search_query() ); ?></h2>
    <span class="borderline"></span>
</header>
