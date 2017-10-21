<?php include('inc/connection.php'); ?>
<?php include('inc/functions.php'); ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>modify-user</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">



<?php 
$user_id='';
$first_name='';
$last_name='';
$email='';
$password='';

if (isset($_GET['user_id'])) {
	$user_id=mysqli_real_escape_string($connection,$_GET['user_id']);
	$query = "SELECT * FROM user WHERE id={$user_id}";
	$result_set =mysqli_query($connection, $query);
	if ($result_set) {
		if (mysqli_num_rows($result_set)==1) {
			$user=mysqli_fetch_assoc($result_set);
			$first_name=$user['first_name'];
			$last_name=$user['last_name'];
			$email=$user['email'];
			$password=$user['password'];
		}else{
			header('Location:users.php?errormsg=error');
		}
	}else{
		header('Location:users.php?errormsg=error');
	}

}



if (isset($_POST['submit'])) {
	$user_id=$_POST['user_id'];
	$first_name=$_POST['first_name'];
	$last_name=$_POST['last_name'];
	$email=$_POST['email'];
	
	
	$errors=array();

	$fieldset=array('user_id','first_name','last_name','email');

	$errors=array_merge($errors, verify_req_fields($fieldset)); 

	$req_fields=array('first_name'=>50,'last_name'=>100,'email'=>100);

	foreach ($req_fields as $fieldname => $key) {
		if (strlen(trim($_POST[$fieldname])) >$key) {
			$errors[]='- '.$fieldname.' required'. $key.' characters';
		}
	}

	//check email is already inthe system

	$email=mysqli_real_escape_string($connection, $_POST['email']);

	$query="SELECT * FROM user WHERE email='{$email}' AND id !={$user_id}";

	$result_set=mysqli_query($connection, $query);

	if ($result_set) {
		if(mysqli_num_rows($result_set)==1){
			$errors[]='email already exists';

		}
	}

	if (empty($errors)) {
		
		$first_name=mysqli_real_escape_string($connection, $_POST['first_name']);
		$last_name=mysqli_real_escape_string($connection, $_POST['last_name']);
		$email=mysqli_real_escape_string($connection, $_POST['email']);



		//code goes here

		$query  ="UPDATE user SET";
		$query .="first_name='{$first_name}',";
		$query .="last_name='{$last_name}',";
		$query .="email='{$email}'";
		$query .="WHERE id={$user_id} LIMIT 1";

		$result=mysqli_query($connection, $query);

		if ($result) {
			header('Location: users.php?user-modified=true');
		}else{
			$errors[]='Failed to add the new record';
		}

	}else{
		$errors[]='Failed to add the new record';
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
	<h2>Modify / View User<a href="users.php">Back to userlist</a></h2>

	<?php 
		if (!empty($errors)) {
			echo '<div class="errormsg">';
			foreach ($errors as $error) {
				echo $error.'<br>';
			}
			echo '</div>';
		}

	 ?>
	<form action="modify-user.php" method="post" class="add_form"> 
		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

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
		<a href="change-password">****** | change password</a>
	</p>

	<p>
		<input type="submit" name="submit">
	</p>

	</form>

		

	</main>


</body>
</html>