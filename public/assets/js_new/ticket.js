$( document ).ready(function() {
	$( '.ticket-messages' ).scrollTop( $( '.ticket-messages' ).prop('scrollHeight') );

	$( '.ticket-message__attachment' ).click(function() {
		window.open($( this ).attr('src'), '_blank');
	});
});