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

		$tsp_db_version = '1.0';

		$courses_table_name = $wpdb->prefix . 'tutor_scheduler_courses';
		$tutors_table_name = $wpdb->prefix . 'tutor_scheduler_tutors';
		$schedule_table_name = $wpdb->prefix . 'tutors_scheduler_schedules';
		$date_table_name = 	$wpdb->prefix . 'tutors_scheduler_dates';
		$course2Tutor_table_name = 	$wpdb->prefix . 'tutors_scheduler_C2T';

		$charset_collate = $wpdb->get_charset_collate();

		$courses_sql = "CREATE TABLE $courses_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			date_added  datetime NOT NULL,
			name  tinytext DEFAULT '' NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $courses_sql );

		$tutors_sql = "CREATE TABLE $tutors_table_name (
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

		$schedule_sql = "CREATE TABLE $schedule_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			tutor_ID  mediumint(9) NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $schedule_sql );

		$date_sql = "CREATE TABLE $date_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			schedule_ID  mediumint(9) NOT NULL,
			tutor_ID  mediumint(9) NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $date_sql );

		$course2Tutor_sql = "CREATE TABLE $course2Tutor_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			course_ID  mediumint(9) NOT NULL,
			tutor_ID  mediumint(9) NOT NULL,
			PRIMARY KEY  id (id)
		); $charset_collate";
		dbDelta( $course2Tutor_sql );

 		// echo $wpdb->last_error;
 		// echo $wpdb->last_error;

		add_option( 'tsp_db_version', $tsp_db_version );
	}

}
