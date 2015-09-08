<label for="tutor-list-m-courses">Select a tutor</label>
<select id="tutor-list-m-courses">
	<option value="" selected>Select a tutor</option>
	<?php 
		foreach ($students as $student) {
			$studentsString .= '<option value="'.$student["id"].'">';
				$studentsString .= $student["first_name"] . $student["last_name"];
			$studentsString .= "</option>";
		}
		echo $studentsString
	 ?>
</select>