-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2024-06-30 20:02:22
-- 服务器版本： 10.4.21-MariaDB
-- PHP 版本： 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `takeout`
--

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `foodID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `couriers`
--

CREATE TABLE `couriers` (
  `courierID` int(11) NOT NULL,
  `courierName` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `couriers`
--

INSERT INTO `couriers` (`courierID`, `courierName`, `password`) VALUES
(105661, '111', '1'),
(316411, '不跑', '11'),
(830531, '11', '1'),
(961658, '库里', '1'),
(973015, '牛牛', '1');

-- --------------------------------------------------------

--
-- 表的结构 `foods`
--

CREATE TABLE `foods` (
  `foodID` int(11) NOT NULL,
  `foodName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(5,2) DEFAULT NULL,
  `merchantID` int(11) DEFAULT NULL,
  `photo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `foods`
--

INSERT INTO `foods` (`foodID`, `foodName`, `price`, `merchantID`, `photo`, `description`) VALUES
(0, '抹茶味青团', '2.00', 1, '抹茶味青团.jpg', '抹茶脑袋狂喜！！！'),
(1, '草莓生日蛋糕', '88.00', 2, '草莓生日蛋糕.jpg', '当季新鲜草莓！！'),
(2, '草莓味青团', '3.00', 1, '草莓味青团.jpg', '酸酸甜甜，一口一个'),
(210319, '香辣麻婆汉堡', '12.00', 236399, '../photo/香辣麻婆豆腐.png', '好麻好辣，斯哈不停'),
(793253, '珍珠奶茶', '9.00', 312580, '../photo/e8d2207c-ee02-4cd0-8938-f44e81ddf925.jpg', '好喝好喝');

-- --------------------------------------------------------

--
-- 表的结构 `merchants`
--

CREATE TABLE `merchants` (
  `merchantID` int(11) NOT NULL,
  `merchantName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `merchants`
--

INSERT INTO `merchants` (`merchantID`, `merchantName`, `description`, `address`, `password`) VALUES
(0, 'root', NULL, '广外', '1'),
(1, '超好吃软糯青团', '超多青团，等你发现', '广东省广州市番禺区广东外语外贸大学', '2'),
(2, '花花烘培坊', '超多美味小蛋糕', '广东省广州市番禺区广东外语外贸大学', ''),
(236399, '塔斯塔', NULL, '广东外语外贸大学', '1'),
(301427, '李白', NULL, '广外', '2'),
(312580, '苗苗奶茶', NULL, '广外西苑', '1'),
(327800, '面条店', NULL, '广外西苑', '1'),
(606424, '青桔绿茶', NULL, '小谷围街', '1');

-- --------------------------------------------------------

--
-- 表的结构 `orderdetails`
--

CREATE TABLE `orderdetails` (
  `orderID` int(11) NOT NULL,
  `foodID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `orderdetails`
--

INSERT INTO `orderdetails` (`orderID`, `foodID`, `quantity`) VALUES
(151479, 2, 1),
(173040, 210319, 3),
(176966, 1, 3),
(413819, 0, 1),
(413819, 2, 1),
(453736, 2, 2),
(617926, 0, 3),
(617926, 1, 2),
(833664, 1, 2),
(862345, 0, 3),
(862345, 2, 2),
(955435, 0, 3),
(955435, 2, 1),
(960770, 793253, 2);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `merchantID` int(11) DEFAULT NULL,
  `courierID` int(11) DEFAULT NULL,
  `dispatchTime` datetime DEFAULT NULL,
  `deliveryTime` datetime DEFAULT NULL,
  `status` enum('Preparing','Dispatched','Delivered','Completed','Unget') COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orderID`, `userID`, `merchantID`, `courierID`, `dispatchTime`, `deliveryTime`, `status`, `address`) VALUES
(151479, 231134, 1, 316411, '2024-07-01 01:34:09', '2024-07-01 01:36:30', 'Completed', '广外西苑'),
(173040, 259350, 236399, 973015, '2024-06-30 23:34:21', '2024-06-30 23:43:02', 'Completed', '广外图书馆'),
(176966, 0, 2, 973015, NULL, '2024-06-30 23:51:49', 'Completed', '广外'),
(413819, 0, 1, 973015, NULL, '2024-06-30 23:51:41', 'Completed', '广外'),
(453736, 636740, 1, NULL, '2024-07-01 01:34:14', NULL, 'Dispatched', '广外'),
(617926, 259350, 1, NULL, NULL, NULL, 'Preparing', '广外'),
(833664, 259350, 2, NULL, NULL, NULL, 'Unget', '小谷围街'),
(862345, 259350, 1, NULL, NULL, NULL, 'Preparing', '广东外语外贸大学'),
(955435, 708539, 1, NULL, NULL, NULL, 'Delivered', '广东外语外贸大学'),
(960770, 259350, 312580, NULL, '2024-06-29 22:33:47', NULL, 'Completed', 'thd');

-- --------------------------------------------------------

--
-- 表的结构 `ratings`
--

CREATE TABLE `ratings` (
  `userID` int(11) NOT NULL,
  `merchantID` int(11) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`userID`, `username`, `password`, `address`, `photo`) VALUES
(0, 'admin', '1', NULL, '../avatars/7e8fe501-2376-4ee9-b84c-c1652192e293.jpg'),
(231134, 'buhello', '1', NULL, '../avatars/7e8fe501-2376-4ee9-b84c-c1652192e293.jpg'),
(259350, 'qiqi', '1', NULL, '../avatars/屏幕截图 2023-10-01 165834.png'),
(310701, '呜呜', '1', NULL, NULL),
(636740, '李白', '1', NULL, '../avatars/147a5b36817b447d9720211f7214f86a.jpg'),
(648360, '呜呜', '1', NULL, NULL),
(708539, '张四', '1', NULL, '../avatars/屏幕截图 2024-01-25 134635.png');

--
-- 转储表的索引
--

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`userID`,`foodID`),
  ADD KEY `foodID` (`foodID`);

--
-- 表的索引 `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`courierID`);

--
-- 表的索引 `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`foodID`),
  ADD KEY `merchantID` (`merchantID`);

--
-- 表的索引 `merchants`
--
ALTER TABLE `merchants`
  ADD PRIMARY KEY (`merchantID`);

--
-- 表的索引 `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`orderID`,`foodID`),
  ADD KEY `foodID` (`foodID`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `merchantID` (`merchantID`),
  ADD KEY `courierID` (`courierID`);

--
-- 表的索引 `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`userID`,`merchantID`),
  ADD KEY `merchantID` (`merchantID`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- 限制导出的表
--

--
-- 限制表 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `foods` (`foodID`);

--
-- 限制表 `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`merchantID`) REFERENCES `merchants` (`merchantID`);

--
-- 限制表 `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `foods` (`foodID`);

--
-- 限制表 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`merchantID`) REFERENCES `merchants` (`merchantID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`courierID`) REFERENCES `couriers` (`courierID`);

--
-- 限制表 `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`merchantID`) REFERENCES `merchants` (`merchantID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
