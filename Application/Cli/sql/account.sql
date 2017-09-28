/*
Navicat MySQL Data Transfer

Source Server         : mycms
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2015-06-03 23:41:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL COMMENT '预订单ID',
  `cli_id` int(10) unsigned NOT NULL COMMENT '客户ID',
  `account_date` int(10) unsigned NOT NULL COMMENT '签约日期',
  `number` varchar(20) NOT NULL COMMENT '合同编号',
  `contry` varchar(30) NOT NULL COMMENT '销往国家',
  `collection_account` varchar(30) NOT NULL COMMENT '收款账号',
  `is_out` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否外销 1-是 2-否',
  `commission` decimal(9,2) unsigned NOT NULL COMMENT '客户佣金',
  `send_round` varchar(10) NOT NULL COMMENT '发货周期',
  `is_check` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否商检1-是2-否',
  `is_ticket` tinyint(1) unsigned NOT NULL COMMENT '是否开票 1-是2-否',
  `is_second` tinyint(1) unsigned NOT NULL COMMENT '是否需要 二次包装1-需要 2-否',
  `is_other_check` tinyint(1) unsigned NOT NULL COMMENT '是否需要第三方检测1-需要2-不需要',
  `is_fuzhao` tinyint(1) unsigned NOT NULL COMMENT '是否需要辐照 1-需要 2-不需',
  `remark` text COMMENT '备注',
  `is_all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否全部到账 0-没有 1-全部到账',
  `already_ticket` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否已经开票0-未开票 1-已经开票',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合同表';

-- ----------------------------
-- Table structure for account_buy
-- ----------------------------
DROP TABLE IF EXISTS `account_buy`;
CREATE TABLE `account_buy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned NOT NULL COMMENT '产品ID',
  `buy_user_id` decimal(10,2) unsigned NOT NULL COMMENT '采购价格',
  `buy_time` int(11) unsigned NOT NULL COMMENT '采购时间',
  `warehouse_id` int(11) unsigned NOT NULL COMMENT '仓库ID',
  `total_money` decimal(11,2) unsigned NOT NULL COMMENT '采购总金额',
  `into_time` int(10) unsigned NOT NULL COMMENT '入库时间',
  `is_end` tinyint(1) unsigned NOT NULL COMMENT '是否结束0-未结束1-已经结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合同产品采购单';

-- ----------------------------
-- Table structure for account_buy_product
-- ----------------------------
DROP TABLE IF EXISTS `account_buy_product`;
CREATE TABLE `account_buy_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `acc_pro_id` int(10) unsigned NOT NULL COMMENT '合同产品ID',
  `buy_id` int(10) unsigned NOT NULL COMMENT '采购单id',
  `suppliers` varchar(255) DEFAULT NULL COMMENT '供应商',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '采购价格',
  `num` int(11) unsigned NOT NULL COMMENT '采购数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合同采购明细';

-- ----------------------------
-- Table structure for account_cabin
-- ----------------------------
DROP TABLE IF EXISTS `account_cabin`;
CREATE TABLE `account_cabin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL COMMENT '合同ID',
  `status` tinyint(1) unsigned NOT NULL COMMENT '是否结束0-未结束 1-结束',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订舱单';

-- ----------------------------
-- Table structure for account_card
-- ----------------------------
DROP TABLE IF EXISTS `account_card`;
CREATE TABLE `account_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) unsigned NOT NULL COMMENT '合同ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '办理人',
  `add_time` int(10) unsigned NOT NULL COMMENT '申请办理时间',
  `ok_time` int(10) unsigned NOT NULL COMMENT '办理完成时间',
  `status` tinyint(1) unsigned NOT NULL COMMENT '0-待办理 1-办理完成',
  `type` tinyint(1) unsigned NOT NULL COMMENT '1-信用证2-小证3-年证',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='证书';

-- ----------------------------
-- Table structure for account_check
-- ----------------------------
DROP TABLE IF EXISTS `account_check`;
CREATE TABLE `account_check` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL COMMENT '合同ID',
  `user_id` int(10) unsigned NOT NULL COMMENT '检测人',
  `remark` text COMMENT '备注说明',
  `is_end` tinyint(1) unsigned NOT NULL COMMENT '是否结束0-检测中，1检测完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='实验室检测表';

-- ----------------------------
-- Table structure for account_money
-- ----------------------------
DROP TABLE IF EXISTS `account_money`;
CREATE TABLE `account_money` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `money` decimal(11,2) unsigned NOT NULL COMMENT '到账金额',
  `collection_account` varchar(30) NOT NULL COMMENT '到账账户',
  `time` int(11) unsigned NOT NULL COMMENT '到账时间',
  `qianzhang` decimal(11,9) NOT NULL COMMENT '欠账金额',
  `will_time` int(11) unsigned NOT NULL COMMENT '约定到账期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='合同到账表';

-- ----------------------------
-- Table structure for account_product
-- ----------------------------
DROP TABLE IF EXISTS `account_product`;
CREATE TABLE `account_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL COMMENT '合同ID',
  `product_id` int(10) unsigned NOT NULL COMMENT '产品ID',
  `price` decimal(10,2) unsigned NOT NULL COMMENT '销售价格',
  `num` int(10) unsigned NOT NULL COMMENT '销售数量',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0-待发货 1-已经发货 2-退货',
  `send_time` int(10) unsigned NOT NULL COMMENT '发货时间',
  `recive_time` int(10) unsigned NOT NULL COMMENT '产品到达客户时间',
  `back_time` int(11) unsigned NOT NULL COMMENT '回退到达时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for account_send_form
-- ----------------------------
DROP TABLE IF EXISTS `account_send_form`;
CREATE TABLE `account_send_form` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL COMMENT '制单人ID',
  `user_name` varchar(10) NOT NULL COMMENT '制单人姓名',
  `add_time` int(11) unsigned NOT NULL COMMENT '制单时间',
  `sale_user_id` int(10) unsigned NOT NULL COMMENT '销售人员ID',
  `sale_user_name` varchar(30) NOT NULL COMMENT '销售人员姓名',
  `total_money` decimal(11,2) NOT NULL COMMENT '合计金额',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='发货计划单';

-- ----------------------------
-- Table structure for account_send_form_product
-- ----------------------------
DROP TABLE IF EXISTS `account_send_form_product`;
CREATE TABLE `account_send_form_product` (
  `id` int(11) NOT NULL,
  `form_id` int(10) unsigned NOT NULL COMMENT '发货单ID',
  `account_id` int(10) unsigned NOT NULL COMMENT '合同ID',
  `account_number` varchar(30) NOT NULL COMMENT '合同编号',
  `acc_pro_id` int(10) unsigned NOT NULL COMMENT '合同产品ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
