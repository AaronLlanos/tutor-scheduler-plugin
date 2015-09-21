<label for="tutor-list-m-events">Select a tutor</label>
<select id="tutor-list-m-events">
	<option value="" selected>Select a tutor</option>
</select>
<hr>
<div class="row">
	<form enctype="multipart/form-data" id="student-form" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=m_events'); ?>" role="form">
		<hr>
		<div class="col-xs-12"><input class="btn btn-success" type="submit"></div>
	</form>
</div>