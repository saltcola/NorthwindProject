<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit(); 
    }else{
        $CustomerID = $_SESSION["username"];
       
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer</title>
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
                <div class="btn-group-vertical" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" onClick="location.href='customer-main.php'">View Profile</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-editProfile.php'">Edit Profile</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-searchScreen.php'">Search/Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-shoppingCart.php'">Shopping Cart</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-payment.php'">Edit Payment</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-EditAddress.php'">Edit Order Address</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-pendingOrder.php'">Pending Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-completedOrder.php'">Completed Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='logout.php'">Logout</button>
                </div>
            </div>
            <div class="col-sm-8 employee-right">
                <?php 
                    require('db.php');


                    $query = "SELECT * FROM customers 
                    WHERE CustomerID = '$CustomerID' ";

                    // echo $query;
                    // echo "<br>";

                    $result = NULL;
                    $result = $mysqlConnection->query($query);


                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        $row = $result->fetch_assoc();
                        $ContactName = $row['ContactName'];
                    }

                    
                    $query = "SELECT * FROM `ORDERS` 
                                    WHERE CustomerID = '$CustomerID' 
                                    AND ShipVia IS NULL ";
                    // echo $query;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
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
                        <h2> There is no pending order right now.</h2>
                        ";
                    }

                    foreach($array as $order){
                        $OrderID = $order['OrderID'];
                        $OrderDate = $order['OrderDate'];
            ?>
                <div class = "payment-box">
                    <?php
                        echo "<h4>Order Number : $OrderID</h4>";
                        //echo "<br>";
                        echo "Order Date-Time: $OrderDate";
                        echo "<br>";
                        $query = "SELECT * FROM `order details`
                                        WHERE OrderID = '$OrderID' ";
                        // echo $query;
                        // echo "<br>";
                        $result = NULL;
                        $result = $mysqlConnection->query($query);
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count = $result -> num_rows;
                            echo "Total Items: $count";
                            echo "<br>";
                            echo "-----------------------------------------------------";
                            echo "<br>";
                            $array = array();
                            while($row = $result->fetch_assoc()) $array[] = $row;
                        }
                        foreach ( $array as $item ) {
                            $ProductID = $item['ProductID'];
                            $UnitPrice = $item['UnitPrice'];
                            $Quantity = $item['Quantity']; 
                            $Discount = $item['Discount'];
                            $TotalPrice = $UnitPrice * $Quantity * (1 - $Discount );
                            $query = "SELECT * FROM `products` WHERE ProductID = '$ProductID' ";
                            // echo $query;
                            // echo "<br>";    

                            $result = NULL;
                            $result = $mysqlConnection->query($query);
                            if (!$result) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {

                                $count = $result -> num_rows;
                                // echo $count;
                                // echo "<br>";
                                $product = $result->fetch_assoc();
                                $ProductName = $product['ProductName'];
                                $SupplierID = $product['SupplierID'];
                                $CategoryID = $product['CategoryID'];
                                $QuantityPerUnit = $product['QuantityPerUnit'];
                                $UnitsInStock = $product['UnitsInStock'];
                                $UnitsOnOrder = $product['UnitsOnOrder'];
                                $Discontinued = $product['Discontinued'];

                                echo "Product Name: $ProductName";
                                echo "<br>";
                                echo "Quantity Per Unit: $QuantityPerUnit";
                                echo "<br>";
                                echo "Quantity: $Quantity";
                                echo "<br>";
                                echo "Unit Price: $UnitPrice";
                                echo "<br>"; 
                                echo "Total Price: $TotalPrice";
                                echo "<br>"; 
                                echo "---------------SHIPPING ADDRESS---------------------";
                                echo "<br>"; 

                                //echo address if it has already added

                                $query = "SELECT ShipAddrID FROM `ProductsToAddress` 
                                                WHERE ProductID = '$ProductID'
                                                AND OrderID = '$OrderID'
                                                ";
                                // echo $query;
                                //  echo "<br>";  
                                 $result = NULL;
                                $result = $mysqlConnection->query($query);
                                    
                                if (!$result) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else { 
                                    $row = $result->fetch_assoc();
                                    $ShipAddrID = $row['ShipAddrID'];

                                    $query = "SELECT * FROM `ShipAddresses`
                                                    WHERE ShipAddrID = '$ShipAddrID' ";
                                    //  echo $query;
                                    // echo "<br>"; 
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);
                                        
                                    if (!$result) {
                                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                    } else { 
                                        $countForAddr = $result -> num_rows;
                                        $AddressRow = $result->fetch_assoc();
                                    }

                                }
                                if($countForAddr == 1){
                                    $ShipName = $AddressRow['ShipName'];
                                    $ShipAddress = $AddressRow['ShipAddress'];
                                    $ShipCity = $AddressRow['ShipCity'];
                                    $ShipState = $AddressRow['ShipState'];
                                    $ShipPostalCode = $AddressRow['ShipPostalCode'];
                                    $ShipCountry = $AddressRow['ShipCountry'];
                                    echo "Name: $ShipName";
                                    echo "<br>";
                                    echo "Address: $ShipAddress";
                                    echo "<br>";
                                    echo "City: $ShipCity";
                                    echo "<br>";
                                    echo "State: $ShipState";
                                    echo "<br>"; 
                                    echo "Postal Code: $ShipPostalCode";
                                    echo "<br>"; 
                                    echo "Country: $ShipCountry";
                                    echo "<br>"; 
                                }else{
                                    echo "Shipping Address is not added yet.";
                                    echo "<br>"; 
                                }


                                echo"
                                        <form method = 'post'>
                                            <div class='form-group'>
                                                    <label>Address: </label>
                                                    <input type='text' class='form-control' name='address' placeholder='Address' required />
                                            </div>
                                            <div class='form-group'>
                                                    <label>City: </label>
                                                    <input type='text' class='form-control' name='city' placeholder='City' required />
                                            </div>
                                            <div class='form-group'>
                                                    <label>State: </label>
                                                    <input type='text' class='form-control' name='state' placeholder='State' required />
                                            </div>
                                            <div class='form-group'>
                                                    <label>Post Code: </label>
                                                    <input type='text' class='form-control' name='postalCode' placeholder='Post Code' required />
                                            </div>
                                            <div class='form-group'>
                                                    <label>Country: </label>
                                                    <input type='text' class='form-control' name='country' placeholder='Country' required />
                                            </div>
                                            <div class='form-group'>
                                                  <label for='sel1'>Shipment Type</label>
                                                  <select class='form-control' name = 'ShipmentTypeID' id = 'sel1'>
                                                        <option value = '1'>Ground</option>
                                                        <option value = '2'>Air</option>
                                                        <option value = '3'>Sea</option>
                                                  </select>
                                            </div>
                                            <div class='form-group'>
                                                  <label for='sel1'>Card Type</label>
                                                  <select class='form-control' name = 'DeliveryTypeID' id = 'sel1'>
                                                        <option value = '1'>Over Night</option>
                                                        <option value = '2'>Two Day</option>
                                                        <option value = '3'>Other</option>
                                                  </select>
                                            </div>
                                            <input type = 'hidden' name = 'hiddenProductID'  value =  ' ".$ProductID." ' />
                                            <input type = 'hidden' name = 'hiddenOrderID'  value =  ' ".$OrderID." ' />
                                            <input type = 'hidden' name = 'hiddenOrderDate' value =  ' ".$OrderDate." '/>
                                            <input type='submit' name='AddAddress' value='Edit' />
                                            <input type='reset' value='Clear Form' /> 
                                        </form>
                                ";
                                echo "-----------------------------------------------------------------------------------------";
                                echo "<br>"; 
                            }
                        }
                    ?> 
                </div>
              <?php  }    

                 // for Address

                if (!empty($_POST['AddAddress'])){
                    $ProductID = $_POST['hiddenProductID'];
                    $OrderID = $_POST['hiddenOrderID'];
                    $OrderDate = $_POST['hiddenOrderDate'];
                    $Address = $_POST['address'];
                    $City = $_POST['city'];
                    $State = $_POST['state'];
                    $PostCode = $_POST['postalCode'];
                    $Country = $_POST['country'];
                    $ShipmentTypeID = $_POST['ShipmentTypeID'];
                    $DeliveryTypeID = $_POST['DeliveryTypeID'];
        

                    // echo $OrderID;
                    // echo "<br>";
                    // echo $OrderDate;
                    // echo "<br>";
                    // echo $Address;
                    // echo "<br>";
                    // echo $City;
                    // echo "<br>";
                    // echo $State;
                    // echo "<br>";
                    // echo $PostCode;
                    // echo "<br>";
                    // echo $Country;
                    // echo "<br>";
                    // echo $ShipmentTypeID;
                    // echo "<br>";
                    // echo $DeliveryTypeID;
                    // echo "<br>";

                    $query = "INSERT INTO `Shipments` (OrderID, RequiredDate) VALUES ( '$OrderID', '$OrderDate') ";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                        
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        $ShipmentsID = $mysqlConnection->insert_id;
                        $query = "INSERT INTO `ShipAddresses`(
                        ShipmentsID,RequiredDate, ShipName, ShipAddress, ShipCity, ShipRegion, ShipPostalCode, ShipCountry) VALUES ('$ShipmentsID', '$OrderDate', '$ContactName', '$Address', '$City', '$State', '$PostCode', '$Country')";

                        // echo $query;
                        // echo "<br>";

                        $result = NULL;
                        $result = $mysqlConnection->query($query);
                            
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $ShipAddrID = $mysqlConnection->insert_id;

                            $query = "INSERT INTO `ProductsToAddress` (OrderID, ShipmentsID, ShipAddrID, ProductID, ShipmentTypeID, DeliveryTypeID) VALUES ('$OrderID','$ShipmentsID','$ShipAddrID','$ProductID','$ShipmentTypeID','$DeliveryTypeID' )";
                            // echo $query;
                            // echo "<br>";
                            $result = NULL;
                            $result = $mysqlConnection->query($query);
                                
                            if (!$result) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {

                            }
                        }
                    }
                }
                 $mysqlConnection->close();
              ?>   
                
      
            </div>
        </div>
    </div>
</body>

</html>
