/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-05-19 00:25:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cli_comment
-- ----------------------------
DROP TABLE IF EXISTS `cli_comment`;
CREATE TABLE `cli_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `flow_id` int(11) NOT NULL COMMENT 'flow表ID',
  `p_id` int(11) NOT NULL COMMENT '上级评论ID',
  `content` text NOT NULL COMMENT '评论内容',
  `add_time` int(11) NOT NULL,
  `add_user_id` int(11) NOT NULL COMMENT '评论人ID',
  `add_user_name` varchar(50) NOT NULL COMMENT '评论人姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_comment
-- ----------------------------
INSERT INTO `cli_comment` VALUES ('1', '36', '0', 'dsafasf', '0', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('2', '36', '0', '睡大觉撒旦法', '0', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('3', '36', '1', '四大发生大发', '0', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('4', '36', '0', 'dsafadsfadfadfadf', '1431965182', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('5', '37', '0', '哈哈哈哈哈这就是新的嗲评了', '1431965199', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('6', '37', '0', '在家一条点评吧，哈哈', '1431965212', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('7', '37', '0', '阿阿斯顿发沙发', '1431965242', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('8', '37', '0', '阿达撒发短发', '1431965271', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('9', '37', '0', '水水水水是', '1431965280', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('10', '36', '1', '', '1431965636', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('11', '36', '3', '', '1431965741', '13', '系统管理员');
INSERT INTO `cli_comment` VALUES ('12', '36', '10', 'ssssssssssssssssssss', '1431965891', '13', '系统管理员');
