<?php
    global  $enable_author,
            $enable_prevnext_posts,
            $curr_post_img,
            $mp_weeklynews,
            $review_post,
            $ads_post_section_three;

    if (is_single()) :

        // if via and source options
        if ( isset($mp_weeklynews['_mp_post_display_via_source']) && (bool)$mp_weeklynews['_mp_post_display_via_source'] ) {
            echo '<aside class="via-source">';
            echo '  <ul class="clearfix">';
            if ( isset($mp_weeklynews['_mp_post_display_via_name']) && ($mp_weeklynews['_mp_post_display_via_name'] != '') ) {
                if ( isset($mp_weeklynews['_mp_post_display_via_link']) && ($mp_weeklynews['_mp_post_display_via_link'] != '') ) {
                    echo '<li><span>'. __( 'Via', THEMENAME ) .'</span> <a href="'. $mp_weeklynews['_mp_post_display_via_link'] .'" title="'. $mp_weeklynews['_mp_post_display_via_name'] .'" target="_blank">'. $mp_weeklynews['_mp_post_display_via_name'] .'</a></li>';
                } else {
                    echo '<li><span>'. __( 'Via', THEMENAME ) .'</span> '. $mp_weeklynews['_mp_post_display_via_name'] .'</li>';
                }
            }
            if ( isset($mp_weeklynews['_mp_post_display_source_name']) && ($mp_weeklynews['_mp_post_display_source_name'] != '') ) {
                if ( isset($mp_weeklynews['_mp_post_display_source_link']) && ($mp_weeklynews['_mp_post_display_source_link'] != '') ) {
                    echo '<li><span>'. __( 'Source', THEMENAME ) .'</span> <a href="'. $mp_weeklynews['_mp_post_display_source_link'] .'" title="'. $mp_weeklynews['_mp_post_display_source_name'] .'" target="_blank">'. $mp_weeklynews['_mp_post_display_source_name'] .'</a></li>';
                } else {
                    echo '<li><span>'. __( 'Source', THEMENAME ) .'</span> '. $mp_weeklynews['_mp_post_display_source_name'] .'</li>';
                }
            }
            echo '  </ul>';
            echo '</aside>';
        }
?>

<?php
        $enable_tags    = isset($mp_weeklynews['_mp_enable_tags']) ? $mp_weeklynews['_mp_enable_tags'] : 'enable';
        if ( $enable_tags == 'enable' ) {
            $post_tags = get_the_tags();
            if ( $post_tags ) {
?>
<!-- start:tags -->
<aside class="tags">
    <ul class="clearfix">
        <li><span><?php _e('Tags', THEMENAME); ?></span></li>
<?php
            foreach ($post_tags as $tag) {
?>
        <li><a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo  $tag->name; ?></a></li>
<?php
            }
?>
    </ul>
</aside>
<!-- end:tags -->
<?php
            }
        }
?>

<?php
        // ads section three
        if ( $ads_post_section_three ) {
            $ad_unit        = new MipTheme_Ad();
            $ad_unit->id    = (int)$ads_post_section_three;
            // display ad unit
            echo $ad_unit->formatLayoutAd('row ad-bottom');
        }
?>

<!-- start:article footer -->
<footer>

    <?php
        if ( ($mp_weeklynews['_mp_show_social_sharing'] == 'bottom')||($mp_weeklynews['_mp_show_social_sharing'] == 'both') ) include('post-social-sharing.php');
    ?>

    <?php
        if ( $enable_prevnext_posts == 'enable' ) :
            $prev_post = get_previous_post();
            $next_post = get_next_post();
    ?>
    <aside class="post-navigation clearfix">
        <div class="row">
    <?php if (!empty( $next_post )): ?>
            <div class="col-md-6 text-right">
                <cite><?php _e('Next article', THEMENAME); ?></cite>
                <a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php echo $next_post->post_title; ?></a>
            </div>
    <?php endif; ?>
    <?php if (!empty( $prev_post )): ?>
            <div class="col-md-6">
                <cite><?php _e('Previous article', THEMENAME); ?></cite>
                <a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php echo $prev_post->post_title; ?></a>
            </div>
    <?php endif; ?>
        </div>
    </aside>
    <?php endif; ?>

    <?php

        //include post comments
        if ( isset( $mp_weeklynews['_mp_post_comments_location'] ) && ( $mp_weeklynews['_mp_post_comments_location'] == 'before-author' ) ) {
            echo '<div class="comments-top-margin">';
            require_once( get_template_directory() . '/elements/comments-section.php' );
            echo '</div>';
        }

        if ( $enable_author == 'enable' ) :
        //get author info
        $curauth = get_the_author();
    ?>
    <!-- start:article author-box -->
    <div class="author-box" itemscope itemtype="http://schema.org/Person">
        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 115 ); ?></a>
        <p class="name" itemprop="name"><?php the_author_posts_link(); ?></p>
        <p itemprop="description"><?php the_author_meta('description'); ?></p>
        <p class="follow">
        <?php
            if ( get_the_author_meta('user_url') ) echo '<a href="'. esc_url(get_the_author_meta('user_url')) .'"><i class="fa fa-home fa-lg"></i></a>';
            if ( get_the_author_meta('twitter') ) echo '<a href="'. esc_url(get_the_author_meta('twitter')) .'"><i class="fa fa-twitter fa-lg"></i></a>';
            if ( get_the_author_meta('facebook') ) echo '<a href="'. esc_url(get_the_author_meta('facebook')) .'"><i class="fa fa-facebook-square fa-lg"></i></a>';
            if ( get_the_author_meta('linkedin') ) echo '<a href="'. esc_url(get_the_author_meta('linkedin')) .'"><i class="fa fa-linkedin-square fa-lg"></i></a>';
            if ( get_the_author_meta('gplus') ) echo '<a href="'. esc_url(get_the_author_meta('gplus')) .'"><i class="fa fa-google-plus-square fa-lg"></i></a>';
            if ( get_the_author_meta('vimeo') ) echo '<a href="'. esc_url(get_the_author_meta('vimeo')) .'"><i class="fa fa-vimeo-square fa-lg"></i></a>';
            if ( get_the_author_meta('flickr') ) echo '<a href="'. esc_url(get_the_author_meta('flickr')) .'"><i class="fa fa-flickr fa-lg"></i></a>';
            if ( get_the_author_meta('tumblr') ) echo '<a href="'. esc_url(get_the_author_meta('tumblr')) .'"><i class="fa fa-tumblr-square fa-lg"></i></a>';
        ?>
        </p>
    </div>
    <!-- end:article author-box -->
    <?php
        endif;

        //include post comments
        if ( isset( $mp_weeklynews['_mp_post_comments_location'] ) && ( $mp_weeklynews['_mp_post_comments_location'] == 'after-author' ) ) {
            echo '<div class="comments-top-margin">';
            require_once( get_template_directory() . '/elements/comments-section.php' );
            echo '</div>';
        }

        if ( $review_post == 'enable' ) :
    ?>
    <meta itemprop="author" content="<?php echo get_the_author_meta('display_name'); ?>">
    <meta itemprop="about" content="<?php echo get_post_meta( get_the_ID(), '_mp_review_post_total_text', true ); ?>">
    <meta itemprop="itemreviewed" content="<?php echo get_the_title(); ?>">
    <meta itemprop="datePublished" content="<?php echo get_the_date('Y-m-d\TH:i:sP'); ?>">
    <span class="post-scope-data" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
        <meta itemprop="worstRating" content = "1">
        <meta itemprop="bestRating" content = "10">
        <meta itemprop="ratingValue" content="<?php echo round(get_post_meta( get_the_ID(), '_mp_review_post_total_score', true )/10, 1); ?>">
    </span>
    <?php
        endif;
    ?>
</footer>
<!-- end:article footer -->
<meta itemprop="datePublished" content="<?php echo get_the_date('Y-m-d\TH:i:sP'); ?>">
<meta itemprop="dateModified" content="<?php echo get_the_modified_date('Y-m-d\TH:i:sP'); ?>">
<meta itemprop="headline" content="<?php echo get_the_title(); ?>">
<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
    <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
      <meta itemprop="url" content="<?php echo esc_url($mp_weeklynews['_mp_header_logo_desktop']['url']); ?>">
      <meta itemprop="width" content="">
      <meta itemprop="height" content="">
    </div>
    <meta itemprop="name" content="<?php echo get_bloginfo('name'); ?>">
</div>
<?php
    endif;
?>
