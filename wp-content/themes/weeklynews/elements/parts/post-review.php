<?php
    global $mp_weeklynews, $page_sidebar_pos;
    
    $review_post   = $mp_weeklynews['_mp_enable_review_post'];
    
    if ( $review_post == 'enable' ) :
        $review_post_style              = $mp_weeklynews['_mp_review_post_style'];
        $review_post_summary_type       = $mp_weeklynews['_mp_review_post_summary_type'];
        $review_post_summary_text       = $mp_weeklynews['_mp_review_post_summary_text'];
        $review_post_summary_text_good  = $mp_weeklynews['_mp_review_post_summary_text_good'];
        $review_post_summary_text_bad   = $mp_weeklynews['_mp_review_post_summary_text_bad'];
        $review_post_total_text         = $mp_weeklynews['_mp_review_post_total_text'];
        $review_post_criteria_count     = $mp_weeklynews['_mp_review_post_criteria_count'];
        $review_post_total_score        = $mp_weeklynews['_mp_review_post_total_score'];
        $review_post_position           = $mp_weeklynews['_mp_review_post_position'];
        
        switch ($page_sidebar_pos) {
            case 'multi-sidebar':
                $score_column    = '4';
                $summary_column  = '8';
            break;
            default:
                $score_column    = '3';
                $summary_column  = '9';
            break;
        }
        
        $review_output  = '
            <!-- start:review -->
            <div class="review">
                <div class="row bottom-margin">
                    <div class="col-sm-'. esc_attr($score_column) .'">
                        <div class="score-overall">
                            <span class="score-number">'. ( ( $review_post_style == 'percentage' ) ? round($review_post_total_score) .'%' : round($review_post_total_score/10, 1) ) .'</span>
                            <span class="score-desc">'. $review_post_total_text .'</span>
                        </div>
                    </div>
                    <div class="col-sm-'. esc_attr($summary_column) .'">';
        
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
            $crit_name      = $mp_weeklynews['_mp_review_post_criteria_'. $i .''];
            $crit_value     = $mp_weeklynews['_mp_review_post_criteria_value_'. $i .''];
            $review_output  .= '
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: '. esc_attr($crit_value) .'%;">
                        <span class="skill-number pull-left">'. ( ( $review_post_style == 'percentage' ) ? $crit_value .' %' : round($crit_value/10, 1) ) .'</span>
                        <span class="skill-text pull-left">'. $crit_name .'</span>
                    </div>
                </div>';
        }

        $review_output  .= '</div><!-- end:review -->';
        
        echo $review_output;
    endif;
?>