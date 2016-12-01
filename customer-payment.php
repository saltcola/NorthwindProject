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
            <div class="col-sm-4 employee-left">
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
            <div class="col-sm-8 employee-right">
            <?php

                    $CustomerID = $_SESSION["username"];

                    if (!empty($_POST['bank'])){
                            $bankName = $_POST['bankName'];
                            $holderName = $_POST['holderName'];
                            $bankRouting = $_POST['bankRouting'];
                            $accountNumber = $_POST['accountNumber'];
                            echo $bankName;
                            echo "<br>";
                            echo $holderName;
                            echo "<br>";
                            echo $bankRouting;
                            echo "<br>";
                            echo $accountNumber;
                            echo "<br>";
                            if(isset($_POST['bankCheck'])){
                                echo "Checked";
                            }else{
                                echo "Not checked";
                            }
                    } 
                    if (!empty($_POST['AndroidPay'])){
                            $AndroidEmail = $_POST['AndroidEmail'];
                            echo $AndroidEmail;
                            echo "<br>";
                            if(isset($_POST['AndroidCheck'])){
                                echo "Checked";
                            }else{
                                echo "Not checked";
                            }
                    } 
                    if (!empty($_POST['ApplePay'])){
                            $AppleEmail = $_POST['AppleEmail'];
                            echo $AppleEmail;
                            echo "<br>";
                            if(isset($_POST['AppleCheck'])){
                                echo "Checked";
                            }else{
                                echo "Not checked";
                            }
                    } 
                    if (!empty($_POST['Paypal'])){
                            $PaypalEmail = $_POST['PaypalEmail'];     
                            echo $PaypalEmail;
                            echo "<br>";
                            if(isset($_POST['PaypalCheck'])){
                                echo "Checked";
                            }else{
                                echo "Not checked";
                            }
                    }
                    if(!empty($_POST['card'])){
                        $CardType = $_POST['CardType'];
                        $CardHolderName = $_POST['cardHolderName'];
                        $CardNumber = $_POST['cardNumber'];
                        $CCV = $_POST['CCV'];
                        $expDate = $_POST['expDate'];
                        // echo $CardType;
                        // echo "<br>";
                        // echo $CardHolderName;
                        // echo "<br>";
                        // echo $CardNumber;
                        // echo "<br>";
                        // echo $CCV;
                        // echo "<br>";
                        // echo $expDate;
                        // echo "<br>";

                        if(isset($_POST['cardCheck'])){
                            $cardCheck = 1;
                        }else{
                            $cardCheck = 0;
                        }

                        // echo $cardCheck;
                        // echo "<br>";

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

                        // echo $CardTypeID;
                        // echo "<br>";

                        require('db.php');

                        $checkExistsQuery = " SELECT *
                                                    FROM customerPaymentCards
                                                    WHERE CustomerID = '$CustomerID'
                                                    AND CardTypeID = '$CardTypeID'
                                                    AND CardNumber = '$CardNumber' ";

                        // echo $checkExistsQuery;
                        //  echo "<br>";
                        $checkResult = NULL;
                        $checkResult = $mysqlConnection->query($checkExistsQuery);

                        if (!$checkResult) {
                            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
                        } else {
                            $count = $checkResult -> num_rows;
                            // echo $count;
                        }
                        

                        if($count > 0){
                            echo "<div class='form'>
                                    <h3>Sorry! This Card already exists!</h3>
                                    <br/>Click here to <a href='customer-payment.php'>Back</a></div>"; 
                            $mysqlConnection->close();  
                            exit();  
                        }

                        $query = " INSERT INTO `customerPaymentCards` (CardTypeID, CardNumber, HolderName, CCV, ExpireDate , CustomerID, Prefered)
                            VALUES ('$CardTypeID', '$CardNumber', '$CardHolderName', '$CCV', '$expDate', '$CustomerID', '$cardCheck')";

                        // echo $query;
                        //  echo "<br>";

                            $result = NULL;
                            $result = $mysqlConnection->query($query);
                            // echo $result;
                                
                            if($result){
                                echo "<div class='form'>
                                            <h3>Your payment method update successfully.</h3>
                                            <br/>Click here to <a href='customer-payment.php'>Back</a></div>";
                                exit();
                            }   

                        $mysqlConnection->close();                   

                }
            ?>

            <?php
                  require('db.php');

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
                        
                
                        echo "<div class = 'payment-box'>
                            <h1>Preferred Payment Method</h1>";
                        echo "<h3>Card Type:          ".$CardType."</h3>" ;
                        echo "<h3>CardNumber:       ".$row['CardNumber']."</h3>" ;
                        echo "<h3>Holder Name:      ".$row['CustomerID']."</h3>" ;
                        echo "<h3>CCV:                    ".$row['CCV']."</h3>" ;
                        echo "<h3>Expiration Date:   ".$row['ExpireDate']."</h3>" ;                            
                        echo "</div>";

                    }

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
                    // echo $count3;
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
