<?php
    global $mp_weeklynews;
?>
<!-- start:header-branding -->
<div id="header-branding" class="header-widget header-layout-widget-1">                
    <!-- start:container -->
    <div class="container">
        
        <!-- start:row -->
        <div class="row">
        
            <!-- start:col -->
            <div class="col-sm-12 table <?php echo $mp_weeklynews['_mp_header_widget_column_1_align']; ?>">
                <?php
                    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                        dynamic_sidebar($mp_weeklynews['_mp_header_widget_column_1_source']);
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