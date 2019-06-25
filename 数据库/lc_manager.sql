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

 Date: 28/02/2019 13:24:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lc_manager
-- ----------------------------
DROP TABLE IF EXISTS `lc_manager`;
CREATE TABLE `lc_manager`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `manager_name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `manager_passwd` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `manager_auth` tinyint(1) NOT NULL DEFAULT 0,
  `dept_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 138 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lc_manager
-- ----------------------------
INSERT INTO `lc_manager` VALUES (1, 'smartgen', '670b14728ad9902aecba32e22fa4f6bd', 0, 1);
INSERT INTO `lc_manager` VALUES (17, '罗彤', '670b14728ad9902aecba32e22fa4f6bd', 0, 20);
INSERT INTO `lc_manager` VALUES (5, '郭爽', '670b14728ad9902aecba32e22fa4f6bd', 1, 3);
INSERT INTO `lc_manager` VALUES (18, '王海川', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (6, '赵会勤', '4de35585e43001e7436de75dae44b67f', 1, 2);
INSERT INTO `lc_manager` VALUES (7, '刘超', '8cbe54ab6abe5e09b30b8d346e76ae20', 1, 3);
INSERT INTO `lc_manager` VALUES (79, '俆铁山', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);
INSERT INTO `lc_manager` VALUES (10, '吕茵', '670b14728ad9902aecba32e22fa4f6bd', 1, 4);
INSERT INTO `lc_manager` VALUES (11, '周玉静', '670b14728ad9902aecba32e22fa4f6bd', 1, 5);
INSERT INTO `lc_manager` VALUES (19, '易娜', 'e7e86ff4bcb3ecbc8872a4a15f24ae09', 0, 13);
INSERT INTO `lc_manager` VALUES (20, '王珊', 'd6b95d8877c4466cae7d483cb33f5ade', 0, 9);
INSERT INTO `lc_manager` VALUES (21, '郐晓梅', '670b14728ad9902aecba32e22fa4f6bd', 0, 10);
INSERT INTO `lc_manager` VALUES (22, '翟明', '670b14728ad9902aecba32e22fa4f6bd', 0, 11);
INSERT INTO `lc_manager` VALUES (23, '王洪杰', '670b14728ad9902aecba32e22fa4f6bd', 0, 12);
INSERT INTO `lc_manager` VALUES (24, '刘蕊', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (25, '道瑞娟', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (26, '姚关保', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (27, '宋耀军', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (28, '苏晓贞', '670b14728ad9902aecba32e22fa4f6bd', 0, 16);
INSERT INTO `lc_manager` VALUES (29, '杨新艳', '670b14728ad9902aecba32e22fa4f6bd', 0, 16);
INSERT INTO `lc_manager` VALUES (30, '崔文峰', '670b14728ad9902aecba32e22fa4f6bd', 0, 17);
INSERT INTO `lc_manager` VALUES (31, '王磊', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (32, '王向前', '670b14728ad9902aecba32e22fa4f6bd', 0, 28);
INSERT INTO `lc_manager` VALUES (33, '徐红宗', '670b14728ad9902aecba32e22fa4f6bd', 0, 27);
INSERT INTO `lc_manager` VALUES (34, '吴少飞', '670b14728ad9902aecba32e22fa4f6bd', 0, 27);
INSERT INTO `lc_manager` VALUES (35, '马雷', 'a43acf8e6bec9ac03efae8fbf8c8c44c', 0, 28);
INSERT INTO `lc_manager` VALUES (36, '杨新征', '670b14728ad9902aecba32e22fa4f6bd', 0, 17);
INSERT INTO `lc_manager` VALUES (37, '邓彦峰', '670b14728ad9902aecba32e22fa4f6bd', 0, 17);
INSERT INTO `lc_manager` VALUES (38, '艾可可', '670b14728ad9902aecba32e22fa4f6bd', 0, 20);
INSERT INTO `lc_manager` VALUES (39, '王乐', '670b14728ad9902aecba32e22fa4f6bd', 0, 8);
INSERT INTO `lc_manager` VALUES (40, '杜红利', '670b14728ad9902aecba32e22fa4f6bd', 0, 8);
INSERT INTO `lc_manager` VALUES (41, '普兰红', '670b14728ad9902aecba32e22fa4f6bd', 0, 8);
INSERT INTO `lc_manager` VALUES (42, '张鹏', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (135, '周伟', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (44, '朱利娟', 'e10adc3949ba59abbe56e057f20f883e', 0, 11);
INSERT INTO `lc_manager` VALUES (45, '赵远霞', '670b14728ad9902aecba32e22fa4f6bd', 0, 11);
INSERT INTO `lc_manager` VALUES (46, '冯国敏', '670b14728ad9902aecba32e22fa4f6bd', 0, 11);
INSERT INTO `lc_manager` VALUES (47, '徐铁山', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);
INSERT INTO `lc_manager` VALUES (49, '马玉成', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (128, '曹梦娟', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (51, '甄素平', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (74, '陈豪爽', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (53, '李闪闪', 'acd639fcd26c41b9a5e8bb392dca869c', 0, 23);
INSERT INTO `lc_manager` VALUES (54, '苏帅强', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (55, '陈燕超', '670b14728ad9902aecba32e22fa4f6bd', 0, 12);
INSERT INTO `lc_manager` VALUES (56, '胡雪梅', '670b14728ad9902aecba32e22fa4f6bd', 0, 12);
INSERT INTO `lc_manager` VALUES (57, '张学静', '670b14728ad9902aecba32e22fa4f6bd', 0, 12);
INSERT INTO `lc_manager` VALUES (127, '郭亚辉', '4f9a2140a271d3f3830768c6a01f1023', 0, 7);
INSERT INTO `lc_manager` VALUES (59, '程元端', '670b14728ad9902aecba32e22fa4f6bd', 0, 24);
INSERT INTO `lc_manager` VALUES (60, '郭政平', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (61, '赵兴华', 'cba0905465b19ec8c088e6daf5467d00', 0, 26);
INSERT INTO `lc_manager` VALUES (134, '高松伟', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (63, '吕艺璇', '670b14728ad9902aecba32e22fa4f6bd', 0, 16);
INSERT INTO `lc_manager` VALUES (64, '皇甫亚丽', '670b14728ad9902aecba32e22fa4f6bd', 0, 16);
INSERT INTO `lc_manager` VALUES (65, '李鹏', '670b14728ad9902aecba32e22fa4f6bd', 0, 8);
INSERT INTO `lc_manager` VALUES (66, '张建平', '670b14728ad9902aecba32e22fa4f6bd', 0, 3);
INSERT INTO `lc_manager` VALUES (129, '王永建', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (68, '徐金星', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);
INSERT INTO `lc_manager` VALUES (80, '电子车间维修', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (70, '康亚萍', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (71, '朱军甫', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (72, '卞艳玲', '670b14728ad9902aecba32e22fa4f6bd', 0, 9);
INSERT INTO `lc_manager` VALUES (73, '庞帅', 'fcea920f7412b5da7be0cf42b8c93759', 0, 13);
INSERT INTO `lc_manager` VALUES (75, '邓艳峰', '670b14728ad9902aecba32e22fa4f6bd', 0, 17);
INSERT INTO `lc_manager` VALUES (76, '常亚雨', '670b14728ad9902aecba32e22fa4f6bd', 0, 17);
INSERT INTO `lc_manager` VALUES (77, '赵鑫', '670b14728ad9902aecba32e22fa4f6bd', 0, 16);
INSERT INTO `lc_manager` VALUES (78, '张冬蕾', '670b14728ad9902aecba32e22fa4f6bd', 0, 5);
INSERT INTO `lc_manager` VALUES (81, '崔慧娟', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (82, '张翠翠', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (83, '张雯', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (84, '韩柯', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (137, '李英杰', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (86, '徐倩', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (87, '恽青', '670b14728ad9902aecba32e22fa4f6bd', 0, 23);
INSERT INTO `lc_manager` VALUES (136, '冯向远', '670b14728ad9902aecba32e22fa4f6bd', 0, 13);
INSERT INTO `lc_manager` VALUES (89, '周志田', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (90, '张春洋', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (125, '周昆仑', '670b14728ad9902aecba32e22fa4f6bd', 0, 10);
INSERT INTO `lc_manager` VALUES (133, '张永飞', '670b14728ad9902aecba32e22fa4f6bd', 0, 22);
INSERT INTO `lc_manager` VALUES (126, '李治良', '670b14728ad9902aecba32e22fa4f6bd', 0, 11);
INSERT INTO `lc_manager` VALUES (94, '高昌盛', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (95, '于光枭', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (96, '李勇', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (97, '张倩倩', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (98, '王相结', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (99, '马清春', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (100, '李贺堂', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (101, '尚志兴', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (102, '王本泉', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (103, '陈亚军', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (104, '水清华', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (105, '王辉', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (106, '张双洋', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (107, '张威', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (108, '郭兵', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (109, '黄晓乐', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (110, '李朝晖', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (111, '刘霞丽', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (112, '毕小亮', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (113, '司建政', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (114, '臧合生', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (115, '王艺朋', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (116, '董俊丽', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (117, '李桂东', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (118, '朱伟燕', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (119, '陈孝宗', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (120, '姜涛', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (121, '苏孟佳', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (122, '邓明洋', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (123, '王会博', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (124, '王付松', '670b14728ad9902aecba32e22fa4f6bd', 0, 14);
INSERT INTO `lc_manager` VALUES (130, '杜占军', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);
INSERT INTO `lc_manager` VALUES (131, '翟雪娟', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);
INSERT INTO `lc_manager` VALUES (132, '杨凯', '670b14728ad9902aecba32e22fa4f6bd', 0, 21);

SET FOREIGN_KEY_CHECKS = 1;
