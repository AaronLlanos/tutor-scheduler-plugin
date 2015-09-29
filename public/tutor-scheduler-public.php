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
									$events_table_name, 
									$booked_events_table_name 
								) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->courses_table_name = $courses_table_name;
		$this->tutor_table_name = $tutor_table_name;
		$this->C2T_table_name = $C2T_table_name;
		$this->events_table_name = $events_table_name;
		$this->booked_events_table_name = $booked_events_table_name;

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
		// wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ) . 'css/libs/bootstrap.min.css', array(), $this->version, 'all' );
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

	public function send_confirmation_email($tutor_ID, $bookedID) {

		$tutor = json_decode($this->get_tutors($tutor_ID));

		$tutorEmail = $tutor[0]->{"email"};
		$tutorSubject = $_POST["tutor_subject"];
		$eventDate = $_POST["event_date"];
		// multiple recipients
		$to  = $_POST["email"] . ', '; // note the comma
		$to .= $tutorEmail;

		// subject
		$subject = 'LCAE - Tutor Appointment Booking Confirmation';

		$tutorName = $tutor[0]->{"first_name"}.' '.$tutor[0]->{"last_name"};
		$tuteeName = $_POST["first_name"].' '.$_POST["last_name"];
		$tuteeEmail = $_POST["email"];
		$noteToTutor = $_POST["note_to_tutor"];

		// Message
		require_once 'partials/email-controller.php';
		$message = Email_Controller::getSuccessMessage(
							$eventDate,
							$tutorSubject,
							$tutorName,
							$tutorEmail,
							$tuteeName,
							$tuteeEmail,
							$noteToTutor,
							$_SERVER["HTTP_REFERER"],
							$bookedID
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

	public function cancel_appointment($bookedID){
		global $wpdb;

		$response['success'] = true;
		// Get the information from the tables
		$bookedAppointmentSQL = 'SELECT * FROM '.$this->booked_events_table_name.' WHERE id = '.$bookedID;
		$booked_data_format = array('%d', '%d', '%s', '%s', '%s', '%s', '%d');
		$bookedAppointmentObject = $wpdb->get_row($bookedAppointmentSQL);
		$tutorInformationSQL = 'SELECT first_name, last_name, email FROM '.$this->tutor_table_name.' WHERE id = '.$bookedAppointmentObject->tutor_ID;
		$tutorObject = $wpdb->get_row($tutorInformationSQL);
		// If it is already cancelled, no need to resend the email.
		if ($bookedAppointmentObject->canceled == 0){
			if(!$wpdb->update($this->events_table_name, array('date_taken' => 0), array('id' => $bookedAppointmentObject->event_ID))
					|| !$wpdb->update($this->booked_events_table_name, array('canceled' => 1), array('id' => $bookedID))){
				$response['success'] = false;
				$response['message'] = 'Unable to connect to database. Please try again.';
			}
			$response['message'] = 'Successfully cancelled appointment #'.$bookedAppointmentObject->id.'. A confirmation email will be sent shortly.'; 
			// Send out the email!
			$to  = $bookedAppointmentObject->tutee_email . ', '; // note the comma
			$to .= $tutorObject->email;
			$subject = 'LCAE - Tutor Appointment Cancellation Confirmation';
			require_once 'partials/email-controller.php';
			$message = Email_Controller::getCancellationMessage(
								$bookedAppointmentObject->start,
								$bookedAppointmentObject->tutee_first_name,
								$bookedAppointmentObject->tutee_last_name,
								$bookedAppointmentObject->tutee_email,
								$tutorObject->first_name,
								$tutorObject->last_name,
								$tutorObject->email
							);
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'From: LCAE <lcae@austin.utexas.edu>'."\r\n";
			// $headers .= 'Cc: birthdayarchive@example.com'."\r\n";
			// $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

			// Mail it
			mail($to, $subject, $message, $headers);
		}
		$response['message'] = 'This appointment has already been cancelled. Thank you for trying again.';
		return $response;
	}

	public function confirm_tas_appointment() {
		global $wpdb;

		if ( !wp_verify_nonce( $_REQUEST['nonce'], "confirm_tas_appointment")) {
			exit("No naughty business please");
		}
		//Verify recapcha
		$rData = array(
			'secret' => '6LfCTQ0TAAAAADPjuc5P6nBzjdWnTEbIxsZZrxqU',
			'response' => $_REQUEST['recaptcha_response'],
			'remoteip' => $_SERVER['REMOTE_ADDR']
		);
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
				CURLOPT_POST => 1,
				CURLOPT_POSTFIELDS => $rData
		));
		$recaptchaResponse = curl_exec($curl);
		curl_close($curl);

		if($recaptchaResponse == false){
			$result["type"] = "error";
			$result["error_type"] = "recaptcha";
			$result["message"] = "Apparently Google's recaptcha thinks you are a robot. Please try again.";
		}else if(gettype($recaptchaResponse) == "object" && isset($recaptchaResponse->success)){
			if($recaptchaResponse->success == false){
				$result["type"] = "error";
				$result["error_type"] = "recaptcha";
				/**
				 * missing-input-secret		The secret parameter is missing.
				 * invalid-input-secret		The secret parameter is invalid or malformed.
				 * missing-input-response	The response parameter is missing.
				 * invalid-input-response	The response parameter is invalid or malformed.
				 */
				// $result["message"] = gettype($recaptchaResponse->success);
				switch ($recaptchaResponse->{'error-codes'}) {
					case 'missing-input-secret':
						$result["message"] = 'The secret parameter is missing.'; break;
					case 'invalid-input-secret':
						$result["message"] = 'The secret parameter is invalid or malformed.'; break;
					case 'missing-input-response':
						$result["message"] = 'The response parameter is missing.'; break;
					case 'invalid-input-response':
						$result["message"] = 'The response parameter is invalid or malformed.'; break;
					default:
						$result["message"] = 'Whatever.'; break;
				}
			}else if($recaptchaResponse->success == true){
				//Update the date_taken flag on this specific appointment
				$eventSql = 'SELECT date_taken, start FROM '.$this->events_table_name.' WHERE id = '.$_POST["event_id"];
				$eventObjectToUpdate = $wpdb->get_row($eventSql);
				//Check to make sure the flag is still 0 ex: RACE CONDITIONS!
				if ($eventObjectToUpdate->date_taken != 0) {
					$result["type"] = "error";
					$result["error_type"] = "race";
					$result["message"] = "This appointment appears to have already been booked. Updating calendar now...";
				}
				else if (!$wpdb->update($this->events_table_name, array('date_taken' => 1), array('id' => $_REQUEST["event_id"]) )) {
					$result["type"] = "error";
					$result["error_type"] = "db";
					$result["message"] = "Could not connect to the database. Please try again later.";
				}else{
					$result["type"] = "success";
					//Save to booked events
					$booked_data = array(
											'event_ID' => $_POST["event_id"],
											'tutor_ID' => $_REQUEST["tutor_id"],
											'start' => $eventObjectToUpdate->start,
											'tutee_first_name' => $_POST["first_name"],
											'tutee_last_name' => $_POST["last_name"],
											'tutee_email' => $_POST["email"],
											'canceled' => 0
										);
					$booked_data_format = array('%d', '%d', '%s', '%s', '%s', '%s', '%d');
					if ($wpdb->insert($this->booked_events_table_name, $booked_data, $booked_data_format)){
						//Send a confirmation email to student
						$this->send_confirmation_email($_REQUEST["tutor_id"], $wpdb->insert_id);
					}
				}
			}
		}else{
			$result["type"] = "error";
			$result["error_type"] = "recaptcha";
			$result["message"] = 'Man, something went wrong with recaptcha. I really dont know what to say.';
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
		// Boolean
		$cancelAppointment = (isset($_GET['action']) ? $_GET['action'] : false);
		$canceledAppointmentResponse = false;
		$bookedID = (isset($_GET['booked_ID']) ? $_GET['booked_ID'] : false);
		if (strcmp($cancelAppointment, 'cancel') === 0 && $bookedID != false){
			$canceledAppointmentResponse = $this->cancel_appointment($bookedID);
		}
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
