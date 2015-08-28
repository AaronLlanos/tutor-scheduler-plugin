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
			$updateMessage = '';
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
				$studentID = $this->addStudent();
				$insertCourse = $this->updateCourses($studentID);
				$updateSchedule = $this->updateSchedule($studentID);

				return $insertCourse && $updateSchedule;
			}

			return $insertSuccess;
		}

		public function getCourseCount( $courses ){

			$courseArray = explode(",", $courses);
			$courseArrayCount = count($courseArray);
			if ($courseArrayCount == 1) {
				if (strcmp($courseArray[0], "") == 0)
					return 0;
			}

			return $courseArrayCount;
		}

		/**
		 * @function addStudent() adds a student to the database.
		 * @return int|false Returns unique student ID if successful. Otherwise false.
		 */
		public function addStudent(){
			global $wpdb;

			//Default information for table query
			$insertSuccess = true;
			$table = $this->tutor_table_name;
			$format = array('%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s');
			$date_added = date('Y-m-d H:i:s');

			//Get all variables from form
			$firstName = $_POST["first-name"];
			$lastName = $_POST["last-name"];
			$email = $_POST["email"];
			$major = $_POST["major"];
			$classification = $_POST["classification"];
			$program = $_POST["program"];
			$coursesCount = $this->getCourseCount($_POST["courses"]);

			//Send all the data to the student table
			$tutorData = array( 'first_name' => $firstName,
						 	'last_name' => $lastName,
						 	'email' => $email,
						 	'major' => $major,
						 	'classification' => $classification,
						 	'program' => $program,
						 	'course_count' => $coursesCount,
						 	'date_added' => $date_added
						);

			//Insert into table. Get the ID to update the C2T table
			if (!$wpdb->insert( $table, $tutorData, $format )) {
		 		return false;
			}
			else {
				//Error check
				// Unique ID of newly inserted schedule.
				// Returns false if the last insertion was not completed properly 	
				return $wpdb->insert_id;
			}
				
		}

		/**
		 * Update courses for tutor for join table
		 * @param  int|false $studentID False if student not inserted (see addStudent()). Int
		 * @return bool            return true or false on success or failure respectively.
		 */
		public function updateCourses($studentID){
			global $wpdb;

			if (!$studentID) {
				return false;
			}

			if ($this->getCourseCount($_POST["courses"]) == 0) {
				return true;
			}

			$courseArray = explode(",", $_POST["courses"]);

			//Update C2T table based on $studentID.
			$table = $wpdb->prefix . 'tutor_scheduler_C2T';
			
			$format = array('%d', '%d');
			foreach ($courseArray as $courseID) {
				$courseData = array('course_id' => $courseID, 'tutor_id' => $studentID);
				if (!$wpdb->insert( $table, $courseData, $format )) {
			 		return false;
				}
				//Update course tutor count
				$tutorCountQuery = 'SELECT tutor_count FROM '. $this->courses_table_name . ' WHERE id = ' . $courseID;
				$tutorCount = $wpdb->get_var($tutorCountQuery);
				$tutorCount += 1;
				$wpdb->update(
								$this->courses_table_name, 
								array('tutor_count' => $tutorCount),
								array('id' => $courseID)
							 );
			}
			return true;
		}

		/**
		 * Update schedule for tutor
		 * @param  int|false $studentID False if student not inserted (see addStudent()). Int
		 * @return bool            return true or false on success or failure respectively.
		 */
		public function updateSchedule($studentID){
			global $wpdb;
			//Add dates to table
			$events_table_name = $wpdb->prefix . 'tutor_scheduler_event';

			$events = explode(", ", $_POST["schedule"]);
			$scheduleSQLFormat = array("%d", "%s", "%s", "%s", "%d", "%d");
			$eventObject;

			foreach ($events as $eventObjectString){
				$eventObj = json_decode(stripslashes($eventObjectString));
				$scheduleData = array(
									'tutor_ID' => $studentID,
									'title' => $eventObj->{'title'},
									'start' => $eventObj->{'start'},
									'end' => $eventObj->{'end'},
									'parent_ID' => $eventObj->{'id'},
									'date_taken' => 0
								 );

				if (!$wpdb->insert($events_table_name, $scheduleData, $scheduleSQLFormat)) {
					return false;
				}

			}
			return true;			
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
					$studentsString .= "<td>" . $student["classification"] . "</td>";
					$studentsString .= "<td>" . $student["course_count"] . "</td>";
					$studentsString .= "<td>" . $student["date_added"] . "</td>";
					$studentsString .= '<td><button class="btn btn-xs btn-danger student-remove" data-name="' . $student["first_name"] . ' ' . $student["last_name"] . '" data-studentID="' . $student["id"] . '">X</button></td>';
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
