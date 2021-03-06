<?php 
	/**
	* 
	*/
	class CoursesManager extends Tutor_Scheduler_Admin
	{
		
		function __construct($courses_table_name, $courses_slug)
		{
			$this->courses_table_name = $courses_table_name;
			$this->courses_slug = $courses_slug;
		}

		public function run()
		{
			if ( !current_user_can( 'read' ) )  {
				wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
			}
			$updateMessage = '';
			if (count($_POST) > 0){
				$insertSuccess = $this->executePostRequest();
				$updateMessage = $this->getUpdateMessage($updateMessage, $insertSuccess);
			}
			$courses = json_decode($this->get_tutor_courses(), true);
			require_once 'manage-courses-display.php';
		}

		public function executePostRequest() {	
			global $wpdb;	
			/**
			 * Track to see if there were any errors while inserting into table
			 * @var boolean
			 */
			$insertSuccess = true;
			$table = $this->courses_table_name;
			$format = array('%s', '%s', '%d' );
			$date_added = date('Y-m-d H:i:s');

			foreach ($_POST as $key => $value) {
				if ($value == "add"){
					$data = array( 'date_added' => $date_added, 'name' => str_replace('_', ' ', $key));

					//Error check
					if (!$wpdb->insert( $table, $data, $format )) {
				 		$insertSuccess = false;
					}
				}else{
					$data = array( 'ID' => $key );
					//Error check
					if (!$wpdb->delete( $table, $data ) ) {
				 		$insertSuccess = false;
					}
				}
			}

			return $insertSuccess;
		}

		public function coursesToString($courses){
			$coursesString = '';
			foreach ($courses as $course) {
				$coursesString .= "<tr>";
					$coursesString .= "<td>" . $course["name"] . "</td>";
					$coursesString .= "<td>" . $course["date_added"] . "</td>";
					$coursesString .= "<td>" . $course["tutor_count"] . "</td>";
					$coursesString .= '<td><button class="btn btn-xs btn-danger course-remove" data-name="' . $course["name"] . '" data-courseID="' . $course["id"] . '">X</button></td>';
				$coursesString .= "</tr>";
			}

			return $coursesString;
		}
	}
 ?>