<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new MipTheme_AdminShortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="miptheme-popup">

	<div id="miptheme-popup-wrap">

		<div id="miptheme-popup-form-wrap">

			<div id="miptheme-popup-head">

				<?php echo $shortcode->popup_title; ?>

			</div>
			<!-- /#miptheme-popup-head -->

			<form method="post" id="miptheme-popup-form">

				<table id="miptheme-popup-form-table">

					<?php echo $shortcode->output; ?>

					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary miptheme-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#miptheme-popup-form-table -->

			</form>
			<!-- /#miptheme-popup-form -->

		</div>
		<!-- /#miptheme-popup-form-wrap -->
		<div class="clear"></div>

	</div>
	<!-- /#miptheme-popup-wrap -->

</div>
<!-- /#miptheme-popup -->

</body>
</html>
