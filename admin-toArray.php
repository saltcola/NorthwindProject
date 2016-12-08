<?php 
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
?>