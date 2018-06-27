-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-12-2017 a las 18:57:33
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_costos`
--

CREATE TABLE `centro_costos` (
  `cc_id` int(11) NOT NULL,
  `cc_nombre` varchar(50) NOT NULL,
  `cc_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `centro_costos`
--

INSERT INTO `centro_costos` (`cc_id`, `cc_nombre`, `cc_codigo`) VALUES
(1, 'Administracion DEFDER', 201900),
(2, 'Biblioteca central', 106600),
(3, 'Centro de estudios clasicos', 112700),
(4, 'Centro de formacion virtual', 106102),
(5, 'Contraloria interna ', 104100),
(6, 'Coordinacion de educacion continua', 106900),
(7, 'Coordinacion de practica profesional', 106800),
(8, 'Decanato de artes y educacion fisica', 114100),
(9, 'Decanato de ciencias basicas', 113100),
(10, 'Decanato de filosofia y educacion', 111100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `dpto_id` int(11) NOT NULL,
  `dpto_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `memo_num_memo` varchar(45) DEFAULT NULL,
  `memo_fecha_recep_memo` varchar(45) DEFAULT NULL,
  `memo_fecha_memo` varchar(45) DEFAULT NULL,
  `memo_fecha_entrega_analista` varchar(45) DEFAULT NULL,
  `memo_resolucion` varchar(45) DEFAULT NULL,
  `memo_url_resolucion` varchar(45) DEFAULT NULL,
  `memo_dpto_id` int(11) NOT NULL,
  `memo_cc_id` int(11) NOT NULL,
  `memo_memo_estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_archivo`
--

CREATE TABLE `memo_archivo` (
  `memo_archivo_id` int(11) NOT NULL,
  `memo_archivo_url` varchar(45) DEFAULT NULL,
  `memo_archivo_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle`
--

CREATE TABLE `memo_detalle` (
  `memo_det_id` int(11) NOT NULL,
  `memo_det_descripcion` varchar(250) DEFAULT NULL,
  `memo_det_num_orden_compra_chc` varchar(45) DEFAULT NULL,
  `memo_det_cert_disp_presupuestaria` varchar(45) DEFAULT NULL,
  `memo_det_num_orden_compra_manager` varchar(45) DEFAULT NULL,
  `memo_det_num_factura` varchar(45) DEFAULT NULL,
  `memo_det_fecha_factura` varchar(45) DEFAULT NULL,
  `memo_det_monto_total` varchar(45) DEFAULT NULL,
  `memo_det_observaciones` varchar(45) DEFAULT NULL,
  `memo_det_memo_id` int(11) NOT NULL,
  `memo_det_proveedor_id` int(11) NOT NULL,
  `memo_det_memo_detalle_estado_id` int(11) NOT NULL,
  `memo_det_proc_compra_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_archivo`
--

CREATE TABLE `memo_detalle_archivo` (
  `memo_det_archivo_id` int(11) NOT NULL,
  `memo_det_archivo_url` varchar(45) DEFAULT NULL,
  `memo_det_archivo_memo_det_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_compra`
--

CREATE TABLE `memo_detalle_compra` (
  `memo_det_compra_id` int(11) NOT NULL,
  `memo_det_compra_nombre_producto` varchar(45) DEFAULT NULL,
  `memo_det_compra_cantidad` varchar(45) DEFAULT NULL,
  `memo_det_compra_valor` varchar(45) DEFAULT NULL,
  `memo_det_compra_total` varchar(45) DEFAULT NULL,
  `memo_det_compra_memo_det_id` int(11) NOT NULL,
  `memo_det_compra_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_estado`
--

CREATE TABLE `memo_detalle_estado` (
  `memo_detalle_estado_id` int(11) NOT NULL,
  `memo_detalle_estado_tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_detalle_estado`
--

INSERT INTO `memo_detalle_estado` (`memo_detalle_estado_id`, `memo_detalle_estado_tipo`) VALUES
(1, 'En proceso'),
(2, 'Opcion de compra nula'),
(3, 'Sin efecto'),
(4, 'Sin gestion'),
(5, 'Terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estado`
--

CREATE TABLE `memo_estado` (
  `memo_estado_id` int(11) NOT NULL,
  `memo_estado_tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_estado`
--

INSERT INTO `memo_estado` (`memo_estado_id`, `memo_estado_tipo`) VALUES
(1, 'En proceso'),
(2, 'Orden de compra nula'),
(3, 'Sin efecto'),
(4, 'Sin gestion'),
(5, 'Terminado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_tiene_usuario`
--

CREATE TABLE `memo_tiene_usuario` (
  `memo_tiene_usu_memo_id` int(11) NOT NULL,
  `memo_tiene_usu_usuario_id` int(11) NOT NULL,
  `memo_tiene_usu_asignacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento_compra`
--

CREATE TABLE `procedimiento_compra` (
  `proc_compra_id` int(11) NOT NULL,
  `proc_compra_tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `procedimiento_compra`
--

INSERT INTO `procedimiento_compra` (`proc_compra_id`, `proc_compra_tipo`) VALUES
(1, 'CM'),
(2, 'Compra directa'),
(3, 'Gran compra'),
(4, 'Licitacion'),
(5, 'Trato directo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `proveedor_nombre` varchar(100) NOT NULL,
  `proveedor_rut` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_rut` varchar(45) DEFAULT NULL,
  `usuario_nombre` varchar(45) DEFAULT NULL,
  `usuario_contraseña` varchar(45) DEFAULT NULL,
  `usuario_usuario_perfil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `usuario_perfil_id` int(11) NOT NULL,
  `usuario_perfil_nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_perfil`
--

INSERT INTO `usuario_perfil` (`usuario_perfil_id`, `usuario_perfil_nombre`) VALUES
(1, 'Administrador'),
(2, 'Supervisor'),
(3, 'Analista');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`dpto_id`);

--
-- Indices de la tabla `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`,`memo_dpto_id`,`memo_cc_id`,`memo_memo_estado_id`),
  ADD KEY `fk_memo_departamento1_idx` (`memo_dpto_id`),
  ADD KEY `fk_memo_centro_costos1_idx` (`memo_cc_id`),
  ADD KEY `fk_memo_memo_estado1_idx` (`memo_memo_estado_id`);

--
-- Indices de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD PRIMARY KEY (`memo_archivo_id`,`memo_archivo_memo_id`),
  ADD KEY `fk_memo_archivo_memo1_idx` (`memo_archivo_memo_id`);

--
-- Indices de la tabla `memo_detalle`
--
ALTER TABLE `memo_detalle`
  ADD PRIMARY KEY (`memo_det_id`,`memo_det_memo_id`,`memo_det_proveedor_id`,`memo_det_memo_detalle_estado_id`,`memo_det_proc_compra_id`),
  ADD KEY `fk_memo_detalle_memo1_idx` (`memo_det_memo_id`),
  ADD KEY `fk_memo_detalle_proveedor1_idx` (`memo_det_proveedor_id`),
  ADD KEY `fk_memo_detalle_memo_detalle_estado1_idx` (`memo_det_memo_detalle_estado_id`),
  ADD KEY `fk_memo_detalle_procedimiento_compra1_idx` (`memo_det_proc_compra_id`);

--
-- Indices de la tabla `memo_detalle_archivo`
--
ALTER TABLE `memo_detalle_archivo`
  ADD PRIMARY KEY (`memo_det_archivo_id`,`memo_det_archivo_memo_det_id`),
  ADD KEY `fk_memo_detalle_archivo_memo_detalle1_idx` (`memo_det_archivo_memo_det_id`);

--
-- Indices de la tabla `memo_detalle_compra`
--
ALTER TABLE `memo_detalle_compra`
  ADD PRIMARY KEY (`memo_det_compra_id`,`memo_det_compra_memo_det_id`,`memo_det_compra_memo_id`),
  ADD KEY `fk_memo_detalle_compra_memo_detalle1_idx` (`memo_det_compra_memo_det_id`,`memo_det_compra_memo_id`);

--
-- Indices de la tabla `memo_detalle_estado`
--
ALTER TABLE `memo_detalle_estado`
  ADD PRIMARY KEY (`memo_detalle_estado_id`);

--
-- Indices de la tabla `memo_estado`
--
ALTER TABLE `memo_estado`
  ADD PRIMARY KEY (`memo_estado_id`);

--
-- Indices de la tabla `memo_tiene_usuario`
--
ALTER TABLE `memo_tiene_usuario`
  ADD PRIMARY KEY (`memo_tiene_usu_memo_id`,`memo_tiene_usu_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_usuarios1_idx` (`memo_tiene_usu_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_memo1_idx` (`memo_tiene_usu_memo_id`);

--
-- Indices de la tabla `procedimiento_compra`
--
ALTER TABLE `procedimiento_compra`
  ADD PRIMARY KEY (`proc_compra_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`,`usuario_usuario_perfil_id`),
  ADD KEY `fk_usuario_usuario_perfil1_idx` (`usuario_usuario_perfil_id`);

--
-- Indices de la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`usuario_perfil_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `dpto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  MODIFY `memo_archivo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `memo_detalle`
--
ALTER TABLE `memo_detalle`
  MODIFY `memo_det_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `memo_detalle_compra`
--
ALTER TABLE `memo_detalle_compra`
  MODIFY `memo_det_compra_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `memo_detalle_estado`
--
ALTER TABLE `memo_detalle_estado`
  MODIFY `memo_detalle_estado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `memo_estado`
--
ALTER TABLE `memo_estado`
  MODIFY `memo_estado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `procedimiento_compra`
--
ALTER TABLE `procedimiento_compra`
  MODIFY `proc_compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  MODIFY `usuario_perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `memo`
--
ALTER TABLE `memo`
  ADD CONSTRAINT `fk_memo_centro_costos1` FOREIGN KEY (`memo_cc_id`) REFERENCES `centro_costos` (`cc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_departamento1` FOREIGN KEY (`memo_dpto_id`) REFERENCES `departamento` (`dpto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_memo_estado1` FOREIGN KEY (`memo_memo_estado_id`) REFERENCES `memo_estado` (`memo_estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD CONSTRAINT `fk_memo_archivo_memo1` FOREIGN KEY (`memo_archivo_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_detalle`
--
ALTER TABLE `memo_detalle`
  ADD CONSTRAINT `fk_memo_detalle_memo1` FOREIGN KEY (`memo_det_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_detalle_memo_detalle_estado1` FOREIGN KEY (`memo_det_memo_detalle_estado_id`) REFERENCES `memo_detalle_estado` (`memo_detalle_estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_detalle_procedimiento_compra1` FOREIGN KEY (`memo_det_proc_compra_id`) REFERENCES `procedimiento_compra` (`proc_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_detalle_proveedor1` FOREIGN KEY (`memo_det_proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_detalle_archivo`
--
ALTER TABLE `memo_detalle_archivo`
  ADD CONSTRAINT `fk_memo_detalle_archivo_memo_detalle1` FOREIGN KEY (`memo_det_archivo_memo_det_id`) REFERENCES `memo_detalle` (`memo_det_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_detalle_compra`
--
ALTER TABLE `memo_detalle_compra`
  ADD CONSTRAINT `fk_memo_detalle_compra_memo_detalle1` FOREIGN KEY (`memo_det_compra_memo_det_id`,`memo_det_compra_memo_id`) REFERENCES `memo_detalle` (`memo_det_id`, `memo_det_memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_tiene_usuario`
--
ALTER TABLE `memo_tiene_usuario`
  ADD CONSTRAINT `fk_memo_has_usuarios_memo1` FOREIGN KEY (`memo_tiene_usu_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_has_usuarios_usuarios1` FOREIGN KEY (`memo_tiene_usu_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_usuario_perfil1` FOREIGN KEY (`usuario_usuario_perfil_id`) REFERENCES `usuario_perfil` (`usuario_perfil_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
