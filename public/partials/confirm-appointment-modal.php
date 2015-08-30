<div class="modal-header">
	<h3 class="modal-title">Confirm Appointment</h3>
</div>
<div class="modal-body">
	<div class="row">
		<div class="col-xs-3">
			<strong>Tutor: </strong><br><span class="selected-tutor-name"></span>	
		</div>
		<div class="col-xs-3">
			<strong>Date: </strong><br><span id="selected-tutor-date"></span>
		</div>
		<div class="col-xs-3">
			<strong>Subject: </strong><br><span id="selected-tutor-subject"></span>
		</div>
		<div class="col-xs-3">
			<strong>Location: </strong><br>SSB 4.400
		</div>
	</div>
	<hr>
	<form>
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
						<label for="program">*Participating Program</label>
						<select name="program" id="program" class="form-control" form="student-form" required>
							<option value="other" selected>select one</option>
							<option value="Gateway">Gateway</option>
							<option value="LLP">LLP</option>
							<option value="Journalism">Journalism</option>
							<option value="McNair">McNair</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<label for="note-to-tutor">Leave a Note for <span class="selected-tutor-name"></span>:</label>
					<textarea id="note-to-tutor" style="height: 225px;" class="form-control"></textarea>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button class="btn btn-success" type="submit">Confirm</button>
	<button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
</div>