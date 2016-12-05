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
    <?php
        if (!empty($_POST['addToCart'])){
            $ProductID = $_POST['hiddenAdd'];
            $UnitsInStock = $_POST['hiddenQua'];
            $UnitsOnOrder = $_POST['hiddenOnOrder'];
            $Quantity = $_POST['Quantity'];
            $RequireDate = date("Y-m-d H:i:s");
            $CartOption = False;

            if($Quantity <= 0 || $Quantity > $UnitsInStock){
                echo "<script>
                        alert('Quantity is not valid!');
                        window.location.href='customer-searchScreen.php';
                        </script>";
            }else{
                require('db.php');

                $queryForCart = "SELECT id, Quantity
                                            FROM `Shoppingcart`
                                            WHERE CustomerID = '$CustomerID' 
                                            AND ProductID = '$ProductID' ";
                // echo $queryForCart;
                // echo "<br>";
                $result = NULL;
                $result = $mysqlConnection->query($queryForCart);
                if (!$result) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $count = $result -> num_rows;
                    // echo $count;
                    // echo "<br>";
                }
                if ($count >0){
                    $row = $result->fetch_assoc();
                    $id = $row['id'];
                    $QuantityInCart = $row['Quantity'];
                    $QuantityUpdate = $Quantity + $QuantityInCart;
                    // echo $id;
                    // echo "<br>";
                    // echo $QuantityInCart;
                    // echo "<br>";
                    // echo $QuantityUpdate;
                    // echo "<br>";
                    $queryForCart = "UPDATE `Shoppingcart`
                                SET Quantity = '$QuantityUpdate',
                                        RequireDate = '$RequireDate'
                                WHERE ProductID = '$ProductID' 
                                AND CustomerID = '$CustomerID'
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
                }else if($count == 0){
                    $queryForCart ="INSERT into `Shoppingcart` (CustomerID, ProductID, Quantity, RequireDate)
                                                VALUES ('$CustomerID','$ProductID','$Quantity','$RequireDate')";
                    // echo $queryForCart;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($queryForCart);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    }else{
                        // echo "CART INSERTED";
                        // echo "<br>";
                        $CartOption = True;
                    } 
                }
                if($CartOption){
                    $UnitsLeft = $UnitsInStock - $Quantity;
                    $UnitsOnOrder = $UnitsOnOrder + $Quantity;
                    $queryForProduct = "UPDATE `products`
                                    SET UnitsInStock = '$UnitsLeft',
                                            UnitsOnOrder = '$UnitsOnOrder'
                                    WHERE ProductID = '$ProductID'
                    ";
                    $result = NULL;
                    $result = $mysqlConnection->query($queryForProduct);
                    if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                        // echo "products Updated ";
                        echo "<script>
                                alert('Item Added To Shopping Cart');
                                window.location.href='customer-searchScreen.php';
                                </script>";
                    } 
                }
                $mysqlConnection->close();
            }
        } 
    ?>
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
            
                <!--Search-->
                <form method = "post">    
                    <div class = "row">
                            <div class = "col-sm-3">
                                <div class="form-group">
                                      <label for="sel1">Category</label>
                                      <select class="form-control" name = "Category" id = "sel1">
                                            <option value = "0">All</option>
                                            <option value = "1">Beverages</option>
                                            <option value = "2">Condiments</option>
                                            <option value = "3">Confections</option>
                                            <option value = "4">Dairy Products</option>
                                            <option value = "5">Grains/Cereals</option>
                                            <option value = "6">Meat/Poultry</option>
                                            <option value = "7">Produce</option>
                                            <option value = "8">Seafood</option>
                                      </select>
                                </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="ProductName" class="form-control" placeholder="ProductName"/>
                    </div>
                    <div class="form-group">
                        <label>Supplier</label>
                        <input type="text" name="Supplier" class="form-control" placeholder="Supplier"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class = "login-button" name="search" value="Search" />
                    </div>
                </form>
                <?php 
                if (!empty($_POST['search'])){
                    $CategoryID = $_POST['Category'];
                    // echo $CategoryID;
                    // echo "<br>";
                    $ProductName = $_POST['ProductName'];
                    // echo $ProductName;
                    // echo "<br>";
                    $Supplier = $_POST['Supplier'];                    
                    // echo $Supplier;
                    // echo "<br>";

                    //Supplier Name to ID

                    require('db.php');

                    if($Supplier == NULL){                        
                        $SupplierIDQuery = "SELECT * FROM products";                        
                    }else{
                        $SupQuery = "SELECT CompanyID
                                                FROM Company
                                                WHERE CompanyName LIKE '%".$Supplier."%'
                                                AND CompanyID < 1000
                        ";
                        // echo $SupQuery;
                        // echo "<br>";

                        $resultSup = NULL;
                        $resultSup = $mysqlConnection->query($SupQuery);
                        if (!$resultSup) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                                $countSup = $resultSup -> num_rows;
                                // echo $countSup;
                                // echo "<br>";
                        }

                        if($countSup > 0){
                            $array = array();
                            while($row = $resultSup->fetch_assoc()) $array[] = $row;
                            $str_Supplier = "";
                            for($i = 0; $i < $countSup; $i ++){
                                $CompanyID = $array[$i]['CompanyID'];
                                if($i == 0) {                                        
                                    $str_Supplier = " WHERE SupplierID = '".$CompanyID. "' ";
                                }else{
                                    $str_Supplier = $str_Supplier." OR SupplierID = '".$CompanyID. "' ";
                                }
                            }
                            $SupplierIDQuery = "SELECT * FROM products".$str_Supplier."";
                        }
                    }

                    

                    // echo $SupplierIDQuery;
                    // echo "<br>";

                    if($CategoryID == 0){
                        $str_CategoryID = "";
                        if ($ProductName == null){
                            $str_ProductName = "";
                        }else{
                            $str_ProductName = " WHERE ProductName LIKE '%".$ProductName."%' ";
                        }
                    }else{
                        $str_CategoryID = " WHERE CategoryID = '".$CategoryID."' ";
                        $str_ProductName = ($ProductName == null)? "":" AND ProductName LIKE '%".$ProductName."%' ";
                    }

                    // echo $str_CategoryID;
                    // echo "<br>";
                    // echo $str_Supplier;
                    // echo "<br>";
                    // echo $str_ProductName;
                    // echo "<br>";

                    $searchQuery = "SELECT * 
                                                FROM (".$SupplierIDQuery.")t
                                                ".$str_CategoryID.$str_ProductName."";

                    // echo $searchQuery;
                    // echo "<br>";
                    $result = NULL;
                    $result = $mysqlConnection->query($searchQuery);
                    if (!$result) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    } else {
                            $count = $result -> num_rows;
                            // echo $count;
                            // echo "<br>";
                    }

                    if($count > 0){
                        $array = array();
                        while($row = $result->fetch_assoc()) $array[] = $row;

                    }
                }

                $mysqlConnection->close();
            ?>

            <table class="table">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Quantity Per Unit</th>
                    <th>Unit Price</th>
                    <th>In Stock</th>
                    <th>Add to cart</th>
                  </tr>
                </thead>
               
                <?php foreach ($array as $product) { 
                            $ProductID = $product['ProductID'];
                            $ProductName = $product['ProductName'];
                            $SupplierID = $product['SupplierID'];
                            $CategoryID = $product['CategoryID'];
                            $QuantityPerUnit = $product['QuantityPerUnit'];
                            $UnitPrice = $product['UnitPrice'];
                            $UnitsInStock = $product['UnitsInStock'];
                            $UnitsOnOrder = $product['UnitsOnOrder'];
                            $Discontinued = $product['Discontinued'];
                            
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

                             require('db.php');
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
                            $mysqlConnection->close();
                ?>
                 <tbody>
                <tr>
                    <td><?php echo $ProductName?></td>
                    <td><?php echo $row['CompanyName']?></td>
                    <td><?php echo $Category ?></td>
                    <td><?php echo $QuantityPerUnit?></td>
                    <td><?php echo $UnitPrice?></td>
                    <td><?php echo $UnitsInStock?></td>
                    <td>
                        <form class="form-inline" method = "post">
                            <div class="form-group">
                                <input class = "col-xs-3 small-Input" align="left"  type="text" name="Quantity" value = 0  required />

                                <input type = 'hidden' name = 'hiddenOnOrder' value = <?php echo $UnitsOnOrder ?> />
                                <input type = 'hidden' name = 'hiddenQua' value = <?php echo $UnitsInStock ?> />
                                <input type = 'hidden' name = 'hiddenAdd' value = <?php echo $ProductID ?> />
                                <input type="submit" name="addToCart" value="Add" />
                            </div>
                        </form>
                    </td>
                    </tr>
                </tbody>
                    <?php } ?>
                  
            </table>  
      
            </div>
        </div>
    </div>
</body>

</html>
