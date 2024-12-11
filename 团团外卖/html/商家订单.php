<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 开始会话
session_start();

// 获取存储在会话中的restaurant_id
$merchantID = $_SESSION['merchantID'];
$query0 = "SELECT merchantName FROM merchants WHERE merchantID=$merchantID";
$result0 = mysqli_query($connection, $query0);
$row0 = mysqli_fetch_assoc($result0);
$merchantName = $row0['merchantName'];
function getOrderStatus($status) {
  switch ($status) {
    case 'Unget':
      return '商家未接单';
    case 'Preparing':
      return '商家已接单';
    case 'Dispatched':
      return '等待骑手接单中';
    case 'Delivered':
      return '骑手已接单';
      case 'Completed':
      return '骑手已送达';
    default:
      return '未知状态';
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>团团外卖</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
  
  <style>
  .btn {
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
</style>

</head>
<body>
  
    <header>
        <nav>
          <h1>团团外卖</h1>
          <ul>
          <li><a href="商家页面.php">首页</a></li>
            <li><a href="商家订单.php">我的订单</a></li>
            <li><a href="商家个人主页.php">个人主页</a></li>
          </ul>
        </nav>
      </header>

    <div class="container">
        <center><h2><?php echo $merchantName ?>的订单</h2>
        <table id="menu-table">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>用户ID</th>
                    <!-- <th>备注</th> -->
                    <th>地址</th>
                    <th>订单内容</th>
                    <th>订单总价</th>
                    <th>订单状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="menu-body">
              <?php
             // 从"orders"表中检索符合当前用户的订单，并按订单号升序排列
             $query = "SELECT * FROM orders WHERE merchantID=$merchantID ";
             $result = mysqli_query($connection, $query);
             // echo $query;
             $displayedOrders = array();
             
             while ($row = mysqli_fetch_assoc($result)) {
               $orderID = $row['orderID'];
               $query2 = "SELECT * FROM orderdetails WHERE orderID = '$orderID' ";
               // echo $query;
               // echo $query2;
               $result2 = mysqli_query($connection, $query2);
               if (!$result2) {
                 die("查询失败: " . mysqli_error($connection));
             }
               //检查订单号是否已经显示过，如果是，则跳过该订单的显示
               if (in_array($orderID, $displayedOrders)) {
                 continue;
               }

               echo "<tr>";
               echo "<td>" . $orderID . "</td>";
               echo "<td>" . $row['userID'] . "</td>";
               echo "<td>" . $row['address'] . "</td>";
               echo "<td>";

               $totalPrice = 0;
               $orderContent = array();

               while ($row2 = mysqli_fetch_assoc($result2)) {
                 $foodID = $row2['foodID'];
                 $quantity = $row2['quantity'];
                 //找food表里的名字
                 $query3 = "SELECT * FROM foods WHERE foodID=$foodID ";
                 $result3 = mysqli_query($connection, $query3);
                 $row3 = mysqli_fetch_assoc($result3);

                 $foodName = $row3['foodName'];
                 $price = $row3['price'];

                 $itemTotal = $price * $quantity;
                 $totalPrice += $itemTotal;

                 if (!isset($orderContent[$foodName])) {
                   $orderContent[$foodName] = 0;
                 }
                 $orderContent[$foodName] += $quantity;

                 echo $foodName . " × " . $quantity . "<br>";
               }

               echo "</td>";
               echo "<td>" . $totalPrice . "</td>";
               echo "<td>" . getOrderStatus($row['status']) . "</td>";
               echo "<td>";
               
                  
                  // 添加接单按钮
                  if ($row['status'] == 'Unget') {
                      echo "<button class='btn'  onclick=\"updateStatus(" . $orderID . ")\">接单</button>";
                  }
                  if ($row['status'] == 'Preparing') {
                    echo "<button class='btn'  onclick=\"updateStatus(" . $orderID . ")\">出餐</button>";
                }
                  
                  echo "</td>";
                  echo "</tr>";

                  // 将已显示的订单号添加到数组中
                  $displayedOrders[] = $orderID;
                }

                // 关闭数据库连接
                mysqli_close($connection);
              ?>
            </tbody>
        </table>
      </center>
    </div>

  </center>

  <div id="message"></div>

  <script>
  // 更新订单状态
  function updateStatus(orderID) {
    // 发起 AJAX 请求
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../php/update_status.php?orderID=" + orderID, true);
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // 请求成功后刷新页面
        location.reload();
        document.getElementById("message").innerHTML = xhr.responseText;
      }
    };
    // 发送 AJAX 请求
    xhr.send();
  }
</script>



</body>

</html>
