<h4>Add a Tutor</h4>
<p><b>Note: * denotes required field</b></p>
<form enctype="multipart/form-data" id="student-form" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->tutor_slug . '&type=add'); ?>" role="form">
	<div class="row">
		<div class="col-xs-6">
			<div class="row">
				<div class="col-xs-6 form-group">
					<label for="first-name">*First Name</label>
					<input name="first-name" type="text" class="form-control" id="first-name" placeholder="First Name" autofocus required><br>	
				</div>
				<div class="col-xs-6 form-group">
					<label for="last-name">*Last Name</label>
					<input name="last-name" type="text" class="form-control" id="last-name" placeholder="Last Name" required><br>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 form-group">
					<label for="email">*Email</label>
					<input name="email" type="text" class="form-control" id="email" placeholder="Email" required><br>
				</div>
				<div class="col-xs-6 form-group">
					<label for="major">Major</label>
					<input name="major" type="text" class="form-control" id="major" placeholder="Major"><br>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 form-group">
					<label for="classification">Classification</label>
					<select name="classification" id="classification" class="form-control" form="student-form">
						<option value="" selected>select one</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="Masters">Masters</option>
						<option value="PhD">PhD</option>
					</select>
				</div>
				<div class="col-xs-6 form-group">
					<label for="program">Participating Program</label>
					<select name="program" id="program" class="form-control" form="student-form">
						<option value="" selected>select one</option>
						<option value="Gateway">Gateway</option>
						<option value="LLP">LLP</option>
						<option value="Journalism">Journalism</option>
						<option value="McNair">McNair</option>
					</select>
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<label>Tutor Courses (<?php echo count($courses) ?>)</label>
			<input id="courses" type="text" name="courses" class="hidden">
			<input id="schedule" type="text" name="schedule" class="hidden">
			<div class="table-scroll">
				<table id="courses-table" class="table table-bordered">
					<tbody><?php echo $this->coursesToString($courses); ?></tbody>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<label for="recurr_until">Recurr Dates Until: (YYYY-MM-DD)</label>
		<input id="recurr_until" name="recurr_until" type="text" required></input><a tabindex="0" class="btn btn-defalut" id="calendar_pop" role="button" ><span class="dashicons dashicons-calendar-alt"></span></a tabindex="0">
		<br>
		<div id='fullcalendar'></div>
	</div>
	<hr>
	<input type="submit" class="btn btn-success" value="Add Student">
</form>

