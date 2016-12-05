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
            <div class="col-sm-2 employee-left">
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
            <div class="col-sm-9 employee-right">
            <?php 
                if (!empty($_POST['EditCart']))
                {
                    $CartOption = False;
                    $UnitsInStock = $_POST['hiddenInStock'];
                    $id = $_POST['hiddenID'];
                    $Quantity = $_POST['Quantity'];
                    $RequireDate = date("Y-m-d H:i:s");
                    $ProductID = $_POST['hiddenProductID'];
                    $UnitsOnOrder = $_POST['hiddenUnitsOnOrder'];
                    $UnitsOldOrder = $_POST['hiddenUnitsOldOrder'];
                    // echo $id;
                    // echo "<br>";                    
                    // echo $Quantity;
                    // echo "<br>";
                    // echo $UnitsInStock;
                    // echo "<br>";
                    // echo $UnitsOldOrder;
                    // echo "<br>";
                    // echo $Quantity;
                    // echo "<br>";
                    if($Quantity <= 0 || $Quantity > $UnitsInStock)
                    {
                        echo "<script>
                                alert('Quantity is not valid!');
                                window.location.href='customer-shoppingCart.php';
                                </script>";
                    }
                    else
                    {
                        require('db.php');
                        $queryForCart = "UPDATE `Shoppingcart`
                                                    SET Quantity = '$Quantity',
                                                            RequireDate = '$RequireDate'
                                                    WHERE id = '$id'
                                                    ";
                        // echo $queryForCart;
                        // echo "<br>";
                        $result = NULL;
                        $result = $mysqlConnection->query($queryForCart);
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        }else{
                            // echo "CART UPDATED";
                            // echo "<br>";
                            $CartOption = True;
                        }
                        if($CartOption){

                            $UnitsLeft = $UnitsInStock + $UnitsOldOrder - $Quantity;
                            $UnitsOnOrder = $UnitsOnOrder + $Quantity;
                            $queryForProduct = "UPDATE `products`
                                            SET UnitsInStock = '$UnitsLeft',
                                                    UnitsOnOrder = '$UnitsOnOrder'
                                            WHERE ProductID = '$ProductID'
                            ";

                            // echo $queryForProduct;
                            // echo "<br>";

                            $result = NULL;
                            $result = $mysqlConnection->query($queryForProduct);
                            if (!$result) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                echo "<script>
                                    alert('Shopping Cart Updated');
                                    window.location.href='customer-shoppingCart.php';
                                    </script>";
                            }                    
                            $mysqlConnection->close();
                        }
                    }
                }
                if (!empty($_POST['Remove']))
                {
                    $CartOption = False;
                    $UnitsInStock = $_POST['hiddenInStock'];
                    $id = $_POST['hiddenID'];
                    $ProductID = $_POST['hiddenProductID'];
                    $UnitsOnOrder = $_POST['hiddenUnitsOnOrder'];
                    $UnitsOldOrder = $_POST['hiddenUnitsOldOrder'];
                    // $UnitsInStock;
                    // echo "<br>";
                    // echo $UnitsOldOrder;
                    // echo "<br>";
                    require('db.php');
                    $query = "DELETE FROM `Shoppingcart` WHERE id = '$id' ";
                    // echo $query;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        $UnitsUpdate = $UnitsInStock + $UnitsOldOrder;
                        $UnitsOnOrder = $UnitsOnOrder - $UnitsOldOrder;

                        // echo $UnitsUpdate;
                        // echo "<br>";
                        // echo $UnitsOnOrder;
                        // echo "<br>";

                        $queryForProduct = "UPDATE `products`
                                            SET UnitsInStock = '$UnitsUpdate',
                                                    UnitsOnOrder = '$UnitsOnOrder'
                                            WHERE ProductID = '$ProductID'
                            ";
                        $result = NULL;
                        $result = $mysqlConnection->query($queryForProduct);
                        if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        }else{
                            echo "<script>
                                    alert('Item Removed');
                                    window.location.href='customer-shoppingCart.php';
                                    </script>";
                        }
                    }

                    $mysqlConnection->close();

                }

            ?>
              <table class="table">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Quantity Per Unit</th>
                    <th>In Stock</th>
                    <th>Unit Price</th>
                    <th>In Cart</th>
                    <th>Total Price</th>
                    <th>Edit cart</th>
                  </tr>
                </thead>
                <?php
                    require('db.php');
                    $array = array();
                    $query = "SELECT * FROM `Shoppingcart` WHERE CustomerID = '$CustomerID' ";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                                $count = $result -> num_rows;
                                // echo $count;
                                // echo "<br>";
                                while($row = $result->fetch_assoc()) $array[] = $row;
                                $FinalPrice = 0;

                                $checkout = False;
                                if (!empty($_POST['Checkout']) && (!$checkout) ){
                                    $OrderDate = date("Y-m-d H:i:s");
                                    $query = "INSERT INTO `ORDERS`(CustomerID,OrderDate) VALUES ( '$CustomerID', '$OrderDate') ";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);
                                    if (!$result) {
                                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                    } else {
                                        $query = "SELECT OrderID FROM `ORDERS`
                                                        WHERE CustomerID = '$CustomerID'
                                                        AND OrderDate = '$OrderDate'
                                        ";
                                        $result = NULL;
                                        $result = $mysqlConnection->query($query);
                                        if (!$result) {
                                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                        } else {
                                            $row = $result->fetch_assoc();
                                            $OrderID = $row['OrderID'];
                                            $checkout = True;
                                        }
                                    }
                                }

                                foreach ($array as $order) {
                                    $id = $order['id'];                        
                                    $ProductID = $order['ProductID'];
                                    $RequireDate = $order['RequireDate'];
                                    $Quantity = $order['Quantity'];
                                    // $ProductID = $_POST['hiddenProductID'];

                                    // echo $id;
                                    // echo "<br>";
                                    // echo $ProductID;
                                    // echo "<br>";
                                    // echo $Quantity;
                                    // echo "<br>";

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
                                    }

                                    $ProductName = $product['ProductName'];
                                    $SupplierID = $product['SupplierID'];
                                    $CategoryID = $product['CategoryID'];
                                    $QuantityPerUnit = $product['QuantityPerUnit'];
                                    $UnitPrice = $product['UnitPrice'];
                                    $UnitsInStock = $product['UnitsInStock'];
                                    $UnitsOnOrder = $product['UnitsOnOrder'];
                                    $Discontinued = $product['Discontinued'];

                                    $TotalPrice = $Quantity*$UnitPrice;
                                    $FinalPrice = $FinalPrice + $TotalPrice;

                                    // echo $ProductName;
                                    // echo "<br>";
                                    // echo $SupplierID;
                                    // echo "<br>";
                                    // echo $CategoryID;
                                    // echo "<br>";
                                    // echo $QuantityPerUnit;
                                    // echo "<br>";
                                    // echo $UnitPrice;
                                    // echo "<br>";
                                    // echo $UnitsInStock;
                                    // echo "<br>";
                                    // echo $UnitsOnOrder;
                                    // echo "<br>";
                                    
                                    switch($CategoryID){
                                        case 1: $Category = "Beverages"; break;
                                        case 2: $Category = "Condiments"; break;
                                        case 3: $Category = "Confections"; break;
                                        case 4: $Category = "Dairy Products"; break;
                                        case 5: $Category = "Grains/Cereals"; break;
                                        case 6: $Category = "Meat/Poultry"; break;
                                        case 7: $Category = "Produce"; break;
                                        case 8: $Category = "Seafood"; break;
                                    }

                                    $searchQuery1 = "SELECT CompanyName FROM Company
                                                                WHERE CompanyID = ' ".$SupplierID." '
                                    ";
                                    // echo $searchQuery1;

                                    
                                    $resultSup = NULL;
                                    $resultSup = $mysqlConnection->query($searchQuery1);
                                    if (!$resultSup) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                    } else {
                                            $count = $resultSup -> num_rows;
                                            $row = $resultSup->fetch_assoc();
                                            // echo $count;
                                            // echo "<br>";
                                    }
                                
                        
                ?>
                <tbody>
                <tr>
                    <td><?php echo $ProductName?></td>                    
                    <td><?php echo $QuantityPerUnit?></td>
                    <td><?php echo $UnitsInStock?></td>
                    <td><?php echo $UnitPrice?></td>
                    <td><?php echo $Quantity ?></td>
                    <td><?php echo $TotalPrice?></td>
                    <td>
                        <form class="form-inline" method = "post">
                            <div class="form-group">
                                <input class = "col-xs-3 small-Input" align="left"  type="text" name="Quantity" value = 0  required />
                                <input type = 'hidden' name = 'hiddenID' value = <?php echo $id ?> />
                                <input type = 'hidden' name = 'hiddenInStock' value = <?php echo $UnitsInStock ?> />
                                <input type = 'hidden' name = 'hiddenProductID' value = <?php echo $ProductID ?> />
                                <input type = 'hidden' name = 'hiddenUnitsOnOrder' value = <?php echo $UnitsOnOrder ?> />
                                <input type = 'hidden' name = 'hiddenUnitsOldOrder' value = <?php echo $Quantity ?> />
                                <input type="submit" name="EditCart" value="Edit" />
                                <input type="submit" name="Remove" value="Remove" />
                            </div>
                        </form>
                    </td>
                    </tr>
                </tbody>
                    <?php 

                        if (!empty($_POST['Checkout']) && $checkout){                       
                            $query = "INSERT INTO `order details`(OrderID, ProductID, UnitPrice, Quantity, Discount) VALUES ( '$OrderID', '$ProductID','$UnitPrice', '$Quantity', 0) ";
                            // echo $query;
                            // echo "<br>";
                            $result = NULL;
                            $result = $mysqlConnection->query($query);
                            if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                $query = "DELETE FROM `Shoppingcart` WHERE id = '$id' ";
                                // echo $query;
                                // echo "<br>";
                                $result = NULL;
                                $result = $mysqlConnection->query($query);
                                if (!$result) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                } else {
                                    echo "<script>
                                        alert('Order Placed');
                                        window.location.href='customer-shoppingCart.php';
                                        </script>";
                                }

                            }

                        }
                   }} $mysqlConnection->close(); ?>
            </table> 
            <h4> Total Price : $ <?php echo $FinalPrice ?> </h4>
            <form  class="form-inline" method = "post" >
                <input type="submit" class = "login-button" name="Checkout" value="Place Order" />
            </form>
            </div>
        </div>
    </div>
</body>

</html>
