/*
 Navicat Premium Data Transfer

 Source Server         : 3
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 192.168.0.3:3306
 Source Schema         : sbangong

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 28/02/2019 13:24:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lc_dept
-- ----------------------------
DROP TABLE IF EXISTS `lc_dept`;
CREATE TABLE `lc_dept`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `pid` int(10) NOT NULL DEFAULT 0,
  `rank` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lc_dept
-- ----------------------------
INSERT INTO `lc_dept` VALUES (1, '郑州众智科技股份有限公司', 0, 1);
INSERT INTO `lc_dept` VALUES (2, '企管中心', 1, 9);
INSERT INTO `lc_dept` VALUES (3, '企划部', 2, 3);
INSERT INTO `lc_dept` VALUES (4, '行政部', 2, 4);
INSERT INTO `lc_dept` VALUES (5, '人事部', 2, 5);
INSERT INTO `lc_dept` VALUES (7, '生产中心', 1, 6);
INSERT INTO `lc_dept` VALUES (8, '质量中心', 1, 7);
INSERT INTO `lc_dept` VALUES (9, '电子车间', 7, 0);
INSERT INTO `lc_dept` VALUES (10, '电控车间', 7, 0);
INSERT INTO `lc_dept` VALUES (11, '计划物控', 7, 0);
INSERT INTO `lc_dept` VALUES (12, '采购中心', 1, 5);
INSERT INTO `lc_dept` VALUES (13, '设备工艺', 7, 0);
INSERT INTO `lc_dept` VALUES (14, '研发中心', 1, 3);
INSERT INTO `lc_dept` VALUES (15, '市场营销中心', 1, 2);
INSERT INTO `lc_dept` VALUES (16, '财务中心', 1, 8);
INSERT INTO `lc_dept` VALUES (17, '总经办', 1, 1);
INSERT INTO `lc_dept` VALUES (18, '企管办', 2, 0);
INSERT INTO `lc_dept` VALUES (19, '生产办', 7, 0);
INSERT INTO `lc_dept` VALUES (20, '质量办', 8, 0);
INSERT INTO `lc_dept` VALUES (21, '技术中心', 1, 4);
INSERT INTO `lc_dept` VALUES (22, '市场部', 15, 0);
INSERT INTO `lc_dept` VALUES (23, '营销部', 15, 0);
INSERT INTO `lc_dept` VALUES (24, '技术服务部', 15, 0);
INSERT INTO `lc_dept` VALUES (25, '总师办', 14, 0);
INSERT INTO `lc_dept` VALUES (26, '设备研发部', 14, 0);
INSERT INTO `lc_dept` VALUES (27, '研发一部', 14, 0);
INSERT INTO `lc_dept` VALUES (28, '研发三部', 14, 0);
INSERT INTO `lc_dept` VALUES (29, '质量部', 8, 0);

SET FOREIGN_KEY_CHECKS = 1;
