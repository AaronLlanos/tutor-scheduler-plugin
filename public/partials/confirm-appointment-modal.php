<div class="modal-header modal-success">
	<h3 class="modal-title">Confirm Appointment</h3>
</div>
<?php  
	$nonce = wp_create_nonce("confirm_tas_appointment");
    $link = admin_url('admin-ajax.php?action=confirm_tas_appointment&nonce='.$nonce);
 ?>
<form id="confirm-appointment" action="<?php echo $link; ?>" method="POST" data-nonce="<?php echo $nonce ?>" data-eventID="-1">
	<div class="modal-body modal-success">
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
		<span class="before-ajax-request">
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
							<input name="email" type="email" class="form-control" id="email" placeholder="Email" required><br>
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
						<textarea id="note-to-tutor" style="height: 190px;" class="form-control"></textarea>
					</div>
					<div class="g-recaptcha" data-sitekey="6LfCTQ0TAAAAAOfEfKTALxNDwVG-ExaPdHZc-_wM"></div>
				</div>
			</div>
		</span>
		<span class="after-ajax-race-error hidden">
			<div class="row">
				<div class="col-xs-4">
					<div class="dashicons dashicons-no" style="font-size: 240px; width: 240px; height: 240px; overflow: visible;"></div>
				</div>
				<div class="col-xs-8">
					<h4>Uh oh! It appears this appointment is already taken!</h4>
					<p>What to do now?</p> 
					<ul>
						<li>Please try to book another appointment.</li>
						<li>If this page has been up for a while, please refresh the page to recieve a list of fresh appointments</li>
					</ul>
				</div>
			</div>
		</span>
		<span class="after-ajax-success hidden">
			<div class="row">
				<div class="col-xs-4">
					<div class="dashicons dashicons-yes" style="font-size: 240px; width: 240px; height: 240px; overflow: visible;"></div>
				</div>
				<div class="col-xs-8">
					<h4>Success! You've fully booked your appointment!</h4>
					<p>What to do now?</p> 
					<ul>
						<li>Wait for the confirmation email</li>
						<li>Save the event to your calendar via the button below!</li>
					</ul>
					<div id="addthisevent" class="addthisevent">
					    <span id="start" class="start"></span>
					    <span id="end" class="end"></span>
					    <span id="time" class="timezone">America/Chicago</span>
					    <span id="title" class="title"></span>
					    <span id="description" class="description"></span>
					    <span id="location" class="location">SSB 4.400</span>
					    <span id="organizer" class="organizer">LCAE Tutoring</span>
					    <span id="organizer_email" class="organizer_email">lcae@austin.utexas.edu</span>
					    <span id="all_day_event" class="all_day_event">false</span>
					    <span id="date_format" class="date_format">MM/DD/YYYY</span>
					</div>
				</div>
			</div>
		</span>
	</div>
	<div class="modal-footer modal-success">
		<button class="btn btn-success before-ajax-request" type="submit">Confirm <img src="<?php echo plugins_url( 'images/loader.gif', __DIR__ ); ?>" class="loading-spinner hidden"></button>
		<button class="btn btn-danger before-ajax-request" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
		<button class="btn btn-info after-ajax-success after-ajax-race-error hidden" type="button" data-dismiss="modal" aria-label="Close">Close</button>
		
	</div>
</form>

