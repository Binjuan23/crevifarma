-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-04-2023 a las 15:33:05
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crevi_farma`
--
CREATE DATABASE IF NOT EXISTS `crevi_farma` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE `crevi_farma`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `foro` int(11) NOT NULL,
  `pregunta` varchar(10000) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`foro`, `pregunta`, `fecha`, `usuario_id`) VALUES
(1, '¿Funciona el foro?', '2023-04-16 18:32:55', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guardias`
--

CREATE TABLE `guardias` (
  `ID` int(11) NOT NULL,
  `ID_farmacia` int(11) NOT NULL,
  `dia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `guardias`
--

INSERT INTO `guardias` (`ID`, `ID_farmacia`, `dia`) VALUES
(1, 3, 'Lunes'),
(2, 4, 'Martes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencias`
--

CREATE TABLE `licencias` (
  `ID` int(11) NOT NULL,
  `ID_usuario` int(11) DEFAULT NULL,
  `Numero` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `licencias`
--

INSERT INTO `licencias` (`ID`, `ID_usuario`, `Numero`) VALUES
(1, NULL, '1111111111'),
(2, NULL, '2222222222'),
(3, 3, '3333333333'),
(4, 4, '44444444444');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamentos`
--

CREATE TABLE `medicamentos` (
  `ID` int(11) NOT NULL,
  `id_farmacia` int(11) NOT NULL,
  `nombre_med` varchar(50) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `medicamentos`
--

INSERT INTO `medicamentos` (`ID`, `id_farmacia`, `nombre_med`, `stock`) VALUES
(1, 3, 'Fluimucil Jarabe', 3),
(2, 4, 'Ibuprofeno Normon', 10),
(5, 3, 'Paracetamol Normon 500mg', 5),
(6, 3, 'Paracetamol Normon 1g', 1),
(7, 3, 'Ibuprofeno Normon 400mg', 3),
(8, 3, 'Enantyum 25mg', 7),
(9, 4, 'Diazepan Leo 2mg', 10),
(10, 4, 'Nolotil 595mg', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `categoria_es` varchar(50) NOT NULL,
  `categoria_val` varchar(50) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `stock` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `nombre`, `categoria_es`, `categoria_val`, `precio`, `stock`) VALUES
(11247, 'Inmunoferon 90 Cápsulas', 'Suplementos', 'Suplements', 27.14, 15),
(11424, 'Lacer Pasta Dental 2x125 ml', 'Higiene', 'Higiene', 8.69, 50),
(11555, 'Lotigén Champú Anticaída 100 ml', 'Higiene', 'Higiene', 3.41, 100),
(11748, 'NATURA Melatonina 1mg y Valeriana 60 Gummies', 'Suplementos', 'Suplements', 18.00, 25),
(22168, 'Scottex Papel Higiénico Acolchado 32 uds', 'Hogar', 'Llar', 15.41, 1),
(66214, 'Betres Ambientador Rosa Frutos Rojos 85 ml', 'Hogar', 'Llar', 5.20, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_comprados`
--

CREATE TABLE `productos_comprados` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_farmacia` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_medicamento` int(11) NOT NULL,
  `fecha_reserva` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `foro_id` int(11) NOT NULL,
  `respuesta` text NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `respuesta_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `foro_id`, `respuesta`, `usuario_id`, `fecha`, `respuesta_id`) VALUES
(1, 1, 'Parece ser que si', 2, '2023-04-16 18:45:49', NULL),
(2, 1, 'Estoy contestando al anterior', 3, '2023-04-16 18:46:23', 1),
(3, 1, 'Esta respuesta es para el anterior comentario de id 3', 4, '2023-04-17 11:10:39', 2),
(4, 1, 'Yo soy un comentario sin referencia a nadie', 1, '2023-04-17 11:11:36', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(100) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` datetime NOT NULL,
  `dinero` decimal(7,2) DEFAULT NULL,
  `tipo` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `nombre`, `apellidos`, `edad`, `usuario`, `contraseña`, `imagen`, `fecha_creacion`, `ultimo_login`, `dinero`, `tipo`, `email`, `direccion`) VALUES
(1, 'Juan Vicente', 'Brotons Martínez', 37, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'assets/images/fotoPerfil.jpg', '2023-03-05 18:43:42', '2023-03-05 18:37:37', NULL, 'admin', 'bromarlola@hotmail.com', NULL),
(2, NULL, NULL, NULL, 'normal1', 'a13c8d352d437d05a9ea0fa682414bd0', NULL, '2023-03-05 18:47:10', '2023-03-05 18:46:06', NULL, 'normal', 'normal1@hotmail.com', NULL),
(3, NULL, NULL, NULL, 'farmacia1', 'bfeabe687ad615e98762c8bcfb721730', NULL, '2023-03-05 18:49:11', '2023-03-05 18:47:41', NULL, 'farmacia', 'farmacia1@hotmail.com', NULL),
(4, NULL, NULL, NULL, 'farmacia2', 'a6639cd12cc842763628464863b74607', NULL, '2023-03-05 18:49:11', '2023-03-05 18:47:41', NULL, 'farmacia', 'farmacia2@hotmail.com', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`foro`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `guardias`
--
ALTER TABLE `guardias`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_farmacia` (`ID_farmacia`);

--
-- Indices de la tabla `licencias`
--
ALTER TABLE `licencias`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_farmacia` (`id_farmacia`) USING BTREE;

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `productos_comprados`
--
ALTER TABLE `productos_comprados`
  ADD KEY `id_pedido` (`id_pedido`,`id_usuario`,`id_producto`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD KEY `id_farmacia` (`id_farmacia`,`id_usuario`,`id_medicamento`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `respuesta_id` (`respuesta_id`),
  ADD KEY `foro_id` (`foro_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `foro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `guardias`
--
ALTER TABLE `guardias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `licencias`
--
ALTER TABLE `licencias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
