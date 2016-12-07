<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: employee-login.php");
        exit(); 
    }else{

        $OrderID = $_GET['id'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order</title>
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
                <?php require('employee-left-button.php'); ?>
            </div>
            <div class="col-sm-9 employee-right">
            <div class = "payment-box">
    <?php 
        require('db.php');
        // for payment method
        $username = $_SESSION["username"];
        $query = "SELECT * FROM `ORDERS`
                        WHERE OrderID = '$OrderID' ";
        $result = NULL;
        $result = $mysqlConnection->query($query);
        if (!$result) {
            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
        } else {
            $row = $result->fetch_assoc();
            $OrderDate = $row['OrderDate'];
        }

        echo "<h4>Order Number : $OrderID</h4>";
        //echo "<br>";
        echo "Order Date-Time: $OrderDate";
        echo "<br>";

        $query = "SELECT * FROM `Payment`
                        WHERE OrderID = '$OrderID' ";
        $result = NULL;
        $result = $mysqlConnection->query($query);
        if (!$result) {
            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
        } else {
            $row = $result->fetch_assoc();
            $Total = $row['Total'];
            $PaymentTypeID = $row['PaymentTypeID'];
            switch ($PaymentTypeID) {
                case 1 :
                    $PaymentType = "Android Pay";
                    break;
                case 2 :
                    $PaymentType = "Apple Pay";
                    break;
                case 3 :
                    $PaymentType = "Credit Card";
                    break;
                case 4 :
                    $PaymentType = "Debit Card";
                    break;
                case 5 :
                    $PaymentType = "Paypall";
                    break;
                case 6 :
                    $PaymentType = "Bank Account";
                    break;
            }
        }
        // for order details
        $query = "SELECT * FROM `order details` WHERE OrderID = $OrderID ";
        $result = NULL;
        $result = $mysqlConnection->query($query);
        if (!$result) {
            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
        } else {
            $array = array();
            while($row = $result->fetch_assoc()) $array[] = $row;
        }

        echo "Total Price: $Total";
        echo "<br>";
        echo "Payment Method: $PaymentType";
        echo "<br>";
        echo "-----------------------------------------------------";
        echo "<br>";

        foreach($array as $item){
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
                echo "---------------SHIPPING ADDRESS--------------";
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
                    $ShipState = $AddressRow['ShipRegion'];
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
                    require('WarningShippingAddress.php');
                }
                
                echo "--------------------------------------------------------------------------------------";
                echo "<br>"; 
            }
        }
        if (!empty($_POST['Complete'])){
            $ShipperID = $_POST['ShipperID'];
            $query = "SELECT * FROM `employees`WHERE username = '$username' ";

            // echo $query;
            // echo "<br>";

            $result = NULL;
            $result = $mysqlConnection->query($query);
            if (!$result) {
                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
            } else {
                $row = $result->fetch_assoc();
                $EmployeeID = $row['EmployeeID'];
                // echo $EmployeeID;
                // echo "<br>";

                $query = "UPDATE `ORDERS` 
                                SET EmployeeID = '$EmployeeID',
                                        ShipVia = '$ShipperID'
                                WHERE OrderID = '$OrderID'
                ";

                // echo $query;
                // echo "<br>";
                $result = NULL;
                $result = $mysqlConnection->query($query);
                if (!$result) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $ShippedDate = date("Y-m-d H:i:s");
                    $query = "SELECT ShipmentsID FROM `ProductsToAddress` WHERE OrderID = '$OrderID'
                    ";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        $array = array();
                        while($row = $result->fetch_assoc()) $array[] = $row;
                    }
                    foreach($array as $order){
                        $ShipmentsID = $order['ShipmentsID'];

                        $query = "UPDATE `ShipAddresses` 
                                        SET ShippedDate = '$ShippedDate',
                                                ShipVia = '$ShipperID'
                                        WHERE ShipmentsID = '$ShipmentsID'
                        ";
                        $result = NULL;
                        $result = $mysqlConnection->query($query);
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } 
                    }
                }
            }
            echo "<script>
                            alert('Order Completed');
                            window.location.href='employee-ListofActiveOrder.php';
                            </script>";
        }        
    ?>
    <form  class="form-inline" method = "post" >
        <div class="form-group">
              <label for="sel1">Ship Via</label>
              <select class="form-control" name = "ShipperID" id = "sel1">
                    <option value = "1" >Speedy Express</option>
                    <option value = "2" >United Package</option>
                    <option value = "3" >Federal Shipping</option>
              </select>
        </div>
        <input type="submit" class = "login-button" name="Complete" value="Complete Order" />
    </form>
    
    </div>
            </div>
        </div>
    </div>

</body>