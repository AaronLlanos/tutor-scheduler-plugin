(function( $ ) {
	'use strict';

	//Course input functions
	var CourseFilters = {
		bindCourseInput: function () {
			// $("#course-select").on()
			var courseNamesList = [];
			$.each(coursesJSON, function (i, course) {
				console.log(course);
				courseNamesList.push(course.name);
			});
			$("#course-select").autocomplete({
				source: courseNamesList
			});
		}
	}
	

	//Fullcalendar functions
	var FullCalendarFrontEnd = {
		loadCalendar: function () {
			var self = this;
			$("#fullcalendar-frontend").fullCalendar({
		        editable: false,
		        allDaySlot: false,
		        header: {
				    left:   'prev,next today',
				    center: 'title',
				    right:  'month,agendaWeek,agendaDay'
				},
				events: eventJSON,
				slotEventOverlap: true,
		        height: "auto",
		        minTime: "12:00:00",
		        maxTime: "20:00:00",
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
		confirmAppointment: function () {

		}
	}

	//Window load!
	$( window ).load(function(){
		FullCalendarFrontEnd.loadCalendar();
		CourseFilters.bindCourseInput();
	});

})( jQuery );
