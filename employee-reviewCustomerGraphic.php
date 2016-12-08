
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
                <form method = "post" > 
                    <div class="form-group">
                        <label>Search By FIrst Name</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="FirstName" class="form-control" placeholder="First Name"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByFirstName" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Last Name</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="LastName" class="form-control" placeholder="Last Name"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByLastName" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Company</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Company" class="form-control" placeholder="Company"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByCompany" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Email</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Email" class="form-control" placeholder="Email"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByEmail" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Phone</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Phone" class="form-control" placeholder="Phone"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByPhone" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Fax</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Fax" class="form-control" placeholder="Fax"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByFax" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Address</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Address" class="form-control" placeholder="Address"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByAddress" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By City</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="City" class="form-control" placeholder="City"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByCity" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By State</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="State" class="form-control" placeholder="State"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByState" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Postal Code</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="PostalCode" class="form-control" placeholder="Postal Code"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByPostalCode" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Country</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="Country" class="form-control" placeholder="Country"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByCountry" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">                       
                        <input type="submit" name="SearchAll" value="List All" />
                    </div>                    
                </form>
            </div> <!--div for right side -->
<?php 
require('db.php');
$array = array();
if(!empty($_POST['SearchAll'])){
    $query = "SELECT * FROM `customers` ";
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

}
if(!empty($_POST['SearchByFirstName'])){
    $fName = $_POST['FirstName'];
    $query = "SELECT * FROM `customers` WHERE fName LIKE '%".$fName."%' ";
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

}
if(!empty($_POST['SearchByCountry'])){
    $Country = $_POST['Country'];
    $query = "SELECT * FROM `customers` WHERE Country LIKE '%".$Country."%' ";
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
    
}
if(!empty($_POST['SearchByPostalCode'])){
    $PostalCode = $_POST['PostalCode'];
    $query = "SELECT * FROM `customers` WHERE PostalCode LIKE '%".$PostalCode."%' ";
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
    
}
if(!empty($_POST['SearchByState'])){
    $State = $_POST['State'];
    $query = "SELECT * FROM `customers` WHERE State LIKE '%".$State."%' ";
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
    
}
if(!empty($_POST['SearchByCity'])){
    $City = $_POST['City'];
    $query = "SELECT * FROM `customers` WHERE City LIKE '%".$City."%' ";
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
    
}
if(!empty($_POST['SearchByAddress'])){
    $Address = $_POST['Address'];
    $query = "SELECT * FROM `customers` WHERE Address LIKE '%".$Address."%' ";
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
    
}
if(!empty($_POST['SearchByFax'])){
    $Fax = $_POST['Fax'];
    $query = "SELECT * FROM `customers` WHERE Fax LIKE '%".$Fax."%' ";
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
    
}
if(!empty($_POST['SearchByPhone'])){
    $Phone = $_POST['Phone'];
    $query = "SELECT * FROM `customers` WHERE Phone LIKE '%".$Phone."%' ";
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
    
}
if(!empty($_POST['SearchByEmail'])){
    $Email = $_POST['Email'];
    $query = "SELECT * FROM `customers` WHERE Email LIKE '%".$Email."%' ";
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
    
}
if(!empty($_POST['SearchByCompany'])){
    $Company = $_POST['Company'];
    $query = "SELECT * FROM `customers` WHERE Company LIKE '%".$Company."%' ";
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
    
}
if(!empty($_POST['SearchByLastName'])){
    $lName = $_POST['LastName'];
    $query = "SELECT * FROM `customers` WHERE LastName LIKE '%".$LastName."%' ";
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
    
}
?>

            
            <div class = "row">
                <div class = "col-sm-2"></div>
                <div class = "col-sm-9">
                    <table class="table">
                        <thead>
                          <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Fax</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Postal Code</th>
                            <th>Country</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
            <?php foreach ($array as $customer){
                            $fName = $customer['fName'];
                            $lName = $customer['lName'];
                            $companyName = $customer['CompanyName'];
                            $address = $customer['Address'];
                            $city = $customer['City'];
                            $state = $customer['Region'];
                            $postalCode = $customer['PostalCode'];
                            $country = $customer['Country'];
                            $phone = $customer['Phone'];
                            $fax = $customer['Fax'];
                            $email = $customer['Email'];
                            $username = $customer['CustomerID'];
            ?>
                        <tbody>
                            <tr>
                                <td><?php echo $fName?></td>
                                <td><?php echo $lName ?></td>
                                <td><?php echo $companyName ?></td>
                                <td><?php echo $email ?></td>
                                <td><?php echo $phone?></td>
                                <td><?php echo $fax?></td>
                                <td><?php echo $address?></td>
                                <td><?php echo $city?></td>
                                <td><?php echo $state?></td>
                                <td><?php echo $postalCode?></td>
                                <td><?php echo $country?></td>
                                <td>
                                    <?php 
                                    echo "<a href ='employee-editCustomer.php?id=".$username." '> Edit</a> ";
                                    ?>
                                </td>
                            </tr>
                        </tbody>
            <?php } ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
