<?php 
	/**
	* 
	*/
	class TutorManager extends Tutor_Scheduler_Admin
	{
		
		public function __construct($tutor_table_name, $tutor_slug, $courses_table_name){
			$this->tutor_table_name = $tutor_table_name;
			$this->tutor_slug = $tutor_slug;
			$this->courses_table_name = $courses_table_name;
		}
		public function run(){
			//Check for admin priveldges
			if ( !current_user_can( 'manage_options' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			
			//Run POST data
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
			$insertSuccess = true;
			//Check and get type from URL
			$type = isset($_GET['type']) ? $_GET['type'] : '';

			//Check if we are adding a student
			if (strcmp($type, 'add') === 0) {
				$insertSuccess = $this->add_student();
			}

			return $insertSuccess;
		}

		public function add_student(){
			global $wpdb;

			//Default information for table query
			$insertSuccess = true;
			$table = $this->tutor_table_name;
			$format = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s');
			$date_added = date('Y-m-d H:i:s');

			//Get all variables from form
			$firstName = $_POST["first-name"];
			$lastName = $_POST["last-name"];
			$email = $_POST["email"];
			$major = $_POST["major"];
			$classification = $_POST["classification"];
			$program = $_POST["program"];
			$coursesCount = count(explode(",", $courseArray));

			//Add courses to DB.C2T

			//Add new tutor schedule to DB
			// $scheduleData = array('tutor_name' => , );
			$scheduleID = $wpdb->insert_id; //Unique ID of newly inserted schedule

			//Send all the data to the student table
			$tutorData = array( 'first_name' => $firstName,
						 	'last_name' => $lastName,
						 	'email' => $email,
						 	'major' => $major,
						 	'classification' => $classification,
						 	'program' => $program,
						 	'coursesCount' => $coursesCount,
						 	'date_added' => $date_added,
						 	'schedule' => $scheduleID
						);
			//Error check
			// $wpdb->show_errors(); //Debug!!
			if (!$wpdb->insert( $table, $data, $format )) {
				// $wpdb->print_error(); //Debug!
		 		$insertSuccess = false;
			}
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
						$returnString .= '<input class="course-highlight-checkbox" type="checkbox" data-courseID="'.$course["id"].'"> ' . $course["name"];
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

			$studentsString = '';
			foreach ($students as $student) {
				// var_dump($student);
				$studentsString .= "<tr>";
					$studentsString .= "<td>" . $student["first_name"] . "</td>";
					$studentsString .= "<td>" . $student["last_name"] . "</td>";
					$studentsString .= "<td>" . $student["email"] . "</td>";
					$studentsString .= "<td>" . $student["major"] . "</td>";
					$studentsString .= "<td>" . $student["coursesCount"] . "</td>";
					$studentsString .= '<td><button class="btn btn-xs btn-danger student-remove" data-name="' . $student["name"] . '" data-studentID="' . $student["id"] . '">X</button></td>';
				$studentsString .= "</tr>";
			}

			return $studentsString;
		}

		public function get_tutor_students(){
			global $wpdb;

			
			$query = "
				SELECT *
				FROM " . $this->tutor_table_name . "
				ORDER BY first_name
			";

			$tutors = $wpdb->get_results($query);

			return json_encode($tutors);
		}
	}
 ?>
