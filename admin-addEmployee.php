<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: admin-login.php");
        exit(); 
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Employee</title>
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
            <div class="col-sm-3 employee-right">
                <?php require('admin-left-button.php'); ?>
            </div>
            <div class="col-sm-8 employee-right">
                <?php
                require('db.php');
                // If form submitted, insert values into the database.
                if (!empty($_POST['submit'])){
                    $FirstName = $_POST['FirstName'];
                    $LastName = $_POST['LastName'];
                    $Title = $_POST['Title'];
                    $TitleOfCourtesy = $_POST['TitleOfCourtesy'];
                    $Birthday = date("Y-m-d H:i:s", strtotime($_POST['Birthdate']));
                    $HireDate =date("Y-m-d H:i:s", strtotime($_POST['HireDate'])) ;
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    $address = $_POST['address'];
                    $city = $_POST['city'];
                    $state = $_POST['state'];
                    $postalCode = $_POST['postalCode'];
                    $country = $_POST['country'];
                    $HomePhone = $_POST['HomePhone'];
                    $Salary = $_POST['Salary'];

                    $query = "INSERT into `employees` (FirstName, LastName, Title, TitleOfCourtesy, BirthDate, HireDate, username, password, Address, City, Region, PostalCode, Country, HomePhone, Salary)
            VALUES ('$FirstName', '$LastName', '$Title', '$TitleOfCourtesy', '$Birthday', '$HireDate', 
            '$username', '$password','$address', '$city', '$state', '$postalCode', '$country', '$HomePhone', '$Salary')";


                    

                    // echo $query;
                    // echo "<br>";
                    // echo "Username: ".$username;
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                        
                    if($result){
                        echo "<div class='form'>
                                    <h3>Profile updated.</h3>
                                    <br/>Click here to <a href='admin-main.php'>Back</a></div>";
                        }
                }else{
            ?>
            <div class = "row">
                <div class = "col-sm-6">
                    <form name="registration" action="" method="post">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control"  name="FirstName" placeholder="First Name"  required />
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control"  name="LastName" placeholder="Last Name"  required />
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control"  name="Title" placeholder="Title"  required />
                        </div>

                        <div class="form-group">
                            <label>Title Of Courtesy</label>
                            <input type="text" class="form-control"  name="TitleOfCourtesy" placeholder="Title Of Courtesy"  required />
                        </div>

                        <div class="form-group">
                            <label>Birthday</label>
                            <input type="datetime-local" class="form-control"  name="Birthdate" placeholder="Birthday"  required />
                        </div>

                        <div class="form-group">
                            <label>Hire Date</label>
                            <input type="datetime-local" class="form-control"  name="HireDate" placeholder="Hire Date"  required />
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="username"  required />
                        </div>

                        <div class="form-group">
                                <label>Password: </label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required />
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address"  class="form-control"  placeholder="Address" required />
                        </div>               

                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" </div>

                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" placeholder="State"  </div>

                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country"  required />
                        </div>

                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" class="form-control" name="postalCode" placeholder="Post Code"  required />                
                        </div>

                        <div class="form-group">
                            <label>HomePhone</label>
                            <input type="text" class="form-control" name="HomePhone" placeholder="Phone"  required />
                        </div>  
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" class="form-control" name="Salary" placeholder="Salary"  required />
                        </div>                     

                        <input type="submit" class = "login-button"  name="submit" value="Add" />
                        <input type='reset' class = "login-button" value='Clear Form' /> 

                    </form>
                </div>
            </div>
    <?php } ?> 

            </div>
        </div>
    </div>
</body>

</html>
