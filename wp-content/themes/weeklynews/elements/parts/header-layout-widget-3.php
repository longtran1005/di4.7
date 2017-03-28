<?php
    global $mp_weeklynews;
?>
<!-- start:header-branding -->
<div id="header-branding" class="header-widget header-layout-widget-3">                
    <!-- start:container -->
    <div class="container">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-md-4 <?php echo $mp_weeklynews['_mp_header_widget_column_1_align']; ?>">
                <?php
                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                        dynamic_sidebar($mp_weeklynews['_mp_header_widget_column_1_source']);
                    endif;
                ?>
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-md-4 <?php echo $mp_weeklynews['_mp_header_widget_column_2_align']; ?>">
                <?php
                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                        dynamic_sidebar($mp_weeklynews['_mp_header_widget_column_2_source']);
                    endif;
                ?>
            </div>
            <!-- end:col -->
            
            <!-- start:col -->
            <div class="col-md-4 <?php echo $mp_weeklynews['_mp_header_widget_column_3_align']; ?>">
                <?php
                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                        dynamic_sidebar($mp_weeklynews['_mp_header_widget_column_3_source']);
                    endif;
                ?>
            </div>
            <!-- end:col -->
            
        </div>
        <!-- end:row -->

    </div>
    <!-- end:container -->                    
</div>
<!-- end:header-branding -->