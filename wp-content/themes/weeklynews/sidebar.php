<?php
    global $curr_sidebar_source;
?>
<!-- start:sidebar -->
<div id="sidebar" class="sidebar">
    <div class="theiaStickySidebar">
  	<?php
  	    if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) :
      		if ( ($curr_sidebar_source != 'None') && !empty($curr_sidebar_source) ) :
      		    dynamic_sidebar ( $curr_sidebar_source );
      		else :
      		    dynamic_sidebar( 'primary-widget-area' );
      		endif;
  	    endif;
  	?>
    </div>
</div>
<!-- end:sidebar -->
