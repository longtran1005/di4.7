<?php
    global $mp_weeklynews, $page_pagination;

    $today          = date('Ym');
    $curr_selection = (get_query_var('m') != null)    ? get_query_var('m') : $today;
    $curr_selection = ( strlen($curr_selection) <= 4 ) ? substr($curr_selection, 0, 4 ) : substr($curr_selection, 4, 2 ) .'/'. substr($curr_selection, 0, 4 );

    $page_archive_title = $mp_weeklynews['_mp_archivepage_title'];
?>
<section id="archive-page" class="module-timeline">
    <?php
        if ( $page_archive_title ) echo '<header><h2>'. $page_archive_title .'</h2><span class="borderline"></span></header>';
    ?>
    <!-- start:articles -->
    <div class="articles">

        <div class="input-append date" id="archive-date-picker" data-date="<?php echo esc_attr($curr_selection); ?>" data-date-format="mm/yyyy">
            <input class="span2" size="16" type="text" value="<?php echo esc_attr($curr_selection); ?>" readonly>
            <span class="add-on"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>


<?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();

            $category = get_the_category();
            $post_article                                   = new MipTheme_Article();
            $post_article->cat_ID                           = $category[0]->cat_ID;
            $post_article->cat_name                         = $category[0]->cat_name;
            $post_article->article_link                     = $post->ID;
            $post_article->article_title                    = $post->post_title;
            $post_article->article_content                  = ( empty( $post->post_excerpt ) ) ? $post->post_content : $post->post_excerpt;
            $post_article->article_post_date                = get_the_time(MIPTHEME_DATE_DEFAULT) .' at '. get_the_time(MIPTHEME_TIME_DEFAULT);

            $att_img_src                    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-3');
            $post_article->article_thumb    = ( has_post_thumbnail() ) ? $att_img_src[0] : MipTheme_Global::mp_set_dummy_img( '265x160' );

            echo $post_article->formatArticleTimeline();

        endwhile;

        get_template_part('elements/parts/'. $page_pagination );
    endif;
?>

    </div>
    <!-- end:articles -->
</section>
