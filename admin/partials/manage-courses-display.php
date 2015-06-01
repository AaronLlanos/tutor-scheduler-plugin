<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    tutor-appointment-scheduler
 * @subpackage tutor-appointment-scheduler/admin/partials
 */

if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}

//Grab the courses
$courses = Tutor_Scheduler_Admin::get_tutor_courses();

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap bootstrap-wpadmin">

    <!-- Add the icon to the page -->
    <h2><span class="dashicons dashicons-calendar-alt"></span> &nbsp; <?php echo get_admin_page_title(); ?></h2>
    <hr>

    <!-- Main page content here. -->
    <p>Woohoo, the start of something awesome!</p>
    <?php echo typeof $courses; ?>


</div><!-- /.wrap -->