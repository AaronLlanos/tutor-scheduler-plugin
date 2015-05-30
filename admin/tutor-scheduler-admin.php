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
	public function __construct( $plugin_name, $version, $top_level_slug ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->top_level_slug = $top_level_slug;

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

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
		
		add_menu_page( 'Tutor Appointment Scheduler', 'LCAE Tutor Scheduler', 'manage_options', $this->top_level_slug, array($this, 'load_admin_page'), 'dashicons-calendar-alt' );
	}

	/**
	 * Build the custom menu for the admin menu bar.
	 * 
	 * @since    1.0.0    Build the custom menu for the admin menu bar.
	 */
	public function register_courses_submenu(){
		
		add_submenu_page( $this->top_level_slug, 'Manage Courses', 'Manage Courses', 'manage_options', 'tutor-scheduler-manage-courses', array($this, 'load_manage_courses_page') );
	
	}

	/**
	 * Build the custom menu for the admin menu bar.
	 * 
	 * @since    1.0.0    Build the custom menu for the admin menu bar.
	 */
	public function register_students_submenu(){
		
		add_submenu_page( $this->top_level_slug, 'Manage Students', 'Manage Students', 'manage_options', 'tutor-scheduler-manage-students', array($this, 'load_manage_students_page') );
	
	}

	private function load_admin_page(){

		return plugin_dir_url( __FILE__ ) . 'partials/top-level-display.php';

	}

	private function load_manage_courses_page(){

		return plugin_dir_url( __FILE__ ) . 'partials/manage-courses-display.php';
		
	}

	private function load_manage_students_page(){

		return plugin_dir_url( __FILE__ ) . 'partials/manage-students-display.php';
		
	}

}
