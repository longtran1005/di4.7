<?php
/**
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 */

if ( ! class_exists( 'MipTheme_Review' ) ) {

    class MipTheme_Review {

        static function get_review( $atts ) {
            global $post;
            $review_post   = redux_post_meta('mp_weeklynews', $post->ID, '_mp_enable_review_post');

            if ( $review_post == 'enable' ) :
                $review_post_style              = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_style');
                $review_post_summary_type       = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_summary_type');
                $review_post_summary_text       = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_summary_text');
                $review_post_summary_text_good  = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_summary_text_good');
                $review_post_summary_text_bad   = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_summary_text_bad');
                $review_post_total_text         = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_text');
                $review_post_criteria_count     = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_criteria_count');
                $review_post_total_score        = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_total_score');

                $review_output  = '
                    <!-- start:review -->
                    <div class="review">
                        <div class="row bottom-margin">
                            <div class="col-sm-3">
                                <div class="score-overall">
                                    <span class="score-number">'. ( ( $review_post_style == 'percentage' ) ? round($review_post_total_score) .'%' : round($review_post_total_score/10, 1) ) .'</span>
                                    <span class="score-desc">'. $review_post_total_text .'</span>
                                </div>
                            </div>
                            <div class="col-sm-9">';

                if ( $review_post_summary_type == 'summary' ) :

                    $review_output  .= '
                                <h4>Summary</h4>
                                <p>'. do_shortcode($review_post_summary_text) .'</p>';

                elseif ( $review_post_summary_type == 'good-bad' ) :

                    $review_output  .= '
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4>'. __('The Good', THEMENAME) .'</h4>
                                        <ul class="good"><li><i class="fa fa-plus-circle"></i>'. str_replace(array("\r\n", "\r", "\n"), '</li><li><i class="fa fa-plus-circle"></i>', $review_post_summary_text_good) .'</li></ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4>'. __('The Bad', THEMENAME) .'</h4>
                                        <ul class="bad"><li><i class="fa fa-minus-circle"></i>'. str_replace(array("\r\n", "\r", "\n"), '</li><li><i class="fa fa-minus-circle"></i>', $review_post_summary_text_bad) .'</li></ul>
                                    </div>
                                </div>';

                endif;

                $review_output  .= '
                            </div>
                        </div>';

                for ( $i = 1; $i <= $review_post_criteria_count; $i++ ) {
                    $crit_name      = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_criteria_'. $i .'');
                    $crit_value     = redux_post_meta('mp_weeklynews', $post->ID, '_mp_review_post_criteria_value_'. $i .'');
                    $review_output  .= '
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: '. $crit_value .'%;">
                                <span class="skill-number pull-left">'. ( ( $review_post_style == 'percentage' ) ? $crit_value .' %' : round($crit_value/10, 1) ) .'</span>
                                <span class="skill-text pull-left">'. $crit_name .'</span>
                            </div>
                        </div>';
                }

                $review_output  .= '</div><!-- end:review -->';

                return $review_output;
            endif;
        }

    }

}


if ( ! class_exists( 'MipTheme_Quotes' ) ) {

    class MipTheme_Quotes {

        static function get_quote( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '',
                        'style' => '',
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="'. $style .'"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_center( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="text-center"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_left( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="text-left"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_right( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="text-right"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_box_center( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="boxquote text-center"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_box_left( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="boxquote text-left"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function quote_box_right( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="boxquote text-right"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function pull_quote_left( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="pull-left"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

        static function pull_quote_right( $atts, $content = null ) {
            extract(shortcode_atts(
                    array(
                        'author' => '', /* empty for default color OR color profile OR custom #color */
                    ),
                    $atts
                )
            );

            $footer = '';
            if ($author != '') {
                $footer .= '<footer>'. $author .'</footer>';
            }
            return '<blockquote class="pull-right"><p>'. $content .'</p>'. $footer .'</blockquote>';
        }

    }

}


if ( ! class_exists( 'MipTheme_Alert' ) ) {
    class MipTheme_Alert {

        static function get_alert( $atts, $content = null) {
    		extract( shortcode_atts( array(
    			'type'  => 'warning',
    			'close' => 'true'
    		), $atts ) );

    		if($close == 'false') {
    			$btn    = '';
                $class  = '';
    		} else{
    			$btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                $class  = ' alert-dismissible';
    		}

    		return '<div class="alert alert-' . esc_attr($type) . esc_attr($class) . '" role="alert">' . $btn . do_shortcode($content) . '</div>';
        }

    }
}


if ( ! class_exists( 'MipTheme_Dropcap' ) ) {
    class MipTheme_Dropcap {

        static function get_dropcap( $atts, $content = null) {
            extract(shortcode_atts(array(
    			'style'         => '',
                'color'         => '',
                'background'    => ''
    		), $atts));

    		if($style == '') {
    			$return = '';
    		} else{
    			$return = 'dropcap-'. $style;
    		}

            if($color == '') {
    			$class1 = '';
    		} else{
    			$class1 = 'color:'. $color .';';
    		}

            if($background == '') {
    			$class2 = '';
    		} else{
    			$class2 = 'background:'. $background .';';
    		}

            $class = ( ($class1 != '')||($class2 != '') ) ? ' style="'. $class1 . $class2 .'"' : '';

    		return '<span class="dropcap '. esc_attr($return) .'"'. $class .'>' .esc_html($content). '</span>';
        }

    }
}


if ( ! class_exists( 'MipTheme_Spacer' ) ) {
    class MipTheme_Spacer {

        static function get_spacer( $atts ) {
            extract( shortcode_atts( array(
    			'height'  => '50'
    		), $atts ) );

    		if($height == '') {
    			$return = '';
    		} else{
    			$return = 'style="height: '.esc_attr($height).'px;"';
    		}

    		return '<div class="spacer" ' . $return . '></div>';
        }

    }
}


if ( ! class_exists( 'MipTheme_List' ) ) {
    class MipTheme_List {

        static function get_list( $atts, $content = null ) {
            extract(shortcode_atts(array(), $atts));

		    return '<ul class="shortcode-list">'. do_shortcode($content) . '</ul>';
        }

        static function get_listitem( $atts, $content = null ) {
            extract(shortcode_atts(array(
    			'icon'      => 'fa-check'
    		), $atts));

    		return '<li><i class="fa '.esc_attr($icon).'"></i> '. do_shortcode($content) . '</li>';
        }

    }
}
