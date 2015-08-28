<table class="table table-striped table-hover">
	<thead> 
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Major</th>
			<th>Classification</th>
			<th># Courses</th>
			<th>Date Added</th>
			<th><span class="dashicons dashicons-trash"></span></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $this->studentsToString($students); ?>
	</tbody>
</table>