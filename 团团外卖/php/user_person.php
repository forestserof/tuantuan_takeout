<?php
session_start();

// 检查用户是否已登录
if (!isset($_SESSION['userID'])) {
    // 用户未登录，进行相应处理，例如跳转到登录页面
    header("Location: ../html/登录.html");
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
    $userID = $_SESSION['userID'];
    $username = $_POST['name'];

    // 执行更新个人信息的SQL语句
    $updateQuery = "UPDATE users SET username = '$username' WHERE userID = $userID";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // 个人信息更新成功，进行相应处理
        header("Location: ../html/个人主页.php");
        exit();
    } else {
        // 个人信息更新失败，进行相应处理，例如显示错误信息
        echo "个人信息更新失败: " . mysqli_error($connection);
    }
}
// 处理更新头像请求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] == "update_avatar") {
    $userID = $_SESSION['userID'];
    
    // 处理上传的头像文件
    if ($_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
        $tempName = $_FILES["avatar"]["tmp_name"];
        $fileName = $_FILES["avatar"]["name"];
        
        // 指定保存头像文件的目录
        $uploadDir = "../avatars/";
        $filePath = $uploadDir . $fileName;
        
        // 将临时文件移动到指定目录
        if (move_uploaded_file($tempName, $filePath)) {
            // 头像文件上传成功，执行更新头像的SQL语句
            $updateQuery = "UPDATE users SET photo = '$filePath' WHERE userID = $userID";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
                // 头像更新成功，进行相应处理
                header("Location: ../html/个人主页.php");
                exit();
            } else {
                // 头像更新失败，进行相应处理，例如显示错误信息
                echo "头像更新失败: " . mysqli_error($connection);
            }
        } else {
            // 头像文件移动失败，进行相应处理，例如显示错误信息
            echo "头像文件上传失败";
        }
    } else {
        // 上传头像文件出错，进行相应处理，例如显示错误信息
        echo "上传头像文件出错";
    }
}

// 处理更新密码请求
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["form_type"]) && $_POST["form_type"] == "update_password") {
    $userID = $_SESSION['userID'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    // 查询当前用户的密码
    $selectQuery = "SELECT password FROM users WHERE userID = $userID";
    $selectResult = mysqli_query($connection, $selectQuery);

    if ($selectResult && mysqli_num_rows($selectResult) === 1) {
        $row = mysqli_fetch_assoc($selectResult);
        $currentPassword = $row['password'];

        // 检查旧密码是否匹配
        if ($oldPassword === $currentPassword) {
            // 旧密码正确，执行更新密码的SQL语句
            $updateQuery = "UPDATE users SET password = '$newPassword' WHERE userID = $userID";
            $updateResult = mysqli_query($connection, $updateQuery);

            if ($updateResult) {
                // 密码更新成功，进行相应处理
                echo '<script>alert("密码修改成功");window.location.href="../html/个人主页.php";</script>';
                exit();
            } else {
                // 密码更新失败，进行相应处理，例如显示错误信息
                echo "密码更新失败: " . mysqli_error($connection);
            }
        } else {
            // 旧密码不匹配，显示弹窗提示
            echo '<script>alert("旧密码输入不正确");window.location.href="../html/个人主页.php";</script>';
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
