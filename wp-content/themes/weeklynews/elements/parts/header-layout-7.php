<?php
    global $mp_weeklynews;
?>
<!-- start:header-branding -->
<div id="header-branding" class="header-layout-7">                
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
                <?php
                    if ( isset($mp_weeklynews['_mp_header_weather_location']) ) {
                ?>
                <div class="weather" id="weather">
                    <i class="icon"></i>
                    <h3><span class="glyphicon glyphicon-map-marker"></span> <span class="location"></span> <span class="temp"></span></h3>
                    <span class="date"><?php if ( isset($mp_weeklynews['_mp_header_weather_show_date']) && (bool)$mp_weeklynews['_mp_header_weather_show_date']) echo date_i18n(MIPTHEME_DATE_HEADER); ?> <?php if ( isset($mp_weeklynews['_mp_header_weather_show_desc']) && (bool)$mp_weeklynews['_mp_header_weather_show_desc']) echo '<span class="desc"></span>'; ?></span>
                </div>
                <script>
                    "use strict";
                    var weather_widget      = true;
                    var weather_lang        = '<?php echo esc_js( ( isset($mp_weeklynews['_mp_header_weather_lang']) && ($mp_weeklynews['_mp_header_weather_lang'] != '') ) ? $mp_weeklynews['_mp_header_weather_lang'] : '' ); ?>';
                    var weather_location    = '<?php echo esc_js($mp_weeklynews['_mp_header_weather_location']); ?>';
                    var weather_unit        = '<?php echo esc_js($mp_weeklynews['_mp_header_weather_temperature']); ?>';
                </script>
                <?php
                    }
                ?>
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