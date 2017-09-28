/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-05-21 00:19:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cli_help
-- ----------------------------
DROP TABLE IF EXISTS `cli_help`;
CREATE TABLE `cli_help` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` int(11) unsigned NOT NULL COMMENT '客户ID',
  `help_user_id` int(11) unsigned NOT NULL COMMENT '求助人',
  `add_user_id` int(10) unsigned NOT NULL COMMENT '发起人',
  `p_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复的内容ID,0为发起人刚发起的问题',
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `add_time` int(11) unsigned NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_help
-- ----------------------------
INSERT INTO `cli_help` VALUES ('1', '123', '45', '13', '0', 'adsfasdfadf', '&lt;p&gt;adsfadfadf1111111111&lt;/p&gt;', '1432136905');
INSERT INTO `cli_help` VALUES ('2', '123', '45', '13', '0', '11111111', '&lt;p&gt;1dsfadadfsa&lt;/p&gt;', '1432137268');
INSERT INTO `cli_help` VALUES ('3', '123', '13', '13', '0', '1111', '&lt;p&gt;1111111111&lt;/p&gt;', '1432137374');
INSERT INTO `cli_help` VALUES ('4', '123', '13', '13', '0', '12', '&lt;p&gt;123123123&lt;/p&gt;', '1432137420');
INSERT INTO `cli_help` VALUES ('5', '123', '13', '13', '0', '12', '&lt;p&gt;123123123&lt;/p&gt;', '1432137433');
INSERT INTO `cli_help` VALUES ('6', '123', '13', '13', '0', '12', '&lt;p&gt;123123123&lt;/p&gt;', '1432137493');
INSERT INTO `cli_help` VALUES ('7', '123', '13', '13', '0', '12', '&lt;p&gt;123123123&lt;/p&gt;', '1432137504');
INSERT INTO `cli_help` VALUES ('8', '123', '13', '13', '0', '12', '&lt;p&gt;123123123&lt;/p&gt;', '1432137516');
INSERT INTO `cli_help` VALUES ('9', '123', '13', '13', '0', '45555555555555555555555555', '&lt;p&gt;ewwwwwwr&lt;/p&gt;', '1432137537');
INSERT INTO `cli_help` VALUES ('10', '123', '13', '13', '0', 'wwwwwwww', '&lt;p&gt;wwwwwwww&lt;/p&gt;', '1432137550');
