<?php 
	/**
	* 
	*/
	class Tutor_Scheduler_Table_Installer
	{

		/**
		 * Returns true if all appropriate tables installed. Else, return false.
		 * @return boolean Returns true if all appropriate tables installed. Else, return false.
		 */
		public function check_database($courses_table_name, $tutors_table_name){
			global $wpdb;

			if($wpdb->get_var("SHOW TABLES LIKE '$courses_table_name'") != $courses_table_name) {
			    return false;
			}
			if($wpdb->get_var("SHOW TABLES LIKE '$tutors_table_name'") != $tutors_table_name) {
			    return false;
			}

			return true;
		}

		public function install_tables($courses_table_name, $tutors_table_name){

			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			$courses_sql = "CREATE TABLE $courses_table_name (
			  id mediumint(9) NOT NULL AUTO_INCREMENT,
			  date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  name tinytext NOT NULL,
			  tutor_count mediumint(9) NOT NULL
			  UNIQUE KEY id (id)
			) $charset_collate;";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $courses_sql );

		}

	}
 ?>