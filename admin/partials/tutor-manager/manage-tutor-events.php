
<div class="row">
	<div class="col-xs-4">
		<label for="tutor-list-m-events">Select a tutor</label>
		<select id="tutor-list-m-events" class="form-control">
			<option value="" selected>Select a tutor</option>
		</select>
	</div>
</div>
<hr>
<div class="alert alert-info">
	<b>Alert: </b>This section is currently under construction. Please check back later.
</div>
<form enctype="multipart/form-data" id="student-form" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=m_events'); ?>" role="form">
	<div class="row">
		<div class="col-xs-8">
			<div id="edit-t-fullcalendar"></div>
		</div>
		<div class="col-xs-4">
			
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-12"><input class="btn btn-success" type="submit"></div>	
	</div>
</form>
