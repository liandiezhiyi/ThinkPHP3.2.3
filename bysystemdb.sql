/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : bysystemdb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-09-21 14:10:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yzx_access`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_access`;
CREATE TABLE `yzx_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yzx_access
-- ----------------------------
INSERT INTO `yzx_access` VALUES ('1', '2');
INSERT INTO `yzx_access` VALUES ('3', '2');
INSERT INTO `yzx_access` VALUES ('7', '1');
INSERT INTO `yzx_access` VALUES ('23', '11');
INSERT INTO `yzx_access` VALUES ('27', '1');
INSERT INTO `yzx_access` VALUES ('29', '13');
INSERT INTO `yzx_access` VALUES ('30', '13');

-- ----------------------------
-- Table structure for `yzx_business`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_business`;
CREATE TABLE `yzx_business` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `business_uuid` varchar(255) DEFAULT NULL COMMENT '(登记编号)',
  `business_dname` varchar(255) DEFAULT NULL COMMENT '逝者姓名',
  `business_dsex` varchar(255) DEFAULT NULL COMMENT '逝者性别',
  `business_dage` varchar(255) DEFAULT NULL COMMENT '逝者年龄',
  `business_conclusion` int(10) NOT NULL COMMENT '(死因)(yzx_conclusion表中的ID)',
  `business_dtime` int(11) DEFAULT NULL COMMENT '死亡时间',
  `business_didplace` varchar(255) DEFAULT NULL COMMENT '接灵地点',
  `business_dree` varchar(255) DEFAULT NULL COMMENT '逝者户籍地址',
  `business_dplace` varchar(255) DEFAULT NULL COMMENT '接灵时间',
  `business_createtime` int(11) DEFAULT NULL COMMENT '登记日期',
  `business_isfinish` varchar(255) DEFAULT NULL COMMENT '(是否结清) 0.否 1.是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_business
-- ----------------------------
INSERT INTO `yzx_business` VALUES ('1', '1559894248', '某某某', '1', '20', '1', '1559894248', '山卡卡', '农村', '1559894248', '1559894248', '0');
INSERT INTO `yzx_business` VALUES ('2', '1559894249', '王某某', '2', '21', '2', '1559894248', '山卡卡', '农村', '1559894248', '1559894248', null);

-- ----------------------------
-- Table structure for `yzx_carclass`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_carclass`;
CREATE TABLE `yzx_carclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carclass_name` varchar(255) DEFAULT NULL COMMENT '汽车部门',
  `carclass_info` varchar(255) DEFAULT NULL COMMENT '汽车部门简介',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_carclass
-- ----------------------------
INSERT INTO `yzx_carclass` VALUES ('2', '监察部2', '监察部');
INSERT INTO `yzx_carclass` VALUES ('3', '商务部', '商务部');
INSERT INTO `yzx_carclass` VALUES ('4', '监察部', '监察部');

-- ----------------------------
-- Table structure for `yzx_carrecord`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_carrecord`;
CREATE TABLE `yzx_carrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carrecord_starttime` datetime DEFAULT NULL COMMENT '用车开始时间',
  `carrecord_endtime` datetime DEFAULT NULL COMMENT '用车结束时间',
  `carrecord_info` varchar(255) NOT NULL COMMENT '用车信息',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_carrecord
-- ----------------------------

-- ----------------------------
-- Table structure for `yzx_carsystem`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_carsystem`;
CREATE TABLE `yzx_carsystem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carsystem_licence` varchar(255) DEFAULT NULL COMMENT '汽车牌照',
  `carsystem_class` int(11) DEFAULT NULL COMMENT '汽车所属部门',
  `carsystem_master` varchar(255) DEFAULT NULL COMMENT '汽车负责人',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_carsystem
-- ----------------------------
INSERT INTO `yzx_carsystem` VALUES ('1', '浙BY90M0', '2', '29');

-- ----------------------------
-- Table structure for `yzx_classify`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_classify`;
CREATE TABLE `yzx_classify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classify_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `classify_info` varchar(255) DEFAULT NULL COMMENT '分类描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_classify
-- ----------------------------
INSERT INTO `yzx_classify` VALUES ('1', '美体', '美容美颜');
INSERT INTO `yzx_classify` VALUES ('2', '随葬', '随葬物品');
INSERT INTO `yzx_classify` VALUES ('3', '墓地', '墓地');

-- ----------------------------
-- Table structure for `yzx_company`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_company`;
CREATE TABLE `yzx_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) NOT NULL COMMENT '证明单位名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_company
-- ----------------------------
INSERT INTO `yzx_company` VALUES ('1', '某某某单位');
INSERT INTO `yzx_company` VALUES ('2', '测试');

-- ----------------------------
-- Table structure for `yzx_conclusion`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_conclusion`;
CREATE TABLE `yzx_conclusion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conclusion_name` varchar(255) DEFAULT NULL COMMENT '病因名称)',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_conclusion
-- ----------------------------
INSERT INTO `yzx_conclusion` VALUES ('1', '不明');
INSERT INTO `yzx_conclusion` VALUES ('2', '自杀');
INSERT INTO `yzx_conclusion` VALUES ('3', '车祸死亡');

-- ----------------------------
-- Table structure for `yzx_cost`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_cost`;
CREATE TABLE `yzx_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_name` varchar(255) DEFAULT NULL COMMENT '收费项目名称',
  `cost_expenses` varchar(255) DEFAULT NULL COMMENT '价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_cost
-- ----------------------------
INSERT INTO `yzx_cost` VALUES ('1', '美体', '122');
INSERT INTO `yzx_cost` VALUES ('2', '纸钱', '12');
INSERT INTO `yzx_cost` VALUES ('8', '测试', '12');
INSERT INTO `yzx_cost` VALUES ('32', '服务', '123');

-- ----------------------------
-- Table structure for `yzx_dreson`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_dreson`;
CREATE TABLE `yzx_dreson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dreson_name` varchar(255) DEFAULT NULL COMMENT '死亡原因',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_dreson
-- ----------------------------
INSERT INTO `yzx_dreson` VALUES ('2', '工地死亡');
INSERT INTO `yzx_dreson` VALUES ('10', '测试');

-- ----------------------------
-- Table structure for `yzx_group`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_group`;
CREATE TABLE `yzx_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yzx_group
-- ----------------------------
INSERT INTO `yzx_group` VALUES ('1', '超级管理员', '1', '1,14,22,23,24,25,26,15,27,28,29,30,31,32,16,33,34,35,2,18,36,37,38,40,60,19,41,42,43,44,46,20,47,48,49,50,51,21,52,53,54,55,56,3,70,4,115,117,118,119,120,121,116,122,123,124,125,126,127,128,137,138,140,129,130,131,132,133,134,135,136,61,62,65,66,67,68,69,63,71,72,73,74,75,64,76,77,78,79,80,81,82,83,84,86,87,88,89,90,85,91,92,93,94,95,96,97,100,101,102,103,104,98,110,111,112,113,114,99,105,106,107,108,109');
INSERT INTO `yzx_group` VALUES ('2', '管理员', '1', '2,18,36,37,38,40,19,41,42,43,44,46,20,47,48,49,50,51,21,52,53,54,55,56,61,62,65,66,67,68,69,63,71,72,73,74,75,64,76,77,78,79,80,81,82');
INSERT INTO `yzx_group` VALUES ('11', '普通管理员', '1', '3,70');
INSERT INTO `yzx_group` VALUES ('13', '车辆部门管理', '1', '83,84,86,87,88,89,90,85,91,92,93,94,95');

-- ----------------------------
-- Table structure for `yzx_history`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_history`;
CREATE TABLE `yzx_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `history_title` varchar(255) DEFAULT NULL COMMENT '历史发展标题',
  `history_content` text COMMENT '历史发展内容',
  `history_url` varchar(255) DEFAULT NULL COMMENT '历史发展图片',
  `history_time` int(11) DEFAULT NULL COMMENT '时间',
  `history_des` varchar(255) DEFAULT NULL COMMENT '摘要',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_history
-- ----------------------------
INSERT INTO `yzx_history` VALUES ('4', '支持二次开发的【微信小程序电商管理系统】', '&lt;p&gt;\r\n全开源免费的一款微信小程序B2C模式电商管理软件，支持SAAS多开模式&lt;br&gt;下载地址：https://www.yiovo.com/&lt;br&gt;\r\n下载地址：https://www.yiovo.com/ &lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/oa/201909120946394970.jpeg&quot; style=&quot;max-width:100%;&quot;&', '/bysystem/uploads/2019-09-12/5d79a3856af08.PNG', '1568252805', '测试1');

-- ----------------------------
-- Table structure for `yzx_local`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_local`;
CREATE TABLE `yzx_local` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `local_name` varchar(255) DEFAULT NULL COMMENT '区域名称',
  `local_info` varchar(255) DEFAULT NULL COMMENT '区域简介',
  `classify_local` varchar(255) DEFAULT NULL COMMENT '（[list]）拥有的所有分类id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_local
-- ----------------------------
INSERT INTO `yzx_local` VALUES ('1', '都匀', null, '1,2,3');
INSERT INTO `yzx_local` VALUES ('2', '贵阳', '贵阳', '1,2');
INSERT INTO `yzx_local` VALUES ('3', '凯里', '凯里', '1,2,3');
INSERT INTO `yzx_local` VALUES ('14', '测试12', '测试41', '1,2');

-- ----------------------------
-- Table structure for `yzx_master`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_master`;
CREATE TABLE `yzx_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_username` varchar(255) DEFAULT NULL COMMENT '账号\r\n',
  `master_nickname` varchar(255) DEFAULT NULL COMMENT '名称',
  `master_password` varchar(255) DEFAULT NULL COMMENT '密码',
  `master_createtime` int(11) DEFAULT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_master
-- ----------------------------
INSERT INTO `yzx_master` VALUES ('1', 'shu888', 'shuqwq', 'e10adc3949ba59abbe56e057f20f883e', '1562749323');
INSERT INTO `yzx_master` VALUES ('3', 'shuu', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '1560909700');
INSERT INTO `yzx_master` VALUES ('7', 'admin', '超级管理员', 'e10adc3949ba59abbe56e057f20f883e', '1561020159');
INSERT INTO `yzx_master` VALUES ('23', 'test', 'test1', 'e10adc3949ba59abbe56e057f20f883e', '1562767730');
INSERT INTO `yzx_master` VALUES ('27', 'superadmin', 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', '1562771346');
INSERT INTO `yzx_master` VALUES ('29', '王亮', '王亮', 'e10adc3949ba59abbe56e057f20f883e', '1565751312');
INSERT INTO `yzx_master` VALUES ('30', '王一', '王一', 'e10adc3949ba59abbe56e057f20f883e', '1565856215');

-- ----------------------------
-- Table structure for `yzx_member`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_member`;
CREATE TABLE `yzx_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_upperid` int(11) DEFAULT NULL COMMENT '(所属业务ID)',
  `member_name` varchar(255) DEFAULT NULL COMMENT '(家属名称)',
  `member_relationship` varchar(255) DEFAULT NULL COMMENT '(与逝者关系)',
  `member_telephone` varchar(255) DEFAULT NULL COMMENT '(联系电话)',
  `member_place` varchar(255) DEFAULT NULL COMMENT '联系具体地址)',
  `member_arrivetime` int(11) DEFAULT NULL COMMENT '(到达中心时间)',
  `member_remark` varchar(255) DEFAULT NULL COMMENT '(备注',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_member
-- ----------------------------
INSERT INTO `yzx_member` VALUES ('1', '1', '李某某', '1', '15100000000', '贵阳', '1559894248', '');
INSERT INTO `yzx_member` VALUES ('2', '2', '王某某', '2', '13100000000', '南明', '1559894248', null);

-- ----------------------------
-- Table structure for `yzx_notice`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_notice`;
CREATE TABLE `yzx_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oasystem_id` int(11) NOT NULL COMMENT '文档的ID',
  `oaclass_id` int(11) NOT NULL COMMENT '文档的分类id',
  `master_checkuser` int(11) NOT NULL COMMENT '文档查看人id',
  `create_time` int(11) DEFAULT NULL COMMENT '查看时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yzx_notice
-- ----------------------------
INSERT INTO `yzx_notice` VALUES ('1', '2', '9', '7', '1567155758');
INSERT INTO `yzx_notice` VALUES ('2', '3', '10', '7', '1567155758');
INSERT INTO `yzx_notice` VALUES ('14', '5', '9', '7', '1579140984');
INSERT INTO `yzx_notice` VALUES ('4', '49', '1', '7', '1568096269');
INSERT INTO `yzx_notice` VALUES ('7', '11', '1', '7', '1568096860');
INSERT INTO `yzx_notice` VALUES ('13', '52', '9', '7', '1579140977');
INSERT INTO `yzx_notice` VALUES ('16', '54', '9', '7', '1584332494');
INSERT INTO `yzx_notice` VALUES ('17', '55', '1', '7', '1584332507');
INSERT INTO `yzx_notice` VALUES ('18', '28', '1', '7', '1584349024');
INSERT INTO `yzx_notice` VALUES ('19', '56', '1', '7', '1600150184');

-- ----------------------------
-- Table structure for `yzx_oaclasses`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_oaclasses`;
CREATE TABLE `yzx_oaclasses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oaclasses_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `oaclasses_url` varchar(255) DEFAULT NULL COMMENT '分类图标',
  `oaclasses_info` varchar(255) DEFAULT NULL COMMENT '分类描述',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_oaclasses
-- ----------------------------
INSERT INTO `yzx_oaclasses` VALUES ('1', '测试1', '/bysystem/uploads/oa/201908291550125725.jpg', '测试1');
INSERT INTO `yzx_oaclasses` VALUES ('9', '测试3', '/bysystem/uploads/oa/201908301555582720.jpg', '测试一1');
INSERT INTO `yzx_oaclasses` VALUES ('10', '测试4', '/bysystem/uploads/oa/201908300929415634.jpg', '');
INSERT INTO `yzx_oaclasses` VALUES ('5', '测试2', '/bysystem/uploads/oa/201909041517305651.jpg', '测试一1');
INSERT INTO `yzx_oaclasses` VALUES ('14', '测试7', '/bysystem/uploads/oa/201909031419087590.jpg', '');

-- ----------------------------
-- Table structure for `yzx_oasystem`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_oasystem`;
CREATE TABLE `yzx_oasystem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oasystem_name` varchar(255) NOT NULL COMMENT '文档名称',
  `oasystem_content` text COMMENT '文档内容',
  `oasystem_user` int(11) NOT NULL COMMENT '发布人',
  `oasystem_url` varchar(255) DEFAULT NULL COMMENT '文档上传文档链接-',
  `oasystem_classes` int(11) NOT NULL COMMENT '文档分类',
  `oasystem_noticestate` int(11) NOT NULL COMMENT '文档通知（0通知，1未通知）',
  `oasystem_noticetime` int(11) DEFAULT NULL COMMENT '如果通知 记录通知时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_oasystem
-- ----------------------------
INSERT INTO `yzx_oasystem` VALUES ('1', '通知', '&lt;p&gt;11222222&lt;/p&gt;', '27', '', '1', '1', '0');
INSERT INTO `yzx_oasystem` VALUES ('2', '通知11', '&lt;p&gt;通知11&lt;/p&gt;', '7', '/bysystem/uploads/oa/file/201908301701491471.xls', '9', '0', '1567155709');
INSERT INTO `yzx_oasystem` VALUES ('3', '通知', '', '27', '/bysystem/uploads/oa/file/201908301702389915.xls', '10', '0', '1567155758');
INSERT INTO `yzx_oasystem` VALUES ('4', '通知', '&lt;p&gt;11wwwe&lt;/p&gt;', '27', '', '10', '1', '0');
INSERT INTO `yzx_oasystem` VALUES ('5', '通知', '&lt;p&gt;sfsfsf&lt;/p&gt;', '27', '', '9', '0', '1567159436');
INSERT INTO `yzx_oasystem` VALUES ('56', '月  有', '&lt;p&gt;11&lt;/p&gt;', '7', '', '1', '0', '1586838281');
INSERT INTO `yzx_oasystem` VALUES ('11', '1鑫多像仍', '&lt;p&gt;1鑫多像仍1鑫多像仍&lt;/p&gt;', '7', '', '1', '0', '1567581136');
INSERT INTO `yzx_oasystem` VALUES ('55', '月  有', '&lt;p&gt;月  有月  有&lt;br&gt;&amp;nbsp;月  有&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '7', '', '1', '0', '1584327355');
INSERT INTO `yzx_oasystem` VALUES ('28', '测试通知', '&lt;p&gt;测试测试测试测试人大规模111&lt;/p&gt;', '7', '/bysystem/uploads/oa/file/201909051312346320.xls', '1', '0', '1584327367');
INSERT INTO `yzx_oasystem` VALUES ('52', 'lllasdad', '&lt;p&gt;sfsffsfsf&lt;/p&gt;', '7', '', '9', '0', '1579140802');
INSERT INTO `yzx_oasystem` VALUES ('49', '请及时查看', '&lt;p&gt;请及时查看请及时查看请及时查看&lt;/p&gt;', '7', '', '1', '0', '1567666257');
INSERT INTO `yzx_oasystem` VALUES ('54', '月  有', '&lt;p&gt;月  有月  有&lt;br&gt;&amp;nbsp;月  有月  有&lt;br&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '7', '', '9', '0', '1584326765');

-- ----------------------------
-- Table structure for `yzx_order`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_order`;
CREATE TABLE `yzx_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` varchar(255) NOT NULL COMMENT '订单号',
  `order_price` double(10,2) DEFAULT NULL COMMENT '总价',
  `order_state` int(11) DEFAULT NULL COMMENT '状态（1待支付，2已支付，3已取消',
  `order_user` int(11) DEFAULT NULL COMMENT '用户id',
  `order_area` int(11) DEFAULT NULL COMMENT '操作区域',
  `order_sign` varchar(255) DEFAULT NULL COMMENT '用户签名',
  `order_create` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_order
-- ----------------------------
INSERT INTO `yzx_order` VALUES ('26', 'YZX11565247849', '150.00', '2', '1', '1', '/byg/public/upload/201908081738308599.jpeg', '1565247849');
INSERT INTO `yzx_order` VALUES ('25', 'YZX11565247657', '150.00', '3', '3', '1', '测试', '1565247657');
INSERT INTO `yzx_order` VALUES ('27', 'YZX11565699664', '100.00', '3', '3', '1', '测试', '1565697875');

-- ----------------------------
-- Table structure for `yzx_ordetail`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_ordetail`;
CREATE TABLE `yzx_ordetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordetail_ornum` varchar(255) DEFAULT NULL COMMENT '订单id',
  `ordetail_id` int(11) DEFAULT NULL COMMENT '商品id',
  `ordetail_num` int(11) DEFAULT NULL COMMENT '数量',
  `ordetail_price` double(10,2) DEFAULT NULL COMMENT '商品单价',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of yzx_ordetail
-- ----------------------------
INSERT INTO `yzx_ordetail` VALUES ('18', 'YZX11565247657', '100', '1', '50.00');
INSERT INTO `yzx_ordetail` VALUES ('16', 'YZX11565247849', '101', '1', '50.00');
INSERT INTO `yzx_ordetail` VALUES ('15', 'YZX11565247849', '101', '1', '100.00');

-- ----------------------------
-- Table structure for `yzx_product`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_product`;
CREATE TABLE `yzx_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `product_price` double(10,2) DEFAULT NULL COMMENT '商品价格',
  `product_num` int(11) DEFAULT NULL COMMENT '商品库存',
  `product_info` text COMMENT '商品描述',
  `product_img` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `product_classify` int(11) DEFAULT NULL COMMENT '商品所属分类',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_product
-- ----------------------------
INSERT INTO `yzx_product` VALUES ('90', 'mj试', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101627503412.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101627554015.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', '/bysystem/uploads/2019-07-10/5d25a1920edbf.jpeg', '1');
INSERT INTO `yzx_product` VALUES ('91', 'mj试', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/20190710162813657.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101628204126.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;img src=&quot;https://p.ssl.qhimg.com/dmsmfl/120_75_/t012207a4f45f5275e3.webp?size=763x379&amp;amp;phash=8761875197583253074&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', 'https://p.ssl.qhimg.com/dmsmfl/120_75_/t012207a4f45f5275e3.webp?size=763x379&amp;phash=8761875197583253074', '1');
INSERT INTO `yzx_product` VALUES ('92', 'mj2', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101628528104.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101628588470.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101629022049.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', 'https://ps.ssl.qhimg.com/sdmt/244_162_100/t016a2e8fa4f21a841b.webp', '1');
INSERT INTO `yzx_product` VALUES ('93', 'mj试', '121.00', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/201907101629412127.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/20190710162949152.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', 'https://p.ssl.qhimg.com/dmsmfl/120_75_/t012207a4f45f5275e3.webp?size=763x379&amp;phash=8761875197583253074', '1');
INSERT INTO `yzx_product` VALUES ('94', '测试1测试1测试1测试1测试1测试1测试1测试1测试1测试1测试1测试1', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/20190710163018280.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', '/bysystem/uploads/2019-07-10/5d25a226565ea.jpeg', '2');
INSERT INTO `yzx_product` VALUES ('100', '测试1', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/201907102352007004.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907102352235036.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', '/bysystem/uploads/2019-07-10/5d2609cf9e011.PNG', '2');
INSERT INTO `yzx_product` VALUES ('101', 'mj试', '1213.90', '12', '&lt;p&gt;&lt;img src=&quot;/bysystem/uploads/images/201907111411488352.jpeg&quot; style=&quot;max-width:100%;&quot;&gt;&lt;img src=&quot;/bysystem/uploads/images/201907111411524875.jpeg&quot; style=&quot;font-family: inherit; font-size: inherit; font-style: inherit; font-variant-ligatures: inherit; font-variant-caps: inherit; font-weight: inherit; max-width: 100%;&quot;&gt;&lt;br&gt;&lt;/p&gt;', '/bysystem/uploads/2019-07-11/5d26d332262de.jpeg', '2');

-- ----------------------------
-- Table structure for `yzx_relationship`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_relationship`;
CREATE TABLE `yzx_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relationship_name` varchar(255) DEFAULT NULL COMMENT '关系名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_relationship
-- ----------------------------
INSERT INTO `yzx_relationship` VALUES ('1', '同事1');
INSERT INTO `yzx_relationship` VALUES ('2', '父子');

-- ----------------------------
-- Table structure for `yzx_rule`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_rule`;
CREATE TABLE `yzx_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yzx_rule
-- ----------------------------
INSERT INTO `yzx_rule` VALUES ('1', '0', 'Admin/Rule/index', '权限控制', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('2', '0', 'Admin/Basic/index', '基本信息', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('3', '0', 'Admin/Business/index', '业务管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('18', '2', 'Admin/Basic/Costlist', '收费项目', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('14', '1', 'Admin/Rule/userlist', '用户管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('16', '1', 'Admin/Rule/RuleList', '权限管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('15', '1', 'Admin/Rule/GroupList', '角色管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('19', '2', 'Admin/Basic/Companylist', '证明单位', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('20', '2', 'Admin/Basic/Dresonlist', '死亡原因', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('21', '2', 'Admin/Basic/RelationshipList', '关系设置', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('22', '14', 'Admin/Rule/adduser', '新增用户', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('23', '14', 'Admin/Rule/updateUser', '修改用户', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('24', '14', 'Admin/Rule/delUser', '删除用户', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('25', '14', 'Admin/Rule/delUsers', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('26', '14', 'Admin/Rule/UserSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('27', '15', 'Admin/Rule/AddGroup', '新增角色', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('28', '15', 'Admin/Rule/updateGroup', '修改角色', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('29', '15', 'Admin/Rule/delGroup', '删除角色', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('30', '15', 'Admin/Rule/delGroups', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('31', '15', 'Admin/Rule/GroupSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('32', '15', 'Admin/Rule/RuleGroup', '分配权限', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('33', '16', 'Admin/Rule/AddRule', '新增权限', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('34', '16', 'Admin/Rule/updateRule', '修改权限', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('35', '16', 'Admin/Rule/delRule', '删除权限', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('36', '18', 'Admin/Basic/addCost', '新增收费项目', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('37', '18', 'Admin/Basic/updateCost', '修改收费项目', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('38', '18', 'Admin/Basic/delCost', '删除收费项目', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('60', '18', 'Admin/Basic/delCosts', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('40', '18', 'Admin/Basic/CostSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('41', '19', 'Admin/Basic/addCompany', '新增证明单位', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('42', '19', 'Admin/Basic/updateCompany', '修改证明单位', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('43', '19', 'Admin/Basic/delCompany', '删除证明单位', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('44', '19', 'Admin/Basic/delCompanies', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('46', '19', 'Admin/Basic/CompanySearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('47', '20', 'Admin/Basic/addDreson', '新增死亡原因', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('48', '20', 'Admin/Basic/updateDreson', '修改死亡原因', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('49', '20', 'Admin/Basic/delDreson', '删除死亡原因', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('50', '20', 'Admin/Basic/delDresons', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('51', '20', 'Admin/Basic/DresonSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('52', '21', 'Admin/Basic/addRelationship', '新增关系', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('53', '21', 'Admin/Basic/updateRelationShip', '修改关系', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('54', '21', 'Admin/Basic/delRelationship', '删除关系', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('55', '21', 'Admin/Basic/delRelationships', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('56', '21', 'Admin/Basic/RelationshipSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('61', '0', 'Admin/Tablet/index', '平板管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('62', '61', 'Admin/Tablet/productClasslist', '商品分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('63', '61', 'Admin/Tablet/locallist', '区域设置', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('64', '61', 'Admin/Tablet/Productlist', '商品设置', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('65', '62', 'Admin/Tablet/addClassify', '新增分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('66', '62', 'Admin/Tablet/updateClassify', '修改分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('67', '62', 'Admin/Tablet/delClassify', '删除分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('68', '62', 'Admin/Tablet/delClassifies', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('69', '62', 'Admin/Tablet/classsifySearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('70', '3', 'Admin/Business/yuyuelist', '预约管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('71', '63', 'Admin/Tablet/addLocal', '新增区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('72', '63', 'Admin/Tablet/updateLocal', '修改区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('73', '63', 'Admin/Tablet/delLocal', '删除区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('74', '63', 'Admin/Tablet/delLocals', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('75', '63', 'Admin/Tablet/localSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('76', '64', 'Admin/Tablet/addProduct', '新增商品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('77', '64', 'Admin/Tablet/updateProduct', '修改商品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('78', '64', 'Admin/Tablet/delProduct', '删除商品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('79', '64', 'Admin/Tablet/delProducts', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('80', '64', 'Admin/Tablet/productSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('81', '64', 'Admin/Tablet/more', '更多', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('82', '61', 'Admin/Tablet/orderlist', '订单管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('83', '0', 'Admin/Car/index', '车辆管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('84', '83', 'Admin/Car/carsystemlist', '车辆信息', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('85', '83', 'Admin/Car/carclasslist', '汽车部门', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('86', '84', 'Admin/Car/carsystemSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('87', '84', 'Admin/Car/carsystemadd', '添加汽车信息', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('88', '84', 'Admin/Car/updatecarsystem', '修改汽车信息', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('89', '84', 'Admin/Car/delcarsystem', '删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('90', '84', 'Admin/Car/delcarsystems', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('91', '85', 'Admin/Car/carclassadd', '添加汽车部门', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('92', '85', 'Admin/Car/carclassSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('93', '85', 'Admin/Car/delcarclassed', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('94', '85', 'Admin/Car/delcarclass', '删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('95', '85', 'Admin/Car/updatecarclass', '修改', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('96', '0', 'Admin/Warehouse/index', '仓库管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('97', '96', 'Admin/Warehouse/WarehouseClasslist', '区域管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('98', '96', 'Admin/Warehouse/WarehouseProductlist', '仓库物品管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('99', '96', 'Admin/Warehouse/Supplierlist', '供应商管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('100', '97', 'Admin/Warehouse/addWarehouseClass', '新增区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('101', '97', 'Admin/Warehouse/updateWarehouseClass', '修改区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('102', '97', 'Admin/Warehouse/delWarehouseClass', '删除区域', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('103', '97', 'Admin/Warehouse/delWarehouseClasses', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('104', '97', 'Admin/Warehouse/WarehouseClassSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('105', '99', 'Admin/Warehouse/addSupplier', '新增供应商', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('106', '99', 'Admin/Warehouse/updateSupplier', '修改供应商', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('107', '99', 'Admin/Warehouse/delSupplier', '删除供应商', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('108', '99', 'Admin/Warehouse/delSuppliers', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('109', '99', 'Admin/Warehouse/SupplierSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('110', '98', 'Admin/Warehouse/addWarehouseProduct', '新增仓库物品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('111', '98', 'Admin/Warehouse/updateWarehouseProduct', '修改仓库物品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('112', '98', 'Admin/Warehouse/delWarehouseProduct', '删除仓库物品', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('113', '98', 'Admin/Warehouse/delWarehouseProducts', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('114', '98', 'Admin/Warehouse/WarehouseProductSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('4', '0', 'Admin/Oa/index', '档案中心', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('115', '4', 'Admin/Oa/oaClasseslist', '文档分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('116', '4', 'Admin/Oa/oasystemlist', '文档管理', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('117', '115', 'Admin/Oa/addOaclass', '新增分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('118', '115', 'Admin/Oa/updateOaclass', '修改分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('119', '115', 'Admin/Oa/delOaclass', '删除分类', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('120', '115', 'Admin/Oa/delOaclasses', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('121', '115', 'Admin/Oa/OaclassSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('122', '116', 'Admin/Oa/addOasystem', '新增文档', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('123', '116', 'Admin/Oa/updateOasystem', '修改文档', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('124', '116', 'Admin/Oa/delOasystem', '删除文档', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('125', '116', 'Admin/Oa/delOasystems', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('126', '116', 'Admin/Oa/OasystemSearch', '搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('127', '116', 'Admin/Oa/moredetail', '更多', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('128', '4', 'Admin/Oa/historynoticlist', '历史通知', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('129', '4', 'Admin/Oa/historylist', '发展编辑', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('130', '129', 'Admin/Oa/addhistory', '添加发展编辑', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('131', '129', 'Admin/Oa/uploadFile', '编辑器图片', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('132', '129', 'Admin/Oa/more', '发展详情', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('133', '129', 'Admin/Oa/updatehistory', '修改发展历史', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('134', '129', 'Admin/Oa/delhistory', '删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('135', '129', 'Admin/Oa/delhistorys', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('136', '129', 'Admin/Oa/historySearch', '发展搜索', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('137', '128', 'Admin/Oa/delhistorynotice', '删除通知', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('138', '128', 'Admin/Oa/delhistorynotices', '批量删除', '1', '1', '');
INSERT INTO `yzx_rule` VALUES ('140', '128', 'Admin/Oa/NoticfySearch', '搜索', '1', '1', '');

-- ----------------------------
-- Table structure for `yzx_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_supplier`;
CREATE TABLE `yzx_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL COMMENT '供应商名称',
  `supplier_phone` varchar(255) DEFAULT NULL COMMENT '供应商电话',
  `supplier_info` text COMMENT '供应商信息',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_supplier
-- ----------------------------
INSERT INTO `yzx_supplier` VALUES ('1', '一条龙服务', '0857-2535555', '一条龙服务');
INSERT INTO `yzx_supplier` VALUES ('2', '大众木棺', '13345678998', '大众木棺');
INSERT INTO `yzx_supplier` VALUES ('8', '磊圣木材', '0857-2535555', '磊圣木材');

-- ----------------------------
-- Table structure for `yzx_warehouseclass`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_warehouseclass`;
CREATE TABLE `yzx_warehouseclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouseclass_name` varchar(255) NOT NULL COMMENT '区域名称',
  `warehouseclass_info` varchar(255) DEFAULT NULL COMMENT '区域简介',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_warehouseclass
-- ----------------------------
INSERT INTO `yzx_warehouseclass` VALUES ('1', 'A大仓', 'A大仓');
INSERT INTO `yzx_warehouseclass` VALUES ('2', 'B大仓区域', 'B大仓区域');

-- ----------------------------
-- Table structure for `yzx_warehouseproduct`
-- ----------------------------
DROP TABLE IF EXISTS `yzx_warehouseproduct`;
CREATE TABLE `yzx_warehouseproduct` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouseproduct_name` varchar(255) NOT NULL COMMENT '商品名称',
  `warehouseproduct_class` int(11) NOT NULL COMMENT '商品所在区域',
  `warehouseproduct_supplier` int(11) DEFAULT NULL COMMENT '商品供应商）可为空',
  `warehouseproduct_num` int(11) DEFAULT NULL COMMENT '商品数量',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of yzx_warehouseproduct
-- ----------------------------
INSERT INTO `yzx_warehouseproduct` VALUES ('1', '测试', '2', '1', '50');
INSERT INTO `yzx_warehouseproduct` VALUES ('2', '测试22', '1', '1', '50');
INSERT INTO `yzx_warehouseproduct` VALUES ('5', '测试2', '2', '2', '50');
INSERT INTO `yzx_warehouseproduct` VALUES ('6', '测44', '1', '1', '50');
