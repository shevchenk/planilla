/*
 Navicat Premium Data Transfer

 Source Server         : LocalHost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : planilla

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 03/06/2018 22:15:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for a_dias
-- ----------------------------
DROP TABLE IF EXISTS `a_dias`;
CREATE TABLE `a_dias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `dia_apocope` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of a_dias
-- ----------------------------
INSERT INTO `a_dias` VALUES (1, 'Lunes', 'Lu', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (2, 'Martes', 'Ma', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (3, 'Miercoles', 'Mi', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (4, 'Jueves', 'Ju', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (5, 'Viernes', 'Vi', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (6, 'Sabado', 'Sa', 1, '2018-04-19 10:30:00', NULL, 1, NULL);
INSERT INTO `a_dias` VALUES (7, 'Domingo', 'Do', 1, '2018-04-19 10:30:00', NULL, 1, NULL);

-- ----------------------------
-- Table structure for m_cargos
-- ----------------------------
DROP TABLE IF EXISTS `m_cargos`;
CREATE TABLE `m_cargos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sueldo_mensual_base` decimal(10, 2) NULL DEFAULT NULL COMMENT 'Sueldo mensual que se tomará automaticamente al contrato del trabajador',
  `sueldo_produccion_base` decimal(10, 2) NULL DEFAULT NULL COMMENT 'Sueldo por producción que se tomará automaticamente al contrato del trabajador',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_cargos
-- ----------------------------
INSERT INTO `m_cargos` VALUES (1, 'Jefe Sistemas', 5000.00, 5000.00, 1, '2018-04-22 21:08:43', NULL, 1, NULL);
INSERT INTO `m_cargos` VALUES (2, 'Programador', 2000.00, 400.00, 1, '2018-04-22 23:18:09', NULL, 1, NULL);

-- ----------------------------
-- Table structure for m_consorcios
-- ----------------------------
DROP TABLE IF EXISTS `m_consorcios`;
CREATE TABLE `m_consorcios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consorcio` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `consorcio_apocope` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `ruc` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_consorcios
-- ----------------------------
INSERT INTO `m_consorcios` VALUES (1, 'Isel', 'ISEL', 'botas-andrea.jpg', '12332112311', 1, '2018-04-22 00:12:05', '2018-04-23 14:20:13', 1, 1);

-- ----------------------------
-- Table structure for m_dias_no_laborables
-- ----------------------------
DROP TABLE IF EXISTS `m_dias_no_laborables`;
CREATE TABLE `m_dias_no_laborables`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `sede_ids` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Cuando se programe un día no laborable debe ejecutarse un de /* comment truncated */ /*monio que ejecute un evento programado de dia de descanzo a todos los trabajadores según sede y fecha asignada.*/' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_dias_no_laborables
-- ----------------------------
INSERT INTO `m_dias_no_laborables` VALUES (1, '2018-04-28', '1', 1, '2018-04-23 14:32:45', '2018-04-23 14:32:45', 1, NULL);
INSERT INTO `m_dias_no_laborables` VALUES (2, '2018-04-29', '', 1, '2018-04-23 14:33:34', '2018-04-23 14:35:29', 1, 1);

-- ----------------------------
-- Table structure for m_eventos_tipos
-- ----------------------------
DROP TABLE IF EXISTS `m_eventos_tipos`;
CREATE TABLE `m_eventos_tipos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_tipo` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `aplica_dscto` int(11) NOT NULL DEFAULT 0 COMMENT '0: No aplica | 1:Si aplica | El dscto servirá para los calculos de dscto de pago del trabajo o justificacion de las faltas o minutos libres prestados.',
  `aplica_cambio` int(11) NOT NULL DEFAULT 0 COMMENT '0: Todo | 1: Fecha Ingreso | 2: Fecha Salida',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Estos tipos clasificaran los eventos para poder identificar  /* comment truncated */ /*quienes descontaran su pago o justifican su inasistencia o minutos de salidas.*/' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_eventos_tipos
-- ----------------------------
INSERT INTO `m_eventos_tipos` VALUES (1, 'Vacaciones', 0, 0, 1, '2018-04-22 21:54:14', '2018-04-22 21:58:06', 1, 1);

-- ----------------------------
-- Table structure for m_horarios_plantillas
-- ----------------------------
DROP TABLE IF EXISTS `m_horarios_plantillas`;
CREATE TABLE `m_horarios_plantillas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plantilla_descripcion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `dia_ids` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `hora_inicio` time(0) NOT NULL,
  `hora_fin` time(0) NOT NULL,
  `horario_amanecida` int(11) NULL DEFAULT 0,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_horarios_plantillas
-- ----------------------------
INSERT INTO `m_horarios_plantillas` VALUES (1, 'a', '1', '02:00:00', '10:00:00', 0, 1, '2018-04-23 14:38:06', '2018-04-23 14:38:06', 1, NULL);
INSERT INTO `m_horarios_plantillas` VALUES (2, 'B', '2,4', '23:00:00', '06:00:00', 1, 1, '2018-04-23 14:40:30', '2018-04-23 14:40:30', 1, NULL);

-- ----------------------------
-- Table structure for m_menus
-- ----------------------------
DROP TABLE IF EXISTS `m_menus`;
CREATE TABLE `m_menus`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_icono` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_menus
-- ----------------------------
INSERT INTO `m_menus` VALUES (1, 'Mantenimiento', 'fa fa-cogs', 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_menus` VALUES (2, 'Proceso', 'fa fa-list', 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_menus` VALUES (3, 'Reporte', 'fa fa-list', 1, '2018-06-03 21:24:32', NULL, 1, NULL);

-- ----------------------------
-- Table structure for m_opciones
-- ----------------------------
DROP TABLE IF EXISTS `m_opciones`;
CREATE TABLE `m_opciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `opcion` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ruta` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `class_icono` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `op_menu_id`(`menu_id`) USING BTREE,
  CONSTRAINT `m_opciones_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `m_menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_opciones
-- ----------------------------
INSERT INTO `m_opciones` VALUES (1, 1, 'Sedes', 'mantenimiento.sede.sede', 'fa fa-institution', 1, '2018-04-20 13:08:21', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (2, 2, 'Contratos', 'proceso.contrato.contrato', 'fa fa-sitemap', 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (3, 1, 'Consorcios', 'mantenimiento.consorcio.consorcio', 'fa fa-cubes', 1, '2018-04-21 17:48:09', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (4, 1, 'Tipo de Eventos', 'mantenimiento.eventotipo.eventotipo', 'fa', 1, '2018-04-21 17:48:56', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (5, 1, 'Menús', 'mantenimiento.menu.menu', 'fa', 1, '2018-04-21 18:33:27', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (6, 1, 'Opciones', 'mantenimiento.opcion.opcion', 'fa', 1, '2018-04-21 18:33:59', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (7, 1, 'Usuarios', 'mantenimiento.persona.persona', 'fa fa-group', 1, '2018-04-21 18:34:51', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (8, 1, 'Privilegios', 'mantenimiento.privilegio.privilegio', 'fa fa-dedent', 1, '2018-04-21 18:39:33', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (9, 1, 'Regímenes', 'mantenimiento.regimen.regimen', 'fa', 1, '2018-04-21 18:40:01', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (10, 1, 'Dias No Laborables', 'mantenimiento.dianolaboral.dianolaboral', 'fa', 1, '2018-04-23 14:26:44', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (11, 1, 'Plantillas Horarios', 'mantenimiento.horarioplantilla.horarioplantilla', 'fa', 1, '2018-04-23 14:28:39', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (12, 2, 'Eventos', 'proceso.evento.evento', 'fa', 1, '2018-04-24 11:26:31', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (13, 2, 'Eventos Master', 'proceso.eventomaster.eventomaster', 'fa', 1, '2018-04-24 11:26:31', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (14, 2, 'Programación Horarios', 'proceso.horarioprogramado.horarioprogramado', 'fa', 1, '2018-04-25 21:47:49', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (15, 2, 'Marcación', 'proceso.marcacion.marcacion', 'fa fa-clock-o', 1, '2018-04-25 21:48:45', NULL, 1, NULL);
INSERT INTO `m_opciones` VALUES (16, 3, 'Horarios', 'reporte.horario.horario', 'fa', 1, '2018-06-03 21:23:49', NULL, 1, NULL);

-- ----------------------------
-- Table structure for m_personas
-- ----------------------------
DROP TABLE IF EXISTS `m_personas`;
CREATE TABLE `m_personas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paterno` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `materno` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dni` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sexo` char(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'M',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `remember_token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `celular` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `fecha_nacimiento` date NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_personas
-- ----------------------------
INSERT INTO `m_personas` VALUES (1, 'Salcedo', 'Franco', 'Jorge Luis', '12312312', 'M', 'jorgeshevchenk@gmail.com', '$2y$10$GbcNEAXRTarkHEU/diSbA.vNd5eipLoV5f2RMpr5piMcJZb3NxIhK', 'uxDoS430i4w17vsAOKkRPeHjb2HLp3eryyEYITsDzAdK51X3czSjRT5OBFwT', '', '', '', '1988-10-14', 1, '2018-04-20 13:10:36', '2018-04-23 14:29:55', 1, 1);
INSERT INTO `m_personas` VALUES (7, 'Mori', 'Guerra', 'Luis', '12332111', 'M', '', '$2y$10$PG1PUQK.hJkX8wfH3HG/5e0E1xEjMbpvwkFT6U1GRL4UNLUREw/iG', '', '', '', '', NULL, 1, '2018-04-22 23:30:17', '2018-04-22 23:30:17', 1, NULL);

-- ----------------------------
-- Table structure for m_privilegios
-- ----------------------------
DROP TABLE IF EXISTS `m_privilegios`;
CREATE TABLE `m_privilegios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilegio` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_privilegios
-- ----------------------------
INSERT INTO `m_privilegios` VALUES (1, 'Master', 1, '2018-04-20 13:08:48', NULL, 1, NULL);
INSERT INTO `m_privilegios` VALUES (2, 'Prueba', 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);

-- ----------------------------
-- Table structure for m_privilegios_opciones
-- ----------------------------
DROP TABLE IF EXISTS `m_privilegios_opciones`;
CREATE TABLE `m_privilegios_opciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privilegio_id` int(11) NOT NULL,
  `opcion_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `po_privilegio_id`(`privilegio_id`) USING BTREE,
  INDEX `po_opcion_id`(`opcion_id`) USING BTREE,
  CONSTRAINT `m_privilegios_opciones_ibfk_1` FOREIGN KEY (`opcion_id`) REFERENCES `m_opciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `m_privilegios_opciones_ibfk_2` FOREIGN KEY (`privilegio_id`) REFERENCES `m_privilegios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_privilegios_opciones
-- ----------------------------
INSERT INTO `m_privilegios_opciones` VALUES (1, 1, 1, 1, '2018-04-20 13:08:48', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (2, 1, 2, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (3, 1, 3, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (4, 1, 4, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (5, 1, 5, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (6, 1, 6, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (7, 1, 7, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (8, 1, 8, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (9, 1, 9, 1, '2018-04-20 13:05:43', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (10, 1, 10, 1, '2018-04-23 14:29:11', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (11, 1, 11, 1, '2018-04-23 14:29:11', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (12, 1, 12, 1, '2018-04-24 11:26:31', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (13, 1, 13, 1, '2018-04-24 11:26:31', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (14, 2, 3, 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (15, 2, 2, 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (16, 2, 8, 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (17, 2, 1, 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (18, 2, 7, 1, '2018-04-25 01:46:06', '2018-04-25 01:46:06', 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (19, 1, 14, 1, '2018-04-25 21:51:13', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (20, 1, 15, 1, '2018-04-25 21:51:31', NULL, 1, NULL);
INSERT INTO `m_privilegios_opciones` VALUES (21, 1, 16, 1, '2018-06-03 21:25:03', NULL, 1, NULL);

-- ----------------------------
-- Table structure for m_regimenes
-- ----------------------------
DROP TABLE IF EXISTS `m_regimenes`;
CREATE TABLE `m_regimenes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `regimen` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `tipo_regimen` int(11) NOT NULL COMMENT '1:Flujo|2:Mixto|3:Otros',
  `aporte` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `comision` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `prima` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `seguro` decimal(10, 2) NOT NULL DEFAULT 0.00,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_regimenes
-- ----------------------------
INSERT INTO `m_regimenes` VALUES (1, 'AFP Prima', 1, 10.00, 3.00, 1.12, 0.00, 1, '2018-04-22 00:12:50', '2018-04-22 20:58:32', 1, 1);

-- ----------------------------
-- Table structure for m_sedes
-- ----------------------------
DROP TABLE IF EXISTS `m_sedes`;
CREATE TABLE `m_sedes`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sede` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `direccion` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `telefono` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `celular` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_sedes
-- ----------------------------
INSERT INTO `m_sedes` VALUES (1, 'Av 28 Julio', 'Av 28 de Julio', '', '', '', 'botas-andrea.jpg', 1, '2018-04-21 22:42:41', '2018-04-21 22:42:41', 1, NULL);
INSERT INTO `m_sedes` VALUES (2, 'Junin 606', 'Juniin', '', '', '', 'fondo.jpg', 1, '2018-04-23 14:33:14', '2018-04-23 14:33:14', 1, NULL);

-- ----------------------------
-- Table structure for m_sedes_consorcios
-- ----------------------------
DROP TABLE IF EXISTS `m_sedes_consorcios`;
CREATE TABLE `m_sedes_consorcios`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consorcio_id` int(11) NOT NULL,
  `sede_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_s_c_consorcio_id`(`consorcio_id`) USING BTREE,
  INDEX `fk_m_s_c_sede_id`(`sede_id`) USING BTREE,
  CONSTRAINT `m_sedes_consorcios_ibfk_1` FOREIGN KEY (`consorcio_id`) REFERENCES `m_consorcios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `m_sedes_consorcios_ibfk_2` FOREIGN KEY (`sede_id`) REFERENCES `m_sedes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for m_sedes_privilegios_personas
-- ----------------------------
DROP TABLE IF EXISTS `m_sedes_privilegios_personas`;
CREATE TABLE `m_sedes_privilegios_personas`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `privilegio_id` int(11) NOT NULL,
  `sede_ids` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Selecciona las sedes a las cuales el usuario tiene permiso, si esta vacio indica que tiene todas las sedes.',
  `consorcio_ids` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT 'Selecciona los consorcios a las cuales el usuario tiene permiso, si esta vacio indica que tiene todas los consorcios.',
  `fecha_ingreso` date NULL DEFAULT NULL,
  `fecha_salida` date NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ppc_privilegio_id`(`privilegio_id`) USING BTREE,
  INDEX `ppc_persona_id`(`persona_id`) USING BTREE,
  CONSTRAINT `m_sedes_privilegios_personas_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `m_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `m_sedes_privilegios_personas_ibfk_2` FOREIGN KEY (`privilegio_id`) REFERENCES `m_privilegios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of m_sedes_privilegios_personas
-- ----------------------------
INSERT INTO `m_sedes_privilegios_personas` VALUES (1, 1, 1, '', '', '2018-04-20', NULL, 1, '2018-04-20 13:08:48', NULL, 1, 1);
INSERT INTO `m_sedes_privilegios_personas` VALUES (2, 1, 2, '', '', '2018-04-25', NULL, 1, '2018-04-25 01:04:29', NULL, 1, NULL);

-- ----------------------------
-- Table structure for p_asistencias
-- ----------------------------
DROP TABLE IF EXISTS `p_asistencias`;
CREATE TABLE `p_asistencias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_contrato_id` int(11) NOT NULL,
  `horario_programado_id` int(11) NULL DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NULL DEFAULT NULL,
  `hora_ingreso` time(0) NOT NULL,
  `hora_salida` time(0) NULL DEFAULT NULL,
  `total_hora_tardanza` time(0) NOT NULL DEFAULT '00:00:00' COMMENT 'total tardanza se validará su hora ingreso programada vs la hora ingreso marcada, solo se considera tardanza si ',
  `total_hora` time(0) NULL DEFAULT NULL COMMENT 'Total hora esta afecto al calculo de la fecha y hora inicial menos la fecha y hora final.',
  `asistencia_estado_ini` int(11) NULL DEFAULT 0 COMMENT 'Asistencia Estado esta afecto al calculo de la fecha y hora inicial  vs el horario programado. 0: Dentro del Tiempo | 1: Tardanza | 2: Falta (porque marco mayor y fuera de la  hora ingreso programado) | 3: Cancelado (Por que no cuenta con horario programa /* comment truncated */ /*do) .*/',
  `asistencia_estado_fin` int(11) NULL DEFAULT 0 COMMENT 'Asistencia Estado esta afecto al calculo de la fecha y hora inicial  vs el horario programado. 0: Asistió | 1: Tardanza | 2: Falta (porque marco mayor y fuera de la  hora ingreso programado) | 3: Cancelado (Por que no cuenta con horario programado o no ma /* comment truncated */ /*rco hora de salida) .*/',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_a_persona_contrato_id`(`persona_contrato_id`) USING BTREE,
  INDEX `fk_a_horario_programado_id`(`horario_programado_id`) USING BTREE,
  CONSTRAINT `p_asistencias_ibfk_1` FOREIGN KEY (`horario_programado_id`) REFERENCES `p_horarios_programados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_asistencias_ibfk_2` FOREIGN KEY (`persona_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_asistencias
-- ----------------------------
INSERT INTO `p_asistencias` VALUES (3, 2, 1, '2018-04-24', NULL, '08:00:00', NULL, '00:00:00', NULL, 1, 0, 0, '2018-04-24 12:02:35', '2018-04-24 18:09:24', 1, 1);
INSERT INTO `p_asistencias` VALUES (6, 1, NULL, '2018-04-29', NULL, '20:16:53', NULL, '00:00:00', NULL, 3, 3, 1, '2018-04-29 20:16:53', '2018-04-29 20:16:53', 1, NULL);

-- ----------------------------
-- Table structure for p_asistencias_historicos
-- ----------------------------
DROP TABLE IF EXISTS `p_asistencias_historicos`;
CREATE TABLE `p_asistencias_historicos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_id` int(11) NOT NULL,
  `persona_contrato_id` int(11) NOT NULL,
  `horario_programado_id` int(11) NULL DEFAULT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_salida` date NULL DEFAULT NULL,
  `hora_ingreso` time(0) NOT NULL,
  `hora_salida` time(0) NULL DEFAULT NULL,
  `total_hora_tardanza` time(0) NOT NULL DEFAULT '00:00:00' COMMENT 'total tardanza se validará su hora ingreso programada vs la hora ingreso marcada, solo se considera tardanza si ',
  `total_hora` time(0) NULL DEFAULT NULL COMMENT 'Total hora esta afecto al calculo de la fecha y hora inicial menos la fecha y hora final.',
  `asistencia_estado_ini` int(11) NULL DEFAULT 0 COMMENT 'Asistencia Estado esta afecto al calculo de la fecha y hora inicial  vs el horario programado. 0: Dentro del Tiempo | 1: Tardanza | 2: Falta (porque marco mayor y fuera de la  hora ingreso programado) | 3: Cancelado (Por que no cuenta con horario programa /* comment truncated */ /*do) .*/',
  `asistencia_estado_fin` int(11) NULL DEFAULT 0 COMMENT 'Asistencia Estado esta afecto al calculo de la fecha y hora inicial  vs el horario programado. 0: Asistió | 1: Tardanza | 2: Falta (porque marco mayor y fuera de la  hora ingreso programado) | 3: Cancelado (Por que no cuenta con horario programado o no ma /* comment truncated */ /*rco hora de salida) .*/',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL COMMENT 'persona updated será la el usuario aterior (el penultimo) que modifico el registro.',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_a_h_persona_contrato_id`(`persona_contrato_id`) USING BTREE,
  INDEX `fk_a_h_horario_programado_id`(`horario_programado_id`) USING BTREE,
  INDEX `fk_a_h_asistencia_id`(`asistencia_id`) USING BTREE,
  CONSTRAINT `p_asistencias_historicos_ibfk_1` FOREIGN KEY (`asistencia_id`) REFERENCES `p_asistencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_asistencias_historicos_ibfk_2` FOREIGN KEY (`horario_programado_id`) REFERENCES `p_horarios_programados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_asistencias_historicos_ibfk_3` FOREIGN KEY (`persona_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_asistencias_historicos
-- ----------------------------
INSERT INTO `p_asistencias_historicos` VALUES (1, 3, 2, 1, '2018-04-24', NULL, '08:00:00', NULL, '00:00:00', NULL, 1, 0, 0, '2018-04-24 18:09:24', '2018-04-24 18:09:24', 1, NULL);
INSERT INTO `p_asistencias_historicos` VALUES (3, 6, 1, NULL, '2018-04-29', NULL, '20:16:53', NULL, '00:00:00', NULL, 3, NULL, 1, '2018-04-29 20:16:53', '2018-04-29 20:16:53', 1, NULL);

-- ----------------------------
-- Table structure for p_asistencias_marcaciones
-- ----------------------------
DROP TABLE IF EXISTS `p_asistencias_marcaciones`;
CREATE TABLE `p_asistencias_marcaciones`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_id` int(11) NULL DEFAULT NULL,
  `persona_contrato_id` int(11) NOT NULL,
  `fecha_marcada` date NULL DEFAULT NULL,
  `hora_marcada` time(0) NULL DEFAULT NULL,
  `tipo_registro` int(11) NOT NULL DEFAULT 1 COMMENT '1: Registro Sistema | 2: Registro Huella Digital',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pam_fk_asistencia_id`(`asistencia_id`) USING BTREE,
  INDEX `pam_fk_persona_contrato_id`(`persona_contrato_id`) USING BTREE,
  CONSTRAINT `p_asistencias_marcaciones_ibfk_1` FOREIGN KEY (`asistencia_id`) REFERENCES `p_asistencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_asistencias_marcaciones_ibfk_2` FOREIGN KEY (`persona_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_asistencias_marcaciones
-- ----------------------------
INSERT INTO `p_asistencias_marcaciones` VALUES (1, 6, 1, '2018-04-29', '20:16:53', 1, 1, '2018-04-29 20:16:53', '2018-04-29 20:16:53', 1, NULL);

-- ----------------------------
-- Table structure for p_eventos
-- ----------------------------
DROP TABLE IF EXISTS `p_eventos`;
CREATE TABLE `p_eventos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `evento_tipo_id` int(11) NOT NULL,
  `persona_contrato_id` int(11) NOT NULL,
  `evento_descripcion` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `hora_inicio` time(0) NOT NULL,
  `hora_fin` time(0) NOT NULL,
  `ini_marcado` datetime(0) NULL DEFAULT NULL COMMENT 'Fecha y Hora de inicio marcado por el trabajador a travez de la huella digital.',
  `fin_marcado` datetime(0) NULL DEFAULT NULL COMMENT 'Fecha y Hora de fin marcado por el trabajador a travez de la huella digital.',
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_eventos_evento_tipo_id`(`evento_tipo_id`) USING BTREE,
  INDEX `fk_p_eventos_persona_contrato_id`(`persona_contrato_id`) USING BTREE,
  CONSTRAINT `p_eventos_ibfk_1` FOREIGN KEY (`evento_tipo_id`) REFERENCES `m_eventos_tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_eventos_ibfk_2` FOREIGN KEY (`persona_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Las fechas seran auntomáticamente calculadas por la programa /* comment truncated */ /*cion asignada del empleado tanto el horario final como el horario incial seran automáticos según sea el caso, podrá ser editado por quien asigna el permiso.*/' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_eventos
-- ----------------------------
INSERT INTO `p_eventos` VALUES (1, 1, 2, '2112321213xswfsdfs', '2018-04-24', '2018-04-24', '10:44:00', '11:00:00', NULL, NULL, 0, '2018-04-24 11:50:04', '2018-04-24 18:09:24', 1, 1);
INSERT INTO `p_eventos` VALUES (2, 1, 2, 'asda', '2018-04-24', '2018-04-25', '08:00:00', '19:00:00', NULL, NULL, 0, '2018-04-24 11:52:23', '2018-04-24 12:11:20', 1, 1);
INSERT INTO `p_eventos` VALUES (3, 1, 2, 'nuevo projnsf kjsd.fkjdkj kjsdkfsdkj jkdskjfkjsdfkjdsf jkkjsdkjdskjsdkjldsf kjkjsdkjdsjkdsf kjkjsdjksdkjsdf kjkjdskljdsf kjdkdskjdsf kjkjsdkjsdf nsdkjsdf kjnjdsnkdfkn sdkjknsdkjkdsfjkjskjnsdkjn kknsdfnsd nkjskjskjsdg knkjsdkjndskjngkjnsndvkn  kjsdkjfds knsdkdsfnj atte yo', '2018-04-25', '2018-04-26', '11:11:00', '11:11:00', NULL, NULL, 0, '2018-04-24 11:57:13', '2018-04-24 17:55:37', 1, 1);
INSERT INTO `p_eventos` VALUES (4, 1, 2, 'asdasd asdasd asd', '2018-04-24', '2018-04-25', '11:11:00', '12:00:00', NULL, NULL, 0, '2018-04-24 11:59:42', '2018-04-24 12:11:02', 1, 1);
INSERT INTO `p_eventos` VALUES (5, 1, 2, 'wnuvo', '2018-04-23', '2018-04-25', '12:32:00', '18:43:00', NULL, NULL, 1, '2018-04-24 18:09:48', '2018-04-24 18:09:48', 1, NULL);

-- ----------------------------
-- Table structure for p_eventos_asistencias
-- ----------------------------
DROP TABLE IF EXISTS `p_eventos_asistencias`;
CREATE TABLE `p_eventos_asistencias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asistencia_id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_asistencia_evento_p_asistencias1`(`asistencia_id`) USING BTREE,
  INDEX `fk_p_asistencia_evento_m_eventos1`(`evento_id`) USING BTREE,
  CONSTRAINT `p_eventos_asistencias_ibfk_1` FOREIGN KEY (`evento_id`) REFERENCES `p_eventos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_eventos_asistencias_ibfk_2` FOREIGN KEY (`asistencia_id`) REFERENCES `p_asistencias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'Asistencia y Eventos afectaran a las asistencias y guardarán /* comment truncated */ /* en su historico para ver los movimientos.*/' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_eventos_asistencias
-- ----------------------------
INSERT INTO `p_eventos_asistencias` VALUES (2, 3, 1, 0, '2018-04-24 12:04:27', '2018-04-24 18:09:24', 1, 1);

-- ----------------------------
-- Table structure for p_horarios_programados
-- ----------------------------
DROP TABLE IF EXISTS `p_horarios_programados`;
CREATE TABLE `p_horarios_programados`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_contrato_id` int(11) NOT NULL,
  `dia_id` int(11) NOT NULL,
  `horario_plantilla_id` int(11) NOT NULL,
  `hora_inicio` time(0) NOT NULL,
  `hora_fin` time(0) NOT NULL,
  `horario_amanecida` int(11) NOT NULL DEFAULT 0 COMMENT 'Este estado identificara que horarios pueden ser con hora de ingreso mayor a la hora de salida solo cuando este activo en 1.',
  `tolerancia` int(11) NULL DEFAULT 0,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_h_p_dia_id`(`dia_id`) USING BTREE,
  INDEX `fk_p_h_p_persona_contrato_id`(`persona_contrato_id`) USING BTREE,
  INDEX `fk_p_h_p_horario_plantilla_id`(`horario_plantilla_id`) USING BTREE,
  CONSTRAINT `p_horarios_programados_ibfk_1` FOREIGN KEY (`dia_id`) REFERENCES `a_dias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_horarios_programados_ibfk_2` FOREIGN KEY (`horario_plantilla_id`) REFERENCES `m_horarios_plantillas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_horarios_programados_ibfk_3` FOREIGN KEY (`persona_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_horarios_programados
-- ----------------------------
INSERT INTO `p_horarios_programados` VALUES (1, 2, 1, 1, '10:00:00', '18:00:00', 0, 5, 1, '2018-04-24 12:03:56', NULL, 1, NULL);

-- ----------------------------
-- Table structure for p_personas_contratos
-- ----------------------------
DROP TABLE IF EXISTS `p_personas_contratos`;
CREATE TABLE `p_personas_contratos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `sede_id` int(11) NOT NULL,
  `consorcio_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `regimen_id` int(11) NOT NULL,
  `estado_contrato` int(11) NOT NULL DEFAULT 1 COMMENT '1:Vigente | 2:Vacaciones | 3:Cesante ',
  `tipo_contrato` int(11) NOT NULL DEFAULT 2 COMMENT '1:Producción|2:Regular',
  `fecha_ini_contrato` date NULL DEFAULT NULL,
  `fecha_fin_contrato` date NULL DEFAULT NULL,
  `sueldo_mensual` decimal(10, 2) NULL DEFAULT NULL,
  `sueldo_produccion` decimal(10, 2) NULL DEFAULT NULL,
  `asignacion_familiar` int(11) NOT NULL DEFAULT 0,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_p_c_persona_id`(`persona_id`) USING BTREE,
  INDEX `fk_m_p_c_sede_id`(`sede_id`) USING BTREE,
  INDEX `fk_m_p_c_consorcio_id`(`consorcio_id`) USING BTREE,
  INDEX `fk_m_p_c_cargo_id`(`cargo_id`) USING BTREE,
  INDEX `fk_m_p_c_regimen_id`(`regimen_id`) USING BTREE,
  CONSTRAINT `p_personas_contratos_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `m_cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_ibfk_2` FOREIGN KEY (`consorcio_id`) REFERENCES `m_consorcios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_ibfk_3` FOREIGN KEY (`persona_id`) REFERENCES `m_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_ibfk_4` FOREIGN KEY (`regimen_id`) REFERENCES `m_regimenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_ibfk_5` FOREIGN KEY (`sede_id`) REFERENCES `m_sedes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_personas_contratos
-- ----------------------------
INSERT INTO `p_personas_contratos` VALUES (1, 1, 1, 1, 1, 1, 2, 1, '2018-04-24', '2018-04-27', 5000.00, 5000.00, 1, 1, '2018-04-22 21:12:51', '2018-04-24 11:29:20', 1, 1);
INSERT INTO `p_personas_contratos` VALUES (2, 7, 2, 1, 2, 1, 1, 2, '2018-04-26', '2018-11-22', 2000.00, 400.00, 0, 1, '2018-04-22 23:32:17', '2018-04-28 12:40:12', 1, 1);

-- ----------------------------
-- Table structure for p_personas_contratos_historicos
-- ----------------------------
DROP TABLE IF EXISTS `p_personas_contratos_historicos`;
CREATE TABLE `p_personas_contratos_historicos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `sede_id` int(11) NOT NULL,
  `consorcio_id` int(11) NOT NULL,
  `cargo_id` int(11) NOT NULL,
  `regimen_id` int(11) NOT NULL,
  `estado_contrato` int(11) NOT NULL DEFAULT 1 COMMENT '1:Vigente | 2:Vacaciones | 3:Cesante ',
  `tipo_contrato` int(11) NOT NULL DEFAULT 2 COMMENT '1:Producción|2:Regular',
  `fecha_ini_contrato` date NULL DEFAULT NULL,
  `fecha_fin_contrato` date NULL DEFAULT NULL,
  `sueldo_mensual` decimal(10, 2) NULL DEFAULT NULL,
  `sueldo_produccion` decimal(10, 2) NULL DEFAULT NULL,
  `asignacion_familiar` int(11) NOT NULL DEFAULT 0,
  `ultimo_registro` int(11) NOT NULL DEFAULT 1,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_m_p_c_h_persona_id`(`persona_id`) USING BTREE,
  INDEX `fk_m_p_c_h_sede_id`(`sede_id`) USING BTREE,
  INDEX `fk_m_p_c_h_consorcio_id`(`consorcio_id`) USING BTREE,
  INDEX `fk_m_p_c_h_cargo_id`(`cargo_id`) USING BTREE,
  INDEX `fk_m_p_c_h_egimen_id`(`regimen_id`) USING BTREE,
  CONSTRAINT `p_personas_contratos_historicos_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `m_cargos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_historicos_ibfk_2` FOREIGN KEY (`consorcio_id`) REFERENCES `m_consorcios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_historicos_ibfk_3` FOREIGN KEY (`regimen_id`) REFERENCES `m_regimenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_historicos_ibfk_4` FOREIGN KEY (`persona_id`) REFERENCES `m_personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_personas_contratos_historicos_ibfk_5` FOREIGN KEY (`sede_id`) REFERENCES `m_sedes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of p_personas_contratos_historicos
-- ----------------------------
INSERT INTO `p_personas_contratos_historicos` VALUES (1, 1, 1, 1, 1, 1, 1, 1, '2018-04-22', '2018-12-28', 5000.00, 5000.00, 1, 0, 1, '2018-04-22 21:12:51', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (2, 1, 1, 1, 1, 1, 1, 1, '2018-04-22', '2018-12-28', 5000.00, 5000.00, 1, 0, 1, '2018-04-22 21:13:59', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (3, 1, 1, 1, 1, 1, 1, 1, '2018-04-22', '2018-12-28', 5000.00, 5000.00, 1, 0, 1, '2018-04-22 21:14:03', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (4, 1, 1, 1, 1, 1, 1, 1, '2018-04-22', '2018-12-28', 5000.00, 5000.00, 1, 0, 1, '2018-04-22 21:14:57', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (5, 7, 1, 1, 2, 1, 1, 2, '2018-04-16', '2018-11-22', 2000.00, 400.00, 0, 0, 1, '2018-04-22 23:32:17', '2018-04-28 12:40:16', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (6, 7, 1, 1, 2, 1, 1, 2, '2018-04-16', '2018-11-22', 2000.00, 400.00, 0, 0, 1, '2018-04-22 23:32:22', '2018-04-28 12:40:16', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (7, 1, 1, 1, 1, 1, 1, 2, '2018-04-16', '2018-11-22', 5000.00, 5000.00, 0, 0, 1, '2018-04-23 14:11:18', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (8, 1, 1, 1, 1, 1, 1, 2, '2018-04-16', '2018-11-22', 5000.00, 5000.00, 0, 0, 1, '2018-04-23 14:11:20', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (9, 7, 1, 1, 2, 1, 2, 1, '2018-04-23', '2018-06-27', 2000.00, 400.00, 1, 0, 1, '2018-04-23 14:12:55', '2018-04-28 12:40:16', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (10, 7, 1, 1, 2, 1, 2, 1, '2018-04-23', '2018-06-27', 2000.00, 400.00, 1, 0, 1, '2018-04-23 14:13:07', '2018-04-28 12:40:16', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (11, 1, 1, 1, 1, 1, 2, 1, '2018-04-24', '2018-04-27', 5000.00, 5000.00, 1, 0, 1, '2018-04-24 11:29:20', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (12, 1, 1, 1, 1, 1, 2, 1, '2018-04-24', '2018-04-27', 5000.00, 5000.00, 1, 0, 1, '2018-04-24 11:29:52', '2018-04-24 11:30:32', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (13, 1, 1, 1, 1, 1, 2, 1, '2018-04-24', '2018-04-27', 5000.00, 5000.00, 1, 1, 1, '2018-04-24 11:30:32', '2018-04-24 11:30:32', 1, NULL);
INSERT INTO `p_personas_contratos_historicos` VALUES (14, 7, 2, 1, 2, 1, 1, 2, '2018-04-26', '2018-11-22', 2000.00, 400.00, 0, 0, 1, '2018-04-28 12:40:12', '2018-04-28 12:40:16', 1, 1);
INSERT INTO `p_personas_contratos_historicos` VALUES (15, 7, 2, 1, 2, 1, 1, 2, '2018-04-26', '2018-11-22', 2000.00, 400.00, 0, 1, 1, '2018-04-28 12:40:16', '2018-04-28 12:40:16', 1, NULL);

-- ----------------------------
-- Table structure for p_planillas_aux
-- ----------------------------
DROP TABLE IF EXISTS `p_planillas_aux`;
CREATE TABLE `p_planillas_aux`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docente_contrato_id` int(11) NOT NULL,
  `regimen_id` int(11) NOT NULL,
  `horario_programado_id` int(11) NOT NULL,
  `fecha_inicio` datetime(0) NULL DEFAULT NULL,
  `cussp` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `horas_extras` decimal(3, 2) NULL DEFAULT NULL,
  `horas_labor` decimal(3, 2) NULL DEFAULT NULL,
  `dia_laboral_id` int(11) NULL DEFAULT NULL,
  `descanso_vacacional` int(11) NULL DEFAULT NULL,
  `condi_tardanza_falta` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `condi_tardanza` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `falta` int(11) NULL DEFAULT NULL,
  `tarde_falta` decimal(3, 2) NULL DEFAULT NULL,
  `tardanza` decimal(3, 2) NULL DEFAULT NULL,
  `p_planillascol` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `sueldo_basico` decimal(8, 2) NULL DEFAULT NULL,
  `asigna_fami` varchar(2) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `vacaciones` decimal(5, 2) NULL DEFAULT NULL,
  `adelanto_desc` decimal(5, 2) NULL DEFAULT NULL,
  `total_pago` decimal(8, 2) NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_planillas_m_docente_contrato1`(`docente_contrato_id`) USING BTREE,
  INDEX `fk_p_planillas_m_regimen1`(`regimen_id`) USING BTREE,
  INDEX `fk_p_planillas_p_horarios_programados1`(`horario_programado_id`) USING BTREE,
  CONSTRAINT `p_planillas_aux_ibfk_1` FOREIGN KEY (`docente_contrato_id`) REFERENCES `p_personas_contratos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_planillas_aux_ibfk_2` FOREIGN KEY (`regimen_id`) REFERENCES `m_regimenes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `p_planillas_aux_ibfk_3` FOREIGN KEY (`horario_programado_id`) REFERENCES `p_horarios_programados` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for p_planillas_descuentos_aux
-- ----------------------------
DROP TABLE IF EXISTS `p_planillas_descuentos_aux`;
CREATE TABLE `p_planillas_descuentos_aux`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planillas_id` int(11) NOT NULL,
  `tardanzas` decimal(5, 2) NULL DEFAULT NULL,
  `inasistencias` decimal(5, 2) NULL DEFAULT NULL,
  `adelanto` decimal(5, 2) NULL DEFAULT NULL,
  `total_descuento` decimal(8, 2) NULL DEFAULT NULL,
  `at_pension_regimen` decimal(5, 2) NULL DEFAULT NULL,
  `at_spp_aporta_obli` decimal(5, 2) NULL DEFAULT NULL,
  `at_spp_porc_flujo` decimal(5, 2) NULL DEFAULT NULL,
  `at_spp_porc_mixto` decimal(5, 2) NULL DEFAULT NULL,
  `at_spp_prima_seguro` decimal(5, 2) NULL DEFAULT NULL,
  `at_renta_qta_cate` decimal(5, 2) NULL DEFAULT NULL,
  `at_renta_cta_cate` decimal(5, 2) NULL DEFAULT NULL,
  `at_total_aportes` decimal(8, 2) NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  `p_planilla_descuentoscol` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_planilla_descuentos_p_planillas1`(`planillas_id`) USING BTREE,
  CONSTRAINT `p_planillas_descuentos_aux_ibfk_1` FOREIGN KEY (`planillas_id`) REFERENCES `p_planillas_aux` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for p_planillas_ingresos_aux
-- ----------------------------
DROP TABLE IF EXISTS `p_planillas_ingresos_aux`;
CREATE TABLE `p_planillas_ingresos_aux`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planillas_id` int(11) NOT NULL,
  `sueldo_basico` decimal(5, 2) NULL DEFAULT NULL,
  `asignacion_fami` decimal(5, 2) NULL DEFAULT NULL,
  `por_hora_extra` decimal(3, 2) NULL DEFAULT NULL,
  `cal_hora_extra` decimal(5, 2) NULL DEFAULT NULL,
  `por_seg_hora_extra` decimal(3, 2) NULL DEFAULT NULL,
  `cal_seg_hora_extra` decimal(5, 2) NULL DEFAULT NULL,
  `indenmiza_hora_extra` decimal(3, 2) NULL DEFAULT NULL,
  `bonifica_hora_min` decimal(3, 2) NULL DEFAULT NULL,
  `movilidad` decimal(3, 2) NULL DEFAULT NULL,
  `no_movilidad` decimal(3, 2) NULL DEFAULT NULL,
  `capacitacion` decimal(5, 2) NULL DEFAULT NULL,
  `reintegro` decimal(5, 2) NULL DEFAULT NULL,
  `subsidio` decimal(5, 2) NULL DEFAULT NULL,
  `movilidad_asistencia` decimal(5, 2) NULL DEFAULT NULL,
  `otros` decimal(5, 2) NULL DEFAULT NULL,
  `vacaciones` decimal(5, 2) NULL DEFAULT NULL,
  `total_ingresos` decimal(8, 2) NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `fk_p_planilla_ingresos_p_planillas1`(`planillas_id`) USING BTREE,
  CONSTRAINT `p_planillas_ingresos_aux_ibfk_1` FOREIGN KEY (`planillas_id`) REFERENCES `p_planillas_aux` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for zaux_m_consorcio
-- ----------------------------
DROP TABLE IF EXISTS `zaux_m_consorcio`;
CREATE TABLE `zaux_m_consorcio`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `consorcio` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `consorcio_apocope` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `tipo_contrato` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `asigna_familia` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `boni_horas` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `horas_extras` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `renta_cuarta` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `renta_quinta` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `remuneracion` decimal(5, 2) NULL DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `persona_id_created_at` int(11) NOT NULL,
  `persona_id_updated_at` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
