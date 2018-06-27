-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 26-10-2017 a las 14:40:37
-- Versión del servidor: 5.7.17-0ubuntu0.16.04.2
-- Versión de PHP: 5.6.30-10+deb.sury.org~xenial+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `controlmemo`
--

--
-- Volcado de datos para la tabla `centro_costos`
--

INSERT INTO `centro_costos` (`cc_id`, `cc_nombre`, `cc_codigo`) VALUES
(1, 'Administracion DEFDER', 201100),
(2, 'Biblioteca central', 106600),
(3, 'Centro de estudios clasicos', 112700),
(4, 'Centro de formacion virtual', 106102),
(5, 'Contraloria interna ', 104100),
(6, 'Coordinacion de educacion continua', 106900),
(7, 'Coordinacion de practica profesional', 106800),
(8, 'Decanato de artes y educacion fisica', 114100),
(9, 'Decanato de ciencias basicas', 113100),
(10, 'Decanato de filosofia y educacion', 111100);

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`dpto_id`, `dpto_nombre`) VALUES
(1, 'Admision y registro curricular'),
(2, 'Campus Joaquin Cabezas Garcias'),
(3, 'Centro de acompañamiento al aprendizaje'),
(4, 'Centro de estudios clasicos'),
(5, 'Contraloria interna'),
(6, 'Coordinacion general de practicas'),
(7, 'Departamento biologia'),
(8, 'Departamento de aleman'),
(9, 'Departamento de artes visuales'),
(10, 'Departamento de bienestar del personal'),
(11, 'Departamento de castellano'),
(12, 'Departamento de educacion basica');

--
-- Volcado de datos para la tabla `memo_detalle_estado`
--

INSERT INTO `memo_detalle_estado` (`memo_detalle_estado_id`, `memo_detalle_estado_tipo`) VALUES
(1, 'En proceso'),
(2, 'Opcion de compra nula'),
(3, 'Sin efecto'),
(4, 'Sin gestion'),
(5, 'Terminado');

--
-- Volcado de datos para la tabla `memo_estado`
--

INSERT INTO `memo_estado` (`memo_estado_id`, `memo_estado_tipo`) VALUES
(1, 'En proceso'),
(2, 'Orden de compra nula'),
(3, 'Sin efecto'),
(4, 'Sin gestion'),
(5, 'Terminado');

--
-- Volcado de datos para la tabla `procedimiento_compra`
--

INSERT INTO `procedimiento_compra` (`proc_compra_id`, `proc_compra_tipo`) VALUES
(1, 'CM'),
(2, 'Compra directa'),
(3, 'Gran compra'),
(4, 'Licitacion'),
(5, 'Trato directo');

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `proveedor_nombre`, `proveedor_rut`) VALUES
(1, 'Abastible S.A', ''),
(2, 'Abatte S.A', ''),
(3, 'Accion grafica publicitaria SPA', ''),
(4, 'Acevedo Quintanilla Alvaro Andres', ''),
(5, 'Acima soluciones integrales LTDA', ''),
(6, 'Activenetwork SPA', ''),
(7, 'Adela del Carmen Leon Ibarra', ''),
(8, 'Adexus S.A.', ''),
(9, 'ADT Security services S.A', ''),
(10, 'Advantage computacional LTDA', ''),
(11, 'AG Imprenta LTDA', ''),
(12, 'Agencia de viajes del sud LTDA', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
