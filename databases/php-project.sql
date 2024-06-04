-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 04 2023 г., 17:50
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php-project`
--

DELIMITER $$
--
-- Процедуры
--
CREATE DEFINER=`root`@`%` PROCEDURE `GetPersonalDataChangesById` (`id` INT)   BEGIN
    SELECT * FROM old_users WHERE record_id = id;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `get_emails` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE check_email VARCHAR(255);
    DECLARE cur CURSOR FOR SELECT email FROM users WHERE LENGTH(email) > 20;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO check_email;
        IF done THEN
            LEAVE read_loop;
        END IF;
        SELECT check_email;
    END LOOP;
    CLOSE cur;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `get_telephones` ()   BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE telephone VARCHAR(255);
    DECLARE cur CURSOR FOR SELECT email FROM users;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO telephone;
        IF done THEN
            LEAVE read_loop;
        END IF;
        SELECT telephone;
    END LOOP;
    CLOSE cur;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `old_users`
--

CREATE TABLE `old_users` (
  `record_id` int DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `old_users`
--

INSERT INTO `old_users` (`record_id`, `login`, `email`, `telephone`, `password`, `timestamp`) VALUES
(15, 'Всеволод Ростовский', 'vsevolod.sheng@mail.ru', '+7978798802', '$2y$10$f8nkuUqlT51g0V1fhWVZgOZNHwvZDP7haq2gBotZz5vsbLjdjzyiu', '2023-06-15 07:21:48'),
(15, 'Всеволод Ростовский', 'vsevolod.sheng@mail.ru', '+79787988044', '$2y$10$f8nkuUqlT51g0V1fhWVZgOZNHwvZDP7haq2gBotZz5vsbLjdjzyiu', '2023-06-15 07:22:02'),
(16, 'Всеволод Ростов', 'vsevolod@mail.ru', '+79787988111', '$2y$10$.m9uyTaFWY0Beefu5QIvH.YhtYAqLXNIJTtSGmIkdg7MFQPIQNIo2', '2023-06-15 08:37:46'),
(15, 'Всеволод Ростовский', 'vsevolod.sheng@mail.ru', '+79787988045', '$2y$10$f8nkuUqlT51g0V1fhWVZgOZNHwvZDP7haq2gBotZz5vsbLjdjzyiu', '2023-06-15 08:37:53');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `test_view`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `test_view` (
`id` int
,`login` varchar(64)
,`email` varchar(48)
,`telephone` varchar(48)
);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(48) DEFAULT NULL,
  `telephone` varchar(48) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `telephone`, `password`) VALUES
(15, 'Всеволод Ростовский', 'vsevolod.sheng@mail.ru', '79787988045', '$2y$10$f8nkuUqlT51g0V1fhWVZgOZNHwvZDP7haq2gBotZz5vsbLjdjzyiu'),
(16, 'Всеволод Ростов', 'vsevolod@mail.ru', '79787988111', '$2y$10$.m9uyTaFWY0Beefu5QIvH.YhtYAqLXNIJTtSGmIkdg7MFQPIQNIo2'),
(17, 'KJHB.LKJHH.B,JB', '465u456u2@REGJJJ', '46356543653', '$2y$10$njVw15xkBnD/DBWjLss.BevlIRL.FNNnZbvorefxYmMVmap0pZVLW');

--
-- Триггеры `users`
--
DELIMITER $$
CREATE TRIGGER `check_email_format` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.email NOT REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+.[A-Za-z]{2,}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Неверный формат электронной почты';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `check_telephone_format` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.telephone NOT REGEXP '^+[0-9]{1,3}-[0-9]{1,14}$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Неверный формат телефонного номера';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `save_old_data` BEFORE UPDATE ON `users` FOR EACH ROW BEGIN
    INSERT INTO old_users (record_id, login, email, telephone, password, timestamp)
    VALUES (OLD.id, OLD.login, OLD.email, OLD.telephone, OLD.password, CURRENT_TIMESTAMP);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `view_test`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `view_test` (
`login` varchar(64)
,`email` varchar(48)
,`telephone` varchar(48)
);

-- --------------------------------------------------------

--
-- Структура для представления `test_view`
--
DROP TABLE IF EXISTS `test_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `test_view`  AS SELECT `users`.`id` AS `id`, `users`.`login` AS `login`, `users`.`email` AS `email`, `users`.`telephone` AS `telephone` FROM `users``users`  ;

-- --------------------------------------------------------

--
-- Структура для представления `view_test`
--
DROP TABLE IF EXISTS `view_test`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `view_test`  AS SELECT `users`.`login` AS `login`, `users`.`email` AS `email`, `users`.`telephone` AS `telephone` FROM `users``users`  ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
