<?php
    global $category, $featured_video_url, $featured_audio_embed;

    $format = get_post_format();
?>

<header>
    <?php get_template_part('elements/parts/breadcrumb'); ?>
    <h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
</header>

<?php  
    if ( $featured_video_url ) :
?>

<!-- start:cover video -->
<div class="head-video relative">
    <?php
        $featured_video = new MipTheme_Video();
        echo $featured_video->renderVideo( $featured_video_url );
    ?>
</div>
<!-- end:cover video -->

<?php
    else :

        //check for post format - audio
        if ( ($format == 'audio')&&($featured_audio_embed != '') ) :
?>

<!-- start:cover audio -->
<div class="head-video relative">
    <?php
        echo $featured_audio_embed;
    ?>
</div>
<!-- end:cover audio -->

<?php
        else :
            //check for thumbnail
            if ( has_post_thumbnail() ) :
            $att_img_src    = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumb-1');
            $curr_post_img  = $att_img_src[0];
?>
<div class="head-image thumb-wrap relative">
    <img src="<?php echo $curr_post_img; ?>" width="770" height="470" alt="Responsive image" class="img-responsive" />
    <a href="<?php echo get_category_link( $category[0]->term_id ); ?>" class="theme">
        <?php echo $category[0]->name; ?>
    </a>
</div>
<?php
            endif;
        endif;
    endif;
?>

<p class="lead">
    <?php the_excerpt(); ?>
</p>

<?php the_content(); ?>

<?php
    //include share buttons and author box
    get_template_part('elements/parts/post-author-box');
?>