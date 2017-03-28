<div class="soc-media-sharing <?php echo $mp_weeklynews['_mp_social_sharing_theme']; ?>">
    <?php if ( isset($mp_weeklynews['_mp_social_sharing_title'])&&($mp_weeklynews['_mp_social_sharing_title'] != '') ) echo '<h3 class="hidden-xs">'. $mp_weeklynews['_mp_social_sharing_title'] .'</h3>'; ?>
    <?php
        // facebook share
        if ( isset($mp_weeklynews['_mp_social_sharing_facebook'])&&($mp_weeklynews['_mp_social_sharing_facebook'] != 'none') ) {
    ?>
    <a class="btn-social btn-facebook <?php echo $mp_weeklynews['_mp_social_sharing_facebook']; ?>" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-facebook-square fa-lg"></i><span id="smFacebook">Facebook</span></a>
    <?php
        }
        // twitter share
        if ( isset($mp_weeklynews['_mp_social_sharing_twitter'])&&($mp_weeklynews['_mp_social_sharing_twitter'] != 'none') ) {
    ?>
    <a class="btn-social btn-twitter <?php echo $mp_weeklynews['_mp_social_sharing_twitter']; ?>" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr(get_the_title()); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-twitter-square fa-lg"></i><span id="smTwitter">Twitter</span></a>
    <?php
        }
        // google share
        if ( isset($mp_weeklynews['_mp_social_sharing_google'])&&($mp_weeklynews['_mp_social_sharing_google'] != 'none') ) {
    ?>
    <a class="btn-social btn-google <?php echo $mp_weeklynews['_mp_social_sharing_google']; ?>" href="http://plus.google.com/share?url=<?php echo get_permalink(); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-google-plus-square fa-lg"></i><span id="smGoogle">Google+</span></a>
    <?php
        }
        // linkedin share
        if ( isset($mp_weeklynews['_mp_social_sharing_linkedin'])&&($mp_weeklynews['_mp_social_sharing_linkedin'] != 'none') ) {
    ?>
    <a class="btn-social btn-linkedin <?php echo $mp_weeklynews['_mp_social_sharing_linkedin']; ?>" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo esc_attr(get_the_title()); ?>" onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-linkedin-square fa-lg"></i><span id="smLinkedin">LinkedIn</span></a>
    <?php
        }
        // pinterest share
        if ( isset($mp_weeklynews['_mp_social_sharing_pinterest'])&&($mp_weeklynews['_mp_social_sharing_pinterest'] != 'none') ) {
    ?>
    <a class="btn-social btn-pinterest <?php echo $mp_weeklynews['_mp_social_sharing_pinterest']; ?>" href="http://pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&amp;media=<?php echo ( $curr_post_img ? $curr_post_img : ''); ?>"  onclick="window.open(this.href, 'weeklywin', 'left=50,top=50,width=600,height=360,toolbar=0'); return false;"><i class="fa fa-pinterest-square fa-lg"></i><span>Pinterest</span></a>
    <?php
        }
    ?>
</div>
<?php
    if  (
            (isset($mp_weeklynews['_mp_social_sharing_facebook'])&&($mp_weeklynews['_mp_social_sharing_facebook'] == 'btn-icon-title btn-icon-counter')) ||
            (isset($mp_weeklynews['_mp_social_sharing_twitter'])&&($mp_weeklynews['_mp_social_sharing_twitter'] == 'btn-icon-title btn-icon-counter')) ||
            (isset($mp_weeklynews['_mp_social_sharing_linkedin'])&&($mp_weeklynews['_mp_social_sharing_linkedin'] == 'btn-icon-title btn-icon-counter'))
        ) {
?>
<script>
    "use strict";
    var smStats =   '<?php echo get_permalink(); ?>';
    <?php
        if (isset($mp_weeklynews['_mp_social_sharing_facebook'])&&($mp_weeklynews['_mp_social_sharing_facebook'] == 'btn-icon-title btn-icon-counter')) { echo 'var smStatsFacebook =   true;'; } else { echo 'var smStatsFacebook =   false;'; }
        if (isset($mp_weeklynews['_mp_social_sharing_twitter'])&&($mp_weeklynews['_mp_social_sharing_twitter'] == 'btn-icon-title btn-icon-counter'))   { echo 'var smStatsTwitter =   true;';  } else { echo 'var smStatsTwitter =   false;';  }
        //if (isset($mp_weeklynews['_mp_social_sharing_google'])&&($mp_weeklynews['_mp_social_sharing_google'] == 'btn-icon-title btn-icon-counter'))     { echo 'var smStatsGoogle =   true;';   } else { echo 'var smStatsGoogle =   false;';   }
        if (isset($mp_weeklynews['_mp_social_sharing_linkedin'])&&($mp_weeklynews['_mp_social_sharing_linkedin'] == 'btn-icon-title btn-icon-counter')) { echo 'var smStatsLinkedIn =   true;';   } else { echo 'var smStatsLinkedIn =   false;';   }
    ?>
</script>
<?php
    }
?>
