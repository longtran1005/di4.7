<?php
$category = get_the_category();

// Update Post View
MipTheme_Post_Views::update_post_views($post->ID);
//Update Read Post Counting
MipTheme_Post_Views::update_count_read_post($post->ID);
?>
<head>
    <link rel="stylesheet" id="miptheme-oldstyle-css-1-css" href="/wp-content/themes/weeklynews/vendor/css/desktopStyles1.css?ver=2.5.3" type="text/css" media="all">
</head>
<?php
while (have_posts()) {
    the_post();
    ?>
<body class="popupp">
    <form name="aspnetForm" method="post" action="<?php echo get_the_permalink(); ?>?print=" id="aspnetForm" data-content-id="6af0f7bd-549b-47f0-8b57-19f6a6264a4a">
        <div>
            <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwULLTEzODU0OTUzMzFkZIg47jzSIdoiEG1DwlaYkKtu8WVwiN57z5skmXYc53Cl">
        </div>

        <div>

            <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="14B16341">
        </div>
        <h1>


            &nbsp;
            <a class="printer" onclick="window.print(); return false;" href="#" title=""><span class="no">To print</span></a>
        </h1>

        <div class="box-white group">
            <span class="fright">Publicerad <?php echo mysql2date('d-m-Y', get_the_date()); ?></span>
        </div>

        <h2>
            <?php
            $title = get_field('title_for_article', $post->ID);
            if (!$title) $title = the_title();
            echo $title;
            ?>
        </h2>


        <div class="flexiblesize">
            <div class="nosver" style="">
                <div>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>


        <?php $author_image = get_field('author_image', $post->ID); ?>

        <div>



            <p class="authorzone group">


  <span>
    <?php if (get_field('author_info', $post->ID)): ?>
    <a id="ctl00_MainContent_HideArticleAuthors_ArticleAuthorsList_ctl00_ctl00_AuthorLink" href="#"><?php echo get_field('author_info', $post->ID); ?></a>
    <?php endif; ?>
      <?php if (get_field('author_email_address', $post->ID)): ?>
          <a href="mailto:<?php echo get_field('author_email_address', $post->ID); ?>"><?php echo get_field('author_email_address', $post->ID); ?></a>
      <?php endif; ?>


<!--      <a class="twitterlink" href="https://twitter.com/didebatt" target="_blank">@didebatt</a>-->

  </span>
            </p>




        </div>



        <script src="http://static.images-di.se/CombinedScripts/desktopPrintPageBottomScript.js?v=EBpMsRkVNduwC_Und04UT3L0f7FeVdbfwgeOfkyLFAk1"></script>

    </form>

</body>
<?php
} //endwhile;
?>
