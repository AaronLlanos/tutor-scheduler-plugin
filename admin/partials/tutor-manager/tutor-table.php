<h4><?php echo "Number of Students: ". count($students); ?></h4>
<table class="table table-striped table-hover">
	<thead> 
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Major</th>
			<th># Courses</th>
			<th><span class="dashicons dashicons-trash"></span></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $this->studentsToString($students); ?>
	</tbody>
</table>