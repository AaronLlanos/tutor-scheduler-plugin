
<div class="row">
	<div class="col-xs-4">
		<select id="tutor-list-m-events" class="form-control">
			<option value="" selected>Select a tutor</option>
		</select>
	</div>
	<div class="col-xs-4">
		<p><b>Time Block: </b><span id="time-block-binding"></span> minutes</p>
	</div>
	<div class="col-xs-4">
		<p><b>End Date: </b><span id="end-date-binding"></span></p>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-8">
		<div id="edit-t-fullcalendar"></div>
	</div>
	<div class="col-xs-4">
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
				</tr>
			</thead>
			<tbody id="edit-t-events"></tbody>
		</table>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-xs-12">
		<form enctype="multipart/form-data" id="edit-student-form" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=m_events'); ?>" role="form">
			<input id="edit_t_student_id" name="student_id" type="text" class="hidden">
			<input id="edited_schedule" name="edited_schedule" type="text" class="hidden">
			<input class="btn btn-success" type="submit">
		</form>
	</div>	
</div>


