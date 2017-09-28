/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-05-28 23:25:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cli_order
-- ----------------------------
DROP TABLE IF EXISTS `cli_order`;
CREATE TABLE `cli_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` int(10) unsigned DEFAULT NULL COMMENT '客户ID',
  `cli_name` varchar(255) DEFAULT NULL COMMENT '客户名称',
  `add_user` int(11) unsigned NOT NULL COMMENT '创建人ID',
  `add_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `order_time` int(10) unsigned NOT NULL COMMENT '发单时间',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '0-订单创建 1-订单已经生成合同 2-订单失效',
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_order
-- ----------------------------
INSERT INTO `cli_order` VALUES ('1', '123', '12321', '13', '1432733488', '1438733488', '0', 'sssss');
INSERT INTO `cli_order` VALUES ('2', '123', '12321', '13', '1432733549', '1433733488', '0', 'dfdf');
INSERT INTO `cli_order` VALUES ('4', '123', '12321', '13', '1432740672', '1442733488', '0', 'dfdf');

-- ----------------------------
-- Table structure for cli_order_product
-- ----------------------------
DROP TABLE IF EXISTS `cli_order_product`;
CREATE TABLE `cli_order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL COMMENT '订单ID',
  `selling_price` decimal(10,2) unsigned NOT NULL COMMENT '实际销售价格',
  `product_id` int(11) unsigned NOT NULL COMMENT '产品ID',
  `count` int(10) unsigned NOT NULL COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cli_order_product
-- ----------------------------
INSERT INTO `cli_order_product` VALUES ('1', '1', '0.00', '1', '0');
INSERT INTO `cli_order_product` VALUES ('4', '1', '1.00', '1', '1');
INSERT INTO `cli_order_product` VALUES ('5', '1', '1.00', '2', '1');
