# lqphp测试所需的数据库
# Host: localhost  (Version: 5.5.53)
# Date: 2019-01-11 19:24:24
# Generator: MySQL-Front 5.3  (Build 4.234)

SET NAMES utf8;

CREATE DATABASE `lqphp_test`;

#
# Structure for table "tb_book"
#

DROP TABLE IF EXISTS `tb_book`;
CREATE TABLE `tb_book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8;

#
# Data for table "tb_book"
#

INSERT INTO `tb_book` VALUES (1000,'PHP手册',1),(1001,'PHP程序设计',2),(1002,'深入浅出Node.js',1);

#
# Structure for table "tb_bookmarker"
#

DROP TABLE IF EXISTS `tb_bookmarker`;
CREATE TABLE `tb_bookmarker` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

#
# Data for table "tb_bookmarker"
#

INSERT INTO `tb_bookmarker` VALUES (2,'https://blog.csdn.net/luoluozlb','【luoluozlb】失败离成功只有一步，坚持。（QQ：0x265BD66E） - CSDN博客'),(3,'http://www.luoluolzb.cn/','洛洛の空间 - 个人博客，学习过程记录，技术知识分享'),(4,'http://192.168.0.1/net-control.htm','Tenda');

#
# Structure for table "tb_guestbook"
#

DROP TABLE IF EXISTS `tb_guestbook`;
CREATE TABLE `tb_guestbook` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(20) DEFAULT NULL,
  `content` text,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "tb_guestbook"
#

INSERT INTO `tb_guestbook` VALUES (1,'luoluolzb','liuyan',100548),(2,'zhangsan','做的不错！',1547176496);

#
# Structure for table "tb_role"
#

DROP TABLE IF EXISTS `tb_role`;
CREATE TABLE `tb_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1003 DEFAULT CHARSET=utf8;

#
# Data for table "tb_role"
#

INSERT INTO `tb_role` VALUES (1000,'学生'),(1001,'教师'),(1002,'工程师');

#
# Structure for table "tb_testuser"
#

DROP TABLE IF EXISTS `tb_testuser`;
CREATE TABLE `tb_testuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `passwd` varchar(20) DEFAULT NULL,
  `val_id` varchar(32) DEFAULT NULL,
  `checked` int(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8;

#
# Data for table "tb_testuser"
#

/*!40000 ALTER TABLE `tb_testuser` DISABLE KEYS */;
INSERT INTO `tb_testuser` VALUES (1000,'luoluo','luoluo',NULL,1),(1002,'luoluolzb','luoluolzb','58edd6138ed56c5685fe5e66d2a60670',1);
/*!40000 ALTER TABLE `tb_testuser` ENABLE KEYS */;

#
# Structure for table "tb_user"
#

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `age` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "tb_user"
#

INSERT INTO `tb_user` VALUES (1,'luoluo',21),(2,'zhangsan',21),(3,'lisi',18);

#
# Structure for table "tb_user_role"
#

DROP TABLE IF EXISTS `tb_user_role`;
CREATE TABLE `tb_user_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL,
  `role_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "tb_user_role"
#

INSERT INTO `tb_user_role` VALUES (1000,1,1),(1001,2,2),(1003,3,3);
