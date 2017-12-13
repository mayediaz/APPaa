-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-12-2017 a las 16:28:13
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `alarma`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `CLIENTE_ID` int(11) NOT NULL,
  `CLIENTE_NOMBRE` varchar(20) NOT NULL,
  `CLIENTE_REPORTE` tinyint(1) NOT NULL DEFAULT '0',
  `CLIENTE_PRINCIPAL` tinyint(1) NOT NULL DEFAULT '0',
  `CLIENTE_APIKEY` varchar(32) NOT NULL,
  `CLIENTE_FCREACION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CLIENTE_FMODIFICADO` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`CLIENTE_ID`, `CLIENTE_NOMBRE`, `CLIENTE_REPORTE`, `CLIENTE_PRINCIPAL`, `CLIENTE_APIKEY`, `CLIENTE_FCREACION`, `CLIENTE_FMODIFICADO`) VALUES
(1, 'infomedia', 0, 1, '897086f764944d8fa24ec22903721ed9', '2017-11-21 14:09:28', '2017-11-30 16:03:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `define`
--

CREATE TABLE `define` (
  `DEFINE_ID` int(11) NOT NULL,
  `DEFINE_SERVICIO_ID` int(11) NOT NULL,
  `DEFINE_TIPO` varchar(10) NOT NULL,
  `DEFINE_PARAM` varchar(20) NOT NULL,
  `DEFINE_DESCRIPCION` varchar(100) NOT NULL,
  `DEFINE_FCREACION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DEFINE_FMODIFICADO` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `define`
--

INSERT INTO `define` (`DEFINE_ID`, `DEFINE_SERVICIO_ID`, `DEFINE_TIPO`, `DEFINE_PARAM`, `DEFINE_DESCRIPCION`, `DEFINE_FCREACION`, `DEFINE_FMODIFICADO`) VALUES
(1, 1, 'text', 'zabbix', 'Ip Host alojado Zabbix', '2017-11-07 15:09:58', '2017-11-14 13:27:50'),
(2, 2, 'text', 'testCorreo', 'Destinatario del correo de prueba', '2017-11-07 15:10:30', '2017-11-09 15:32:18'),
(3, 2, 'text', 'correo_prin', 'Host a usar para envio de Correo Principal', '2017-11-07 15:10:52', '2017-11-09 15:32:18'),
(4, 2, 'text', 'rem_prin', 'Correo principal a figurar como remitente', '2017-11-07 15:11:10', '2017-11-09 15:32:18'),
(5, 2, 'password', 'pass_prin', 'Contraseña remitente del correo principal', '2017-11-07 15:11:26', '2017-11-09 15:32:18'),
(6, 2, 'text', 'correo_alt', 'Host a usar para envio de Correo Alternativo', '2017-11-07 15:11:41', '2017-11-09 15:32:18'),
(7, 2, 'text', 'rem_alt', 'Correo alternativo a figurar como remitente', '2017-11-07 15:11:58', '2017-11-09 15:32:18'),
(8, 2, 'password', 'pass_alt', 'Contraseña remitente del correo alternativo', '2017-11-07 15:12:11', '2017-11-09 15:32:18'),
(14, 4, 'text', 'url_ccx', 'URL CCX', '2017-11-10 10:50:59', '2017-11-10 11:04:41'),
(15, 3, 'text', 'url_nexmo', 'URL Nexmo', '2017-11-10 11:49:36', '2017-11-10 11:58:44'),
(16, 6, 'text', 'url_spark', 'URL Spark', '2017-11-20 14:52:14', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `EVENTO_ID` int(11) NOT NULL,
  `EVENTO_TIPO` tinyint(1) NOT NULL DEFAULT '0',
  `EVENTO_FECHA` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EVENTO_REFERENCIA` varchar(20) NOT NULL,
  `EVENTO_MENSAJE` text NOT NULL,
  `EVENTO_CLIENTE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `MENU_ID` int(11) NOT NULL,
  `MENU_NOMBRE` varchar(20) NOT NULL,
  `MENU_RUTA` varchar(20) NOT NULL,
  `MENU_ICONO` varchar(20) NOT NULL,
  `MENU_ACTIVO` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`MENU_ID`, `MENU_NOMBRE`, `MENU_RUTA`, `MENU_ICONO`, `MENU_ACTIVO`) VALUES
(1, 'Menus', 'menu.html.php', 'menu', 0),
(2, 'Perfiles', 'perfil.html.php', 'supervisor_account', 0),
(3, 'Permisos', 'permiso.html.php', 'assignment_turned_in', 0),
(4, 'Clientes', 'cliente.html.php', 'business_center', 1),
(5, 'Usuarios', 'usuarios.php', 'person_add', 1),
(6, 'Servicios', 'servicios.php', 'merge_type', 1),
(7, 'Turnos', 'turnos.php', 'content_paste', 1),
(8, 'Mi perfil', 'miperfil.html.php', 'person', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `PERFIL_ID` int(11) NOT NULL,
  `PERFIL_NOMBRE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`PERFIL_ID`, `PERFIL_NOMBRE`) VALUES
(1, 'Superusuario'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `PERMISO_ID` int(11) NOT NULL,
  `PERMISO_MENU_ID` int(11) NOT NULL,
  `PERMISO_PERFIL_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`PERMISO_ID`, `PERMISO_MENU_ID`, `PERMISO_PERFIL_ID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 4, 2),
(10, 5, 2),
(11, 7, 2),
(12, 8, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `SERVICIO_ID` int(11) NOT NULL,
  `SERVICIO_NOMBRE` varchar(20) NOT NULL,
  `SERVICIO_FIJO` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`SERVICIO_ID`, `SERVICIO_NOMBRE`, `SERVICIO_FIJO`) VALUES
(1, 'zabbix', 0),
(2, 'correo', 1),
(3, 'nexmo', 1),
(4, 'ccx', 1),
(5, 'e1', 1),
(6, 'spark', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `turno`
--

CREATE TABLE `turno` (
  `TURNO_ID` int(11) NOT NULL,
  `TURNO_NOMBRE` varchar(10) NOT NULL,
  `TURNO_DESCRIPCION` varchar(30) NOT NULL,
  `TURNO_VALOR` varchar(13) NOT NULL,
  `TURNO_FCREACION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TURNO_FMODIFICADO` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `turno`
--

INSERT INTO `turno` (`TURNO_ID`, `TURNO_NOMBRE`, `TURNO_DESCRIPCION`, `TURNO_VALOR`, `TURNO_FCREACION`, `TURNO_FMODIFICADO`) VALUES
(1, 'turno1ext', 'Ext/Cel Turno 7am a 3pm', '1049', '2017-12-04 08:04:01', '2017-12-11 11:21:02'),
(2, 'turno1cel', 'Cel Turno 7am a 3pm', '*033146570228', '2017-12-04 08:04:01', '2017-12-11 11:21:02'),
(3, 'turno2ext', 'Ext/Cel Turno 3pm a 11pm', '1049', '2017-12-04 08:05:01', '2017-12-11 11:21:02'),
(4, 'turno2cel', 'Cel Turno 3pm a 11pm', '*033146570228', '2017-12-04 08:05:01', '2017-12-11 11:21:02'),
(5, 'turno3ext', 'Ext/Cel Turno 11pm a 7am', '1049', '2017-12-04 08:11:53', '2017-12-11 11:21:02'),
(6, 'turno3cel', 'Cel Turno 11pm a 7am', '*033146570228', '2017-12-04 08:11:53', '2017-12-11 11:21:02'),
(7, 'jefeext', 'Ext/Cel Jef', '1049', '2017-12-04 08:12:39', '2017-12-11 11:21:02'),
(8, 'jefecel', 'Cel Jefe', '*033146570228', '2017-12-04 08:12:39', '2017-12-11 11:21:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `USUARIO_ID` int(11) NOT NULL,
  `USUARIO_NOMBRE` varchar(20) NOT NULL,
  `USUARIO_LOGIN` varchar(20) NOT NULL,
  `USUARIO_PASSWORD` varchar(20) NOT NULL,
  `USUARIO_PERFIL` int(11) NOT NULL,
  `USUARIO_EMPRESA` int(11) NOT NULL,
  `USUARIO_CORREO` varchar(50) NOT NULL,
  `USUARIO_ACCESS_TOKEN` varchar(100) NOT NULL,
  `USUARIO_ROOM` varchar(100) NOT NULL,
  `USUARIO_NROOM` varchar(100) NOT NULL,
  `USUARIO_REFRESH_TOKEN` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`USUARIO_ID`, `USUARIO_NOMBRE`, `USUARIO_LOGIN`, `USUARIO_PASSWORD`, `USUARIO_PERFIL`, `USUARIO_EMPRESA`, `USUARIO_CORREO`, `USUARIO_ACCESS_TOKEN`, `USUARIO_ROOM`, `USUARIO_NROOM`, `USUARIO_REFRESH_TOKEN`) VALUES
(1, 'Marcela Diaz', 'mdiaz', 'bWFyY2VsYWQ=', 1, 1, 'marcela.diaz@infomediaservice.com', 'NWM3ZDhmZGYtZTI0Yi00MTYwLTgyZjYtMzU4YjMxMjhlMjg1YjA1NjhhYjMtODk1', 'Y2lzY29zcGFyazovL3VzL1JPT00vNjE5YWZmZTAtZGY4Mi0xMWU3LWFjZjUtYzE0ZDc4OTA1MDY5', 'Alarmas', 'MTQ5MjMxZTQtMjEwMS00YjE2LWJjZWEtOWViZGUzMWFlYTZiOTdjOGRlZWItZGNm'),
(3, 'Lideyda Soto', 'lsoto', 'bGlkZXlkYXM=', 2, 1, 'lideyda.soto@infomediaservice.com', '', '', '', ''),
(4, 'Jorge Florez', 'jflorez', 'am9yZ2Vm', 2, 1, 'jorge.florez@infomediaservice.com', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `val_define`
--

CREATE TABLE `val_define` (
  `VAL_DEFINE_ID` int(11) NOT NULL,
  `VAL_DEFINE_CLIENTE` int(11) NOT NULL,
  `VAL_DEFINE_PARAM` int(11) NOT NULL,
  `VAL_DEFINE_VALOR` varchar(200) NOT NULL,
  `VAL_DEFINE_TEST_ANT` datetime DEFAULT NULL,
  `VAL_DEFINE_TEST_ACT` datetime DEFAULT NULL,
  `VAL_DEFINE_REPORTE` tinyint(1) NOT NULL DEFAULT '0',
  `VAL_DEFINE_FCREACION` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `VAL_DEFINE_FMODIFICADO` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `val_define`
--

INSERT INTO `val_define` (`VAL_DEFINE_ID`, `VAL_DEFINE_CLIENTE`, `VAL_DEFINE_PARAM`, `VAL_DEFINE_VALOR`, `VAL_DEFINE_TEST_ANT`, `VAL_DEFINE_TEST_ACT`, `VAL_DEFINE_REPORTE`, `VAL_DEFINE_FCREACION`, `VAL_DEFINE_FMODIFICADO`) VALUES
(1, 1, 1, '192.168.0.1', '2017-12-12 16:20:00', '2017-12-12 16:25:00', 0, '2017-11-15 15:22:28', '2017-12-11 11:23:58'),
(2, 1, 2, 'aalarms@infomediaservice.com', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(3, 1, 3, 'mail.infomediaservice.com', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(4, 1, 4, 'cgo@infomediaservice.com', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(5, 1, 5, '1nf0m3d14', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(6, 1, 6, 'smtp.gmail.com', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(7, 1, 7, 'cgoinfomedia@gmail.com', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(8, 1, 8, '1nf0m3d14', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-12 15:11:23'),
(9, 1, 14, 'http://172.16.4.99:9080/aalarms?', NULL, NULL, 0, '2017-11-15 15:22:28', '2017-12-01 14:30:47'),
(10, 1, 15, 'https://api.tropo.com/1.0/sessions?action=create&token=6a665162496369707973756c654b695a5152695467667775696361456d4348444e6a58666c635279776d7152', NULL, NULL, 0, '2017-11-15 15:22:28', NULL),
(12, 1, 16, 'http://172.16.4.119:5002/v1/', NULL, NULL, 0, '2017-11-20 15:11:33', '2017-12-12 16:27:23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`CLIENTE_ID`);

--
-- Indices de la tabla `define`
--
ALTER TABLE `define`
  ADD PRIMARY KEY (`DEFINE_ID`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`EVENTO_ID`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`MENU_ID`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`PERFIL_ID`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`PERMISO_ID`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`SERVICIO_ID`);

--
-- Indices de la tabla `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`TURNO_ID`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`USUARIO_ID`);

--
-- Indices de la tabla `val_define`
--
ALTER TABLE `val_define`
  ADD PRIMARY KEY (`VAL_DEFINE_ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `CLIENTE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `define`
--
ALTER TABLE `define`
  MODIFY `DEFINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `EVENTO_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `MENU_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `PERFIL_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `PERMISO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `SERVICIO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `turno`
--
ALTER TABLE `turno`
  MODIFY `TURNO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `USUARIO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `val_define`
--
ALTER TABLE `val_define`
  MODIFY `VAL_DEFINE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
