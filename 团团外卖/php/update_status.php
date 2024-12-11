<?php
// echo "123";
$connection = mysqli_connect("localhost", "root", "", "takeout");
print_r($_GET);
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  // 获取传递的订单ID
  
  $orderID = $_GET["orderID"];
  echo $orderID;
  echo "订单ID: " . $orderID . "<br>"; // 调试语句，用于确认接收到正确的订单ID
  $query = "SELECT * FROM orders WHERE orderID=$orderID ";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  // 更新订单状态为"商家已接单"
  
  if ($row['status'] == 'Unget') {
    $query = "UPDATE orders SET status='Preparing' WHERE orderID=$orderID";
}
if ($row['status'] == 'Preparing') {
  $query = "UPDATE orders SET status='Dispatched',dispatchTime=NOW() WHERE orderID=$orderID";
}
  $result = mysqli_query($connection, $query);

  if ($result) {
    // 更新成功
    echo "订单已成功接单！";
  } else {
    // 更新失败
    echo "更新订单状态时出错，请重试！";
    echo "错误信息: " . mysqli_error($connection); // 调试语句，用于输出错误信息
  }
}

// 关闭数据库连接
mysqli_close($connection);
?>
