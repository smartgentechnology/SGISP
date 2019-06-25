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

 Date: 28/02/2019 15:35:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lc_dingzhikehu
-- ----------------------------
DROP TABLE IF EXISTS `lc_dingzhikehu`;
CREATE TABLE `lc_dingzhikehu`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kehubianma` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `cunhuobianma` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `xinghao` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `ruanjianbanben` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lc_dingzhikehu
-- ----------------------------
INSERT INTO `lc_dingzhikehu` VALUES (1, '080398', '02.02.01.29.024', 'HGM4020CAN', '2.1');
INSERT INTO `lc_dingzhikehu` VALUES (2, '090756', '02.02.01.10.057', 'HGM1770', '2.9');
INSERT INTO `lc_dingzhikehu` VALUES (12, '130201', '02.02.03.05.065', 'MGC100', '1.5');
INSERT INTO `lc_dingzhikehu` VALUES (14, '040010', '02.02.01.27.069', 'HGM9310CAN', '3.9');
INSERT INTO `lc_dingzhikehu` VALUES (3, '250552', '02.02.01.28.043', 'HGM6110N', '2.2');
INSERT INTO `lc_dingzhikehu` VALUES (4, '080325', '02.02.01.06.057', 'HGM7210', '6.0');
INSERT INTO `lc_dingzhikehu` VALUES (10, '250490', '02.02.01.16.111', 'HGM410N', '2.0');
INSERT INTO `lc_dingzhikehu` VALUES (5, '080325', '02.02.01.06.058', 'HGM7220', '6.0');
INSERT INTO `lc_dingzhikehu` VALUES (13, '250490', '02.02.01.16.112', 'HGM420N', '2.0');
INSERT INTO `lc_dingzhikehu` VALUES (15, '040010', '02.02.01.27.068', 'HGM9320CAN', '3.9');
INSERT INTO `lc_dingzhikehu` VALUES (16, '040010', '02.02.01.27.066', 'HGM9310MPU', '3.9');
INSERT INTO `lc_dingzhikehu` VALUES (17, '040010', '02.02.01.27.067', 'HGM9320MPU', '3.9');
INSERT INTO `lc_dingzhikehu` VALUES (18, '250490', '02.02.01.28.043', 'HGM6110N', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (19, '250490', '02.02.01.28.044', 'HGM6120N', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (20, '250490', '02.02.01.28.045', 'HGM6120NC', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (21, '250490', '02.02.01.28.046', 'HGM6120CAN', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (22, '250490', '02.02.01.28.047', 'HGM6110CAN', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (23, '250490', '02.02.01.28.048', 'HGM6110NC', '2.3');
INSERT INTO `lc_dingzhikehu` VALUES (24, '090565', '02.02.01.06.060', 'HGM7210CAN', '6.1');
INSERT INTO `lc_dingzhikehu` VALUES (25, '270052', '02.02.01.29.024', 'HGM4020CAN', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (26, '270052', '02.02.01.29.025', 'HGM4010CAN', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (27, '270052', '02.02.01.29.026', 'HGM4020NC', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (28, '270052', '02.02.01.29.027', 'HGM4010NC', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (29, '270052', '02.02.01.29.028', 'HGM4020N', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (30, '270052', '02.02.01.29.029', 'HGM4010N', '2.5');
INSERT INTO `lc_dingzhikehu` VALUES (31, '050191', '02.02.01.30.004', 'HGM7110N', '1.9');
INSERT INTO `lc_dingzhikehu` VALUES (32, '050191', '02.02.01.30.005', 'HGM7120N', '1.9');
INSERT INTO `lc_dingzhikehu` VALUES (33, '080408', '02.02.01.19.055', 'HGM9510', '4.2');
INSERT INTO `lc_dingzhikehu` VALUES (34, '240006', '02.02.01.29.025', 'HGM4010CAN', '2.8');
INSERT INTO `lc_dingzhikehu` VALUES (35, '010027', '02.02.01.07.136', 'HGM8151', '1.8');
INSERT INTO `lc_dingzhikehu` VALUES (36, '080148', '02.02.01.14.054', 'HGM7110DC', '2.0');
INSERT INTO `lc_dingzhikehu` VALUES (37, '070409', '02.02.01.27.110', 'WHC9320CAN', '4.1');
INSERT INTO `lc_dingzhikehu` VALUES (38, '130360', '02.02.03.05.073', 'MGC120', '1.4');
INSERT INTO `lc_dingzhikehu` VALUES (39, '130063', '02.02.03.05.073', 'MGC120', '1.4');

SET FOREIGN_KEY_CHECKS = 1;
