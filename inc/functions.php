<?php 

	function verify_query($result_set){
		global $connection;

		if (!$result_set) {
			die("Database query failed". mysqli_error($connection));
		}
	}

	function verify_req_fields($fieldset){
		$errors=array();
		foreach ($fieldset as $field) {
		if (empty(trim($_POST[$field]))) {
			$errors[]='- '.$field.' is required';
		}
	}
	return $errors;
	}


 ?>