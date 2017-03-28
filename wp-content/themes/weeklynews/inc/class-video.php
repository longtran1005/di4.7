<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Video' ) ) { 
 
    class MipTheme_Video {
        
        /*
         * Video handling
         */
        function getYoutubeId($videoUrl) {
            $query_string = array();
            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query_string);
    
            if (empty($query_string["v"])) {
                //explode at ? mark
                $yt_short_link_parts_explode1 = explode('?', $videoUrl);
    
                //short link: http://youtu.be/AgFeZr5ptV8
                $yt_short_link_parts = explode('/', $yt_short_link_parts_explode1[0]);
                if (!empty($yt_short_link_parts[3])) {
                    return $yt_short_link_parts[3];
                }
    
                return $yt_short_link_parts[0];
            } else {
                return $query_string["v"];
            }
        }
    
        /*
         * youtube t param from url (ex: http://youtu.be/AgFeZr5ptV8?t=5s)
         */
        function getYoutubeTimeParam($videoUrl) {
            $query_string = array();
            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $query_string);
            if (!empty($query_string["t"])) {
    
                if (strpos($query_string["t"], 'm')) {
                    //take minutes
                    $explode_for_minutes = explode('m', $query_string["t"]);
                    $minutes = trim($explode_for_minutes[0]);
    
                    //take seconds
                    $explode_for_seconds = explode('s', $explode_for_minutes[1]);
                    $seconds = trim($explode_for_seconds[0]);
    
                    $startTime = ($minutes * 60) + $seconds;
                } else {
                    //take seconds
                    $explode_for_seconds = explode('s', $query_string["t"]);
                    $seconds = trim($explode_for_seconds[0]);
    
                    $startTime = $seconds;
                }
    
                return '&start=' . $startTime;
            } else {
                return '';
            }
        }
        
        /*
         * Vimeo id
         */
        function getVimeoId($videoUrl) {
            $pattern = '/^.+vimeo.com\/(.*\/)?([^#\?]*)/';
            preg_match($pattern, $videoUrl, $matches);
            if (count($matches))
            {
              return $matches[2];
            }        
            return '';
        }
    
        /*
         * Dailymotion
         */
        function getDailymotionID($videoUrl) {
            $id = strtok(basename($videoUrl), '_');
            if (strpos($id,'#video=') !== false) {
                $videoParts = explode('#video=', $id);
                if (!empty($videoParts[1])) {
                    return $videoParts[1];
                }
            } else {
                return $id;
            }
    
        }
    
        /*
         * Detect the video service from url
         */
        function detectVideoService($videoUrl) {
            $videoUrl = strtolower($videoUrl);
            if (strpos($videoUrl,'youtube.com') !== false or strpos($videoUrl,'youtu.be') !== false) {
                return 'youtube';
            }
            if (strpos($videoUrl,'dailymotion.com') !== false) {
                return 'dailymotion';
            }
            if (strpos($videoUrl,'vimeo.com') !== false) {
                return 'vimeo';
            }
    
            return false;
        }
    
    
        function is404($url) {
            $headers = get_headers($url);
            if (strpos($headers[0],'404') !== false) {
                return true;
            } else {
                return false;
            }
        }
        
        function renderVideo($videoUrl, $videoWidth = 1170, $videoHeight = 580) {
            $output = '';
            switch ($this->detectVideoService($videoUrl)) {
                case 'youtube':
                    $output = '<iframe width="'. $videoWidth .'" height="'. $videoHeight .'" frameborder="0" src="http://www.youtube.com/embed/' . $this->getYoutubeId($videoUrl) . '?feature=oembed&wmode=opaque' . $this->getYoutubeTimeParam($videoUrl) . '" allowfullscreen=""></iframe>';
                    break;
                case 'dailymotion':
                    $output = '<iframe width="'. $videoWidth .'" height="'. $videoHeight .'" frameborder="0" src="http://www.dailymotion.com/embed/video/' . $this->getDailymotionID($videoUrl) . '"></iframe>';
                    break;
                case 'vimeo':
                    $output = '<iframe width="'. $videoWidth .'" height="'. $videoHeight .'" frameborder="0" src="http://player.vimeo.com/video/' . $this->getVimeoId($videoUrl) . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
                    break;
            }
            return $output;
        }
        
        
    }
    
}