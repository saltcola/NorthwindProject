<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Registration</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
    <?php
        require('db.php');
        // If form submitted, insert values into the database.
        if (isset($_REQUEST['username'])){

            $username = $_POST['username'];
            $checkQuery = "SELECT * FROM customers WHERE CustomerID = '".$username."' ";
            $checkResult = NULL;
            $checkResult = $mysqlConnection->query($checkQuery);
            $count = $checkResult-> num_rows;

            if($count > 0){
                echo "<div class='form'>
                        <h3>Sorry! This Username already exists!</h3>
                        <br/>Click here to <a href='registration.php'>Back</a></div>";  
                
            }

            $email = $_POST['email'];
            $password = $_POST['password'];
            $trn_date = date("Y-m-d H:i:s");
            $fName = $_POST['fName'];
            $lName = $_POST['lName'];
            $companyName = (!empty($_POST['companyName'])) ? $_POST['companyName'] : 'NULL';
            $address = $_POST['address'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $postalCode = $_POST['postalCode'];
            $country = $_POST['country'];
            $phone = $_POST['phone'];
            $fax = $_POST['fax'];

            $query = "INSERT into `customers` (CustomerID, Password, Email, trn_date, fName, 
            lName, companyName, Address, City, Region, PostalCode, Country, Phone, Fax)
            VALUES ('$username', '".md5($password)."', '$email', '$trn_date', '$fName', '$lName', 
            '$companyName', '$address', '$city', '$state', '$postalCode', '$country', '$phone', '$fax')";

            $result = NULL;
            $result = $mysqlConnection->query($query);
                
            if($result){
                echo "<div class='form'>
                            <h3>You are registered successfully.</h3>
                            <br/>Click here to <a href='login.php'>Login</a></div>";
                }
            }else{
    ?>
        <div class="form">
            <h1>Registration</h1>
            <form name="registration" action="" method="post">
                <input type="text" name="fName" placeholder="First Name" required />
                <input type="text" name="lName" placeholder="Last Name" required />
                <input type="text" name="companyName" placeholder="Company" />
                <input type="text" name="username" placeholder="Username" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Password" required />
                <input type="text" name="address" placeholder="Address" required />
                <input type="text" name="city" placeholder="City" required />
                <input type="text" name="state" placeholder="State" required />
                <input type="text" name="country" placeholder="Country" required />
                <input type="text" name="postalCode" placeholder="Post Code" required />
                <input type="text" name="phone" placeholder="Phone" required />
                <input type="text" name="fax" placeholder="Fax" required />
                <input type="submit" name="submit" value="Register" />
                <a class = ".backButton" href='index.html'>Back</a> 
            </form>
        </div>
    <?php } ?>


    </body>
</html>