<?php
// echo "123";
$connection = mysqli_connect("localhost", "root", "", "takeout");
print_r($_GET);
if ($_SERVER["REQUEST_METHOD"] === "GET") {
  // 获取传递的订单ID
  
  $orderID = $_GET["orderID"];
  echo $orderID;
  echo "订单ID: " . $orderID . "<br>"; // 调试语句，用于确认接收到正确的订单ID

  // 更新订单状态为"商家已接单"
  $query = "UPDATE orders SET status='Completed' WHERE orderID=$orderID";
  echo "查询语句: " . $query . "<br>"; // 调试语句，用于确认生成的查询语句是否正确

  $result = mysqli_query($connection, $query);

  if ($result) {
    // 更新成功
    echo "订单已完成！";
  } else {
    // 更新失败
    echo "更新订单状态时出错，请重试！";
    echo "错误信息: " . mysqli_error($connection); // 调试语句，用于输出错误信息
  }
}

// 关闭数据库连接
mysqli_close($connection);
?>
