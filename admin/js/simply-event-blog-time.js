(function( $ ) {
	'use strict';

	$(document).ready(function(){

		$('.wp-admin .event-hour').timepicker({
			timeFormat: 'h:mm p',
			interval: 30,
			minTime: '1',
			maxTime: '11:00pm',
			defaultTime: '0',
			startTime: '0:00',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});
	});

})( jQuery );
