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
            </div>
        </div>
        <div class = "row">
            <div class = "col-sm-1"></div>
            <div class = "col-sm-10">
                <table class="table">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Category</th>
                        <th>Quantity Per Unit</th>
                        <th>Unit Price</th>
                        <th>In Stock</th>
                        <th>Unite On Order</th>
                        <th>Discontinued</th>
<!--                         <th>Add to cart</th> -->
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
                                $Discontinued = ($product['Discontinued'] == 1)?"True":"False";
                                
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
                        <td><?php echo $UnitsOnOrder?></td>
                        <td><?php echo $Discontinued?></td>
                        <!-- <td>
                            <form class="form-inline" method = "post">
                                <div class="form-group">
                                    <input class = "col-xs-3 small-Input" align="left"  type="text" name="Quantity" value = 0  required />

                                    <input type = 'hidden' name = 'hiddenOnOrder' value = <?php echo $UnitsOnOrder ?> />
                                    <input type = 'hidden' name = 'hiddenQua' value = <?php echo $UnitsInStock ?> />
                                    <input type = 'hidden' name = 'hiddenAdd' value = <?php echo $ProductID ?> />
                                    <input type="submit" name="addToCart" value="Add" />
                                </div>
                            </form>
                        </td> -->
                        </tr>
                    </tbody>
                        <?php } ?>
                      
                </table>  
            </div>
            <div class = "col-sm-1"></div>
        </div>
    </div>
</body>

</html>
