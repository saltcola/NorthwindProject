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
            <div class="col-sm-2 employee-left">
                <div class="btn-group-vertical" role="group" aria-label="...">
                    <button type="button" class="btn btn-default" onClick="location.href='customer-main.php'">View Profile</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-editProfile.php'">Edit Profile</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-payment.php'">Edit Payment</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-completedOrder.php'">Completed Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-pendingOrder.php'">Pending Order</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-shoppingCart.php'">Shopping Cart</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-searchScreen.php'">Search Screen</button>
                    <button type="button" class="btn btn-default" onClick="location.href='customer-quickSearch.php'">Quick Search</button>
                    <button type="button" class="btn btn-default" onClick="location.href='logout.php'">Logout</button>
                </div>
            </div>
            <div class="col-sm-9 employee-right">
            <?php

                    $CustomerID = $_SESSION["username"];

                    // If Bank form submit
                    if (!empty($_POST['bank'])){
                            $BankName = $_POST['bankName'];
                            $HolderName = $_POST['holderName'];
                            $RoutingNumber = $_POST['bankRouting'];
                            $AccountNumber = $_POST['accountNumber'];
                            // echo $BankName;
                            // echo "<br>";
                            // echo $HolderName;
                            // echo "<br>";
                            // echo $RoutingNumber;
                            // echo "<br>";
                            // echo $AccountNumber;
                            // echo "<br>";
                            if(isset($_POST['bankCheck'])){
                                $Prefered = 1;  
                            }else{
                                $Prefered = 0; 
                            }

                            require('db.php');

                            // Check if there the account is already exist in DB
                            $checkExistsQuery = " SELECT *
                                                        FROM customerPaymentBank
                                                        WHERE CustomerID = '$CustomerID'
                                                        AND AccountNumber = '$AccountNumber' ";

                            // echo $checkExistsQuery;
                            // echo "<br>";
                            // echo $Prefered;
                            // echo "<br>";

                            $checkResult = NULL;
                            $checkResult = $mysqlConnection->query($checkExistsQuery);
                            if (!$checkResult) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                $count = $checkResult -> num_rows;
                            }

                            // echo $count;
                            // echo "<br>";

                            if($count > 0){
                                echo "<div class='form'>
                                        <h3>Sorry! This Bank Account already exists!</h3>
                                        <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                                $mysqlConnection->close();  
                                exit();  
                            }

                            // INSERT new Bank Account to DB
                            if($Prefered == 1){
                                    $query = "UPDATE customerPaymentCards
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentBank
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                INSERT INTO `customerPaymentBank` (BankName, HolderName, RoutingNumber, AccountNumber , CustomerID, Prefered)
                                                VALUES ('$BankName', '$HolderName', '$RoutingNumber', '$AccountNumber', '$CustomerID', '$Prefered')
                                                            ";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->multi_query($query);


                            }else{
                                    $query = " INSERT INTO `customerPaymentBank` (BankName, HolderName, RoutingNumber, AccountNumber , CustomerID,Prefered)
                                                VALUES ('$BankName', '$HolderName', '$RoutingNumber', '$AccountNumber', '$CustomerID', '$Prefered')";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);

                            }

                             if (!$result) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                }else{
                                    echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                    exit();
                                }  

                            $mysqlConnection->close();


                    } 

                    // If Android form submit
                    if (!empty($_POST['AndroidPay'])){
                            $PaymentTypeID = 1;
                            $Email = $_POST['AndroidEmail'];
                            // echo $Email;
                            // echo "<br>";
                            if(isset($_POST['AndroidCheck'])){
                                $Prefered = 1;
                            }else{
                                $Prefered =  0;
                            }

                             require('db.php');
                            // Check if there the account is already exist in DB
                            $checkExistsQuery = " SELECT *
                                                        FROM customerPaymentThirdParty
                                                        WHERE CustomerID = '$CustomerID'
                                                        AND Email = '$Email' ";

                            // echo $checkExistsQuery;
                            // echo "<br>";

                            $checkResult = NULL;
                            $checkResult = $mysqlConnection->query($checkExistsQuery);
                            if (!$checkResult) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                $count = $checkResult -> num_rows;
                            }

                            // echo $count;
                            // echo "<br>";
                            if($count > 0){
                                echo "<div class='form'>
                                        <h3>Sorry! This AndroidPay Email Account already exists!</h3>
                                        <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                                $mysqlConnection->close();  
                                exit();  
                            }
                            // INSERT new Bank Account to DB
                            if($Prefered == 1){
                                    $query = "UPDATE customerPaymentCards
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentBank
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')
                                                            ";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->multi_query($query);


                            }else{
                                    $query = " INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);

                            }

                             if (!$result) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                }else{
                                    echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                    exit();
                                }  

                            $mysqlConnection->close();

                    }

                    // If Apple form submit 
                    if (!empty($_POST['ApplePay'])){
                            $PaymentTypeID = 2;
                            $Email = $_POST['AppleEmail'];
                            // echo $Email;
                            // echo "<br>";
                            if(isset($_POST['AppleCheck'])){
                                $Prefered = 1;
                            }else{
                                $Prefered = 0;
                            }

                            require('db.php');
                            // Check if there the account is already exist in DB
                            $checkExistsQuery = " SELECT *
                                                        FROM customerPaymentThirdParty
                                                        WHERE CustomerID = '$CustomerID'
                                                        AND Email = '$Email' ";

                            // echo $checkExistsQuery;
                            // echo "<br>";

                            $checkResult = NULL;
                            $checkResult = $mysqlConnection->query($checkExistsQuery);
                            if (!$checkResult) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                $count = $checkResult -> num_rows;
                            }

                            // echo $count;
                            // echo "<br>";
                            if($count > 0){
                                echo "<div class='form'>
                                        <h3>Sorry! This AndroidPay Email Account already exists!</h3>
                                        <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                                $mysqlConnection->close();  
                                exit();  
                            }
                            // INSERT new Bank Account to DB
                            if($Prefered == 1){
                                    $query = "UPDATE customerPaymentCards
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentBank
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')
                                                            ";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->multi_query($query);


                            }else{
                                    $query = " INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);

                            }

                             if (!$result) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                }else{
                                    echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                    exit();
                                }  

                            $mysqlConnection->close();
                    }

                    // If Paypal form submit 
                    if (!empty($_POST['Paypal'])){
                            $PaymentTypeID = 5;
                            $Email = $_POST['PaypalEmail'];     
                            // echo $Email;
                            // echo "<br>";
                            if(isset($_POST['PaypalCheck'])){
                                $Prefered = 1;
                            }else{
                                $Prefered = 0;
                            }

                            require('db.php');
                            // Check if there the account is already exist in DB
                            $checkExistsQuery = " SELECT *
                                                        FROM customerPaymentThirdParty
                                                        WHERE CustomerID = '$CustomerID'
                                                        AND Email = '$Email' ";

                            // echo $checkExistsQuery;
                            // echo "<br>";

                            $checkResult = NULL;
                            $checkResult = $mysqlConnection->query($checkExistsQuery);
                            if (!$checkResult) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            } else {
                                $count = $checkResult -> num_rows;
                            }

                            // echo $count;
                            // echo "<br>";
                            if($count > 0){
                                echo "<div class='form'>
                                        <h3>Sorry! This AndroidPay Email Account already exists!</h3>
                                        <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                                $mysqlConnection->close();  
                                exit();  
                            }
                            // INSERT new Bank Account to DB
                            if($Prefered == 1){
                                    $query = "UPDATE customerPaymentCards
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentBank
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')
                                                            ";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->multi_query($query);


                            }else{
                                    $query = " INSERT INTO `customerPaymentThirdParty` (PaymentTypeID, Email, CustomerID, Prefered)
                                                VALUES ('$PaymentTypeID', '$Email','$CustomerID', '$Prefered')";
                                    // echo $query;
                                    // echo "<br>";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);

                            }

                             if (!$result) {
                                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                                }else{
                                    echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                    exit();
                                }  

                            $mysqlConnection->close();
                    }

                    // If card form submit
                    if(!empty($_POST['card'])){
                        $CardType = $_POST['CardType'];
                        $CardHolderName = $_POST['cardHolderName'];
                        $CardNumber = $_POST['cardNumber'];
                        $CCV = $_POST['CCV'];
                        $expDate = $_POST['expDate'];

                        if(isset($_POST['cardCheck'])){ 
                            $cardCheck = 1;                           
                        }else{
                            $cardCheck = 0;
                        }

                        switch($CardType){
                            case "Debit":
                                $CardTypeID = 1; break;
                            case "Visa":
                                $CardTypeID = 2; break;
                            case "Master":
                                $CardTypeID = 3; break;
                            case "AMEX":
                                $CardTypeID = 4; break;
                            case "Discover":
                                $CardTypeID = 5; break;
                        }

                        require('db.php');

                        // Check if there the card is already exist in DB
                        $checkExistsQuery = " SELECT *
                                                    FROM customerPaymentCards
                                                    WHERE CustomerID = '$CustomerID'
                                                    AND CardTypeID = '$CardTypeID'
                                                    AND CardNumber = '$CardNumber' ";

                        $checkResult = NULL;
                        $checkResult = $mysqlConnection->query($checkExistsQuery);
                        if (!$checkResult) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count = $checkResult -> num_rows;
                        }
                        if($count > 0){
                            echo "<div class='form'>
                                        <h3>Sorry! This Card already exists!</h3>
                                        <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                            $mysqlConnection->close();  
                            exit();  
                        }

                        // INSERT new card to DB
                        if($cardCheck == 1){
                                $query = "UPDATE customerPaymentCards
                                            SET Prefered = 0
                                            WHERE CustomerID = '$CustomerID';
                                            UPDATE customerPaymentBank
                                            SET Prefered = 0
                                            WHERE CustomerID = '$CustomerID';
                                            UPDATE customerPaymentThirdParty
                                            SET Prefered = 0
                                            WHERE CustomerID = '$CustomerID';
                                            INSERT INTO `customerPaymentCards` (CardTypeID, CardNumber, HolderName, CCV, ExpireDate , CustomerID, Prefered)
                                            VALUES ('$CardTypeID', '$CardNumber', '$CardHolderName', '$CCV', '$expDate', '$CustomerID', '$cardCheck')
                                                        ";
                                //echo $query;
                                $result = NULL;
                                $result = $mysqlConnection->multi_query($query);


                        }else{
                                $query = " INSERT INTO `customerPaymentCards` (CardTypeID, CardNumber, HolderName, CCV, ExpireDate , CustomerID, Prefered)
                                VALUES ('$CardTypeID', '$CardNumber', '$CardHolderName', '$CCV', '$expDate', '$CustomerID', '$cardCheck')";
                                $result = NULL;
                                $result = $mysqlConnection->query($query);

                        }

                         if (!$result) {
                                throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                            }else{
                                echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                exit();
                            }  
                        
                        $mysqlConnection->close();
                }
            ?>

            <?php             
             
            // OUTPUT all payment methods
            require('db.php');

                  // check if card payment exist in customerPaymentCards table
                  $query1 = "SELECT *
                                    FROM customerPaymentCards
                                    WHERE CustomerID = '$CustomerID' 
                                    AND Prefered = 0" ;
                $result1 = NULL;
                $result1 = $mysqlConnection->query($query1);
                 if (!$result1) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count1 = $result1 -> num_rows;
                            //echo $count1;
                        }
                    if ($count1 > 0){
                        $array = array();
                        while($row = $result1->fetch_assoc()) $array[] = $row;
                        foreach($array as $card){
                            $CardNum = $card['CardNumber'];
                            $CardID = $card['CardID'];
                            $CustomerID = $card['CustomerID'];
                            switch($card['CardTypeID']){
                                        case 1: 
                                            $CardType = "Debit"; break;
                                        case 2: 
                                            $CardType = "Visa";break;
                                        case 3: 
                                            $CardType = "Master";break;
                                        case 4: 
                                            $CardType = "AMEX";break;
                                        case 5: 
                                            $CardType = "Discover";break;
                                }
                                $newstring = (strlen($CardNum)>4)?substr($CardNum, -4):$CardNum;
                                // Remove card
                                if (!empty($_POST['deleteCard'])){
                                        $CardID = $_POST['hiddenCard'];
                                        $query = "DELETE 
                                                        FROM customerPaymentCards
                                                        WHERE CardID = '$CardID'
                                                        ";
                                        $result = NULL;
                                        $result = $mysqlConnection->query($query);
                                            
                                        if($result){
                                            echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                                        exit();
                                            }
                                }
                                // SET to preferred
                                if (!empty($_POST['setToPreferred'])){ 
                                        $CardID = $_POST['hiddenCard']; 
                                        $query = "UPDATE customerPaymentCards
                                                        SET Prefered = 0
                                                        WHERE CustomerID = '$CustomerID';
                                                        UPDATE customerPaymentBank
                                                        SET Prefered = 0
                                                        WHERE CustomerID = '$CustomerID';
                                                        UPDATE customerPaymentThirdParty
                                                        SET Prefered = 0
                                                        WHERE CustomerID = '$CustomerID';
                                                        UPDATE customerPaymentCards
                                                        SET Prefered = 1
                                                        WHERE CardID = '$CardID';
                                                        ";
                                        $result = NULL;
                                        $result = $mysqlConnection->multi_query($query);
                                            
                                        if($result){
                                            echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                                        exit();
                                            }
                                }
                                echo "
                                <div class = 'payment-box'>
                                    <h3>Stored Card</h3>
                                    <p>Card Type: ".$CardType."</p> 
                                    <p>CardNumber: **** **** **** " .$newstring. "</p>
                                    <form method = 'post'>
                                    <input type = 'hidden' name = 'hiddenCard' value = ' ".$CardID." ' />
                                    <input type = 'submit' name = 'deleteCard' value = 'Remove Card' />
                                    <input type = 'submit' name = 'setToPreferred' value = 'Preferred' />
                                    </form>
                                </div>" ;
                        }
                    }


                // check if  bank payment exist in customerPaymentBank table
                $query2 = "SELECT *
                                    FROM customerPaymentBank
                                    WHERE  Prefered = 0
                                    AND CustomerID = '$CustomerID' ";
                $result2 = NULL;
                $result2 = $mysqlConnection->query($query2);
                if (!$result2) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $count2 = $result2 -> num_rows;
                    //echo $count2;
                }
                if ($count2 > 0){
                        $array = array();
                        while($row = $result2->fetch_assoc()) $array[] = $row;
                        foreach($array as $bank){
                            $BankName = $bank['BankName'];
                            $HolderName = $bank['HolderName'];
                            $RoutingNumber = $bank['RoutingNumber'];
                            $AccountNumber = $bank['AccountNumber']; 
                            $CustomerID = $bank['CustomerID'];
                            $id = $bank['id'];
                           
                            $newstring = (strlen($AccountNumber)>4)?substr($AccountNumber, -4):$AccountNumber;

                            // Remove bank
                            if (!empty($_POST['deleteBank'])){
                                    $id = $_POST['hiddenBank'];
                                    $query = "DELETE 
                                                    FROM customerPaymentBank
                                                    WHERE id = '$id'
                                                    ";
                                    $result = NULL;
                                    $result = $mysqlConnection->query($query);
                                        
                                    if($result){
                                        echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                                    exit();
                                        }
                            }
                            // SET to preferred
                            if (!empty($_POST['setBankToPreferred'])){ 
                                    $id = $_POST['hiddenBank']; 
                                    //echo $id;
                                    $query = "UPDATE customerPaymentCards
                                                    SET Prefered = 0
                                                    WHERE CustomerID = '$CustomerID';
                                                    UPDATE customerPaymentBank
                                                    SET Prefered = 0
                                                    WHERE CustomerID = '$CustomerID';
                                                    UPDATE customerPaymentThirdParty
                                                    SET Prefered = 0
                                                    WHERE CustomerID = '$CustomerID';
                                                    UPDATE customerPaymentBank
                                                    SET Prefered = 1
                                                    WHERE id = '$id';
                                                    ";

                                    //echo $query;
                                    $result = NULL;
                                    $result = $mysqlConnection->multi_query($query);
                                        
                                    if($result){
                                        echo '<script type="text/javascript">
                                                    window.location = "customer-payment.php"
                                                     </script>';
                                        exit();
                                        }
                            }

                            echo "
                            <div class = 'payment-box'>
                                <h3>Stored Bank Account</h3>
                                <p>Bank Name: ".$BankName."</p> 
                                <p>Account Number: **** **** **** " .$newstring. "</p>
                                <form method = 'post'>
                                    <input type = 'hidden' name = 'hiddenBank' value = ' ".$id." ' />
                                    <input type = 'submit' name = 'deleteBank' value = 'Remove Account' />
                                    <input type = 'submit' name = 'setBankToPreferred' value = 'Preferred' />
                                </form>
                            </div>" ;
                        }
                    }

                // check if third party payment exist in customerPaymentThirdParty table
                $query3 = "SELECT *
                                    FROM customerPaymentThirdParty
                                    WHERE  Prefered = 0
                                    AND CustomerID = '$CustomerID' ";
                $result3 = NULL;
                $result3 = $mysqlConnection->query($query3);
                if (!$result3) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $count3 = $result3 -> num_rows;
                }
                if($count3 > 0){
                    $array = array();
                    while($row = $result3->fetch_assoc()) $array[] = $row;
                    foreach($array as $bank){
                        $PaymentTypeID = $bank['PaymentTypeID'];
                        $Email = $bank['Email'];
                        $CustomerID = $bank['CustomerID'];
                        $id = $bank['id'];
                        $Prefered = $bank['Prefered'];
                        
                        switch($PaymentTypeID){
                            case 1: $PaymentType = "Android Pay"; break;
                            case 2: $PaymentType = "ApplePay"; break;
                            case 5: $PaymentType = "PayPal"; break;
                        }
                        

                        // Remove bank
                        if (!empty($_POST['deletePay'])){
                                $id = $_POST['hiddenPay'];
                                $query = "DELETE 
                                                FROM customerPaymentThirdParty
                                                WHERE id = '$id'
                                                ";
                                $result = NULL;
                                $result = $mysqlConnection->query($query);
                                    
                                if($result){
                                    echo '<script type="text/javascript">
                                                window.location = "customer-payment.php"
                                                 </script>';
                                                exit();
                                    }
                        }
                        // SET to preferred
                        if (!empty($_POST['setPayToPreferred'])){ 
                                $id = $_POST['hiddenPay']; 
                                //echo $id;
                                $query = "UPDATE customerPaymentCards
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentBank
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 0
                                                WHERE CustomerID = '$CustomerID';
                                                UPDATE customerPaymentThirdParty
                                                SET Prefered = 1
                                                WHERE id = '$id';
                                                ";

                                //echo $query;
                                $result = NULL;
                                $result = $mysqlConnection->multi_query($query);
                                    
                                if($result){
                                    echo '<script type="text/javascript">
                                                window.location = "customer-payment.php"
                                                 </script>';
                                    exit();
                                    }
                            }

                            echo "
                            <div class = 'payment-box'>
                                <h3>Stored Third Party Payment</h3>
                                <p>Payment Name: ".$PaymentType."</p> 
                                <p>Account Email: " .$Email. "</p>
                                <form method = 'post'>
                                    <input type = 'hidden' name = 'hiddenPay' value = ' ".$id." ' />
                                    <input type = 'submit' name = 'deletePay' value = 'Remove Account' />
                                    <input type = 'submit' name = 'setPayToPreferred' value = 'Preferred' />
                                </form>
                            </div>" ;
                        }
                }



                // OUTPUT Preferred payment method
                  //require('db.php');

                  // check if preferred payment exist in customerPaymentCards table
                  $query1 = "SELECT *
                                    FROM customerPaymentCards
                                    WHERE  Prefered = 1
                                    AND CustomerID = '$CustomerID' ";
                $result1 = NULL;
                $result1 = $mysqlConnection->query($query1);
                 if (!$result1) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count1 = $result1 -> num_rows;
                            //echo $count1;
                        }

                    if ($count1 > 0){
                        $row = $result1->fetch_assoc();
                        switch($row['CardTypeID']){
                                case 1: 
                                    $CardType = "Debit"; break;
                                case 2: 
                                    $CardType = "Visa";break;
                                case 3: 
                                    $CardType = "Master";break;
                                case 4: 
                                    $CardType = "AMEX";break;
                                case 5: 
                                    $CardType = "Discover";break;
                        }

                        $CardNum = $row['CardNumber'];
                        $newstring = (strlen($CardNum)>4)?substr($CardNum, -4):$CardNum;
                        
                
                        echo "
                        <div class = 'payment-box'>
                            <h3>Default Payment Method -- Card</h3>
                            <p>Card Type: ".$CardType."</p> 
                            <p>CardNumber: **** **** **** " .$newstring. "</p>
                        </div>" ;
                    }

                // check if preferred payment exist in customerPaymentBank table
                $query2 = "SELECT *
                                    FROM customerPaymentBank
                                    WHERE  Prefered = 1
                                    AND CustomerID = '$CustomerID' ";
                $result2 = NULL;
                $result2 = $mysqlConnection->query($query2);
                if (!$result2) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $count2 = $result2 -> num_rows;
                    // echo $count2;
                }
                if ($count2 > 0){
                        $bank = $result2->fetch_assoc();
                        $BankName = $bank['BankName'];
                        $AccountNumber = $bank['AccountNumber'];                        
                        $newstring = (strlen($AccountNumber)>4)?substr($AccountNumber, -4):$AccountNumber;
                        echo "
                            <div class = 'payment-box'>
                                <h3>Default Payment Method -- Bank Account</h3>
                                <p>Bank Name: ".$BankName."</p> 
                                <p>Account Number: **** **** **** " .$newstring. "</p>
                            </div>" ;
                }

                // check if preferred payment exist in customerPaymentThirdParty table
                $query3 = "SELECT *
                                    FROM customerPaymentThirdParty
                                    WHERE  Prefered = 1
                                    AND CustomerID = '$CustomerID' ";
                $result3 = NULL;
                $result3 = $mysqlConnection->query($query3);
                if (!$result3) {
                    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                } else {
                    $count3 = $result3 -> num_rows;
                }
                if($count3 > 0){
                    $bank = $result3->fetch_assoc();
                    $PaymentTypeID = $bank['PaymentTypeID'];
                    $Email = $bank['Email'];
                  
                    switch($PaymentTypeID){
                        case 1: $PaymentType = "Android Pay"; break;
                        case 2: $PaymentType = "ApplePay"; break;
                        case 5: $PaymentType = "PayPal"; break;
                    }
                    echo "
                            <div class = 'payment-box'>
                                <h3>Default Payment Method -- Third Party</h3>
                                <p>Payment Name: ".$PaymentType."</p> 
                                <p>Account Email: " .$Email. "</p>
                            </div>" ;

                }

                  $mysqlConnection->close();


            ?>

              <div class = "payment-box">
              <h1><Strong>Using Debit Card Or Credit Card</Strong></h1>
                        <form method = "post">
                                    <div class = "row">
                                        <div class = "col-sm-3">
                                            <div class="form-group">
                                                  <label for="sel1">Card Type</label>
                                                  <select class="form-control" name = "CardType" id = "sel1">
                                                        <option>Debit</option>
                                                        <option>Visa</option>
                                                        <option>Master</option>
                                                        <option>AMEX</option>
                                                        <option>Discover</option>
                                                  </select>
                                            </div>
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label>Name On The Card</label>
                                    <input type="text" name="cardHolderName" class="form-control" placeholder="Card Holder Name" required />
                                </div>
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input type="text" name="cardNumber" class="form-control" placeholder="Card Number"  required />
                                </div>
                                <div class="form-group">
                                    <label>CCV</label>
                                    <input type="text" name="CCV" class="form-control" placeholder="CCV"  required />
                                </div>
                                <div class = "row">
                                        <div class = "col-sm-3">
                                            <div class="form-group">
                                                <label>Expiration Date</label>
                                                <input type="date" name="expDate" class="form-control" placeholder="Expiration Date"  required />
                                            </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <p><input type = "checkbox" name="cardCheck" /> Set to default</p>
                                    <input type="submit" name="card" value="Update" />
                                </div>
                        </form>
              </div>
              <div class = "payment-box">
              <h1><Strong>Using Bank Account</Strong></h1>
                        <form method = "post">
                                <div class="form-group">
                                    <label>Bank Name</label>
                                    <input type="text" name="bankName" class="form-control" placeholder="bankName" required/>
                                </div>
                                <div class="form-group">
                                    <label>Holder Name</label>
                                    <input type="text" name="holderName" class="form-control" placeholder="Holder Name" required/>
                                </div>
                                <div class="form-group">
                                    <label>Bank Routing Number</label>
                                    <input type="text" name="bankRouting" class="form-control" placeholder="Bank Routing Number" required/>
                                </div>
                                <div class="form-group">
                                    <label>Account Number</label>
                                    <input type="text" name="accountNumber" class="form-control" placeholder="Account Number" required/>
                                </div>
                                <div class="form-group">
                                    <p><input type = "checkbox" name="bankCheck" /> Set to default</p>
                                    <input type="submit" name="bank" value="Update" />
                                </div>
                        </form>
              </div>
              <div class = "payment-box">
              <h1><Strong>Using Android Pay</Strong></h1>
                  <form method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="AndroidEmail" class="form-control" placeholder="Email" required/>
                            <p><input type = "checkbox" name="AndroidCheck" /> Set to default</p>
                            <input type="submit" name="AndroidPay" value="Update" />
                        </div>
                    </form>
              </div>
              <div class = "payment-box">
              <h1><Strong>Using Apple Pay</Strong></h1>
                    <form method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="AppleEmail" class="form-control" placeholder="Email" required/>
                            <p><input type = "checkbox" name="AppleCheck" /> Set to default</p>
                            <input type="submit" name="ApplePay" value="Update" />
                        </div>
                    </form>
              </div>
              <div class = "payment-box">
              <h1><Strong>Using Paypal</Strong></h1>
                    <form method="post">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="PaypalEmail" class="form-control" placeholder="Email" required/>
                            <p><input type = "checkbox" name="PaypalCheck" /> Set to default</p>
                            <input type="submit" name="Paypal" value="Update" />
                        </div>
                    </form>
              </div>

            </div>
        </div>
    </div>
</body>

</html>
