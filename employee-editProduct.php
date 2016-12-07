<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: employee-login.php");
        exit(); 
    }else{

        $ProductID = $_GET['id'];

        require('db.php');

        $query = "SELECT * FROM `products` WHERE ProductID = '$ProductID' ";
        // echo $query;
        // echo "<br>";
        $result = NULL;
        $result = $mysqlConnection->query($query);
        if (!$result) {
        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
        } else {
                $product = $result->fetch_assoc();
                // echo $product['ProductName'];
                // echo "<br>";
                $ProductName = $product['ProductName'];
                $SupplierID = $product['SupplierID'];
                $CategoryID = $product['CategoryID'];
                $QuantityPerUnit = $product['CategoryID'];
                $UnitPrice = $product['UnitPrice'];
                $UnitsInStock = $product['UnitsInStock'];
                $UnitsOnOrder = $product['UnitsOnOrder'];
                $ReorderLevel = $product['ReorderLevel'];
                $Discontinued = $product['Discontinued'];
        }

    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Product</title>
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
            <div class="col-sm-8 employee-right">
            <form name="registration" action="" method="post">
                <div class="form-group">
                        <label>ProductName: </label>
                        <input  type="text" class="form-control" name="ProductName" value= "<?php echo $ProductName ?>" placeholder="Product Name" required />
                </div>
               <div class="form-group">
                      <label for="sel1">Supplier</label>
                      <select class="form-control" name = "SupplierID" id = "sel1">
                            <option value = "1"<?php if($SupplierID == 1 ) echo "SELECTED";?> >Exotic Liquids</option>
                            <option value = "2" <?php if($SupplierID == 2 ) echo "SELECTED";?>>New Orleans Cajun Delights</option>
                            <option value = "3" <?php if($SupplierID == 3 ) echo "SELECTED";?>>Grandma Kelly's Homestead</option>
                            <option value = "4"<?php if($SupplierID == 4 ) echo "SELECTED";?>>Tokyo Traders</option>
                            <option value = "5"<?php if($SupplierID == 5 ) echo "SELECTED";?>>Cooperativa de Quesos 'Las Cabras'</option>
                            <option value = "6"<?php if($SupplierID == 6 ) echo "SELECTED";?>>Mayumi's</option>
                            <option value = "7"<?php if($SupplierID == 7 ) echo "SELECTED";?>>Pavlova, Ltd.</option>
                            <option value = "8"<?php if($SupplierID == 8 ) echo "SELECTED";?>>Specialty Biscuits, Ltd.</option>
                            <option value = "9"<?php if($SupplierID == 9 ) echo "SELECTED";?>>PB Knckebrd AB</option>
                            <option value = "10"<?php if($SupplierID == 10 ) echo "SELECTED";?>>Refrescos Americanas LTDA</option>
                            <option value = "11"<?php if($SupplierID == 11 ) echo "SELECTED";?>>Heli Swaren GmbH & Co. KG</option>
                            <option value = "12"<?php if($SupplierID == 12 ) echo "SELECTED";?>>Plutzer Lebensmittelgromrkte AG</option>
                            <option value = "13"<?php if($SupplierID == 13 ) echo "SELECTED";?>>Nord-Ost-Fisch Handelsgesellschaft mbH</option>
                            <option value = "14"<?php if($SupplierID == 14 ) echo "SELECTED";?>>Formaggi Fortini s.r.l.</option>
                            <option value = "15"<?php if($SupplierID == 15 ) echo "SELECTED";?>>Norske Meierier</option>
                            <option value = "16"<?php if($SupplierID == 16 ) echo "SELECTED";?>>Bigfoot Breweries</option>
                            <option value = "17"<?php if($SupplierID == 17 ) echo "SELECTED";?>>Svensk Sjfda AB</option>
                            <option value = "18"<?php if($SupplierID == 18 ) echo "SELECTED";?>>Aux joyeux ecclsiastiques</option>
                            <option value = "19"<?php if($SupplierID == 19 ) echo "SELECTED";?>>New England Seafood Cannery</option>
                            <option value = "20"<?php if($SupplierID == 20 ) echo "SELECTED";?>>Leka Trading</option>
                            <option value = "21"<?php if($SupplierID == 21 ) echo "SELECTED";?>>Lyngbysild</option>
                            <option value = "22"<?php if($SupplierID == 22 ) echo "SELECTED";?>>Zaanse Snoepfabriek</option>
                            <option value = "23"<?php if($SupplierID == 23 ) echo "SELECTED";?>>Karkki Oy</option>
                            <option value = "24"<?php if($SupplierID == 24 ) echo "SELECTED";?>>G'day, Mate</option>
                            <option value = "25"<?php if($SupplierID == 25 ) echo "SELECTED";?>>Ma Maison</option>
                            <option value = "26"<?php if($SupplierID == 26 ) echo "SELECTED";?>>Pasta Buttini s.r.l.</option>
                            <option value = "27"<?php if($SupplierID == 27 ) echo "SELECTED";?>>Escargots Nouveaux</option>
                            <option value = "28"<?php if($SupplierID == 28 ) echo "SELECTED";?>>Gai pturage</option>
                            <option value = "29"<?php if($SupplierID == 29 ) echo "SELECTED";?>>Forts d'rables</option>
                      </select>
                </div>
                <div class="form-group">
                      <label for="sel1">Category</label>
                      <select class="form-control" name = "CategoryID" id = "sel1">
                            <option value = "1" <?php if($CategoryID == 1 ) echo "SELECTED";?> >Beverages</option>
                            <option value = "2" <?php if($CategoryID == 2 ) echo "SELECTED";?>>Condiments</option>
                            <option value = "3" <?php if($CategoryID == 3 ) echo "SELECTED";?>>Confections</option>
                            <option value = "4" <?php if($CategoryID == 4 ) echo "SELECTED";?> >Dairy Products</option>
                            <option value = "5" <?php if($CategoryID == 5 ) echo "SELECTED";?>>Grains/Cereals</option>
                            <option value = "6" <?php if($CategoryID == 6 ) echo "SELECTED";?>>Meat/Poultry</option>
                            <option value = "7" <?php if($CategoryID == 7 ) echo "SELECTED";?>>Produce</option>
                            <option value = "8" <?php if($CategoryID == 8 ) echo "SELECTED";?>>Seafood</option>
                      </select>
                </div>
                <div class="form-group">
                        <label>Unit Price: </label>
                        <input type="text" class="form-control" name="UnitPrice" placeholder="Unit Price" value= <?php echo $UnitPrice ?> required />
                </div>
                <div class="form-group">
                        <label>Units In Stock: </label>
                        <input type="text" class="form-control" name="UnitsInStock" placeholder="Units In Stock" value= <?php echo $UnitsInStock ?> required/>
                </div>
                <div class="form-group">
                        <label>Units On Order: </label>
                        <input type="text" class="form-control" name="UnitsOnOrder" placeholder="Units On Order" value= <?php echo $UnitsOnOrder ?> required/>
                </div>
                <div class="form-group">
                        <label>Reorder Level: </label>
                        <input type="text" class="form-control" name="ReorderLevel" placeholder="Reorder Level" value= <?php echo $ReorderLevel ?> required/>
                </div>
                <div class="form-group">
                        <label>Discontinued: </label>
                        <select class="form-control" name = "Discontinued" id = "sel1">
                            <option value = "0" <?php if($Discontinued == 0 ) echo "SELECTED";?> >No</option>
                            <option value = "1" <?php if($Discontinued == 1 ) echo "SELECTED";?> >Yes</option>                            
                      </select>
                </div>
                <input type="submit" class = "login-button" name="edit" value="Edit" />
                <input class = "login-button" name="Back" type="submit" value="Cancel" /> 
            </form>
            <?php 
                if(!empty($_POST['Back'])){
                    echo "<script>
                                    
                                    window.location.href='employee-main.php';
                                    </script>"; 
                exit;
                }

                if(!empty($_POST['edit'])){
                    $ProductName = $_POST['ProductName'];
                    $SupplierID = $_POST['SupplierID'];
                    $CategoryID = $_POST['CategoryID'];
                    $QuantityPerUnit = $_POST['CategoryID'];
                    $UnitPrice = $_POST['UnitPrice'];
                    $UnitsInStock = $_POST['UnitsInStock'];
                    $UnitsOnOrder = $_POST['UnitsOnOrder'];
                    $ReorderLevel = $_POST['ReorderLevel'];
                    $Discontinued = $_POST['Discontinued'];

                   // echo $ProductName ;
                   // echo "<br>";
                   //  echo $SupplierID ;
                   //  echo "<br>";
                   //  echo $CategoryID ;
                   //  echo "<br>";
                   //  echo $UnitPrice ;
                   //  echo "<br>";
                   //  echo $UnitsInStock ;
                   //  echo "<br>";
                   //  echo $UnitsOnOrder ;
                   //  echo "<br>";
                   //  echo $ReorderLevel;
                   //  echo "<br>";                    
                   //  echo $Discontinued ;
                   //  echo "<br>";

                    $query = "UPDATE `products`
                                   SET ProductName  = '$ProductName',
                                            SupplierID = '$SupplierID',
                                            CategoryID = '$CategoryID',
                                            UnitPrice = '$UnitPrice',
                                            UnitsInStock = '$UnitsInStock',
                                            UnitsOnOrder = '$UnitsOnOrder',
                                            ReorderLevel = '$ReorderLevel',
                                            Discontinued = '$Discontinued'
                                    WHERE ProductID = '$ProductID'     
                        ";

                    // echo $query;
                    // echo "<ba>";
                    $result = NULL;
                    $result = $mysqlConnection->query($query);
                    if(!$result){
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                    }else{

                        echo "<script type='text/javascript'>
                            alert('Product Edited');
                            window.location = 'employee-editProduct.php?id=".$ProductID." '
                             </script>";               
                    }

                }
            ?>   
            </div>
        </div>
    </div>

</body>