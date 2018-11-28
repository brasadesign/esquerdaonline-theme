jQuery(document).ready(function($) {
	var youtube = document.querySelectorAll( ".youtube" );

	$( '.modal-item-open' ).click(function(e) {
		e.preventDefault();
		console.log( 'ahoyw');
		$link_elem = $( this );
		$( '.lds-ellipsis' ).fadeIn();
		var type = $(this).attr('data-type');
		console.log(type);
		switch(type) {
			case 'video':
			function youtube_parser(url){
				var video_id_regExp = /^.*((youtu.be\/|vimeo.com\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/,
				match = url.match(video_id_regExp),
				video_id;
				if (match&&match[7]){
					//valid
					video_id = match[7];
					return video_id;
				} else {
					//invalid
					return false;
				}
			}
			var url = $(this).attr('data-src');
			if (url.includes("youtube")){
				var urlFinal = "https://www.youtube.com/embed/"+ youtube_parser(url) +"?rel=0&showinfo=0&autoplay=1";

				var iframe = document.createElement( "iframe" );
				iframe.setAttribute( "frameborder", "0" );
				iframe.setAttribute( "allowfullscreen", "" );
				iframe.setAttribute( "src", urlFinal );
				$('#modal-content').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
				$('#modal-content iframe').fitVids();
				$('#modal-content ').fitVids();

				$('#modal-content').append( iframe );
				$('#modal-content iframe').append('<div id="close-modal"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>')
			}
			else if(url.includes("vimeo")){
				var urlFinal = 'https://player.vimeo.com/video/'+ youtube_parser(url) +'?autoplay=1&loop=1&autopause=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen';

				var iframe = document.createElement( "iframe" );
				iframe.setAttribute( "frameborder", "0" );
				iframe.setAttribute( "allowfullscreen", "" );
				iframe.setAttribute( "src", urlFinal );
				$('#modal-content').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
				$('#modal-content iframe').fitVids();
				$('#modal-content ').fitVids();

				$('#modal-content').append( iframe );
				$('#modal-content').append('<div id="close-modal"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>')
			}
			else if(url.includes("facebook")){
				$('#modal-content').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
				$('#modal-content iframe').fitVids();
				$('#modal-content ').fitVids();

				$('#modal-content').append( '<div class="fb-video" data-href="'+url+'" data-width="500" data-show-text="false"> </div>' );
				(function(d, s, id) { var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id; js.src = "//connect.facebook.net/en_US/all.js#xfbml=1"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));


				setTimeout(function() {
					if (typeof(FB) != 'undefined') {

						FB.XFBML.parse();

					}
				}, 2000)
			}
			$('#modal-content').append('<div id="close-modal"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
			setTimeout( function(){
				$( '#modal-content' ).append( '<div style="width:100%;clear:both;"></div>');

				$( '#modal .modal-share' ).clone().appendTo( '#modal-content' );
				var $modal_share = $( '#modal-content' ).find( '.modal-share' );
				$modal_share.attr( 'style', '' );
				$modal_share.attr( 'data-url', $link_elem.attr( 'data-url') );
				if ( $link_elem.attr( 'data-download') ) {
					$( '#modal-content' ).append( '<div style="width:100%;clear:both;"></div>');
					console.log( 'tem download?');
					$( '#modal .modal-download' ).clone().appendTo( '#modal-content' );
					var $modal_download = $( '#modal-content' ).find( '.modal-download' );
					$modal_download.attr( 'style', '' );
					$modal_download.find( 'a' ).attr( 'href', $link_elem.attr( 'data-download') );
				} else {
					$modal_share.addClass( 'noparent' );
				}
			}, 3400 );
 			break;
			case 'image':
				$( '#modal' ).addClass( 'data-image' );
				$( '#modal-content' ).append( '<img src="'+ $(this).attr( 'data-src') +'">');
				$('#modal-content').append('<div id="close-modal"><a href="#"><i class="fa fa-times" aria-hidden="true"></i></a></div>');
			break;
			//
			//     case image:
			//         var data = ""
			//         break;
			default:
			break;


		}
		$( '#modal' ).fadeIn();

		$(document).keyup(function(e) {
			if (e.keyCode === 27) $( '#modal' ).fadeOut('fast', function() {
				$('#modal-content').html(" ");
				$( '#modal' ).removeClass( 'data-image' );
			});   // esc
		});
		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
		$("#modal").on("click", "#close-modal a", function(e) {
			e.preventDefault();
			$( '#modal' ).fadeOut('fast', function() {
				$('#modal-content').html(" ");
				$( '#modal' ).removeClass( 'data-image' );
			});
		});
	});
});
