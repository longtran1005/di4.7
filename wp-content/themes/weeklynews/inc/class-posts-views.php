<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 *
 * v2.4
 */

if ( ! class_exists( 'MipTheme_Post_Views' ) ) { 
 
    class MipTheme_Post_Views {
        
        static $post_views_counter_key              = 'mip_post_views_count';
        static $post_views_counter_7_day_array      = '_mip_post_views_count_7_day_arr';
        static $post_views_counter_7_day_total      = '_mip_post_views_count_7_day_total';
        static $post_views_7days_last_day           = '_mip_post_view_7days_last_day';
        static $post_views_24_hours_total           = '_mip_post_views_count_24_hours_total';
        static $ajax_update_function                = '';
        
        static function update_post_views($postID) {
            global $page, $mp_weeklynews;

            if (is_single() and (empty($page) or $page == 1)) {
                
                // Use if Ajax Post Views are not enabled
                $ajax_post_views    = ( isset($mp_weeklynews['_mp_enable_ajax_post_views']) && (bool)$mp_weeklynews['_mp_enable_ajax_post_views'] ) ? true : false;
                if( !$ajax_post_views ) {
                    $count = get_post_meta($postID, self::$post_views_counter_key, true);
                    if ($count == ''){
                        update_post_meta($postID, self::$post_views_counter_key, 1);
                    } else {
                        $count++;
                        update_post_meta($postID, self::$post_views_counter_key, $count);
                    }
                } else {
                    self::$ajax_update_function .= 'jQuery().ready(function jQuery_ready() {
                                            miptheme_ajax_post_views.get_post_views('. json_encode('[' . $postID . ']') .');
                                        });';
                }
                
                
                // 7 day count array
                $current_day = date("N") - 1;  //get the current day
                $count_7_day_array = get_post_meta($postID, self::$post_views_counter_7_day_array, true);  // get the array with day of week -> count
    
                if (is_array($count_7_day_array)) {
    
                    if (isset($count_7_day_array[$current_day])) { // check to see if the current day is defined - if it's not defined it's not ok.
    
                        if (get_post_meta($postID, self::$post_views_7days_last_day, true) == $current_day) {
                            // the day was not changed since the last update
                            $count_7_day_array[$current_day]++;
                            
                            //update 24 hours post view
                            update_post_meta($postID, self::$post_views_24_hours_total, $count_7_day_array[$current_day]);
                        } else {
                            // the day was changed since the last update - reset the current day
                            $count_7_day_array[$current_day] = 1;
    
                            //update last day with the current day
                            update_post_meta($postID, self::$post_views_7days_last_day, $current_day);
                            
                            // reset 24 hours post view to 1
                            update_post_meta($postID, self::$post_views_24_hours_total, 1);
                        }
    
                        // update the array
                        update_post_meta($postID, self::$post_views_counter_7_day_array, $count_7_day_array);
    
                        // update the 7days sum
                        update_post_meta($postID, self::$post_views_counter_7_day_total, array_sum($count_7_day_array));
                    }
    
                } else {
                    // the array is not initialized
                    $count_7_day_array = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0);
                    $count_7_day_array[$current_day] = 1; // add one view on the current day
    
                    // set the array
                    update_post_meta($postID, self::$post_views_counter_7_day_array, $count_7_day_array);
    
                    // set last day with the current day
                    update_post_meta($postID, self::$post_views_7days_last_day, $current_day);
    
                    // set 7 days total to 1 view :)
                    update_post_meta($postID, self::$post_views_counter_7_day_total, 1);
                    
                    // set 24 hours total to 1 view :)
                    update_post_meta($postID, self::$post_views_24_hours_total, 1);
  
                }
                
            }
        }
        
        
        static function get_post_views($postID, $counter_view = 'mip_post_views_count') {
            $count = get_post_meta($postID, $counter_view, true);
    
            if ($count == '') {
                delete_post_meta($postID, $counter_view);
                add_post_meta($postID, $counter_view, '0');
                return "0";
            }
            return $count;
        }
    
        
        
        static function update_via_ajax() { 
            return "\n<!-- JS generated by theme -->" . "\n\n<script>\n    " . self::$ajax_update_function . "\n</script>\n\n";
        }

        //HuongNTL
        static function update_count_read_post($postID) {
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
        
    }
    
}

function miptheme_ajax_post_views_call() {
    echo MipTheme_Post_Views::update_via_ajax();
}

//load the footer js
add_action('wp_footer', 'miptheme_ajax_post_views_call', 100);