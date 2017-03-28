<?php
    global $curr_sidebar_source_middle;
?>
<!-- start:sidebar-mid -->
<div id="sidebar-mid" class="sidebar-mid">
    
    <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
            if ( ($curr_sidebar_source_middle != 'None') && !empty($curr_sidebar_source_middle) ) :
		dynamic_sidebar ( $curr_sidebar_source_middle );
	    else :
                dynamic_sidebar( 'secondary-widget-area' );
            endif;
        endif;
    ?>
    
</div>
<!-- end:sidebar-mid -->