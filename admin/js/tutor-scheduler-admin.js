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
		largestParentID: -1,
		editedEvents: [],
		recurrUntil: {},
		timeblock: 0 // These are in minutes
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
			$("#add-course-button").on("click", function (){
				CourseManager.addCourse();
			});
			$("#add-course-input").keypress(function (event){
				if ( event.which === 13 ) {
					event.preventDefault();
					$("#add-course-button").click();
				}
				
			});
			$(".course-remove").on("click", function (){
				var confirmedVal = confirm("Are you sure you want to remove " + $(this).attr("data-name") + " from the table?");
				if (confirmedVal === true) {
					//Remove the course from the table
					$(this).parent().parent().addClass("danger");
					$("#temp-course-table").prepend(CourseManager.addCourseFormat($(this).attr("data-courseID"), false));
					$("#temp-course-table").prepend('<tr class="danger"><td>'+$(this).attr("data-name")+'</td></tr>');
				}
			});
		},
		validateCourse: function (inputValue){
			//Make sure it is not blank
			if (inputValue.length === 0) {
				return false;
			}
			//Should make sure there are no duplicates.
			
			return true;
		},
		addCourseFormat: function (inputValue, addVal){
			if (addVal){
				return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="add" name="'+inputValue+'">';
			}else{
				return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="remove" name="'+inputValue+'">';
			}
		},
		addCourse: function (){
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

		if (this.hasHeader) {
			this.hasHeader = {
			    left:   'prev,next today',
			    center: 'title',
			    right:  'month,agendaWeek,agendaDay'
			};
		}

		this.render = function(){
			this.identifier.fullCalendar('render');
		};

		this.serializeDates = function(){
			var schedule = '';
			var newCalObject = {};
			var input = $("input#schedule");
			var scheduledDates = this.identifier.fullCalendar('clientEvents');
			if ($("#edit-t-fullcalendar").is(this.identifier)){
				scheduledDates = filteredTutorEvents.editedEvents;
				input = $("input#edited_schedule");
			}

			$.each(scheduledDates, function(i, calObject){
				if (typeof calObject.adding === 'undefined'){
					calObject.adding = false;
				}
				newCalObject = {
									start: calObject.start,
									end: calObject.end,
									title: calObject.title,
									id: calObject.id,
									adding: calObject.adding,
									description: calObject.description
								};
				schedule += JSON.stringify(newCalObject)+", ";
			});

			input.val(schedule);
			input.attr("size", schedule.length);
			
			return true;

		};
		this.recurrDates = function(recurrUntil){
			// console.log("In recurring.");
			var self = this;
			var start, end;
			var scheduledDates = this.identifier.fullCalendar('clientEvents');
			// console.log(scheduledDates);
			var apptTimeBlocks = $("#time-to-add").val();
			// This is so that we do not have duplicates on the front end and also to remove 
			// any potential memory leaks
			this.clearEvents();

			recurrUntil = moment(recurrUntil, "YYYY-MM-DD").add({day: 1});

			// console.log(recurrUntil);

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
			this.identifier.fullCalendar({
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
			    	// console.log("in events");
			    	// console.log(filteredTutorEvents.eventJSON);
					callback(filteredTutorEvents.eventJSON);
				}
		    });
		};
		this.deleteEvent = function (calEvent){
			this.identifier.fullCalendar('removeEvents', function (event){
				return event == calEvent;
			});
			// This compares if the current calendar is the editing calendar.
			// If it is, we need to add the event object to the "Currently editing" events table.
			if ($("#edit-t-fullcalendar").is(this.identifier)){
				// Add it to the filteredTutorObjects variable.
				TutorScheduler.checkIfEdited(calEvent, false);
				// Add it to the DOM
				TutorScheduler.editedEventsToDOM();
			}
		};
		this.addNewEvent = function (customDate, id){

			var tutorName = $("#first-name").val() + " " + $("#last-name").val();
			var startTime = customDate.format();
			var timeToAdd = $("#time-to-add").val();
			var endTime = customDate.add({minutes: timeToAdd}).format();
			//Assume no name is less than 3 characters, including the space seperating first and last
			if (tutorName.length > 3){
				var eventObject = {
					id: id,
					title: tutorName,
					start: startTime,
					end: endTime,
					description: "Tutoring with " + tutorName
				}
				// This compares if the current calendar is the editing calendar.
				// If it is, we need to add the event object to the "Currently editing" events table.
				if ($("#edit-t-fullcalendar").is(this.identifier)){
					// Add it to the filteredTutorObjects variable.
					TutorScheduler.checkIfEdited(eventObject, true);
					// Add it to the DOM
					TutorScheduler.editedEventsToDOM();
				}
				// Add it to the front end of the calendar using the Fullcalendar API.
		        this.identifier.fullCalendar('renderEvent', eventObject, true);
			}else{
				alert("Please enter a name before scheduling times.")
				$("#first-name").focus();
			}

		};
		this.clearEvents = function () {
			this.identifier.fullCalendar('removeEvents');
		};
		this.updateEvents = function () {
			// console.log("Updating events!");
			// console.log(this.identifier);
			this.clearEvents();
			this.identifier.fullCalendar('refetchEvents');
		};
	}

	var TutorScheduler = {
		// Check if an eventObject is already in the edited events array.
		// If it is, remove it.
		// It it isnt, add it. 
		checkIfEdited: function (calEventObject, adding){
			if(typeof calEventObject.start === 'object'){
				calEventObject.start = calEventObject.start.format();
				calEventObject.end = calEventObject.end.format();
			}
			// Object if it is in the array or undefined if it isnt.
			var inArray = _.find(filteredTutorEvents.editedEvents, function (eventObject){
				return calEventObject.start == eventObject.start;
			});
			if (typeof inArray === 'undefined'){
				calEventObject.adding = adding;
				filteredTutorEvents.editedEvents.push(calEventObject);
			}else{
				filteredTutorEvents.editedEvents = _.reject(filteredTutorEvents.editedEvents, function (eventObject){
					return calEventObject.start == eventObject.start;
				});
			}
		},
		// When editing events this inputs the table 
		editedEventsToDOM: function () {
			var self = this;
			var element = $("#edit-t-events");
			element.html('');
			$.each(filteredTutorEvents.editedEvents, function (i, eventObject){
				var contextualClass = ''; // Contextual class refers to a Bootstrap HTML class
				var editType = '';
				if (eventObject.adding){
					contextualClass = 'bg-success';
					editType = 'add';
				}else{
					contextualClass = 'bg-danger';
					editType = 'remove';
				}
				var eventTabletemplate = '<tr class="'+contextualClass+'" data-type="'+editType+'">';
				eventTabletemplate += '<td>' + moment(eventObject.start).format("llll") + '</td>';
				eventTabletemplate += '</tr>';
				element.append(eventTabletemplate);
			});
		},

		loadTutorNames: function (){
			var self = this;
			/**
			 * Modify this function!!! m m
			 */
			 var localTutorJSON = (typeof tutorJSON === 'undefined') ? {} : tutorJSON;
			$.each(localTutorJSON, function(i, tutorObject){
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
			var editTutorCalendar = new FullCalendar($('#edit-t-fullcalendar'), true);
			addTutorCalendar.newCalendar();
			editTutorCalendar.newCalendar();
			/**
			 * Course Tutor Functions!
			 */
			$('.modal-body').on('change', '#edit-t-time-to-add', function(){
				filteredTutorEvents.timeBlock = $(this).val();
				$("#time-to-add").val(filteredTutorEvents.timeBlock);
				$("#time-block-binding").html(filteredTutorEvents.timeBlock);
			});
			$('.modal-body').on('change', '#edit-t-recurr-until', function(){
				filteredTutorEvents.recurrUntil = $(this).val();
				$("#end-date-binding").html(moment(filteredTutorEvents.recurrUntil).format("LL"));
			});

			$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			 	addTutorCalendar.render();
				editTutorCalendar.render();
				$("#first-name").val('');
				$("#last-name").val('');
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
				$("#edit_t_student_id").val(selectedTutorID);
				// Remove all FullCalendar frontend events. This is mainly so that 
				// frontend events created under one tutor do not accidentally make their way over to
				// other tutors.
				$("#edit-t-events").html('');
				CustomInputFilters.updateEvents(selectedTutorID);
				// Do they have events already set? If not, they need to have a time block.
				// And they also need an end date.
				if (filteredTutorEvents.eventJSON.length < 1) {
					CustomInputFilters.toggleEditEventsModal();
				}else{
					var endTime = filteredTutorEvents.eventJSON[0].end;
					var startTime = filteredTutorEvents.eventJSON[0].start;
					var timeBlock =  moment(endTime).diff(startTime, 'minutes');
					$("#time-to-add").val(timeBlock);
					$("#time-block-binding").html(timeBlock);
				}
				/**
				 * Need to add a refresher for the calendar
				 */
				
				editTutorCalendar.updateEvents();
			});

			$("#add-student-form").submit(function(event){
				//Serialize data for POST object before submit event
				var recurrUntil = $("#recurr-until").val();

				addTutorCalendar.recurrDates(recurrUntil);

				if ( TutorScheduler.serializeCourses() === false ){
					event.preventDefault();
				}
				else if ( addTutorCalendar.serializeDates() === false ){
					event.preventDefault();
				}
				else this.submit();
			});

			$("#edit-student-form").submit(function (event){
				//Serialize data for POST object before submit event
				// var recurrUntil = filteredTutorEvents.recurrUntil;

				// editTutorCalendar.recurrDates(recurrUntil);
				$.each(filteredTutorEvents.editedEvents, function (i, eventObject){
					++filteredTutorEvents.largestParentID;
					eventObject.id = filteredTutorEvents.largestParentID;
				});
				if ( editTutorCalendar.serializeDates() === false ){
					event.preventDefault();
				}
				else this.submit();
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

			$("div").on("click", "input.course-highlight-checkbox", function (event){
				//For the check boxes of courses when adding a tutor
				if ($(this).context.checked) {
					$(this).parent().parent().addClass("success");
				}else{
					$(this).parent().parent().removeClass("success");
				}
			});

			$("div").on("click", "input.course-highlight-danger", function (event){
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

		toggleEditEventsModal: function () {
			//Set modal title
			$(".modal .modal-title").html("It seems you don't have events available yet!");
			//Set the time block selector.
			$(".modal .modal-body").html('<select name="time-to-add" id="edit-t-time-to-add" class="form-control" form="student-form" required><option selected>Tutoring Time Block</option><option value="30">30 minutes</option><option value="60">60 minutes</option></select>');
			//Need to add the date picker so that we can set a recurr until date.
			$(".modal .modal-body").append('<input id="edit-t-recurr-until" type="date" placeholder="Choose an ending date.">');
			//Pop up the modal. 
			$('.modal').modal('toggle');
		},
		
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
			var courseIDs = _.filter(C2TJSON, function (C2TRow){
				return C2TRow.tutor_ID === tutorID;
			});
			//Filter out the courses which are registered and not registered.
			$.each(courseIDs, function (i, C2TRow){
				courseToAdd = _.filter(coursesJSON, function (coursesRow){
					return C2TRow.course_ID === coursesRow.id;
				});
				filteredTutorCourses.notRegistered = _.reject(filteredTutorCourses.notRegistered, function (coursesRow){
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
			$.each(filteredTutorCourses.registered, function (i, course){
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
			$.each(filteredTutorCourses.notRegistered, function (i, course){
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
			// Fill the eventJSON with only the events tied to the tutor ID.
			// This function also filters out days that are in the past.
			filteredTutorEvents.eventJSON = _.filter(eventJSON, function(eventObject){
				if(eventObject.tutor_ID === tutorID){
					largestParentID = Math.max(eventObject.parent_ID, largestParentID);
					if (yesterday.isBefore(eventObject.start)){
						recurrUntil = moment(eventObject.start);
					}
				}
				return eventObject.tutor_ID === tutorID && yesterday.isBefore(eventObject.start) && eventObject.date_taken == 0;
			});
			filteredTutorEvents.largestParentID = largestParentID;
			filteredTutorEvents.recurrUntil = recurrUntil.format("YYYY-MM-DD");
			filteredTutorEvents.editedEvents = [];
			$("#end-date-binding").html(recurrUntil.format("LL"));
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
