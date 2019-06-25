-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2018 年 11 月 13 日 10:18
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `sbangong`
--
CREATE DATABASE `sbangong` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sbangong`;

-- --------------------------------------------------------

--
-- 权限组 `lc_auth_group`
--

CREATE TABLE IF NOT EXISTS `lc_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- 权限用户对应表 `lc_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `lc_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 权限 `lc_auth_rule`
--

CREATE TABLE IF NOT EXISTS `lc_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='规则表' AUTO_INCREMENT=73 ;

-- --------------------------------------------------------



--
-- 定制客户(不用处理) `lc_dingzhikehu`
--

CREATE TABLE IF NOT EXISTS `lc_dingzhikehu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kehubianma` varchar(100) NOT NULL DEFAULT '',
  `cunhuobianma` varchar(100) NOT NULL DEFAULT '',
  `xinghao` varchar(100) NOT NULL DEFAULT '',
  `ruanjianbanben` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- 管理员（无用） `lc_manager`
--

CREATE TABLE IF NOT EXISTS `lc_manager` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `manager_name` varchar(16) NOT NULL DEFAULT '',
  `manager_passwd` char(32) NOT NULL DEFAULT '',
  `manager_auth` tinyint(1) NOT NULL DEFAULT '0',
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

-- --------------------------------------------------------

--
-- 导航 `lc_nav`
--

CREATE TABLE IF NOT EXISTS `lc_nav` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单表',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '所属菜单',
  `name` varchar(15) DEFAULT '' COMMENT '菜单名称',
  `mca` varchar(255) DEFAULT '' COMMENT '模块、控制器、方法',
  `ico` varchar(20) DEFAULT '' COMMENT 'font-awesome图标',
  `color` varchar(20) DEFAULT '',
  `order_number` int(11) unsigned DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- OEM `lc_oem`
--

CREATE TABLE IF NOT EXISTS `lc_oem` (
  `oem_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oem_name` varchar(40) NOT NULL DEFAULT '',
  `oem_img` varchar(100) NOT NULL DEFAULT '',
  `oem_products` varchar(100) NOT NULL DEFAULT '',
  `oem_area` varchar(100) NOT NULL DEFAULT '',
  `startdate` int(10) unsigned NOT NULL DEFAULT '0',
  `enddate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`oem_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=245 ;

-- --------------------------------------------------------

--
-- 生产计划（无用） `lc_pprocedure`
--

CREATE TABLE IF NOT EXISTS `lc_pprocedure` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL DEFAULT '',
  `batch` varchar(100) NOT NULL DEFAULT '',
  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `hours` float(5,1) unsigned NOT NULL DEFAULT '0.0',
  `people` int(10) unsigned NOT NULL DEFAULT '1',
  `sn` varchar(100) NOT NULL DEFAULT '',
  `manager_id` int(10) NOT NULL DEFAULT '0',
  `type` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` int(4) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17027 ;

-- --------------------------------------------------------

--
-- 生产计划（无用） `lc_pschedule`
--

CREATE TABLE IF NOT EXISTS `lc_pschedule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL DEFAULT '',
  `batch` varchar(100) NOT NULL DEFAULT '',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(100) NOT NULL DEFAULT '',
  `ontime` int(10) unsigned NOT NULL DEFAULT '0',
  `downtime` int(10) unsigned NOT NULL DEFAULT '0',
  `onnumber` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2697 ;

-- --------------------------------------------------------

--
-- 下发文件（无用） `lc_sendfile`
--

CREATE TABLE IF NOT EXISTS `lc_sendfile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL DEFAULT '',
  `filename` varchar(100) NOT NULL DEFAULT '',
  `filepath` varchar(100) NOT NULL DEFAULT '',
  `mdate` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- 翻译库 `lc_tlibrary`
--

CREATE TABLE IF NOT EXISTS `lc_tlibrary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cn` text NOT NULL,
  `en` text NOT NULL,
  `abben` text NOT NULL,
  `sp` text NOT NULL,
  `jp` text NOT NULL,
  `ru` text NOT NULL,
  `remarks` varchar(100) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `mdate` int(10) unsigned NOT NULL DEFAULT '0',
  `flag` int(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1419 ;

-- --------------------------------------------------------

--
-- 培训计划 `lc_train`
--

CREATE TABLE IF NOT EXISTS `lc_train` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quarter` int(10) unsigned NOT NULL DEFAULT '0',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `ontime` int(10) unsigned NOT NULL DEFAULT '0',
  `downtime` int(10) unsigned DEFAULT NULL,
  `train_content` text NOT NULL,
  `train_people` varchar(100) NOT NULL DEFAULT '',
  `lecturer` varchar(100) NOT NULL DEFAULT '',
  `remark` varchar(100) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `checkcontent` varchar(100) NOT NULL DEFAULT '',
  `flag` int(4) unsigned NOT NULL DEFAULT '0',
  'add_time' int(10) unsigned not null default '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=248 ;

-- --------------------------------------------------------

--
-- 工作计划 `lc_workplan`
--

CREATE TABLE IF NOT EXISTS `lc_workplan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dept_id` int(10) unsigned NOT NULL DEFAULT '0',
  `month` int(10) unsigned NOT NULL DEFAULT '0',
  `number` int(10) unsigned NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `date` varchar(40) NOT NULL DEFAULT '',
  `manager_id` int(10) unsigned NOT NULL DEFAULT '0',
  `state` int(10) unsigned NOT NULL DEFAULT '0',
  `reason` varchar(100) NOT NULL DEFAULT '',
  `remarks` varchar(100) NOT NULL DEFAULT '',
  `resource` varchar(100) NOT NULL DEFAULT '',
  `manager_add` int(10) unsigned NOT NULL DEFAULT '0',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 维修台帐 `lc_weixiu`
--

CREATE TABLE IF NOT EXISTS `lc_fanxiu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tabflag` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否制单',
  `fanxiunumber` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '返修单号',
  `receive_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '接收日期',
  `customer` varchar(100) NOT NULL DEFAULT '' COMMENT '客户名称',
  `person` varchar(100) NOT NULL DEFAULT '' COMMENT '业务员',
  `product` varchar(40) NOT NULL DEFAULT '' COMMENT '产品编号',
  `qty` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `barcode` varchar(40) NOT NULL DEFAULT '' COMMENT '条码',
  `cishu` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '维修次数',
  `pdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '产品生产日期',
  `prdate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生产返修间隔日期',
  `result` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理结果',
  `remark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `add_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '登记人',
  `add_date` int(10) NOT NULL DEFAULT '0' COMMENT '登记日期',
  `hv` varchar(20) NOT NULL DEFAULT '' COMMENT '硬件版本',
  `sv` varchar(20) NOT NULL DEFAULT '' COMMENT '软件版本',
  `qz` varchar(200) NOT NULL DEFAULT '' COMMENT '修前正面照片',
  `qb` varchar(200) NOT NULL DEFAULT '' COMMENT '修前背面照片',
  `fault` text NOT NULL DEFAULT '' COMMENT '故障现象',
  `maint` text NOT NULL DEFAULT '' COMMENT '维修过程',
  `hz` varchar(200) NOT NULL DEFAULT '' COMMENT '修后正面照片',
  `hb` varchar(200) NOT NULL DEFAULT '' COMMENT '修后背面照片',
  `hsv` varchar(20) NOT NULL DEFAULT '' COMMENT '修后软件版本',
  `maint_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '维修人',
  `maint_date` int(10) NOT NULL DEFAULT '0' COMMENT '维修日期',
  `bad` int(4) NOT NULL DEFAULT '0' COMMENT '不良类型',
  `bad_cause` int(4) NOT NULL DEFAULT '0' COMMENT '原因分析',
  `improve` varchar(200) NOT NULL DEFAULT '' COMMENT '改进方案',
  `cause_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '分析人',
  `cause_date` int(10) NOT NULL DEFAULT '0' COMMENT '分析日期',
  `gongneng` int(4) NOT NULL DEFAULT '0' COMMENT '功能检验',
  `baozhuang` int(4) NOT NULL DEFAULT '0' COMMENT '包装检验',
  `leader_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '领导审核',
  `leader_date` int(10) NOT NULL DEFAULT '0' COMMENT '领导审核日期',
  `entry_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入库日期',
  `return_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退回日期',
  `express` varchar(40) NOT NULL DEFAULT '' COMMENT '快递公司',
  `expressid` varchar(200) NOT NULL DEFAULT '' COMMENT '快递单号',
  `flag` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标记',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 维修质检 `lc_fanxiuquality`
--

CREATE TABLE IF NOT EXISTS `lc_fanxiuquality` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fanxiuid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '维修单ID',
  `quality_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '质检人员',
  `quality_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '质检日期',
  `result` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '结果',
  `describe` text NOT NULL DEFAULT '' COMMENT '不合格描述',
  `type` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 快递公司 `lc_express`
--

CREATE TABLE IF NOT EXISTS `lc_express` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '快递公司',
  `pinyin` varchar(100) NOT NULL DEFAULT '' COMMENT '公司拼音',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 栏目设置 `lc_column`
--

CREATE TABLE IF NOT EXISTS `lc_column` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `module` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '对应模块',
  `field` varchar(50) NOT NULL DEFAULT '' COMMENT '对应字段',
  `width` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '宽度',
  `rank` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 栏目设置 `lc_columnset`
--

CREATE TABLE IF NOT EXISTS `lc_columnset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `columnid` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '栏目ID',
  `module` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '对应模块',
  `manager_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `width` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '宽度',
  `rank` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 查询记录 `lc_query`
--

CREATE TABLE IF NOT EXISTS `lc_query` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `query` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '查询内容',
  `module` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '对应模块',
  `manager_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 客户邮件 `lc_customer`
--

CREATE TABLE IF NOT EXISTS `lc_customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) unsigned NOT NULL DEFAULT '' COMMENT '邮箱地址'
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 客户邮件 `lc_temp`
--

CREATE TABLE IF NOT EXISTS `lc_temp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL DEFAULT '',
  `barcode` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;
--
-- 返修公告 `lc_fanxiugonggao`
--

CREATE TABLE IF NOT EXISTS `lc_fanxiugonggao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL DEFAULT '' COMMENT '公告内容',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `manager_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 固定资产台账 `lc_zichan`
--

CREATE TABLE IF NOT EXISTS `lc_zichan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bianma` varchar(100) NOT NULL DEFAULT '' COMMENT '编码',
  `bianmaxiuding` varchar(100) NOT NULL DEFAULT '' COMMENT '编码修订',
  `mingcheng` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `mingchengxiuding` varchar(100) NOT NULL DEFAULT '' COMMENT '名称修订',
  `leixing` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '设备类型',
  `leibie` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
  `xinghao` varchar(100) NOT NULL DEFAULT '' COMMENT '型号',
  `danjia` varchar(40) NOT NULL DEFAULT '' COMMENT '入库单价',
  `shuliang` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `danwei` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '单位',
  `ruriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入账日期',
  `bumen` bigint(20) NOT NULL DEFAULT '0' COMMENT '部门',
  `didian` varchar(100) NOT NULL DEFAULT '' COMMENT '存放地点',
  `zhuangtai` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `beizhu` varchar(100) NOT NULL DEFAULT '' COMMENT 'U8备注',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `chuchangbianhao` varchar(100) NOT NULL DEFAULT '' COMMENT '出厂编号',
  `changjia` varchar(100) NOT NULL DEFAULT '' COMMENT '厂家',
  `shouxiaoriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首校日期',
  `jianyanriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '检验日期',
  `daoqiriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期日期',
  `daoqijiange` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期间隔',
  `zhouqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '校准周期',
  `jigou` varchar(100) NOT NULL DEFAULT '' COMMENT '校准机构',
  `xiaozhunleixing` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '校准类型',
  `fuzeren` bigint(20) NOT NULL DEFAULT '0' COMMENT '负责人',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 固定资产台账修订 `lc_zichan`
--

CREATE TABLE IF NOT EXISTS `lc_zichan` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bianma` varchar(100) NOT NULL DEFAULT '' COMMENT '编码',
  `bianmaxiuding` varchar(100) NOT NULL DEFAULT '' COMMENT '编码修订',
  `mingcheng` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `mingchengxiuding` varchar(100) NOT NULL DEFAULT '' COMMENT '名称修订',
  `leixing` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '设备类型',
  `leibie` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
  `xinghao` varchar(100) NOT NULL DEFAULT '' COMMENT '型号',
  `danjia` varchar(40) NOT NULL DEFAULT '' COMMENT '入库单价',
  `shuliang` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `danwei` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '单位',
  `ruriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '入账日期',
  `bumen` bigint(20) NOT NULL DEFAULT '0' COMMENT '部门',
  `didian` varchar(100) NOT NULL DEFAULT '' COMMENT '存放地点',
  `zhuangtai` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `beizhu` varchar(100) NOT NULL DEFAULT '' COMMENT 'U8备注',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `chuchangbianhao` varchar(100) NOT NULL DEFAULT '' COMMENT '出厂编号',
  `changjia` varchar(100) NOT NULL DEFAULT '' COMMENT '厂家',
  `shouxiaoriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首校日期',
  `jianyanriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '检验日期',
  `daoqiriqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期日期',
  `daoqijiange` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期间隔',
  `zhouqi` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '校准周期',
  `jigou` varchar(100) NOT NULL DEFAULT '' COMMENT '校准机构',
  `xiaozhunleixing` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '校准类型',
  `fuzeren` bigint(20) NOT NULL DEFAULT '0' COMMENT '负责人',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- app版本 `lc_version`
--

CREATE TABLE IF NOT EXISTS `lc_version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(100) NOT NULL DEFAULT '' COMMENT '版本号',
  `udate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `address` varchar(100) NOT NULL DEFAULT '' COMMENT '下载地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


--
-- 合理化建议 `lc_suggest`
--

CREATE TABLE IF NOT EXISTS `lc_suggest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '类别',
  `content` text NOT NULL DEFAULT '' COMMENT '内容',
  `img` varchar(200) NOT NULL DEFAULT '' COMMENT '图片',
  `addid` bigint(20) NOT NULL DEFAULT '0' COMMENT '建议人',
  `addtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `dept_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '部门',
  `transfer` bigint(20) NOT NULL DEFAULT '0' COMMENT '中转人',
  `transfertime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '中转时间',
  `flag` int(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否采纳',
  `cause` varchar(200) NOT NULL DEFAULT '' COMMENT '原因',
  `handler` bigint(20) NOT NULL DEFAULT '0' COMMENT '处理人',
  `handletime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '处理时间',
  `result` varchar(200) NOT NULL DEFAULT '' COMMENT '处理结果',
  `state` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2206 ;

--
-- 人脸库 `lc_face`
--

CREATE TABLE IF NOT EXISTS `lc_face` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(11)  NOT NULL DEFAULT '' COMMENT '手机号',
  `img` MEDIUMTEXT NOT NULL DEFAULT '' COMMENT '人脸图片',
  `cdata` MEDIUMTEXT NOT NULL DEFAULT '' COMMENT '人脸数据',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;