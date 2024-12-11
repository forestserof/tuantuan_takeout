<?php
// 开始会话
session_start();
// 获取存储在会话中的 user_id
$userID = $_SESSION['userID'];

// 连接数据库
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 获取备注和地址
$address = $_POST['address'];

// 生成唯一的order_id
do {
  $orderID = rand(100000, 999999);
  $checkQuery = "SELECT orderID FROM orders WHERE orderID = '$orderID'";
  $checkResult = mysqli_query($connection, $checkQuery);
  $orderExists = mysqli_num_rows($checkResult) > 0;
} while ($orderExists);

// 查询购物车信息
$cartQuery = "SELECT * FROM cart WHERE userID = $userID";
$cartResult = mysqli_query($connection, $cartQuery);

// 循环遍历购物车中的项，并插入订单表
while ($cartRow = mysqli_fetch_assoc($cartResult)) {
  $foodID = $cartRow['foodID'];
  $quantity = $cartRow['quantity'];
  $foodQuery = "SELECT * FROM foods WHERE foodID = $foodID";
  $foodResult = mysqli_query($connection, $foodQuery);
  $foodRow = mysqli_fetch_assoc($foodResult);
  $merchantID = $foodRow['merchantID'];
  // 插入订单
  $orderQuery = "INSERT INTO orders (orderID, userID, merchantID, address, status)
   VALUES ('$orderID', '$userID', '$merchantID',  '$address', 'Unget')";
  //  echo $orderQuery;
  //  echo "<br>";
  mysqli_query($connection, $orderQuery);

  $orderdetailsQuery = "INSERT INTO orderdetails (orderID, foodID, quantity) 
  VALUES ('$orderID', $foodID, $quantity )";
  // echo $orderdetailsQuery;
  mysqli_query($connection, $orderdetailsQuery);
  $clearCartQuery = "DELETE FROM cart WHERE userID = $userID and foodID = $foodID";
  mysqli_query($connection, $clearCartQuery);
}

// 循环遍历购物车中的项，并插入订单详情表



// 关闭数据库连接
mysqli_close($connection);

// 弹出订单提交确认消息框
echo "<script>alert('订单已提交！');</script>";

// 跳转到订单页面或其他操作
header("Location: ../html/客户订单.php");
exit();
?>
