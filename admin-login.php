<?php
	require('db.php');
	session_start();
	function redirect(){
		//header("Location: welcome.php", true);
		echo '<script type="text/javascript">
           			window.location = "admin-main.php"
     				 </script>';
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Admin Login</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
	<?php
			// If form submitted, insert values into the database.
		if (!empty($_POST['submit'])){
			$username = "root";
			$password = $_POST['password'];
		      $query = "SELECT * FROM `users` WHERE username='$username' and password='".md5($password)."'";

		      // echo $query;
		      // echo "<br>";

			$result = $mysqlConnection->query($query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			
		      if($rows==1){
				$_SESSION['username'] = $username;
				redirect();
		       }else{
				echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='admin-login.php'>Login</a></div>";
			}
		}else{
	?>
		<div class="form">
			<h1>Admin Login</h1>
			<form action="" method="post" name="login" >
				<input class = "login-style" type="text" name="username" value = "root" disabled />
				<input class = "login-style" type="password" name="password" placeholder="Password"  />
				<input class = "login-button" name="submit" type="submit" value="Login" />
				<input class = "login-button" name="AdminBack" type="submit" value="Cancel" />
			</form>
			<p>Using Password: 123456</p>
		</div>
	<?php } ?>
	<?php 
		if(!empty($_POST['AdminBack'])){
			echo '<script type="text/javascript">
           			window.location = "index.html"
     				 </script>';
		exit;
		}
	?>
	</body>
</html>