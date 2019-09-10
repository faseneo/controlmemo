-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2019 a las 18:45:59
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Estructura de tabla para la tabla `acciones`
--

CREATE TABLE `acciones` (
  `acciones_id` int(11) NOT NULL,
  `acciones_nombre` varchar(60) NOT NULL,
  `acciones_estado` tinyint(4) DEFAULT '1',
  `acciones_menuitem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigna_dificultad`
--

CREATE TABLE `asigna_dificultad` (
  `asigna_dificultad_id` int(11) NOT NULL,
  `asigna_dificultad_texto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigna_prioridad`
--

CREATE TABLE `asigna_prioridad` (
  `asigna_prioridad_id` int(11) NOT NULL,
  `asigna_prioridad_texto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigna_usuario`
--

CREATE TABLE `asigna_usuario` (
  `asigna_usuario_id` int(11) NOT NULL,
  `asigna_usuario_memo_id` int(11) NOT NULL,
  `asigna_usuario_usuario_id` int(11) NOT NULL,
  `asigna_usuario_comentario` varchar(255) NOT NULL,
  `asigna_usuario_estado_asignacion_id` int(11) NOT NULL,
  `asigna_usuario_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `asigna_usuario_asigna_prioridad_id` int(11) NOT NULL,
  `asigna_usuario_asigna_dificultad_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asocia_resolucion`
--

CREATE TABLE `asocia_resolucion` (
  `asocia_resolucion_id` int(11) NOT NULL,
  `asocia_resolucion_memo_id` int(11) NOT NULL,
  `asocia_resolucion_memo_res_is` int(11) NOT NULL,
  `asocia_resolucion_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `asocia_resolucion_comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_estados`
--

CREATE TABLE `cambio_estados` (
  `cambio_estados_id` int(11) NOT NULL,
  `cambio_estados_memo_id` int(11) NOT NULL,
  `cambio_estados_memo_estado_id` int(11) NOT NULL,
  `cambio_estados_observacion` varchar(255) DEFAULT NULL,
  `cambio_estados_usuario_id` int(11) NOT NULL,
  `cambio_estados_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_estados_detmemo`
--

CREATE TABLE `cambio_estados_detmemo` (
  `cambio_estados_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_estado_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_observacion` varchar(255) NOT NULL,
  `cambio_estados_detmemo_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centro_costos`
--

CREATE TABLE `centro_costos` (
  `cc_codigo` int(11) NOT NULL,
  `cc_nombre` varchar(200) NOT NULL,
  `cc_tipo` enum('PROPIO','PROYECTO') DEFAULT NULL,
  `cc_dependencia_codigo` int(11) NOT NULL,
  `cc_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `depto_id` int(11) NOT NULL,
  `depto_nombre` varchar(250) NOT NULL,
  `depto_nombre_corto` varchar(60) DEFAULT NULL,
  `depto_estado` tinyint(4) DEFAULT NULL,
  `depto_habilitado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `dependencia_codigo` int(11) NOT NULL,
  `dependencia_nombre` varchar(200) NOT NULL,
  `dependencia_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_memo`
--

CREATE TABLE `detalle_memo` (
  `detmemo_id` int(11) NOT NULL,
  `detmemo_descripcion` varchar(300) DEFAULT NULL,
  `detmemo_ocnum_chilecompra` varchar(50) DEFAULT NULL COMMENT 'Numero orden compra chilecompra',
  `detmemo_ocnum_sistema_interno` varchar(50) DEFAULT NULL COMMENT 'Numero orden compra manager',
  `detmemo_monto_total` float DEFAULT NULL,
  `detmemo_contacto_nombre` varchar(45) DEFAULT NULL,
  `detmemo_proc_compra_id` int(11) NOT NULL,
  `detmemo_proveedor_id` int(11) NOT NULL,
  `detmemo_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `detmemo_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_memo_archivo`
--

CREATE TABLE `detalle_memo_archivo` (
  `detmemo_archivo_id` int(11) NOT NULL,
  `detmemo_archivo_url` varchar(200) NOT NULL,
  `detmemo_archivo_name` varchar(255) NOT NULL,
  `detmemo_archivo_type` varchar(20) NOT NULL,
  `detmemo_archivo_size` float NOT NULL,
  `detmemo_archivo_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detmemo_archivo_detmemo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_orden_compra`
--

CREATE TABLE `detalle_orden_compra` (
  `detalle_ocompra_id` int(11) NOT NULL,
  `detalle_ocompra_descripcion_item` varchar(200) NOT NULL,
  `detalle_ocompra_cantidad` float NOT NULL,
  `detalle_ocompra_valor` float NOT NULL,
  `detalle_ocompra_total` float NOT NULL,
  `detalle_ocompra_detmemo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detmemo_tiene_doctributario`
--

CREATE TABLE `detmemo_tiene_doctributario` (
  `detmemo_tiene_doctributario_id` int(11) NOT NULL,
  `detmemo_tiene_doctributario_detmemo_id` int(11) NOT NULL,
  `detmemo_tiene_doctributario_doc_tributario_id` int(11) NOT NULL,
  `detmemo_tiene_doctributario_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_tributario`
--

CREATE TABLE `documento_tributario` (
  `doc_tributario_id` int(11) NOT NULL,
  `doc_tributario_numero` int(11) NOT NULL,
  `doc_tributario_monto` float NOT NULL,
  `doc_tributario_fecha` date NOT NULL,
  `doc_tributario_fecha_recepcion` date DEFAULT NULL,
  `doc_tributario_tipo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doc_tributario_tipo`
--

CREATE TABLE `doc_tributario_tipo` (
  `doc_tributario_tipo_id` int(11) NOT NULL,
  `doc_tributario_tipo_nombre` varchar(30) NOT NULL COMMENT 'factura,boleta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dpto_tiene_usu`
--

CREATE TABLE `dpto_tiene_usu` (
  `dpto_tiene_usu_depto_id` int(11) NOT NULL,
  `dpto_tiene_usu_usuario_id` int(11) NOT NULL,
  `dpto_tiene_usu_fecha_asignacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dpto_tiene_usu_principal` tinyint(4) NOT NULL,
  `dpto_tiene_usu_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_asignacion`
--

CREATE TABLE `estado_asignacion` (
  `estado_asignacion_id` int(11) NOT NULL,
  `estado_asignacion_texto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_detalle_memo`
--

CREATE TABLE `estado_detalle_memo` (
  `estado_detmemo_id` int(11) NOT NULL,
  `estado_detmemo_tipo` varchar(50) NOT NULL,
  `estado_detmemo_orden` tinyint(4) NOT NULL,
  `estado_detmemo_descripcion` varchar(128) DEFAULT NULL,
  `estado_detmemo_activo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='										';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios`
--

CREATE TABLE `historial_cambios` (
  `historial_cambios_id` int(11) NOT NULL,
  `historial_cambios_tipo_id` int(11) NOT NULL,
  `historial_cambios_tabla` varchar(128) NOT NULL,
  `historial_cambios_pk` varchar(255) NOT NULL,
  `historial_cambios_campo_nombre` varchar(128) NOT NULL,
  `historial_cambios_valor_anterior` varchar(1000) NOT NULL,
  `historial_cambios_valor_nuevo` varchar(1000) NOT NULL,
  `historial_cambios_fecha_transaccion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `historial_cambios_usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios_tipo`
--

CREATE TABLE `historial_cambios_tipo` (
  `hist_camb_tipo_id` int(11) NOT NULL,
  `hist_camb_tipo_texto` varchar(30) NOT NULL COMMENT 'insert,update,delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `memo_num_memo` varchar(10) NOT NULL,
  `memo_anio` smallint(6) NOT NULL,
  `memo_materia` varchar(400) NOT NULL,
  `memo_fecha_memo` date NOT NULL,
  `memo_fecha_recepcion` date NOT NULL,
  `memo_depto_solicitante_id` int(11) NOT NULL,
  `memo_nombre_solicitante` varchar(60) NOT NULL,
  `memo_depto_destinatario_id` int(11) NOT NULL,
  `memo_nombre_destinatario` varchar(60) NOT NULL,
  `memo_fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_cc_codigo` int(11) DEFAULT NULL,
  `memo_fecha_cdp` date DEFAULT NULL,
  `memo_tipo_doc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_archivo`
--

CREATE TABLE `memo_archivo` (
  `memo_archivo_id` int(11) NOT NULL,
  `memo_archivo_nom_documento` varchar(255) DEFAULT NULL,
  `memo_archivo_url` varchar(255) NOT NULL,
  `memo_archivo_name` varchar(255) NOT NULL,
  `memo_archivo_type` varchar(80) NOT NULL,
  `memo_archivo_size` float NOT NULL,
  `memo_archivo_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_archivo_principal_flag` tinyint(4) NOT NULL,
  `memo_archivo_memo_id` int(11) NOT NULL,
  `memo_archivo_estado` tinyint(4) NOT NULL DEFAULT '1',
  `memo_archivo_tipo_archivo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_derivado`
--

CREATE TABLE `memo_derivado` (
  `memo_derivado_id` int(11) NOT NULL,
  `memo_derivado_memo_id` int(11) NOT NULL,
  `memo_derivado_dpto_id` int(11) NOT NULL,
  `memo_derivado_nombre_destinatario` varchar(80) NOT NULL,
  `memo_derivado_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_derivado_depto_actual` tinyint(4) NOT NULL DEFAULT '1',
  `memo_derivado_estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estado`
--

CREATE TABLE `memo_estado` (
  `memo_estado_id` int(11) NOT NULL,
  `memo_estado_tipo` varchar(50) NOT NULL,
  `memo_estado_orden` tinyint(4) NOT NULL,
  `memo_estado_descripcion` varchar(128) DEFAULT NULL,
  `memo_estado_color_bg` varchar(20) DEFAULT NULL,
  `memo_estado_color_font` varchar(20) DEFAULT NULL,
  `memo_estado_activo` tinyint(4) NOT NULL DEFAULT '1',
  `memo_estado_depto_id` int(11) NOT NULL,
  `memo_estado_memo_estadogenerico_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estadogenerico`
--

CREATE TABLE `memo_estadogenerico` (
  `memo_estadogenerico_id` int(11) NOT NULL,
  `memo_estadogenerico_nombre` varchar(50) NOT NULL,
  `memo_estadogenerico_orden` tinyint(4) NOT NULL,
  `memo_estadogenerico_descripcion` varchar(128) DEFAULT NULL,
  `memo_estadogenerico_color_bg` varchar(20) DEFAULT NULL,
  `memo_estadogenerico_color_font` varchar(20) DEFAULT NULL,
  `memo_estadogenerico_activo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estado_flujo`
--

CREATE TABLE `memo_estado_flujo` (
  `memo_estado_flujo_estado_id` int(11) NOT NULL,
  `memo_estado_flujo_estado_id_hijo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_observaciones`
--

CREATE TABLE `memo_observaciones` (
  `memo_observaciones_id` int(11) NOT NULL,
  `memo_observaciones_texto` varchar(500) NOT NULL,
  `memo_observaciones_fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_observaciones_memo_id` int(11) NOT NULL,
  `memo_observaciones_usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_resoluciones`
--

CREATE TABLE `memo_resoluciones` (
  `memo_res_id` int(11) NOT NULL,
  `memo_res_num` varchar(15) NOT NULL,
  `memo_res_url` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_nombre` varchar(60) NOT NULL,
  `menu_url` varchar(255) DEFAULT NULL,
  `menu_descripcion` varchar(255) DEFAULT NULL,
  `menu_estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menuitem`
--

CREATE TABLE `menuitem` (
  `menuitem_id` int(11) NOT NULL,
  `menuitem_nombre` varchar(50) NOT NULL,
  `menuitem_url` varchar(255) DEFAULT NULL,
  `menuitem_estado` tinyint(4) DEFAULT NULL,
  `menuitem_menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `perfiles_id` int(11) NOT NULL,
  `perfiles_nombre` varchar(25) NOT NULL,
  `perfiles_descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `permisos_perfiles_id` int(11) NOT NULL,
  `permisos_acciones_id` int(11) NOT NULL,
  `permisos_fecha_ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `permisos_fecha_modificacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento_compra`
--

CREATE TABLE `procedimiento_compra` (
  `proc_compra_id` int(11) NOT NULL,
  `proc_compra_tipo` varchar(50) NOT NULL,
  `proc_compra_orden` tinyint(4) NOT NULL,
  `proc_compra_descripcion` varchar(256) DEFAULT NULL,
  `proc_compra_activo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `proveedor_rut` varchar(12) NOT NULL,
  `proveedor_nombre` varchar(180) NOT NULL,
  `proveedor_direccion` varchar(128) DEFAULT NULL,
  `proveedor_fono` varchar(15) DEFAULT NULL,
  `proveedor_ciudad` varchar(100) DEFAULT NULL,
  `proveedor_region` varchar(100) DEFAULT NULL,
  `proveedor_cuenta` varchar(30) DEFAULT NULL,
  `proveedor_contacto_nombre` varchar(80) DEFAULT NULL,
  `proveedor_contacto_email` varchar(120) DEFAULT NULL,
  `proveedor_contacto_fono` varchar(15) DEFAULT NULL,
  `proveedor_estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo`
--

CREATE TABLE `tipo_archivo` (
  `tipo_archivo_id` int(11) NOT NULL,
  `tipo_archivo_nombre` varchar(80) NOT NULL,
  `tipo_archivo_activo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tipo_doc_id` int(11) NOT NULL,
  `tipo_doc_nombre` varchar(60) DEFAULT NULL,
  `tipo_doc_estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_rut` varchar(10) NOT NULL,
  `usuario_nombre` varchar(60) NOT NULL,
  `usuario_email` varchar(130) NOT NULL,
  `usuario_password` varchar(10) NOT NULL,
  `usuario_usu_rol_id` int(11) NOT NULL,
  `usuario_fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_urlimg` varchar(254) DEFAULT NULL,
  `usuario_estado` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:creado,1:activo, 2:inactivo (se podria agregar bloqueado y eliminado)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `usu_rol_id` int(11) NOT NULL,
  `usu_rol_nombre` varchar(64) NOT NULL,
  `usu_rol_descripcion` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usu_perfiles`
--

CREATE TABLE `usu_perfiles` (
  `usu_perfiles_usuario_id` int(11) NOT NULL,
  `usu_perfiles_perfiles_id` int(11) NOT NULL,
  `usu_perfiles_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD PRIMARY KEY (`acciones_id`),
  ADD KEY `fk_acciones_menuitem1_idx` (`acciones_menuitem_id`);

--
-- Indices de la tabla `asigna_dificultad`
--
ALTER TABLE `asigna_dificultad`
  ADD PRIMARY KEY (`asigna_dificultad_id`);

--
-- Indices de la tabla `asigna_prioridad`
--
ALTER TABLE `asigna_prioridad`
  ADD PRIMARY KEY (`asigna_prioridad_id`);

--
-- Indices de la tabla `asigna_usuario`
--
ALTER TABLE `asigna_usuario`
  ADD PRIMARY KEY (`asigna_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_usuarios1_idx` (`asigna_usuario_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_memo1_idx` (`asigna_usuario_memo_id`),
  ADD KEY `fk_asigna_usuario_estado_asignacion1_idx` (`asigna_usuario_estado_asignacion_id`),
  ADD KEY `fk_asigna_usuario_asigna_prioridad1_idx` (`asigna_usuario_asigna_prioridad_id`),
  ADD KEY `fk_asigna_usuario_asigna_dificultad1_idx` (`asigna_usuario_asigna_dificultad_id`);

--
-- Indices de la tabla `asocia_resolucion`
--
ALTER TABLE `asocia_resolucion`
  ADD PRIMARY KEY (`asocia_resolucion_id`),
  ADD KEY `fk_memo_has_memo_resoluciones_memo_resoluciones1_idx` (`asocia_resolucion_memo_res_is`),
  ADD KEY `fk_memo_has_memo_resoluciones_memo1_idx` (`asocia_resolucion_memo_id`);

--
-- Indices de la tabla `cambio_estados`
--
ALTER TABLE `cambio_estados`
  ADD PRIMARY KEY (`cambio_estados_id`),
  ADD KEY `fk_memo_has_memo_estado_memo_estado1_idx` (`cambio_estados_memo_estado_id`),
  ADD KEY `fk_memo_has_memo_estado_memo1_idx` (`cambio_estados_memo_id`);

--
-- Indices de la tabla `cambio_estados_detmemo`
--
ALTER TABLE `cambio_estados_detmemo`
  ADD PRIMARY KEY (`cambio_estados_detmemo_id`),
  ADD KEY `fk_detalle_memo_has_estado_detalle_memo_estado_detalle_memo_idx` (`cambio_estados_detmemo_estado_detmemo_id`),
  ADD KEY `fk_detalle_memo_has_estado_detalle_memo_detalle_memo1_idx` (`cambio_estados_detmemo_detmemo_id`);

--
-- Indices de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  ADD PRIMARY KEY (`cc_codigo`),
  ADD KEY `fk_centro_costos_dependencia1_idx` (`cc_dependencia_codigo`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`depto_id`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`dependencia_codigo`);

--
-- Indices de la tabla `detalle_memo`
--
ALTER TABLE `detalle_memo`
  ADD PRIMARY KEY (`detmemo_id`),
  ADD KEY `fk_detalle_memo_procedimiento_compra1_idx` (`detmemo_proc_compra_id`),
  ADD KEY `fk_detalle_memo_proveedor1_idx` (`detmemo_proveedor_id`),
  ADD KEY `fk_detalle_memo_memo1_idx` (`detmemo_memo_id`);

--
-- Indices de la tabla `detalle_memo_archivo`
--
ALTER TABLE `detalle_memo_archivo`
  ADD PRIMARY KEY (`detmemo_archivo_id`),
  ADD KEY `fk_detalle_memo_archivo_detalle_memo1_idx` (`detmemo_archivo_detmemo_id`);

--
-- Indices de la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  ADD PRIMARY KEY (`detalle_ocompra_id`),
  ADD KEY `fk_detalle_orden_compra_detalle_memo1_idx` (`detalle_ocompra_detmemo_id`);

--
-- Indices de la tabla `detmemo_tiene_doctributario`
--
ALTER TABLE `detmemo_tiene_doctributario`
  ADD PRIMARY KEY (`detmemo_tiene_doctributario_id`),
  ADD KEY `fk_detalle_memo_has_documento_tributario_documento_tributar_idx` (`detmemo_tiene_doctributario_doc_tributario_id`),
  ADD KEY `fk_detalle_memo_has_documento_tributario_detalle_memo1_idx` (`detmemo_tiene_doctributario_detmemo_id`);

--
-- Indices de la tabla `documento_tributario`
--
ALTER TABLE `documento_tributario`
  ADD PRIMARY KEY (`doc_tributario_id`),
  ADD KEY `fk_documento_tributario_doc_tributario_tipo1_idx` (`doc_tributario_tipo_id`);

--
-- Indices de la tabla `doc_tributario_tipo`
--
ALTER TABLE `doc_tributario_tipo`
  ADD PRIMARY KEY (`doc_tributario_tipo_id`);

--
-- Indices de la tabla `dpto_tiene_usu`
--
ALTER TABLE `dpto_tiene_usu`
  ADD KEY `fk_departamento_has_usuario_usuario1_idx` (`dpto_tiene_usu_usuario_id`),
  ADD KEY `fk_departamento_has_usuario_departamento1_idx` (`dpto_tiene_usu_depto_id`);

--
-- Indices de la tabla `estado_asignacion`
--
ALTER TABLE `estado_asignacion`
  ADD PRIMARY KEY (`estado_asignacion_id`);

--
-- Indices de la tabla `estado_detalle_memo`
--
ALTER TABLE `estado_detalle_memo`
  ADD PRIMARY KEY (`estado_detmemo_id`);

--
-- Indices de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  ADD PRIMARY KEY (`historial_cambios_id`),
  ADD KEY `fk_memo_historial_historial_tipo1_idx` (`historial_cambios_tipo_id`),
  ADD KEY `fk_historial_cambios_usuario1_idx` (`historial_cambios_usuario_id`);

--
-- Indices de la tabla `historial_cambios_tipo`
--
ALTER TABLE `historial_cambios_tipo`
  ADD PRIMARY KEY (`hist_camb_tipo_id`);

--
-- Indices de la tabla `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`memo_id`),
  ADD KEY `idx_memo_depto_solicitante` (`memo_depto_solicitante_id`),
  ADD KEY `idx_memo_depto_destinatario` (`memo_depto_destinatario_id`),
  ADD KEY `fk_memo_centro_costos1_idx` (`memo_cc_codigo`),
  ADD KEY `fk_memo_tipo_documento1_idx` (`memo_tipo_doc_id`);

--
-- Indices de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD PRIMARY KEY (`memo_archivo_id`),
  ADD KEY `fk_memo_archivo_memo1_idx` (`memo_archivo_memo_id`),
  ADD KEY `fk_memo_archivo_tipo_archivo1_idx` (`memo_archivo_tipo_archivo_id`);

--
-- Indices de la tabla `memo_derivado`
--
ALTER TABLE `memo_derivado`
  ADD PRIMARY KEY (`memo_derivado_id`),
  ADD KEY `fk_memo_ruta_memo1_idx` (`memo_derivado_memo_id`),
  ADD KEY `fk_memo_ruta_departamento1_idx` (`memo_derivado_dpto_id`);

--
-- Indices de la tabla `memo_estado`
--
ALTER TABLE `memo_estado`
  ADD PRIMARY KEY (`memo_estado_id`),
  ADD KEY `fk_memo_estado_departamento1_idx` (`memo_estado_depto_id`),
  ADD KEY `fk_memo_estado_memo_estadogenerico1_idx` (`memo_estado_memo_estadogenerico_id`);

--
-- Indices de la tabla `memo_estadogenerico`
--
ALTER TABLE `memo_estadogenerico`
  ADD PRIMARY KEY (`memo_estadogenerico_id`);

--
-- Indices de la tabla `memo_estado_flujo`
--
ALTER TABLE `memo_estado_flujo`
  ADD KEY `fk_memo_estado_has_memo_estado_memo_estado2_idx` (`memo_estado_flujo_estado_id_hijo`),
  ADD KEY `fk_memo_estado_has_memo_estado_memo_estado1_idx` (`memo_estado_flujo_estado_id`);

--
-- Indices de la tabla `memo_observaciones`
--
ALTER TABLE `memo_observaciones`
  ADD PRIMARY KEY (`memo_observaciones_id`),
  ADD KEY `fk_memo_observaciones_memo1_idx` (`memo_observaciones_memo_id`);

--
-- Indices de la tabla `memo_resoluciones`
--
ALTER TABLE `memo_resoluciones`
  ADD PRIMARY KEY (`memo_res_id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `menuitem`
--
ALTER TABLE `menuitem`
  ADD PRIMARY KEY (`menuitem_id`),
  ADD KEY `fk_menuitem_menu1_idx` (`menuitem_menu_id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  ADD PRIMARY KEY (`perfiles_id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`permisos_perfiles_id`,`permisos_acciones_id`),
  ADD KEY `fk_perfiles_has_acciones_acciones1_idx` (`permisos_acciones_id`),
  ADD KEY `fk_perfiles_has_acciones_perfiles1_idx` (`permisos_perfiles_id`);

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
-- Indices de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  ADD PRIMARY KEY (`tipo_archivo_id`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`tipo_doc_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `fk_usuario_usuario_rol1_idx` (`usuario_usu_rol_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`usu_rol_id`);

--
-- Indices de la tabla `usu_perfiles`
--
ALTER TABLE `usu_perfiles`
  ADD PRIMARY KEY (`usu_perfiles_usuario_id`,`usu_perfiles_perfiles_id`),
  ADD KEY `fk_usuario_has_perfiles_perfiles1_idx` (`usu_perfiles_perfiles_id`),
  ADD KEY `fk_usuario_has_perfiles_usuario1_idx` (`usu_perfiles_usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acciones`
--
ALTER TABLE `acciones`
  MODIFY `acciones_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asigna_dificultad`
--
ALTER TABLE `asigna_dificultad`
  MODIFY `asigna_dificultad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `asigna_prioridad`
--
ALTER TABLE `asigna_prioridad`
  MODIFY `asigna_prioridad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `asigna_usuario`
--
ALTER TABLE `asigna_usuario`
  MODIFY `asigna_usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `asocia_resolucion`
--
ALTER TABLE `asocia_resolucion`
  MODIFY `asocia_resolucion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cambio_estados`
--
ALTER TABLE `cambio_estados`
  MODIFY `cambio_estados_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `cambio_estados_detmemo`
--
ALTER TABLE `cambio_estados_detmemo`
  MODIFY `cambio_estados_detmemo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  MODIFY `cc_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5001002;

--
-- AUTO_INCREMENT de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  MODIFY `dependencia_codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5001001;

--
-- AUTO_INCREMENT de la tabla `detalle_memo`
--
ALTER TABLE `detalle_memo`
  MODIFY `detmemo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  MODIFY `detalle_ocompra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detmemo_tiene_doctributario`
--
ALTER TABLE `detmemo_tiene_doctributario`
  MODIFY `detmemo_tiene_doctributario_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `documento_tributario`
--
ALTER TABLE `documento_tributario`
  MODIFY `doc_tributario_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `doc_tributario_tipo`
--
ALTER TABLE `doc_tributario_tipo`
  MODIFY `doc_tributario_tipo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_asignacion`
--
ALTER TABLE `estado_asignacion`
  MODIFY `estado_asignacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_detalle_memo`
--
ALTER TABLE `estado_detalle_memo`
  MODIFY `estado_detmemo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  MODIFY `historial_cambios_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial_cambios_tipo`
--
ALTER TABLE `historial_cambios_tipo`
  MODIFY `hist_camb_tipo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  MODIFY `memo_archivo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_derivado`
--
ALTER TABLE `memo_derivado`
  MODIFY `memo_derivado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `memo_estado`
--
ALTER TABLE `memo_estado`
  MODIFY `memo_estado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `memo_estadogenerico`
--
ALTER TABLE `memo_estadogenerico`
  MODIFY `memo_estadogenerico_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `memo_observaciones`
--
ALTER TABLE `memo_observaciones`
  MODIFY `memo_observaciones_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_resoluciones`
--
ALTER TABLE `memo_resoluciones`
  MODIFY `memo_res_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `menuitem`
--
ALTER TABLE `menuitem`
  MODIFY `menuitem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `perfiles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `procedimiento_compra`
--
ALTER TABLE `procedimiento_compra`
  MODIFY `proc_compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  MODIFY `tipo_archivo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `tipo_doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `usu_rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acciones`
--
ALTER TABLE `acciones`
  ADD CONSTRAINT `fk_acciones_menuitem1` FOREIGN KEY (`acciones_menuitem_id`) REFERENCES `menuitem` (`menuitem_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asigna_usuario`
--
ALTER TABLE `asigna_usuario`
  ADD CONSTRAINT `fk_asigna_usuario_asigna_dificultad1` FOREIGN KEY (`asigna_usuario_asigna_dificultad_id`) REFERENCES `asigna_dificultad` (`asigna_dificultad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asigna_usuario_asigna_prioridad1` FOREIGN KEY (`asigna_usuario_asigna_prioridad_id`) REFERENCES `asigna_prioridad` (`asigna_prioridad_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_asigna_usuario_estado_asignacion1` FOREIGN KEY (`asigna_usuario_estado_asignacion_id`) REFERENCES `estado_asignacion` (`estado_asignacion_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_has_usuarios_memo1` FOREIGN KEY (`asigna_usuario_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_has_usuarios_usuarios1` FOREIGN KEY (`asigna_usuario_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `asocia_resolucion`
--
ALTER TABLE `asocia_resolucion`
  ADD CONSTRAINT `fk_memo_has_memo_resoluciones_memo1` FOREIGN KEY (`asocia_resolucion_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_has_memo_resoluciones_memo_resoluciones1` FOREIGN KEY (`asocia_resolucion_memo_res_is`) REFERENCES `memo_resoluciones` (`memo_res_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cambio_estados`
--
ALTER TABLE `cambio_estados`
  ADD CONSTRAINT `fk_memo_has_memo_estado_memo1` FOREIGN KEY (`cambio_estados_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_has_memo_estado_memo_estado1` FOREIGN KEY (`cambio_estados_memo_estado_id`) REFERENCES `memo_estado` (`memo_estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cambio_estados_detmemo`
--
ALTER TABLE `cambio_estados_detmemo`
  ADD CONSTRAINT `fk_detalle_memo_has_estado_detalle_memo_detalle_memo1` FOREIGN KEY (`cambio_estados_detmemo_detmemo_id`) REFERENCES `detalle_memo` (`detmemo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_memo_has_estado_detalle_memo_estado_detalle_memo1` FOREIGN KEY (`cambio_estados_detmemo_estado_detmemo_id`) REFERENCES `estado_detalle_memo` (`estado_detmemo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  ADD CONSTRAINT `fk_centro_costos_dependencia1` FOREIGN KEY (`cc_dependencia_codigo`) REFERENCES `dependencia` (`dependencia_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_memo`
--
ALTER TABLE `detalle_memo`
  ADD CONSTRAINT `fk_detalle_memo_memo1` FOREIGN KEY (`detmemo_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_memo_procedimiento_compra1` FOREIGN KEY (`detmemo_proc_compra_id`) REFERENCES `procedimiento_compra` (`proc_compra_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_memo_proveedor1` FOREIGN KEY (`detmemo_proveedor_id`) REFERENCES `proveedor` (`proveedor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_memo_archivo`
--
ALTER TABLE `detalle_memo_archivo`
  ADD CONSTRAINT `fk_detalle_memo_archivo_detalle_memo1` FOREIGN KEY (`detmemo_archivo_detmemo_id`) REFERENCES `detalle_memo` (`detmemo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_orden_compra`
--
ALTER TABLE `detalle_orden_compra`
  ADD CONSTRAINT `fk_detalle_orden_compra_detalle_memo1` FOREIGN KEY (`detalle_ocompra_detmemo_id`) REFERENCES `detalle_memo` (`detmemo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detmemo_tiene_doctributario`
--
ALTER TABLE `detmemo_tiene_doctributario`
  ADD CONSTRAINT `fk_detalle_memo_has_documento_tributario_detalle_memo1` FOREIGN KEY (`detmemo_tiene_doctributario_detmemo_id`) REFERENCES `detalle_memo` (`detmemo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_memo_has_documento_tributario_documento_tributario1` FOREIGN KEY (`detmemo_tiene_doctributario_doc_tributario_id`) REFERENCES `documento_tributario` (`doc_tributario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documento_tributario`
--
ALTER TABLE `documento_tributario`
  ADD CONSTRAINT `fk_documento_tributario_doc_tributario_tipo1` FOREIGN KEY (`doc_tributario_tipo_id`) REFERENCES `doc_tributario_tipo` (`doc_tributario_tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dpto_tiene_usu`
--
ALTER TABLE `dpto_tiene_usu`
  ADD CONSTRAINT `fk_departamento_has_usuario_departamento1` FOREIGN KEY (`dpto_tiene_usu_depto_id`) REFERENCES `departamento` (`depto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_departamento_has_usuario_usuario1` FOREIGN KEY (`dpto_tiene_usu_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `historial_cambios`
--
ALTER TABLE `historial_cambios`
  ADD CONSTRAINT `fk_historial_cambios_usuario1` FOREIGN KEY (`historial_cambios_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_historial_historial_tipo1` FOREIGN KEY (`historial_cambios_tipo_id`) REFERENCES `historial_cambios_tipo` (`hist_camb_tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo`
--
ALTER TABLE `memo`
  ADD CONSTRAINT `fk_memo_centro_costos1` FOREIGN KEY (`memo_cc_codigo`) REFERENCES `centro_costos` (`cc_codigo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_memo_tipo_documento1` FOREIGN KEY (`memo_tipo_doc_id`) REFERENCES `tipo_documento` (`tipo_doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD CONSTRAINT `fk_memo_archivo_memo1` FOREIGN KEY (`memo_archivo_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_archivo_tipo_archivo1` FOREIGN KEY (`memo_archivo_tipo_archivo_id`) REFERENCES `tipo_archivo` (`tipo_archivo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_derivado`
--
ALTER TABLE `memo_derivado`
  ADD CONSTRAINT `fk_memo_ruta_departamento1` FOREIGN KEY (`memo_derivado_dpto_id`) REFERENCES `departamento` (`depto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_ruta_memo1` FOREIGN KEY (`memo_derivado_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_estado`
--
ALTER TABLE `memo_estado`
  ADD CONSTRAINT `fk_memo_estado_departamento1` FOREIGN KEY (`memo_estado_depto_id`) REFERENCES `departamento` (`depto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_estado_memo_estadogenerico1` FOREIGN KEY (`memo_estado_memo_estadogenerico_id`) REFERENCES `memo_estadogenerico` (`memo_estadogenerico_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_estado_flujo`
--
ALTER TABLE `memo_estado_flujo`
  ADD CONSTRAINT `fk_memo_estado_has_memo_estado_memo_estado1` FOREIGN KEY (`memo_estado_flujo_estado_id`) REFERENCES `memo_estado` (`memo_estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_estado_has_memo_estado_memo_estado2` FOREIGN KEY (`memo_estado_flujo_estado_id_hijo`) REFERENCES `memo_estado` (`memo_estado_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_observaciones`
--
ALTER TABLE `memo_observaciones`
  ADD CONSTRAINT `fk_memo_observaciones_memo1` FOREIGN KEY (`memo_observaciones_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `fk_menuitem_menu1` FOREIGN KEY (`menuitem_menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `fk_perfiles_has_acciones_acciones1` FOREIGN KEY (`permisos_acciones_id`) REFERENCES `acciones` (`acciones_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_perfiles_has_acciones_perfiles1` FOREIGN KEY (`permisos_perfiles_id`) REFERENCES `perfiles` (`perfiles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_usuario_rol1` FOREIGN KEY (`usuario_usu_rol_id`) REFERENCES `usuario_rol` (`usu_rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usu_perfiles`
--
ALTER TABLE `usu_perfiles`
  ADD CONSTRAINT `fk_usuario_has_perfiles_perfiles1` FOREIGN KEY (`usu_perfiles_perfiles_id`) REFERENCES `perfiles` (`perfiles_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_perfiles_usuario1` FOREIGN KEY (`usu_perfiles_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
