(function( $ ) {
	'use strict';

	//Course input functions
	var CourseFilters = {
		bindCourseInput: function () {
			// $("#course-select").on()
		}
	}
	

	//Fullcalendar functions
	var FullCalendarFrontEnd = {
		loadCalendar: function () {
			var self = this;
			$('#fullcalendar-frontend').fullCalendar({
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
		        //Drill down view. Month  view to day view, week view to day view 
		        dayClick: function(date, jsEvent, view) {
		        	self.drilldown();
			    },
		        //Tooltip to confirm appointment here.
			    eventClick: function(calEvent, jsEvent, view) {
		        	// Must add a tooltip here
		        	self.confirmAppointment();
			    }
		    });
		},
		drilldown: function () {

		},
		confirmAppointment: function () {

		}
	}

	//Window load!
	$( window ).load(function(){
		FullCalendarFrontEnd.loadCalendar();

	});

})( jQuery );
