<?php
global $mp_weeklynews, $user_query, $cat_sidebar_template;

// User Loop
if ( ! empty( $user_query->results ) ) {
    
    $author_counter = 0;

    $Layout_col_per_rows    = ( isset( $mp_weeklynews['_mp_authorteampage_template_1_columns'] ) && (bool)$mp_weeklynews['_mp_authorteampage_template_1_columns'] )   ? $mp_weeklynews['_mp_authorteampage_template_1_columns']  : '3';
    $layout_columns         = MipTheme_Util::getColumnClass( $Layout_col_per_rows );
    $gravatar_size          = MipTheme_Util::getAvatarSize( $cat_sidebar_template, $Layout_col_per_rows );

    foreach ( $user_query->results as $user ) {

        if ( $author_counter%$Layout_col_per_rows == 0 ) {
            if ( $author_counter > 1 ) echo '</div><!-- end:row -->';
            echo '<!-- start:row --><div class="row clearfix">';
        }

        echo '<div class="author-info '. $layout_columns .'">';
        echo '<a href="'. get_author_posts_url( $user->ID ) .'">'. get_avatar( $user->ID, $gravatar_size ).'</a>';
        echo '<h3><a href="'. get_author_posts_url( $user->ID ) .'">'. $user->display_name .'</a></h3>';


        // display author actions info
        if ( isset( $mp_weeklynews['_mp_authorteampage_show_author_actions'] ) && (bool)$mp_weeklynews['_mp_authorteampage_show_author_actions'] ) :

            echo '<div class="author-actions">';

            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['posts'] ) {
                echo '  <span class="fa-file-text-o">'. count_user_posts($user->ID). ' '  . __('posts', THEMENAME) .'</span>';
            }

            // get author comments
            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['comments'] ) {
                if ( !(isset($mp_weeklynews['_mp_post_facebook_comments_enable']) && (bool)$mp_weeklynews['_mp_post_facebook_comments_enable']) ) {
                    $author_comments = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) AS author_comment_counts FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %d", $user->ID));
                    echo '<span class="fa-comments">'. $author_comments . ' '  . __('comments', THEMENAME) .'</span>';
                }
            }

            // get author views
            if ( isset($mp_weeklynews['_mp_authorpage_show_author_meta'])&&(bool)$mp_weeklynews['_mp_authorpage_show_author_meta']['views'] ) {
                $author_post_views = $wpdb->get_var($wpdb->prepare("SELECT SUM(meta_value) AS post_views, meta_key FROM $wpdb->postmeta WHERE meta_key = 'mip_post_views_count' AND post_id IN (SELECT ID from $wpdb->posts WHERE post_author = %d) GROUP BY meta_key", $user->ID));
                echo '  <span class="fa-eye">'. ($author_post_views ? $author_post_views : '0') . ' '  . __('views', THEMENAME) .'</span>';
            }
            echo '</div>';

        // display author actions info
        endif;

        //echo '<p class="desc">'. MipTheme_Util::ShortenText($user->description, 60) .'</p>';

        echo '<p class="follow">';
        if ( get_the_author_meta('user_url', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('user_url', $user->ID)) .'"><i class="fa fa-home fa-lg"></i></a>';
        if ( get_the_author_meta('twitter', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('twitter', $user->ID)) .'"><i class="fa fa-twitter fa-lg"></i></a>';
        if ( get_the_author_meta('facebook', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('facebook', $user->ID)) .'"><i class="fa fa-facebook-square fa-lg"></i></a>';
        if ( get_the_author_meta('linkedin', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('linkedin', $user->ID)) .'"><i class="fa fa-linkedin-square fa-lg"></i></a>';
        if ( get_the_author_meta('gplus', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('gplus', $user->ID)) .'"><i class="fa fa-google-plus-square fa-lg"></i></a>';
        if ( get_the_author_meta('vimeo', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('vimeo', $user->ID)) .'"><i class="fa fa-vimeo-square fa-lg"></i></a>';
        if ( get_the_author_meta('flickr', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('flickr', $user->ID)) .'"><i class="fa fa-flickr fa-lg"></i></a>';
        if ( get_the_author_meta('tumblr', $user->ID) ) echo '<a href="'. esc_url(get_the_author_meta('tumblr', $user->ID)) .'"><i class="fa fa-tumblr-square fa-lg"></i></a>';
        echo '</p>';
        echo '</div>';
        $author_counter++;

    }

    if ( $author_counter > 0 ) echo '</div><!-- end:row -->';
}

?>
