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
		<input id="course-select" type="text" placeholder="Ex: CHEM 301" class="form-control">
	</div>
	<div class="col-sm-6">
		<label for="tutors-list">Select a Tutor</label>
		<select name="tutors-list" id="tutors-list" class="form-control"></select>
	</div>
</div>
<hr>
<div class="row">
	<div id="fullcalendar-frontend"></div>
</div>
