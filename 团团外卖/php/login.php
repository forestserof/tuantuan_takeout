<!doctype html>
<?php 
require_once("conn.php");
?>

<html>
<head>
	<meta charset="utf-8">
	<title>login</title>
	<script>
		<?php
		session_start(); // 开启会话
	    // echo "hash_hkdf";
		$name = $_POST["name"];
		$password = $_POST["password"];
		$type = $_POST["type"];
		
		if ($type === '客户') {
			$tableName = 'users';
			$sql = "SELECT * FROM $tableName WHERE username='$name' AND password='$password'";
		} elseif ($type === '商家') {
			$tableName = 'merchants';
			$sql = "SELECT * FROM $tableName WHERE merchantName='$name' AND password='$password'";
		} elseif ($type === '骑手') {
			$tableName = 'couriers';
			$sql = "SELECT * FROM $tableName WHERE courierName='$name' AND password='$password'";
		}
		// echo $name;
		// 验证账户信息
		
		$result = $conn->query($sql);
		
		if ($result->num_rows > 0) {
			// 登录成功，跳转到相应页面
			if ($type == "商家") {
				// 获取商家的restaurant_id
				$merchantID = ""; // 设置默认值
				$query = "SELECT merchantID FROM merchants WHERE merchantName='$name'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$merchantID = $row['merchantID'];
				}

				// // 将restaurant_id存储到会话中
				$_SESSION['merchantID'] = $merchantID;

				// 跳转到商家页面
				echo "alert('登录成功！');";
				echo "window.location.href='../html/商家页面.php';";
				
			} elseif ($type == "客户") {
				// 获取客户的user_id
				$userID = ""; // 设置默认值
				$query = "SELECT userID FROM users WHERE username='$name'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$userID = $row['userID'];
				}
				// // 将user_id存储到会话中
				$_SESSION['userID'] = $userID;
				// 跳转到客户页面
				echo "alert('登录成功！');";
				echo "window.location.href='../html/客户主页.php';";
			} elseif ($type == "骑手") {
				// 获取骑手的user_id
				$courierID = ""; // 设置默认值
				$query = "SELECT courierID FROM couriers WHERE courierName='$name'";
				$result = $conn->query($query);
				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$courierID = $row['courierID'];
				}
				// // 将user_id存储到会话中
				$_SESSION['courierID'] = $courierID;
				// 跳转到骑手页面
				echo "alert('登录成功！');";
				echo "window.location.href='../html/骑手主页.php';";
			}
		} else {
			// 登录失败，弹窗提示
			echo "alert('账号、密码或身份不正确，请重新输入！');";
			echo "window.history.back();";
		}
		
		mysqli_close($conn);
		?>
	</script>
</head>
<body>
</body>
</html>
