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
            <div class="col-sm-4 employee-left">
                <div class="btn-group-vertical" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" onClick="location.href='employee-ListofActiveOrder.html'">List of Active customer order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='employee-enter-editNewProduct.html'">Enter/Edit New Products/Categories</button>
                    <button type="button" class="btn btn-default" onClick="location.href='employee-search.html'">Search</button>
                    <button type="button" class="btn btn-default" onClick="location.href='employee-inventory-purchasing.html'">Inventory/Purchasing</button>
                    <button type="button" class="btn btn-default" onClick="location.href='employee-reviewCustomerGraphic.html'">Review Customer Demographic</button>
                    <button type="button" class="btn btn-default" onClick="location.href='index.html'">Logout</button>
                </div>
            </div>
            <div class="col-sm-8 employee-right">
              For employee information
            </div>
        </div>
    </div>
</body>

</html>