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
$courses = $this->get_tutor_courses();

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap bootstrap-wpadmin">

    <!-- Add the icon to the page -->
    <h2><span class="dashicons dashicons-calendar-alt"></span> &nbsp; <?php echo get_admin_page_title(); ?></h2>
    <hr>

    <!-- Main page content here. -->

	<div class="row">
		<div class="col-xs-6">
			<form class="tas-admin-card" action>
				<div class="form-group">
				 	<label for="add-course">Add a Course</label>
				 	<input type="text" class="form-control" id="add-course" placeholder="Ex: UGS 303">
				 	<button type="submit" class="btn btn-success">Add Course</button>
				</div>
			</form>
		</div>
		<div class="col-xs-6 tas-admin-card">
    		<h4><?php echo "Number of Courses: ".count($courses); ?></h4>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Course Name</th>
						<th>Date Added</th>
						<th><span class="dashicons dashicons-trash"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($courses as $course) {
							echo "<tr>";
								echo "<td>" . $course['name'] . "</td>";
								echo "<td>" . $course['date_added'] . "</td>";
							echo "</tr>";
						}
					 ?>
				</tbody>
			</table>
		</div>
	</div>

	

</div><!-- /.wrap -->