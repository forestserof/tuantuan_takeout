<?php
require_once("conn.php");

// Print the received POST data
print_r($_POST);

// Get the form submission data
$name = $_POST['name'];
$password = $_POST['password'];
$type = $_POST['type'];

$connection = mysqli_connect("localhost", "root", "", "takeout");

// Build SQL statement, table name, and fields based on the selected type
if ($type === '客户') {
    $tableName = 'users';
    $fields = 'userID ,username, password';
    do {
        $ID = rand(100000, 999999);
        $checkQuery = "SELECT userID FROM users WHERE userID = '$ID'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $orderExists = mysqli_num_rows($checkResult) > 0;
      } while ($orderExists);
    $values = "'$ID','$name', '$password'";
} elseif ($type === '商家') {
    $tableName = 'merchants';
    $fields = 'merchantID, merchantName, password, address';
    $address = $_POST['address'];
    do {
        $ID = rand(100000, 999999);
        $checkQuery = "SELECT merchantID FROM merchants WHERE merchantID = '$ID'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $orderExists = mysqli_num_rows($checkResult) > 0;
      } while ($orderExists);
    $values = "'$ID','$name', '$password', '$address'";
} elseif ($type === '骑手') {
    $tableName = 'couriers';
    do {
        $ID = rand(100000, 999999);
        $checkQuery = "SELECT courierID FROM couriers WHERE courierID = '$ID'";
        $checkResult = mysqli_query($connection, $checkQuery);
        $orderExists = mysqli_num_rows($checkResult) > 0;
      } while ($orderExists);
    $fields = 'courierID,courierName, password';
    $values = "'$ID','$name', '$password'";
}

// Build the SQL statement and execute the insert operation
$sql = "INSERT INTO $tableName ($fields) VALUES ($values)";
echo $sql;
mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);

// Redirect to the login page
header("location:../html/登录.html");
?>
