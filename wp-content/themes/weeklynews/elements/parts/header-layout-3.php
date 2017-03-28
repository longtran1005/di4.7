<?php
    global $mp_weeklynews;
?>
<!-- start:header-branding -->
<div id="header-branding" class="header-layout-3">                
    <!-- start:container -->
    <div class="<?php echo ( isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container'; ?>">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-sm-6 col-md-2 nopadding-right" itemscope="itemscope" itemtype="http://schema.org/Organization">
                <!-- start:logo -->
                <?php echo MipTheme_Util::miptheme_set_logo(); ?>
                <meta itemprop="name" content="<?php bloginfo('name')?>">
                <!-- end:logo -->
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-sm-8 col-md-10 nopadding-left text-right banner-src">
                <?php
                    $ad_unit        = new MipTheme_Ad();
                    $ad_unit->id    = (int)$mp_weeklynews['_mp_header_banner'];
        
                    echo $ad_unit->formatBlankAd();
                ?>
            </div>
            <!-- end:col -->
            
        </div>
        <!-- end:row -->

    </div>
    <!-- end:container -->                    
</div>
<!-- end:header-branding -->