<?php
	$username = "USER325173";
	$password = "8ZDS9phSw";
	$database = "db_325173_2";
	$address = "saltcola.lima-db.de";
	
	 // Create connection
    $mysqlConnection = new mysqli($address, $username, $password, $database);

    // Check connection
    if ($mysqlConnection->connect_error) {
        die("Connection failed: " . $mysqlConnection->connect_error);
    }
?>