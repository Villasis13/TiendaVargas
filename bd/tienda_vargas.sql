-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 22-02-2024 a las 20:39:19
-- Versión del servidor: 5.7.33
-- Versión de PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_vargas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `fecha_caja` date NOT NULL,
  `hora_caja` time NOT NULL,
  `hora_caja_cierre` time DEFAULT NULL,
  `monto_caja` decimal(10,2) NOT NULL,
  `monto_caja_cierre` decimal(10,2) DEFAULT NULL,
  `estado_caja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_caja`, `fecha_caja`, `hora_caja`, `hora_caja_cierre`, `monto_caja`, `monto_caja_cierre`, `estado_caja`) VALUES
(3, '2024-02-21', '21:01:34', NULL, '97.00', NULL, 1),
(4, '2024-02-22', '08:57:12', '12:42:57', '124.70', '124.70', 0),
(5, '2024-02-22', '15:23:40', '15:34:54', '103.50', '103.50', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_cliente_documento` bigint(20) NOT NULL,
  `cliente_nombre` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `cliente_numdocumento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `cliente_direccion` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente_telefono` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cliente_microtime` varchar(1000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_cliente_documento`, `cliente_nombre`, `cliente_numdocumento`, `cliente_direccion`, `cliente_telefono`, `cliente_microtime`) VALUES
(1, 2, 'JORGE LUIS TENAZOA DORADO', '72894908', '', '', '1708537233.0456'),
(2, 2, 'ROGER CHAVEZ MEDINA', '61999172', '', NULL, ''),
(3, 2, 'BRYAN LEONID DÍAZ VARGAS', '71423949', '', NULL, ''),
(5, 2, 'WAGNER LEANDRO VILLASIS HIDALGO', '75994496', '', '', '1708537527.0749'),
(6, 2, 'LILA VERÓNICA HIDALGO ROJAS', '42481505', '', '', '1708536858.0261'),
(7, 2, 'ALVARADO SOUZA MILAGROS TERESITA', '71135386', '', '', '1708568134.5335'),
(8, 2, 'ANONIMO', '11111111', '', '', '1708574563.883'),
(9, 2, 'CHAVEZ MEDINA WILMER', '61999171', '', '', '1708633581.3234'),
(10, 2, 'VARGAS DE DIAZ SONIA', '05701497', '', '', '1708634028.5721');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_documento`
--

CREATE TABLE `cliente_documento` (
  `id_cliente_documento` bigint(20) NOT NULL,
  `clientedocumento_codigo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clientedocumento_identidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clientedocumento_identidad_abr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clientedocumento_estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente_documento`
--

INSERT INTO `cliente_documento` (`id_cliente_documento`, `clientedocumento_codigo`, `clientedocumento_identidad`, `clientedocumento_identidad_abr`, `clientedocumento_estado`, `created_at`, `updated_at`) VALUES
(1, '0', 'DOC.TRIB.NO.DOM.SIN.RUC', '-', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(2, '1', 'Documento Nacional de Identidad', 'DNI', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(3, '4', 'Carnet de extranjería', 'EXTR', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(4, '6', 'Registro Unico de Contributentes', 'RUC', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(5, '7', 'Pasaporte', 'PAS', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(6, 'A', 'Cédula Diplomática de identidad', 'CDI', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58'),
(7, 'B', 'DOC.IDENT.PAIS.RESIDENCIA-NO.D', 'NO', 1, '2023-06-15 02:40:49', '2023-06-15 02:40:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` bigint(20) UNSIGNED NOT NULL,
  `empresa_razon_social` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_nombrecomercial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_ruc` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_domiciliofiscal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_pais` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_departamento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_provincia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_distrito` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_ubigeo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_telefono2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_celular2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_foto_ticket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_correo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empresa_usuario_sol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_clave_sol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa_estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `empresa_razon_social`, `empresa_nombrecomercial`, `empresa_descripcion`, `empresa_ruc`, `empresa_domiciliofiscal`, `empresa_pais`, `empresa_departamento`, `empresa_provincia`, `empresa_distrito`, `empresa_ubigeo`, `empresa_telefono1`, `empresa_telefono2`, `empresa_celular1`, `empresa_celular2`, `empresa_foto`, `empresa_foto_ticket`, `empresa_correo`, `empresa_usuario_sol`, `empresa_clave_sol`, `empresa_estado`, `created_at`, `updated_at`) VALUES
(1, 'TIENDA VARGAS', 'TIENDA VARGAS', 'TIENDA VARGAS', '20607850179', 'FRENTE BANCO DE LA NACIÓN DE NAUTA ', 'PE', 'LORETO ', 'MAYNAS ', 'IQUITOS', '160101', NULL, NULL, NULL, NULL, 'inicio/img/logo.png', 'inicio/img/logo.png', NULL, 'MISKIBUF', 'Miskibufeo1', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida`
--

CREATE TABLE `medida` (
  `id_medida` int(11) NOT NULL,
  `nombre_medida` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `medida_codigo` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `medida`
--

INSERT INTO `medida` (`id_medida`, `nombre_medida`, `medida_codigo`) VALUES
(1, 'UNIDADES INDIVIDUALES', 'UI'),
(2, 'DOCENAS', 'DC'),
(3, 'PAQUETES', 'PQ'),
(4, 'GRAMOS', 'GR'),
(5, 'KILOGRAMOS', 'KG'),
(6, 'LITROS', 'LI'),
(7, 'BOLSAS', 'BL'),
(8, 'BOTELLAS', 'BT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(11) NOT NULL,
  `menu_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_controlador` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_icono` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `menu_orden` int(11) NOT NULL,
  `menu_mostrar` tinyint(1) NOT NULL,
  `menu_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`id_menu`, `menu_nombre`, `menu_controlador`, `menu_icono`, `menu_orden`, `menu_mostrar`, `menu_estado`) VALUES
(1, 'Login', 'Login', '-', 0, 0, 1),
(2, 'Panel de Inicio', 'Admin', 'fa fa-dashboard', 1, 0, 1),
(3, 'Gestión de Menu', 'Menu', 'menu-icon fa fa-desktop', 2, 1, 1),
(4, 'Roles de Usuario', 'Rol', 'menu-icon fa fa-user-secret', 5, 1, 1),
(5, 'Usuarios', 'Usuario', 'menu-icon fa fa-user', 4, 1, 1),
(6, 'Datos Personales', 'Datos', 'fa fa-', 0, 0, 1),
(11, 'Inventario', 'Productos', 'menu-icon bi bi-box-seam', 6, 1, 1),
(12, 'Clientes', 'Clientes', 'menu-icon fa fa-users', 7, 1, 1),
(13, 'Ventas', 'Ventas', 'menu-icon bi bi-cash-coin', 8, 1, 1),
(15, 'Historial', 'Reportes', 'menu-icon fa fa-book', 10, 1, 1),
(16, 'Caja', 'Caja', 'menu-icon bi bi-inboxes-fill', 11, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id_opcion` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `opcion_nombre` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `opcion_funcion` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `opcion_icono` char(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `opcion_mostrar` tinyint(1) NOT NULL,
  `opcion_orden` int(11) NOT NULL,
  `opcion_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`id_opcion`, `id_menu`, `opcion_nombre`, `opcion_funcion`, `opcion_icono`, `opcion_mostrar`, `opcion_orden`, `opcion_estado`) VALUES
(1, 1, 'Inicio de Sesion', 'inicio', '-', 0, 0, 1),
(2, 2, 'Inicio', 'inicio', 'fa fa-play', 1, 1, 1),
(3, 2, 'Cerrar Sesión', 'finalizar_sesion', 'fa fa-sign-out', 0, 1, 1),
(4, 3, 'Gestionar Menús', 'inicio', NULL, 1, 1, 1),
(5, 3, 'Iconos', 'iconos', NULL, 1, 2, 1),
(6, 3, 'Accesos por Rol', 'roles', NULL, 0, 0, 1),
(7, 3, 'Opciones por Menú', 'opciones', NULL, 0, 0, 1),
(8, 3, 'Gestionar Permisos(breve)', 'gestion_permisos', '', 0, 0, 1),
(9, 4, 'Gestionar Roles', 'inicio', '', 1, 1, 1),
(10, 4, 'Accesos por Rol', 'accesos', '', 0, 0, 1),
(11, 3, 'Gestionar Restricciones(breve)', 'gestion_restricciones', '', 0, 0, 1),
(12, 5, 'Gestionar Usuarios', 'inicio', '', 1, 1, 1),
(13, 6, 'Editar Datos', 'editar_datos', '', 0, 0, 1),
(14, 6, 'Editar Usuario', 'editar_usuario', '', 0, 0, 1),
(15, 6, 'Cambiar Contraseña', 'cambiar_contrasenha', '', 0, 0, 1),
(19, 10, 'Ver Caja', 'inicio', '', 1, 1, 1),
(20, 11, 'Listar Productos', 'inicio', '', 1, 1, 1),
(21, 12, 'Ver Clientes', 'inicio', '', 1, 1, 1),
(22, 13, 'Realizar Venta', 'inicio', '', 1, 1, 1),
(23, 14, 'Gestionar Caja', 'inicio', '', 1, 1, 1),
(24, 11, 'Formato de Ingreso', 'formato', '', 0, 2, 1),
(25, 16, 'Gestionar Caja', 'inicio', '', 1, 1, 1),
(26, 15, 'Ver historial', 'inicio', '', 1, 1, 1),
(27, 15, 'Ver Ventas', 'historial_ventas', '', 0, 2, 1),
(28, 15, 'Ver Compras', 'historial_compras', '', 0, 3, 1),
(29, 13, 'Detalle', 'detalle_venta', '', 0, 2, 1),
(30, 13, 'Imprimir pdf', 'imprimir_pdf', '', 0, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id_permiso` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `permiso_accion` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `permiso_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `id_opcion`, `permiso_accion`, `permiso_estado`) VALUES
(1, 1, 'validar_sesion', 1),
(2, 4, 'guardar_menu', 1),
(3, 6, 'configurar_relacion', 1),
(4, 7, 'guardar_opcion', 1),
(5, 7, 'agregar_permiso', 1),
(6, 7, 'eliminar_permiso', 1),
(7, 7, 'configurar_acceso', 1),
(8, 9, 'guardar_rol', 1),
(9, 10, 'gestionar_acceso_rol', 1),
(10, 12, 'guardar_nuevo_usuario', 1),
(11, 12, 'guardar_edicion_usuario', 1),
(12, 12, 'guardar_edicion_persona', 1),
(13, 12, 'restablecer_contrasenha', 1),
(14, 13, 'guardar_datos', 1),
(15, 14, 'guardar_usuario', 1),
(16, 15, 'guardar_contrasenha', 1),
(17, 20, 'guardar_editar_productos', 1),
(18, 20, 'edicion_productos', 1),
(19, 20, 'eliminar_producto', 1),
(20, 21, 'guardar_editar_clientes', 1),
(21, 21, 'edicion_clientes', 1),
(22, 21, 'eliminar_cliente', 1),
(23, 23, 'abrir_caja', 1),
(24, 24, 'listar_productos_input', 1),
(25, 22, 'listar_productos_comprar', 1),
(26, 22, 'guardar_realizar_venta', 1),
(31, 24, 'guardar_formato_ingreso', 1),
(34, 26, 'traer_datos_filtro', 1),
(35, 25, 'abrir_caja', 1),
(36, 22, 'consultar_serie', 1),
(37, 22, 'consultar_cliente', 1),
(40, 29, 'imprimir_pdf', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id_persona` int(11) NOT NULL,
  `persona_nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `persona_apellido_paterno` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `persona_apellido_materno` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_nacimiento` date DEFAULT NULL,
  `persona_telefono` char(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `persona_creacion` datetime NOT NULL,
  `persona_modificacion` datetime NOT NULL,
  `person_codigo` varchar(40) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `persona_nombre`, `persona_apellido_paterno`, `persona_apellido_materno`, `persona_nacimiento`, `persona_telefono`, `persona_creacion`, `persona_modificacion`, `person_codigo`) VALUES
(1, 'Wagner Villasis', 'Hidalgo', NULL, NULL, NULL, '2020-09-17 00:00:00', '2020-09-17 00:00:00', '010101010101'),
(2, 'Leandro Villasis', 'Hidalgo', NULL, NULL, NULL, '2023-06-06 05:44:43', '2023-06-06 05:44:43', '010101010100');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(20) NOT NULL,
  `id_medida` int(11) NOT NULL,
  `id_tipo_afectacion` int(20) UNSIGNED NOT NULL,
  `producto_nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `producto_precio` decimal(10,2) NOT NULL,
  `producto_stock` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `producto_procentaje_igv` decimal(10,2) DEFAULT NULL,
  `producto_valor_unit` decimal(10,2) DEFAULT NULL,
  `productos_microtime` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `productos_impuesto_bolsa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_medida`, `id_tipo_afectacion`, `producto_nombre`, `producto_precio`, `producto_stock`, `fecha_creacion`, `producto_procentaje_igv`, `producto_valor_unit`, `productos_microtime`, `productos_impuesto_bolsa`) VALUES
(1, 3, 2, 'Vaso Plástico', '3.00', '11', '2024-02-16 16:16:50', NULL, NULL, '1708118210.3058', 0),
(2, 1, 2, 'Papel Toalla Higienol', '3.00', '14', '2024-02-16 16:14:47', NULL, NULL, '1708118087.7698', 0),
(3, 1, 2, 'Ayudin Grande', '9.00', '18', '2024-02-16 16:17:03', NULL, NULL, '1708118223.4576', 0),
(4, 1, 2, 'Ayudin Pequeño', '3.00', '15', '2024-02-16 16:17:08', NULL, NULL, '1708118228.2625', 0),
(5, 3, 2, 'Papel Suave', '15.00', '0', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(6, 3, 2, 'Pamper Ninet', '50.00', '10', '2024-02-16 16:51:51', NULL, NULL, '1708120311.0351', 0),
(7, 1, 2, 'Cuadernos Grande', '5.00', '49', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(8, 3, 2, 'Jabones en Barra', '70.00', '5', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(9, 3, 2, 'Leche Gloria', '99.99', '4', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(10, 1, 2, 'Filete Real', '7.50', '48', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(11, 2, 2, 'Huevos', '8.00', '24', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(12, 3, 2, 'Pasta Dental Kolynos', '40.00', '2', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(13, 3, 2, 'Sardina Rosaimar', '99.99', '5', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(14, 1, 2, 'Ajinomen', '1.80', '15', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(15, 1, 2, 'Lejía Margot', '0.50', '70', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(16, 1, 2, 'Aceite Tondero', '10.00', '36', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(17, 1, 2, 'Aceite Palmerola', '8.50', '48', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(18, 3, 2, 'Gaseosa Coca Cola', '50.00', '9', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(19, 5, 2, 'Arroz', '3.50', '10', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(20, 5, 2, 'Azúcar', '4.00', '15', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(21, 2, 2, 'Jabonsillo Protex', '30.00', '10', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(22, 1, 2, 'Bolígrafo Faber Castell', '0.70', '40', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(23, 3, 2, 'Cigarro Hamilton', '30.00', '5', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(24, 1, 2, 'Galleta Soda', '0.50', '53', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(25, 1, 2, 'Galleta Vainilla', '0.50', '52', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(26, 1, 2, 'Pila Panasonic Grande', '4.50', '20', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(27, 1, 2, 'Pila Panasonic Pequeño', '2.50', '40', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(28, 1, 2, 'Tokai', '3.00', '17', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(29, 5, 2, 'Maíz', '2.00', '10', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(30, 3, 2, 'Yomost', '11.00', '5', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(31, 1, 2, 'Mentol Vick Vaporub', '3.50', '24', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(32, 1, 2, 'Mentol Sikura', '3.50', '36', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(33, 1, 2, 'Sal Yodada Yamisal', '1.00', '25', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(34, 1, 2, 'Linterna Luken', '6.00', '16', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(35, 1, 2, 'Jamonilla Tulip', '9.00', '20', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(36, 1, 2, 'Hot Dog Pequeño', '9.00', '8', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(37, 1, 2, 'Hot Dog Grande', '13.00', '0', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(38, 1, 2, 'Entero de Anchoveta Rosaimar', '5.50', '12', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(39, 1, 2, 'Toalla Higiénica Nosotras', '5.50', '60', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(40, 3, 2, 'Fósforo Cocinero', '3.00', '6', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(41, 1, 2, 'Pulp Grande Durazno', '5.00', '7', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(42, 1, 2, 'Pulp Mediano Durazno', '2.00', '15', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(43, 1, 2, 'Pulp Pequeño Durazno', '1.00', '30', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(44, 1, 2, 'Gaseosa Coca Cola personal', '3.00', '45', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(45, 1, 2, 'Gaseosa Inca Kola personal', '3.00', '47', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(46, 6, 2, 'Gaseosa Coca Cola Litro', '10.00', '20', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(47, 6, 2, 'Gaseosa Inca Kola Litro', '10.00', '20', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(48, 1, 2, 'Jabón Popeye', '2.00', '24', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(49, 1, 2, 'Jabón Bolivar', '3.00', '28', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(50, 1, 2, 'Jabón Jumbo', '2.00', '22', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(51, 3, 2, 'Vela Rayo', '5.00', '15', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(52, 1, 2, 'Poett Grande', '3.50', '4', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(53, 1, 2, 'Poett Pequeño', '2.50', '5', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(54, 7, 2, 'Bolsa Bombón Globo Pop', '7.00', '9', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(55, 7, 2, 'Chicle Huevito', '8.00', '10', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(56, 3, 2, 'Agua San Luis Pequeño', '20.00', '4', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(57, 3, 2, 'Agua San Luis Grande ', '30.00', '6', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(58, 8, 2, 'Ron Cartavio', '20.00', '6', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(59, 8, 2, 'Sillao', '3.00', '8', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(60, 8, 2, 'Vinagre', '3.00', '12', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(61, 1, 2, 'Avena Grano de Oro', '1.00', '35', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(62, 1, 2, 'Tallarín Santa Catalina', '3.00', '20', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(63, 1, 2, 'Macarrón Espiga de Oro', '2.00', '19', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(64, 1, 2, 'Café Kirma', '1.00', '96', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(65, 5, 2, 'Fariña', '5.00', '10', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(66, 1, 2, 'Cocoa D\'Gussto', '1.00', '50', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(67, 1, 2, 'Milo', '1.20', '42', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(68, 1, 2, 'Shampoo Head ', '1.00', '45', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(69, 1, 2, 'Colonia Pera in Love', '22.00', '9', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(70, 1, 2, 'Perfume Mersi', '40.00', '12', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(71, 1, 2, 'Perfume Kalos', '60.00', '7', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(72, 1, 2, 'Talco Imágenes ', '15.00', '24', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(73, 1, 2, 'Betún Santiago Grande', '4.00', '15', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(74, 1, 2, 'Mayonesa Alacena', '6.50', '25', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(75, 1, 2, 'Sal de Andrews', '0.70', '79', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(76, 1, 2, 'Gelatina Cifrut ', '3.50', '33', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(77, 1, 2, 'Suavitel', '1.20', '19', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(78, 1, 2, 'Timolina', '3.00', '12', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(79, 1, 2, 'Agua Oxigenada', '2.00', '16', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(80, 1, 2, 'Leche de Magnesia', '9.00', '26', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(81, 7, 2, 'Algodón', '2.00', '18', '2024-02-16 12:43:24', NULL, NULL, '', 0),
(82, 1, 2, 'Paraguas', '22.00', '6', '2024-02-16 12:43:24', NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restricciones`
--

CREATE TABLE `restricciones` (
  `id_restriccion` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol_nombre` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `rol_descripcion` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `rol_estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `rol_nombre`, `rol_descripcion`, `rol_estado`) VALUES
(1, 'Libre', 'Accesos sin inicio de sesión', 1),
(2, 'SuperAdmin', 'Tiene acceso a la gestión total del sistema', 1),
(3, 'Vendedor', 'Gestión del sistema', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_menus`
--

CREATE TABLE `roles_menus` (
  `id_rol_menu` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles_menus`
--

INSERT INTO `roles_menus` (`id_rol_menu`, `id_rol`, `id_menu`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 3, 2),
(8, 2, 6),
(9, 3, 6),
(10, 2, 7),
(11, 2, 8),
(12, 1, 8),
(13, 2, 9),
(14, 3, 9),
(15, 1, 9),
(16, 1, 10),
(17, 2, 10),
(18, 3, 10),
(19, 2, 11),
(20, 2, 12),
(21, 2, 13),
(22, 2, 14),
(23, 3, 14),
(24, 2, 14),
(25, 1, 14),
(27, 2, 15),
(28, 3, 15),
(29, 2, 16),
(30, 3, 11),
(31, 3, 12),
(32, 3, 13),
(33, 3, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie`
--

CREATE TABLE `serie` (
  `id_serie` bigint(20) UNSIGNED NOT NULL,
  `tipocomp` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correlativo` int(11) NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `serie`
--

INSERT INTO `serie` (`id_serie`, `tipocomp`, `serie`, `correlativo`, `estado`, `created_at`, `updated_at`) VALUES
(3, '01', 'F001', 0, 1, NULL, NULL),
(5, '03', 'B001', 0, 1, NULL, NULL),
(6, '07', 'FN01', 0, 1, NULL, NULL),
(7, '07', 'BN01', 0, 1, NULL, NULL),
(8, '08', 'FD01', 0, 1, NULL, NULL),
(9, '08', 'BD01', 0, 1, NULL, NULL),
(10, 'RC', '20231031', 0, 1, NULL, NULL),
(11, 'RA', '20210520', 0, 1, NULL, NULL),
(13, '20', 'NV01', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `id_tipo_afectacion` int(20) UNSIGNED NOT NULL,
  `codigo` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigo_afectacion` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_afectacion` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_afectacion` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_afectacion`
--

INSERT INTO `tipo_afectacion` (`id_tipo_afectacion`, `codigo`, `descripcion`, `codigo_afectacion`, `nombre_afectacion`, `tipo_afectacion`, `created_at`, `updated_at`) VALUES
(1, '10', 'OP. GRAVADAS', '1000', 'IGV', 'VAT', NULL, NULL),
(2, '20', 'OP. EXONERADAS', '9997', 'EXO', 'VAT', NULL, NULL),
(3, '30', 'OP. INAFECTAS', '9998', 'INA', 'FRE', NULL, NULL),
(4, '21', 'OP. GRATUITAS', '9996', 'GRA', 'FRE', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id_tipo_documento` int(11) NOT NULL,
  `tipo_documento_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id_tipo_documento`, `tipo_documento_nombre`) VALUES
(1, 'BOLETA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago`
--

CREATE TABLE `tipo_pago` (
  `id_tipo_pago` int(11) NOT NULL,
  `tipo_pago_nombre` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_pago`
--

INSERT INTO `tipo_pago` (`id_tipo_pago`, `tipo_pago_nombre`) VALUES
(1, 'EFECTIVO'),
(2, 'TRANSFERENCIA YAPE'),
(3, 'TRANSFERENCIA PLIN'),
(4, 'TARJETA'),
(5, 'TRANSFERENCIA OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `usuario_nickname` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_contrasenha` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_imagen` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `usuario_estado` tinyint(1) NOT NULL,
  `usuario_creacion` datetime NOT NULL,
  `usuario_ultimo_login` datetime NOT NULL,
  `usuario_ultima_modificacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_persona`, `id_rol`, `usuario_nickname`, `usuario_contrasenha`, `usuario_email`, `usuario_imagen`, `usuario_estado`, `usuario_creacion`, `usuario_ultimo_login`, `usuario_ultima_modificacion`) VALUES
(1, 1, 2, 'wagner', '$2y$10$hNHJimtV16/G3w/t/cycAeWdHEibLUW1fKzBFEYGLOKewUncjCdSS', 'wagnervillasishidalgo060@gmail.com', 'media/usuarios/usuario.jpg', 1, '2020-09-17 00:00:00', '2024-02-22 08:57:02', '2024-02-13 12:10:28'),
(2, 2, 3, 'sonia', '$2y$10$tSo2K8kmsh8w/MIG3HSeY./YpgFYCBtZpZUvshpWYemxAdd6lgByu', 'sonia@gmail.com', 'media/usuarios/usuario.jpg', 1, '2020-10-27 18:29:10', '2024-02-22 15:31:04', '2024-02-13 12:11:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_tipo_pago` int(11) NOT NULL,
  `venta_serie` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_correlativo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_total` decimal(10,2) NOT NULL,
  `venta_pago_cliente` decimal(10,2) NOT NULL,
  `venta_vuelto` decimal(10,2) NOT NULL,
  `venta_fecha` datetime NOT NULL,
  `venta_codigo` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_tipo_pago`, `venta_serie`, `venta_correlativo`, `venta_total`, `venta_pago_cliente`, `venta_vuelto`, `venta_fecha`, `venta_codigo`, `created_at`) VALUES
(6, 8, 1, '5', '0', '3.50', '7.00', '0.50', '2024-02-21 23:28:57', '1708576137.3891', '2024-02-21 23:28:57'),
(7, 8, 1, '5', '0', '3.00', '15.00', '3.00', '2024-02-22 08:57:36', '1708610256.6856', '2024-02-22 08:57:36'),
(8, 8, 1, '5', '0', '3.00', '100.00', '97.00', '2024-02-22 11:01:50', '1708617710.1441', '2024-02-22 11:01:50'),
(9, 8, 1, '5', '0', '0.70', '2.00', '1.30', '2024-02-22 11:02:53', '1708617773.623', '2024-02-22 11:02:53'),
(10, 8, 1, '5', '0', '9.00', '10.00', '1.00', '2024-02-22 11:03:33', '1708617813.1868', '2024-02-22 11:03:33'),
(11, 8, 1, '5', '0', '9.00', '10.00', '1.00', '2024-02-22 11:06:44', '1708618004.1495', '2024-02-22 11:06:44'),
(12, 9, 1, '5', '0', '50.00', '60.00', '10.00', '2024-02-22 15:26:21', '1708633581.3473', '2024-02-22 15:26:21'),
(13, 10, 1, '5', '0', '3.50', '5.00', '1.50', '2024-02-22 15:33:48', '1708634028.5952', '2024-02-22 15:33:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_detalle`
--

CREATE TABLE `ventas_detalle` (
  `id_venta_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(20) NOT NULL,
  `venta_detalle_precio_unitario` decimal(10,2) NOT NULL,
  `venta_detalle_nombre_producto` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_detalle_cantidad` decimal(10,0) NOT NULL,
  `venta_detalle_valor_total` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas_detalle`
--

INSERT INTO `ventas_detalle` (`id_venta_detalle`, `id_venta`, `id_producto`, `venta_detalle_precio_unitario`, `venta_detalle_nombre_producto`, `venta_detalle_cantidad`, `venta_detalle_valor_total`, `created_at`) VALUES
(4, 6, 44, '3.00', 'Gaseosa Coca Cola personal', '2', '3.50', '2024-02-21 23:28:57'),
(5, 6, 24, '0.50', 'Galleta Soda', '1', '3.50', '2024-02-21 23:28:57'),
(6, 7, 1, '3.00', 'Vaso Plástico', '4', '3.00', '2024-02-22 08:57:36'),
(7, 8, 1, '3.00', 'Vaso Plástico', '1', '3.00', '2024-02-22 11:01:50'),
(8, 9, 75, '0.70', 'Sal de Andrews', '1', '0.70', '2024-02-22 11:02:53'),
(9, 10, 3, '9.00', 'Ayudin Grande', '1', '9.00', '2024-02-22 11:03:33'),
(10, 11, 3, '9.00', 'Ayudin Grande', '1', '9.00', '2024-02-22 11:06:44'),
(11, 12, 18, '50.00', 'Gaseosa Coca Cola', '1', '50.00', '2024-02-22 15:26:21'),
(12, 13, 76, '3.50', 'Gelatina Cifrut ', '1', '3.50', '2024-02-22 15:33:48');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_cliente_documento` (`id_cliente_documento`);

--
-- Indices de la tabla `cliente_documento`
--
ALTER TABLE `cliente_documento`
  ADD PRIMARY KEY (`id_cliente_documento`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`);

--
-- Indices de la tabla `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`id_medida`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_opcion`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id_permiso`),
  ADD KEY `id_opcion` (`id_opcion`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_medida` (`id_medida`),
  ADD KEY `id_tipo_afectacion` (`id_tipo_afectacion`);

--
-- Indices de la tabla `restricciones`
--
ALTER TABLE `restricciones`
  ADD PRIMARY KEY (`id_restriccion`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_opcion` (`id_opcion`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_menus`
--
ALTER TABLE `roles_menus`
  ADD PRIMARY KEY (`id_rol_menu`),
  ADD KEY `id_rol` (`id_rol`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indices de la tabla `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`id_serie`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`id_tipo_afectacion`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id_tipo_documento`);

--
-- Indices de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  ADD PRIMARY KEY (`id_tipo_pago`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_persona` (`id_persona`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_cliente` (`id_cliente`,`id_tipo_pago`),
  ADD KEY `id_tipo_pago` (`id_tipo_pago`);

--
-- Indices de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD PRIMARY KEY (`id_venta_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `cliente_documento`
--
ALTER TABLE `cliente_documento`
  MODIFY `id_cliente_documento` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `medida`
--
ALTER TABLE `medida`
  MODIFY `id_medida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_opcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `restricciones`
--
ALTER TABLE `restricciones`
  MODIFY `id_restriccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles_menus`
--
ALTER TABLE `roles_menus`
  MODIFY `id_rol_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `serie`
--
ALTER TABLE `serie`
  MODIFY `id_serie` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  MODIFY `id_tipo_afectacion` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id_tipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipo_pago`
--
ALTER TABLE `tipo_pago`
  MODIFY `id_tipo_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  MODIFY `id_venta_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_cliente_documento`) REFERENCES `cliente_documento` (`id_cliente_documento`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD CONSTRAINT `permisos_ibfk_1` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`id_opcion`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_medida`) REFERENCES `medida` (`id_medida`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_tipo_afectacion`) REFERENCES `tipo_afectacion` (`id_tipo_afectacion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_tipo_pago`) REFERENCES `tipo_pago` (`id_tipo_pago`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas_detalle`
--
ALTER TABLE `ventas_detalle`
  ADD CONSTRAINT `ventas_detalle_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_detalle_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
