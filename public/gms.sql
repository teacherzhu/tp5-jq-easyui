/*
Navicat MySQL Data Transfer

Source Server         : home
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : gms

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-03-15 22:40:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gms_group
-- ----------------------------
DROP TABLE IF EXISTS `gms_group`;
CREATE TABLE `gms_group` (
  `id` int(11) NOT NULL COMMENT '组织ID',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '组织名称',
  `pid` int(11) NOT NULL COMMENT '父节点ID',
  `level` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '检索字段',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gms_group
-- ----------------------------
INSERT INTO `gms_group` VALUES ('1', '根组织', '0', '/1');

-- ----------------------------
-- Table structure for gms_role
-- ----------------------------
DROP TABLE IF EXISTS `gms_role`;
CREATE TABLE `gms_role` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL COMMENT '名称',
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '状态',
  `rules` text COMMENT '规则',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_role
-- ----------------------------
INSERT INTO `gms_role` VALUES ('1', '2017-03-15 21:07:25', '2017-03-15 21:07:27', '管理员', '1', '');

-- ----------------------------
-- Table structure for gms_rule
-- ----------------------------
DROP TABLE IF EXISTS `gms_rule`;
CREATE TABLE `gms_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `pid` int(11) DEFAULT '0' COMMENT '上级菜单',
  `name` varchar(100) DEFAULT NULL COMMENT '菜单名称',
  `title` varchar(100) DEFAULT NULL COMMENT '菜单标题',
  `icon` varchar(30) DEFAULT 'icon-form' COMMENT '图标',
  `type` varchar(1) DEFAULT '1' COMMENT '导航',
  `is_hide` varchar(1) DEFAULT '1' COMMENT '隐藏',
  `status` varchar(1) DEFAULT '1' COMMENT '状态',
  `sort` smallint(3) unsigned DEFAULT '1' COMMENT '排序',
  `condition` varchar(40) DEFAULT NULL COMMENT '附加参数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of gms_rule
-- ----------------------------
INSERT INTO `gms_rule` VALUES ('24', '1', 'admin/rule/index', '菜单管理', 'iconfont icon-form', '1', '0', '1', '2', '');
INSERT INTO `gms_rule` VALUES ('40', '2', 'admin/role/index', '用户组管理', 'iconfont icon-form', '1', '0', '1', '2', '');
INSERT INTO `gms_rule` VALUES ('20', '1', 'Admin/Config/index', '配置管理', 'iconfont icon-form', '1', '0', '1', '3', '');
INSERT INTO `gms_rule` VALUES ('36', '2', 'admin/user/index', '用户管理', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('25', '24', 'admin/rule/create', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('26', '24', 'admin/rule/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('27', '24', 'admin/rule/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('37', '36', 'admin/user/create', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('38', '36', 'admin/user/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('39', '36', 'admin/user/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('41', '40', 'admin/role/create', '新增', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('42', '40', 'admin/role/edit', '编辑', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('43', '40', 'admin/role/del', '删除', 'iconfont icon-form', '1', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('3', '0', '', '数据库', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('2', '0', '', '用户信息', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('1', '0', '', '系统配置', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('54', '3', 'admin/database/backup_list', '备份数据库', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('55', '3', 'admin/database/rollback_list', '还原数据库', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('65', '1', 'admin/sysconfig/set', '系统设置', 'iconfont icon-form', '1', '0', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('73', '54', 'admin/database/optimize', '优化表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('74', '54', 'admin/database/repair', '修复表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('75', '54', 'admin/database/backup', '备份表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('76', '55', 'admin/database/rollback', '还原表', 'iconfont icon-form', '0', '1', '1', '1', '');
INSERT INTO `gms_rule` VALUES ('77', '55', 'admin/database/del', '删除表', 'iconfont icon-form', '0', '1', '1', '1', '');

-- ----------------------------
-- Table structure for gms_user
-- ----------------------------
DROP TABLE IF EXISTS `gms_user`;
CREATE TABLE `gms_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(64) NOT NULL COMMENT '用户密码',
  `role_id` int(11) DEFAULT NULL COMMENT '用户角色',
  `create_time` datetime NOT NULL COMMENT '注册日期',
  `update_time` datetime NOT NULL COMMENT '最后修改时间',
  `login_ip` varchar(20) DEFAULT NULL COMMENT '上次登录IP',
  `login_time` datetime NOT NULL COMMENT '上次登录时间',
  `group_id` int(11) NOT NULL COMMENT '所属组织',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` int(3) DEFAULT '1' COMMENT '验证/状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gms_user
-- ----------------------------
INSERT INTO `gms_user` VALUES ('1', 'admin', 'admin', '1', '2017-01-01 00:00:01', '2017-03-15 22:30:05', '0.0.0.0', '2017-03-15 22:30:05', '1', '', '1');
