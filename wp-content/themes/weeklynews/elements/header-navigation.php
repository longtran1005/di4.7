<?php
    global  $mp_weeklynews,
            $cat_quicklinks_menu,
            $page_quicklinks_menu;
?>

<div class="header-page-body container">
   <div class="headerFrame lp_header row">
      <div id="js-stock-clock" class="hfr js-stock-clock col-md-2 col-sm-3 col-xs-12" data-update-interval="60000" data-update-symbols="OMXSPI,DJI">
         <h2>
            <a href="/" target="_top" class="di-top-image-ref">
            <img src="http://static.images-di.se/Static/imgs/di_logo_transparent_Top_New.v447034498.png" style="height:90px;border-width:0px;">
            </a>
         </h2>
      </div>
      <div class="bfr topBannerContainer col-md-10 col-sm-9 hidden-xs"></div>
   </div>
</div>

<nav class="navbar-default">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img class="logo-mobile" src="<?php bloginfo('template_directory'); ?>/vendor/css/images/di_logo_transparent.png" alt="logo" />
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
              <div class="menutop">
<!--                  <div class="col-xs-12 col-sm-3 col-md-3 pull-right">-->
<!--                      <form class="navbar-form fix-position-search" id="nav-search-form" action="/?s=" role="search">-->
<!--                          <div class="input-group fix-display">-->
<!--                              <input type="text" class="form-control" placeholder="Sök bolag, nyheter, tjänster" name="s" id="search_text">-->
<!--                              <i class="glyphicon glyphicon-search custom-search"></i>-->
<!--                          </div>-->
<!--                      </form>-->
<!--                  </div>-->
                <?php
                    $defaults = array(
                        'theme_location'  => 'header-menu',
                        'menu'            => '',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'menuright menuheader',
                        'menu_id'         => '',
                        'echo'            => true,
                        'fallback_cb'     => 'MipTheme_Global::mip_fb_nav_menu',
                        'items_wrap'      => MipTheme_Util::mip_nav_menu_wrapper(),
                        'depth'           => 0,
                        'walker'          => new MipTheme_Head_Desktop_Walker_Nav_Menu()
                    );
                    wp_nav_menu( $defaults );
                ?>
            <?php
                //echo di_nav_sub_menu($defaults);
            ?>
            </div>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
</nav>
<?php
    do_action('miptheme_unique_posts_after_header');
?>