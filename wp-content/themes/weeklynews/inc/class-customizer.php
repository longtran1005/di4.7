<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */


/*
 * Custom customizer
 */

 if ( ! class_exists( 'MipTheme_Customize' ) ) {

    class MipTheme_Customize {



        public static function register ( $wp_customize ) {
            global $mp_weeklynews;

            $header_background_color            = '#444';
            $header_top_border                  = '#3a3a3a';
            $header_bottom_border               = '#4d4d4d';
            $header_background_color_mobile     = '#444';
            $header_top_border_mobile           = '#3a3a3a';
            $search_border_width                = '3px';
            $search_border_color                = '#4a4a4a';
            $search_border_shadow               = '#3d3d3d';
            $search_text_color                  = '#999';
            $search_icon_color                  = '#a1a1a1';
            $weather_location_color             = '#c3c3c3';
            $weather_temperature_color          = '#fff';
            $weather_date_color                 = '#878787';
            $header_nav_top_background_color    = '#3a3a3a';
            $header_nav_top_border_color        = '#4d4d4d';
            $header_nav_main_background_color   = '#3f3f3f';
            $header_nav_main_border_color       = '#4d4d4d';
            $header_nav_main_hover_background   = '#222';
            $sidebar_background_color           = '#444';



            # If Light Theme
            if ( isset($mp_weeklynews['_mp_theme_style']) && ($mp_weeklynews['_mp_theme_style'] == 'theme-light') ) {
               # If Light Header
               if ( isset($mp_weeklynews['_mp_theme_light_style']) && (($mp_weeklynews['_mp_theme_light_style'] == 'light-both')||($mp_weeklynews['_mp_theme_light_style'] == 'light-header')) ) {

                  $header_background_color            = '#fff';
                  $header_top_border                  = '#e3e3e3';
                  $header_bottom_border               = '#e3e3e3';
                  $header_background_color_mobile     = '#444';
                  $header_top_border_mobile           = '#3a3a3a';
                  $search_border_width                = '1px';
                  $search_border_color                = '#e0e0e0';
                  $search_border_shadow               = '#f7f7f7';
                  $search_text_color                  = '#999';
                  $search_icon_color                  = '#a1a1a1';
                  $weather_location_color             = '#444';
                  $weather_temperature_color          = '#222';
                  $weather_date_color                 = '#aaa';
                  $header_nav_top_background_color    = '#fff';
                  $header_nav_top_border_color        = '#e3e3e3';
                  $header_nav_main_background_color   = '#fff';
                  $header_nav_main_border_color       = '#fff';

               }

               # If Light Sidebar
               if ( isset($mp_weeklynews['_mp_theme_light_style']) && (($mp_weeklynews['_mp_theme_light_style'] == 'light-both')||($mp_weeklynews['_mp_theme_light_style'] == 'light-sidebar')) ) {

                  $sidebar_background_color           = '#fff';

               }
            }

            # add sections
            $wp_customize->add_section(
                'body_section',
                array(
                    'title' => 'Body Settings',
                    'description' => '',
                    'priority' => 1,
                )
            );

            $wp_customize->add_section(
                'header_section',
                array(
                    'title' => 'Header - Settings',
                    'description' => '',
                    'priority' => 2,
                )
            );

            $wp_customize->add_section(
                'search_section',
                array(
                    'title' => 'Header - Search form',
                    'description' => '',
                    'priority' => 3,
                )
            );

            $wp_customize->add_section(
                'weather_section',
                array(
                    'title' => 'Header - Weather widget',
                    'description' => '',
                    'priority' => 4,
                )
            );

            $wp_customize->add_section(
                'nav_section',
                array(
                    'title' => 'Header - Navigation',
                    'description' => '',
                    'priority' => 5,
                )
            );

            $wp_customize->add_section(
                'content_section',
                array(
                    'title' => 'Content settings',
                    'description' => '',
                    'priority' => 6,
                )
            );

            $wp_customize->add_section(
                'mid_sidebar_section',
                array(
                    'title' => 'Mid Sidebar settings',
                    'description' => '',
                    'priority' => 7,
                )
            );

            $wp_customize->add_section(
                'sidebar_section',
                array(
                    'title' => 'Sidebar settings',
                    'description' => '',
                    'priority' => 7,
                )
            );

            $wp_customize->add_section(
                'footer_section',
                array(
                    'title' => 'Footer settings',
                    'description' => '',
                    'priority' => 8,
                )
            );



            # add settings
            $wp_customize->add_setting(
                'body_background_color',
                array(
                    'default' => '#fff',
                    'transport' => 'postMessage',
                )
            );

            #header
            $wp_customize->add_setting(
                'header_background_color',
                array(
                    'default' => $header_background_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_top_border',
                array(
                    'default' => $header_top_border,
                    'transport' => 'postMessage',
                )
            );


            $wp_customize->add_setting(
                'header_bottom_border',
                array(
                    'default' => $header_bottom_border,
                    'transport' => 'postMessage',
                )
            );

            # header mobile
            $wp_customize->add_setting(
                'header_background_color_mobile',
                array(
                    'default' => $header_background_color_mobile,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_top_border_mobile',
                array(
                    'default' => $header_top_border_mobile,
                    'transport' => 'postMessage',
                )
            );

            // header - search form
            $wp_customize->add_setting(
                'search_border_width',
                array(
                    'default' => $search_border_width,
                    'sanitize_callback' => 'miptheme_sanitize_text',
                    'transport' => 'postMessage',
                )
            );
            $wp_customize->add_setting(
                'search_border_radius',
                array(
                    'default' => '25px',
                    'sanitize_callback' => 'miptheme_sanitize_text',
                    'transport' => 'postMessage',
                )
            );
            $wp_customize->add_setting(
                'search_border_color',
                array(
                    'default' => $search_border_color,
                    'transport' => 'postMessage',
                )
            );
            $wp_customize->add_setting(
                'search_border_shadow',
                array(
                    'default' => $search_border_shadow,
                    'transport' => 'postMessage',
                )
            );
            $wp_customize->add_setting(
                'search_text_color',
                array(
                    'default' => $search_text_color,
                    'transport' => 'postMessage',
                )
            );
            $wp_customize->add_setting(
                'search_icon_color',
                array(
                    'default' => '#a1a1a1',
                    'transport' => 'postMessage',
                )
            );

            // header - weather widget
            $wp_customize->add_setting(
                'weather_icon_color',
                array(
                    'default' => $search_icon_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'weather_location_color',
                array(
                    'default' => $weather_location_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'weather_temperature_color',
                array(
                    'default' => $weather_temperature_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'weather_date_color',
                array(
                    'default' => $weather_date_color,
                    'transport' => 'postMessage',
                )
            );


            #header - navigation
            $wp_customize->add_setting(
                'header_nav_top_background_color',
                array(
                    'default' => $header_nav_top_background_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_nav_top_border_color',
                array(
                    'default' => $header_nav_top_border_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_nav_main_background_color',
                array(
                    'default' => $header_nav_main_background_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_nav_main_border_color',
                array(
                    'default' => $header_nav_main_border_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'header_nav_main_hover_background',
                array(
                    'default' => $header_nav_main_hover_background,
                    'transport' => 'postMessage',
                )
            );

            // content section
            $wp_customize->add_setting(
                'content_background_color',
                array(
                    'default' => '#fff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'content_shadow_color',
                array(
                    'default' => '#cccccc',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'author_background_color',
                array(
                    'default' => '#f5f5f7',
                    'transport' => 'postMessage',
                )
            );

            // mid sidebar section
            $wp_customize->add_setting(
                'mid_sidebar_background_color',
                array(
                    'default' => '#fff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_border_color',
                array(
                    'default' => '#e3e3e3',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_section_title',
                array(
                    'default' => '#444',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_section_title_border_1',
                array(
                    'default' => '#f5f5f5',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_section_title_border_2',
                array(
                    'default' => '#222',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_article_title',
                array(
                    'default' => '#222',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_article_text',
                array(
                    'default' => '#5c5c5c',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'mid_sidebar_article_date',
                array(
                    'default' => '#777',
                    'transport' => 'postMessage',
                )
            );


            // sidebar section
            $wp_customize->add_setting(
                'sidebar_background_color',
                array(
                    'default' => $sidebar_background_color,
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_wquote_background_color',
                array(
                    'default' => '#8e6161',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_wquote_heading_color',
                array(
                    'default' => '#ffffff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_wquote_border_color',
                array(
                    'default' => '#8e6161',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_wquote_text_color',
                array(
                    'default' => '#ffffff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_wquote_footer_color',
                array(
                    'default' => '#ffffff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_waudio_background_color',
                array(
                    'default' => '#54878a',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'sidebar_waudio_heading_color',
                array(
                    'default' => '#ffffff',
                    'transport' => 'postMessage',
                )
            );

            # footer
            $wp_customize->add_setting(
                'footer_background_color',
                array(
                    'default' => '#fff',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'footer_menu_color',
                array(
                    'default' => '#222',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'footer_menu_border',
                array(
                    'default' => '#e4e4e4',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'footer_headings_color',
                array(
                    'default' => '#444',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'footer_text_color',
                array(
                    'default' => '#888',
                    'transport' => 'postMessage',
                )
            );

            $wp_customize->add_setting(
                'footer_link_color',
                array(
                    'default' => '#828282',
                    'transport' => 'postMessage',
                )
            );


            # add controls - body
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'body_background_color',
                    array(
                        'label' => 'Background color',
                        'section' => 'body_section',
                        'settings' => 'body_background_color',
                    )
                )
            );

            # add controls - header
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_background_color',
                    array(
                        'label' => 'Background color',
                        'section' => 'header_section',
                        'settings' => 'header_background_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_top_border',
                    array(
                        'label' => 'Top border color',
                        'section' => 'header_section',
                        'settings' => 'header_top_border',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_bottom_border',
                    array(
                        'label' => 'Bottom border color',
                        'section' => 'header_section',
                        'settings' => 'header_bottom_border',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_background_color_mobile',
                    array(
                        'label' => 'Background color (mobile)',
                        'section' => 'header_section',
                        'settings' => 'header_background_color_mobile',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_top_border_mobile',
                    array(
                        'label' => 'Top border color (mobile)',
                        'section' => 'header_section',
                        'settings' => 'header_top_border_mobile',
                    )
                )
            );

            // add controls - header - search form
            $wp_customize->add_control(
                'search_border_width',
                array(
                    'label' => 'Border width (px)',
                    'section' => 'search_section',
                    'type' => 'text',
                )
            );
            $wp_customize->add_control(
                'search_border_radius',
                array(
                    'label' => 'Border radius (px)',
                    'section' => 'search_section',
                    'type' => 'text',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'search_border_color',
                    array(
                        'label' => 'Border color',
                        'section' => 'search_section',
                        'settings' => 'search_border_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'search_border_shadow',
                    array(
                        'label' => 'Inset shadow',
                        'section' => 'search_section',
                        'settings' => 'search_border_shadow',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'search_text_color',
                    array(
                        'label' => 'Text color',
                        'section' => 'search_section',
                        'settings' => 'search_text_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'search_icon_color',
                    array(
                        'label' => 'Search icon color',
                        'section' => 'search_section',
                        'settings' => 'search_icon_color',
                    )
                )
            );


            // add controls - header - weather widget
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'weather_icon_color',
                    array(
                        'label' => 'Weather graphic color',
                        'section' => 'weather_section',
                        'settings' => 'weather_icon_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'weather_location_color',
                    array(
                        'label' => 'Weather title location color',
                        'section' => 'weather_section',
                        'settings' => 'weather_location_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'weather_temperature_color',
                    array(
                        'label' => 'Weather temperature color',
                        'section' => 'weather_section',
                        'settings' => 'weather_temperature_color',
                    )
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'weather_date_color',
                    array(
                        'label' => 'Weather graphic color',
                        'section' => 'weather_section',
                        'settings' => 'weather_date_color',
                    )
                )
            );

            // add controls - header nav section
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_nav_top_background_color',
                    array(
                        'label' => 'Top Navigation Background color',
                        'section' => 'nav_section',
                        'settings' => 'header_nav_top_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_nav_top_border_color',
                    array(
                        'label' => 'Top Navigation Border color',
                        'section' => 'nav_section',
                        'settings' => 'header_nav_top_border_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_nav_main_background_color',
                    array(
                        'label' => 'Main Navigation Background color',
                        'section' => 'nav_section',
                        'settings' => 'header_nav_main_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_nav_main_border_color',
                    array(
                        'label' => 'Main Navigation Border color',
                        'section' => 'nav_section',
                        'settings' => 'header_nav_main_border_color',
                    )
                )
            );


            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_nav_main_hover_background',
                    array(
                        'label' => 'Main Navigation Hover Background',
                        'section' => 'nav_section',
                        'settings' => 'header_nav_main_hover_background',
                    )
                )
            );


            // add controls - content section
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'content_background_color',
                    array(
                        'label' => 'Content Background color',
                        'section' => 'content_section',
                        'settings' => 'content_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'content_shadow_color',
                    array(
                        'label' => 'Content Shadow color',
                        'section' => 'content_section',
                        'settings' => 'content_shadow_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'author_background_color',
                    array(
                        'label' => 'Author Box background color',
                        'section' => 'content_section',
                        'settings' => 'author_background_color',
                    )
                )
            );


            // add controls - mid sidebar section
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_background_color',
                    array(
                        'label' => 'Background color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_border_color',
                    array(
                        'label' => 'Border color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_border_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_section_title',
                    array(
                        'label' => 'Section Title Color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_section_title',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_section_title_border_1',
                    array(
                        'label' => 'Section Title Border 1',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_section_title_border_1',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_section_title_border_2',
                    array(
                        'label' => 'Section Title Border 2',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_section_title_border_2',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_article_title',
                    array(
                        'label' => 'Article Title Color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_article_title',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_article_text',
                    array(
                        'label' => 'Article Text Color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_article_text',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'mid_sidebar_article_date',
                    array(
                        'label' => 'Article Date Color',
                        'section' => 'mid_sidebar_section',
                        'settings' => 'mid_sidebar_article_date',
                    )
                )
            );

            // add controls - sidebar section
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_background_color',
                    array(
                        'label' => 'Sidebar background color',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_wquote_background_color',
                    array(
                        'label' => 'Sidebar Quote Widget background',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_wquote_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_wquote_heading_color',
                    array(
                        'label' => 'Sidebar Quote Widget Title',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_wquote_heading_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_wquote_border_color',
                    array(
                        'label' => 'Sidebar Quote Widget Title Border',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_wquote_border_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_wquote_text_color',
                    array(
                        'label' => 'Sidebar Quote Widget Text',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_wquote_text_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_wquote_footer_color',
                    array(
                        'label' => 'Sidebar Quote Widget Footer (Has Opacity)',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_wquote_footer_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_waudio_background_color',
                    array(
                        'label' => 'Sidebar Audio Widget background',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_waudio_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'sidebar_waudio_heading_color',
                    array(
                        'label' => 'Sidebar Audio Widget Title',
                        'section' => 'sidebar_section',
                        'settings' => 'sidebar_waudio_heading_color',
                    )
                )
            );


            // add controls - footer section
            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_background_color',
                    array(
                        'label' => 'Footer background color',
                        'section' => 'footer_section',
                        'settings' => 'footer_background_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_menu_color',
                    array(
                        'label' => 'Footer menu color',
                        'section' => 'footer_section',
                        'settings' => 'footer_menu_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_menu_border',
                    array(
                        'label' => 'Footer menu border',
                        'section' => 'footer_section',
                        'settings' => 'footer_menu_border',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_headings_color',
                    array(
                        'label' => 'Footer Titles color',
                        'section' => 'footer_section',
                        'settings' => 'footer_headings_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_text_color',
                    array(
                        'label' => 'Footer text color',
                        'section' => 'footer_section',
                        'settings' => 'footer_text_color',
                    )
                )
            );

            $wp_customize->add_control(
                new WP_Customize_Color_Control(
                    $wp_customize,
                    'footer_link_color',
                    array(
                        'label' => 'Footer link color',
                        'section' => 'footer_section',
                        'settings' => 'footer_link_color',
                    )
                )
            );



            # Hook - Using AJAX to update the live preview
            if ( $wp_customize->is_preview() && ! is_admin() ) {
                add_action( 'wp_footer', 'mip_customize_preview', 21);
            }

        }


        /**
          * This will output the custom WordPress settings to the live theme's WP head.
          *
          * Used by hook: 'wp_head'
          *
          * @see add_action('wp_head',$func)
          */

        public static function header_output() {
            ?>
            <!--Customizer CSS-->
            <style type="text/css">
                <?php self::generate_css('body', 'background-color', 'body_background_color', ''); ?>
                <?php self::generate_css('#header-branding', 'background-color', 'header_background_color', ''); ?>
                <?php self::generate_css('#page-header-mobile', 'background-color', 'header_background_color_mobile', ''); ?>
                <?php self::generate_css('#header-branding', 'border-top-color', 'header_nav_top_border_color', ''); ?>
                <?php self::generate_css('#page-header-mobile', 'border-top-color', 'header_top_border_mobile', ''); ?>
                <?php self::generate_css('#header-branding', 'border-bottom-color', 'header_nav_main_border_color', ''); ?>
                <?php self::generate_css('#header-navigation, #header-navigation ul li a', 'border-color', 'header_nav_main_border_color', ''); ?>
                <?php self::generate_css('#header-branding .weather i.icon', 'color', 'weather_icon_color', ''); ?>
                <?php self::generate_css('#header-branding .weather h3', 'color', 'weather_location_color', ''); ?>
                <?php self::generate_css('#header-branding .weather h3 span.temp', 'color', 'weather_temperature_color', ''); ?>
                <?php self::generate_css('#header-branding .weather span.date', 'color', 'weather_date_color', ''); ?>
                <?php self::generate_css('#header-branding #search-form', 'border-width', 'search_border_width', ''); ?>
                <?php self::generate_css('#header-branding #search-form', 'border-color', 'search_border_color', ''); ?>
                <?php self::generate_css('#header-branding #search-form', '-webkit-border-radius', 'search_border_radius', ''); ?>
                <?php self::generate_css('#header-branding #search-form', 'border-radius', 'search_border_radius', ''); ?>
                <?php self::generate_css('#header-branding #search-form', '-webkit-box-shadow', 'search_border_shadow', 'inset 0 3px 0 0 '); ?>
                <?php self::generate_css('#header-branding #search-form', 'box-shadow', 'search_border_shadow', 'inset 0 3px 0 0 '); ?>
                <?php self::generate_css('#header-branding #search-form input', 'color', 'search_text_color', ''); ?>
                <?php self::generate_css('#header-branding #search-form button', 'color', 'search_icon_color', ''); ?>

                <?php self::generate_css('#top-navigation', 'background-color', 'header_nav_top_background_color', ''); ?>
                <?php self::generate_css('#header-navigation', 'background-color', 'header_nav_main_background_color', ''); ?>

                <?php self::generate_css('#header-navigation ul li.search-nav .dropdown-menu', 'background-color', 'header_nav_main_background_color', ''); ?>
                <?php self::generate_css('#header-navigation ul li.search-nav .dropdown-menu input', 'background-color', 'header_background_color', ''); ?>

                <?php self::generate_css('#top-navigation ul ul', 'background-color', 'header_nav_top_background_color', ''); ?>
                <?php self::generate_css('#header-navigation ul ul', 'background-color', 'header_nav_main_background_color', ''); ?>
                <?php self::generate_css('#top-navigation ul li', 'border-color', 'header_nav_top_border_color', ''); ?>
                <?php self::generate_css('#header-navigation ul li', 'border-color', 'header_nav_main_border_color', ''); ?>
                <?php self::generate_css('#header-navigation ul li.current a, #header-navigation ul li.current-menu-item a, #header-navigation ul li a:hover, #header-navigation ul li:hover a, #header-navigation ul li a:focus', 'background-color', 'header_nav_main_hover_background', ''); ?>

                <?php self::generate_css('#page-content', 'background-color', 'content_background_color', ''); ?>
                <?php self::generate_css('#page-content', '-webkit-box-shadow', 'content_shadow_color', '0 0 12px 0 '); ?>
                <?php self::generate_css('#page-content', 'box-shadow', 'content_shadow_color', '0 0 12px 0 '); ?>
                <?php self::generate_css('.author-box', 'background-color', 'author_background_color', ''); ?>

                <?php self::generate_css('#sidebar-mid', 'background-color', 'mid_sidebar_background_color', ''); ?>
                <?php self::generate_css('#sidebar-mid', 'border-left-color', 'mid_sidebar_border_color', ''); ?>
                <?php self::generate_css('#sidebar-mid header h2', 'color', 'mid_sidebar_section_title', ''); ?>
                <?php self::generate_css('#sidebar-mid header h2', 'border-color', 'mid_sidebar_section_title_border_1', ''); ?>
                <?php self::generate_css('#sidebar-mid header span.borderline', 'background', 'mid_sidebar_section_title_border_2', ''); ?>
                <?php self::generate_css('#sidebar-mid aside article h3 a', 'color', 'mid_sidebar_article_title', ''); ?>
                <?php self::generate_css('#sidebar-mid aside article span.text', 'color', 'mid_sidebar_article_text', ''); ?>
                <?php self::generate_css('#sidebar-mid aside article span.published', 'color', 'mid_sidebar_article_date', ''); ?>

                <?php self::generate_css('#sidebar', 'background-color', 'sidebar_background_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote', 'background-color', 'sidebar_wquote_background_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote header h2', 'color', 'sidebar_wquote_heading_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote header span.borderline', 'background-color', 'sidebar_wquote_heading_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote header h2', 'border-color', 'sidebar_wquote_border_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote blockquote p', 'color', 'sidebar_wquote_text_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-quote blockquote footer', 'color', 'sidebar_wquote_footer_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-singles', 'background-color', 'sidebar_waudio_background_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-singles header h2', 'color', 'sidebar_waudio_heading_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-singles header h2', 'border-color', 'sidebar_waudio_background_color', ''); ?>
                <?php self::generate_css('#page-content .sidebar .module-singles header span.borderline', 'background-color', 'sidebar_waudio_heading_color', ''); ?>

                <?php self::generate_css('#page-footer .container', 'background-color', 'footer_background_color', ''); ?>
                <?php self::generate_css('#foot-menu ul li a', 'border-color', 'footer_menu_color', ''); ?>
                <?php self::generate_css('#foot-menu', 'color', 'footer_menu_border', ''); ?>
                <?php self::generate_css('#page-footer .foot-widgets h2', 'color', 'footer_headings_color', ''); ?>
                <?php self::generate_css('#page-footer .foot-widgets aside', 'color', 'footer_text_color', ''); ?>
                <?php self::generate_css('#page-footer .foot-widgets aside.widget li:before', 'color', 'footer_text_color', ''); ?>
                <?php self::generate_css('#page-footer .copyright', 'color', 'footer_text_color', ''); ?>
                <?php self::generate_css('#page-footer .foot-widgets a', 'color', 'footer_link_color', ''); ?>
                <?php self::generate_css('#page-footer .copyright a', 'color', 'footer_link_color', ''); ?>

            </style>
            <!--/Customizer CSS-->
            <?php
        }


        /**
        * This will generate a line of CSS for use in header output. If the setting
        * ($mod_name) has no defined value, the CSS will not be output.
        *
        * @uses get_theme_mod()
        * @param string $selector CSS selector
        * @param string $style The name of the CSS *property* to modify
        * @param string $mod_name The name of the 'theme_mod' option to fetch
        * @param string $prefix Optional. Anything that needs to be output before the CSS property
        * @param string $postfix Optional. Anything that needs to be output after the CSS property
        * @param bool $echo Optional. Whether to print directly to the page (default: true).
        * @return string Returns a single line of CSS with selectors and a property.
        */
        public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
            $return = '';
            $mod = get_theme_mod($mod_name);
            if ( ! empty( $mod ) ) {
                $return = sprintf('%s { %s:%s; }',
                    $selector,
                    $style,
                    $prefix.$mod.$postfix
                );
                if ( $echo ) {
                    echo $return;
                }
            }
            return $return;
        }

    }

}


// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'MipTheme_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'MipTheme_Customize' , 'header_output' ) );


/*
 * Using AJAX to update the live preview
 */

# Function
function mip_customize_preview() {
    ?>
    <script type="text/javascript">
        ( function( $ ) {
            // body
            wp.customize('body_background_color',function( value ) {
                value.bind(function(to) {
                    $('body').css('background-color', to );
                });
            });
            // header
            wp.customize('image_upload_logo_desktop',function( value ) {
                value.bind(function(to) {
                    $('#header-branding h1 img').attr('src', to );
                });
            });
            wp.customize('image_upload_logo_mobile',function( value ) {
                value.bind(function(to) {
                    $('#page-header-mobile h1 img').attr('src', to );
                });
            });
            wp.customize('header_background_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding').css('background-color', to );
                    $('#header-navigation ul li.search-nav .dropdown-menu input').css('background-color', to );
                });
            });
            wp.customize('header_top_border',function( value ) {
                value.bind(function(to) {
                    $('#header-branding').css('border-top-color', to );
                });
            });
            wp.customize('header_background_color_mobile',function( value ) {
                value.bind(function(to) {
                    $('#page-header-mobile').css('background-color', to );
                });
            });
            wp.customize('header_top_border_mobile',function( value ) {
                value.bind(function(to) {
                    $('#page-header-mobile').css('border-top-color', to );
                });
            });
            wp.customize('header_bottom_border',function( value ) {
                value.bind(function(to) {
                    $('#header-branding').css('border-bottom-color', to );
                });
            });
            // header - weather widget
            wp.customize('weather_icon_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding .weather i.icon').css('color', to );
                });
            });
            wp.customize('weather_location_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding .weather h3').css('color', to );
                });
            });
            wp.customize('weather_temperature_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding .weather h3 span.temp').css('color', to );
                });
            });
            wp.customize('weather_date_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding .weather span.date').css('color', to );
                });
            });
            // header - search form
            wp.customize('search_border_width',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('border-width', to );
                });
            });
            wp.customize('search_border_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('border-color', to );
                });
            });
            wp.customize('search_border_radius',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('-webkit-border-radius', to );
                });
            });
            wp.customize('search_border_radius',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('border-radius', to );
                });
            });
            wp.customize('search_border_shadow',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('-webkit-box-shadow', 'inset 0 3px 0 0 '+ to );
                });
            });
            wp.customize('search_border_shadow',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form').css('box-shadow', 'inset 0 3px 0 0 '+ to );
                });
            });
            wp.customize('search_text_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form input').css('color', to );
                });
            });
            wp.customize('search_icon_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding #search-form button').css('color', to );
                });
            });

            // header nav
            wp.customize('header_nav_top_background_color',function( value ) {
                value.bind(function(to) {
                    $('#top-navigation, #top-navigation ul ul').css('background-color', to );
                    $('#header-navigation ul li.search-nav .dropdown-menu').css('background-color', to );
                });
            });

            wp.customize('header_nav_main_background_color',function( value ) {
                value.bind(function(to) {
                    $('#header-navigation, #header-navigation ul ul').css('background-color', to );
                });
            });

            wp.customize('header_nav_top_border_color',function( value ) {
                value.bind(function(to) {
                    //$('#top-navigation ul li').css('border-color', to );
                    $('#header-branding').css('border-top-color', to );
                });
            });

            wp.customize('header_nav_main_border_color',function( value ) {
                value.bind(function(to) {
                    $('#header-branding').css('border-bottom-color', to );
                    $('#header-navigation, #header-navigation ul li a').css('border-color', to );


                    //$('#header-navigation ul li').css('border-color', to );
                });
            });

            wp.customize('header_nav_main_hover_background',function( value ) {
                value.bind(function(to) {
                    $('#header-navigation ul li a:hover').css('background-color', to );
                });
            });


            // content
            wp.customize('content_background_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content').css('background-color', to );
                });
            });
            wp.customize('content_shadow_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content').css('-webkit-box-shadow', '0 0 12px 0 '+ to );
                });
            });
            wp.customize('content_shadow_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content').css('box-shadow', '0 0 12px 0 '+ to );
                });
            });
            wp.customize('author_background_color',function( value ) {
                value.bind(function(to) {
                    $('.author-box').css('background-color', to );
                });
            });


            // sidebar mid
            wp.customize('mid_sidebar_background_color',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid').css('background-color', to );
                });
            });

            wp.customize('mid_sidebar_border_color',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid').css('border-color', to );
                });
            });

            wp.customize('mid_sidebar_section_title',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid header h2').css('color', to );
                });
            });

            wp.customize('mid_sidebar_section_title_border_1',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid header h2').css('border-color', to );
                });
            });

            wp.customize('mid_sidebar_section_title_border_2',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid header span.borderline').css('background', to );
                });
            });

            wp.customize('mid_sidebar_article_title',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid aside article h3 a').css('color', to );
                });
            });

            wp.customize('mid_sidebar_article_text',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid aside article span.text').css('color', to );
                });
            });

            wp.customize('mid_sidebar_article_date',function( value ) {
                value.bind(function(to) {
                    $('#sidebar-mid aside article span.published').css('color', to );
                });
            });

            // sidebar
            wp.customize('sidebar_background_color',function( value ) {
                value.bind(function(to) {
                    $('#sidebar').css('background-color', to );
                });
            });
            wp.customize('sidebar_wquote_background_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-quote').css('background-color', to );
                });
            });
            wp.customize('sidebar_wquote_heading_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-quote header h2').css('color', to );
                    $('#page-content .sidebar .module-quote header span.borderline').css('background-color', to );
                });
            });
            wp.customize('sidebar_wquote_border_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-quote header h2').css('border-color', to );
                });
            });
            wp.customize('sidebar_wquote_text_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-quote blockquote p').css('color', to );
                });
            });
            wp.customize('sidebar_wquote_footer_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-quote blockquote footer').css('color', to );
                });
            });
            wp.customize('sidebar_waudio_background_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-singles').css('background-color', to );
                    $('#page-content .sidebar .module-singles header h2').css('border-color', to );
                });
            });
            wp.customize('sidebar_waudio_heading_color',function( value ) {
                value.bind(function(to) {
                    $('#page-content .sidebar .module-singles header h2').css('color', to );
                    $('#page-content .sidebar .module-singles header span.borderline').css('background-color', to );
                });
            });


            // footer
            wp.customize('footer_background_color',function( value ) {
                value.bind(function(to) {
                    $('#page-footer .container').css('background-color', to );
                });
            });
            wp.customize('footer_menu_border',function( value ) {
                value.bind(function(to) {
                    $('#foot-menu').css('border-color', to );
                });
            });
            wp.customize('footer_menu_color',function( value ) {
                value.bind(function(to) {
                    $('#foot-menu ul li a').css('color', to );
                });
            });
            wp.customize('footer_headings_color',function( value ) {
                value.bind(function(to) {
                    $('#page-footer .foot-widgets h2').css('color', to );
                });
            });
            wp.customize('footer_text_color',function( value ) {
                value.bind(function(to) {
                    $('#page-footer .foot-widgets aside').css('color', to );
                    //$('#page-footer aside.widget li:before').css('color', to );
                    $('#page-footer .copyright').css('color', to );
                });
            });
            wp.customize('footer_link_color',function( value ) {
                value.bind(function(to) {
                    $('#page-footer .foot-widgets a').css('color', to );
                    $('#page-footer .copyright a').css('color', to );
                });
            });

        } )( jQuery )
    </script>
    <?php
}  // End function example_customize_preview()


/*
 * Help functions
 */


# sanitization - text value
function miptheme_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}


# sanitization - checkbox value
function miptheme_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

# sanitization - integer value
function miptheme_sanitize_integer( $input ) {
    if( is_numeric( $input ) ) {
        return intval( $input );
    }
}
