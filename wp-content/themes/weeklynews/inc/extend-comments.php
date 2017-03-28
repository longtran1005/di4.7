<?php

if ( ! class_exists( 'MipTheme_Walker_Comment' ) ) { 
    class MipTheme_Walker_Comment extends Walker_Comment
    {
        public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
            if ( !empty( $args['end-callback'] ) ) {
                ob_start();
                call_user_func( $args['end-callback'], $comment, $args, $depth );
                $output .= ob_get_clean();
                return;
            }
            if ( 'div' == $args['style'] )
                $output .= "</div><!-- #comment-## -->\n";
            else
                $output .= "<!-- #comment-## -->\n";
        }
    
    }
}

