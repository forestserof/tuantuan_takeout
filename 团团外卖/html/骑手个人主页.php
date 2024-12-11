<?php
// 开始会话
session_start();

// 获取存储在会话中的user_id
$courierID = $_SESSION['courierID'];
// 从"login"表中检索数据
$connection = mysqli_connect("localhost", "root", "", "takeout");
$query = "SELECT courierName FROM couriers where courierID=$courierID";
$result = mysqli_query($connection, $query);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <link rel="stylesheet" href="../css/zystyle.css">
  <link rel="stylesheet" href="../css/ddstyle.css">
    <style type="text/css">
        body {
            background-color: #f2f5f8;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color:#abdcd6;
            color: #fff;
            text-align: center;
            margin-right: -17px;

        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            margin-right: 0px;
        }
        /* 设置表头样式 */
th {
  background-color: #f2f2f2;
  font-weight: bold;
  text-align: left;
  padding: 8px;
}

/* 设置表格单元格样式 */
td {
  padding: 8px;
}
        .wrapper {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin: 16px;
            padding: 16px;
        }    
        form {
            margin-top: 16px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
        }
        form input[type="text"],
        form input[type="password"],
        form select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            width: 80%;
        }
        form select {
            height: 32px;
        }
        form button {
            background-color: #f1adb1;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            margin-top: 16px;
            padding: 8px;
            font-weight: bold;
            transition: background-color 0.2s ease;
        }
        form button:hover {
            background-color: #ff4d85;
        }
    </style>
</head>

<body>
    <center>
    <header>
    <nav>
      <h1>团团外卖</h1>
      <ul>
      <li><a href="骑手主页.php">我的订单</a></li>
            <li><a href="骑手个人主页.php">个人主页</a></li>
      </ul>
    </nav>
    </header>
    </center>
    <div class="wrapper">
    <table>
    <thead>
        <tr>
                <th>用户名</th>
        </tr>
    </thead>
    <?php
        // 循环遍历检索到的数据并在表格中显示出来
        while ($row = mysqli_fetch_assoc($result)) {
        $courierName=$row['courierName'];
        // $photo=$row['per_photo'];

        echo "<tr>";
        // echo "<td><img src='$photo' alt='头像' width='100' height='100'></td>";
        echo "<td>" . $courierName . "</td>";
        echo "</tr>";
        }
    ?>
    </table>
    </div>
    <div class="wrapper">
        <h2>修改个人信息</h2>
        <form method="post" action="../php/rid_person.php"> <!-- 将 action 设置为后端处理修改个人信息的 PHP 文件 -->
            <label for="name">用户名/店名</label>
            <input type="text" id="name" name="name" required>
            
            <button type="submit">保存</button>
            <input type="hidden" name="form_type" value="update_info"> <!-- 隐藏字段，指定表单类型为修改个人信息 -->
        </form>
    </div>
    
    
    <div class="wrapper">
        <h2>修改密码</h2>
        <form method="post" action="../php/rid_person.php">
            <label for="old_password">旧密码</label>
            <input type="password" id="old_password" name="old_password" required>
            
            <label for="new_password">新密码</label>
            <input type="password" id="new_password" name="new_password" required>
            
            <label for="confirm_password">确认密码</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">保存</button>
            <input type="hidden" name="form_type" value="update_password"> <!-- 隐藏字段，指定表单类型为修改密码 -->
        </form>
    </div>

    <div class="wrapper">
        <form method="post" action="./登录.html"> <!-- 将 action 设置为后端处理修改个人信息的 PHP 文件 -->
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
        <button type="submit">退出登录</button>
            </div>
        </form>
    </div>
</body>
</html>