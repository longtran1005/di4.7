<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Global' ) ) { 
 
    class MipTheme_Global {
        
        //theme options
        static $mp_options;
        
        //current template
        static $curr_template = ''; 
        
        //current page if (top level)
        static $curr_page_id;
        
        
        # Set Fallback for Navigation
        static function mip_fb_nav_menu() {
            echo '<ul class="nav clearfix">';
            echo '  <li><a href="' . home_url() . '/wp-admin/nav-menus.php?action=locations">Click here - to select or create a menu</a></li>';
            echo '</ul>';
        }
        
        # Set Top Navigation Fallback
        static function mip_fb_top_menu() { 
            global $mp_weeklynews;
            $streched_menu  = ( isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container';
            
            $wrap   = '';
            if ( (bool)$mp_weeklynews['_mp_header_top_show_social_networking'] || (bool)$mp_weeklynews['_mp_header_topmenu_enable'] ) {
                
                $wrap .= '<div id="top-navigation"><div class="'. $streched_menu .'"><nav id="top-menu">';
                $wrap .= '<ul>';
                
                if ( isset($mp_weeklynews['_mp_header_topmenu_show_date']) && ($mp_weeklynews['_mp_header_topmenu_show_date'] != 'none') ) {
                    $wrap .= '<li class="date '. $mp_weeklynews['_mp_header_topmenu_show_date'] .'"><span>'. date_i18n(MIPTHEME_DATE_HEADER) .'</span></li>';
                }       
                
                if ( isset($mp_weeklynews['_mp_header_topmenu_show_options']) ) {
                    $wrap .= '<li class="options">';
                    
                    if ( (bool)$mp_weeklynews['_mp_header_topmenu_show_options']['register'] ) {
                        if ( ! is_user_logged_in() ) {
                            if ( get_option('users_can_register') ) $wrap .= '<a href="' . site_url('wp-login.php?action=register', 'login') . '"><span class="glyphicon glyphicon-pencil"></span> ' . __('Register', THEMENAME) . '</a>';
                        }
                        else {
                            $wrap .= '<a href="' . admin_url() . 'edit.php"><span class="glyphicon glyphicon-pencil"></span> ' . __('My Posts', THEMENAME) . '</a>';
                        }
                    }
                    
                    if ( (bool)$mp_weeklynews['_mp_header_topmenu_show_options']['login'] ) {
                        if ( ! is_user_logged_in() ) {
                            $wrap .= '<a href="' . wp_login_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log in', THEMENAME) . '</a>';
                        } else {
                            $wrap .= '<a href="' . wp_logout_url() . '"><span class="glyphicon glyphicon-asterisk"></span> ' . __('Log out', THEMENAME) . '</a>';
                        }
                    }
                    
                    $wrap .= '</li>';
                }           
                
                $wrap .= '<li class="soc-media">';
                $wrap .= ( isset($mp_weeklynews['_mp_social_facebook']) && ($mp_weeklynews['_mp_social_facebook'] != '')  )     ? '<a href="'. $mp_weeklynews['_mp_social_facebook'] .'"><i class="fa fa-facebook"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_twitter']) && ($mp_weeklynews['_mp_social_twitter'] != '')  )       ? '<a href="'. $mp_weeklynews['_mp_social_twitter'] .'"><i class="fa fa-twitter"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_google']) && ($mp_weeklynews['_mp_social_google'] != '')  )         ? '<a href="'. $mp_weeklynews['_mp_social_google'] .'"><i class="fa fa-google-plus"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_linkedin']) && ($mp_weeklynews['_mp_social_linkedin'] != '')  )     ? '<a href="'. $mp_weeklynews['_mp_social_linkedin'] .'"><i class="fa fa-linkedin"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_pinterest']) && ($mp_weeklynews['_mp_social_pinterest'] != '')  )   ? '<a href="'. $mp_weeklynews['_mp_social_pinterest'] .'"><i class="fa fa-pinterest"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_flickr']) && ($mp_weeklynews['_mp_social_flickr'] != '')  )         ? '<a href="'. $mp_weeklynews['_mp_social_flickr'] .'"><i class="fa fa-flickr"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_youtube']) && ($mp_weeklynews['_mp_social_youtube'] != '')  )       ? '<a href="'. $mp_weeklynews['_mp_social_youtube'] .'"><i class="fa fa-youtube"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_vimeo']) && ($mp_weeklynews['_mp_social_vimeo'] != '')  )           ? '<a href="'. $mp_weeklynews['_mp_social_vimeo'] .'"><i class="fa fa-vimeo-square"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_instagram']) && ($mp_weeklynews['_mp_social_instagram'] != '')  )   ? '<a href="'. $mp_weeklynews['_mp_social_instagram'] .'"><i class="fa fa-instagram"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_dribbble']) && ($mp_weeklynews['_mp_social_dribbble'] != '')  )     ? '<a href="'. $mp_weeklynews['_mp_social_dribbble'] .'"><i class="fa fa-dribbble"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_behance']) && ($mp_weeklynews['_mp_social_behance'] != '')  )       ? '<a href="'. $mp_weeklynews['_mp_social_behance'] .'"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_tumblr']) && ($mp_weeklynews['_mp_social_tumblr'] != '')  )         ? '<a href="'. $mp_weeklynews['_mp_social_tumblr'] .'"><i class="fa fa-tumblr"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_reddit']) && ($mp_weeklynews['_mp_social_reddit'] != '')  )         ? '<a href="'. $mp_weeklynews['_mp_social_reddit'] .'"><i class="fa fa-reddit"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_vkontakte']) && ($mp_weeklynews['_mp_social_vkontakte'] != '')  )   ? '<a href="'. $mp_weeklynews['_mp_social_vkontakte'] .'"><i class="fa fa-vk"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_weibo']) && ($mp_weeklynews['_mp_social_weibo'] != '')  )           ? '<a href="'. $mp_weeklynews['_mp_social_weibo'] .'"><i class="fa fa-tencent-weibo"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_wechat']) && ($mp_weeklynews['_mp_social_wechat'] != '')  )         ? '<a href="'. $mp_weeklynews['_mp_social_wechat'] .'"><i class="fa fa-weixin"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_qq']) && ($mp_weeklynews['_mp_social_qq'] != '')  )                 ? '<a href="'. $mp_weeklynews['_mp_social_qq'] .'"><i class="fa fa-qq"></i></a>' : '';
                $wrap .= ( isset($mp_weeklynews['_mp_social_rss']) && ($mp_weeklynews['_mp_social_rss'] != '')  )               ? '<a href="'. $mp_weeklynews['_mp_social_rss'] .'"><i class="fa fa-rss"></i></a>' : '';
                //$wrap .= ( isset($mp_weeklynews['_mp_social_500px']) && ($mp_weeklynews['_mp_social_500px'] != '')  )           ? '<a href="'. $mp_weeklynews['_mp_social_500px'] .'"><i class="fa fa-behance"></i></a>' : '';
                $wrap .= '</li>';
                $wrap .= '</ul></nav></div></div>';
            }
            
            echo $wrap;
        }
    
        static function mp_set_dummy_img( $dim ) {
            if ( $dim && ($dim != '') ) {
                return get_template_directory_uri() . '/images/dummy/'. $dim .'.jpg';
            }
        }
    
    }
}