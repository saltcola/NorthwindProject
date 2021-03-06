<?php
    //include auth.php file on all secure pages
    //include("auth.php");
    session_start();
    if(!isset($_SESSION["username"])){
        header("Location: admin-login.php");
        exit(); 
    }else{
        require('db.php');
        $query = "SELECT * FROM `employees` ";
        $result = NULL;
        $result = $mysqlConnection->query($query);
        $array = array();
        if (!$result) {
            throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
        } else {
            $count = $result -> num_rows;
            // echo $count;
            // echo "<br>";
            while($row = $result->fetch_assoc()) $array[] = $row;
        }

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
              <table class="table">
                        <thead>
                          <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>TitleOfCourtesy</th>
                            <th>Title</th>
                            <th>Birthday</th>
                            <th>HireDate</th>
                            <th>HomePhone</th>
                            <th>Salary</th>
                            <th>Edit</th>
                          </tr>
                        </thead>
            <?php foreach ($array as $employee){
                            $FirstName = $employee['FirstName'];
                            $LastName = $employee['LastName'];
                            $Title = $employee['Title'];
                            $TitleOfCourtesy = $employee['TitleOfCourtesy'];
                            $Birthday = $employee['BirthDate'];
                            $HireDate = $employee['HireDate'];
                            $HomePhone = $employee['HomePhone'];
                            $Salary = $employee['Salary'];
                            $EmployeeID = $employee['EmployeeID'];
            ?>
                        <tbody>
                            <tr>
                                <td><?php echo $FirstName?></td>
                                <td><?php echo $LastName ?></td>
                                <td><?php echo $TitleOfCourtesy ?></td>
                                <td><?php echo $Title ?></td>
                                <td><?php echo $Birthday?></td>
                                <td><?php echo $HireDate?></td>
                                <td><?php echo $HomePhone?></td>
                                <td><?php echo $Salary?></td>
                                <td>
                                    <?php 
                                    echo "<a href ='admin-editemployee.php?id=".$EmployeeID." '> Edit</a> ";
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
