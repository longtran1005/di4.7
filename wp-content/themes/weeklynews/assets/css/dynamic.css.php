<?php
  header('Content-type: text/css');
?>

<?php
  global $mp_weeklynews, $wpdb;

  // Loop trough custom links in menus
  $custom_links = $wpdb->get_results(
    "
    SELECT post_id, meta_value
    FROM $wpdb->postmeta
    WHERE meta_key = '_menu_item_nav_color' AND meta_value <> ''
    "
  );

  foreach ( $custom_links as $menu_link )
  {
    $color = $menu_link->meta_value;
    if ($color) {
      if(!preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) break;
      //die("Not a value color");


      $colorDarker = ''; // Prepare to fill with the results
      for($i = 1; $i <= 3; $i++) {
        $parts[$i] = hexdec($parts[$i]);
        $parts[$i] = round($parts[$i] * 80/100); // 80/100 = 80%, i.e. 20% darker
        $colorDarker .= str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
      }
?>

#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .dropnav-container ul.dropnav-menu,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .dropnav-container ul.dropnav-menu li,
#mobile-menu ul li#mobile-nav-menu-item-<?php echo $menu_link->post_id; ?> a,
#foot-menu ul li.menu-item-<?php echo $menu_link->post_id; ?> a {
    border-color: <?php echo $color; ?>;
}

#header-navigation ul li.menu-category-<?php echo $menu_link->post_id; ?> .subnav-menu,
#header-navigation ul li.menu-category-<?php echo $menu_link->post_id; ?>:hover .subnav-menu a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .subnav-container,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .subnav-menu a:hover,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .subnav-menu .current a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> .dropnav-container ul li a:hover {
    background: <?php echo $color; ?>;
}

#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> a:hover,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?>:hover a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?> ul,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?>.current-menu-item a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?>.current-menu-parent a,
#header-navigation ul li#nav-menu-item-<?php echo $menu_link->post_id; ?>.current-post-ancestor a,
#header-navigation-sub nav.cat-<?php echo $menu_link->post_id; ?>,
#mobile-menu ul li#mobile-nav-menu-item-<?php echo $menu_link->post_id; ?> a:hover {
    color: #fff;
    background: <?php echo '#'. $colorDarker; ?>;
}

#foot-menu ul li.menu-item-<?php echo $menu_link->post_id; ?> a:hover,
#foot-menu ul li.menu-item-<?php echo $menu_link->post_id; ?>.current a {
    color: <?php echo '#'. $colorDarker; ?>;
}

<?php

    }
  }


  // Loop trough categories
  $categories = get_categories( array( 'hide_empty' => 0 ) );
    foreach ($categories as $category) {

      $cat_id           = $category->cat_ID;
      $cat_data         = get_option("category_$category->cat_ID");
      $cat_parent_id    = MipTheme_Util::get_category_top_parent_id($cat_id);
      //$color  = $cat_data['cat-primary-color'] ? $cat_data['cat-primary-color'] : ($cat_date_parent['cat-primary-color'] ? $cat_date_parent['cat-primary-color'] : '');
      $color            = $cat_data['cat-primary-color'] ? $cat_data['cat-primary-color'] : '';

      if ($color) {
        if(!preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $color, $parts)) break;
        //die("Not a value color");


        $colorDarker = ''; // Prepare to fill with the results
        for($i = 1; $i <= 3; $i++) {
          $parts[$i] = hexdec($parts[$i]);
          $parts[$i] = round($parts[$i] * 80/100); // 80/100 = 80%, i.e. 20% darker
          $colorDarker .= str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
        }

?>

#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .dropnav-container ul.dropnav-menu,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .dropnav-container ul.dropnav-menu li,
#mobile-menu ul li.menu-category-<?php echo $category->cat_ID; ?> a,
.sidr ul li.menu-category-<?php echo $category->cat_ID; ?> a {
    border-color: <?php echo $color; ?>;
}

#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .subnav-menu,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?>:hover .subnav-menu a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .dropnav-container ul li a:hover,
#mobile-menu ul li.menu-category-<?php echo $category->cat_ID; ?> a:hover {
    background: <?php echo $color; ?>;
}

#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> a:hover,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?>:hover a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> ul,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?>.current-menu-item a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?>.current-menu-parent a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?>.current-post-ancestor a,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .subnav-container,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .subnav-menu a:hover,
#header-navigation ul li.menu-category-<?php echo $category->cat_ID; ?> .subnav-menu .current a,
#header-navigation-sub nav.cat-<?php echo $category->cat_ID; ?>,
.sidr ul li.menu-category-<?php echo $category->cat_ID; ?> a:hover {
    color: #fff;
    background: <?php echo '#'. $colorDarker; ?>;
}

#header-navigation-sub nav.cat-<?php echo $category->cat_ID; ?> ul li.current-cat a,
#header-navigation-sub nav.cat-<?php echo $category->cat_ID; ?> ul li a:hover {
    color: <?php echo $color; ?>;
}

.linkbox.cat-<?php echo $category->cat_ID; ?> a:hover .overlay {
    background: rgba(<?php echo $parts[1]; ?>, <?php echo $parts[2]; ?>, <?php echo $parts[3]; ?>, 0.8);
}

a.theme.cat-<?php echo $category->cat_ID; ?>,
article.cat-<?php echo $category->cat_ID; ?> a.theme,
article.cat-<?php echo $category->cat_ID; ?> a.theme i.fa,
div.head-image.cat-<?php echo $category->cat_ID; ?> a.theme,
article a.theme.cat-<?php echo $category->cat_ID; ?>,
#page-content .section-<?php echo $category->cat_ID; ?> header span.borderline,
.article-post.cat-<?php echo $category->cat_ID; ?> .review .score-overall,
.article-post.cat-<?php echo $category->cat_ID; ?> .review .progress-bar {
    background: <?php echo $color; ?>;
}

<?php
    if ( $cat_id == $cat_parent_id ) {
?>
article.parent-cat-<?php echo $cat_parent_id; ?> .related-box a:hover,
article.parent-cat-<?php echo $cat_parent_id; ?> a.category,
article.parent-cat-<?php echo $cat_parent_id; ?> .post-pagination a:hover,
article.parent-cat-<?php echo $cat_parent_id; ?> .post-navigation a:hover,
.article-post.parent-cat-<?php echo $cat_parent_id; ?> .review ul.good li i.fa,
#archive-page.module-timeline .parent-cat-<?php echo $cat_parent_id; ?> a,
.sidebar aside.widget .category.parent-cat-<?php echo $cat_parent_id; ?> a,
.sidebar span.parent-cat-<?php echo $cat_parent_id; ?> a,
#sidebar-mid span.parent-cat-<?php echo $cat_parent_id; ?> a,
#page-footer span.parent-cat-<?php echo $cat_parent_id; ?> a {
    color: <?php echo $color; ?>;
}

#archive-page.module-timeline article i.parent-bullet-<?php echo $category->cat_ID; ?>,
a.show-more.parent-cat-<?php echo $category->cat_ID; ?>,
.sidebar .module-timeline article i.parent-bullet-<?php echo $category->cat_ID; ?>,
#sidebar-mid .module-timeline article i.parent-bullet-<?php echo $category->cat_ID; ?> {
    background: <?php echo $color; ?>;
}
<?php
    }
?>
article.cat-<?php echo $category->cat_ID; ?> .related-box a:hover,
article.cat-<?php echo $category->cat_ID; ?> a.category,
article.cat-<?php echo $category->cat_ID; ?> .post-pagination a:hover,
article.cat-<?php echo $category->cat_ID; ?> .post-navigation a:hover,
.article-post.cat-<?php echo $category->cat_ID; ?> .review ul.good li i.fa,
.section-<?php echo $category->cat_ID; ?> header h2 a,
#archive-page.module-timeline .cat-<?php echo $category->cat_ID; ?> a,
.sidebar aside.widget .category.cat-<?php echo $category->cat_ID; ?> a,
.sidebar span.cat-<?php echo $category->cat_ID; ?> a,
#sidebar-mid span.cat-<?php echo $category->cat_ID; ?> a,
#page-footer span.cat-<?php echo $category->cat_ID; ?> a {
    color: <?php echo $color; ?>!important;
}

#archive-page.module-timeline article i.bullet-<?php echo $category->cat_ID; ?>,
a.show-more.cat-<?php echo $category->cat_ID; ?>,
.sidebar .module-timeline article i.bullet-<?php echo $category->cat_ID; ?>,
#sidebar-mid .module-timeline article i.bullet-<?php echo $category->cat_ID; ?> {
    background: <?php echo $color; ?>!important;
}

.post-pagination.cat-<?php echo $category->cat_ID; ?> a:hover, .post-pagination.cat-<?php echo $category->cat_ID; ?> .current {
    background: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}

#foot-menu ul li.menu-category-<?php echo $category->cat_ID; ?> a {
    border-color: <?php echo $color; ?>;
}

#foot-menu ul li.menu-category-<?php echo $category->cat_ID; ?> a:hover,
#foot-menu ul li.menu-category-<?php echo $category->cat_ID; ?>.current a {
    color: <?php echo '#'. $colorDarker; ?>;
}

<?php
    }
  }

  if ( $mp_weeklynews['_mp_header_sticky_menu'] && isset($mp_weeklynews['_mp_header_sticky_menu_logo']['url']) ) {
?>

  #header-navigation #menu span.sticky-logo {
    background: url(<?php echo $mp_weeklynews['_mp_header_sticky_menu_logo']['url']; ?>) no-repeat 0 50%;
    width: <?php echo $mp_weeklynews['_mp_header_sticky_menu_logo']['width']; ?>px;
  }

  .affix #header-navigation #menu ul.nav {
    padding-left: <?php echo $mp_weeklynews['_mp_header_sticky_menu_logo']['width']; ?>px;
  }

<?php
  }

  if ( $mp_weeklynews['_mp_header_sticky_menu'] && ($mp_weeklynews['_mp_header_sticky_menu_show_first']) ) {
?>

  .affix #header-navigation #menu ul.nav li:first-child {
    display: none;
  }

  .affix #header-navigation #menu ul.nav ul.dropnav-menu li:first-child,
  .affix #header-navigation #menu ul.nav ul.subnav-menu li:first-child {
    display: block;
  }

<?php
  }

  if ( isset($mp_weeklynews['_mp_typ_section_titles_border']['border-color'])               && ($mp_weeklynews['_mp_typ_section_titles_border']['border-color'] != '') )                echo '#page-content header h2 { border-color: '. $mp_weeklynews['_mp_typ_section_titles_border']['border-color'] .' }';
  if ( isset($mp_weeklynews['_mp_typ_section_titles_border_short']['border-color'])         && ($mp_weeklynews['_mp_typ_section_titles_border_short']['border-color'] != '') )          echo '#page-content header span.borderline { background: '. $mp_weeklynews['_mp_typ_section_titles_border_short']['border-color'] .' }';
  if ( isset($mp_weeklynews['_mp_typ_section_titles_sidebar_border']['border-color'])       && ($mp_weeklynews['_mp_typ_section_titles_sidebar_border']['border-color'] != '') )        echo '.sidebar header h2 { border-color: '. $mp_weeklynews['_mp_typ_section_titles_sidebar_border']['border-color'] .' }';
  if ( isset($mp_weeklynews['_mp_typ_section_titles_sidebar_border_short']['border-color']) && ($mp_weeklynews['_mp_typ_section_titles_sidebar_border_short']['border-color'] != '') )  echo '.sidebar header span.borderline { background: '. $mp_weeklynews['_mp_typ_section_titles_sidebar_border_short']['border-color'] .' }';

  echo $mp_weeklynews['_mp_css_code'];
?>

#breaking-news a.theme-title {
  background: <?php echo $mp_weeklynews['_mp_breakingnews_title_background']; ?>;
}


<?php
  // Layout hover effect
  if ( $mp_weeklynews['_mp_cat_layout_effect'] && isset($mp_weeklynews['_mp_cat_layout_effect']) ) {
    switch ( $mp_weeklynews['_mp_cat_layout_effect'] ) {
      case '1':
?>
.linkbox,
.thumb-wrap {
    position: relative;
    overflow: hidden;
}

.linkbox a img,
.thumb-wrap a img {
   -webkit-transition: all 0.2s linear;
   -moz-transition: all 0.2s linear;
   -o-transition: all 0.2s linear;
   -ms-transition: all 0.2s linear;
   transition: all 0.2s linear;
}

.linkbox a:hover img,
.thumb-wrap a:hover img {
    -webkit-transform: scale(1.1,1.1);
   -moz-transform: scale(1.1,1.1);
   -o-transform: scale(1.1,1.1);
   -ms-transform: scale(1.1,1.1);
   transform: scale(1.1,1.1);
}
<?php
      break;
      case '2':
?>
.linkbox,
.thumb-wrap {
    position: relative;
    overflow: hidden;
    background: #000;
}

.subnav-posts article.linkbox {
    background: none;
}

.linkbox a img,
.thumb-wrap a img {
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  transition: all 0.2s linear;
}

.linkbox a:hover img,
.thumb-wrap a:hover img {
  -webkit-transform: scale(1.1,1.1);
  -moz-transform: scale(1.1,1.1);
  -o-transform: scale(1.1,1.1);
  -ms-transform: scale(1.1,1.1);
  transform: scale(1.1,1.1);
  opacity: 0.5;

}
<?php
      break;
      case '3':
?>
.linkbox,
.thumb-wrap {
    position: relative;
    overflow: hidden;
    background: #000;
}

.subnav-posts article.linkbox {
    background: none;
}

.linkbox a img,
.thumb-wrap a img {
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  transition: all 0.2s linear;
}

.linkbox a:hover img,
.thumb-wrap a:hover img {
  -webkit-transform: rotate(3deg) scale(1.1,1.1);
  -moz-transform: rotate(3deg) scale(1.1,1.1);
  -o-transform: rotate(3deg) scale(1.1,1.1);
  -ms-transform: rotate(3deg) scale(1.1,1.1);
  transform: rotate(3deg) scale(1.1,1.1);
}
<?php
      break;
    }
  }
?>


/* WooCommerce */
<?php
# If Woocommerce
if ( class_exists( 'woocommerce' ) ) {
  // Get settings
  $colors = array_map( 'esc_attr', (array) get_option( 'woocommerce_frontend_css_colors' ) );

  // Defaults
  if ( empty( $colors['primary'] ) ) {
    $colors['primary'] = '#ad74a2';
  }
  if ( empty( $colors['secondary'] ) ) {
    $colors['secondary'] = '#f7f6f7';
  }
  if ( empty( $colors['highlight'] ) ) {
    $colors['highlight'] = '#85ad74';
  }
  if ( empty( $colors['content_bg'] ) ) {
    $colors['content_bg'] = '#ffffff';
  }
  if ( empty( $colors['subtext'] ) ) {
    $colors['subtext'] = '#777777';
  }
?>

#page-content section.woocommerce.woo-lay-2 span.price,
#page-content section.woocommerce.woo-lay-3 span.price,
#page-content .woocommerce.news-lay-4 span.price {
  color: <?php echo $colors['highlight']; ?>;
}

<?php
}
# End If Woocommerce



/* Light Theme Styling */
# If Light Theme
if ( isset($mp_weeklynews['_mp_theme_style']) && ($mp_weeklynews['_mp_theme_style'] == 'theme-light') ) {
  # If Light Header
  if ( isset($mp_weeklynews['_mp_theme_light_style']) && (($mp_weeklynews['_mp_theme_light_style'] == 'light-both')||($mp_weeklynews['_mp_theme_light_style'] == 'light-header')) ) {
?>

#top-navigation {
  background: #fff;
}

#top-navigation ul li a,
#top-navigation ul li li a {
  color: #777;
}

#top-navigation ul li.date span,
#top-navigation ul li a:hover,
#top-navigation ul li.options a:hover {
  color: #444;
}

#top-navigation ul ul {
  background: #e3e3e3;
}

#header-branding {
    background: #fff;
    border-top: 5px solid #e3e3e3;
    border-bottom: 1px solid #e3e3e3;
}

#header-branding .weather h3 {
    color: #444;
}

#header-branding .weather h3 span.temp {
  color: #222;
}

#header-branding .weather span.date {
    color: #aaa;
}

#header-branding .weather i.icon {
    color: #444;
}

#header-branding #search-form {
    border: 1px solid #E0E0E0;
    text-align: left;
    -webkit-box-shadow: inset 0 3px 0 0 #F7F7F7;
    box-shadow: inset 0 3px 0 0 #F7F7F7;
}

#header-branding #search-form input {
    line-height: 42px;
    height: 42px;
}

#header-branding #search-form button {
    line-height: 42px;
    height: 42px;
}

#header-branding #search-form {
  margin-top: 25px;
}

#header-navigation {
    background: #fff;
    border-bottom: 1px solid #e3e3e3;
}

#header-navigation ul {
  border: none;
}

#header-navigation ul li {
    border: none;
}

#header-navigation ul li a,
#header-navigation ul ul li a {
    color: #444;
    border-color: #e3e3e3;
}

#header-navigation ul li.current a,
#header-navigation ul li.current-menu-item a,
#header-navigation ul li a:hover,
#header-navigation ul li:hover a,
#header-navigation ul li a:focus {
    color: #fff;
}

<?php
  }
  # End If Light Header

  # If Light Sidebar
  if ( isset($mp_weeklynews['_mp_theme_light_style']) && (($mp_weeklynews['_mp_theme_light_style'] == 'light-both')||($mp_weeklynews['_mp_theme_light_style'] == 'light-sidebar')) ) {
?>

#sidebar {
    border-left: 1px solid #e3e3e3;
    color: #5c5c5c;
    background: #fff;
}

.sidebar {
    color: #5c5c5c;
    background: #fff;
}

.left-sidebar .sidebar {
    border-left: none;
    border-right: 1px solid #e3e3e3;
}

.sidebar aside.widget a {
    color: #999;
}

#page-content .sidebar aside a:hover {
    color: #222;
}

#page-content .sidebar header h2 {
    color: #444;
    border-color: #f5f5f5;
}

#page-content .sidebar header span.borderline {
    background: #222;
}

.sidebar aside.widget h3 a {
    color: #444;
}

.sidebar aside.widget .category a {
    color: #999;
}

.sidebar aside.widget h3 a:hover {
    color: #222;
    text-decoration: underline;
}

.sidebar aside.widget .category a:hover {
    color: #444;
}

.module-timeline article .cnt {
    border-color: #ccc;
}

.module-timeline article i.bullet {
    border-color: #fff;
    background: #999;
}

.sidebar span.stars {
    background-position: 0% 100%;
}

.sidebar .module-news article {
    border-color: #eee;
}

#page-content .sidebar .module-quote header h2 {
    color: #fff;
    border-color: #8e6161;
}

#page-content .sidebar .module-quote header span.borderline {
    background: #fff;
}

#page-content .sidebar .module-singles header h2 {
    color: #fff;
    border-color: #5d8d90;
}

#page-content .sidebar .module-singles header span.borderline {
    background: #fff;
}

.sidebar .module-singles li a {
    color: #fff;
}

.sidebar .module-tags li a {
    border-color: #bbb;
    background: #e3e3e3;
    color: #969696;
}

.sidebar .module-tags li a span {
    background: #bbb;
    color: #fff;
}

.sidebar .module-photos .col-xs-4 {
    border-color: #fff;
}

#wp-calendar tbody td {
    background: #fff;
    border-color: #e7e7e7;
}

.sidebar .ad-separator {
  background: #ddd;
}

<?php
  }
  # End If Light Sidebar
}
# End If Light Theme
?>

/* Lightbox - close button */
body.admin-bar .on #pbCloseBtn {
  top: 30px;
}
