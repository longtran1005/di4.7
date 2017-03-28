<?php
/**
 * WeeklyNews Theme
 *
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

# Constants
define('THEMENAME',         'weeklynews');
define('THEMEOPTIONSNAME', 	'_mp_wn_');
define('THEMEREDUXNAME', 	'mp_weeklynews');
define('THEMEVERSION',      '2.5.4');
define('THEMEDIR', 	        get_template_directory() . '/');
define('THEMEURL', 	        get_template_directory_uri() . '/');
define('WPURL', 	        site_url('/'));
define('URL', 		        home_url('/'));
define('BFI_QUALITY', 		'90');


add_action( 'after_setup_theme', 'weeklynews_theme_setup' );
function weeklynews_theme_setup() {

    global $mp_weeklynews, $content_width;

    # Theme Support
    add_theme_support('menus');
    add_theme_support('widgets');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('featured-image');
    add_theme_support('post-formats', array( 'gallery', 'video', 'quote', 'audio', 'image' ) );
    add_theme_support('custom-background', array('default-color'   => '#ffffff') );
    add_theme_support('woocommerce');

    # Theme Textdomain
    load_theme_textdomain(THEMENAME, get_template_directory() . '/languages');


    # Enqueue scripts and styles for the front end
    add_action('wp_enqueue_scripts', 'miptheme_scripts');
    add_action('wp_update_nav_menu', 'miptheme_generate_options_css');
    add_action('redux/options/mp_weeklynews/saved', 'miptheme_generate_options_css');
    add_action('admin_enqueue_scripts', 'miptheme_admin_css');
    add_action('after_setup_theme', 'miptheme_add_editor_styles');
    add_action('wp_head', 'miptheme_analytics_code', 40);
    add_action('wp_head', 'miptheme_custom_js_code_header', 40);
    add_action('wp_footer', 'miptheme_custom_js_code', 40);
    add_action('admin_menu', 'miptheme_remove_redux_menu',12 );

    # add custom body class
    add_filter('body_class', 'miptheme_add_custom_body_class');

    # Administrative Functions
    if (is_admin()) {
        // add custom functionalities
        require_once('wp-admin/tinymce/tinymce.php');
    }

    if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/inc/redux/ReduxCore/framework.php' ) ) {
        require_once( dirname( __FILE__ ) . '/inc/redux/ReduxCore/framework.php' );
    }
    require_once(dirname( __FILE__ ) . '/inc/redux-metaboxes.php');
    require_once(dirname( __FILE__ ) . '/inc/redux-options.php');


    // redux framework - custom actions
    add_action('init', 'miptheme_removeReduxDemoMode');


    # Theme Customizer
    require_once('inc/class-customizer.php');


    # Extending user profile
    add_filter('user_contactmethods', 'miptheme_modify_contact_methods');


    # Extending categories with colorpicker
    add_action('category_add_form_fields', 'miptheme_category_form_custom_field_add', 10 );
    add_action('category_edit_form_fields','miptheme_extra_category_fields', 10);
    add_action('edited_category', 'miptheme_save_extra_category_fileds');
    add_action('created_category', 'miptheme_save_extra_category_fileds', 11, 1);
    add_action('edited_category', 'miptheme_generate_options_css');
    add_action('created_category', 'miptheme_generate_options_css', 11, 1);
    add_action('admin_enqueue_scripts', 'miptheme_colorpicker_enqueue' );


    # Extending menus with walker class
    add_action('wp_update_nav_menu_item', 'miptheme_custom_nav_update',10, 3);
    add_filter('wp_setup_nav_menu_item','miptheme_custom_nav_item' );
    add_filter('wp_edit_nav_menu_walker', 'miptheme_custom_nav_edit_walker',10,2 );
    add_filter('nav_menu_css_class', 'miptheme_wpa_category_nav_class', 10, 2 );


    # Load Global Functions - Utils - Widgets
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    //add_action( 'wp_head', 'miptheme_track_post_views');


    # Load Widget Classes
    add_action( 'widgets_init', 'miptheme_load_widgets' );

    # Shortcode Classes
    add_shortcode('review', array( 'MipTheme_Review', 'get_review' ));
    add_shortcode('miptheme_alert', array( 'MipTheme_Alert', 'get_alert' ));
    add_shortcode('miptheme_dropcap', array( 'MipTheme_Dropcap', 'get_dropcap' ));
    add_shortcode('miptheme_spacer', array( 'MipTheme_Spacer', 'get_spacer' ));
    add_shortcode('miptheme_list', array( 'MipTheme_List', 'get_list' ));
    add_shortcode('miptheme_listitem', array( 'MipTheme_List', 'get_listitem' ));
    add_shortcode('miptheme_quote', array( 'MipTheme_Quotes', 'get_quote' ));


    # Register Ads System Post class
    add_action('init','MipTheme_Register_Adsystem_Post_Type');


    # Register Thumbnail Sizes
    // slider images
    add_image_size('slider-big', 819, 452, true);
    add_image_size('slider-thumb-1', 292, 452, true);
    add_image_size('slider-thumb-2', 350, 150, true);

    // post images
    add_image_size('post-thumb-1', 770, 470, true);
    
    add_image_size('post-thumb-3', 265, 160, true);
    add_image_size('post-thumb-7', 100,  80, true);
    add_image_size('post-thumb-9', 370, 223, true);

    // di
    add_image_size('post-thumb-wide', 532, 130, true);
    add_image_size('post-thumb-2', 560, 390, true);
    

    # Register Menus
    register_nav_menus(
        array(
            'top-menu' => __( 'Top Menu', 'mip-theme' ),
            'header-menu' => __( 'Header Menu (Primary Navigation)', 'mip-theme' ),
            'footer-menu' => __( 'Footer Menu', 'mip-theme' )
        )
    );


    # Register Sidebars
    if(isset($mp_weeklynews['_mp_sidebars']) && sizeof($mp_weeklynews['_mp_sidebars']) > 0)
    {
        // add primary widget
        register_sidebar(
            array(
                'id' => 'primary-widget-area',
                'name' =>  __( 'Primary Widget Area', THEMENAME ),
                'description' => __( 'The Primary widget area (Main Sidebar)', THEMENAME ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
                'after_widget' => '</aside>',
                'before_title' => '<header><h2>',
                'after_title' => '</h2><span class="borderline"></span></header>'
            )
        );

        // add secondary widget
        register_sidebar(
            array(
                'id' => 'secondary-widget-area',
                'name' =>  __( 'Secondary Widget Area', THEMENAME ),
                'description' => __( 'The Secondary widget area (Mid Sidebar)', THEMENAME ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
                'after_widget' => '</aside>',
                'before_title' => '<header><h2>',
                'after_title' => '</h2><span class="borderline"></span></header>'
            )
        );

        foreach($mp_weeklynews['_mp_sidebars'] as $sidebar)
        {
            register_sidebar(
                array(
                    'id' => miptheme_generate_slug($sidebar, 45),
                    'name' => __( $sidebar, THEMENAME ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
                    'after_widget' => '</aside>',
                    'before_title' => '<header><h2>',
                    'after_title' => '</h2><span class="borderline"></span></header>'
                )
            );
        }
    }


    # Filter to Replace default css class for vc_row shortcode and vc_column
    add_filter('vc_shortcodes_css_class', 'miptheme_shortcodes_css_class', 10, 2);

    # Force Visual Composer to initialize as "built into the theme"
    if (function_exists('vc_set_as_theme')) {
        vc_set_as_theme();
    }


    # Jetpack galleries fix
    if ( ! isset( $content_width ) ) $content_width = 770;


    # Date variables
    define('MIPTHEME_DATE_HEADER',          ( (isset( $mp_weeklynews['_mp_dateformat_header'] ))        ? $mp_weeklynews['_mp_dateformat_header']       : 'F jS, Y' ) );
    define('MIPTHEME_DATE_DEFAULT',         ( (isset( $mp_weeklynews['_mp_dateformat_default'] ))       ? $mp_weeklynews['_mp_dateformat_default']      : 'F jS, Y' ) );
    define('MIPTHEME_DATE_DEFAULT_SHORT',   ( (isset( $mp_weeklynews['_mp_short_dateformat_default'] )) ? $mp_weeklynews['_mp_short_dateformat_default']: 'M jS, Y' ) );
    define('MIPTHEME_TIME_DEFAULT',         ( (isset( $mp_weeklynews['_mp_timeformat_default'] ))       ? $mp_weeklynews['_mp_timeformat_default']      : 'g:i A' ) );
    define('MIPTHEME_DATE_SIDEBAR',         ( (isset( $mp_weeklynews['_mp_dateformat_sidebar'] ))       ? $mp_weeklynews['_mp_dateformat_sidebar']      : 'M jS, Y' ) );
    define('MIPTHEME_DATE_TIMELINE',        ( (isset( $mp_weeklynews['_mp_dateformat_timeline'] ))      ? $mp_weeklynews['_mp_dateformat_timeline']     : 'M jS' ) );


    # WooCommerce
    add_action( 'after_switch_theme', 'miptheme_woocommerce_image_dimensions', 1 );
    add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args' );
        function jk_related_products_args( $args ) {

        $args['posts_per_page'] = 4; // 4 related products
        $args['columns'] = 4; // arranged in 2 columns
        return $args;
    }


    # Ajax Paging
    add_action( 'wp_ajax_nopriv_miptheme_ajax_blocks', 'MipTheme_Ajax::mipthemeAjaxBlock' );
    add_action( 'wp_ajax_miptheme_ajax_blocks', 'MipTheme_Ajax::mipthemeAjaxBlock' );

    # Pre get posts for paging
    add_action( 'pre_get_posts', 'miptheme_pre_get_posts' );

    # Disable Emoji
    if ( isset($mp_weeklynews['_mp_disable_emoji_icons'])&&(bool)$mp_weeklynews['_mp_disable_emoji_icons'] ) {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
    }

    // facebook image meta tag - video only post fix
    if ( isset($mp_weeklynews['_mp_page_open_graph_image']) && (bool)$mp_weeklynews['_mp_page_open_graph_image'] ) {
        add_filter('language_attributes', 'miptheme_add_opengraph_doctype');
        add_action('wp_head', 'miptheme_insert_fb_in_head', 5 );
    }

}

# ---------------------------------------------------------

# Enqueue scripts and styles for the front end
require_once('inc/enqueue-scripts.php');

# ---------------------------------------------------------

// redux framework - custom actions
function miptheme_removeReduxDemoMode() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
    }
}

// remove redux menu under the tools
function miptheme_remove_redux_menu() {
    remove_submenu_page('tools.php','redux-about');
}


# ---------------------------------------------------------

# Pre get posts for paging
function miptheme_pre_get_posts( $query ) {

    // check category
    if ( is_category() && $query->is_main_query() ) {
        global $mp_weeklynews;

        $curr_cat_id    = 0;

        if ( get_query_var('cat') && ( get_query_var('cat') != '' )) {
            $curr_cat_id                = get_query_var('cat');
        } else {
            $catObj         = get_category_by_slug(get_query_var('category_name'));
            if ($catObj) $curr_cat_id    = $catObj->term_id;
        }

        $curr_parent_id             = $curr_cat_id; // default: set to this cat
        $curr_cat_obj               = get_category($curr_cat_id);

        // check for root category
        if ( ($curr_cat_id != 0) && ($curr_cat_obj->category_parent != 0) ) {
            $cat_temp_id  = $curr_cat_id;
            $cat_temp_obj = $curr_cat_obj;
            while ($cat_temp_id) {
                $cat            = get_category($cat_temp_id); // get the object for the catid
                $cat_temp_id    = $cat->category_parent; // assign parent ID (if exists) to $cat_temp_id
                if ( isset($mp_weeklynews['_mp_cat_'. $cat_temp_id .'_set_for_children']) && (bool)$mp_weeklynews['_mp_cat_'. $cat_temp_id .'_set_for_children'] ) {
                    $curr_parent_id = $cat_temp_id;
                }
            }
        }

        $page_show_posts_num        = ( isset($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number']) && ($mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number'] > 0) )                           ? $mp_weeklynews['_mp_cat_'. $curr_parent_id .'_posts_number']             : (isset($mp_weeklynews['_mp_cat_posts_number']) ? $mp_weeklynews['_mp_cat_posts_number'] : '');
        if ( isset($page_show_posts_num) && ($page_show_posts_num > 0) ) {
            // Modify posts per page
            $query->set( 'posts_per_page', $page_show_posts_num );
        }

    }

    // check home
    if ( is_home() && $query->is_main_query() ) {
        global $mp_weeklynews;
        $page_show_posts_num            = $mp_weeklynews['_mp_homepage_posts_number'];

        if ( isset($page_show_posts_num) && ($page_show_posts_num > 0) ) {
            // Modify posts per page
            $query->set( 'posts_per_page', $page_show_posts_num );
        }

    }

    // check tag
    if ( is_tag() && $query->is_main_query() ) {
        global $mp_weeklynews;
        $page_show_posts_num            = $mp_weeklynews['_mp_tagpage_posts_number'];

        if ( isset($page_show_posts_num) && ($page_show_posts_num > 0) ) {
            // Modify posts per page
            $query->set( 'posts_per_page', $page_show_posts_num );
        }
    }

    // check author
    if ( is_author() && $query->is_main_query() ) {
        global $mp_weeklynews;
        $page_show_posts_num            = $mp_weeklynews['_mp_authorpage_posts_number'];

        if ( isset($page_show_posts_num) && ($page_show_posts_num > 0) ) {
            // Modify posts per page
            $query->set( 'posts_per_page', $page_show_posts_num );
        }
    }


}



# ---------------------------------------------------------

# BFI Thumb
//require_once('BFI_Thumb.php');
require_once('inc/external/otf_regen_thumbs.php');

# ---------------------------------------------------------

# Theme Importer
require_once('inc/importer/extend-importer.php');

# ---------------------------------------------------------

# Extending user profile
require_once('inc/extend-user-profile.php');

# ---------------------------------------------------------

# Extending categories with colorpicker
require_once('inc/extend-category.php');

# ---------------------------------------------------------

# Extending menus with walker class
require_once('inc/extend-menus.php');

# ---------------------------------------------------------

# Extending comments with walker class
require_once('inc/extend-comments.php');

# ---------------------------------------------------------

# Load Global Functions - Utils - Widgets
require_once('inc/global-functions.php');
require_once('inc/class-global.php');
require_once('inc/class-util.php');
require_once('inc/class-posts-views.php');
require_once('inc/class-widgets.php');
require_once('inc/class-article.php');
require_once('inc/class-ad.php');
require_once('inc/class-video.php');
require_once('inc/class-shortcodes.php');
require_once('inc/class-image.php');
require_once('inc/breadcrumbs/breadcrumbs-plus.php');
require_once('inc/class-ajax.php');
require_once('inc/class-unique-posts.php');
require_once('inc/class-thumbnailer.php');

# ---------------------------------------------------------

# Ads System
require_once('inc/ads/ads-register.php');

# ---------------------------------------------------------

# Extend Visual Composer
require_once('inc/extend-visual-composer.php');

# ---------------------------------------------------------

# Load Plugin Activation
require_once('inc/tgm-required-plugin-activation-load.php');

# ---------------------------------------------------------

function pre_dump($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}


function wpb_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
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
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);



// add a link to the WP Toolbar
function custom_toolbar_link($wp_admin_bar) {
    $args = array(
        'id' => 'manual-guide',
        'title' => 'Manual Guide',
        'href' => '/doc/Di_WordPress-Guide.pdf',
        'meta' => array(
            'class' => 'manual-guide',
            'title' => 'Manual Guide'
        )
    );
    $wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'custom_toolbar_link', 9999);



//------------------------------  DEBUG TEMPLATE --------------------------------------------

/**
 * HieuLC
 * Tool to know what type of page. Extract from template-loader.php
 * Enter description here ...
 */
function debug_current_page(){

    if     ( is_404()  				) 	 	$rs  = '404' ;
    elseif ( is_search()        	)  	$rs  = 'is_search' ;
    elseif ( is_front_page()    	) 	   	$rs  = 'is_front_page';
    elseif ( is_home()            	)  	$rs  = 'is_home' ;
    elseif ( is_post_type_archive() )  	$rs  = 'is_post_type_archive';
    elseif ( is_tax()        		)    	$rs  = 'is_tax' ;
    elseif ( is_attachment()      	)   	$rs  = 'is_attachment';

    elseif ( is_single()         	)   	$rs  = 'is_single' ;
    elseif ( is_page()          	)    	$rs  = 'is_page' ;
    elseif ( is_category()        	)  	$rs  = 'is_category';
    elseif ( is_tag()               )  	$rs  = 'is_tag';
    elseif ( is_author()            )   	$rs  = 'is_author';
    elseif ( is_date()              )   	$rs  = 'is_date'   ;
    elseif ( is_archive()         	)   	$rs  = 'is_archive'      ;
    elseif ( is_comments_popup()  	)   	$rs  = 'is_comments_popup';
    elseif ( is_paged()            	)  	$rs  = 'is_paged'        ;
    echo "current page: ".  $rs;
}

/**
 * DEBUG using template for current Page Or POST
 */
// Grabbing current page template
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}
function get_current_template( $echo = false ) {
    if( !isset( $GLOBALS['current_theme_template'] ) ) return false;
    if( $echo ) echo $GLOBALS['current_theme_template']; else  return $GLOBALS['current_theme_template'];
}



//only published post to select in relationship
add_filter('acf/fields/relationship/query/name=articles_on_home_page', 'relationship_options_filter', 10, 3);
function relationship_options_filter($options, $field, $the_post) {
    $options['post_status'] = array('publish');
    return $options;
}




//------------------------------ END DEBUG TEMPLATE --------------------------------------------


//Auto increase post meta filled "articles_on_home_page"

//Add 'display homepage' option for post
add_action( 'add_meta_boxes', 'cd_meta_box_add' );
add_action( 'save_post', 'cd_meta_box_save' );

function cd_meta_box_cb()
{
    global $post;

    $frontpage_id = get_option('page_on_front');
    $posts_homepage = get_field("articles_on_home_page", $frontpage_id);

    $check = 0;
    foreach($posts_homepage as $p){
        if($p->ID == $post->ID){
            $check = 1;
            break;
        }
    }
//    $values = get_post_custom( $post->ID );
//    $temp = $values['display_on_homepage'];
//    $check = isset( $temp ) ?  $temp[0]  : '';
    // We'll use this nonce field later on when saving.
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <input type="radio" name="display_on_homepage" class="post-format" id="post-format-0" value="1" <?php if($check) echo 'checked="checked"' ?> >
    <label for="post-format-0" class="post-format-standard">Yes</label>
    <input type="radio" name="display_on_homepage" class="post-format" id="post-format-1" value="0" <?php if(!$check) echo 'checked="checked"' ?>>
    <label for="post-format-1" class="post-format-standard">No</label>

<?php
}
function cd_meta_box_add()
{
    add_meta_box( 'my-meta-box-id', 'Display on homepage', 'cd_meta_box_cb', 'post', 'normal', 'high' );
}

function cd_meta_box_save( $post_id )
{
    update_post_meta( $post_id, 'display_on_homepage', esc_attr( $_POST['display_on_homepage'] ) );
    // get page front ID
    $frontpage_id = get_option('page_on_front');
    $posts_homepage = get_field("articles_on_home_page", $frontpage_id);

    //update field
    $post = get_post($post_id);
    if( isset( $_POST['display_on_homepage']) && ($_POST['display_on_homepage']>0)) {

        //update field
        array_unshift($posts_homepage, $post);

        update_field("articles_on_home_page", $posts_homepage, $frontpage_id);

    } else {
        $list_post = array();
        foreach($posts_homepage as $p){
            if($p->ID == $post_id){

            } else {
                array_push($list_post, $p);
            }
        }
        update_field("articles_on_home_page", $list_post, $frontpage_id);
    }
}




//Add custom field into setting page / Admin

add_action('admin_init', 'api_settings_init');

function api_settings_init() {
    add_settings_section('api_setting_section','Setting API','','general');
    add_settings_field('api_setting', 'Run Api: GetArticles', 'api_callback_function', 'general', 'api_setting_section');
    register_setting('general','api_setting');
}


function api_callback_function() {
    $option = get_option('api_setting');
    $input =  '<input name="api_setting" type="radio" value="1" '.($option==1?'checked':'').'/> Enable
            <input name="api_setting" type="radio" value="0" '.($option==0?'checked':'').'/> Disable';
    echo $input;
}

//Fix bug don't display new post schedule on homepage
add_action( 'publish_future_post', 'update_list_articles_on_homepage' );

function update_list_articles_on_homepage( $post_id ) {
    $myvals= get_post_meta($post_id, 'display_on_homepage');
    if(!$myvals[0][0]) $_POST['display_on_homepage'] = 0;
    else $_POST['display_on_homepage'] = 1;
//    $_POST['display_on_homepage'] = 1;
//    update_post_meta( $post_id, 'display_on_homepage', esc_attr( $_POST['display_on_homepage'] ) );
    // get page front ID
    $frontpage_id = get_option('page_on_front');
    $posts_homepage = get_field("articles_on_home_page", $frontpage_id);

    //update field
    $post = get_post($post_id);
    if( isset( $_POST['display_on_homepage']) && ($_POST['display_on_homepage']>0)) {

        //update field
        array_unshift($posts_homepage, $post);

        update_field("articles_on_home_page", $posts_homepage, $frontpage_id);

    } else {
        $list_post = array();
        foreach($posts_homepage as $p){
            if($p->ID == $post_id){

            } else {
                array_push($list_post, $p);
            }
        }
        update_field("articles_on_home_page", $list_post, $frontpage_id);
    }
}


add_action('admin_footer', 'my_admin_footer_function');
function my_admin_footer_function()
{
    if ($_GET['db'] == 1) {
        echo '<p> This will be inserted at the bottom of admin page This will be inserted at the bottom of admin page This will be inserted at the bottom of admin page This will be inserted at the bottom of admin page This will be inserted at the bottom of admin page This will be inserted at the bottom of admin page</p>';
    }
}