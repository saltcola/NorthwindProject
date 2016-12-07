<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: employee-login.php");
        exit(); 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee</title>
    <!-- Local Css file -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="continer" id = "Employee">
        <div class="row">
            <div class="col-sm-3 employee-left">
                <?php require('employee-left-button.php'); ?>
            </div>
            <div class="col-sm-8 employee-right">
              <?php 
                // search for active order
                require('db.php');
                    
                    $query = "SELECT * FROM `ORDERS` 
                                    WHERE EmployeeID IS NULL ";
                    // echo $query;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    $array = array();
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        $count = $result -> num_rows;
                        // echo $count;
                        // echo "<br>";
                        while($row = $result->fetch_assoc()) $array[] = $row;
                    }
                    if($count == 0){
                        echo "
                        <h2> There is no active order right now.</h2>
                        ";
                    }
              ?>

              <ul class="list-group">
                <?php foreach($array as $order) { 
                        $OrderID = $order['OrderID'];

                        $query = "SELECT * FROM `order details`
                                        WHERE OrderID = '$OrderID' ";
                        $result = NULL;
                        $result = $mysqlConnection->query($query);
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count = $result -> num_rows;
                        }


                    
                    echo " <a href='emlpoyee-editOrder.php?id=".$OrderID." '>
                                    <li class='list-group-item'> 
                                        OrderID: '$OrderID' 
                                        <span class='badge'> 
                                            Total Items: '$count'
                                        </span>
                                    </li>
                                </a>";

                } ?>
              </ul>
            </div>
        </div>
    </div>
</body>

</html>
