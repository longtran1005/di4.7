<?php
//update_option( '_miptheme_importer', false );
function mip_demo_installer() { ?>
    <h2><?php _e('Import Demo Content', THEMENAME ); ?></h2>

    <?php
	if ( get_option( '_miptheme_importer' ) !== false ) {
    ?>

    <div class="updated" style="margin: 20px 20px 20px 0 !important;">
	<div style="margin: 10px 0 10px 0; padding: 15px; background: #FCF7D4;">
	    <strong>Warning!</strong>
	    <p>Importing Demo Content can be done only once. You already imported demo content!</p>
	</div>
    </div>

    <?php
	} else {
    ?>

    <div class="updated" style="margin: 20px 20px 20px 0 !important;">
	<div style="margin: 10px 0 10px 0; padding: 15px; background: #FCF7D4;">
	    <strong>Warning!</strong>
	    <p>Importing Demo Content will add posts and media files to your wordpress. It's not recommended to do this if you already have your own content. Please, back up your data before importing this demo content.</p>
	</div>
	<p>
	    <strong>This is the easiest way to setup your theme</strong> with dummy content so you can play with it and see how some things are done.
	    This demo will import few pages, posts, categories and one menu. Images will be downloaded from our server and they are for demo use only.
	</p>
	<p>
	    <strong>When you click on button "Import Demo Data", please be patient. It can take a couple of minutes for whole import.</strong>.
	</p>
    </div>

    <form method="post">
        <input type="hidden" name="checkinstaller" value="<?php echo wp_create_nonce('mip-demo-installer'); ?>" />
        <input type="hidden" name="action" value="mip-installer-data" />
        <input type="submit" name="import-demo" class="button action" value="<?php _e('Import Demo Content', THEMENAME ); ?>" />
    </form>

    <?php
	}
    ?>


<?php
    if ( isset($_REQUEST['action']) ) {
	if(  'mip-installer-data' == $_REQUEST['action'] && check_admin_referer('mip-demo-installer' , 'checkinstaller')){
	    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		require_once ABSPATH . 'wp-admin/includes/import.php';
		$importer_error = false;
		if ( !class_exists( 'WP_Importer' ) ) {
		    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		    if ( file_exists( $class_wp_importer ) ) {
			require_once($class_wp_importer);
		    }
		    else {
			$importer_error = true;
		    }
		}

		if ( !class_exists( 'WP_Import' ) ) {
		    $class_wp_import = get_template_directory() . '/inc/importer/wordpress-importer.php';
		    if ( file_exists( $class_wp_import ) )
			require_once($class_wp_import);
		    else
			$importerError = true;
		}

		if ($importer_error) {
		    die("There was an error while performing data import. Please contant us for more information.");
		} else {
		    if(!is_file( get_template_directory() . '/inc/importer/sample_data.xml')) {
			echo "The XML file containing the dummy content is not available or could not be read .. You might want to try to set the file permission to chmod 755.<br/>If this doesn't work, please use the wordpress importer and import the XML file (should be located in your download .zip: Sample Content folder) manually ";
		    }
		    else{
			$wp_import = new WP_Import();
			$wp_import->fetch_attachments = true;
			$wp_import->import( get_template_directory() . '/inc/importer/sample_data.xml');
		}
	    }

	    // Set default menus
	    $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
	    set_theme_mod( 'nav_menu_locations' , array('header-menu' => $main_menu->term_id, 'footer-menu' => $main_menu->term_id ) );

	    //Set homepage
	    $my_homepage 	= get_page_by_title( 'Homepage' );
	    update_option( 'page_on_front', $my_homepage->ID );
	    update_option( 'show_on_front', 'page' );
	    update_post_meta( $my_homepage->ID, '_mp_sidebar_source_single_middle', 'secondary-widget-area' );
	    update_post_meta( $my_homepage->ID, '_mp_sidebar_source_single', 'primary-widget-area' );

	    // Set default widgets
	    update_option('sidebars_widgets', '');

	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_ads_img_widget', array('ad_source' => get_template_directory_uri() . '/images/dummy/banner_300x250.png', 'ad_link' => 'http://themes.mipdesign.com/', 'ad_background' => false));
	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_timeline_widget', array('title' => 'Weekly Timeline', 'number' => 7));
	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_quote_widget', array('title' => 'Weekly Quote', 'quote_text' => 'I like the dreams of the future better than the history of the past.', 'quote_source' => 'Thomas Jefferson'));
	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_audio_posts_widget', array('title' => 'Top Singles', 'number' => 5));
	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_ads_img_widget', array('ad_source' => get_template_directory_uri() . '/images/dummy/banner_300x250.png', 'ad_link' => 'http://themes.mipdesign.com/', 'ad_background' => true));
	    miptheme_add_widget_to_sidebar( 'primary-widget-area' , 'mp_reviews_widget', array('title' => 'Latest Reviews', 'number' => 4, 'show_date' => true, 'show_category' => true ));

	    miptheme_add_widget_to_sidebar( 'secondary-widget-area' , 'mp_recent_posts_widget', array('title' => 'Must Read', 'number' => 4, 'show_date' => true, 'show_category' => true, 'show_mid_column' => true ));
	    miptheme_add_widget_to_sidebar( 'secondary-widget-area' , 'mp_ads_img_widget', array('ad_source' => get_template_directory_uri() . '/images/dummy/banner_160x600.png', 'ad_link' => 'http://themes.mipdesign.com/', 'ad_background' => false));
	    miptheme_add_widget_to_sidebar( 'secondary-widget-area' , 'mp_recent_posts_widget', array('title' => 'Don\'t forget', 'number' => 2, 'show_date' => true, 'show_category' => false, 'show_mid_column' => true ));
	    miptheme_add_widget_to_sidebar( 'secondary-widget-area' , 'mp_reviews_widget', array('title' => 'Weekly Gadget', 'number' => 1, 'show_date' => false, 'show_category' => false ));

	    // set importer success
	    update_option( '_miptheme_importer', 'true' );

	}
    }

} // end mip_demo_installer
?>
