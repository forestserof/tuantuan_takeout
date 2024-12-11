<?php
// 从"restaurants"表中检索数据
          $connection = mysqli_connect("localhost", "root", "", "takeout");
          $query = "SELECT * FROM merchants";
          $result = mysqli_query($connection,$query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>团团外卖</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
</head>
<body>
  <header>
    <nav>
      <h1>团团外卖</h1>
      <ul>
      <li><a href="客户主页.php">首页</a></li>
        <li><a href="购物车.php">购物车</a></li>
        <li><a href="客户订单.php">我的订单</a></li>
        <li><a href="个人主页.php">个人主页</a></li>
      </ul>
    </nav>
  </header>
  <center>
    <table id="restaurant-table">
      <thead>
        <tr>
          <th>店名</th>
        </tr>
      </thead>
      <tbody id="restaurant-body">
        <?php
          

          // 循环遍历检索到的数据并在表格中显示出来
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['merchantName'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "<td>
            <form method='post' action='菜品.php' id='restaurant-form'>
            <input type='hidden' name='merchantID' value=".$row['merchantID'].">
            <button type='submit' name='view_menu' onclick='submitForm()'>→</button>
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
</body>
</html>
