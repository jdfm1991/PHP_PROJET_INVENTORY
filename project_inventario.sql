-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20240523.2997b5272e
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-01-2026 a las 23:15:40
-- Versión del servidor: 8.0.19
-- Versión de PHP: 8.3.24

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_movement_items_data_table`
--

CREATE TABLE `account_movement_items_data_table` (
  `ami_id` int NOT NULL,
  `ami_movement` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ami_product` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ami_rate` decimal(28,4) NOT NULL,
  `ami_amount` decimal(28,4) NOT NULL,
  `ami_quantity` decimal(28,4) NOT NULL,
  `ami_total` decimal(28,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_movement_types_data_table`
--

CREATE TABLE `account_movement_types_data_table` (
  `amt_id` int NOT NULL,
  `amt_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `account_types_data_table`
--

CREATE TABLE `account_types_data_table` (
  `at_id` int NOT NULL,
  `at_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bp_data_table`
--

CREATE TABLE `bp_data_table` (
  `bp_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bp_type` int NOT NULL,
  `bp_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bp_indentity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Sin Registrar',
  `bp_numphone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '+00-000-00000',
  `bp_address` varchar(200) DEFAULT NULL,
  `bp_balance` double(28,4) DEFAULT '0.0000',
  `bp_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='aliados comerciales';

--
-- Volcado de datos para la tabla `bp_data_table`
--

INSERT INTO `bp_data_table` (`bp_id`, `bp_type`, `bp_name`, `bp_indentity`, `bp_numphone`, `bp_address`, `bp_balance`, `bp_status`) VALUES
('695a544e6d1f1', 2, 'jose', 'V-25123587', '01254', 'su propia casa pues', 0.0000, 1),
('695a5479a7d80', 1, 'juan', 'V-25', '25', 'vasa', 0.0000, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bp_types_data_table`
--

CREATE TABLE `bp_types_data_table` (
  `bpt_id` int NOT NULL,
  `bpt_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='tipos de aliados comerciales cliente proveedor ';

--
-- Volcado de datos para la tabla `bp_types_data_table`
--

INSERT INTO `bp_types_data_table` (`bpt_id`, `bpt_name`) VALUES
(1, 'Cliente'),
(2, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_data_table`
--

CREATE TABLE `company_data_table` (
  `c_id` int NOT NULL,
  `c_name` varchar(80) NOT NULL,
  `c_identity` varchar(50) NOT NULL,
  `c_address` varchar(200) NOT NULL,
  `c_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `company_data_table`
--

INSERT INTO `company_data_table` (`c_id`, `c_name`, `c_identity`, `c_address`, `c_status`) VALUES
(1, 'Empresa de Prueba', 'J-12345678-9', 'direecion de prueba', 1);

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
('695a3d0c7242d', 'Seccion Administrativa', 'Administrativa', 1, NULL),
('695a3d1d5c177', 'Seccion de Sistema', 'Sistema', 1, NULL);

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
(1, '695a3d0c7242d', '695a3d6c4ba21'),
(2, '695a3d0c7242d', '695a474222d03'),
(4, '695a3d1d5c177', '695adba79068f'),
(5, '695a3d0c7242d', '695aee45b83b1'),
(6, '695a3d0c7242d', '695ad0164c8c2');

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
('695a3d6c4ba21', 'empresas', 'Gestion de Empresas', 1, 0),
('695a474222d03', 'sociocomercial', 'Proveedores y Clientes', 1, 0),
('695ad0164c8c2', 'compraventas', 'Registro de Compras y Ventas', 1, 0),
('695adba79068f', 'tasacambiaria', 'Control Cambiario', 1, 0),
('695aee45b83b1', 'productos', 'Gestion de Productos', 1, 0);

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
(1, 'Productos'),
(2, 'Recetas');

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
('695af4626efe7', 1, 'PROD-01', 'ARROZ', 0.5000, 0.8000, 0, 1),
('695af4845358e', 1, 'PROD-02', 'POLLO', 1.0000, 1.2000, 0, 1);

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
(1, '2026-01-05', 304.6796, 357.8858, NULL),
(2, '2026-01-04', 304.6800, 357.8900, NULL);

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
(2, 'Euros', 'EUR');

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
('695a3cce09a08', 'Jovanni Franco', 'jovannifranco@gmail.com', 'jfranco', '$2y$10$jsmVVu1ROKUq8bPTKs6hE.ANYtFqKsmkxo.3pm7TKKjEcsZNWNiX2', 1, 1);

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
(1, 'Estandar');

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
-- Indices de la tabla `account_movement_types_data_table`
--
ALTER TABLE `account_movement_types_data_table`
  ADD PRIMARY KEY (`amt_id`);

--
-- Indices de la tabla `account_types_data_table`
--
ALTER TABLE `account_types_data_table`
  ADD PRIMARY KEY (`at_id`);

--
-- Indices de la tabla `bp_data_table`
--
ALTER TABLE `bp_data_table`
  ADD PRIMARY KEY (`bp_id`);

--
-- Indices de la tabla `bp_types_data_table`
--
ALTER TABLE `bp_types_data_table`
  ADD PRIMARY KEY (`bpt_id`);

--
-- Indices de la tabla `company_data_table`
--
ALTER TABLE `company_data_table`
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
  MODIFY `ami_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `account_movement_types_data_table`
--
ALTER TABLE `account_movement_types_data_table`
  MODIFY `amt_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `account_types_data_table`
--
ALTER TABLE `account_types_data_table`
  MODIFY `at_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bp_types_data_table`
--
ALTER TABLE `bp_types_data_table`
  MODIFY `bpt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `company_data_table`
--
ALTER TABLE `company_data_table`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `container_model_data_table`
--
ALTER TABLE `container_model_data_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `ut_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
