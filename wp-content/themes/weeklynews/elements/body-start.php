<?php
    global $mp_weeklynews;
    
    if ( isset($mp_weeklynews['_mp_post_facebook_comments_enable']) && (bool)$mp_weeklynews['_mp_post_facebook_comments_enable'] ) :
        $fb_local   = ( isset($mp_weeklynews['_mp_social_facebook_local']) && ($mp_weeklynews['_mp_social_facebook_local'] != '') )    ?  $mp_weeklynews['_mp_social_facebook_local'] : 'en_US';

?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/<?php echo $fb_local; ?>/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
    endif;
?>