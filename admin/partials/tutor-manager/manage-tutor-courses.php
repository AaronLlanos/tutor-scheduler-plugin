<label for="tutor-list-m-courses">Select a tutor</label>
<select id="tutor-list-m-courses">
	<option value="" selected>Select a tutor</option>
</select>
<hr>
<div class="row">
	<form enctype="multipart/form-data" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=m_courses'); ?>" role="form">
		<div class="col-xs-6">
			<h5>Registered Courses: (check those to remove)</h5>
			<div class="table-scroll table-scroll-large">
				<table class="table table-striped table-hover">
					<tbody id="registered-courses"></tbody>
				</table>
			</div>
		</div>
		<div class="col-xs-6">
			<h5>Courses Not Registered For: (check those to add)</h5>
			<div class="table-scroll table-scroll-large">
				<table class="table table-striped table-hover">
					<tbody id="not-registered-courses"></tbody>
				</table>
			</div>
		</div>
		<span id="input-container"></span>
		<input id="r-course-student-id" name="student_id" value="" hidden type="text">
		<hr>
		<div class="col-xs-12"><input class="btn btn-success" type="submit"></div>
	</form>
</div>