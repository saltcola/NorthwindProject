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
                                FROM users
                                WHERE username = '$username' ";
            
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
        <div class = "row customer-header">
        </div>
        <div class="row">
            <div class="col-sm-4 employee-left">
                <div class="btn-group-vertical" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" onClick="location.href='customer-editProfile.php'">Edit Profile</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-payment.php'">Edit Payment</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-completedOrder.php'">Completed Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-pendingOrder.php'">Pending Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-shoppingCart.php'">Shopping Cart</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-searchScreen.php'">Search Screen</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-quickSearch.php'">Quick Search</button>
                    <button type="button" class="btn btn-default" onClick="location.href='logout.php'">Logout</button>
                </div>
            </div>
            <div class="col-sm-8 employee-right">
                <p><strong>Name:                   </strong><?php echo $row['fName'] ?> <?php echo $row['lName'] ?></p>
                <p><strong>Company Name:  </strong> <?php echo $row['companyName'] ?> </p>
                <p><strong>Username:           </strong> <?php echo $row['username'] ?> </p>
                <p><strong>Email:                   </strong> <?php echo $row['email'] ?> </p>
                <p><strong>Address:               </strong> <?php echo $row['address'] ?> </p>
                <p><strong>City:                     </strong> <?php echo $row['city'] ?> </p>
                <p><strong>State:                   </strong> <?php echo $row['state'] ?> </p>
                <p><strong>Zipcode:               </strong> <?php echo $row['postalCode'] ?> </p>
                <p><strong>Country:               </strong> <?php echo $row['country'] ?> </p>
                <p><strong>Phone:                 </strong> <?php echo $row['phone'] ?> </p>
                <p><strong>Fax:                      </strong> <?php echo $row['fax'] ?> </p>
                                               
            </div>
        </div>
    </div>
</body>

</html>
