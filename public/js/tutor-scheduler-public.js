(function( $ ) {
	'use strict';

	var filteredEventJSON = [];
	/**
	 * Sidenote: $.each() gaurantees order!!! YAY! :D
	 */

	//Fullcalendar functions
	var FullCalendarFrontEnd = {
		loadCalendar: function () {
			var self = this;
			var calendar = $("#fullcalendar-frontend");
			calendar.fullCalendar({
		        editable: false,
		        allDaySlot: false,
		        header: {
				    left:   'prev,next today',
				    center: 'title',
				    right:  'month,agendaWeek,agendaDay'
				},
				events: function(start, end, timezone, callback){
					callback(filteredEventJSON);
				},
				slotEventOverlap: true,
		        height: "auto",
		        minTime: "12:00:00",
		        maxTime: "20:00:00",
		        timezone: "America/Chicago",
		        defaultView: 'agendaWeek',
		        //Drill down view. Month  view to day view, week view to day view 
		        dayClick: function(date, jsEvent, view) {
		        	calendar.fullCalendar('changeView', 'agendaDay');
		        	calendar.fullCalendar('gotoDate', date);
			    },
		        //Tooltip to confirm appointment here.
			    eventClick: function(calEvent, jsEvent, view) {
		        	// console.log(calEvent);
		        	self.confirmAppointment(calEvent);
			    }
		    });
		},
		confirmAppointment: function (calEvent) {
			$(".selected-tutor-name").html(calEvent.title);
			$("#selected-tutor-date").html(calEvent.start.format("dddd, MMMM Do YYYY, h:mma"));
			var selectedCourse = _.find(coursesJSON, function(courseObject){
				return courseObject.id === $("#course-select").val();
			});
			if (selectedCourse == undefined) {
				$("#selected-tutor-subject").html('Not Selected');
			}else{
				$("#selected-tutor-subject").html(selectedCourse.name);
			}
			$("#confirm-appointment-modal").modal('show');
		},
		updateEvents: function (tutorIDs) {
			var self = this;
			if (typeof tutorIDs === "object") {
				var eventsToAdd;
				filteredEventJSON = [];
				$.each(tutorIDs, function (i, tutorID){
					eventsToAdd = _.filter(eventJSON, function(eventObject){
						return eventObject.tutor_ID === tutorID.id;
					});
					$.merge(filteredEventJSON, eventsToAdd)
				});
			}else{
				filteredEventJSON = _.filter(eventJSON, function(eventObject){
					return eventObject.tutor_ID === tutorIDs;
				});
			}
			$("#fullcalendar-frontend").fullCalendar('refetchEvents');

		}
	}

	//Course input functions
	var CustomInputFilters = {
		loadBindings: function () {
			var self = this;
			$("#course-select").on('change', function(){
				console.log();
				var selectedCourseID = $(this).val();
				var filteredTutorJSON;
				if (selectedCourseID === "") {
					filteredTutorJSON = self.loadTutorNames(-1);
				}else{
					filteredTutorJSON = self.loadTutorNames(selectedCourseID);
				}
				FullCalendarFrontEnd.updateEvents(filteredTutorJSON);
			});
			$("#tutor-select").on('change', function(){
				var selectedTutorID = $(this).val();
				FullCalendarFrontEnd.updateEvents(selectedTutorID);
			});
		},
		loadCourseNames: function () {
			var optionTemplate;
			var courseList = $("#course-select");
			var sortedCoursesJSON = coursesJSON;
			_.sortBy(sortedCoursesJSON, 'name');
			courseList.append('<option value="" selected>Select a course</option>');
			$.each(sortedCoursesJSON, function (i, course) {
				optionTemplate = '<option value="' + course.id + '">' + course.name + '</option>';
				courseList.append(optionTemplate);
			});
		},
		loadTutorNames: function (courseID) {
			var optionTemplate;
			var tutorsList = $("#tutor-select");
			var filteredTutorJSON = [];
			tutorsList.html(''); //Clear list
			//Load all tutors
			tutorsList.append('<option value="" selected>Select a tutor</option>');
			if (courseID === (-1)){
				filteredTutorJSON = tutorsJSON;
			}else{
				//Only load the tutors associated with the course ID from C2T
				
				var tutorIDs = _.filter(C2TJSON, function(row){
					return row.course_ID === courseID;
				});

				var tutorToAdd;
				$.each(tutorIDs, function (i, tutorID){
					tutorToAdd = _.find(tutorsJSON, function(tutorObject){
						return tutorObject.id === tutorID.tutor_ID;
					});
					filteredTutorJSON.push(tutorToAdd);
				});
			}
			_.sortBy(filteredTutorJSON, 'first_name');
			$.each(filteredTutorJSON, function (i, tutor) {
				optionTemplate = '<option value="' + tutor.id + '">' + tutor.first_name + ' ' + tutor.last_name + '</option>';
				tutorsList.append(optionTemplate);
			});
			
			return filteredTutorJSON;
		}

	}

	//Window load!
	$( window ).load(function(){
		FullCalendarFrontEnd.loadCalendar();
		CustomInputFilters.loadCourseNames();
		CustomInputFilters.loadTutorNames(-1);
		CustomInputFilters.loadBindings();
	});

})( jQuery );
