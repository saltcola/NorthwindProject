<?php
	require('db.php');
	session_start();
	function redirect(){
		//header("Location: welcome.php", true);
		echo '<script type="text/javascript">
           			window.location = "employee-main.php"
     				 </script>';
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Employee Login</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
	<?php
			// If form submitted, insert values into the database.
		if (isset($_POST['username'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		      $query = "SELECT * FROM `employees` WHERE username='$username' and password='".md5($password)."'";
			$result = $mysqlConnection->query($query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			
		      if($rows==1){
				$_SESSION['username'] = $username;
				redirect();
		       }else{
				echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='employee-login.php'>Login</a></div>";
			}
		}else{
	?>
		<div class="form">
			<h1>Employee Login</h1>
			<form action="" method="post" name="login" >
				<input class = "login-style" type="text" name="username" placeholder="Username" required />
				<input class = "login-style" type="password" name="password" placeholder="Password" required />
				<input class = "login-button" name="submit" type="submit" value="Login" />
				<input class = "login-button" name="EmployeeBack" type="submit" value="Cancel" />
			</form>
			<p>Not registered yet? <a href='employee-registration.php'>Register Here</a></p>
		</div>
	<?php } ?>
	<?php 
		if(!empty($_POST['EmployeeBack'])){
			echo '<script type="text/javascript">
           			window.location = "index.html"
     				 </script>';
		exit;
		}
	?>
	</body>
</html>