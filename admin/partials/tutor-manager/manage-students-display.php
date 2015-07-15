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

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap bootstrap-wpadmin">
    <!-- Add the icon to the page -->
    <h2><span class="dashicons dashicons-calendar-alt"></span> &nbsp; <?php echo get_admin_page_title(); ?></h2>
    <hr>

    <!-- Main page content here. -->
    <?php echo $updateMessage; ?>
	<div class="row">
		<div class="tas-admin-card">
    		<?php require_once 'tutor-table.php'; ?>
		</div>
	</div>
	<ul id="myTabs" class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a aria-controls="home" role="tab" data-toggle="tab" href="#add-student">Add Tutor</a></li>
		<li role="presentation"><a aria-controls="manage-tutor-courses" role="tab" data-toggle="tab" href="#manage-tutor-courses">Manage Tutor Courses</a></li>
		<li role="presentation"><a aria-controls="manage-tutor" role="tab" data-toggle="tab" href="#manage-tutor">Manage Tutor(s)</a></li>
	</ul>
	<div class="tab-content tas-admin-card">
		<div role="tabpanel" id="add-student" class="tab-pane fade in active">
			<?php require_once 'add-student-form.php'; ?>
		</div>
		<div role="tabpanel" id="manage-tutor-courses" class="tab-pane fade">
			...
		</div>
		<div role="tabpanel" id="manage-tutor" class="tab-pane fade">
			...
		</div>
	</div>

</div>

	

</div><!-- /.wrap -->