-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-08-2018 a las 16:38:37
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.4

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
-- Estructura de tabla para la tabla `centro_costos`
--

CREATE TABLE `centro_costos` (
  `cc_codigo` int(11) NOT NULL,
  `cc_nombre` varchar(150) DEFAULT NULL,
  `cc_dependencia_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `centro_costos`
--

INSERT INTO `centro_costos` (`cc_codigo`, `cc_nombre`, `cc_dependencia_codigo`) VALUES
(100000, 'Macul', 100000),
(101000, 'Rectoría', 101000),
(101100, 'RECTORIA', 101000),
(101101, 'RECTORIA APORTES', 101000),
(102000, 'Prorrectoría', 102000),
(102100, '(PRORRECTORIA)', 102000),
(102200, 'DIRECCION DE RELACIONES INSTITUCIONALES Y CO', 102000),
(102201, 'CARICOM', 102000),
(103000, 'Secretaría General', 103000),
(103100, 'SECRETARIA GENERAL', 103000),
(103101, 'CEREMONIAS DE TITULACION', 103000),
(103200, 'DEPTO JURIDICO', 103000),
(103300, 'SUBDEPTO DE TITULOS Y GRADOS', 103000),
(103400, 'SECCION PARTES Y ARCHIVO', 103000),
(104000, 'Contraloría Interna', 104000),
(104100, 'CONTRALORIA INTERNA', 104000),
(105000, 'Dirección de Planificación y Presupuesto', 105000),
(105100, 'DIRECCION DE PLANIFICACION Y PRESUPUESTO', 105000),
(105101, 'PROY/ FDI LINEA INSTITUCIONAL AÑOS ANTERIORES', 105000),
(105102, 'PROY/ FDI LINEA INSTITUCIONAL 2011', 105000),
(105103, 'MECESUP UMC0105', 105000),
(105104, 'MECESUP UMC0204', 105000),
(105105, 'MECESUP UMC0302', 105000),
(105106, 'MECESUP AUS0307', 105000),
(105107, 'MECESUP UMC0402', 105000),
(105108, 'MECESUP UMC0404', 105000),
(105109, 'MECESUP UMC0602', 105000),
(105110, 'MECESUP UCH0610', 105000),
(105111, 'MECESUP UCO0608', 105000),
(105112, 'MECESUP UMC0701', 105000),
(105113, 'MECESUP UMC0802', 105000),
(105114, 'MECESUP UMC0803', 105000),
(105115, 'MECESUP ULS0602', 105000),
(105116, 'MECESUP USA0608', 105000),
(105117, 'PROY/FONDO DE FORTALECIMIENTO UNIV. CRUCH 20', 105000),
(105118, 'PROY/UMC1101 CONVENIO DE DESEMPEÑO DEPTO. FI', 105000),
(105119, 'PROY/UMC1111 CONVENIO DE DESEMPEÑO DEPTO. DE', 105000),
(105120, 'PROY/FDI \" CENTRO DE FORMACION DE HABILIDADES CLINICAS UMCE\"', 105000),
(105121, 'PROY/FDI \" FORTALECIMIENTO DE LOS PROCESOS DE GESTION DE LOS PLANES\"', 105000),
(105122, 'PROY/FDI \" CAMINANDO HACIA LA INCLUSION\"', 105000),
(105123, 'PROY/UMC1398 BASAL 2', 105000),
(105124, 'PROY/UMC1302 PLAN DE MEJORAMIENTO FAC. CIENCIAS BASICAS', 105000),
(105126, 'PROY/PM UMC 1404 MODELO IMNOVADOR', 105000),
(105127, 'PROY/PM UMC1406 CENTRO DE ACOMPAÑAMIENTO', 105000),
(105128, 'PROY/FDI TALLERES RIZOMA', 105000),
(105129, 'PROY/FDI TALLER DE GRABADO LICEO A5', 105000),
(105130, 'PROY/FDI INVERNADERO PLANTAS MEDICINALES', 105000),
(105131, 'PROY/FDI CRA ESTUDIANTES DE MATEMATICAS', 105000),
(105132, 'PROY/FDI PROGRAMA VIVA LA DIFERENCIA', 105000),
(105133, 'PROY/PMI UMC 1501', 105000),
(105134, 'PROY/CM UMCE 1555 (CONVENIO MARCO)', 105000),
(105135, 'PROY/UMC1503 CURSO PROPEDEUTICO MUSICAL', 105000),
(105136, 'PROY/UMC1504 PRACTICAS FISICAS INCLUSIVAS', 105000),
(105137, 'PROY/UMC1506 MODER. GESTION SERVICIO BIBLIOTECA', 105000),
(105138, 'PROY/PILOTO DIAGNOSTICO Y DISEÑO DE PLANES', 105000),
(105139, 'PROY/UMC1507', 105000),
(105140, 'PROY/UMC1655', 105000),
(105141, 'PROY/UMC1656', 105000),
(105200, 'UNIDAD DE ANALISIS INSTITUCIONAL', 105000),
(105201, 'PROY/FONDO BASAL UMC1298', 105000),
(105202, 'PROY/FONDO DE FORTA. 2DA ETAPA UMCE1299', 105000),
(106000, 'Vicerrectoría Académica', 106000),
(106100, 'VICERRECTORIA ACADEMICA', 106000),
(106101, 'DIRECCION DE ASEGURAMIENTO DE LA CALIDAD', 106000),
(106102, 'CENTRO DE FORMACION VIRTUAL', 106000),
(106103, 'PROCESO DE ACREDITACION', 106000),
(106104, 'PORTAL SIMEDD', 106000),
(106106, 'PROY/PROGRAMA PACE', 106000),
(106107, 'PACE UMC1677', 106000),
(106200, 'DIRECCION DE DOCENCIA', 106000),
(106201, 'PROCESO DE MATRICULA', 106000),
(106202, 'PROGRAMA PROPEDEUTICO', 106000),
(106300, 'DIRECCION DE INVESTIGACION', 106000),
(106301, 'FONDOS CENTRALES DE INVESTIGACION', 106000),
(106302, 'PROY/ FONDECYT-CONICYT', 106000),
(106303, 'PROYECTO COPEC', 106000),
(106304, 'PROY/EXPLORA-CONICYT: ED16/046:LAS LEVADURAS', 106000),
(106305, 'PROY/FONDEF:D10/1038: RED DE INFORMACION', 106000),
(106306, 'PROY. FONIDE F611145', 106000),
(106307, 'PROY/CORFO \"DESARROLLO DE NANOBIOMATERIALES\"', 106000),
(106308, 'PROY/FONDEF IDeA CA12i10075', 106000),
(106309, 'PROY/INACH \" SELECTIVIDAD Y ESPECIFIDAD...\"R. VARGAS', 106000),
(106310, 'PROY/ENIN-UMCE', 106000),
(106311, 'PROY/FONIDE F811345-2013', 106000),
(106312, 'PROY/FONIS EVS 13I0052', 106000),
(106313, 'PROY/FIC-R ELABORACION NANOBIOMATERIALES', 106000),
(106400, 'DIRECCION DE EXTENSION Y COMUNICACIONES', 106000),
(106401, 'FONDOS CENTRALES DE EXTENSION', 106000),
(106402, 'FONDO EDITORIAL', 106000),
(106403, 'PROY / FONDEF PICALAB', 106000),
(106404, 'WEB Y MARKETING', 106000),
(106500, 'DEPTO DE MEDIOS EDUCATIVOS', 106000),
(106501, 'SUBDEPTO DE IMPRESIONES', 106000),
(106600, 'BIBLIOTECA CENTRAL', 106000),
(106700, 'SUBDEPTO DE ADMISION Y REGISTRO CURRICULAR', 106000),
(106800, 'COORDINACION DE PRACTICA PROFESIONAL', 106000),
(106900, 'COORDINACION DE EDUCACION CONTINUA', 106000),
(106901, 'PROY/ APROPIACION CURRICULAR AÑOS ANTERIORES', 106000),
(106902, 'PROY/ APROPIACION CURRICULAR', 106000),
(106903, 'PROY/ POSTITULOS DE MENCION AÑOS ANTERIORES', 106000),
(106904, 'PROY/ POSTITULOS DE MENCION 1er CICLO 2010/1', 106000),
(106905, 'PROY/ POSTITULOS DE MENCION 2DO CICLO 2010/1', 106000),
(106906, 'PROY/ PERFECCIONAMIENTO DOCENTE ATACAMA', 106000),
(106907, 'PROY/ AT ESCUELAS MUNICIPALES AYSEN', 106000),
(106908, 'PROY/ PERFECCIONAMIENTO DOCENTE PUERTO MONTT', 106000),
(106909, 'PROY/ LICEOS PRIORITARIOS VI Y XI REGION', 106000),
(106910, 'PROY/ LICEOS PRIORITARIOS MATER DEI', 106000),
(106911, 'PROY/ CURSOS DE PERFECCIONAMIENTO', 106000),
(106912, '(POST. MENCION TECNICO PROF. CPEIP 2012)', 106000),
(106913, 'PROY/POSTITULOS DE MENCION 1er CICLO 2011/12', 106000),
(106914, 'PROY/DIP. EDUC. MAT. 3° A 8° E. BASICA (ARQU', 106000),
(106915, 'PROY/ SERVICIO DE DISEÑO Y EJECUCION DE POST', 106000),
(106916, 'PROY/ DIPLOMADO EQUIPOS DIRECTIVOS QUILLOTA', 106000),
(106917, 'PROY/ASISTENCIA TECNICA CHUQUICAMATA', 106000),
(106918, 'PROY/FORT.FORMACIÓN TÉCNICO PROF.AGROPECUARI', 106000),
(106919, 'DILPOMADO EN GESTION DE SEGURIDAD ESCOLAR', 106000),
(106920, 'PROY/PROGRAMA DE FORMACION DE TECNICOS DE NIVEL SUPERIOR PARA AGENTES EDUCATIVAS DE JARDINES', 106000),
(106921, 'PROY. POSTITULO DE MENCION CS. NATURALES GRANEROS', 106000),
(106922, 'PROY/PROGRAMA DE INDAGACION CIENTIFICA', 106000),
(107000, 'Dirección de Postgrado', 107000),
(107100, 'DIRECCION DE POSTGRADO', 107000),
(107101, 'MAGISTER EDUC MENCION CURRICULUM EDUCACIONAL', 107000),
(107102, 'PACE', 107000),
(107103, 'MAGISTER EDUC MENCION GESTION EDUCACIONAL', 107000),
(107104, 'MAGISTER EDUC MENCION PEDAGOGIA Y GESTION UN', 107000),
(107105, 'MAGISTER ENSEÑ-APRENDIZAJE DEL INGLES (TEFL)', 107000),
(107106, 'MAGISTER EDUC DIFERENCIAL NECESIDADES MULTIP', 107000),
(107107, 'MAGISTER EN ESTUDIOS CLASICOS LENGUAS GRIEGA', 107000),
(107108, 'MAGISTER EN ESTUDIOS CLASICOS CULTURA GRECO', 107000),
(107109, 'MAGISTER EDUC EN SALUD Y BIENESTAR HUMANO', 107000),
(107110, 'MAGISTER EN GESTION DEPORTIVO', 107000),
(107111, 'MAGISTER EDUC MOTRIZ Y SALUD ADULTO MAYOR', 107000),
(107112, 'MAGISTER EN CIENCIAS MENCION EN ENTOMOLOGIA', 107000),
(107113, 'MAGISTER EN DIDACTICA DE LA LENGUA Y LA LIT.', 107000),
(107200, '(PROGRAMAS DE DOCTORADO)', 107000),
(107201, 'DOCTORADO EN EDUCACION', 107000),
(107202, 'DOCTORADO EN CIENCIAS DE LA MOTRICIDAD HUMAN', 107000),
(107300, 'PROGRAMA DE GRADUACION EXTRAORDINARIA', 107000),
(108000, 'Coordinación Programas ETP y Educación Adulto', 108000),
(108100, 'COORDINACION DE PROGRAMAS ETP Y EDUC ADULTOS', 108000),
(108101, 'PROGRAMA DE REG. DE TITULO PARA ETP', 108000),
(108102, 'CONVENIO UMCE - MUNICIPALIDAD DE SALAMANCA', 108000),
(109000, 'Dirección de Asuntos Estudiantiles', 109000),
(109100, 'DIRECCION DE ASUNTOS ESTUDIANTILES', 109000),
(109101, 'PROY/ SALA CUNA JUNJI', 109000),
(109102, 'PROY/ FDI AÑOS ANTERIORES', 109000),
(109103, 'PROY/ FDI PARQUE DEPORTIVO MACUL', 109000),
(109104, 'PROY/ FDI 2011', 109000),
(109105, 'PROY/ FDI 2012', 109000),
(109106, 'PRE UNIVERSITARIO SOLIDARIO UMCE', 109000),
(109200, 'SUBDEPTO DE SERVICIOS ESTUDIANTILES', 109000),
(109300, 'SUBDEPTO DE SALUD ESTUDIANTIL', 109000),
(109301, 'CENTRO DE SALUD', 109000),
(109400, 'SUBDEPTO DE DEPORTES, CULTURA Y RECREACIÓN', 109000),
(109500, 'FEP', 109000),
(110000, 'Dirección de Administración y Finanzas', 110000),
(110100, 'DIRECCION DE ADMINISTRACION Y FINANZAS', 110000),
(110101, 'PROYECTO DE RECONSTRUCCION', 110000),
(110200, 'DEPTO DE FINANZAS', 110000),
(110201, 'CENTRO DE FOTOCOPIADO', 110000),
(110202, 'FONDO SOLIDARIO DE CREDITO UNIVERSITARIO', 110000),
(110211, '(SUBDPTO ADQUISICIONES)', 110000),
(110212, '(SBDPTO DE CONTROL DE GESTION)', 110000),
(110213, '(SUBDPTO DE NORMALIZACION)', 110000),
(110214, '(SUBDPTO DE TESORERIA)', 110000),
(110215, '(SUBDPTO DE CONTABILIDAD)', 110000),
(110300, 'DEPTO DE PERSONAL', 110000),
(110301, 'SUBDEPTO CENTRO INFANTIL', 110000),
(110302, 'SUBDEPTO DE BIENESTAR DEL PERSONAL', 110000),
(110311, '(SUBDPTO DE REMUNERACIONES)', 110000),
(110312, '(SUBDPTO ADMINISTR. DE PERSONAL)', 110000),
(110400, 'DEPTO DE INFRAESTRUCTURA', 110000),
(110401, 'SUBDEPTO DE ADMINISTRACION DE BIENES', 110000),
(110402, 'SECCION BODEGA', 110000),
(110403, 'SUBDEPTO DE ADMINISTRACION DE SERVICIOS', 110000),
(110404, 'SECCION PORTERIA', 110000),
(110405, 'SECCION TRANSPORTES', 110000),
(110406, 'PREVENCION DE RIESGOS', 110000),
(110407, 'SECCION TALLERES', 110000),
(110500, 'DEPTO DE INFORMATICA', 110000),
(110601, '(PROY/ DIC. BILINGUE LENGUA DE SEÑAS CHILENA', 110000),
(110603, 'LIC. EN EDUC. DIF. PROBLEMAS DE APRENDIZAJE', 110000),
(110604, 'LIC. EN EDUC. DIF. PROBLEMAS DE AUDICION Y L', 110000),
(110605, 'LIC. EN EDUC. DIF. PROBLEMAS DE VISION', 110000),
(110606, 'LIC. EN EDUC. DIF. RETARDO MENTAL', 110000),
(110607, '(POST. INTERP. EN LENGUA DE SEÑAS CHILENA)', 110000),
(111000, 'Facultad de Filosofía y Educación', 111000),
(111100, 'DECANATO DE FILSOFIA Y EDUCACION', 111000),
(111101, 'DIPLOMADO EN DIRECCION ESCOLAR DE EXCELENCIA', 111000),
(111102, 'Proyecto convenio Conadi', 111000),
(111200, 'DEPTO DE FILOSOFIA', 111000),
(111300, 'DEPTO DE FORMACION PEDAGOGICA', 111000),
(111400, 'DEPTO DE EDUCACION PARVULARIA', 111000),
(111401, 'DIPLOMADO DE EDUCACION PARVULARIA', 111000),
(111500, 'DEPTO DE EDUCACION GENERAL BASICA', 111000),
(111600, 'DEPTO DE EDUCACION DIFERENCIAL', 111000),
(111601, 'PROY/DICCIONARIO LENGUA DE SEÑAS CHILENA VD', 111000),
(111602, '(PROY/ DISCAPACIDAD MULTIPLE 2010)', 111000),
(111607, 'PROY/SENADIS 13-408-2012', 111000),
(111608, 'PROY/POSTITULO DE LENGUA DE SEÑAS CHILENA', 111000),
(111609, 'CONV.DOCENTE ASISTENCIAL U.ANDRES BELLO', 111000),
(111611, 'PROY/SENADIS 13-508-2015', 111000),
(111700, 'DEPTO DE RELIGION', 111000),
(111701, 'LIC. EN EDUC. PED. EDUC.BASICA C/M REL. EVAN', 111000),
(112000, 'Facultad de Historia, Geografía y Letras', 112000),
(112100, 'DECANATO DE HISTORIA, GEOGRAFIA Y LETRAS', 112000),
(112101, 'LABORATORIO IDIOMAS Y SIST MULTIMEDIAS LISIM', 112000),
(112102, 'MAGISTER EN CULTURA E IDENTIDAD LATINOAMERIC', 112000),
(112200, 'DEPTO DE HISTORIA Y GEOGRAFIA', 112000),
(112300, 'DEPTO DE ALEMAN', 112000),
(112500, 'DEPTO DE FRANCES', 112000),
(112600, 'DEPTO DE INGLES', 112000),
(112700, 'CENTRO DE ESTUDIOS CLASICOS', 112000),
(112701, 'LICENCIATURA EN FILOSOFIA GRIEGA Y LATINA', 112000),
(112800, 'DEPTO DE CASTELLANO', 112000),
(112801, 'MAGISTER EN DIDACTICA DE LA LENGUA Y LIETRAT', 112000),
(113000, 'Facultad de Ciencias Básicas', 113000),
(113100, 'DECANATO DE CIENCIAS BASICAS', 113000),
(113101, 'PROY/ ECBI', 113000),
(113200, 'DEPTO DE BIOLOGIA', 113000),
(113300, 'DEPTO DE FISICA', 113000),
(113301, 'PROY/ ESO', 113000),
(113302, 'PROY/ OBSERVATORIO TURISTICO PAILALEN', 113000),
(113400, 'DEPTO DE MATEMATICAS', 113000),
(113401, 'PROY/ MULTIGRADO VI REGION', 113000),
(113402, '(PROY/ INTEL EDUCAR)', 113000),
(113403, '(PROY/ MINEDUC TIC 7° BASICO)', 113000),
(113404, '(PROY/ TIC FID UMCE)', 113000),
(113405, '(PROY/ ELABORACION ITEMS MAT SINCE)', 113000),
(113500, 'DEPTO DE QUIMICA', 113000),
(113600, 'INSTITUTO DE ENTOMOLOGIA', 113000),
(114000, 'Facultad de Artes y Educación Física', 114000),
(114100, 'DECANATO DE ARTES Y EDUCACION FISICA', 114000),
(114101, 'PROY/ DESPUES DE CLASES', 114000),
(114200, 'DEPTO DE ARTES VISUALES', 114000),
(114300, 'DEPTO DE EDUCACION MUSICAL', 114000),
(114301, 'LICENCIATURA EN MUSICA', 114000),
(114302, 'LIC. EN MUSICA Y DIRECCION DE AGRUPACIONES M', 114000),
(114303, 'ESCUELA MUSICAL VESPERTINA', 114000),
(114400, 'DEPARTAMENTO DE EDUCACION FISICA (DEFDER)', 114000),
(114500, 'DEPTO DE KINESIOLOGIA', 114000),
(114501, 'PROY/ POSTITULO ATENCION PRIMARIA (APS)', 114000),
(114551, 'MAGISTER EN KINESIOLOGIA Y BIOMECANICA CLINI', 114000),
(115000, 'Ingresos Centrales', 115000),
(115100, 'INGRESOS CENTRALES', 115000),
(116000, 'Gastos Centrales', 116000),
(116100, 'GASTOS CENTRALES', 116000),
(200000, 'Defder', 200000),
(201000, 'Defder', 200000),
(201100, 'ADMINISTRACION DEFDER', 200000),
(300000, 'Sede Graneros', 300000),
(301000, 'Sede Graneros', 301000),
(301100, 'SEDE GRANEROS', 301000),
(301101, 'Lic. en Educ. y Pedagogía en Educ. Parvulari', 301000),
(301102, 'Lic. en Educ. y Pedagogía en Educ. Gral. Bás', 301000),
(301103, 'Progr. Especial de Licenciatura en Educacion', 301000),
(400000, 'Liceo Mercedes Marin Del Solar', 400000),
(400100, 'Liceo', 400000),
(400101, 'Liceo Mercedes Marin', 400000),
(500000, 'Fundación UMCE', 500000),
(500100, 'Fundación UMCE', 500000),
(500101, 'BIENES Y MATERIALES', 500000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `dpto_id` int(11) NOT NULL,
  `dpto_nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`dpto_id`, `dpto_nombre`) VALUES
(1, 'ADMISION Y REGISTRO CURRICULAR'),
(2, 'CAMPUS JOAQUIN CABEZAS GARCIAS'),
(3, 'CENTRO DE ACOMPAÑAMIENTO AL APRENDIZAJE'),
(4, 'CENTRO DE ESTUDIOS CLASICOS'),
(5, 'CENTRO DE FORMACION VIRTUAL'),
(6, 'CONTRALORIA INTERNA'),
(7, 'COORDINACION GENERAL DE PRACTICAS'),
(8, 'DEPARTAMENTO DE ALEMÁN'),
(9, 'DEPARTAMENTO DE ARTES VISUALES'),
(10, 'DEPARTAMENTO DE BIENESTAR DEL PERSONAL '),
(11, 'DEPARTAMENTO DE BIOLOGIA '),
(12, 'DEPARTAMENTO DE CASTELLANO'),
(13, 'DEPARTAMENTO DE DESARROLLO DE LAS PERSONAS'),
(14, 'DEPARTAMENTO DE EDUCACION BASICA'),
(15, 'DEPARTAMENTO DE EDUCACION DIFERENCIAL'),
(16, 'DEPARTAMENTO DE EDUCACION FISICA'),
(17, 'DEPARTAMENTO DE EDUCACION FISICA, DEPORTES Y RECREACION'),
(18, 'DEPARTAMENTO DE EDUCACION PARVULARIA'),
(19, 'DEPARTAMENTO DE FILOSOFIA'),
(20, 'DEPARTAMENTO DE FINANZAS'),
(21, 'DEPARTAMENTO DE FISICA'),
(22, 'DEPARTAMENTO DE FORMACION PEDAGOGICA'),
(23, 'DEPARTAMENTO DE HISTORIA Y GEOGRAFIA Y LETRAS'),
(24, 'DEPARTAMENTO DE INFORMATICA'),
(25, 'DEPARTAMENTO DE INGLES'),
(26, 'DEPARTAMENTO DE KINESIOLOGIA'),
(27, 'DEPARTAMENTO DE MATEMATICA'),
(28, 'DEPARTAMENTO DE MEDIOS EDUCATIVOS'),
(29, 'DEPARTAMENTO DE MUSICA'),
(30, 'DEPARTAMENTO DE PERSONAL'),
(31, 'DEPARTAMENTO DE QUIMICA'),
(32, 'DEPARTAMENTO DE RECURSOS HUMANOS'),
(33, 'DEPARTAMENTO JURIDICO'),
(34, 'DIRECCION DE ADMINISTRACION'),
(35, 'DIRECCION DE ASEGURAMIENTO DE LA CALIDAD'),
(36, 'DIRECCION DE ASUNTOS ESTUDIANTILES'),
(37, 'DIRECCION DE BIBLIOTECAS'),
(38, 'DIRECCION DE DOCENCIA '),
(39, 'DIRECCION DE EDUCACION CONTINUA '),
(40, 'DIRECCION DE EXTENSION Y VINCULACION CON EL MEDIO'),
(41, 'DIRECCION DE INVESTIGACION'),
(42, 'DIRECCION DE POSTGRADO'),
(43, 'DIRECCION DE RELACIONES INSTITUCIONALES Y COOPERACION INTERNACIONAL'),
(44, 'DRICI'),
(45, 'FACULTAD DE ARTES Y ED. FISICA'),
(46, 'FACULTAD DE CIENCIAS BASICAS'),
(47, 'FACULTAD DE FILOSOFIA DECANATO'),
(48, 'FACULTAD DE HISTORIA GEOGRAFIA Y LETRAS'),
(49, 'FONDO SOLIDARIO DE CREDITO UNIVERSITARIO'),
(50, 'INFRAESTRUCTURA'),
(51, 'INSTITUTO DE ENTOMOLOGIA'),
(52, 'PLANIFICACION'),
(53, 'RECTORIA'),
(54, 'RED CAMPUS SUSTENTABLE'),
(55, 'SECCION ASEO Y ORNATO'),
(56, 'SECCION BODEGA'),
(57, 'SECCION DE PARTES Y ARCHIVO'),
(58, 'SECRETARIA GENERAL'),
(59, 'SEDE GRANEROS'),
(60, 'SERVICIO DE BIENESTAR DE PERSONAL'),
(61, 'SERVICIO Y MANTENCION'),
(62, 'SIMEDPRO'),
(63, 'SUBDEPARTAMENTO DE ADMINISTRACION DE BIENES'),
(64, 'SUBDEPARTAMENTO DE BIENESTAR ESTUDIANTIL'),
(65, 'SUBDEPARTAMENTO DE CENTRO INFANTIL '),
(66, 'SUBDEPARTAMENTO DE REMUNERACIONES'),
(67, 'SUBDEPARTAMENTO DE SALUD ESTUDIANTIL'),
(68, 'SUBDEPARTAMENTO DE SERVICIOS ESTUDIANTILES'),
(69, 'SUBDEPARTAMENTO DE TESORERIA'),
(70, 'SUBDEPARTAMENTO DE TITULOS Y GRADOS '),
(71, 'SUBDEPTO DE EJERCICIO FISICO SALUD Y DEPORTE'),
(72, 'TENT'),
(73, 'VICERRECTORIA ACADEMICA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `dependencia_codigo` int(11) NOT NULL,
  `dependencia_nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`dependencia_codigo`, `dependencia_nombre`) VALUES
(100000, 'Macul'),
(101000, 'Rectoría'),
(102000, 'Prorrectoría'),
(103000, 'Secretaría General'),
(104000, 'Contraloría Interna'),
(105000, 'Dirección de Planificación Presupuesto'),
(106000, 'Vicerrectoría Académica'),
(107000, 'Dirección de Postgrado'),
(108000, 'Coordinación Programas ETP y Educación Adulto'),
(109000, 'Dirección de Asuntos Estudiantiles'),
(110000, 'Dirección de Administración y Finanzas'),
(111000, 'Facultad de Filosofía y Educación'),
(112000, 'Facultad de Historia, Geografía y Letras'),
(113000, 'Facultad de Ciencias Básicas'),
(114000, 'Facultad de Artes y Educación Física'),
(115000, 'Ingresos Centrales'),
(116000, 'Gastos Centrales'),
(200000, 'Defder'),
(201000, 'Defder'),
(300000, 'Sede Graneros'),
(301000, 'Sede Graneros'),
(400000, 'Liceo Mercedes Marin Del Solar'),
(500000, 'Fundación UMCE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_cambios_tipo`
--

CREATE TABLE `historial_cambios_tipo` (
  `hist_camb_tipo_id` int(11) NOT NULL,
  `hist_camb_tipo_texto` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo`
--

CREATE TABLE `memo` (
  `memo_id` int(11) NOT NULL,
  `memo_num_memo` varchar(10) NOT NULL,
  `memo_anio` smallint(6) DEFAULT NULL,
  `memo_materia` varchar(400) NOT NULL,
  `memo_fecha_memo` date NOT NULL,
  `memo_fecha_recepcion` date NOT NULL,
  `memo_depto_solicitante_id` int(11) NOT NULL,
  `memo_nombre_solicitante` varchar(60) NOT NULL,
  `memo_depto_destinatario_id` int(11) NOT NULL,
  `memo_nombre_destinatario` varchar(60) NOT NULL,
  `memo_memo_estado_id` int(11) NOT NULL,
  `memo_fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo`
--

INSERT INTO `memo` (`memo_id`, `memo_num_memo`, `memo_anio`, `memo_materia`, `memo_fecha_memo`, `memo_fecha_recepcion`, `memo_depto_solicitante_id`, `memo_nombre_solicitante`, `memo_depto_destinatario_id`, `memo_nombre_destinatario`, `memo_memo_estado_id`, `memo_fecha_ingreso`) VALUES
(1, '23', 2018, 'prueba', '2018-07-17', '2018-07-23', 1, 'Pino', 20, 'Leonel Duran', 1, '2018-07-24 20:23:59'),
(2, '25A', 2018, 'Prueba dos memo 25a', '2018-07-19', '2018-07-24', 1, 'Pino', 20, 'Leonel Duran', 1, '2018-07-24 20:28:36'),
(3, '12', 2018, 'Prueba', '2018-07-05', '2018-07-12', 1, 'JUan', 34, 'Leonel Durán', 1, '2018-08-01 15:18:42'),
(4, '12', 2018, 'Prueba de ñoños', '2018-07-09', '2018-07-11', 2, 'José', 34, 'Leonel Durán', 1, '2018-08-01 15:22:12'),
(5, '12', 2018, 'Prueba de ñoños', '2018-07-09', '2018-07-11', 2, 'José', 34, 'Leonel Durán', 1, '2018-08-01 19:08:38'),
(6, '12', 2018, 'Prueba de ñoños', '2018-07-09', '2018-07-11', 2, 'José', 34, 'Leonel Durán', 1, '2018-08-01 19:11:50'),
(7, '12', 2018, 'Prueba de ñoños', '2018-07-09', '2018-07-11', 2, 'José', 34, 'Leonel Durán', 1, '2018-08-01 19:20:13'),
(8, '12', 2018, 'Prueba de ñoños', '2018-07-09', '2018-07-11', 2, 'José', 34, 'Leonel Durán', 1, '2018-08-01 20:36:16'),
(9, '34', 2018, 'Prueba con acéntos malos y ñoñerías', '2018-08-01', '2018-08-08', 1, 'Juan Ñoño', 34, 'Leonel Durán', 1, '2018-08-10 20:19:41'),
(10, '34', 2018, 'Segunda prueba con acéntos malos y ñoñerías', '2018-08-01', '2018-08-08', 4, 'Manuel  Ñoño', 34, 'Leonel Durán', 1, '2018-08-10 20:20:56'),
(11, '56', 2018, 'Tercera prueba con acentós y ñoñerías', '2018-08-02', '2018-08-08', 8, 'José García Nuñez', 34, 'Leonel Durán', 1, '2018-08-10 20:28:03'),
(12, '', 0, '', '0000-00-00', '0000-00-00', 0, '', 34, 'Leonel Durán', 1, '2018-08-13 15:09:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_archivo`
--

CREATE TABLE `memo_archivo` (
  `memo_archivo_id` int(11) NOT NULL,
  `memo_archivo_url` varchar(255) NOT NULL,
  `memo_archivo_name` varchar(255) NOT NULL,
  `memo_archivo_type` varchar(20) NOT NULL,
  `memo_archivo_size` float NOT NULL,
  `memo_archivo_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_archivo_principal_flag` tinyint(4) NOT NULL,
  `memo_archivo_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_archivo`
--

INSERT INTO `memo_archivo` (`memo_archivo_id`, `memo_archivo_url`, `memo_archivo_name`, `memo_archivo_type`, `memo_archivo_size`, `memo_archivo_fecha_registro`, `memo_archivo_principal_flag`, `memo_archivo_memo_id`) VALUES
(1, 'archivos/memo23.pdf', 'memo_registro_curricular_a_finanza.pdf', 'pdf', 123, '2018-07-24 20:27:06', 1, 1),
(2, 'archivos/memo23_otro.pdf', 'cotizacion_memo23.pdf', 'pdf', 230, '2018-07-25 16:27:29', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle`
--

CREATE TABLE `memo_detalle` (
  `memo_det_id` int(11) NOT NULL,
  `memo_det_proc_compra_id` int(11) NOT NULL,
  `memo_det_num_oc_chc` varchar(20) DEFAULT NULL COMMENT 'Numero orden compra chilecompra',
  `memo_det_num_oc_manager` varchar(20) DEFAULT NULL COMMENT 'Numero orden compra manager',
  `memo_det_proveedor_id` int(11) NOT NULL,
  `memo_det_fecha_cdp` date DEFAULT NULL COMMENT 'certificado disponibilidad presupuestaria',
  `memo_det_num_factura` int(11) DEFAULT NULL,
  `memo_det_fecha_factura` date DEFAULT NULL,
  `memo_det_monto_total` float DEFAULT NULL,
  `memo_det_observaciones` varchar(250) DEFAULT NULL,
  `memo_det_memo_id` int(11) NOT NULL,
  `memo_det_cc_codigo` int(11) NOT NULL,
  `memo_det_memo_detalle_estado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_archivo`
--

CREATE TABLE `memo_detalle_archivo` (
  `memo_det_archivo_id` int(11) NOT NULL,
  `memo_det_archivo_url` varchar(200) NOT NULL,
  `memo_det_archivo_name` varchar(255) NOT NULL,
  `memo_det_archivo_type` varchar(20) NOT NULL,
  `memo_det_archivo_size` float NOT NULL,
  `memo_det_archivo_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `memo_det_archivo_memo_det_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_compra`
--

CREATE TABLE `memo_detalle_compra` (
  `memo_det_compra_id` int(11) NOT NULL,
  `memo_det_compra_nombre_producto` varchar(120) DEFAULT NULL,
  `memo_det_compra_cantidad` float DEFAULT NULL,
  `memo_det_compra_valor` float DEFAULT NULL,
  `memo_det_compra_total` float DEFAULT NULL,
  `memo_det_compra_memo_det_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_detalle_estado`
--

CREATE TABLE `memo_detalle_estado` (
  `memo_detalle_estado_id` int(11) NOT NULL,
  `memo_detalle_estado_tipo` varchar(50) NOT NULL,
  `memo_detalle_prioridad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_detalle_estado`
--

INSERT INTO `memo_detalle_estado` (`memo_detalle_estado_id`, `memo_detalle_estado_tipo`, `memo_detalle_prioridad`) VALUES
(1, 'En proceso', 0),
(2, 'Opcion de Compra nula', 0),
(3, 'Sin efecto', 0),
(4, 'Sin gestion', 0),
(5, 'Terminado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_estado`
--

CREATE TABLE `memo_estado` (
  `memo_estado_id` int(11) NOT NULL,
  `memo_estado_tipo` varchar(50) NOT NULL,
  `memo_prioridad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `memo_estado`
--

INSERT INTO `memo_estado` (`memo_estado_id`, `memo_estado_tipo`, `memo_prioridad`) VALUES
(1, 'Ingresado sin Autorizacion', 0),
(2, 'En Proceso', 0),
(3, 'Sin efecto', 0),
(4, 'Sin gestion', 0),
(5, 'Terminado', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_historial_cambios`
--

CREATE TABLE `memo_historial_cambios` (
  `memo_hist_cam_id` int(11) NOT NULL,
  `memo_hist_cam_usuario_id` int(11) NOT NULL,
  `memo_hist_cam_memo_id` int(11) NOT NULL,
  `memo_hist_cam_campo_nombre` varchar(25) NOT NULL,
  `memo_hist_cam_valor_anterior` varchar(255) NOT NULL,
  `memo_hist_cam_valor_nuevo` varchar(255) NOT NULL,
  `memo_hist_cam_tipo_id` int(11) NOT NULL,
  `memo_hist_cam_fecha_modifica` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_relacion`
--

CREATE TABLE `memo_relacion` (
  `memo_relacion_id` int(11) NOT NULL,
  `memo_relacion_origen_id` int(10) UNSIGNED NOT NULL,
  `memo_relacion_destino_id` int(10) UNSIGNED NOT NULL,
  `memo_relacion_relacion_tipo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_relacion_tipo`
--

CREATE TABLE `memo_relacion_tipo` (
  `memo_relacion_tipo_id` int(11) NOT NULL,
  `memo_relacion_tipo_nombre` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_resoluciones`
--

CREATE TABLE `memo_resoluciones` (
  `memo_res_is` int(11) NOT NULL,
  `memo_res_num` varchar(15) NOT NULL,
  `memo_res_url` varchar(300) NOT NULL,
  `memo_res_memo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo_tiene_usuario`
--

CREATE TABLE `memo_tiene_usuario` (
  `memo_tiene_usu_id` int(11) NOT NULL,
  `memo_tiene_usu_memo_id` int(11) NOT NULL,
  `memo_tiene_usu_usuario_id` int(11) NOT NULL,
  `memo_tiene_usu_fecha_asigna` datetime NOT NULL,
  `memo_tiene_usu_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_permisos`
--

CREATE TABLE `perfil_permisos` (
  `perfil_permiso_id` int(11) NOT NULL,
  `perfil_permiso_ingreso` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimiento_compra`
--

CREATE TABLE `procedimiento_compra` (
  `proc_compra_id` int(11) NOT NULL,
  `proc_compra_tipo` varchar(50) NOT NULL,
  `proc_prioridad` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `procedimiento_compra`
--

INSERT INTO `procedimiento_compra` (`proc_compra_id`, `proc_compra_tipo`, `proc_prioridad`) VALUES
(1, 'Convenio Marco (CM)', 0),
(2, 'Compra directa', 0),
(3, 'Gran compra', 0),
(4, 'Licitacion Publica / Privada', 0),
(5, 'Trato directo', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `proveedor_nombre` varchar(180) NOT NULL,
  `proveedor_rut` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `usuario_rut` varchar(10) NOT NULL,
  `usuario_nombre` varchar(60) NOT NULL,
  `usuario_password` varchar(10) NOT NULL,
  `usuario_usu_rol_id` int(11) NOT NULL,
  `usuario_estado` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:creado,1:activo, 2:inactivo (se podria agregar bloqueado y eliminado)',
  `usuario_fecha_ingreso` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_perfil`
--

CREATE TABLE `usuario_perfil` (
  `usu_perfil_id` int(11) NOT NULL,
  `usu_perfil_nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE `usuario_rol` (
  `usu_rol_id` int(11) NOT NULL,
  `usu_rol_nombre` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`usu_rol_id`, `usu_rol_nombre`) VALUES
(1, 'Administrador'),
(2, 'Supevisor'),
(3, 'Analista'),
(4, 'Secretaria');

--
-- Índices para tablas volcadas
--

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
  ADD PRIMARY KEY (`dpto_id`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`dependencia_codigo`);

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
  ADD KEY `fk_memo_memo_estado1_idx` (`memo_memo_estado_id`),
  ADD KEY `idx_memo_depto_solicitante` (`memo_depto_solicitante_id`),
  ADD KEY `idx_memo_depto_destinatario` (`memo_depto_destinatario_id`);

--
-- Indices de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  ADD PRIMARY KEY (`memo_archivo_id`),
  ADD KEY `fk_memo_archivo_memo1_idx` (`memo_archivo_memo_id`);

--
-- Indices de la tabla `memo_detalle`
--
ALTER TABLE `memo_detalle`
  ADD PRIMARY KEY (`memo_det_id`),
  ADD KEY `fk_memo_detalle_memo1_idx` (`memo_det_memo_id`),
  ADD KEY `fk_memo_detalle_proveedor1_idx` (`memo_det_proveedor_id`),
  ADD KEY `fk_memo_detalle_memo_detalle_estado1_idx` (`memo_det_memo_detalle_estado_id`),
  ADD KEY `fk_memo_detalle_procedimiento_compra1_idx` (`memo_det_proc_compra_id`),
  ADD KEY `fk_memo_detalle_centro_costos1_idx` (`memo_det_cc_codigo`);

--
-- Indices de la tabla `memo_detalle_archivo`
--
ALTER TABLE `memo_detalle_archivo`
  ADD PRIMARY KEY (`memo_det_archivo_id`),
  ADD KEY `fk_memo_detalle_archivo_memo_detalle1_idx` (`memo_det_archivo_memo_det_id`);

--
-- Indices de la tabla `memo_detalle_compra`
--
ALTER TABLE `memo_detalle_compra`
  ADD PRIMARY KEY (`memo_det_compra_id`),
  ADD KEY `fk_memo_detalle_compra_memo_detalle1_idx` (`memo_det_compra_memo_det_id`);

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
-- Indices de la tabla `memo_historial_cambios`
--
ALTER TABLE `memo_historial_cambios`
  ADD PRIMARY KEY (`memo_hist_cam_id`),
  ADD KEY `fk_memo_historial_usuario1_idx` (`memo_hist_cam_usuario_id`),
  ADD KEY `fk_memo_historial_memo1_idx` (`memo_hist_cam_memo_id`),
  ADD KEY `fk_memo_historial_historial_tipo1_idx` (`memo_hist_cam_tipo_id`);

--
-- Indices de la tabla `memo_relacion`
--
ALTER TABLE `memo_relacion`
  ADD PRIMARY KEY (`memo_relacion_id`),
  ADD KEY `fk_memo_relacion_memo_relacion_tipo1_idx` (`memo_relacion_relacion_tipo_id`),
  ADD KEY `idx_relacion_origen` (`memo_relacion_origen_id`),
  ADD KEY `idx_relacion_destino` (`memo_relacion_destino_id`);

--
-- Indices de la tabla `memo_relacion_tipo`
--
ALTER TABLE `memo_relacion_tipo`
  ADD PRIMARY KEY (`memo_relacion_tipo_id`);

--
-- Indices de la tabla `memo_resoluciones`
--
ALTER TABLE `memo_resoluciones`
  ADD PRIMARY KEY (`memo_res_is`),
  ADD KEY `fk_memo_resoluciones_memo1_idx` (`memo_res_memo_id`);

--
-- Indices de la tabla `memo_tiene_usuario`
--
ALTER TABLE `memo_tiene_usuario`
  ADD PRIMARY KEY (`memo_tiene_usu_id`,`memo_tiene_usu_memo_id`,`memo_tiene_usu_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_usuarios1_idx` (`memo_tiene_usu_usuario_id`),
  ADD KEY `fk_memo_has_usuarios_memo1_idx` (`memo_tiene_usu_memo_id`);

--
-- Indices de la tabla `perfil_permisos`
--
ALTER TABLE `perfil_permisos`
  ADD PRIMARY KEY (`perfil_permiso_id`);

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
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `fk_usuario_usuario_rol1_idx` (`usuario_usu_rol_id`);

--
-- Indices de la tabla `usuario_perfil`
--
ALTER TABLE `usuario_perfil`
  ADD PRIMARY KEY (`usu_perfil_id`);

--
-- Indices de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD PRIMARY KEY (`usu_rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `dpto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `memo`
--
ALTER TABLE `memo`
  MODIFY `memo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `memo_archivo`
--
ALTER TABLE `memo_archivo`
  MODIFY `memo_archivo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT de la tabla `memo_historial_cambios`
--
ALTER TABLE `memo_historial_cambios`
  MODIFY `memo_hist_cam_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_relacion`
--
ALTER TABLE `memo_relacion`
  MODIFY `memo_relacion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_resoluciones`
--
ALTER TABLE `memo_resoluciones`
  MODIFY `memo_res_is` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `memo_tiene_usuario`
--
ALTER TABLE `memo_tiene_usuario`
  MODIFY `memo_tiene_usu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `perfil_permisos`
--
ALTER TABLE `perfil_permisos`
  MODIFY `perfil_permiso_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimiento_compra`
--
ALTER TABLE `procedimiento_compra`
  MODIFY `proc_compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  MODIFY `usu_rol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `centro_costos`
--
ALTER TABLE `centro_costos`
  ADD CONSTRAINT `fk_centro_costos_dependencia1` FOREIGN KEY (`cc_dependencia_codigo`) REFERENCES `dependencia` (`dependencia_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo`
--
ALTER TABLE `memo`
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
  ADD CONSTRAINT `fk_memo_detalle_centro_costos1` FOREIGN KEY (`memo_det_cc_codigo`) REFERENCES `centro_costos` (`cc_codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
  ADD CONSTRAINT `fk_memo_detalle_compra_memo_detalle1` FOREIGN KEY (`memo_det_compra_memo_det_id`) REFERENCES `memo_detalle` (`memo_det_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_historial_cambios`
--
ALTER TABLE `memo_historial_cambios`
  ADD CONSTRAINT `fk_memo_historial_historial_tipo1` FOREIGN KEY (`memo_hist_cam_tipo_id`) REFERENCES `historial_cambios_tipo` (`hist_camb_tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_historial_memo1` FOREIGN KEY (`memo_hist_cam_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_memo_historial_usuario1` FOREIGN KEY (`memo_hist_cam_usuario_id`) REFERENCES `usuario` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_relacion`
--
ALTER TABLE `memo_relacion`
  ADD CONSTRAINT `fk_memo_relacion_memo_relacion_tipo1` FOREIGN KEY (`memo_relacion_relacion_tipo_id`) REFERENCES `memo_relacion_tipo` (`memo_relacion_tipo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `memo_resoluciones`
--
ALTER TABLE `memo_resoluciones`
  ADD CONSTRAINT `fk_memo_resoluciones_memo1` FOREIGN KEY (`memo_res_memo_id`) REFERENCES `memo` (`memo_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_usuario_usuario_rol1` FOREIGN KEY (`usuario_usu_rol_id`) REFERENCES `usuario_rol` (`usu_rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
