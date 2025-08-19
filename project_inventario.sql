-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250624.c910e1faac
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-08-2025 a las 16:16:47
-- Versión del servidor: 8.0.26
-- Versión de PHP: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `project_inventario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_data_table`
--

CREATE TABLE `account_data_table` (
  `a_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ac_id` int NOT NULL,
  `at_id` int NOT NULL,
  `a_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `a_name` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `a_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `account_data_table`
--

INSERT INTO `account_data_table` (`a_id`, `ac_id`, `at_id`, `a_code`, `a_name`, `a_status`) VALUES
('68a285e7a09a4', 1, 1, 'VENT-01', 'VENTA DE CHATARRA', 1),
('68a331ed60853', 2, 2, 'COMP-01', 'COMPRA DE COMIDA', 1),
('68a3322f2b656', 2, 2, 'COMP-02', 'COMPRA DE CHATARRA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_movements_data_table`
--

CREATE TABLE `account_movements_data_table` (
  `am_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ac_id` int NOT NULL,
  `a_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `e_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'proveedor o cliente',
  `am_date` date NOT NULL,
  `am_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `am_amount` decimal(28,4) NOT NULL,
  `am_rate` decimal(28,4) NOT NULL,
  `am_change` decimal(28,4) NOT NULL,
  `am_datereg` date NOT NULL,
  `am_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `account_movements_data_table`
--

INSERT INTO `account_movements_data_table` (`am_id`, `ac_id`, `a_id`, `e_id`, `am_date`, `am_name`, `am_amount`, `am_rate`, `am_change`, `am_datereg`, `am_status`) VALUES
('68a3415d985e8', 1, '68a285e7a09a4', '68a3205f46ef5', '2025-08-18', 'VENTAS DE METALES VARIOS', 50.0000, 0.0000, 0.0000, '2025-08-18', 0),
('68a34ec8899e4', 1, '68a285e7a09a4', '68a3205f46ef5', '2025-08-18', 'VENTAS DE HIERRO', 50.0000, 0.0000, 0.0000, '2025-08-18', 1),
('68a34ee004542', 2, '68a3322f2b656', '689fb088ea0e9', '2025-08-18', 'COMPRA DE HIERRO', 40.0000, 0.0000, 0.0000, '2025-08-18', 1),
('68a47824d110e', 1, '68a285e7a09a4', '68a3205f46ef5', '2025-08-19', 'KJIN', 42.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4785c07db9', 1, '68a285e7a09a4', '68a3205f46ef5', '2025-08-19', 'KJIN', 35.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4969de6415', 1, '68a285e7a09a4', '68a3205f46ef5', '2025-08-19', 'COSAS VARIAS DE PRUEBA', 42.0000, 136.8900, 5749.3800, '2025-08-19', 1),
('68a49d2f3fc23', 2, '68a3322f2b656', '689fb088ea0e9', '2025-08-19', 'MERCANCIA NUEVA', 34.5000, 136.8900, 4722.7000, '2025-08-19', 1),
('68a49d972877f', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a49e2ae44d2', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a49e63275b4', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a49e7194426', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a49ef7891a1', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a49fc695522', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a02235b68', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a08b4064d', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a09e3efdb', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a0c13639f', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a0f5e1608', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a1170958d', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a15496f8f', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a173e85ce', 0, '0', '0', '0000-00-00', '', 0.0000, 0.0000, 0.0000, '2025-08-19', 1),
('68a4a1e42f4b6', 2, '68a331ed60853', '689fb088ea0e9', '2025-08-14', 'COMPRA DE COSAS', 54.5000, 136.8900, 7460.5000, '2025-08-19', 1),
('68a4a2d8ba6e2', 2, '68a3322f2b656', '689fb088ea0e9', '2025-08-19', 'CHATARRA', 30.0000, 136.8900, 4106.7000, '2025-08-19', 1),
('68a4a2daeaa50', 2, '68a3322f2b656', '689fb088ea0e9', '2025-08-19', 'CHATARRA', 30.0000, 136.8900, 4106.7000, '2025-08-19', 1),
('68a4a3128e245', 2, '68a3322f2b656', '689fb088ea0e9', '2025-08-19', 'CHATARRA', 30.0000, 136.8900, 4106.7000, '2025-08-19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_movement_items_data_table`
--

CREATE TABLE `account_movement_items_data_table` (
  `ami_id` int NOT NULL,
  `ami_movement` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ami_producto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ami_rate` decimal(28,4) NOT NULL,
  `ami_amount` decimal(28,4) NOT NULL,
  `ami_quantity` decimal(28,4) NOT NULL,
  `ami_total` decimal(28,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `account_movement_items_data_table`
--

INSERT INTO `account_movement_items_data_table` (`ami_id`, `ami_movement`, `ami_producto`, `ami_rate`, `ami_amount`, `ami_quantity`, `ami_total`) VALUES
(1, '68a4a173e85ce', '0', 0.0000, 0.0000, 0.0000, 0.0000),
(2, '68a4a173e85ce', '0', 0.0000, 0.0000, 0.0000, 0.0000),
(3, '68a4a173e85ce', '0', 0.0000, 0.0000, 0.0000, 0.0000),
(4, '68a4a1e42f4b6', '0', 136.8900, 0.0000, 0.0000, 0.0000),
(5, '68a4a1e42f4b6', '0', 136.8900, 0.0000, 0.0000, 0.0000),
(6, '68a4a1e42f4b6', '0', 136.8900, 0.0000, 0.0000, 0.0000),
(7, '68a4a3128e245', '68a3911971564', 136.8900, 0.5000, 50.0000, 25.0000),
(8, '68a4a3128e245', '68a3824a50b6e', 136.8900, 0.1000, 50.0000, 5.0000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_types_data_table`
--

CREATE TABLE `account_types_data_table` (
  `at_id` int NOT NULL,
  `at_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `account_types_data_table`
--

INSERT INTO `account_types_data_table` (`at_id`, `at_name`) VALUES
(1, 'VENTAS'),
(2, 'COMPRAS'),
(3, 'NOMINAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_data_table`
--

CREATE TABLE `client_data_table` (
  `c_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_indentity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Sin Registrar',
  `c_numphone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '+00-000-00000',
  `c_balance` double(28,4) DEFAULT '0.0000',
  `c_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `client_data_table`
--

INSERT INTO `client_data_table` (`c_id`, `c_name`, `c_indentity`, `c_numphone`, `c_balance`, `c_status`) VALUES
('689faf4948a10', '', '', '', 0.0000, 0),
('689fb088ea0e9', 'jovanni', 'V-847068', '424987858', 0.0000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `container_data_table`
--

CREATE TABLE `container_data_table` (
  `cont_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cont_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cont_tag` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cont_status` tinyint(1) NOT NULL DEFAULT '1',
  `cont_order` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `container_data_table`
--

INSERT INTO `container_data_table` (`cont_id`, `cont_name`, `cont_tag`, `cont_status`, `cont_order`) VALUES
('689e60a548f67', 'Gestion de Inventario', 'Inventario', 1, 2),
('689f9bde2eaf6', 'Gestion Administrativa', 'Administrativa', 1, 1),
('68a23ffa7db3f', 'Gestion de Seguridad', 'Seguridad', 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `container_model_data_table`
--

CREATE TABLE `container_model_data_table` (
  `id` int NOT NULL,
  `cont_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `m_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `container_model_data_table`
--

INSERT INTO `container_model_data_table` (`id`, `cont_id`, `m_id`) VALUES
(3, '689f9bde2eaf6', '689f9ee1e210d'),
(4, '689f9bde2eaf6', '689f9ef20af38'),
(5, '689f9bde2eaf6', '68a23fc2c66f4'),
(6, '68a23ffa7db3f', '68a240171a3a3'),
(7, '689f9bde2eaf6', '68a24ad85bc28'),
(8, '689f9bde2eaf6', '68a319ed13400'),
(9, '689f9bde2eaf6', '68a37189e2633');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `module_data_table`
--

CREATE TABLE `module_data_table` (
  `m_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `m_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `m_namelist` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `m_status` tinyint(1) NOT NULL DEFAULT '1',
  `m_available` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `module_data_table`
--

INSERT INTO `module_data_table` (`m_id`, `m_name`, `m_namelist`, `m_status`, `m_available`) VALUES
('689f9ee1e210d', 'clientes', 'Gestion de Clientes', 1, 0),
('689f9ef20af38', 'tasacambiaria', 'Control Cambiario', 1, 0),
('68a23fc2c66f4', 'proveedores', 'Gestion de Proveedor', 1, 0),
('68a240171a3a3', 'usuario', 'Gestion de Usuario', 1, 0),
('68a24ad85bc28', 'cuentas', 'Gestion de Cuentas', 1, 0),
('68a319ed13400', 'registros', 'Movimiento de Capital', 1, 0),
('68a37189e2633', 'productos', 'Gestion de Productos', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_category_data_table`
--

CREATE TABLE `product_category_data_table` (
  `pc_id` int NOT NULL,
  `pc_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product_category_data_table`
--

INSERT INTO `product_category_data_table` (`pc_id`, `pc_name`) VALUES
(1, 'Material Ferroso'),
(2, 'Material no Ferroso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_data_table`
--

CREATE TABLE `product_data_table` (
  `p_id` varchar(20) NOT NULL,
  `pc_id` int NOT NULL DEFAULT '1',
  `p_code` varchar(10) NOT NULL,
  `p_name` varchar(150) NOT NULL,
  `p_price_p` decimal(28,4) NOT NULL,
  `p_price_s` decimal(28,4) NOT NULL,
  `p_quantity` float NOT NULL DEFAULT '0',
  `p_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product_data_table`
--

INSERT INTO `product_data_table` (`p_id`, `pc_id`, `p_code`, `p_name`, `p_price_p`, `p_price_s`, `p_quantity`, `p_status`) VALUES
('68a3824a50b6e', 1, 'MF-01', 'HIERRO', 0.1000, 0.1400, 0, 1),
('68a3911971564', 1, 'MF-02', 'ALUMINIO', 0.5000, 0.6000, 0, 1),
('68a39606a2b78', 1, 'MF-03', 'COBRE', 0.0900, 0.1000, 0, 1),
('68a3963b2e948', 2, 'MnF-01', 'BATERIA', 0.5000, 0.6000, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate_data_table`
--

CREATE TABLE `rate_data_table` (
  `r_id` int NOT NULL,
  `r_date` date NOT NULL,
  `r_exchange_d` decimal(28,4) DEFAULT NULL,
  `r_exchange_e` decimal(28,4) DEFAULT NULL,
  `r_exchange_p` decimal(28,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rate_data_table`
--

INSERT INTO `rate_data_table` (`r_id`, `r_date`, `r_exchange_d`, `r_exchange_e`, `r_exchange_p`) VALUES
(1, '2025-08-19', 136.8931, 160.2827, NULL),
(2, '2025-08-18', 136.8900, 160.2800, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate_types_data_table`
--

CREATE TABLE `rate_types_data_table` (
  `rt_id` int NOT NULL,
  `rt_exchange` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rt_acronym` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rate_types_data_table`
--

INSERT INTO `rate_types_data_table` (`rt_id`, `rt_exchange`, `rt_acronym`) VALUES
(1, 'Dolares Americanos', 'USD'),
(2, 'Euros', 'EUROS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipts_data_table`
--

CREATE TABLE `receipts_data_table` (
  `rc_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `uid` varchar(20) NOT NULL,
  `rc_date` date NOT NULL,
  `rc_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rc_concept` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rc_amount` decimal(28,4) NOT NULL,
  `rc_balence` decimal(28,4) NOT NULL,
  `rc_status` tinyint(1) NOT NULL DEFAULT '1',
  `rc_type` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'VENTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receipts_items_data_table`
--

CREATE TABLE `receipts_items_data_table` (
  `ri_id` int NOT NULL,
  `rc_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `aei_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ei_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ei_detail` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ei_amount` decimal(28,4) NOT NULL,
  `ri_quatity` decimal(28,4) NOT NULL,
  `ri_amount` decimal(28,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supplier_data_table`
--

CREATE TABLE `supplier_data_table` (
  `s_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `s_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `s_indentity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Sin Registrar',
  `s_numphone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '+00-000-00000',
  `s_balance` double(28,4) DEFAULT '0.0000',
  `s_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `supplier_data_table`
--

INSERT INTO `supplier_data_table` (`s_id`, `s_name`, `s_indentity`, `s_numphone`, `s_balance`, `s_status`) VALUES
('68a3205f46ef5', 'jovanni franco', 'V-20975144', '4249568741', 0.0000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_data_table`
--

CREATE TABLE `user_data_table` (
  `u_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_login` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_pass` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `u_level` int NOT NULL,
  `u_status` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user_data_table`
--

INSERT INTO `user_data_table` (`u_id`, `u_name`, `u_email`, `u_login`, `u_pass`, `u_level`, `u_status`) VALUES
('685c635b19ebd', 'Jovanni Franco', 'jovannifranco@gmail.com', 'jfranco', '$2y$12$XWxnSHpB23ATbKEcEyqGtefN2RD01y79i61pNbWq7xkL/D6Kev2xS', 1, 1),
('685c64852c294', 'hbkjn', 'knkl', 'ljo', '$2y$12$tt4il3SmZ47ZkR47wUINeOuZkw9YB/.j8UIplGufFeWbae7z4hO02', 1, 0),
('685c64cd90edc', 'Daniel Franco', 'jdfm1991@gmail.com', 'dfranco', '$2y$12$sjvnlUGE22myYPTUR1sWqOI46Jup1t7y8gVJ9Ed6.jsLqtz4SJhfm', 2, 1),
('68a245a97e353', 'mano plas', 'mao@gmail.com', 'mano', '$2y$12$mQi8k1dB1aTosleewOO/MusD/L061oq3Oa1uvELLwBndr9jDkS8zy', 4, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_types_data_table`
--

CREATE TABLE `user_types_data_table` (
  `ut_id` int NOT NULL,
  `ut_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user_types_data_table`
--

INSERT INTO `user_types_data_table` (`ut_id`, `ut_name`) VALUES
(1, 'Super Administrador'),
(2, 'Administrador'),
(4, 'Operador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `account_data_table`
--
ALTER TABLE `account_data_table`
  ADD PRIMARY KEY (`a_id`);

--
-- Indices de la tabla `account_movements_data_table`
--
ALTER TABLE `account_movements_data_table`
  ADD PRIMARY KEY (`am_id`);

--
-- Indices de la tabla `account_movement_items_data_table`
--
ALTER TABLE `account_movement_items_data_table`
  ADD PRIMARY KEY (`ami_id`);

--
-- Indices de la tabla `account_types_data_table`
--
ALTER TABLE `account_types_data_table`
  ADD PRIMARY KEY (`at_id`);

--
-- Indices de la tabla `client_data_table`
--
ALTER TABLE `client_data_table`
  ADD PRIMARY KEY (`c_id`);

--
-- Indices de la tabla `container_data_table`
--
ALTER TABLE `container_data_table`
  ADD PRIMARY KEY (`cont_id`);

--
-- Indices de la tabla `container_model_data_table`
--
ALTER TABLE `container_model_data_table`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `module_data_table`
--
ALTER TABLE `module_data_table`
  ADD PRIMARY KEY (`m_id`);

--
-- Indices de la tabla `product_category_data_table`
--
ALTER TABLE `product_category_data_table`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indices de la tabla `product_data_table`
--
ALTER TABLE `product_data_table`
  ADD PRIMARY KEY (`p_id`);

--
-- Indices de la tabla `rate_data_table`
--
ALTER TABLE `rate_data_table`
  ADD PRIMARY KEY (`r_id`);

--
-- Indices de la tabla `rate_types_data_table`
--
ALTER TABLE `rate_types_data_table`
  ADD PRIMARY KEY (`rt_id`);

--
-- Indices de la tabla `receipts_data_table`
--
ALTER TABLE `receipts_data_table`
  ADD PRIMARY KEY (`rc_id`);

--
-- Indices de la tabla `receipts_items_data_table`
--
ALTER TABLE `receipts_items_data_table`
  ADD PRIMARY KEY (`ri_id`);

--
-- Indices de la tabla `supplier_data_table`
--
ALTER TABLE `supplier_data_table`
  ADD PRIMARY KEY (`s_id`);

--
-- Indices de la tabla `user_data_table`
--
ALTER TABLE `user_data_table`
  ADD PRIMARY KEY (`u_id`);

--
-- Indices de la tabla `user_types_data_table`
--
ALTER TABLE `user_types_data_table`
  ADD PRIMARY KEY (`ut_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `account_movement_items_data_table`
--
ALTER TABLE `account_movement_items_data_table`
  MODIFY `ami_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `account_types_data_table`
--
ALTER TABLE `account_types_data_table`
  MODIFY `at_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `container_model_data_table`
--
ALTER TABLE `container_model_data_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `product_category_data_table`
--
ALTER TABLE `product_category_data_table`
  MODIFY `pc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rate_data_table`
--
ALTER TABLE `rate_data_table`
  MODIFY `r_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `rate_types_data_table`
--
ALTER TABLE `rate_types_data_table`
  MODIFY `rt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `receipts_items_data_table`
--
ALTER TABLE `receipts_items_data_table`
  MODIFY `ri_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_types_data_table`
--
ALTER TABLE `user_types_data_table`
  MODIFY `ut_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
