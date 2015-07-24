<?php 
	/**
	* 
	*/
	class TutorManager extends Tutor_Scheduler_Admin
	{
		
		function __construct($tutor_table_name, $tutor_slug, $courses_table_name){
			$this->tutor_table_name = $tutor_table_name;
			$this->tutor_slug = $tutor_slug;
			$this->courses_table_name = $courses_table_name;
		}
		public function run(){
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			echo var_dump($_POST);
			if (count($_POST) > 0){
				$insertSuccess = $this->executePostRequest();
				$updateMessage = $this->getUpdateMessage($updateMessage, $insertSuccess);
			}

			//Grab the students
			$students = json_decode($this->get_tutor_students(), true);
			$courses = json_decode($this->get_tutor_courses(), true);

			require_once 'manage-students-display.php';
		}

		public function executePostRequest(){

			//Check and get type from URL
			$insertSuccess = true;
			$type = isset($_GET['type']) ? $_GET['type'] : '';

			//Check if we are adding a student
			if (strcmp($type, 'add') === 0) {
				$insertSuccess = $this->add_student();
			}
		}

		public function add_student(){
			global $wpdb;

			//Default information for table query
			$insertSuccess = true;
			$table = $this->tutor_table_name;
			$format = array('%s', '%s', '%s', '%s', '%s', '%s');
			$date_added = date('Y-m-d H:i:s');

			//Reverse the POST data so that we can remove information from it in O(1)
			$postReversed = array_reverse($_POST, true);

			//Get all variables from form
			$firstName = array_pop($postReversed);
			$lastName = array_pop($postReversed);
			$email = array_pop($postReversed);
			$major = array_pop($postReversed);
			$classification = array_pop($postReversed);
			$program = array_pop($postReversed);
			$courseArray = array();
			while (count($postReversed) > 0) {
				
				array_push($courseArray, array_pop($postReversed));
			}

			//Send all the data to the student table
			$data = array($firstName,
						 	$lastName,
						 	$email,
						 	$major,
						 	$classification,
						 	$program,
						 	$courseArray,
						 	$date_added
						);
			return $insertSuccess;
		}

		public function coursesToString($courses){
			$returnString = '';
			$index = 0;
			foreach ($courses as $course) {
				if($index % 4 == 0){
					$returnString .= "<tr>";
				}				
				$returnString .= '<td class="course-highlight">';
					$returnString .= '<label style="display: block;">';
						$returnString .= '<input name="'.$course["id"].'" value="'.$course["name"].'" class="course-highlight-checkbox" type="checkbox"> ' . $course["name"];
					$returnString .= '</label>';
				$returnString .= '</td>';
				if($index % 4 == 3){
					$returnString .= "</tr>";
				}	
				$index += 1;
			}
			if($index % 4 != 3){
				$returnString .= "</tr>";
			}	
			return $returnString;
			 
		}

		public function studentsToString($students){
/**
 * This needs work!
 * 
 */

			// $studentsString = '';
			// foreach ($students as $student) {
			// 	// var_dump($student);
			// 	$studentsString .= "<tr>";
			// 		$studentsString .= "<td>" . $student["name"] . "</td>";
			// 		$studentsString .= "<td>" . $student["date_added"] . "</td>";
			// 		$studentsString .= "<td>" . $student["major"] . "</td>";
			// 		$studentsString .= '<td><button class="btn btn-xs btn-danger student-remove" data-name="' . $student["name"] . '" data-studentID="' . $student["id"] . '">X</button></td>';
			// 	$studentsString .= "</tr>";
			// }

			return $studentsString;
		}

		public function get_tutor_students(){
			global $wpdb;

			
			$query = "
				SELECT *
				FROM " . $this->tutor_table_name . "
				ORDER BY name
			";

			$tutors = $wpdb->get_results($query);

			return json_encode($tutors);
		}
	}
 ?>
