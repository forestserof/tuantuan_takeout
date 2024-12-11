<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 开始会话
session_start();
// 获取存储在会话中的user_id
$userID = $_SESSION['userID'];

$connection = mysqli_connect("localhost", "root", "", "takeout");
if (isset($_POST['merchantID'])) {
  $merchantID = $_POST['merchantID'];
  // echo "Restaurant ID: " . $restaurantID;
}

$query0 = "SELECT * FROM merchants WHERE merchantID = $merchantID";
$result0 = mysqli_query($connection, $query0);
$row0 = mysqli_fetch_assoc($result0);
$merchantName = $row0['merchantName'];

if (isset($_POST['add_to_cart'])) {
  $price = $_POST['price'];
  $foodID = $_POST['foodID'];

  // 检查数据库中是否存在相同的userid和itemid记录
  $checkQuery = "SELECT foodID, quantity FROM cart WHERE foodID = '$foodID' AND userID = $userID";
  $checkResult = mysqli_query($connection, $checkQuery);
  if (mysqli_num_rows($checkResult) > 0) {
    // 存在相同记录，更新数量
    $row = mysqli_fetch_assoc($checkResult);
    $foodID = $row['foodID'];
    $currentQuantity = $row['quantity'];

    $newQuantity = $currentQuantity + 1;
    $updateQuery = "UPDATE cart SET quantity = $newQuantity WHERE foodID = $foodID";
    mysqli_query($connection, $updateQuery);
  } else {
    // 不存在相同记录，插入新的记录
    $insertQuery = "INSERT INTO `cart` (foodID, userID, quantity) VALUES ('$foodID', '$userID', 1 )";
    mysqli_query($connection, $insertQuery);
  }

  // 设置添加成功的标识
  $_SESSION['added_to_cart'] = true;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>吃不饱外卖</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
  <style>
    #message-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 10px 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <header>
    <nav>
      <h1>吃不饱外卖</h1>
      <ul>
      <li><a href="客户主页.php">首页</a></li>
        <li><a href="购物车.php">购物车</a></li>
        <li><a href="客户订单.php">我的订单</a></li>
        <li><a href="个人主页.php">个人主页</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <center>
      <h2><?php echo $merchantName; ?></h2>
      <br>
      <table id="menu-table">
        <thead>
          <tr>
            <th>菜品图片</th>
            <th>菜名</th>
            <th>价格</th>
            <th>描述</th>
            <th>    </th>
          </tr>
        </thead>
        <tbody id="menu-body">
          <?php
            // 从"menu"表中检索数据
            $query = "SELECT * FROM foods WHERE merchantID = $merchantID";
            $result = mysqli_query($connection, $query);
            $path = '../photo/';

            // 循环遍历检索到的数据并在表格中显示出来
            while ($row = mysqli_fetch_assoc($result)) {
              $file = $row['photo'];
              echo "<tr>";
              echo "<td><img src='{$path}$file' alt='' width='160' height='120'></td>";
              echo "<td>" . $row['foodName'] . "</td>";
              echo "<td>" . $row['price'] . "</td>";
              echo "<td>" . $row['description'] . "</td>";
              echo "<td>
                      <form method='post' action=''>
                        <input type='hidden' name='foodID' value='" . $row['foodID'] . "'>
                        <input type='hidden' name='merchantID' value='" . $row['merchantID'] . "'> 
                        <input type='hidden' name='price' value='" . $row['price'] . "'>
                        <input type='hidden' name='description' value='" . $row['description'] . "'>
                        <button type='submit' name='add_to_cart'>加入购物车</button>
                      </form>
                    </td>";
              echo "</tr>";
            }

            // 关闭数据库连接
            mysqli_close($connection);
          ?>
        </tbody>
      </table>
    </center>
  </div>

  <div id="message-container">已加入购物车</div>
  <script>
    // 显示提示信息并在一段时间后隐藏
    function showAddToCartMessage() {
      var messageContainer = document.getElementById("message-container");
      messageContainer.style.display = "block";
      setTimeout(function() {
        messageContainer.style.display = "none";
      }, 2000); // 3秒后隐藏提示信息
    }

    // 页面加载后检查是否添加到购物车成功并显示提示信息
    window.onload = function() {
      <?php if (isset($_SESSION['added_to_cart']) && $_SESSION['added_to_cart']) { ?>
        showAddToCartMessage();
        <?php unset($_SESSION['added_to_cart']); ?>
      <?php } ?>
    };
  </script>
</body>
</html>
