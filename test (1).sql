-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 31 2025 г., 12:03
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `point_id` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `request_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('new','confirmed','in_progress','completed','cancelled') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `service_id`, `point_id`, `request_date`, `request_time`, `notes`, `status`, `created_at`) VALUES
(1, 2, 1, 1, '2025-05-04', '09:14:00', '', 'new', '2025-04-29 22:11:47'),
(2, 2, 1, 1, '2025-05-04', '09:14:00', '', 'new', '2025-04-29 22:11:47'),
(3, 2, 1, 1, '2025-05-04', '09:14:00', '', 'new', '2025-04-29 22:14:06'),
(4, 2, 1, 1, '2025-05-04', '09:14:00', '', 'new', '2025-04-29 22:15:04'),
(5, 6, 1, 4, '2025-05-31', '16:23:00', '', 'new', '2025-05-30 14:23:59');

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `price`, `created_at`) VALUES
(1, 'Диагностика', 'Полная диагностика оборудования', 500.00, '2025-04-29 22:28:11'),
(2, 'Чистка от пыли', 'Чистка системы охлаждения', 1500.00, '2025-04-29 22:28:11'),
(3, 'Замена термопасты', 'Замена термопасты на процессоре/видеокарте', 1200.00, '2025-04-29 22:28:11'),
(4, 'Установка ОС', 'Установка и настройка операционной системы', 2000.00, '2025-04-29 22:28:11'),
(12, 'Ремонт ноутбука', 'Диагностика и ремонт ноутбуков любой сложности', 2500.00, '2025-04-29 22:32:13'),
(13, 'Чистка от пыли', 'Полная разборка и чистка системы охлаждения', 1500.00, '2025-04-29 22:32:13'),
(14, 'Замена экрана', 'Замена матрицы ноутбука или телефона', 3500.00, '2025-04-29 22:32:13');

-- --------------------------------------------------------

--
-- Структура таблицы `service_points`
--

CREATE TABLE `service_points` (
  `id` int(11) NOT NULL,
  `area` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `working_hours` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Дамп данных таблицы `service_points`
--

INSERT INTO `service_points` (`id`, `area`, `name`, `address`, `phone`, `working_hours`) VALUES
(4, '', 'Центральный сервис', 'ул. Главная, 10', '+7 (123) 456-78-90', '09:00-21:00 ежедневно'),
(5, '', 'Северный филиал', 'ул. Северная, 5', '+7 (123) 456-78-91', '10:00-20:00 пн-пт'),
(6, '', 'Южный сервис', 'ул. Южная, 15', '+7 (123) 456-78-92', '10:00-18:00 сб-вс');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `phone`, `password`, `created_at`, `name`, `email`, `description`) VALUES
(2, 'IRASHKA_7', '+79132484385', '$2y$10$tH4AfDOHQQ6AY8pUSSnlP.lnPYjmBmsE98dZDyYuQvgU219xywWa.', '2025-04-29 21:37:18', NULL, NULL, NULL),
(4, 'admin22', '+79132484385', '$2y$10$LFBJdJJQzmlSKecE7STYMuQR23XUJ.N4haPWPMjU7ULRZQcan/kUq', '2025-05-30 13:48:09', NULL, NULL, NULL),
(6, 'admin', '+79132484385', '$2y$10$iqmwSBNJmq.dYINFDZwcyeMaqr0c6IGgB1JytUw1LxiQjwUpJnzUq', '2025-05-30 14:23:12', NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `point_id` (`point_id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `service_points`
--
ALTER TABLE `service_points`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `service_points`
--
ALTER TABLE `service_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `requests_ibfk_3` FOREIGN KEY (`point_id`) REFERENCES `service_points` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
