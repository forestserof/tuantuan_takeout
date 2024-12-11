<?php
// 开始会话
session_start();
// 获取存储在会话中的user_id
$userID = $_SESSION['userID'];

// 从"cart"表中检索数据
$connection = mysqli_connect("localhost", "root", "", "takeout");
$query = "SELECT * FROM cart where userID=$userID";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>团团外卖</title>
  <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
  <style>
    .quantity-buttons {
      /* display: flex; */
      justify-content: center;
      align-items: center;
    }

    .quantity-button {
      border: none;
      background-color: #f2f2f2;
      font-size: 16px;
      cursor: pointer;
      padding: 5px 10px;
      color: #333;
    }

    .delete-button {
      border: none;
      background-color: #f2f2f2;
      font-size: 16px;
      cursor: pointer;
      padding: 5px 10px;
      color: #ff0000;
    }
  </style>
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
  <form method="post" action="../php/ddsubmit.php">
    <center>
      <br>
      <h2>购物车</h2>
      <br>
      <table id="restaurant-table">
        <thead>
          <tr>
            <th>菜名</th>
            <th>图片</th>
            <th>价格</th>
            <th>数量</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody id="restaurant-body">
          <?php
          // 定义一个变量来存储商品总价
          $totalPrice = 0;
          $path = '../photo/';
          // 循环遍历检索到的数据并在表格中显示出来
          while ($row = mysqli_fetch_assoc($result)) {
            $foodID = $row['foodID'];
            $query1 = "SELECT * FROM foods where foodID=$foodID";
            $result1 = mysqli_query($connection, $query1);
            $row1 = mysqli_fetch_assoc($result1);
            $file = $row1['photo'];

            // 累加每个商品的价格到总价变量中
            $totalPrice += $row1['price'] * $row['quantity'];

            echo "<tr>";
            echo "<td class='item-price'>" . $row1['foodName'] . "</td>";
            echo "<td>";
            echo "<img src='{$path}$file' alt='' width='160' height='120'>";
            echo "</td>";
            echo "<td class='item-price'>" . $row1['price'] . "</td>";
            echo "<td>";
            echo "<div class='quantity-buttons'>";
            echo "<button class='quantity-button minus-button' data-id='" . $row['foodID'] . "' data-quantity-change='-1'>-</button>";
            echo "<span class='quantity' id='quantity-" . $row['foodID'] . "'>" . $row['quantity'] . "</span>";
            echo "<button class='quantity-button plus-button' data-id='" . $row['foodID'] . "' data-quantity-change='1'>+</button>";
            echo "</div>";
            echo "</td>";
            echo "<td>";
            echo "<button class='delete-button' data-id='" . $row['foodID'] . "'>删除</button>";
            echo "</td>";
            echo "</tr>";
          }

          // 关闭数据库连接
          mysqli_close($connection);
          ?>
        </tbody>
      </table>
    </center>
    <p id="total-price">总价：<?php echo $totalPrice; ?></p>
    <div>
      <label for="address">地址：</label>
      <input type="text" id="address" name="address" required>
    </div>
    <br/>
    <button type="submit">提交订单</button>
  </form>
  <center>
  </center>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../js/gwscript.js"></script>
  <script>
    $(document).ready(function() {
      // 减少商品数量的按钮点击事件处理程序
      $(".minus-button").on("click", function() {
        var id = $(this).data("id");
        var quantityChange = $(this).data("quantity-change");
        var quantityElement = $("#quantity-" + id);
        var quantity = parseInt(quantityElement.text());

        // 更新数量
        // quantity += quantityChange;
        quantityElement.text(quantity);

        // 更新总价
        updateTotalPrice();
      });

      // 增加商品数量的按钮点击事件处理程序
      $(".plus-button").on("click", function() {
        var id = $(this).data("id");
        var quantityChange = $(this).data("quantity-change");
        var quantityElement = $("#quantity-" + id);
        var quantity = parseInt(quantityElement.text());

        // 更新数量
        quantity += quantityChange;
        quantityElement.text(quantity);

        // 更新总价
        updateTotalPrice();
      });

      // 删除商品按钮点击事件处理程序
      $(".delete-button").on("click", function() {
        var id = $(this).data("id");
        var row = $(this).closest("tr");

        // 移除商品行
        row.remove();

        // 更新总价
        updateTotalPrice();
      });

      // 更新总价的函数
      function updateTotalPrice() {
        var totalPrice = 0;

        // 计算新的总价
        $(".item-price").each(function() {
          var price = parseFloat($(this).text());
          var quantity = parseInt($(this).closest("tr").find(".quantity").text());
          totalPrice += price * quantity;
        });

        // 更新总价元素的内容
        $("#total-price").text("总价：" + totalPrice);
      }
    });
  </script>
</body>
</html>
