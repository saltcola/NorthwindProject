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
            <div class="col-sm-8 employee-right">
              <form method="post">
                <div class="form-group">
                        <label>Search By Product Name</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="ProductName" class="form-control" placeholder="Product Name"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByProductName" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Supplier Company Name</label>
                        <div class = "row">
                            <div class = "col-sm-8">
                                <input type="text" name="CompanyName" class="form-control" placeholder="Company Name"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByCompanyName" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Units In Stock</label>
                        <div class = "row">
                            <div class = "col-sm-4">
                                <input type="text" name="UnitsInStockMin" class="form-control" placeholder="Min Units In Stock"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="text" name="UnitsInStockMax" class="form-control" placeholder="Max Units In Stock"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByUnitsInStock" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Unit Price</label>
                        <div class = "row">
                            <div class = "col-sm-4">
                                <input type="text" name="UnitPriceMin" class="form-control" placeholder="Minimum Unit Price"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="text" name="UnitPriceMax" class="form-control" placeholder="Maxium Unit Price"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByUnitPrice" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Search By Units On Order</label>
                        <div class = "row">
                            <div class = "col-sm-4">
                                <input type="text" name="UnitsOnOrderMin" class="form-control" placeholder="Minimum Units On Order"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="text" name="UnitsOnOrderMax" class="form-control" placeholder="Maxium Units On Order"/>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByUnitsOnOrder" value="Search" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                          <label for="sel1">Search By Category</label>
                          <div class = "row">
                            <div class = "col-sm-8">
                              <select class="form-control" name = "Category" id = "sel1">
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
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByCategory" value="Search" />
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                          <label for="sel1">Search By Delivery Type</label>
                          <div class = "row">
                            <div class = "col-sm-8">
                              <select class="form-control" name = "DeliveryType" id = "sel1">
                                    <option value = "1">Over Night</option>
                                    <option value = "2">Two day</option>
                                    <option value = "3">Other</option>
                              </select>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByDeliveryType" value="Search" />
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                          <label for="sel1">Search By Shipment Type</label>
                          <div class = "row">
                            <div class = "col-sm-8">
                              <select class="form-control" name = "ShipmentType" id = "sel1">
                                    <option value = "1">Ground</option>
                                    <option value = "2">Air</option>
                                    <option value = "3">Sea</option>
                              </select>
                            </div>
                            <div class = "col-sm-4">
                                <input type="submit" name="SearchByShipmentType" value="Search" />
                            </div>
                            </div>
                    </div>
              </form>
            </div>
<?php
$array = array();
require('db.php');

if(!empty($_POST['SearchByProductName'])){

    $ProductName = $_POST['ProductName'];
    $query = "SELECT * FROM `products` WHERE ProductName LIKE '%".$ProductName."%' ";

    // echo $query;
    // echo "<br>";

    require('admin-toArray.php');
}
if(!empty($_POST['SearchByCompanyName'])){
    $CompanyName = $_POST['CompanyName'];
    $query = "SELECT * FROM `products` WHERE SupplierID IN (SELECT CompanyID FROM `Company` WHERE CompanyID < 1000 AND CompanyName LIKE  '%".$CompanyName."%' )
    ";
    // echo $query;
    // echo "<br>";
    require('admin-toArray.php');
} 
if(!empty($_POST['SearchByUnitsInStock'])){
    $min = $_POST['UnitsInStockMin'];
    $max = $_POST['UnitsInStockMax'];
    $query = "SELECT * FROM `products` WHERE UnitsInStock >= '$min' AND UnitsInStock <= '$max' ORDER BY UnitsInStock

    ";

    require('admin-toArray.php');

} 
if(!empty($_POST['SearchByUnitPrice'])){

    $min = $_POST['UnitPriceMin'];
    $max = $_POST['UnitPriceMax'];
    $query = "SELECT * FROM `products` WHERE UnitPrice >= '$min' AND UnitPrice <= '$max' ORDER BY UnitPrice
    ";

    require('admin-toArray.php');

}
if(!empty($_POST['SearchByUnitsOnOrder'])){

    $min = $_POST['UnitsOnOrderMin'];
    $max = $_POST['UnitsOnOrderMax'];
    $query = "SELECT * FROM `products` WHERE UnitsOnOrder >= '$min' AND UnitsOnOrder <= '$max' ORDER BY UnitsOnOrder
    ";

    require('admin-toArray.php');

} 
if(!empty($_POST['SearchByCategory'])){

    $CategoryID = $_POST['Category'];

    $query = "SELECT * FROM `products` WHERE 
                    CategoryID = '$CategoryID'
    ";
    require('admin-toArray.php');

} 
if(!empty($_POST['SearchByDeliveryType'])){
    $DeliveryTypeID = $_POST['DeliveryType'];
    $query = "SELECT * FROM `products` WHERE ProductID IN (SELECT DISTINCT ProductID FROM `ProductsToAddress` WHERE  DeliveryTypeID = '$DeliveryTypeID' ) ";
    // echo $query;
    // echo "<br>";
    require('admin-toArray.php');
} 
if(!empty($_POST['SearchByShipmentType'])){
    $ShipmentTypeID = $_POST['ShipmentType'];
    $query = "SELECT * FROM `products` WHERE ProductID IN (SELECT DISTINCT ProductID FROM `ProductsToAddress` WHERE  ShipmentTypeID = '$ShipmentTypeID' ) ";
    // echo $query;
    // echo "<br>";
    require('admin-toArray.php');
}   



?>

            <div class = "row">
            <div class = "col-sm-2"></div>
            <div class = "col-sm-9">
                <table class="table">
                    <thead>
                      <tr>
                        <th>Product Name</th>
                        <th>Supplier</th>
                        <th>Category</th>
                        <th>Quantity Per Unit</th>
                        <th>Unit Price</th>
                        <th>In Stock</th>
                        <th>Units On Order</th>
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
                    </tr>
                    </tbody>
                        <?php } ?>
                      
                </table>  
            </div>
            <div class = "col-sm-1"></div>
        </div>
        </div>
    </div>
</body>

</html>
