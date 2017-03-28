<?php
$category = get_the_category();

// Update Post View
MipTheme_Post_Views::update_post_views($post->ID);
//Update Read Post Counting
MipTheme_Post_Views::update_count_read_post($post->ID);




$requesPrint = $_GET['print'];
if($requesPrint){
    locate_template('di-print.php',true);
} else {
    get_header();
    while (have_posts()) {
        the_post();
        ?>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>

        <div class="scroll-area">
            <div class="container">
                <div class="row">
                    <div class="section article-detail col-lg-6 col-md-8 col-xs-12">
                        <div class="intro top-toolbar-container">
                            <a class="top-toolbar has-padding-right pull-left" href="javascript:goBack()"
                               title=""><strong class="arrow-back">«</strong>Tillbaka</a>
                            <a name="toprint" class="print-popup  top-toolbar has-padding top-toolbar-float-right "
                               data-printurl="<?php echo get_the_permalink(); ?>?print=1">Skriv ut</a>
                            <?php
                            /*
                            <a name="readlater" class="js-subscribe-article  top-toolbar has-padding-left top-toolbar-float-right js-logged-in" data-pageguid="cfb65214-e9e3-4b8d-8010-cd304e417fd0">Spara artikel</a>
                            <div class="vertical-divider-right "></div>
                            <a name="toprint" class="print-popup  top-toolbar has-padding top-toolbar-float-right " data-printurl="/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/?print=">Skriv ut</a>
                            <div>
                                <div class="vertical-divider-right"></div>
                                <a id="hlCommentsCounter" class="kommentarer js-article-comments-count  top-toolbar has-padding" data-comments-text="Kommentarer ({0})" href="http://www.di.se/artiklar/2016/3/25/netflix-ska-dra-mindre-mobildata/#comments">Kommentera (0)</a>
                            </div>
                            */
                            ?>
                        </div>
                        <h1 class="nosver">
                            <?php
                            $title = get_field('title_for_article', $post->ID);
                            if (!$title) $title = the_title();
                            echo $title;
                            ?>
                        </h1>

                        <p>
                            <span class="pubdate">Publicerad <?php echo mysql2date('d-m-Y', get_the_date()); ?></span>
                        </p>

                        <div class="preambula">
                            <?php
                            if (get_post_thumbnail_id()) {
                                $thumb_img = get_post(get_post_thumbnail_id());
                                ?>
                                <div class="nosver">
                                    <p class="group">
                                        <?php
                                            $article_image = get_field('image_display_on_article', $post->ID);
                                            if(!$article_image):
                                                the_post_thumbnail(array(532, 299), array('class' => "noprint", 'style' => 'border-width:0px;'));
                                            else :
                                        ?>
                                            <img class="noprint" src="<?php echo $article_image['url']; ?>" style="border-width:0px; max-height: 299px">
                                        <?php
                                            endif;
                                        ?>
                                        <span class="figcaption"><?php echo $thumb_img->post_content ?></span>
                                        <span class="figcaption credit">
                                            <?php
                                            if(!$article_image)
                                                echo $thumb_img->post_excerpt;
                                            else
                                                echo get_field('article_image_caption', $post->ID);
                                            ?>
                                        </span>
                                    </p>
                                </div>

                            <?php
                            }
                            ?>

                            <div class="flexiblesize">
                                <div class="nosver" style="">
                                    <div>
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="author-container ">
                            <div class="authorzone">
                                <?php $author_image = get_field('author_image', $post->ID); ?>
                                <p class="authorzone group">
                                    <?php if ($author_image['sizes']['thumbnail']): ?>
                                        <a href="#">
                                            <img src="<?php echo $author_image['sizes']['thumbnail']; ?>"
                                                 style="border-width:0px;">
                                        </a>
                                    <?php endif; ?>
                                    <span>
                                 <?php if (get_field('author_info', $post->ID)): ?>
                                     <a href="#"><?php echo get_field('author_info', $post->ID); ?></a>
                                 <?php endif; ?>
                                        <?php if (get_field('author_email_address', $post->ID)): ?>
                                            <a href="mailto:<?php echo get_field('author_email_address', $post->ID); ?>"><?php echo get_field('author_email_address', $post->ID); ?></a>
                                        <?php endif; ?>
                                </span>
                                </p>
                            </div>
                            <?php
                            /*

                            <div class="share-container js-share-tool " data-article-id="cfb65214-e9e3-4b8d-8010-cd304e417fd0" data-can-be-shared-for-free="True">
                                <h2>
                                    <span class="share-text">Dela artikel</span>
                                </h2>
                                <div class="share-type facebook">
                                    <a href="https://www.facebook.com/dialog/share?app_id=258882817554391&amp;display=popup&amp;href=<?php the_permalink();?>&amp;redirect_uri=<?php the_permalink();?>" target="_blank" data-url-template="{0}" data-statistic-share-type="sharedFacebookArticle" data-share-type="facebook">
                                    <i class="facebook-icon"></i>
                                    Facebook
                                    </a>
                                </div>
                                <div class="share-type twittr">
                                    <a href="https://twitter.com/intent/tweet?text=<?php the_title();?>%20<?php the_permalink();?>" target="_blank" data-url-template="https://twitter.com/intent/tweet?text=Netflix%20ska%20dra%20mindre%20mobildata%20{0}" data-statistic-share-type="sharedTwitterArticle" data-share-type="twitter">
                                    <i class="twittr-icon"></i>
                                    Twitter
                                    </a>
                                </div>
                                <div class="share-type linkedin">
                                    <a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>/&amp;title=<?php the_title();?>" target="_blank" data-url-template="http://www.linkedin.com/shareArticle?mini=true&amp;url={0}&amp;title=Netflix%20ska%20dra%20mindre%20mobildata" data-statistic-share-type="sharedLinkedInArticle" data-share-type="linkedin">
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

                            */
                            ?>

                        </div>


                        <div class="related-post">
                            <?php
                            $categories = get_the_category($post->ID);
                            if ($categories) {
                                $category_ids = array();
                                foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;
                                $args = array(
                                    'category__in' => $category_ids,
                                    'post__not_in' => array($post->ID),
                                    'posts_per_page' => 5,
                                    'ignore_sticky_posts' => 1,
                                    'orderby' => $sort_order,
                                    'offset' => $offset,
                                    'meta_key' => (($sort_order == 'meta_value_num') ? 'mip_post_views_count' : ''),
                                );
                            }

                            $r = new WP_Query(apply_filters('widget_posts_args', $args));
                            if ($r->have_posts()) :
                                while ($r->have_posts()) :
                                    $r->the_post();
                                    $row_link = get_the_permalink();

                                    $thumbnail = get_post_thumbnail_id();
                                    $thumb_img = get_post($thumbnail);


                                    $caption_img = get_post_meta($post->ID, '_mp_featured_image_caption', true);
                                    if (!$caption_img) {
                                        $caption_img = $thumb_img->post_excerpt;
                                    }

                                    $type_display = get_field('type_display_on_home_page', $post->ID);

                                    $image_src = "";
                                    $font_size_class = "";

                                    $headline_font_size = get_field('headline_font_size', $post->ID);
                                    $font_size_class = MipTheme_Util::getHeadlineFontSize($headline_font_size, $type_display, $post->post_title);

                                    ?>
                                    <div class="lp_row1">
                                        <div class="spteaser">
                                            <?php
                                            if ($type_display == "image-left" || $type_display == "image-right") {
                                                $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-2');
                                                $class = $type_display == "image-left" ? "imgleft" : "imgright";
                                                ?>
                                                <div class="widget <?php echo $class; ?>">
                                                    <a href="<?php echo $row_link; ?>" class="" target="">
                                                    <span class="gate">
                                                        <img src="<?php echo $image_src[0]; ?>" width="256"
                                                             height="144">
                                                        <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                            <var>
                                                                <span><?php echo $thumb_img->post_content ?></span>
                                                                <span><?php echo $caption_img ?></span>
                                                            </var>
                                                        <?php endif; ?>
                                                    </span>
                                                    </a>

                                                    <h2>
                                                        <a href="<?php echo $row_link; ?>">
                                                            <span
                                                                class="<?php echo $font_size_class; ?>"><?php echo $post->post_title ?></span>
                                                        </a>
                                                    </h2>

                                                    <p>
                                                        <a href="<?php echo $row_link; ?>">
                                                            <?php echo get_field("summary", $post->ID); ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            <?php
                                            } else {
                                                $image_src = wp_get_attachment_image_src($thumbnail, 'post-thumb-wide');
                                                $class = "full-width";
                                                ?>
                                                <div class="widget <?php echo $class; ?>">
                                                    <?php if ($image_src) {
                                                        ?>
                                                        <a href="<?php echo $row_link ?>" class="" target="">
                                                        <span class="gate imgtopic bigfoto">
                                                            <img src="<?php echo $image_src[0]; ?>"
                                                                 style="border-width:0px;" width="532" height="130">
                                                            <?php if ($thumb_img != null && ($thumb_img->post_content != null || $thumb_img->post_excerpt != null)) : ?>
                                                                <var>
                                                                    <span><?php echo $thumb_img->post_content ?></span>
                                                                    <span><?php echo $caption_img ?></span>
                                                                </var>
                                                            <?php endif; ?>
                                                        </span>
                                                        </a>
                                                    <?php } ?>
                                                    <h2>
                                                        <a href="<?php echo get_permalink($post->ID); ?>">
                                                            <span
                                                                class="<?php echo $font_size_class; ?>"><?php echo $post->post_title ?>
                                                                <br></span>
                                                        </a>
                                                    </h2>

                                                    <p>
                                                        <a href="<?php echo get_permalink($post->ID); ?>">
                                                            <?php echo get_field("summary", $post->ID); ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
                            endif;
                            wp_reset_postdata();
                            wp_reset_query();
                            ?>
                        </div>
                        <!-- end related post -->
                    </div>
                    <div class="aside col-lg-3 col-md-4 col-xs-12">
                        <a class="secondcol-prenumerera skip-frame-reload"
                           href="http://www.di.se/pren/digital-paketering/digitalpaper/">Prenumerera</a>
                        <?php get_sidebar('mid') ?>
                    </div>
                    <div class="sidebar col-lg-2 col-md-12 col-xs-12">

                    </div>
                    <div class="fourthcol col-lg-2 col-md-12 col-xs-12">

                    </div>
                </div>
            </div>
        </div>

    <?php
    } //endwhile;
    get_footer();
} //endif;
?>
