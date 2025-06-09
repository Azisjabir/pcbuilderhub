-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 11:15 AM
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
-- Database: `pcbuildhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(4, 'admin2', '1c6637a8f2e1f75e06ff9984894d6bd16a3a36a9');

-- --------------------------------------------------------

--
-- Table structure for table `build_components`
--

CREATE TABLE `build_components` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(20) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `build_components`
--

INSERT INTO `build_components` (`id`, `name`, `category`, `details`, `price`, `image`) VALUES
(9, 'Intel Core i9-13900K', 'cpu', 'Cores/Threads: 24/32 (8P+16E cores).\r\nBase Clock: 3.0 GHz (P-core).\r\nBoost Clock: 5.8 GHz (P-core).\r\nPower: 125W TDP.\r\nUse Case: High-performance tasks like gaming, video editing, and productivity.', 1560, 'Intel Core i9-13900K.jpg'),
(10, 'Intel Core i5-13600K', 'cpu', 'Cores/Threads: 14/20 (6P+8E cores).\r\nBase Clock: 2.6 GHz (E-core).\r\nBoost Clock: 5.1 GHz (P-core).\r\nPower: 125W TDP.\r\nUse Case: Mid-tier gaming and multitasking.', 1330, 'Intel Core i5-13600K.jpg'),
(11, 'GIGABYTE GeForce RTX 4060', 'gpu', 'VRAM: 8GB GDDR6.\r\nPower Requirement: 115W (Recommended PSU: 550W).\r\nUse Case: 1080p and 1440p gaming.', 1800, 'Gigabyte NVIDIA GeForce RTX 4060.jpg'),
(12, 'Gigabyte AMD Radeon RX 6700 XT', 'gpu', 'VRAM: 12GB GDDR6.\r\nPower Requirement: 230W (Recommended PSU: 650W).\r\nUse Case: High-performance gaming and rendering.', 1800, 'Gigabyte AMD Radeon RX 6700 XT.jpeg'),
(13, 'Corsair Vengeance LPX DDR4 3200MHz', 'ram', '16GB (2x8GB)\r\nGreat for gaming and general multitasking.', 230, 'pngwing.com.png'),
(14, 'Kingston Fury Beast DDR4 3600MHz', 'ram', '32GB (2x16GB)\r\nHigh-capacity kit for demanding workloads.', 170, 'Kingston Fury Beast 32GB (2x16GB) DDR4 3600MHz.jpg'),
(15, 'Corsair RM650e', 'power supply', '650W, 80+ Gold\r\nIdeal for mid-tier systems.\r\nFully modular cables for easier management.', 470, 'Corsair RM650e (650W, 80+ Gold).jpg'),
(16, 'Seasonic Focus GX-750', 'power supply', '750W, 80+ Gold\r\nSuitable for high-performance builds with powerful GPUs like RTX 3070.', 870, 'Seasonic Focus GX-750 (750W, 80+ Gold).jpeg'),
(17, 'Noctua NH-U12S redux', 'cooler', 'Compact design.\r\nEffective cooling for mid-tier CPUs (e.g., i5-13600K).', 413, 'Noctua NH-U12S redux.jpg'),
(18, 'MSI MAG CoreLiquid 240R V2 ', 'cooler', 'AIO Liquid Cooler\r\nDual 120mm radiator.\r\nSuitable for high-performance CPUs like i9-13900K.\r\n', 550, 'MSI MAG CoreLiquid 240R V2 (AIO Liquid Cooler).jpeg'),
(19, 'NZXT H510', 'case', 'Minimalist design.\r\nGood airflow and cable management.', 270, 'NZXT H510.jpg'),
(20, 'Corsair 4000D Airflow', 'case', 'Excellent cooling potential.\r\nFits long GPUs and tall CPU coolers.', 360, 'Corsair 4000D Airflow.jpg'),
(21, 'AMD Ryzen 7 5800X', 'cpu', 'Socket: AM4.\r\nCores/Threads: 8/16.\r\nBase Clock: 3.8 GHz.\r\nBoost Clock: 4.7 GHz.', 1400, 'AMD Ryzen 7 5800X.jpg'),
(22, 'Intel Core i7-10700K', 'cpu', 'Socket: LGA 1200.\r\nCores/Threads: 8/16.\r\nBase Clock: 3.8 GHz.\r\nBoost Clock: 5.1 GHz.', 210, 'Intel Core i7-10700K.jpg'),
(23, 'NVIDIA GeForce 7600 GT', 'gpu', 'Interface: AGP (Accelerated Graphics Port).\r\nVRAM: 256MB.\r\nUse Case: Legacy systems from the 2000s.', 75, 'NVIDIA GeForce 7600 GT.jpg'),
(24, 'Corsair Dominator Platinum RGB DDR5-5200', 'ram', 'Type: DDR5.\r\nCapacity: 32GB (16GBx2).\r\nSpeed: 5200MHz.', 1800, 'Corsair Dominator Platinum RGB DDR5-5200.jpg'),
(25, 'Thermaltake Litepower 450W', 'power supply', 'Wattage: 450W.\r\nEfficiency Rating: No 80+ certification.', 130, 'Thermaltake Litepower 450W.jpg'),
(26, 'Cooler Master Hyper 212 EVO ', 'cooler', 'Type: Air cooler.\r\nSocket Support: LGA 775/115x/1366/AM4 (older Intel/AMD sockets', 190, 'Cooler Master Hyper 212 EVO (Old Version).jpg'),
(27, 'NZXT H1', 'case', 'Form Factor: Mini-ITX.', 1600, 'NZXT H1.jpg'),
(29, 'MSI PRO B760M-E DDR4', 'motherboard', 'Key Specifications:\r\n\r\nChipset: Intel B760.\r\nMemory Support: Dual-channel DDR4 memory, with two DIMM slots supporting up to 64GB. Memory speeds are supported up to 4800 MHz (OC). \r\nMSI GLOBAL\r\nExpansion Slots:\r\n1x PCIe 4.0 x16 slot.\r\n1x PCIe 3.0 x1 slot. \r\nMSI GLOBAL\r\nStorage Options:\r\n1x M.2 slot (PCIe 4.0 x4) supporting 2280/2260/2242 devices.\r\n4x SATA 6Gbps ports. \r\nMSI GLOBAL\r\nAudio: 7.1-Channel High Definition Audio powered by the Realtek ALC897 Codec. \r\nMSI GLOBAL\r\nNetworking: Realtek RTL8', 530, 'B760M.png'),
(30, 'Samsung 970 Evo Plus 1TB', 'storage', 'Sequential Read/Write Speeds: 3500/3300 MB/s.\r\nGreat for OS and primary storage.', 323, 'Samsung 970 Evo Plus 1TB.jpg'),
(31, 'AMD Ryzen 5 5600X', 'cpu', 'Cores/Threads: 6/12\r\nBase Clock: 3.7 GHz\r\nMax Boost Clock: 4.6 GHz\r\nTDP: 65W\r\nIntegrated Graphics: None', 1300, 'AMD Ryzen 5 5600X.jpg'),
(32, 'EVGA GeForce RTX 3060', 'gpu', 'CUDA Cores: 3584\r\nMemory: 12GB GDDR6\r\nMemory Interface: 192-bit\r\nPower Consumption: 170W\r\nRecommended PSU: 550W', 900, 'EVGA GeForce RTX 3060.jpg'),
(33, 'ASUS ROG STRIX B550-F Gaming', 'motherboard', 'Socket: AM4 (AMD Ryzen CPUs).\r\nChipset: B550 (AMD).\r\nMemory: Supports DDR4 up to 128GB', 800, 'ASUS ROG STRIX B550-F Gaming.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compatible`
--

CREATE TABLE `compatible` (
  `id` int(11) NOT NULL,
  `motherboard_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compatible`
--

INSERT INTO `compatible` (`id`, `motherboard_id`, `component_id`, `category`) VALUES
(13, 29, 9, 'cpu'),
(14, 29, 10, 'cpu'),
(15, 29, 11, 'gpu'),
(16, 29, 12, 'gpu'),
(17, 29, 13, 'ram'),
(18, 29, 14, 'ram'),
(19, 29, 15, 'power supply'),
(20, 29, 16, 'power supply'),
(21, 29, 17, 'cooler'),
(22, 29, 18, 'cooler'),
(23, 29, 19, 'case'),
(24, 29, 20, 'case'),
(25, 33, 21, 'cpu'),
(26, 33, 31, 'cpu'),
(27, 33, 32, 'gpu'),
(28, 33, 13, 'ram'),
(29, 33, 14, 'ram'),
(30, 33, 15, 'power supply'),
(31, 33, 16, 'power supply'),
(32, 33, 26, 'cooler'),
(33, 33, 19, 'case');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`) VALUES
(1, 'How do I use Build Your Own PC?', 'To use Build Your Own PC, You need to select motherboard first then the rest of the components will display only compatible to the motherboard you choose. So, you can build your PC without any issues that the parts are not compatible.', '2025-01-20 12:59:54');

-- --------------------------------------------------------

--
-- Table structure for table `learn_categories`
--

CREATE TABLE `learn_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `learn_categories`
--

INSERT INTO `learn_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'AMD Build', 'Learn how to build a PC using AMD components.', '2024-11-19 13:33:58'),
(2, 'INTEL Build', 'Learn how to build a PC using Intel components.', '2024-11-19 13:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `article_url` text NOT NULL,
  `video_url` text NOT NULL,
  `quiz_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `category_id`, `article_url`, `video_url`, `quiz_url`) VALUES
(1, 1, 'https://community.amd.com/t5/pc-building-how-to-articles/essential-parts-needed-to-build-a-gaming-pc/ta-p/584990', 'https://www.youtube.com/embed/PXaLc9AYIcg', 'https://docs.google.com/forms/d/e/1FAIpQLSfg1iUkPpwoCn2LJvsCao7CFYVzS3ObXuZYvZwMqGuzkjQYAw/viewform?usp=dialog'),
(3, 2, 'https://www.intel.com/content/www/us/en/gaming/resources/how-to-build-a-gaming-pc.html', 'https://www.youtube.com/embed/DC-Xn2C_L1U', 'https://docs.google.com/forms/d/e/1FAIpQLSdh3S1v5HJlZ4flb3yk4NA-WY8IzwZtL7n_cSs_Ox2bgFuLoQ/viewform?usp=dialog');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL,
  `replied` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`, `replied`) VALUES
(10, 8, 'user1', 'user1@gmail.com', '0111111111', 'XXXXXXXXXXXXXXXXXXXXXXXXXX?', 0),
(11, 8, 'azis', 'user1@gmail.com', '0122222222', 'AAAAAAAAAAAAAAAA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'Pending',
  `receipt_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `receipt_file`) VALUES
(24, 8, 'user1', '0123445656', 'user1@gmail.com', 'QR Payment', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450', 'MSI PRO B760M-E DDR4 (MATX) (1100 x 1)', 1100, '2025-01-19', 'Pending', '1737313716_AMD Ryzen 5 7600X.jpg'),
(25, 8, 'user1', '0123445656', 'user1@gmail.com', 'cash_on_delivery', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450', '0 (1500 x 1) - ', 1500, '2025-01-20', 'Pending', NULL),
(26, 8, 'user1', '0123445656', 'user1@gmail.com', 'cash_on_delivery', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450', 'MSI PRO B760M-E DDR4 (MATX) (1100 x 1) - ', 1100, '2025-01-21', 'Pending', NULL),
(27, 8, 'user1', '0123445656', 'user1@gmail.com', 'Online Banking', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450', 'MSI PRO B760M-E DDR4 (MATX) (1100 x 1) - ', 1100, '2025-01-21', 'Pending', NULL),
(28, 8, 'user1', '0123445656', 'user1@gmail.com', 'QR Payment', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450', ' Intel Core i5-12600K (1250 x 1)', 1250, '2025-01-21', 'Pending', '1737428734_AMD Ryzen 5 7600X.webp');

-- --------------------------------------------------------

--
-- Table structure for table `prebuilt`
--

CREATE TABLE `prebuilt` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(255) NOT NULL,
  `price` varchar(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `detail` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prebuilt`
--

INSERT INTO `prebuilt` (`id`, `name`, `category`, `price`, `image`, `detail`) VALUES
(10, 'PACKAGE BASIC A', 'Basic', '1800', 'basic.png', 'Processor (CPU): Intel Core i3 (12th Gen) or AMD Ryzen 3 (5000 Series)\r\nRAM: 8 GB DDR4\r\nStorage: 256 GB SSD (faster boot and load times) or 1 TB HDD\r\nGraphics: Integrated Graphics (Intel UHD or AMD Radeon Vega)\r\nMotherboard: Entry-level (compatible with CPU and has at least one M.2 slot)\r\nPower Supply (PSU): 300-400W\r\nDisplay: 1080p Monitor, 60Hz\r\nOperating System: Windows 11 Home'),
(14, 'PACKAGE INTERMEDIATE A', 'Intermediate', '3300', 'basic.png', 'Processor (CPU): Intel Core i5 (13th Gen) or AMD Ryzen 5 (7000 Series)\r\nRAM: 16 GB DDR4/DDR5\r\nStorage: 512 GB NVMe SSD + 1 TB HDD\r\nGraphics: NVIDIA GTX 1660 Super or AMD Radeon RX 6600\r\nMotherboard: Mid-tier with multiple PCIe slots, DDR5 support (optional)\r\nPower Supply (PSU): 500-650W (80+ Bronze or better)\r\nDisplay: 1080p Monitor, 120Hz/144Hz\r\nOperating System: Windows 11 Pro'),
(15, 'PACKAGE ADVANCED R3', 'Advanced', '8900', 'basic.png', 'Processor (CPU): Intel Core i9 (13th Gen) or AMD Ryzen 9 (7000 Series)\r\nRAM: 32 GB DDR5 or higher\r\nStorage: 1 TB NVMe Gen 4 SSD + 2 TB HDD\r\nGraphics: NVIDIA RTX 4080/4090 or AMD Radeon RX 7900 XTX\r\nMotherboard: High-end with robust cooling, multiple M.2 slots, WiFi 6E support\r\nPower Supply (PSU): 750-1000W (80+ Gold or better)\r\nDisplay: 1440p or 4K Monitor, 144Hz+\r\nOperating System: Windows 11 Pro');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`, `quantity`) VALUES
(50, 'Intel Core i9-13900K', 'cpu', 1560, '../uploaded_img/Intel-i9-14900K.jpg', 15),
(51, 'GIGABYTE GeForce RTX 4060', 'gpu', 1800, '../uploaded_img/Gigabyte NVIDIA GeForce RTX 4060.jpg', 10),
(52, 'Corsair Vengeance LPX DDR4 3200MHz', 'ram', 230, '../uploaded_img/pngwing.com.png', 20),
(53, 'Corsair RM650e', 'power supply', 470, '../uploaded_img/Corsair RM650e (650W, 80+ Gold).jpg', 15),
(54, 'Noctua NH-U12S redux', 'cooler', 413, '../uploaded_img/Noctua NH-U12S redux.jpg', 8),
(55, 'NZXT H510', 'case', 270, '../uploaded_img/NZXT H510.jpg', 10),
(56, 'MSI PRO B760M-E DDR4', 'motherboard', 530, '../uploaded_img/B760M.png', 10),
(57, 'Samsung 970 Evo Plus 1TB', 'storage', 323, '../uploaded_img/Samsung 970 Evo Plus 1TB.jpg', 15),
(58, 'Intel Core i5-13600K', 'cpu', 1330, '../uploaded_img/Intel Core i5-13600K.jpg', 10),
(59, 'Gigabyte AMD Radeon RX 6700 XT', 'gpu', 1800, '../uploaded_img/Gigabyte AMD Radeon RX 6700 XT.jpeg', 9),
(60, 'Kingston Fury Beast DDR4 3600MHz', 'ram', 170, '../uploaded_img/Kingston Fury Beast 32GB (2x16GB) DDR4 3600MHz.jpg', 12),
(61, 'Seasonic Focus GX-750', 'power supply', 870, '../uploaded_img/Seasonic Focus GX-750 (750W, 80+ Gold).jpeg', 15),
(62, 'MSI MAG CoreLiquid 240R V2 ', 'cooler', 550, '../uploaded_img/MSI MAG CoreLiquid 240R V2 (AIO Liquid Cooler).jpeg', 12),
(63, 'Corsair 4000D Airflow', 'case', 360, '../uploaded_img/Corsair 4000D Airflow.jpg', 7);

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reply_message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `message_id`, `admin_id`, `reply_message`, `created_at`) VALUES
(11, 10, 1, 'AAAAAAAAAAAAAAAA', '2025-01-20 06:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `rating`, `review`, `created_at`) VALUES
(8, 'Awang Syafiq', 5, 'Excellent platform! Easy to navigate and very helpful for building my PC.', '2025-01-20 14:17:23'),
(9, 'Azis Jabir', 4, 'Great experience overall, but I wish there were more component options available.', '2025-01-20 14:18:13'),
(10, 'Ilhan Sabli', 3, 'It’s decent, but some features are a bit confusing for beginners.', '2025-01-20 14:18:57'),
(11, 'Izailyana Ab Sani', 4, 'Absolutely loved it! The guides are incredibly detailed and easy to follow.', '2025-01-20 14:19:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(8, 'user1', 'user1@gmail.com', '0123445656', 'b3daa77b4c04a9551b8781d03191fe098f325e67', '200, 2, UCA2, JALAN TUARAN, KOTA KINABALU, SABAH, MALAYSIA - 88450');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_components`
--
ALTER TABLE `build_components`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compatible`
--
ALTER TABLE `compatible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `motherboard_id` (`motherboard_id`),
  ADD KEY `component_id` (`component_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `learn_categories`
--
ALTER TABLE `learn_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prebuilt`
--
ALTER TABLE `prebuilt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `replies_ibfk_1` (`message_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `build_components`
--
ALTER TABLE `build_components`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `compatible`
--
ALTER TABLE `compatible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `learn_categories`
--
ALTER TABLE `learn_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `prebuilt`
--
ALTER TABLE `prebuilt`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compatible`
--
ALTER TABLE `compatible`
  ADD CONSTRAINT `compatible_ibfk_1` FOREIGN KEY (`motherboard_id`) REFERENCES `build_components` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compatible_ibfk_2` FOREIGN KEY (`component_id`) REFERENCES `build_components` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `learn_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
