<?php	
	require('db.php');
	$sqlAllcustomers = "SELECT * FROM customers";
	
	$result = NULL;
    	$result = $mysqlConnection->query($sqlAllcustomers);

    if (!$result) {
        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
    } else {
        $array = array();
        while($row = $result->fetch_assoc()) $array[] = $row;
    }

    $mysqlConnection->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CSE4701 Project Group B</title>
    <!-- <link rel="stylesheet" href="css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Black+Ops+One|Press+Start+2P' rel='stylesheet' type='text/css'>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
     <script src="https://code.jquery.com/jquery-2.2.2.js"></script>
     <script src="js/prefixfree.min.js"></script>
     <script src="js/script.js"></script> -->
</head>

<body> 
  <h1>CSE4701 Project</h1>
  <p>Group B</p>
  <form name="add_customer">
	Add customer with name: 
	<input type="text" name="customer_name">
	<input type="hidden" name="add_customer" value="1">
	
	<input type="submit">	
	</form>

	<div id="doc2" class="yui-t7">
		<div id="inner">
			<div id="bd">
				<div id="yui-main">
					<div class="yui-b">
						<div class="yui-gf">
		
							<div class="yui-u first">
								<h2>customers</h2>
							</div><!--// .yui-u -->

							<div class="yui-u">

							<?php foreach ($array as $customer) { ?>
								<div class="job">
									<h4><li>
										<strong>CompanyName:</strong> <?php echo $customer['CompanyName'] ?>
										<br> 
										<strong>ContactName:</strong> (<?php echo $customer['ContactName'] ?>)
									</li></h4>																
								</div>
							<?php } ?>

							</div><!--// .yui-u -->
						</div><!--// .yui-gf -->
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>