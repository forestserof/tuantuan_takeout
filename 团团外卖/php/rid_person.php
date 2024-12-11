<?php
session_start();

// 检查用户是否已登录
if (!isset($_SESSION['courierID'])) {
    // 用户未登录，进行相应处理，例如跳转到登录页面
    header("Location: ../html/login.php");
    exit();
}

// 建立数据库连接
$connection = mysqli_connect("localhost", "root", "", "takeout");

// 检查连接是否成功
if (!$connection) {
    die("数据库连接失败: " . mysqli_connect_error());
}

// 处理更新个人信息请求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] == "update_info") {
    $courierID = $_SESSION['courierID'];
    $name = $_POST['name'];

    // 执行更新个人信息的SQL语句
    $updateQuery = "UPDATE couriers SET courierName = '$name' WHERE courierID = $courierID";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // 个人信息更新成功，进行相应处理
        header("Location: ../html/骑手个人主页.php");
        exit();
    } else {
        // 个人信息更新失败，进行相应处理，例如显示错误信息
        echo "个人信息更新失败: " . mysqli_error($connection);
    }
}

// 处理更新密码请求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] == "update_password") {
    $courierID = $_SESSION['courierID'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // 查询当前用户的密码
    $selectQuery = "SELECT password FROM couriers WHERE courierID = $courierID";
    $selectResult = mysqli_query($connection, $selectQuery);

    if ($selectResult && mysqli_num_rows($selectResult) === 1) {
        $row = mysqli_fetch_assoc($selectResult);
        $currentPassword = $row['password'];

        // 检查旧密码是否匹配
        if ($oldPassword === $currentPassword) {
            // 旧密码正确，执行更新密码的SQL语句
            $updateQuery = "UPDATE couriers SET password = '$newPassword' WHERE courierID = $courierID";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
                // 密码更新成功，进行相应处理
                echo '<script>alert("密码修改成功");window.location.href="../html/骑手个人主页.php";</script>';
                exit();
            } else {
                // 密码更新失败，进行相应处理，例如显示错误信息
                echo "密码更新失败: " . mysqli_error($connection);
            }
        } else {
            // 旧密码不匹配，显示弹窗提示
            echo '<script>alert("旧密码输入不正确");window.location.href="../html/骑手个人主页.php";</script>';
            exit();
        }
    } else {
        // 查询当前用户密码失败，进行相应处理，例如显示错误信息
        echo "密码查询失败: " . mysqli_error($connection);
    }
}

// 关闭数据库连接
mysqli_close($connection);
?>
