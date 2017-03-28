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
 * File Date: 08/18/14
 */

global  $page_template,
        $category,
        $page_sidebar_pos,
        $featured_video_url,
        $featured_video_embed,
        $featured_audio_embed,
        $featured_image_height_limit,
        $curr_sidebar_source,
        $curr_sidebar_source_middle,
        $filter_related_posts_title,
        $filter_related_posts_offset,
        $filter_related_posts_sort,
        $review_post,
        $review_post_position,
        $enable_prevnext_posts,
        $enable_postmeta,
        $enable_breadcrumbs,
        $show_category_feat_img,
        $content_width,
        $ads_post_section_one,
        $ads_post_section_two,
        $ads_post_section_three;

//get meta values
$page_template                  = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_post_layout_single')                  ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_post_layout_single')                  : $mp_weeklynews['_mp_post_layout'];
$featured_image_height_limit    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_post_layout_single_image_height')     ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_post_layout_single_image_height')     : ( isset($mp_weeklynews['_mp_post_layout_image_height'] ) ? $mp_weeklynews['_mp_post_layout_image_height'] : 0);
$page_sidebar_pos               = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_position_single')             ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_position_single')             : $mp_weeklynews['_mp_sidebar_position'];
$curr_sidebar_source            = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_source_single')               ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_source_single')               : $mp_weeklynews['_mp_sidebar_source'];
$curr_sidebar_source_middle     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_source_single_middle')        ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_sidebar_source_single_middle')        : $mp_weeklynews['_mp_sidebar_source_middle'];
$enable_author                  = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_author_single')                ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_author_single')                : $mp_weeklynews['_mp_enable_author'];
$enable_prevnext_posts          = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_prevnext_posts_single')        ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_prevnext_posts_single')        : $mp_weeklynews['_mp_enable_prevnext_posts'];
$enable_related_posts           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_posts_single')         ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_related_posts_single')         : $mp_weeklynews['_mp_enable_related_posts'];
$filter_related_posts           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_filter_related_posts_single')         ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_filter_related_posts_single')         : $mp_weeklynews['_mp_filter_related_posts'];
$filter_related_posts_title     = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_title_single')          ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_title_single')          : $mp_weeklynews['_mp_related_posts_title'];
$filter_related_posts_offset    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_offset_single')         ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_offset_single')         : $mp_weeklynews['_mp_related_posts_offset'];
$filter_related_posts_sort      = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_sort_single')           ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_related_posts_sort_single')           : $mp_weeklynews['_mp_related_posts_sort'];
$featured_video_url             = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_featured_video');
$featured_video_embed           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_featured_video_embed');
$featured_audio_embed           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_featured_audio_embed');
$review_post                    = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_enable_review_post');
$review_post_position           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_review_post_position');
$enable_postmeta                = $mp_weeklynews['_mp_enable_postmeta'];
$enable_breadcrumbs             = $mp_weeklynews['_mp_posts_enable_breadcrumbs'];
$show_category_feat_img         = $mp_weeklynews['_mp_posts_show_category_on_feat_img'];

$ads_post_section_one           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_1_single')     ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_1_single')     : ( isset($mp_weeklynews['_mp_ads_posts_section_1'] ) ? $mp_weeklynews['_mp_ads_posts_section_1'] : 0);
$ads_post_section_two           = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_2_single')     ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_2_single')     : ( isset($mp_weeklynews['_mp_ads_posts_section_2'] ) ? $mp_weeklynews['_mp_ads_posts_section_2'] : 0);
$ads_post_section_three         = redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_3_single')     ? redux_post_meta(THEMEREDUXNAME, $post->ID, '_mp_ads_posts_section_3_single')     : ( isset($mp_weeklynews['_mp_ads_posts_section_3'] ) ? $mp_weeklynews['_mp_ads_posts_section_3'] : 0);

$category = get_the_category();

// Update Post View
MipTheme_Post_Views::update_post_views($post->ID);

// Content Width for Jetpack
if ( $page_sidebar_pos == 'hide-sidebar' ) $content_width = 1120;

get_header();

while (have_posts()) {
the_post();


?>

<div class="scroll-area" style="visibility: visible;">
    <div class="container">
        <div class="contentpage">
            <div class="threecols">
                <div class="maincol">
                    <div class="section lp_flak">
                        <div class="intro top-toolbar-container">
                            <a class="tillbaka js top-toolbar has-padding-right" href="javascript:goBack()" title=""><strong class="arrow-back">«</strong>Tillbaka</a>
                            <a name="readlater" class="js-subscribe-article  top-toolbar has-padding-left top-toolbar-float-right js-logged-in" data-pageguid="cfb65214-e9e3-4b8d-8010-cd304e417fd0">Spara artikel</a>
                            <div class="vertical-divider-right "></div>
                            <a name="toprint" class="print-popup  top-toolbar has-padding top-toolbar-float-right " data-printurl="/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/?print=">Skriv ut</a>
                            <div>
                                <div class="vertical-divider-right"></div>
                                <a id="hlCommentsCounter" class="kommentarer js-article-comments-count  top-toolbar has-padding" data-comments-text="Kommentarer ({0})" href="http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/#comments">Kommentera (0)</a>
                            </div>
                        </div>
                        <h1 class="nosver" style="">
                            <?php the_title();?>
                        </h1>
                        <p><span class="pubdate">Publicerad 2016-03-25 07:59</span></p>
                        <div class="preambula">
                            <div class="nosver" style="">
                            </div>
                            <div class="nosver" style="">
                                <p class="group">
                                    <?php the_post_thumbnail([532, 299], ['class' => "noprint", 'style' => 'border-width:0px;']);?>
                                    <span class="figcaption"></span>
                                    <span class="figcaption credit">Foto: Colourbox</span>
                                </p>
                            </div>
                            <div class="flexiblesize">
                                <div class="nosver" style="">
                                    <div>
                                    <?php the_content(); ?>
                                    </div>
                                </div>
                                <div class="sver" style="display : none"></div>
                            </div>
                        </div>
                        <div class="flexiblesize">
                            <div class="sver" style="display : none"></div>
                        </div>
                        <div class="content-holder">
                            <div class="nosver" style="">
                            </div>
                            <div>
                                <p><strong>Kunderna använder mobilerna</strong> för att titta på film och tv i allt större utsträckning, vilket gör att de som har abonnemang med begränsad datamängd riskerar att slå i taket eller drabbas av extraavgifter vid Netflixtittande.</p>
                            </div>
                            <div>
                                <p><strong>I maj beräknas</strong> tjänsten släppas.</p>
                            </div>
                        </div>
                        <div class="author-container ">
                            <div class="authorzone">
                                <p class="authorzone group">
                                    <span>
                                    <a id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl00_ArticleAuthorsList_ctl00_ctl00_AuthorLink" href="/nyheter/tt-1/">TT</a>
                                    </span>
                                </p>
                            </div>
                            <div class="share-container js-share-tool " data-article-id="cfb65214-e9e3-4b8d-8010-cd304e417fd0" data-can-be-shared-for-free="True">
                                <h2>
                                    <span class="share-text">Dela artikel</span>
                                </h2>
                                <div class="share-type facebook">
                                    <a href="https://www.facebook.com/dialog/share?app_id=258882817554391&amp;display=popup&amp;href=http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/&amp;redirect_uri=http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/" target="_blank" data-url-template="{0}" data-statistic-share-type="sharedFacebookArticle" data-share-type="facebook">
                                    <i class="facebook-icon"></i>
                                    Facebook
                                    </a>
                                </div>
                                <div class="share-type twittr">
                                    <a href="https://twitter.com/intent/tweet?text=Netflix%20ska%20dra%20mindre%20mobildata%20http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/" target="_blank" data-url-template="https://twitter.com/intent/tweet?text=Netflix%20ska%20dra%20mindre%20mobildata%20{0}" data-statistic-share-type="sharedTwitterArticle" data-share-type="twitter">
                                    <i class="twittr-icon"></i>
                                    Twitter
                                    </a>
                                </div>
                                <div class="share-type linkedin">
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/&amp;title=Netflix%20ska%20dra%20mindre%20mobildata" target="_blank" data-url-template="http://www.linkedin.com/shareArticle?mini=true&amp;url={0}&amp;title=Netflix%20ska%20dra%20mindre%20mobildata" data-statistic-share-type="sharedLinkedInArticle" data-share-type="linkedin">
                                    <i class="linkedin-icon"></i>
                                    Linked In
                                    </a>
                                </div>
                                <div class="share-type email">
                                    <a id="share-by-email-link"><i class="email-icon"></i>Email</a>
                                </div>
                                <div id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_popupDiv" class="js-popup-dynamic-content" data-popup-container-id="DynamicPopup" data-show-popup-selector="#share-by-email-link">
                                    <div id="email-popup" class="abuser" data-statistic-type="sharedEmailArticle" data-receiver-original-address="mottagarens e-postadress" data-sender-original-address="din e-postadress*">
                                    <h2> Skicka artikeln </h2>
                                    <ul class="twocols tomail">
                                        <li>        
                                            <input name="" type="text" value="mottagarens e-postadress" id="" data-save-state="addressTo">  
                                            <span id="" class="error-message" style="color:Red;display:none;">skriv in en korrekt e-postadress</span>
                                            <input name="ctl00$ctl00$ctl00$FourColumnWidthContent$ThreeColumnsContent$MainAndSecondColumnContent$MainColumnContent$ArticleMainContent$ArticleAuthorsContent$ArticleAuthorsContent$ctl01$ctl00$ctl00$addressFrom" type="text" value="din e-postadress*" id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_ctl00_addressFrom">
                                            <span id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_ctl00_addressFromRegularExpressionValidator" class="error-message" style="color:Red;display:none;">skriv in en korrekt e-postadress</span>
                                            <label for="message">Skicka med en hälsning</label>
                                            <textarea name="ctl00$ctl00$ctl00$FourColumnWidthContent$ThreeColumnsContent$MainAndSecondColumnContent$MainColumnContent$ArticleMainContent$ArticleAuthorsContent$ArticleAuthorsContent$ctl01$ctl00$ctl00$message" rows="6" cols="18" id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_ctl00_message" data-save-state="message"></textarea> 
                                        </li>
                                        <li class="right">
                                            <div id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_ctl00_login" style="display: none;">
                                                <p><small>* Om du har ett konto på di.se fylls din e-postadress i automatiskt.</small></p>
                                                <p class="group">
                                                <label for="loggain">Inte inloggad?</label>
                                                <input type="button" name="loggain" class="log-in js-article-subscription-close-popup" value="Logga in">
                                                </p>
                                                <p>eller <a class="register js-article-subscription-close-popup" href="#">Skapa nytt konto - gratis</a></p>
                                            </div>
                                            <input type="button" name="ctl00$ctl00$ctl00$FourColumnWidthContent$ThreeColumnsContent$MainAndSecondColumnContent$MainColumnContent$ArticleMainContent$ArticleAuthorsContent$ArticleAuthorsContent$ctl01$ctl00$ctl00$sendButton" value="Skicka" onclick="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;ctl00$ctl00$ctl00$FourColumnWidthContent$ThreeColumnsContent$MainAndSecondColumnContent$MainColumnContent$ArticleMainContent$ArticleAuthorsContent$ArticleAuthorsContent$ctl01$ctl00$ctl00$sendButton&quot;, &quot;&quot;, true, &quot;EmailControl&quot;, &quot;&quot;, false, true))" id="ctl00_ctl00_ctl00_FourColumnWidthContent_ThreeColumnsContent_MainAndSecondColumnContent_MainColumnContent_ArticleMainContent_ArticleAuthorsContent_ArticleAuthorsContent_ctl01_ctl00_ctl00_sendButton" class="emailPopup">            
                                        </li>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aside lp_second">
                        <a class="secondcol-prenumerera skip-frame-reload" href="http://www.di.se/pren/digital-paketering/digitalpaper/">Prenumerera</a>                  
                        <div id="sidebar-mid" class="sidebar-mid">
                            <aside class="widget module-news">                
                                <div class="js-open-webtv-in-popup">
                                    <div class="red-border-top"></div>
                                    <div class="whitebox new-lastest-new-widget">
                                        <h3>
                                            <a id="" href="/nyheter/alla-nyheter/">Recent Posts</a>
                                            <i class="icon-red-arrow-right"></i>
                                        </h3>
                                        <ul class="listwhite">
                                                                                <li class="active">
                                                        <a href="http://difail.niteco.se/2016/03/24/insiderkronikan-reafynd-pa-mq/" title="">
                                                            Insiderkrönikan: Reafynd på MQ                                        </a>
                                                    </li>
                                                                                <li class="active">
                                                        <a href="http://difail.niteco.se/2016/03/24/headers-post/" title="">
                                                            Headers Post                                        </a>
                                                    </li>
                                                                                <li class="active">
                                                        <a href="http://difail.niteco.se/2016/03/24/links-post/" title="">
                                                            Links Post                                        </a>
                                                    </li>
                                                                                <li class="active">
                                                        <a href="http://difail.niteco.se/2016/03/24/blockquote-post/" title="">
                                                            Blockquote Post                                        </a>
                                                    </li>
                                                                                <li class="active">
                                                        <a href="http://difail.niteco.se/2016/03/24/ul-and-ol-post/" title="">
                                                            UL and OL Post                                        </a>
                                                    </li>
                                                                    </ul>
                                    </div>
                                </div>
                            </aside>        
                        </div>
                    </div>
                </div>
                <div class="sidebar lp_third">
                   
                </div>
            </div>
            <div class="fourthcol lp_tab">
            
            </div>
        </div>
    </div>
</div>

<?php
} //endwhile;
?>

<?php
    //load footer
    get_footer();
?>
