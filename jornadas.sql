/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : jornadas

 Target Server Type    : MySQL
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 27/09/2020 04:39:11
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `categoria` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES (1, 'cat-01', 'Cocinera');
INSERT INTO `categorias` VALUES (2, 'cat-02', 'Peon');
INSERT INTO `categorias` VALUES (3, 'cat-03', 'Jefe de Servicio');

-- ----------------------------
-- Table structure for descansos
-- ----------------------------
DROP TABLE IF EXISTS `descansos`;
CREATE TABLE `descansos`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dias` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_empleado` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of descansos
-- ----------------------------
INSERT INTO `descansos` VALUES (1, '6', 1);
INSERT INTO `descansos` VALUES (2, '4', 3);

-- ----------------------------
-- Table structure for dias_laborados
-- ----------------------------
DROP TABLE IF EXISTS `dias_laborados`;
CREATE TABLE `dias_laborados`  (
  `id` int(11) NOT NULL,
  `fecha` date NULL DEFAULT NULL,
  `dia` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entrada` time(0) NULL DEFAULT NULL,
  `salida` time(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for empleados
-- ----------------------------
DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `rfc` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_categoria` int(11) NULL DEFAULT NULL,
  `activo` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of empleados
-- ----------------------------
INSERT INTO `empleados` VALUES (1, 'AJSY-123', 'MSSGSGA', 'Melissa', 'Larsson', 1, 'Si');
INSERT INTO `empleados` VALUES (3, 'CATAD7653', 'ZLAGSRSD', 'Zara maria', 'robles G', 2, 'Si');

-- ----------------------------
-- Table structure for jornadas_empleados
-- ----------------------------
DROP TABLE IF EXISTS `jornadas_empleados`;
CREATE TABLE `jornadas_empleados`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `entrada` time(0) NULL DEFAULT NULL,
  `salida` time(0) NULL DEFAULT NULL,
  `id_empleado` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jornadas_empleados
-- ----------------------------
INSERT INTO `jornadas_empleados` VALUES (1, 'Lunes', '08:20:14', '18:20:26', 1);
INSERT INTO `jornadas_empleados` VALUES (2, 'Miercoles', '08:48:00', '20:48:00', 1);
INSERT INTO `jornadas_empleados` VALUES (3, 'Lunes', '07:08:00', '17:05:00', 3);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `IdUser` int(5) NOT NULL AUTO_INCREMENT,
  `NombreUser` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Nombres` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Apellidos` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `Tipo` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` blob NULL COMMENT 'Quetzalcoatl para desincriptar',
  PRIMARY KEY (`IdUser`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'Zara', 'Zara', 'Larsson', 'admin', 'asdfg@gmail.com', 0xA2D5C2B1FA10BF56F38C0765F5FA5D11);
INSERT INTO `usuarios` VALUES (17, 'melissa', 'melissa', 'r', 'admin', 'mel@gmail.com', 0x1F2463D5367B9ABF63EC0DD1B7987F6D);

SET FOREIGN_KEY_CHECKS = 1;
