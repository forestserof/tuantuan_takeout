<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");
session_start();
// 获取存储在会话中的user_id
$userID = $_SESSION['userID'];
if (isset($_POST['id']) && isset($_POST['quantityChange'])) {
  $id = $_POST['id'];
  $quantityChange = $_POST['quantityChange'];

  // 查询当前商品的数量
  $query = "SELECT quantity FROM cart WHERE foodID = $id and userID = $userID";
  $result = mysqli_query($connection, $query);
  $row = mysqli_fetch_assoc($result);
  $currentQuantity = $row['quantity'];

  // 计算更新后的数量
  $newQuantity = $currentQuantity + $quantityChange;

  // 确保数量最低为1
  $newQuantity = max($newQuantity, 1);

  // 更新数据库中的数量
  $updateQuery = "UPDATE cart SET quantity = $newQuantity WHERE foodID = $id and userID = $userID ";
  mysqli_query($connection, $updateQuery);

  // 返回更新后的数量
  echo $newQuantity;
}
// 关闭数据库连接
mysqli_close($connection);
?>
