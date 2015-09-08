(function( $ ) {
	'use strict';

	var registeredCoursesJSON = [];
	var notRegisteredcoursesJSON = [];
	/**
	 * Functions for adding courses to student scheduler
	 */
	var CourseManager = {
		tempCourses: [],
		loadBindings: function () {
			$("#add-course-button").on("click", function(){
				CourseManager.addCourse();
			});
			$("#add-course-input").keypress(function(event){
				if ( event.which === 13 ) {
					event.preventDefault();
					$("#add-course-button").click();
				}
				
			});
			$(".course-remove").on("click", function(){
				var confirmedVal = confirm("Are you sure you want to remove " + $(this).attr("data-name") + " from the table?");
				if (confirmedVal === true) {
					//Remove the course from the table
					$(this).parent().parent().addClass("danger");
					$("#temp-course-table").prepend(CourseManager.addCourseFormat($(this).attr("data-courseID"), false));
					$("#temp-course-table").prepend('<tr class="danger"><td>'+$(this).attr("data-name")+'</td></tr>');
				}
			});

			/**
			 * Course Tutor Functions!
			 */
			$("#calendar_pop").popover({
				content: '<div id="fullcalendar_popover"></div>',
				html: true
			});
			$("#calendar_pop").click(function(){
				FullCalendar.popup();
			});
		},
		validateCourse: function(inputValue){
			//Make sure it is not blank
			if (inputValue.length === 0) {
				return false;
			}
			//Should make sure there are no duplicates.
			
			return true;
		},
		addCourseFormat: function(inputValue, addVal){
			if (addVal){
				return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="add" name="'+inputValue+'">';
			}else{
				return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="remove" name="'+inputValue+'">';
			}
		},
		addCourse: function(){
			var inputValue = $("#add-course-input").val();
			if (CourseManager.validateCourse(inputValue)) {
				$("#temp-course-table")
					.prepend(CourseManager.addCourseFormat(inputValue, true))
					.prepend('<tr class="success"><td>'+inputValue+'</td></tr>');
				$("#add-course-input")
					.val("")
					.parent().removeClass("has-error");
			}else{
				$("#add-course-input").parent().addClass("has-error");
			}
		}
	};

	var FullCalendar = {
		recurrDates: function(recurrUntil){
			var self = this;
			var start;
			var scheduledDates = $("#fullcalendar").fullCalendar('clientEvents');
			$("#fullcalendar").fullCalendar('removeEvents');

			recurrUntil = moment(recurrUntil, "YYYY-MM-DD");

			$.each(scheduledDates, function(i, eventObject){
				self.addNewEvent(eventObject.start, i);
				start = eventObject.start;
				while (start.add({weeks: 1}).isBefore(recurrUntil)){
					//Must subtract an hour because WP adds "1" to the timestamp rounding it up an hour
					start = start.subtract({minutes: 60});
					self.addNewEvent(start, i);
				}
			});

		},
		popup: function(){
			var self = this;
			$('#fullcalendar_popover').fullCalendar({
				editable: false,
		        timezone: "America/Chicago",
				dayClick: function (date, jsEvent, view) {
					//Input the value into input.
					$("#recurr_until").val(date.format());
					//Close the popover
					$("#calendar_pop").popover('hide');
				}
			});
		},
		newCalendar: function () {
			var self = this;
			$('#fullcalendar').fullCalendar({
		        // put your options and callbacks here
		        editable: true,
		        header: false,
		        columnFormat: 'dddd',
		        allDaySlot: false,
		        height: "auto",
		        minTime: "07:00:00",
		        maxTime: "20:00:00",
		        timezone: "America/Chicago",
		        weekends: false,
		        defaultView: 'agendaWeek',
		        dayClick: function(date, jsEvent, view) {
		        	self.addNewEvent(date, 0);
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
		addNewEvent: function(customDate, id){

			var tutorName = $("#first-name").val() + " " + $("#last-name").val();
			var startTime = customDate.format();
			var endTime = customDate.add({hours: 1}).format();
			//Assume no name is less than 4 characters, including the space seperating first and last
			if (tutorName.length > 4){
				var eventObject = {
					id: id,
					title: tutorName,
					start: startTime,
					end: endTime,
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

	var TutorScheduler = {

		serializeCourses: function(){
			var coursesArray = $("#courses-table").find(".success");
			var courses = [];

			coursesArray.each(function(i, course){
				courses.push($(course).find("input").attr("data-courseID"));
			});
			$("input#courses").val(courses.toString());

			return true;
		},
		serializeDates: function(){
			var schedule = '';
			var newCalObject = {};
			var scheduledDates = $("#fullcalendar").fullCalendar('clientEvents');

			$(scheduledDates).each(function(i, calObject){
				newCalObject = {
									start: calObject.start,
									end: calObject.end,
									title: calObject.title,
									id: calObject.id,
									description: calObject.description
								};
				schedule += JSON.stringify(newCalObject)+", ";

			});

			$("input#schedule").val(schedule);
			$("input#schedule").attr("size", schedule.length);
			
			return true;

		},
		loadBindings: function () {

			//Manage tutor courses
			$("#tutor-list-m-courses").on('change', function(){
				var selectedTutorID = $(this).val();
				var courseIDs = _.filter(C2TJSON, function(C2TRow){
					return C2TRow.tutor_ID === selectedTutorID;
				});
				registeredCoursesJSON = [];
				notRegisteredcoursesJSON = [];
				$.each(courseIDs, function(i, C2TRow){
					var coursesToAdd = _.filter(coursesJSON, function(coursesRow){
						return C2TRow.course_ID === coursesRow.id;
					});
					$.merge(registeredCoursesJSON, coursesToAdd);
				});
				$.each(courseIDs, function(i, C2TRow){
					notRegisteredcoursesJSON = _.filter(coursesJSON, function(coursesRow){
						return courseIDs.course_ID === coursesRow.id;
					});
					$.merge(registeredCoursesJSON, coursesToAdd);
				});
			});

			$("#update-tutor-courses").click(function(){
				e.preventDefault();
				$.ajax({
					type: "post",
					dataType: "json",
					url: myAjax.ajaxurl,
					data : {
						action: "update_tutor_information",
						type: 'update_courses',
						nonce: $("#tutor-list-m-courses").attr("data-nonce"),
						tutor_id: selectedTutorID,
						
					},
					success: function(resp) {
						if(resp.type == "success") {
							// self.ajaxSuccess(resp.event_id);
						}
						else {
							// self.ajaxError(resp);
						}
					},
					error: function ( jqXHR, textStatus, errorThrown) {
						var resp = {
							error_type: "ajax",
							message: textStatus,
							type: "error",
							event_id: -1
						}
						// self.ajaxError(resp);
					},
					complete: function ( jqXHR, textStatus ) {
						// loadingSpinner.addClass("hidden");
						// confirmationForm.find("input").removeAttr("disabled");
						// $("#fullcalendar-frontend").fullCalendar('refetchEvents');
					}
				});
			});
			//Create a calendar
			$("#student-form").submit(function(event){
				//Serialize data for POST object before submit event
				var recurrUntil = $("#recurr_until").val();

				FullCalendar.recurrDates(recurrUntil);

				if ( TutorScheduler.serializeCourses() === false ){
					event.preventDefault();
				}
				if ( TutorScheduler.serializeDates() === false ){
					event.preventDefault();
				}
				this.submit();
			});

			$("input.course-highlight-checkbox").on("click", function(event){
				//For the check boxes of courses when adding a tutor
				if ($(this).context.checked) {
					$(this).parent().parent().addClass("success");
				}else{
					$(this).parent().parent().removeClass("success");
				}
			});

			$(".student-remove").on("click", function(event){
				var confirmedVal = confirm("Are you sure you want to remove " + $(this).attr("data-name") + " from the table?");
				if (confirmedVal === false) {
					//Stop propigation
					event.preventDefault();
				}else{
					$("#student-remove-input").val($(this).attr("data-tutorID"));
					$("#student-remove-form").submit();
				}
			});
		}
	}

	$( window ).load(function(){


		/**
		 * Course Manager Functions!!!!!!
		 */
		CourseManager.loadBindings();

		/**
		 * Tutor Manager Functions!
		 */
		FullCalendar.newCalendar();
		TutorScheduler.loadBindings();

	});

})( jQuery );
