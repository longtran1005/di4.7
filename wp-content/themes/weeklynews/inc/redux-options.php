<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_config')) {

    class Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

	    $this->initSettings();

        }

        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
            // Function to test the compiler hook and demo CSS output.
            add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
           // add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
	    $filename = dirname(__FILE__) . '/../assets/css/font-style' . '.css';
	    global $wp_filesystem;
	    if( empty( $wp_filesystem ) ) {
		require_once( ABSPATH .'/wp-admin/includes/file.php' );
		WP_Filesystem();
	    }

	    if( $wp_filesystem ) {
		$wp_filesystem->put_contents(
		    $filename,
		    $css,
		    FS_CHMOD_FILE // predefined mode settings for WP files
		);
	    }
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', THEMENAME),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', THEMENAME),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = "Testing filter hook!";

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            //if (class_exists('ReduxFrameworkPlugin')) {
            //    remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2);
            //}

            // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
            //remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
        }

        public function setSections() {

            /* Redux Url */
	    //$redux_url = ReduxFramework::$_url;
	    $redux_url = get_template_directory_uri() . '/inc/redux/ReduxCore';
        // ACTUAL DECLARATION OF SECTIONS

	    /* Advanced Settings */

			$this->sections[] = array(
                'title' => __('Theme Styling', THEMENAME),
                'icon' => 'el-icon-idea',
                'fields' => array(
		    array(
			'id' => '_mp_theme_layout',
			'type' => 'button_set',
			'title' => __('Theme Layout', THEMENAME),
			'subtitle' => __('Select theme layout', THEMENAME),
			'options' => array(
			    'theme-boxed' => 'Boxed Theme',
			    'theme-unboxed' => 'Unboxed Theme',
			),
			'default' => 'theme-boxed',
                    ),
			array(
			'id' => '_mp_theme_layout_sidebar_padding',
			'type' => 'button_set',
			'title' => __('Unboxed sidebar padding', THEMENAME),
			'subtitle' => __('Use padding if sidebar has background color', THEMENAME),
			'options' => array(
				'sidebar-no-padding' => 'No padding',
			    'sidebar-padding' => 'Standard padding',
			),
			'default' => 'sidebar-padding',
			'required'  => array('_mp_theme_layout', "=", 'theme-unboxed'),
                    ),
                    array(
			'id' => '_mp_theme_style',
			'type' => 'button_set',
			'title' => __('Theme Styling', THEMENAME),
			'subtitle' => __('Select theme styling', THEMENAME),
			'options' => array(
			    'theme-dark' => 'Dark Theme',
			    'theme-light' => 'Light Theme',
			),
			'default' => 'theme-dark',
                    ),
		    array(
			'id' => '_mp_theme_light_style',
			'type' => 'button_set',
			'title' => __('Light Theme Styling', THEMENAME),
			'subtitle' => __('Specify light theme styling', THEMENAME),
			'options' => array(
			    'light-both' => 'Header & Sidebar',
			    'light-header' => 'Header only',
			    'light-sidebar' => 'Sidebar only',
			),
			'default' => 'light-both',
			'required'  => array('_mp_theme_style', "=", 'theme-light'),
                    ),
                    array(
            			'id' => '_mp_theme_smooth_scrolling',
            			'type' => 'switch',
            			'title' => __('Enable Smooth Scrolling', THEMENAME),
                        'subtitle' => __('Works only on Chrome browser', THEMENAME),
            			'default' => 1,
        		    )

                ),

            );


            $this->sections[] = array(
                'title' => __('Homepage', THEMENAME),
                'icon' => 'el-icon-home',
                'fields' => array(
		    array(
			'id' => '_mp_homepage_info',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'desc' => __('Only if "Front page display" is set to "<a href="options-reading.php">Your latest posts</a>".', THEMENAME),
		    ),
            array(
    			'id' => '_mp_homepage_template',
    			'type' => 'image_select',
    			'title' => __('Posts layout', THEMENAME),
    			'subtitle' => __('Select layout for posts.', THEMENAME),
    			'options' => array(
    			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
    			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
    			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
    			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
    			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
    			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
    			    'loop-cat-7' => array('alt' => 'Category layout 7', 'img' => $redux_url.'/assets/img/cat-layout-7.png'),
    			    'loop-cat-8' => array('alt' => 'Category layout 8', 'img' => $redux_url.'/assets/img/cat-layout-8.png'),
    			),
    			'default' => 'loop-cat-7'
		    ),
            array(
    			'id'=>'_mp_homepage_template_chars',
    			'type' => 'slider',
    			'title' => __('Limit text characters', THEMENAME),
    			"default" => "0",
    			"min" 	=> "0",
    			"step"	=> "1",
    			"max" 	=> "1000",
    			'subtitle' => __('0 for using default wordpress settings', THEMENAME),
                'required'  => array('_mp_homepage_template', "=", array('loop-cat-1', 'loop-cat-2', 'loop-cat-7', 'loop-cat-8')),
		    ),
		    array(
			'id' => '_mp_homepage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
			    'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_homepage_sidebar_source_middle',
			'title' => __( 'Choose default middle/left sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle or left column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page (max 160px content).',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_homepage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_homepage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page (max 300px content).',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_homepage_sidebar_template', "!=", 'hide-sidebar'),
		    ),
		    array(
			'id' => '_mp_homepage_breakingnews_enable',
			'type' => 'switch',
			'title' => __('Display News Scroller', THEMENAME),
			'default' => 0,
		    ),
		    array(
			'id'=>'_mp_homepage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),
		    array(
			'id' => '_mp_homepage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),
		    array(
			'id' => '_mp_homepage_top_slider_info',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'desc' => __('<strong>Top Slider</strong><br>Only if "Front page display" is set to "Your latest posts".', THEMENAME),
		    ),
		    /*array(
			'id' => '_mp_homepage_top_slider_enable',
			'type' => 'switch',
			'title' => __('Enable Top Slider', THEMENAME),
			'default' => 0
        ),*/

            array(
                'id' => '_mp_homepage_top_slider_enable',
                'type' => 'button_set',
                'title' => __('Enable Top Slider', THEMENAME),
                'options' => array(
                    0 => 'Disable',
                    1 => 'Enable',
                    2 => 'Shortcode'
                 ),
                'default' => 0
            ),
            array(
                'id' => '_mp_homepage_top_slider_shortcode',
                'type' => 'text',
                'title' => __('Top Slider Shortcode', THEMENAME),
                'required'  => array('_mp_homepage_top_slider_enable', "equals", 2)
            ),
			array(
				'id' => '_mp_homepage_top_slider_unique_articles',
				'type' => 'switch',
				'title' => __('Enable unique posts', THEMENAME),
				'default' => 0,
			),
		    array(
			'id' => '_mp_homepage_top_slider_mobile',
			'type' => 'switch',
			'title' => __('Hide slider on mobile devices', THEMENAME),
			'default' => 0,
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_display',
			'type'      => 'radio',
			'title'     => __('Slider display', THEMENAME),
			'subtitle'  => __('Choose how to display your posts', THEMENAME),
			'options'   => array(
			    'page-slider-1' => 'Display by category (each slide - one category)',
			    'page-slider-2' => 'Display by latest posts',
			    //'page-slider-3' => 'Owl Slider',
			),
			'default'   => 'page-slider-2',
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_layout',
			'type'      => 'image_select',
			'title'     => __('Slider layout', THEMENAME),
			'subtitle'  => __('Choose layout for your slider', THEMENAME),
			'options' => array(
			    'slider-layout-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/slider-layout-1.png'),
			    'slider-layout-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/slider-layout-2.png'),
			    'slider-layout-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/slider-layout-3.png'),
			    'slider-layout-4' => array('alt' => 'Layout 4', 'img' => $redux_url.'/assets/img/slider-layout-4.png'),
			    'slider-layout-5' => array('alt' => 'Layout 5', 'img' => $redux_url.'/assets/img/slider-layout-5.png'),
				'slider-layout-6' => array('alt' => 'Layout 6', 'img' => $redux_url.'/assets/img/slider-layout-6.png'),
			),
			'default'   => 'slider-layout-1',
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_padding',
			'type'      => 'spacing',
			'title'     => __('Slider padding (px)', THEMENAME),
			'mode'      => 'padding',
			'units'     => 'px',
			'left'      => false,
			'right'     => false,

			'output'    => array('#page-slider'),
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_background',
			'type'      => 'background',
			'title'     => __('Slider background', THEMENAME),
			'preview'      => false,
			'output'    => array('#page-slider'),
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_autostart',
			'type'      => 'switch',
			'title'     => __('Auto Start', THEMENAME),
			'subtitle'  => __('Determines whether the carousel should scroll automatically or not.', THEMENAME),
			'default'   => 0,
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'=>'_mp_homepage_top_slider_autostart_delay',
			'type' => 'slider',
			'title' => __('Auto Start Delay', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "500",
			"max" 	=> "10000",
			'desc' => __('delay in milliseconds before the carousel starts scrolling the first time', THEMENAME),
			'required'  => array (
			    array('_mp_homepage_top_slider_enable', "equals", 1),
			    array('_mp_homepage_top_slider_autostart', "equals", 1)
			)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_summary',
			'type'      => 'switch',
			'title'     => __('Show text summary', THEMENAME),
			'subtitle'  => __('Do you want to display short summary bellow title?', THEMENAME),
			'default'   => 0,
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_sort',
			'type'      => 'select',
			'title'     => __('Sort order', THEMENAME),
			'subtitle'  => __('Choose how to sort your posts', THEMENAME),
			'options'   => array(
			    'date' => 'Latest',
			    'rand' => 'Random posts',
			    'name' => 'By name',
			    'type' => 'By Post Type',
			    'modified' => 'Last Modified',
			    'comment_count' => 'Most Commented',
			),
			'default'   => 'date',
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id'        => '_mp_homepage_top_slider_slides',
			'type'      => 'button_set',
			'title'     => __('Display slides', THEMENAME),
			'subtitle'  => __('Choose how many slides to display', THEMENAME),

			//Must provide key => value pairs for radio options
			'options'   => array(
			    '4' => '1',
			    '8' => '2',
			    '12' => '3',
			    '16' => '4',
			    '20' => '5'
			),
			'default' => '12',
			'required'  => array(
			    array('_mp_homepage_top_slider_enable', "equals", 1),
			    array('_mp_homepage_top_slider_display', "=", 'page-slider-2'),
			),
		    ),
		    array(
			'id' => '_mp_homepage_top_slider_categories',
			'type' => 'select',
			'data'      => 'categories',
			'multi'     => true,
			'sortable'   => true,
			'title' => __('Show categories', THEMENAME),
			'subtitle'  => __('If none is selected, all categories are included by default', THEMENAME),
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_homepage_top_slider_tags',
			'type' => 'select',
			'data'      => 'tags',
			'multi'     => true,
			'sortable'   => true,
			'title' => __('Filter by tag slug', THEMENAME),
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_homepage_top_slider_category_display',
			'type' => 'button_set',
			'title' => __('Display Category labels as', THEMENAME),
			'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'root' => 'Root Categories',
			    'sub' => 'Sub Categories'
			),
			'default' => 'root',
			'required'  => array('_mp_homepage_top_slider_enable', "equals", 1)
		    ),


                )
            );


	    $this->sections[] = array(
                'title'     => __('Header Settings', THEMENAME),
                'icon'      => 'el-icon-arrow-up',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

					array(
						'id' => '_mp_enable_header_widgets',
						'type' => 'switch',
						'title' => __('Enable widgetized area', THEMENAME),
						'on' => 'Enable',
						'off' => 'Disable',
						'default' => false,
					),
					array(
						'id' => '_mp_header_widget_layout',
						'type' => 'image_select',
						'title' => __('Area layout', THEMENAME),
						'subtitle' => __('Select header layout.', THEMENAME),
						'options' => array(
							'header-layout-widget-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/header-layout-widget-1.png'),
							'header-layout-widget-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/header-layout-widget-2.png'),
							'header-layout-widget-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/header-layout-widget-3.png'),
							),
						'required'  => array('_mp_enable_header_widgets', "equals", '1'),
					),

					array(
						'id' => '_mp_header_widget_column_1_source',
						'title' => __( 'Select sidebar for first column', THEMENAME ),
						'desc' => 'Please select the sidebar you would like to display on first column.',
						'type' => 'select',
						'data' => 'sidebars',
						'default' => 'None',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-1', 'header-layout-widget-2', 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),
					array(
						'id' => '_mp_header_widget_column_1_align',
						'type' => 'select',
						'title' => __('Select alignment for first column', THEMENAME),
						'options' => array(
							'text-left' => 'Left',
							'text-center' => 'Center',
							'text-right' => 'Right',
						),
						'default' => 'text-left',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-1', 'header-layout-widget-2', 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),

					array(
						'id' => '_mp_header_widget_column_2_source',
						'title' => __( 'Select sidebar for second column', THEMENAME ),
						'desc' => 'Please select the sidebar you would like to display on second column.',
						'type' => 'select',
						'data' => 'sidebars',
						'default' => 'None',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-2', 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),
					array(
						'id' => '_mp_header_widget_column_2_align',
						'type' => 'select',
						'title' => __('Select alignment for second column', THEMENAME),
						'options' => array(
							'text-left' => 'Left',
							'text-center' => 'Center',
							'text-right' => 'Right',
						),
						'default' => 'text-left',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-2', 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),

					array(
						'id' => '_mp_header_widget_column_3_source',
						'title' => __( 'Select sidebar for third column', THEMENAME ),
						'desc' => 'Please select the sidebar you would like to display on third column.',
						'type' => 'select',
						'data' => 'sidebars',
						'default' => 'None',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),
					array(
						'id' => '_mp_header_widget_column_3_align',
						'type' => 'select',
						'title' => __('Select alignment for third column', THEMENAME),
						'options' => array(
							'text-left' => 'Left',
							'text-center' => 'Center',
							'text-right' => 'Right',
						),
						'default' => 'text-left',
						'required'  => array(
							array('_mp_header_widget_layout', "=", array( 'header-layout-widget-3' )),
							array('_mp_enable_header_widgets', "equals", '1'),
						),
					),

		    array(
			'id' => '_mp_header_layout',
			'type' => 'image_select',
			'title' => __('Header layout', THEMENAME),
			'subtitle' => __('Select header layout.', THEMENAME),
			'options' => array(
			    'header-layout-1' => array('alt' => 'Header Layout 1', 'img' => $redux_url.'/assets/img/header-layout-1.png'),
			    'header-layout-2' => array('alt' => 'Header Layout 2', 'img' => $redux_url.'/assets/img/header-layout-2.png'),
			    'header-layout-6' => array('alt' => 'Header Layout 6', 'img' => $redux_url.'/assets/img/header-layout-6.png'),
			    'header-layout-3' => array('alt' => 'Header Layout 3', 'img' => $redux_url.'/assets/img/header-layout-3.png'),
			    'header-layout-4' => array('alt' => 'Header Layout 4', 'img' => $redux_url.'/assets/img/header-layout-4.png'),
			    'header-layout-5' => array('alt' => 'Header Layout 5', 'img' => $redux_url.'/assets/img/header-layout-5.png'),
			    'header-layout-7' => array('alt' => 'Header Layout 7', 'img' => $redux_url.'/assets/img/header-layout-7.png'),

			),
			'default' => 'header-layout-1',
			'required'  => array('_mp_enable_header_widgets', "equals", false),
                    ),
		    array(
                        'id' => '_mp_header_type',
                        'type' => 'button_set',
                        'title' => __('Header type', THEMENAME),
			'subtitle' => __('Type of header to display', THEMENAME),
			'options'   => array(
			    'full' => 'Full width background',
			    'streched' => 'Full width header',
			    'boxed' => 'Boxed'
			),
                        'default' => 'full',
                    ),
		    array(
                        'id' => '_mp_header_logo_desktop',
                        'type' => 'media',
                        'title' => __('Desktop logo', THEMENAME),
			'subtitle' => __('Logo for desktop version', THEMENAME),
			'default'  => array(
			    'url'=> get_template_directory_uri() . '/images/logo-white.png',
			    'width'=> 250,
			    'height'=> 47,
			),
			'required'  => array('_mp_enable_header_widgets', "equals", false),
                    ),
		    array(
                        'id' => '_mp_header_logo_desktop_retine',
                        'type' => 'media',
                        'title' => __('Desktop Retina logo', THEMENAME),
			'subtitle' => __('Retina Logo for desktop version', THEMENAME),
			'required'  => array('_mp_enable_header_widgets', "equals", false),
                    ),
		    array(
                        'id' => '_mp_header_logo_mobile',
                        'type' => 'media',
                        'title' => __('Mobile logo', THEMENAME),
			'subtitle' => __('Logo for mobile version', THEMENAME),
			'default'  => array(
			    'url'=> get_template_directory_uri() . '/images/logo-white-mobile.png',
			    'width'=> 180,
			    'height'=> 31,
			),
			'required'  => array('_mp_enable_header_widgets', "equals", false),
                    ),
		    array(
                        'id' => '_mp_header_logo_mobile_retina',
                        'type' => 'media',
                        'title' => __('Mobile Retina logo', THEMENAME),
			'subtitle' => __('Retina Logo for mobile version', THEMENAME),
			'required'  => array('_mp_enable_header_widgets', "equals", false),
                    ),
		    array(
                        'id' => '_mp_header_weather_location',
                        'type' => 'text',
                        'title' => __('Weather location', THEMENAME),
			'subtitle' => __('Enter city and contry', THEMENAME),
                        'desc' => __('e.g. Paris, France<br>If you want to get user auto location just leave the field blank. The theme will then use a public HTTP API for developers (<a href="http://freegeoip.net">freegeoip.net</a>) to search the geolocation of IP addresses. You are allowed up to 10,000 queries per hour, and the service is free and open source.', THEMENAME),
			'default'  => '',
			'required'  => array('_mp_header_layout', "=", array('header-layout-1', 'header-layout-6', 'header-layout-7') ),
                    ),
		    array(
                        'id' => '_mp_header_weather_temperature',
                        'type' => 'button_set',
                        'title' => __('Display temperature in', THEMENAME),
			'options'   => array(
			    'c' => 'Celsius',
			    'f' => 'Fahrenheit'
			),
                        'default' => 'c',
			'required'  => array('_mp_header_layout', "=", array('header-layout-1', 'header-layout-6', 'header-layout-7') ),
                    ),
		    array(
                        'id' => '_mp_header_weather_show_date',
                        'type' => 'switch',
                        'title' => __('Display date', THEMENAME),
                        'default' => '1',
			'required'  => array('_mp_header_layout', "=", array('header-layout-1', 'header-layout-6', 'header-layout-7') ),
                    ),
		    array(
                        'id' => '_mp_header_weather_show_desc',
                        'type' => 'switch',
                        'title' => __('Display weather description', THEMENAME),
                        'default' => '1',
			'required'  => array('_mp_header_layout', "=", array('header-layout-1', 'header-layout-6', 'header-layout-7') ),
                    ),


			array(
				'id' => '_mp_header_weather_lang',
				'type' => 'select',
				'title' => __('Language for description', THEMENAME),
				'options'   => array(
					'bg' => 'Bulgarian',
					'zh_tw' => 'Chinese Traditional',
					'zh_cn' => 'Chinese Simplified',
					'nl' => 'Dutch',
					'en' => 'English',
					'fi' => 'Finnish',
					'fr' => 'French',
					'de' => 'German',
					'it' => 'Italian',
					'pl' => 'Polish',
					'pt' => 'Portuguese',
					'ro' => 'Romanian',
					'ru' => 'Russian',
					'sp' => 'Spanish',
					'se' => 'Swedish',
					'tr' => 'Turkish',
					'ua' => 'Ukrainian',
				),
				'default' => 'en',
				'required'  => array(
					array('_mp_header_layout', "=", array('header-layout-1', 'header-layout-6', 'header-layout-7') ),
					array('_mp_header_weather_show_desc', "=", 1 ),
				)
            ),

		    array(
			'id' 	=> '_mp_header_banner',
			'type' 	=> 'select',
			'title' => __('Banner 728x90', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
			'required'  => array('_mp_header_layout', "=", 'header-layout-3'),
		    ),

		    array(
			'id' 	=> '_mp_header_banner_left',
			'type' 	=> 'select',
			'title' => __('Banner left', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
			'required'  => array('_mp_header_layout', "=", array('header-layout-5', 'header-layout-7')),
		    ),

		    array(
			'id' 	=> '_mp_header_banner_right',
			'type' 	=> 'select',
			'title' => __('Banner right', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
			'required'  => array('_mp_header_layout', "=", array('header-layout-5', 'header-layout-7')),
		    ),


                )
            );


	    $this->sections[] = array(
                'title'     => __('Navigation', THEMENAME),
                'icon'      => 'el-icon-map-marker',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id' => '_mp_header_sticky_menu',
                        'type' => 'switch',
                        'title' => __('Sticky menu', THEMENAME),
                        'subtitle' => __('Use navigation as sticky menu', THEMENAME),
                        'on' => 'Enable',
                        'off' => 'Disable',
                            'default' => '0'
                    ),
                    array(
                        'id' => '_mp_header_sticky_menu_mobile',
                        'type' => 'switch',
                        'title' => __('Sticky mobile menu', THEMENAME),
                        'subtitle' => __('Use mobile header as sticky menu', THEMENAME),
                        'on' => 'Enable',
                        'off' => 'Disable',
                        'default' => '0'
                    ),
                    array(
                        'id' => '_mp_header_sticky_menu_logo',
                        'type' => 'media',
                        'title' => __('Sticky menu logo', THEMENAME),
                        'subtitle' => __('Logo for sticky menu', THEMENAME),
                        'required'  => array('_mp_header_sticky_menu', "equals", '1'),
                    ),
                    array(
                        'id' => '_mp_header_sticky_menu_show_first',
                        'type' => 'button_set',
                        'title' => __('Hide first item on sticky menu', THEMENAME),
                        'subtitle' => __('Hide first navigation item', THEMENAME),
                        'options'   => array(
                            '1' => 'Hide',
                            '0' => 'Show'
                        ),
                        'on' => 'Enable',
                        'off' => 'Disable',
                        'default' => '1',
                        'required'  => array('_mp_header_sticky_menu', "equals", '1'),
                    ),
                    array(
                        'id' => '_mp_header_show_options',
                        'type' => 'switch',
                        'title' => __('Display login/register', THEMENAME),
                        'subtitle' => __('Display login/register links in main navigation', THEMENAME),
                        'desc' => __('Do not display this if you have long menu', THEMENAME),
                        'default' => '0',
                        'on' => 'Enable',
                        'off' => 'Disable',
                    ),

                    array(
                        'id' => '_mp_header_show_search',
                        'type' => 'switch',
                        'title' => __('Display search button', THEMENAME),
                        'subtitle' => __('Display search button in main navigation', THEMENAME),
                        'desc' => __('Do not display this if you have long menu', THEMENAME),
                        'default' => '0',
                        'on' => 'Enable',
                        'off' => 'Disable',
                    ),
                    array(
                        'id' => '_mp_header_show_subnav',
                        'type' => 'switch',
                        'title' => __('Sub navigation', THEMENAME),
                        'subtitle' => __('Show sub menu below main navigation', THEMENAME),
                        'desc' => __('This should be used only when you have main category filled only with categories and you cannot have Quicklinks menu at the same time', THEMENAME),
                        'default' => '0',
                        'on' => 'Enable',
                        'off' => 'Disable',
                        //'required'  => array('_mp_header_show_quicklinks', "equals", '0'),
                    ),
                    array(
                        'id' => '_mp_header_show_quicklinks',
                        'type' => 'switch',
                        'title' => __('Quicklinks menu', THEMENAME),
                        'subtitle' => __('Show quicklinks menu below main navigation', THEMENAME),
                        'desc' => __('You cannot have Sub navigation enabled if you enable this option', THEMENAME),
                        'default' => '0',
                        'on' => 'Enable',
                        'off' => 'Disable',
                        'required'  => array('_mp_header_show_subnav', "equals", '0'),
                    ),
                    array(
                        'id' => '_mp_header_show_quicklinks_menu',
                        'type' => 'select',
                        'title' => __('Select Quicklinks global menu', THEMENAME),
                        'subtitle' => __('Select what menu to display as quicklinks', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'data' => 'menus',
                        'required'  => array('_mp_header_show_quicklinks', "equals", '1'),
                    ),
                    array(
                        'id' => '_mp_header_show_quicklinks_type',
                        'type' => 'button_set',
                        'title' => __('Quicklinks menu type', THEMENAME),
                        'subtitle' => __('Type of menu to display', THEMENAME),
                        'options'   => array(
                            'full-width' => 'Full screen',
                            'boxed' => 'Boxed'
                        ),
                        'default' => 'boxed',
                        'required'  => array('_mp_header_show_quicklinks', "equals", '1'),
                    ),
					array(
                        'id'        => '_mp_header_mobilemenu_info',
                        'type'      => 'info',
                        'title'     => __('Mobile Menu Settings', THEMENAME),
                        'desc'  => __('Set your top menu before header branding', THEMENAME),
                        'style'    => 'success',
                        'notice'   => true,
                    ),
					array(
                        'id'       => '_mp_header_mobilemenu_show_options',
                        'type'     => 'checkbox',
                        'title' => __('Display login/register', THEMENAME),
                        'subtitle' => __('Display login/register links in top navigation', THEMENAME),
                        'options'  => array(
                            'login' => 'Display login',
                            'register' => 'Display register',
                        ),
                        'default' => array(
                            'login' => '0',
                            'register' => '0',
                        ),
                    ),

                    array(
                        'id'        => '_mp_header_topmenu_info',
                        'type'      => 'info',
                        'title'     => __('Top Menu Settings', THEMENAME),
                        'desc'  => __('Set your top menu before header branding', THEMENAME),
                        'style'    => 'success',
                        'notice'   => true,
                    ),
                    array(
                        'id' => '_mp_header_topmenu_enable',
                        'type' => 'switch',
                        'title' => __('Enable Top Menu', THEMENAME),
                        'subtitle' => __('Enable top navigation', THEMENAME),
                        'default' => '0',
                        'on' => 'Enable',
                        'off' => 'Disable',
                    ),
                    array(
                        'id'       => '_mp_header_topmenu_show_options',
                        'type'     => 'checkbox',
                        'title' => __('Display login/register', THEMENAME),
                        'subtitle' => __('Display login/register links in top navigation', THEMENAME),
                        'options'  => array(
                            'login' => 'Display login',
                            'register' => 'Display register',
                        ),
                        'default' => array(
                            'login' => '0',
                            'register' => '0',
                        ),
                        'required'  => array('_mp_header_topmenu_enable', "=", '1'),
                    ),
                    array(
                        'id' => '_mp_header_topmenu_show_date',
                        'type' => 'button_set',
                        'title' => __('Display date', THEMENAME),
                        'subtitle' => __('Do you want to display date in top menu', THEMENAME),
                        'options'   => array(
                            'none' => 'No date',
                            'first' => 'On left, before everything',
                            'last' => 'On right, after everything',
                        ),
                        'default' => 'none',
                        'required'  => array('_mp_header_topmenu_enable', "=", '1'),
                    ),

                    array(
                        'id' => '_mp_header_top_show_social_networking',
                        'type' => 'switch',
                        'title' => __('Display social icons', THEMENAME),
                        'subtitle' => __('Display social icons in top navigation (if enabled)', THEMENAME),
                        'desc' => __('This will show links you selected under "Social Networking"', THEMENAME),
                        'default' => '0',
                        'required'  => array('_mp_header_topmenu_enable', "=", '1'),
                    ),

                )
            );


	    $this->sections[] = array(
                'title'     => __('Social Networking', THEMENAME),
                'icon'      => 'el-icon-group',
                'subsection' => true,
                'fields'    => array(

		    array(
                        'id' => '_mp_header_show_social_networking',
                        'type' => 'switch',
                        'title' => __('Display "+follow" menu item', THEMENAME),
			'subtitle' => __('Display follow link with dropdown in main navigation', THEMENAME),
			'desc' => __('This will show links you selected under "Social Networking"', THEMENAME),
                        'default' => '0'
                    ),
		    array(
                        'id'        => '_mp_social_facebook',
                        'type'      => 'text',
                        'title'     => __('Facebook URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_twitter',
                        'type'      => 'text',
                        'title'     => __('Twitter URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_google',
                        'type'      => 'text',
                        'title'     => __('Google+ URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_linkedin',
                        'type'      => 'text',
                        'title'     => __('LinkedIn URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_pinterest',
                        'type'      => 'text',
                        'title'     => __('Pinterest URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_flickr',
                        'type'      => 'text',
                        'title'     => __('Flickr URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_youtube',
                        'type'      => 'text',
                        'title'     => __('Youtube URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_vimeo',
                        'type'      => 'text',
                        'title'     => __('Vimeo URL', THEMENAME),
                    ),
			array(
                        'id'        => '_mp_social_instagram',
                        'type'      => 'text',
                        'title'     => __('Instagram URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_dribbble',
                        'type'      => 'text',
                        'title'     => __('Dribbble URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_behance',
                        'type'      => 'text',
                        'title'     => __('Behance URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_tumblr',
                        'type'      => 'text',
                        'title'     => __('Tumblr URL', THEMENAME),
                    ),
            array(
                        'id'        => '_mp_social_reddit',
                        'type'      => 'text',
                        'title'     => __('Reddit URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_vkontakte',
                        'type'      => 'text',
                        'title'     => __('VKontakte URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_weibo',
                        'type'      => 'text',
                        'title'     => __('Weibo URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_wechat',
                        'type'      => 'text',
                        'title'     => __('WeChat URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_qq',
                        'type'      => 'text',
                        'title'     => __('QQ URL', THEMENAME),
                    ),
		    array(
                        'id'        => '_mp_social_rss',
                        'type'      => 'text',
                        'title'     => __('RSS URL', THEMENAME),
                    ),
		    /*array(
                        'id'        => '_mp_social_500px',
                        'type'      => 'text',
                        'title'     => __('500px URL', THEMENAME),
                    ),*/

                )
            );



	    /* Categories */
	    $cats[] = array(
		'id'   => 'info_normal',
		'type' => 'info',
		'style' => 'success',
		//'notice' => true,
		'icon'      => 'el-icon-info-sign',
		'title' => 'Default settings',
		'desc' => __('This are default setting for all categories. If you want to override this, please select custom settings for desired category below.', THEMENAME)
	    );

	    $cats[] = array(
    		'id' => '_mp_cat_template_default',
    		'type' => 'image_select',
    		'title' => __('Category layout', THEMENAME),
    		'subtitle' => __('Select layout for all categories.', THEMENAME),
    		'options' => array(
    		    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
    		    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
    		    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
    		    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
    		    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
    		    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
    		    'loop-cat-7' => array('alt' => 'Category layout 7', 'img' => $redux_url.'/assets/img/cat-layout-7.png'),
    		    'loop-cat-8' => array('alt' => 'Category layout 8', 'img' => $redux_url.'/assets/img/cat-layout-8.png'),
    		),
    		'default' => 'loop-cat-1'
    	    );

        $cats[] = array(
            'id'=>'_mp_cat_template_default_chars',
            'type' => 'slider',
            'title' => __('Limit text characters', THEMENAME),
            "default" => "0",
            "min" 	=> "0",
            "step"	=> "1",
            "max" 	=> "1000",
            'subtitle' => __('0 for using default wordpress settings', THEMENAME),
            'required'  => array('_mp_cat_template_default', "=", array('loop-cat-1', 'loop-cat-2', 'loop-cat-7', 'loop-cat-8')),
        );

	    $cats[] = array(
		'id' => '_mp_cat_show_title',
		'type' => 'button_set',
		'title' => __('Show category title on top', THEMENAME),
		'options'   => array(
		    '0' => 'Don\'t Display Title',
		    '1' => 'Display Title',
		    '2' => 'Display  Image'
		),
		'default' => '0',
	    );

		$cats[] = array(
		'id' => '_mp_cat_show_title_image',
		'type' => 'media',
		'title' => __('Category image', THEMENAME),
		'required'  => array('_mp_cat_show_title', "=", '2'),
	    );

		$cats[] = array(
			'id' => '_mp_linkbox_layout',
			'type' => 'image_select',
			'title' => __('Image Box Layout', THEMENAME),
			'subtitle' => __('Select layout for image boxes.', THEMENAME),
			'options' => array(
			    'linkbox-layout-1' => array('alt' => 'Linkbox Layout 1', 'img' => $redux_url.'/assets/img/linkbox-layout-1.png'),
			    'linkbox-layout-2' => array('alt' => 'Linkbox Layout 2', 'img' => $redux_url.'/assets/img/linkbox-layout-2.png'),

			),
			'default' => 'linkbox-layout-1',
        );

		$cats[] = array(
			'id' => '_mp_cat_show_postmeta_linkbox',
			'type' => 'button_set',
			'title' => __('Enable Post Meta on Image Boxes', THEMENAME),
			'subtitle' => __('Show date/comments/views', THEMENAME),
			'options'   => array(
			    '1' => 'Show Meta',
			    '0' => 'Hide Meta',
			),
			'default' => '0',
		);

		$cats[] = array(
			'id'       => '_mp_cat_postmeta_linkbox_options',
			'type'     => 'checkbox',
			'title' => __('What Post Meta info to display', THEMENAME),
			'subtitle' => __('Select what you want to display', THEMENAME),
			'options'  => array(
			    'date' => 'Post date',
			    'comments' => 'Post Comments',
			    'views' => 'Post Views'
			),
			'default' => array(
			    'date' => '1',
			    'comments' => '1',
			    'views' => '1'
			),
			'required'  => array('_mp_cat_show_postmeta_linkbox', "=", '1'),
		);

		$cats[] = array(
			'id' => '_mp_cat_layout_effect',
			'type' => 'button_set',
			'title' => __('Layout hover effect', THEMENAME),
			'subtitle' => __('Do you want hover effect on layouts', THEMENAME),
			'options'   => array(
			    '0' => 'No effect',
			    '1' => 'Zoom',
			    '2' => 'Zoom & Opacity',
			    '3' => 'Zoom & Rotate',
			),
			'default' => '0',
		);

	    $cats[] = array(
		'id' => '_mp_cat_show_postmeta',
		'type' => 'button_set',
		'title' => __('Enable Post Meta on Text layouts', THEMENAME),
		'subtitle' => __('Show date/comments/views', THEMENAME),
		'options'   => array(
		    '1' => 'Show Meta',
		    '0' => 'Hide Meta',
		),
		'default' => '1',
	    );

	    $cats[] = array(
		'id'       => '_mp_cat_show_postmeta_options',
		'type'     => 'checkbox',
		'title' => __('What Post Meta info to display', THEMENAME),
		'subtitle' => __('Select what you want to display', THEMENAME),
		'options'  => array(
		    'date' => 'Post date',
		    'comments' => 'Post Comments',
		    'views' => 'Post Views'
		),
		'default' => array(
		    'date' => '1',
		    'comments' => '1',
		    'views' => '1'
		),
		'required'  => array('_mp_cat_show_postmeta', "=", '1'),
	    );

	    /*$cats[] = array(
		'id' => '_mp_cat_show_postmeta',
		'type' => 'button_set',
		'title' => __('Display Post Meta on Text layouts', THEMENAME),
		'subtitle' => __('Hide date and comments in layouts', THEMENAME),
		'options'   => array(
		    '0' => 'Show Meta',
		    '1' => 'Hide Meta',
		    '2' => 'Date only',
		    '3' => 'Comments only',
		),
		'default' => '0',
	    );*/

	    /*$cats[] = array(
		'id' => '_mp_cat_show_breakingnews',
		'type' => 'switch',
		'title' => __('Display Breaking News', THEMENAME),
		'subtitle' => __('You must first enable it under Post Settings', THEMENAME),
		'default' => '0',
	    );*/



	    $cats[] = array(
		'id' => '_mp_cat_sidebar_template',
		'type' => 'image_select',
		'title' => __('Sidebar position', THEMENAME),
		'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
		'options' => array(
		    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
		    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
		    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
		    'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
		    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
		    ),
		'default' => 'multi-sidebar'
	    );

	    $cats[] = array(
		'id' => '_mp_cat_sidebar_source_middle',
		'title' => __( 'Choose default middle/left sidebar', THEMENAME ),
		'subtitle' => __( 'Sidebar for middle or left column', THEMENAME ),
		'desc' => 'Please select the sidebar you would like to display on this page (max 160px content).',
		'type' => 'select',
		'data' => 'sidebars',
		'default' => 'None',
		'required'  => array('_mp_cat_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
	    );

	    $cats[] = array(
		'id' => '_mp_cat_sidebar_source',
		'title' => __( 'Choose default sidebar', THEMENAME ),
		'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
		'desc' => 'Please select the sidebar you would like to display on this page (max 300px content).',
		'type' => 'select',
		'data' => 'sidebars',
		'default' => 'None',
		'required'  => array('_mp_cat_sidebar_template', "!=", 'hide-sidebar'),
	    );

	    $cats[] = array(
		'id'=>'_mp_cat_posts_number',
		'type' => 'slider',
		'title' => __('Posts per page', THEMENAME),
		"default" => "0",
		"min" 	=> "0",
		"step"	=> "1",
		"max" 	=> "50",
		'desc' => __('0 for using default wordpress settings', THEMENAME),
	    );

	    $cats[] = array(
		'id' => '_mp_cat_pagination',
		'type' => 'button_set',
		'title' => __('Pagination template', THEMENAME),
		'subtitle' => __('Choose template for pagination.', THEMENAME),
		'options'   => array(
		    'post-pagination-1' => 'Pager with numbers',
		    'post-pagination-2' => 'Prev/next pager'
		),
		'default' => 'post-pagination-1',
	    );

	    $cats[] = array(
		'id' => '_mp_cat_header_quicklinks_menu',
		'type' => 'select',
		'title' => __('Select Quicklinks category menu', THEMENAME),
		'subtitle' => __('Select what quicklinks menu to display on categories', THEMENAME),
		'desc' => __('', THEMENAME),
		'data' => 'menus',
		'required'  => array('_mp_header_show_quicklinks', "equals", '1'),
	    );



	    /* ads for categories */
	    $banner_cats[] = array(
		'id'   => 'info_ads_cat_normal',
		'type' => 'info',
		'style' => 'success',
		//'notice' => true,
		'icon'      => 'el-icon-info-sign',
		'title' => 'Default settings',
		'desc' => __('This are default setting for all categories. If you want to override this, please select custom settings for desired category below.', THEMENAME)
	    );

	    $banner_cats[] = array(
		'id' 	=> '_mp_ads_cat_top',
		'type' 	=> 'select',
		'title' => __('Top banner', THEMENAME),
		'data'  => 'posts',
		'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
	    );

	    $banner_cats[] = array(
		'id' 	=> '_mp_ads_cat_wall',
		'type' 	=> 'select',
		'title' => __('Wallpaper Ad', THEMENAME),
		'data'  => 'posts',
		'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
	    );

	    $banner_cats[] = array(
		'id' 	=> '_mp_ads_cat_layout_banner',
		'type' 	=> 'select',
		'title' => __('Banner in Layout', THEMENAME),
		'subtitle' => __('Do you want to divide layout with an ad?', THEMENAME),
		'data'  => 'posts',
		'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
	    );

	    $banner_cats[] = array(
		'id' => '_mp_ads_cat_layout_banner_count',
		'type' => 'slider',
		'title' => __('Show banner after row:', THEMENAME),
		"default" => "0",
		"min" 	=> "0",
		"step"	=> "1",
		"max" 	=> "10",
		'desc' => __('0 for showing banner on top of category', THEMENAME),
		'required'  => array('_mp_ads_cat_layout_banner', "not", ''),
	    );

	    $categories		= 0;
	    $category_args	= null;
	    $category_notice	= '';
	    $categories_all 	= get_categories();
	    $categories_parent 	= get_categories( array('parent' => 0) );

	    if($categories_all && (count($categories_all) < 50)) {
		    $categories	= $categories_all;
	    } else if ($categories_parent && (count($categories_parent) < 50)){
    		$categories	= $categories_parent;
    		$category_args	= array('parent' => 0 );
    		$category_notice = ' (Only root categories because you have more than 50 categories in database)';
	    }

	    if($categories && (count($categories) < 50)){

		$cats[] = array(
		    'id'   => '_mp_cat_info_selection',
		    'type'     => 'info',
		    'desc' => 'Custom settings for categories' . $category_notice,
		);

		$cats[] = array(
		    'id'   => '_mp_cat_selection',
		    'title' => __( 'Select Category', THEMENAME ),
		    'type'     => 'select',
		    'data'     => 'categories',
                    'args'     => $category_args,
		);

		$banner_cats[] = array(
		    'id'   => '_mp_cat_ads_info_selection',
		    'type' => 'info',
		    'notice' => true,
		    'style' => 'success',
		    'title' => __('Custom settings for top categories '. count($categories) .'', THEMENAME),
		);

		$banner_cats[] = array(
		    'id'   => '_mp_ads_cat_selection',
		    'title' => __( 'Select Category', THEMENAME ),
		    'type'     => 'select',
		    'data'     => 'categories',
                    'args'     => $category_args,
		);


		foreach($categories as $category) {
		    //if ($category->parent > 0) { continue; }

		    $cats[] = array(
                        'id'        => '_mp_cat_'. $category->term_id .'_section_start',
                        'type'      => 'section',
			'title'      => $category->name,
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required'  => array('_mp_cat_selection', "=", $category->term_id),
                    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_template',
			'type' => 'image_select',
			'title' => __('Category layout', THEMENAME),
			//'subtitle' => __('Select layout for this category.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			    'loop-cat-7' => array('alt' => 'Category layout 7', 'img' => $redux_url.'/assets/img/cat-layout-7.png'),
			    'loop-cat-8' => array('alt' => 'Category layout 8', 'img' => $redux_url.'/assets/img/cat-layout-8.png'),
			),
		    );

            $cats[] = array(
                'id'=>'_mp_cat_'. $category->term_id .'_template_chars',
                'type' => 'slider',
                'title' => __('Limit text characters', THEMENAME),
                "default" => "0",
                "min" 	=> "0",
                "step"	=> "1",
                "max" 	=> "1000",
                'subtitle' => __('0 for using default wordpress settings', THEMENAME),
                'required'  => array('_mp_cat_'. $category->term_id .'_template', "=", array('loop-cat-1', 'loop-cat-2', 'loop-cat-7', 'loop-cat-8')),
            );

		    $cats[] = array(
				'id' => '_mp_cat_'. $category->term_id .'_show_title',
				'type' => 'button_set',
				'title' => __('Show category title on top', THEMENAME),
				'options'   => array(
					'0' => 'Don\'t Display Title',
					'1' => 'Display Title',
					'2' => 'Display  Image'
				),
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_show_title_image',
			'type' => 'media',
			'title' => __('Category image', THEMENAME),
			'required'  => array('_mp_cat_'. $category->term_id .'_show_title', "=", '2'),
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			),
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array (
			    array('_mp_cat_'. $category->term_id .'_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
			)
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_cat_'. $category->term_id .'_sidebar_template', "!=", 'hide-sidebar'),
		    );

		    $cats[] = array(
			'id'=>'_mp_cat_'. $category->term_id .'_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_header_quicklinks_menu',
			'type' => 'select',
			'title' => __('Select Quicklinks category menu', THEMENAME),
			'subtitle' => __('Select what quicklinks menu to display on this category', THEMENAME),
			'desc' => __('', THEMENAME),
			'data' => 'menus',
			'required'  => array('_mp_header_show_quicklinks', "equals", '1'),
		    );

		    $cats[] = array(
			'id' => '_mp_cat_'. $category->term_id .'_set_for_children',
			'type' => 'switch',
			'title' => __('Use this setting for child categories', THEMENAME),
			//'subtitle' => __('', THEMENAME),
			'default' => 0,
		    );

		    $cats[] = array(
                        'id'        => '_mp_cat_'. $category->term_id .'_section_end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                        'required'  => array('_mp_cat_selection', "=", $category->term_id),
                    );


		    $banner_cats[] = array(
                        'id'        => '_mp_ads_cat_'. $category->term_id .'_section_start',
			'title'      => $category->name,
                        'type'      => 'section',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                        'required'  => array('_mp_ads_cat_selection', "=", $category->term_id),
                    );

		    $banner_cats[] = array(
			'id' 	=> '_mp_ads_cat_'. $category->term_id .'_top',
			'type' 	=> 'select',
			'title' => __('Top banner', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
		    );

		    $banner_cats[] = array(
                        'id' 	=> '_mp_ads_cat_'. $category->term_id .'_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    );


		    $banner_cats[] = array(
			'id' 	=> '_mp_ads_cat_'. $category->term_id .'_layout_banner',
			'type' 	=> 'select',
			'title' => __('Banner in Layout', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
		    );

		    $banner_cats[] = array(
			'id' => '_mp_ads_cat_'. $category->term_id .'_layout_banner_count',
			'type' => 'slider',
			'title' => __('Show banner after row:', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "10",
			'desc' => __('0 for showing banner on top of category', THEMENAME),
			'required'  => array('_mp_ads_cat_'. $category->term_id .'_layout_banner', "not", ''),
		    );


		    $banner_cats[] = array(
                        'id'        => '_mp_ads_cat_'. $category->term_id .'_section_end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                        'required'  => array('_mp_ads_cat_selection', "=", $category->term_id),
                    );

		}
	    }

	    $this->sections[] = array(
                'title'     => __('Categories', THEMENAME),
                'icon'      => 'el-icon-folder-open',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => $cats
            );


            /* Post settings */
            $this->sections[] = array(
                'title' => __('Posts Settings', THEMENAME),
                'icon' => 'el-icon-file-edit',
                'fields' => array(
                    array(
			'id' => '_mp_post_layout',
			'type' => 'image_select',
			'title' => __('Post layout', THEMENAME),
			'subtitle' => __('Select main layout for posts.', THEMENAME),
			'options' => array(
			    'loop-page-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/post-layout-1.png'),
			    'loop-page-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/post-layout-2.png'),
			    'loop-page-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/post-layout-3.png'),
			    'loop-page-4' => array('alt' => 'Layout 4', 'img' => $redux_url.'/assets/img/post-layout-4.png'),
			    'loop-page-5' => array('alt' => 'Layout 5', 'img' => $redux_url.'/assets/img/post-layout-5.png'),
			    ),
			'default' => 'loop-page-1'
                    ),
		    array(
			'id' => '_mp_post_layout_image_height',
			'type' => 'switch',
			'title' => __('Show full image height', THEMENAME),
			'subtitle' => __('Fit only horizontally', THEMENAME),
			'default' => 0,
			'required'  => array (
			    array('_mp_post_layout', "=", array('loop-page-1', 'loop-page-2') ),
			)
		    ),
		    array(
			'id' => '_mp_sidebar_position',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
                    ),
		    array(
			'id' => '_mp_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_sidebar_position', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_sidebar_position', "!=", 'hide-sidebar'),
		    ),
		    array(
                        'id' => '_mp_enable_ajax_post_views',
                        'type' => 'switch',
                        'title' => __('Enable Ajax Post Views', THEMENAME),
                        'subtitle' => __('Enable this if you are using a cache plugin!', THEMENAME),
                        'default' => 1,
                    ),
		    array(
                        'id' => '_mp_posts_enable_lazy_load',
                        'type' => 'switch',
                        'title' => __('Enable Lazy Load for images', THEMENAME),
                        'subtitle' => __('Lazy Load is delays loading of images in long web pages', THEMENAME),
                        'default' => 0,
                    ),
		    array(
                        'id' => '_mp_posts_enable_image_categories',
                        'type' => 'switch',
                        'title' => __('Show Category on post images', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                        'default' => 1,
                    ),
		    array(
                        'id' => '_mp_posts_enable_image_post_formats',
                        'type' => 'switch',
                        'title' => __('Show Post Format after category', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                        'default' => 1,
                        'required'  => array('_mp_posts_enable_image_categories', "=", '1'),
                    ),
		    /*array(
                        'id' => '_mp_posts_label_categories_display',
                        'type' => 'button_set',
                        'title' => __('Display Category labels as', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                        'options'   => array(
			    'root' => 'Root Categories',
			    'sub' => 'Sub Categories'
			),
                        'default' => 'root',
                    ),*/
		    array(
                        'id' => '_mp_posts_show_category_on_feat_img',
                        'type' => 'switch',
                        'title' => __('Show category on featured image', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                        'default' => '0',
                    ),
		    array(
                        'id' => '_mp_posts_enable_breadcrumbs',
                        'type' => 'button_set',
                        'title' => __('Enable Breadcrumbs', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),
		    array(
                        'id' => '_mp_enable_postmeta',
                        'type' => 'button_set',
                        'title' => __('Enable Post Meta after Title', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),

		    array(
			'id'       => '_mp_enable_postmeta_elements',
			'type'     => 'checkbox',
			'title'    => __('What to display in Post Meta', THEMENAME),
			'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'  => array(
			    'date' => 'Post Date',
			    'author' => 'Author',
			    'categories' => 'Categories',
			    'comments' => 'Comments',
			    'views' => 'Views',
			),
			'default'  => array(
			    'date' => '1',
			    'author' => '1',
			    'categories' => '1',
			    'comments' => '1',
			    'views' => '0',
			),
			'required'  => array('_mp_enable_postmeta', "=", 'enable'),
		    ),
		    array(
                        'id' => '_mp_enable_tags',
                        'type' => 'button_set',
                        'title' => __('Enable Tags after Content', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),
                    array(
                        'id' => '_mp_enable_author',
                        'type' => 'button_set',
                        'title' => __('Enable Author Information', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),
		    array(
                        'id' => '_mp_enable_prevnext_posts',
                        'type' => 'button_set',
                        'title' => __('Enable Prev/Next Posts', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),


                )
            );


	    /* Post settings */
            $this->sections[] = array(
                'title' => __('Related posts settings', THEMENAME),
                //'icon' => 'el-icon-file-edit',
		'subsection' => true,
                'fields' => array(
		    array(
                        'id'        => 'related-notice-info-1',
                        'type'  => 'info',
                        'style' => 'success',
                        'title'     => __('Related posts box at the bottom', THEMENAME),
                        'desc'      => __('This box will be displayed at bottom of the post, after author box (if selected).', THEMENAME)
                    ),
                    array(
                        'id' => '_mp_enable_related_posts',
                        'type' => 'button_set',
                        'title' => __('Display related posts', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'enable',
                    ),
                    array(
                        'id'        => '_mp_filter_related_posts',
                        'type'      => 'button_set',
                        'title'     => __('Filter related posts by', THEMENAME),
                        'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                        'options'   => array(
                            'cat' => 'Category',
                            'tag' => 'Tag'
                        ),
                        'default'   => 'cat',
			'required'  => array('_mp_enable_related_posts', "=", 'enable'),
                    ),
		    array(
                        'id' => '_mp_related_posts_title',
                        'type' => 'text',
                        'title' => __('Title for related posts', THEMENAME),
			'subtitle' => __('Default: <i>"Related Posts"</i>', THEMENAME),
			'default'   => __('Related Posts', THEMENAME),
			'required'  => array('_mp_enable_related_posts', "=", 'enable'),
                    ),
		    array(
			'id'=>'_mp_related_posts_count',
			'type' => 'slider',
			'title' => __('Posts Count', THEMENAME),
			'subtitle' => __('Default: <i>"3"</i>', THEMENAME),
			"default" => "3",
			"min" 	=> "3",
			"step"	=> "3",
			"max" 	=> "30",
			'desc' => __('Number of related posts to display', THEMENAME),
			'required'  => array('_mp_enable_related_posts', "=", 'enable'),
		    ),
		    array(
                        'id' => '_mp_related_posts_offset',
                        'type' => 'text',
                        'title' => __('Posts offset', THEMENAME),
			'subtitle' => __('Default: <i>"0"</i> (No offset)', THEMENAME),
			'desc' => __('Number of post to displace or pass over', THEMENAME),
			'default'   => 0,
			'validate'  => 'numeric',
			'required'  => array('_mp_enable_related_posts', "=", 'enable'),
                    ),
		    array(
			'id'        => '_mp_related_posts_sort',
			'type'      => 'select',
			'title'     => __('Sort order', THEMENAME),
			'subtitle'  => __('Choose how to sort your posts', THEMENAME),
			'options'   => array(
			    'date' => 'Latest',
			    'rand' => 'Random posts',
			    'name' => 'By name',
			    'modified' => 'Last Modified',
			    'comment_count' => 'Most Commented',
			    'meta_value_num' => 'Most Viewed',
			),
			'default'   => 'date',
			'required'  => array('_mp_enable_related_posts', "=", 'enable'),
		    ),
		    array(
                        'id'        => 'related-notice-info-2',
                        'type'  => 'info',
                        'style' => 'warning',
                        'title'     => __('Related posts box on the side', THEMENAME),
                        'desc'      => __('This box will be displayed after post title.', THEMENAME)
                    ),
		    array(
                        'id' => '_mp_enable_related_box',
                        'type' => 'button_set',
                        'title' => __('Display related box', THEMENAME),
                        'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'disable',
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_count',
                        'type'      => 'button_set',
                        'title'     => __('Number of sections', THEMENAME),
			'subtitle'  => __('Number of sections in related box', THEMENAME),
                        'desc'  => __('How many sections you want to have in related box', THEMENAME),
                        'options'   => array(
                            '1' => '1',
                            '2' => '2',
			    '3' => '3',
                            //'4' => '4',
			    //'5' => '5',
                        ),
                        'default'   => '1',
			'required'  => array('_mp_enable_related_box', "=", 'enable'),
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_float',
                        'type'      => 'button_set',
                        'title'     => __('Show box on', THEMENAME),
			'subtitle'  => __('Where to display related box', THEMENAME),
                        'options'   => array(
                            'pull-left' => 'On left side',
                            'pull-right' => 'On right side',
                        ),
                        'default'   => 'pull-right',
			'required'  => array('_mp_enable_related_box', "=", 'enable'),
                    ),

		    // First section
		    array(
                        'id'        => 'related-box-info-1',
                        'type'  => 'info',
                        'title'     => __('First section data', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_title_1',
                        'type' => 'text',
                        'title' => __('Section title', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_format_1',
                        'type'      => 'radio',
                        'title'     => __('Section format', THEMENAME),
                        'subtitle'  => __('Choose how to format post layout', THEMENAME),
                        'options'   => array(
                            'related-box-1' => 'Only Title',
                            'related-box-2' => 'Title and Published date',
                            'related-box-3' => 'Image and Title'
                        ),
                        'default'   => 'related-box-3',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_filter_1',
                        'type'      => 'button_set',
                        'title'     => __('Filter related box by', THEMENAME),
                        'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                        'options'   => array(
                            'cat' => 'Category',
                            'tag' => 'Tag'
                        ),
                        'default'   => 'cat',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_count_1',
                        'type' => 'text',
                        'title' => __('Posts count', THEMENAME),
			'desc' => __('Number of post to show', THEMENAME),
			'default'   => 3,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_offset_1',
                        'type' => 'text',
                        'title' => __('Posts offset', THEMENAME),
			'subtitle' => __('Default: <i>"0"</i> (No offset)', THEMENAME),
			'desc' => __('Number of post to displace or pass over', THEMENAME),
			'default'   => 0,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
                    ),
		    array(
			'id'        => '_mp_enable_related_box_sort_1',
			'type'      => 'select',
			'title'     => __('Sort order', THEMENAME),
			'subtitle'  => __('Choose how to sort your posts', THEMENAME),
			'options'   => array(
			    'date' => 'Latest',
			    'rand' => 'Random posts',
			    'name' => 'By name',
			    'modified' => 'Last Modified',
			    'comment_count' => 'Most Commented',
			),
			'default'   => 'date',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '1', '2', '3' )),
			)
		    ),

		    // Second section
		    array(
                        'id'        => 'related-box-info-2',
                        'type'  => 'info',
                        'title'     => __('Second section data', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_title_2',
                        'type' => 'text',
                        'title' => __('Second Section title', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_format_2',
                        'type'      => 'radio',
                        'title'     => __('Section format', THEMENAME),
                        'subtitle'  => __('Choose how to format post layout', THEMENAME),
                        'options'   => array(
                            'related-box-1' => 'Only Title',
                            'related-box-2' => 'Title and Published date',
                            'related-box-3' => 'Image and Title'
                        ),
                        'default'   => 'related-box-3',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_filter_2',
                        'type'      => 'button_set',
                        'title'     => __('Filter related box by', THEMENAME),
                        'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                        'options'   => array(
                            'cat' => 'Category',
                            'tag' => 'Tag'
                        ),
                        'default'   => 'cat',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_count_2',
                        'type' => 'text',
                        'title' => __('Posts count', THEMENAME),
			'desc' => __('Number of post to show', THEMENAME),
			'default'   => 3,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_offset_2',
                        'type' => 'text',
                        'title' => __('Posts offset', THEMENAME),
			'subtitle' => __('Default: <i>"0"</i> (No offset)', THEMENAME),
			'desc' => __('Number of post to displace or pass over', THEMENAME),
			'default'   => 0,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
                    ),
		    array(
			'id'        => '_mp_enable_related_box_sort_2',
			'type'      => 'select',
			'title'     => __('Sort order', THEMENAME),
			'subtitle'  => __('Choose how to sort your posts', THEMENAME),
			'options'   => array(
			    'date' => 'Latest',
			    'rand' => 'Random posts',
			    'name' => 'By name',
			    'modified' => 'Last Modified',
			    'comment_count' => 'Most Commented',
			),
			'default'   => 'date',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", array( '2', '3' )),
			)
		    ),

		    // Third section
		    array(
                        'id'        => 'related-box-info-3',
                        'type'  => 'info',
                        'title'     => __('Third section data', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_title_3',
                        'type' => 'text',
                        'title' => __('Third Section title', THEMENAME),
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_format_3',
                        'type'      => 'radio',
                        'title'     => __('Section format', THEMENAME),
                        'subtitle'  => __('Choose how to format post layout', THEMENAME),
                        'options'   => array(
                            'related-box-1' => 'Only Title',
                            'related-box-2' => 'Title and Published date',
                            'related-box-3' => 'Image and Title'
                        ),
                        'default'   => 'related-box-3',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
                    ),
		    array(
                        'id'        => '_mp_enable_related_box_filter_3',
                        'type'      => 'button_set',
                        'title'     => __('Filter related box by', THEMENAME),
                        'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                        'options'   => array(
                            'cat' => 'Category',
                            'tag' => 'Tag'
                        ),
                        'default'   => 'cat',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_count_3',
                        'type' => 'text',
                        'title' => __('Posts count', THEMENAME),
			'desc' => __('Number of post to show', THEMENAME),
			'default'   => 3,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3'),
			)
                    ),
		    array(
                        'id' => '_mp_enable_related_box_offset_3',
                        'type' => 'text',
                        'title' => __('Posts offset', THEMENAME),
			'subtitle' => __('Default: <i>"0"</i> (No offset)', THEMENAME),
			'desc' => __('Number of post to displace or pass over', THEMENAME),
			'default'   => 0,
			'validate'  => 'numeric',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
                    ),
		    array(
			'id'        => '_mp_enable_related_box_sort_3',
			'type'      => 'select',
			'title'     => __('Sort order', THEMENAME),
			'subtitle'  => __('Choose how to sort your posts', THEMENAME),
			'options'   => array(
			    'date' => 'Latest',
			    'rand' => 'Random posts',
			    'name' => 'By name',
			    'modified' => 'Last Modified',
			    'comment_count' => 'Most Commented',
			),
			'default'   => 'date',
			'required'  => array (
			    array('_mp_enable_related_box', "=", 'enable'),
			    array('_mp_enable_related_box_count', "=", '3' ),
			)
		    ),
                )
            );

	    /* Post settings */
            $this->sections[] = array(
                'title' => __('Review posts settings', THEMENAME),
		'desc' => __('Set default values for reviews (can be overwritten on post posts)', THEMENAME),
                //'icon' => 'el-icon-file-edit',
		'subsection' => true,
                'fields' => array(
		    array(
			'id' => '_mp_review_post_position_global',
			'type' => 'button_set',
			'title' => __('Review box position', THEMENAME),
			'desc' => __('If you are using custom position then please use <strong>[review]</strong> shortcode to place the review box in any place within post content', THEMENAME),
			'options'   => array(
			    'top' => 'Top of the post',
			    'bottom' => 'Bottom of the post',
			    'custom' => 'Custom position'
			),
			'default' => 'bottom',
		    ),
		    array(
			'id'        => '_mp_review_post_style_global',
			'type'      => 'button_set',
			'title'     => __('Review style', THEMENAME),
			'options'   => array(
			    'percentage' => 'Percentage',
			    'points' => 'Points',
			),
			'default' => 'percentage',
		    ),

		    array(
			'id'        => '_mp_review_post_summary_type_global',
			'type'      => 'button_set',
			'title'     => __('Review summary type', THEMENAME),
			'subtitle'  => __('How to display review summary', THEMENAME),
			'options'   => array(
			    'summary' => 'Summary box',
			    'good-bad' => 'The Good / The Bad boxes',
			),
			'default' => 'summary',
		    ),

		    array(
			'id'        => '_mp_review_post_criteria_count_global',
			'type'      => 'button_set',
			'title'     => __('Number of criterias', THEMENAME),
			'subtitle'  => __('Size of a review', THEMENAME),
			'desc'  => __('How many criteria fields you want to have', THEMENAME),
			'options'   => array(
			    '1' => '1',
			    '2' => '2',
			    '3' => '3',
			    '4' => '4',
			    '5' => '5',
			    '6' => '6',
			    '7' => '7',
			    '8' => '8',
			),
			'default' => '0',
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_1_global',
			'type'          => 'text',
			'title'         => __('#1 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('1', '2', '3', '4', '5', '6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_2_global',
			'type'          => 'text',
			'title'         => __('#2 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('2', '3', '4', '5', '6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_3_global',
			'type'          => 'text',
			'title'         => __('#3 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('3', '4', '5', '6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_4_global',
			'type'          => 'text',
			'title'         => __('#4 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('4', '5', '6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_5_global',
			'type'          => 'text',
			'title'         => __('#5 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('5', '6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_6_global',
			'type'          => 'text',
			'title'         => __('#6 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('6', '7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_7_global',
			'type'          => 'text',
			'title'         => __('#7 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('7', '8') ),
			)
		    ),

		    array(
			'id'            => '_mp_review_post_criteria_8_global',
			'type'          => 'text',
			'title'         => __('#8 - Criteria name', THEMENAME),
			'desc'          => __('Name of the review criteria', THEMENAME),
			'required'  => array (
			    array('_mp_review_post_criteria_count_global', "=", array('8') ),
			)
		    ),

		    array(
			'id'       => '_mp_review_post_progress_background',
			'type'     => 'background',
			'title'    => __('Background color for progress bar', THEMENAME),
			'default'  => array(
			    'background-color' => '#f5f5f5',
			),
			'compiler'    => array('.article-post .progress'),
			'background-repeat' => false,
			'background-attachment' => false,
			'background-position' => false,
			'background-image' => false,
			'background-clip' => false,
			'background-origin' => false,
			'background-size' => false,
			'background-repeat' => false,
			'preview_media' => false,
			'preview' => false,
		    ),

		    array(
			'id'   => '_mp_info_review',
			'type' => 'info',
			'style' => 'success',
			//'notice' => true,
			'icon'      => 'el-icon-info-sign',
			'title' => 'Block Review Settings',
			'desc' => __('These are default settings for <strong>Block Review Template</strong> under Visual Composer', THEMENAME)
		    ),
		    array(
			'id'       => '_mp_review_block_vc_background',
			'type'     => 'background',
			'title'    => __('Background color', THEMENAME),
			'default'  => array(
			    'background-color' => '#444444',
			),
			'compiler'    => array('.cat-reviews'),
			'background-repeat' => false,
			'background-attachment' => false,
			'background-position' => false,
			'background-image' => false,
			'background-clip' => false,
			'background-origin' => false,
			'background-size' => false,
			'background-repeat' => false,
			'preview_media' => false,
			'preview' => false,
		    ),
		    array(
			'id'       => '_mp_review_block_vc_font-color',
			'type'     => 'color',
			'title'    => __('Font color', THEMENAME),
			'default'  => '#fff',
			'compiler'    => array('.cat-reviews article a h3'),
		    )

		),
	    );


	    /* Post settings */
            $this->sections[] = array(
                'title' => __('Social sharing settings', THEMENAME),
                //'icon' => 'el-icon-file-edit',
		'subsection' => true,
                'fields' => array(
		    array(
                        'id' => '_mp_show_social_sharing',
                        'type' => 'button_set',
                        'title' => __('Display social sharing buttons', THEMENAME),
                        'subtitle' => __('Where to display buttons', THEMENAME),
			'options'   => array(
			    'none' => 'Don\'t display buttons',
			    'bottom' => 'Bottom of the post',
			    'top' => 'Top of the post',
			    'both' => 'Top and bottom'
			),
                        'default' => 'bottom',
                    ),

		    array(
                        'id' => '_mp_social_sharing_title',
                        'type' => 'text',
                        'title' => __('Title Social Sharing', THEMENAME),
			'subtitle' => __('Default: <i>""</i>', THEMENAME),
			'default'   => '',
			'required'  => array('_mp_show_social_sharing', "!=", 'none'),
                    ),

		    array(
			'id' => '_mp_social_sharing_theme',
			'type' => 'image_select',
			'title' => __('Social Sharing Styles', THEMENAME),
			'subtitle' => __('Select theme for buttons.', THEMENAME),
			'options' => array(
			    'default' => array('alt' => 'Default', 'img' => $redux_url.'/assets/img/socmedia_layout_1.png'),
			    'soc-style-two' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/socmedia_layout_2.png'),
			    'soc-style-three' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/socmedia_layout_3.png'),
			),
			'default' => 'default',
			'required'  => array('_mp_show_social_sharing', "!=", 'none'),
		    ),

		    /*array(
			'id'       => '_mp_enable_social_sharing',
			'type'     => 'checkbox',
			'title'    => __('Enable social sharing', THEMENAME),
			'subtitle' => __('Choose where to share', THEMENAME),
			'options'  => array(
			    'twitter' => 'Twitter',
			    'facebook' => 'Facebook',
			    'pinterest' => 'Pinterest',
			    'linkedin' => 'Linkedin',
			    'google' => 'Google+',
			),
			'default'  => array(
			    'twitter' => '1',
			    'facebook' => '1',
			    'pinterest' => '1',
			    'linkedin' => '1',
			    'google' => '1',
			),
			'required'  => array(
			    array('_mp_show_social_sharing', "!=", 'none'),
			    array('_mp_social_sharing_theme', "=", 'default'),
			)
		    ),*/

		    array(
                        'id' => '_mp_social_sharing_facebook',
                        'type' => 'button_set',
                        'title' => __('Display Facebook button', THEMENAME),
                        'subtitle' => __('How to display Facebook button', THEMENAME),
			'options'   => array(
			    'none' => 'Don\'t display button',
			    'btn-icon' => 'Only Icon',
			    'btn-icon-title' => 'Icon & Title',
			    'btn-icon-title btn-icon-counter' => 'Icon & Counter'
			),
                        'default' => 'btn-icon-title',
			'required'  => array(
			    array('_mp_show_social_sharing', "!=", 'none'),
			)
                    ),

		    array(
                        'id' => '_mp_social_sharing_twitter',
                        'type' => 'button_set',
                        'title' => __('Display Twitter button', THEMENAME),
                        'subtitle' => __('How to display Twitter button', THEMENAME),
			'options'   => array(
			    'none' => 'Don\'t display button',
			    'btn-icon' => 'Only Icon',
			    'btn-icon-title' => 'Icon & Title',
			    'btn-icon-title btn-icon-counter' => 'Icon & Counter'
			),
                        'default' => 'btn-icon-title',
			'required'  => array(
			    array('_mp_show_social_sharing', "!=", 'none'),
			)
                    ),

		    array(
                        'id' => '_mp_social_sharing_google',
                        'type' => 'button_set',
                        'title' => __('Display Google button', THEMENAME),
                        'subtitle' => __('How to display Google button', THEMENAME),
			'options'   => array(
			    'none' => 'Don\'t display button',
			    'btn-icon' => 'Only Icon',
			    'btn-icon-title' => 'Icon & Title',
			    //'btn-icon-title btn-icon-counter' => 'Icon & Counter'
			),
                        'default' => 'btn-icon-title',
			'required'  => array(
			    array('_mp_show_social_sharing', "!=", 'none'),
			)
                    ),

		    array(
                        'id' => '_mp_social_sharing_linkedin',
                        'type' => 'button_set',
                        'title' => __('Display LinkedIn button', THEMENAME),
                        'subtitle' => __('How to display LinkedIn button', THEMENAME),
			'options'   => array(
			    'none' => 'Don\'t display button',
			    'btn-icon' => 'Only Icon',
			    'btn-icon-title' => 'Icon & Title',
			    'btn-icon-title btn-icon-counter' => 'Icon & Counter'
			),
                        'default' => 'btn-icon-title',
			'required'  => array(
			    array('_mp_show_social_sharing', "!=", 'none'),
			)
                    ),

					array(
						'id' => '_mp_social_sharing_pinterest',
						'type' => 'button_set',
						'title' => __('Display Pinterest button', THEMENAME),
						'subtitle' => __('How to display Pinterest button', THEMENAME),
						'options'   => array(
							'none' => 'Don\'t display button',
							'btn-icon' => 'Only Icon',
							'btn-icon-title' => 'Icon & Title',
							//'icon-counter' => 'Icon & Counter'
						),
						'default' => 'btn-icon-title',
						'required'  => array(
							array('_mp_show_social_sharing', "!=", 'none'),
						)
					),


                )
            );


	    /* Post settings */
            $this->sections[] = array(
                'title' => __('Comments settings', THEMENAME),
				'desc' => __('Set additional values for comment section!', THEMENAME),
                //'icon' => 'el-icon-file-edit',
				'subsection' => true,
                'fields' => array(
					array(
                        'id' => '_mp_post_comments_location',
                        'type' => 'select',
                        'title' => __('Comments Location', THEMENAME),
                        'subtitle' => __('Where to display comments?', THEMENAME),
						'options'   => array(
							'after-related' => 'After Related Posts',
							'before-author' => 'Before Author Box',
							'after-author' => 'After Author Box',
						),
						'default'  => 'after-related',
					),
					array(
						'id' => '_mp_post_facebook_comments_enable',
						'type' => 'switch',
						'title' => __('Show Facebook Comments', THEMENAME),
						'subtitle' => __('This will disable standard comments', THEMENAME),
						'default'  => 0,
					),
					array(
						'id'=>'_mp_post_facebook_comments_number',
						'type' => 'slider',
						'title' => __('Number of Comments', THEMENAME),
						"default" => "5",
						"min" 	=> "1",
						"step"	=> "1",
						"max" 	=> "100",
						'desc' => __('The number of comments to show by default.', THEMENAME),
						'required'  => array('_mp_post_facebook_comments_enable', "equals", 1),
					),

					array(
						'id' => '_mp_social_facebook_local',
						'type' => 'select',
						'title' => __('Facebook localization', THEMENAME),
						'subtitle' => __('Open Graph internationalization', THEMENAME),
						'options'   => array(
							'af_ZA' => 'Afrikaans (af_ZA)',
							'ak_GH' => 'Akan (ak_GH)',
							'am_ET' => 'Amharic (am_ET)',
							'ar_AR' => 'Arabic (ar_AR)',
							'as_IN' => 'Assamese (as_IN)',
							'ay_BO' => 'Aymara (ay_BO)',
							'az_AZ' => 'Azerbaijani (az_AZ)',
							'be_BY' => 'Belarusian (be_BY)',
							'bg_BG' => 'Bulgarian (bg_BG)',
							'bn_IN' => 'Bengali (bn_IN)',
							'br_FR' => 'Breton (br_FR)',
							'bs_BA' => 'Bosnian (bs_BA)',
							'ca_ES' => 'Catalan (ca_ES)',
							'cb_IQ' => 'Sorani Kurdish (cb_IQ)',
							'ck_US' => 'Cherokee (ck_US)',
							'co_FR' => 'Corsican (co_FR)',
							'cs_CZ' => 'Czech (cs_CZ)',
							'cx_PH' => 'Cebuano (cx_PH)',
							'cy_GB' => 'Welsh (cy_GB)',
							'da_DK' => 'Danish (da_DK)',
							'de_DE' => 'German (de_DE)',
							'el_GR' => 'Greek (el_GR)',
							'en_GB' => 'English (UK) (en_GB)',
							'en_IN' => 'English (India) (en_IN)',
							'en_PI' => 'English (Pirate) (en_PI)',
							'en_UD' => 'English (Upside Down) (en_UD)',
							'en_US' => 'English (US) (en_US)',
							'eo_EO' => 'Esperanto (eo_EO)',
							'es_CO' => 'Spanish (Colombia) (es_CO)',
							'es_ES' => 'Spanish (Spain) (es_ES)',
							'es_LA' => 'Spanish (es_LA)',
							'et_EE' => 'Estonian (et_EE)',
							'eu_ES' => 'Basque (eu_ES)',
							'fa_IR' => 'Persian (fa_IR)',
							'fb_LT' => 'Leet Speak (fb_LT)',
							'ff_NG' => 'Fulah (ff_NG)',
							'fi_FI' => 'Finnish (fi_FI)',
							'fo_FO' => 'Faroese (fo_FO)',
							'fr_CA' => 'French (Canada) (fr_CA)',
							'fr_FR' => 'French (France) (fr_FR)',
							'fy_NL' => 'Frisian (fy_NL)',
							'ga_IE' => 'Irish (ga_IE)',
							'gl_ES' => 'Galician (gl_ES)',
							'gn_PY' => 'Guarani (gn_PY)',
							'gu_IN' => 'Gujarati (gu_IN)',
							'gx_GR' => 'Classical Greek (gx_GR)',
							'ha_NG' => 'Hausa (ha_NG)',
							'he_IL' => 'Hebrew (he_IL)',
							'hi_IN' => 'Hindi (hi_IN)',
							'hr_HR' => 'Croatian (hr_HR)',
							'hu_HU' => 'Hungarian (hu_HU)',
							'hy_AM' => 'Armenian (hy_AM)',
							'id_ID' => 'Indonesian (id_ID)',
							'ig_NG' => 'Igbo (ig_NG)',
							'is_IS' => 'Icelandic (is_IS)',
							'it_IT' => 'Italian (it_IT)',
							'ja_JP' => 'Japanese (ja_JP)',
							'ja_KS' => 'Japanese (Kansai) (ja_KS)',
							'jv_ID' => 'Javanese (jv_ID)',
							'ka_GE' => 'Georgian (ka_GE)',
							'kk_KZ' => 'Kazakh (kk_KZ)',
							'km_KH' => 'Khmer (km_KH)',
							'kn_IN' => 'Kannada (kn_IN)',
							'ko_KR' => 'Korean (ko_KR)',
							'ku_TR' => 'Kurdish (Kurmanji) (ku_TR)',
							'la_VA' => 'Latin (la_VA)',
							'lg_UG' => 'Ganda (lg_UG)',
							'li_NL' => 'Limburgish (li_NL)',
							'ln_CD' => 'Lingala (ln_CD)',
							'lo_LA' => 'Lao (lo_LA)',
							'lt_LT' => 'Lithuanian (lt_LT)',
							'lv_LV' => 'Latvian (lv_LV)',
							'mg_MG' => 'Malagasy (mg_MG)',
							'mk_MK' => 'Macedonian (mk_MK)',
							'ml_IN' => 'Malayalam (ml_IN)',
							'mn_MN' => 'Mongolian (mn_MN)',
							'mr_IN' => 'Marathi (mr_IN)',
							'ms_MY' => 'Malay (ms_MY)',
							'mt_MT' => 'Maltese (mt_MT)',
							'my_MM' => 'Burmese (my_MM)',
							'nb_NO' => 'Norwegian (bokmal) (nb_NO)',
							'nd_ZW' => 'Ndebele (nd_ZW)',
							'ne_NP' => 'Nepali (ne_NP)',
							'nl_BE' => 'Dutch (Belgi�) (nl_BE)',
							'nl_NL' => 'Dutch (nl_NL)',
							'nn_NO' => 'Norwegian (nynorsk) (nn_NO)',
							'ny_MW' => 'Chewa (ny_MW)',
							'or_IN' => 'Oriya (or_IN)',
							'pa_IN' => 'Punjabi (pa_IN)',
							'pl_PL' => 'Polish (pl_PL)',
							'ps_AF' => 'Pashto (ps_AF)',
							'pt_BR' => 'Portuguese (Brazil) (pt_BR)',
							'pt_PT' => 'Portuguese (Portugal) (pt_PT)',
							'qu_PE' => 'Quechua (qu_PE)',
							'rm_CH' => 'Romansh (rm_CH)',
							'ro_RO' => 'Romanian (ro_RO)',
							'ru_RU' => 'Russian (ru_RU)',
							'rw_RW' => 'Kinyarwanda (rw_RW)',
							'sa_IN' => 'Sanskrit (sa_IN)',
							'sc_IT' => 'Sardinian (sc_IT)',
							'se_NO' => 'Northern S�mi (se_NO)',
							'si_LK' => 'Sinhala (si_LK)',
							'sk_SK' => 'Slovak (sk_SK)',
							'sl_SI' => 'Slovenian (sl_SI)',
							'sn_ZW' => 'Shona (sn_ZW)',
							'so_SO' => 'Somali (so_SO)',
							'sq_AL' => 'Albanian (sq_AL)',
							'sr_RS' => 'Serbian (sr_RS)',
							'sv_SE' => 'Swedish (sv_SE)',
							'sw_KE' => 'Swahili (sw_KE)',
							'sy_SY' => 'Syriac (sy_SY)',
							'sz_PL' => 'Silesian (sz_PL)',
							'ta_IN' => 'Tamil (ta_IN)',
							'te_IN' => 'Telugu (te_IN)',
							'tg_TJ' => 'Tajik (tg_TJ)',
							'th_TH' => 'Thai (th_TH)',
							'tk_TM' => 'Turkmen (tk_TM)',
							'tl_PH' => 'Filipino (tl_PH)',
							'tl_ST' => 'Klingon (tl_ST)',
							'tr_TR' => 'Turkish (tr_TR)',
							'tt_RU' => 'Tatar (tt_RU)',
							'tz_MA' => 'Tamazight (tz_MA)',
							'uk_UA' => 'Ukrainian (uk_UA)',
							'ur_PK' => 'Urdu (ur_PK)',
							'uz_UZ' => 'Uzbek (uz_UZ)',
							'vi_VN' => 'Vietnamese (vi_VN)',
							'wo_SN' => 'Wolof (wo_SN)',
							'xh_ZA' => 'Xhosa (xh_ZA)',
							'yi_DE' => 'Yiddish (yi_DE)',
							'yo_NG' => 'Yoruba (yo_NG)',
							'zh_CN' => 'Simplified Chinese (China) (zh_CN)',
							'zh_HK' => 'Traditional Chinese (Hong Kong) (zh_HK)',
							'zh_TW' => 'Traditional Chinese (Taiwan) (zh_TW)',
							'zu_ZA' => 'Zulu (zu_ZA)',
							'zz_TR' => 'Zazaki (zz_TR)',
						),
						'default' => 'en_US',
						'required'  => array('_mp_post_facebook_comments_enable', "equals", 1),
					),
					array(
						'id' => '_mp_post_facebook_app_id',
						'type' => 'text',
						'title' => __('Facebook App ID', THEMENAME),
						'subtitle' => __('For Comments Moderation', THEMENAME),
						'default'  => '',
					),


			),
	    );


	    /* Page settings */
            $this->sections[] = array(
                'title' => __('Pages Settings', THEMENAME),
                'icon' => 'el-icon-file',
                'fields' => array(
                    array(
			'id' => '_mp_page_layout',
			'type' => 'image_select',
			'title' => __('Page layout', THEMENAME),
			'subtitle' => __('Select main layout for pages.', THEMENAME),
			'options' => array(
			    'loop-page-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/post-layout-1.png'),
			    'loop-page-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/post-layout-2.png'),
			    'loop-page-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/post-layout-3.png'),
			    'loop-page-4' => array('alt' => 'Layout 4', 'img' => $redux_url.'/assets/img/post-layout-4.png'),
			    ),
			'default' => 'loop-page-1'
                    ),
		    array(
			'id' => '_mp_page_layout_image_height',
			'type' => 'switch',
			'title' => __('Show full image height', THEMENAME),
			'subtitle' => __('Fit only horizontally', THEMENAME),
			'required'  => array (
			    array('_mp_page_layout', "=", array('loop-page-1', 'loop-page-2') ),
			)
		    ),
		    array(
			'id' => '_mp_page_sidebar_position',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for pages.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
                    ),
		    array(
			'id' => '_mp_page_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_page_sidebar_position', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_page_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_page_sidebar_position', "!=", 'hide-sidebar'),
		    ),
		    array(
                        'id' => '_mp_pages_enable_breadcrumbs',
                        'type' => 'button_set',
                        'title' => __('Enable Breadcrumbs', THEMENAME),
                        'subtitle' => __('This option only affects <b>pages</b>.', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
                        'default' => 'disable',
                    ),
                )
            );


	    $this->sections[] = array(
                'title' => __('404 page', THEMENAME),
                'icon' => 'el-icon-remove-circle',
		'subsection' => true,
                'fields' => array(
                    array(
			'id' => '_mp_404page_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'hide-sidebar'
		    ),
		    array(
			'id' => '_mp_404page_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_404page_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_404page_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_404page_sidebar_template', "!=", 'hide-sidebar'),
		    ),
		    array(
			'id' => '_mp_404page_show_posts',
			'title' => __( 'Show latest posts', THEMENAME ),
			'subtitle' => __( 'Show latest posts below search', THEMENAME ),
			'type' => 'switch',
			'default' => '1',

		    ),
		    array(
			'id'=>'_mp_404page_posts_title',
			'type' => 'text',
			'title' => __('Latest posts title', THEMENAME),
			'default' => __('Our latest posts', THEMENAME),
			'required'  => array('_mp_404page_show_posts', "=", '1'),
		    ),
		    array(
			'id' => '_mp_404page_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-6',
			'required'  => array('_mp_404page_show_posts', "=", '1'),
		    ),
		    array(
			'id'=>'_mp_404page_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "6",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
			'required'  => array('_mp_404page_show_posts', "=", '1'),
		    ),

                )
            );


	    $this->sections[] = array(
                'title' => __('Archive page', THEMENAME),
                'icon' => 'el-icon-calendar-sign',
		'subsection' => true,
                'fields' => array(
                    array(
			'id' => '_mp_archivepage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_archivepage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_archivepage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_archivepage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_archivepage_sidebar_template', "!=", 'hide-sidebar'),
		    ),
		    array(
			'id' => '_mp_archivepage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),
            array(
			'id'=>'_mp_archivepage_title',
			'type' => 'text',
			'title' => __('News archive', THEMENAME),
			'default' => __('News archive', THEMENAME),
		    ),

                )
            );

	     $this->sections[] = array(
                'title' => __('Author page', THEMENAME),
		'icon' => 'el-icon-address-book-alt',
                'subsection' => true,
                'fields' => array(
                    array(
			'id' => '_mp_authorpage_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-1'
		    ),
		    array(
			'id' => '_mp_authorpage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_authorpage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_authorpage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_authorpage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_authorpage_sidebar_template', "!=", 'hide-sidebar'),
		    ),
            array(
                'id'=>'_mp_authorpage_title',
                'type' => 'text',
                'title' => __('Page Title', THEMENAME),
                "default" => "Author's Posts",
                'subtitle' => __('Title before author\'s posts', THEMENAME),
		    ),
		    array(
			'id'=>'_mp_authorpage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),
		    array(
			'id' => '_mp_authorpage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),
            array(
                'id' => '_mp_authorpage_show_author_actions',
                'type' => 'switch',
                'title' => __('Enable author\'s meta', THEMENAME),
                'subtitle' => __('No. of posts, comments and views', THEMENAME),
                'default' => '0',
		    ),

			array(
				'id'       => '_mp_authorpage_show_author_meta',
				'type'     => 'checkbox',
				'title' => __('Display author\'s meta', THEMENAME),
				'subtitle' => __('Select what you want to display', THEMENAME),
				'options'  => array(
					'posts' => 'Number of posts',
					'comments' => 'Number of  Comments',
					'views' => 'Number of Post Views'
				),
				'default' => array(
					'posts' => '0',
					'comments' => '0',
					'views' => '0'
				),
				'required'  => array('_mp_authorpage_show_author_actions', "=", '1'),
			),


		    array(
			'id' => '_mp_authorteampage_info',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'desc' => __('<strong>Team Of Authors Page</strong><br>Only if "Team Of Authors" is set as page template.', THEMENAME),
		    ),

            array(
                'id' => '_mp_authorteampage_template',
                'type' => 'image_select',
                'title' => __('Page layout', THEMENAME),
                'subtitle' => __('Select layout for authors.', THEMENAME),
                'options' => array(
                    'authorteampage-1' => array('alt' => 'Page layout 1', 'img' => $redux_url.'/assets/img/authorteampage-layout-1.png'),
                    'authorteampage-2' => array('alt' => 'Page layout 2', 'img' => $redux_url.'/assets/img/authorteampage-layout-2.png'),
                ),
                'default' => 'authorteampage-1'
		    ),

            array(
                'id' => '_mp_authorteampage_template_1_columns',
                'type' => 'button_set',
                'title' => __('No. of columns', THEMENAME),
                'subtitle' => __('Display authors info in columns', THEMENAME),
                'options'   => array(
                    '2' => '2',
                    '3' => '3',
                    '4' => '4'
                ),
                'default' => '3',
                'required'  => array('_mp_authorteampage_template', "=", 'authorteampage-1'),
		    ),

            array(
                'id' => '_mp_authorteampage_template_2_columns',
                'type' => 'button_set',
                'title' => __('No. of columns', THEMENAME),
                'subtitle' => __('Display authors info in columns', THEMENAME),
                'options'   => array(
                    '1' => '1',
                    '2' => '2'
                ),
                'default' => '1',
                'required'  => array('_mp_authorteampage_template', "=", 'authorteampage-2'),
		    ),

			array(
				'id'=>'_mp_authorteampage_authors_per_page',
				'type' => 'slider',
				'title' => __('Authors per page', THEMENAME),
				'subtitle' => __('Number of authors per page', THEMENAME),
				"default" => "0",
				"min" 	=> "0",
				"step"	=> "1",
				"max" 	=> "100",
				'desc' => __('0 for displaying all authors', THEMENAME),
		    ),

			array(
                'id' => '_mp_authorteampage_authors_orderby',
                'type' => 'select',
                'title' => __('Order by', THEMENAME),
                'subtitle' => __('Order Authors by', THEMENAME),
                'options'   => array(
                    'ID' => 'ID',
                    'display_name' => 'User display name',
                    'user_name' => 'User name',
					'user_email' => 'User email',
                    'url' => 'User url',
                    'post_count' => 'User post count',
                    'post_views' => 'User post views',
                ),
                'default' => 'post_count',
		    ),

			array(
                'id' => '_mp_authorteampage_authors_order',
                'type' => 'select',
                'title' => __('Order', THEMENAME),
                'subtitle' => __('Ascending or descending', THEMENAME),
                'options'   => array(
                    'ASC' => 'Ascending',
                    'DESC' => 'Descending',
                ),
                'default' => 'DESC',
		    ),

            array(
                'id' => '_mp_authorteampage_show_author_actions',
                'type' => 'switch',
                'title' => __('Display author\'s meta', THEMENAME),
                'subtitle' => __('No. of posts, comments and views', THEMENAME),
                'default' => '0',
		    ),

			array(
                'id' => '_mp_authorteampage_authors_roles',
                'type' => 'select',
                'title' => __('Include Authors Roles', THEMENAME),
                'subtitle' => __('Select one or more', THEMENAME),
				'multi'	=> true,
                'options'   => array(
                    'Administrator' => 'Administrator',
                    'Editor' => 'Editor',
					'Author' => 'Author',
                    'Contributor' => 'Contributor',
					'Subscriber' => 'Subscriber',
                ),
                'default' => 'Author',
		    ),

		    array(
                'id' => '_mp_authorteampage_exclude',
                'type' => 'text',
                'title' => __('Exclude Authors', THEMENAME),
                'subtitle' => __('Don\'t display these authors', THEMENAME),
                'description' => __('List of authots id, separated by commas (e.g. 2,3,5).', THEMENAME),
            ),

                )
            );

	    $this->sections[] = array(
                'title' => __('Search page', THEMENAME),
                'icon' => 'el-icon-search',
		'subsection' => true,
                'fields' => array(
		    array(
			'id' => '_mp_searchpage_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-2'
		    ),
                    array(
			'id' => '_mp_searchpage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_searchpage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_searchpage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_searchpage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_searchpage_sidebar_template', "!=", 'hide-sidebar'),
		    ),
		    array(
			'id' => '_mp_searchpage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),
		    array(
			'id' => '_mp_searchpage_advanced',
			'type' => 'button_set',
			'title' => __('Enable Advanced Search', THEMENAME),
			'options'   => array(
			    'search-advanced' => 'Enable',
			    'search-basic' => 'Disable'
			),
			'default' => 'search-basic',
		    ),
		    array(
			'id' => '_mp_searchpage_exclude_pages',
			'type' => 'button_set',
			'title' => __('Exclude Pages in results', THEMENAME),
			'options'   => array(
			    '1' => 'Exclude',
			    '0' => 'Don\'t exclude'
			),
			'default' => '1',
		    ),

		    array(
			'id'=>'_mp_searchpage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),

                )
            );


	    $this->sections[] = array(
                'title' => __('Tag page', THEMENAME),
                'icon' => 'el-icon-tags',
		'subsection' => true,
                'fields' => array(
		    array(
			'id' => '_mp_tagpage_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-2'
		    ),
                    array(
			'id' => '_mp_tagpage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_tagpage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_tagpage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_tagpage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_tagpage_sidebar_template', "!=", 'hide-sidebar'),
		    ),
		    array(
			'id' => '_mp_tagpage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),

		    array(
			'id'=>'_mp_tagpage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),

                )
            );


        /*$this->sections[] = array(
                'title' => __('Gallery page', THEMENAME),
                'icon' => 'el-icon-picture',
		'subsection' => true,
                'fields' => array(
		    array(
			'id' => '_mp_gallerypage_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-2'
		    ),
                    array(
			'id' => '_mp_gallerypage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_gallerypage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_gallerypage_sidebar_template', "=", 'multi-sidebar'),
		    ),
		    array(
			'id' => '_mp_gallerypage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
		    ),
		    array(
			'id' => '_mp_gallerypage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),

		    array(
			'id'=>'_mp_gallerypage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),

                )
            );


        $this->sections[] = array(
                'title' => __('Video page', THEMENAME),
                'icon' => 'el-icon-video',
		'subsection' => true,
                'fields' => array(
		    array(
			'id' => '_mp_videopage_template',
			'type' => 'image_select',
			'title' => __('Posts layout', THEMENAME),
			'subtitle' => __('Select layout for posts.', THEMENAME),
			'options' => array(
			    'loop-cat-1' => array('alt' => 'Category layout 1', 'img' => $redux_url.'/assets/img/cat-layout-1.png'),
			    'loop-cat-2' => array('alt' => 'Category layout 2', 'img' => $redux_url.'/assets/img/cat-layout-2.png'),
			    'loop-cat-3' => array('alt' => 'Category layout 3', 'img' => $redux_url.'/assets/img/cat-layout-3.png'),
			    'loop-cat-4' => array('alt' => 'Category layout 4', 'img' => $redux_url.'/assets/img/cat-layout-4.png'),
			    'loop-cat-5' => array('alt' => 'Category layout 5', 'img' => $redux_url.'/assets/img/cat-layout-5.png'),
			    'loop-cat-6' => array('alt' => 'Category layout 6', 'img' => $redux_url.'/assets/img/cat-layout-6.png'),
			),
			'default' => 'loop-cat-2'
		    ),
                    array(
			'id' => '_mp_videopage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_videopage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_videopage_sidebar_template', "=", 'multi-sidebar'),
		    ),
		    array(
			'id' => '_mp_videopage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
		    ),
		    array(
			'id' => '_mp_videopage_pagination',
			'type' => 'button_set',
			'title' => __('Pagination template', THEMENAME),
			'subtitle' => __('Choose template for pagination.', THEMENAME),
			'options'   => array(
			    'post-pagination-1' => 'Pager with numbers',
			    'post-pagination-2' => 'Prev/next pager'
			),
			'default' => 'post-pagination-1',
		    ),

		    array(
			'id'=>'_mp_videopage_posts_number',
			'type' => 'slider',
			'title' => __('Posts per page', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "50",
			'desc' => __('0 for using default wordpress settings', THEMENAME),
		    ),

                )
            );*/


	    $this->sections[] = array(
                'title' => __('bbPress page', THEMENAME),
                'icon' => 'el-icon-comment-alt',
		'subsection' => true,
                'fields' => array(
                    array(
			'id' => '_mp_bbpresspage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_bbpresspage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_bbpresspage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_bbpresspage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_bbpresspage_sidebar_template', "!=", 'hide-sidebar'),
		    ),

                )
            );


	    $this->sections[] = array(
                'title' => __('WooCommerce page', THEMENAME),
                'icon' => 'el-icon-shopping-cart',
		'subsection' => true,
                'fields' => array(
                    array(
			'id' => '_mp_woocommercepage_sidebar_template',
			'type' => 'image_select',
			'title' => __('Sidebar position', THEMENAME),
			'subtitle' => __('Select main sidebar position for posts.', THEMENAME),
			'options' => array(
			    'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
			    'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
			    'multi-sidebar' => array('alt' => 'Multi Column Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
				'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
			    'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
			    ),
			'default' => 'right-sidebar'
		    ),
		    array(
			'id' => '_mp_woocommercepage_sidebar_source_middle',
			'title' => __( 'Choose default middle sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for middle column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_woocommercepage_sidebar_template', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
		    ),
		    array(
			'id' => '_mp_woocommercepage_sidebar_source',
			'title' => __( 'Choose default sidebar', THEMENAME ),
			'subtitle' => __( 'Sidebar for left/right column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on this page.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_woocommercepage_sidebar_template', "!=", 'hide-sidebar'),
		    ),

                )
            );


	    /* Post settings */
            $this->sections[] = array(
                'title' => __('NewsScroller Settings', THEMENAME),
		'desc' => __('Set default values for news scroller', THEMENAME),
                'icon' => 'el-icon-indent-left',
                'fields' => array(
		    array(
			'id' => '_mp_breakingnews_enable',
			'type' => 'switch',
			'title' => __('Enable News Scroller', THEMENAME),
			'default' => '0',
		    ),
		    array(
			'id' => '_mp_breakingnews_title',
			'type' => 'text',
			'title' => __('News Scroller Title', THEMENAME),
			'default' => 'Breaking News',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_title_link',
			'type' => 'text',
			'title' => __('News Scroller Title Link', THEMENAME),
			'default' => '',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_title_background',
			'type' => 'color',
			'title' => __('News Scroller Title Background', THEMENAME),
			'default' => '',
			'default'  => '#de5b47',
			'transparent'  => false,
			'validate' => 'color',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_filter_cats',
			'type' => 'select',
			'data'      => 'categories',
			'multi'     => true,
			'sortable'   => true,
			'title' => __('Filter by categories', THEMENAME),
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_filter_tags',
			'type' => 'select',
			'data'      => 'tags',
			'multi'     => true,
			'sortable'   => true,
			'title' => __('Filter by tag slug', THEMENAME),
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		     array(
			'id'=>'_mp_breakingnews_posts_count',
			'type' => 'slider',
			'title' => __('Posts count', THEMENAME),
			"default" => "0",
			"min" 	=> "0",
			"step"	=> "1",
			"max" 	=> "20",
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_date_enable',
			'type' => 'switch',
			'title' => __('Display date', THEMENAME),
			'default' => '1',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_cat_enable',
			'type' => 'switch',
			'title' => __('Display category', THEMENAME),
			'default' => '1',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		    array(
			'id' => '_mp_breakingnews_cat_display',
			'type' => 'button_set',
			'title' => __('Display Category labels as', THEMENAME),
			'options'   => array(
			    'root' => 'Root Categories',
			    'sub' => 'Sub Categories'
			),
			'default' => 'root',
			'required'  => array('_mp_breakingnews_enable', "equals", 1)
		    ),
		),
	    );


	    $this->sections[] = array(
                'title'     => __('Sidebars', THEMENAME),
                'icon'      => 'el-icon-retweet',
                //'subsection' => true,
                'fields'    => array(
		     array(
                        'id'        => '_mp_sidebars',
                        'type'      => 'multi_text',
                        'title'     => __('My Sidebars', THEMENAME),
                        'subtitle'  => __('Add/remove your sidebars', THEMENAME),
			'add_text'  => __('Add sidebar', THEMENAME),
			'default'   => array( 'Primary Widget Area', 'Secondary Widget Area' ),
                    ),
		    array(
			'id' => '_mp_sidebars_enable_sticky',
			'type' => 'button_set',
			'title' => __('Enable sticky sidebars', THEMENAME),
			'subtitle'  => __('Set sidebars to be sticky', THEMENAME),
			'options'   => array(
			    'disable' => 'No Sticky Sidebars',
			    '#sidebar-mid' => 'Middle Sidebar',
			    '#sidebar' => 'Right Sidebar',
			    '#sidebar-mid, #sidebar' => 'All Sidebars',
			),
			'default' => 'disable',
		    ),

                )
            );


	    $this->sections[] = array(
                'title'     => __('Footer Settings', THEMENAME),
                'icon'      => 'el-icon-arrow-down',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
		    array(
			'id' => '_mp_enable_footer_widgets',
			'type' => 'button_set',
			'title' => __('Enable widgetized area', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
			'default' => 'disable',
		    ),
		    array(
			'id' => '_mp_footer_layout',
			'type' => 'image_select',
			'title' => __('Area layout', THEMENAME),
			'subtitle' => __('Select footer layout.', THEMENAME),
			'options' => array(
			    'footer-default' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/footer-layout-default.png'),
			    'footer-layout-1' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/footer-layout-1.png'),
			    'footer-layout-2' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/footer-layout-2.png'),
			    'footer-layout-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/footer-layout-3.png'),
			    ),
			'default' => 'footer-default',
			'required'  => array('_mp_enable_footer_widgets', "=", 'enable'),
                    ),
		    array(
			'id' => '_mp_footer_column_1_source',
			'title' => __( 'Choose sidebar for first column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on first column.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array(
			    array('_mp_footer_layout', "=", array( 'footer-default', 'footer-layout-1', 'footer-layout-2', 'footer-layout-3' )),
			    array('_mp_enable_footer_widgets', "=", 'enable'),
			),
                    ),
		    array(
			'id' => '_mp_footer_column_2_source',
			'title' => __( 'Choose sidebar for second column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on second column.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_footer_layout', "=", array( 'footer-default', 'footer-layout-1', 'footer-layout-2', 'footer-layout-3' )),
                    ),
		    array(
			'id' => '_mp_footer_column_3_source',
			'title' => __( 'Choose sidebar for third column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on third column.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_footer_layout', "=", array( 'footer-default', 'footer-layout-2', 'footer-layout-3' )),
                    ),
		    array(
			'id' => '_mp_footer_column_4_source',
			'title' => __( 'Choose sidebar for fourth column', THEMENAME ),
			'desc' => 'Please select the sidebar you would like to display on fourth column.',
			'type' => 'select',
			'data' => 'sidebars',
			'default' => 'None',
			'required'  => array('_mp_footer_layout', "=", array( 'footer-layout-3' )),
                    ),

		    array(
			'id' => '_mp_enable_footer_copy',
			'type' => 'button_set',
			'title' => __('Enable copyright section', THEMENAME),
			'options'   => array(
			    'enable' => 'Enable',
			    'disable' => 'Disable'
			),
			'default' => 'enable',
		    ),
		    array(
			'id' => '_mp_enable_footer_copy_text',
			'title' => __( 'Copyright Text', THEMENAME ),
			'type' => 'text',
			'default' => '&copy; <a href="#">Weekly News</a> 2014. All rights reserved.',
			'required'  => array('_mp_enable_footer_copy', "=", 'enable'),
                    ),
		    array(
			'id' => '_mp_enable_footer_copy_author_text',
			'title' => __( 'Author Text', THEMENAME ),
			'type' => 'text',
			'default' => 'Produced by <a href="http://themes.mipdesign.com">Mip Themes</a>',
			'required'  => array('_mp_enable_footer_copy', "=", 'enable'),
                    ),
                )
            );


	    $this->sections[] = array(
                'title'     => __('Typography', THEMENAME),
                'icon'      => 'el-icon-text-width',
                //'subsection' => true,
                'fields'    => array(
		    array(
			'id'       => '_mp_typ_subsets',
			'type'     => 'select',
			'title'    => __('Select the character set', THEMENAME),
			'subtitle' => __('This include default theme font only', THEMENAME),
			'options'  => array(
			    'latin' 		=> 'Latin',
			    'latin,latin-ext' 	=> 'Latin Extended',
			    'greek' 		=> 'Greek',
			    'greek,greek-ext' 	=> 'Greek Extended',
			    'cyrillic' 		=> 'Cyrillic',
			    'cyrillic,cyrillic-ext' => 'Cyrillic Extended',
			    'vietnamese' 		=> 'Vietnamese',
			),
			'default'  => 'latin',
		    ),
		    array(
                        'id'        => '_mp_typ_body_font',
                        'type'      => 'typography',
                        'title'     => __('Body Font', THEMENAME),
                        'subtitle'  => __('Specify the body font properties.', THEMENAME),
                        'google'    => true,
			'font-weight'   => false,
			'text-align'   => false,
			'compiler'    => array('body'),
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#5c5c5c',
                            'font-size'     => '14px',
			    'line-height'   => '18px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '400',
                        ),
                    ),

		    array(
                        'id'        => '_mp_type_info_nav',
                        'type'      => 'info',
                        'title'     => __('Navigation Fonts', THEMENAME),
                        'desc'  => __('Typography for header and footer navigation', THEMENAME),
                        'style'    => 'success',
			'notice'   => true,
                    ),

		    array(
                        'id'        => '_mp_typ_top_navigation',
                        'type'      => 'typography',
                        'title'     => __('Top Navigation', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#top-navigation ul li a'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			'line-height' => false,
			'text-transform' => true,
			'color'         => false,
                        'default'   => array(
                            'color'         => '#bcbcbc',
                            'font-size'     => '12px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '400',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_top_navigation_link',
                        'type'      => 'link_color',
                        'title'     => __('Top Navigation Link', THEMENAME),
                        'subtitle'  => __('Specify the link properties', THEMENAME),
			'compiler'    => array('#top-navigation ul li a', '#top-navigation ul ul li a'),
			'active'   => false,
			'visited'  => false,
                        'default'  => array(
			    'regular'  => '#bbbbbb',
			    'hover'    => '#ffffff',
			)
                    ),

		    array(
                        'id'        => '_mp_typ_header_navigation',
                        'type'      => 'typography',
                        'title'     => __('Header Navigation', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#header-navigation ul li a'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			'line-height' => false,
			'text-transform' => true,
			'color'         => false,
                        'default'   => array(
                            'color'         => '#fff',
                            'font-size'     => '14px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '700',
			    'text-transform' => 'uppercase',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_header_navigation_link',
                        'type'      => 'link_color',
                        'title'     => __('Header Navigation Link', THEMENAME),
                        'subtitle'  => __('Specify the link properties', THEMENAME),
			'compiler'    => array('#header-navigation ul li a', '#header-navigation ul ul li a'),
			'active'   => false,
			'visited'  => false,
                        'default'  => array(
			    'regular'  => '#ffffff',
			    'hover'    => '#ffffff',
			)
                    ),

		    array(
                        'id'        => '_mp_typ_header_quicklinks',
                        'type'      => 'typography',
                        'title'     => __('Quicklinks Navigation', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#header-quicklinks ul li a'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			'line-height' => false,
			'text-transform' => true,
			'color'         => false,
                        'default'   => array(
                            'color'         => '#fff',
                            'font-size'     => '14px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '400',
			    'text-transform' => 'none',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_header_quicklinks_link',
                        'type'      => 'link_color',
                        'title'     => __('Quicklinks Navigation Link', THEMENAME),
                        'subtitle'  => __('Specify the link properties', THEMENAME),
			'compiler'    => array('#header-quicklinks nav ul li a'),
			'active'   => false,
			'visited'  => false,
                        'default'  => array(
			    'regular'  => '#5c5c5c',
			    'hover'    => '#222',
			)
                    ),

		    array(
                        'id'        => '_mp_typ_header_quicklinks_background',
                        'type'      => 'background',
                        'title'     => __('Quicklinks Navigation Background', THEMENAME),
                        'subtitle'  => __('Specify the background color', THEMENAME),
			'compiler'    => array('#header-quicklinks.full-width', '#header-quicklinks nav'),
			'background-repeat' => false,
			'background-attachment'   => false,
			'background-position'     => false,
			'background-image' => false,
			'background-size' => false,
			'transparent'   => false,
			'preview'   => false,
			'default'  => array(
			    'background-color' => '#f3f3f3',
			)
                    ),

		    array(
                        'id'        => '_mp_typ_footer_navigation',
                        'type'      => 'typography',
                        'title'     => __('Footer Navigation', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#foot-menu ul li a'),
			//'compiler'    => 'true',
			'units'     =>'px',
			'text-align'   => false,
			'line-height' => false,
			'text-transform' => true,
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '14px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '700',
			    'text-transform' => 'uppercase',
                        ),
                    ),

			array(
                        'id'        => '_mp_type_info_top_slider',
                        'type'      => 'info',
                        'title'     => __('Top Slider Settings', THEMENAME),
                        'desc'  => __('H2 and H3 Headings for top slider', THEMENAME),
                        'style'    => 'success',
			'notice'   => true,
                    ),

			array(
                        'id'        => '_mp_typ_page_slider_title_font',
                        'type'      => 'typography',
                        'title'     => __('Top Slider Headings', THEMENAME),
                        'subtitle'  => __('Specify top slider headings font properties.', THEMENAME),
                        'google'    => true,
						'text-align'   => false,
						'compiler'    => array('#page-slider article.linkbox h2', '#page-slider article.linkbox h3'),
						 'color'         => false,
						'font-size'     => false,
						'font-weight'     => false,
						'line-height'   => false,
						'units'     =>'px',
                        'default'   => array(
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
							'google'    => true,
                        ),
                    ),

			array(
                        'id'        => '_mp_typ_page_slider_title_h2',
                        'type'      => 'typography',
                        'title'     => __('Top Slider Heading H2', THEMENAME),
                        'subtitle'  => __('Specify the article title font properties.', THEMENAME),
                        'google'    => false,
						'text-align'   => false,
						'compiler'    => array('#page-slider article.linkbox h2'),
						'font-family'   => false,
						//'compiler'    => 'true',
						'units'     =>'px',
                        'default'   => array(
                            'color'         => '#fff',
                            'font-size'     => '30px',
							'line-height'   => '36px',
                            'font-weight'   => '400',
                        ),
                    ),

			array(
                        'id'        => '_mp_typ_page_slider_title_h3',
                        'type'      => 'typography',
                        'title'     => __('Top Slider Heading H3', THEMENAME),
                        'subtitle'  => __('Specify the article title font properties.', THEMENAME),
                        'google'    => false,
						'text-align'   => false,
						'compiler'    => array('#page-slider article.linkbox h3'),
						'font-family'   => false,
						'preview'   => false,
						//'compiler'    => 'true',
						'units'     =>'px',
                        'default'   => array(
                            'color'         => '#fff',
                            'font-size'     => '15px',
							'line-height'   => '18px',
                            'font-weight'   => '700',
                        ),
                    ),

		    array(
                        'id'        => '_mp_type_info_article',
                        'type'      => 'info',
                        'title'     => __('Post Settings', THEMENAME),
                        'desc'  => __('Entry Headings and links in posts and pages.', THEMENAME),
                        'style'    => 'success',
			'notice'   => true,
                    ),

		    array(
                        'id'        => '_mp_typ_article_title_font',
                        'type'      => 'typography',
                        'title'     => __('Article Title Font', THEMENAME),
                        'subtitle'  => __('Specify the article title font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post header h1', '.head-image .overlay h1'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '30px',
			    'line-height'   => '36px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_article_h1_font',
                        'type'      => 'typography',
                        'title'     => __('Article Heading H1', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post h1'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '30px',
			    'line-height'   => '36px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_article_h2_font',
                        'type'      => 'typography',
                        'title'     => __('Article Heading H2', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post h2'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '24px',
			    'line-height'   => '30px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_article_h3_font',
                        'type'      => 'typography',
                        'title'     => __('Article Heading H3', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post h3'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '22px',
			    'line-height'   => '26px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),

		    /*array(
                        'id'        => '_mp_typ_article_h4_font',
                        'type'      => 'typography',
                        'title'     => __('Article Heading H4', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post h4'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '18px',
			    'line-height'   => '24px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_article_h5_font',
                        'type'      => 'typography',
                        'title'     => __('Article Heading H5', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'text-align'   => false,
			'compiler'    => array('.article-post h5'),
			//'compiler'    => 'true',
			'units'     =>'px',
                        'default'   => array(
                            'color'         => '#222',
                            'font-size'     => '16px',
			    'line-height'   => '20px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => 'Normal',
                        ),
                    ),*/


            array(
                        'id'        => '_mp_typ_content_linka',
                        'type'      => 'link_color',
                        'title'     => __('Posts Content Navigation Link', THEMENAME),
                        'subtitle'  => __('Specify the link properties', THEMENAME),
			'compiler'    => array('.article-post-content a'),
			'active'   => false,
			'visited'  => false,
                        'default'  => array(
			    'regular'  => '#222',
			    'hover'    => '#000',
			)
                    ),


		    array(
                        'id'        => '_mp_type_info_section_titles',
                        'type'      => 'info',
                        'title'     => __('Section Titles', THEMENAME),
                        'desc'  => __('Typography for section titles', THEMENAME),
                        'style'    => 'success',
			'notice'   => true,
                    ),

		    array(
                        'id'        => '_mp_typ_section_titles',
                        'type'      => 'typography',
                        'title'     => __('Main Content Section Titles', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#page-content header h2'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			//'line-height' => false,
			'text-transform' => true,
                        'default'   => array(
                            'color'         => '#444444',
                            'font-size'     => '17px',
			    'line-height'   => '17px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => '400',
			    'text-transform' => 'uppercase',
                        ),
                    ),

		    array(
			'id'       => '_mp_typ_section_titles_border',
			'type'     => 'border',
			'title'    => __('Main Content Title Border', THEMENAME),
			'compiler'    => array('#page-content header h2'),
			'output'    => array('#page-content header h2'),
			'all'  => false,
			'style'  => false,
			'top'    => false,
			'right'  => false,
			'bottom' => false,
			'left'   => false,
			'default'  => array(
			    'border-color'  => '#f5f5f5',
			)
		    ),

		    array(
			'id'       => '_mp_typ_section_titles_border_short',
			'type'     => 'border',
			'title'    => __('Main Content Title Border Short', THEMENAME),
			'compiler'    => array('#page-content header span.borderline'),
			'all'  => false,
			'style'  => false,
			'top'    => false,
			'right'  => false,
			'bottom' => false,
			'left'   => false,
			'default'  => array(
			    'border-color'  => '#222',
			)
		    ),

		    array(
                        'id'        => '_mp_typ_section_titles_sidebar',
                        'type'      => 'typography',
                        'title'     => __('Sidebar Section Titles', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('#page-content .sidebar header h2'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			//'line-height' => false,
			'text-transform' => true,
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '17px',
			    'line-height'   => '17px',
                            'font-family'   => 'Roboto Condensed',
                            'font-weight'   => '400',
			    'text-transform' => 'uppercase',
                        ),
                    ),

		    array(
			'id'       => '_mp_typ_section_titles_sidebar_border',
			'type'     => 'border',
			'title'    => __('Sidebar Title Border', THEMENAME),
			'compiler'    => array('#sidebar header h2'),
			'all'  => false,
			'style'  => false,
			'top'    => false,
			'right'  => false,
			'bottom' => false,
			'left'   => false,
			'default'  => array(
			    'border-color'  => '#4e4e4e',
			)
		    ),

		    array(
			'id'       => '_mp_typ_section_titles_sidebar_border_short',
			'type'     => 'border',
			'title'    => __('Sidebar Title Border Short', THEMENAME),
			'compiler'    => array('#sidebar header span.borderline'),
			'all'  => false,
			'style'  => false,
			'top'    => false,
			'right'  => false,
			'bottom' => false,
			'left'   => false,
			'default'  => array(
			    'border-color'  => '#fff',
			)
		    ),

		    array(
                        'id'        => '_mp_type_info_author',
                        'type'      => 'info',
                        'title'     => __('Author Box', THEMENAME),
                        'desc'  => __('Typography for author box', THEMENAME),
                        'style'    => 'success',
			'notice'   => true,
                    ),

		    array(
                        'id'        => '_mp_typ_author_name',
                        'type'      => 'typography',
                        'title'     => __('Author Title', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('.article-post footer .author-box p.name a'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			//'line-height' => false,
			'text-transform' => true,
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '20px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '400',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_author_desc',
                        'type'      => 'typography',
                        'title'     => __('Author Description', THEMENAME),
                        'subtitle'  => __('Specify the font properties.', THEMENAME),
                        'google'    => true,
			'compiler'    => array('.article-post footer .author-box p'),
			//'compiler'    => 'true',
			'text-align'   => false,
			'units'     =>'px',
			//'line-height' => false,
			'text-transform' => true,
                        'default'   => array(
                            'color'         => '#5c5c5c',
                            'font-size'     => '14px',
                            'font-family'   => 'Roboto',
                            'font-weight'   => '400',
			    'line-height' => '24px',
                        ),
                    ),

		    array(
                        'id'        => '_mp_typ_author_social_links',
                        'type'      => 'color',
                        'title'     => __('Author Social Links', THEMENAME),
                        'subtitle'  => __('Specify color properties.', THEMENAME),
			'compiler'    => array('.article-post footer .author-box p a'),
			'default'  => '#bbbbbb',
                    ),


                )
            );



	    /* Ad management */

            $this->sections[] = array(
                'title' => __('Ads System', THEMENAME),
		'desc' => __('You must first create ads in "Ads System"', THEMENAME),
                'icon' => 'el-icon-network',
                'fields' => array(

                )
            );

	    $this->sections[] = array(
                'title' => __('Ads for homepage', THEMENAME),
		'subsection' => true,
                'fields' => array(
                    array(
                        'id' 	=> '_mp_ads_home_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_home_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_home_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_home_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

                )
            );

	    $this->sections[] = array(
                'title' => __('Ads for pages', THEMENAME),
		'subsection' => true,
                'fields' => array(
		    array(
			'id'   => '_mp_info_ads_posts',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for Posts', THEMENAME),
		    ),
                    array(
                        'id' 	=> '_mp_ads_posts_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id' 	=> '_mp_ads_posts_section_1',
			'type' 	=> 'select',
			'title' => __('Post Ad 1', THEMENAME),
			'subtitle' => __('Before the post', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
		    ),
		    array(
			'id' 	=> '_mp_ads_posts_section_2',
			'type' 	=> 'select',
			'title' => __('Post Ad 2', THEMENAME),
			'subtitle' => __('Before post content (after image)', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
		    ),
		    array(
			'id' 	=> '_mp_ads_posts_section_3',
			'type' 	=> 'select',
			'title' => __('Post Ad 3', THEMENAME),
			'subtitle' => __('After the post', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
		    ),

		    array(
                        'id' 	=> '_mp_ads_posts_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),

		    array(
                        'id' 	=> '_mp_ads_posts_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_posts_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id'   => '_mp_info_ads_pages',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for Pages', THEMENAME),
		    ),
		    array(
                        'id' 	=> '_mp_ads_page_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_page_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_page_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_page_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id'   => '_mp_info_ads_author',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for Author Page', THEMENAME),
		    ),
		    array(
                        'id' 	=> '_mp_ads_author_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_author_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_author_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_author_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id'   => '_mp_info_ads_archive',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for Archive Page', THEMENAME),
		    ),
		    array(
                        'id' 	=> '_mp_ads_archive_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_archive_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_archive_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_archive_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id'   => '_mp_info_ads_bbPress',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for bbPress Page', THEMENAME),
		    ),
		    array(
                        'id' 	=> '_mp_ads_bbpress_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_bbpress_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_bbpress_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_bbpress_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

		    array(
			'id'   => '_mp_info_ads_woocommerce',
			'type' => 'info',
			'notice' => true,
			'style' => 'success',
			'title' => __('Ads for WooCommerce Page', THEMENAME),
		    ),
		    array(
                        'id' 	=> '_mp_ads_woocommerce_top',
                        'type' 	=> 'select',
                        'title' => __('Top Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_woocommerce_wall',
                        'type' 	=> 'select',
                        'title' => __('Wallpaper Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_woocommerce_side_left',
                        'type' 	=> 'select',
                        'title' => __('Left Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),
		    array(
                        'id' 	=> '_mp_ads_woocommerce_side_right',
                        'type' 	=> 'select',
                        'title' => __('Right Side Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    ),

                )
            );


	    $this->sections[] = array(
                'title' => __('Ads for categories', THEMENAME),
		'subsection' => true,
                'fields' => $banner_cats
            );


		$this->sections[] = array(
                'title' => __('Ads for mobile', THEMENAME),
		'subsection' => true,
                'fields' => array(
                    array(
                        'id' 	=> '_mp_ads_mobile_header',
                        'type' 	=> 'select',
                        'title' => __('Header Ad', THEMENAME),
			'data'  => 'posts',
			'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'mobile-display', 'posts_per_page' => -1 ),
                    ),

                )
            );

            /* Advanced Settings */

            $this->sections[] = array(
                'title' => __('Advanced Settings', THEMENAME),
                'icon' => 'el-icon-cog',
                'fields' => array(
        		    array(
            			'id' => '_mp_page_title_simple',
            			'title' => __( 'Simple Page title', THEMENAME ),
            			'desc' => __('Enable this if you have problem with page titles.', THEMENAME),
            			'type' => 'switch',
            			'default' => false,
        		    ),
                    array(
            			'id' => '_mp_page_open_graph_image',
            			'title' => __( 'Enable Open Graph Featured image', THEMENAME ),
            			'desc' => __('Enable this if you don\'t have any SEO plugins installed.', THEMENAME),
            			'type' => 'switch',
            			'default' => false,
        		    ),
                    array(
            			'id' => '_mp_minify_css_js',
            			'title' => __( 'Use minified CSS and JS files', THEMENAME ),
            			'desc' => __('Enable this if you don\'t have any minify plugins installed.', THEMENAME),
            			'type' => 'switch',
            			'default' => true,
        		    ),
                    array(
            			'id' => '_mp_disable_emoji_icons',
            			'title' => __( 'Disable Emoji', THEMENAME ),
            			'desc' => __('Disable this if you don\'t need them (Wordpress default install).', THEMENAME),
            			'type' => 'switch',
            			'default' => false,
        		    ),
                    array(
                        'id' => '_mp_ga_code',
                        'type' => 'ace_editor',
                        'title' => __('Google Analytics Code', THEMENAME),
                        'desc' => __('Here you can paste your Google Analytics code (not your id). If you don\'t have it or you are already using one, just leave blank. Don\'t use <b>&lt;script&gt;</b> tags.', THEMENAME),
			'mode' => 'javascript',
                        'theme' => 'chrome'
                    ),
                    array(
                        'id' => '_mp_css_code',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS Code', THEMENAME),
                        'desc' => __('e.g. #header{ background: #000; }<br> Don\'t use <b>&lt;style&gt;</b> tags', THEMENAME),
                        'subtitle' => __('Paste your CSS code here.', THEMENAME),
                        'mode' => 'css',
			'compiler'	=> true,
                        'theme' => 'chrome',
			'default'  => '',
                    ),
                    array(
                        'id' => '_mp_js_code_header',
                        'type' => 'ace_editor',
                        'title' => __('Custom JS Code (Header)', THEMENAME),
                        'desc' => __('e.g. alert("Hello World!");<br> Don\'t use <b>&lt;script&gt;</b> tags or <strong>document.ready</strong>', THEMENAME),
                        'subtitle' => __('Paste your JS code here.', THEMENAME),
                        'mode' => 'javascript',
                        'theme' => 'chrome'
                    ),
		    array(
                        'id' => '_mp_js_code',
                        'type' => 'ace_editor',
                        'title' => __('Custom JS Code (Footer)', THEMENAME),
                        'desc' => __('e.g. alert("Hello World!");<br> Don\'t use <b>&lt;script&gt;</b> tags or <strong>document.ready</strong>', THEMENAME),
                        'subtitle' => __('Paste your JS code here.', THEMENAME),
                        'mode' => 'javascript',
                        'theme' => 'chrome'
                    ),
		    array(
			'id' => '_mp_js_jquery_footer',
			'title' => __( 'Register jQuery in footer', THEMENAME ),
			'desc' => __('Disable this if you have problems with other plugins!', THEMENAME),
			'type' => 'switch',
			'default' => '0',
		    ),
			array(
			'id'=>'_mp_js_ajaxpagination_timer',
			'type' => 'slider',
			'title' => __('Ajax Pagination Timer', THEMENAME),
			'desc' => __('Use higher settings if pagination is overlapping!', THEMENAME),
			"default" => "1000",
			"min" 	=> "1000",
			"step"	=> "100",
			"max" 	=> "3000",
		    ),
                )
            );


	    /* Advanced Settings - Datetime */

	    $this->sections[] = array(
                'title' => __('Datetime Settings', THEMENAME),
		'desc' => __('Please, check this tutorial on <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">how to format Date and Time</a>', THEMENAME),
                'icon' => 'el-icon-calendar-sign',
		'subsection' => true,
                'fields' => array(




                    array(
                        'id' => '_mp_dateformat_default',
                        'type' => 'text',
                        'title' => __('Default date format', THEMENAME),
			'subtitle' => __('Main content and posts', THEMENAME),
                        'desc' => __('(e.g.: November 6th, 2014)', THEMENAME),
			'default' => 'F jS, Y',
                    ),
		    array(
                        'id' => '_mp_short_dateformat_default',
                        'type' => 'text',
                        'title' => __('Default short date format', THEMENAME),
			'subtitle' => __('Image layouts', THEMENAME),
                        'desc' => __('(e.g.: Nov 6th, 2014)', THEMENAME),
			'default' => 'M jS, Y',
                    ),
		    array(
                        'id' => '_mp_timeformat_default',
                        'type' => 'text',
                        'title' => __('Default time format', THEMENAME),
			'subtitle' => __('Main content and posts', THEMENAME),
                        'desc' => __('(e.g.: 12:50 AM)', THEMENAME),
			'default' => 'g:i A',
                    ),
		    array(
                        'id' => '_mp_dateformat_header',
                        'type' => 'text',
                        'title' => __('Header date format', THEMENAME),
			'subtitle' => __('Header widget', THEMENAME),
                        'desc' => __('(e.g.: November 6th, 2014)', THEMENAME),
			'default' => 'F jS, Y',
                    ),
		    array(
                        'id' => '_mp_dateformat_sidebar',
                        'type' => 'text',
                        'title' => __('Sidebar date format', THEMENAME),
			'subtitle' => __('Shorter date to fit', THEMENAME),
                        'desc' => __('(e.g.: Nov 6th, 2014)', THEMENAME),
			'default' => 'M jS, Y',
                    ),
		    array(
                        'id' => '_mp_dateformat_timeline',
                        'type' => 'text',
                        'title' => __('Timeline date format', THEMENAME),
			'subtitle' => __('Timeline Widget', THEMENAME),
                        'desc' => __('(e.g.: Nov 6th)', THEMENAME),
			'default' => 'M jS',
                    ),
                )
            );


            // FAVICONS

            $this->sections[] = array(
                'title' => __('Favicons', THEMENAME),
                'icon' => 'el-icon-star',
                'fields' => array(
                    array(
                        'id' => '_mp_favicon_16',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Favicon 16x16 pixels (ico)', THEMENAME),
                        'desc' => __('The 16x16 favicon is the most used on all browsers.', THEMENAME)
                    ),
                    array(
                        'id' => '_mp_favicon_57',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 57x57 pixels (png)', THEMENAME),
                        'desc' => __('For non-Retina iPhone, iPod Touch, and Android 2.1+ devices', THEMENAME)
                    ),
                    array(
                        'id' => '_mp_favicon_76',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 76x76 pixels (png)', THEMENAME),
                        'desc' => __('Size for iPad 2 and iPad mini (standard resolution)', THEMENAME)
                    ),
                    array(
                        'id' => '_mp_favicon_120',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 120x120 pixels (png)', THEMENAME),
                        'desc' => __('Size for iPhone and iPod touch (high resolution)', THEMENAME)
                    ),
                    array(
                        'id' => '_mp_favicon_152',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Apple Touch Icon 152x152 pixels (png)', THEMENAME),
                        'desc' => __('Size for iPad and iPad mini (high resolution)', THEMENAME)
                    )
                )
            );


            /* Theme Information */

            ob_start();

            $ct = wp_get_theme();
            $this->theme = $ct;
            $item_name = $this->theme->get('Name');
            $tags = $this->theme->Tags;
            $screenshot = $this->theme->get_screenshot();
            $class = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;',THEMENAME ), $this->theme->display('Name') );

            ?>
            <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                            <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
                                    <img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
                            </a>
                            <?php endif; ?>
                            <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
                    <?php endif; ?>

                    <h4>
                            <?php echo $this->theme->display('Name'); ?>
                    </h4>

                    <div>
                            <ul class="theme-info">
                                    <li><?php printf( __('By %s',THEMENAME), $this->theme->display('Author') ); ?></li>
                                    <li><?php printf( __('Version %s',THEMENAME), $this->theme->display('Version') ); ?></li>
                                    <li><?php echo '<strong>'.__('Tags', THEMENAME).':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
                            </ul>
                            <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
                            <?php if ( $this->theme->parent() ) {
                                    printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
                                            __( 'http://codex.wordpress.org/Child_Themes',THEMENAME ),
                                            $this->theme->parent()->display( 'Name' ) );
                            } ?>

                    </div>

            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $this->sections[] = array(
                    'icon' => 'el-icon-list-alt',
                    'title' => __('Theme Information', THEMENAME),
                    'fields' => array(
                            array(
                                    'id' => 'raw_new_info',
                                    'type' => 'raw',
                                    'content' => $item_info,
                                    )
                            )
                    );


            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', THEMENAME),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }



        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'mp_weeklynews',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => false,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', THEMENAME),
                'page_title'        => __('Theme Options', THEMENAME),
		'disable_tracking'  => true,

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDxrzMjF3WLwVS4QRHcOyxGgQjsdggkGD8', // Must be defined to add google fonts to the typography module

                'async_typography'  => true,                    // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                ),

                'intro_text'    => '<p>'.$theme->get('Description').'</p>',
                'footer_text'   => __('<p>Don\'t forget to <a href="http://themeforest.net/user/mip" target="_blank">rate us</a> if you like this template.</p>', THEMENAME)

            );



        }

    }

    global $reduxConfig;
    $reduxConfig = new Redux_Framework_config();

}


/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
