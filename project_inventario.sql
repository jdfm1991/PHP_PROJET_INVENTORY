-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20240523.2997b5272e
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 19-01-2026 a las 00:54:45
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
('1', 3, 'Movimientos Internos', 'Sin Registrar', '+00-000-00000', NULL, 0.0000, 0),
('695a544e6d1f1', 2, 'jose', 'V-25123587', '01254', 'su propia casa pues', 0.0000, 1),
('695a5479a7d80', 1, 'juan', 'V-25', '25', 'vasa', 0.0000, 0);

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
(2, 'Proveedor'),
(3, 'Interno');

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
(6, '695a3d0c7242d', '695ad0164c8c2'),
(7, '695a3d1d5c177', '696cb386c5798'),
(8, '695a3d0c7242d', '696cb390ee324');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_movements_data_table`
--

CREATE TABLE `inventory_movements_data_table` (
  `im_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `im_company` varchar(20) NOT NULL,
  `im_type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `im_date` date NOT NULL,
  `im_partner` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `im_description` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `im_amount` decimal(28,4) NOT NULL,
  `im_rate` decimal(28,4) NOT NULL,
  `im_rtype` int NOT NULL,
  `im_change` decimal(28,4) NOT NULL,
  `im_datereg` datetime NOT NULL,
  `im_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventory_movements_data_table`
--

INSERT INTO `inventory_movements_data_table` (`im_id`, `im_company`, `im_type`, `im_date`, `im_partner`, `im_description`, `im_amount`, `im_rate`, `im_rtype`, `im_change`, `im_datereg`, `im_status`) VALUES
('696d295b7d4df', '1', '3', '2026-01-18', '1', 'CARGO DE PRODUCTO COMPUESTO', 10.0000, 344.5100, 1, 3445.1000, '2026-01-18 14:41:31', 1),
('696d295b87bbb', '1', '4', '2026-01-18', '1', 'Descargo por cargo de 20 PLATO DE ARROZ CON POLLO', 0.3000, 344.5100, 1, 103.3530, '2026-01-18 14:41:31', 1),
('696d2a0a3470a', '1', '3', '2026-01-18', '1', 'MUCHAS', 159.9000, 344.5100, 1, 55087.1500, '2026-01-18 14:44:26', 1),
('696d2a0a4ba50', '1', '4', '2026-01-18', '1', 'Descargo por cargo de 30 ARROZ CON POLLO', 114.0000, 344.5100, 1, 39274.1400, '2026-01-18 14:44:26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_movement_items_data_table`
--

CREATE TABLE `inventory_movement_items_data_table` (
  `imi_id` int NOT NULL,
  `imi_movement` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imi_date` date NOT NULL,
  `imi_product` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `imi_type` int NOT NULL,
  `imi_unit` int NOT NULL,
  `imi_amount` decimal(28,4) NOT NULL,
  `imi_quantity` decimal(28,4) NOT NULL,
  `imi_total` decimal(28,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventory_movement_items_data_table`
--

INSERT INTO `inventory_movement_items_data_table` (`imi_id`, `imi_movement`, `imi_date`, `imi_product`, `imi_type`, `imi_unit`, `imi_amount`, `imi_quantity`, `imi_total`) VALUES
(1, '696d295b7d4df', '2026-01-18', '696cf1f493dde', 2, 3, 0.5000, 20.0000, 10.0000),
(2, '696d295b87bbb', '2026-01-18', '695af4626efe7', 1, 1, 0.2000, 2.0000, 4.0000),
(3, '696d295b87bbb', '2026-01-18', '695af4845358e', 1, 1, 0.1000, 2.0000, 2.0000),
(4, '696d2a0a3470a', '2026-01-18', '695af4626efe7', 1, 2, 1.5000, 5.0000, 7.5000),
(5, '696d2a0a3470a', '2026-01-18', '695af4845358e', 1, 1, 1.2000, 2.0000, 2.4000),
(6, '696d2a0a3470a', '2026-01-18', '696023870dfed', 2, 3, 5.0000, 30.0000, 150.0000),
(7, '696d2a0a4ba50', '2026-01-18', '695af4845358e', 1, 1, 2.0000, 45.0000, 60.0000),
(8, '696d2a0a4ba50', '2026-01-18', '695af4626efe7', 1, 1, 1.8000, 27.0000, 54.0000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventory_movement_types_data_table`
--

CREATE TABLE `inventory_movement_types_data_table` (
  `imt_id` int NOT NULL,
  `imt_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventory_movement_types_data_table`
--

INSERT INTO `inventory_movement_types_data_table` (`imt_id`, `imt_name`) VALUES
(1, 'VENTAS'),
(2, 'COMPRAS'),
(3, 'CARGOS'),
(4, 'DESCARGOS'),
(5, 'AJUSTES'),
(6, 'DEVOLUCION EN VENTAS'),
(7, 'DEVOLUCION EN COMPRAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_recipe_data_table`
--

CREATE TABLE `item_recipe_data_table` (
  `ir_id` int NOT NULL,
  `ir_recipe` varchar(20) NOT NULL,
  `ir_product` varchar(20) NOT NULL,
  `ir_name` varchar(100) NOT NULL,
  `ir_amount` decimal(28,4) NOT NULL,
  `ir_quantity` decimal(28,4) NOT NULL,
  `ir_unit` varchar(10) NOT NULL,
  `ir_total` decimal(28,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `item_recipe_data_table`
--

INSERT INTO `item_recipe_data_table` (`ir_id`, `ir_recipe`, `ir_product`, `ir_name`, `ir_amount`, `ir_quantity`, `ir_unit`, `ir_total`) VALUES
(5, '696023870dfed', '695af4845358e', 'POLLO', 1.0000, 1.5000, 'Lts', 2.0000),
(6, '696023870dfed', '695af4626efe7', 'ARROZ', 2.0000, 0.9000, 'Kg', 1.8000),
(7, '696cf1f493dde', '695af4626efe7', 'ARROZ', 2.0000, 0.1000, 'Kg', 0.2000),
(8, '696cf1f493dde', '695af4845358e', 'POLLO', 1.0000, 0.1000, 'Lts', 0.1000),
(9, '696cf2ec48a05', '695af4845358e', 'POLLO', 1.0000, 0.1100, 'Lts', 0.1100),
(10, '696cf2ec48a05', '695af4626efe7', 'ARROZ', 2.0000, 0.0750, 'Kg', 0.1500);

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
('695aee45b83b1', 'productos', 'Gestion de Productos', 1, 0),
('696cb386c5798', 'usuario', 'Gestion de Usuarios', 1, 0),
('696cb390ee324', 'inventario', 'Gestion de Inventario', 1, 0);

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
  `p_unit` int NOT NULL,
  `p_price_p` decimal(28,4) NOT NULL,
  `p_price_s` decimal(28,4) NOT NULL,
  `p_existence` float NOT NULL DEFAULT '0',
  `p_status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product_data_table`
--

INSERT INTO `product_data_table` (`p_id`, `pc_id`, `p_code`, `p_name`, `p_unit`, `p_price_p`, `p_price_s`, `p_existence`, `p_status`) VALUES
('695af4626efe7', 1, 'PROD-01', 'ARROZ', 2, 2.0000, 1.5000, 35, 1),
('695af4845358e', 1, 'PROD-02', 'POLLO', 1, 1.0000, 1.2000, 32, 1),
('696021c7954f0', 2, 'RECE-01', 'ARRROZ CON POLLO', 3, 3.8000, 5.0000, 0, 0),
('696023870dfed', 2, 'RECE-02', 'ARROZ CON POLLO', 3, 3.3000, 5.0000, 61, 1),
('696cf1f493dde', 2, 'RECE-03', 'PLATO DE ARROZ CON POLLO', 3, 0.3000, 0.5000, 55, 1),
('696cf2ec48a05', 2, 'RECE-04', 'CPSAS', 3, 0.2600, 0.5000, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_units_data_table`
--

CREATE TABLE `product_units_data_table` (
  `pu_id` int NOT NULL,
  `pu_name` varchar(20) NOT NULL,
  `pu_acronym` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product_units_data_table`
--

INSERT INTO `product_units_data_table` (`pu_id`, `pu_name`, `pu_acronym`) VALUES
(1, 'Litros', 'Lts'),
(2, 'Kilogramos', 'Kg'),
(3, 'Unidades', 'Und');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rate_data_table`
--

CREATE TABLE `rate_data_table` (
  `r_id` int NOT NULL,
  `r_date` date NOT NULL,
  `r_type` int DEFAULT NULL,
  `r_exchange` decimal(28,4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rate_data_table`
--

INSERT INTO `rate_data_table` (`r_id`, `r_date`, `r_type`, `r_exchange`) VALUES
(3, '2026-01-13', 1, 330.3751),
(4, '2026-01-13', 2, 384.3320),
(5, '2026-01-10', 1, 330.3800),
(6, '2026-01-11', 2, 384.3300),
(7, '2026-01-09', 1, 325.3800),
(8, '2026-01-09', 2, 379.6400),
(9, '2026-01-10', 2, 384.3310),
(10, '2026-01-11', 1, 330.3800),
(11, '2026-01-20', 1, 344.5071),
(12, '2026-01-20', 2, 400.4929),
(13, '2026-01-18', 1, 344.5100),
(14, '2026-01-18', 2, 400.4900);

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
('695a3cce09a08', 'Jovanni Franco', 'jovannifranco@gmail.com', 'jfranco', '$2y$10$jsmVVu1ROKUq8bPTKs6hE.ANYtFqKsmkxo.3pm7TKKjEcsZNWNiX2', 1, 1),
('696cb3f48aea9', 'Demostrativo', 'demo@demo.com', 'demo', '$2y$10$au0eMcUKJiTxjJP4TpQoo.W9su7ZMmjrIQ5I.AKXm2mXzGgNq.jgK', 1, 1);

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
-- Indices de la tabla `inventory_movements_data_table`
--
ALTER TABLE `inventory_movements_data_table`
  ADD PRIMARY KEY (`im_id`);

--
-- Indices de la tabla `inventory_movement_items_data_table`
--
ALTER TABLE `inventory_movement_items_data_table`
  ADD PRIMARY KEY (`imi_id`);

--
-- Indices de la tabla `inventory_movement_types_data_table`
--
ALTER TABLE `inventory_movement_types_data_table`
  ADD PRIMARY KEY (`imt_id`);

--
-- Indices de la tabla `item_recipe_data_table`
--
ALTER TABLE `item_recipe_data_table`
  ADD PRIMARY KEY (`ir_id`);

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
-- Indices de la tabla `product_units_data_table`
--
ALTER TABLE `product_units_data_table`
  ADD PRIMARY KEY (`pu_id`);

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
-- AUTO_INCREMENT de la tabla `bp_types_data_table`
--
ALTER TABLE `bp_types_data_table`
  MODIFY `bpt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `company_data_table`
--
ALTER TABLE `company_data_table`
  MODIFY `c_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `container_model_data_table`
--
ALTER TABLE `container_model_data_table`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `inventory_movement_items_data_table`
--
ALTER TABLE `inventory_movement_items_data_table`
  MODIFY `imi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `inventory_movement_types_data_table`
--
ALTER TABLE `inventory_movement_types_data_table`
  MODIFY `imt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `item_recipe_data_table`
--
ALTER TABLE `item_recipe_data_table`
  MODIFY `ir_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `product_category_data_table`
--
ALTER TABLE `product_category_data_table`
  MODIFY `pc_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `product_units_data_table`
--
ALTER TABLE `product_units_data_table`
  MODIFY `pu_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rate_data_table`
--
ALTER TABLE `rate_data_table`
  MODIFY `r_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `rate_types_data_table`
--
ALTER TABLE `rate_types_data_table`
  MODIFY `rt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user_types_data_table`
--
ALTER TABLE `user_types_data_table`
  MODIFY `ut_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
