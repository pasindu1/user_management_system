<?php 
	$connection=mysqli_connect('localhost','root','','userdb');

	if (mysqli_connect_errno()) {
		die("databse connecton falied" . mysqli_connect_error());
	}else{
		//echo "Connection is successful";
	}
?>