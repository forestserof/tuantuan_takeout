
<?php
$connection = mysqli_connect("localhost", "root", "", "takeout");
  // 开始会话
session_start();

// 获取存储在会话中的restaurant_id
$merchantID = $_SESSION['merchantID'];
// 允许上传的图片后缀
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
echo $_FILES["file"]["size"];
$extension = end($temp);     // 获取文件后缀名

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 4096000)   // 小于 2mb
&& in_array($extension, $allowedExts))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "错误：: " . $_FILES["file"]["error"] . "<br>";
	}
	else
	{
		echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
		echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
		echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
		
		// 判断当期目录下的 upload 目录是否存在该文件
		// 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
        $path='../photo/';
        $dest_file=$path. $_FILES["file"]["name"];
		if (file_exists($dest_file))
		{
			echo $_FILES["file"]["name"] . " 文件已经存在。 ";
		}
		else
		{
			// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
			move_uploaded_file($_FILES["file"]["tmp_name"], $dest_file);
			echo "文件存储在: " . $dest_file;

            // 获取表单提交的其他菜品信息
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
			// $connection = mysqli_connect("localhost", "root", "", "takeout");

			//生成唯一的foodID
			do {
				$foodID = rand(100000, 999999);
				$checkQuery = "SELECT foodID FROM foods WHERE foodID = '$foodID'";
				$checkResult = mysqli_query($connection, $checkQuery);
				$orderExists = mysqli_num_rows($checkResult) > 0;
			  } while ($orderExists);
            // 将菜品信息插入到数据库
            $insertQuery = "INSERT INTO foods (foodID,merchantID,foodName, price, description, photo) VALUES ('$foodID','$merchantID','$name', '$price', '$description', '$dest_file')";
            if (mysqli_query($connection, $insertQuery)) {
                echo "菜品信息已成功存储到数据库。";
				header("Location: ../html/商家页面.php");
                exit();
            } else {
                echo "存储菜品信息到数据库时出现错误：" . mysqli_error($connection);
            }
		}
	}
}
else
{
	echo "非法的文件格式";
}
mysqli_close($connection);
?>


