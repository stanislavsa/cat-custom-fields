( function( $ ) {

	"use strict";

	$( function() {

		$( '.catcf-video-delete' ).on( 'click', function( e ) {
			e.preventDefault();

			$( this ).parents( 'td' )
				.find( 'input' ).val( '' ).end()
				.find( '.catcf-preview' ).hide();
		} );

		$( '#cat-video' ).on( 'change', function( e ) {
			var self = $( this );
			var thumb = '';
			var videoId = '';
			var match;
			var url = $( this ).val();

			if ( url ) {

				if ( url.match( /youtube\.com/i ) || url.match( /youtu\.be/i ) ) {
					match = url.match( /watch\?v=(.*)/i );
					if ( match ) {
						videoId = match[1];
						videoId = videoId.split('&');
						videoId = videoId[0];
					} else {
						videoId = url.split('?');
						videoId = videoId[0].split('youtu.be/');
						videoId = videoId[1];
					}
					if ( videoId ) {
						thumb = 'https://i.ytimg.com/vi/' + videoId + '/hqdefault.jpg';
						$( this ).parents( 'td' )
							.find( 'img' ).attr( 'src', thumb ).end()
							.find( '#cat-video' ).val( 'https://www.youtube.com/embed/' + videoId ).end()
							.find( '.catcf-preview' ).show();
					}
				}
				if ( url.match( /vimeo\.com/i ) ) {
					videoId = url.split('?');
					if ( url.match( /player\.vimeo\.com\/video/i ) ) {
						videoId = videoId[0].split('player.vimeo.com/video/');
						videoId = videoId[1];
					} else {
						videoId = videoId[0].split('vimeo.com/');
						videoId = videoId[1];
					}
					if ( videoId ) {
						$.getJSON( 'http://vimeo.com/api/v2/video/' + videoId + '.json', function( data ) {
							console.log( data[0] );
							if ( data[0]['thumbnail_medium'] ) {
								thumb = data[0]['thumbnail_medium'];
								self.parents( 'td' )
									.find( 'img' ).attr( 'src', thumb ).end()
									.find( '#cat-video' ).val( 'https://player.vimeo.com/video/' + videoId ).end()
									.find( '.catcf-preview' ).show();
							}
						});
					}
				}
			}

		} );

		/**
		 * Image Uploader
		 */
		$( '.catcf-image-add' ).on( 'click', function( e ) {
			e.preventDefault();

			var holder = $( this ).parents( 'td' );
			var frame = wp.media( {
				title: wp.media.view.l10n.chooseImage,
				multiple: false,
				library: { type: 'image' }
			} );

			frame.on( 'select', function() {
				var attachment = frame.state().get( 'selection' ).first().toJSON();

				holder
					.find( 'input[type="hidden"]' ).val( attachment.id ).end()
					.find( 'input[type="text"]' ).val( attachment.url ).end()
					.find( 'img' ).attr( 'src', attachment.url ).end()
					.find( '.catcf-image-add' ).hide().end()
					.find( '.catcf-preview' ).show();
			} );

			frame.open();
		} );
		$( '.catcf-image-delete' ).on( 'click', function( e ) {
			e.preventDefault();

			$( this ).parents( 'td' )
				.find( 'input' ).val( '' ).end()
				.find( '.catcf-image-add' ).show().end()
				.find( '.catcf-preview' ).hide();
		} );


	} );

} )( jQuery );
