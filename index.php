<?php include('inc/connection.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<?php 
		if (isset($_POST['submit'])) {
			//user enter the submisiion

			$errors=array();
			//email and password is set
			if(!isset($_POST['email']) || strlen(trim($_POST['email'])) <1){
				$errors[]='Invalid username/ Password';
			}
			if(!isset($_POST['password']) || strlen(trim($_POST['password'])) <1){
				$errors[]='Invalid username/ Password';
			}
		if (empty($errors)) {
			$email= mysqli_real_escape_string($connection,$_POST['email']);
			$password=mysqli_real_escape_string($connection,$_POST['password']);
			$hashed_password=sha1($password);

			$query="SELECT * FROM user WHERE email='{$email}' AND password='{$password}' LIMIT 1"; 

			$result_set=mysqli_query($connection,$query);

			if($result_set){
				if (mysqli_num_rows($result_set)==1) {
					$user=mysqli_fetch_assoc($result_set);

					$_SESSION['user_id']=$user['id'];
					$_SESSION['first_name']=$user['first_name'];

					$query ="UPDATE user SET last_login = NOW()";
					$query .="WHERE id={$_SESSION['user_id']}";

					$result_set=mysqli_query($connection,$query);
					if (!$result_set) {
						die("Database query failed");
					}

					header('Location: users.php');
				}else{
					$errors[]='invalid username /passsword';
				}

			}else{
				$errors[]='database connection Failed'; 
			}

			}	


		}

	 ?>


</head>
<body>
<div class="login">
	<form action="index.php" method="post">
		<fieldset>
			<legend><h1>Log In</h1></legend>
			<?php 
				if (isset($errors) && !empty($errors)) {
					echo '<p class="error">Invalid username/ Password</p>';
				}
			 ?>
					

			<p>
				<label>Username:</label>
				<input type="text" name="email">
			</p>

			
			<p>
				<label>Password:</label>
				<input type="password" name="password">
			</p>

			<p>
				<button type="submit" name="submit">
					Log In
				</button>
			</p>

		</fieldset>
	</form>
</div>
</body>
</html>
<?php mysqli_close($connection); ?>