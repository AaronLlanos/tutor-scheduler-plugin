<h4>Add a Tutor</h4>
<p><b>Note: * denotes required field</b></p>
<form enctype="multipart/form-data" id="student-form" method="POST" action="<?php echo admin_url('admin.php?page=' . $this->student_slug . ''); ?>" role="form">
	<div class="col-xs-6">
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
				<input type="text" class="form-control" id="email" placeholder="Email" required><br>
			</div>
			<div class="col-xs-6 form-group">
				<label for="major">Major</label>
				<input type="text" class="form-control" id="major" placeholder="Major"><br>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 form-group">
				<label for="classification">Classification</label>
				<select id="classification" class="form-control" form="student-add-form">
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
				<label for="program">Participating Program</label>
				<select id="program" class="form-control" form="student-add-form">
					<option>select one</option>
					<option>Gateway</option>
					<option>LLP</option>
					<option>Journalism</option>
					<option>McNair</option>
				</select>
			</div>
		</div>
	</div>
	<div class="col-xs-6">
		<label for="courses">Tutor Courses (<?php echo count($courses) ?>)</label>
		<table id="courses" class="table">
			<?php echo $this->coursesToString($courses); ?>
		</table>
	</div>
	<div class="row">
		<button type="submit" class="btn btn-success">Add Student</button>
	</div>
</form>