-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 06:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(11) NOT NULL,
  `AdminName` varchar(45) DEFAULT NULL,
  `UserName` varchar(45) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7894561238, 'test@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2025-02-15 07:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(5) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `CreationDate`) VALUES
(1, 'Cake', '2025-02-23 10:33:03'),
(2, 'Muffins', '2025-02-23 10:34:33'),
(3, 'Cookies', '2025-02-23 10:35:08'),
(4, 'Pastry', '2025-02-23 10:35:21'),
(5, 'Waffles', '2025-02-23 10:35:35'),
(6, 'Bread', '2025-02-23 10:35:49'),
(7, 'Donut', '2025-02-23 10:36:05'),
(8, 'Pie', '2025-02-23 10:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `ID` int(10) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `EnquiryDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsRead` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`ID`, `Name`, `Email`, `Message`, `EnquiryDate`, `IsRead`) VALUES
(1, 'VISHWA', 'tandelvishwa398@gmail.com', 'Send me this order by tomorrow morning.....', '2025-02-24 07:49:34', 1),
(2, 'srushti', 'srushti@gmail.com', 'i need this order by today evening...', '2025-02-25 06:29:04', 1),
(3, 'karina', 'kt@gmail.com', 'where is my order', '2025-02-25 08:07:29', NULL),
(4, 'srushti', 'srushti@gmail.com', 'got it...!', '2025-02-25 08:29:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblorderaddresses`
--

CREATE TABLE `tblorderaddresses` (
  `ID` int(11) NOT NULL,
  `UserId` char(100) DEFAULT NULL,
  `Ordernumber` char(100) DEFAULT NULL,
  `Flatnobuldngno` varchar(255) DEFAULT NULL,
  `StreetName` varchar(255) DEFAULT NULL,
  `Area` varchar(255) DEFAULT NULL,
  `Landmark` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `OrderTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `OrderFinalStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorderaddresses`
--

INSERT INTO `tblorderaddresses` (`ID`, `UserId`, `Ordernumber`, `Flatnobuldngno`, `StreetName`, `Area`, `Landmark`, `City`, `OrderTime`, `OrderFinalStatus`) VALUES
(1, '1', '143070254', '590', 'jivanjyot', 'kakwadi', 'near tandel hardware', 'valsad', '2025-02-24 07:46:43', 'Order Confirmed'),
(2, '1', '905455353', '590', 'jivanjyot', 'kakwadi', 'near tandel hardware', 'valsad', '2025-02-24 07:56:16', 'Order Cancelled'),
(3, '1', '286178828', '590', 'jivanjyot', 'kakwadi', 'near tandel hardware', 'valsad', '2025-02-25 05:55:36', 'Order being Prepared'),
(4, '2', '589172660', '234', 'jogni', 'kakwadi', 'near jogni temple', 'valsad', '2025-02-25 06:28:08', 'Order Pickup'),
(5, '\r\n3\r\n\r\n', '674285637', '580', 'jivanjyot', 'kakwadi', 'near tandel hardware', 'valsad', '2025-02-25 06:31:34', 'Order Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `ID` int(11) NOT NULL,
  `UserId` char(10) DEFAULT NULL,
  `FoodId` char(10) DEFAULT NULL,
  `IsOrderPlaced` int(11) DEFAULT NULL,
  `OrderNumber` char(100) DEFAULT NULL,
  `CashonDelivery` varchar(100) DEFAULT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ItemQty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`ID`, `UserId`, `FoodId`, `IsOrderPlaced`, `OrderNumber`, `CashonDelivery`, `OrderDate`, `ItemQty`) VALUES
(1, '1', '3', 1, '143070254', 'Cash on Delivery', '2025-02-24 07:46:04', 1),
(2, '1', '2', 1, '143070254', 'Cash on Delivery', '2025-02-24 07:46:15', 1),
(3, '1', '5', 1, '905455353', 'Cash on Delivery', '2025-02-24 07:55:47', 1),
(4, '1', '2', 1, '286178828', 'Cash on Delivery', '2025-02-25 05:55:15', 1),
(5, '2', '5', 1, '589172660', 'Cash on Delivery', '2025-02-25 06:27:33', 1),
(6, '3', '7', 1, '674285637', 'Cash on Delivery', '2025-02-25 06:30:55', 1),
(24, '', '1', NULL, NULL, NULL, '2025-03-10 17:52:21', 1),
(40, '13', '1', 1, '193865197', 'Cash on Delivery', '2025-03-10 19:36:58', 2),
(43, '13', '2', 1, '193865197', 'Cash on Delivery', '2025-03-10 19:39:29', 5),
(44, '13', '11', 1, '193865197', 'Cash on Delivery', '2025-03-10 19:39:47', 10),
(90, '14', '6', NULL, NULL, NULL, '2025-03-12 09:18:19', 1),
(92, '1', '1', NULL, NULL, NULL, '2025-03-12 09:35:00', 3),
(106, '13', '3', 1, '317248279', 'Cash on Delivery', '2025-03-14 17:21:19', 2),
(107, '13', '2', 1, '317248279', 'Cash on Delivery', '2025-03-17 05:57:39', 1),
(108, '13', '11', 1, '412791985', 'Cash on Delivery', '2025-04-07 02:09:58', 1),
(109, '13', '10', 1, '720079445', 'Cash on Delivery', '2025-04-07 02:18:03', 1),
(110, '13', '12', 1, '720079445', 'Cash on Delivery', '2025-04-07 02:18:21', 1),
(111, '13', '3', 1, '812504167', 'Cash on Delivery', '2025-04-07 02:32:29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblordertracking`
--

CREATE TABLE `tblordertracking` (
  `ID` int(10) NOT NULL,
  `OrderId` char(50) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `status` char(50) DEFAULT NULL,
  `StatusDate` timestamp NULL DEFAULT current_timestamp(),
  `OrderCanclledByUser` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblordertracking`
--

INSERT INTO `tblordertracking` (`ID`, `OrderId`, `remark`, `status`, `StatusDate`, `OrderCanclledByUser`) VALUES
(0, '193865197', 'unavailable', 'Order Cancelled', '2025-03-12 09:14:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About us', '<font face=\"Roboto\"><span style=\"font-size: 15.3333px;\">Welcome to Bakery House where every Bite tells a story of passion,quality,and tradition.since our establishment,we have been dedicated to craftingdelicious baked goods made from the finest ingredients and a touch of love.At Bakery House,we specialize in a wide range of fresh,handmade treats, including artisan bread,mouthwatering pastries,delightful cakes,crunchy cookies, and savory snacks.whether you are celebrating a special occasion or simply craving something sweet,we have something to satisfy every taste.Our commitment to quality and customer satisfaction sets us apart.we believe in freshness,authenticity,and warm experience for every one who walks through our doors.</span></font><div><font face=\"Roboto\"><span style=\"font-size: 15.3333px;\">Come visit us and experience the magic of homemade goodness at Bakery House....</span></font></div>', NULL, NULL, '2025-02-23 18:16:35'),
(2, 'contactus', 'Contact Us', '#590 jivanjyot,Kakwadi,Valsad', 'Tandel@gmail.com', 3110021004, '2025-02-23 18:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `ItemName` varchar(120) DEFAULT NULL,
  `ItemPrice` varchar(120) DEFAULT NULL,
  `ItemDes` varchar(500) DEFAULT NULL,
  `Image` varchar(120) DEFAULT NULL,
  `ItemQty` varchar(120) DEFAULT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`ID`, `CategoryName`, `ItemName`, `ItemPrice`, `ItemDes`, `Image`, `ItemQty`, `Weight`, `CreationDate`) VALUES
(1, 'Cake', 'dark chocolate cake', '800', '                                                                                                                                                            a cake flavoured with melted chocolate,cocoa&nbsp; powder,or both.', '537dc337a3e5c9ebe371a3f78e26cb9e.jpg', '0', '500 gm', '2021-07-07 11:59:35'),
(2, 'Cake', 'Red velvet Cake', '550', '                                                                                                                                                            very mild cocoa with a slightly tart edge....', '4d1f1114b427c87a1b1151ba285422b2.jpg', '8', '2 kg', '2021-07-07 13:00:49'),
(3, 'Donut', 'donut', '250', '                                                    A sweet,fried,ring-shaped pastry.', 'fb2f72f59a6358df5798edd85b95d0e5.jpg', '32', '2 kg', '2021-07-07 13:02:46'),
(4, 'Pie', 'Apple pie', '80', '                                                    A dessert made with apple backed pastry.', '7e4dafbdea8b88a25ba290ffc84fc8a2.jpg', '10', '3 kg', '2021-07-09 05:18:29'),
(5, 'Pie', 'Cherry pie', '200', '                                                    cherry flavour is front and center in this pie', '98e6e7d57ab1829cd9450fb688fffebd.jpg', '5', '4 kg', '2021-07-09 05:20:05'),
(6, 'Bread', 'Brown bread', '180', '                                                    A bread made from whole grain flavours like wheat,rye or corn.', '76d5eea6554a5f4f0481c8f128bbda9f.jpg', '88', '2 kg', '2021-07-09 05:21:30'),
(7, 'Bread', 'Croissant', '150', '&nbsp;A yeasted, laminated dough backed into loaf shape.', 'ab283200559dec02a02970890e899747.jpg', '4', '1.5 kg', '2021-07-09 05:22:45'),
(8, 'Waffles', 'belgian waffle', '150', 'Thick fluffy waffles with deep pockets.', 'bf728c48c7546f2a944c0f2afe85228a.jpg', '4 ', '500 gm', '2021-07-09 05:24:51'),
(9, 'Waffles', 'bubble waffle', '100', ' Crispy on outside, while the inside of each bubble is fluffy...', 'eca698bbb48182478704cb53df642461.jpg', '0', '4 kg', '2021-07-09 05:27:25'),
(10, 'Cookies', 'Macroons', '80', '                                                                                                        small,light,meringue-based sandwich cookies.', '8c36cc5f983552cf34f383df2f15f805.jpg', '499', '3 kg', '2021-07-09 05:30:05'),
(11, 'Pastry', 'Blueberry', '70', 'Blueberrylicious delight pastry', 'f0c39dbe1e97fbb06550be121b5939be.jpg', '0', '2 kg', '2021-07-09 05:32:02'),
(12, 'Muffins', 'Chocolate muffins', '25', ' Made with chocolate chips and studded.', '2a252b50456defcd9fc68375f56e1b78.jpg', '0', '1.5 kg', '2021-07-09 05:33:28'),
(13, 'Pastry', 'Pineapple', '50', 'Fruity dessert made with pineapple and vanilla sponge..', 'cc99a2da6f33b05dc4b5d569c56ba282.jpg', '1', '2 kg', '2021-07-09 05:36:02'),
(14, 'Muffins', 'Blueberry', '90', 'Soft,moist muffins with lots of blueberries and a sweet,crisp top.', 'a644c105f8d5c6e2640023ecb44433ac.jpg', '1', '2 kg', '2021-07-09 05:37:26'),
(15, 'Cookies', 'peanut butter', '110', 'Cookie is flat,peanut flavour and crumbly texture....', '7fa213f3cd85bbbb9b2783ccfa5f5316.jpg', '10', '1 kg', '2021-07-16 12:41:11'),
(16, 'Waffles', 'Chocolate  waffle', '120', 'Crispy on outside,while the inside of each bubble is fulffy.', 'c208ef50cf182a2f5cc604eb4d8fdb26.jpg', '1', '500 gm', '2025-02-23 13:25:49'),
(17, 'Pastry', 'strawberry', '90', 'A dessert made with flaky pastry and a strawberry filling....', '694557eaf22b9547db79685729403517.jpg', '1', '500 gm', '2025-02-23 13:27:27'),
(18, 'Cake', 'vanilla', '700', 'soft,melt-in-your mouth crumb and bursting with vanilla flavour.', '6761776ff37fac349f3d9ccdb5fd62da.jpg', '1', '1.5 kg', '2025-02-23 13:31:57'),
(19, 'Cake', 'Panda cake', '999', '                                                    cartoon cake&nbsp;', 'ce30679542c1a99b54d2d2aed9774687jpeg', '0', '1 kg', '2025-03-11 08:05:34'),
(21, 'Cake', 'Panda cake', '100', 'best', 'ce30679542c1a99b54d2d2aed9774687jpeg', '5', '3 kg', '2025-04-01 08:04:22');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubscriber`
--

CREATE TABLE `tblsubscriber` (
  `ID` int(5) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `DateofSub` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubscriber`
--

INSERT INTO `tblsubscriber` (`ID`, `Email`, `DateofSub`) VALUES
(1, 'tandelvishwa398@gmail.com', '2025-02-24 07:55:19'),
(2, 'srushti@gmail.com', '2025-02-25 06:26:12'),
(3, 'kt@gmail.com', '2025-02-25 06:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FirstName`, `LastName`, `Email`, `MobileNumber`, `Password`, `RegDate`) VALUES
(1, 'vishwa', 'Tandel', 'tandelvishwa398@gmail.com', 9104809163, '9771ddbc38803c1d3a4b1ae362083b7d', '2025-02-24 07:45:28'),
(2, 'Srushti', 'Tandel', 'srushti@gmail.com', 9737809163, 'fcea920f7412b5da7be0cf42b8c93759', '2025-02-25 06:25:48'),
(3, 'karina', 'Tandel', 'kt@gmail.com', 1234567890, '75f34b5502bec3c609734fdf4d37fa5c', '2025-02-25 06:30:31'),
(13, 'Joey ', 'tribbiani', 'bigdaddy@gmail.com', 9876543210, '95cc60d8ebdc5a6553a29dd96d68fee4', '2025-03-10 17:43:59'),
(14, 'raju', 'mistry', 'raju@gmail.com', 8521479630, '8cf78df51ce3a14c2b182aea432bb5b3', '2025-03-12 09:17:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CategoryName` (`CategoryName`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`Ordernumber`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`FoodId`,`OrderNumber`);

--
-- Indexes for table `tblordertracking`
--
ALTER TABLE `tblordertracking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsubscriber`
--
ALTER TABLE `tblsubscriber`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblsubscriber`
--
ALTER TABLE `tblsubscriber`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
