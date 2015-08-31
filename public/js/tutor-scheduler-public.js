(function( $ ) {
	'use strict';

	var filteredEventJSON = [];

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
			var updatedButtons = $(".addthisevent-drop").children().last();
			$(".addthisevent-drop").html("");
			$(".addthisevent-drop").html(updatedButtons);
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
		ajaxSuccess: function (argument) {
			$(".modal-success").addClass("bg-success");
			$(".before-ajax-request").addClass("hidden");
			$(".after-ajax-success").removeClass("hidden");

		},
		ajaxError: function (argument) {
			$(".modal-success").addClass("bg-danger");
		},
		loadBindings: function () {
			var self = this;

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
			$("#confirm-appointment").submit(function(e){
				e.preventDefault();
				var confirmationForm = $("#confirm-appointment");
				var loadingSpinner = $(".loading-spinner");
				confirmationForm.find("input").attr("disabled", "");
				loadingSpinner.removeClass("hidden");

				$.ajax({
					type: "post",
					dataType: "json",
					url: myAjax.ajaxurl,
					data : {
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
						if(resp.type == "success") {
							self.ajaxSuccess(resp.event_id);
						}
						else {
							self.ajaxError(resp.message);
						}
					},
					error: function ( jqXHR, textStatus, errorThrown) {
						// body...
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						self.ajaxError(textStatus);
					},
					complete: function ( jqXHR, textStatus ) {
						loadingSpinner.addClass("hidden");
						confirmationForm.find("input").removeAttr("disabled");
						$("#fullcalendar-frontend").fullCalendar('refetchEvents');
					}
				});
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
		addthisevent.settings({
			license    : "replace-with-your-licensekey",
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
