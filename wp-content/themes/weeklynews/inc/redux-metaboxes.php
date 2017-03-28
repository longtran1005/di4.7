<?php
global $page_template;
// INCLUDE THIS BEFORE you load your ReduxFramework object config file.


// You may replace $redux_opt_name with a string if you wish. If you do so, change loader.php
// as well as all the instances below.
$redux_opt_name = "mp_weeklynews";

if ( !function_exists( "redux_add_posts_metaboxes" ) ):
    function redux_add_posts_metaboxes($metaboxes) {

        $post_id            = isset($_GET['post']) ? $_GET['post'] : 0;

        $post_categories    = wp_get_post_categories( $post_id );
        $cats = '';
        $weeklynews_mp      = get_option('mp_weeklynews');
        $redux_url          = get_template_directory_uri() . '/inc/redux/ReduxCore';

        foreach($post_categories as $c){
            $cat = get_category( $c );
            $cats .= $cat->cat_ID .',';
        }

        $boxsections[] = array(
            'title' => __('Posts Settings', THEMENAME),
            'icon' => 'el-icon-file-edit',
            'desc' => __('This options overides your global settings.', THEMENAME),
            'fields' => array(
                array(
                    'id' => '_mp_post_layout_single',
                    'type' => 'image_select',
                    'title' => __('Post layout', THEMENAME),
                    'desc' => __('Select layout for this post.', THEMENAME),
                    'options' => array(
                        'loop-page-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/post-layout-1.png'),
                        'loop-page-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/post-layout-2.png'),
                        'loop-page-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/post-layout-3.png'),
                        'loop-page-4' => array('alt' => 'Layout 4', 'img' => $redux_url.'/assets/img/post-layout-4.png'),
                        'loop-page-5' => array('alt' => 'Layout 5', 'img' => $redux_url.'/assets/img/post-layout-5.png'),
                    ),
                    'default' => $weeklynews_mp['_mp_post_layout'],
                ),

                array(
                    'id' => '_mp_post_layout_single_image_height',
                    'type' => 'switch',
                    'title' => __('Show full image height', THEMENAME),
                    'subtitle' => __('Fit only horizontally', THEMENAME),
                    'required'  => array (
                        array('_mp_post_layout_single', "=", array('loop-page-1', 'loop-page-2', 'loop-page-3') ),
                    )
                ),

                array(
                    'id' => '_mp_sidebar_position_single',
                    'type' => 'image_select',
                    'title' => __('Sidebar position', THEMENAME),
                    'subtitle' => __('Select main sidebar position for this post.', THEMENAME),
                    'options' => array(
                        'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
                        'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
                        'multi-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
                        'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
                        'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
                     ),
                    'default' => $weeklynews_mp['_mp_sidebar_position'],
                ),

                array(
                    'id' => '_mp_sidebar_source_single_middle',
                    'title' => __( 'Choose default middle/left sidebar', THEMENAME ),
                    'desc' => 'Please select the sidebar you would like to display on this page (max 160px content).',
                    'type' => 'select',
                    'data' => 'sidebars',
                    'default' => 'None',
                    'required'  => array('_mp_sidebar_position_single', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
                    'default' => $weeklynews_mp['_mp_sidebar_source_middle'],
                ),

                array(
                    'id' => '_mp_sidebar_source_single',
                    'title' => __( 'Select default sidebar', THEMENAME ),
                    'desc' => 'Please select the sidebar you would like to display on this page (max 300px content).',
                    'type' => 'select',
                    'data' => 'sidebars',
                    'required'  => array('_mp_sidebar_position_single', "=", array( 'left-sidebar', 'right-sidebar', 'multi-sidebar' )),
                    'default' => $weeklynews_mp['_mp_sidebar_source'],
                    'required'  => array('_mp_sidebar_position_single', "!=", 'hide-sidebar'),
                ),

                array(
                    'id' => '_mp_category_label',
                    'title' => __( 'Select category label', THEMENAME ),
                    'desc' => 'Please select category or subcategory as highlighted label.',
                    'type' => 'select',
                    'data' => 'categories',
                    'args' => array( 'include' => $cats ),
                ),

                array(
                    'id' => '_mp_enable_author_single',
                    'type' => 'button_set',
                    'title' => __('Display Author Information', THEMENAME),
                    'options'   => array(
                        'enable' => 'Enable',
                        'disable' => 'Disable'
                    ),
                    'default' => $weeklynews_mp['_mp_enable_author'],
                ),
                array(
                    'id' => '_mp_enable_prevnext_posts_single',
                    'type' => 'button_set',
                    'title' => __('Display Prev/Next Posts', THEMENAME),
                    'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                    'options'   => array(
                        'enable' => 'Enable',
                        'disable' => 'Disable'
                    ),
                    'default' => $weeklynews_mp['_mp_enable_prevnext_posts'],
                ),
                array(
                    'id' => '_mp_post_display_via_source',
                    'type' => 'switch',
                    'title' => __('Display Via & Source', THEMENAME),
                    'default' => 0,
                ),
                array(
                    'id' => '_mp_post_display_via_name',
                    'type' => 'text',
                    'title' => __('Via name', THEMENAME),
                    'required'  => array('_mp_post_display_via_source', "=", '1'),
                ),
                array(
                    'id' => '_mp_post_display_via_link',
                    'type' => 'text',
                    'title' => __('Via URL', THEMENAME),
                    'required'  => array('_mp_post_display_via_source', "=", '1'),
                ),
                array(
                    'id' => '_mp_post_display_source_name',
                    'type' => 'text',
                    'title' => __('Source name', THEMENAME),
                    'required'  => array('_mp_post_display_via_source', "=", '1'),
                ),
                array(
                    'id' => '_mp_post_display_source_link',
                    'type' => 'text',
                    'title' => __('Source URL', THEMENAME),
                    'required'  => array('_mp_post_display_via_source', "=", '1'),
                ),
            )
        );


        /* Post settings */
        $boxsections[] = array(
            'title' => __('Related posts boxes', THEMENAME),
            'desc' => __('Your selection overrides global theme options', THEMENAME),
            'icon' => 'el-icon-share',
            //'subsection' => true,
            'fields' => array(
                array(
                    'id'        => 'related-notice-info-1',
                    'type'  => 'info',
                    'style' => 'success',
                    'title'     => __('Related posts box at the bottom', THEMENAME),
                    'desc'      => __('This box will be displayed at bottom of the post, after author box (if selected).', THEMENAME)
                ),
                array(
                    'id' => '_mp_enable_related_posts_single',
                    'type' => 'button_set',
                    'title' => __('Display related posts', THEMENAME),
                    'options'   => array(
                        'enable' => 'Enable',
                        'disable' => 'Disable'
                    ),
                ),
                array(
                    'id'        => '_mp_filter_related_posts_single',
                    'type'      => 'button_set',
                    'title'     => __('Filter related posts by', THEMENAME),
                    'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                    'options'   => array(
                        'cat' => 'Category',
                        'tag' => 'Tag'
                    ),
                    'required'  => array('_mp_enable_related_posts_single', "=", 'enable')
                ),
                array(
                    'id' => '_mp_related_posts_title_single',
                    'type' => 'text',
                    'title' => __('Title for related posts', THEMENAME),
                    'subtitle' => __('Default: "Related Posts"', THEMENAME),
                    'required'  => array('_mp_enable_related_posts_single', "=", 'enable'),
                ),

                array(
                    'id'=>'_mp_related_posts_offset_single',
                    'type' => 'slider',
                    'title' => __('Posts offset', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to displace or pass over (0 for no offset)', THEMENAME),
                ),

                array(
                    'id'        => '_mp_related_posts_sort_single',
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
                    'required'  => array('_mp_enable_related_posts', "=", 'enable'),
                ),
                array(
                    'id'        => 'related-notice-info-2_single',
                    'type'  => 'info',
                    'style' => 'warning',
                    'title'     => __('Related posts box on the side', THEMENAME),
                    'desc'      => __('This box will be displayed after post title.', THEMENAME)
                ),
                array(
                    'id' => '_mp_enable_related_box_single',
                    'type' => 'button_set',
                    'title' => __('Display related box', THEMENAME),
                    'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                    'options'   => array(
                        'enable' => 'Enable',
                        'disable' => 'Disable'
                    ),
                ),
                array(
                    'id'        => '_mp_enable_related_box_count_single',
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
                    'required'  => array('_mp_enable_related_box_single', "=", 'enable'),
                ),
                array(
                    'id'        => '_mp_enable_related_box_float_single',
                    'type'      => 'button_set',
                    'title'     => __('Show box on', THEMENAME),
                    'subtitle'  => __('Where to display related box', THEMENAME),
                    'options'   => array(
                        'pull-left' => 'On left side',
                        'pull-right' => 'On right side',
                    ),
                    'required'  => array('_mp_enable_related_box_single', "=", 'enable'),
                ),

                // First section
                array(
                    'id'        => 'related-box-info-1_single',
                    'type'  => 'info',
                    'title'     => __('First section data', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),
                array(
                    'id' => '_mp_enable_related_box_title_1_single',
                    'type' => 'text',
                    'title' => __('Section title', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_format_1_single',
                    'type'      => 'radio',
                    'title'     => __('Section format', THEMENAME),
                    'subtitle'  => __('Choose how to format post layout', THEMENAME),
                    'options'   => array(
                        'related-box-1' => 'Only Title',
                        'related-box-2' => 'Title and Published date',
                        'related-box-3' => 'Image and Title'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_filter_1_single',
                    'type'      => 'button_set',
                    'title'     => __('Filter related box by', THEMENAME),
                    'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                    'options'   => array(
                        'cat' => 'Category',
                        'tag' => 'Tag'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),


                 array(
                    'id'=>'_mp_enable_related_box_count_1_single',
                    'type' => 'slider',
                    'title' => __('Posts count', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to show', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),

                array(
                    'id'=>'_mp_enable_related_box_offset_1_single',
                    'type' => 'slider',
                    'title' => __('Posts offset', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to displace or pass over (0 for no offset)', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),

                array(
                    'id'        => '_mp_enable_related_box_sort_1_single',
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
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '1', '2', '3' )),
                    )
                ),

                // Second section
                array(
                    'id'        => 'related-box-info-2_single',
                    'type'  => 'info',
                    'title'     => __('Second section data', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),
                array(
                    'id' => '_mp_enable_related_box_title_2_single',
                    'type' => 'text',
                    'title' => __('Second Section title', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_format_2_single',
                    'type'      => 'radio',
                    'title'     => __('Section format', THEMENAME),
                    'subtitle'  => __('Choose how to format post layout', THEMENAME),
                    'options'   => array(
                        'related-box-1' => 'Only Title',
                        'related-box-2' => 'Title and Published date',
                        'related-box-3' => 'Image and Title'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_filter_2_single',
                    'type'      => 'button_set',
                    'title'     => __('Filter related box by', THEMENAME),
                    'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                    'options'   => array(
                        'cat' => 'Category',
                        'tag' => 'Tag'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),


                array(
                    'id'=>'_mp_enable_related_box_count_2_single',
                    'type' => 'slider',
                    'title' => __('Posts count', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to show', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),

                array(
                    'id'=>'_mp_enable_related_box_offset_2_single',
                    'type' => 'slider',
                    'title' => __('Posts offset', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to displace or pass over (0 for no offset)', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),

                array(
                    'id'        => '_mp_enable_related_box_sort_2_single',
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
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", array( '2', '3' )),
                    )
                ),

                // Third section
                array(
                    'id'        => 'related-box-info-3_single',
                    'type'  => 'info',
                    'title'     => __('Third section data', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),
                array(
                    'id' => '_mp_enable_related_box_title_3_single',
                    'type' => 'text',
                    'title' => __('Third Section title', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_format_3_single',
                    'type'      => 'radio',
                    'title'     => __('Section format', THEMENAME),
                    'subtitle'  => __('Choose how to format post layout', THEMENAME),
                    'options'   => array(
                        'related-box-1' => 'Only Title',
                        'related-box-2' => 'Title and Published date',
                        'related-box-3' => 'Image and Title'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),
                array(
                    'id'        => '_mp_enable_related_box_filter_3_single',
                    'type'      => 'button_set',
                    'title'     => __('Filter related box by', THEMENAME),
                    'subtitle'  => __('Choose how to filter related posts', THEMENAME),
                    'options'   => array(
                        'cat' => 'Category',
                        'tag' => 'Tag'
                    ),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),

                array(
                    'id'=>'_mp_enable_related_box_count_3_single',
                    'type' => 'slider',
                    'title' => __('Posts count', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to show', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),

                array(
                    'id'=>'_mp_enable_related_box_offset_3_single',
                    'type' => 'slider',
                    'title' => __('Posts offset', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "1",
                    "max" 	=> "30",
                    'desc' => __('Number of post to displace or pass over (0 for no offset)', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),


                array(
                    'id'        => '_mp_enable_related_box_sort_3_single',
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
                    'required'  => array (
                        array('_mp_enable_related_box_single', "=", 'enable'),
                        array('_mp_enable_related_box_count_single', "=", '3' ),
                    )
                ),
            )
        );


        $boxsections[] = array(
            'title' => __('Review post settings', THEMENAME),
            'icon' => 'el-icon-star-empty',
            'fields' => array(
                array(
                    'id' => '_mp_enable_review_post',
                    'type' => 'button_set',
                    'title' => __('Display review', THEMENAME),
                    'options'   => array(
                        'enable' => 'Enable',
                        'disable' => 'Disable'
                    ),
                    'default' => 'disable',
                ),
                array(
                    'id' => '_mp_review_post_position',
                    'type' => 'button_set',
                    'title' => __('Review box position', THEMENAME),
                    'desc' => __('If you are using custom position then please use <strong>[review]</strong> shortcode to place the review box in any place within post content', THEMENAME),
                    'options'   => array(
                        'top' => 'Top of the post',
                        'bottom' => 'Bottom of the post',
                        'custom' => 'Custom position'
                    ),
                    'default' => $weeklynews_mp['_mp_review_post_position_global'],
                    'required'  => array('_mp_enable_review_post', "=", 'enable'),
                ),
                array(
                    'id'        => '_mp_review_post_style',
                    'type'      => 'button_set',
                    'title'     => __('Review style', THEMENAME),
                    'options'   => array(
                        'percentage' => 'Percentage',
                        'points' => 'Points',
                    ),
                    'default' => $weeklynews_mp['_mp_review_post_style_global'],
                    'required'  => array('_mp_enable_review_post', "=", 'enable'),
                ),

                array(
                    'id'        => '_mp_review_post_summary_type',
                    'type'      => 'button_set',
                    'title'     => __('Review summary type', THEMENAME),
                    'subtitle'  => __('How to display review summary', THEMENAME),
                    'options'   => array(
                        'summary' => 'Summary box',
                        'good-bad' => 'The Good / The Bad boxes',
                    ),
                    'default' => $weeklynews_mp['_mp_review_post_summary_type_global'],
                    'required'  => array('_mp_enable_review_post', "=", 'enable'),
                ),
                array(
                    'id'        => '_mp_review_post_summary_text',
                    'type'      => 'editor',
                    'title'     => __('Review summary', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_summary_type', "=", 'summary' ),
                    )
                ),
                array(
                    'id'        => '_mp_review_post_summary_text_good',
                    'type'      => 'textarea',
                    'title'     => __('Review summary (The Good)', THEMENAME),
                    'desc'     => __('Hit enter for line breaks. It will be replaced with a list.', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_summary_type', "=", 'good-bad' ),
                    )
                ),
                array(
                    'id'        => '_mp_review_post_summary_text_bad',
                    'type'      => 'textarea',
                    'title'     => __('Review summary (The Bad)', THEMENAME),
                    'desc'     => __('Hit enter for line breaks. It will be replaced with a list.', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_summary_type', "=", 'good-bad' ),
                    )
                ),
                array(
                    'id'        => '_mp_review_post_total_text',
                    'type'      => 'text',
                    'title'     => __('Text appears under the total score', THEMENAME),
                    'required'  => array('_mp_enable_review_post', "=", 'enable'),
                ),

                array(
                    'id'        => '_mp_review_post_criteria_count',
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
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_count_global']) ? $weeklynews_mp['_mp_review_post_criteria_count_global'] : 0),
                    'required'  => array('_mp_enable_review_post', "=", 'enable'),
                ),

                array(
                    'id'            => '_mp_review_post_criteria_1',
                    'type'          => 'text',
                    'title'         => __('#1 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('1', '2', '3', '4', '5', '6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_1_global']) ? $weeklynews_mp['_mp_review_post_criteria_1_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_1',
                    'type'          => 'slider',
                    'title'         => __('#1 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('1', '2', '3', '4', '5', '6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_2',
                    'type'          => 'text',
                    'title'         => __('#2 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('2', '3', '4', '5', '6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_2_global']) ? $weeklynews_mp['_mp_review_post_criteria_2_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_2',
                    'type'          => 'slider',
                    'title'         => __('#2 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('2', '3', '4', '5', '6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_3',
                    'type'          => 'text',
                    'title'         => __('#3 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('3', '4', '5', '6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_3_global']) ? $weeklynews_mp['_mp_review_post_criteria_3_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_3',
                    'type'          => 'slider',
                    'title'         => __('#3 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('3', '4', '5', '6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_4',
                    'type'          => 'text',
                    'title'         => __('#4 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('4', '5', '6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_4_global']) ? $weeklynews_mp['_mp_review_post_criteria_4_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_4',
                    'type'          => 'slider',
                    'title'         => __('#4 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('4', '5', '6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_5',
                    'type'          => 'text',
                    'title'         => __('#5 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('5', '6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_5_global']) ? $weeklynews_mp['_mp_review_post_criteria_5_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_5',
                    'type'          => 'slider',
                    'title'         => __('#5 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('5', '6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_6',
                    'type'          => 'text',
                    'title'         => __('#6 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('6', '7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_6_global']) ? $weeklynews_mp['_mp_review_post_criteria_6_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_6',
                    'type'          => 'slider',
                    'title'         => __('#6 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('6', '7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_7',
                    'type'          => 'text',
                    'title'         => __('#7 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('7', '8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_7_global']) ? $weeklynews_mp['_mp_review_post_criteria_7_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_7',
                    'type'          => 'slider',
                    'title'         => __('#7 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('7', '8') ),
                    )
                ),

                array(
                    'id'            => '_mp_review_post_criteria_8',
                    'type'          => 'text',
                    'title'         => __('#8 - Criteria name', THEMENAME),
                    'desc'          => __('Name of the review criteria', THEMENAME),
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('8') ),
                    ),
                    'default' => ( isset($weeklynews_mp['_mp_review_post_criteria_8_global']) ? $weeklynews_mp['_mp_review_post_criteria_8_global'] : '' ),
                ),
                array(
                    'id'            => '_mp_review_post_criteria_value_8',
                    'type'          => 'slider',
                    'title'         => __('#8 - Criteria value', THEMENAME),
                    'desc'          => __('Min: 0, max: 100, step: 1, default value: 75', THEMENAME),
                    'default'       => 75,
                    'min'           => 0,
                    'step'          => 1,
                    'max'           => 100,
                    'display_value' => 'text',
                    'required'  => array (
                        array('_mp_enable_review_post', "=", 'enable'),
                        array('_mp_review_post_criteria_count', "=", array('8') ),
                    )
                ),


            )
        );


        $boxsections[] = array(
            'title' => __('Audio post settings', THEMENAME),
            'icon' => 'el-icon-music',
            'fields' => array(
                array(
                    'id' => '_mp_featured_audio_embed',
                    'type' => 'textarea',
                    'title' => __('Audio embed', THEMENAME),
                    'desc' => __('Paste an embed link and it will be embeded in the post instead of featured image', THEMENAME)
                ),
                array(
                    'id' => '_mp_featured_audio_title',
                    'type' => 'text',
                    'title' => __('Audio title', THEMENAME)
                ),
                array(
                    'id' => '_mp_featured_audio_author',
                    'type' => 'text',
                    'title' => __('Audio author', THEMENAME)
                ),
            )
        );

        $boxsections[] = array(
            'title' => __('Video post settings', THEMENAME),
            'icon' => 'el-icon-video',
            'fields' => array(
                array(
                    'id' => '_mp_featured_video',
                    'type' => 'text',
                    'title' => __('Video URL', THEMENAME),
                    'desc' => __('Paste a link from Youtube, Vimeo or Dailymotion and it will be embeded in the post instead of featured image. This has higher prioriry than embed code.', THEMENAME)
                ),
                array(
                    'id'       => '_mp_featured_video_overwrite_thumbnail',
                    'type'     => 'switch',
                    'title'    => __('Overwrite thumbnail', THEMENAME),
                    'subtitle' => __('Do you want to overwrite thumbnail if exist with video thumbnail?', THEMENAME),
                    'default'  => false,
                ),
                array(
                    'id' => '_mp_featured_video_embed',
                    'type' => 'textarea',
                    'title' => __('Video embed', THEMENAME),
                    'desc' => __('Paste an embed link and it will be embeded in the post instead of featured image', THEMENAME)
                )
            )
        );

        $boxsections[] = array(
            'title' => __('Ads System', THEMENAME),
            'icon' => 'el-icon-network',
            'fields' => array(
                array(
                    'id' 	=> '_mp_ads_posts_top_single',
                    'type' 	=> 'select',
                    'title' => __('Top Ad', THEMENAME),
                    'subtitle' => __('Below the header', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_top']) ? $weeklynews_mp['_mp_ads_posts_top'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_section_1_single',
                    'type' 	=> 'select',
                    'title' => __('Post Ad 1', THEMENAME),
                    'subtitle' => __('Before the post', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_section_1']) ? $weeklynews_mp['_mp_ads_posts_section_1'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_section_2_single',
                    'type' 	=> 'select',
                    'title' => __('Post Ad 2', THEMENAME),
                    'subtitle' => __('Before post content (after image)', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_section_2']) ? $weeklynews_mp['_mp_ads_posts_section_2'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_section_3_single',
                    'type' 	=> 'select',
                    'title' => __('Post Ad 3', THEMENAME),
                    'subtitle' => __('After the post', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_section_3']) ? $weeklynews_mp['_mp_ads_posts_section_3'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_wall_single',
                    'type' 	=> 'select',
                    'title' => __('Wallpaper Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_wall']) ? $weeklynews_mp['_mp_ads_posts_wall'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_side_left_single',
                    'type' 	=> 'select',
                    'title' => __('Left Side Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_side_left']) ? $weeklynews_mp['_mp_ads_page_side_left'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_posts_side_right_single',
                    'type' 	=> 'select',
                    'title' => __('Right Side Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_posts_side_right']) ? $weeklynews_mp['_mp_ads_posts_side_right'] : '' ),
                ),
            )
        );




        $metaboxes[] = array(
            'id' => 'post_options',
            'title' => __('Post Options', THEMENAME),
            'post_types' => array('post'),
            'position' => 'normal', // normal, advanced, side
            'priority' => 'high', // high, core, default, low
            'sections' => $boxsections
        );

        return $metaboxes;
  }
  add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'redux_add_posts_metaboxes');
endif;


if ( !function_exists( "redux_add_pages_metaboxes" ) ):
    function redux_add_pages_metaboxes($metaboxes) {

        $weeklynews_mp      = get_option('mp_weeklynews');
        $redux_url          = get_template_directory_uri() . '/inc/redux/ReduxCore';

        $boxsections[] = array(
            'title' => __('Page Settings', THEMENAME),
            'icon' => 'el-icon-file-edit',
            'desc' => __('This options overides your global settings.', THEMENAME),
            'fields' => array(
                    array(
                    'id' => '_mp_page_layout_single',
                    'type' => 'image_select',
                    'title' => __('Page layout', THEMENAME),
                    'subtitle' => __('Select layout for this page.', THEMENAME),
                    'options' => array(
                        'loop-page-1' => array('alt' => 'Layout 1', 'img' => $redux_url.'/assets/img/post-layout-1.png'),
                        'loop-page-2' => array('alt' => 'Layout 2', 'img' => $redux_url.'/assets/img/post-layout-2.png'),
                        'loop-page-3' => array('alt' => 'Layout 3', 'img' => $redux_url.'/assets/img/post-layout-3.png'),
                        'loop-page-4' => array('alt' => 'Layout 4', 'img' => $redux_url.'/assets/img/post-layout-4.png'),
                    ),
                    'default' => $weeklynews_mp['_mp_page_layout'],
                ),
                array(
                    'id' => '_mp_page_layout_single_image_height',
                    'type' => 'switch',
                    'title' => __('Show full image height', THEMENAME),
                    'subtitle' => __('Fit only horizontally', THEMENAME),
                    'required'  => array (
                        array('_mp_page_layout_single', "=", array('loop-page-1', 'loop-page-2', 'loop-page-3') ),
                    )
                ),
                array(
                    'id' => '_mp_page_sidebar_position_single',
                    'type' => 'image_select',
                    'title' => __('Sidebar position', THEMENAME),
                    'subtitle' => __('Select main sidebar position for this page.', THEMENAME),
                    'options' => array(
                        'left-sidebar' => array('alt' => 'Left Sidebar', 'img' => $redux_url.'/assets/img/2cl.png'),
                        'right-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/2cr.png'),
                        'multi-sidebar' => array('alt' => 'Right Sidebar', 'img' => $redux_url.'/assets/img/3cr.png'),
                        'multi-sidebar mid-left' => array('alt' => 'Multi Column Sidebar - Mid left', 'img' => $redux_url.'/assets/img/3cm.png'),
                        'hide-sidebar' => array('alt' => 'No Sidebar', 'img' => $redux_url.'/assets/img/1c.png'),
                     ),
                    'default' => $weeklynews_mp['_mp_page_sidebar_position'],
                ),

                array(
                    'id' => '_mp_page_sidebar_source_single_middle',
                    'title' => __( 'Choose default middle/left sidebar', THEMENAME ),
                    'desc' => 'Please select the sidebar you would like to display on this page (max 160px content).',
                    'type' => 'select',
                    'data' => 'sidebars',
                    'default' => $weeklynews_mp['_mp_page_sidebar_source_middle'],
                    'required'  => array('_mp_page_sidebar_position_single', "=", array('multi-sidebar', 'multi-sidebar mid-left')),
                ),

                array(
                    'id' => '_mp_page_sidebar_source_single',
                    'title' => __( 'Select default sidebar', THEMENAME ),
                    'desc' => 'Please select the sidebar you would like to display on this page (max 300px content).',
                    'type' => 'select',
                    'data' => 'sidebars',
                    'default' => $weeklynews_mp['_mp_page_sidebar_source'],
                    'required'  => array('_mp_page_sidebar_position_single', "!=", 'hide-sidebar'),
                ),

                array(
                    'id' => '_mp_page_unique_articles',
                    'type' => 'switch',
                    'title' => __('Enable unique posts', THEMENAME),
                    'default' => 0,
                ),

                array(
                    'id' => '_mp_page_breakingnews_enable',
                    'type' => 'switch',
                    'title' => __('Display News Scroller', THEMENAME),
                    'default' => 0,
                ),
                (
                    ( (bool)$weeklynews_mp['_mp_header_show_quicklinks'] ) ?
                        array(
                            'id' => '_mp_page_header_quicklinks_menu',
                            'type' => 'select',
                            'title' => __('Select Quicklinks Menu', THEMENAME),
                            'subtitle' => __('Select what menu to display as quicklinks', THEMENAME),
                            'desc' => __('', THEMENAME),
                            'data' => 'menus',
                        )
                    :
                        array(
                            'id' => '_mp_divider_page',
                            'type' => 'divide',
                        )
                )
            )
        );

        $boxsections[] = array(
            'title' => __('Top slider', THEMENAME),
            'icon' => 'el-icon-website',
            'fields' => array(
                array(
                    'id' => '_mp_page_top_slider_enable',
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
                    'id' => '_mp_page_top_slider_shortcode',
                    'type' => 'text',
                    'title' => __('Top Slider Shortcode', THEMENAME),
                    'required'  => array('_mp_page_top_slider_enable', "equals", 2)
                ),
                array(
                    'id' => '_mp_page_top_slider_mobile',
                    'type' => 'switch',
                    'title' => __('Hide slider on mobile devices', THEMENAME),
                    'default' => 0,
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_display',
                    'type'      => 'radio',
                    'title'     => __('Slider display', THEMENAME),
                    'subtitle'  => __('Choose how to display your posts', THEMENAME),
                    'options'   => array(
                        'page-slider-1' => 'Display by category (each slide - one category)',
                        'page-slider-2' => 'Not displayed by category (post shown only by order)',
                        //'page-slider-3' => 'Owl Slider',
                    ),
                    'default'   => 'page-slider-2',
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_layout',
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
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_padding',
                    'type'      => 'spacing',
                    'title'     => __('Slider padding (px)', THEMENAME),
                    'mode'      => 'padding',
                    'units'     => 'px',
                    'left'      => false,
                    'right'     => false,

                    'output'    => array('#page-slider'),
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_background',
                    'type'      => 'background',
                    'title'     => __('Slider background', THEMENAME),
                    'preview'      => false,
                    'output'    => array('#page-slider'),
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_autostart',
                    'type'      => 'switch',
                    'title'     => __('Auto Start', THEMENAME),
                    'subtitle'  => __('Determines whether the carousel should scroll automatically or not.', THEMENAME),
                    'default'   => 0,
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'=>'_mp_page_top_slider_autostart_delay',
                    'type' => 'slider',
                    'title' => __('Auto Start Delay', THEMENAME),
                    "default" => "0",
                    "min" 	=> "0",
                    "step"	=> "500",
                    "max" 	=> "10000",
                    'desc' => __('delay in milliseconds before the carousel starts scrolling the first time', THEMENAME),
                    'required'  => array (
                        array('_mp_page_top_slider_enable', "equals", 1),
                        array('_mp_page_top_slider_autostart', "equals", 1)
                    )
                ),
                array(
                    'id'        => '_mp_page_top_slider_summary',
                    'type'      => 'switch',
                    'title'     => __('Show text summary', THEMENAME),
                    'subtitle'  => __('Do you want to display short summary bellow title?', THEMENAME),
                    'default'   => 0,
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_sort',
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
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id'        => '_mp_page_top_slider_slides',
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
                        array('_mp_page_top_slider_enable', "equals", 1),
                        array('_mp_page_top_slider_display', "=", 'page-slider-2'),
                    ),
                ),
                array(
                    'id' => '_mp_page_top_slider_categories',
                    'type' => 'select',
                    'data'      => 'categories',
                    'multi'     => true,
                    'sortable'   => true,
                    'title' => __('Show categories', THEMENAME),
                    'subtitle'  => __('If none is selected, all categories are included by default', THEMENAME),
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id' => '_mp_page_top_slider_tags',
                    'type' => 'select',
                    'data'      => 'tags',
                    'multi'     => true,
                    'sortable'   => true,
                    'title' => __('Filter by tag slug', THEMENAME),
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),
                array(
                    'id' => '_mp_page_top_slider_category_display',
                    'type' => 'button_set',
                    'title' => __('Display Category labels as', THEMENAME),
                    'subtitle' => __('This option only affects <b>posts</b>.', THEMENAME),
                    'options'   => array(
                        'root' => 'Root Categories',
                        'sub' => 'Sub Categories'
                    ),
                    'default' => 'root',
                    'required'  => array('_mp_page_top_slider_enable', "equals", 1)
                ),

            )
        );

        $boxsections[] = array(
            'title' => __('Video page settings', THEMENAME),
            'icon' => 'el-icon-video',
            'fields' => array(
                array(
                    'id' => '_mp_page_featured_video',
                    'type' => 'text',
                    'title' => __('Video URL', THEMENAME),
                    'desc' => __('Paste a link from Youtube, Vimeo or Dailymotion and it will be embeded in the post instead of featured image. This has higher prioriry than embed code.', THEMENAME)
                ),
                array(
                    'id'       => '_mp_featured_video_overwrite_thumbnail',
                    'type'     => 'switch',
                    'title'    => __('Overwrite thumbnail', THEMENAME),
                    'subtitle' => __('Do you want to overwrite thumbnail if exist with video thumbnail?', THEMENAME),
                    'default'  => false,
                ),
                array(
                    'id' => '_mp_page_featured_video_embed',
                    'type' => 'textarea',
                    'title' => __('Video embed', THEMENAME),
                    'desc' => __('Paste an embed link and it will be embeded in the post instead of featured image.', THEMENAME)
                ),
            )
        );


        $boxsections[] = array(
            'title' => __('Ads System', THEMENAME),
            'icon' => 'el-icon-network',
            'fields' => array(
                array(
                    'id' 	=> '_mp_ads_page_top_single',
                    'type' 	=> 'select',
                    'title' => __('Top Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'standard-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_page_top']) ? $weeklynews_mp['_mp_ads_page_top'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_page_wall_single',
                    'type' 	=> 'select',
                    'title' => __('Wallpaper Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'wall-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_page_wall']) ? $weeklynews_mp['_mp_ads_page_wall'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_page_side_left_single',
                    'type' 	=> 'select',
                    'title' => __('Left Side Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_page_side_left']) ? $weeklynews_mp['_mp_ads_page_side_left'] : '' ),
                ),
                array(
                    'id' 	=> '_mp_ads_page_side_right_single',
                    'type' 	=> 'select',
                    'title' => __('Right Side Ad', THEMENAME),
                    'data'  => 'posts',
                    'args'	=> array( 'post_type' => 'mp_ads', 'meta_value' => 'side-display', 'posts_per_page' => -1 ),
                    'default' => ( isset($weeklynews_mp['_mp_ads_page_side_right']) ? $weeklynews_mp['_mp_ads_page_side_right'] : '' ),
                ),
            )
        );

        $metaboxes[] = array(
            'id' => 'post_options',
            'title' => __('Page Options', THEMENAME),
            'post_types' => array('page'),
            'position' => 'normal', // normal, advanced, side
            'priority' => 'high', // high, core, default, low
            'sections' => $boxsections
        );

        return $metaboxes;
  }
  add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'redux_add_pages_metaboxes');
endif;


if ( !function_exists( "redux_add_ads_metaboxes" ) ):
    function redux_add_ads_metaboxes($metaboxes) {

        $boxsections[] = array(
            'title' => __('Edit Your Ad', THEMENAME),
            'icon' => 'el-icon-file-edit',
            //'desc' => __('This options overides your global settings.', THEMENAME),
            'fields' => array(
                array(
                    'id' => '_mp_ads_ad_display',
                    'type' => 'button_set',
                    'title' => __('Ad Display', THEMENAME),
                    'options'   => array(
                        'standard-display' => 'Standard Ad',
                        'mobile-display' => 'Mobile Ad',
                        'wall-display' => 'Wallpaper Ad',
                        'side-display' => 'Side Ad'
                    ),
                ),
                array(
                    'id' => '_mp_ads_ad_type',
                    'type' => 'button_set',
                    'title' => __('Ad Type', THEMENAME),
                    'options'   => array(
                        'image' => 'Image',
                        'code' => 'Code'
                    ),
                ),
                array(
                    'id' => '_mp_ads_ad_size',
                    'type' => 'select',
                    'title' => __('Ad Size', THEMENAME),
                    'subtitle' => __('Select your ad size', THEMENAME),
                    'options'   => array(
                        '300x250' => '300 x 250 - Medium Rectangle',
                        '336x280' => '336 x 280 - Large Rectangle',
                        '728x90' => '728 x 90 - Leaderboard',
                        '160x600' => '160 x 600 - Wide Skyscraper',
                        '320x50' => '320 x 50 - Mobile Banner',
                        '234x60' => '234 x 60 - Half Banner',
                        '320x100' => '320 x 100 - Large Mobile Banner',
                        '468x60' => '468 x 60 - Banner',
                        '970x90' => '970 x 90 - Large Leaderboard',
                        '120x600' => '120 x 600 - Skyscraper',
                        '120x240' => '120 x 240 - Vertical Banner',
                        '300x600' => '300 x 600 - Large Skyscraper',
                        '250x250' => '250 x 250 - Square',
                        '200x200' => '200 x 200 - Small Square',
                        '180x150' => '180 x 150 - Small Rectangle',
                        '125x125' => '125 x 125 - Button',
                        'responsive' => 'Responsive ad unit (for google AdSence)',
                        'custom-size' => 'Custom ad size',
                    ),
                    'required'  => array('_mp_ads_ad_display', "=", 'standard-display'),
                    'default' => '',
                ),
                array(
                    'id' => '_mp_ads_ad_side_size',
                    'type' => 'select',
                    'title' => __('Ad Size', THEMENAME),
                    'subtitle' => __('Select your ad size', THEMENAME),
                    'options'   => array(
                        '160' => '160 x 600 - Wide Skyscraper',
                        '120' => '120 x 600 - Skyscraper',
                        '300' => '300 x 600 - Large Skyscraper',
                    ),
                    'required'  => array('_mp_ads_ad_display', "=", 'side-display'),
                    'default' => '',
                ),
                array(
                    'id' => '_mp_ads_ad_image',
                    'type' => 'media',
                    'title' => __('Top Banner image', THEMENAME),
                    'required'  => array(
                        array('_mp_ads_ad_type', "=", 'image'),
                    ),
                ),
                array(
                    'id' => '_mp_ads_ad_url',
                    'type' => 'text',
                    'title' => __('Banner URL', THEMENAME),
                    'desc' => __('Link target for image banner (e.g. http://themes.mipdesign.com)', THEMENAME),
                    'required'  => array('_mp_ads_ad_type', "=", 'image'),
                ),
                array(
                    'id' => '_mp_ads_ad_url_target',
                    'type' => 'button_set',
                    'title' => __('URL Behaviour', THEMENAME),
                    'options'   => array(
                        '_blank' => 'Open in new window',
                        '_self' => 'Open in same window'
                    ),
                    //'default' => '_blank',
                    'required'  => array('_mp_ads_ad_type', "=", 'image'),
                ),
                array(
                    'id' => '_mp_ads_ad_click',
                    'type' => 'text',
                    'title' => __('Banner Click Event', THEMENAME),
                    'desc' => __('', THEMENAME),
                    'required'  => array('_mp_ads_ad_type', "=", 'image'),
                ),
                array(
                    'id' => '_mp_ads_ad_code',
                    'type' => 'textarea',
                    'title' => __('Banner Embed Code', THEMENAME),
                    'required'  => array(
                        array('_mp_ads_ad_type', "=", 'code'),
                    )
                ),
            )
        );

        $metaboxes[] = array(
            'id' => 'post_options',
            'title' => __('Ads Settings', THEMENAME),
            'post_types' => array('mp_ads'),
            'position' => 'normal', // normal, advanced, side
            'priority' => 'high', // high, core, default, low
            'sections' => $boxsections
        );

        return $metaboxes;
  }
  add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'redux_add_ads_metaboxes');
endif;


if ( !function_exists( "redux_add_photo_caption_metaboxes" ) ):
    function redux_add_photo_caption_metaboxes($metaboxes) {

        $boxsections[] = array(
            'title' => '',
            //'icon' => 'el-icon-file-edit',
            //'desc' => __('This options overides your global settings.', THEMENAME),
            'fields' => array(
                array(
                    'id' => '_mp_featured_image_caption',
                    'type' => 'text',
                    'title' => __('Image Caption', THEMENAME),
                ),
            )
        );

        $metaboxes[] = array(
            'id' => 'caption_options',
            'title' => __('Featured Image Caption', THEMENAME),
            'post_types' => array('post', 'page'),
            'position' => 'side', // normal, advanced, side
            'priority' => 'default', // high, core, default, low
            'sections' => $boxsections
        );
        return $metaboxes;
    }
    add_action('redux/metaboxes/'.$redux_opt_name.'/boxes', 'redux_add_photo_caption_metaboxes');
endif;



/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function1')):
    function redux_validate_callback_function1($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;


function save_post_review_meta( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['redux_metaboxes_meta_nonce'] ) ) {
        return $post_id;
    }

    $nonce = $_POST['redux_metaboxes_meta_nonce'];
    // Verify that the nonce is valid.
    // Validate fields (if needed)
    //$plugin_options = $this->_validate_values( $plugin_options, $this->options );

    if ( ! wp_verify_nonce( $nonce, 'redux_metaboxes_meta_nonce' ) ) {
        return $post_id;
    }

    if ( isset( $_POST['mp_weeklynews'] ) ) {
        $form_values    = $_POST['mp_weeklynews'];
        if ( isset($form_values['_mp_enable_review_post']) ) {
            $review_enabled = $form_values['_mp_enable_review_post'];
            $criteria_count = isset($form_values['_mp_review_post_criteria_count']) ? $form_values['_mp_review_post_criteria_count'] : '';
            if ( ($review_enabled == 'enable') && $criteria_count ) {
                $total_score = 0;
                for ( $i = 1; $i <= $criteria_count; $i++ ) {
                    $total_score += $form_values['_mp_review_post_criteria_value_'. $i .''];
                }
                update_post_meta( $post_id, '_mp_review_post_total_score', sanitize_text_field( round($total_score/$criteria_count, 1) ) );
            }
        }
    }

}
add_action( 'save_post', 'save_post_review_meta' );



// The loader will load all of the extensions automatically based on your $redux_opt_name
require_once(dirname( __FILE__ ) . '/redux/ReduxCore/loader.php');
