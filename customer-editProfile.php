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
    <title>Customer EditProfile</title>
    <!-- Local Css file -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body>
    <div class="contine" r>
        <div class="row">
            <div class="col-sm-3 employee-left">
                <?php require('customer-left-button.php'); ?>
            </div>
            <div class="col-sm-9 employee-right">

            <?php
                require('db.php');
                // If form submitted, insert values into the database.
                if (isset($_REQUEST['username']) && !empty($_POST['submit'])){
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    //$trn_date = date("Y-m-d H:i:s");
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
                    $ContactName = $fName." ".$lName;

                    $query = "UPDATE `customers` 
                                    SET Email = '$email', 
                                            fName = '$fName', 
                                            lName = '$lName',
                                            ContactName = '$ContactName', 
                                            companyName = '$companyName', 
                                            Address = '$address', 
                                            City = '$city', 
                                            Region = '$state', 
                                            PostalCode = '$postalCode', 
                                            Country = '$country', 
                                            Phone = '$phone', 
                                            Fax = '$fax'
                                    WHERE CustomerID = '$username' 
                                    ";

                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                        
                    if($result){
                        echo "<div class='form'>
                                    <h3>Profile updated.</h3>
                                    <br/>Click here to <a href='customer-main.php'>Back</a></div>";
                        }
                }else{
            ?>
            <div class = "row">
                <div class = "col-sm-6">
                    <form name="registration" action="" method="post">

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control"  name="Name" placeholder="First Name" value= "<?php echo $row['fName'] ?> " required />
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control"  name="lName" placeholder="Last Name" value= "<?php echo $row['lName'] ?> " required />
                        </div>

                        <div class="form-group">
                            <label>Company Name</label>
                            <?php 
                                $companyName = $row['CompanyName'] ;
                                if( $companyName == "NULL"){
                                    echo " <input type= 'text' class='form-control' name= 'companyName' placeholder='Company' /> ";
                                }else{
                                    echo " <input type= 'text'  class='form-control' name= 'companyName' placeholder='Company'  value = '$companyName' /> ";
                                }

                            ?>
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="username" value= "<?php echo $row['CustomerID'] ?>" disabled />
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value= "<?php echo $row['Email'] ?> " required />
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address"  class="form-control"  placeholder="Address" value= "<?php echo $row['Address'] ?>  " required />
                        </div>               

                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" name="city" placeholder="City" value= "<?php echo $row['City'] ?> re"quired />
                        </div>

                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" name="state" placeholder="State" value= "<?php echo $row['Region'] ?> "required />
                        </div>

                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" class="form-control" name="country" placeholder="Country" value= "<?php echo $row['Country'] ?>" required />
                        </div>

                        <div class="form-group">
                            <label>Zip Code</label>
                            <input type="text" class="form-control" name="postalCode" placeholder="Post Code" value= <?php echo $row['PostalCode'] ?> required />                
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone" value= <?php echo $row['Phone'] ?> required />
                        </div>

                        <div class="form-group">
                            <label>Fax</label>
                           <input type="text"  class="form-control" name="fax" placeholder="Fax" value= "<?php echo $row['Fax'] ?>" required />
                        </div>

                        <input type="submit" class = "login-button"  name="submit" value="Edit" />
                        <input class = "login-button" name="Back" type="submit" value="Cancel" />

                    </form>
                </div>
            </div>
    <?php } ?> 
    <?php 
        if(!empty($_POST['Back'])){
            echo '<script type="text/javascript">
                    window.location = "customer-main.php"
                     </script>';
        exit;
        }
    ?>               
            </div>
        </div>
    </div>
</body>

</html>
