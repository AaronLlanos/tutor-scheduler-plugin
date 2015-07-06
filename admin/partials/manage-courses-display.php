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

$updateMessage = '';
if (count($_POST) > 0){
	global $wpdb;
	
	/**
	 * Track to see if there were any errors while inserting into table
	 * @var boolean
	 */
	$insertError = false;
	$table = $wpdb->prefix . 'tutor_scheduler_courses';
	$format = array('%s', '%s', '%d' );
	$date_added = date('Y-m-d H:i:s');

	foreach ($_POST as $key => $value) {
		if ($value == "add"){
			$data = array( 'date_added' => $date_added, 'name' => $key, 'tutor_count' => 0);

			//Error check
			if (!$wpdb->insert( $table, $data, $format )) {
		 		$insertError = true;
			}
		}else{
			$data = array( 'ID' => $key );
			//Error check
			if (!$wpdb->delete( $table, $data ) ) {
		 		$insertError = true;
			}
		}
	}

	if (!$insertError){
		$updateMessage .= '<div class="alert alert-success" role="alert">';
		$updateMessage .= 	'Success: All updates have been made successfully!';
		$updateMessage .= '</div>';
	}else{
		$updateMessage .= '<div class="alert alert-danger" role="alert">';
		$updateMessage .= 	'Error: There was a problem inserting the courses into the table.';
		$updateMessage .= '</div>';
	}
}

//Grab the courses
$courses = json_decode($this->get_tutor_courses(), true);

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
		<div class="col-xs-6">
			<div class="tas-admin-card form-group">
				<label for="add-course">Add a Course</label>
				<input type="text" class="form-control" id="add-course" placeholder="Ex: UGS 303 then hit enter" autofocus><br>
				<button type="button" class="btn btn-success">Add Course</button>
			</div>
			<form enctype="multipart/form-data" id="course-form" class="tas-admin-card" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->courses_slug . ''); ?>">
				<div class="form-group">
					<h4>Courses Being Edited</h4>
				 	<hr>
					<table class="table"> 
						<tbody id="temp-course-table"></tbody>
					</table>
					<br>
				 	<button id="save-changes" type="submit" class="btn btn-primary">Save Changes</button>
				 	<p><b>*Note:</b> When ready to finally submit courses to table, hit the save changes button before leaving the page.</p>
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
						<th>Tutor Count</th>
						<th><span class="dashicons dashicons-trash"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($courses as $course) {
							// var_dump($course);
							echo "<tr>";
								echo "<td>" . $course["name"] . "</td>";
								echo "<td>" . $course["date_added"] . "</td>";
								echo "<td>" . $course["tutor_count"] . "</td>";
								echo '<td><button class="btn btn-xs btn-danger course-remove" data-name="' . $course["name"] . '" data-courseID="' . $course["id"] . '">X</button></td>';
							echo "</tr>";
						}
					 ?>

				</tbody>
			</table>
		</div>
	</div>

	

</div><!-- /.wrap -->