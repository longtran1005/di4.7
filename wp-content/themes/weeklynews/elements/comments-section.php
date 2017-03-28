<?php
    global $mp_weeklynews;
    if ( isset($mp_weeklynews['_mp_post_facebook_comments_enable']) && (bool)$mp_weeklynews['_mp_post_facebook_comments_enable'] ) :
        get_template_part( 'elements/facebook-comments' );
    else :
        comments_template();
    endif;
?>