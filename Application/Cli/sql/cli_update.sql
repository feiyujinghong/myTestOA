/*
Navicat MySQL Data Transfer

Source Server         : localhsot
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-05-28 20:04:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cli_update`
-- ----------------------------
DROP TABLE IF EXISTS `cli_update`;
CREATE TABLE `cli_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_id` int(11) NOT NULL,
  `str` varchar(900) NOT NULL DEFAULT '',
  `update_arr` varchar(900) NOT NULL DEFAULT '',
  `add_time` int(11) NOT NULL,
  `is_agree` tinyint(4) NOT NULL,
  `bak` varchar(300) NOT NULL DEFAULT '',
  `dr` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_update
-- ----------------------------
INSERT INTO `cli_update` VALUES ('1', '127', '公司名称:由公司名称申请变更为公司名称1<br/>客户来源:由搜狐网站申请变更为来电询盘<br/>详细地址:由详细地址详细地址申请变更为详细地址详细地址1<br/>跟踪周期:由1申请变更为2<br/>', 'a:4:{s:12:\"company_name\";a:2:{s:3:\"old\";s:12:\"公司名称\";s:3:\"new\";s:13:\"公司名称1\";}s:6:\"source\";a:2:{s:3:\"old\";s:12:\"搜狐网站\";s:3:\"new\";s:12:\"来电询盘\";}s:8:\"detailed\";a:2:{s:3:\"old\";s:24:\"详细地址详细地址\";s:3:\"new\";s:25:\"详细地址详细地址1\";}s:6:\"follow\";a:2:{s:3:\"old\";s:1:\"1\";s:3:\"new\";s:1:\"2\";}}', '1432718764', '1', '', '0');
