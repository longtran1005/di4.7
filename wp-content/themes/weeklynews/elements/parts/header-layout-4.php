<!-- start:header-branding -->
<div id="header-branding" class="header-layout-4">                
    <!-- start:container -->
    <div class="<?php echo ( isset($mp_weeklynews['_mp_header_type']) && ($mp_weeklynews['_mp_header_type'] == 'streched')) ? 'no-container' : 'container'; ?>">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-sm-12 text-center table" itemscope="itemscope" itemtype="http://schema.org/Organization">
                <!-- start:logo -->
                <?php echo MipTheme_Util::miptheme_set_logo(); ?>
                <meta itemprop="name" content="<?php bloginfo('name')?>">
                <!-- end:logo -->
            </div>
            <!-- end:col -->
            
        </div>
        <!-- end:row -->

    </div>
    <!-- end:container -->                    
</div>
<!-- end:header-branding -->