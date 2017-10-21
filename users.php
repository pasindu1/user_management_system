<!--Hi this is me -->

<?php include('inc/connection.php'); ?>
<?php include('inc/functions.php'); ?>
<?php session_start(); ?>

<?php 
	
	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Users</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<?php 
		if (!isset($_SESSION['user_id'])) {
			header('Location: index.php');
		}

		$userlist='';

		$query="SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name";
		$users=mysqli_query($connection, $query);

		verify_query($users);
			while ($user=mysqli_fetch_assoc($users)){
				$userlist .="<tr>";
				$userlist .="<td>".$user['first_name']."</td>";
				$userlist .="<td>{$user['last_name']}</td>";
				$userlist .="<td>{$user['last_login']}</td>";
				$userlist .="<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";
				$userlist .="<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";
				$userlist .="</tr>";
			}
		

	 ?> 
</head>
<body>
<header>
	<div class="appname">User management System</div>
	<div class="loggedin">Welcome <?php echo $_SESSION['first_name']; ?> <a href="logout.php">logout</a></div>
</header>	
	<main>
	<h2><a href="add-user.php">+ Add New</a></h2>

		<table class="userlist">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Last login</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
			<?php echo $userlist; ?>

		</table>

	</main>


</body>
</html>
