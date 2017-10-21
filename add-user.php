<?php include('inc/connection.php'); ?>
<?php include('inc/functions.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>add user</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">



<?php 

$first_name='';
$last_name='';
$email='';
$password='';



if (isset($_POST['submit'])) {

	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$email=$_POST['email'];
	$password=$_POST['password'];
	
	$errors=array();

	$fieldset=array('first_name','last_name','email','password');

	$errors=array_merge($errors, verify_req_fields($fieldset)); 

	$req_fields=array('first_name'=>50,'last_name'=>100,'email'=>100,'password'=>40);

	foreach ($req_fields as $fieldname => $key) {
		if (strlen(trim($_POST[$fieldname])) >$key) {
			$errors[]='- '.$fieldname.' required'. $key.' characters';
		}
	}

	//check email is already inthe system

	$email=mysqli_real_escape_string($connection, $_POST['email']);

	$query="SELECT * FROM user WHERE email='{$email}' LIMIT 1";

	$result_set=mysqli_query($connection, $query);

	if ($result_set) {
		if(mysqli_num_rows($result_set)==1){
			$errors[]='email already exists';

		}
	}

	if (empty($errors)) {
		$first_name=mysqli_real_escape_string($connection, $_POST['first_name']);
		$last_name=mysqli_real_escape_string($connection, $_POST['last_name']);
		$password=mysqli_real_escape_string($connection, $_POST['password']);


		$query="INSERT INTO user (first_name,last_name,email,password,is_deleted)";
		$query .="VALUES('{$first_name}','{$last_name}','{$email}','{$password}',0)";

		$result=mysqli_query($connection, $query);

		if ($result) {
			header('Location: users.php?user-added=true');
		}

	}



}
	


 ?>	

</head>
<body>
<?php 
if (!isset($_SESSION['user_id'])) {
			header('Location: index.php');
		}

 ?>
<header>
	<div class="appname">User management System</div>
	<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> <a href="logout.php">logout</a></div>
</header>	
	<main>
	<h2>ADD NEW USER<a href="users.php">Back to userlist</a></h2>

	<?php 
		if (!empty($errors)) {
			echo '<div class="errormsg">';
			foreach ($errors as $error) {
				echo $error.'<br>';
			}
			echo '</div>';
		}

	 ?>
	<form action="add-user.php" method="post" class="add_form"> 


	<p>
		<label>First Name:</label>
		<input type="text" name="first_name" <?php echo 'value="'.$first_name.'"'; ?>>
	</p>

	<p>
		<label>Last Name:</label>
		<input type="text" name="last_name"  <?php echo 'value="'.$last_name.'"'; ?>>
	</p>
	<p>
		<label>Email:</label>
		<input type="email" name="email"  <?php echo 'value="'.$email.'"'; ?>>
	</p>
	<p>
		<label>Passsword:</label>
		<input type="password" name="password"  <?php echo 'value="'.$password.'"'; ?>>
	</p>

	<p>
		<input type="submit" name="submit">
	</p>

	</form>

		

	</main>


</body>
</html>