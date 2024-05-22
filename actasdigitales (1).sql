-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-05-2024 a las 19:21:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `actasdigitales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meetings`
--

CREATE TABLE `meetings` (
  `meeting_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `meetings`
--

INSERT INTO `meetings` (`meeting_id`, `title`, `date`, `start_time`, `end_time`) VALUES
(1, 'Reunion 1 - Prueba', '2024-05-13', '00:12:00', '03:11:59'),
(2, 'Reunion - Prueba 2', '2024-05-14', '13:00:00', '14:00:00'),
(3, 'Reunion - Prueba 3', '2024-05-16', '10:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meeting_participants`
--

CREATE TABLE `meeting_participants` (
  `meeting_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `meeting_participants`
--

INSERT INTO `meeting_participants` (`meeting_id`, `user_id`, `role`) VALUES
(1, 1000210101, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `records`
--

CREATE TABLE `records` (
  `id_record` int(11) NOT NULL,
  `date_record` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `affair` varchar(255) DEFAULT NULL,
  `responsible` int(11) DEFAULT NULL,
  `privacy` enum('Pública','Privada') DEFAULT NULL,
  `relationship_record` int(11) DEFAULT NULL,
  `meeting_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `records`
--

INSERT INTO `records` (`id_record`, `date_record`, `start_time`, `end_time`, `affair`, `responsible`, `privacy`, `relationship_record`, `meeting_id`) VALUES
(1, '2024-04-29', '09:00:00', '14:00:00', 'Primera Prueba', 1000210101, 'Pública', NULL, NULL),
(3, '2024-04-28', '07:00:00', '10:00:00', 'Segunda Prueba', 1000210101, 'Privada', NULL, NULL),
(4, '2023-09-18', '10:00:00', '15:00:00', 'Tercera Prueba', 1000210101, 'Pública', 1, NULL),
(6, '2002-10-19', '09:00:00', '11:00:00', 'Cuarta prueba', 1000210101, 'Pública', 1, NULL),
(7, '2003-10-19', '08:00:00', '10:00:00', 'Quinta prueba', 1000210101, 'Pública', 3, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rol` enum('Administrador','Miembro','Invitado') DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `rol`, `password_hash`) VALUES
(1000210101, 'Miguel Negrete', 'migue@gmail.com', 'Administrador', '$2y$10$gDOpeQ4JC9bkH3gbEOcwEuPx/JYCjYt3nzMi.ZDW/lgWbcoFAV.dW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indices de la tabla `meeting_participants`
--
ALTER TABLE `meeting_participants`
  ADD PRIMARY KEY (`meeting_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id_record`),
  ADD KEY `responsible` (`responsible`),
  ADD KEY `relationship_record` (`relationship_record`),
  ADD KEY `meeting_id` (`meeting_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `meetings`
--
ALTER TABLE `meetings`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `records`
--
ALTER TABLE `records`
  MODIFY `id_record` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `meeting_participants`
--
ALTER TABLE `meeting_participants`
  ADD CONSTRAINT `meeting_participants_ibfk_1` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`meeting_id`),
  ADD CONSTRAINT `meeting_participants_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_ibfk_1` FOREIGN KEY (`responsible`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `records_ibfk_2` FOREIGN KEY (`relationship_record`) REFERENCES `records` (`id_record`),
  ADD CONSTRAINT `records_ibfk_3` FOREIGN KEY (`meeting_id`) REFERENCES `meetings` (`meeting_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
