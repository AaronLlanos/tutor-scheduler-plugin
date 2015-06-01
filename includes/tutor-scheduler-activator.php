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
		
	}

}
