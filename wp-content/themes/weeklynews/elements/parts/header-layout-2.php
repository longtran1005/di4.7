<!-- start:header-branding -->
<div id="header-branding" class="header-layout-2">                
    <!-- start:container -->
    <div class="<?php echo ( isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container'; ?>">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-sm-6 col-md-6" itemscope="itemscope" itemtype="http://schema.org/Organization">
                <!-- start:logo -->
                <?php echo MipTheme_Util::miptheme_set_logo(); ?>
                <meta itemprop="name" content="<?php bloginfo('name')?>">
                <!-- end:logo -->
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-sm-6 col-md-6 text-right">
                <form id="search-form" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                    <input type="text" name="s" placeholder="<?php _e('Search', THEMENAME); ?> <?php bloginfo('name'); ?>" value="<?php echo get_search_query(); ?>" />
                    <button><span class="glyphicon glyphicon-search"></span></button>
                </form>
            </div>
            <!-- end:col -->
            
        </div>
        <!-- end:row -->

    </div>
    <!-- end:container -->                    
</div>
<!-- end:header-branding -->