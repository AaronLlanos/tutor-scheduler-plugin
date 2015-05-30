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
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<h1><?php echo get_admin_page_title(); ?></h1>
