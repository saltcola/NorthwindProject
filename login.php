<?php
	require('db.php');
	session_start();
	function redirect(){
		//header("Location: welcome.php", true);
		echo '<script type="text/javascript">
           			window.location = "customer-main.php"
     				 </script>';
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
	<?php
			// If form submitted, insert values into the database.
		if (isset($_POST['username'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
		      $query = "SELECT * FROM `customers` WHERE CustomerID='$username' and Password='".md5($password)."'";
			$result = $mysqlConnection->query($query) or die(mysql_error());
			$rows = mysqli_num_rows($result);
			
		      if($rows==1){
				$_SESSION['username'] = $username;
				redirect();
		       }else{
				echo "<div class='form'>
				<h3>Username/password is incorrect.</h3>
				<br/>Click here to <a href='login.php'>Login</a></div>";
			}
		}else{
	?>
		<div class="form">
			<h1>Log In</h1>
			<form action="" method="post" name="login">
				<input type="text" name="username" placeholder="Username" required />
				<input type="password" name="password" placeholder="Password" required />
				<input name="submit" type="submit" value="Login" />
			</form>
			<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
			<p>Or <a href='index.html'>Go Back</a></p>
		</div>
	<?php } ?>
	</body>
</html>