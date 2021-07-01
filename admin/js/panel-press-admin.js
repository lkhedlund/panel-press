(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$('body').on('click', '.pp-media-toggle', function(e) {
		e.preventDefault();
		let button = $(this);
		let pp_media_uploader = null;
		pp_media_uploader = wp.media({
			title: button.data('modal-title'),
			button: {
				text: button.data('modal-button')
			},
			multiple: true
		}).on('select', function() {
			let attachment = pp_media_uploader.state().get('selection').first().toJSON();
			button.prev().val(attachment[button.data('return')]);
		}).open();
	});
})( jQuery );
