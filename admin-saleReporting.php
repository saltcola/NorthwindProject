<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    require('db.php');
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
    <title>Admin</title>
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
                <?php require('admin-left-button.php') ?>
            </div>
            <div class="col-sm-9 employee-right">
                 <div class = "payment-box">
                  <form method="post">
                    <div class="form-group">
                            <label>Search By Time</label>
                            <div class = "row">
                                <div class = "col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">From</span>
                                        <input type="datetime-local" class="form-control"  name="StartDate" required />
                                    </div>                            
                                </div>
                                <div class = "col-sm-5">
                                    <div class="input-group">
                                        <span class="input-group-addon">To</span>
                                        <input type="datetime-local" class="form-control"  name="EndDate" required />
                                    </div>
                                </div>
                                <div class = "col-sm-2">
                                    <input type="submit" name="SearchByTime" value="Search" />
                                </div>
                            </div>
                        </div>
                  </form>
              </div>
                 <div class = "payment-box">
                    <label>Search By Shipping Location</label>
                    <form  method="post">
                        <div class = "row">
                            <div class = "col-sm-3">
                                <select class="form-control" name = "Country" id = "sel1" >
                                    <option value="0">0-Country</option>
                                <?php 
                                    $query = "SELECT country_name FROM `apps_countries` ";
                                    require('admin-toArray.php');
                                    foreach($array as $country){
                                        $country_name = $country['country_name'];
                                        echo "<option >$country_name</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-3">
                                <select class="form-control" name = "State" id = "sel1">
                                    <option value="0">0-State In USA</option>
                                <?php 
                                    $query = "SELECT DISTINCT state_code FROM `cities` ";
                                    require('admin-toArray.php');
                                    foreach($array as $state){
                                        $state_code = $state['state_code'];
                                        echo "<option  >$state_code</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-3">
                                <select class="form-control" name = "City" id = "sel1">
                                <option value="0">0-City In USA</option>
                                <?php 
                                    $query = "SELECT DISTINCT city FROM `cities` ";
                                    require('admin-toArray.php');
                                    foreach($array as $city){
                                        $city = $city['city'];
                                        echo "<option  >$city</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-2">
                                    <input type="submit" name="SearchByLocation" value="Search" />
                                </div>
                        </div>
                    </form>                    
                </div>

                <div class = "payment-box">
                    <label>Search By Customer</label>
                    <form  method="post">
                        <div class = "row">
                            <div class = "form-group col-sm-5">
                                <input type="text" name="ContactName" class="form-control" placeholder="Customer Contact Name"/>
                            </div>  
                        </div>
                        
                        <div class = "row">
                            <div class = "col-sm-3">
                                <select class="form-control" name = "Country" id = "sel1" >
                                    <option value="0">0-Country</option>
                                <?php 
                                    $query = "SELECT country_name FROM `apps_countries` ";
                                    require('admin-toArray.php');
                                    foreach($array as $country){
                                        $country_name = $country['country_name'];
                                        echo "<option >$country_name</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-3">
                                <select class="form-control" name = "State" id = "sel1">
                                    <option value="0">0-State In USA</option>
                                <?php 
                                    $query = "SELECT DISTINCT state_code FROM `cities` ";
                                    require('admin-toArray.php');
                                    foreach($array as $state){
                                        $state_code = $state['state_code'];
                                        echo "<option  >$state_code</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-3">
                                <select class="form-control" name = "City" id = "sel1">
                                <option value="0">0-City In USA</option>
                                <?php 
                                    $query = "SELECT DISTINCT city FROM `cities` ";
                                    require('admin-toArray.php');
                                    foreach($array as $city){
                                        $city = $city['city'];
                                        echo "<option  >$city</option> ";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class = "col-sm-2">
                                    <input type="submit" name="SearchByCustomer" value="Search" />
                                </div>
                        </div>
                    </form>
                </div>

                <div class = "payment-box">
                  <form method="post">
                    <div class="form-group">
                            <label>Search By Product</label>
                    </div>
                    </form>
                </div>

            </div>            
        </div>

<?php 
$array = array();


if(!empty($_POST['SearchByTime'])){
    $StartDate = date("Y-m-d H:i:s", strtotime($_POST['StartDate']));
    $EndDate = date("Y-m-d H:i:s", strtotime($_POST['EndDate']));
    // echo $StartDate;
    // echo "<br>";
    // echo $EndDate;
    // echo "<br>";
    if ($StartDate > $EndDate){
        echo '<script type="text/javascript">
                    alert("Your Time input is not valid!");
                    window.location = "admin-saleReporting.php"
                     </script>';
        exit();
    }else{
        $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE OrderDate >= '$StartDate' AND OrderDate <= '$EndDate'
        ) ";
        // echo $query;
        // echo "<br>";
        require('admin-toArray.php');
    }

}
if(!empty($_POST['SearchByLocation'])){
    $Country = $_POST['Country'];
    $Region = $_POST['State'];
    $City = $_POST['City'];
    // echo $Country;
    // echo "<br>";
    // echo $Region;
    // echo "<br>";
    // echo $City;
    // echo "<br>";
    if($Country == "0"){
        echo '<script type="text/javascript">
                    alert("No Country Input!");
                    window.location = "admin-saleReporting.php"
                     </script>';
            exit();
    }else if($Country == "USA"){
         if($Region == "0" && $City == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `Shipments` WHERE ShipmentsID IN(SELECT ShipmentsID FROM `ShipAddresses` WHERE ShipCountry = '$Country')) ";
                require('admin-toArray.php');
         }else if($Region == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `Shipments` WHERE ShipmentsID IN(SELECT ShipmentsID FROM `ShipAddresses` WHERE ShipCountry = '$Country' AND ShipCity = '$City' )) ";
                require('admin-toArray.php');
         }else if($City == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `Shipments` WHERE ShipmentsID IN(SELECT ShipmentsID FROM `ShipAddresses` WHERE ShipCountry = '$Country' AND ShipRegion = '$Region')) ";
                require('admin-toArray.php');
         }else{
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `Shipments` WHERE ShipmentsID IN(SELECT ShipmentsID FROM `ShipAddresses` WHERE ShipCountry = '$Country' AND ShipRegion = '$Region' AND ShipCity = '$City' )) ";
                require('admin-toArray.php');
         }
    }else if($Region == "0" && $City == "0"){
        $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `Shipments` WHERE ShipmentsID IN(SELECT ShipmentsID FROM `ShipAddresses` WHERE ShipCountry = '$Country')) ";
        require('admin-toArray.php');
    }else{
        echo '<script type="text/javascript">
                    alert("Input City or State is not in USA!");
                    window.location = "admin-saleReporting.php"
                     </script>';
        exit();
    }  
}

if(!empty($_POST['SearchByCustomer'])){
    $Country = $_POST['Country'];
    $Region = $_POST['State'];
    $City = $_POST['City'];
    $ContactName = $_POST['$ContactName'];
    // echo $Country;
    // echo "<br>";
    // echo $Region;
    // echo "<br>";
    // echo $City;
    // echo "<br>";
    if($Country == "0"){
        echo '<script type="text/javascript">
                    alert("No Country Input!");
                    window.location = "admin-saleReporting.php"
                     </script>';
            exit();
    }else if($Country == "USA"){
         if($Region == "0" && $City == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE CustomerID IN(SELECT CustomerID FROM `customers` WHERE Country = '$Country')) ";
                require('admin-toArray.php');
         }else if($Region == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE CustomerID IN(SELECT CustomerID FROM `customers` WHERE Country = '$Country' AND City = '$City' )) ";
                require('admin-toArray.php');
         }else if($City == "0"){
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE CustomerID IN(SELECT CustomerID FROM `customers` WHERE Country = '$Country' AND Region = '$Region')) ";
                require('admin-toArray.php');
         }else{
                $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE CustomerID IN(SELECT CustomerID FROM `customers` WHERE Country = '$Country' AND Region = '$Region' AND City = '$City' )) ";
                require('admin-toArray.php');
         }
    }else if($Region == "0" && $City == "0"){
        $query = "SELECT * FROM `order details` WHERE OrderID IN (SELECT OrderID FROM `ORDERS` WHERE CustomerID IN(SELECT CustomerID FROM `customers` WHERE Country = '$Country')) ";
        require('admin-toArray.php');
    }else{
        echo '<script type="text/javascript">
                    alert("Input City or State is not in USA!");
                    window.location = "admin-saleReporting.php"
                     </script>';
        exit();
    }  
}


?>

        <div class = "row">
            <div class = "col-sm-1"></div>
            <div class = "col-sm-10">
                <table class="table">
                    <thead>
                      <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Order By</th>
                        <th>Customer Location</th>
                        <th>Product Name</th>
                        <th>Supplier Name</th>
                        <th>Unit Price</th>
                        <th>Total Units Sold</th>
                        <th>Total Price Sold</th>
                        <th>ShipTo<th>
                        <th>ShipBy<th>
                      </tr>
                    </thead>
                   
                    <?php foreach ($array as $order) { 
                                $OrderID = $order['OrderID'];
                                $ProductID = $order['ProductID'];
                                $UnitPrice = $order['UnitPrice'];
                                $Quantity = $order['Quantity'];
                                $Discount = $order['Discount'];


                                $searchQuery1 = "SELECT * FROM `ORDERS` WHERE OrderID = '$OrderID'
                                ";
                                // echo $searchQuery1;
                                
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                        //$count = $resultSup -> num_rows;
                                        $row = $resultSup->fetch_assoc();
                                        // echo $count;
                                        // echo "<br>";
                                }

                                $OrderDate = $row['OrderDate'];
                                $CustomerID = $row['CustomerID'];
                                $ShipViaID = $row['ShipVia'];

                                switch ($ShipViaID) {
                                    case 1:
                                        $ShipVia = "Speedy Express";
                                        break;
                                    case 1:
                                        $ShipVia = "United Package";
                                        break;
                                    case 1:
                                        $ShipVia = "Federal Shipping";
                                        break;
                                }

                                $searchQuery1 = "SELECT * FROM `customers` WHERE CustomerID = '$CustomerID'
                                ";
                                // echo $searchQuery1;
                                
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                        //$count = $resultSup -> num_rows;
                                        $row = $resultSup->fetch_assoc();
                                        // echo $count;
                                        // echo "<br>";
                                }

                                $ContactName = $row['ContactName'];
                                $Location = $row['City']." ".$row['Region']." ".$row['Country'];



                                $searchQuery1 = "SELECT ProductName, SupplierID FROM `products` WHERE ProductID = '$ProductID'
                                ";
                                // echo $searchQuery1;
                                
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                        //$count = $resultSup -> num_rows;
                                        $row = $resultSup->fetch_assoc();
                                        // echo $count;
                                        // echo "<br>";
                                }

                                $ProductName = $row['ProductName'];
                                $TotalPrice = $UnitPrice * $Quantity*(1-$Discount);

                                $SupplierID = $row['SupplierID'];

                                $searchQuery1 = "SELECT CompanyName FROM `Company` WHERE CompanyID = '$SupplierID'
                                ";
                                // echo $searchQuery1;
                                
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                        //$count = $resultSup -> num_rows;
                                        $row = $resultSup->fetch_assoc();
                                        // echo $count;
                                        // echo "<br>";
                                }
                                $CompanyName = $row['CompanyName'];

                                $searchQuery1 = "SELECT ShipmentsID FROM `ProductsToAddress` WHERE OrderID = '$OrderID' AND ProductID = '$ProductID'
                                ";
                                // echo $searchQuery1;
                                //  echo "<br>";
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {                                     
                                        $row = $resultSup->fetch_assoc();
                                        // $count = $resultSup -> num_rows;
                                        // echo $count;
                                        // echo "<br>";
                                }

                                $ShipmentsID = $row['ShipmentsID'];
                                // echo $ShipmentsID;
                                // echo "<br";
                                $searchQuery1 = "SELECT ShipCity, ShipRegion, ShipCountry FROM `ShipAddresses` WHERE ShipmentsID = '$ShipmentsID'
                                ";
                                //echo $searchQuery1;
                                
                                $resultSup = NULL;
                                $resultSup = $mysqlConnection->query($searchQuery1);
                                if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                        //$count = $resultSup -> num_rows;
                                        $row = $resultSup->fetch_assoc();
                                        // echo $count;
                                        // echo "<br>";
                                }

                                $ShipTo = $row['ShipCity']." ".$row['ShipRegion']." ".$row['ShipCountry'];

                
                    ?>
                     <tbody>
                    <tr> 
                        <td><?php echo $OrderID ?></td>
                        <td><?php echo $OrderDate ?></td>
                        <td><?php echo $ContactName ?></td>
                        <td><?php echo $Location ?></td>
                        <td><?php echo $ProductName  ?></td>
                        <td><?php echo $CompanyName  ?></td>
                        <td><?php echo $UnitPrice ?></td>
                        <td><?php echo $Quantity ?></td>
                        <td><?php echo $TotalPrice ?></td>
                        <td><?php echo $ShipTo ?></td>
                        <td><?php echo $ShipVia ?></td>
                    </tr>
                    </tbody>
                        <?php } ?>
                      
                </table>  
            </div>
        </div>
    </div>
</body>

</html>
