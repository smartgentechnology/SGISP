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

 Date: 28/02/2019 13:11:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for lc_oem
-- ----------------------------
DROP TABLE IF EXISTS `lc_oem`;
CREATE TABLE `lc_oem`  (
  `oem_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `oem_name` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `oem_img` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `oem_products` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `oem_area` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `startdate` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `enddate` int(10) UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`oem_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 308 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lc_oem
-- ----------------------------
INSERT INTO `lc_oem` VALUES (1, '江苏江豪发电机组有限公司', 'data/OEM/20161219/q79hlkn836.jpg', '全部', '全部', 1477324800, 1514736000);
INSERT INTO `lc_oem` VALUES (2, '广东顺德奥南动力工程有限公司', 'data/OEM/20161219/nlc0y7m9uo.jpg', '全部', '全部', 1477324800, 1514736000);
INSERT INTO `lc_oem` VALUES (3, '成都市威明斯发电配套设备有限公司', 'data/OEM/20161219/mjyvi768rc.jpg', '全部', '全部', 1475856000, 1507478400);
INSERT INTO `lc_oem` VALUES (4, '成都闽东电机设备有限公司', 'data/OEM/20161219/o8ajt9xb6g.jpg', '全部', '全部', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (5, '上海瑞营机械制造有限公司', 'data/OEM/20161219/3owhgxf82p.jpg', '全部', '全部', 1473868800, 1536940800);
INSERT INTO `lc_oem` VALUES (6, '陕西黎明发电设备有限公司', 'data/OEM/20161219/4yespadbju.jpg', '全部', '全部', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (7, '江苏德丰机电设备有限公司', 'data/OEM/20161219/o6hu3xflmn.jpg', '全部', '全部', 1473177600, 1514736000);
INSERT INTO `lc_oem` VALUES (8, '威海迪赛尔电气工程有限公司', 'data/OEM/20161219/jbde6qri3h.jpg', '全部', '全部', 1472659200, 1504195200);
INSERT INTO `lc_oem` VALUES (9, '海南惠能动力设备有限公司', 'data/OEM/20161219/9p86lxetvf.jpg', '全部', '全部', 1472400000, 1503936000);
INSERT INTO `lc_oem` VALUES (10, '厦门彼奥动力科技有限公司', 'data/OEM/20161219/dvy0f3x82l.jpg', '全部', '全部', 1471968000, 1514736000);
INSERT INTO `lc_oem` VALUES (11, '广州威能机电有限公司', 'data/OEM/20161219/jt126z4o9a.jpg', '全部', '全部', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (12, '重庆龙源动力设备有限公司', 'data/OEM/20161219/j3fet0ku9y.jpg', '全部', '全部', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (13, '江西省博大动力设备有限公司', 'data/OEM/20161219/dirc4vtmah.jpg', '全部', '全部', 1464710400, 1514736000);
INSERT INTO `lc_oem` VALUES (14, '扬州顺风发电设备有限公司', 'data/OEM/20161219/s4mau8fblw.jpg', '全部', '全部', 1467561600, 1514736000);
INSERT INTO `lc_oem` VALUES (15, '广州市亚虎动力设备有限公司', 'data/OEM/20161219/kqnvub7y1t.jpg', '全部', '全部', 1467302400, 1498924800);
INSERT INTO `lc_oem` VALUES (16, '扬州市康成发电设备有限公司', 'data/OEM/20161219/djog2epinv.jpg', '全部', '全部', 1466697600, 1514736000);
INSERT INTO `lc_oem` VALUES (17, '南京旭照发电机组有限公司', 'data/OEM/20161219/ht2p3vcnb0.jpg', '全部', '全部', 1451577600, 1514649600);
INSERT INTO `lc_oem` VALUES (18, '四川众信通电子科技有限公司', 'data/OEM/20161219/o80gwhdeb4.jpg', '全部', '全部', 1451577600, 1514649600);
INSERT INTO `lc_oem` VALUES (19, '四川威尔霸动力设备有限公司', 'data/OEM/20161219/myjuk4ecpf.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (20, '四川大洋发电机动力科技有限公司', 'data/OEM/20161219/gx2lnm685i.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (21, '重庆新有为动力科技有限公司', 'data/OEM/20161219/z59ygjwdts.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (22, '温州百友机电有限公司', 'data/OEM/20161219/t7e9nhjy5g.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (23, '佛山市顺德区顺恒鑫柴油发动机有限公司', 'data/OEM/20161219/4jcy96fdaq.jpg', '全部', '全部', 1451577600, 1483286400);
INSERT INTO `lc_oem` VALUES (24, '河南乐维机电技术服务有限公司', 'data/OEM/20161219/wg35p91tzl.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (25, '乐维（上海）能源技术服务股份有限公司', 'data/OEM/20161219/60jkea7hlb.jpg', '全部', '全部', 1458489600, 1490025600);
INSERT INTO `lc_oem` VALUES (26, '潍坊佰斯特动力设备有限公司', 'data/OEM/20161219/mxav9b3p8h.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (27, '江苏海兴动力科技有限公司', 'data/OEM/20161219/o10xg5as6w.jpg', '全部', '全部', 1458576000, 1490112000);
INSERT INTO `lc_oem` VALUES (28, '重庆西康机电设备有限公司', 'data/OEM/20161219/3yz6dasihw.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (29, '泰州市凯华柴油发电机组有限公司', 'data/OEM/20161219/eqsrbof190.jpg', '全部', '全部', 1451923200, 1514736000);
INSERT INTO `lc_oem` VALUES (30, 'R G POWER', 'data/OEM/20161219/hfzr3im84v.jpg', '全部', '沙特阿拉伯王国', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (31, 'SUNGJIN ELECTRIC Co.,Ltd', 'data/OEM/20161219/r16utcx39y.jpg', '全部', '韩国', 1460390400, 1491926400);
INSERT INTO `lc_oem` VALUES (32, 'CONG TY TNHH THUONG MAI KIEN MINH', 'data/OEM/20161219/07ujgiz689.jpg', '全部', '越南', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (33, 'TECNICS GRUPOS ELECTROGENOS,S.L', 'data/OEM/20161219/743orfu1vm.jpg', '全部', '西班牙王国', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (34, 'WELLING ＆ CROSSLEY PTY LTD', 'data/OEM/20161219/ydukq9t42a.jpg', '全部', '澳大利亚', 1451577600, 1514736000);
INSERT INTO `lc_oem` VALUES (35, 'SINCRO AUSTRALIA PTY LTD', 'data/OEM/20161219/6rlmi7kd4u.jpg', '全部', '澳大利亚', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (36, '西安海兴电力科技有限公司', 'data/OEM/20161219/927fzudixk.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (37, '青岛海天星机电设备有限公司', 'data/OEM/20161219/gpscxar3qh.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (38, '温州百友机电有限公司', 'data/OEM/20161219/7ordmfknga.jpg', '全部', '全部', 1451577600, 1483200000);
INSERT INTO `lc_oem` VALUES (39, '重庆通本电力设备有限公司', 'data/OEM/20161219/1ks4ugqj57.jpg', '全部', '全部', 1452528000, 1483200000);
INSERT INTO `lc_oem` VALUES (40, '广东康动发电机有限公司', 'data/OEM/20161219/2fkhe7cnq3.jpg', '全部', '全部', 1448899200, 1480608000);
INSERT INTO `lc_oem` VALUES (41, '扬州市巨威机电设备有限公司', 'data/OEM/20161219/50cn1xkuys.jpg', '全部', '全部', 1451232000, 1482854400);
INSERT INTO `lc_oem` VALUES (42, '广东华锐动力科技有限公司', 'data/OEM/20161219/97lek58v6g.jpg', '全部', '全部', 1448899200, 1483200000);
INSERT INTO `lc_oem` VALUES (43, '福建一华电机有限公司', 'data/OEM/20161219/xpesikd3az.jpg', '全部', '全部', 1420041600, 1451577600);
INSERT INTO `lc_oem` VALUES (44, '湖北京汉动力科技有限公司', 'data/OEM/20161219/6x9bn30p2y.jpg', '全部', '全部', 1448899200, 1454256000);
INSERT INTO `lc_oem` VALUES (45, '福建金龙腾动力机械有限公司', 'data/OEM/20161219/oe56lndjh4.jpg', '全部', '全部', 1448899200, 1483200000);
INSERT INTO `lc_oem` VALUES (46, '扬州福康斯发电机有限公司', 'data/OEM/20161219/e25i8d0zpn.jpg', '全部', '全部', 1449417600, 1481040000);
INSERT INTO `lc_oem` VALUES (47, '江苏领权电机有限公司', 'data/OEM/20161219/mf2iors4hk.jpg', '全部', '全部', 1449158400, 1480780800);
INSERT INTO `lc_oem` VALUES (48, '昆明百内发电机有限公司', 'data/OEM/20161219/o2rug60jcn.jpg', '全部', '全部', 1447603200, 1479225600);
INSERT INTO `lc_oem` VALUES (49, '四川康鑫杰机械设备有限公司', 'data/OEM/20161219/eojfd2cqb0.jpg', '全部', '全部', 1446998400, 1483113600);
INSERT INTO `lc_oem` VALUES (50, '云南振邦机电设备有限公司', 'data/OEM/20161219/asimwn5lcg.jpg', '全部', '全部', 1446048000, 1477756800);
INSERT INTO `lc_oem` VALUES (51, '扬州市恒益机电自控设备有限公司', 'data/OEM/20161219/z8jygp721w.jpg', '全部', '全部', 1445184000, 1476806400);
INSERT INTO `lc_oem` VALUES (52, '陈修顺', 'data/OEM/20161219/f2kstx79ji.jpg', '全部', '全部', 1444233600, 1475856000);
INSERT INTO `lc_oem` VALUES (53, '扬州飞鸿电材有限公司', 'data/OEM/20161219/328bm15x0l.jpg', '全部', '全部', 1434038400, 1465747200);
INSERT INTO `lc_oem` VALUES (54, '上海康城发电设备有限公司', 'data/OEM/20161219/5wcvyudmoi.jpg', '全部', '全部', 1434556800, 1466265600);
INSERT INTO `lc_oem` VALUES (55, '福建金隆昌工业科技有限公司', 'data/OEM/20161219/tspvauex8i.jpg', '全部', '全部', 1438358400, 1469894400);
INSERT INTO `lc_oem` VALUES (56, '江苏方联电力设备有限公司', 'data/OEM/20161219/w5auvbixpr.jpg', '全部', '全部', 1436112000, 1467820800);
INSERT INTO `lc_oem` VALUES (57, '佛山斯坦福机电设备有限公司', 'data/OEM/20161219/dlc03u9kwb.jpg', '全部', '全部', 1436371200, 1468080000);
INSERT INTO `lc_oem` VALUES (58, '扬州市华宇动力设备有限公司', 'data/OEM/20161219/gmp5e219hu.jpg', '全部', '全部', 1436803200, 1468425600);
INSERT INTO `lc_oem` VALUES (59, '佛山市顺德区顺恒鑫柴油发动机有限公司', 'data/OEM/20161219/7sz0w516ie.jpg', '全部', '全部', 1420041600, 1451577600);
INSERT INTO `lc_oem` VALUES (60, '江西省博大动力设备有限公司', 'data/OEM/20161219/27j1xeszm4.jpg', '全部', '全部', 1436976000, 1468598400);
INSERT INTO `lc_oem` VALUES (61, '河南瑞国机械设备销售有限公司', 'data/OEM/20161219/8qx0vu3f5p.jpg', '全部', '全部', 1439308800, 1470931200);
INSERT INTO `lc_oem` VALUES (62, 'Asian Power Investment Pvt Ltd', 'data/OEM/20161219/wecdsj0876.jpg', '全部', '马尔代夫共和国', 1439913600, 1471536000);
INSERT INTO `lc_oem` VALUES (63, 'PT.Sumberindo Domasenergi Makmur', 'data/OEM/20161219/8tikl6fa21.jpg', '全部', '印度尼西亚国家雅加达地区', 1452182400, 1483200000);
INSERT INTO `lc_oem` VALUES (78, '扬州康明斯发电设备有限公司', 'data/OEM/20161220/3edxmcbsfz.jpg', '全部', '全部', 1482163200, 1513699200);
INSERT INTO `lc_oem` VALUES (65, 'PD.PSD', 'data/OEM/20161219/2vuzrslknf.jpg', '全部', '印度尼西亚国家棉兰地区', 1439913600, 1471536000);
INSERT INTO `lc_oem` VALUES (66, 'Inventure System ＆ Technology Pte Ltd', 'data/OEM/20161219/gzw9mr34bu.jpg', '全部', '新加坡', 1381420800, 1413043200);
INSERT INTO `lc_oem` VALUES (67, 'PT CONCORT PERSADA INDONESIA', 'data/OEM/20161219/i4vcuom0ay.jpg', '全部', '印度尼西亚', 1381420800, 1413043200);
INSERT INTO `lc_oem` VALUES (68, '桂林市山水柴油发电机制造有限公司', 'data/OEM/20161219/vnd01xubq4.jpg', '全部', '全部', 1477929600, 1509552000);
INSERT INTO `lc_oem` VALUES (69, '郑州曦航机电设备有限公司', 'data/OEM/20161219/nvbry079zg.jpg', '全部', '南美洲、越南、柬埔寨、泰国、缅甸、孟加拉、老挝', 1333209600, 1388505600);
INSERT INTO `lc_oem` VALUES (70, '福建泰德机械工业有限公司', 'data/OEM/20161219/b76upoij9v.jpg', '全部', '全部', 1272988800, 1304524800);
INSERT INTO `lc_oem` VALUES (71, 'MSM MEGA CONSORTIUM SDN.BHD.', 'data/OEM/20161219/widlk5zjra.jpg', '全部', '马来西亚', 1364745600, 1427904000);
INSERT INTO `lc_oem` VALUES (72, 'AUTO COMMS AND CONTROL', 'data/OEM/20161219/ke3xbfi5qv.jpg', '全部', '南美洲', 1356883200, 1388505600);
INSERT INTO `lc_oem` VALUES (73, '上海康城发电设备有限公司', 'data/OEM/20161219/0xoy13usna.jpg', '全部', '全部', 1434556800, 1466265600);
INSERT INTO `lc_oem` VALUES (74, '溯高美·索克曼电气（上海）有限公司', 'data/OEM/20161219/18yv0t2gke.jpg', '仅柴油发电机', '河南省、广东省、湖北省、山东省、重庆市、江西省', 1293811200, 1325347200);
INSERT INTO `lc_oem` VALUES (75, '安徽凯捷电力科技有限公司', 'data/OEM/20161219/io0sv16pyk.jpg', '柴油发电机机组控制系统', '安徽省内', 1347206400, 1378828800);
INSERT INTO `lc_oem` VALUES (76, '郑州恒高动力科技有限公司', 'data/OEM/20161219/rx8gly6chq.jpg', '全部', '全部', 1409155200, 1440777600);
INSERT INTO `lc_oem` VALUES (77, '扬州福康斯发电机有限公司', 'data/OEM/20161219/ythz84rg1b.jpg', '全部', '全部', 1480521600, 1512057600);
INSERT INTO `lc_oem` VALUES (79, '山西原发发电设备有限公司', 'data/OEM/20161228/qnxar52tul.jpg', '全部', '全部', 1476028800, 1514736000);
INSERT INTO `lc_oem` VALUES (80, '江苏鑫宏机电制造有限公司', 'data/OEM/20161229/tfu9ebd2kj.jpg', '全部', '全部', 1482940800, 1514736000);
INSERT INTO `lc_oem` VALUES (81, '山东赛马力发电设备有限公司', 'data/OEM/20170103/phnv8q07oy.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (82, '昆明百内发电机有限公司', 'data/OEM/20170103/3rsypudx7o.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (83, '江苏星光发电设备有限公司', 'data/OEM/20170103/pilv39yan1.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (84, '重庆通本电力设备有限公司', 'data/OEM/20170104/hfkzcauw90.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (85, '湖南乾鼎电气设备有限公司', 'data/OEM/20170105/4stc7ylx1r.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (86, '江苏兴华昌发电设备有限公司', 'data/OEM/20170111/gx0hmuad6n.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (87, '上海科泰电源股份有限公司', 'data/OEM/20170116/7ygq0c6iba.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (88, '西安长东船舶动力有限公司', 'data/OEM/20170117/6sdw0gthez.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (89, '潍坊七星动力设备有限公司', 'data/OEM/20170118/fqlbrmn2uy.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (90, '广州市亚虎东路设备有限公司', 'data/OEM/20170208/z2t4nq1sha.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (91, '重庆康电发电设备有限公司', 'data/OEM/20170208/3ni4bo8y92.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (92, '郑州雷鸣发电设备制造有限公司', 'data/OEM/20170214/6jin8hb2q3.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (93, '湖北艾克森动力科技有限公司', 'data/OEM/20170217/ymxvf7prcw.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (94, '重庆元朔机电有限公司', 'data/OEM/20170222/y8si34xz5o.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (95, '温州百友机电有限公司', 'data/OEM/20170222/ou82bvqr1c.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (96, 'PT. SUMBERINDO DOMASENERGI MAKMUR', 'data/OEM/20170224/wpbmze0j81.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (97, 'PD.P S D', 'data/OEM/20170227/thv0xy9rzf.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (98, 'R G POWER', 'data/OEM/20170228/ihwq9c5o1p.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (99, '四川科沃发电设备有限公司', 'data/OEM/20170302/mqig7xzuca.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (100, '成都卡珀动力科技有限公司', 'data/OEM/20170306/0s2vbo8eyz.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (101, '四川千钧机电设备有限公司', 'data/OEM/20170307/g386o5kb9n.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (102, '四川格瓦斯电力科技有限公司', 'data/OEM/20170309/wpdt3iqmgy.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (103, '河南乐维机电技术服务有限公司', 'data/OEM/20170309/m1t38hi6b4.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (104, '乐维（上海）能源技术服务股份有限公司', 'data/OEM/20170309/i273bqe08f.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (105, '四川博斯宇动力设备有限公司', 'data/OEM/20170310/vomqdl583i.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (107, '广东华锐动力科技有限公司', 'data/OEM/20170315/ytxf90czkr.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (108, '扬州市思马克机电设备有限公司', 'data/OEM/20170316/5boynlhqf4.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (109, '江苏明邦智能科技有限公司', 'data/OEM/20170320/ja5eyir0dv.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (110, '潍坊丰茂动力设备有限公司', 'data/OEM/20170328/gxr2afvw5s.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (111, '西安海兴电力科技有限公司', 'data/OEM/20170328/1lyqwjmgn6.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (112, '佛山市英利发电机有限公司', 'data/OEM/20170329/xwui18qnc4.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (113, '四川威尔霸动力设备有限公司', 'data/OEM/20170330/o74wxzsu9q.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (126, '福建艾斯博动力设备有限公司', 'data/OEM/2017-04-27/5901b503be6ab.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (115, '扬州市艾威特机电有限公司 ', 'data/OEM/20170407/fopzb65rd4.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (125, '佛山康明斯动力设备有限公司', 'data/OEM/2017-04-20/58f84a8182e3b.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (123, '重庆沃能机电设备有限公司', 'data/OEM/2017-04-13/58eedd0b50517.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (124, '重庆市坤力发电成套设备有限公司', 'data/OEM/2017-04-13/58eedd2782548.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (127, '江苏江豪发电机组有限公司', 'data/OEM/2017-05-02/590850c76144b.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (128, '雷天动力设备（苏州）有限公司', 'data/OEM/2017-05-05/590be66d9f447.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (131, '江苏优凯动力设备有限公司', 'data/OEM/2017-05-10/5912adcb9a062.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (130, '广西正柴发电机组制造有限公司', 'data/OEM/2017-05-09/591177c0d271c.jpg', '全部', '全部', 1483200000, 1546272000);
INSERT INTO `lc_oem` VALUES (132, '扬州威力动力设备有限公司', 'data/OEM/2017-05-12/5915214f70379.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (133, 'SMARTCLOUD LIMITED', 'data/OEM/2017-05-24/59253890d32ed.jpg', '全部', '新西兰', 1496246400, 1514736000);
INSERT INTO `lc_oem` VALUES (134, '南宁科动机电设备有限公司', 'data/OEM/2017-07-21/5971a61db34a7.png', '全部', '全', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (135, '重庆兵翔机电设备有限公司', 'data/OEM/2017-08-07/5987c5fdbaeb9.png', '全部', '全部', 1502035200, 1514736000);
INSERT INTO `lc_oem` VALUES (136, '广州市亚虎动力设备有限公司', 'data/OEM/2017-08-07/5987c66957bcf.png', '全部', '全部', 1501084800, 1532707200);
INSERT INTO `lc_oem` VALUES (137, '四川威尔霸动力设备有限公司', 'data/OEM/2017-08-07/5987c82fe8b25.png', '全部', '全部', 1502035200, 1514736000);
INSERT INTO `lc_oem` VALUES (138, '重庆中胜发电设备有限公司', 'data/OEM/2017-08-07/5987cb50a7d8c.png', '全部', '全部', 1502035200, 1514736000);
INSERT INTO `lc_oem` VALUES (139, '郑州金圣天达科技有限公司', 'data/OEM/2017-08-12/598e693103d09.png', '全部', '全部', 1502467200, 1514736000);
INSERT INTO `lc_oem` VALUES (140, '成都市德锋通讯设备有限公司', 'data/OEM/2017-08-21/599a709216e36.png', '控制器及云监控', '全部', 1503244800, 1514736000);
INSERT INTO `lc_oem` VALUES (141, '陕西年丰动力科技有限公司', 'data/OEM/2017-08-24/599e9af089544.png', '全部', '全部', 1503504000, 1514736000);
INSERT INTO `lc_oem` VALUES (142, '昆明德锋电源设备有限公司', 'data/OEM/2017-09-04/59acb65ea037a.png', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (143, '安徽冲科电力技术有限公司', 'data/OEM/2017-09-04/59acdcadd9701.png', '全部', '全部', 1496246400, 1527868800);
INSERT INTO `lc_oem` VALUES (144, '东莞市隆昌机电设备有限公司', 'data/OEM/2017-09-15/59bb9a0916e36.png', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (145, '厦门釜立特机电设备有限公司', 'data/OEM/2017-09-18/59bf7103af79e.png', '全部', '全部', 1498838400, 1530374400);
INSERT INTO `lc_oem` VALUES (146, '山东华力机电有限公司', 'data/OEM/2017-10-10/59dc8cc1e8b25.jpg', '全部', '全部', 1483200000, 1514736000);
INSERT INTO `lc_oem` VALUES (147, '河北华北柴油机有限责任公司', 'data/OEM/2017-10-31/59f830418583b.jpg', '全部', '全部', 1509379200, 1530374400);
INSERT INTO `lc_oem` VALUES (148, '扬州扬科机械电气有限公司', 'data/OEM/2017-11-07/5a01474f07a12.jpg', '全部', '全部', 1509984000, 1546272000);
INSERT INTO `lc_oem` VALUES (149, '英泰集团有限公司', 'data/OEM/2017-11-11/5a0664aae8b25.jpg', '全部', '全部', 1483200000, 1546272000);
INSERT INTO `lc_oem` VALUES (150, '东莞市能达机电设备有限公司', 'data/OEM/2017-11-20/5a12875ec65d4.jpg', '全部', '全部', 1498838400, 1530374400);
INSERT INTO `lc_oem` VALUES (151, '四川斯坦福电力设备有限公司', 'data/OEM/2017-11-20/5a12853503d09.jpg', '全部', '全部', 1511107200, 1546272000);
INSERT INTO `lc_oem` VALUES (152, '湖南山力玉柴新能源动力科技有限公司', 'data/OEM/2017-11-25/5a18c10266ff3.jpg', '全部', '全部', 1511539200, 1546272000);
INSERT INTO `lc_oem` VALUES (153, '福建永强力加动力设备有限公司', 'data/OEM/2017-11-28/5a1cdab853ec6.jpg', '全部', '全部', 1511798400, 1546272000);
INSERT INTO `lc_oem` VALUES (154, '南京旭照发电机组有限公司', 'data/OEM/2017-11-28/5a1cdae90b71b.jpg', '全部', '全部', 1511798400, 1546272000);
INSERT INTO `lc_oem` VALUES (155, '厦门固泰力动力科技有限公司', 'data/OEM/2017-12-04/5a24d8c5501bd.jpg', '全部', '全部', 1512316800, 1546272000);
INSERT INTO `lc_oem` VALUES (156, '山东华全动力股份有限公司', 'data/OEM/2017-12-06/5a27b07df0537.jpg', '全部', '全部', 1483200000, 1546272000);
INSERT INTO `lc_oem` VALUES (157, '昆明百内发电机有限公司', 'data/OEM/2017-12-14/5a31eb49d1cef.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (158, '好善有限公司', 'data/OEM/2018-10-31/5bd967eb6dfac.jpg', '全部', '台湾', 1514736000, 1609430400);
INSERT INTO `lc_oem` VALUES (159, '曄鑫電機有限公司', 'data/OEM/2017-12-29/5a45ff9b39387.jpg', '全部', '全部', 1514736000, 1609430400);
INSERT INTO `lc_oem` VALUES (160, '江苏恒华动力设备有限公司', 'data/OEM/2018-01-02/5a4afbab0f424.jpg', '全部', '全部', 1514822400, 1546272000);
INSERT INTO `lc_oem` VALUES (161, '扬州市康成发电设备有限公司', 'data/OEM/2018-01-02/5a4afbda1ab3f.jpg', '全部', '全部', 1514822400, 1546272000);
INSERT INTO `lc_oem` VALUES (162, '扬州市孚创控制设备厂', 'data/OEM/2018-01-02/5a4afc06bebc2.jpg', '全部', '全部', 1514822400, 1546272000);
INSERT INTO `lc_oem` VALUES (163, '江苏星光发电设备有限公司', 'data/OEM/2018-01-02/5a4afc2f6acfc.jpg', '全部', '全部', 1514822400, 1546272000);
INSERT INTO `lc_oem` VALUES (164, '深圳市捷豹动力科技股份有限公司', 'data/OEM/2018-01-02/5a4b4934baeb9.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (165, '广西星光电力工程有限公司', 'data/OEM/2018-01-02/5a4b49a381b32.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (166, '福建中驰动力科技有限公司', 'data/OEM/2018-01-03/5a4c32734c4b4.jpg', '全部', '全部', 1514908800, 1546272000);
INSERT INTO `lc_oem` VALUES (167, '成都市德锋通信设备有限公司', 'data/OEM/2018-01-03/5a4c85f17a120.jpg', '控制器及云监控', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (168, '成都闽东电机设备有限公司', 'data/OEM/2018-01-03/5a4c865794c5f.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (169, '江西省博大动力设备有限公司', 'data/OEM/2018-01-03/5a4c86d3aba95.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (170, '西安长东船舶动力有限公司', 'data/OEM/2018-01-03/5a4c874776417.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (171, '广东西电动力科技股份有限公司', 'data/OEM/2018-01-03/5a4c87e8487ab.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (172, '成都市威明斯发电配套设备有限公司', 'data/OEM/2018-01-03/5a4c88262dc6c.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (173, '四川格瓦斯电力科技有限公司', 'data/OEM/2018-01-03/5a4c890ea7d8c.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (174, '四川威尔霸动力设备有限公司', 'data/OEM/2018-01-03/5a4c89558d24d.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (175, '重庆康电发电设备有限公司', 'data/OEM/2018-01-03/5a4c8980e8b25.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (176, '重庆通本电力设备有限公司', 'data/OEM/2018-01-03/5a4c89b0f0537.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (177, '重庆元朔机电有限公司', 'data/OEM/2018-01-03/5a4c89d48d24d.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (178, '西安海兴电力科技有限公司', 'data/OEM/2018-01-03/5a4c89f290f56.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (179, '武汉劲康动力工程有限公司襄阳分公司', 'data/OEM/2018-01-04/5a4deaa290f56.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (180, '福建华泰电力实业有限公司', 'data/OEM/2018-01-08/5a532247aba95.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (181, '扬州市奥克发电设备有限公司', 'data/OEM/2018-01-09/5a5479854c4b4.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (182, '佛山市顺德区顺恒鑫柴油发电机有限公司', 'data/OEM/2018-01-10/5a559b681e848.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (183, '福州和辉自控机电设备有限公司', 'data/OEM/2018-01-15/5a5c5086dd40a.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (184, 'KIEN MINH TRADING CO., LTD (KMC)', 'data/OEM/2018-10-31/5bd96788892ee.jpg', '全部', '越南', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (185, '成都飞鸿鑫磊机电有限公司', 'data/OEM/2018-01-22/5a65854f90f56.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (186, '成都沃康动力科技有限公司', 'data/OEM/2018-01-22/5a65857f16e36.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (187, '广州盛康动力设备有限公司', 'data/OEM/2018-01-26/5a6acac898968.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (188, '四川中高机电设备有限公司', 'data/OEM/2018-01-31/5a710c4caba95.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (189, '重庆吉峰发电设备有限公司', 'data/OEM/2018-01-31/5a710c7a1e848.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (190, '湖南乾鼎电气设备有限公司', 'data/OEM/2018-02-01/5a7284dc2dc6c.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (191, '重庆中胜发电设备有限公司', 'data/OEM/2018-02-05/5a77e670a037a.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (192, '山东华全动力股份有限公司', 'data/OEM/2018-02-23/5a8fbe21c28cb.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (193, '泰州市凯华柴油发电机组有限公司', 'data/OEM/2018-02-26/5a9380aa90f56.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (194, '南昌市鼎鑫机电工程有限公司', 'data/OEM/2018-02-26/5a93bddf31975.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (195, '昆明德锋电源设备有限公司', 'data/OEM/2018-03-14/5aa8aee20b71b.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (196, '扬州福康斯发电机有限公司', 'data/OEM/2018-03-14/5aa8af1990f56.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (197, '广东顺恒鑫柴油发电机股份有限公司', 'data/OEM/2018-03-16/5aab776829f63.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (198, '扬州市思马克机电设备有限公司', 'data/OEM/2018-03-19/5aaf0d23dd40a.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (199, '江苏罡杨发电设备有限公司', 'data/OEM/2018-03-20/5ab081a73567e.jpg', '全部', '全部', 1420041600, 1546272000);
INSERT INTO `lc_oem` VALUES (200, '扬州市顺通发电设备有限公司', 'data/OEM/2018-03-20/5ab081dbe4e1c.jpg', '全部', '全部', 1483200000, 1546272000);
INSERT INTO `lc_oem` VALUES (201, '广州金动能源科技有限公司', 'data/OEM/2018-03-20/5ab082041ab3f.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (202, '佛山市上柴云动科技有限公司', 'data/OEM/2018-03-20/5ab0822466ff3.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (203, '江苏江豪发电机组有限公司', 'data/OEM/2018-03-21/5ab1d3ab29f63.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (204, '扬州市恒益机电自控设备有限公司', 'data/OEM/2018-03-28/5abb1cc2501bd.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (205, '江苏瑞昌哥尔德发电设备股份有限公司', 'data/OEM/2018-03-29/5abc78f94c4b4.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (206, '福建鑫恒鑫电机有限公司', 'data/OEM/2018-03-29/5abc79320b71b.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (207, '江苏鑫宏机电制造有限公司', 'data/OEM/2018-03-30/5abdcff8e8b25.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (208, '西安康发机电设备有限公司', 'data/OEM/2018-04-02/5ac1d3f5a037a.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (209, '陕西黎明发电设备有限公司', 'data/OEM/2018-04-16/5ad42f079c671.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (210, '陕西华友发电机有限公司', 'data/OEM/2018-04-16/5ad42f2f5b8d8.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (211, '河南乐维机电技术服务有限公司', 'data/OEM/2018-04-21/5ada943353ec6.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (212, '乐维（上海）能源技术服务股份有限公司', 'data/OEM/2018-04-21/5ada94fb31975.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (213, '福州威莱科电气有限公司', 'data/OEM/2018-05-21/5b028a9f1ab3f.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (214, '江苏兴华昌发电设备有限公司', 'data/OEM/2018-05-22/5b03d3f35ad66.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (215, '佛山斯坦福机电设备有限公司', 'data/OEM/2018-05-25/5b07d21046185.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (216, 'SMARTCLOUD LIMITED', 'data/OEM/2018-10-31/5bd96706d691a.jpg', '全部', '新西兰', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (217, '山东赛马力发电设备有限公司', 'data/OEM/2018-06-19/5b28c5f50faf2.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (218, '云南振邦机电设备有限公司', 'data/OEM/2018-06-27/5b32ff4e112a8.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (219, '佛山市民源发电机设备有限公司', 'data/OEM/2018-07-02/5b39cf6d3e418.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (220, '康达新能源设备股份有限公司', 'data/OEM/2018-07-04/5b3c59c4c5ea8.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (221, '广州翔锐机电设备有限公司', 'data/OEM/2018-07-11/5b45ccb140f9c.jpg', '全部', '全部', 1530374400, 1535731200);
INSERT INTO `lc_oem` VALUES (222, '云南晓普科技有限公司', 'data/OEM/2018-07-26/5b598e5a7190c.jpg', '全部', '全部', 1530374400, 1546272000);
INSERT INTO `lc_oem` VALUES (223, '福建博大巨达电机有限公司', 'data/OEM/2018-08-02/5b625d84de71c.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (224, '云南龙瑞经贸有限公司', 'data/OEM/2018-08-06/5b67c32c29234.jpg', '全部', '全部', 1533052800, 1564675200);
INSERT INTO `lc_oem` VALUES (225, '广州威能机电有限公司', 'data/OEM/2018-08-09/5b6b8b6f747a5.jpg', '全部', '全部', 1514736000, 1577808000);
INSERT INTO `lc_oem` VALUES (226, '长沙市宇晨电气有限公司', 'data/OEM/2018-08-09/5b6bd4bc114bb.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (227, '扬州市东华星动力科技有限公司', 'data/OEM/2018-08-13/5b71272364374.jpg', '全部', '全部', 1527782400, 1559404800);
INSERT INTO `lc_oem` VALUES (228, '扬州市大地设备安装有限公司', 'data/OEM/2018-08-13/5b712753c3955.jpg', '全部', '全部', 1527782400, 1559404800);
INSERT INTO `lc_oem` VALUES (229, '江西四维动力设备有限公司', 'data/OEM/2018-08-17/5b76303d98ab0.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (230, '广西玉发电气有限公司', 'data/OEM/2018-08-17/5b76305c3d1d8.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (231, '神洲万达（福建）电机有限公司', 'data/OEM/2018-08-18/5b77b6af31abd.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (232, '潍柴重机股份有限公司', 'data/OEM/2018-09-21/5ba4836962778.jpg', '全部', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (233, 'PT. Sumberindo Domasenergi Makmur', 'data/OEM/2018-10-31/5bd966c6be07a.jpg', '全部', '雅加达', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (234, '郑州雷鸣发电设备制造有限公司', 'data/OEM/2018-09-29/5baf0e7d8b316.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (235, '江苏礼德动力设备有限公司', 'data/OEM/2018-09-30/5bb044baf2c7f.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (236, '泉州市固泰机械设备有限公司 ', 'data/OEM/2018-10-11/5bbee4ff6562a.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (237, '江苏辛沃动力设备有限公司', 'data/OEM/2018-10-27/5bd3d7f3f07ab.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (238, 'PD.PSD', 'data/OEM/2018-10-31/5bd966a6ca842.jpg', '全部', '棉兰', 1514736000, 1577808000);
INSERT INTO `lc_oem` VALUES (239, '辛沃动力设备（上海）有限公司', 'data/OEM/2018-11-07/5be23732b0b1c.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (240, '扬州市孚创控制设备厂', 'data/OEM/2018-11-07/5be23a446df10.jpg', '全部', '全部', 1546185600, 1577808000);
INSERT INTO `lc_oem` VALUES (241, '长沙市万鼎机电设备有限公司', 'data/OEM/2018-11-07/5be24244bacbd.jpg', '全部', '全部', 1530374400, 1561996800);
INSERT INTO `lc_oem` VALUES (242, '芜湖开普机电设备有限公司', 'data/OEM/2018-11-07/5be242250c456.jpg', '全部', '全部', 1541001600, 1577808000);
INSERT INTO `lc_oem` VALUES (243, '安徽帕沃电气科技有限公司', 'data/OEM/2018-11-07/5be2800451db2.jpg', '全部', '全部', 1541001600, 1577808000);
INSERT INTO `lc_oem` VALUES (244, '广州海康机械设备有限公司', 'data/OEM/2018-11-09/5be51544bc86f.jpg', '全部', '全部', 1541692800, 1573315200);
INSERT INTO `lc_oem` VALUES (245, '深圳市希力普环保设备发展有限公司', 'data/OEM/2018-11-15/5becdbc97490d.jpg', '全部', '全部', 1541001600, 1577808000);
INSERT INTO `lc_oem` VALUES (246, '厦门釜立特机电设备有限公司', 'data/OEM/2018-11-20/5bf37ec05bd93.jpg', '全部', '全部', 1542643200, 1577808000);
INSERT INTO `lc_oem` VALUES (247, 'PT. Sumberindo Domasenergi Makmur', 'data/OEM/2018-11-21/5bf4b44bc06e5.jpg', '全部', '全部', 1546272000, 1609430400);
INSERT INTO `lc_oem` VALUES (248, '郑州斯玛特电气工程有限公司', 'data/OEM/2018-11-22/5bf63a8d1aad8.jpg', '全部', '全部', 1542816000, 1577808000);
INSERT INTO `lc_oem` VALUES (249, '成都康发动力设备有限公司', 'data/OEM/2018-11-26/5bfbabdb8cdbe.jpg', '全部', '全部', 1543161600, 1577808000);
INSERT INTO `lc_oem` VALUES (250, '广东顺德奥南动力工程有限公司', 'data/OEM/2018-12-03/5c04a140c1354.jpg', '全部', '全部', 1543766400, 1577808000);
INSERT INTO `lc_oem` VALUES (251, '温州百友机电有限公司', 'data/OEM/2018-12-03/5c04a16ad318d.jpg', '全部', '全部', 1543766400, 1577808000);
INSERT INTO `lc_oem` VALUES (252, '保定市恒发发电设备有限公司', 'data/OEM/2018-12-05/5c0729894780a.jpg', '全部', '全部', 1543939200, 1577808000);
INSERT INTO `lc_oem` VALUES (253, '盐城贝斯特动力机有限公司', 'data/OEM/2018-12-05/5c0787177a1ac.jpg', '全部', '全部', 1543939200, 1577808000);
INSERT INTO `lc_oem` VALUES (254, '安徽乐维动力设备服务有限公司', 'data/OEM/2018-12-06/5c08d0ccd3e96.jpg', '全部', '全部', 1544025600, 1577808000);
INSERT INTO `lc_oem` VALUES (255, '上海恩能捷机电工程有限公司', 'data/OEM/2018-12-06/5c08d0e1b4ddb.jpg', '全部', '全部', 1544025600, 1577808000);
INSERT INTO `lc_oem` VALUES (256, '合肥雷诺士电源设备有限公司', 'data/OEM/2018-12-06/5c08d0fd09fab.jpg', '全部', '全部', 1544025600, 1577808000);
INSERT INTO `lc_oem` VALUES (257, '泰州市凯华柴油发电机组有限公司', 'data/OEM/2019-01-08/5c33f4d8d74f6.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (258, '福州和辉自控机电设备有限公司', 'data/OEM/2018-12-26/5c23400552f5b.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (259, '福建中驰动力科技有限公司', 'data/OEM/2019-01-02/5c2c1a664ae2c.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (260, '河南康帅动力设备有限公司', 'data/OEM/2019-01-04/5c2ef06fcbce4.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (261, '云南振邦机电设备有限公司', 'data/OEM/2019-01-07/5c32b375699d9.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (262, '广州赛瓦特实业发展有限公司', 'data/OEM/2019-01-07/5c32b38e00a54.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (263, '成都市威明斯发电配套设备有限公司', 'data/OEM/2019-01-07/5c32e1784bffa.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (264, '广东顺恒鑫柴油发电机股份有限公司', 'data/OEM/2019-01-09/5c35a393d73b0.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (265, '重庆通本电力设备有限公司', 'data/OEM/2019-01-10/5c36d83c08001.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (266, '英泰集团有限公司', 'data/OEM/2019-01-10/5c36fb756f92f.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (267, '西安长东船舶动力有限公司', 'data/OEM/2019-01-11/5c37f7dd08b72.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (268, '江苏江豪发电机组有限公司', 'data/OEM/2019-01-15/5c3d8b35d8ee7.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (269, '广西康宝利实业股份有限公司', 'data/OEM/2019-01-15/5c3d9ebe70ba6.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (270, '江苏星光发电设备有限公司', 'data/OEM/2019-01-16/5c3ebb0bd590f.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (271, '陕西华友发电机有限公司', 'data/OEM/2019-01-17/5c4045633f980.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (272, '陕西黎明发电设备有限公司', 'data/OEM/2019-01-17/5c40463323c0e.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (273, '宁波高松电子有限公司', 'data/OEM/2019-01-22/5c46db5eac037.jpg', '供应商', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (274, '重庆志焜电子有限公司', 'data/OEM/2019-01-22/5c46dbb2ad83a.jpg', '供应商', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (275, '湖北天瑞电子股份有限公司', 'data/OEM/2019-01-22/5c46dbda14cc0.jpg', '供应商', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (276, '深圳市东成电子有限公司', 'data/OEM/2019-01-22/5c46dbfc16c3b.jpg', '供应商', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (277, '河南友邦电气有限公司', 'data/OEM/2019-01-22/5c46dc2569ca4.jpg', '供应商', '全部', 1514736000, 1546272000);
INSERT INTO `lc_oem` VALUES (278, '福建一华电机有限公司', 'data/OEM/2019-01-28/5c4eacf63b06c.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (279, '山东华全动力股份有限公司', 'data/OEM/2019-02-15/5c665fd63d557.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (280, '四川中高机电设备有限公司', 'data/OEM/2019-02-15/5c66686e65bb0.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (281, '四川格瓦斯电力科技有限公司', 'data/OEM/2019-02-15/5c6677e9eec81.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (282, '四川斯坦福电力设备有限公司', 'data/OEM/2019-02-15/5c667de0b7c5b.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (283, '四川千钧机电设备有限公司', 'data/OEM/2019-02-16/5c6760023a668.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (284, '成都闽东电机设备有限公司', 'data/OEM/2019-02-16/5c67615d8fe6b.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (285, '成都市德锋通信设备有限公司', 'data/OEM/2019-02-16/5c67634a0c78c.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (286, '重庆吉峰发电设备有限公司', 'data/OEM/2019-02-16/5c676afe13f53.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (287, '重庆元朔机电有限公司', 'data/OEM/2019-02-16/5c676c97a8dd3.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (288, '重庆康电发电设备有限公司', 'data/OEM/2019-02-16/5c676da74df70.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (289, '重庆龙源动力设备有限公司', 'data/OEM/2019-02-16/5c676e6b460a8.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (290, '西安康发机电设备有限公司', 'data/OEM/2019-02-16/5c6772eb6c090.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (291, '西安海兴电力科技有限公司', 'data/OEM/2019-02-16/5c6774fbac6bf.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (292, '武汉劲康动力工程有限公司襄阳分公司', 'data/OEM/2019-02-16/5c67760bde70e.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (293, '扬州市思马克机电有限公司', 'data/OEM/2019-02-20/5c6ce84ebc7b8.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (294, '扬州中顺发电设备有限公司', 'data/OEM/2019-02-20/5c6cea79b9347.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (295, '重庆中胜发电设备有限公司', 'data/OEM/2019-02-20/5c6cebd399077.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (296, '四川中高电气股份有限公司', 'data/OEM/2019-02-20/5c6cf85952b95.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (297, '福建科泰德电力设备有限公司', 'data/OEM/2019-02-22/5c6f5285d9def.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (298, '四川华派电力设备有限公司', 'data/OEM/2019-02-25/5c734fb1983d9.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (299, '佛山斯坦福机电设备有限公司', 'data/OEM/2019-02-25/5c73739a95618.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (303, '安徽冲科电力技术有限公司', 'data/OEM/2019-02-26/5c74ed11d819c.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (304, '东莞市捷源发电机科技有限公司', 'data/OEM/2019-02-26/5c74ed479922b.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (302, '广州市威霸机械设备有限公司', 'data/OEM/2019-02-25/5c73747b33716.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (305, '深圳市捷豹动力科技有限公司', 'data/OEM/2019-02-26/5c74eee3e0b2f.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (306, '江西省博大动力设备有限公司', 'data/OEM/2019-02-26/5c74efa1b507c.jpg', '全部', '全部', 1546272000, 1577808000);
INSERT INTO `lc_oem` VALUES (307, '湖南乾鼎电气设备有限公司', 'data/OEM/2019-02-26/5c74f046619ae.jpg', '全部', '全部', 1546272000, 1577808000);

SET FOREIGN_KEY_CHECKS = 1;
