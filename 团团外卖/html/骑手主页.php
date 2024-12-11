<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 开始会话
session_start();
$courierID = $_SESSION['courierID'];
if (isset($_POST['update_status'])) {
  $orderID = $_POST['orderID'];
  $merchantID = $_POST['merchantID'];
  // $foodID = $_POST['foodID'];
  $status = $_POST['status'];
if($status='Delivered'){
// 更新订单状态
$updateQuery = "UPDATE `orders` 
SET status = '$status',courierID = '$courierID'
WHERE orderID = '$orderID' AND merchantID = '$merchantID'";
}
if($status='Completed'){
  // 更新订单状态
  $updateQuery = "UPDATE `orders` 
  SET status = '$status',courierID = '$courierID',deliveryTime = NOW() 
  WHERE orderID = '$orderID' AND merchantID = '$merchantID'";
  }
  // echo $updateQuery;
  mysqli_query($connection, $updateQuery);
}

// 读取订单状态函数
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
  <title>骑手订单</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
</head>
<body>
  
    <header>
        <nav>
          <h1>骑手订单</h1>
          <ul>
            <li><a href="骑手页面.php">我的订单</a></li>
            <li><a href="骑手个人主页.php">个人主页</a></li>
          </ul>
        </nav>
      </header>

    <div class="container">
        <center><h2>骑手的订单</h2>
        <br>
        <table id="orders-table">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>用户名</th>
                    <th>商家</th>
                    <th>商家地址</th>
                    <!-- <th>备注</th> -->
                    <th>客户地址</th>
                    <th>状态</th>
                    <th>操作</th>
                    <th>  </th>
                </tr>
            </thead>
            <tbody id="orders-body">
              <?php
                // 从"orders"表中检索数据
                $query = "SELECT * FROM orders";
                $result = mysqli_query($connection, $query);
                
                // 循环遍历检索到的数据并在表格中显示出来
                while ($row = mysqli_fetch_assoc($result)) {
                  $userID=$row['userID'];
                  $merchantID=$row['merchantID'];
                  $query1 = "SELECT * FROM users where userID=$userID";
                  $result1 = mysqli_query($connection, $query1);
                  $row1 = mysqli_fetch_assoc($result1);
                
                $query2 = "SELECT * FROM merchants where merchantID=$merchantID";
                $result2 = mysqli_query($connection, $query2);
                $row2 = mysqli_fetch_assoc($result2);
                  // 判断订单状态是否为"未接单"
                  if ($row['status'] == 'Dispatched' || $row['courierID'] == $courierID ) {
                    
                  echo "<tr>";
                  echo "<td>" . $row['orderID'] . "</td>";
                  echo "<td>" . $row1['username'] . "</td>";
                  echo "<td>" . $row2['merchantName'] . "</td>";
                  echo "<td>" . $row2['address'] . "</td>";
                  // echo "<td>" . $row['remarks'] . "</td>";
                  echo "<td>" . $row['address'] . "</td>";
                  
                  
                  echo "<td>" . getOrderStatus($row['status']) . "</td>";
                  echo "<td>
                            <form method='post' action=''>
                                <input type='hidden' name='orderID' value='" . $row['orderID'] . "'>
                                <input type='hidden' name='merchantID' value='" . $row['merchantID'] . "'>
                                
                                <select name='status'>
                                    <option value='Delivered'" . ($row['status'] == 'Dispatched' ? ' selected' : '') . ">骑手已接单</option>
                                    <option value='Completed'" . ($row['status'] == 'Delivered' ? ' selected' : '') . ">骑手已送达</option>
                                </select>
                            </td>";
                  echo "<td>
                            <button type='submit' name='update_status'>更新</button>
                        </td>";
                  echo "</form>";
                  echo "</tr>";
                  }
                }

                // 关闭数据库连接
                mysqli_close($connection);
              ?>
            </tbody>
        </table>
      </center>
    </div>

</body>
</html>
