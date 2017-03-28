(function($){
	var $mp_ids;
	var $mp_thumbs;

	$(function(){
		$( '.widgets-holder-wrap, .editwidget' ).on( 'click', '.mp-gallery-choose-images', function( event ) {
			event.preventDefault();

			var widget_form = $( this ).closest( 'form' );

			$mp_ids    = widget_form.find( '.mp-gallery-widget-ids' );
			$mp_thumbs	= widget_form.find( '.mp-gallery-widget-thumbs' );

			var idsString = $mp_ids.val();

			var attachments = getMpAttachments( idsString );

			var selection   = null;
			var editing     = false;

			if ( attachments ) {
				selection = getMpSelection( attachments );

				editing = true;
			}

			var options = {
				state: 'gallery-edit',
				title: wp.media.view.l10n.addMedia,
				multiple: true,
				editing: editing,
				selection: selection
			};

			var workflow = getMpWorkflow( options );

			workflow.open();
		});

	});

	var media       = wp.media, l10n;

	// Link any localized strings.
	l10n = media.view.l10n = typeof _wpMediaViewsL10n === 'undefined' ? {} : _wpMediaViewsL10n;

	/**
	 * wp.media.view.MediaFrame.GalleryWidget
	 *
	 * This behavior can be very nearly had by setting the workflow's state to 'gallery-edit', but
	 * we cannot use the custom WidgetGalleryEdit controller with it (must overide createStates(),
	 * which is necessary to disable the sidebar gallery settings in the media browser)
	 */
	media.view.MediaFrame.GalleryWidget = media.view.MediaFrame.Post.extend({
		createStates: function() {
			var options = this.options;

			// `CollectionEdit` and `CollectionAdd` were only introduced in r27214-core,
			// so they may not be available yet.
			if ( 'CollectionEdit' in media.controller ) {
				this.states.add([
					new media.controller.CollectionEdit({
						type:           'image',
						collectionType: 'gallery',
						title:           l10n.editGalleryTitle,
						SettingsView:    media.view.Settings.Gallery,
						library:         options.selection,
						editing:         options.editing,
						menu:           'gallery'
					}),
					new media.controller.CollectionAdd({
						type:           'image',
						collectionType: 'gallery',
						title:          l10n.addToGalleryTitle
					})
				]);
			} else {
				// If `CollectionEdit` is not available, then use the old approach.

				if ( ! ( 'WidgetGalleryEdit' in media.controller ) ) {
					// Remove the gallery settings sidebar when editing widgets.
					media.controller.WidgetGalleryEdit = media.controller.GalleryEdit.extend({
						gallerySettings: function( /*browser*/ ) {
							return;
						}
					});
				}

				this.states.add([
					new media.controller.WidgetGalleryEdit({
						library: options.selection,
						editing: options.editing,
						menu:    'gallery'
					}),
					new media.controller.GalleryAdd({ })
				]);
			}
		}
	});

	/**
	 * Take a given Selection of attachments and a thumbs wrapper div (jQuery object)
	 * and fill it with thumbnails
	 */
	function setupMpThumbs( selection, wrapper ){
		wrapper.empty();

		var imageSize = _wpGalleryWidgetAdminSettings.thumbSize;

		selection.each( function( model ){
			var sizedUrl = model.get('url') + '?w=' + imageSize + '&h=' + imageSize + '&crop=true';

			var thumb = '<img src="' + sizedUrl + '" alt="' + model.get('title') + '" \
				title="' + model.get('title') + '" width="' + imageSize + '" height="' + imageSize + '" style="display:inline-block;border: 1px solid #aaa;padding: 2px;background-color: #fff;margin: 0 6px 6px 0;" />';

			wrapper.append( thumb );
		});
	}

	/**
	 * Take a csv string of ids (as stored in db) and fetch a full Attachments collection
	 */
	function getMpAttachments( idsString ) {
		if ( ! idsString ) {
			return null;
		}

		// Found in /wp-includes/js/media-editor.js
		var shortcode = wp.shortcode.next( 'gallery', '[gallery ids="' + idsString + '"]' );

		// Ignore the rest of the match object, to give attachments() below what it expects
		shortcode     = shortcode.shortcode;

		var attachments = wp.media.gallery.attachments( shortcode );

		return attachments;
	}

	/**
	 * Take an Attachments collection and return a corresponding Selection model that can be
	 * passed to a MediaFrame to prepopulate the gallery picker
	 */
	function getMpSelection( attachments ) {
		var selection = new wp.media.model.Selection( attachments.models, {
			props:    attachments.props.toJSON(),
			multiple: true
		});

		selection.gallery = attachments.gallery;

		// Fetch the query's attachments, and then break ties from the
		// query to allow for sorting.
		selection.more().done( function() {
			// Break ties with the query.
			selection.props.set( { query: false } );
			selection.unmirror();
			selection.props.unset( 'orderby' );
		});

		return selection;
	}

	/**
	 * Create a media 'workflow' (MediaFrame). This is the main entry point for the media picker
	 */
	function getMpWorkflow( options ) {
		var workflow = new wp.media.view.MediaFrame.GalleryWidget( options );

		workflow.on( 'update', function( selection ) {
			var state = workflow.state();

			selection = selection || state.get( 'selection' );

			if ( ! selection ) {
				return;
			}

			// Map the Models down into a simple array of ids that can be easily imploded to a csv string
			var ids = selection.map( function( model ){
				return model.get( 'id' );
			} );

			var id_string = ids.join( ',' );

			$mp_ids.val( id_string );

			setupMpThumbs( selection, $mp_thumbs );
		}, this );

		workflow.setState( workflow.options.state );

		return workflow;
	}
})(jQuery);
