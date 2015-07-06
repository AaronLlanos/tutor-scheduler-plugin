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
		$wpdb->show_errors( true );

		$tsp_db_version = '1.0';

		$courses_table_name = $wpdb->prefix . 'tutor_scheduler_courses';
		$tutors_table_name = $wpdb->prefix . 'tutor_scheduler_tutors';
		
		$charset_collate = $wpdb->get_charset_collate();

		$courses_sql = "CREATE TABLE $courses_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			date_added  datetime NOT NULL,
			name  tinytext DEFAULT '' NOT NULL,
			tutor_count  mediumint(9) DEFAULT 0 NOT NULL,
			PRIMARY KEY  id (id)
		);";

		$tutors_sql = "CREATE TABLE $tutors_table_name (
			id  mediumint(9) NOT NULL AUTO_INCREMENT,
			date_added  datetime NOT NULL,
			name  tinytext NOT NULL,
			tutor_count  mediumint(9) NOT NULL,
			PRIMARY KEY  id (id)
		);";

		dbDelta( $courses_sql );
 		// echo $wpdb->last_error;
		dbDelta( $tutors_sql );
 	// 	echo $wpdb->last_error;

		add_option( 'tsp_db_version', $tsp_db_version );
	}

}
