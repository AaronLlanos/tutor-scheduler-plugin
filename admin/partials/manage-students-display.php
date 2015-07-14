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

if (count($_POST) > 0){
	$insertSuccess = $this->executePostRequest();
	$updateMessage = $this->getUpdateMessage($updateMessage, $insertSuccess);
}

//Grab the students
$students = json_decode($this->get_tutor_students(), true);

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
			<div class="tas-admin-card">
				<h4>Add a Tutor</h4>
				<p><b>Note: * denotes required field</b></p>
				<form id="student-add-form" role="form">
					<div class="row">
						<div class="col-xs-6 form-group">
							<label for="first-name">*First Name</label>
							<input type="text" class="form-control" id="first-name" placeholder="First Name" autofocus required><br>	
						</div>
						<div class="col-xs-6 form-group">
							<label for="last-name">*Last Name</label>
							<input type="text" class="form-control" id="last-name" placeholder="Last Name" required><br>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 form-group">
							<label for="email">*Email</label>
							<input type="text" class="form-control" id="email" placeholder="Email"><br>
						</div>
						<div class="col-xs-6 form-group">
							<label for="major">Major</label>
							<input type="text" class="form-control" id="major" placeholder="Major"><br>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6 form-group">
							<label for="classification">Classification</label>
							<select id="classification" form="student-add-form">
								<option>select one</option>
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>Graduate Student Masters</option>
								<option>Graduate Student PhD</option>
							</select>
						</div>
						<div class="col-xs-6 form-group">
							<button type="button" class="btn btn-info">Select Tutor Courses</button>
						</div>
					</div>
					<button type="button" class="btn btn-success">Add Student</button>
				</form>
			</div>
			<form enctype="multipart/form-data" id="student-form" class="tas-admin-card" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->students_slug . ''); ?>">
				<div class="form-group">
					<h4>Students Being Edited</h4>
				 	<hr>
					<table class="table"> 
						<tbody id="temp-student-table"></tbody>
					</table>
					<br>
				 	<button id="save-changes" type="submit" class="btn btn-primary">Save Changes</button>
				 	<p><b>*Note:</b> When ready to finally submit students to table, hit the save changes button before leaving the page.</p>
				</div>
			</form>
		</div>
		<div class="col-xs-6 tas-admin-card">
    		<h4><?php echo "Number of Students: ". count($students); ?></h4>
			<table class="table table-striped table-hover">
				<thead> 
					<tr>
						<th>Student Name</th>
						<th>Date Added</th>
						<th>Tutor Count</th>
						<th><span class="dashicons dashicons-trash"></span></th>
					</tr>
				</thead>
				<tbody>
					<?php echo $this->studentsToString($students); ?>
				</tbody>
			</table>
		</div>
	</div>

	

</div><!-- /.wrap -->