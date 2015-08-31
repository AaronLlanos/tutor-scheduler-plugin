<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/public
 * @author     Your Name <email@example.com>
 */
class Tutor_Scheduler_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( 
									$plugin_name,
									$version,
									$courses_table_name,
									$tutor_table_name,
									$C2T_table_name,
									$events_table_name 
								) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->courses_table_name = $courses_table_name;
		$this->tutor_table_name = $tutor_table_name;
		$this->C2T_table_name = $C2T_table_name;
		$this->events_table_name = $events_table_name;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tutor-scheduler-public.css', array(), $this->version, 'all' );

		//Bootstrap
		wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/libs/bootstrap.min.css', array(), $this->version, 'all' );
		//FullCalendar
		wp_enqueue_style( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'css/libs/full-calendar.min.css', array(), $this->version, 'all' );
		//AddThisEvent
		wp_enqueue_style( 'add-this-event', plugin_dir_url( __FILE__ ) . 'css/libs/addthisevent.theme5.css', array(), '1.6.0', 'all' );
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/libs/bootstrap.min.js', array( 'jquery' ), '3.3.5', false );
		//FullCalendar
		wp_enqueue_script( 'fullcalendar', plugin_dir_url( __FILE__ ) . 'js/libs/full-calendar.min.js', array( 'jquery', 'moment' ), '2.3.2', false );
		//underscore
		wp_enqueue_script( 'underscore', plugin_dir_url( __FILE__ ) . 'js/libs/underscore.min.js', array(), '1.8.3', false );
		//AddThisEvent
		wp_enqueue_script( 'add-this-event', plugin_dir_url( __FILE__ ) . 'js/libs/add-this-event.min.js', array(), '1.6.0', false );
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tutor-scheduler-public.js', array( 'jquery', 'underscore', 'fullcalendar', 'add-this-event' ), $this->version, false );
		
		wp_localize_script( $this->plugin_name, 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

	}

	public function send_confirmation_email($tutor_ID) {

		$tutor = json_decode($this->get_tutors($tutor_ID));

		$tutorEmail = $tutor[0]->{"email"};
		$tutorSubject = $_POST["tutor_subject"];
		$eventDate = $_POST["event_date"];
		// multiple recipients
		$to  = $_POST["email"] . ', '; // note the comma
		$to .= $tutorEmail;

		// subject
		$subject = 'LCAE - Tutor Appointment Confirmation';

		$tutorName = $tutor[0]->{"first_name"}.' '.$tutor[0]->{"last_name"};
		$tuteeName = $_POST["first_name"].' '.$_POST["last_name"];
		$tuteeEmail = $_POST["email"];
		$noteToTutor = $_POST["note_to_tutor"];

		// message
		require_once 'partials/email-controller.php';
		$message = Email_Controller::getMessage(
							$eventDate,
							$tutorSubject,
							$tutorName,
							$tutorEmail,
							$tuteeName,
							$tuteeEmail,
							$noteToTutor
						);

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'To: '.$tuteeName .' <'.$tuteeEmail.'>, '. $tutorName.' <'.$tutorEmail.'>'."\r\n";
		$headers .= 'From: LCAE <lcae@austin.utexas.edu>'."\r\n";
		// $headers .= 'Cc: birthdayarchive@example.com'."\r\n";
		// $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);
	}

	public function confirm_tas_appointment() {
		global $wpdb;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "confirm_tas_appointment")) {
			exit("No naughty business please");
		}

		$sql = 'SELECT date_taken FROM '.$this->events_table_name.' WHERE id = '.$_POST["event_id"];
		//Update the date_taken flag on this specific appointment
		if (!$wpdb->update($this->events_table_name, array('date_taken' => 1), array('id' => $_REQUEST["event_id"]) )
			 || !$wpdb->get_var($sql) != 0) {
			$result["type"] = "error";

		}else{
			$result["type"] = "success";
			//Send a confirmation email to student
			$this->send_confirmation_email($_REQUEST["tutor_id"]);	
		}

		$result["event_id"] = $_REQUEST["event_id"];




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
	 * [get_courses description]
	 * @return [type] [description]
	 */
	public function get_courses(){
		global $wpdb;

 		// echo '<script type="text/javascript">console.log("Courses table name =  ' . $this->courses_table_name . '");</script>';
		
		$query = "
			SELECT id, name
			FROM " . $this->courses_table_name . "
			ORDER BY id
		";

		$courses = $wpdb->get_results($query);

		return json_encode($courses);
	}

	/**
	 * [get_courses description]
	 * @return [type] [description]
	 */
	public function get_tutors($tutorID = -1){
		global $wpdb;
		if ($tutorID == -1) {
			$query = "
				SELECT id, first_name, last_name
				FROM " . $this->tutor_table_name . "
				ORDER BY id
			";
		}else{
			$query = "
				SELECT *
				FROM " . $this->tutor_table_name . "
				WHERE id = " . $tutorID . "
			";
		}	
		

		$tutors = $wpdb->get_results($query);

		return json_encode($tutors);
	}

	/**
	 * [get_C2T description]
	 * @return [type] [description]
	 */
	public function get_C2T() {
		global $wpdb;
		
		$query = "
			SELECT course_ID, tutor_ID
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
	public function get_events($eventID = -1) {
		global $wpdb;
		
		$query = "
				SELECT *
				FROM " . $this->events_table_name . "
				WHERE date_taken = 0
				";
		

		$events = $wpdb->get_results($query);

		return json_encode($events);
	}


	/**
	 * Hook that will load the shortcode which loads the front-end of the site
	 */
	public function run( $atts ) {

		$courses = $this->get_courses();		
		$tutors = $this->get_tutors();		
		$C2T = $this->get_C2T();		
		$events = $this->get_events();

		echo 	'<script type="text/javascript">
					var coursesJSON = ' . $courses . ';
					var tutorsJSON = ' . $tutors . ';
					var C2TJSON = ' . $C2T . ';
					var eventJSON = ' . $events . ';
				</script>';

		if (!require_once 'partials/tutor-appointment-scheduler-display.php') {
			return 'Error failed to load the Calendar';
		}		
	}

}
