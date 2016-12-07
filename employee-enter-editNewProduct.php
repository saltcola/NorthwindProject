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
              <form name="registration" action="" method="post">
                <div class="form-group">
                        <label>ProductName: </label>
                        <input  type="text" class="form-control" name="ProductName" placeholder="Product Name" required />
                </div>
                <div class="form-group">
                      <label for="sel1">Supplier</label>
                      <select class="form-control" name = "SupplierID" id = "sel1">
                            <option value = "1">Exotic Liquids</option>
                            <option value = "2">New Orleans Cajun Delights</option>
                            <option value = "3">Grandma Kelly's Homestead</option>
                            <option value = "4">Tokyo Traders</option>
                            <option value = "5">Cooperativa de Quesos 'Las Cabras'</option>
                            <option value = "6">Mayumi's</option>
                            <option value = "7">Pavlova, Ltd.</option>
                            <option value = "8">Specialty Biscuits, Ltd.</option>
                            <option value = "9">PB Knckebrd AB</option>
                            <option value = "10">Refrescos Americanas LTDA</option>
                            <option value = "11">Heli Swaren GmbH & Co. KG</option>
                            <option value = "12">Plutzer Lebensmittelgromrkte AG</option>
                            <option value = "13">Nord-Ost-Fisch Handelsgesellschaft mbH</option>
                            <option value = "14">Formaggi Fortini s.r.l.</option>
                            <option value = "15">Norske Meierier</option>
                            <option value = "16">Bigfoot Breweries</option>
                            <option value = "17">Svensk Sjfda AB</option>
                            <option value = "18">Aux joyeux ecclsiastiques</option>
                            <option value = "19">New England Seafood Cannery</option>
                            <option value = "20">Leka Trading</option>
                            <option value = "21">Lyngbysild</option>
                            <option value = "22">Zaanse Snoepfabriek</option>
                            <option value = "23">Karkki Oy</option>
                            <option value = "24">G'day, Mate</option>
                            <option value = "25">Ma Maison</option>
                            <option value = "26">Pasta Buttini s.r.l.</option>
                            <option value = "27">Escargots Nouveaux</option>
                            <option value = "28">Gai pturage</option>
                            <option value = "29">Forts d'rables</option>
                      </select>
                </div>
                <div class="form-group">
                      <label for="sel1">Category</label>
                      <select class="form-control" name = "CategoryID" id = "sel1">
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
                <div class="form-group">
                        <label>Quantity Per Unit: </label>
                        <input type="text" class="form-control" name="QuantityPerUnit" placeholder="Quantity Per Unit" required />
                </div>
                <div class="form-group">
                        <label>Unit Price: </label>
                        <input type="text" class="form-control" name="UnitPrice" placeholder="Unit Price" required />
                </div>
                <div class="form-group">
                        <label>Units In Stock: </label>
                        <input type="text" class="form-control" name="UnitsInStock" placeholder="Units In Stock"  required/>
                </div>
                <div class="form-group">
                        <label>Reorder Level: </label>
                        <input type="text" class="form-control" name="ReorderLevel" placeholder="Reorder Level" required/>
                </div>
                <div class="form-group">
                        <label>Discontinued: </label>
                        <select class="form-control" name = "Discontinued" id = "sel1">
                            <option value = "0">No</option>
                            <option value = "1">Yes</option>                            
                      </select>
                </div>
                <input type="submit" class = "login-button" name="add" value="Add" />
                <input class = "login-button" name="Back" type="submit" value="Cancel" /> 
            </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php 

if(!empty($_POST['add'])){
    $ProductName = $_POST['ProductName'];
    $SupplierID = $_POST['SupplierID'];
    $CategoryID = $_POST['CategoryID'];
    $QuantityPerUnit = $_POST['QuantityPerUnit'];
    $UnitsInStock = $_POST['UnitsInStock'];
    $UnitPrice = $_POST['UnitPrice'];
    $ReorderLevel = $_POST['ReorderLevel'];
    $Discontinued = $_POST['Discontinued'];

    require('db.php');

    $query = "INSERT INTO `products`(ProductName, SupplierID, CategoryID, QuantityPerUnit, UnitsInStock, UnitPrice, ReorderLevel, Discontinued) VALUES ('$ProductName' , '$SupplierID', '$CategoryID', '$QuantityPerUnit', '$UnitsInStock', '$UnitPrice', '$ReorderLevel', '$Discontinued' )";
            // echo $query;
            // echo "<br>";

            $result = NULL;
            $result = $mysqlConnection->query($query);
                
            if(!$result){
                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
            }else{
                echo "<script>
                            alert('Product Added');
                            window.location.href='employee-main.php';
                            </script>";                
            }

}


?>
