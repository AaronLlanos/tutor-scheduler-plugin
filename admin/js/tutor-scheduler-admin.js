
/**
 * Functions for adding courses to student scheduler
 */
var CourseManager = {
	tempCourses: [],
	validateCourses: function(){
		//Should make sure there are no duplicates.
		return true;
	},
	addCourseFormat: function(inputValue, addVal){
		if (addVal){
			return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="add" name="'+inputValue+'">';
		}else{
			return '<input id="'+inputValue+'" type="text" class="form-control hidden" value="remove" name="'+inputValue+'">';
		}
	}
};

(function( $ ) {
	'use strict';

	$( window ).load(function(){

		/**
		 * Course Manager Functions!!!!!!
		 */
		$("#add-course").keypress(function(event){
			if ( event.which == 13 ) {
				var inputValue = $("#add-course").val();
				CourseManager.validateCourses(inputValue);
				$("#temp-course-table").prepend(CourseManager.addCourseFormat(inputValue, true));
				$("#temp-course-table").prepend('<tr class="success"><td>'+inputValue+'</td></tr>');
				$("#add-course").val("");
			}
			
		});
		$(".course-remove").on("click", function(){
			var confirmedVal = confirm("Are you sure you want to remove "+$(this).attr("data-name")+" from the table?");
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
