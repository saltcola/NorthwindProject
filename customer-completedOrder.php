<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: login.php");
        exit(); 
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
                <?php require('customer-left-button.php'); ?>
            </div>
            <div class="col-sm-9 employee-right">
              <?php 
                require('db.php');
                    
                    $query = "SELECT * FROM `ORDERS` 
                                    WHERE CustomerID = '$CustomerID' 
                                    AND EmployeeID IS NOT NULL 
                                    AND ShipVia IS NOT NULL ";
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
                        <h2> There is no Completed order right now.</h2>
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
                                echo "--------------------------------------------------------------------------------------";
                                echo "<br>"; 
                            }
                        }
                    ?>
                    <form class="form-inline" method = "post">
                            <div class="form-group">
                                <input type = 'hidden' name = 'hiddenOrderID' value = <?php echo $OrderID ?> />
                                <input type="submit" name="Remove" value="Remove" />
                            </div>
                    </form>    
                </div>
              <?php  }
           
                 if (!empty($_POST['Remove'])){
                    $OrderID =  $_POST['hiddenOrderID'];
                    $query = $query = "SELECT * FROM `order details`
                                        WHERE OrderID = '$OrderID' ";
                    // echo $query;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        // $count = $result -> num_rows;
                        // echo "Total Items: $count";
                        // echo "<br>";
                        // echo "-----------------------------------------------------";
                        // echo "<br>";
                        $array = array();
                        while($row = $result->fetch_assoc()) $array[] = $row;
                    }
                    foreach ( $array as $item )
                    {
                        $ProductID = $item['ProductID'];
                        $UnitPrice = $item['UnitPrice'];
                        $Quantity = $item['Quantity']; 
                        $Discount = $item['Discount'];

                        $query = "SELECT UnitsInStock, UnitsOnOrder FROM `products` WHERE ProductID = '$ProductID' ";
                        // echo $query;
                        // echo "<br>";
                        $result = NULL;
                        $result = $mysqlConnection->query($query);
                        
                        if (!$result) 
                        {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else 
                        {
                            $row = $result->fetch_assoc();
                            $UnitsInStock = $row['UnitsInStock'] + $Quantity;
                            $UnitsOnOrder = $row['UnitsOnOrder'] - $Quantity;

                            $query = "UPDATE `products` SET 
                                        UnitsInStock = '$UnitsInStock', UnitsOnOrder = '$UnitsOnOrder' WHERE ProductID = '$ProductID'
                            ";




                            // echo $row['UnitsInStock'] ;
                            // echo "<br>";
                            // echo $row['UnitsOnOrder'] ;
                            // echo "<br>";
                            // echo $Quantity;
                            // echo "<br>";
 
                            // echo $UnitsInStock;
                            // echo "<br>";
                            // echo $UnitsOnOrder;
                            // echo "<br>";
                        
                            // echo $query;
                            // echo "<br>";

                            $result = NULL;
                            $result = $mysqlConnection->query($query);
                            if (!$result) 
                            {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            }                              
                        }                        
                    }

                    // echo $OrderID;
                    // echo "<br>";
                    $multiQuery = "DELETE FROM `ORDERS` WHERE OrderID = $OrderID;
                                            DELETE FROM `order details` WHERE OrderID = $OrderID;
                    ";

                    // echo $multiQuery;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->multi_query($multiQuery);
                    if (!$result) 
                    {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else 
                    {
                        echo "<script>
                            alert('Order Removed');
                            window.location.href='customer-pendingOrder.php';
                            </script>";
                    }
                 }
              ?>
              
            </div>
        </div>
    </div>
</body>

</html>
