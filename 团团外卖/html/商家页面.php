
<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 开始会话
session_start();

// 获取存储在会话中的restaurant_id
$merchantID = $_SESSION['merchantID'];
$query0 = "SELECT * FROM merchants where merchantID=$merchantID";
$result0 = mysqli_query($connection, $query0);
$row0 = mysqli_fetch_assoc($result0);
$merchantName = $row0['merchantName'];


if (isset($_POST['delete_item'])) {
  $itemID = $_POST['item_id'];

  // 从menu表中删除指定菜品
  $deleteQuery = "DELETE FROM `menu` WHERE item_id = '$itemID' AND restaurant_id = '$restaurantID'";
  mysqli_query($connection, $deleteQuery);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>吃不饱外卖</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
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
        <center><h2><?php echo $merchantName ?>菜单</h2>
        <br>
        <table id="menu-table">
            <thead>
                <tr>
                    <th>菜品图片</th>
                    <th>菜名</th>
                    <th>价格</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="menu-body">
              <?php
                // 从"menu"表中检索数据

                $query = "SELECT * FROM foods where merchantID=$merchantID";
                $result = mysqli_query($connection, $query);
                $path = '../photo/';
                // 循环遍历检索到的数据并在表格中显示出来
                while ($row = mysqli_fetch_assoc($result)) {
                  $file =  $row['photo']  ;
                  echo "<tr>";
                  echo "<td><img src='{$path}$file' alt=''  width='160' height='120'></td>";
                  echo "<td>" . $row['foodName'] . "</td>";
                  echo "<td>" . $row['price'] . "</td>";
                  echo "<td>" . $row['description'] . "</td>";
                  echo "<td>
                            <form method='post' action='../php/delete_food.php'>
                                <input type='hidden' name='foodID' value='" . $row['foodID'] . "'>
                                <input type='hidden' name='merchantID' value='" . $row['merchantID'] . "'> 
                                <input type='hidden' name='price' value='" . $row['price'] . "'>
                                <input type='hidden' name='description' value='" . $row['description'] . "'>
                                <button type='submit' name='delete_item'>删除</button>
                            </form>
                        </td>";
                  echo "</tr>";
                }

                // 关闭数据库连接
                mysqli_close($connection);
              ?>
            </tbody>
        </table>
        <br>
        <button onclick="showAddForm()">新增菜品</button>
          <div id="addFormContainer" style="display: none;">
            <form method="post" action="../php/upload.php" enctype="multipart/form-data">
              <label for="name">菜名:</label>
              <input type="text" name="name" id="name" required><br><br>
              <label for="price">价格:</label>
              <input type="text" name="price" id="price" required><br><br>
              <label for="description">描述:</label>
              <input type="text" name="description" id="description" required><br><br>
              <label for="photo">菜品图片:</label>
              <input type="file" name="file" id="file" required><br><br>
              <button type="submit">提交</button>
            </form>
          </div>
      </center>
    </div>

  </center>
  <script src="../js/cpscript.js"></script>
  <script>
      function showAddForm() {
        var addFormContainer = document.getElementById("addFormContainer");
        addFormContainer.style.display = "block";
      }
    </script>
</body>
</html>
