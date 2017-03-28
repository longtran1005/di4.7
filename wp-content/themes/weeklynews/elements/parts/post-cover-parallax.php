<?php
    global $category, $featured_video_url, $featured_audio_embed, $format, $enable_postmeta, $enable_breadcrumbs, $mp_weeklynews, $show_category_feat_img;

    $format = get_post_format();

    if ( has_post_thumbnail() ) :
        //check for thumbnail
        $post_cover_format          = array(1170,480);
        $post_parallax_format       = array(1200,800);

        $att_img_src                = wp_get_attachment_image_src( get_post_thumbnail_id(), $post_cover_format);
        $curr_post_img              = $att_img_src[0];

        $att_img_src_parallax       = wp_get_attachment_image_src( get_post_thumbnail_id(), $post_parallax_format);
        $curr_post_img_parallax     = $att_img_src_parallax[0];
?>

<!-- start:cover image -->
<div class="head-image cat-<?php if ($category[0]) echo esc_attr($category[0]->cat_ID); ?>">
    <div class="head-image-parallax thumb-wrap relative" style="background-image: url(<?php echo $curr_post_img_parallax; ?>);">
        <img src="<?php echo esc_url($curr_post_img_parallax); ?>" width="1170" height="480" alt="<?php echo get_the_title(); ?>" class="img-responsive" />
        <?php
            if ( $show_category_feat_img ) echo '<a href="'. get_category_link( $category[0]->term_id ) .'" class="theme">'. $category[0]->name .'</a>';
        ?>
        <div class="overlay" itemscope itemtype="http://schema.org/Article">
            <header>
                <?php if ( $enable_breadcrumbs == 'enable' ) get_template_part('elements/parts/breadcrumb'); ?>
                <h1 itemprop="name"><?php the_title(); ?></h1>
                <?php if ( $enable_postmeta == 'enable' ) { ?>
                <p class="post-meta clearfix">
                    <?php if ( isset($mp_weeklynews['_mp_enable_postmeta_elements']['date']) && $mp_weeklynews['_mp_enable_postmeta_elements']['date'] ) : ?><span class="fa-calendar" itemprop="dateCreated"><?php echo get_the_date(MIPTHEME_DATE_DEFAULT); ?></span><?php endif; ?>
                    <?php if ( isset($mp_weeklynews['_mp_enable_postmeta_elements']['author']) && $mp_weeklynews['_mp_enable_postmeta_elements']['author'] ) : ?><span class="fa-author" itemprop="author"><?php echo get_avatar( get_the_author_meta( 'ID', $post->post_author ), 16 ); ?> <a href="<?php echo get_author_posts_url( $post->post_author ); ?>"><?php the_author_meta( 'display_name', $post->post_author ); ?></a></span><?php endif; ?>
                    <?php
                        if ( isset($mp_weeklynews['_mp_enable_postmeta_elements']['categories']) && $mp_weeklynews['_mp_enable_postmeta_elements']['categories'] ) :
                            $cats               = get_the_category();
                            $cats_separator     = ', ';
                            $cats_output        = '';
                            if($cats){
                                foreach($cats as $cat) {
                                    $cats_output .= '<a href="'.get_category_link( $cat->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $cat->name ) ) . '">'.$cat->cat_name.'</a>'.$cats_separator;
                                }
                                echo '<span class="fa-categories">'. trim($cats_output, $cats_separator) .'</span>';
                            }
                        endif;
                    ?>
                <?php
                    if ( isset($mp_weeklynews['_mp_enable_postmeta_elements']['comments']) && $mp_weeklynews['_mp_enable_postmeta_elements']['comments'] ) :
                        if ( isset($mp_weeklynews['_mp_post_facebook_comments_enable'])&&(bool)$mp_weeklynews['_mp_post_facebook_comments_enable']) {
                ?>
                <span class="fa-comments"><fb:comments-count href="<?php echo get_permalink(); ?>"></fb:comments-count> <?php _e( 'comments', THEMENAME ); ?></span>
                <?php
                        } else {
                ?>
                <span class="fa-comments"><a href="<?php comments_link(); ?>"><?php comments_number('0', '1', '%'); ?> <?php _e( 'comments', THEMENAME ); ?></a></span>
                <?php
                        }
                    endif;
                ?>
                <?php if ( isset($mp_weeklynews['_mp_enable_postmeta_elements']['views']) && $mp_weeklynews['_mp_enable_postmeta_elements']['views'] ) : ?><span class="fa-eye post-view-counter-<?php echo $post->ID;?>"><?php echo MipTheme_Post_Views::get_post_views($post->ID); ?></span><?php endif; ?>
                </p>
                <?php } ?>
                <div class="sharing hidden-xs hidden-sm">
                    <?php if ( isset($mp_weeklynews['_mp_social_sharing_facebook']) && $mp_weeklynews['_mp_social_sharing_facebook'] != 'none' ) : ?><a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-facebook-square fa-lg"></i></a><?php endif; ?>
                    <?php if ( isset($mp_weeklynews['_mp_social_sharing_twitter']) && $mp_weeklynews['_mp_social_sharing_twitter'] != 'none' ) : ?><a href="https://twitter.com/intent/tweet?text=<?php echo esc_attr(get_the_title()); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-twitter fa-lg"></i></a><?php endif; ?>
                    <?php if ( isset($mp_weeklynews['_mp_social_sharing_google']) && $mp_weeklynews['_mp_social_sharing_google'] != 'none' ) : ?><a href="http://plus.google.com/share?url=<?php echo get_permalink(); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-google-plus-square fa-lg"></i></a><?php endif; ?>
                    <?php if ( isset($mp_weeklynews['_mp_social_sharing_linkedin']) && $mp_weeklynews['_mp_social_sharing_linkedin'] != 'none' ) : ?><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-linkedin-square fa-lg"></i></a><?php endif; ?>
                    <?php if ( isset($mp_weeklynews['_mp_social_sharing_pinterest']) && $mp_weeklynews['_mp_social_sharing_pinterest'] != 'none' ) : ?><a href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&amp;media=<?php echo ( $curr_post_img ? $curr_post_img : ''); ?>"  onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-pinterest-square fa-lg"></i></a><?php endif; ?>
                </div>
                <?php
                    if ( get_post_meta( get_the_ID(), '_mp_featured_image_caption', true ) ) {
                        echo '<div class="featured-caption">'. get_post_meta( get_the_ID(), '_mp_featured_image_caption', true ) .'</div>';
                    }
                ?>
            </header>
        </div>
    </div>
</div>
<!-- end:cover image -->

<?php
    endif;
?>
