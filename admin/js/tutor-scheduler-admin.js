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
			if (confirmedVal == true) {
				//Remove the course from the table
				$(this).parent().parent().addClass("danger");
				$("#temp-course-table").prepend(CourseManager.addCourseFormat($(this).attr("data-courseID"), false));
				$("#temp-course-table").prepend('<tr class="danger"><td>'+$(this).attr("data-name")+'</td></tr>');
			}
		});

		/**
		 * Course Tutor Functions!
		 */
		

	});

})( jQuery );
