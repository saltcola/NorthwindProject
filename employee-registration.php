<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration</title>
        <link rel="stylesheet" href="css/style.css" />
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
    <?php
        require('db.php');
        // If form submitted, insert values into the database.
        if (isset($_REQUEST['username'])){

            $username = $_POST['username'];
            $checkQuery = "SELECT * FROM employees WHERE username = '$username' ";
            $checkResult = NULL;
            $checkResult = $mysqlConnection->query($checkQuery);
            $count = $checkResult-> num_rows;

            if($count > 0){
                echo "<div class='form'>
                        <h3>Sorry! This Username already exists!</h3>
                        <br/>Click here to <a href='registration.php'>Back</a></div>";  
                
            }


            $password = $_POST['password'];
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $postalCode = $_POST['postalCode'];
            $country = $_POST['country'];
            $HomePhone = $_POST['phone'];

            $query = "INSERT into `employees` (username, password, FirstName, 
            LastName, Address, City, Region, PostalCode, Country, HomePhone)
            VALUES ('$username', '".md5($password)."', '$fName', '$lName', '$address', '$city', '$state', '$postalCode', '$country', '$HomePhone')";

            // echo $query;
            // echo "<br>";

            $result = NULL;
            $result = $mysqlConnection->query($query);
                
            if($result){
                echo "<div class='form'>
                            <h3>You are registered successfully.</h3>
                            <br/>Click here to <a href='employee-login.php'>Login</a></div>";
                }
            }else{
    ?>
        <div class="form">
            <h1>Registration</h1>
            <form name="registration" action="" method="post">
                <div class="form-group">
                        <label>First Name: </label>
                        <input  type="text" class="form-control" name="fName" placeholder="First Name" required />
                </div>
                <div class="form-group">
                        <label>Last Name: </label>
                        <input type="text" class="form-control" name="lName" placeholder="Last Name" required />
                </div>
                <div class="form-group">
                        <label>Username: </label>
                        <input type="text" class="form-control" name="username" placeholder="Username" required />
                </div>
                <div class="form-group">
                        <label>Password: </label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required />
                </div>
                <div class="form-group">
                        <label>Address: </label>
                        <input type="text" class="form-control" name="address" placeholder="Address"  />
                </div>
                <div class="form-group">
                        <label>City: </label>
                        <input type="text" class="form-control" name="city" placeholder="City" />
                </div>
                <div class="form-group">
                        <label>State: </label>
                        <input type="text" class="form-control" name="state" placeholder="State"  />
                </div>
                <div class="form-group">
                        <label>Country: </label>
                        <input type="text" class="form-control" name="country" placeholder="Country" />
                </div>
                <div class="form-group">
                        <label>Post Code: </label>
                        <input type="text" class="form-control" name="postalCode" placeholder="Post Code" />
                </div>
                <div class="form-group">
                        <label>Phone: </label>
                        <input type="text" class="form-control" name="phone" placeholder="Phone" />
                </div>
                <input type="submit" class = "login-button" name="submit" value="Register" />
                <input class = "login-button" name="Back" type="submit" value="Cancel" /> 
            </form>
        </div>
    <?php } ?>
    <?php 
        if(!empty($_POST['Back'])){
            echo '<script type="text/javascript">
                    window.location = "index.html"
                     </script>';
        exit;
        }
    ?>


    </body>
</html>