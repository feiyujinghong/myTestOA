/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-05-17 22:32:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cli_admin
-- ----------------------------
DROP TABLE IF EXISTS `cli_admin`;
CREATE TABLE `cli_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_user_id` int(10) NOT NULL COMMENT '全局管理元ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_admin
-- ----------------------------
INSERT INTO `cli_admin` VALUES ('34', '46');
INSERT INTO `cli_admin` VALUES ('35', '47');
INSERT INTO `cli_admin` VALUES ('36', '48');
INSERT INTO `cli_admin` VALUES ('37', '49');

-- ----------------------------
-- Table structure for cli_group
-- ----------------------------
DROP TABLE IF EXISTS `cli_group`;
CREATE TABLE `cli_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '组名',
  `leader_id` int(11) NOT NULL COMMENT '组长iD',
  `user_ids` varchar(255) NOT NULL COMMENT '组员ID串',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_group
-- ----------------------------
INSERT INTO `cli_group` VALUES ('1', 'fda111', '45', '46,47,48');
INSERT INTO `cli_group` VALUES ('2', 'fda222', '45', '46,47,48');
