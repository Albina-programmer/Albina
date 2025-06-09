-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 26 2025 г., 16:52
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `store_db`
--
CREATE DATABASE IF NOT EXISTS `store_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `store_db`;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `surname`, `phone`, `email`, `product_name`, `product_price`, `order_date`) VALUES
(3, 'Albina', 'Tansıqbaeva', '91-234-56-78', 'albina@gmail.com', 'ZTE Blade A75', '110.00', '2025-05-26 12:57:30');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` enum('smartfon','aksessuar') NOT NULL,
  `info` text NOT NULL,
  `price` varchar(50) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `info`, `price`, `image`) VALUES
(1, 'Apple iPhone 13', 'smartfon', 'Apple iPhone 13, Starlight, 4/128 GB,oq rang, operativka 4GB, Apple A15 Bionic', '679$', 'img_682d5ac1f165c1.91158142.png'),
(2, 'Samsung Galaxy S25 Ultra', 'smartfon', 'Samsung Galaxy S25 Ultra, Titanium Black, 12/512 GB, \r\n45W Fast Charging, Qualcomm Snapdragon 8 Elite', '789$', 'img_682d5846c92fd1.07288145.png'),
(4, 'Apple iPhone 16 Pro', 'smartfon', 'Apple iPhone 16 Pro, Black Titanium, 8/256 GB, 20W-30W PD Fast Charging, 25W-30W MagSafe', '1800$', 'img_682d57d4199137.86868979.png'),
(6, 'Xiaomi 14T', 'smartfon', 'Xiaomi 14T, Titan Gray, 12/512 GB, \r\n67W Hyper Charge,12 GB operativka, MediaTek Dimensity 8300 Ultra.', '600$', 'img_682d59fa9bc082.75151552.png'),
(8, 'Apple AirPods Max', 'aksessuar', 'Simsiz minigarnituralar Apple AirPods Max Grey (2024), Для музыки, спортивного использования, рабочих целей.', '600$', 'img_682d5becd6dc30.93815217.png'),
(9, 'USB Type-C zaryadlovchi', 'aksessuar', 'Samsung EP-TA800 25 Vt USB Type-C oq tarmoq zaryadlovchi, haddan tashqari qizib ketmasdan va uzoq kutmasdan tez zaryadlashni kafolatlaydi.', '10$', 'img_682d5ce3245347.18528033.png'),
(10, 'Simsiz minigarnituralar Canyon', 'aksessuar', 'Simsiz minigarnituralar Canyon TWS-5 Black, Для работы, Для прослушивания аудио и видео, Для телефона', '14$', 'img_682d5d97d25a25.85418380.png'),
(11, 'Corn M243, Green 32GB', 'smartfon', 'Corn M243, Green, xotira 32 GB, Ikkita SIM kartali,  uzoq muddat ishlash va qulaylikni ta’minlaydi', '21$', 'img_682d5ef43183e0.99020859.png'),
(12, 'Samsung Galaxy A56', 'smartfon', 'Samsung Galaxy A56, Awesome Olive, 8/256 GB, 45W Fast Charging, Samsung Exynos 1580', '420$', 'img_682d5fa1c31062.23429884.png'),
(13, 'Xiaomi Redmi Note 14', 'smartfon', 'Xiaomi Redmi Note 14, Midnight Black, 6/128 GB + Canyon TWS-5 simsiz minigarnituralari, \r\n45W Fast Charging, MediaTek Dimensity 7025 Ultra.', '209$', 'img_682d60dbc101b7.54552052.png'),
(14, 'Dyson WP02 OnTrac naushnik', 'aksessuar', 'Dyson WP02 OnTrac simsiz minigarnituralari CNC qora nikel, Eshitish vositalari faol shovqinni bekor qilish tizimi bilan jihozlangan.', '509$', 'img_682d629d4c8813.15941116.png'),
(15, 'Apple iPhone 16 Pro Max', 'smartfon', 'Apple iPhone 16 Pro Max, Desert Titanium, 8/512 GB, 20W-30W PD Fast Charging, \r\nApple A18 Pro', '2000$', 'img_682d63f765d168.86078383.png'),
(16, 'Samsung Galaxy S25', 'smartfon', 'Samsung Galaxy S25, Silver Shadow, 12/256 GB + Naushniklar sovg\'a sifatida, \r\n18 W Fast Charging, Qualcomm Snapdragon 8 Elite', '1100$', 'img_682d649d96b630.07010383.png'),
(17, 'ZTE Blade A75', 'smartfon', 'ZTE Blade A75, Basalt Black, 4/128 GB, 22.5W Fast Charging, 22.5W Fast Charging', '110$', 'img_682d652fdcfa51.92684906.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
