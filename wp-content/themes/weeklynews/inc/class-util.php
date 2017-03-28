<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Util' ) ) {

    class MipTheme_Util
    {

        protected static $carousel_index = 1;

        static function read_theme_settings()
        {
            MipTheme_Global::$mp_options = get_option(THEMEOPTIONSNAME);
        }


        // get a theme meta value from wp
        static function get_meta($option_name, $object_id, $default_value = '')
        {
            if (get_post_meta($object_id, $option_name, true)) {
                return get_post_meta($object_id, $option_name, true);
            } else {
                if (!empty($default_value)) {
                    return $default_value;
                } else {
                    return;
                }
            }
        }

        # Set Fallback for Navigation
        static function mip_fb_nav_menu()
        {
            $output = '<ul class="nav clearfix">
                            <li><a href="' . home_url() . '/wp-admin/nav-menus.php?action=locations">Click here - to select or create a menu</a></li>
                        </ul>';
            return $output;
        }

        # Set Navigation Wrapper
        static function mip_nav_menu_wrapper()
        {
            global $mp_weeklynews;
            $wrap = '';

            if ($mp_weeklynews['_mp_header_sticky_menu'] && isset($mp_weeklynews['_mp_header_sticky_menu_logo']['url'])) $wrap .= '<a href="' . home_url('/') . '"><span class="sticky-logo"></span></a>';
            $wrap .= '<ul id="%1$s" class="%2$s">';
            $wrap .= '%3$s';


            if ($mp_weeklynews['_mp_header_show_search']) {
                $wrap .= '<li class="search-nav"><a id="search-nav-button" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-search"></span></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <form role="search" method="get" class="form-inline" action="' . home_url('/') . '">
                                        <button class="btn"><span class="glyphicon glyphicon-search"></span></button>
                                        <div class="form-group">
                                            <input id="nav-search" type="text" name="s"  value="' . get_search_query() . '" >
                                        </div>

                                    </form>
                                </div>
                            </li>';
            }


            if ($mp_weeklynews['_mp_header_show_options']) {
                if (!is_user_logged_in()) {
                    $wrap .= '<li class="options"><a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log in', THEMENAME) . '</a></li>';
                    if (get_option('users_can_register'))
                        $wrap .= '<li class="options"><a href="' . site_url('wp-login.php?action=register', 'login') . '"><span class="glyphicon glyphicon-pencil"></span> ' . __('Register', THEMENAME) . '</a></li>';
                } else {
                    $wrap .= '<li class="options"><a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log out', THEMENAME) . '</a></li>';
                    $wrap .= '<li class="options"><a href="' . admin_url() . 'edit.php"><span class="glyphicon glyphicon-pencil"></span> ' . __('My Posts', THEMENAME) . '</a></li>';
                }
            }

            if ($mp_weeklynews['_mp_header_show_social_networking']) {
                $wrap .= '<li class="soc-media"><a href="#"><span class="glyphicon glyphicon-plus"></span> ' . __('Follow', THEMENAME) . '</a>';
                $wrap .= '<div class="dropnav-container"><ul class="dropnav-menu">';
                $wrap .= (isset($mp_weeklynews['_mp_social_facebook']) && ($mp_weeklynews['_mp_social_facebook'] != '')) ? '<li class="soc-links soc-facebook"><a href="' . $mp_weeklynews['_mp_social_facebook'] . '" target="_blank">Facebook</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_twitter']) && ($mp_weeklynews['_mp_social_twitter'] != '')) ? '<li class="soc-links soc-twitter"><a href="' . $mp_weeklynews['_mp_social_twitter'] . '" target="_blank">Twitter</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_google']) && ($mp_weeklynews['_mp_social_google'] != '')) ? '<li class="soc-links soc-google"><a href="' . $mp_weeklynews['_mp_social_google'] . '" target="_blank">Google+</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_linkedin']) && ($mp_weeklynews['_mp_social_linkedin'] != '')) ? '<li class="soc-links soc-linkedin"><a href="' . $mp_weeklynews['_mp_social_linkedin'] . '" target="_blank">Linkedin</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_pinterest']) && ($mp_weeklynews['_mp_social_pinterest'] != '')) ? '<li class="soc-links soc-pinterest"><a href="' . $mp_weeklynews['_mp_social_pinterest'] . '" target="_blank">Pinterest</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_flickr']) && ($mp_weeklynews['_mp_social_flickr'] != '')) ? '<li class="soc-links soc-flickr"><a href="' . $mp_weeklynews['_mp_social_flickr'] . '" target="_blank">Flickr</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_youtube']) && ($mp_weeklynews['_mp_social_youtube'] != '')) ? '<li class="soc-links soc-youtube"><a href="' . $mp_weeklynews['_mp_social_youtube'] . '" target="_blank">Youtube</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vimeo']) && ($mp_weeklynews['_mp_social_vimeo'] != '')) ? '<li class="soc-links soc-vimeo"><a href="' . $mp_weeklynews['_mp_social_vimeo'] . '" target="_blank">Vimeo</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_instagram']) && ($mp_weeklynews['_mp_social_instagram'] != '')) ? '<li class="soc-links soc-instagram"><a href="' . $mp_weeklynews['_mp_social_instagram'] . '" target="_blank">Instagram</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_dribbble']) && ($mp_weeklynews['_mp_social_dribbble'] != '')) ? '<li class="soc-links soc-dribbble"><a href="' . $mp_weeklynews['_mp_social_dribbble'] . '" target="_blank">Dribbble</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_behance']) && ($mp_weeklynews['_mp_social_behance'] != '')) ? '<li class="soc-links soc-behance"><a href="' . $mp_weeklynews['_mp_social_behance'] . '" target="_blank">Behance</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_tumblr']) && ($mp_weeklynews['_mp_social_tumblr'] != '')) ? '<li class="soc-links soc-tumblr"><a href="' . $mp_weeklynews['_mp_social_tumblr'] . '" target="_blank">Tumblr</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_reddit']) && ($mp_weeklynews['_mp_social_reddit'] != '')) ? '<li class="soc-links soc-reddit"><a href="' . $mp_weeklynews['_mp_social_reddit'] . '" target="_blank">Reddit</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vkontakte']) && ($mp_weeklynews['_mp_social_vkontakte'] != '')) ? '<li class="soc-links soc-vkontakte"><a href="' . $mp_weeklynews['_mp_social_vkontakte'] . '" target="_blank">VKontakte</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_weibo']) && ($mp_weeklynews['_mp_social_weibo'] != '')) ? '<li class="soc-links soc-weibo"><a href="' . $mp_weeklynews['_mp_social_weibo'] . '" target="_blank">Weibo</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_wechat']) && ($mp_weeklynews['_mp_social_wechat'] != '')) ? '<li class="soc-links soc-wechat"><a href="' . $mp_weeklynews['_mp_social_wechat'] . '" target="_blank">WeChat</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_qq']) && ($mp_weeklynews['_mp_social_qq'] != '')) ? '<li class="soc-links soc-qq"><a href="' . $mp_weeklynews['_mp_social_qq'] . '" target="_blank">QQ</a></li>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_rss']) && ($mp_weeklynews['_mp_social_rss'] != '')) ? '<li class="soc-links soc-rss"><a href="' . $mp_weeklynews['_mp_social_rss'] . '" target="_blank">RSS</a></li>' : '';
                //$wrap .= ( isset($mp_weeklynews['_mp_social_500px']) && ($mp_weeklynews['_mp_social_500px'] != '') )        ? '<li class="soc-links soc-500px"><a href="'. $mp_weeklynews['_mp_social_500px'] .'">500px</a></li>' : '';
                $wrap .= '</ul></div>';
                $wrap .= '</li>';
            }

            $wrap .= '</ul>';
            return $wrap;
        }


        // set top logo
        static function miptheme_set_logo()
        {
            global $mp_weeklynews;
            $retina_logo = (isset($mp_weeklynews['_mp_header_logo_desktop_retine']['url']) && ($mp_weeklynews['_mp_header_logo_desktop_retine']['url'] != '')) ? ' data-retina="' . esc_url($mp_weeklynews['_mp_header_logo_desktop_retine']['url']) . '"' : '';
            if (is_front_page()) {
                return '<h1><a itemprop="url" href="' . get_bloginfo('url') . '"><img src="' . esc_url($mp_weeklynews['_mp_header_logo_desktop']['url']) . '" width="' . esc_attr($mp_weeklynews['_mp_header_logo_desktop']['width']) . '" height="' . esc_attr($mp_weeklynews['_mp_header_logo_desktop']['height']) . '" alt="' . get_bloginfo('name') . '"' . $retina_logo . ' /></a><span>' . get_bloginfo('name') . '</span></h1>';
            } else {
                return '<div class="logo"><a itemprop="url" href="' . get_bloginfo('url') . '"><img src="' . esc_url($mp_weeklynews['_mp_header_logo_desktop']['url']) . '" width="' . esc_attr($mp_weeklynews['_mp_header_logo_desktop']['width']) . '" height="' . esc_attr($mp_weeklynews['_mp_header_logo_desktop']['height']) . '" alt="' . get_bloginfo('name') . '"' . $retina_logo . ' /></a></div>';
            }
        }


        function miptheme_register_replacement($link)
        {
            if (!is_user_logged_in()) {
                if (get_option('users_can_register'))
                    $link = '<li class="options"><a href="' . site_url('wp-login.php?action=register', 'login') . '"><span class="glyphicon glyphicon-pencil"></span> ' . __('Register', THEMENAME) . '</a></li>';
                else
                    $link = '';
            } else {
                $link = '<li class="options"><a href="' . admin_url() . 'edit.php"><span class="glyphicon glyphicon-pencil"></span> ' . __('My Posts', THEMENAME) . '</a></li>';
            }
            return $link;
        }


        # Login links
        function miptheme_loginout_replacement($text)
        {
            if (!is_user_logged_in())
                $link = '<a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log in', THEMENAME) . '</a>';
            else
                $link = '<a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log out', THEMENAME) . '</a>';

            return $link;
        }


        # Set Top Navigation Wrapper
        static function mip_mobile_menu_wrapper()
        {
            global $mp_weeklynews;

            $wrap = '';
            $wrap .= '<ul id="%1$s" class="%2$s">';

            $wrap .= '%3$s';

            if (isset($mp_weeklynews['_mp_header_mobilemenu_show_options'])) {
                if ((bool)$mp_weeklynews['_mp_header_mobilemenu_show_options']['register']) {
                    if (!is_user_logged_in()) {
                        if (get_option('users_can_register')) $wrap .= '<li><a href="' . site_url('wp-login.php?action=register', 'login') . '"><span class="glyphicon glyphicon-pencil"></span>' . __('Register', THEMENAME) . '</a></li>';
                    } else {
                        $wrap .= '<li><a href="' . admin_url() . 'edit.php"><span class="glyphicon glyphicon-pencil"></span>' . __('My Posts', THEMENAME) . '</a></li>';
                    }
                }

                if ((bool)$mp_weeklynews['_mp_header_mobilemenu_show_options']['login']) {
                    if (!is_user_logged_in()) {
                        $wrap .= '<li><a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span>' . __('Log in', THEMENAME) . '</a></li>';
                    } else {
                        $wrap .= '<li><a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span>' . __('Log out', THEMENAME) . '</a></li>';
                    }
                }
            }

            $wrap .= '</ul>';
            return $wrap;
        }


        # Set Top Navigation Wrapper
        static function mip_top_menu_wrapper()
        {
            global $mp_weeklynews;
            $streched_menu = (isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container';

            $wrap = '';
            $wrap .= '<div id="top-navigation"><div class="' . $streched_menu . '"><nav id="top-menu">';
            $wrap .= '<ul id="%1$s" class="%2$s">';

            if (isset($mp_weeklynews['_mp_header_topmenu_show_date']) && ($mp_weeklynews['_mp_header_topmenu_show_date'] != 'none')) {
                $wrap .= '<li class="date ' . $mp_weeklynews['_mp_header_topmenu_show_date'] . '"><span>' . date_i18n(MIPTHEME_DATE_HEADER) . '</span></li>';
            }

            $wrap .= '%3$s';

            if (isset($mp_weeklynews['_mp_header_topmenu_show_options'])) {
                $wrap .= '<li class="options">';

                if ((bool)$mp_weeklynews['_mp_header_topmenu_show_options']['register']) {
                    if (!is_user_logged_in()) {
                        if (get_option('users_can_register')) $wrap .= '<a href="' . site_url('wp-login.php?action=register', 'login') . '"><span class="glyphicon glyphicon-pencil"></span> ' . __('Register', THEMENAME) . '</a>';
                    } else {
                        $wrap .= '<a href="' . admin_url() . 'edit.php"><span class="glyphicon glyphicon-pencil"></span> ' . __('My Posts', THEMENAME) . '</a>';
                    }
                }

                if ((bool)$mp_weeklynews['_mp_header_topmenu_show_options']['login']) {
                    if (!is_user_logged_in()) {
                        $wrap .= '<a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log in', THEMENAME) . '</a>';
                    } else {
                        $wrap .= '<a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log out', THEMENAME) . '</a>';
                    }
                }

                $wrap .= '</li>';
            }

            if ($mp_weeklynews['_mp_header_top_show_social_networking']) {
                $wrap .= '<li class="soc-media">';
                $wrap .= (isset($mp_weeklynews['_mp_social_facebook']) && ($mp_weeklynews['_mp_social_facebook'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_facebook'] . '" target="_blank"><i class="fa fa-facebook"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_twitter']) && ($mp_weeklynews['_mp_social_twitter'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_twitter'] . '" target="_blank"><i class="fa fa-twitter"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_google']) && ($mp_weeklynews['_mp_social_google'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_google'] . '" target="_blank"><i class="fa fa-google-plus"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_linkedin']) && ($mp_weeklynews['_mp_social_linkedin'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_linkedin'] . '" target="_blank"><i class="fa fa-linkedin"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_pinterest']) && ($mp_weeklynews['_mp_social_pinterest'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_pinterest'] . '" target="_blank"><i class="fa fa-pinterest"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_flickr']) && ($mp_weeklynews['_mp_social_flickr'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_flickr'] . '" target="_blank"><i class="fa fa-flickr"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_youtube']) && ($mp_weeklynews['_mp_social_youtube'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_youtube'] . '" target="_blank"><i class="fa fa-youtube"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vimeo']) && ($mp_weeklynews['_mp_social_vimeo'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_vimeo'] . '" target="_blank"><i class="fa fa-vimeo-square"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_instagram']) && ($mp_weeklynews['_mp_social_instagram'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_instagram'] . '" target="_blank"><i class="fa fa-instagram"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_dribbble']) && ($mp_weeklynews['_mp_social_dribbble'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_dribbble'] . '" target="_blank"><i class="fa fa-dribbble"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_behance']) && ($mp_weeklynews['_mp_social_behance'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_behance'] . '" target="_blank"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_tumblr']) && ($mp_weeklynews['_mp_social_tumblr'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_tumblr'] . '" target="_blank"><i class="fa fa-tumblr"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_reddit']) && ($mp_weeklynews['_mp_social_reddit'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_reddit'] . '" target="_blank"><i class="fa fa-reddit"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vkontakte']) && ($mp_weeklynews['_mp_social_vkontakte'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_vkontakte'] . '" target="_blank"><i class="fa fa-vk"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_weibo']) && ($mp_weeklynews['_mp_social_weibo'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_weibo'] . '" target="_blank"><i class="fa fa-tencent-weibo"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_wechat']) && ($mp_weeklynews['_mp_social_wechat'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_wechat'] . '" target="_blank"><i class="fa fa-weixin"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_qq']) && ($mp_weeklynews['_mp_social_qq'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_qq'] . '" target="_blank"><i class="fa fa-qq"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_rss']) && ($mp_weeklynews['_mp_social_rss'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_rss'] . '" target="_blank"><i class="fa fa-rss"></i></a>' : '';
                //$wrap .= ( isset($mp_weeklynews['_mp_social_500px']) && ($mp_weeklynews['_mp_social_500px'] != '')  )           ? '<a href="'. $mp_weeklynews['_mp_social_500px'] .'"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= '</li>';
            }

            $wrap .= '</ul></nav></div></div>';
            return $wrap;
        }

        # Set Top Navigation Fallback
        static function mip_fb_top_menu()
        {
            global $mp_weeklynews;

            $wrap = '';
            $wrap .= '<div id="top-navigation"><div class="container"><nav id="top-menu">';
            $wrap .= '<ul>';

            if ($mp_weeklynews['_mp_header_top_show_social_networking']) {
                $wrap .= '<li class="soc-media">';
                $wrap .= (isset($mp_weeklynews['_mp_social_facebook']) && ($mp_weeklynews['_mp_social_facebook'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_facebook'] . '"><i class="fa fa-facebook"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_twitter']) && ($mp_weeklynews['_mp_social_twitter'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_twitter'] . '"><i class="fa fa-twitter"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_google']) && ($mp_weeklynews['_mp_social_google'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_google'] . '"><i class="fa fa-google-plus"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_linkedin']) && ($mp_weeklynews['_mp_social_linkedin'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_linkedin'] . '"><i class="fa fa-linkedin"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_pinterest']) && ($mp_weeklynews['_mp_social_pinterest'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_pinterest'] . '"><i class="fa fa-pinterest"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_flickr']) && ($mp_weeklynews['_mp_social_flickr'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_flickr'] . '"><i class="fa fa-flickr"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_youtube']) && ($mp_weeklynews['_mp_social_youtube'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_youtube'] . '"><i class="fa fa-youtube"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vimeo']) && ($mp_weeklynews['_mp_social_vimeo'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_vimeo'] . '"><i class="fa fa-vimeo-square"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_dribbble']) && ($mp_weeklynews['_mp_social_dribbble'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_dribbble'] . '"><i class="fa fa-dribbble"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_behance']) && ($mp_weeklynews['_mp_social_behance'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_behance'] . '"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_tumblr']) && ($mp_weeklynews['_mp_social_tumblr'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_tumblr'] . '"><i class="fa fa-tumblr"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_vkontakte']) && ($mp_weeklynews['_mp_social_vkontakte'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_vkontakte'] . '"><i class="fa fa-vk"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_weibo']) && ($mp_weeklynews['_mp_social_weibo'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_weibo'] . '"><i class="fa fa-tencent-weibo"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_wechat']) && ($mp_weeklynews['_mp_social_wechat'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_wechat'] . '"><i class="fa fa-weixin"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_qq']) && ($mp_weeklynews['_mp_social_qq'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_qq'] . '"><i class="fa fa-qq"></i></a>' : '';
                $wrap .= (isset($mp_weeklynews['_mp_social_rss']) && ($mp_weeklynews['_mp_social_rss'] != '')) ? '<a href="' . $mp_weeklynews['_mp_social_rss'] . '"><i class="fa fa-rss"></i></a>' : '';
                //$wrap .= ( isset($mp_weeklynews['_mp_social_500px']) && ($mp_weeklynews['_mp_social_500px'] != '')  )           ? '<a href="'. $mp_weeklynews['_mp_social_500px'] .'"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= '</li>';
            }

            if ((bool)$mp_weeklynews['_mp_header_topmenu_show_options']['login']) {
                if (!is_user_logged_in()) {
                    $wrap .= '<li class="options"><a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log in', THEMENAME) . '</a></li>';
                } else {
                    $wrap .= '<li class="options"><a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log out', THEMENAME) . '</a></li>';
                }
            }

            $wrap .= '</ul></nav></div></div>';
            return $wrap;
        }


        static function ShowRating($value, $class = 'stars')
        {
            if ($value) {
                return '<span class="' . $class . '"><span style="width:' . $value . '%;"></span></span>';
            }
        }


        // get category array
        static function get_categoris_array($all_categories = true)
        {
            if (is_admin() === false) {
                return;
            }

            $categories = get_categories(array(
                'hide_empty' => 0
            ));

            $categories_array_walker = new categories_array_walker;
            $categories_array_walker->walk($categories, 4);

            if ($all_categories === true) {
                $categories_buffer[' Show all categories '] = '';
                return array_merge(
                    $categories_buffer,
                    $categories_array_walker->array_buffer
                );
            } else {
                return $categories_array_walker->array_buffer;
            }
        }


        // get woocommerce category array
        static function get_wc_categories_array()
        {
            if (is_admin() === false) {
                return;
            }

            $cats = array();

            $taxonomies = array(
                'product_cat'
            );
            $args = array();
            $categories = get_terms(
                $taxonomies,
                $args
            );

            foreach ($categories as $val) {
                $cats[$val->name] = $val->term_id;
            }

            wp_reset_postdata();
            return $cats;
        }


        // get ads system array
        static function get_adssystem_array()
        {
            if (is_admin() === false) {
                return;
            }

            $ads = array();
            $args = array('post_type' => 'mp_ads', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC');
            $r = new WP_Query($args);
            while ($r->have_posts()) : $r->the_post();
                $ads[get_the_title()] = get_the_ID();
            endwhile;
            wp_reset_postdata();

            return $ads;
        }


        static function ShortenText($text, $count)
        {
            if ($count > 0) {
                // Change to the number of characters you want to display
                $chars_limit = $count;
                $chars_text = strlen($text);
                $text = strip_tags($text . " ");
                $text = preg_replace("/\[caption.*\[\/caption\]/", '', $text);
                $text = str_replace(']]>', ']]>', $text); // remove caption
                $text = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);// remove caption
                $text = substr($text, 0, $chars_limit);
                $text = substr($text, 0, strrpos($text, ' '));

                // If the text has more characters that your limit,
                //add ... so the user knows the text is actually longer
                if ($chars_text > $chars_limit) {
                    $text = $text . "...";
                }
                return $text;
            }
        }

        # Get parent root category
        static function get_category_top_parent_id($catid)
        {
            $catParent = 0;
            while ($catid) {
                $cat = get_category($catid); // get the object for the catid
                $catid = $cat->category_parent; // assign parent ID (if exists) to $catid
                $catParent = $cat->cat_ID;
            }
            return $catParent;
        }

        # Get last 'child' category
        static function get_category_last_child_id($category)
        {
            $curr_cat_id = $category[0]->cat_ID;
            foreach ($category as $childcat) {
                $curr_root_id_tmp = MipTheme_Util::get_category_top_parent_id($childcat->cat_ID);
                if ($childcat->cat_ID != $curr_root_id_tmp) {
                    $curr_cat_id = $childcat->cat_ID;
                }
            }
            return $curr_cat_id;
        }

        # Turn a category ID to a Name
        static function cat_id_to_name($id)
        {
            foreach ((array)(get_categories()) as $category) {
                if ($id == $category->cat_ID) {
                    return $category->cat_name;
                    break;
                }
            }
        }

        # Turn category name to ID
        static function get_category_id($cat_name)
        {
            $term = get_term_by('name', $cat_name, 'category');
            if (is_object($term)) {
                return $term->term_id;
            } else {
                return '';
            }
        }

        static function cat_id_to_slug($id)
        {
            foreach ((array)(get_categories()) as $category) {
                if ($id == $category->cat_ID) {
                    return $category->slug;
                    break;
                }
            }
        }

        static function return_category($post_id, $inc_cat, $cat_display = 'root')
        {
            $cat_id = 0;
            $cat_name = '';
            $cat_label_id = get_post_meta($post_id, '_mp_category_label', true);
            $categories = get_the_category($post_id);

            // Assemble a tree of category relationships
            // Also re-key the category array for easier
            // reference
            $category_tree = array();
            $keyed_categories = array();

            foreach ((array)$categories as $c) {
                $category_tree[$c->cat_ID] = $c->category_parent;
                $keyed_categories[$c->cat_ID] = $c;
            }

            // Now loop through and create a tiered list of
            // categories
            $tiered_categories = array();
            $tier = 0;

            // This is the recursive bit
            while (!empty($category_tree)) {
                $cats_to_unset = array();
                foreach ((array)$category_tree as $cat_id => $cat_parent) {
                    if (!in_array($cat_parent, array_keys($category_tree))) {
                        $tiered_categories[$tier][] = $cat_id;
                        $cats_to_unset[] = $cat_id;
                    }
                }

                foreach ($cats_to_unset as $ctu) {
                    unset($category_tree[$ctu]);
                }
                $tier++;
            }

            // Walk through the tiers to order the cat objects properly
            $ordered_categories = array();
            foreach ((array)$tiered_categories as $tier) {
                foreach ((array)$tier as $tcat) {
                    $ordered_categories[] = $keyed_categories[$tcat];
                }
            }

            //if ( in_array($cat_label_id, $inc_cat) || in_array( self::get_category_top_parent_id($cat_label_id), $inc_cat ) ) {
            if ($cat_label_id && ($cat_label_id != '')) {
                $cat_id = $cat_label_id;
                $cat_name = get_cat_name($cat_label_id);
            } else {

                foreach ($ordered_categories as &$cat) {
                    if (!empty($inc_cat)) {
                        if (in_array($cat->cat_ID, $inc_cat)) {
                            $cat_id = $cat->cat_ID;
                            $cat_name = $cat->cat_name;
                            if ($cat_display == 'root') break;
                        }
                        if (in_array($cat->parent, $inc_cat)) {
                            $cat_id = $cat->cat_ID;
                            $cat_name = $cat->cat_name;
                            if ($cat_display == 'sub') break;
                        }
                    } else {
                        if (($cat_display == 'root') && ($cat->parent == 0)) {
                            $cat_id = $cat->cat_ID;
                            $cat_name = $cat->cat_name;
                            break;
                        } else if (($cat_display == 'sub') && ($cat->parent != 0)) {
                            $cat_id = $cat->cat_ID;
                            $cat_name = $cat->cat_name;
                            break;
                        }
                    }
                    $cat_id = $cat->cat_ID;
                    $cat_name = $cat->cat_name;
                }

            }
            return array($cat_id, $cat_name);
        }

        public static function posts_by_year()
        {
            // array to use for results
            $years = array();

            // get posts from WP
            $posts = get_posts(array(
                'numberposts' => -1,
                'orderby' => 'post_date',
                'order' => 'ASC',
                'post_type' => 'post',
                'post_status' => 'publish'
            ));

            // loop through posts, populating $years arrays
            foreach ($posts as $post) {
                $years[date('Y', strtotime($post->post_date))][] = $post;
            }
            wp_reset_postdata();

            // reverse sort by year
            krsort($years);

            return $years;
        }


        static function setCatLayoutBanner($curr_cat_id, $class = 'row ad ad-cat')
        {

            global $mp_weeklynews;

            $enable_banner = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_show'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_show'] : $mp_weeklynews['_mp_cat_layout_banner_show'];
            $banner_type = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_type'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_type'] : $mp_weeklynews['_mp_cat_layout_banner_type'];
            $banner_image = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_image']['url'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_image']['url'] : $mp_weeklynews['_mp_cat_layout_banner_image']['url'];
            $banner_image_width = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_image']['width'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_image']['width'] : $mp_weeklynews['_mp_cat_layout_banner_image']['width'];
            $banner_link = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_link'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_link'] : $mp_weeklynews['_mp_cat_layout_banner_link'];
            $banner_embed = $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_embed'] ? $mp_weeklynews['_mp_cat_' . $curr_cat_id . '_layout_banner_embed'] : $mp_weeklynews['_mp_cat_layout_banner_embed'];

            $output = '';

            if ($enable_banner && isset($banner_type)) {
                switch ($banner_type) {
                    case 'image':
                        $banner_image = '<img src="' . $banner_image . '" width="' . $banner_image_width . '" alt="" />';
                        $banner_image = (isset($banner_link)) ? '<a href="' . $banner_link . '" target="_blank">' . $banner_image . '</a>' : $banner_image;

                        $output = '<div class="' . $class . '">' . $banner_image . '</div>';
                        break;
                    case 'embed':
                        $output = '<div class="' . $class . '">' . $banner_embed . '</div>';
                        break;
                }
                return $output;
            }

        }


        static function get_image_attachment_data($post_id, $size = 'thumbnail', $count = 1)
        {
            $objMeta = array();
            $meta = '';
            $args = array(
                'numberposts' => $count,
                'post_parent' => $post_id,
                'post_type' => 'attachment',
                'nopaging' => false,
                'post_mime_type' => 'image',
                'order' => 'ASC',
                'orderby' => 'menu_order ID',
                'post_status' => 'any'
            );

            $attachments = get_children($args);

            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $meta = new stdClass();
                    $meta->ID = $attachment->ID;
                    $meta->title = $attachment->post_title;
                    $meta->caption = $attachment->post_excerpt;
                    $meta->description = $attachment->post_content;
                    $meta->alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);

                    // Image properties
                    $props = wp_get_attachment_image_src($attachment->ID, $size, false);

                    $meta->properties['url'] = $props[0];
                    $meta->properties['width'] = $props[1];
                    $meta->properties['height'] = $props[2];

                    $objMeta[] = $meta;
                }

                return (count($attachments) == 1) ? $meta : $objMeta;
            }
        }


        static function get_item_scope($post_review = 'disable')
        {
            if ($post_review == 'enable') {
                return 'itemscope itemtype="http://schema.org/Review"';
            } else {
                return 'itemscope itemtype="http://schema.org/Article"';
            }
        }


        static function getColumnClass($columns = 3)
        {
            switch ($columns) {
                case 1:
                    return 'col-md-12';
                    break;
                case 2:
                    return 'col-md-6';
                    break;
                case 3:
                    return 'col-md-4';
                    break;
                case 4:
                    return 'col-md-3';
                    break;
                default:
                    return 'col-md-12';
            }
        }


        static function getAvatarSize($sidebar = 'multi-sidebar', $columns = 3)
        {
            if ($sidebar == 'hide-sidebar') {
                switch ($columns) {
                    case 2:
                        return '350';
                        break;
                    case 3:
                        return '280';
                        break;
                    case 4:
                        return '210';
                        break;
                    default:
                        return '210';
                        break;
                }
            } else if ($sidebar == 'multi-sidebar') {
                switch ($columns) {
                    case 2:
                        return '200';
                        break;
                    case 3:
                        return '150';
                        break;
                    case 4:
                        return '100';
                        break;
                    default:
                        return '100';
                        break;
                }
            } else { // left or right sidebar
                switch ($columns) {
                    case 2:
                        return '250';
                        break;
                    case 3:
                        return '200';
                        break;
                    case 4:
                        return '130';
                        break;
                    default:
                        return '130';
                        break;
                }
            }
        }


        static function setImage($sImg, $sTitle, $imgWidth, $imgHeight, $imgClass = 'class="img-responsive"')
        {
            global $mp_weeklynews;
            $img_lazy_load = (isset($mp_weeklynews['_mp_posts_enable_lazy_load']) && (bool)$mp_weeklynews['_mp_posts_enable_lazy_load']) ? true : false;
            if ($img_lazy_load) {
                return '<img class="bttrlazyloading' . (($imgClass != '') ? ' img-responsive' : '') . '" data-bttrlazyloading-md-src="' . esc_url($sImg) . '" width="' . $imgWidth . '" height="' . $imgHeight . '" alt="' . esc_attr($sTitle) . '"' . $imgClass . ' />
                        <noscript><img src="' . esc_url($sImg) . '" width="' . $imgWidth . '" height="' . $imgHeight . '" alt="' . esc_attr($sTitle) . '"' . $imgClass . ' /></noscript>';
            } else {
                return '<img src="' . esc_url($sImg) . '" width="' . $imgWidth . '" height="' . $imgHeight . '" alt="' . esc_attr($sTitle) . '"' . $imgClass . ' />';
            }
        }


        static function noDummyImage($sImg)
        {
            $pos_value = strrpos($sImg, "dummy");
            if ($sImg) {
                if ($pos_value === false) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }


        static function checkUnboxedThemeImage($aImgWidth = array('post-thumb-2', 560, 390))
        {
            global $mp_weeklynews;
            if (isset($mp_weeklynews['_mp_theme_layout']) && ($mp_weeklynews['_mp_theme_layout'] == 'theme-unboxed')) { // return unboxed width
                switch ($aImgWidth[0]) {
                    case 'post-thumb-1':
                        return array('610_bfi_425', 795, 485);
                        break;
                    case 'post-thumb-2':
                        return array('610_bfi_425', 610, 425);
                        break;
                    case 'post-thumb-3':
                        return array('290_bfi_176', 290, 176);
                        break;
                    case 'post-thumb-9':
                        return array('383_bfi_231', 383, 213);
                        break;
                    case '370':
                        return array('610_bfi_425', 610, 425);
                        break;
                    case '237':
                        return array('610_bfi_425', 610, 425);
                        break;
                    case '479':
                        return array('610_bfi_425', 610, 425);
                        break;
                    case '339':
                        return array('610_bfi_425', 610, 425);
                        break;
                    default:
                        return $aImgWidth;
                }

            } else { // return original width
                return $aImgWidth;
            }
        }


        public static function getCarouselIndex()
        {
            return self::$carousel_index++;
        }

        //Get headline font-size for DI
        public static function getHeadlineFontSize($headline_font_size = 'headline-auto', $type_display, $title)
        {
            if (($headline_font_size == 'headline-auto') || (!$headline_font_size)) {
                if ($type_display == "image-left" || $type_display == "image-right") {
                    if (strlen($title) >= 20) {
                        $font_size_class = "headline-normal";
                    } else {
                        $font_size_class = "headline-big";
                    }
                } else {
                    if (strlen($title) >= 20) {
                        $font_size_class = "headline-big";
                    } else {
                        $font_size_class = "headline-biggest";
                    }
                }
            } else {
                $font_size_class = $headline_font_size;
            }
            return $font_size_class;
        }
        //create new table
        public static function createTableStoreLinkArticle(){
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'crawler_link_post';
            if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
                $sql = "CREATE TABLE $table_name (
                        id mediumint(9) NOT NULL AUTO_INCREMENT,
                        time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
                        title varchar(255),
                        summary varchar(255),
                        post_content text,
                        img_url varchar(255),
                        post_url varchar(255),
                        type_display varchar(255),
                        img_content varchar(255),
                        img_caption varchar(255),
                        img_article_url varchar(255),
                        status smallint(2) NOT NULL DEFAULT 0,
                        UNIQUE KEY id (id)
                        ) $charset_collate;";
                require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                dbDelta( $sql );
            }

        }
        //insert data to table
        public static function insertDataToCrawlerLinkPost($article){
            global $wpdb;
            $table_name = $wpdb->prefix . 'crawler_link_post';
            $url = 'http://www.di.se';
            if(strpos($article['post_url'], $url) !== false){
                $log = $wpdb->insert( $table_name,
                    array(
                        'title' => $article['title'],
                        'summary' => $article['summary'],
                        'post_content' => $article['post_content'],
                        'img_url' => $article['img_url'],
                        'post_url' => $article['post_url'],
                        'type_display' => $article['type_display'],
                        'img_content' => $article['img_content'],
                        'img_caption' => $article['img_caption'],
                        'img_article_url' => $article['img_article_url'],
                    )
                );
            }

            self::writeLog($log, "Insert data into crawler_link_post table successful.");
        }
        //insert data to table
        public static function getDataFromCrawlerLinkPost(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'crawler_link_post';
            $data = $wpdb->get_results("SELECT * FROM $table_name WHERE status = 0 LIMIT 1");
            $result = array();
            foreach($data as $row){
                $result['id'] = $row->id;
                $result['title'] = $row->title;
                $result['summary'] = $row->summary;
                $result['post_content'] = $row->post_content;
                $result['img_url'] = $row->img_url;
                $result['post_url'] = $row->post_url;
                $result['type_display'] = $row->type_display;
                $result['img_content'] = $row->img_content;
                $result['img_caption'] = $row->img_caption;
                $result['img_article_url'] = $row->img_article_url;
            }
            return $result;
        }
        //update data for Crawler_link_post table
        public static function updateDataOfCrawlerLinkPost($data){
            global $wpdb;
            $table_name = $wpdb->prefix . 'crawler_link_post';
            $wpdb->update($table_name, array('status' => 1, 'post_content' => $data['post_content'], 'img_article_url' => $data['img_article_url'] ), array('id'=>$data['id']));
        }
        //delete record of Crawler_link_post table
        public static function deleteDataOfCrawlerLinkPost($id){
            global $wpdb;
            $table_name = $wpdb->prefix . 'crawler_link_post';
            $wpdb->delete($table_name,array('id' => $id));
        }
        //write log
        public function writeLog($message, $success_msg=''){
            ini_set( 'error_log', WP_CONTENT_DIR . '/debug.log' );
            if ( is_array( $message ) || is_object( $message ) ) {
                error_log( print_r( $message ) );
            } else {
                error_log($success_msg);
            }
        }
        //insert post
        public static function insertPost($data){
            $post_arr = array();
            $post_arr['post_title'] = $data['title'];
            $post_arr['post_content'] = $data['post_content'];
            $post_arr['post_date'] = $data['post_date'];
            $post_arr['post_date_gmt'] = $data['post_date'];
            $post = get_page_by_title($post_arr['post_title'], OBJECT, 'post');
            print_r($post_arr);
            if (null == $post){
                $id = wp_insert_post($post_arr, true);
//                echo 'Insert new post';
                self::writeLog($id, 'Insert successful - '.$id);

//                echo '<br />\n';
            } else {
                $id = $post->ID;
                $post_arr['ID'] = $id;
                $log = wp_update_post($post_arr, true);
                self::writeLog($log, 'Update successful - '.$id);
//                echo 'Update post '.$id;
            }

            //update custom fields
            update_field('summary', $data['summary'], $id);
            update_field('author_email_address', $data['author_email'], $id);
            update_field('author_info', $data['author_name'], $id);
            update_field('summary', $data['summary'], $id);
            update_field('title_for_article', $data['title_for_article'], $id);
            update_field('article_image_caption', $data['image_article_caption'], $id);
            update_field('type_display_on_home_page', $data['type_display'], $id);
            update_post_meta($id, '_mp_featured_image_caption', $data['img_caption']);
            update_field('original_post_url', $data['post_url'], $id);
            //upload feature image
            if($data['img_article_url'])
                self::uploadImageForPost($data['img_article_url'], $id, 1,'', $data['img_caption']);
            //update image for article
            if($data['img_article_url'])
                self::uploadImageForPost($data['img_article_url'], $id, 0, 'image_display_on_article', $data['image_article_caption']);
            //update image for author - img_author_url
//            echo $data['img_author_url'];
            if($data['img_author_url'])
                self::uploadImageForPost($data['img_author_url'], $id, 0, 'author_image');
            return $id;

        }
        //parse data into post
        public static function parseDataToPostRecord($data){
            $post_arr = array();
            $post_arr['post_title'] = $data['post_content'];
            $post_arr['post_content'] = $data['post_content'];
        }
        //Insert feature image for post
        public static function uploadImageForPost($image_url, $post_id, $is_feature_img=1, $field_name='', $image_caption=''){
            $upload_dir = wp_upload_dir(); // Set upload folder

            $filename   = md5($image_url).".jpg"; // Create image file name
            // Check folder permission and define file location
            if( wp_mkdir_p( $upload_dir['path'] ) ) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }

            if (!file_exists($file)){
                $image_data = file_get_contents($image_url); // Get image data
                // Create the image  file on the server
                file_put_contents( $file, $image_data );
            }

            // Check image file type
            $wp_filetype = wp_check_filetype( $filename, null );

            // Set attachment data
            if(!$image_caption) $image_caption = ' ';
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name( $filename ),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_excerpt'   => $image_caption,
                'image_meta'     => array('caption' =>$image_caption, 'title' => $image_caption)
            );

            // Create the attachment
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

            // Include image.php
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Define attachment metadata
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

            // Assign metadata to attachment
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // And finally assign featured image to post
            if($is_feature_img){
                set_post_thumbnail( $post_id, $attach_id );
            }
            else
                update_field($field_name, $attach_id, $post_id);
        }
        function createSignature($secret, $value){
            $sig = hash_hmac('sha256', $value, $secret, true);
            return base64_encode($sig);
        }
        function getDomData($url=''){
            //Init curl
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            //Get dom
            $dom = new DOMDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($data);
            return $dom;
        }

        function getArticleDetail($url)
        {
            $dom = self::getDomData($url);
            $xpath = new DomXpath($dom);

            $node_title = $xpath->query("//*/h1[@class='di_article-top__heading']");
            if (empty($node_title) || ($node_title->length < 1)) {
                $node_title = $xpath->query("//*/h1[@class='article__headline h1--huge--bold']");
            }
            $article_title = "";
            if (!empty($node_title) && ($node_title->length > 0)) {
                $article_title = $node_title->item(0)->nodeValue;
            }

            $node_heading_picture = $xpath->query("//*/picture[@class='di_article-figure__picture']");
            if (empty($node_heading_picture) || ($node_heading_picture->length < 1)) {
                $node_heading_picture = $xpath->query("//*/figure[@class='article__image']/picture");
            }
            $article_heading_image_url = "";
            if (!empty($node_heading_picture) && ($node_heading_picture->length > 0)) {
                $node_heading_image = $node_heading_picture->item(0)->getElementsByTagName("img");

                if (!empty($node_heading_image) && ($node_heading_image->length > 0)) {
                    $article_heading_image_url = $node_heading_image->item(0)->getAttribute('srcset');
                }
            }

            $node_figure_caption = $xpath->query("//*/p[@class='di_article-figure__caption']/text()");
            $article_figure_content = "";
            if (!empty($node_figure_caption) && ($node_figure_caption->length > 0)) {
                $article_figure_content = $node_figure_caption->item(0)->nodeValue;
            }
            if (empty($article_figure_content)) {
                $node_figure_caption = $xpath->query("//*/figcaption[@class='article__image__caption']/text()");
                if (!empty($node_figure_caption) && ($node_figure_caption->length > 0)) {
                    $article_figure_content = $node_figure_caption->item(0)->nodeValue;
                }
            }
            $article_figure_content = trim($article_figure_content);

            $node_figure = $xpath->query("//*/p[@class='di_article-figure__caption']");
            $article_figure_caption = "";
            if (!empty($node_figure) && ($node_figure->length > 0)) {
                $node_figure_caption = $node_figure->item(0)->getElementsByTagName("span");

                if (!empty($node_figure_caption) && ($node_figure_caption->length > 0)) {
                    $article_figure_caption = $node_figure_caption->item(0)->nodeValue;
                }
            }
            if (empty($article_figure_caption)) {
                $node_figure = $xpath->query("//*/span[@class='article__image__credit']");

                if (!empty($node_figure) && ($node_figure->length > 0)) {
                    $article_figure_caption = $node_figure->item(0)->nodeValue;
                }
            }

            if (empty($article_figure_content)){
                $article_figure_content = trim($article_figure_caption);
            }else{
                $article_figure_content .= " " . trim($article_figure_caption);
            }

            $node_author = $xpath->query("//*/div[@class='di_byline__image']/figure");
            $author_image_url = "";
            if (!empty($node_author) && ($node_author->length > 0)) {
                $node_author_image_url = $node_author->item(0)->getElementsByTagName("img");

                if (!empty($node_author_image_url) && ($node_author_image_url->length > 0)) {
                    $author_image_url = $node_author_image_url->item(0)->getAttribute('src');
                }
            }
            if (empty($author_image_url)) {
                $node_author = $xpath->query("//*/div[@class='article__byline__bottom__picture']/figure/picture");

                if (!empty($node_author) && ($node_author->length > 0)) {
                    $node_author_image_url = $node_author->item(0)->getElementsByTagName("img");

                    if (!empty($node_author_image_url) && ($node_author_image_url->length > 0)) {
                        $author_image_url = $node_author_image_url->item(0)->getAttribute('srcset');
                    }
                }
            }

            $node_author_name = $xpath->query("//*/span[@class='di_byline__author-name']");
            $author_name = "";
            if (!empty($node_author_name) && ($node_author_name->length > 0)) {
                $author_name = $node_author_name->item(0)->nodeValue;
            }
            if (empty($author_name)) {
                $node_author_name = $xpath->query("//*/a[@class='article__byline__bottom__author__name']");

                if (!empty($node_author_name) && ($node_author_name->length > 0)) {
                    $author_name = $node_author_name->item(0)->nodeValue;
                }
            }

            $node_postdate = $xpath->query("//*/p[@class='di_byline__text']/*/time");
            $article_publish_date = "";
            if (!empty($node_postdate) && ($node_postdate->length > 0)) {
                $article_publish_date = $node_postdate->item(0)->nodeValue;
            }
            if (empty($article_publish_date)) {
                $node_postdate = $xpath->query("//*/span[@class='article__byline__top__date']/time");

                if (!empty($node_postdate) && ($node_postdate->length > 0)) {
                    $article_publish_date = $node_postdate->item(0)->getAttribute("datetime");
                }
            }
            if (empty($article_publish_date)) {
                $article_publish_date = date('Y-m-d h:i:s', time());
            }

            $node_article_body = $xpath->query("//*/div[@class='di_article-content']");
            $article_body = "";
            if (!empty($node_article_body) && ($node_article_body->length > 0)) {
                $article_body = $node_article_body->item(0)->c14n();
            }
            if (empty($article_body)) {
                $node_article_excerpt = $xpath->query("//*/div[@class='article__lead']");
                $article_excerpt = "";

                if (!empty($node_article_excerpt) && ($node_article_excerpt->length > 0)) {
                    $article_excerpt = $node_article_excerpt->item(0)->c14n();
                }

                $node_article_body = $xpath->query("//*/div[@class='article__main_column article__body']");

                if (!empty($node_article_body) && ($node_article_body->length > 0)) {
                    $article_body = $article_excerpt . $node_article_body->item(0)->c14n();
                }
            }

            $node_author_email = $xpath->query("//*/a[@class='article__byline__bottom__author__mail']");
            $author_email = "";
            if (!empty($node_author_email) && ($node_author_email->length > 0)) {
                $author_email = $node_author_email->item(0)->nodeValue;
            }else{
                $node_author_email = $xpath->query("//*/a[@class='di_byline__author-info di_byline__author-info--email']");
                if (!empty($node_author_email) && ($node_author_email->length > 0)) {
                    $author_email = $node_author_email->item(0)->nodeValue;
                }
            }

            $article = array(
                'title_for_article' => $article_title,
                'img_article_url' => self::getRealImageUrlFromSrcsetAttribute($article_heading_image_url),
                'img_content' => $article_figure_content,
                'img_caption' => $article_figure_caption,
                'img_author_url' => self::getRealImageUrlFromSrcsetAttribute($author_image_url),
                'author_name' => $author_name,
                'post_date' => $article_publish_date,
                'image_article_caption' => $article_figure_content,
                'content' => $article_body,
                'author_email' => $author_email,

            );

            return $article;

        }

        function crawlArticleList()
        {
            $dom = self::getDomData('http://www.di.se');
            $xpath = new DomXpath($dom);
            $article_css_class_name = "di_teaser";
            $article_title_class_name = "di_teaser__heading";
            $article_dom_entries = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $article_css_class_name ')]");
            $article_result_set = array();


            foreach ($article_dom_entries as $article_dom) {
                $node_heading = $xpath->query("section/h1/a", $article_dom);

                $article_title = $article_post_url = "";
                if (!empty($node_heading) && ($node_heading->length > 0)) {
                    $article_title = $node_heading->item(0)->nodeValue;
                    $article_post_url = $node_heading->item(0)->getAttribute('href');
                    if (!((substr($article_post_url, 0, 7) == 'http://') || (substr($article_post_url, 0, 8) == 'https://')) && !empty($article_post_url)) {
                        $article_post_url = "http://www.di.se" . $article_post_url;
                    }
                }

                $node_summary = $xpath->query("section/p/a", $article_dom);
                $article_summary = "";
                if (!empty($node_summary) && ($node_summary->length > 0)) {
                    $article_summary = $node_summary->item(0)->nodeValue;
                }

                $node_heading_picture = $xpath->query("a/figure/picture", $article_dom);
                if (!empty($node_heading_picture) && ($node_heading_picture->length > 0)) {
                    $node_heading_image = $node_heading_picture->item(0)->getElementsByTagName("img");

                    if (!empty($node_heading_image) && ($node_heading_image->length > 0)) {
                        $article_heading_image_url = $node_heading_image->item(0)->getAttribute('srcset');
                    }
                }

                $article = array(
                    'title' => $article_title,
                    'summary' => $article_summary,
                    'post_url' => $article_post_url,
                    'font_size_class' => $article_title_class_name,
                    'img_url' => self::getRealImageUrlFromSrcsetAttribute($article_heading_image_url),
                    'type_display' => "",
                    'img_content' => "",
                    'img_caption' => "",
                );

                if (!empty($article_post_url)) {
                    array_push($article_result_set, $article);
                }
            }

            return $article_result_set;
        }

        function getRealImageUrlFromSrcsetAttribute($url)
        {
            $pattern = '/(.*?.(png|jpeg|jpg|gif))/im';

            if (!preg_match($pattern, $url)){
                return "";
            }

            preg_match_all($pattern, $url, $out, PREG_PATTERN_ORDER);

            if ((count($out) > 2) && (isset($out[1][0]))) {
                return $out[1][0];
            }

            return $url;
        }
    }

}


class categories_array_walker extends Walker {
    var $tree_type      = 'category';
    var $db_fields      = array ('parent' => 'parent', 'id' => 'term_id');
    var $array_buffer   = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
    }

    function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        $this->array_buffer[str_repeat(' -- ', $depth) .  $category->name] = $category->term_id;
    }

    function end_el( &$output, $page, $depth = 0, $args = array() ) {
    }
}
