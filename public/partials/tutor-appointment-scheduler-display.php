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
