<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit(); 
    }else{
            require('db.php');

            $username = $_SESSION["username"];
            $sqlUser = "SELECT * 
                                FROM customers
                                WHERE CustomerID = '$username' ";
            
            $result = NULL;
            $result = $mysqlConnection->query($sqlUser);

            if (!$result) {
                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
            } else {
                $row = $result->fetch_assoc();
            }

            $mysqlConnection->close();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Profile</title>
    <!-- Local Css file -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="continer">
        <div class="row">
            <div class="col-sm-3 employee-left">
                <?php require('customer-left-button.php'); ?>
            </div>
            <div class="col-sm-9 employee-right">
                <p><strong>Name:                   </strong><?php echo $row['fName'] ?> <?php echo $row['lName'] ?></p>
                <p><strong>Company Name:  </strong> <?php echo $row['CompanyName'] ?> </p>
                <p><strong>Username:           </strong> <?php echo $row['CustomerID'] ?> </p>
                <p><strong>Email:                   </strong> <?php echo $row['Email'] ?> </p>
                <p><strong>Address:               </strong> <?php echo $row['Address'] ?> </p>
                <p><strong>City:                     </strong> <?php echo $row['City'] ?> </p>
                <p><strong>State:                   </strong> <?php echo $row['Region'] ?> </p>
                <p><strong>Zipcode:               </strong> <?php echo $row['PostalCode'] ?> </p>
                <p><strong>Country:               </strong> <?php echo $row['Country'] ?> </p>
                <p><strong>Phone:                 </strong> <?php echo $row['Phone'] ?> </p>
                <p><strong>Fax:                      </strong> <?php echo $row['Fax'] ?> </p>
                                               
            </div>
        </div>
    </div>
</body>

</html>
