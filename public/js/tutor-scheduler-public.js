(function( $ ) {
	'use strict';

	var filteredEventJSON = [];
	// var coursesJSON = coursesJSON;
	// var tutorsJSON = tutorsJSON;

	var AddThisEventCustom = {
		updateData: function (calEvent, selectedCourse) {
			$("#start").html(calEvent.start.format("MM/DD/YYYY hh:mm A"));
			$("#end").html(calEvent.end.format("MM/DD/YYYY hh:mm A"));
			$("#title").html("Tutoring with " + calEvent.title);
			$("#description").html("Tutoring with " + calEvent.title + ". Reviewing " + selectedCourse.name);
			addthisevent.refresh();
			this.cleanUpDuplicates();
		},
		cleanUpDuplicates: function () {
			var updatedButtons = $(".addthisevent_dropdown").last();
			$(".addthisevent_dropdown").remove();
			$(".addthisevent-drop").append(updatedButtons);
		}
	}

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
				eventLimit: true, // for all non-agenda views
			    views: {
			        agenda: {
			            eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
			        },
			        month: {
			        	eventLimit: 3
			        }
			    },
				slotEventOverlap: true,
		        height: "auto",
		        minTime: "08:00:00",
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

			var form = $("#confirm-appointment-modal").find("form");
			var selectedCourse = _.find(coursesJSON, function(courseObject){
				return courseObject.id === $("#course-select").val();
			});
			if (selectedCourse == undefined) {
				selectedCourse = {};
				selectedCourse.name = "Unselected";
			}
			$("#selected-tutor-subject").html(selectedCourse.name);
			form.attr("data-tutorSubject", selectedCourse.name);
			form.attr("data-eventID", calEvent.id);
			form.attr("data-tutorID", calEvent.tutor_ID);
			form.attr("data-tutorName", $(".selected-tutor-name").first().html());
			form.attr("data-eventDate", calEvent.start.format("dddd, MMMM Do YYYY, h:mma"));
			AddThisEventCustom.updateData(calEvent, selectedCourse);
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
		ajaxSuccess: function (event_id) {
			$(".modal-success").addClass("bg-success");
			$(".before-ajax-request").addClass("hidden");
			$(".after-ajax-success").removeClass("hidden");
			//Update the eventsJSON by removing the booked event from the frontend
			eventJSON = _.reject(eventJSON, function(eventObject){
				return eventObject.id === event_id;
			});
			filteredEventJSON = _.reject(filteredEventJSON, function(eventObject){
				return eventObject.id === event_id;
			});
		},
		ajaxError: function (resp) {
			/**
			 * Response types are as follows:
			 * resp.type = ["db", "ajax", "race"];
			 */
			// console.log(resp);
			$(".modal-success").addClass("bg-danger");
			if (resp.error_type === "race") {
				$(".before-ajax-request").addClass("hidden");
				$(".after-ajax-race-error").removeClass("hidden");
				//Update the eventsJSON by removing the booked event from the frontend
				eventJSON = _.reject(eventJSON, function(eventObject){
					return eventObject.id === resp.event_id;
				});
				filteredEventJSON = _.reject(filteredEventJSON, function(eventObject){
					return eventObject.id === resp.event_id;
				});
			}else if(resp.error_type === "recaptcha"){
				grecaptcha.reset();
				alert(resp.message);
			}else{
				alert(resp.message);
			}
		},
		submitAjaxForm: function () {
			// body...
			var self = this;
			var confirmationForm = $("#confirm-appointment");
			var loadingSpinner = $(".loading-spinner");
			confirmationForm.find("input").attr("disabled", "");
			loadingSpinner.removeClass("hidden");

			$.ajax({
				type: "post",
				dataType: "json",
				url: myAjax.ajaxurl,
				data : {
					recaptcha_response: grecaptcha.getResponse(),
					action: "confirm_tas_appointment",
					event_id: confirmationForm.attr("data-eventID"),
					nonce: confirmationForm.attr("data-nonce"),
					tutor_id: confirmationForm.attr("data-tutorID"),
					tutor_subject: confirmationForm.attr("data-tutorSubject"),
					tutor_name: confirmationForm.attr("data-tutorName"),
					event_date: confirmationForm.attr("data-eventDate"),
					first_name: $("#first-name").val(),
					last_name: $("#last-name").val(),
					email: $("#email").val(),
					classification: $("#classification").val(),
					major: $("#major").val(),
					note_to_tutor: $("#note-to-tutor").val(),
					program: $("#program").val()
				},
				success: function(resp) {
					// console.log("Success!");
					if(resp.type == "success") {
						self.ajaxSuccess(resp.event_id);
					}
					else {
						self.ajaxError(resp);
					}
				},
				error: function ( jqXHR, textStatus, errorThrown) {
					// console.log(jqXHR);
					// console.log(textStatus);
					// console.log(errorThrown);
					var resp = {
						error_type: "ajax",
						message: textStatus,
						type: "error",
						event_id: -1
					}
					self.ajaxError(resp);
				},
				complete: function ( jqXHR, textStatus ) {
					loadingSpinner.addClass("hidden");
					confirmationForm.find("input").removeAttr("disabled");
					$("#fullcalendar-frontend").fullCalendar('refetchEvents');
				}
			});
		},
		refreshModal: function () {
			$("input").val('');
			$(".modal-success").removeClass("bg-success");
			$(".modal-success").removeClass("bg-danger");
			$(".before-ajax-request").removeClass("hidden");
			$(".after-ajax-success").addClass("hidden");
			$(".after-ajax-race-error").addClass("hidden");
			grecaptcha.reset();
		},
		loadBindings: function () {
			var self = this;
			$('.modal').on('hidden.bs.modal', function () {
			    self.refreshModal();
			});
			$("#course-select").on('change', function(){
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
			$(".g-recaptcha").on('click', function (argument){
				self.recaptchaAjaxForm();
			});
			$("#confirm-appointment").submit(function(e){
				e.preventDefault();
				self.submitAjaxForm();
			});
		},
		loadCourseNames: function () {
			var optionTemplate;
			var courseList = $("#course-select");
			var localCoursesJSON = (typeof coursesJSON === 'undefined' ? {} : coursesJSON);
			var sortedCoursesJSON = _.sortBy(localCoursesJSON, 'name');
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
			tutorsList.empty(); //Clear list
			//Load all tutors
			tutorsList.append('<option value="" selected>Select a tutor</option>');
			var localTutorsJSON = (typeof tutorsJSON === 'undefined' ? {} : tutorsJSON);
			if (courseID === (-1)){
				filteredTutorJSON = localTutorsJSON;
			}else{
				//Only load the tutors associated with the course ID from C2T
				
				var tutorIDs = _.filter(C2TJSON, function(row){
					return row.course_ID === courseID;
				});

				var tutorToAdd;
				$.each(tutorIDs, function (i, tutorID){
					tutorToAdd = _.find(localTutorsJSON, function(tutorObject){
						return tutorObject.id === tutorID.tutor_ID;
					});
					filteredTutorJSON.push(tutorToAdd);
				});
			}
			filteredTutorJSON = _.sortBy(filteredTutorJSON, 'first_name');
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
		addthisevent.settings({
			css        : false,
			outlook    : {show:true, text:"Outlook"},
			google     : {show:true, text:"Google"},
			yahoo      : {show:true, text:"Yahoo"},
			outlookcom : {show:true, text:"Outlook.com"},
			appleical  : {show:true, text:"Apple"},
			dropdown   : {order:"appleical,google,outlook,outlookcom,yahoo"}
		});
	});

})( jQuery );
