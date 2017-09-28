/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-05-13 00:12:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cli_follow
-- ----------------------------
DROP TABLE IF EXISTS `cli_follow`;
CREATE TABLE `cli_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` int(11) NOT NULL,
  `follow_time` int(11) NOT NULL,
  `follow_type` varchar(11) NOT NULL,
  `link_type` varchar(50) NOT NULL,
  `follow_content` varchar(300) NOT NULL DEFAULT '',
  `insert_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='沟通表';

-- ----------------------------
-- Records of cli_follow
-- ----------------------------
INSERT INTO `cli_follow` VALUES ('27', '110', '123', '0', '0', '12312321', '0');
INSERT INTO `cli_follow` VALUES ('28', '110', '2147483647', '0', '0', '3333333333333层层层层层层层层层层层ccccc', '0');
INSERT INTO `cli_follow` VALUES ('29', '110', '123', '1', '2', '213123', '0');
INSERT INTO `cli_follow` VALUES ('30', '114', '1970', '0', '0', '阿斯蒂芬放大法按时阿斯顿发达啊啊地方阿斯蒂芬阿斯蒂芬阿凡达琐琐碎碎琐琐碎碎', '1');
INSERT INTO `cli_follow` VALUES ('31', '117', '1431446400', '0', '0', '', '1');
INSERT INTO `cli_follow` VALUES ('32', '117', '1431446400', '0', '0', '', '1');
INSERT INTO `cli_follow` VALUES ('33', '117', '1431446400', '0', '0', '', '1');
INSERT INTO `cli_follow` VALUES ('34', '117', '1431446400', '0', '0', '', '1');
INSERT INTO `cli_follow` VALUES ('35', '117', '1431446400', '0', '0', '', '1');
INSERT INTO `cli_follow` VALUES ('36', '122', '1431446400', '001', '4u48932432', '&lt;p&gt;ssssssssssssfas&lt;/p&gt;&lt;p&gt;asdf&lt;/p&gt;&lt;p&gt;adsf&lt;/p&gt;&lt;p&gt;asdf&lt;/p&gt;&lt;p&gt;as&lt;/p&gt;&lt;p&gt;df&lt;/p&gt;&lt;p&gt;af&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '1');

-- ----------------------------
-- Table structure for sys_code
-- ----------------------------
DROP TABLE IF EXISTS `sys_code`;
CREATE TABLE `sys_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(30) NOT NULL COMMENT '代码',
  `name` varchar(50) NOT NULL COMMENT '代码名称',
  `p_id` int(10) unsigned NOT NULL COMMENT '上级ID',
  `order` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-正常 1-禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sys_code
-- ----------------------------
INSERT INTO `sys_code` VALUES ('1', 'GOUTONG_TYPE', '沟通方式', '0', '0', '0');
INSERT INTO `sys_code` VALUES ('2', '12122', 'dsdafasdf', '0', '0', '0');
INSERT INTO `sys_code` VALUES ('3', 'UNIT', '计量单位', '0', '0', '0');
INSERT INTO `sys_code` VALUES ('4', 'ZHENZHIMIANMAO', '政治面貌', '0', '0', '0');
INSERT INTO `sys_code` VALUES ('5', '0001', '团员', '4', '1', '0');
INSERT INTO `sys_code` VALUES ('6', '0002', '党员', '4', '2', '0');
INSERT INTO `sys_code` VALUES ('7', '0003', '群众', '4', '3', '0');
INSERT INTO `sys_code` VALUES ('8', '001', 'QQ', '1', '1', '0');
INSERT INTO `sys_code` VALUES ('9', '002', 'TM', '1', '2', '0');
INSERT INTO `sys_code` VALUES ('10', '003', '贸易通', '1', '3', '0');
