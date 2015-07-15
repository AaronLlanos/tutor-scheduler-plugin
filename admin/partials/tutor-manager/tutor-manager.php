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
			# code...
		}

		public function coursesToString($courses){
			$returnString = '';
			$index = 0;
			foreach ($courses as $course) {
				if($index % 3 == 0){
					$returnString .= "<tr>";
				}				
				$returnString .= '<td>';
					$returnString .= '<label>';
						$returnString .= '<input type="checkbox" data-courseID="' . $course["id"] . '"> ' . $course["name"];
					$returnString .= '</label>';
				$returnString .= '</td>';
				if($index % 3 == 2){
					$returnString .= "</tr>";
				}	
				$index += 1;
			}
			if($index % 3 != 2){
				$returnString .= "</tr>";
			}	
			return $returnString;
			 
		}

		public function studentsToString($students){
			$studentsString = '';
			foreach ($students as $student) {
				// var_dump($student);
				$studentsString .= "<tr>";
					$studentsString .= "<td>" . $student["name"] . "</td>";
					$studentsString .= "<td>" . $student["date_added"] . "</td>";
					$studentsString .= "<td>" . $student["major"] . "</td>";
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
				ORDER BY name
			";

			$tutors = $wpdb->get_results($query);

			return json_encode($tutors);
		}
	}
 ?>