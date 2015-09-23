<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    
 * @subpackage /public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="alert alert-info">
	<h4>Please Read this Thouroughly Before Proceeding!</h4>
	Welcome to our beta tutor scheduler. Here at LCAE we are striving to make our student experience as efficient as possible.
	<ul>
		<li><b>Booking for STEM subjects: </b>This scheduler is currently being refined over the next few days. To book an appointment please refer to the "Original" youcanbookme system by scrolling down. Thank you.</li>
		<li><b>Booking non-STEM subjects: </b>Please feel free to use this calendar to refine your search.</li>
	</ul>
</div>

<div class="row">
	<div class="col-sm-6">
		<label for="course-select">Select a Course</label>
		<select name="course-select" id="course-select" class="form-control"></select>
	</div>
	<div class="col-sm-6">
		<label for="tutor-select">Select a Tutor</label>
		<select name="tutor-select" id="tutor-select" class="form-control"></select>
	</div>
</div>
<hr>
<div class="row">
	<div id="fullcalendar-frontend"></div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="confirm-appointment-modal" id="confirm-appointment-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<?php require_once 'confirm-appointment-modal.php'; ?>
		</div>
	</div>
</div>