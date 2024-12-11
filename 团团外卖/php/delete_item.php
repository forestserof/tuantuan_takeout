<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");
session_start();
// 获取存储在会话中的user_id
$userID = $_SESSION['userID'];
if (isset($_POST['id'])) {
  $id = $_POST['id'];

  // 删除数据库中对应的记录
  $deleteQuery = "DELETE FROM cart WHERE foodID = $id and userID = $userID ";
  mysqli_query($connection, $deleteQuery);
}

// 关闭数据库连接
mysqli_close($connection);
header("Location: ../html/商家订单.php");
?>
