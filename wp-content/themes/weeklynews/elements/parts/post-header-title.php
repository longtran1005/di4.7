<?php
    global $mp_weeklynews, $enable_breadcrumbs, $enable_postmeta;
?>
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
    <?php
        if ( is_single() && (($mp_weeklynews['_mp_show_social_sharing'] == 'top')||($mp_weeklynews['_mp_show_social_sharing'] == 'both')) ) include('post-social-sharing.php');
    ?>
</header>
