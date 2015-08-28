(function( $ ) {
	'use strict';

	/**
	 * Functions for adding courses to student scheduler
	 */
	var CourseManager = {
		tempCourses: [],
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
		recurrDates: function(recurrUntil, scheduledDates){
			var self = this;
			var start;
			recurrUntil = moment(recurrUntil, "YYYY-MM-DD");

			$.each(scheduledDates, function(i, eventObject){
				eventObject.id = i;
				start = eventObject.start;
				while (start.isBefore(recurrUntil)){
					//Must subtract an hour because WP adds "1" to the timestamp rounding it up an hour
					start = start.add({weeks: 1}).subtract({minutes: 60});
					self.addNewEvent(start, i);
				}

			});

		},
		popup: function(){
			var self = this;
			$('#fullcalendar_popover').fullCalendar({
				editable: true,
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
		        minTime: "12:00:00",
		        maxTime: "19:00:00",
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
		addNewEvent: function(date, id){

			var tutorName = $("#first-name").val() + " " + $("#last-name").val();
			//Assume no name is less than 4 charactersl, including the space seperating first and last
			if (tutorName.length > 4){
				var eventObject = {
					id: id,
					title: tutorName,
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

	var TutorScheduler = {
		serializeCourses: function(){
			var coursesArray = $("#courses-table").find(".success");
			var courses = [];

			coursesArray.each(function(i, course){
				courses.push($(course).find("input").attr("data-courseID"));
			});
			$("input#courses").val(courses.toString());
			// console.log("The courses val is:"); //Debug
			// console.log($("input#courses").val());

			return true;
		},
		serializeDates: function(scheduledDates){
			var schedule = '';
			var newCalObject = {};

			$(scheduledDates).each(function(i, calObject){
				newCalObject = {
									start: calObject.start.format(),
									end: calObject.end.format(),
									title: calObject.title,
									id: calObject.id,
									description: calObject.description
								};
				schedule += JSON.stringify(newCalObject)+", ";

			});

			$("input#schedule").val(schedule);
			$("input#schedule").attr("size", schedule.length);
			
			return true;

		}
	}

	$( window ).load(function(){


		/**
		 * Course Manager Functions!!!!!!
		 */
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
		//Create a calendar
		FullCalendar.newCalendar();

		//Bindings to page!
		$("#student-form").submit(function(event){
			//Serialize data for POST object before submit event
			var scheduledDates = $("#fullcalendar").fullCalendar('clientEvents');
			var recurrUntil = $("#recurr_until").val();

			FullCalendar.recurrDates(recurrUntil, scheduledDates);

			if ( TutorScheduler.serializeCourses() === false ){
				event.preventDefault();
			}
			scheduledDates = $("#fullcalendar").fullCalendar('clientEvents');
			if ( TutorScheduler.serializeDates(scheduledDates) === false ){
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

	});

})( jQuery );
