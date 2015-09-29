<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Tutor_Appointment_Scheduler
 * @subpackage Tutor_Appointment_Scheduler/includes
 * @author     Your Name <email@example.com>
 */
class Tutor_Scheduler_Activator {

	/**
	 * Activate all appropriate tables if none in $wpdb.
	 *
	 * This function will go through the $wpdb and check to see if the apprpriate tables are available. 
	 * This insures the plugin runs queries successfully later on.
	 *
	 * @since    1.0.0
	 */

	public static function activate() {
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		global $wpdb;
		global $tsp_db_version;
		// $wpdb->show_errors( true );

		$tsp_db_version = '1.1';

		$courses_table_name = $wpdb->prefix . 'tutor_scheduler_courses';
		$tutors_table_name = $wpdb->prefix . 'tutor_scheduler_tutors';
		$events_table_name = $wpdb->prefix . 'tutor_scheduler_events';
		$booked_events_table_name = $wpdb->prefix . 'tutor_scheduler_booked_events';
		$course2Tutor_table_name = 	$wpdb->prefix . 'tutor_scheduler_C2T';

		$charset_collate = $wpdb->get_charset_collate();

		$courses_sql = "CREATE TABLE IF NOT EXISTS $courses_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			date_added  datetime NOT NULL,
			tutor_count  mediumint(9) DEFAULT 0 NOT NULL,
			name  tinytext DEFAULT '' NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $courses_sql );

		$tutors_sql = "CREATE TABLE IF NOT EXISTS $tutors_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			first_name  tinytext NOT NULL,
			last_name  tinytext NOT NULL,
			email  tinytext NOT NULL,
			major  tinytext DEFAULT '' NOT NULL,
			classification  tinytext DEFAULT '' NOT NULL,
			program  tinytext DEFAULT '' NOT NULL,
			course_count mediumint(9) DEFAULT 0 NOT NULL,
			date_added  datetime NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $tutors_sql );

		$booked_event_sql = "CREATE TABLE IF NOT EXISTS $booked_events_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			event_ID  mediumint(9) NOT NULL,
			tutor_ID  mediumint(9) NOT NULL,
			start  datetime NOT NULL,
			tutee_first_name tinytext NOT NULL,
			tutee_last_name tinytext NOT NULL,
			tutee_email  tinytext NOT NULL,
			canceled  tinyint NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $booked_event_sql );

		$events_sql = "CREATE TABLE IF NOT EXISTS $events_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			parent_ID  mediumint(9) NOT NULL,
			tutor_ID  mediumint(9) NOT NULL,
			start  datetime NOT NULL,
			end  datetime NOT NULL,
			title  tinytext NOT NULL,
			date_taken  tinyint(1) DEFAULT 0 NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $events_sql );

		$course2Tutor_sql = "CREATE TABLE IF NOT EXISTS $course2Tutor_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			course_ID  mediumint(9) NOT NULL,
			tutor_ID  mediumint(9) NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $course2Tutor_sql );

 		// echo $wpdb->last_error;
 		// echo $wpdb->last_error;
 		/**
 		 * This will add or remove any columns from tables.
 		 */
 		$hasCanceled = $wpdb->get_row("SELECT * FROM ".$booked_events_table_name);
		//Add column if not present.
		if(!isset($hasCanceled->canceled)){
		    $addQuery = 'ALTER TABLE '.$booked_events_table_name.
 					' ADD canceled tinyint(4) DEFAULT 0 NOT NULL';
 			$wpdb->query($addQuery);
		}
 		

		add_option( 'tsp_db_version', $tsp_db_version );

		file_put_contents(dirname(__file__).'/error_activation.txt', ob_get_contents());
	}

}
