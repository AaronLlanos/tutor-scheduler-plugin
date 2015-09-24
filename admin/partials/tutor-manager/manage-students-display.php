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

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap bootstrap-wpadmin">
    <!-- Add the icon to the page -->
    <h2><span class="dashicons dashicons-calendar-alt"></span> &nbsp; <?php echo get_admin_page_title(); ?></h2>    
    <hr>

    <!-- Main page content here. -->
    <?php echo $updateMessage; ?>

	<h4><?php echo "Number of Students: ". count($students); ?></h4>
	
	<!-- Tab List -->
	<ul id="myTabs" class="nav nav-tabs" role="tablist">
		<li role="presentation" <?php if ($addTab){echo 'class="active"';} ?>><a aria-controls="add-tutor" role="tab" data-toggle="tab" href="#add-tutor">Add Tutor</a></li>
		<li role="presentation" <?php if ($m_coursesTab){echo 'class="active"';} ?>><a aria-controls="manage-tutor-courses" role="tab" data-toggle="tab" href="#manage-tutor-courses">Manage Tutor Courses</a></li>
		<li role="presentation" <?php if ($m_eventsTab){echo 'class="active"';} ?>><a aria-controls="manage-tutor-events" role="tab" data-toggle="tab" href="#manage-tutor-events">Manage Tutor Dates</a></li>
		<li role="presentation" <?php if ($removeTab){echo 'class="active"';} ?>><a aria-controls="manage-tutor" role="tab" data-toggle="tab" href="#manage-tutor">Remove Tutor</a></li>
	</ul>
	<!-- Tab Content -->
	<div class="tab-content tas-admin-card">
    	
		<div role="tabpanel" id="add-tutor" class="tab-pane fade <?php if ($addTab){echo 'in active';} ?>">
			<?php require_once 'add-tutor-form.php'; ?>
		</div>
		<div role="tabpanel" id="manage-tutor-courses" class="tab-pane fade <?php if ($m_coursesTab){echo 'in active';} ?>">
			<?php require_once 'manage-tutor-courses.php'; ?>
		</div>
		<div role="tabpanel" id="manage-tutor-events" class="tab-pane fade <?php if ($m_eventsTab){echo 'in active';} ?>">
			<?php require_once 'manage-tutor-events.php'; ?>
		</div>
		<div role="tabpanel" id="manage-tutor" class="tab-pane fade <?php if ($removeTab){echo 'in active';} ?>">
			<?php require_once 'tutor-table.php'; ?>
			<form id="student-remove-form" class="hidden" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=remove'); ?>"><input id="student-remove-input" name="student_id"></form>
		</div>
	</div>
	<div class="modal fade bs-example-modal-sm" tabindex="1000" role="dialog" style="width: 500px !important; margin-left: 200px !important; margin-top: 200px !important">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div><!-- /.wrap -->