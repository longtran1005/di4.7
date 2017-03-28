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
 * File Date: 09/15/14
 */

global $cat_template, $page_show_posts_num;

$cat_template                   = $mp_weeklynews['_mp_404page_template'];
$cat_sidebar_template           = $mp_weeklynews['_mp_404page_sidebar_template'];
$curr_sidebar_source            = $mp_weeklynews['_mp_404page_sidebar_source'];
$curr_sidebar_source_middle     = $mp_weeklynews['_mp_404page_sidebar_source_middle'];
$page_show_posts                = $mp_weeklynews['_mp_404page_show_posts'];
$page_show_posts_num            = $mp_weeklynews['_mp_404page_posts_number'];
$page_show_posts_title          = $mp_weeklynews['_mp_404page_posts_title'];

get_header(); ?>

<!-- start:ad-top-banner -->
<?php get_template_part('elements/ad-top-banner'); ?>
<!-- end:ad-top-banner -->

<!-- start:container -->
<div class="container">
    <!-- start:page content -->
    <div id="page-content" class="<?php echo esc_attr($cat_sidebar_template); ?>">
        <div class="container errorpage">
            <div class="box">
                <div class="inner">
                    <h1>
                        404 – sidan kunde inte hittas</h1>
                    <p>
                        <strong>Sidan du försöker nå kan tyvärr inte hittas på di.se.<br>
                            Det kan bero på att sidan har tagits borts, att länken är trasig eller att du råkat skriva in fel adress.</strong>
                    </p>
                    <p class="marked">
                        <strong>Kontrollera igen att du skrivit in rätt adress.</strong></p>
                    <p>
                        Om du klickat på en länk på någon av våra sidor eller om du tror att något har blivit fel hos oss, mejla gärna och berätta:</p>
                    <p>
                        <a href="mailto:dise@di.se"><strong>dise@di.se</strong></a></p>
                    <p>
                        Glöm inte att berätta vilken länk du klickade på, så ska vi försöka åtgärda felet.</p>
                </div>
                <!-- // .inner -->
            </div>
        </div>



    </div>
    <!-- end:page content -->
</div>
<!-- end:container -->

<?php
    //load footer
    get_footer();
?>
