/**
 * Tutor Scheduler Admin Javascript
 *
 *
 * Purpose: This file controls all of the Javascript for the Course Manager and Tutor Manager Pages.
 * 
 */

(function( $ ) {
	'use strict';

	var filteredTutorEvents = {
		eventsJSON: [], 
		parentEventJSON: [],
		largestParentID: -1,
		recurrUntil: {}
	};
	var filteredTutorCourses = {
		registered: [],
		notRegistered: []
	};
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

	function FullCalendar(identifier, hasHeader) {
		this.identifier = identifier;
		this.hasHeader = hasHeader;
		this.render = function(){
			identifier.fullCalendar('render');
		};

		this.serializeDates = function(){
			var schedule = '';
			var newCalObject = {};
			var scheduledDates = this.identifier.fullCalendar('clientEvents');

			$.each(scheduledDates, function(i, calObject){
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

		};
		this.recurrDates = function(recurrUntil){
			var self = this;
			var start, end;
			var scheduledDates = identifier.fullCalendar('clientEvents');
			var apptTimeBlocks = $("#time-to-add").val();
			identifier.fullCalendar('removeEvents');

			recurrUntil = moment(recurrUntil, "YYYY-MM-DD").add({day: 1});

			$.each(scheduledDates, function(i, eventObject){
				start = eventObject.start;
				while (start.isBefore(recurrUntil)){
					self.addNewEvent(start, i);
					start = start.subtract({minutes: apptTimeBlocks}).add({weeks: 1});
				}
			});

		};
		this.newCalendar = function () {
			var self = this;
			identifier.fullCalendar({
		        // put your options and callbacks here
		        header: self.hasHeader,
		        columnFormat: 'dddd',
		        allDaySlot: false,
		        height: "auto",
		        minTime: "07:00:00",
		        maxTime: "20:00:00",
		        timezone: "America/Chicago",
		        defaultView: 'agendaWeek',
		        dayClick: function(date, jsEvent, view) {
		        	self.addNewEvent(date, 0);
			    },
			    eventClick: function(calEvent, jsEvent, view) {
			    	self.deleteEvent(calEvent);
			    },
			    events: function(start, end, timezone, callback){
					callback(filteredTutorEvents.eventsJSON);
					// if (editSingleEvent) {
					// 	callback(filteredTutorEvents.eventsJSON);
					// }else{
					// 	callback(filteredTutorEvents.parentEventJSON);
					// }
				}
		    });
		};
		this.deleteEvent = function(calEvent){
			identifier.fullCalendar('removeEvents', function(event){
				return event == calEvent;
			});
		};
		this.addNewEvent = function(customDate, id){

			var tutorName = $("#first-name").val() + " " + $("#last-name").val();
			var startTime = customDate.format();
			var timeToAdd = $("#time-to-add").val();
			var endTime = customDate.add({minutes: timeToAdd}).format();
			//Assume no name is less than 4 characters, including the space seperating first and last
			if (tutorName.length > 4){
				var eventObject = {
					id: id,
					title: tutorName,
					start: startTime,
					end: endTime,
					description: "Tutoring with " + tutorName
				}
		        identifier.fullCalendar('renderEvent', eventObject, true);
			}else{
				alert("Please enter a name before scheduling times.")
				$("#first-name").focus();
			}

		}
	}

	var TutorScheduler = {

		loadTutorNames: function (){
			var self = this;
			/**
			 * Modify this function!!!
			 */
			 var tutorJSON = (typeof tutorJSON === 'undefined') ? {} : tutorJSON;
			$.each(tutorJSON, function(i, tutorObject){
				var tutorOptionTemplate = '<option value="'+tutorObject.id+'">'+tutorObject.first_name+' '+tutorObject.last_name+'</option>';
				$("#tutor-list-m-courses").append(tutorOptionTemplate);
				$("#tutor-list-m-events").append(tutorOptionTemplate);
			});
			
		},

		serializeCourses: function(){
			var coursesArray = $("#courses-table").find(".success");
			var courses = [];

			coursesArray.each(function(i, course){
				courses.push($(course).find("input").attr("data-courseID"));
			});
			$("input#courses").val(courses.toString());

			return true;
		},
		loadBindings: function () {
			var self = this;

			var addTutorCalendar = new FullCalendar($('#add-t-fullcalendar'), false);
			var editTutorCalendar = new FullCalendar($('#edit-t-fullcalendar'), false);
			addTutorCalendar.newCalendar();
			editTutorCalendar.newCalendar();
			/**
			 * Course Tutor Functions!
			 */
			$('.modal-body').on('change', '#edit-t-time-to-add', function(){
				var timeToAdd = $(this).val();
				$("#time-to-add").val(timeToAdd);
			});
			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			 	addTutorCalendar.render();
				editTutorCalendar.render();
				$("#first-name").val('');
				$("#last-name").val('');
			});
			$("#calendar_pop").popover({
				content: '<div id="fullcalendar_popover"></div>',
				html: true
			});
			$("#calendar_pop").click(function(){
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
			});
			$("#tutor-list-m-courses").on('change', function(){
				var selectedTutorID = $(this).val();
				$("#r-course-student-id").val(selectedTutorID);
				CustomInputFilters.loadCourseNames(selectedTutorID);
			});
			$("#tutor-list-m-events").on('change', function(){
				var selectedTutorID = $(this).val();
				var name = $("#tutor-list-m-events option:selected").text().split();
				$("#first-name").val(name[0]);
				$("#last-name").val(name[1]);
				CustomInputFilters.updateEvents(selectedTutorID);
				if (filteredTutorEvents.eventJSON.length < 1) {
					//Set modal title, body.
					$(".modal .modal-title").html("Please Enter a Time Block");
					$(".modal .modal-body").html('<select name="time-to-add" id="edit-t-time-to-add" class="form-control" form="student-form" required><option selected>Tutoring Time Block</option><option value="30">30 minutes</option><option value="60">60 minutes</option></select>');
					//Pop up the modal. 
					$('.modal').modal('toggle')
				}else{
					var endTime = filteredTutorEvents.eventJSON[0].end;
					var startTime = filteredTutorEvents.eventJSON[0].start;
					var timeBlock =  moment(endTime).diff(startTime, 'minutes');
				}
			});

			//Create a calendar
			$("#add-student-form").submit(function(event){
				//Serialize data for POST object before submit event
				var recurrUntil = $("#recurr_until").val();

				addTutorCalendar.recurrDates(recurrUntil);

				if ( TutorScheduler.serializeCourses() === false ){
					event.preventDefault();
				}
				if ( addTutorCalendar.serializeDates() === false ){
					event.preventDefault();
				}
				this.submit();
			});

			$("#edit-student-form").submit(function(event){
				//Serialize data for POST object before submit event
				var recurrUntil = $("#recurr_until").val();

				addTutorCalendar.recurrDates(recurrUntil);

				if ( TutorScheduler.serializeCourses() === false ){
					event.preventDefault();
				}
				if ( addTutorCalendar.serializeDates() === false ){
					event.preventDefault();
				}
				this.submit();
			});

			$("#registered-courses").on('click', 'input.r-course-add', function(){
				var inputValue = $(this).attr("data-courseID");
				var addVal = false;
				if ($(this).context.checked) {
					//Get input format
					$("#input-container").append(CourseManager.addCourseFormat(inputValue, addVal));
				}else{
					$("input[name='"+inputValue+"']").detach();
				}
			});
			$("#not-registered-courses").on('click', 'input.r-course-remove', function(){
				var inputValue = $(this).attr("data-courseID");
				var addVal = true;
				if ($(this).context.checked) {
					//Get input format
					$("#input-container").append(CourseManager.addCourseFormat(inputValue, addVal));
				}else{
					$("input[name='"+inputValue+"']").detach();
				}
			});

			$("div").on("click", "input.course-highlight-checkbox", function(event){
				//For the check boxes of courses when adding a tutor
				if ($(this).context.checked) {
					$(this).parent().parent().addClass("success");
				}else{
					$(this).parent().parent().removeClass("success");
				}
			});

			$("div").on("click", "input.course-highlight-danger", function(event){
				//For the check boxes of courses when adding a tutor
				if ($(this).context.checked) {
					$(this).parent().parent().addClass("danger");
				}else{
					$(this).parent().parent().removeClass("danger");
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

	//Course input functions
	var CustomInputFilters = {
		
		loadCourseNames: function (tutorID) {
			var courseToAdd = [];
			var registeredCoursesDOM = $("#registered-courses");
			var notRegisteredCoursesDOM = $("#not-registered-courses");
			//Clean the DOM
			registeredCoursesDOM.empty();
			notRegisteredCoursesDOM.empty();
			//Prepare the lists
			filteredTutorCourses.registered = [];
			filteredTutorCourses.notRegistered = coursesJSON;
			//Get the IDs of the courses tied to the tutor ID.
			var courseIDs = _.filter(C2TJSON, function(C2TRow){
				return C2TRow.tutor_ID === tutorID;
			});
			//Filter out the courses which are registered and not registered.
			$.each(courseIDs, function(i, C2TRow){
				courseToAdd = _.filter(coursesJSON, function(coursesRow){
					return C2TRow.course_ID === coursesRow.id;
				});
				filteredTutorCourses.notRegistered = _.reject(filteredTutorCourses.notRegistered, function(coursesRow){
					return C2TRow.course_ID === coursesRow.id;
				});
				$.merge(filteredTutorCourses.registered, courseToAdd);
			});
			//Sort the filtered in ascending alphabetical order.
			filteredTutorCourses.registered = _.sortBy(filteredTutorCourses.registered, 'name');
			filteredTutorCourses.notRegistered = _.sortBy(filteredTutorCourses.notRegistered, 'name');

			/**
			 * Need to append these dates to the DOM.
			 */
			var htmlToAppend = '';
			$.each(filteredTutorCourses.registered, function(i, course){
				htmlToAppend += '<tr>';
				htmlToAppend += '<td class="course-highlight">';
				htmlToAppend += '<label style="display: block;">';
				htmlToAppend += '<input class="course-highlight-danger r-course-add" type="checkbox" data-courseID="'+course.id+'">&nbsp; '+course.name
				htmlToAppend += '</label>';
				htmlToAppend += '</td>';
				htmlToAppend += '</tr>';
			});
			registeredCoursesDOM.append(htmlToAppend);
			htmlToAppend = '';
			$.each(filteredTutorCourses.notRegistered, function(i, course){
				htmlToAppend += '<tr>';
				htmlToAppend += '<td class="course-highlight">';
				htmlToAppend += '<label style="display: block;">';
				htmlToAppend += '<input class="course-highlight-checkbox r-course-remove" type="checkbox" data-courseID="'+course.id+'">&nbsp; '+course.name
				htmlToAppend += '</label>';
				htmlToAppend += '</td>';
				htmlToAppend += '</tr>';
			});
			notRegisteredCoursesDOM.append(htmlToAppend);
		},
		updateEvents: function (tutorID) {
			var self = this;
			var largestParentID = -1;
			var yesterday = moment().subtract({day: 1});
			var recurrUntil = moment().add({day: 1});
			filteredTutorEvents.parentEventJSON = []; // Clear the JSON array so that it is now clean.
			filteredTutorEvents.eventJSON = _.filter(eventJSON, function(eventObject){
				if(eventObject.tutor_ID === tutorID){
					largestParentID = Math.max(eventObject.parent_ID, largestParentID);
					if (yesterday.isBefore(eventObject.start)){
						recurrUntil = moment(eventObject.start);
					}
				}
				return eventObject.tutor_ID === tutorID && yesterday.isBefore(eventObject.start);
			});
			for (var i = largestParentID; i >= 0; i--) {
				var parentToPush = _.find(filteredTutorEvents.eventJSON, function(eventObject){
					//Parent ID is a String and i is a number.
					// This comes as a string from the DB.
					return eventObject.parent_ID == i; 	
				});
				filteredTutorEvents.parentEventJSON.push(parentToPush);
			};
			filteredTutorEvents.largestParentID = largestParentID;
			filteredTutorEvents.recurrUntil = recurrUntil.format("YYYY-MM-DD");
			/**
			 * Need to add a refresher for the calendar
			 */
			console.log(filteredTutorEvents.recurrUntil);
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
		TutorScheduler.loadTutorNames();
		TutorScheduler.loadBindings();

	});

})( jQuery );
