<?php

$orig_post = $post;

global  $mp_weeklynews,
        $pos,
        $filter_related_posts_title,
        $filter_related_posts_offset,
        $filter_related_posts_sort,
        $page_sidebar_pos;

$rel_posts_count                = ( isset($mp_weeklynews['_mp_related_posts_count']) && ($mp_weeklynews['_mp_related_posts_count'] != '') ) ? $mp_weeklynews['_mp_related_posts_count'] : 3;

//get related posts by category
$categories = get_the_category($post->ID);
if ($categories) {
    $category_ids = array();
    foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
    $args=array(
        'category__in'          => $category_ids,
        'post__not_in'          => array($post->ID),
        'posts_per_page'        => $rel_posts_count,
        'ignore_sticky_posts'   => 1,
        'orderby'               => $filter_related_posts_sort,
        'offset'                => $filter_related_posts_offset,
        'meta_key'              => ( ($filter_related_posts_sort == 'meta_value_num') ? 'mip_post_views_count' : '' ),
    );
    $my_query = new wp_query( $args );

    $page_sidebar               = ( $page_sidebar_pos == 'multi-sidebar mid-left' )                                         ? 'multi-sidebar' : $page_sidebar_pos;
    $page_sidebar               = ( ($page_sidebar == 'left-sidebar') || ($page_sidebar == 'right-sidebar') )               ? 'sidebar' : $page_sidebar;

    $first_image_attr           = new MipTheme_ImageCat();
    $first_image                = $first_image_attr->get_image_attr_cat06($page_sidebar .'-1');

    $image_post_format_first    = $first_image[0];
    $image_post_first_width     = $first_image[1];
    $image_post_first_height    = $first_image[2];

    if( $my_query->have_posts() ) {
?>

<!-- start:related-posts -->
<section class="news-lay-3 bottom-margin">

    <header>
        <h2><?php echo $filter_related_posts_title; ?></h2>
        <span class="borderline"></span>
    </header>

<?php
    $post_counter   = 0;
    while ($my_query->have_posts()) : $my_query->the_post();
        $category = get_the_category();

        $post_article                                   = new MipTheme_Article();
        $post_article->cat_ID                           = $category[0]->term_id;
        $post_article->cat_name                         = $category[0]->name;
        $post_article->article_link                     = $post->ID;
        $post_article->article_title                    = $post->post_title;
        $post_article->article_content                  = $post->post_content;
        $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT);
        $post_article->article_comments_count           = $post->comment_count;

        $att_img_src                                    = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_post_format_first);
        $post_article->article_thumb = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '265x160' );

        if ( $post_counter%3 == 0 ) {
            if ( $post_counter > 1 ) echo '</div><!-- end:row -->';
            echo '<!-- start:row --><div class="row">';
        }

        echo '<div class="col-sm-4">'. $post_article->formatArticleStyle10($image_post_first_width,$image_post_first_height) .'</div>';

        $post_counter++;
    endwhile;
    if ( $post_counter > 0 ) echo '</div><!-- end:row -->';
?>

</section>
<!-- end:related-posts -->

<?php
    }
    $post = $orig_post;
    wp_reset_postdata();
}
?>
