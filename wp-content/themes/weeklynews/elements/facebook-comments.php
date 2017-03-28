<?php
    global $mp_weeklynews;
?>
<!-- start:article-comments -->
<section id="facebook-comments">

    <header>
        <h2><fb:comments-count href="<?php echo get_permalink(); ?>"></fb:comments-count> <?php _e( 'Facebook Comments', THEMENAME ); ?></h2>
        <span class="borderline"></span>
    </header>

    <div class="fb-comments" data-href="<?php echo get_permalink(); ?>" data-width="100%" data-numposts="<?php $mp_weeklynews['_mp_post_facebook_comments_number']; ?>" data-colorscheme="light"></div>

</section>
<!-- end:article-comments -->

