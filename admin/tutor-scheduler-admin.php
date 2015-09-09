<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/admin
 * @author     Your Name <email@example.com>
 */
class Tutor_Scheduler_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The slug name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $top_level_slug    The slug name of this plugin.
	 */
	private $top_level_slug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name,
									$version,
									$top_level_slug,
									$student_slug,
									$courses_slug,
									$tutor_table_name,
									$courses_table_name,
									$C2T_table_name,
									$events_table_name, 
									$booked_events_table_name 
								) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->top_level_slug = $top_level_slug;
		$this->student_slug = $student_slug;
		$this->courses_slug = $courses_slug;
		$this->tutor_table_name = $tutor_table_name;
		$this->courses_table_name = $courses_table_name;
		$this->C2T_table_name = $C2T_table_name;
		$this->events_table_name = $events_table_name;
		$this->error_message = '';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tutor-scheduler-admin.css', array(), $this->version, 'all' );
		//Bootstrap
		// wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		//FullCalendar
		wp_enqueue_style( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'css/full-calendar.min.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//Moment.js
		wp_enqueue_script( 'moment', plugin_dir_url( __FILE__ ) . 'js/libs/moment.min.js', array(), '2.10.3', false );
		//Bootstrap
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/libs/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		//FullCalendar
		wp_enqueue_script( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'js/libs/full-calendar.min.js', array( 'jquery', 'moment' ), $this->version, false );
		//Underscore
		wp_enqueue_script( 'underscore', plugin_dir_url( __FILE__ ) . 'js/libs/underscore.min.js', array(), '1.8.3', false );
		//Plugin functions
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tutor-scheduler-admin.js', array( 'jquery', 'moment', 'bootstrap', 'fullcalendar' ), $this->version, false );
		
		wp_localize_script( $this->plugin_name, 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
	}


	public function load_top_level_display(){

		if (!include_once 'partials/top-dashboard-display.php'){
			echo $this->get_error_message();
		}

	}



	public function load_manage_courses_page(){

		require_once 'partials/courses-manager/courses-manager.php';
		$coursesManager = new CoursesManager($this->courses_table_name, $this->courses_slug);
		$coursesManager->run();
		
	}

	public function load_manage_students_page(){

		require_once 'partials/tutor-manager/tutor-manager.php';
		$tutorManager = new TutorManager($this->tutor_table_name, $this->student_slug, $this->courses_table_name, $this->C2T_table_name, $this->events_table_name);
		$tutorManager->run();
		
	}

	/**
	 * Build the custom menu for the admin menu bar.
	 * 
	 * @since    1.0.0    Build the custom menu for the admin menu bar.
	 */
	public function register_parent_custom_menu(){
		/**
		 * This function adds the menu to the worpress dashboard.
		 * 
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		add_menu_page( 
			'Tutor Appointment Scheduler',
			'LCAE Tutor Scheduler',
			'read',
			$this->top_level_slug,
			array( $this, 'load_top_level_display' ),
			'dashicons-calendar-alt',
			null
		);

	}

	/**
	 * Build the custom menu for the admin menu bar.
	 * 
	 * @since    1.0.0    Build the custom menu for the admin menu bar.
	 */
	public function register_courses_submenu(){
		
		add_submenu_page( 
			$this->top_level_slug,
			'Manage Courses',
			'Manage Courses',
			'read',
			$this->courses_slug,
			array( $this, 'load_manage_courses_page' ) 
		);
	
	}

	/**
	 * Build the custom menu for the admin menu bar.
	 * 
	 * @since    1.0.0    Build the custom menu for the admin menu bar.
	 */
	public function register_students_submenu(){
		
		add_submenu_page( 
			$this->top_level_slug,
			'Manage Students',
			'Manage Students',
			'read',
			$this->student_slug,		
			array( $this, 'load_manage_students_page' )
 		);
	
	}

	public function get_error_message(){
			$this->error_message .= '<div class="wrap bootstrap-wpadmin">';
			$this->error_message .= 	'<div class="alert alert-danger" role="alert">Error: Something went wrong</div>';
			$this->error_message .= '</div>';
			return $this->error_message;
	}



	public function getUpdateMessage($updateMessage, $insertSuccess){
		if ($insertSuccess){
			$updateMessage .= '<div class="alert alert-success" role="alert">';
			$updateMessage .= 	'Success: All updates have been made successfully!';
			$updateMessage .= '</div>';
		}else{
			$updateMessage .= '<div class="alert alert-danger" role="alert">';
			$updateMessage .= 	'Error: There was a problem inserting the courses into the table.';
			$updateMessage .= '</div>';
		}
		return $updateMessage;
	}

	public function update_tutor_information() {
		global $wpdb;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "update_tutor_information")) {
			exit("No naughty business please");
		}

		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$result = json_encode($result);
			echo $result;
		}
		else {
			header("Location: ".$_SERVER["HTTP_REFERER"]);
		}

		die();
	}


	/**
	 * [get_tutor_courses description]
	 * @return 	array|boolean return array of tutor courses on success. Else, return false.
	 */
	public function get_tutor_courses(){
		global $wpdb;

 		// echo '<script type="text/javascript">console.log("Courses table name =  ' . $this->courses_table_name . '");</script>';
		
		$query = "
			SELECT *
			FROM " . $this->courses_table_name . "
			ORDER BY name
		";

		$courses = $wpdb->get_results($query);

		return json_encode($courses);
	}

	public function get_C2T() {
		global $wpdb;
		
		$query = "
			SELECT *
			FROM " . $this->C2T_table_name . "
			ORDER BY id
			";

		$C2T = $wpdb->get_results($query);

		return json_encode($C2T);
	}

	/**
	 * [get_C2T description]
	 * @return [type] [description]
	 */
	// public function get_events($eventID = -1) {
	// 	global $wpdb;
		
	// 	$query = "
	// 			SELECT *
	// 			FROM " . $this->events_table_name . "
	// 			WHERE date_taken = 0
	// 			";
		

	// 	$events = $wpdb->get_results($query);

	// 	return json_encode($events);
	// }

}
