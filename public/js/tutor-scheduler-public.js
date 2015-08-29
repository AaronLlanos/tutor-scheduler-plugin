(function( $ ) {
	'use strict';

	$( window ).load(function(){
		$('#fullcalendar-frontend').fullCalendar({
	        // put your options and callbacks here
	        editable: false,
	        allDaySlot: false,
	        header: {
			    left:   'prev,next today',
			    center: 'title',
			    right:  'month,agendaWeek,agendaDay'
			},
			events: eventJSON,
	        height: "auto",
	        minTime: "12:00:00",
	        maxTime: "19:00:00",
	        timezone: "America/Chicago",
	        defaultView: 'agendaWeek',
	        dayClick: function(date, jsEvent, view) {
	        	// self.addNewEvent(date, 0);
		    },
		    eventClick: function(calEvent, jsEvent, view) {
		    	// self.deleteEvent(calEvent);
		    }
	    });

	    $('#fullcalendar-frontend').fullCalendar( 'addEventSource', eventJSON);

	    console.log(eventJSON);
	});

})( jQuery );
