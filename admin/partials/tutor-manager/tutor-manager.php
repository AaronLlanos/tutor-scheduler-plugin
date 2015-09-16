<?php 
	/**
	* 
	*/
	class TutorManager extends Tutor_Scheduler_Admin
	{
		
		public function __construct($tutor_table_name, $tutor_slug, $courses_table_name, $C2T_table_name, $events_table_name){
			$this->tutor_table_name = $tutor_table_name;
			$this->tutor_slug = $tutor_slug;
			$this->courses_table_name = $courses_table_name;
			$this->C2T_table_name = $C2T_table_name;
			$this->events_table_name = $events_table_name;
		}
		public function run(){
			global $wpdb;
			//Check for admin priveldges
			if ( !current_user_can( 'read' ) )  {
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

			$tutorJSON = $this->get_tutor_students();
			$coursesJSON = $this->get_tutor_courses();
			$C2TJSON = $this->get_C2T();

			echo 	'<script type="text/javascript">var tutorJSON = '.$tutorJSON.';
													var coursesJSON = '.$coursesJSON.';
													var C2TJSON = '.$C2TJSON.';
					</script>';

			require_once 'manage-students-display.php';

		}

		public function executePostRequest(){
			global $wpdb;
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
			else if (strcmp($type, 'remove') === 0) {
				$studentID = $_POST["student_id"];
				if (!$wpdb->delete( $this->tutor_table_name, array('id' => $_POST['student_id']) )) {
					return false;
				}
				/**
				 * Should email all students who have an appointment with this tutor!!!!!!!!
				 */
					
				/**
				 *
				 * Should decrement course tutor count for each course this tutor was apart of. 
				 */
				return $this->updateCourses($studentID, 'remove') && $this->updateSchedule($studentID, 'remove');
				/**
				 * Should remove all events tied to this tutor
				 */
				;
			}

			return $insertSuccess;
		}

		/**
		 * Properly count how many courses in the array. This function 
		 * takes into account that explode() may return count(array) = 1 even though an 
		 * arrray is empty.
		 * @param  [type] $courses [description]
		 * @return [type]          [description]
		 */
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
		public function updateCourses($studentID, $updateType = 'add'){
			global $wpdb;

			if (!$studentID) {
				return false;
			}

			//Update C2T table based on $studentID.
			$courseArray = array();
			$courseSQL = false;
			$courseRows = array();
			$table = $wpdb->prefix . 'tutor_scheduler_C2T';

			if (strcmp($updateType, 'remove') == 0) {
				//Get all the ID's of courses that are associated with this tutor
				$courseSQL = '
								SELECT *
								FROM ' . $table .'
								WHERE tutor_ID = ' . $studentID;

				$courseRows = $wpdb->get_results($courseSQL);
				foreach ($courseRows as $row) {
					// echo $row;
					array_push($courseArray, $row->course_ID);
				}

				//Then delete it.
				$wpdb->delete($table, array('tutor_ID' => $studentID), array('%d'));
				
			}else{
				//Since we are in the add section, get the array of courses to update
				if ($this->getCourseCount($_POST["courses"]) == 0) {
					return true;
				}
				$courseArray = explode(",", $_POST["courses"]);
			}
			

			$format = array('%d', '%d');
			foreach ($courseArray as $courseID) {
				$courseData = array('course_ID' => $courseID, 'tutor_ID' => $studentID);
				if (strcmp($updateType, 'add') == 0) {
					if (!$wpdb->insert( $table, $courseData, $format )) {
				 		return false;
					}
				}
				//Update course tutor count
				$tutorCountQuery = 'SELECT tutor_count FROM '. $this->courses_table_name . ' WHERE id = ' . $courseID;
				$tutorCount = $wpdb->get_var($tutorCountQuery);
				if (strcmp($updateType, 'add') == 0) {
					$tutorCount += 1;
				}else{
					$tutorCount -= 1;
				}
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
		public function updateSchedule($studentID, $updateType = 'add'){
			global $wpdb;
			//Add dates to table
			$events_table_name = $wpdb->prefix . 'tutor_scheduler_events';

			if (strcmp($updateType, 'add') == 0) {
				$events = explode(", ", $_POST["schedule"]);
				$scheduleSQLFormat = array("%d", "%s", "%s", "%s", "%d", "%d");
				$eventObject;

				foreach ($events as $eventObjectString){
					$eventObj = json_decode(stripslashes($eventObjectString));
					$scheduleData = array(
										'tutor_ID' => $studentID,
										'title' => $eventObj->title,
										'start' => $eventObj->start,
										'end' => $eventObj->end,
										'parent_ID' => $eventObj->id,
										'date_taken' => 0
									 );

					if (!$wpdb->insert($events_table_name, $scheduleData, $scheduleSQLFormat)) {
						return false;
					}

				}
			}else{
				//Remove the events from the database
				$wpdb->delete($events_table_name, array('tutor_ID' => $studentID), array('%d'));
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
					$studentsString .= '<td><button class="btn btn-xs btn-danger student-remove" data-name="' . $student["first_name"] . ' ' . $student["last_name"] . '" data-tutorID="'.$student["id"].'">X</a></td>';
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
