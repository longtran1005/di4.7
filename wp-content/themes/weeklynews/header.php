<?php
/**
 * WeeklyNews Theme
 *
 * Theme by: MipThemes
 * http://themes.mipdesign.com
 *
 * Our portfolio: http://themeforest.net/user/mip/portfolio
 * Thanks for using our theme!
 *
 */
 global $mp_weeklynews;
?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <!-- start:global -->
    <meta charset="<?php bloginfo( 'charset' );?>" />
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"><![endif]-->
    <!-- end:global -->

    <!-- start:page title -->
    <title><?php if ( isset($mp_weeklynews['_mp_page_title_simple']) && (bool)$mp_weeklynews['_mp_page_title_simple'] ) { wp_title(''); } else if (is_front_page()) { ?>  <?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>  <?php  } else { wp_title(' | ', true, 'right'); ?> <?php bloginfo('name'); } ?></title>
    <!-- end:page title -->

    <!-- start:responsive web design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- end:responsive web design -->

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <!-- Favicon icon -->
    <link rel="apple-touch-icon" sizes="57x57" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="60x60" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/weeklynews/images/favicons/apple-touch-icon-180x180.png" />
    <link rel="icon" type="image/png" href="/wp-content/themes/weeklynews/images/favicons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/wp-content/themes/weeklynews/images/favicons/android-chrome-192x192.png" sizes="192x192" />
    <link rel="icon" type="image/png" href="/wp-content/themes/weeklynews/images/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/wp-content/themes/weeklynews/images/favicons/favicon-16x16.png" sizes="16x16" />

    <?php
        // facebook image meta tag - video only post fix
        if ( isset($mp_weeklynews['_mp_page_open_graph_image']) && (bool)$mp_weeklynews['_mp_page_open_graph_image'] && is_single() ) {
            global $post;
            if (has_post_thumbnail($post->ID)) {
                $post_feat_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                if (!empty($post_feat_image[0])) {
                    echo '<meta property="og:image" content="' .  $post_feat_image[0] . '" />';
                }
            }
        }


        // set facebook App ID
        if ( isset($mp_weeklynews['_mp_post_facebook_app_id']) && ($mp_weeklynews['_mp_post_facebook_app_id'] != '') ) echo '<meta property="fb:app_id" content="'. $mp_weeklynews['_mp_post_facebook_app_id'] .'" />';

        // set favicons
        if ( isset($mp_weeklynews['_mp_favicon_16']['url']) && ($mp_weeklynews['_mp_favicon_16']['url'] != '') ) echo '<link rel="icon" type="image/png" href="'. esc_url($mp_weeklynews['_mp_favicon_16']['url']) .'">';
        if ( isset($mp_weeklynews['_mp_favicon_57']['url']) && ($mp_weeklynews['_mp_favicon_57']['url'] != '') ) echo '<link rel="apple-touch-icon" href="'. esc_url($mp_weeklynews['_mp_favicon_57']['url']) .'">';
        if ( isset($mp_weeklynews['_mp_favicon_76']['url']) && ($mp_weeklynews['_mp_favicon_76']['url'] != '') ) echo '<link rel="apple-touch-icon-precomposed" sizes="76x76" href="'. esc_url($mp_weeklynews['_mp_favicon_76']['url']) .'">';
        if ( isset($mp_weeklynews['_mp_favicon_120']['url']) && ($mp_weeklynews['_mp_favicon_120']['url'] != '') ) echo '<link rel="apple-touch-icon-precomposed" sizes="120x120" href="'. esc_url($mp_weeklynews['_mp_favicon_120']['url']) .'">';
        if ( isset($mp_weeklynews['_mp_favicon_152']['url']) && ($mp_weeklynews['_mp_favicon_152']['url'] != '') ) echo '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="'. esc_url($mp_weeklynews['_mp_favicon_152']['url']) .'">';
    ?>

    <?php wp_head(); ?>

    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/respond.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5shiv.js"></script>
    <![endif]-->
</head>
<body <?php body_class() ?> itemscope itemtype="http://schema.org/WebPage">

    <!-- start:body-start -->
    <?php get_template_part('elements/body-start'); ?>
    <!-- end:body-start -->

    <!-- start:page outer wrap -->
    <div id="page-outer-wrap">
        <!-- start:page inner wrap -->
        <div id="page-inner-wrap">

        <?php get_template_part('elements/header-navigation'); ?>
        
        
<script>
    $(document).ready(function () {
        $(".dropnav-container").hide();
        $('.container').removeClass('custom-padding');
        var element = $(".menuheader").find('li.current-menu-item');
        var id = '.parent-' + element.attr('id');
        
        if($(id).length){
            $(id).removeClass('hidden');
            $('.container').addClass('custom-padding');
        };

        $('.custom-search').click(function(){
            var key = $('#search_text').val();
            document.location.href = '/?s=' + key;
        })

        $('.print-popup').click(function(){
            var url = $('.print-popup').data().printurl;
            window.open(url, "popupWindow", "width=625,height=600,scrollbars=yes");

        })
    });
</script>