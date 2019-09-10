-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2019 a las 09:39:03
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

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `listado_memos_estadomax_depto_adquisiciones` (IN `deptosol` INT, IN `estado` INT, IN `inicio` INT, IN `fin` INT, IN `usuario` INT, IN `anio` INT, IN `mes` INT, IN `numdoc` INT, IN `usuasigna` INT, IN `estadonot` VARCHAR(6))  BEGIN
DECLARE maximos VARCHAR(2000);
DECLARE consulta VARCHAR (2000);
DECLARE filtromemo VARCHAR(2000)DEFAULT ' ';
DECLARE agregajoin VARCHAR(2000)DEFAULT ' ';
DECLARE campo1 varchar(30) default '(NULL)';
DECLARE campo2 varchar(30) default '(NULL)';
DECLARE campo3 varchar(40) default '(NULL)';
DECLARE filtro VARCHAR(2000)DEFAULT ' WHERE 1 = 1 ';
DECLARE orden VARCHAR(1000) DEFAULT ' ORDER BY cambio_estados_dias DESC, fecha_recepcion_unidad ASC, memo_fecha_memo DESC';
DECLARE pagina VARCHAR (50);
DECLARE estado_recepcion int;

SELECT me.memo_estado_id INTO estado_recepcion
FROM usuario as usu
INNER JOIN dpto_tiene_usu AS dtu ON dtu.dpto_tiene_usu_usuario_id = usu.usuario_id
INNER JOIN memo_estado AS me ON me.memo_estado_depto_id = dtu.dpto_tiene_usu_depto_id
WHERE usu.usuario_id = usuario AND dtu.dpto_tiene_usu_principal = 1 AND me.memo_estado_memo_estadogenerico_id = 2;

SET pagina = CONCAT(' LIMIT ',inicio,',',fin);

	IF deptosol <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF anio <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_anio=',anio);
	END IF;

	IF mes <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND MONTH(mm.memo_fecha_memo) = ',mes);
	END IF;

	IF numdoc  <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_num_memo=',numdoc );
	END IF;

	IF usuasigna <> 0 THEN 
		SET agregajoin = ' LEFT JOIN asigna_usuario AS asu ON asu.asigna_usuario_memo_id = mm.memo_id 
											 LEFT JOIN estado_asignacion AS ea ON ea.estado_asignacion_id = asu.asigna_usuario_estado_asignacion_id ';
		SET filtromemo = concat(filtromemo,' AND asu.asigna_usuario_usuario_id=',usuasigna );
		SET campo1 = 'asu.asigna_usuario_usuario_id';
		SET campo2 = 'asu.asigna_usuario_fecha';
		SET campo3 = 'ea.estado_asignacion_texto';
	END IF;

SET maximos = CONCAT('SELECT estado_max(mm.memo_id,',usuario,') AS estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_memo, 
			mm.memo_materia, mm.memo_depto_solicitante_id, ',campo1,' AS asigna_usu_usuario_id , ',campo2,' AS asigna_usu_fecha, ',campo3,' AS asigna_usu_estado
					FROM memo as mm 
					LEFT JOIN memo_derivado AS md ON md.memo_derivado_memo_id = mm.memo_id ',agregajoin,' WHERE md.memo_derivado_dpto_id in (87) ',filtromemo);

	SET @consulta = CONCAT('SELECT estado_max_id,memo_id, memo_num_memo, memo_anio,
							memo_fecha_memo, memo_materia, memo_depto_solicitante_id, 
							dep.depto_nombre, met.memo_estado_tipo, met.memo_estado_color_bg, met.memo_estado_color_font, 
							cei.cambio_estados_memo_estado_id,cei.cambio_estados_observacion, cei.cambio_estados_fecha,
							DATEDIFF(CURDATE(), cei.cambio_estados_fecha) as cambio_estados_dias, cei.cambio_estados_usuario_id, met.memo_estado_memo_estadogenerico_id,
							(SELECT cambio_estados_fecha FROM cambio_estados WHERE cambio_estados_memo_id=memo_id AND cambio_estados_memo_estado_id = ',estado_recepcion,'  ORDER BY cambio_estados_fecha DESC LIMIT 1) AS fecha_recepcion_unidad,
							asigna_usu_usuario_id, us.usuario_nombre, asigna_usu_fecha, asigna_usu_estado
			FROM (',maximos,') AS TABLA_MEM_MAX
			LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
			LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
			INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id
			LEFT JOIN usuario as us ON us.usuario_id=asigna_usu_usuario_id');

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id=',estado);
	END IF;
	IF estadonot <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id NOT IN (',estadonot,')');
	END IF;

	SET @consulta = concat(@consulta,orden);
	SET @consulta = concat(@consulta,pagina);

	/*select @consulta;*/

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `listado_memo_por_estadomax_depto` (IN `deptosol` INT, IN `deptodes` INT, IN `estado` INT, IN `inicio` INT, IN `fin` INT, IN `usuario` INT, IN `anio` INT, IN `mes` INT, IN `numdoc` INT, IN `dptoid` VARCHAR(30), IN `estadonot` VARCHAR(6))  BEGIN
DECLARE maximos VARCHAR(2000);
DECLARE consulta VARCHAR (2000);
DECLARE filtromemo VARCHAR(2000)DEFAULT ' ';
DECLARE filtro VARCHAR(2000)DEFAULT ' WHERE 1 = 1 ';
DECLARE orden VARCHAR(1000) DEFAULT ' ORDER BY cambio_estados_dias ASC, memo_fecha_recepcion ASC, memo_fecha_memo DESC';
DECLARE pagina VARCHAR (50);
DECLARE estado_recepcion int;

SELECT me.memo_estado_id INTO estado_recepcion
FROM usuario as usu
INNER JOIN dpto_tiene_usu AS dtu ON dtu.dpto_tiene_usu_usuario_id = usu.usuario_id
INNER JOIN memo_estado AS me ON me.memo_estado_depto_id = dtu.dpto_tiene_usu_depto_id
WHERE usu.usuario_id = usuario AND dtu.dpto_tiene_usu_principal = 1 AND me.memo_estado_memo_estadogenerico_id = 2;

SET pagina = CONCAT(' LIMIT ',inicio,',',fin);

	IF deptosol <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF deptodes <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_destinatario_id = ',deptodes);
	END IF;

	IF anio <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_anio=',anio);
	END IF;

	IF mes <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND MONTH(mm.memo_fecha_memo) = ',mes);
	END IF;

	IF numdoc  <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_num_memo=',numdoc );
	END IF;

SET maximos = CONCAT('SELECT DISTINCT estado_max(mm.memo_id,',usuario,') as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, 
mm.memo_fecha_recepcion, mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id 
FROM memo as mm INNER JOIN cambio_estados AS ce ON ce.cambio_estados_memo_id = mm.memo_id 
WHERE 1=1 AND ce.cambio_estados_usuario_id = ',usuario,filtromemo,' UNION SELECT estado_max(mm.memo_id,',usuario,') as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
FROM memo as mm LEFT JOIN memo_derivado AS md ON md.memo_derivado_memo_id = mm.memo_id WHERE md.memo_derivado_dpto_id in (',dptoid ,') ',filtromemo);

	SET @consulta = CONCAT('SELECT estado_max_id,memo_id, memo_num_memo, memo_anio, memo_fecha_recepcion, 
							memo_fecha_memo, memo_materia, memo_fecha_ingreso, memo_depto_solicitante_id, memo_depto_destinatario_id,
							dep.depto_nombre, dep2.depto_nombre as depto_nombre_dest, met.memo_estado_tipo, met.memo_estado_color_bg, met.memo_estado_color_font, 
							cei.cambio_estados_memo_estado_id,cei.cambio_estados_observacion, cei.cambio_estados_fecha,
							DATEDIFF(CURDATE() ,cei.cambio_estados_fecha) as cambio_estados_dias, cei.cambio_estados_usuario_id, met.memo_estado_memo_estadogenerico_id,
							(SELECT cambio_estados_fecha FROM cambio_estados WHERE cambio_estados_memo_id=memo_id AND cambio_estados_memo_estado_id = ',estado_recepcion,' ) AS fecha_recepcion_unidad
			FROM (',maximos,') AS TABLA_MEM_MAX
			LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
			LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
			INNER JOIN departamento as dep2 ON dep2.depto_id = memo_depto_destinatario_id
			INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id ');

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id=',estado);
	END IF;
	IF estadonot <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id NOT IN (',estadonot,')');
	END IF;

	SET @consulta = concat(@consulta,orden);
	SET @consulta = concat(@consulta,pagina);

	/*select @consulta;*/

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `total_listado_memos_estado_depto` (IN `deptosol` INT, IN `deptodes` INT, IN `estado` INT, IN `usuario` INT, IN `anio` INT, IN `mes` INT, IN `numdoc` INT, IN `dptoid` VARCHAR(30), IN `estadonot` VARCHAR(6))  BEGIN
DECLARE maximos VARCHAR(2000);
DECLARE consulta VARCHAR (2000);
DECLARE filtromemo VARCHAR(2000)DEFAULT ' ';
DECLARE filtro VARCHAR(2000)DEFAULT ' WHERE 1 = 1 ';

	IF deptosol <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF deptodes <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_destinatario_id  = ',deptodes);
	END IF;

	IF anio <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_anio=',anio);
	END IF;

	IF mes <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND MONTH(mm.memo_fecha_memo) = ',mes);
	END IF;

	IF numdoc  <> 0 THEN
			SET filtromemo = concat(filtromemo,' AND mm.memo_num_memo=',numdoc );
	END IF;

	SET maximos = CONCAT('SELECT DISTINCT estado_max(mm.memo_id,',usuario,') as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, 
	mm.memo_fecha_recepcion, mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id 
	FROM memo as mm INNER JOIN cambio_estados AS ce ON ce.cambio_estados_memo_id = mm.memo_id 
	WHERE 1=1 AND ce.cambio_estados_usuario_id = ',usuario,filtromemo,' UNION SELECT estado_max(mm.memo_id,',usuario,') as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_recepcion,
					 mm.memo_fecha_memo, mm.memo_materia, mm.memo_fecha_ingreso, mm.memo_depto_solicitante_id, mm.memo_depto_destinatario_id
	FROM memo as mm LEFT JOIN memo_derivado AS md ON md.memo_derivado_memo_id = mm.memo_id WHERE md.memo_derivado_dpto_id in (',dptoid ,') ',filtromemo);

	SET @consulta = CONCAT('SELECT count(*) AS cantidad FROM (',maximos,') AS TABLA_MEM_MAX 
							LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
							LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
							INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id ');

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id=',estado);
	END IF;
	IF estadonot <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id NOT IN (',estadonot,')');
	END IF;

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `total_listado_memos_estado_depto_adquisiciones` (IN `deptosol` INT, IN `estado` INT, IN `usuario` INT, IN `anio` INT, IN `mes` INT, IN `numdoc` INT, IN `usuasigna` INT, IN `estadonot` VARCHAR(6))  BEGIN
DECLARE maximos VARCHAR(2000);
DECLARE consulta VARCHAR (2000);
DECLARE filtromemo VARCHAR(2000)DEFAULT ' ';
DECLARE filtro VARCHAR(2000)DEFAULT ' WHERE 1 = 1 ';
DECLARE agregajoin VARCHAR(2000)DEFAULT ' ';
DECLARE campo1 varchar(30) default '(NULL)';
DECLARE campo2 varchar(30) default '(NULL)';

	IF deptosol <> 1 THEN
		SET filtromemo = CONCAT(filtromemo,' AND mm.memo_depto_solicitante_id = ',deptosol);
	END IF;

	IF anio <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND mm.memo_anio=',anio);
	END IF;

	IF mes <> 0 THEN
		SET filtromemo = concat(filtromemo,' AND MONTH(mm.memo_fecha_memo) = ',mes);
	END IF;

	IF numdoc  <> 0 THEN
			SET filtromemo = concat(filtromemo,' AND mm.memo_num_memo=',numdoc );
	END IF;

	/*IF usuasigna <> 0 THEN 
		SET filtromemo = concat(filtromemo,' AND asu.asigna_usuario_usuario_id=',usuasigna );
	END IF;*/

	IF usuasigna <> 0 THEN 
		SET agregajoin = ' LEFT JOIN asigna_usuario AS asu ON asu.asigna_usuario_memo_id = mm.memo_id ';
		SET filtromemo = concat(filtromemo,' AND asu.asigna_usuario_usuario_id=',usuasigna );
		SET campo1 = 'asu.asigna_usuario_usuario_id';
		SET campo2 = 'asu.asigna_usuario_fecha';
	END IF;

	SET maximos = CONCAT('SELECT estado_max(mm.memo_id,',usuario,') AS estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_memo, 
			mm.memo_materia, mm.memo_depto_solicitante_id, ',campo1,' AS asigna_usu_usuario_id , ',campo2,' AS asigna_usu_fecha
					FROM memo as mm 
					LEFT JOIN memo_derivado AS md ON md.memo_derivado_memo_id = mm.memo_id ',agregajoin,' WHERE md.memo_derivado_dpto_id in (87) ',filtromemo);

	/*SET maximos = CONCAT('SELECT estado_max(mm.memo_id,',usuario,') as estado_max_id, mm.memo_id, mm.memo_num_memo, mm.memo_anio, mm.memo_fecha_memo, 
			mm.memo_materia, mm.memo_depto_solicitante_id, asu.asigna_usuario_usuario_id, asu.asigna_usuario_fecha
					FROM memo as mm 
					LEFT JOIN memo_derivado AS md ON md.memo_derivado_memo_id = mm.memo_id 
					LEFT JOIN asigna_usuario AS asu ON asu.asigna_usuario_memo_id = mm.memo_id 
					WHERE md.memo_derivado_dpto_id in (87) ',filtromemo);*/

	SET @consulta = CONCAT('SELECT count(*) AS cantidad FROM (',maximos,') AS TABLA_MEM_MAX 
							LEFT JOIN cambio_estados as cei ON cei.cambio_estados_id = estado_max_id
							LEFT JOIN memo_estado as met ON met.memo_estado_id = cambio_estados_memo_estado_id
							INNER JOIN departamento as dep ON dep.depto_id = memo_depto_solicitante_id ');

	SET @consulta = CONCAT(@consulta,filtro);

	IF estado <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id=',estado);
	END IF;
	IF estadonot <> 0 THEN
		SET @consulta = concat(@consulta,' AND cambio_estados_memo_estado_id NOT IN (',estadonot,')');
	END IF;

	PREPARE smpt FROM @consulta;
	EXECUTE smpt;
	DEALLOCATE PREPARE smpt;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `estado_max` (`memid` INT, `usuario` INT) RETURNS INT(11) BEGIN
	DECLARE estado_max_id int;
	DECLARE usudeptoid int;

	SELECT dtu.dpto_tiene_usu_depto_id INTO usudeptoid
	FROM usuario as usu
	INNER JOIN dpto_tiene_usu AS dtu ON dtu.dpto_tiene_usu_usuario_id = usu.usuario_id
	WHERE usu.usuario_id = usuario
	AND dtu.dpto_tiene_usu_principal = 1;

	IF usudeptoid <> 1  THEN
		SELECT max(cambio_estados_id) INTO estado_max_id	
		FROM cambio_estados
		WHERE cambio_estados_memo_id = memid
		AND cambio_estados_memo_estado_id in(SELECT me.memo_estado_id 
																				FROM memo_estado as me
																				WHERE me.memo_estado_depto_id=usudeptoid);
	ELSE
		SELECT max(cambio_estados_id) INTO estado_max_id	
		FROM cambio_estados
		WHERE cambio_estados_memo_id = memid;
	END IF;

	RETURN estado_max_id;
END$$

DELIMITER ;

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

--
-- Volcado de datos para la tabla `asigna_dificultad`
--

INSERT INTO `asigna_dificultad` (`asigna_dificultad_id`, `asigna_dificultad_texto`) VALUES
(1, 'Alta'),
(2, 'Media'),
(3, 'Baja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asigna_prioridad`
--

CREATE TABLE `asigna_prioridad` (
  `asigna_prioridad_id` int(11) NOT NULL,
  `asigna_prioridad_texto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asigna_prioridad`
--

INSERT INTO `asigna_prioridad` (`asigna_prioridad_id`, `asigna_prioridad_texto`) VALUES
(1, 'Inmediata'),
(2, 'Urgente'),
(3, 'Alta'),
(4, 'Normal'),
(5, 'Baja');

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
  `asigna_usuario_asigna_dificultad_id` int(11) NOT NULL,
  `asigna_usuario_ultimamod` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asigna_usuario`
--

INSERT INTO `asigna_usuario` (`asigna_usuario_id`, `asigna_usuario_memo_id`, `asigna_usuario_usuario_id`, `asigna_usuario_comentario`, `asigna_usuario_estado_asignacion_id`, `asigna_usuario_fecha`, `asigna_usuario_asigna_prioridad_id`, `asigna_usuario_asigna_dificultad_id`, `asigna_usuario_ultimamod`) VALUES
(1, 4, 4, 'Favor cursar segun materia', 3, '2019-09-04 23:47:11', 4, 2, '2019-09-04 21:27:17'),
(2, 20, 2, 'ver', 3, '2019-09-04 23:47:37', 4, 2, '2019-09-04 21:30:01'),
(3, 1, 7, 'ver', 1, '2019-09-04 23:47:56', 1, 2, '2019-09-04 19:47:56'),
(4, 3, 4, 'ver', 3, '2019-09-04 23:54:12', 2, 1, '2019-09-04 21:09:43'),
(5, 3, 7, 'ver', 3, '2019-09-04 23:54:22', 3, 2, '2019-09-04 20:53:22'),
(6, 3, 2, 'ver', 3, '2019-09-03 23:54:28', 4, 2, '2019-09-04 20:04:18'),
(7, 4, 2, 'ver', 3, '2019-09-05 01:13:25', 4, 2, '2019-09-04 21:26:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asocia_resolucion`
--

CREATE TABLE `asocia_resolucion` (
  `asocia_resolucion_id` int(11) NOT NULL,
  `asocia_resolucion_memo_id` int(11) NOT NULL,
  `asocia_resolucion_res_id` int(11) NOT NULL,
  `asocia_resolucion_res_url` varchar(300) NOT NULL,
  `asocia_resolucion_res_anio` int(11) NOT NULL,
  `asocia_resolucion_res_num` varchar(15) NOT NULL,
  `asocia_resolucion_res_cat_cod` varchar(10) NOT NULL,
  `asocia_resolucion_res_fecha` date NOT NULL,
  `asocia_resolucion_res_fecha_pub` datetime NOT NULL,
  `asocia_resolucion_fecha_agregacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `asocia_resolucion_comentario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `asocia_resolucion`
--

INSERT INTO `asocia_resolucion` (`asocia_resolucion_id`, `asocia_resolucion_memo_id`, `asocia_resolucion_res_id`, `asocia_resolucion_res_url`, `asocia_resolucion_res_anio`, `asocia_resolucion_res_num`, `asocia_resolucion_res_cat_cod`, `asocia_resolucion_res_fecha`, `asocia_resolucion_res_fecha_pub`, `asocia_resolucion_fecha_agregacion`, `asocia_resolucion_comentario`) VALUES
(1, 3, 47461, 'http://resoluciones2.umce.cl/adjunto/2019_N_100100_Res_Ex autoriza la transferencia de carrera a Camila Ignacia Paz Guajardo Lizada.pdf', 2019, '100100', 'sc020', '2019-01-25', '2019-01-29 12:19:22', NULL, ''),
(2, 4, 47461, 'http://resoluciones2.umce.cl/adjunto/2019_N_100100_Res_Ex autoriza la transferencia de carrera a Camila Ignacia Paz Guajardo Lizada.pdf', 2019, '100100', 'sc020', '2019-01-25', '2019-01-29 12:19:22', NULL, ''),
(3, 20, 47463, 'http://resoluciones2.umce.cl/adjunto/2019_N_100102_Res_Ex autoriza rebaja de carga academica fuera de plazo a Camilo Ignacio Valdes Pulgar.pdf', 2019, '100102', 'sc020', '2019-01-25', '2019-01-29 12:22:00', NULL, '');

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

--
-- Volcado de datos para la tabla `cambio_estados`
--

INSERT INTO `cambio_estados` (`cambio_estados_id`, `cambio_estados_memo_id`, `cambio_estados_memo_estado_id`, `cambio_estados_observacion`, `cambio_estados_usuario_id`, `cambio_estados_fecha`) VALUES
(1, 1, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-01 14:48:08'),
(2, 1, 5, 'Revisar', 3, '2019-07-01 15:01:58'),
(3, 1, 32, 'Revisar', 3, '2019-07-01 15:01:58'),
(4, 2, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-01 15:04:50'),
(5, 3, 31, 'Documento nuevo ingresado por usuario', 5, '2019-07-01 19:44:31'),
(6, 4, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-01 19:48:03'),
(7, 4, 4, 'Revisar para aprobación', 3, '2019-07-02 15:44:17'),
(8, 4, 8, 'Aprobado para enviar  a ppto', 3, '2019-07-02 15:46:14'),
(9, 4, 11, 'Revisar segun memo 2233', 3, '2019-07-02 15:47:36'),
(10, 4, 12, 'Aprobado enviar a Adquisiciones', 3, '2019-07-02 15:49:57'),
(15, 4, 14, 'Cursar segun detalle', 3, '2019-07-02 17:00:06'),
(16, 4, 17, 'Cursar segun detalle', 3, '2019-07-02 17:00:07'),
(20, 3, 35, 'Revisar para comprar', 5, '2019-07-04 15:32:29'),
(21, 3, 2, 'Revisar para comprar', 5, '2019-07-04 15:32:29'),
(22, 2, 5, 'Revisar esto por favor', 3, '2019-07-04 15:34:22'),
(23, 2, 32, 'Revisar esto por favor', 3, '2019-07-04 15:34:22'),
(24, 1, 35, 'Esto es correcto ver su compra', 5, '2019-07-04 15:35:41'),
(25, 1, 2, 'Esto es correcto ver su compra', 5, '2019-07-04 15:35:41'),
(26, 1, 4, 'En espera de aprobación del Director', 3, '2019-07-04 15:37:05'),
(27, 1, 8, 'Aprobado enviar a PPTO', 3, '2019-07-04 15:37:29'),
(28, 1, 11, 'Revisar para comprar', 3, '2019-07-04 15:38:22'),
(29, 1, 12, 'aprobado para enviar a adquisiciones', 3, '2019-07-04 15:41:43'),
(30, 1, 14, 'Favor Cursar compra', 3, '2019-07-04 16:01:58'),
(31, 1, 17, 'Favor Cursar compra', 3, '2019-07-04 16:01:58'),
(32, 5, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-04 19:44:19'),
(33, 6, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-04 19:46:38'),
(34, 3, 4, 'Para revision', 3, '2019-07-08 21:56:20'),
(35, 5, 5, 'Derivado para revision', 3, '2019-07-09 16:02:46'),
(36, 7, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-09 21:35:02'),
(38, 7, 5, 'Para su revision', 3, '2019-07-09 22:37:14'),
(39, 7, 6, 'ya se reviso', 3, '2019-07-09 22:38:11'),
(40, 8, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-10 15:05:43'),
(41, 9, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-10 16:03:48'),
(42, 9, 3, 'malo', 3, '2019-07-10 16:04:39'),
(43, 10, 1, 'Documento nuevo ingresado por usuario', 3, '2019-07-10 16:05:34'),
(44, 11, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 16:46:33'),
(45, 12, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 16:47:18'),
(46, 13, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:00:05'),
(47, 14, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:01:34'),
(48, 15, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:12:03'),
(49, 16, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:14:08'),
(50, 17, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:17:24'),
(51, 18, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:18:12'),
(52, 19, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-11 20:22:31'),
(53, 6, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:37'),
(54, 16, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:37'),
(55, 17, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:38'),
(56, 18, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:38'),
(57, 19, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:38'),
(58, 12, 4, 'Para revision en DAF', 3, '2019-07-11 21:37:38'),
(59, 16, 8, 'Aprobado con observacion, enviar a informatica para su revision', 3, '2019-07-12 19:21:16'),
(60, 16, 5, 'Revisar si esto se puede realizar', 3, '2019-07-12 19:21:45'),
(61, 16, 32, 'Revisar si esto se puede realizar', 3, '2019-07-12 19:21:46'),
(62, 16, 34, 'En revision', 5, '2019-07-12 19:22:32'),
(63, 16, 38, 'Si se puede comprar, esta ok', 5, '2019-07-12 19:25:10'),
(64, 16, 40, 'Esta ok, ', 5, '2019-07-12 19:26:46'),
(65, 2, 34, 'Revisar', 5, '2019-07-12 20:08:12'),
(66, 3, 8, 'Cursar PPTO', 3, '2019-07-22 20:41:35'),
(67, 12, 8, 'Cursar PPTO', 3, '2019-07-22 20:49:06'),
(68, 19, 8, 'Cursar ppto', 3, '2019-07-22 21:52:47'),
(69, 18, 5, 'Revisar si esto se puede comprar', 3, '2019-07-22 22:31:50'),
(70, 18, 32, 'Revisar si esto se puede comprar', 3, '2019-07-22 22:31:50'),
(71, 20, 31, 'Documento nuevo ingresado por usuario', 5, '2019-07-23 16:03:45'),
(72, 21, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-23 16:10:26'),
(73, 21, 4, 'Revisar', 3, '2019-07-23 16:11:04'),
(74, 21, 5, 'Revisar si esta compra se puede realizar', 3, '2019-07-23 16:12:37'),
(75, 21, 32, 'Revisar si esta compra se puede realizar', 3, '2019-07-23 16:12:37'),
(76, 20, 35, 'Vafor revisar y cursar', 5, '2019-07-23 16:17:44'),
(77, 20, 2, 'Vafor revisar y cursar', 5, '2019-07-23 16:17:45'),
(78, 20, 4, 'revisar', 3, '2019-07-23 16:18:28'),
(79, 21, 34, 'En revision', 5, '2019-07-23 16:28:01'),
(80, 8, 5, 'revisar', 3, '2019-07-24 14:43:02'),
(81, 8, 32, 'revisar', 3, '2019-07-24 14:43:02'),
(82, 3, 11, 'Revisar para cursar', 3, '2019-07-24 15:36:46'),
(83, 19, 11, 'Revisar para cursar', 3, '2019-07-24 15:36:47'),
(84, 12, 11, 'Revisar para cursar', 3, '2019-07-24 15:36:47'),
(85, 7, 4, 'revisar', 3, '2019-07-24 15:38:18'),
(86, 7, 7, 'Se reviso y se archiva', 3, '2019-07-24 15:38:29'),
(87, 3, 12, 'Aprobados enviar a Adquisiciones', 3, '2019-07-24 15:52:09'),
(88, 19, 12, 'Aprobados enviar a Adquisiciones', 3, '2019-07-24 15:52:10'),
(89, 12, 12, 'Aprobados enviar a Adquisiciones', 3, '2019-07-24 15:52:10'),
(90, 3, 14, 'Favor Cursar', 3, '2019-07-24 15:52:45'),
(91, 3, 17, 'Favor Cursar', 3, '2019-07-24 15:52:45'),
(94, 19, 14, 'Favor Cursar', 3, '2019-07-24 16:13:39'),
(95, 19, 17, 'Favor Cursar', 3, '2019-07-24 16:13:39'),
(97, 20, 8, 'Memos aprobados', 3, '2019-07-24 20:02:17'),
(98, 6, 8, 'Memos aprobados', 3, '2019-07-24 20:02:17'),
(99, 17, 8, 'Memos aprobados', 3, '2019-07-24 20:02:17'),
(100, 6, 11, 'cursar', 3, '2019-07-24 20:05:40'),
(101, 17, 11, 'cursar', 3, '2019-07-24 20:05:40'),
(102, 20, 11, 'cursar', 3, '2019-07-24 20:05:40'),
(103, 6, 12, 'Aprobado enviar a Adquisiciones', 3, '2019-07-24 20:07:17'),
(104, 17, 12, 'Aprobado enviar a Adquisiciones', 3, '2019-07-24 20:07:17'),
(105, 20, 12, 'Aprobado enviar a Adquisiciones', 3, '2019-07-24 20:07:17'),
(106, 6, 14, 'Cursar', 3, '2019-07-24 20:50:27'),
(107, 6, 17, 'Cursar', 3, '2019-07-24 20:50:27'),
(108, 17, 14, 'Cursar', 3, '2019-07-24 20:50:27'),
(109, 17, 17, 'Cursar', 3, '2019-07-24 20:50:27'),
(110, 12, 14, 'Cursar', 3, '2019-07-24 20:50:27'),
(111, 12, 17, 'Cursar', 3, '2019-07-24 20:50:27'),
(112, 20, 14, 'Cursar', 3, '2019-07-24 20:50:27'),
(113, 20, 17, 'Cursar', 3, '2019-07-24 20:50:27'),
(114, 22, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-31 16:05:25'),
(115, 23, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-31 16:06:22'),
(116, 24, 2, 'Documento recibido e ingresado por usuario', 3, '2019-07-31 16:07:40'),
(117, 24, 4, 'Para revisión', 3, '2019-07-31 16:09:18'),
(118, 23, 4, 'Para revisión', 3, '2019-07-31 16:09:18'),
(119, 22, 4, 'Para revisión', 3, '2019-07-31 16:09:18'),
(126, 24, 5, 'Generar cotizacion para monto del CDP', 3, '2019-08-07 20:17:46'),
(127, 24, 17, 'Generar cotizacion para monto del CDP', 3, '2019-08-07 20:17:46'),
(128, 23, 8, 'Enviar a PPTO', 3, '2019-08-13 18:13:59'),
(129, 23, 11, 'Cursar', 3, '2019-08-13 18:14:21'),
(130, 23, 12, 'aprobado por ppto, enviar a adquisi', 3, '2019-08-13 18:14:50'),
(131, 23, 14, 'Cursar', 3, '2019-08-13 18:15:02'),
(132, 23, 17, 'Cursar', 3, '2019-08-13 18:15:02'),
(142, 4, 26, 'Asignado a usuario : Jorge', 2, '2019-09-04 23:47:11'),
(143, 20, 26, 'Asignado a usuario : María José Garcés', 2, '2019-09-04 23:47:37'),
(144, 1, 26, 'Asignado a usuario : Lorena ', 2, '2019-09-04 23:47:57'),
(145, 3, 26, 'Asignado a usuario : Jorge', 2, '2019-09-04 23:54:12'),
(146, 3, 26, 'Asignado a usuario : Lorena ', 2, '2019-09-04 23:54:22'),
(147, 3, 26, 'Asignado a usuario : María José Garcés', 2, '2019-09-04 23:54:28'),
(150, 3, 27, 'Ingreso de datos al memo', 4, '2019-09-05 01:09:43'),
(151, 4, 26, 'Asignado a usuario : María José Garcés', 2, '2019-09-05 01:13:25'),
(155, 4, 27, 'Ingreso de datos al memo', 2, '2019-09-05 01:26:47'),
(156, 20, 27, 'Ingreso de datos al memo', 2, '2019-09-05 01:30:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cambio_estados_detmemo`
--

CREATE TABLE `cambio_estados_detmemo` (
  `cambio_estados_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_estado_detmemo_id` int(11) NOT NULL,
  `cambio_estados_detmemo_observacion` varchar(255) NOT NULL,
  `cambio_estados_detmemo_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cambio_estados_detmemo_usu_id` int(11) NOT NULL
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

--
-- Volcado de datos para la tabla `centro_costos`
--

INSERT INTO `centro_costos` (`cc_codigo`, `cc_nombre`, `cc_tipo`, `cc_dependencia_codigo`, `cc_estado`) VALUES
(0, 'n/a', 'PROPIO', 1000000, 0),
(1001100, 'RECTORIA', 'PROPIO', 1001000, 1),
(1001101, 'RECTORIA APORTES', 'PROPIO', 1001000, 1),
(1002100, 'PRORRECTORIA', 'PROPIO', 1002000, 1),
(1002101, 'DIRECCION DE EDUCACION CONTINUA', 'PROPIO', 1002000, 1),
(1002104, 'DIRECCION DE VINCULACION CON EL MEDIO', 'PROPIO', 1002000, 1),
(1002200, 'DIRECCION DE RELACIONES INSTITUCIONALES', 'PROPIO', 1002000, 1),
(1003100, 'SECRETARIA GENERAL', 'PROPIO', 1003000, 1),
(1003101, 'CEREMONIAS DE TITULACION', 'PROPIO', 1003000, 1),
(1003200, 'DEPTO JURIDICO', 'PROPIO', 1003000, 1),
(1003300, 'SUBDEPTO DE TITULOS Y GRADOS', 'PROPIO', 1003000, 1),
(1003400, 'SECCION PARTES Y ARCHIVOS', 'PROPIO', 1003000, 1),
(1004100, 'CONTRALORIA INTERNA', 'PROPIO', 1004000, 1),
(1005100, 'DIRECCION DE PLANIFICACION Y PRESUPUESTO', 'PROPIO', 1005000, 1),
(1005110, 'UNIDAD DE ANALISIS INSTITUCIONAL', 'PROPIO', 1005000, 1),
(1005114, 'PROY MECESUP CUENTA RESERVA', 'PROYECTO', 1005000, 1),
(1005119, 'PROY UMC1111', 'PROYECTO', 1005000, 1),
(1005120, 'PROY FDI KINE', 'PROYECTO', 1005000, 1),
(1005121, 'PROY FDI DAC', 'PROYECTO', 1005000, 1),
(1005122, 'PROY FDI DAE', 'PROYECTO', 1005000, 1),
(1005123, 'PROY. FB UM1498', 'PROYECTO', 1005000, 1),
(1005124, 'PROY UMC1756 IMP.PLAN PLURIANUAL CUOTA 2 2017', 'PROYECTO', 1005000, 1),
(1005126, 'PROY UMC1404', 'PROYECTO', 1005000, 1),
(1005127, 'PROY. PM UMC1406', 'PROYECTO', 1005000, 1),
(1005128, 'PROY FDI TALLERES RIZOMA', 'PROYECTO', 1005000, 1),
(1005129, 'PROY FDI TALLERES DE GRABADO LICEO A-5', 'PROYECTO', 1005000, 1),
(1005130, 'PROY FDI INVERNADERO PLANTAS MEDICINALES', 'PROYECTO', 1005000, 1),
(1005131, 'PROY FDI CRA EST. MATEMATICAS', 'PROYECTO', 1005000, 1),
(1005132, 'PROY FDI PROG. VIVA LA DIFERENCIA', 'PROYECTO', 1005000, 1),
(1005133, 'PROY PMI UMC1501', 'PROYECTO', 1005000, 1),
(1005134, 'PROY CM UM1555', 'PROYECTO', 1005000, 1),
(1005135, 'PROY UMC1503 FDI PROPEDEUTICO MUSICAL', 'PROYECTO', 1005000, 1),
(1005136, 'PROY UMC1504 FDI PRACTICAS FISICAS INCLUSIVAS', 'PROYECTO', 1005000, 1),
(1005137, 'PROY UMC1506 FDI MOD GESTION BIBLIOTECA', 'PROYECTO', 1005000, 1),
(1005138, 'PROY UMC1556 CONVENIO PILOTO', 'PROYECTO', 1005000, 1),
(1005139, 'BNA UMC1507', 'PROYECTO', 1005000, 1),
(1005140, 'PROY UMC1655 PLAN PLURIANUAL', 'PROYECTO', 1005000, 1),
(1005141, 'PROY UMC1656 1ER AÑO PLAN PLURIANUAL 2016-2020 UMC', 'PROYECTO', 1005000, 1),
(1005142, 'PROY FDI UMC1601 ESTRATEGIAS INNOVADORAS', 'PROYECTO', 1005000, 1),
(1005143, 'PROY FDI UMC1602 CONSTRUYENDO IGUALDAD DE OPORT', 'PROYECTO', 1005000, 1),
(1005144, 'PROY FDI UMC1603 TALLERES RIZOMA', 'PROYECTO', 1005000, 1),
(1005145, 'PROY FDI UMC1605 TALLARES DE GRABADO LICEO A-5', 'PROYECTO', 1005000, 1),
(1005146, 'PROY FDI UMC1607 DOCENTES QUE SE LA JUEGAN', 'PROYECTO', 1005000, 1),
(1005147, 'PROY UMC1755 IMPLEMENT PLAN PLURIANUAL  CUOTA 1', 'PROYECTO', 1005000, 1),
(1005148, 'PROY UMC1756 IMP.PLAN PLURIANUAL CUOTA 2 2017', 'PROYECTO', 1005000, 0),
(1005201, 'PROY/UMC1799 PLAN DE FORT.UNIV.ESTATALES', 'PROYECTO', 1005000, 1),
(1005202, 'PROY UMC1299', 'PROYECTO', 1005000, 1),
(1005203, 'PROY PM UMC1406', 'PROYECTO', 1005000, 0),
(1005205, 'PROY CM UMC1555', 'PROYECTO', 1005000, 0),
(1005207, 'PROY CM UMC1655', 'PROYECTO', 1005000, 0),
(1005212, 'PROY FDI  UMC1605', 'PROYECTO', 1005000, 0),
(1005214, 'PROY CM UMC1755', 'PROYECTO', 1005000, 0),
(1005215, 'PROY CM UMC1855 PLAN PLURIANUAL 3 AÑO', 'PROYECTO', 1005000, 1),
(1005216, 'PROY UMC1804 SEMILLERO LUDICO FDI ESTUDIANTIL', 'PROYECTO', 1005000, 1),
(1005217, 'PROY CM UMC1856 UNIVERSIDADES ESTATALES AÑO 2018', 'PROYECTO', 1005000, 1),
(1005218, 'PROY CM UMC1857 PARA UES, MEJ. LA CALIDAD AÑO 2018', 'PROYECTO', 1005000, 1),
(1006100, 'VICERRECTORIA ACADEMICA', 'PROPIO', 1006000, 1),
(1006101, 'DIRECCION DE ASEGURAMIENTO DE  LA CALIDAD', 'PROPIO', 1006000, 1),
(1006102, 'CENTRO DE FORMACION VIRTUAL', 'PROPIO', 1006000, 1),
(1006103, 'PROCESO DE ACREDITACION', 'PROPIO', 1006000, 1),
(1006104, 'UNIDAD SIMEDPRO', 'PROPIO', 1006000, 1),
(1006108, 'PROY PACE 2017', 'PROYECTO', 1006000, 1),
(1006109, 'PROY PACE 2018', 'PROYECTO', 1006000, 1),
(1006200, 'DIRECCION DE DOCENCIA', 'PROPIO', 1006000, 1),
(1006201, 'PROCESO DE MATRICULA', 'PROPIO', 1006000, 1),
(1006202, 'PROGRAMA PROPEDEUTICO', 'PROPIO', 1006000, 1),
(1006300, 'DIRECCION DE INVESTIGACION', 'PROPIO', 1006000, 1),
(1006301, 'FONDOS CENTRALES DE INVESTIGACION', 'PROPIO', 1006000, 1),
(1006302, 'PROY FONDECYT-CONICYT', 'PROYECTO', 1006000, 1),
(1006303, 'PROY COPEC-UC', 'PROYECTO', 1006000, 1),
(1006309, 'PROY INACH', 'PROYECTO', 1006000, 1),
(1006313, 'PROY FIC-R ELEBORACION NANOBIOMATERIALES', 'PROYECTO', 1006000, 1),
(1006314, 'PROY PROF. PROFESORES/ENTRENADORES', 'PROYECTO', 1006000, 1),
(1006400, 'DIRECCION DE EXTENCION Y COMUNICACIONES', 'PROPIO', 1006000, 1),
(1006401, 'FONDO CENTRALES DE EXTENSION', 'PROPIO', 1006000, 1),
(1006402, 'FONDO EDITORIAL', 'PROPIO', 1006000, 1),
(1006403, 'PROY FONDEF PICALAB TOMAS THAYER', 'PROYECTO', 1006000, 1),
(1006404, 'WEB MARKETING', 'PROPIO', 1006000, 1),
(1006500, 'DEPTO DE MEDIOS EDUCATIVOS', 'PROPIO', 1006000, 1),
(1006501, 'SUBDEPTO DE IMPRESIONES', 'PROPIO', 1006000, 1),
(1006600, 'BIBLIOTECA CENTRAL', 'PROPIO', 1006000, 1),
(1006700, 'SUBDEPTO DE ADMISION Y REGISTRO CURRICULAR', 'PROPIO', 1006000, 1),
(1006800, 'COORDINACION DE PRACTICA PROFESIONAL', 'PROPIO', 1006000, 1),
(1006911, 'PROY CURSOS DE PERFECCIONAMIENTO', 'PROYECTO', 1006000, 1),
(1006922, 'PROY PROGRAMA DE INDAGACION CIENTIFICA ICEC', 'PROYECTO', 1006000, 1),
(1006923, 'PROY UMC 1308 MOVAMONOS POR LA EDUCACION PUBLICA', 'PROYECTO', 1006000, 1),
(1006924, 'PROY ICEC 2017-2019', 'PROYECTO', 1006000, 1),
(1007100, 'DIRECCION DE POSTGRADO', 'PROPIO', 1007000, 1),
(1007101, 'MAGISTER EDUCACION MENCION CURRICULUM EDUCACIONAL', 'PROPIO', 1007000, 1),
(1007102, 'MAGISTER EDUCACION MENCION EVALUACION  EDUCACIONAL', 'PROPIO', 1007000, 1),
(1007103, 'MAGISTER EDUCACION MENCION GESTION EDUCACIONAL', 'PROPIO', 1007000, 1),
(1007104, 'MAGISTER EDUCACION MENCION PEDAGOGIA Y GESTION UNI', 'PROPIO', 1007000, 1),
(1007105, 'MAGISTER EDUCACION MENCION APRENDIZAJE DEL INGLES', 'PROPIO', 1007000, 1),
(1007106, 'MAGISTER EDUCACION DIFERENCIAL NECESIDADES MULTIPL', 'PROPIO', 1007000, 1),
(1007107, 'MAGISTER EN ESTUDIOS CLASICOS LENGUAS GRIEGA', 'PROPIO', 1007000, 1),
(1007108, 'MAGISTER EN ESTUDIOS CLASICOS CULTURA GRECO', 'PROPIO', 1007000, 1),
(1007109, 'MAGISTER EN EDUC EN SALUD Y BIENESTAR HUMANO', 'PROPIO', 1007000, 1),
(1007110, 'MAGISTER EN GESTION DEPORTIVO', 'PROPIO', 1007000, 1),
(1007111, 'MAGISTER EDUC MOTRIZ Y SALUD ADULTO MAYOR', 'PROPIO', 1007000, 1),
(1007112, 'MAGISTER NE CIENCIAS MENCION ENTOMOLOGIA', 'PROPIO', 1007000, 1),
(1007113, 'MAGISTER EN DIDACTICA DE LA LENGUA Y LA LITERATURA', 'PROPIO', 1007000, 1),
(1007200, 'DOCTORADO EN EDUCACION NO EJECUTABLE', 'PROPIO', 1007000, 0),
(1007201, 'DOCTORADO EN EDUCACION', 'PROPIO', 1007000, 1),
(1007202, 'DOCTORADO EN CIENCIAS DE LA MOTRICIDAD HUMANA', 'PROPIO', 1007000, 1),
(1007300, 'PROGRAMA DE GRADUACION EXTRAORDINARIA', 'PROPIO', 1007000, 1),
(1009100, 'DIRECCION DE ASUNTOS ESTUDIANTILES', 'PROPIO', 1009000, 1),
(1009101, 'SALA CUNA JUNJI', 'PROPIO', 1009000, 1),
(1009200, 'SUBDEPTO SERVICIOS ESTUDIANTILES', 'PROPIO', 1009000, 1),
(1009300, 'SUBDEPTO DE SALUD ESTUDIANTIL', 'PROPIO', 1009000, 1),
(1009301, 'CENTRO DE SALUD', 'PROPIO', 1009000, 1),
(1009400, 'SUBDEPTO DE DEPORTES CULTURA Y RECREACION', 'PROPIO', 1009000, 1),
(1009500, 'FEP', 'PROPIO', 1009000, 1),
(1011100, 'DIRECCION DE ADMINISTRACION Y FINANZAS', 'PROPIO', 1011000, 1),
(1011200, 'DEPTO DE FINANZAS', 'PROPIO', 1011000, 1),
(1011201, 'FONDO SOLIDARIO DE CREDITO UNIVERSITARIO', 'PROPIO', 1011000, 1),
(1011300, 'DEPTO DE RECURSOS HUMANOS', 'PROPIO', 1011000, 1),
(1011301, 'SUBDEPTO CENTRO INFANTIL', 'PROPIO', 1011000, 1),
(1011302, 'SUBDEPTO DE BIENESTAR DEL PERSONAL', 'PROPIO', 1011000, 1),
(1011400, 'DEPTO DE INFRAESTUCTURA', 'PROPIO', 1011000, 1),
(1011401, 'SUBDEPTO DE ADMINISTRACION DE BIENES', 'PROPIO', 1011000, 1),
(1011402, 'SECCION BODEGA', 'PROPIO', 1011000, 1),
(1011403, 'SUBDEPTO ADMINISTRACION DE SERVICIOS', 'PROPIO', 1011000, 1),
(1011404, 'SECCION PORTERIA', 'PROPIO', 1011000, 1),
(1011405, 'SECCION TRANSPORTE', 'PROPIO', 1011000, 1),
(1011406, 'PREVENCION DE RIESGOS', 'PROPIO', 1011000, 1),
(1011407, 'SECCION TALLARES', 'PROPIO', 1011000, 1),
(1011500, 'DEPTO DE INFORMATICA', 'PROPIO', 1011000, 1),
(1110100, 'DECANATO DE FILOSOFIA Y EDUCACION', 'PROPIO', 1110000, 1),
(1110102, 'PROY CONVENIO CONADI', 'PROYECTO', 1110000, 1),
(1110200, 'DEPTO. DE FILOSOFIA', 'PROPIO', 1110000, 1),
(1110300, 'DEPTO. DE FORMACION PEDAGOGICA', 'PROPIO', 1110000, 1),
(1110400, 'DEPTO. DE EDUCACION PARVULARIA', 'PROPIO', 1110000, 1),
(1110500, 'DEPTO DE EDUCACION GENERAL BASICA', 'PROPIO', 1110000, 1),
(1110600, 'DEPTO. DE EDUACION DIFERENCIAL', 'PROPIO', 1110000, 1),
(1110601, 'LIC.EN EDUC.DIF. PROBLEMAS DE APRENDIZAJE', 'PROPIO', 1110000, 1),
(1110602, 'LIC. EN EDUC. DIF. PROBLEMAS DE AUDICION Y LENGUAJ', 'PROPIO', 1110000, 1),
(1110603, 'LIC.EN EDUC. DIF. PROBLEMA DE VISION', 'PROPIO', 1110000, 1),
(1110604, 'LIC. EN EDUC. DIF RETARDO MENTAL', 'PROPIO', 1110000, 1),
(1110605, 'CONVENIO DOCENTE ASIENCIAL U.ANDRES BELLO', 'PROPIO', 1110000, 1),
(1110606, 'PROY/ POSTITULO DE LENGUA DE SEÑAS', 'PROYECTO', 1110000, 1),
(1120100, 'DECANATO DE HISTORIA GEOGRAFIA Y LETRAS', 'PROPIO', 1120000, 1),
(1120101, 'LABORATORIO DE IDIOMAS Y SISTEMAS MUTIMEDIAS LISIM', 'PROPIO', 1120000, 1),
(1120200, 'DEPARTAMENTO DE HISTORIA Y GEOGRAFIA', 'PROPIO', 1120000, 1),
(1120300, 'DEPARTAMENTO ALEMAN', 'PROPIO', 1120000, 1),
(1120500, 'DEPARTAMENTO DE FRANCES', 'PROPIO', 1120000, 1),
(1120600, 'DEPARTAMENTO DE INGLES', 'PROPIO', 1120000, 1),
(1120700, 'CENTRO DE ESTUDIOS  CLASICOS', 'PROPIO', 1120000, 1),
(1120800, 'DEPARTAMENTO DE CASTELLANO', 'PROPIO', 1120000, 1),
(1130100, 'DECANATO DE CIENCIAS BASICAS', 'PROPIO', 1130000, 1),
(1130200, 'DEPARTAMENTO DE BIOLOGIA', 'PROPIO', 1130000, 1),
(1130300, 'DEPARTAMENTO DE FISICA', 'PROPIO', 1130000, 1),
(1130302, 'PROY OBSERVATORIO TURISTICO PAILALEN', 'PROYECTO', 1130000, 1),
(1130400, 'DEPARTAMENTO DE MATEMATICAS', 'PROPIO', 1130000, 1),
(1130500, 'DEPARTAMENTO DE QUIMICA', 'PROPIO', 1130000, 1),
(1130600, 'INSTITUTO DE ENTOMOLOGIA', 'PROPIO', 1130000, 1),
(1140100, 'DECANATO DE ARTES Y EDUCACION FISICA', 'PROPIO', 1140000, 1),
(1140200, 'DEPARTAMENTO DE ARTES VISUALES', 'PROPIO', 1140000, 1),
(1140300, 'DEPARTAMENTO DE EDUCACION MUSICAL', 'PROPIO', 1140000, 1),
(1140301, 'LICENCIATURA EN MUSICA', 'PROPIO', 1140000, 1),
(1140302, 'LIC.EN MUSICA Y DIREC. DE AGRUPACIONES MUSICALES', 'PROPIO', 1140000, 1),
(1140303, 'ESCUELA MUSICAL VESPERTINA', 'PROPIO', 1140000, 1),
(1140400, 'DEPARTAMENTO DE EDUCACION FISICA', 'PROPIO', 1140000, 1),
(1140500, 'DEPARTAMENTO DE KINESIOLOGIA', 'PROPIO', 1140000, 1),
(1140501, 'PROY POSTITULO ATENCION PRIMARIA (APS)', 'PROYECTO', 1140000, 1),
(1140551, 'MAGISTER EN KINESIOLOGIA Y BIOMECANICA CLINICA', 'PROPIO', 1140000, 1),
(1150100, 'INGRESOS CENTRALES', 'PROPIO', 1150000, 1),
(1160100, 'GASTOS CENTRALES', 'PROPIO', 1160000, 1),
(2001100, 'DEFDER', 'PROPIO', 2001000, 1),
(3001100, 'SEDE GRANEROS', 'PROPIO', 3001000, 1),
(3001101, 'LIC. EN EDUC. Y PEDAGOGIA EN EDUC. PARVULARIA', 'PROPIO', 3001000, 1),
(3001102, 'LIC. EN EDUC. Y PEDAGOGIA EN EDUC. GRAL BASICA', 'PROPIO', 3001000, 1),
(3001103, 'PROGRAMA ESPECIAL DE LICENCIATURA EN EDUCACION', 'PROPIO', 3001000, 1),
(4001100, 'LICEO MERCEDES MARIN DEL SOLAR', 'PROPIO', 4001000, 1),
(5001001, 'FUNDACION UMCE', 'PROPIO', 5000000, 1);

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

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`depto_id`, `depto_nombre`, `depto_nombre_corto`, `depto_estado`, `depto_habilitado`) VALUES
(1, 'TODOS', 'TODOS', 0, 1),
(2, 'RECTORÍA', 'RECTORÍA', 1, 0),
(3, 'CONTRALORÍA INTERNA', 'CONTRALORÍA', 1, 0),
(4, 'PRORRECTORÍA', 'PRORRECTORÍA', 1, 0),
(5, 'DRICI - DIRECCIÓN DE RELACIONES INSTITUCIONALES Y COOPERACION INTERNACIONAL', 'DRICI', 1, 0),
(6, 'LICEO A-5', 'LICEO', 1, 0),
(7, 'FUNDACIÓN UMCE', 'FUNDACIÓN', 1, 0),
(8, 'DIRECCIÓN DE PLANIFICACIÓN Y PRESUPUESTO', 'PLANIFICACIÓN', 1, 0),
(9, 'DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS', 'DAF', 1, 1),
(10, 'DIRECCIÓN DE ASUNTOS ESTUDIANTILES', 'DAE', 1, 0),
(11, 'DIRECCIÓN DE EXTENSION Y VINCULACIÓN CON EL MEDIO', NULL, 1, 0),
(12, 'SECRETARÍA GENERAL', 'SECRETARÍA', 1, 0),
(13, 'VICERRECTORÍA ACADEMICA', 'VICERRECTORÍA', 1, 0),
(14, 'DIRECCIÓN DE DOCENCIA ', 'DOCENCIA', 1, 0),
(15, 'DIRECCIÓN DE INVESTIGACIÓN', 'INVESTIGACIÓN', 1, 0),
(16, 'DIRECCIÓN DE POSTGRADO', 'POSTGRADO', 1, 0),
(17, 'DIRECCIÓN DE ASEGURAMIENTO DE LA CALIDAD', 'DAC', 1, 0),
(18, 'DIRECCIÓN DE EDUCACIÓN CONTINUA ', NULL, 1, 0),
(19, 'SIMEDPRO - SIST. INTEGRAL DE MONITOREO Y EV. DEL DESEMPEÑO PROFESIONAL ', NULL, 1, 0),
(20, 'DEPARTAMENTO DE BIBLIOTECA', 'BIBLIOTECA', 1, 0),
(21, 'DEPARTAMENTO DE ADMISION Y REGISTRO CURRICULAR', NULL, 1, 0),
(22, 'CENTRO DE FORMACIÓN VIRTUAL', 'FORMACIÓN VIRTUAL', 1, 0),
(23, 'FACULTAD DE FILOSOFÍA DECANATO', NULL, 1, 0),
(24, 'FACULTAD DE ARTES Y ED. FISICA', NULL, 1, 0),
(25, 'FACULTAD DE HISTORIA GEOGRAFÍA Y LETRAS', NULL, 1, 0),
(26, 'FACULTAD DE CIENCIAS BASICAS', NULL, 1, 0),
(27, 'UNIDAD DE FORMULACIÓN Y CONTROL PRESUPUESTARIO', NULL, 1, 0),
(28, 'UNIDAD DE FORMULACIÓN Y EVALUACIÓN Y CONTROL DE PROYECTOS', NULL, 1, 0),
(29, 'UNIDAD DE ANÁLISIS INSTITUCIONAL', 'UAI', 1, 0),
(30, 'DEPARTAMENTO DE FINANZAS', 'FINANZAS', 1, 1),
(31, 'DEPARTAMENTO DE RECURSOS HUMANOS', 'RRHH', 1, 0),
(32, 'DEPARTAMENTO DE INFORMATICA', 'INFORMÁTICA', 1, 1),
(33, 'DEPARTAMENTO INFRAESTRUCTURA', 'INFRAESTRUCTURA', 1, 0),
(34, 'SUBDEPARTAMENTO DE BIENESTAR ESTUDIANTIL', 'BIENESTAR ESTUDIANTIL', 1, 0),
(35, 'SUBDEPARTAMENTO DE SALUD ESTUDIANTIL Y CENTRO MÉDICO', 'CENTRO MÉDICO', 1, 0),
(36, 'SUBDEPTO DE EJERCICIO FISICO SALUD Y DEPORTE', NULL, 1, 0),
(37, 'EXTENSIÓN Y PUBLICACIONES', NULL, 1, 0),
(38, 'COMUNICACIONES Y PAGINA WEB', NULL, 1, 0),
(39, 'DEPARTAMENTO DE MEDIOS EDUCATIVOS', 'MEDIOS EDUCATIVOS', 1, 0),
(40, 'DEPARTAMENTO JURIDICO', NULL, 1, 0),
(41, 'SUBDEPARTAMENTO DE TITULOS Y GRADOS ', NULL, 1, 0),
(42, 'SECCIÓN DE PARTES, ARCHIVOS E INFORMACIONES', NULL, 1, 0),
(43, 'UNIDAD DE GESTIÓN CURRICULAR', NULL, 1, 0),
(44, 'UNIDAD DE GESTIÓN DE RECURSOS PARA EL APRENDIZAJE', NULL, 1, 0),
(45, 'COORDINACIÓN GENERAL DE PRACTICAS', NULL, 1, 0),
(46, 'CENTRO DE ACOMPAÑAMIENTO AL APRENDIZAJE', 'CAA', 1, 0),
(47, 'UNIDAD DE GESTIÓN DE PROYECTOS', NULL, 1, 0),
(48, 'UNIDAD DE PERFECCIONAMIENTO Y CAPACITACIÓN EN INVESTIGACIÓN', NULL, 1, 0),
(49, 'SECCIÓN SELECCIÓN Y CANJE', NULL, 1, 0),
(50, 'SECCIÓN PROCESOS TÉCNICOS Y CIRCULACIÓN', NULL, 1, 0),
(51, 'SECCIÓN REFERENCIA Y HEMEROTECA', NULL, 1, 0),
(52, 'UNIDAD ASEGURAMIENTO CALIDAD CURRICULUM', NULL, 1, 0),
(53, 'UNIDAD ASEGURAMIENTO CALIDAD EXTENSIÓN E INVESTIGACIÓN Y PROCESOS ADMINISTRATIVOS', NULL, 1, 0),
(54, 'SECRETARÍA DE DISEÑO Y ESTUDIOS', NULL, 1, 0),
(55, 'COORDINACIÓN DE PROGRAMAS DE PERFECCIONAMIENTO', NULL, 1, 0),
(56, 'COORDINACIÓN DE PROGRAMAS DE ASISTENCIA TÉCNICA Y PROYECTOS', NULL, 1, 0),
(57, 'COORDINACIÓN DE PROGRAMAS DE EDUCACIÓN A DISTANCIA', NULL, 1, 0),
(58, 'DEPARTAMENTO DE EDUCACIÓN PARVULARIA', 'PARVULARIA', 1, 0),
(59, 'DEPARTAMENTO DE FORMACIÓN PEDAGÓGICA', 'FORMACIÓN PEDAGÓGICA', 1, 0),
(60, 'DEPARTAMENTO DE EDUCACIÓN BÁSICA', 'BÁSICA', 1, 0),
(61, 'DEPARTAMENTO DE EDUCACIÓN DIFERENCIAL', 'DIFERENCIAL', 1, 0),
(62, 'DEPARTAMENTO DE FILOSOFÍA', 'FILOSOFÍA', 1, 0),
(63, 'DEARTAMENTO DE RELIGIÓN', 'RELIGIÓN', 1, 0),
(64, 'COORDINACIÓN PROGRAMA DE EDUCACIÓN TÉCNICO PROFESIONAL Y ADULTO', NULL, 1, 0),
(65, 'DEPARTAMENTO DE ARTES VISUALES', 'ARTES', 1, 0),
(66, 'DEPARTAMENTO DE EDUCACIÓN FISICA, DEPORTES Y RECREACIÓN', NULL, 1, 0),
(67, 'DEPARTAMENTO DE MÚSICA', 'MÚSICA', 1, 0),
(68, 'DEPARTAMENTO DE KINESIOLOGÍA', 'KINESIOLOGÍA', 1, 0),
(69, 'DEPARTAMENTO DE HISTORIA Y GEOGRAFÍA Y LETRAS', 'HISTORIA', 1, 0),
(70, 'CENTRO DE ESTUDIOS CLÁSICOS', NULL, 1, 0),
(71, 'DEPARTAMENTO DE CASTELLANO', 'CASTELLANO', 1, 0),
(72, 'DEPARTAMENTO DE INGLÉS', 'INGLÉS', 1, 0),
(73, 'DEPARTAMENTO DE ALEMÁN', 'ALEMÁN', 1, 0),
(74, 'DEPARTAMENTO DE FRANCÉS', 'FRANCÉS', 1, 0),
(75, 'LISIM - LAB. DE IDIOMAS Y SISTEMAS MULTIMEDIALES', NULL, 1, 0),
(76, 'DEPARTAMENTO DE BIOLOGÍA ', 'BIOLOGÍA', 1, 0),
(77, 'DEPARTAMENTO DE FÍSICA', 'FÍSICA', 1, 0),
(78, 'DEPARTAMENTO DE QUÍMICA', 'QUÍMICA', 1, 0),
(79, 'DEPARTAMENTO DE MATEMÁTICA', 'MATEMÁTICA', 1, 0),
(80, 'INSTITUTO DE ENTOMOLOGÍA', 'ENTOMOLOGÍA', 1, 0),
(81, 'SUBDEPARTAMENTO DE TESORERÍA Y COBRANZA', 'TESORERIA', 1, 1),
(82, 'SUBDEPARTAMENTO DE CONTABILIDAD', 'CONTABILIDAD', 1, 1),
(83, 'SUBDEPARTAMENTO DE PRESUPUESTO', 'PPTO', 1, 1),
(84, 'SUBDEPARTAMENTO DE ARANCELES Y CREDITOS', NULL, 1, 0),
(85, 'SUBDEPARTAMENTO DE SERVICIOS ESTUDIANTILES', NULL, 1, 0),
(86, 'OFICINA FONDO SOLIDARIO DE CRÉDITO UNIVERSITARIO', NULL, 1, 0),
(87, 'SUBDEPARTAMENTO DE ADQUISICIONES', 'ADQUISICIONES', 1, 1),
(88, 'SECCIÓN BODEGA CENTRAL', 'BODEGA', 1, 0),
(89, 'SUBDEPARTAMENTO DE ADMINISTRACIÓN RECURSOS HUMANOS', 'RRHH', 1, 0),
(90, 'SUBDEPARTAMENTO DE REMUNERACIONES', 'REMUNERACIONES', 1, 0),
(91, 'SUBDEPARTAMENTO DE BIENESTAR DEL PERSONAL ', 'BIENESTAR DEL PERSONAL ', 1, 0),
(92, 'SUBDEPARTAMENTO CENTRO INFANTIL ', NULL, 1, 0),
(93, 'SECCIÓN DE CAPACITACIÓN', NULL, 1, 0),
(94, 'DEPARTAMENTO DE DESARROLLO DE LAS PERSONAS', NULL, 1, 0),
(95, 'SECCIÓN DE OPERACIONES', 'OPERACIONES', 1, 0),
(96, 'SECCIÓN DE DESARROLLO', 'DESARROLLO', 1, 0),
(97, 'SUBDEPARTAMENTO DE SERVICIOS Y MANTENCIÓN', NULL, 1, 0),
(98, 'SECCIÓN DE PREVENCIÓN DE RIESGOS', NULL, 1, 0),
(99, 'CAMPUS JOAQUIN CABEZAS GARCIAS', 'DEFDER', 1, 0),
(100, 'SUBDEPARTAMENTO DE ADMINISTRACIÓN DE BIENES', NULL, 1, 0),
(101, 'OFICINA DE ARQUITECTURA', NULL, 1, 0),
(102, 'SECCIÓN ASEO Y ORNATO', NULL, 1, 0),
(103, 'SECCIÓN PORTERÍA', 'PORTERÍA', 1, 0),
(104, 'SECCIÓN TRANSPORTE', 'TRANSPORTE', 1, 0),
(105, 'SECCIÓN TALLERES', 'TALLERES', 1, 0),
(106, 'SEDE GRANEROS', 'GRANEROS', 1, 0),
(107, 'RED CAMPUS SUSTENTABLE', NULL, 1, 0),
(108, 'TENT', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `dependencia_codigo` int(11) NOT NULL,
  `dependencia_nombre` varchar(200) NOT NULL,
  `dependencia_estado` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`dependencia_codigo`, `dependencia_nombre`, `dependencia_estado`) VALUES
(1000000, 'MACUL', 0),
(1001000, 'RECTORIA', 1),
(1002000, 'PRORRECTORIA', 1),
(1003000, 'SECRETARIA GENERAL', 1),
(1004000, 'CONTRALORIA INTERNA', 1),
(1005000, 'DIRECCION DE PLANIFICACION Y PRESUPUESTO', 1),
(1006000, 'VICERRECTORIA ACADEMICA', 1),
(1007000, 'DIRECCION DE POSGRADO', 1),
(1009000, 'DIRECCION DE ASUNTOS ESTUDIANTILES', 1),
(1011000, 'DIRECCION DE ADMINITRACION Y FINANZAS', 1),
(1110000, 'FACULTAD DE FILOSOFIA Y EDUCACION', 1),
(1120000, 'FACULTAD DE HISTORIA, GEOGRAFIA Y LETRAS', 1),
(1130000, 'FACULTAD DE CIENCIAS BASICAS', 1),
(1140000, 'FACULTAD DE ARTES Y EDUCACION FISICA', 1),
(1150000, 'INGRESOS CENTRALES', 1),
(1160000, 'GASTOS CENTRALES', 1),
(2000000, 'CAMPUS DEFDER', 0),
(2001000, 'CAMPUS DEFDER', 1),
(3000000, 'CAMPUS GRANEROS', 0),
(3001000, 'SEDE GRANEROS', 1),
(4000000, 'LICEO MERCEDES MARIN DEL SOLAR', 0),
(4001000, 'LICEO MERCEDES MARIN DEL SOLAR', 1),
(5000000, 'FUNDACION UMCE', 0),
(5001000, 'FUNDACION UMCE', 1);

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
  `detmemo_memo_id` int(11) NOT NULL,
  `detmemo_cc_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_memo`
--

INSERT INTO `detalle_memo` (`detmemo_id`, `detmemo_descripcion`, `detmemo_ocnum_chilecompra`, `detmemo_ocnum_sistema_interno`, `detmemo_monto_total`, `detmemo_contacto_nombre`, `detmemo_proc_compra_id`, `detmemo_proveedor_id`, `detmemo_fecha`, `detmemo_memo_id`, `detmemo_cc_codigo`) VALUES
(1, 'Algo', '123', '123', 1000000, 'Juan Perez', 2, 2, '2019-09-05 06:45:56', 3, 1130200),
(2, 'Algo nuevo', '234', '234', 100000, 'Juan', 5, 1, '2019-09-05 06:50:16', 3, 1130200);

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

--
-- Volcado de datos para la tabla `dpto_tiene_usu`
--

INSERT INTO `dpto_tiene_usu` (`dpto_tiene_usu_depto_id`, `dpto_tiene_usu_usuario_id`, `dpto_tiene_usu_fecha_asignacion`, `dpto_tiene_usu_principal`, `dpto_tiene_usu_estado`) VALUES
(1, 1, '2019-06-07 19:44:39', 1, 1),
(87, 2, '2019-06-07 20:59:12', 1, 1),
(87, 4, '2019-06-10 22:24:29', 1, 1),
(32, 5, '2019-06-13 21:08:41', 1, 1),
(82, 6, '2019-06-18 23:21:07', 1, 1),
(9, 3, '2019-06-21 19:18:53', 1, 1),
(30, 3, '2019-06-21 19:18:53', 0, 1),
(81, 3, '2019-06-21 19:18:53', 0, 1),
(82, 3, '2019-06-21 19:18:53', 0, 1),
(83, 3, '2019-06-21 19:18:54', 0, 1),
(87, 3, '2019-06-21 19:18:54', 0, 1),
(87, 7, '2019-07-26 15:22:11', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_asignacion`
--

CREATE TABLE `estado_asignacion` (
  `estado_asignacion_id` int(11) NOT NULL,
  `estado_asignacion_texto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_asignacion`
--

INSERT INTO `estado_asignacion` (`estado_asignacion_id`, `estado_asignacion_texto`) VALUES
(1, 'No leido'),
(2, 'Leido'),
(3, 'Confirmada'),
(4, 'Cerrado'),
(5, 'Terminado'),
(6, 'Re-Asignado');

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

--
-- Volcado de datos para la tabla `estado_detalle_memo`
--

INSERT INTO `estado_detalle_memo` (`estado_detmemo_id`, `estado_detmemo_tipo`, `estado_detmemo_orden`, `estado_detmemo_descripcion`, `estado_detmemo_activo`) VALUES
(1, 'En Proceso', 1, 'En Espera de Antecedentes', 1),
(2, 'En Espera de Antecedentes', 2, 'En Espera de Antecedentes', 1),
(3, 'Compra Parcial', 3, 'Compra Parcial', 1),
(4, 'Compra Realizada', 4, 'Compra Parcial', 1),
(5, 'OC Nula', 5, 'Orden de Compra Nula', 1),
(6, 'OC Cancelada', 6, 'Orden de Compra Cancelada', 1);

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

--
-- Volcado de datos para la tabla `historial_cambios`
--

INSERT INTO `historial_cambios` (`historial_cambios_id`, `historial_cambios_tipo_id`, `historial_cambios_tabla`, `historial_cambios_pk`, `historial_cambios_campo_nombre`, `historial_cambios_valor_anterior`, `historial_cambios_valor_nuevo`, `historial_cambios_fecha_transaccion`, `historial_cambios_usuario_id`) VALUES
(1, 2, 'memo_archivo', '1', 'memo_archivo_url', 'archivos/archivo_memo_2018_123.png', 'archivos/archivo_memo_2019_123.png', '2019-01-29 16:13:57', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios_tipo`
--

CREATE TABLE `historial_cambios_tipo` (
  `hist_camb_tipo_id` int(11) NOT NULL,
  `hist_camb_tipo_texto` varchar(30) NOT NULL COMMENT 'insert,update,delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historial_cambios_tipo`
--

INSERT INTO `historial_cambios_tipo` (`hist_camb_tipo_id`, `hist_camb_tipo_texto`) VALUES
(1, 'inserta'),
(2, 'modifica'),
(3, 'elimina');

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
  `memo_tipo_doc_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo`
--

INSERT INTO `memo` (`memo_id`, `memo_num_memo`, `memo_anio`, `memo_materia`, `memo_fecha_memo`, `memo_fecha_recepcion`, `memo_depto_solicitante_id`, `memo_nombre_solicitante`, `memo_depto_destinatario_id`, `memo_nombre_destinatario`, `memo_fecha_ingreso`, `memo_tipo_doc_id`) VALUES
(1, '123', 2019, 'prueba', '2019-07-01', '2019-07-01', 9, 'Leonel Durán', 32, 'Paulina Sepulveda', '2019-07-01 14:48:08', NULL),
(2, '444', 2019, 'Otra prueba para informatica', '2019-06-26', '2019-06-26', 9, 'Leonel Duran', 32, 'Paulina Sepulveda', '2019-07-01 15:04:50', NULL),
(3, '666', 2019, 'Compra de notebook desarrollo', '2019-06-24', '2019-07-04', 32, 'Paulina Sepulveda', 9, 'Leonel Duran', '2019-07-01 19:44:31', NULL),
(4, '5555', 2019, 'prueba de memo compra', '2019-06-10', '2019-07-01', 76, 'Juan Perez', 9, 'Leonel Durán', '2019-07-01 19:48:03', NULL),
(5, '357', 2019, 'Prueba de ingreso desde DAF a Conta', '2019-07-03', '2019-07-03', 9, 'Leonel Durán', 82, 'Juan Conta', '2019-07-04 19:44:19', NULL),
(6, '159', 2019, 'Recepcion des otros depto a DAF', '2019-07-01', '2019-07-04', 8, 'Cesar Marilaf', 9, 'Leonel Durán', '2019-07-04 19:46:38', NULL),
(7, '999', 2019, 'Prueba de solicitud', '2019-07-03', '2019-07-09', 9, 'Leonel Durán', 79, 'Juan Perez', '2019-07-09 21:35:02', NULL),
(8, '321321', 2019, 'prueba de ingreso de memo', '2019-07-08', '2019-07-24', 9, 'Leonel Durán', 32, 'Paulina Sepulveda', '2019-07-10 15:05:43', NULL),
(9, '9090', 2019, 'Revisar contratos honorarios', '2019-07-10', '2019-07-10', 9, 'Leonel Durán', 90, 'Catalina Cordova', '2019-07-10 16:03:48', NULL),
(10, '9090', 2019, 'Revisar contratos honorarios', '2019-07-04', '2019-07-04', 9, 'Leonel Duran', 90, 'Catalina Cordova', '2019-07-10 16:05:34', NULL),
(11, '888', 2019, 'prueba d ecompra', '2019-06-19', '2019-07-08', 78, 'Juan De Nuevo', 9, 'Leonel Durán', '2019-07-11 16:46:33', NULL),
(12, '7777', 2019, 'nuevo', '2019-07-01', '2019-07-11', 31, 'Carol', 9, 'Leonel Durán', '2019-07-11 16:47:18', NULL),
(13, '456', 2019, 'Prueba compra Mayo2019', '2019-05-27', '2019-07-11', 71, 'Jose Carrasco', 9, 'Leonel Durán', '2019-07-11 20:00:05', NULL),
(14, '654', 2019, 'Prueba de compra de Abril 2019', '2019-04-22', '2019-07-11', 34, 'Carolina Muñoz', 9, 'Leonel Durán', '2019-07-11 20:01:34', NULL),
(15, '554466', 2019, 'Prueba compra muchas cosas', '2019-03-05', '2019-03-07', 22, 'Paula Gonzalez', 9, 'Leonel Durán', '2019-07-11 20:12:03', NULL),
(16, '7878', 2019, 'Prueba de otra compra en Julio', '2019-07-02', '2019-07-08', 79, 'Juan', 9, 'Leonel Durán', '2019-07-11 20:14:08', NULL),
(17, '632', 2019, 'otra compra ', '2019-07-03', '2019-07-09', 20, 'Karin Muñoz', 9, 'Leonel Durán', '2019-07-11 20:17:24', NULL),
(18, '3232', 2019, 'Compra nueva Julio', '2019-07-09', '2019-07-11', 58, 'Cecilia Nuñez', 9, 'Leonel Durán', '2019-07-11 20:18:12', NULL),
(19, '5252', 2019, 'compra de pantalla 23\"', '2019-07-08', '2019-07-11', 71, 'Carolina Zapata', 9, 'Leonel Durán', '2019-07-11 20:22:31', NULL),
(20, '8888', 2019, 'Prueba de ingreso de memo desde INFORMATICA, con nuevos datos', '2019-07-11', '2019-07-23', 32, 'Paulina Sepulveda', 9, 'Leonel Duran', '2019-07-23 16:03:45', NULL),
(21, '35', 2019, 'Compra teclados y mouses', '2019-07-22', '2019-07-23', 20, 'Ernesto Alvarez', 9, 'Leonel Durán', '2019-07-23 16:10:26', NULL),
(22, '319', 2019, 'Compra de 9 proyectores marca EPSON POWERLITE, formulada en memo 67 (28-03-2019)', '2019-07-30', '2019-07-30', 59, 'Fabían Castro', 9, 'Leonel Durán', '2019-07-31 16:05:25', NULL),
(23, '320', 2019, 'Compra de 2 Impresoras Multifunción HP DESKJET INK ADVANTAGE 5275', '2019-07-30', '2019-07-30', 59, 'Fabían Castro', 9, 'Leonel Durán', '2019-07-31 16:06:22', NULL),
(24, '323', 2019, 'Compra 4 Laptops HP240GG INW24LT,  formulada en memo 145(18-04-2019)', '2019-07-30', '2019-07-30', 59, 'Fabían Casgtro', 9, 'Leonel Durán', '2019-07-31 16:07:40', NULL);

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
-- Estructura de tabla para la tabla `memo_cdp`
--

CREATE TABLE `memo_cdp` (
  `memo_cdp_id` int(11) NOT NULL,
  `memo_cdp_num` varchar(20) NOT NULL,
  `memo_cdp_fecha` date NOT NULL,
  `memo_cdp_cc_codigo` int(11) NOT NULL,
  `memo_cdp_obs` varchar(255) DEFAULT NULL,
  `memo_cdp_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_cdp`
--

INSERT INTO `memo_cdp` (`memo_cdp_id`, `memo_cdp_num`, `memo_cdp_fecha`, `memo_cdp_cc_codigo`, `memo_cdp_obs`, `memo_cdp_memo_id`) VALUES
(1, '6352', '2019-09-03', 1110300, 'ver', 24),
(2, '6353', '2019-09-03', 1011500, 'ver', 24),
(3, '333', '2019-09-03', 1130200, '80% de este CC', 3),
(4, '333', '2019-09-03', 1130200, '60%', 4);

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

--
-- Volcado de datos para la tabla `memo_derivado`
--

INSERT INTO `memo_derivado` (`memo_derivado_id`, `memo_derivado_memo_id`, `memo_derivado_dpto_id`, `memo_derivado_nombre_destinatario`, `memo_derivado_fecha`, `memo_derivado_depto_actual`, `memo_derivado_estado_id`) VALUES
(1, 1, 32, 'Paulina Sepulveda', '2019-07-01 15:01:58', 0, 1),
(2, 4, 9, 'Leonel Durán', '2019-07-01 19:48:03', 0, 1),
(3, 4, 83, 'Juan', '2019-07-02 15:47:36', 0, 1),
(5, 4, 87, 'Maria Jose garces', '2019-07-02 17:00:07', 1, 1),
(7, 3, 9, 'Leonel Duran', '2019-07-04 15:32:29', 0, 1),
(8, 2, 32, 'Paulina Sepulveda', '2019-07-04 15:34:23', 1, 1),
(9, 1, 9, 'Leonel Duran', '2019-07-04 15:35:41', 0, 1),
(10, 1, 83, 'Duran', '2019-07-04 15:38:23', 0, 1),
(11, 1, 87, 'Maria Jose garces', '2019-07-04 16:01:58', 1, 1),
(12, 6, 9, 'Leonel Durán', '2019-07-04 19:46:38', 0, 1),
(13, 5, 82, 'Juan Conta', '2019-07-09 16:02:46', 1, 1),
(14, 7, 79, 'Juan Perez', '2019-07-09 22:37:14', 0, 1),
(15, 7, 9, 'Leonel Durán', '2019-07-09 22:38:11', 1, 1),
(16, 11, 9, 'Leonel Durán', '2019-07-11 16:46:33', 1, 1),
(17, 12, 9, 'Leonel Durán', '2019-07-11 16:47:18', 0, 1),
(18, 13, 9, 'Leonel Durán', '2019-07-11 20:00:05', 1, 1),
(19, 14, 9, 'Leonel Durán', '2019-07-11 20:01:34', 1, 1),
(20, 15, 9, 'Leonel Durán', '2019-07-11 20:12:03', 1, 1),
(21, 16, 9, 'Leonel Durán', '2019-07-11 20:14:08', 0, 1),
(22, 17, 9, 'Leonel Durán', '2019-07-11 20:17:24', 0, 1),
(23, 18, 9, 'Leonel Durán', '2019-07-11 20:18:13', 0, 1),
(24, 19, 9, 'Leonel Durán', '2019-07-11 20:22:31', 0, 1),
(25, 16, 32, 'Paulina Sepulveda', '2019-07-12 19:21:46', 0, 1),
(26, 16, 79, 'Juan', '2019-07-12 19:26:46', 1, 1),
(27, 18, 32, 'Paulina Sepulveda', '2019-07-22 22:31:50', 1, 1),
(28, 21, 9, 'Leonel Durán', '2019-07-23 16:10:26', 0, 1),
(29, 21, 32, 'Paulina', '2019-07-23 16:12:37', 1, 1),
(30, 20, 9, 'Leonel Duran', '2019-07-23 16:17:45', 0, 1),
(31, 8, 32, 'Paulina Sepulveda', '2019-07-24 14:43:02', 1, 1),
(32, 3, 83, 'Arturo', '2019-07-24 15:36:47', 0, 1),
(33, 19, 83, 'Arturo', '2019-07-24 15:36:47', 0, 1),
(34, 12, 83, 'Arturo', '2019-07-24 15:36:47', 0, 1),
(35, 3, 87, 'Maria Jose Garces', '2019-07-24 15:52:45', 1, 1),
(38, 19, 87, 'Maria Jose Garces', '2019-07-24 16:13:39', 1, 1),
(40, 6, 83, 'Arturo', '2019-07-24 20:05:40', 0, 1),
(41, 17, 83, 'Arturo', '2019-07-24 20:05:40', 0, 1),
(42, 20, 83, 'Arturo', '2019-07-24 20:05:40', 0, 1),
(43, 6, 87, 'Maria Jose Garces', '2019-07-24 20:50:27', 1, 1),
(44, 17, 87, 'Maria Jose Garces', '2019-07-24 20:50:27', 1, 1),
(45, 12, 87, 'Maria Jose Garces', '2019-07-24 20:50:27', 1, 1),
(46, 20, 87, 'Maria Jose Garces', '2019-07-24 20:50:27', 1, 1),
(47, 22, 9, 'Leonel Durán', '2019-07-31 16:05:25', 1, 1),
(48, 23, 9, 'Leonel Durán', '2019-07-31 16:06:22', 0, 1),
(49, 24, 9, 'Leonel Durán', '2019-07-31 16:07:40', 0, 1),
(50, 24, 87, 'Maria Jose Garces', '2019-08-07 20:17:46', 1, 1),
(51, 23, 83, 'Jose Catalan', '2019-08-13 18:14:21', 0, 1),
(52, 23, 87, 'MJ ', '2019-08-13 18:15:02', 1, 1);

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

--
-- Volcado de datos para la tabla `memo_estado`
--

INSERT INTO `memo_estado` (`memo_estado_id`, `memo_estado_tipo`, `memo_estado_orden`, `memo_estado_descripcion`, `memo_estado_color_bg`, `memo_estado_color_font`, `memo_estado_activo`, `memo_estado_depto_id`, `memo_estado_memo_estadogenerico_id`) VALUES
(1, 'Ingresado', 1, 'Primer estado del memo', 'blue-bg', 'white-text', 1, 9, 1),
(2, 'Recibido', 1, 'Primer estado del memo', 'cyan-bg', 'black-text', 1, 9, 2),
(3, 'Anulado', 2, 'Si tiene mal escrito numero memo, fecha memo o fecha recepcion se anula el memo', 'blue-grey-bg', 'white-text', 1, 9, 3),
(4, 'Pendiente DAF', 2, 'Entregado a Director DAF en espera de aprobación ', 'deep-orange-bg', 'white-text', 1, 9, 4),
(5, 'Derivado a Otro Depto.', 2, 'Se deriva a cualquier otro Depto', 'yellow-bg', 'black-text', 1, 9, 5),
(6, 'Devuelto desde otro Depto', 3, 'Devuelto del origen', 'light-blue-bg', 'white-text', 1, 9, 6),
(7, 'Archivado', 4, 'Memo informativo que solo se archiva', 'brown-bg', 'white-text', 1, 9, 7),
(8, 'Aprobado DAF', 4, 'Aprobado por Director DAF', 'teal-bg', 'white-text', 1, 9, 8),
(9, 'Rechazado DAF', 4, 'Rechazado por Director DAF', 'granate-bg', 'white-text', 1, 9, 9),
(10, 'Respondido', 9, 'Se responde el memo a su origen', 'indigo-bg', 'white-text', 1, 9, 10),
(11, 'Derivado a PPTO', 5, 'Derivado específicamente a Presupuesto', 'lime-bg', 'black-text', 1, 9, NULL),
(12, 'Aprobado por PPTO', 6, 'Aprobado por PPTO', 'olive-bg', 'white-text', 1, 9, NULL),
(13, 'Rechazado por PPTO', 6, 'Rechazado desde PPTO', 'pink-bg', 'white-text', 1, 9, NULL),
(14, 'Derivado Adquisiciones', 7, 'Aprobado por PPTO y enviado a Adquisiciones', 'amber-bg', 'black-text', 1, 9, NULL),
(15, 'Rechazado por Disponibilidad Adquisiciones', 8, 'Rechazado desde Adquisiciones', 'red-bg', 'white-text', 1, 9, NULL),
(16, 'Ingresado', 1, 'Estado crea memo de adquisiciones', 'blue-bg', 'white-text', 0, 87, 1),
(17, 'Recibido, Sin Asignar', 1, 'Recibido desde DAF u Otro Depto.', 'cyan-bg', 'black-text', 1, 87, 2),
(18, 'Anulado', 2, 'Si tiene mal escrito numero memo, fecha memo o fecha recepcion se anula el memo', 'blue-grey-bg', 'white-text', 0, 87, 3),
(19, 'Pendiente', 2, 'Entregado a Jefa Adquisiciones', 'deep-orange-bg', 'white-text', 0, 87, 4),
(20, 'Derivado a Otro Depto', 2, 'Se deriva a cualquier otro Depto', 'yellow-bg', 'black-text', 0, 87, 5),
(21, 'Devuelto desde otro Depto', 3, 'Devuelto del origen', 'light-blue-bg', 'white-text', 0, 87, 6),
(22, 'Archivado', 4, 'Memo informativo que solo se archiva', 'brown-bg', 'white-text', 1, 87, 7),
(23, 'Aprobado', 4, 'Aprobado por jefa Adquisiciones', 'teal-bg', 'white-text', 0, 87, 8),
(24, 'Rechazado', 6, 'Rechazado por Jefa Adquisiciones', 'granate-bg', 'white-text', 1, 87, 9),
(25, 'Respondido', 6, 'Se responde el memo a su origen', 'indigo-bg', 'white-text', 1, 87, 10),
(26, 'Asignado', 2, 'Jefa Adquisiciones asigna memo compra a Analista', 'lime-bg', 'black-text', 1, 87, NULL),
(27, 'En Gestion', 5, 'Memo en Gestion, se esta procesando la compra', 'orange-bg', 'white-text', 1, 87, NULL),
(28, 'Rechazado por Disponibilidad', 6, 'Rechazado por analista por disponibilidad de producto', 'red-bg', 'white-text', 1, 87, NULL),
(29, 'Cerrado', 6, 'Memo Cerrado pero faltan datos como la factura, NO completo', 'deep-purple-bg', 'white-text', 1, 87, NULL),
(30, 'Finalizado', 7, 'Memo terminado completo , sin datos faltantes', 'blue-magenta-bg', 'white-text', 1, 87, NULL),
(31, 'Ingresado', 1, 'Estado Ingresado memo de Informática', 'blue-bg', 'white-text', 1, 32, 1),
(32, 'Recibido', 1, 'Recibido desde otro departamento', 'cyan-bg', 'white-text', 1, 32, 2),
(33, 'Anulado', 2, 'Memo Anulado', 'blue-grey-bg', 'white-text', 1, 32, 3),
(34, 'Pendiente', 2, 'Pendiente por Jefe Departamento', 'deep-orange-bg', 'white-text', 1, 32, 4),
(35, 'Derivado a Otro Depto.', 2, 'Se derivada a cualquier otro Depto.', 'yellow-bg', 'black-text', 1, 32, 5),
(36, 'Devuelto desde otro Depto', 3, 'Devuelto desde otro depto.', 'light-blue-bg', 'white-text', 1, 32, 6),
(37, 'Archivado', 4, 'Memo informativo que solo se archiva', 'brown-bg', 'white-text', 1, 32, 7),
(38, 'Aprobado', 4, 'Aprobado Jefe Departamento', 'teal-bg', 'white-text', 1, 32, 8),
(39, 'Rechazado', 4, 'Rechazado por Jefe Departamento', 'granate-bg', 'white-text', 1, 32, 9),
(40, 'Respondido', 9, 'Se responde el memo a su origen', 'indigo-bg', 'white-text', 1, 32, 10);

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

--
-- Volcado de datos para la tabla `memo_estadogenerico`
--

INSERT INTO `memo_estadogenerico` (`memo_estadogenerico_id`, `memo_estadogenerico_nombre`, `memo_estadogenerico_orden`, `memo_estadogenerico_descripcion`, `memo_estadogenerico_color_bg`, `memo_estadogenerico_color_font`, `memo_estadogenerico_activo`) VALUES
(1, 'Ingresado', 1, 'Memo Ingresado', 'blue-bg', 'black-text', 1),
(2, 'Recibido', 1, 'Memo Recibido', 'cyan-bg', 'black-text', 1),
(3, 'Anulado', 2, 'Si tiene mal escrito numero memo, fecha memo o fecha recepcion se anula el memo', 'blue-grey-bg', 'white-text', 1),
(4, 'Pendiente', 2, 'Entregado a Jefe Unidad en espera de aprobación ', 'deep-orange-bg', 'white-text', 1),
(5, 'Derivado Otro Depto.', 2, 'Se deriva a otra Unidad o Depto', 'yellow-bg', 'black-text', 1),
(6, 'Devuelto otro Depto', 3, 'Devuelto desde ultima Unidad derivada', 'light-blue-bg', 'white-text', 1),
(7, 'Archivado', 4, 'Memo que solo se archiva', 'brown-bg', 'white-text', 1),
(8, 'Aprobado', 4, 'Aprobado por Jefe Unidad', 'teal-bg', 'white-text', 1),
(9, 'Rechazado', 4, 'Rechazado por Jefe Unidad', 'granate-bg', 'white-text', 1),
(10, 'Respondido', 5, 'Se responde el memo a Unidad origen', 'indigo-bg', 'white-text', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estado_flujo`
--

CREATE TABLE `memo_estado_flujo` (
  `memo_estado_flujo_estado_id` int(11) NOT NULL,
  `memo_estado_flujo_estado_id_hijo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_estado_flujo`
--

INSERT INTO `memo_estado_flujo` (`memo_estado_flujo_estado_id`, `memo_estado_flujo_estado_id_hijo`) VALUES
(1, 3),
(1, 4),
(1, 5),
(2, 3),
(2, 4),
(2, 5),
(4, 7),
(4, 8),
(4, 9),
(5, 6),
(6, 5),
(8, 5),
(8, 11),
(9, 10),
(11, 12),
(11, 13),
(12, 5),
(12, 14),
(13, 10),
(15, 10),
(16, 18),
(16, 19),
(16, 20),
(17, 20),
(17, 22),
(17, 26),
(26, 27),
(27, 24),
(27, 25),
(27, 28),
(27, 29),
(29, 30),
(31, 33),
(31, 34),
(31, 35),
(32, 33),
(32, 34),
(32, 35),
(34, 37),
(34, 38),
(34, 39),
(35, 36),
(36, 35),
(38, 40),
(39, 40),
(4, 5),
(34, 35),
(6, 4),
(36, 34);

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

--
-- Volcado de datos para la tabla `memo_observaciones`
--

INSERT INTO `memo_observaciones` (`memo_observaciones_id`, `memo_observaciones_texto`, `memo_observaciones_fecha`, `memo_observaciones_memo_id`, `memo_observaciones_usuario_id`) VALUES
(1, 'agrego comentario', '2019-09-05 00:53:22', 3, 7),
(2, 'otra cosa', '2019-09-05 00:58:39', 3, 7),
(3, 'otra obs', '2019-09-05 01:00:08', 3, 7),
(4, 'nueva observacion', '2019-09-05 01:09:43', 3, 4),
(9, 'observacion', '2019-09-05 01:26:47', 4, 2),
(10, 'otra obs', '2019-09-05 01:27:17', 4, 4);

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

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_nombre`, `menu_url`, `menu_descripcion`, `menu_estado`) VALUES
(1, 'Buscador', '', 'Buscador de memos', 1),
(2, 'Memo', '', 'Todo sobre el memo', 1),
(3, 'Detalle Memo', '', 'Detalle del memo, informativos, ordenes de compra, etc', 1),
(4, 'Listados', '', 'Listados memos', 1),
(5, 'Informes', '', 'Estadísticas e informes', 1),
(6, 'Mantenedor', '', 'Mantenedor del Administrador de tablas básicas del sistema', 1);

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

--
-- Volcado de datos para la tabla `menuitem`
--

INSERT INTO `menuitem` (`menuitem_id`, `menuitem_nombre`, `menuitem_url`, `menuitem_estado`, `menuitem_menu_id`) VALUES
(1, 'Buscador Simple', 'vs_buscadorsim.php', 1, 1),
(2, 'Buscador Avanzado', 'vs_buscadorav.php', 1, 1),
(3, 'Buscador Admin', 'vs_buscadoradm.php', 1, 1),
(4, 'Ingreso Memo', 'vs_ingresomemo.php', 1, 2),
(5, 'Ingreso Detalle Memo', 'vs_detallememo.php', 1, 2),
(6, 'Listado', 'vs_listadomemos.php', 1, 4),
(7, 'Listado Admin', 'vs_listadomemoadm.php', 1, 4),
(8, 'Listado Asignación', 'vs_listadomemoasigna.php', 1, 4),
(9, 'Informe General', 'vs_informegral.php', 1, 5),
(10, 'Centro de Costos', 'mt_centrocosto.php', 1, 6),
(11, 'Departamentos', 'mt_departamento.php', 1, 6),
(12, 'Dependencias', 'mt_dependencia', 1, 6),
(13, 'Procedimiento de Compra', 'mt_procedimientos.php', 1, 6),
(14, 'Proveedores', 'mt_proveedores.php', 1, 6),
(15, 'Usuarios', 'mt_usuarios.php', 1, 6),
(16, 'Usuarios Rol', 'mt_usuariorol.php', 1, 6),
(17, 'Perfiles', 'mt_perfil.php', 1, 6),
(18, 'Sección', 'mt_seccion.php', 1, 6),
(19, 'Estado Detalle Memo', 'mt_estadodetmemo.php', 1, 6),
(20, 'Estado Memos', 'mt_memoestado.php', 1, 6),
(21, 'Menú', 'mt_menu.php', 1, 6),
(22, 'Menú Item', 'mt_menuitem.php', 1, 6),
(23, 'Menú Item Acciones', 'mt_itemacciones.php', 1, 6),
(24, 'Estado Asignación Memos', 'mt_estadoasignacion.php', 1, 6),
(25, 'Dificultad Asignación', 'mt_asignadificultad.php', 1, 6),
(26, 'Prioridad Asignación', 'mt_asignaprioridad.php', 1, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `perfiles_id` int(11) NOT NULL,
  `perfiles_nombre` varchar(25) NOT NULL,
  `perfiles_descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`perfiles_id`, `perfiles_nombre`, `perfiles_descripcion`) VALUES
(1, 'Administrador', 'Tiene todos los permisos para la administración del portal'),
(2, 'Jefe Departamento', 'Permiso para asignar tareas y algunos permiso de admin'),
(3, 'Supervisor', 'Solo algunos permisos Jefe de Depto. y de Administrador'),
(4, 'Analista', 'Permisos para gestión de los memos de adquisiciones'),
(5, 'Secretaria', 'Permisos de ingreso y recepción de Memos, cambios estados memos y listados memos'),
(6, 'Gestión Pago', 'Permisos para listar memos y gestionar los pagos de facturas'),
(7, 'Observador', 'Permisos solo de lecturas a listados e informes');

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

--
-- Volcado de datos para la tabla `procedimiento_compra`
--

INSERT INTO `procedimiento_compra` (`proc_compra_id`, `proc_compra_tipo`, `proc_compra_orden`, `proc_compra_descripcion`, `proc_compra_activo`) VALUES
(1, 'Convenio Marco (CM)', 2, 'Valor de compra hasta 1000 UTM', 1),
(2, 'Compra Menor a 3 UTM', 3, 'Compras menores a 3 UTM', 1),
(3, 'Gran compra', 4, 'Gran compra', 1),
(4, 'Licitacion Publica / Privada', 5, 'Licitacion Publica / Privada', 1),
(5, 'Trato directo', 6, 'Trato directo', 1),
(6, 'Caja Chica', 1, 'Caja chica del departamento solicitante', 1);

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

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `proveedor_rut`, `proveedor_nombre`, `proveedor_direccion`, `proveedor_fono`, `proveedor_ciudad`, `proveedor_region`, `proveedor_cuenta`, `proveedor_contacto_nombre`, `proveedor_contacto_email`, `proveedor_contacto_fono`, `proveedor_estado`) VALUES
(1, '96781350-8', 'EDENRED CHILE SOCIEDAD ANONIMA', 'Andrés Bello 2687', '+56223539000', 'Las Condes', 'Metropolitana', '', 'Juan Perez', 'jperez@edenred.cl', '+56223539001', 'Activo'),
(2, '96775870-1', 'WEI CHILE S.A.', 'Avda. Pedro de Valdivia 2550', '+56223790000', 'Ñuñoa', 'Metropolitana', '', 'Jose Garcia García', 'jgarcia@wei.cl', '+56223790020', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo`
--

CREATE TABLE `tipo_archivo` (
  `tipo_archivo_id` int(11) NOT NULL,
  `tipo_archivo_nombre` varchar(80) NOT NULL,
  `tipo_archivo_activo` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_archivo`
--

INSERT INTO `tipo_archivo` (`tipo_archivo_id`, `tipo_archivo_nombre`, `tipo_archivo_activo`) VALUES
(1, 'Memo Escaneado', 1),
(2, 'Anexo Memo', 1),
(3, 'Anexo Detalle Memo', 1),
(4, 'Factura', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `tipo_doc_id` int(11) NOT NULL,
  `tipo_doc_nombre` varchar(60) DEFAULT NULL,
  `tipo_doc_estado` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`tipo_doc_id`, `tipo_doc_nombre`, `tipo_doc_estado`) VALUES
(1, 'Memo', 1),
(2, 'Circular', 1);

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

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `usuario_rut`, `usuario_nombre`, `usuario_email`, `usuario_password`, `usuario_usu_rol_id`, `usuario_fecha_ingreso`, `usuario_urlimg`, `usuario_estado`) VALUES
(1, '1-9', 'Administrador', 'soportedesarrollo@umce.cl', '123456', 1, '2019-06-07 19:44:39', NULL, 1),
(2, '2-7', 'María José Garcés', 'mjose.garces@umce.cl', '123456', 2, '2019-06-07 20:59:12', NULL, 1),
(3, '5-1', 'jany', 'jany@umce.cl', '123456', 4, '2019-06-10 16:02:40', NULL, 1),
(4, '3-5', 'Jorge', 'jorge@umce.cl', '123456', 3, '2019-06-10 22:24:14', NULL, 1),
(5, '13-7', 'Susana', 'susana@umce.cl', '123456', 4, '2019-06-13 21:08:41', NULL, 1),
(6, '12-5', 'Juan Perez', 'jperez@umce.cl', '123456', 7, '2019-06-18 23:21:07', NULL, 1),
(7, '4-3', 'Lorena ', 'lorena@umce.cl', '123456', 3, '2019-07-26 15:22:11', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `usu_rol_id` int(11) NOT NULL,
  `usu_rol_nombre` varchar(64) NOT NULL,
  `usu_rol_descripcion` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`usu_rol_id`, `usu_rol_nombre`, `usu_rol_descripcion`) VALUES
(1, 'Administrador', NULL),
(2, 'Jefa Adquisiciones', NULL),
(3, 'Analista', NULL),
(4, 'Secretaria', NULL),
(5, 'Administrativo Adquisiciones', NULL),
(6, 'Director', NULL),
(7, 'Jefe Departamento', NULL);

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
-- Volcado de datos para la tabla `usu_perfiles`
--

INSERT INTO `usu_perfiles` (`usu_perfiles_usuario_id`, `usu_perfiles_perfiles_id`, `usu_perfiles_fecha`) VALUES
(1, 1, '2019-06-07 20:29:44'),
(2, 2, '2019-07-26 15:22:58'),
(2, 4, '2019-07-26 15:22:58'),
(3, 5, '2019-06-10 20:25:44'),
(4, 3, '2019-06-10 22:24:39'),
(4, 4, '2019-06-10 22:24:39'),
(5, 5, '2019-06-13 21:08:54'),
(6, 2, '2019-06-18 23:21:23'),
(7, 4, '2019-07-26 15:22:48');

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
  ADD KEY `fk_detalle_memo_memo1_idx` (`detmemo_memo_id`),
  ADD KEY `fk_detalle_memo_centro_costos1_idx` (`detmemo_cc_codigo`);

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
  ADD KEY `fk_memo_tipo_documento1_idx` (`memo_tipo_doc_id`);

--
-- Indices de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD PRIMARY KEY (`memo_archivo_id`),
  ADD KEY `fk_memo_archivo_memo1_idx` (`memo_archivo_memo_id`),
  ADD KEY `fk_memo_archivo_tipo_archivo1_idx` (`memo_archivo_tipo_archivo_id`);

--
-- Indices de la tabla `memo_cdp`
--
ALTER TABLE `memo_cdp`
  ADD PRIMARY KEY (`memo_cdp_id`),
  ADD KEY `fk_memo_cdp_centro_costos1_idx` (`memo_cdp_cc_codigo`),
  ADD KEY `fk_memo_cdp_memo1_idx` (`memo_cdp_memo_id`);

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
  MODIFY `asigna_usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `asocia_resolucion`
--
ALTER TABLE `asocia_resolucion`
  MODIFY `asocia_resolucion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cambio_estados`
--
ALTER TABLE `cambio_estados`
  MODIFY `cambio_estados_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

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
  MODIFY `detmemo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  MODIFY `memo_archivo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_cdp`
--
ALTER TABLE `memo_cdp`
  MODIFY `memo_cdp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `memo_derivado`
--
ALTER TABLE `memo_derivado`
  MODIFY `memo_derivado_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

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
  MODIFY `memo_observaciones_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `fk_memo_has_memo_resoluciones_memo1` FOREIGN KEY (`asocia_resolucion_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_detalle_memo_centro_costos1` FOREIGN KEY (`detmemo_cc_codigo`) REFERENCES `centro_costos` (`cc_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  ADD CONSTRAINT `fk_memo_tipo_documento1` FOREIGN KEY (`memo_tipo_doc_id`) REFERENCES `tipo_documento` (`tipo_doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD CONSTRAINT `fk_memo_archivo_memo1` FOREIGN KEY (`memo_archivo_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_archivo_tipo_archivo1` FOREIGN KEY (`memo_archivo_tipo_archivo_id`) REFERENCES `tipo_archivo` (`tipo_archivo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_cdp`
--
ALTER TABLE `memo_cdp`
  ADD CONSTRAINT `fk_memo_cdp_centro_costos1` FOREIGN KEY (`memo_cdp_cc_codigo`) REFERENCES `centro_costos` (`cc_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_cdp_memo1` FOREIGN KEY (`memo_cdp_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
