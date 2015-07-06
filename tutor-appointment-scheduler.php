<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ddce.utexas.edu/academiccenter/gateway-scholars/
 * @since             1.0.0
 * @package           Tutor Appointment Scheduler
 *
 * @wordpress-plugin
 * Plugin Name:       Tutor Appointment Scheduler
 * Plugin URI:        https://github.com/AaronLlanos/tutor-scheduler-plugin.git
 * Description:       This plugin is proprietery software used by the Longhorn Center for Academic Excellence to schedule tutors of various subjects within the office.
 * Version:           1.0.0
 * Author:            Aaron Llanos
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       Tutor Appointment Scheduler
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_tutor_scheduler() {

	require_once plugin_dir_path( __FILE__ ) . 'includes/tutor-scheduler-activator.php';
	Tutor_Scheduler_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/tutor-scheduler-deactivator.php
 */
function deactivate_tutor_scheduler() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/tutor-scheduler-deactivator.php';
	Tutor_Scheduler_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tutor_scheduler' );
register_deactivation_hook( __FILE__, 'deactivate_tutor_scheduler' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/tutor-scheduler.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tutor_scheduler() {

	$plugin = new Tutor_Scheduler();
	$plugin->run();

}
run_tutor_scheduler();
