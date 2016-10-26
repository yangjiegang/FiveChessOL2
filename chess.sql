/*
Navicat MySQL Data Transfer

Source Server         : mysql_in_WAMP
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : chess

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-10-26 19:24:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for backchess
-- ----------------------------
DROP TABLE IF EXISTS `backchess`;
CREATE TABLE `backchess` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `whiteX` varchar(10) NOT NULL,
  `whiteY` varchar(10) NOT NULL,
  `blackX` varchar(10) NOT NULL,
  `blackY` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of backchess
-- ----------------------------

-- ----------------------------
-- Table structure for black
-- ----------------------------
DROP TABLE IF EXISTS `black`;
CREATE TABLE `black` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `posX` int(5) NOT NULL,
  `posY` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of black
-- ----------------------------

-- ----------------------------
-- Table structure for flag
-- ----------------------------
DROP TABLE IF EXISTS `flag`;
CREATE TABLE `flag` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mark` char(8) NOT NULL DEFAULT '',
  `sequence` char(8) NOT NULL,
  `whoBackChess` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of flag
-- ----------------------------
INSERT INTO `flag` VALUES ('1', 'white', 'black', '-1');

-- ----------------------------
-- Table structure for white
-- ----------------------------
DROP TABLE IF EXISTS `white`;
CREATE TABLE `white` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `posX` varchar(5) NOT NULL,
  `posY` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of white
-- ----------------------------
