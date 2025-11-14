-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 14-11-2025 a las 22:30:55
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `Id` int NOT NULL,
  `Matricula` varchar(10) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apaterno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Amaterno` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Celular` varchar(12) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `Sexo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`Id`, `Matricula`, `Nombre`, `Apaterno`, `Amaterno`, `Email`, `Celular`, `CP`, `Sexo`) VALUES
(1, '230130055', 'Pedro Antonio', 'De Los Santos', 'Aguilar', '230130069@upve.edu.mx', '6971095029', '81600', 'Femenino'),
(16, '230130048', 'Lilian Sarahi', 'Tapia', 'Garcia', '230130048@upve.edu.mx', '697', '81611', 'Femenino'),
(41, '230130052', 'Sofía', 'Moreno', 'Ríos', '230130052@upve.edu.mx', '6589745123', '81610', 'Femenino'),
(42, '230130053', 'Carlos Alberto', 'García', 'Peña', '230130053@upve.edu.mx', '6974125986', '81605', 'Masculino'),
(43, '230130054', 'Fernanda', 'Hernández', 'Torres', '230130054@upve.edu.mx', '6583241795', '81611', 'Femenino'),
(47, '230130059', 'Mariana', 'Flores', 'Martínez', '230130059@upve.edu.mx', '6589514723', '81608', 'Femenino'),
(48, '230130060', 'Eduardo', 'Reyes', 'Ortiz', '230130060@upve.edu.mx', '6971478953', '81607', 'Masculino'),
(49, '230130061', 'Paola', 'Gutiérrez', 'Haro', '230130061@upve.edu.mx', '6582457931', '81615', 'Femenino'),
(50, '230130062', 'Luis Ángel', 'Camacho', 'Soto', '230130062@upve.edu.mx', '6978547129', '81613', 'Masculino'),
(51, '230130063', 'Diana', 'Mendoza', 'Gómez', '230130063@upve.edu.mx', '6589735142', '81609', 'Femenino'),
(61, '230130055', 'Alonso', 'Melendrez', 'Angulo', '230130055@upve.edu.mx', '6585698522', '81611', 'Masculino');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
