<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! function_exists( 'pageTitle' ) ) {
    function pageTitle($echo){
        $title = "";

        global $paged;
        if (function_exists('is_tag') && is_tag()) {
            $title .= single_tag_title(__("Tag Archive for &quot;" , 'circle'),false);
            $title .= '&quot; - ';
        }
        elseif (is_archive()) {
            $title .= wp_title('',true);
            //$title .= __(' Archive - ' , 'circle');
            $title .= __(' - ' , 'circle');

        }
        elseif (is_search()) {
        $title .= __('Search for &quot;' , 'circle') . esc_html(get_search_query()).'&quot; - ';
        }
        elseif (!(is_404()) && (is_single()) || (is_page())) {
            $title .= wp_title('',true);
            $title .= ' - ';
        }
        elseif (is_404()) {
            $title .= __('Not Found - ' , 'circle');
        }
        if (is_home()) {
            $title .= get_bloginfo('name');
            $title .= ' - ';
            $title .= get_bloginfo('description');
        }
        else {
            $title .= get_bloginfo('name');
        }
        if ($paged>1) {
            $title .= ' - page ' . $paged;
        }

        if ( !$echo ) return $title;
        echo $title;
    }
}


if ( ! function_exists( 'miptheme_custom_link_page' ) ) {
    function miptheme_custom_link_page( $anchor, $class, $i ) {
        global $wp_rewrite;
        $post = get_post();

        if ( 1 == $i ) {
                $url = get_permalink();
        } else {
                if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
                        $url = add_query_arg( 'page', $i, get_permalink() );
                elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
                        $url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
                else
                        $url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
        }

        if ( is_preview() ) {
                $url = add_query_arg( array(
                        'preview' => 'true'
                ), $url );

                if ( ( 'draft' !== $post->post_status ) && isset( $_GET['preview_id'], $_GET['preview_nonce'] ) ) {
                        $url = add_query_arg( array(
                                'preview_id'    => wp_unslash( $_GET['preview_id'] ),
                                'preview_nonce' => wp_unslash( $_GET['preview_nonce'] )
                        ), $url );
                }
        }

        return '<a class="'. $class .'" href="' . esc_url( $url ) . $anchor .'">';
    }
}


if ( ! function_exists( 'miptheme_custom_wp_link_pages' ) ) {
    function miptheme_custom_wp_link_pages( $args = '' ) {
        $defaults = array(
            'before' => '<div id="post-paging">',
            'after' => '</div>',
            'text_before' => '',
            'text_after' => '',
            'next_or_number' => 'number',
            'nextpagelink' => '<i class="fa fa-chevron-right"></i>',
            'previouspagelink' => '<i class="fa fa-chevron-left"></i>',
            'pagelink' => '%',
            'echo' => 1
        );

        $r = wp_parse_args( $args, $defaults );
        $r = apply_filters( 'wp_link_pages_args', $r );
        extract( $r, EXTR_SKIP );

        global $page, $numpages, $multipage, $more, $pagenow;

        $output = '';
        if ( $multipage ) {
            // previous
            if ( $more ) {
                $output .= $before;
                $i = $page - 1;
                if ( $i && $more ) {
                    $output .= miptheme_custom_link_page( '#page-content', 'prev', $i );
                    $output .= $text_before . $previouspagelink . $text_after . '</a> ';
                } else {
                    $output .= '<span class="disabled"><i class="fa fa-chevron-left"></i></span> ';
                }
                $output .= '<span class="current">'. $page .' <em> of </em> '. $numpages . '</span> ';

                $i = $page + 1;
                if ( $i <= $numpages && $more ) {
                    $output .= miptheme_custom_link_page( '#page-content', 'next', $i );
                    $output .= $text_before . $nextpagelink . $text_after . '</a>';
                }
                $output .= $after;
            }
        }

        if ( $echo )
                echo $output;

        return $output;
    }
}

if ( ! function_exists( 'miptheme_generate_slug' ) ) {
    function miptheme_generate_slug($phrase, $maxLength)
    {
        $result = strtolower($phrase);

        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = trim(preg_replace("/[\s-]+/", " ", $result));
        $result = trim(substr($result, 0, $maxLength));
        $result = preg_replace("/\s/", "-", $result);

        return $result;
    }
}

if ( ! function_exists( 'miptheme_set_post_views' ) ) {
    function miptheme_set_post_views($postID) {
        $count_key = 'mip_post_views_count';
        $count = get_post_meta($postID, $count_key, true);
        if($count==''){
            $count = 0;
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');
        }else{
            $count++;
            update_post_meta($postID, $count_key, $count);
        }
    }
}


if ( ! function_exists( 'miptheme_track_post_views' ) ) {
    function miptheme_track_post_views ($post_id) {
        if ( !is_single() ) return;
        if ( empty ( $post_id) ) {
            global $post;
            $post_id = $post->ID;
        }
        miptheme_set_post_views($post_id);
    }
}


if ( ! function_exists( 'miptheme_add_widget_to_sidebar' ) ) {
    function miptheme_add_widget_to_sidebar($sidebarSlug, $widgetSlug, $widgetSettings = array()) {
        $sidebarOptions = get_option('sidebars_widgets');
        if(!isset($sidebarOptions[$sidebarSlug])){
        $sidebarOptions[$sidebarSlug] = array('_multiwidget' => 1);
        }
        $newWidget = get_option('widget_'.$widgetSlug);
        if(!is_array($newWidget))$newWidget = array();
        $count = count($newWidget)+1;
        $sidebarOptions[$sidebarSlug][] = $widgetSlug.'-'.$count;

        $newWidget[$count] = $widgetSettings;

        update_option('sidebars_widgets', $sidebarOptions);
        update_option('widget_'.$widgetSlug, $newWidget);
    }
}


if ( ! function_exists( 'miptheme_generate_options_css' ) ) {
    function miptheme_generate_options_css($newdata) {
    	$data = $newdata;
    	$css_dir = get_template_directory() .'/assets/css/'; // Shorten code, save 1 call

    	ob_start(); // Capture all output (output buffering)

    	require($css_dir . 'dynamic.css.php'); // Generate CSS

    	$css = ob_get_clean(); // Get generated CSS (output buffering)
    	file_put_contents($css_dir . 'dynamic.css', $css, LOCK_EX); // Save it
    }
}


if ( ! function_exists( 'miptheme_add_custom_body_class' ) ) {
    function miptheme_add_custom_body_class($classes) {
        global $mp_weeklynews;

        if ( isset($mp_weeklynews['_mp_cat_show_postmeta_linkbox']) && (bool)$mp_weeklynews['_mp_cat_show_postmeta_linkbox'] ) {
            $classes[] = 'linkbox-has-meta';
        }

        if ( isset($mp_weeklynews['_mp_linkbox_layout']) && ($mp_weeklynews['_mp_linkbox_layout'] != '') ) {
            $classes[] = $mp_weeklynews['_mp_linkbox_layout'];
        }

        if ( isset($mp_weeklynews['_mp_theme_layout']) && ($mp_weeklynews['_mp_theme_layout']!= '') ) {
            $classes[] = $mp_weeklynews['_mp_theme_layout'];
        }

        if ( isset($mp_weeklynews['_mp_theme_layout_sidebar_padding']) && isset($mp_weeklynews['_mp_theme_layout']) && ($mp_weeklynews['_mp_theme_layout'] == 'theme-unboxed') ) {
            $classes[] = $mp_weeklynews['_mp_theme_layout_sidebar_padding'];
        }

        if ( isset($mp_weeklynews['_mp_theme_style']) && ($mp_weeklynews['_mp_theme_style'] == 'theme-light') && isset($mp_weeklynews['_mp_theme_light_style']) && ($mp_weeklynews['_mp_theme_light_style'] != 'light-header') ) {
            $classes[] = 'sidebar-light';
        } else {
            $classes[] = 'sidebar-dark';
        }

    	return $classes;
    }
}


//Adding the Open Graph in the Language Attributes
function miptheme_add_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}


//Lets add Open Graph Meta Info
function miptheme_insert_fb_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
    echo '<meta property="og:title" content="' . get_the_title() . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . get_permalink() . '"/>';
    echo '<meta property="og:site_name" content="'. get_bloginfo() .'"/>';
    if($excerpt = $post->post_excerpt) {
        $excerpt = strip_tags($post->post_excerpt);
        $excerpt = str_replace("", "'", $excerpt);
    } else {
        $excerpt = get_bloginfo('description');
    }
    echo '<meta property="og:description" content="'. $excerpt .'"/>';
	if(has_post_thumbnail( $post->ID )) {
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        if (!empty($thumbnail_src[0])) {
		          echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
        }
	}
	echo "";
}
