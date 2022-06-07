/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : tymb

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-09-02 17:25:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for join
-- ----------------------------
DROP TABLE IF EXISTS `join`;
CREATE TABLE `join` (
  `jid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(6) NOT NULL,
  `pid` int(2) NOT NULL,
  `tid` int(4) NOT NULL,
  `group` varchar(14) COLLATE utf8_bin DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `card` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`jid`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `pid` (`pid`) USING BTREE,
  KEY `team` (`tid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of join
-- ----------------------------
INSERT INTO `join` VALUES ('1', '1', '1', '2', '个人组', 'upload/video/20200901/234375819515333e73a1a1e6a159351c.mp4', 'upload/image/jz.png', '1598929564');

-- ----------------------------
-- Table structure for program
-- ----------------------------
DROP TABLE IF EXISTS `program`;
CREATE TABLE `program` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_bin NOT NULL,
  `img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sid` int(3) NOT NULL,
  `video` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `content` varchar(2000) COLLATE utf8_bin DEFAULT NULL,
  `groups` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `valid` bit(1) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`pid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of program
-- ----------------------------
INSERT INTO `program` VALUES ('1', '第二届川籍农民工运动会（云健身）健步走项目竞赛', 'image/p1.jpg', '1', 'https://video19.ifeng.com/video09/2020/07/23/p36652565-102-009-230025.mp4', '1598884779', '1601395200', '<p>正确政治路线决定正确组织路线，正确组织路线服务保证正确政治路线。什么时候坚持正确组织路线，党的组织就蓬勃发展，党的事业就顺利推进；什么时候组织路线发生偏差，党的组织就遭到破坏，党的事业就出现挫折。</p>', '[\"个人组\",\"团体组\"]', '', '1598884779', '1598884779');
INSERT INTO `program` VALUES ('2', '第二届川籍农民工运动会（云健身）健身跑项目竞赛', 'image/p2.jpg', '2', 'https://vodpub1.v.news.cn/original/20200730/0a8edd6be2164ff9a7e6340c50d60663.mp4', '1598884779', '1601395200', '<p>　　2018年，经中央军委批准，增加林俊德、张超为全军挂像英模。自此，各时期的中国人民解放军挂像英模增加到10位。在建军93周年之际，让我们走近他们，从他们的英雄事迹中读懂中国人民解放军一路走来的精神密码。</p>', '[\"个人组\",\"团体组\"]', '', '1598884779', '1598884779');
INSERT INTO `program` VALUES ('3', '第二届川籍农民工运动会（云健身）云骑行项目竞赛', 'image/p3.jpg', '3', 'https://vodpub1.v.news.cn/original/20200713/e26f773189f34039b8690c8dacdd985f.mp4', '1598884779', '1601395200', '<p>　　家书，是一份牵挂，是一份期盼，也是一份传承。在建党99周年之际，让我们重温几封革命先烈的家书。</p>', '[\"个人组\",\"团体组\"]', '', '1598884779', '1598884779');
INSERT INTO `program` VALUES ('4', '第二届川籍农民工运动会（云健身）体能项目竞赛', 'image/p2.jpg', '5', 'https://vodpub1.v.news.cn/original/20200730/0a8edd6be2164ff9a7e6340c50d60663.mp4', '1598884779', '1601395200', '<p>正确政治路线决定正确组织路线，正确组织路线服务保证正确政治路线。什么时候坚持正确组织路线，党的组织就蓬勃发展，党的事业就顺利推进；什么时候组织路线发生偏差，党的组织就遭到破坏，党的事业就出现挫折。</p>', '[\"个人组\",\"团体组\"]', '', '1598884779', '1598884779');

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `sid` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `headimg` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `valid` bit(1) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES ('1', '健步走', 'image/jbz.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('2', '健步跑', 'image/jbp.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('3', '云骑行', 'image/zxc.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('4', '象棋', 'image/xq.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('5', '体能', 'image/tn.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('6', '居家', 'image/jj.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('7', '跳绳', 'image/ts.png', '', '1598884779', '1598884779');
INSERT INTO `subject` VALUES ('8', '健身路径', 'image/jslj.png', '', '1598884779', '1598884779');

-- ----------------------------
-- Table structure for team
-- ----------------------------
DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `headimg` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `own` bit(1) DEFAULT NULL,
  `code` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `sum` int(5) DEFAULT NULL,
  `valid` bit(1) DEFAULT NULL,
  `creator` int(8) DEFAULT NULL,
  `create_time` int(12) DEFAULT NULL,
  PRIMARY KEY (`tid`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE,
  UNIQUE KEY `creator` (`creator`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of team
-- ----------------------------
INSERT INTO `team` VALUES ('1', '成都假日旅行社', 'upload/20200829/f79e862bfdd77ab63e06531dafe12f07.jpg', '成都', '', '123321', '1', '', '2', '1598633823');
INSERT INTO `team` VALUES ('2', '四川党建期刊集团', 'upload/20200830/b20bba935ee81e553029bba973d12420.jpg', '成都', '', '666666', '1', '', '1', '1598760810');

-- ----------------------------
-- Table structure for team_hub
-- ----------------------------
DROP TABLE IF EXISTS `team_hub`;
CREATE TABLE `team_hub` (
  `thid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `headimg` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `own` bit(1) DEFAULT NULL,
  `code` varchar(6) COLLATE utf8_bin DEFAULT NULL,
  `creator` int(8) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`thid`) USING BTREE,
  UNIQUE KEY `creator` (`creator`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of team_hub
-- ----------------------------

-- ----------------------------
-- Table structure for top
-- ----------------------------
DROP TABLE IF EXISTS `top`;
CREATE TABLE `top` (
  `tid` int(11) NOT NULL,
  `img` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `sort` int(2) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of top
-- ----------------------------
INSERT INTO `top` VALUES ('1', 'image/s1.png', null, '0', '1598886696', '1598886696');
INSERT INTO `top` VALUES ('2', 'image/s2.png', null, '1', '1598886696', '1598886696');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `idcard` varchar(18) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `team` int(5) DEFAULT NULL,
  `teamtime` int(11) DEFAULT NULL,
  `ismigrant` bit(1) NOT NULL,
  `creator` int(5) DEFAULT NULL,
  `valid` bit(1) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE,
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'o2-lN6BsXX2qEsVJJeqBLWwtmfZc', '刘尧夫', '51132319921231307X', '18190927136', '2', '1598864533', '', '2', '', '1598864121', '1598864753');
INSERT INTO `user` VALUES ('2', 'o2-lN6K13YbkhsPasLm9taDM_FmI', '李英', '510902199002023883', '18190927131', '1', '1598633823', '', '1', '', '1598685050', '1598685229');

-- ----------------------------
-- Table structure for user_wx
-- ----------------------------
DROP TABLE IF EXISTS `user_wx`;
CREATE TABLE `user_wx` (
  `uid` int(11) NOT NULL,
  `nickname` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `sex` int(1) DEFAULT NULL,
  `headimgurl` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of user_wx
-- ----------------------------
INSERT INTO `user_wx` VALUES ('1', '树上的胖西瓜', '1', 'http://thirdwx.qlogo.cn/mmopen/vi_32/ticcYaE1HoXODePTgF2o3ysbhydVVj5kTzyp2jjZxVViagw1dGibU1n8PyWpzNEChlLsZFRraXNWYcfDeOqA8dUgg/132', '成都', '1598864753');
INSERT INTO `user_wx` VALUES ('2', '蓝宝儿', '2', 'http://thirdwx.qlogo.cn/mmopen/vi_32/ZcBAvrbBmC6LYKicUqIexQTJmHlXupdtfhRxBpIiaraj4RHibXOYesMO19oIsyyEX3COvjaP4CP70uru6RUXS3ZPQ/132', '成都', '1598685106');
