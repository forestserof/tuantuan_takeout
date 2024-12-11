<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");
session_start();
// 获取存储在会话中的user_id
$merchantID = $_SESSION['merchantID'];
if (isset($_POST['foodID'])) {
  $foodID = $_POST['foodID'];

  // 删除数据库中对应的记录
  $deleteQuery = "DELETE FROM foods WHERE foodID = $foodID";
  mysqli_query($connection, $deleteQuery);
}

// 关闭数据库连接
mysqli_close($connection);
?>