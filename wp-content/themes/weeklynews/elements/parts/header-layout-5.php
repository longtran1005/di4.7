<?php
    global $mp_weeklynews;
?>
<!-- start:header-branding -->
<div id="header-branding" class="header-layout-5">                
    <!-- start:container -->
    <div class="<?php echo ( isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container'; ?>">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-sm-4 text-left">
                <!-- start:banner -->
                <?php
                    $ad_unit        = new MipTheme_Ad();
                    $ad_unit->id    = ( isset($mp_weeklynews['_mp_header_banner_left']) && ($mp_weeklynews['_mp_header_banner_left'] != '') ) ? (int)$mp_weeklynews['_mp_header_banner_left'] : 0;
        
                    if ( $ad_unit->id > 0 ) echo $ad_unit->formatBlankAd();
                ?>
                <!-- end:banner -->
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-sm-4 text-center" itemscope="itemscope" itemtype="http://schema.org/Organization">
                <!-- start:logo -->
                <?php echo MipTheme_Util::miptheme_set_logo(); ?>
                <meta itemprop="name" content="<?php bloginfo('name')?>">
                <!-- end:logo -->
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-sm-4 text-right">
                <!-- start:banner -->
                <?php
                    $ad_unit        = new MipTheme_Ad();
                    $ad_unit->id    = (isset($mp_weeklynews['_mp_header_banner_right']) && ($mp_weeklynews['_mp_header_banner_right'] != '') ) ? (int)$mp_weeklynews['_mp_header_banner_right'] : 0;
        
                    if ( $ad_unit->id > 0 ) echo $ad_unit->formatBlankAd();
                ?>
                <!-- end:banner -->
            </div>
            <!-- end:col -->
            
        </div>
        <!-- end:row -->

    </div>
    <!-- end:container -->                    
</div>
<!-- end:header-branding -->