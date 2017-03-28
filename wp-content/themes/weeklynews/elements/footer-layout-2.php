<?php
    global $mp_weeklynews;
?>
<div class="foot-widgets row">

    <!-- start:col -->
    <div class="col-sm-4">
        <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                dynamic_sidebar($mp_weeklynews['_mp_footer_column_1_source']);
            endif;
        ?>
    </div>
    <!-- end:col -->
    
    <!-- start:col -->
    <div class="col-sm-4">
        <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                dynamic_sidebar($mp_weeklynews['_mp_footer_column_2_source']);
            endif;
        ?>
    </div>
    <!-- end:col -->
    
    <!-- start:col -->
    <div class="col-sm-4">
        <?php
            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : 
                dynamic_sidebar($mp_weeklynews['_mp_footer_column_3_source']);
            endif;
        ?>
    </div>
    <!-- end:col -->

</div>
<!-- end:row -->