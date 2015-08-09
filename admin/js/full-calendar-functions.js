(function( $ ) {
	'use strict';

	var FullCalendar = {
		var self = this;

		loadBlankCalendar: function(){
			$('#fullcalendar').fullCalendar({
		        editable: true,
		        header: false,
		        columnFormat: 'dddd',
		        allDaySlot: false,
		        height: "auto",
		        minTime: "12:00:00",
		        maxTime: "19:00:00",
		        timezone: "America/Chicago",
		        weekends: false,
		        defaultView: 'agendaWeek',
		        dayClick: function(date, jsEvent, view) {
		        	self.addNewEvent(date);
			    },
			    eventClick: function(calEvent, jsEvent, view) {
			    	self.deleteEvent(calEvent);
			    }
		    });
		},
		deleteEvent: function(calEvent){
			$("#fullcalendar").fullCalendar('removeEvents', function(event){
				return event == calEvent;
			});
		},
		addNewEvent: function(date){

			var tutorName = $("#first-name").val() + " " + $("#last-name").val();
			//Assume no name is less than 4 charactersl, including the space seperating first and last
			if (tutorName.length > 4){
				var eventObject = {
					title: "Tutoring with " + tutorName,
					start: date.format(),
					end: date.add({hours: 1}),
					description: "Tutoring with " + tutorName,
					editable: true
				}
		        $("#fullcalendar").fullCalendar('renderEvent', eventObject, true);
			}else{
				alert("Please enter a name before scheduling times.")
				$("#first-name").focus();
			}

		}
	}

	return FullCalendar;

})( jQuery );
