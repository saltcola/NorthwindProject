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
              <?php 
                require('db.php');
                $query = "SELECT * FROM `products`
                                WHERE UnitsInStock = 0
                                ORDER BY Discontinued
                ";
                $result = NULL;
                $result = $mysqlConnection->query($query);
                if (!$result) {
                        throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                        $array = array();
                        while($row = $result->fetch_assoc()) $array[] = $row;
                }
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
                    <th>Unite On Order</th>
                    <th>Discontinued</th>
                    <th>Reorder</th>
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
                    <td>
                        <?php 
                        echo "<a href='employee-editProduct.php?id=".$ProductID." '> Reorder</a> ";
                        ?>
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
