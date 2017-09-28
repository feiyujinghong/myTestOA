/*
Navicat MySQL Data Transfer

Source Server         : localhsot
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : co

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2015-05-12 20:34:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `city_area`
-- ----------------------------
DROP TABLE IF EXISTS `city_area`;
CREATE TABLE `city_area` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `c_id` int(10) unsigned NOT NULL COMMENT '国家id',
  `name` varchar(20) NOT NULL DEFAULT '',
  `reid` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4230 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of city_area
-- ----------------------------
INSERT INTO `city_area` VALUES ('1', '1', '北京市', '0');
INSERT INTO `city_area` VALUES ('102', '1', '西城区', '1');
INSERT INTO `city_area` VALUES ('126', '1', '崇文区', '1');
INSERT INTO `city_area` VALUES ('104', '1', '宣武区', '1');
INSERT INTO `city_area` VALUES ('105', '1', '朝阳区', '1');
INSERT INTO `city_area` VALUES ('106', '1', '海淀区', '1');
INSERT INTO `city_area` VALUES ('107', '1', '丰台区', '1');
INSERT INTO `city_area` VALUES ('108', '1', '石景山区', '1');
INSERT INTO `city_area` VALUES ('109', '1', '门头沟区', '1');
INSERT INTO `city_area` VALUES ('110', '1', '房山区', '1');
INSERT INTO `city_area` VALUES ('111', '1', '通州区', '1');
INSERT INTO `city_area` VALUES ('112', '1', '顺义区', '1');
INSERT INTO `city_area` VALUES ('113', '1', '昌平区', '1');
INSERT INTO `city_area` VALUES ('114', '1', '大兴区', '1');
INSERT INTO `city_area` VALUES ('115', '1', '平谷县', '1');
INSERT INTO `city_area` VALUES ('116', '1', '怀柔县', '1');
INSERT INTO `city_area` VALUES ('117', '1', '密云县', '1');
INSERT INTO `city_area` VALUES ('118', '1', '延庆县', '1');
INSERT INTO `city_area` VALUES ('2', '1', '上海市', '0');
INSERT INTO `city_area` VALUES ('201', '1', '黄浦区', '2');
INSERT INTO `city_area` VALUES ('202', '1', '卢湾区', '2');
INSERT INTO `city_area` VALUES ('203', '1', '徐汇区', '2');
INSERT INTO `city_area` VALUES ('204', '1', '长宁区', '2');
INSERT INTO `city_area` VALUES ('205', '1', '静安区', '2');
INSERT INTO `city_area` VALUES ('206', '1', '普陀区', '2');
INSERT INTO `city_area` VALUES ('207', '1', '闸北区', '2');
INSERT INTO `city_area` VALUES ('208', '1', '虹口区', '2');
INSERT INTO `city_area` VALUES ('209', '1', '杨浦区', '2');
INSERT INTO `city_area` VALUES ('210', '1', '宝山区', '2');
INSERT INTO `city_area` VALUES ('211', '1', '闵行区', '2');
INSERT INTO `city_area` VALUES ('212', '1', '嘉定区', '2');
INSERT INTO `city_area` VALUES ('213', '1', '浦东新区', '2');
INSERT INTO `city_area` VALUES ('214', '1', '松江区', '2');
INSERT INTO `city_area` VALUES ('215', '1', '金山区', '2');
INSERT INTO `city_area` VALUES ('216', '1', '青浦区', '2');
INSERT INTO `city_area` VALUES ('217', '1', '南汇区', '2');
INSERT INTO `city_area` VALUES ('218', '1', '奉贤区', '2');
INSERT INTO `city_area` VALUES ('219', '1', '崇明县', '2');
INSERT INTO `city_area` VALUES ('3', '1', '天津市', '0');
INSERT INTO `city_area` VALUES ('301', '1', '和平区', '3');
INSERT INTO `city_area` VALUES ('302', '1', '河东区', '3');
INSERT INTO `city_area` VALUES ('303', '1', '河西区', '3');
INSERT INTO `city_area` VALUES ('304', '1', '南开区', '3');
INSERT INTO `city_area` VALUES ('305', '1', '河北区', '3');
INSERT INTO `city_area` VALUES ('306', '1', '红桥区', '3');
INSERT INTO `city_area` VALUES ('307', '1', '塘沽区', '3');
INSERT INTO `city_area` VALUES ('308', '1', '汉沽区', '3');
INSERT INTO `city_area` VALUES ('309', '1', '大港区', '3');
INSERT INTO `city_area` VALUES ('310', '1', '东丽区', '3');
INSERT INTO `city_area` VALUES ('311', '1', '西青区', '3');
INSERT INTO `city_area` VALUES ('312', '1', '北辰区', '3');
INSERT INTO `city_area` VALUES ('313', '1', '津南区', '3');
INSERT INTO `city_area` VALUES ('314', '1', '武清区', '3');
INSERT INTO `city_area` VALUES ('315', '1', '宝坻区', '3');
INSERT INTO `city_area` VALUES ('316', '1', '静海县', '3');
INSERT INTO `city_area` VALUES ('317', '1', '宁河县', '3');
INSERT INTO `city_area` VALUES ('318', '1', '蓟县', '3');
INSERT INTO `city_area` VALUES ('4', '1', '重庆市', '0');
INSERT INTO `city_area` VALUES ('401', '1', '渝中区', '4');
INSERT INTO `city_area` VALUES ('402', '1', '大渡口区', '4');
INSERT INTO `city_area` VALUES ('403', '1', '江北区', '4');
INSERT INTO `city_area` VALUES ('404', '1', '沙坪坝区', '4');
INSERT INTO `city_area` VALUES ('405', '1', '九龙坡区', '4');
INSERT INTO `city_area` VALUES ('406', '1', '南岸区', '4');
INSERT INTO `city_area` VALUES ('407', '1', '北碚区', '4');
INSERT INTO `city_area` VALUES ('408', '1', '万盛区', '4');
INSERT INTO `city_area` VALUES ('409', '1', '双桥区', '4');
INSERT INTO `city_area` VALUES ('410', '1', '渝北区', '4');
INSERT INTO `city_area` VALUES ('411', '1', '巴南区', '4');
INSERT INTO `city_area` VALUES ('412', '1', '万州区', '4');
INSERT INTO `city_area` VALUES ('413', '1', '涪陵区', '4');
INSERT INTO `city_area` VALUES ('414', '1', '黔江区', '4');
INSERT INTO `city_area` VALUES ('415', '1', '永川', '4');
INSERT INTO `city_area` VALUES ('416', '1', '合川', '4');
INSERT INTO `city_area` VALUES ('417', '1', '江津', '4');
INSERT INTO `city_area` VALUES ('418', '1', '南川', '4');
INSERT INTO `city_area` VALUES ('419', '1', '长寿县', '4');
INSERT INTO `city_area` VALUES ('420', '1', '綦江县', '4');
INSERT INTO `city_area` VALUES ('421', '1', '潼南县', '4');
INSERT INTO `city_area` VALUES ('422', '1', '荣昌县', '4');
INSERT INTO `city_area` VALUES ('423', '1', '璧山县', '4');
INSERT INTO `city_area` VALUES ('424', '1', '大足县', '4');
INSERT INTO `city_area` VALUES ('425', '1', '铜梁县', '4');
INSERT INTO `city_area` VALUES ('426', '1', '梁平县', '4');
INSERT INTO `city_area` VALUES ('427', '1', '城口县', '4');
INSERT INTO `city_area` VALUES ('428', '1', '垫江县', '4');
INSERT INTO `city_area` VALUES ('429', '1', '武隆县', '4');
INSERT INTO `city_area` VALUES ('430', '1', '丰都县', '4');
INSERT INTO `city_area` VALUES ('431', '1', '奉节县', '4');
INSERT INTO `city_area` VALUES ('432', '1', '开县', '4');
INSERT INTO `city_area` VALUES ('433', '1', '云阳县', '4');
INSERT INTO `city_area` VALUES ('434', '1', '忠县', '4');
INSERT INTO `city_area` VALUES ('435', '1', '巫溪县', '4');
INSERT INTO `city_area` VALUES ('436', '1', '巫山县', '4');
INSERT INTO `city_area` VALUES ('437', '1', '石柱县', '4');
INSERT INTO `city_area` VALUES ('438', '1', '秀山县', '4');
INSERT INTO `city_area` VALUES ('439', '1', '酉阳县', '4');
INSERT INTO `city_area` VALUES ('440', '1', '彭水县', '4');
INSERT INTO `city_area` VALUES ('5', '1', '广东省', '0');
INSERT INTO `city_area` VALUES ('501', '1', '广州', '5');
INSERT INTO `city_area` VALUES ('502', '1', '深圳', '5');
INSERT INTO `city_area` VALUES ('503', '1', '珠海', '5');
INSERT INTO `city_area` VALUES ('504', '1', '汕头', '5');
INSERT INTO `city_area` VALUES ('505', '1', '韶关', '5');
INSERT INTO `city_area` VALUES ('506', '1', '河源', '5');
INSERT INTO `city_area` VALUES ('507', '1', '梅州', '5');
INSERT INTO `city_area` VALUES ('508', '1', '惠州', '5');
INSERT INTO `city_area` VALUES ('509', '1', '汕尾', '5');
INSERT INTO `city_area` VALUES ('510', '1', '东莞', '5');
INSERT INTO `city_area` VALUES ('511', '1', '中山', '5');
INSERT INTO `city_area` VALUES ('512', '1', '江门', '5');
INSERT INTO `city_area` VALUES ('513', '1', '佛山', '5');
INSERT INTO `city_area` VALUES ('514', '1', '阳江', '5');
INSERT INTO `city_area` VALUES ('515', '1', '湛江', '5');
INSERT INTO `city_area` VALUES ('516', '1', '茂名', '5');
INSERT INTO `city_area` VALUES ('517', '1', '肇庆', '5');
INSERT INTO `city_area` VALUES ('518', '1', '清远', '5');
INSERT INTO `city_area` VALUES ('519', '1', '潮州', '5');
INSERT INTO `city_area` VALUES ('520', '1', '揭阳', '5');
INSERT INTO `city_area` VALUES ('521', '1', '云浮', '5');
INSERT INTO `city_area` VALUES ('6', '1', '福建省', '0');
INSERT INTO `city_area` VALUES ('601', '1', '福州', '6');
INSERT INTO `city_area` VALUES ('602', '1', '厦门', '6');
INSERT INTO `city_area` VALUES ('603', '1', '三明', '6');
INSERT INTO `city_area` VALUES ('604', '1', '莆田', '6');
INSERT INTO `city_area` VALUES ('605', '1', '泉州', '6');
INSERT INTO `city_area` VALUES ('606', '1', '漳州', '6');
INSERT INTO `city_area` VALUES ('607', '1', '南平', '6');
INSERT INTO `city_area` VALUES ('608', '1', '龙岩', '6');
INSERT INTO `city_area` VALUES ('609', '1', '宁德', '6');
INSERT INTO `city_area` VALUES ('7', '1', '浙江省', '0');
INSERT INTO `city_area` VALUES ('701', '1', '杭州', '7');
INSERT INTO `city_area` VALUES ('702', '1', '宁波', '7');
INSERT INTO `city_area` VALUES ('703', '1', '温州', '7');
INSERT INTO `city_area` VALUES ('704', '1', '嘉兴', '7');
INSERT INTO `city_area` VALUES ('705', '1', '湖州', '7');
INSERT INTO `city_area` VALUES ('706', '1', '绍兴', '7');
INSERT INTO `city_area` VALUES ('707', '1', '金华', '7');
INSERT INTO `city_area` VALUES ('708', '1', '衢州', '7');
INSERT INTO `city_area` VALUES ('709', '1', '舟山', '7');
INSERT INTO `city_area` VALUES ('710', '1', '台州', '7');
INSERT INTO `city_area` VALUES ('711', '1', '丽水', '7');
INSERT INTO `city_area` VALUES ('8', '1', '江苏省', '0');
INSERT INTO `city_area` VALUES ('801', '1', '南京', '8');
INSERT INTO `city_area` VALUES ('802', '1', '徐州', '8');
INSERT INTO `city_area` VALUES ('803', '1', '连云港', '8');
INSERT INTO `city_area` VALUES ('804', '1', '淮安', '8');
INSERT INTO `city_area` VALUES ('805', '1', '宿迁', '8');
INSERT INTO `city_area` VALUES ('806', '1', '盐城', '8');
INSERT INTO `city_area` VALUES ('807', '1', '扬州', '8');
INSERT INTO `city_area` VALUES ('808', '1', '泰州', '8');
INSERT INTO `city_area` VALUES ('809', '1', '南通', '8');
INSERT INTO `city_area` VALUES ('810', '1', '镇江', '8');
INSERT INTO `city_area` VALUES ('811', '1', '常州', '8');
INSERT INTO `city_area` VALUES ('812', '1', '无锡', '8');
INSERT INTO `city_area` VALUES ('813', '1', '苏州', '8');
INSERT INTO `city_area` VALUES ('9', '1', '山东省', '0');
INSERT INTO `city_area` VALUES ('901', '1', '济南', '9');
INSERT INTO `city_area` VALUES ('902', '1', '青岛', '9');
INSERT INTO `city_area` VALUES ('903', '1', '淄博', '9');
INSERT INTO `city_area` VALUES ('904', '1', '枣庄', '9');
INSERT INTO `city_area` VALUES ('905', '1', '东营', '9');
INSERT INTO `city_area` VALUES ('906', '1', '潍坊', '9');
INSERT INTO `city_area` VALUES ('907', '1', '烟台', '9');
INSERT INTO `city_area` VALUES ('908', '1', '威海', '9');
INSERT INTO `city_area` VALUES ('909', '1', '济宁', '9');
INSERT INTO `city_area` VALUES ('910', '1', '泰安', '9');
INSERT INTO `city_area` VALUES ('911', '1', '日照', '9');
INSERT INTO `city_area` VALUES ('912', '1', '莱芜', '9');
INSERT INTO `city_area` VALUES ('913', '1', '德州', '9');
INSERT INTO `city_area` VALUES ('914', '1', '临沂', '9');
INSERT INTO `city_area` VALUES ('915', '1', '聊城', '9');
INSERT INTO `city_area` VALUES ('916', '1', '滨州', '9');
INSERT INTO `city_area` VALUES ('917', '1', '菏泽', '9');
INSERT INTO `city_area` VALUES ('10', '1', '辽宁省', '0');
INSERT INTO `city_area` VALUES ('1001', '1', '沈阳', '10');
INSERT INTO `city_area` VALUES ('1002', '1', '大连', '10');
INSERT INTO `city_area` VALUES ('1003', '1', '鞍山', '10');
INSERT INTO `city_area` VALUES ('1004', '1', '抚顺', '10');
INSERT INTO `city_area` VALUES ('1005', '1', '本溪', '10');
INSERT INTO `city_area` VALUES ('1006', '1', '丹东', '10');
INSERT INTO `city_area` VALUES ('1007', '1', '锦州', '10');
INSERT INTO `city_area` VALUES ('1008', '1', '葫芦岛', '10');
INSERT INTO `city_area` VALUES ('1009', '1', '营口', '10');
INSERT INTO `city_area` VALUES ('1010', '1', '盘锦', '10');
INSERT INTO `city_area` VALUES ('1011', '1', '阜新', '10');
INSERT INTO `city_area` VALUES ('1012', '1', '辽阳', '10');
INSERT INTO `city_area` VALUES ('1013', '1', '铁岭', '10');
INSERT INTO `city_area` VALUES ('1014', '1', '朝阳', '10');
INSERT INTO `city_area` VALUES ('11', '1', '江西省', '0');
INSERT INTO `city_area` VALUES ('1101', '1', '南昌', '11');
INSERT INTO `city_area` VALUES ('1102', '1', '景德镇', '11');
INSERT INTO `city_area` VALUES ('1103', '1', '萍乡', '11');
INSERT INTO `city_area` VALUES ('1104', '1', '新余', '11');
INSERT INTO `city_area` VALUES ('1105', '1', '九江', '11');
INSERT INTO `city_area` VALUES ('1106', '1', '鹰潭', '11');
INSERT INTO `city_area` VALUES ('1107', '1', '赣州', '11');
INSERT INTO `city_area` VALUES ('1108', '1', '吉安', '11');
INSERT INTO `city_area` VALUES ('1109', '1', '宜春', '11');
INSERT INTO `city_area` VALUES ('1110', '1', '抚州', '11');
INSERT INTO `city_area` VALUES ('1111', '1', '上饶', '11');
INSERT INTO `city_area` VALUES ('12', '1', '四川省', '0');
INSERT INTO `city_area` VALUES ('1201', '1', '成都', '12');
INSERT INTO `city_area` VALUES ('1202', '1', '自贡', '12');
INSERT INTO `city_area` VALUES ('1203', '1', '攀枝花', '12');
INSERT INTO `city_area` VALUES ('1204', '1', '泸州', '12');
INSERT INTO `city_area` VALUES ('1205', '1', '德阳', '12');
INSERT INTO `city_area` VALUES ('1206', '1', '绵阳', '12');
INSERT INTO `city_area` VALUES ('1207', '1', '广元', '12');
INSERT INTO `city_area` VALUES ('1208', '1', '遂宁', '12');
INSERT INTO `city_area` VALUES ('1209', '1', '内江', '12');
INSERT INTO `city_area` VALUES ('1210', '1', '乐山', '12');
INSERT INTO `city_area` VALUES ('1211', '1', '南充', '12');
INSERT INTO `city_area` VALUES ('1212', '1', '宜宾', '12');
INSERT INTO `city_area` VALUES ('1213', '1', '广安', '12');
INSERT INTO `city_area` VALUES ('1214', '1', '达州', '12');
INSERT INTO `city_area` VALUES ('1215', '1', '巴中', '12');
INSERT INTO `city_area` VALUES ('1216', '1', '雅安', '12');
INSERT INTO `city_area` VALUES ('1217', '1', '眉山', '12');
INSERT INTO `city_area` VALUES ('1218', '1', '资阳', '12');
INSERT INTO `city_area` VALUES ('1219', '1', '阿坝自治州', '12');
INSERT INTO `city_area` VALUES ('1220', '1', '甘孜自治州', '12');
INSERT INTO `city_area` VALUES ('1221', '1', '凉山自治州', '12');
INSERT INTO `city_area` VALUES ('13', '1', '陕西省', '0');
INSERT INTO `city_area` VALUES ('3114', '1', '西安', '13');
INSERT INTO `city_area` VALUES ('1302', '1', '铜川', '13');
INSERT INTO `city_area` VALUES ('1303', '1', '宝鸡', '13');
INSERT INTO `city_area` VALUES ('1304', '1', '咸阳', '13');
INSERT INTO `city_area` VALUES ('1305', '1', '渭南', '13');
INSERT INTO `city_area` VALUES ('1306', '1', '延安', '13');
INSERT INTO `city_area` VALUES ('1307', '1', '汉中', '13');
INSERT INTO `city_area` VALUES ('1308', '1', '榆林', '13');
INSERT INTO `city_area` VALUES ('1309', '1', '安康', '13');
INSERT INTO `city_area` VALUES ('1310', '1', '商洛', '13');
INSERT INTO `city_area` VALUES ('14', '1', '湖北省', '0');
INSERT INTO `city_area` VALUES ('1401', '1', '武汉', '14');
INSERT INTO `city_area` VALUES ('1402', '1', '黄石', '14');
INSERT INTO `city_area` VALUES ('1403', '1', '襄樊', '14');
INSERT INTO `city_area` VALUES ('1404', '1', '十堰', '14');
INSERT INTO `city_area` VALUES ('1405', '1', '荆州', '14');
INSERT INTO `city_area` VALUES ('1406', '1', '宜昌', '14');
INSERT INTO `city_area` VALUES ('1407', '1', '荆门', '14');
INSERT INTO `city_area` VALUES ('1408', '1', '鄂州', '14');
INSERT INTO `city_area` VALUES ('1409', '1', '孝感', '14');
INSERT INTO `city_area` VALUES ('1410', '1', '黄冈', '14');
INSERT INTO `city_area` VALUES ('1411', '1', '咸宁', '14');
INSERT INTO `city_area` VALUES ('1412', '1', '随州', '14');
INSERT INTO `city_area` VALUES ('1413', '1', '仙桃', '14');
INSERT INTO `city_area` VALUES ('1414', '1', '天门', '14');
INSERT INTO `city_area` VALUES ('1415', '1', '潜江', '14');
INSERT INTO `city_area` VALUES ('1416', '1', '神农架林区', '14');
INSERT INTO `city_area` VALUES ('1417', '1', '恩施自治州', '14');
INSERT INTO `city_area` VALUES ('15', '1', '河南省', '0');
INSERT INTO `city_area` VALUES ('1501', '1', '郑州', '15');
INSERT INTO `city_area` VALUES ('1502', '1', '开封', '15');
INSERT INTO `city_area` VALUES ('1503', '1', '洛阳', '15');
INSERT INTO `city_area` VALUES ('1504', '1', '平顶山', '15');
INSERT INTO `city_area` VALUES ('1505', '1', '焦作', '15');
INSERT INTO `city_area` VALUES ('1506', '1', '鹤壁', '15');
INSERT INTO `city_area` VALUES ('1507', '1', '新乡', '15');
INSERT INTO `city_area` VALUES ('1508', '1', '安阳', '15');
INSERT INTO `city_area` VALUES ('1509', '1', '濮阳', '15');
INSERT INTO `city_area` VALUES ('1510', '1', '许昌', '15');
INSERT INTO `city_area` VALUES ('1511', '1', '漯河', '15');
INSERT INTO `city_area` VALUES ('1512', '1', '三门峡', '15');
INSERT INTO `city_area` VALUES ('1513', '1', '南阳', '15');
INSERT INTO `city_area` VALUES ('1514', '1', '商丘', '15');
INSERT INTO `city_area` VALUES ('1515', '1', '信阳', '15');
INSERT INTO `city_area` VALUES ('1516', '1', '周口', '15');
INSERT INTO `city_area` VALUES ('1517', '1', '驻马店', '15');
INSERT INTO `city_area` VALUES ('1518', '1', '济源', '15');
INSERT INTO `city_area` VALUES ('16', '1', '河北省', '0');
INSERT INTO `city_area` VALUES ('1601', '1', '石家庄', '16');
INSERT INTO `city_area` VALUES ('1602', '1', '唐山', '16');
INSERT INTO `city_area` VALUES ('1603', '1', '秦皇岛', '16');
INSERT INTO `city_area` VALUES ('1604', '1', '邯郸', '16');
INSERT INTO `city_area` VALUES ('1605', '1', '邢台', '16');
INSERT INTO `city_area` VALUES ('1606', '1', '保定', '16');
INSERT INTO `city_area` VALUES ('1607', '1', '张家口', '16');
INSERT INTO `city_area` VALUES ('1608', '1', '承德', '16');
INSERT INTO `city_area` VALUES ('1609', '1', '沧州', '16');
INSERT INTO `city_area` VALUES ('1610', '1', '廊坊', '16');
INSERT INTO `city_area` VALUES ('1611', '1', '衡水', '16');
INSERT INTO `city_area` VALUES ('17', '1', '山西省', '0');
INSERT INTO `city_area` VALUES ('1701', '1', '太原', '17');
INSERT INTO `city_area` VALUES ('1702', '1', '大同', '17');
INSERT INTO `city_area` VALUES ('1703', '1', '阳泉', '17');
INSERT INTO `city_area` VALUES ('1704', '1', '长治', '17');
INSERT INTO `city_area` VALUES ('1705', '1', '晋城', '17');
INSERT INTO `city_area` VALUES ('1706', '1', '朔州', '17');
INSERT INTO `city_area` VALUES ('1707', '1', '晋中', '17');
INSERT INTO `city_area` VALUES ('1708', '1', '忻州', '17');
INSERT INTO `city_area` VALUES ('1709', '1', '临汾', '17');
INSERT INTO `city_area` VALUES ('1710', '1', '运城', '17');
INSERT INTO `city_area` VALUES ('1711', '1', '吕梁地区', '17');
INSERT INTO `city_area` VALUES ('19', '1', '吉林省', '0');
INSERT INTO `city_area` VALUES ('1901', '1', '长春', '19');
INSERT INTO `city_area` VALUES ('1902', '1', '吉林', '19');
INSERT INTO `city_area` VALUES ('1903', '1', '四平', '19');
INSERT INTO `city_area` VALUES ('1904', '1', '辽源', '19');
INSERT INTO `city_area` VALUES ('1905', '1', '通化', '19');
INSERT INTO `city_area` VALUES ('1906', '1', '白山', '19');
INSERT INTO `city_area` VALUES ('1907', '1', '松原', '19');
INSERT INTO `city_area` VALUES ('1908', '1', '白城', '19');
INSERT INTO `city_area` VALUES ('1909', '1', '延边自治州', '19');
INSERT INTO `city_area` VALUES ('20', '1', '黑龙江', '0');
INSERT INTO `city_area` VALUES ('2001', '1', '哈尔滨', '20');
INSERT INTO `city_area` VALUES ('2002', '1', '齐齐哈尔', '20');
INSERT INTO `city_area` VALUES ('2003', '1', '鹤岗', '20');
INSERT INTO `city_area` VALUES ('2004', '1', '双鸭山', '20');
INSERT INTO `city_area` VALUES ('2005', '1', '鸡西', '20');
INSERT INTO `city_area` VALUES ('2006', '1', '大庆', '20');
INSERT INTO `city_area` VALUES ('2007', '1', '伊春', '20');
INSERT INTO `city_area` VALUES ('2008', '1', '牡丹江', '20');
INSERT INTO `city_area` VALUES ('2009', '1', '佳木斯', '20');
INSERT INTO `city_area` VALUES ('2010', '1', '七台河', '20');
INSERT INTO `city_area` VALUES ('2011', '1', '黑河', '20');
INSERT INTO `city_area` VALUES ('2012', '1', '绥化', '20');
INSERT INTO `city_area` VALUES ('2013', '1', '大兴安岭', '20');
INSERT INTO `city_area` VALUES ('21', '1', '安徽省', '0');
INSERT INTO `city_area` VALUES ('2101', '1', '合肥', '21');
INSERT INTO `city_area` VALUES ('2102', '1', '芜湖', '21');
INSERT INTO `city_area` VALUES ('2103', '1', '蚌埠', '21');
INSERT INTO `city_area` VALUES ('2104', '1', '淮南', '21');
INSERT INTO `city_area` VALUES ('2105', '1', '马鞍山', '21');
INSERT INTO `city_area` VALUES ('2106', '1', '淮北', '21');
INSERT INTO `city_area` VALUES ('2107', '1', '铜陵', '21');
INSERT INTO `city_area` VALUES ('2108', '1', '安庆', '21');
INSERT INTO `city_area` VALUES ('2109', '1', '黄山', '21');
INSERT INTO `city_area` VALUES ('2110', '1', '滁州', '21');
INSERT INTO `city_area` VALUES ('2111', '1', '阜阳', '21');
INSERT INTO `city_area` VALUES ('2112', '1', '宿州', '21');
INSERT INTO `city_area` VALUES ('2113', '1', '巢湖', '21');
INSERT INTO `city_area` VALUES ('2114', '1', '六安', '21');
INSERT INTO `city_area` VALUES ('2115', '1', '亳州', '21');
INSERT INTO `city_area` VALUES ('2116', '1', '宣城', '21');
INSERT INTO `city_area` VALUES ('2117', '1', '池州', '21');
INSERT INTO `city_area` VALUES ('22', '1', '湖南省', '0');
INSERT INTO `city_area` VALUES ('2201', '1', '长沙', '22');
INSERT INTO `city_area` VALUES ('2202', '1', '株洲', '22');
INSERT INTO `city_area` VALUES ('2203', '1', '湘潭', '22');
INSERT INTO `city_area` VALUES ('2204', '1', '衡阳', '22');
INSERT INTO `city_area` VALUES ('2205', '1', '邵阳', '22');
INSERT INTO `city_area` VALUES ('2206', '1', '岳阳', '22');
INSERT INTO `city_area` VALUES ('2207', '1', '常德', '22');
INSERT INTO `city_area` VALUES ('2208', '1', '张家界', '22');
INSERT INTO `city_area` VALUES ('2209', '1', '益阳', '22');
INSERT INTO `city_area` VALUES ('2210', '1', '郴州', '22');
INSERT INTO `city_area` VALUES ('2211', '1', '永州', '22');
INSERT INTO `city_area` VALUES ('2212', '1', '怀化', '22');
INSERT INTO `city_area` VALUES ('2213', '1', '娄底', '22');
INSERT INTO `city_area` VALUES ('2214', '1', '湘西自治州', '22');
INSERT INTO `city_area` VALUES ('23', '1', '广西区', '0');
INSERT INTO `city_area` VALUES ('2301', '1', '南宁', '23');
INSERT INTO `city_area` VALUES ('2302', '1', '柳州', '23');
INSERT INTO `city_area` VALUES ('2303', '1', '桂林', '23');
INSERT INTO `city_area` VALUES ('2304', '1', '梧州', '23');
INSERT INTO `city_area` VALUES ('2305', '1', '北海', '23');
INSERT INTO `city_area` VALUES ('2306', '1', '防城港', '23');
INSERT INTO `city_area` VALUES ('2307', '1', '钦州', '23');
INSERT INTO `city_area` VALUES ('2308', '1', '贵港', '23');
INSERT INTO `city_area` VALUES ('2309', '1', '玉林', '23');
INSERT INTO `city_area` VALUES ('2310', '1', '南宁地区', '23');
INSERT INTO `city_area` VALUES ('2311', '1', '柳州地区', '23');
INSERT INTO `city_area` VALUES ('2312', '1', '贺州', '23');
INSERT INTO `city_area` VALUES ('2313', '1', '百色', '23');
INSERT INTO `city_area` VALUES ('2314', '1', '河池', '23');
INSERT INTO `city_area` VALUES ('24', '1', '海南省', '0');
INSERT INTO `city_area` VALUES ('2401', '1', '海口', '24');
INSERT INTO `city_area` VALUES ('2402', '1', '三亚', '24');
INSERT INTO `city_area` VALUES ('2403', '1', '五指山', '24');
INSERT INTO `city_area` VALUES ('2404', '1', '琼海', '24');
INSERT INTO `city_area` VALUES ('2405', '1', '儋州', '24');
INSERT INTO `city_area` VALUES ('2406', '1', '琼山', '24');
INSERT INTO `city_area` VALUES ('2407', '1', '文昌', '24');
INSERT INTO `city_area` VALUES ('2408', '1', '万宁', '24');
INSERT INTO `city_area` VALUES ('2409', '1', '东方', '24');
INSERT INTO `city_area` VALUES ('2410', '1', '澄迈县', '24');
INSERT INTO `city_area` VALUES ('2411', '1', '定安县', '24');
INSERT INTO `city_area` VALUES ('2412', '1', '屯昌县', '24');
INSERT INTO `city_area` VALUES ('2413', '1', '临高县', '24');
INSERT INTO `city_area` VALUES ('2414', '1', '白沙县', '24');
INSERT INTO `city_area` VALUES ('2415', '1', '昌江县', '24');
INSERT INTO `city_area` VALUES ('2416', '1', '乐东县', '24');
INSERT INTO `city_area` VALUES ('2417', '1', '陵水县', '24');
INSERT INTO `city_area` VALUES ('2418', '1', '保亭县', '24');
INSERT INTO `city_area` VALUES ('2419', '1', '琼中县', '24');
INSERT INTO `city_area` VALUES ('25', '1', '云南省', '0');
INSERT INTO `city_area` VALUES ('2501', '1', '昆明', '25');
INSERT INTO `city_area` VALUES ('2502', '1', '曲靖', '25');
INSERT INTO `city_area` VALUES ('2503', '1', '玉溪', '25');
INSERT INTO `city_area` VALUES ('2504', '1', '保山', '25');
INSERT INTO `city_area` VALUES ('2505', '1', '昭通', '25');
INSERT INTO `city_area` VALUES ('2506', '1', '思茅地区', '25');
INSERT INTO `city_area` VALUES ('2507', '1', '临沧地区', '25');
INSERT INTO `city_area` VALUES ('2508', '1', '丽江', '25');
INSERT INTO `city_area` VALUES ('2509', '1', '文山自治州', '25');
INSERT INTO `city_area` VALUES ('2510', '1', '红河自治州', '25');
INSERT INTO `city_area` VALUES ('2511', '1', '西双版纳', '25');
INSERT INTO `city_area` VALUES ('2512', '1', '楚雄自治州', '25');
INSERT INTO `city_area` VALUES ('2513', '1', '大理自治州', '25');
INSERT INTO `city_area` VALUES ('2514', '1', '德宏自治州', '25');
INSERT INTO `city_area` VALUES ('2515', '1', '怒江自治州', '25');
INSERT INTO `city_area` VALUES ('2516', '1', '迪庆自治州', '25');
INSERT INTO `city_area` VALUES ('26', '1', '贵州省', '0');
INSERT INTO `city_area` VALUES ('2601', '1', '贵阳', '26');
INSERT INTO `city_area` VALUES ('2602', '1', '六盘水', '26');
INSERT INTO `city_area` VALUES ('2603', '1', '遵义', '26');
INSERT INTO `city_area` VALUES ('2604', '1', '安顺', '26');
INSERT INTO `city_area` VALUES ('2605', '1', '铜仁地区', '26');
INSERT INTO `city_area` VALUES ('2606', '1', '毕节地区', '26');
INSERT INTO `city_area` VALUES ('2607', '1', '黔西南州', '26');
INSERT INTO `city_area` VALUES ('2608', '1', '黔东南州', '26');
INSERT INTO `city_area` VALUES ('2609', '1', '黔南自治州', '26');
INSERT INTO `city_area` VALUES ('2701', '1', '拉萨', '27');
INSERT INTO `city_area` VALUES ('2702', '1', '那曲地区', '27');
INSERT INTO `city_area` VALUES ('2703', '1', '昌都地区', '27');
INSERT INTO `city_area` VALUES ('2704', '1', '山南地区', '27');
INSERT INTO `city_area` VALUES ('2705', '1', '日喀则', '27');
INSERT INTO `city_area` VALUES ('2706', '1', '阿里地区', '27');
INSERT INTO `city_area` VALUES ('2707', '1', '林芝地区', '27');
INSERT INTO `city_area` VALUES ('28', '1', '甘肃省', '0');
INSERT INTO `city_area` VALUES ('2801', '1', '兰州', '28');
INSERT INTO `city_area` VALUES ('2802', '1', '金昌', '28');
INSERT INTO `city_area` VALUES ('2803', '1', '白银', '28');
INSERT INTO `city_area` VALUES ('2804', '1', '天水', '28');
INSERT INTO `city_area` VALUES ('2805', '1', '嘉峪关', '28');
INSERT INTO `city_area` VALUES ('2806', '1', '武威', '28');
INSERT INTO `city_area` VALUES ('2807', '1', '定西', '28');
INSERT INTO `city_area` VALUES ('2808', '1', '平凉', '28');
INSERT INTO `city_area` VALUES ('2809', '1', '庆阳', '28');
INSERT INTO `city_area` VALUES ('2810', '1', '陇南地区', '28');
INSERT INTO `city_area` VALUES ('2811', '1', '张掖', '28');
INSERT INTO `city_area` VALUES ('2812', '1', '酒泉', '28');
INSERT INTO `city_area` VALUES ('2813', '1', '甘南自治州', '28');
INSERT INTO `city_area` VALUES ('2814', '1', '临夏自治州', '28');
INSERT INTO `city_area` VALUES ('3101', '1', '乌鲁木齐', '31');
INSERT INTO `city_area` VALUES ('3102', '1', '克拉玛依', '31');
INSERT INTO `city_area` VALUES ('3103', '1', '石河子', '31');
INSERT INTO `city_area` VALUES ('3104', '1', '吐鲁番地区', '31');
INSERT INTO `city_area` VALUES ('3105', '1', '哈密地区', '31');
INSERT INTO `city_area` VALUES ('3106', '1', '和田地区', '31');
INSERT INTO `city_area` VALUES ('3107', '1', '阿克苏地区', '31');
INSERT INTO `city_area` VALUES ('3108', '1', '喀什地区', '31');
INSERT INTO `city_area` VALUES ('3109', '1', '克孜勒苏', '31');
INSERT INTO `city_area` VALUES ('3110', '1', '巴音郭楞', '31');
INSERT INTO `city_area` VALUES ('3111', '1', '昌吉自治州', '31');
INSERT INTO `city_area` VALUES ('3112', '1', '博尔塔拉', '31');
INSERT INTO `city_area` VALUES ('3113', '1', '伊犁州', '31');
INSERT INTO `city_area` VALUES ('3117', '1', '东城区', '1');
INSERT INTO `city_area` VALUES ('35', '1', '台湾省', '0');
INSERT INTO `city_area` VALUES ('3118', '1', '高雄', '35');
INSERT INTO `city_area` VALUES ('3119', '1', '台北', '35');
INSERT INTO `city_area` VALUES ('3120', '1', '嘉义', '35');
INSERT INTO `city_area` VALUES ('3121', '1', '新竹', '35');
INSERT INTO `city_area` VALUES ('3122', '1', '台南', '35');
INSERT INTO `city_area` VALUES ('3123', '1', '台中', '35');
INSERT INTO `city_area` VALUES ('3124', '1', '基隆', '35');
INSERT INTO `city_area` VALUES ('918', '1', '招远', '9');
INSERT INTO `city_area` VALUES ('919', '1', '龙口', '9');
INSERT INTO `city_area` VALUES ('36', '1', '内蒙古', '0');
INSERT INTO `city_area` VALUES ('3601', '1', '呼和浩特', '36');
INSERT INTO `city_area` VALUES ('3602', '1', '包头', '36');
INSERT INTO `city_area` VALUES ('3603', '1', '乌海', '36');
INSERT INTO `city_area` VALUES ('3604', '1', '赤峰', '36');
INSERT INTO `city_area` VALUES ('3605', '1', '通辽', '36');
INSERT INTO `city_area` VALUES ('3606', '1', '鄂尔多斯', '36');
INSERT INTO `city_area` VALUES ('3607', '1', '呼伦贝尔', '36');
INSERT INTO `city_area` VALUES ('3608', '1', '巴彦淖尔盟', '36');
INSERT INTO `city_area` VALUES ('3609', '1', '乌兰察布盟', '36');
INSERT INTO `city_area` VALUES ('3610', '1', '锡林郭勒盟', '36');
INSERT INTO `city_area` VALUES ('3611', '1', '兴安盟', '36');
INSERT INTO `city_area` VALUES ('3612', '1', '阿拉善盟', '36');
INSERT INTO `city_area` VALUES ('37', '1', '宁夏', '0');
INSERT INTO `city_area` VALUES ('3701', '1', '银川', '37');
INSERT INTO `city_area` VALUES ('3702', '1', '石嘴山', '37');
INSERT INTO `city_area` VALUES ('3703', '1', '吴忠', '37');
INSERT INTO `city_area` VALUES ('3704', '1', '固原', '37');
INSERT INTO `city_area` VALUES ('3705', '1', '中卫', '37');
INSERT INTO `city_area` VALUES ('38', '1', '青海省', '0');
INSERT INTO `city_area` VALUES ('3801', '1', '西宁', '38');
INSERT INTO `city_area` VALUES ('3802', '1', '海东地区', '38');
INSERT INTO `city_area` VALUES ('3803', '1', '海北', '38');
INSERT INTO `city_area` VALUES ('3804', '1', '黄南自治州', '38');
INSERT INTO `city_area` VALUES ('3805', '1', '果洛自治州', '38');
INSERT INTO `city_area` VALUES ('3806', '1', '玉树自治州', '38');
INSERT INTO `city_area` VALUES ('3807', '1', '海西自治州', '38');
INSERT INTO `city_area` VALUES ('39', '1', '西藏', '0');
INSERT INTO `city_area` VALUES ('3901', '1', '拉萨', '39');
INSERT INTO `city_area` VALUES ('3902', '1', '那曲地区', '39');
INSERT INTO `city_area` VALUES ('3903', '1', '昌都地区', '39');
INSERT INTO `city_area` VALUES ('3904', '1', '山南地区', '39');
INSERT INTO `city_area` VALUES ('3905', '1', '日喀则地区', '39');
INSERT INTO `city_area` VALUES ('3906', '1', '阿里地区', '39');
INSERT INTO `city_area` VALUES ('3907', '1', '林芝地区', '39');
INSERT INTO `city_area` VALUES ('40', '1', '香港', '0');
INSERT INTO `city_area` VALUES ('4001', '1', '香港', '40');
INSERT INTO `city_area` VALUES ('41', '1', '澳门', '0');
INSERT INTO `city_area` VALUES ('4101', '1', '澳门', '41');
INSERT INTO `city_area` VALUES ('42', '1', '新疆', '0');
INSERT INTO `city_area` VALUES ('4201', '1', '乌鲁木齐', '42');
INSERT INTO `city_area` VALUES ('4202', '1', '克拉玛依', '42');
INSERT INTO `city_area` VALUES ('4203', '1', '石河子', '42');
INSERT INTO `city_area` VALUES ('4204', '1', '阿拉尔', '42');
INSERT INTO `city_area` VALUES ('4205', '1', '图木舒克', '42');
INSERT INTO `city_area` VALUES ('4206', '1', '五家渠', '42');
INSERT INTO `city_area` VALUES ('4207', '1', '吐鲁番地区', '42');
INSERT INTO `city_area` VALUES ('4208', '1', '阿克苏地区', '42');
INSERT INTO `city_area` VALUES ('4209', '1', '喀什地区', '42');
INSERT INTO `city_area` VALUES ('4210', '1', '哈密地区', '42');
INSERT INTO `city_area` VALUES ('4211', '1', '和田地区', '42');
INSERT INTO `city_area` VALUES ('4212', '1', '阿图什', '42');
INSERT INTO `city_area` VALUES ('4213', '1', '库尔勒', '42');
INSERT INTO `city_area` VALUES ('4214', '1', '昌吉自治州', '42');
INSERT INTO `city_area` VALUES ('4215', '1', '阜康', '42');
INSERT INTO `city_area` VALUES ('4216', '1', '米泉', '42');
INSERT INTO `city_area` VALUES ('4217', '1', '博乐', '42');
INSERT INTO `city_area` VALUES ('4218', '1', '伊宁', '42');
INSERT INTO `city_area` VALUES ('4219', '1', '奎屯', '42');
INSERT INTO `city_area` VALUES ('4220', '1', '塔城地区', '42');
INSERT INTO `city_area` VALUES ('4221', '1', '乌苏', '42');
INSERT INTO `city_area` VALUES ('4222', '1', '阿勒泰地区', '42');
INSERT INTO `city_area` VALUES ('2517', '1', '普洱', '25');
INSERT INTO `city_area` VALUES ('2315', '1', '来宾', '23');
INSERT INTO `city_area` VALUES ('2316', '1', '崇左', '23');
INSERT INTO `city_area` VALUES ('2420', '1', '三沙', '24');
INSERT INTO `city_area` VALUES ('4223', '1', '博尔塔拉', '42');
INSERT INTO `city_area` VALUES ('4224', '1', '巴音郭楞', '42');
INSERT INTO `city_area` VALUES ('4225', '1', '克孜勒苏', '42');
INSERT INTO `city_area` VALUES ('4226', '1', '伊犁自治州', '42');
INSERT INTO `city_area` VALUES ('3808', '1', '海南自治州', '38');
INSERT INTO `city_area` VALUES ('4227', '1', '襄阳', '14');

-- ----------------------------
-- Table structure for `cli`
-- ----------------------------
DROP TABLE IF EXISTS `cli`;
CREATE TABLE `cli` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(90) NOT NULL,
  `company_no` varchar(20) NOT NULL DEFAULT '' COMMENT '编号',
  `source` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `detailed` varchar(90) NOT NULL DEFAULT '' COMMENT '详细地址',
  `follow` int(11) NOT NULL COMMENT '跟踪周期',
  `add_time` int(11) NOT NULL,
  `dr` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 COMMENT='客户表';

-- ----------------------------
-- Records of cli
-- ----------------------------
INSERT INTO `cli` VALUES ('106', '北京小戴公司', '001', '1', '1', '1', '106', '详细地址详细地址', '5', '0', '0');
INSERT INTO `cli` VALUES ('107', '北京小戴公司', '001', '1', '1', '1', '106', '详细地址详细地址', '5', '0', '0');
INSERT INTO `cli` VALUES ('108', '32123', '12321', '2', '1', '1', '102', '123321', '123321', '0', '0');
INSERT INTO `cli` VALUES ('109', '123', '123', '1', '1', '3', '309', '123', '123', '0', '0');
INSERT INTO `cli` VALUES ('110', 'asd', 'ad', '1', '1', '15', '1511', 'asdad', '1', '0', '0');
INSERT INTO `cli` VALUES ('111', '123321', '123321', '1', '1', '14', '1411', '12321', '23321', '1431086974', '0');
INSERT INTO `cli` VALUES ('112', '123321', '123321', '1', '1', '0', '0', '12321', '23321', '1431087016', '0');
INSERT INTO `cli` VALUES ('113', '123321', '123321', '1', '0', '0', '0', '123321', '123321', '1431087136', '0');
INSERT INTO `cli` VALUES ('114', '涨写好', '88978', '2', '1', '3', '318', '调试阿斯顿覅偶多耗费', '10', '1431091686', '0');
INSERT INTO `cli` VALUES ('115', '123321', '123321', '3', '1', '17', '1703', '3333333333333333', '2147483647', '1431094677', '0');
INSERT INTO `cli` VALUES ('116', '赵本山', '1591431421809', '2', '1', '6', '604', '详细地址详细地址详细地址详细地址', '12', '1431422055', '0');
INSERT INTO `cli` VALUES ('117', '123321', '7571431424668', '2', '0', '0', '0', '12321', '2321', '1431424688', '0');
INSERT INTO `cli` VALUES ('118', '123321', '5071431426435', '2', '0', '0', '0', '12321', '2321', '1431426441', '0');
INSERT INTO `cli` VALUES ('119', '123321', '5071431426435', '2', '0', '0', '0', '12321', '2321', '1431426483', '0');
INSERT INTO `cli` VALUES ('120', '123321', '5071431426435', '2', '0', '0', '0', '12321', '2321', '1431426556', '0');
INSERT INTO `cli` VALUES ('121', '123321', '5071431426435', '2', '0', '0', '0', '12321', '2321', '1431426591', '0');
INSERT INTO `cli` VALUES ('122', '12321', '1321431426821', '2', '0', '0', '0', '', '12321', '1431426831', '0');

-- ----------------------------
-- Table structure for `cli_follow`
-- ----------------------------
DROP TABLE IF EXISTS `cli_follow`;
CREATE TABLE `cli_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` int(11) NOT NULL,
  `follow_time` int(11) NOT NULL,
  `follow_type` int(11) NOT NULL,
  `link_type` int(11) NOT NULL,
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
INSERT INTO `cli_follow` VALUES ('36', '122', '1432224000', '0', '0', '', '1');

-- ----------------------------
-- Table structure for `cli_link`
-- ----------------------------
DROP TABLE IF EXISTS `cli_link`;
CREATE TABLE `cli_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cli_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `sex` tinyint(4) NOT NULL,
  `bir` varchar(30) NOT NULL DEFAULT '',
  `position` varchar(30) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  `tele` varchar(20) NOT NULL DEFAULT '',
  `private_email` varchar(60) NOT NULL DEFAULT '',
  `com_email` varchar(60) NOT NULL DEFAULT '',
  `fax` varchar(20) NOT NULL DEFAULT '',
  `web` varchar(100) NOT NULL DEFAULT '',
  `work_address` varchar(300) NOT NULL DEFAULT '',
  `adderss` varchar(300) NOT NULL,
  `bak` varchar(600) NOT NULL,
  `insert_type` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COMMENT='联系人信息';

-- ----------------------------
-- Records of cli_link
-- ----------------------------
INSERT INTO `cli_link` VALUES ('127', '108', '123', '123', '123', '13', '123', '123', '123', '123', '123', '123', '1231', '123', '123', '0');
INSERT INTO `cli_link` VALUES ('128', '108', '123', '123', '123', '13', '123', '123', '123', '123', '123', '123', '1231', '123', '123', '0');
INSERT INTO `cli_link` VALUES ('129', '109', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '0');
INSERT INTO `cli_link` VALUES ('130', '109', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '123', '0');
INSERT INTO `cli_link` VALUES ('131', '110', '123219', '127', '123219', '23219', '123219', '239', '123219', '21239', '2139', '1239', '3219', '1239', '123321123ddddddd9', '1');
INSERT INTO `cli_link` VALUES ('132', '113', '123321', '0', '', '', '123321', '', '', '', '', '', '', '', '', '1');
INSERT INTO `cli_link` VALUES ('133', '114', '董事长123', '127', '123321123', '32123', '32123', '32123', '32123', '32123', '32123', '2123212321', '1233212321', '232123213213', '阿斯顿发达对方答复答复阿斯蒂芬', '1');
INSERT INTO `cli_link` VALUES ('134', '110', '', '0', '', '', '', '', '', '', '', '', '', '', '', '1');
INSERT INTO `cli_link` VALUES ('135', '115', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '12', '0');
INSERT INTO `cli_link` VALUES ('136', '115', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '2', '0');
INSERT INTO `cli_link` VALUES ('137', '116', '12321', '2', '', '', '1311111', '', '', '', '', '', '', '', '&lt;p&gt;123213333333333&lt;br/&gt;&lt;/p&gt;', '1');
INSERT INTO `cli_link` VALUES ('138', '117', '23212321', '1', '', '', '1321321', '', '', '', '', '', '', '', '', '1');
INSERT INTO `cli_link` VALUES ('139', '122', '123321', '1', '', '', '12321', '', '', '', '', '', '', '', '', '1');
INSERT INTO `cli_link` VALUES ('140', '122', '123321', '1', '', '', '12321', '', '', '', '', '', '', '', '', '1');

-- ----------------------------
-- Table structure for `country`
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(30) NOT NULL DEFAULT '',
  `en_country` varchar(100) DEFAULT '',
  `ch` varchar(5) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=222 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', '中国', '', 'Z');
INSERT INTO `country` VALUES ('2', '蒙古', '', 'M');
INSERT INTO `country` VALUES ('3', '朝鲜', '', 'C');
INSERT INTO `country` VALUES ('4', '韩国', '', 'H');
INSERT INTO `country` VALUES ('5', '日本', '', 'R');
INSERT INTO `country` VALUES ('6', '菲律宾', '', 'F');
INSERT INTO `country` VALUES ('7', '越南', '', 'Y');
INSERT INTO `country` VALUES ('8', '老挝', '', 'L');
INSERT INTO `country` VALUES ('9', '柬埔寨', '', 'J');
INSERT INTO `country` VALUES ('10', '缅甸', '', 'M');
INSERT INTO `country` VALUES ('11', '泰国', '', 'T');
INSERT INTO `country` VALUES ('12', '马来西亚', '', 'M');
INSERT INTO `country` VALUES ('13', '文莱', '', 'W');
INSERT INTO `country` VALUES ('14', '新加坡', '', 'X');
INSERT INTO `country` VALUES ('15', '印度尼西亚', '', 'Y');
INSERT INTO `country` VALUES ('16', '东帝汶', '', 'D');
INSERT INTO `country` VALUES ('17', '尼泊尔', '', 'N');
INSERT INTO `country` VALUES ('18', '不丹', '', 'B');
INSERT INTO `country` VALUES ('19', '孟加拉国', '', 'M');
INSERT INTO `country` VALUES ('20', '印度', '', 'Y');
INSERT INTO `country` VALUES ('21', '巴基斯坦', '', 'B');
INSERT INTO `country` VALUES ('22', '斯里兰卡', '', 'S');
INSERT INTO `country` VALUES ('23', '马尔代夫', '', 'M');
INSERT INTO `country` VALUES ('24', '哈萨克斯坦', '', 'H');
INSERT INTO `country` VALUES ('25', '吉尔吉斯斯坦', '', 'J');
INSERT INTO `country` VALUES ('26', '塔吉克斯坦', '', 'T');
INSERT INTO `country` VALUES ('27', '乌兹别克斯坦', '', 'W');
INSERT INTO `country` VALUES ('28', '土库曼斯坦', '', 'T');
INSERT INTO `country` VALUES ('29', '阿富汗', '', 'A');
INSERT INTO `country` VALUES ('30', '伊拉克', '', 'Y');
INSERT INTO `country` VALUES ('31', '伊朗', '', 'Y');
INSERT INTO `country` VALUES ('32', '叙利亚', '', 'X');
INSERT INTO `country` VALUES ('33', '约旦', '', 'Y');
INSERT INTO `country` VALUES ('34', '黎巴嫩', '', 'L');
INSERT INTO `country` VALUES ('35', '以色列', '', 'Y');
INSERT INTO `country` VALUES ('36', '巴勒斯坦', '', 'B');
INSERT INTO `country` VALUES ('37', '沙特阿拉伯', '', 'S');
INSERT INTO `country` VALUES ('38', '巴林', '', 'B');
INSERT INTO `country` VALUES ('39', '卡塔尔', '', 'K');
INSERT INTO `country` VALUES ('40', '科威特', '', 'K');
INSERT INTO `country` VALUES ('41', '阿拉伯联合酋长国（阿联酋）', '', 'A');
INSERT INTO `country` VALUES ('42', '阿曼', '', 'A');
INSERT INTO `country` VALUES ('43', '也门', '', 'Y');
INSERT INTO `country` VALUES ('44', '格鲁吉亚', '', 'G');
INSERT INTO `country` VALUES ('45', '亚美尼亚', '', 'Y');
INSERT INTO `country` VALUES ('46', '阿塞拜疆', '', 'A');
INSERT INTO `country` VALUES ('47', '土耳其', '', 'T');
INSERT INTO `country` VALUES ('48', '塞浦路斯', '', 'S');
INSERT INTO `country` VALUES ('49', '芬兰', '', 'F');
INSERT INTO `country` VALUES ('50', '瑞典', '', 'R');
INSERT INTO `country` VALUES ('51', '挪威', '', 'N');
INSERT INTO `country` VALUES ('52', '冰岛', '', 'B');
INSERT INTO `country` VALUES ('53', '丹麦 法罗群岛（丹）', '', 'D');
INSERT INTO `country` VALUES ('54', '爱沙尼亚', '', 'A');
INSERT INTO `country` VALUES ('55', '拉脱维亚', '', 'L');
INSERT INTO `country` VALUES ('56', '立陶宛', '', 'L');
INSERT INTO `country` VALUES ('57', '白俄罗斯', '', 'B');
INSERT INTO `country` VALUES ('58', '俄罗斯', '', 'E');
INSERT INTO `country` VALUES ('59', '乌克兰', '', 'W');
INSERT INTO `country` VALUES ('60', '摩尔多瓦', '', 'M');
INSERT INTO `country` VALUES ('61', '波兰', '', 'B');
INSERT INTO `country` VALUES ('62', '捷克', '', 'J');
INSERT INTO `country` VALUES ('63', '斯洛伐克', '', 'S');
INSERT INTO `country` VALUES ('64', '匈牙利', '', 'X');
INSERT INTO `country` VALUES ('65', '德国', '', 'D');
INSERT INTO `country` VALUES ('66', '奥地利', '', 'A');
INSERT INTO `country` VALUES ('67', '瑞士', '', 'R');
INSERT INTO `country` VALUES ('68', '列支敦士登', '', 'L');
INSERT INTO `country` VALUES ('69', '英国', '', 'Y');
INSERT INTO `country` VALUES ('70', '爱尔兰', '', 'A');
INSERT INTO `country` VALUES ('71', '荷兰', '', 'H');
INSERT INTO `country` VALUES ('72', '比利时', '', 'B');
INSERT INTO `country` VALUES ('73', '卢森堡', '', 'L');
INSERT INTO `country` VALUES ('74', '法国', '', 'F');
INSERT INTO `country` VALUES ('75', '摩纳哥', '', 'M');
INSERT INTO `country` VALUES ('76', '罗马尼亚', '', 'L');
INSERT INTO `country` VALUES ('77', '保加利亚', '', 'B');
INSERT INTO `country` VALUES ('78', '塞尔维亚', '', 'S');
INSERT INTO `country` VALUES ('79', '马其顿', '', 'M');
INSERT INTO `country` VALUES ('80', '阿尔巴尼亚', '', 'A');
INSERT INTO `country` VALUES ('81', '希腊', '', 'X');
INSERT INTO `country` VALUES ('82', '斯洛文尼亚', '', 'S');
INSERT INTO `country` VALUES ('83', '克罗地亚', '', 'K');
INSERT INTO `country` VALUES ('84', '波斯尼亚和墨塞哥维那', '', 'B');
INSERT INTO `country` VALUES ('85', '意大利', '', 'Y');
INSERT INTO `country` VALUES ('86', '梵蒂冈', '', null);
INSERT INTO `country` VALUES ('87', '圣马力诺', '', 'S');
INSERT INTO `country` VALUES ('88', '马耳他', '', 'M');
INSERT INTO `country` VALUES ('89', '西班牙', '', 'X');
INSERT INTO `country` VALUES ('90', '葡萄牙', '', 'P');
INSERT INTO `country` VALUES ('91', '安道尔', '', 'A');
INSERT INTO `country` VALUES ('92', '埃及', '', 'A');
INSERT INTO `country` VALUES ('93', '利比亚', '', 'L');
INSERT INTO `country` VALUES ('94', '苏丹', '', 'S');
INSERT INTO `country` VALUES ('95', '突尼斯', '', 'T');
INSERT INTO `country` VALUES ('96', '阿尔及利亚', '', 'A');
INSERT INTO `country` VALUES ('97', '摩洛哥', '', 'M');
INSERT INTO `country` VALUES ('98', '亚速尔群岛（葡）', '', 'Y');
INSERT INTO `country` VALUES ('99', '马德拉群岛（葡）', '', 'M');
INSERT INTO `country` VALUES ('100', '埃塞俄比亚', '', 'A');
INSERT INTO `country` VALUES ('101', '厄立特里亚', '', 'E');
INSERT INTO `country` VALUES ('102', '索马里', '', 'S');
INSERT INTO `country` VALUES ('103', '吉布提', '', 'J');
INSERT INTO `country` VALUES ('104', '肯尼亚', '', 'K');
INSERT INTO `country` VALUES ('105', '坦桑尼亚', '', 'T');
INSERT INTO `country` VALUES ('106', '乌干达', '', 'W');
INSERT INTO `country` VALUES ('107', '卢旺达', '', 'L');
INSERT INTO `country` VALUES ('108', '布隆迪', '', 'B');
INSERT INTO `country` VALUES ('109', '塞舌尔', '', 'S');
INSERT INTO `country` VALUES ('110', '乍得', '', 'Z');
INSERT INTO `country` VALUES ('111', '中非', '', 'Z');
INSERT INTO `country` VALUES ('112', '喀麦隆', '', 'K');
INSERT INTO `country` VALUES ('113', '赤道几内亚', '', 'C');
INSERT INTO `country` VALUES ('114', '加蓬', '', 'J');
INSERT INTO `country` VALUES ('115', '刚果共和国（即：刚果（布））', '', 'G');
INSERT INTO `country` VALUES ('116', '刚果民主共和国（即：刚果（金））', '', 'G');
INSERT INTO `country` VALUES ('117', '圣多美及普林西比', '', 'S');
INSERT INTO `country` VALUES ('118', '毛里塔尼亚', '', 'M');
INSERT INTO `country` VALUES ('119', '西撒哈拉（注：未独立，详细请看：）', '', 'X');
INSERT INTO `country` VALUES ('120', '塞内加尔', '', 'S');
INSERT INTO `country` VALUES ('121', '冈比亚', '', 'G');
INSERT INTO `country` VALUES ('122', '马里', '', 'M');
INSERT INTO `country` VALUES ('123', '布基纳法索', '', 'B');
INSERT INTO `country` VALUES ('124', '几内亚', '', 'J');
INSERT INTO `country` VALUES ('125', '几内亚比绍', '', 'J');
INSERT INTO `country` VALUES ('126', '佛得角', '', 'F');
INSERT INTO `country` VALUES ('127', '塞拉利昂', '', 'S');
INSERT INTO `country` VALUES ('128', '利比里亚', '', 'L');
INSERT INTO `country` VALUES ('129', '科特迪瓦', '', 'K');
INSERT INTO `country` VALUES ('130', '加纳', '', 'J');
INSERT INTO `country` VALUES ('131', '多哥', '', 'D');
INSERT INTO `country` VALUES ('132', '贝宁', '', 'B');
INSERT INTO `country` VALUES ('133', '尼日尔', '', 'N');
INSERT INTO `country` VALUES ('134', '加那利群岛（西）', '', 'J');
INSERT INTO `country` VALUES ('135', '赞比亚', '', 'Z');
INSERT INTO `country` VALUES ('136', '安哥拉', '', 'A');
INSERT INTO `country` VALUES ('137', '津巴布韦', '', 'J');
INSERT INTO `country` VALUES ('138', '马拉维', '', 'M');
INSERT INTO `country` VALUES ('139', '莫桑比克', '', 'M');
INSERT INTO `country` VALUES ('140', '博茨瓦纳', '', 'B');
INSERT INTO `country` VALUES ('141', '纳米比亚', '', 'N');
INSERT INTO `country` VALUES ('142', '南非', '', 'N');
INSERT INTO `country` VALUES ('143', '斯威士兰', '', 'S');
INSERT INTO `country` VALUES ('144', '莱索托', '', 'L');
INSERT INTO `country` VALUES ('145', '马达加斯加', '', 'M');
INSERT INTO `country` VALUES ('146', '科摩罗', '', 'K');
INSERT INTO `country` VALUES ('147', '毛里求斯', '', 'M');
INSERT INTO `country` VALUES ('148', '留尼旺（法）', '', 'L');
INSERT INTO `country` VALUES ('149', '圣赫勒拿（英）澳大利亚', '', 'S');
INSERT INTO `country` VALUES ('150', '新西兰', '', 'X');
INSERT INTO `country` VALUES ('151', '巴布亚新几内亚', '', 'B');
INSERT INTO `country` VALUES ('152', '所罗门群岛', '', 'S');
INSERT INTO `country` VALUES ('153', '瓦努阿图', '', 'W');
INSERT INTO `country` VALUES ('154', '密克罗尼西亚', '', 'M');
INSERT INTO `country` VALUES ('155', '马绍尔群岛', '', 'M');
INSERT INTO `country` VALUES ('156', '帕劳', '', 'P');
INSERT INTO `country` VALUES ('157', '瑙鲁', '', null);
INSERT INTO `country` VALUES ('158', '基里巴斯', '', 'J');
INSERT INTO `country` VALUES ('159', '图瓦卢', '', 'T');
INSERT INTO `country` VALUES ('160', '萨摩亚', '', 'S');
INSERT INTO `country` VALUES ('161', '斐济群岛', '', null);
INSERT INTO `country` VALUES ('162', '汤加', '', 'T');
INSERT INTO `country` VALUES ('163', '库克群岛（新）', '', 'K');
INSERT INTO `country` VALUES ('164', '关岛（美）', '', 'G');
INSERT INTO `country` VALUES ('165', '新喀里多尼亚（法）', '', 'X');
INSERT INTO `country` VALUES ('166', '法属波利尼西亚', '', 'F');
INSERT INTO `country` VALUES ('167', '皮特凯恩岛（英）', '', 'P');
INSERT INTO `country` VALUES ('168', '瓦利斯与富图纳（法）', '', 'W');
INSERT INTO `country` VALUES ('169', '纽埃（新）', '', 'N');
INSERT INTO `country` VALUES ('170', '托克劳（新）', '', 'T');
INSERT INTO `country` VALUES ('171', '美属萨摩亚', '', 'M');
INSERT INTO `country` VALUES ('172', '北马里亚纳（美）', '', 'B');
INSERT INTO `country` VALUES ('173', '加拿大', '', 'J');
INSERT INTO `country` VALUES ('174', '美国', '', 'M');
INSERT INTO `country` VALUES ('175', '墨西哥', '', 'M');
INSERT INTO `country` VALUES ('176', '格陵兰（丹）', '', 'G');
INSERT INTO `country` VALUES ('177', '危地马拉', '', 'W');
INSERT INTO `country` VALUES ('178', '伯利兹', '', 'B');
INSERT INTO `country` VALUES ('179', '萨尔瓦多', '', 'S');
INSERT INTO `country` VALUES ('180', '洪都拉斯', '', 'H');
INSERT INTO `country` VALUES ('181', '尼加拉瓜', '', 'N');
INSERT INTO `country` VALUES ('182', '哥斯达黎加', '', 'G');
INSERT INTO `country` VALUES ('183', '巴拿马', '', 'B');
INSERT INTO `country` VALUES ('184', '巴哈马', '', 'B');
INSERT INTO `country` VALUES ('185', '古巴', '', 'G');
INSERT INTO `country` VALUES ('186', '牙买加', '', 'Y');
INSERT INTO `country` VALUES ('187', '海地', '', 'H');
INSERT INTO `country` VALUES ('188', '多米尼加共和国', '', 'D');
INSERT INTO `country` VALUES ('189', '安提瓜和巴布达', '', 'A');
INSERT INTO `country` VALUES ('190', '圣基茨和尼维斯', '', 'S');
INSERT INTO `country` VALUES ('191', '多米尼克', '', 'D');
INSERT INTO `country` VALUES ('192', '圣卢西亚', '', 'S');
INSERT INTO `country` VALUES ('193', '圣文森特和格林纳丁斯', '', 'S');
INSERT INTO `country` VALUES ('194', '格林纳达', '', 'G');
INSERT INTO `country` VALUES ('195', '巴巴多斯', '', 'B');
INSERT INTO `country` VALUES ('196', '特立尼达和多巴哥', '', 'T');
INSERT INTO `country` VALUES ('197', '波多黎各（美）', '', 'B');
INSERT INTO `country` VALUES ('198', '英属维尔京群岛', '', 'Y');
INSERT INTO `country` VALUES ('199', '美属维尔京群岛', '', 'M');
INSERT INTO `country` VALUES ('200', '安圭拉（英）', '', 'A');
INSERT INTO `country` VALUES ('201', '蒙特塞拉特（英）', '', 'M');
INSERT INTO `country` VALUES ('202', '瓜德罗普（法）', '', 'G');
INSERT INTO `country` VALUES ('203', '马提尼克（法）', '', 'M');
INSERT INTO `country` VALUES ('204', '荷属安的列斯', '', 'H');
INSERT INTO `country` VALUES ('205', '阿鲁巴（荷）', '', 'A');
INSERT INTO `country` VALUES ('206', '特克斯和凯科斯群岛（英）', '', 'T');
INSERT INTO `country` VALUES ('207', '开曼群岛（英）', '', 'K');
INSERT INTO `country` VALUES ('208', '百慕大（英）', '', 'B');
INSERT INTO `country` VALUES ('209', '哥伦比亚', '', 'G');
INSERT INTO `country` VALUES ('210', '委内瑞拉', '', 'W');
INSERT INTO `country` VALUES ('211', '圭亚那', '', 'G');
INSERT INTO `country` VALUES ('212', '法属圭亚那', '', 'F');
INSERT INTO `country` VALUES ('213', '苏里南', '', 'S');
INSERT INTO `country` VALUES ('214', '厄瓜多尔', '', 'E');
INSERT INTO `country` VALUES ('215', '秘鲁', '', 'M');
INSERT INTO `country` VALUES ('216', '玻利维亚', '', 'B');
INSERT INTO `country` VALUES ('217', '巴西', '', 'B');
INSERT INTO `country` VALUES ('218', '智利', '', 'Z');
INSERT INTO `country` VALUES ('219', '阿根廷', '', 'A');
INSERT INTO `country` VALUES ('220', '乌拉圭', '', 'W');
INSERT INTO `country` VALUES ('221', '巴拉圭', '', 'B');

-- ----------------------------
-- Table structure for `follow_comment`
-- ----------------------------
DROP TABLE IF EXISTS `follow_comment`;
CREATE TABLE `follow_comment` (
  `id` int(11) NOT NULL,
  `follow_id` int(11) NOT NULL,
  `score` tinyint(4) NOT NULL COMMENT '点评分数',
  `comment` varchar(1500) NOT NULL DEFAULT '' COMMENT '点评内容',
  `Leader_id` int(11) NOT NULL COMMENT '点评人',
  ` time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of follow_comment
-- ----------------------------
