-- MySQL dump 10.13  Distrib 5.6.23, for Linux (x86_64)
--
-- Host: localhost    Database: audit_sec
-- ------------------------------------------------------
-- Server version	5.6.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AS400_commands`
--

DROP TABLE IF EXISTS `AS400_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AS400_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` text,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `AS400_sessions`
--

DROP TABLE IF EXISTS `AS400_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AS400_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cli_addr` varchar(20) DEFAULT NULL,
  `addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(300) DEFAULT NULL,
  `backupfile` varchar(300) DEFAULT NULL,
  `desc` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ac_group`
--

DROP TABLE IF EXISTS `ac_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=1775 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ac_network`
--

DROP TABLE IF EXISTS `ac_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ac_network` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `netmask` tinyint(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_group`
--

DROP TABLE IF EXISTS `account_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) unsigned NOT NULL,
  `groupname` varchar(50) NOT NULL,
  `createtime` datetime NOT NULL,
  `changetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mark` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_grouplog`
--

DROP TABLE IF EXISTS `account_grouplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_grouplog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_groupid` int(11) unsigned DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_linuxusers`
--

DROP TABLE IF EXISTS `account_linuxusers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_linuxusers` (
  `date` varchar(128) DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `user` varchar(20) NOT NULL DEFAULT '',
  `uid` varchar(10) DEFAULT NULL,
  `gid` varchar(10) DEFAULT NULL,
  `home` varchar(128) DEFAULT NULL,
  `shell` varchar(128) DEFAULT NULL,
  `type` varchar(24) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_record`
--

DROP TABLE IF EXISTS `account_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_record` (
  `date` varchar(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user` varchar(128) NOT NULL,
  `create_user` varchar(10) NOT NULL,
  `del_user` varchar(10) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `gid` varchar(32) NOT NULL,
  `home` varchar(128) NOT NULL,
  `shell` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_record_day`
--

DROP TABLE IF EXISTS `account_record_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_record_day` (
  `date` varchar(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user` varchar(128) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `gid` varchar(32) NOT NULL,
  `home` varchar(128) NOT NULL,
  `shell` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL,
  KEY `ip_index` (`ip`),
  KEY `user_index` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_record_diy`
--

DROP TABLE IF EXISTS `account_record_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_record_diy` (
  `date` varchar(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user` varchar(128) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `gid` varchar(32) NOT NULL,
  `home` varchar(128) NOT NULL,
  `shell` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  KEY `ip_index` (`ip`),
  KEY `user_index` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_record_month`
--

DROP TABLE IF EXISTS `account_record_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_record_month` (
  `date` varchar(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user` varchar(128) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `gid` varchar(32) NOT NULL,
  `home` varchar(128) NOT NULL,
  `shell` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL,
  KEY `ip_index` (`ip`),
  KEY `user_index` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_record_week`
--

DROP TABLE IF EXISTS `account_record_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_record_week` (
  `date` varchar(20) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `user` varchar(128) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `gid` varchar(32) NOT NULL,
  `home` varchar(128) NOT NULL,
  `shell` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL,
  KEY `ip_index` (`ip`),
  KEY `user_index` (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_user`
--

DROP TABLE IF EXISTS `account_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `createtime` datetime NOT NULL,
  `changetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mark` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_usergroup`
--

DROP TABLE IF EXISTS `account_usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_userid` int(11) unsigned NOT NULL,
  `account_groupid` int(11) unsigned NOT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` smallint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_userlog`
--

DROP TABLE IF EXISTS `account_userlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_userid` int(11) unsigned DEFAULT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` smallint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `account_userscplog`
--

DROP TABLE IF EXISTS `account_userscplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_userscplog` (
  `time` varchar(128) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `port` varchar(20) DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adimportconfig`
--

DROP TABLE IF EXISTS `adimportconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adimportconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `server` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `filteruser` varchar(255) NOT NULL DEFAULT '',
  `filterusergroup` varchar(255) NOT NULL DEFAULT '',
  `adusername` varchar(255) NOT NULL DEFAULT '',
  `adpassword` varchar(255) NOT NULL DEFAULT '',
  `aduserpwd` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_log`
--

DROP TABLE IF EXISTS `admin_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL,
  `resource_user` varchar(50) NOT NULL,
  `optime` datetime NOT NULL,
  `administrator` varchar(50) NOT NULL DEFAULT '' COMMENT '¹ÜÀíÔ±',
  `result` varchar(10) NOT NULL DEFAULT '成功',
  `lgroup` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33235 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_log_day`
--

DROP TABLE IF EXISTS `admin_log_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL,
  `resource_user` varchar(50) NOT NULL,
  `optime` datetime NOT NULL,
  `administrator` varchar(50) NOT NULL DEFAULT '',
  `result` varchar(10) NOT NULL DEFAULT '??',
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2268 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_log_diy`
--

DROP TABLE IF EXISTS `admin_log_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log_diy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL,
  `resource_user` varchar(50) NOT NULL,
  `optime` datetime NOT NULL,
  `administrator` varchar(50) NOT NULL DEFAULT '',
  `result` varchar(10) NOT NULL DEFAULT '??',
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=604 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_log_month`
--

DROP TABLE IF EXISTS `admin_log_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL,
  `resource_user` varchar(50) NOT NULL,
  `optime` datetime NOT NULL,
  `administrator` varchar(50) NOT NULL DEFAULT '',
  `result` varchar(10) NOT NULL DEFAULT '??',
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `admin_log_week`
--

DROP TABLE IF EXISTS `admin_log_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_log_week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `resource` varchar(50) NOT NULL,
  `resource_user` varchar(50) NOT NULL,
  `optime` datetime NOT NULL,
  `administrator` varchar(50) NOT NULL DEFAULT '',
  `result` varchar(10) NOT NULL DEFAULT '??',
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alarm`
--

DROP TABLE IF EXISTS `alarm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarm` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `MailServer` char(255) DEFAULT NULL,
  `account` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `syslogserver` char(255) DEFAULT NULL,
  `syslogport` int(11) DEFAULT '514',
  `syslog_facility` char(255) DEFAULT NULL,
  `Mail_Alarm` tinyint(1) DEFAULT NULL,
  `Syslog_Alarm` tinyint(1) DEFAULT NULL,
  `syslog_level` char(255) DEFAULT NULL,
  `mailto` varchar(255) DEFAULT NULL,
  `db_alarm_level` int(5) DEFAULT NULL,
  `db_replay_log` int(1) DEFAULT NULL,
  `backuptime` int(11) DEFAULT NULL,
  `backup_delete` int(2) DEFAULT NULL,
  `backup_protocol` char(10) DEFAULT NULL,
  `backup_server` char(20) DEFAULT NULL,
  `backup_port` char(10) DEFAULT NULL,
  `backup_username` char(50) DEFAULT NULL,
  `backup_password` char(50) DEFAULT NULL,
  `backup_path` varchar(512) DEFAULT NULL,
  `autoclear` int(11) DEFAULT NULL,
  `autocleardate` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alarmtab`
--

DROP TABLE IF EXISTS `alarmtab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alarmtab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(128) NOT NULL,
  `alarmnum` tinyint(4) DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `detail` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21156997 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alert_mailsms`
--

DROP TABLE IF EXISTS `alert_mailsms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alert_mailsms` (
  `0sendmail` tinyint(1) NOT NULL DEFAULT '0',
  `0sendsms` tinyint(1) NOT NULL DEFAULT '0',
  `1sendmail` tinyint(1) NOT NULL DEFAULT '0',
  `1sendsms` tinyint(1) NOT NULL DEFAULT '0',
  `2sendmail` tinyint(1) NOT NULL DEFAULT '0',
  `2sendsms` tinyint(1) NOT NULL DEFAULT '0',
  `4sendmail` tinyint(1) NOT NULL DEFAULT '0',
  `4sendsms` tinyint(1) NOT NULL DEFAULT '0',
  `smtpip` varchar(20) NOT NULL DEFAULT '',
  `smtpport` varchar(5) NOT NULL DEFAULT '25',
  `smtpuser` varchar(255) NOT NULL DEFAULT '',
  `smtppwd` varchar(255) NOT NULL DEFAULT '',
  `sms_warning` tinyint(1) DEFAULT NULL,
  `mail_warning` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alllogs20150104`
--

DROP TABLE IF EXISTS `alllogs20150104`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alllogs20150104` (
  `id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_cache`
--

DROP TABLE IF EXISTS `app_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_cache` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_type` varchar(20) DEFAULT NULL,
  `last_value` double(15,2) DEFAULT NULL,
  `port` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_config`
--

DROP TABLE IF EXISTS `app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_config` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `app_get` varchar(20) DEFAULT NULL,
  `port` int(5) unsigned DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_day_report`
--

DROP TABLE IF EXISTS `app_day_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_day_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `app_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_errlog`
--

DROP TABLE IF EXISTS `app_errlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_errlog` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `context` mediumtext,
  `port` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_month_report`
--

DROP TABLE IF EXISTS `app_month_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_month_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `app_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_plsqlhistory_log`
--

DROP TABLE IF EXISTS `app_plsqlhistory_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_plsqlhistory_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `excutetime` datetime NOT NULL COMMENT '????',
  `username` varchar(31) NOT NULL DEFAULT '' COMMENT '?????????',
  `dbname` varchar(81) NOT NULL DEFAULT '' COMMENT '?????',
  `sqltext` varchar(4001) NOT NULL DEFAULT '' COMMENT 'sql??',
  `appcommids` varchar(50) NOT NULL DEFAULT '' COMMENT '??????????id',
  `memberid` int(11) NOT NULL COMMENT '????????',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_status`
--

DROP TABLE IF EXISTS `app_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_status` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_type` varchar(20) DEFAULT NULL,
  `value` double(15,4) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  `port` int(10) unsigned DEFAULT NULL,
  `alarm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_warning_log`
--

DROP TABLE IF EXISTS `app_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_warning_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_type` varchar(20) DEFAULT NULL,
  `cur_val` int(8) DEFAULT NULL,
  `thold` int(8) DEFAULT NULL,
  `context` mediumtext,
  `mail_status` tinyint(2) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  `port` int(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20068 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `app_week_report`
--

DROP TABLE IF EXISTS `app_week_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_week_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `port` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `app_name` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appcomm`
--

DROP TABLE IF EXISTS `appcomm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appcomm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `appname` varchar(80) NOT NULL,
  `apppath` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `memberid` int(11) NOT NULL,
  `serverip` varchar(20) NOT NULL,
  `addr` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1459 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appdevices`
--

DROP TABLE IF EXISTS `appdevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appdevices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apppubid` int(11) NOT NULL DEFAULT '0',
  `device_ip` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `old_password` varchar(50) DEFAULT NULL,
  `cur_password` varchar(50) DEFAULT NULL,
  `last_update_time` datetime NOT NULL,
  `change_password` tinyint(1) NOT NULL DEFAULT '0',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `oracle_db` varchar(50) DEFAULT NULL,
  `oracle_auth` varchar(50) DEFAULT NULL,
  `oracle_name` varchar(50) DEFAULT NULL,
  `entrust_password` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appgroup`
--

DROP TABLE IF EXISTS `appgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `appdeviceid` int(11) NOT NULL,
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appicon`
--

DROP TABLE IF EXISTS `appicon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appicon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `path` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applog`
--

DROP TABLE IF EXISTS `applog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `host` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `mail_status` tinyint(2) unsigned DEFAULT '2',
  `sms_status` tinyint(2) unsigned DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=624 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applog20141202`
--

DROP TABLE IF EXISTS `applog20141202`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog20141202` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=624 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applog20150714`
--

DROP TABLE IF EXISTS `applog20150714`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog20150714` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `host` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `mail_status` tinyint(2) unsigned DEFAULT '2',
  `sms_status` tinyint(2) unsigned DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=624 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applog_config`
--

DROP TABLE IF EXISTS `applog_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `msg` varchar(255) DEFAULT NULL,
  `instruction` varchar(255) DEFAULT NULL,
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applog_warning`
--

DROP TABLE IF EXISTS `applog_warning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applog_warning` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `mail_status` tinyint(2) unsigned DEFAULT '2',
  `sms_status` tinyint(2) unsigned DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applogin`
--

DROP TABLE IF EXISTS `applogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applogin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `title` char(255) DEFAULT NULL,
  `appdeviceID` int(11) DEFAULT NULL,
  `uTagname` char(10) DEFAULT NULL,
  `uTagAttributeType` enum('1','2','3') DEFAULT NULL,
  `uTagAttributeValue` char(255) DEFAULT NULL,
  `pTagname` char(255) DEFAULT NULL,
  `pTagAttributeType` enum('1','2','3') DEFAULT NULL,
  `pTagAttributeValue` char(255) DEFAULT NULL,
  `cTagname` char(255) DEFAULT NULL,
  `cTagAttributeType` enum('1','2','3') DEFAULT NULL,
  `cTagAttributeValue` char(255) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applogin_day`
--

DROP TABLE IF EXISTS `applogin_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applogin_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `apppath` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applogin_diy`
--

DROP TABLE IF EXISTS `applogin_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applogin_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `apppath` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applogin_month`
--

DROP TABLE IF EXISTS `applogin_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applogin_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `apppath` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `applogin_week`
--

DROP TABLE IF EXISTS `applogin_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `applogin_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `apppath` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appmember`
--

DROP TABLE IF EXISTS `appmember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appmember` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL,
  `appdeviceid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appprogram`
--

DROP TABLE IF EXISTS `appprogram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appprogram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `description` varchar(80) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `autologin` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apppserver`
--

DROP TABLE IF EXISTS `apppserver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apppserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `appserverip` varchar(32) DEFAULT NULL,
  `description` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `apppub`
--

DROP TABLE IF EXISTS `apppub`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apppub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `description` varchar(80) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `appserverip` varchar(32) DEFAULT NULL,
  `autologinflag` int(11) NOT NULL DEFAULT '0',
  `url` varchar(600) DEFAULT NULL,
  `dynamicFlag` tinyint(1) DEFAULT '0',
  `appprogramname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=167 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appreport_day`
--

DROP TABLE IF EXISTS `appreport_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appreport_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appreport_diy`
--

DROP TABLE IF EXISTS `appreport_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appreport_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appreport_month`
--

DROP TABLE IF EXISTS `appreport_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appreport_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appreport_week`
--

DROP TABLE IF EXISTS `appreport_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appreport_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `serverip` varchar(40) NOT NULL,
  `appname` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appresourcegroup`
--

DROP TABLE IF EXISTS `appresourcegroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appresourcegroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `appgroupname` varchar(20) NOT NULL,
  `appdevicesid` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `appurl`
--

DROP TABLE IF EXISTS `appurl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `appurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fetchkey` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start` varchar(255) DEFAULT NULL,
  `usedtime` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '',
  `specification` varchar(255) NOT NULL DEFAULT '',
  `device_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `audit_host_rrd`
--

DROP TABLE IF EXISTS `audit_host_rrd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_host_rrd` (
  `ip` varchar(15) NOT NULL,
  `type` enum('cpu_system','cpu_user','cpu_nice','core','memory_free','memory_buffer','memory_cache','memory_total','swap','disk','app','physical_memory','virtual_memory','cpu_all_core','env','network','network-package','cpu_total') NOT NULL,
  `local_graph_id` int(11) NOT NULL DEFAULT '0',
  `local_data_id` int(11) NOT NULL DEFAULT '0',
  `ds` varchar(255) NOT NULL DEFAULT '',
  `rrd` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `auditip`
--

DROP TABLE IF EXISTS `auditip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auditip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autobackup_index`
--

DROP TABLE IF EXISTS `autobackup_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autobackup_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` int(11) NOT NULL DEFAULT '0',
  `scriptpath` varchar(255) DEFAULT NULL,
  `interval` int(11) NOT NULL DEFAULT '0',
  `lastruntime` datetime DEFAULT '0000-00-00 00:00:00',
  `su` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  `startup` tinyint(1) NOT NULL DEFAULT '0',
  `running` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autobackup_index_devices`
--

DROP TABLE IF EXISTS `autobackup_index_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autobackup_index_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autobackup_id` int(11) NOT NULL DEFAULT '0',
  `devicesid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autobackup_log`
--

DROP TABLE IF EXISTS `autobackup_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autobackup_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverip` varchar(128) DEFAULT NULL,
  `servername` varchar(128) DEFAULT NULL,
  `backuptime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logpath` varchar(255) DEFAULT NULL,
  `statuts` tinyint(1) NOT NULL DEFAULT '1',
  `message` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autodelete`
--

DROP TABLE IF EXISTS `autodelete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autodelete` (
  `time` int(5) DEFAULT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `file_or_db` tinyint(2) DEFAULT NULL,
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autologin_network`
--

DROP TABLE IF EXISTS `autologin_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autologin_network` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `remoteuser` varchar(20) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `netmask` tinyint(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autologin_users`
--

DROP TABLE IF EXISTS `autologin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autologin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `remoteuser` varchar(20) NOT NULL,
  `password` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_detail_config`
--

DROP TABLE IF EXISTS `autorun_detail_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_detail_config` (
  `id` bigint(14) unsigned NOT NULL AUTO_INCREMENT,
  `autorun_index_id` int(10) unsigned DEFAULT NULL,
  `line_number` int(10) unsigned DEFAULT NULL,
  `action` enum('c','d') DEFAULT NULL,
  `regex` varchar(10) DEFAULT NULL,
  `low_value` int(10) unsigned DEFAULT NULL,
  `high_value` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_index`
--

DROP TABLE IF EXISTS `autorun_index`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deviceid` int(11) DEFAULT NULL,
  `scriptpath` varchar(255) DEFAULT NULL,
  `period` int(11) NOT NULL DEFAULT '2',
  `lastruntime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `su` tinyint(1) NOT NULL DEFAULT '0',
  `desc` varchar(16) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `localpath` varchar(255) NOT NULL,
  `uploadpath` varchar(255) DEFAULT NULL,
  `upload` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_index_devices`
--

DROP TABLE IF EXISTS `autorun_index_devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_index_devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autorun_id` int(11) NOT NULL DEFAULT '0',
  `devicesid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_log`
--

DROP TABLE IF EXISTS `autorun_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverip` varchar(128) DEFAULT NULL,
  `servername` varchar(128) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `checktime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `flag` int(11) NOT NULL,
  `statuts` tinyint(1) NOT NULL DEFAULT '1',
  `message` varchar(255) DEFAULT NULL,
  `remotefile` varchar(255) DEFAULT NULL,
  `localfile` varchar(255) DEFAULT NULL,
  `command` varchar(255) DEFAULT NULL,
  `recordpath` varchar(255) DEFAULT NULL,
  `regularexp` varchar(255) DEFAULT NULL,
  `matchsum` int(11) DEFAULT NULL,
  `matchlineno` int(11) DEFAULT NULL,
  `matchso` int(11) DEFAULT NULL,
  `matcheo` int(11) DEFAULT NULL,
  `matchsubstr` varchar(255) DEFAULT NULL,
  `matchlinestr` varchar(4095) DEFAULT NULL,
  `matchtrue` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=979 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_result`
--

DROP TABLE IF EXISTS `autorun_result`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `device_id` int(11) unsigned NOT NULL DEFAULT '0',
  `autorun_index_id` int(11) unsigned NOT NULL DEFAULT '0',
  `result` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `output_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_result_detail`
--

DROP TABLE IF EXISTS `autorun_result_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_result_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `autorun_result_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cmd` varchar(255) DEFAULT NULL,
  `action` varchar(10) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autorun_template`
--

DROP TABLE IF EXISTS `autorun_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorun_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `scriptpath` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `runtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autotempate_autorun`
--

DROP TABLE IF EXISTS `autotempate_autorun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autotempate_autorun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `autorun_id` int(11) NOT NULL DEFAULT '0',
  `autotemplate_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `autotemplate`
--

DROP TABLE IF EXISTS `autotemplate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autotemplate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scriptpath` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `file_path` varchar(200) NOT NULL,
  `is_modified` tinyint(1) NOT NULL,
  `last_modified_time` datetime NOT NULL,
  `mail_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_err_log`
--

DROP TABLE IF EXISTS `backup_err_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_err_log` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(20) DEFAULT NULL,
  `reason` mediumtext,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_log`
--

DROP TABLE IF EXISTS `backup_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `dblog` tinyint(1) DEFAULT NULL,
  `filelog` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=229 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_passwd_log`
--

DROP TABLE IF EXISTS `backup_passwd_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_passwd_log` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(20) DEFAULT NULL,
  `reason` mediumtext,
  `src_ip` varchar(20) DEFAULT NULL,
  `result` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_session_device`
--

DROP TABLE IF EXISTS `backup_session_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_session_device` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`device_ip`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_session_log`
--

DROP TABLE IF EXISTS `backup_session_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_session_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT NULL,
  `table_name` varchar(30) DEFAULT NULL,
  `sessionid` int(10) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3240 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `backup_setting`
--

DROP TABLE IF EXISTS `backup_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_setting` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `port` smallint(6) NOT NULL,
  `dbactive` tinyint(1) DEFAULT NULL,
  `fileactive` tinyint(1) DEFAULT NULL,
  `user` varchar(20) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  `mysqluser` varchar(20) DEFAULT NULL,
  `mysqlpasswd` varchar(100) DEFAULT NULL,
  `path` varchar(100) DEFAULT NULL,
  `enable` int(11) NOT NULL,
  `dbname` varchar(100) DEFAULT NULL,
  `session_flag` tinyint(1) DEFAULT '0',
  `protocol` varchar(15) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bank_auth`
--

DROP TABLE IF EXISTS `bank_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bank_auth` (
  `time` varchar(128) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `port` varchar(20) DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baseline`
--

DROP TABLE IF EXISTS `baseline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baseline` (
  `ip` char(20) DEFAULT NULL,
  `audit_item` int(11) DEFAULT NULL,
  `baseline` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `baseline_checkreports`
--

DROP TABLE IF EXISTS `baseline_checkreports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `baseline_checkreports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` mediumint(8) NOT NULL DEFAULT '0',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `baseline_template` varchar(256) NOT NULL DEFAULT '',
  `check_result` varchar(256) NOT NULL DEFAULT '',
  `oknums` int(10) unsigned NOT NULL DEFAULT '0',
  `failnums` int(10) unsigned NOT NULL DEFAULT '0',
  `unchecknums` int(10) unsigned NOT NULL DEFAULT '0',
  `filepath` varchar(256) NOT NULL DEFAULT '',
  `check_score` int(5) NOT NULL DEFAULT '0',
  `check_rate` int(5) NOT NULL DEFAULT '0',
  `jid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cactiversion`
--

DROP TABLE IF EXISTS `cactiversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cactiversion` (
  `cacti` char(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `catosys`
--

DROP TABLE IF EXISTS `catosys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catosys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `keyid` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cdef`
--

DROP TABLE IF EXISTS `cdef`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdef` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cdef_items`
--

DROP TABLE IF EXISTS `cdef_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cdef_items` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `cdef_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sequence` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(2) NOT NULL DEFAULT '0',
  `value` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `cdef_id` (`cdef_id`)
) ENGINE=MyISAM AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `changes`
--

DROP TABLE IF EXISTS `changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `changes` (
  `chid` int(10) NOT NULL AUTO_INCREMENT,
  `fid` int(10) NOT NULL,
  `conid` int(10) NOT NULL,
  `diffs` text NOT NULL,
  `changetime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  PRIMARY KEY (`chid`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdcache`
--

DROP TABLE IF EXISTS `cmdcache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdcache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1801 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdcache_day`
--

DROP TABLE IF EXISTS `cmdcache_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdcache_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `ocmd` varchar(255) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `at` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdcache_diy`
--

DROP TABLE IF EXISTS `cmdcache_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdcache_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `ocmd` varchar(255) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `at` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdcache_month`
--

DROP TABLE IF EXISTS `cmdcache_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdcache_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `ocmd` varchar(255) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `at` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdcache_week`
--

DROP TABLE IF EXISTS `cmdcache_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdcache_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `ocmd` varchar(255) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `at` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdlist_day`
--

DROP TABLE IF EXISTS `cmdlist_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdlist_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `cmd` varchar(255) NOT NULL,
  `at` datetime NOT NULL,
  `dangerlevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdlist_diy`
--

DROP TABLE IF EXISTS `cmdlist_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdlist_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `cmd` varchar(255) NOT NULL,
  `at` datetime NOT NULL,
  `dangerlevel` int(11) DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdlist_month`
--

DROP TABLE IF EXISTS `cmdlist_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdlist_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `cmd` varchar(255) NOT NULL,
  `at` datetime NOT NULL,
  `dangerlevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cmdlist_week`
--

DROP TABLE IF EXISTS `cmdlist_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cmdlist_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `addr` varchar(100) NOT NULL,
  `cmd` varchar(255) NOT NULL,
  `at` datetime NOT NULL,
  `dangerlevel` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `colors`
--

DROP TABLE IF EXISTS `colors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `colors` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hex` varchar(6) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commandgroup`
--

DROP TABLE IF EXISTS `commandgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(255) NOT NULL DEFAULT '',
  `commands` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commands`
--

DROP TABLE IF EXISTS `commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `at` datetime NOT NULL,
  `cmd` text NOT NULL,
  `dangerlevel` int(11) DEFAULT NULL,
  `jump_session` int(11) DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2751954 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commandstatistic_day`
--

DROP TABLE IF EXISTS `commandstatistic_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandstatistic_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(255) NOT NULL,
  `luser` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commandstatistic_diy`
--

DROP TABLE IF EXISTS `commandstatistic_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandstatistic_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(255) NOT NULL,
  `luser` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commandstatistic_month`
--

DROP TABLE IF EXISTS `commandstatistic_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandstatistic_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(255) NOT NULL,
  `luser` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `commandstatistic_week`
--

DROP TABLE IF EXISTS `commandstatistic_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandstatistic_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(255) NOT NULL,
  `luser` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `cid` int(10) NOT NULL AUTO_INCREMENT,
  `fid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `interface` varchar(50) NOT NULL,
  `default` text NOT NULL,
  `attributes` varchar(1024) NOT NULL,
  `updatetime` datetime NOT NULL,
  `addtime` datetime NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config_audit_dev`
--

DROP TABLE IF EXISTS `config_audit_dev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_audit_dev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conn_type` enum('telnet','ssh') DEFAULT NULL,
  `dev_type` char(100) DEFAULT NULL,
  `ip` char(15) DEFAULT NULL,
  `port` char(6) DEFAULT NULL,
  `user_username` char(30) DEFAULT NULL,
  `user_pass` char(30) DEFAULT NULL,
  `enable_pass` char(30) DEFAULT NULL,
  `template` int(11) DEFAULT NULL,
  `diff` tinyint(2) DEFAULT NULL,
  `detail` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config_audit_template_files`
--

DROP TABLE IF EXISTS `config_audit_template_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_audit_template_files` (
  `tid` int(11) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `fpath` char(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config_audit_templates`
--

DROP TABLE IF EXISTS `config_audit_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_audit_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `configreport`
--

DROP TABLE IF EXISTS `configreport`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` char(255) NOT NULL,
  `template` varchar(255) NOT NULL,
  `createtime` datetime NOT NULL,
  `cycle` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cronreports`
--

DROP TABLE IF EXISTS `cronreports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cronreports` (
  `week` varchar(255) NOT NULL DEFAULT '',
  `month` varchar(255) NOT NULL DEFAULT '',
  `day` varchar(255) DEFAULT NULL,
  `weekusers` text,
  `monthusers` text,
  `dayusers` text,
  `template` varchar(30) NOT NULL,
  `applytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dayusername` varchar(255) NOT NULL,
  `dayserver` varchar(255) NOT NULL,
  `dayugroupid` int(11) NOT NULL DEFAULT '0',
  `daysgroupid` int(11) NOT NULL DEFAULT '0',
  `weekusername` varchar(255) NOT NULL,
  `weekserver` varchar(255) NOT NULL,
  `weekugroupid` int(11) NOT NULL DEFAULT '0',
  `weeksgroupid` int(11) NOT NULL DEFAULT '0',
  `monthusername` varchar(255) NOT NULL,
  `monthserver` varchar(255) NOT NULL,
  `monthugroupid` int(11) NOT NULL DEFAULT '0',
  `monthsgroupid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crontab_report_file`
--

DROP TABLE IF EXISTS `crontab_report_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crontab_report_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filepath` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `crontablog`
--

DROP TABLE IF EXISTS `crontablog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crontablog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `host` varchar(255) NOT NULL,
  `cmd` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1872 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdlistreport_day`
--

DROP TABLE IF EXISTS `dangercmdlistreport_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdlistreport_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `dangerlevel` int(11) NOT NULL DEFAULT '0',
  `at` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdlistreport_diy`
--

DROP TABLE IF EXISTS `dangercmdlistreport_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdlistreport_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `dangerlevel` int(11) NOT NULL DEFAULT '0',
  `at` datetime NOT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdlistreport_month`
--

DROP TABLE IF EXISTS `dangercmdlistreport_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdlistreport_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `dangerlevel` int(11) NOT NULL DEFAULT '0',
  `at` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdlistreport_week`
--

DROP TABLE IF EXISTS `dangercmdlistreport_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdlistreport_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `dangerlevel` int(11) NOT NULL DEFAULT '0',
  `at` datetime NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdreport_day`
--

DROP TABLE IF EXISTS `dangercmdreport_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdreport_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdreport_diy`
--

DROP TABLE IF EXISTS `dangercmdreport_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdreport_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdreport_month`
--

DROP TABLE IF EXISTS `dangercmdreport_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdreport_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangercmdreport_week`
--

DROP TABLE IF EXISTS `dangercmdreport_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangercmdreport_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `luser` varchar(100) NOT NULL,
  `device_ip` varchar(100) NOT NULL,
  `cmd` varchar(100) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dangerscmds`
--

DROP TABLE IF EXISTS `dangerscmds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dangerscmds` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cmd` text,
  `level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db2_commands`
--

DROP TABLE IF EXISTS `db2_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db2_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `return_code` int(11) DEFAULT NULL,
  `danger` int(1) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=3785 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db2_sessions`
--

DROP TABLE IF EXISTS `db2_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db2_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=690 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_ac_group`
--

DROP TABLE IF EXISTS `db_ac_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_ac_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=277 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db2_commands`
--

DROP TABLE IF EXISTS `db_db2_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db2_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `success` int(1) DEFAULT NULL,
  `return_time` int(11) DEFAULT NULL,
  `level` int(5) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db2_sessions`
--

DROP TABLE IF EXISTS `db_db2_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db2_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT NULL,
  `s_mac` char(255) DEFAULT NULL,
  `d_mac` char(255) DEFAULT NULL,
  `commands` int(5) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_ipgroup`
--

DROP TABLE IF EXISTS `db_db_ipgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_ipgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `ip` char(20) NOT NULL,
  `netmask` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_ipgroup_desc`
--

DROP TABLE IF EXISTS `db_db_ipgroup_desc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_ipgroup_desc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` char(255) DEFAULT NULL,
  `descr` varchar(500) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_login_account`
--

DROP TABLE IF EXISTS `db_db_login_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_login_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_login_account_monthly`
--

DROP TABLE IF EXISTS `db_db_login_account_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_login_account_monthly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133518 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_login_account_weekly`
--

DROP TABLE IF EXISTS `db_db_login_account_weekly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_login_account_weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=503932 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_sql_account`
--

DROP TABLE IF EXISTS `db_db_sql_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_sql_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1241 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_sql_account_monthly`
--

DROP TABLE IF EXISTS `db_db_sql_account_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_sql_account_monthly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1122418 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_db_sql_account_weekly`
--

DROP TABLE IF EXISTS `db_db_sql_account_weekly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_db_sql_account_weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2400852 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbauditpolicy`
--

DROP TABLE IF EXISTS `db_dbauditpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbauditpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `server_ipgroup` int(11) DEFAULT NULL,
  `client_ipgroup` int(11) DEFAULT NULL,
  `systemuser` char(255) DEFAULT NULL,
  `dbuser` char(255) DEFAULT NULL,
  `sourcemac` char(255) DEFAULT NULL,
  `return_line_number` int(11) DEFAULT NULL,
  `result_title` text,
  `result_content` text,
  `replyinfo` char(255) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `level` int(5) NOT NULL DEFAULT '0',
  `mail` tinyint(1) DEFAULT '0',
  `syslog` tinyint(1) DEFAULT '0',
  `policy_order` int(11) DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbauditpolicy_sqloption`
--

DROP TABLE IF EXISTS `db_dbauditpolicy_sqloption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbauditpolicy_sqloption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `sqlopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`sqlopt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbserver`
--

DROP TABLE IF EXISTS `db_dbserver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(255) NOT NULL,
  `hostname` char(255) NOT NULL,
  `dbtype` char(255) NOT NULL,
  `desc` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbserverinfo`
--

DROP TABLE IF EXISTS `db_dbserverinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbserverinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_addr` char(16) DEFAULT NULL,
  `dbtype` char(16) DEFAULT NULL,
  `hostname` varchar(255) NOT NULL,
  `des` varchar(255) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=648 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbsniffer`
--

DROP TABLE IF EXISTS `db_dbsniffer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbsniffer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(255) NOT NULL,
  `hostname` char(255) NOT NULL,
  `interface` char(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `record` tinyint(1) DEFAULT '1',
  `time` int(11) NOT NULL DEFAULT '0',
  `desc` char(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_dbtrustip`
--

DROP TABLE IF EXISTS `db_dbtrustip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_dbtrustip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `trust_ipgroup` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`trust_ipgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_forbidden_commands`
--

DROP TABLE IF EXISTS `db_forbidden_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_forbidden_commands` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(20) DEFAULT NULL,
  `cmd` text,
  `level` int(1) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_ipgroup`
--

DROP TABLE IF EXISTS `db_ipgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_ipgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `ip` char(20) NOT NULL,
  `netmask` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_ipgroup_desc`
--

DROP TABLE IF EXISTS `db_ipgroup_desc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_ipgroup_desc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` char(255) DEFAULT NULL,
  `descr` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_login_account`
--

DROP TABLE IF EXISTS `db_login_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_login_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_login_account_monthly`
--

DROP TABLE IF EXISTS `db_login_account_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_login_account_monthly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=133515 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_login_account_weekly`
--

DROP TABLE IF EXISTS `db_login_account_weekly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_login_account_weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=503883 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_mysql_commands`
--

DROP TABLE IF EXISTS `db_mysql_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_mysql_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `danger` int(1) DEFAULT NULL,
  `return_code` mediumtext,
  PRIMARY KEY (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_mysql_dbauditpolicy`
--

DROP TABLE IF EXISTS `db_mysql_dbauditpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_mysql_dbauditpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `server_ipgroup` int(11) DEFAULT NULL,
  `client_ipgroup` int(11) DEFAULT NULL,
  `dbuser` char(255) DEFAULT NULL,
  `sourcemac` char(255) DEFAULT NULL,
  `replyinfo` char(255) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `level` int(5) NOT NULL DEFAULT '0',
  `mail` tinyint(1) DEFAULT '0',
  `syslog` tinyint(1) DEFAULT '0',
  `policy_order` int(11) DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_mysql_dbauditpolicy_sqloption`
--

DROP TABLE IF EXISTS `db_mysql_dbauditpolicy_sqloption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_mysql_dbauditpolicy_sqloption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `sqlopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`sqlopt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_mysql_dbtrustip`
--

DROP TABLE IF EXISTS `db_mysql_dbtrustip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_mysql_dbtrustip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `trust_ipgroup` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`trust_ipgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_mysql_sessions`
--

DROP TABLE IF EXISTS `db_mysql_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_mysql_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT NULL,
  `commands` int(5) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_oracle_commands`
--

DROP TABLE IF EXISTS `db_oracle_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_oracle_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `cmd_bytes` int(11) DEFAULT NULL,
  `result_bytes` int(11) DEFAULT NULL,
  `return_code` mediumtext,
  `return_time` int(11) DEFAULT NULL,
  `return_result_content` text,
  `return_result_title` mediumtext,
  `level` int(5) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_oracle_dbauditpolicy`
--

DROP TABLE IF EXISTS `db_oracle_dbauditpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_oracle_dbauditpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `server_ipgroup` int(11) DEFAULT NULL,
  `client_ipgroup` int(11) DEFAULT NULL,
  `systemuser` char(255) DEFAULT NULL,
  `dbuser` char(255) DEFAULT NULL,
  `sourcemac` char(255) DEFAULT NULL,
  `return_line_number` int(11) DEFAULT NULL,
  `result_title` text,
  `result_content` text,
  `replyinfo` char(255) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `level` int(5) NOT NULL DEFAULT '0',
  `mail` tinyint(1) DEFAULT '0',
  `syslog` tinyint(1) DEFAULT '0',
  `policy_order` int(11) DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_oracle_dbauditpolicy_sqloption`
--

DROP TABLE IF EXISTS `db_oracle_dbauditpolicy_sqloption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_oracle_dbauditpolicy_sqloption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `sqlopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`sqlopt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_oracle_dbtrustip`
--

DROP TABLE IF EXISTS `db_oracle_dbtrustip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_oracle_dbtrustip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `trust_ipgroup` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`trust_ipgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_oracle_sessions`
--

DROP TABLE IF EXISTS `db_oracle_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_oracle_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `system_user` char(255) DEFAULT NULL,
  `client_hostname` varchar(255) DEFAULT NULL,
  `program` char(255) DEFAULT NULL,
  `ora_service_name` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  `s_mac` char(255) DEFAULT NULL,
  `d_mac` char(255) DEFAULT NULL,
  `total_cmd` int(11) DEFAULT '0',
  `login_success` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_pcap_black_list`
--

DROP TABLE IF EXISTS `db_pcap_black_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_pcap_black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `netmask` int(9) DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sql_account`
--

DROP TABLE IF EXISTS `db_sql_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sql_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `day` date DEFAULT NULL,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1186 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sql_account_monthly`
--

DROP TABLE IF EXISTS `db_sql_account_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sql_account_monthly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `day` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1122401 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sql_account_weekly`
--

DROP TABLE IF EXISTS `db_sql_account_weekly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sql_account_weekly` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(20) DEFAULT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `sqlcmd` varchar(1024) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2400640 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqloptions`
--

DROP TABLE IF EXISTS `db_sqloptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqloptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `optionsname` char(255) DEFAULT NULL,
  `sql_cmd` char(255) DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqlserver_commands`
--

DROP TABLE IF EXISTS `db_sqlserver_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqlserver_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` text,
  `cmd_bytes` int(11) DEFAULT NULL,
  `result_bytes` int(11) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `return_time` int(11) DEFAULT NULL,
  `level` int(5) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqlserver_dbauditpolicy`
--

DROP TABLE IF EXISTS `db_sqlserver_dbauditpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqlserver_dbauditpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `server_ipgroup` int(11) DEFAULT NULL,
  `client_ipgroup` int(11) DEFAULT NULL,
  `dbuser` char(255) DEFAULT NULL,
  `sourcemac` char(255) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `level` int(5) NOT NULL DEFAULT '0',
  `mail` tinyint(1) DEFAULT '0',
  `syslog` tinyint(1) DEFAULT '0',
  `policy_order` int(11) DEFAULT '50',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqlserver_dbauditpolicy_sqloption`
--

DROP TABLE IF EXISTS `db_sqlserver_dbauditpolicy_sqloption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqlserver_dbauditpolicy_sqloption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `sqlopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`sqlopt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqlserver_dbtrustip`
--

DROP TABLE IF EXISTS `db_sqlserver_dbtrustip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqlserver_dbtrustip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `trust_ipgroup` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`trust_ipgroup`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sqlserver_sessions`
--

DROP TABLE IF EXISTS `db_sqlserver_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sqlserver_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  `s_mac` char(255) DEFAULT NULL,
  `d_mac` char(255) DEFAULT NULL,
  `commands` int(5) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sybase_commands`
--

DROP TABLE IF EXISTS `db_sybase_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sybase_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` text,
  `danger` int(1) DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `db_sybase_sessions`
--

DROP TABLE IF EXISTS `db_sybase_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `db_sybase_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  `commands` int(5) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbauditpolicy`
--

DROP TABLE IF EXISTS `dbauditpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbauditpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '0',
  `server_ipgroup` int(11) DEFAULT NULL,
  `client_ipgroup` int(11) DEFAULT NULL,
  `systemuser` char(255) DEFAULT NULL,
  `dbuser` char(255) DEFAULT NULL,
  `sourcemac` char(255) DEFAULT NULL,
  `return_line_number` int(11) DEFAULT NULL,
  `replyinfo` char(255) DEFAULT NULL,
  `success` int(1) DEFAULT NULL,
  `level` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbauditpolicy_sqloption`
--

DROP TABLE IF EXISTS `dbauditpolicy_sqloption`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbauditpolicy_sqloption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `sqlopt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`sqlopt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dbtrustip`
--

DROP TABLE IF EXISTS `dbtrustip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbtrustip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `db_policy_id` int(11) NOT NULL,
  `trust_ipgroup` int(11) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `db_policy_id` (`db_policy_id`,`trust_ipgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `defaultpolicy`
--

DROP TABLE IF EXISTS `defaultpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `defaultpolicy` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `autosu` tinyint(1) DEFAULT '0',
  `syslogalert` tinyint(1) DEFAULT NULL,
  `mailalert` tinyint(1) DEFAULT NULL,
  `loginlock` tinyint(1) DEFAULT NULL,
  `weektime` varchar(255) DEFAULT NULL,
  `sourceip` varchar(255) DEFAULT '',
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `netdisksize` int(5) NOT NULL DEFAULT '0',
  `default_control` tinyint(1) NOT NULL DEFAULT '0',
  `entrust_password` tinyint(1) NOT NULL DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `ipv6enable` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dev`
--

DROP TABLE IF EXISTS `dev`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dev` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `ip` char(15) NOT NULL,
  `devname` varchar(255) NOT NULL,
  `devtype` enum('session','oracle','ftp','web','sftp','rdp','vnc') DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=MyISAM AUTO_INCREMENT=32079 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `phone_id` varchar(32) DEFAULT NULL,
  `pc_id` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `device_html`
--

DROP TABLE IF EXISTS `device_html`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `device_prompts`
--

DROP TABLE IF EXISTS `device_prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_prompts` (
  `device_id` int(11) NOT NULL DEFAULT '0',
  `prompt` char(128) NOT NULL DEFAULT '',
  `insert_time` datetime DEFAULT NULL,
  UNIQUE KEY `device_id` (`device_id`,`prompt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `login_method` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `old_password` varchar(500) DEFAULT NULL,
  `cur_password` varchar(500) DEFAULT NULL,
  `last_update_time` datetime NOT NULL,
  `port` int(11) NOT NULL,
  `device_type` int(11) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `limit_time` date NOT NULL,
  `automodify` int(11) NOT NULL,
  `luser` varchar(200) NOT NULL,
  `master_user` tinyint(1) DEFAULT '0',
  `log_tab` int(11) NOT NULL DEFAULT '0',
  `passwordtry` int(11) DEFAULT NULL,
  `changesure` tinyint(11) DEFAULT NULL,
  `lgroup` varchar(200) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `entrust_password` tinyint(1) NOT NULL DEFAULT '1',
  `change_password` tinyint(1) NOT NULL DEFAULT '0',
  `entrust_username` tinyint(1) NOT NULL DEFAULT '1',
  `publickey_auth` tinyint(1) DEFAULT '0',
  `radiususer` int(11) NOT NULL DEFAULT '0',
  `encoding` int(5) DEFAULT '0',
  `sshprivatekey` varchar(255) DEFAULT NULL,
  `sshpublickey` varchar(255) DEFAULT NULL,
  `sftp` tinyint(1) DEFAULT '0',
  `first_prompt` char(128) NOT NULL DEFAULT '',
  `logincommit` tinyint(1) NOT NULL DEFAULT '0',
  `commanduser` int(11) NOT NULL DEFAULT '0',
  `x11` tinyint(1) NOT NULL DEFAULT '1',
  `desc` varchar(255) NOT NULL,
  `mode` tinyint(1) NOT NULL DEFAULT '0',
  `new_password` varchar(500) DEFAULT NULL,
  `active_change` tinyint(1) NOT NULL DEFAULT '0',
  `su_passwd` tinyint(1) NOT NULL DEFAULT '0',
  `restrictweb` tinyint(1) DEFAULT '0',
  `timeout` int(11) DEFAULT '0',
  `ipv6` varchar(50) DEFAULT NULL,
  `ipv6enable` tinyint(1) NOT NULL DEFAULT '0',
  `key_input` tinyint(1) NOT NULL DEFAULT '1',
  `fastpath_input` tinyint(1) NOT NULL DEFAULT '0',
  `fastpath_output` tinyint(1) NOT NULL DEFAULT '0',
  `su_password` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `device_ip` (`device_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=1921 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devices_cache`
--

DROP TABLE IF EXISTS `devices_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `device_ip` varchar(50) DEFAULT NULL,
  `login_method` int(11) NOT NULL,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `old_password` varchar(500) DEFAULT NULL,
  `cur_password` varchar(500) DEFAULT NULL,
  `last_update_time` datetime NOT NULL,
  `port` int(11) NOT NULL,
  `device_type` int(11) NOT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `limit_time` date NOT NULL,
  `automodify` int(11) NOT NULL,
  `luser` varchar(200) NOT NULL,
  `master_user` tinyint(1) DEFAULT '0',
  `log_tab` int(11) NOT NULL DEFAULT '0',
  `passwordtry` int(11) DEFAULT NULL,
  `changesure` tinyint(11) DEFAULT NULL,
  `lgroup` varchar(200) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `entrust_password` tinyint(1) NOT NULL DEFAULT '1',
  `change_password` tinyint(1) NOT NULL DEFAULT '0',
  `entrust_username` tinyint(1) NOT NULL DEFAULT '1',
  `publickey_auth` tinyint(1) DEFAULT '0',
  `radiususer` int(11) NOT NULL DEFAULT '0',
  `encoding` int(5) DEFAULT '0',
  `sshprivatekey` varchar(255) DEFAULT NULL,
  `sshpublickey` varchar(255) DEFAULT NULL,
  `sftp` tinyint(1) DEFAULT '0',
  `first_prompt` char(128) NOT NULL DEFAULT '',
  `groupid` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `memberid` (`memberid`,`devicesid`)
) ENGINE=MyISAM AUTO_INCREMENT=6014447 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devices_group_cache`
--

DROP TABLE IF EXISTS `devices_group_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_group_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL DEFAULT '0',
  `groupid` int(11) NOT NULL DEFAULT '0',
  `groupname` varchar(20) NOT NULL,
  `ct` int(11) NOT NULL DEFAULT '0',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1089396 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devices_password`
--

DROP TABLE IF EXISTS `devices_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `login_method` int(11) NOT NULL,
  `hostname` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `old_password` varchar(20) NOT NULL,
  `cur_password` varchar(20) NOT NULL,
  `last_update_time` datetime NOT NULL,
  `port` int(11) NOT NULL,
  `device_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devlogin_day`
--

DROP TABLE IF EXISTS `devlogin_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devlogin_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(40) NOT NULL,
  `hostname` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devlogin_diy`
--

DROP TABLE IF EXISTS `devlogin_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devlogin_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(40) NOT NULL,
  `hostname` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devlogin_month`
--

DROP TABLE IF EXISTS `devlogin_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devlogin_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(40) NOT NULL,
  `hostname` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `devlogin_week`
--

DROP TABLE IF EXISTS `devlogin_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devlogin_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `luser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `device_ip` varchar(40) NOT NULL,
  `hostname` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL,
  `user` varchar(40) NOT NULL,
  `mstart` datetime NOT NULL,
  `mend` datetime NOT NULL,
  `ct` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `disk_check`
--

DROP TABLE IF EXISTS `disk_check`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `disk_check` (
  `check_time` date NOT NULL,
  `sshdisk` int(11) DEFAULT NULL,
  `telnetdisk` int(11) DEFAULT NULL,
  `rdpdisk` int(11) DEFAULT NULL,
  `ftpdisk` int(11) DEFAULT NULL,
  `oracledisk` int(11) DEFAULT NULL,
  `db2disk` int(11) DEFAULT NULL,
  `sqlserverdisk` int(11) DEFAULT NULL,
  `mysqldisk` int(11) DEFAULT NULL,
  `sybasedisk` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  `totaldisk` int(11) DEFAULT NULL,
  PRIMARY KEY (`check_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dns_day_report`
--

DROP TABLE IF EXISTS `dns_day_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dns_day_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4107 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dns_month_report`
--

DROP TABLE IF EXISTS `dns_month_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dns_month_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dns_status`
--

DROP TABLE IF EXISTS `dns_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dns_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `type` smallint(2) DEFAULT NULL,
  `delayvalue` smallint(8) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=523 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dns_warning_log`
--

DROP TABLE IF EXISTS `dns_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dns_warning_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `type` int(5) unsigned DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `cur_val` int(8) DEFAULT NULL,
  `thold` int(8) DEFAULT NULL,
  `context` mediumtext,
  `mail_status` tinyint(2) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=363383 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dns_week_report`
--

DROP TABLE IF EXISTS `dns_week_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dns_week_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` int(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `avg` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=591 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eventlogs`
--

DROP TABLE IF EXISTS `eventlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventlogs` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logserver` varchar(32) DEFAULT NULL,
  `msg_level` int(8) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `logsource` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `facility`
--

DROP TABLE IF EXISTS `facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facility` (
  `fid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `describe` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `port` varchar(10) NOT NULL,
  `community` varchar(255) DEFAULT NULL,
  `type` enum('snmp','rsync','ssh','telnet') NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `addtime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  `lastchangetime` datetime NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forbidden_commands`
--

DROP TABLE IF EXISTS `forbidden_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forbidden_commands` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(20) DEFAULT NULL,
  `radius_user` char(64) DEFAULT NULL,
  `cmd` text,
  `level` int(1) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forbidden_commands_groups`
--

DROP TABLE IF EXISTS `forbidden_commands_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forbidden_commands_groups` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cmd` text,
  `level` int(1) DEFAULT NULL,
  `gid` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forbidden_commands_user`
--

DROP TABLE IF EXISTS `forbidden_commands_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forbidden_commands_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `addr` char(20) DEFAULT NULL,
  `radius_user` char(64) DEFAULT NULL,
  `gid` varchar(30) DEFAULT NULL,
  `weektime` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forbidden_groups`
--

DROP TABLE IF EXISTS `forbidden_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forbidden_groups` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `gname` char(20) DEFAULT NULL,
  `black_or_white` int(1) DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `creatorid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftp_command`
--

DROP TABLE IF EXISTS `ftp_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftp_command` (
  `sid` bigint(20) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `session_desc` enum('cmd','reply') DEFAULT NULL,
  `cmd` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftp_sessions`
--

DROP TABLE IF EXISTS `ftp_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftp_sessions` (
  `sid` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpcomm`
--

DROP TABLE IF EXISTS `ftpcomm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpcomm` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `comm` char(255) NOT NULL,
  `at` datetime NOT NULL,
  `filename` varchar(300) DEFAULT NULL,
  `run` int(1) DEFAULT NULL,
  `backupflag` tinyint(1) DEFAULT '0',
  `backupsize` int(11) DEFAULT '0',
  `backup` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpreport_day`
--

DROP TABLE IF EXISTS `ftpreport_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpreport_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpreport_diy`
--

DROP TABLE IF EXISTS `ftpreport_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpreport_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpreport_month`
--

DROP TABLE IF EXISTS `ftpreport_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpreport_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpreport_week`
--

DROP TABLE IF EXISTS `ftpreport_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpreport_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ftpsessions`
--

DROP TABLE IF EXISTS `ftpsessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ftpsessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cliaddr` varchar(50) DEFAULT NULL,
  `svraddr` varchar(50) DEFAULT NULL,
  `auditaddr` varchar(50) DEFAULT NULL,
  `radius_user` char(255) DEFAULT NULL,
  `ftp_user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `replayfile` varchar(300) DEFAULT NULL,
  `run` int(1) DEFAULT NULL,
  `SMAC` char(255) DEFAULT NULL,
  `DMAC` char(255) DEFAULT NULL,
  `total_cmd` int(11) DEFAULT '0',
  `sport` char(10) NOT NULL DEFAULT '0',
  `dport` char(10) NOT NULL DEFAULT '0',
  `logincommit` int(11) NOT NULL DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  `report` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `radius_user` (`radius_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ha`
--

DROP TABLE IF EXISTS `ha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ha` (
  `hsrpip` varchar(30) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `masterip` varchar(30) DEFAULT NULL,
  `interface` varchar(10) DEFAULT NULL,
  `netmask` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `http_command`
--

DROP TABLE IF EXISTS `http_command`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `http_command` (
  `sid` bigint(20) DEFAULT NULL,
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `at` datetime DEFAULT NULL,
  `session_desc` char(255) DEFAULT NULL,
  `cmd` text,
  `content` text,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=205706 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `http_session`
--

DROP TABLE IF EXISTS `http_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `http_session` (
  `sid` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=4623 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `importlog`
--

DROP TABLE IF EXISTS `importlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `importlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL DEFAULT '',
  `uptime` datetime DEFAULT '0000-00-00 00:00:00',
  `type` varchar(10) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ip`
--

DROP TABLE IF EXISTS `ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(128) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `route_temp` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ldap`
--

DROP TABLE IF EXISTS `ldap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldap` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldapname` varchar(200) NOT NULL DEFAULT '',
  `desc` varchar(500) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ldapdevice`
--

DROP TABLE IF EXISTS `ldapdevice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldapdevice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `servergroupid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ldapmanager`
--

DROP TABLE IF EXISTS `ldapmanager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldapmanager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `memberid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ldapuser`
--

DROP TABLE IF EXISTS `ldapuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ldapuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `usergroupid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lgroup`
--

DROP TABLE IF EXISTS `lgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `twoauth` int(11) NOT NULL DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  `smsalert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`devicesid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lgroup_appresourcegrp`
--

DROP TABLE IF EXISTS `lgroup_appresourcegrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lgroup_appresourcegrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `appresourceid` int(11) DEFAULT NULL,
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `loginlock` tinyint(1) DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`appresourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lgroup_devgrp`
--

DROP TABLE IF EXISTS `lgroup_devgrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lgroup_devgrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `serversid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `lgroup_resourcegrp`
--

DROP TABLE IF EXISTS `lgroup_resourcegrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lgroup_resourcegrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) DEFAULT NULL,
  `resourceid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `twoauth` int(5) DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  `smsalert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`,`resourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=424 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data`
--

DROP TABLE IF EXISTS `list_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data` (
  `ip` varchar(15) NOT NULL,
  `hosttype` varchar(20) NOT NULL,
  `type` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuelast` double NOT NULL,
  `list_host_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_day`
--

DROP TABLE IF EXISTS `list_data_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_day` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_hour`
--

DROP TABLE IF EXISTS `list_data_hour`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_hour` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_month`
--

DROP TABLE IF EXISTS `list_data_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_month` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_now`
--

DROP TABLE IF EXISTS `list_data_now`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_now` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_week`
--

DROP TABLE IF EXISTS `list_data_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_week` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_data_year`
--

DROP TABLE IF EXISTS `list_data_year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_data_year` (
  `id` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `last` double DEFAULT NULL,
  `max` double DEFAULT NULL,
  `average` double DEFAULT NULL,
  `min` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_host`
--

DROP TABLE IF EXISTS `list_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_host` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL,
  `hosttype` varchar(20) NOT NULL,
  `type` int(5) NOT NULL,
  `local_graph_id` int(11) NOT NULL DEFAULT '0',
  `formula` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `thold_hi` double NOT NULL DEFAULT '0',
  `thold_low` double NOT NULL DEFAULT '0',
  `mail_alert` tinyint(1) NOT NULL DEFAULT '0',
  `sms_alert` tinyint(1) NOT NULL DEFAULT '0',
  `time_interval` int(11) NOT NULL DEFAULT '30',
  `last_sendtime` int(11) NOT NULL DEFAULT '0',
  `enname` varchar(40) NOT NULL DEFAULT '',
  `graph_template_id` int(11) NOT NULL DEFAULT '0',
  `turntholdon` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=859 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_host_backup`
--

DROP TABLE IF EXISTS `list_host_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_host_backup` (
  `ip` varchar(15) NOT NULL,
  `hosttype` varchar(20) NOT NULL,
  `type` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `thold_hi` double NOT NULL DEFAULT '0',
  `thold_low` double NOT NULL DEFAULT '0',
  `mail_alert` tinyint(1) NOT NULL DEFAULT '0',
  `sms_alert` tinyint(1) NOT NULL DEFAULT '0',
  `time_interval` int(11) NOT NULL DEFAULT '30',
  `last_sendtime` int(11) NOT NULL DEFAULT '0',
  `enname` varchar(40) NOT NULL DEFAULT '',
  `graph_template_id` int(11) NOT NULL DEFAULT '0',
  `turntholdon` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_rrd`
--

DROP TABLE IF EXISTS `list_rrd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_rrd` (
  `id` int(11) DEFAULT NULL,
  `rrdfile` varchar(255) NOT NULL,
  `dsname` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `list_type`
--

DROP TABLE IF EXISTS `list_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_type` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `listdata_log`
--

DROP TABLE IF EXISTS `listdata_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `listdata_log` (
  `ip` varchar(15) NOT NULL,
  `last_value` double NOT NULL,
  `name` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `thold` double NOT NULL,
  `mail` tinyint(1) NOT NULL,
  `sms` tinyint(1) NOT NULL,
  KEY `ip` (`ip`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `listsnmpstatus`
--

DROP TABLE IF EXISTS `listsnmpstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `listsnmpstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `interface` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loadbalance`
--

DROP TABLE IF EXISTS `loadbalance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loadbalance` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) DEFAULT NULL,
  `hostname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `local_status`
--

DROP TABLE IF EXISTS `local_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `local_status` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `value` int(10) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  `sms_last_sendtime` datetime DEFAULT NULL,
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=41168 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `local_status_cache`
--

DROP TABLE IF EXISTS `local_status_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `local_status_cache` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `value` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `local_status_err`
--

DROP TABLE IF EXISTS `local_status_err`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `local_status_err` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_name` smallint(8) DEFAULT NULL,
  `value` smallint(8) DEFAULT NULL,
  `highvalue` int(11) DEFAULT NULL,
  `lowvalue` int(11) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `local_status_warning_log`
--

DROP TABLE IF EXISTS `local_status_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `local_status_warning_log` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` smallint(8) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `mail_status` tinyint(2) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  `context` mediumtext,
  `value` smallint(8) DEFAULT NULL,
  `thold` smallint(8) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=1573762 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `update_success_flag` varchar(5) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4059 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log20141104`
--

DROP TABLE IF EXISTS `log20141104`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log20141104` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `update_success_flag` varchar(5) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log20150714`
--

DROP TABLE IF EXISTS `log20150714`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log20150714` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `update_success_flag` varchar(5) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_alert`
--

DROP TABLE IF EXISTS `log_alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_alert` (
  `aid` int(8) NOT NULL AUTO_INCREMENT,
  `atype` enum('msg','level') NOT NULL,
  `avalue` varchar(255) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_alllogs`
--

DROP TABLE IF EXISTS `log_alllogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_alllogs` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` text,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `host` (`host`),
  KEY `program` (`program`),
  KEY `datetime` (`datetime`),
  KEY `priority` (`priority`),
  KEY `facility` (`facility`)
) ENGINE=MyISAM AUTO_INCREMENT=5315841 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_asset`
--

DROP TABLE IF EXISTS `log_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_asset` (
  `Hid` int(11) NOT NULL AUTO_INCREMENT,
  `hname` varchar(25) DEFAULT NULL,
  `hostname` varchar(50) DEFAULT NULL,
  `system` varchar(255) DEFAULT NULL,
  `group` varchar(25) DEFAULT NULL,
  `support_company` varchar(255) DEFAULT NULL,
  `asset_start` varchar(50) DEFAULT NULL,
  `asset_usetime` int(11) DEFAULT NULL,
  `asset_warrantdate` varchar(50) DEFAULT NULL,
  `asset_sn` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Hid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_authpriv`
--

DROP TABLE IF EXISTS `log_authpriv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_authpriv` (
  `host` varchar(64) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `pre_level` tinyint(1) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `pre_starttime` datetime DEFAULT NULL,
  `srchost` varchar(64) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `realuser` varchar(100) DEFAULT NULL,
  `changeuser` varchar(100) DEFAULT NULL,
  `changegroup` varchar(100) DEFAULT NULL,
  `changeuserid` varchar(100) DEFAULT NULL,
  `changegroupid` varchar(100) DEFAULT NULL,
  `event` int(8) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(64) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `host` (`host`),
  KEY `srchost` (`srchost`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_company`
--

DROP TABLE IF EXISTS `log_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_company` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `connecter` varchar(10) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs`
--

DROP TABLE IF EXISTS `log_countlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs` (
  `host` varchar(32) DEFAULT NULL,
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_day_detailed`
--

DROP TABLE IF EXISTS `log_countlogs_day_detailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_day_detailed` (
  `host` varchar(32) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=2442 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_day_level`
--

DROP TABLE IF EXISTS `log_countlogs_day_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_day_level` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `level` varchar(15) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=4249 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_day_server`
--

DROP TABLE IF EXISTS `log_countlogs_day_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_day_server` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=645 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_hour_detailed`
--

DROP TABLE IF EXISTS `log_countlogs_hour_detailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_hour_detailed` (
  `host` varchar(32) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=9419 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_hour_level`
--

DROP TABLE IF EXISTS `log_countlogs_hour_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_hour_level` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `level` varchar(15) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=50313 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_hour_server`
--

DROP TABLE IF EXISTS `log_countlogs_hour_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_hour_server` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `host` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=10084 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_minuter_detailed`
--

DROP TABLE IF EXISTS `log_countlogs_minuter_detailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_minuter_detailed` (
  `host` varchar(32) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=573735 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_minuter_level`
--

DROP TABLE IF EXISTS `log_countlogs_minuter_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_minuter_level` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `level` varchar(15) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=359630 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_minuter_server`
--

DROP TABLE IF EXISTS `log_countlogs_minuter_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_minuter_server` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `host` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`)
) ENGINE=MyISAM AUTO_INCREMENT=137594 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_month_detailed`
--

DROP TABLE IF EXISTS `log_countlogs_month_detailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_month_detailed` (
  `host` varchar(32) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_month_level`
--

DROP TABLE IF EXISTS `log_countlogs_month_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_month_level` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `level` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_month_server`
--

DROP TABLE IF EXISTS `log_countlogs_month_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_month_server` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_week_detailed`
--

DROP TABLE IF EXISTS `log_countlogs_week_detailed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_week_detailed` (
  `host` varchar(32) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `DEBUG` int(12) unsigned NOT NULL DEFAULT '0',
  `INFO` int(12) unsigned NOT NULL DEFAULT '0',
  `NOTICE` int(12) unsigned NOT NULL DEFAULT '0',
  `WARNING` int(12) unsigned NOT NULL DEFAULT '0',
  `ERR` int(12) unsigned NOT NULL DEFAULT '0',
  `CRIT` int(12) unsigned NOT NULL DEFAULT '0',
  `ALERT` int(12) unsigned NOT NULL DEFAULT '0',
  `EMERG` int(12) unsigned NOT NULL DEFAULT '0',
  `actionlog` int(12) unsigned NOT NULL DEFAULT '0',
  `alllog` int(12) unsigned NOT NULL DEFAULT '0',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=409 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_week_level`
--

DROP TABLE IF EXISTS `log_countlogs_week_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_week_level` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `level` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=649 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_countlogs_week_server`
--

DROP TABLE IF EXISTS `log_countlogs_week_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_countlogs_week_server` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `alllog` int(10) DEFAULT NULL,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_eventconfig`
--

DROP TABLE IF EXISTS `log_eventconfig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_eventconfig` (
  `eventmsg` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `msg_level` int(8) DEFAULT NULL,
  `status` int(8) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) DEFAULT NULL,
  `logsource` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_eventconfig_test`
--

DROP TABLE IF EXISTS `log_eventconfig_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_eventconfig_test` (
  `eventmsg` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `msg_level` int(8) DEFAULT NULL,
  `status` int(8) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) DEFAULT NULL,
  `logsource` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_eventlogs`
--

DROP TABLE IF EXISTS `log_eventlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_eventlogs` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logserver` varchar(32) DEFAULT NULL,
  `msg_level` int(8) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `desc` varchar(255) DEFAULT NULL,
  `logsource` varchar(255) DEFAULT NULL,
  `pos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=22933666 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_facility`
--

DROP TABLE IF EXISTS `log_facility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_facility` (
  `name` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_filter`
--

DROP TABLE IF EXISTS `log_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_filter` (
  `fid` int(8) NOT NULL AUTO_INCREMENT,
  `ftype` enum('host','msg','level','facility') NOT NULL,
  `fvalue` varchar(255) NOT NULL,
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_host`
--

DROP TABLE IF EXISTS `log_host`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_host` (
  `hid` int(8) NOT NULL AUTO_INCREMENT,
  `hname` varchar(50) NOT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `system` varchar(255) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `support_company` varchar(255) DEFAULT NULL,
  `asset_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asset_usedtime` int(5) DEFAULT NULL,
  `asset_warrantdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asset_sn` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`hid`)
) ENGINE=MyISAM AUTO_INCREMENT=356 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_linux_authpriv`
--

DROP TABLE IF EXISTS `log_linux_authpriv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_linux_authpriv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `event` mediumtext,
  `username` varchar(20) DEFAULT NULL,
  `groupname` varchar(20) DEFAULT NULL,
  `loginfo` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_linux_login`
--

DROP TABLE IF EXISTS `log_linux_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_linux_login` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_mod` varchar(15) DEFAULT NULL,
  `pid` int(8) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `uid` tinyint(1) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `srchost` (`srchost`),
  KEY `pid` (`pid`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM AUTO_INCREMENT=180322 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_linux_login20121019`
--

DROP TABLE IF EXISTS `log_linux_login20121019`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_linux_login20121019` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_mod` varchar(15) DEFAULT NULL,
  `pid` int(8) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `uid` tinyint(1) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `srchost` (`srchost`),
  KEY `pid` (`pid`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM AUTO_INCREMENT=5339 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_linux_login20121106`
--

DROP TABLE IF EXISTS `log_linux_login20121106`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_linux_login20121106` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_mod` varchar(15) DEFAULT NULL,
  `pid` int(8) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(10) DEFAULT NULL,
  `uid` tinyint(1) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `srchost` (`srchost`),
  KEY `pid` (`pid`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM AUTO_INCREMENT=2113 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_listdata_log`
--

DROP TABLE IF EXISTS `log_listdata_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_listdata_log` (
  `ip` varchar(15) NOT NULL,
  `last_value` double NOT NULL,
  `name` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `thold` double NOT NULL,
  `mail` tinyint(1) NOT NULL,
  `sms` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=1204 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_log`
--

DROP TABLE IF EXISTS `log_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `update_success_flag` varchar(5) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_log20141104`
--

DROP TABLE IF EXISTS `log_log20141104`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_log20141104` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `update_success_flag` varchar(5) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logdescername`
--

DROP TABLE IF EXISTS `log_logdescername`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logdescername` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `logdesc` varchar(255) DEFAULT NULL COMMENT '????',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logfacility`
--

DROP TABLE IF EXISTS `log_logfacility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logfacility` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `lock` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_login`
--

DROP TABLE IF EXISTS `log_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_login` (
  `host` varchar(64) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `pre_level` tinyint(1) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `pre_starttime` datetime DEFAULT NULL,
  `pre_endtime` datetime DEFAULT NULL,
  `login_mod` tinyint(1) DEFAULT NULL,
  `pid` int(8) unsigned DEFAULT NULL,
  `srchost` varchar(64) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(100) DEFAULT NULL,
  `uid` int(10) unsigned DEFAULT NULL,
  `realuser` varchar(100) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(64) DEFAULT NULL,
  `port` mediumint(8) unsigned DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login_detail` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `srchost` (`srchost`),
  KEY `pid` (`pid`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_login_day_count`
--

DROP TABLE IF EXISTS `log_login_day_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_login_day_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `server` varchar(32) DEFAULT NULL,
  `user` varchar(32) DEFAULT NULL,
  `srcip` varchar(32) DEFAULT NULL,
  `protocol` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `count` int(12) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `date` (`date`),
  KEY `user` (`user`),
  KEY `srcip` (`srcip`)
) ENGINE=MyISAM AUTO_INCREMENT=26483 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_login_month_count`
--

DROP TABLE IF EXISTS `log_login_month_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_login_month_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `server` varchar(32) DEFAULT NULL,
  `user` varchar(32) DEFAULT NULL,
  `srcip` varchar(32) DEFAULT NULL,
  `protocol` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `count` int(12) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `user` (`user`),
  KEY `srcip` (`srcip`)
) ENGINE=MyISAM AUTO_INCREMENT=17961 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_login_week_count`
--

DROP TABLE IF EXISTS `log_login_week_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_login_week_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `server` varchar(32) DEFAULT NULL,
  `user` varchar(32) DEFAULT NULL,
  `srcip` varchar(32) DEFAULT NULL,
  `protocol` varchar(32) DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  `count` int(12) DEFAULT NULL,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `user` (`user`),
  KEY `srcip` (`srcip`)
) ENGINE=MyISAM AUTO_INCREMENT=19630 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logplugprog`
--

DROP TABLE IF EXISTS `log_logplugprog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logplugprog` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(200) DEFAULT NULL COMMENT '????',
  `desc` varchar(255) DEFAULT NULL COMMENT '??',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logs`
--

DROP TABLE IF EXISTS `log_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logs` (
  `host` varchar(64) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `tag` varchar(30) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `logname` varchar(255) DEFAULT NULL,
  `logtype` int(8) DEFAULT NULL,
  `pre_level` tinyint(1) DEFAULT NULL,
  `starttime` datetime DEFAULT NULL,
  `pre_starttime` datetime DEFAULT NULL,
  `srchost` varchar(64) DEFAULT NULL,
  `srcport` int(8) DEFAULT NULL,
  `dsthost` varchar(64) DEFAULT NULL,
  `dstport` int(8) DEFAULT NULL,
  `policyid` int(8) DEFAULT NULL,
  `logaction` int(8) DEFAULT NULL,
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `host` (`host`),
  KEY `program` (`program`),
  KEY `datetime` (`datetime`),
  KEY `priority` (`priority`),
  KEY `facility` (`facility`),
  KEY `starttime` (`starttime`)
) ENGINE=MyISAM AUTO_INCREMENT=101619506 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logs20141202`
--

DROP TABLE IF EXISTS `log_logs20141202`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logs20141202` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logserver` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`seq`),
  KEY `host` (`host`),
  KEY `program` (`program`),
  KEY `datetime` (`datetime`),
  KEY `priority` (`priority`),
  KEY `facility` (`facility`)
) ENGINE=MyISAM AUTO_INCREMENT=47799590 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_logs_warning`
--

DROP TABLE IF EXISTS `log_logs_warning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_logs_warning` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facility` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `program` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` text COLLATE utf8_unicode_ci,
  `logserver` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail_status` tinyint(2) unsigned DEFAULT '2',
  `sms_status` tinyint(2) unsigned DEFAULT '2',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_policy`
--

DROP TABLE IF EXISTS `log_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policyid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_policygroup`
--

DROP TABLE IF EXISTS `log_policygroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_policygroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_realtimelogs`
--

DROP TABLE IF EXISTS `log_realtimelogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_realtimelogs` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `process` int(8) DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` varchar(400) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `logserver` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MEMORY DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_relation`
--

DROP TABLE IF EXISTS `log_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_relation` (
  `idsip` varchar(32) DEFAULT NULL,
  `idsmsg` varchar(50) DEFAULT NULL,
  `devicesip` varchar(32) DEFAULT NULL,
  `devicesmsg` varchar(50) DEFAULT NULL,
  `level` int(8) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `idsserverip` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_relationids`
--

DROP TABLE IF EXISTS `log_relationids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_relationids` (
  `idsip` varchar(32) DEFAULT NULL,
  `system` varchar(32) DEFAULT NULL,
  `desc` varchar(50) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_relationidslog`
--

DROP TABLE IF EXISTS `log_relationidslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_relationidslog` (
  `idsip` varchar(32) DEFAULT NULL,
  `idsmsg` mediumtext,
  `level` int(8) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `relationid` int(8) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `serverip` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_relationlog`
--

DROP TABLE IF EXISTS `log_relationlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_relationlog` (
  `idsip` varchar(32) DEFAULT NULL,
  `idsmsg` mediumtext,
  `serverip` varchar(32) DEFAULT NULL,
  `servermsg` mediumtext,
  `level` int(8) DEFAULT NULL,
  `status` int(8) DEFAULT NULL,
  `relationid` int(8) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_relationserverlog`
--

DROP TABLE IF EXISTS `log_relationserverlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_relationserverlog` (
  `serverip` varchar(32) DEFAULT NULL,
  `servermsg` mediumtext,
  `datetime` datetime DEFAULT NULL,
  `relationid` int(8) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_resourcegroup`
--

DROP TABLE IF EXISTS `log_resourcegroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_resourcegroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serverid` int(11) NOT NULL DEFAULT '0',
  `groupname` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_resourcegrouppolicy`
--

DROP TABLE IF EXISTS `log_resourcegrouppolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_resourcegrouppolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `resourcegroupid` int(11) NOT NULL DEFAULT '0',
  `policyid` int(11) NOT NULL DEFAULT '0',
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `forward` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `save` tinyint(1) NOT NULL DEFAULT '0',
  `warnmsg` tinyint(1) NOT NULL DEFAULT '0',
  `warnmail` tinyint(1) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `order` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_rule`
--

DROP TABLE IF EXISTS `log_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rulename_id` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `level` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_rulename`
--

DROP TABLE IF EXISTS `log_rulename`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_rulename` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` tinyint(1) NOT NULL DEFAULT '0',
  `company` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_searchlog2`
--

DROP TABLE IF EXISTS `log_searchlog2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_searchlog2` (
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `level` varchar(10) DEFAULT NULL,
  `tag` varchar(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `program` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `seq` bigint(20) unsigned NOT NULL DEFAULT '0',
  `logserver` varchar(32) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_searchlogs`
--

DROP TABLE IF EXISTS `log_searchlogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_searchlogs` (
  `name` varchar(255) NOT NULL DEFAULT '',
  `sql` text,
  `status` tinyint(1) DEFAULT '0',
  `tables` varchar(255) DEFAULT NULL,
  `starttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `seq` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_servergroup`
--

DROP TABLE IF EXISTS `log_servergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_servergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL,
  `count` int(11) NOT NULL,
  `description` varchar(200) NOT NULL DEFAULT '',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_setting`
--

DROP TABLE IF EXISTS `log_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_setting` (
  `sid` int(8) NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_slaveserver`
--

DROP TABLE IF EXISTS `log_slaveserver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_slaveserver` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) DEFAULT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_snmp_day_count`
--

DROP TABLE IF EXISTS `log_snmp_day_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_snmp_day_count` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `total_value` int(8) DEFAULT NULL,
  `max_value` smallint(8) DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `count` smallint(8) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_status`
--

DROP TABLE IF EXISTS `log_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_status` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth0_inall` bigint(15) DEFAULT NULL,
  `net_eth0_outall` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  `net_eth1_inall` bigint(15) DEFAULT NULL,
  `net_eth1_outall` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=2621 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_status_day_count`
--

DROP TABLE IF EXISTS `log_status_day_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_status_day_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_status_month_count`
--

DROP TABLE IF EXISTS `log_status_month_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_status_month_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_status_week_count`
--

DROP TABLE IF EXISTS `log_status_week_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_status_week_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_syslog`
--

DROP TABLE IF EXISTS `log_syslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_syslog` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `msg` varchar(255) DEFAULT NULL COMMENT '???',
  `level` varchar(20) DEFAULT NULL COMMENT '????',
  `priority` varchar(20) DEFAULT NULL COMMENT '???',
  `desc` varchar(255) DEFAULT NULL COMMENT '????',
  `facility` varchar(255) DEFAULT NULL,
  `process` int(8) DEFAULT NULL,
  `realtime` tinyint(4) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `program` varchar(20) DEFAULT NULL,
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `instruction` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_syslogbak`
--

DROP TABLE IF EXISTS `log_syslogbak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_syslogbak` (
  `msg` varchar(255) DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  `facility` varchar(255) DEFAULT NULL,
  `host` varchar(255) DEFAULT NULL,
  `process` int(8) DEFAULT NULL,
  `realtime` tinyint(4) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  KEY `process` (`process`),
  KEY `realtime` (`realtime`)
) ENGINE=MEMORY DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_system`
--

DROP TABLE IF EXISTS `log_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_system` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `system` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_system_template`
--

DROP TABLE IF EXISTS `log_system_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_system_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_user`
--

DROP TABLE IF EXISTS `log_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_user` (
  `userid` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `hostlist` mediumtext NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=417 DEFAULT CHARSET=gbk;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_windows_authpriv`
--

DROP TABLE IF EXISTS `log_windows_authpriv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_windows_authpriv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `event` mediumtext,
  `username` varchar(20) DEFAULT NULL,
  `groupname` varchar(20) DEFAULT NULL,
  `loginfo` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_windows_login`
--

DROP TABLE IF EXISTS `log_windows_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_windows_login` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_id` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `port` (`port`),
  KEY `srchost` (`srchost`),
  KEY `starttime` (`starttime`),
  KEY `user` (`user`),
  KEY `protocol` (`protocol`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=3124374 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_windows_login20121019`
--

DROP TABLE IF EXISTS `log_windows_login20121019`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_windows_login20121019` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_id` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `port` (`port`),
  KEY `srchost` (`srchost`),
  KEY `starttime` (`starttime`),
  KEY `user` (`user`),
  KEY `protocol` (`protocol`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=1550072 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_windows_login20121106`
--

DROP TABLE IF EXISTS `log_windows_login20121106`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_windows_login20121106` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_id` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `port` (`port`),
  KEY `srchost` (`srchost`),
  KEY `starttime` (`starttime`),
  KEY `user` (`user`),
  KEY `protocol` (`protocol`),
  KEY `active` (`active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log_windows_login_copy`
--

DROP TABLE IF EXISTS `log_windows_login_copy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_windows_login_copy` (
  `starttime` datetime DEFAULT NULL,
  `endtime` datetime DEFAULT NULL,
  `login_id` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `srchost` varchar(32) DEFAULT NULL,
  `protocol` varchar(10) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `user` varchar(15) DEFAULT NULL,
  `msg` mediumtext,
  `logserver` varchar(32) DEFAULT NULL,
  `port` mediumint(8) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `endtime` (`endtime`),
  KEY `host` (`host`),
  KEY `port` (`port`),
  KEY `srchost` (`srchost`),
  KEY `starttime` (`starttime`),
  KEY `user` (`user`),
  KEY `protocol` (`protocol`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=43318 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login4approve`
--

DROP TABLE IF EXISTS `login4approve`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login4approve` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webuser` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `login_method` int(11) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `approvetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `approveuser` varchar(255) NOT NULL DEFAULT '',
  `applytime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logintime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login_tab`
--

DROP TABLE IF EXISTS `login_tab`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `URL` varchar(100) DEFAULT NULL,
  `userID` varchar(16) DEFAULT NULL,
  `pwdID` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login_template`
--

DROP TABLE IF EXISTS `login_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_type` varchar(20) NOT NULL,
  `login_method` varchar(20) NOT NULL,
  `default` int(11) NOT NULL,
  `icon` varchar(250) NOT NULL DEFAULT '',
  `sucommand` varchar(250) NOT NULL DEFAULT '',
  `snmp_system` int(10) DEFAULT '0',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacct`
--

DROP TABLE IF EXISTS `loginacct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacct` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sourceip` varchar(40) DEFAULT NULL,
  `auditip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `systemuser` varchar(60) NOT NULL,
  `authenticationstatus` tinyint(1) DEFAULT '1',
  `failreason` varchar(60) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2495202 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacct_day`
--

DROP TABLE IF EXISTS `loginacct_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacct_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sourceip` varchar(40) DEFAULT NULL,
  `auditip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `systemuser` varchar(60) NOT NULL,
  `authenticationstatus` tinyint(1) DEFAULT '1',
  `failreason` varchar(60) NOT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=140744 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacct_diy`
--

DROP TABLE IF EXISTS `loginacct_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacct_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sourceip` varchar(40) DEFAULT NULL,
  `auditip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `systemuser` varchar(60) NOT NULL,
  `authenticationstatus` tinyint(1) DEFAULT '1',
  `failreason` varchar(60) NOT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=27662 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacct_month`
--

DROP TABLE IF EXISTS `loginacct_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacct_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sourceip` varchar(40) DEFAULT NULL,
  `auditip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `systemuser` varchar(60) NOT NULL,
  `authenticationstatus` tinyint(1) DEFAULT '1',
  `failreason` varchar(60) NOT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=656541 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacct_week`
--

DROP TABLE IF EXISTS `loginacct_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacct_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `sourceip` varchar(40) DEFAULT NULL,
  `auditip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `systemuser` varchar(60) NOT NULL,
  `authenticationstatus` tinyint(1) DEFAULT '1',
  `failreason` varchar(60) NOT NULL,
  `realname` char(255) DEFAULT NULL,
  `groupname` char(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=73512 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginacctcode`
--

DROP TABLE IF EXISTS `loginacctcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginacctcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engcode` varchar(60) DEFAULT NULL,
  `code` int(11) NOT NULL,
  `cncode` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginapproved_day`
--

DROP TABLE IF EXISTS `loginapproved_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginapproved_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `webuser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_method` varchar(255) NOT NULL,
  `applytime` varchar(255) NOT NULL,
  `approvetime` datetime NOT NULL,
  `approveuser` datetime NOT NULL,
  `logintime` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginapproved_diy`
--

DROP TABLE IF EXISTS `loginapproved_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginapproved_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `webuser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_method` varchar(255) NOT NULL,
  `applytime` varchar(255) NOT NULL,
  `approvetime` datetime NOT NULL,
  `approveuser` datetime NOT NULL,
  `logintime` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginapproved_month`
--

DROP TABLE IF EXISTS `loginapproved_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginapproved_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `webuser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_method` varchar(255) NOT NULL,
  `applytime` varchar(255) NOT NULL,
  `approvetime` datetime NOT NULL,
  `approveuser` datetime NOT NULL,
  `logintime` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=190 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginapproved_week`
--

DROP TABLE IF EXISTS `loginapproved_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginapproved_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `webuser` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `username` varchar(100) NOT NULL,
  `login_method` varchar(255) NOT NULL,
  `applytime` varchar(255) NOT NULL,
  `approvetime` datetime NOT NULL,
  `approveuser` datetime NOT NULL,
  `logintime` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logincommit`
--

DROP TABLE IF EXISTS `logincommit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logincommit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prelogincommit` text,
  `postloggincommit` text,
  `uid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `pretime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `posttime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginfailed_day`
--

DROP TABLE IF EXISTS `loginfailed_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginfailed_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sourceip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2248 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginfailed_diy`
--

DROP TABLE IF EXISTS `loginfailed_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginfailed_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sourceip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=536 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginfailed_month`
--

DROP TABLE IF EXISTS `loginfailed_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginfailed_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sourceip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=4823 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginfailed_week`
--

DROP TABLE IF EXISTS `loginfailed_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginfailed_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `sourceip` varchar(40) DEFAULT NULL,
  `serverip` varchar(40) DEFAULT NULL,
  `portocol` varchar(20) NOT NULL,
  `audituser` varchar(20) NOT NULL,
  `ct` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=801 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `loginlog`
--

DROP TABLE IF EXISTS `loginlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loginlog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `from` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logintimes_day`
--

DROP TABLE IF EXISTS `logintimes_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logintimes_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sct` int(11) NOT NULL DEFAULT '0',
  `tct` int(11) NOT NULL DEFAULT '0',
  `rct` int(11) NOT NULL DEFAULT '0',
  `act` int(11) NOT NULL DEFAULT '0',
  `vct` int(11) NOT NULL DEFAULT '0',
  `fct` int(11) NOT NULL DEFAULT '0',
  `sfct` int(11) NOT NULL DEFAULT '0',
  `webct` int(11) NOT NULL DEFAULT '0',
  `xct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=3514 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logintimes_diy`
--

DROP TABLE IF EXISTS `logintimes_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logintimes_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sct` int(11) NOT NULL DEFAULT '0',
  `tct` int(11) NOT NULL DEFAULT '0',
  `rct` int(11) NOT NULL DEFAULT '0',
  `act` int(11) NOT NULL DEFAULT '0',
  `vct` int(11) NOT NULL DEFAULT '0',
  `fct` int(11) NOT NULL DEFAULT '0',
  `sfct` int(11) NOT NULL DEFAULT '0',
  `webct` int(11) NOT NULL DEFAULT '0',
  `xct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=668 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logintimes_month`
--

DROP TABLE IF EXISTS `logintimes_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logintimes_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sct` int(11) NOT NULL DEFAULT '0',
  `tct` int(11) NOT NULL DEFAULT '0',
  `rct` int(11) NOT NULL DEFAULT '0',
  `act` int(11) NOT NULL DEFAULT '0',
  `vct` int(11) NOT NULL DEFAULT '0',
  `fct` int(11) NOT NULL DEFAULT '0',
  `sfct` int(11) NOT NULL DEFAULT '0',
  `webct` int(11) NOT NULL DEFAULT '0',
  `xct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logintimes_week`
--

DROP TABLE IF EXISTS `logintimes_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logintimes_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sct` int(11) NOT NULL DEFAULT '0',
  `tct` int(11) NOT NULL DEFAULT '0',
  `rct` int(11) NOT NULL DEFAULT '0',
  `act` int(11) NOT NULL DEFAULT '0',
  `vct` int(11) NOT NULL DEFAULT '0',
  `fct` int(11) NOT NULL DEFAULT '0',
  `sfct` int(11) NOT NULL DEFAULT '0',
  `webct` int(11) NOT NULL DEFAULT '0',
  `xct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `luser`
--

DROP TABLE IF EXISTS `luser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `twoauth` int(11) NOT NULL DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  `smsalert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`devicesid`)
) ENGINE=MyISAM AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `luser_appresourcegrp`
--

DROP TABLE IF EXISTS `luser_appresourcegrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luser_appresourcegrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `appresourceid` int(11) DEFAULT NULL,
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `loginlock` tinyint(1) DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`appresourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `luser_devgrp`
--

DROP TABLE IF EXISTS `luser_devgrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luser_devgrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `serversid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `luser_resourcegrp`
--

DROP TABLE IF EXISTS `luser_resourcegrp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luser_resourcegrp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `resourceid` int(11) DEFAULT NULL,
  `autosu` tinyint(1) DEFAULT '0',
  `weektime` varchar(30) DEFAULT NULL,
  `sourceip` varchar(30) DEFAULT NULL,
  `forbidden_commands_groups` varchar(255) DEFAULT NULL,
  `syslogalert` int(5) DEFAULT '0',
  `mailalert` int(5) DEFAULT '0',
  `loginlock` tinyint(1) DEFAULT '0',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `twoauth` int(5) DEFAULT '0',
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `workflow` tinyint(1) NOT NULL DEFAULT '0',
  `wf_user1` int(11) NOT NULL DEFAULT '0',
  `wf_user2` int(11) NOT NULL DEFAULT '0',
  `wf_user3` int(11) NOT NULL DEFAULT '0',
  `wf_user4` int(11) NOT NULL DEFAULT '0',
  `wf_user5` int(11) NOT NULL DEFAULT '0',
  `smsalert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `memberid` (`memberid`,`resourceid`)
) ENGINE=MyISAM AUTO_INCREMENT=4101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `macaddr`
--

DROP TABLE IF EXISTS `macaddr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `macaddr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `cli_addr` varchar(20) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `tar_addr` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mail`
--

DROP TABLE IF EXISTS `mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mail` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `from` char(255) NOT NULL,
  `to` char(255) NOT NULL,
  `subject` char(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1040 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `md5version`
--

DROP TABLE IF EXISTS `md5version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `md5version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(30) NOT NULL,
  `version` varchar(30) NOT NULL,
  `md5sum` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(255) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `realname` char(255) DEFAULT NULL,
  `email` char(255) DEFAULT NULL,
  `level` tinyint(4) DEFAULT '0',
  `mobile` char(15) NOT NULL,
  `flist` text NOT NULL,
  `devs` varchar(255) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `route_map` varchar(128) NOT NULL,
  `logintimes` int(3) NOT NULL DEFAULT '0',
  `lastdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `loginlock` tinyint(1) NOT NULL COMMENT 'µÇÂ½¼ÓËø',
  `usbkey` varchar(128) DEFAULT NULL,
  `usbkeystatus` tinyint(4) DEFAULT '0',
  `weektime` varchar(32) DEFAULT NULL,
  `sourceip` varchar(32) DEFAULT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `nullsourceipallow` tinyint(1) DEFAULT '1',
  `vpnip` varchar(32) DEFAULT NULL,
  `lastdateChpwd` int(11) NOT NULL DEFAULT '0',
  `netdisksize` int(5) NOT NULL DEFAULT '0',
  `default_control` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0js1applet2activex',
  `newmember` tinyint(1) NOT NULL DEFAULT '1',
  `allowchange` tinyint(1) DEFAULT '0',
  `rdp_screen` tinyint(1) DEFAULT '3',
  `login_tip` tinyint(1) DEFAULT '0',
  `firstlogined` tinyint(1) NOT NULL DEFAULT '0',
  `mservergroup` varchar(500) NOT NULL DEFAULT '',
  `musergroup` varchar(500) NOT NULL DEFAULT '',
  `common_user_pri` tinyint(1) NOT NULL DEFAULT '0',
  `mldapid` int(11) NOT NULL DEFAULT '0',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `radius` tinyint(1) DEFAULT '0',
  `rdpdisk` char(255) DEFAULT NULL,
  `rdpdiskauth` tinyint(1) DEFAULT '0',
  `rdpclipauth` tinyint(1) DEFAULT '0',
  `company` char(255) DEFAULT NULL,
  `mobilenum` char(32) DEFAULT NULL,
  `used` tinyint(4) NOT NULL DEFAULT '0',
  `vpn` tinyint(1) DEFAULT '0',
  `passwd_user_pri` tinyint(1) NOT NULL DEFAULT '0',
  `audit_user_pri` tinyint(1) NOT NULL DEFAULT '0',
  `sshprivatekey` varchar(255) DEFAULT NULL,
  `sshpublickey` varchar(255) DEFAULT NULL,
  `restrictweb` tinyint(1) DEFAULT '0',
  `groupname` varchar(256) NOT NULL DEFAULT 'null',
  `privatefloder` tinyint(1) NOT NULL DEFAULT '0',
  `publicfloder` tinyint(1) NOT NULL DEFAULT '0',
  `auth` tinyint(1) NOT NULL DEFAULT '0',
  `workcompany` varchar(255) NOT NULL DEFAULT '',
  `smspassword` varchar(25) NOT NULL DEFAULT '',
  `smstime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `default_appcontrol` tinyint(1) NOT NULL DEFAULT '1',
  `workdepartment` varchar(255) NOT NULL DEFAULT '',
  `rdpdiskauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_up` tinyint(1) NOT NULL DEFAULT '0',
  `searchcache` tinyint(1) NOT NULL DEFAULT '0',
  `localauth` tinyint(1) NOT NULL DEFAULT '1',
  `radiusauth` tinyint(1) NOT NULL DEFAULT '0',
  `ldapauth` tinyint(1) NOT NULL DEFAULT '0',
  `adauth` tinyint(1) NOT NULL DEFAULT '0',
  `apphost` tinyint(1) NOT NULL DEFAULT '1',
  `ldap` tinyint(1) NOT NULL DEFAULT '0',
  `passwordsave` tinyint(1) NOT NULL DEFAULT '0',
  `caauth` tinyint(1) NOT NULL DEFAULT '0',
  `cacn` varchar(255) NOT NULL,
  `rdpdiskauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdpclipauth_down` tinyint(1) NOT NULL DEFAULT '0',
  `rdplocal` tinyint(1) NOT NULL DEFAULT '0',
  `musergrouptype` tinyint(1) NOT NULL DEFAULT '0',
  `randomcode` varchar(6) NOT NULL,
  `sourceipv6` varchar(32) NOT NULL,
  `appdelay` tinyint(4) DEFAULT '5',
  `yibao_sn` varchar(30) NOT NULL,
  `yibao_tokenid` varchar(30) NOT NULL,
  `yibaoauth` tinyint(1) NOT NULL DEFAULT '0',
  `usbkey_temp` varchar(255) NOT NULL,
  `rdplocalcheck` tinyint(1) NOT NULL DEFAULT '0',
  `fingersecauth` tinyint(1) NOT NULL DEFAULT '0',
  `localfingersecauth` tinyint(1) NOT NULL DEFAULT '0',
  `authtype` tinyint(1) NOT NULL DEFAULT '0',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `adou` varchar(1000) NOT NULL,
  `firstauth` varchar(255) NOT NULL,
  `forceeditpassword` tinyint(1) NOT NULL DEFAULT '0',
  `crttab` tinyint(1) NOT NULL DEFAULT '0',
  `apptodisk` tinyint(1) NOT NULL DEFAULT '0',
  `apptoadmingroup` tinyint(1) NOT NULL DEFAULT '0',
  `asyncoutpass` tinyint(2) NOT NULL DEFAULT '-1',
  `webportal` tinyint(1) NOT NULL DEFAULT '0',
  `webportaltime` int(5) NOT NULL DEFAULT '0',
  `webportallogin` int(10) NOT NULL DEFAULT '0',
  `websourceip` varchar(32) NOT NULL,
  `ie_hook_flag` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=830 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memberdept`
--

DROP TABLE IF EXISTS `memberdept`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberdept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memberdesc`
--

DROP TABLE IF EXISTS `memberdesc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberdesc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) NOT NULL DEFAULT '0',
  `membername` char(255) DEFAULT NULL,
  `prideptid` int(11) NOT NULL DEFAULT '0',
  `curdeptid` int(11) NOT NULL DEFAULT '0',
  `pripostid` int(11) NOT NULL DEFAULT '0',
  `curpostid` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL,
  `optime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `action` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memberpost`
--

DROP TABLE IF EXISTS `memberpost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberpost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `desc` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mysql_commands`
--

DROP TABLE IF EXISTS `mysql_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysql_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `danger` int(1) DEFAULT NULL,
  `return_code` mediumtext,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=950 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mysql_sessions`
--

DROP TABLE IF EXISTS `mysql_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mysql_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=1986 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle`
--

DROP TABLE IF EXISTS `oracle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `proxy_addr` char(20) DEFAULT NULL,
  `cli_addr` varchar(20) DEFAULT NULL,
  `addr` char(255) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `user` char(255) CHARACTER SET gb2312 DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `window_size` char(16) DEFAULT NULL,
  `replayfile` varchar(300) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `rdp_runnig` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5332 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_backup_progress`
--

DROP TABLE IF EXISTS `oracle_backup_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_backup_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_addr` varchar(128) DEFAULT NULL,
  `tablename` varchar(128) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_commands`
--

DROP TABLE IF EXISTS `oracle_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` mediumtext,
  `cmd_bytes` int(11) DEFAULT NULL,
  `result_bytes` int(11) DEFAULT NULL,
  `return_code` mediumtext,
  `return_time` int(11) DEFAULT NULL,
  `level` int(5) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=78120 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_disk`
--

DROP TABLE IF EXISTS `oracle_disk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_disk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `disk_name` varchar(50) DEFAULT NULL,
  `disk_path` varchar(255) DEFAULT NULL,
  `total_size` int(11) DEFAULT NULL,
  `free_size` int(11) DEFAULT NULL,
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_disk_day_report`
--

DROP TABLE IF EXISTS `oracle_disk_day_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_disk_day_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `disk_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disk_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_disk_month_report`
--

DROP TABLE IF EXISTS `oracle_disk_month_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_disk_month_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `disk_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disk_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_disk_week_report`
--

DROP TABLE IF EXISTS `oracle_disk_week_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_disk_week_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `disk_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `disk_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_diskgroup`
--

DROP TABLE IF EXISTS `oracle_diskgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_diskgroup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `diskgroup_id` int(10) unsigned DEFAULT NULL,
  `diskgroup_name` varchar(50) DEFAULT NULL,
  `total_size` int(11) DEFAULT NULL,
  `free_size` int(11) DEFAULT NULL,
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_diskgroup_day_report`
--

DROP TABLE IF EXISTS `oracle_diskgroup_day_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_diskgroup_day_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `diskgroup_id` int(10) unsigned DEFAULT NULL,
  `diskgroup_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_diskgroup_month_report`
--

DROP TABLE IF EXISTS `oracle_diskgroup_month_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_diskgroup_month_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `diskgroup_id` int(10) unsigned DEFAULT NULL,
  `diskgroup_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_diskgroup_week_report`
--

DROP TABLE IF EXISTS `oracle_diskgroup_week_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_diskgroup_week_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `diskgroup_id` int(10) unsigned DEFAULT NULL,
  `diskgroup_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_sessions`
--

DROP TABLE IF EXISTS `oracle_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) CHARACTER SET utf8 DEFAULT NULL,
  `user` char(255) CHARACTER SET utf8 DEFAULT NULL,
  `system_user` char(255) DEFAULT NULL,
  `program` char(255) DEFAULT NULL,
  `ora_service_name` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  `s_mac` char(255) DEFAULT NULL,
  `d_mac` char(255) DEFAULT NULL,
  `total_cmd` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=9228 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_tablespace`
--

DROP TABLE IF EXISTS `oracle_tablespace`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_tablespace` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `tablespace_name` varchar(50) DEFAULT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `free_size` int(11) DEFAULT NULL,
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_tablespace_day_report`
--

DROP TABLE IF EXISTS `oracle_tablespace_day_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_tablespace_day_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `tablespace_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_tablespace_month_report`
--

DROP TABLE IF EXISTS `oracle_tablespace_month_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_tablespace_month_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `tablespace_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_tablespace_week_report`
--

DROP TABLE IF EXISTS `oracle_tablespace_week_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_tablespace_week_report` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `tablespace_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_id` int(10) unsigned DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avg_free` double(15,4) DEFAULT NULL,
  `noval` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oracle_warning_log`
--

DROP TABLE IF EXISTS `oracle_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oracle_warning_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `oracle_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `table_id` int(11) unsigned DEFAULT NULL,
  `key_name` varchar(50) DEFAULT NULL,
  `cur_val` int(8) DEFAULT NULL,
  `thold` int(8) DEFAULT NULL,
  `context` mediumtext,
  `mail_status` tinyint(2) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3279 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `otp`
--

DROP TABLE IF EXISTS `otp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otp_domain` varchar(255) NOT NULL DEFAULT '',
  `otp_port` varchar(255) NOT NULL DEFAULT '',
  `otp_spid` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passes`
--

DROP TABLE IF EXISTS `passes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passwd_cache`
--

DROP TABLE IF EXISTS `passwd_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwd_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `passwd` varchar(255) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '2009-02-23 03:53:20',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=gb2312;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_cache`
--

DROP TABLE IF EXISTS `password_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `generate_time` datetime NOT NULL,
  `password_hash` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_crypt`
--

DROP TABLE IF EXISTS `password_crypt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_crypt` (
  `password` varchar(50) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backup` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_policy`
--

DROP TABLE IF EXISTS `password_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `minlen` int(11) NOT NULL DEFAULT '12',
  `minalpha` int(11) NOT NULL DEFAULT '4',
  `minother` int(11) NOT NULL DEFAULT '4',
  `mindiff` int(11) NOT NULL DEFAULT '4',
  `maxrepeats` int(11) NOT NULL DEFAULT '2',
  `histexpire` int(11) NOT NULL DEFAULT '40',
  `histsize` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `password_rules`
--

DROP TABLE IF EXISTS `password_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_rules` (
  `ip` varchar(20) NOT NULL,
  `password_len` int(11) DEFAULT NULL,
  `hasUpperChar` int(11) DEFAULT NULL,
  `hasLowerChar` int(11) DEFAULT NULL,
  `hasDigit` int(11) DEFAULT NULL,
  `haspunctuation` int(11) DEFAULT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passwordkey`
--

DROP TABLE IF EXISTS `passwordkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwordkey` (
  `key_str` varchar(20) DEFAULT NULL,
  `key_date` datetime DEFAULT NULL,
  `key_email` tinyint(1) DEFAULT '1',
  `zip_email` tinyint(1) DEFAULT '1',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zip_file` varchar(256) DEFAULT NULL,
  `backup` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passwordlog`
--

DROP TABLE IF EXISTS `passwordlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwordlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL DEFAULT '',
  `time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=803 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passwordsave`
--

DROP TABLE IF EXISTS `passwordsave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwordsave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `devicesid` int(11) NOT NULL DEFAULT '0',
  `memberid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=134 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pcap_black_list`
--

DROP TABLE IF EXISTS `pcap_black_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pcap_black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `netmask` int(9) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prompts`
--

DROP TABLE IF EXISTS `prompts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prompts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end1` varchar(255) NOT NULL,
  `end2` varchar(255) NOT NULL,
  `end3` varchar(255) NOT NULL,
  `end4` varchar(255) NOT NULL,
  `end5` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `proxyip`
--

DROP TABLE IF EXISTS `proxyip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proxyip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(30) NOT NULL,
  `network` varchar(30) NOT NULL,
  `proxyip` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radacct`
--

DROP TABLE IF EXISTS `radacct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radacct` (
  `RadAcctId` bigint(21) NOT NULL AUTO_INCREMENT,
  `AcctSessionId` varchar(32) NOT NULL DEFAULT '',
  `AcctUniqueId` varchar(32) NOT NULL DEFAULT '',
  `UserName` varchar(64) NOT NULL DEFAULT '',
  `Realm` varchar(64) DEFAULT '',
  `NASIPAddress` varchar(15) NOT NULL DEFAULT '',
  `NASPortId` varchar(15) DEFAULT NULL,
  `NASPortType` varchar(32) DEFAULT NULL,
  `AcctStartTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AcctStopTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `AcctSessionTime` int(12) DEFAULT NULL,
  `AcctAuthentic` varchar(32) DEFAULT NULL,
  `ConnectInfo_start` varchar(50) DEFAULT NULL,
  `ConnectInfo_stop` varchar(50) DEFAULT NULL,
  `AcctInputOctets` bigint(12) DEFAULT NULL,
  `AcctOutputOctets` bigint(12) DEFAULT NULL,
  `CalledStationId` varchar(50) NOT NULL DEFAULT '',
  `CallingStationId` varchar(50) NOT NULL DEFAULT '',
  `AcctTerminateCause` varchar(32) NOT NULL DEFAULT '',
  `ServiceType` varchar(32) DEFAULT NULL,
  `FramedProtocol` varchar(32) DEFAULT NULL,
  `FramedIPAddress` varchar(15) NOT NULL DEFAULT '',
  `AcctStartDelay` int(12) DEFAULT NULL,
  `AcctStopDelay` int(12) DEFAULT NULL,
  PRIMARY KEY (`RadAcctId`),
  KEY `UserName` (`UserName`),
  KEY `FramedIPAddress` (`FramedIPAddress`),
  KEY `AcctSessionId` (`AcctSessionId`),
  KEY `AcctUniqueId` (`AcctUniqueId`),
  KEY `AcctStartTime` (`AcctStartTime`),
  KEY `AcctStopTime` (`AcctStopTime`),
  KEY `NASIPAddress` (`NASIPAddress`)
) ENGINE=MyISAM AUTO_INCREMENT=7178 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radcheck`
--

DROP TABLE IF EXISTS `radcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Attribute` varchar(32) NOT NULL,
  `op` char(2) NOT NULL DEFAULT '==',
  `Value` varchar(253) NOT NULL,
  `email` char(50) NOT NULL,
  `day` int(11) DEFAULT '1',
  `enable` smallint(6) NOT NULL,
  `logintime` int(5) NOT NULL,
  `lastdate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`(32))
) ENGINE=MyISAM AUTO_INCREMENT=308 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radgroupcheck`
--

DROP TABLE IF EXISTS `radgroupcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radgroupcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(64) NOT NULL DEFAULT '',
  `Attribute` varchar(32) NOT NULL DEFAULT '',
  `op` char(2) NOT NULL DEFAULT '==',
  `Value` varchar(253) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `GroupName` (`GroupName`(32))
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radgroupreply`
--

DROP TABLE IF EXISTS `radgroupreply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radgroupreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(64) NOT NULL,
  `Attribute` varchar(32) NOT NULL,
  `op` char(2) NOT NULL DEFAULT '=',
  `Value` varchar(253) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupName` (`GroupName`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radhuntcheck`
--

DROP TABLE IF EXISTS `radhuntcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radhuntcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radhuntgroup`
--

DROP TABLE IF EXISTS `radhuntgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radhuntgroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL,
  `nasipaddress` varchar(15) NOT NULL,
  `describe` varchar(20) NOT NULL,
  `nasipcidr` tinyint(2) unsigned NOT NULL DEFAULT '32',
  PRIMARY KEY (`id`),
  KEY `nasipaddress` (`nasipaddress`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radhuntgroupcheck`
--

DROP TABLE IF EXISTS `radhuntgroupcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radhuntgroupcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL,
  `value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `groupname` (`groupname`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radhuntreply`
--

DROP TABLE IF EXISTS `radhuntreply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radhuntreply` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `describe` char(255) NOT NULL,
  `groupname` char(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radkey`
--

DROP TABLE IF EXISTS `radkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pc_index` varchar(60) DEFAULT NULL,
  `isused` tinyint(1) NOT NULL,
  `limittime` date NOT NULL,
  `keyid` varchar(30) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radreply`
--

DROP TABLE IF EXISTS `radreply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radreply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Attribute` varchar(32) NOT NULL,
  `op` char(2) NOT NULL DEFAULT '=',
  `Value` varchar(253) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=536 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radsourcecheck`
--

DROP TABLE IF EXISTS `radsourcecheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radsourcecheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) NOT NULL,
  `Value` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `UserName` (`UserName`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radsourcegroup`
--

DROP TABLE IF EXISTS `radsourcegroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radsourcegroup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(64) NOT NULL,
  `nasipaddress` varchar(15) NOT NULL,
  `describe` varchar(20) DEFAULT NULL,
  `nasipcidr` tinyint(2) unsigned NOT NULL DEFAULT '32',
  PRIMARY KEY (`id`),
  KEY `nasipaddress` (`nasipaddress`),
  KEY `ip_cidr` (`nasipaddress`,`nasipcidr`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radsourcegroupcheck`
--

DROP TABLE IF EXISTS `radsourcegroupcheck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radsourcegroupcheck` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `groupname` varchar(11) NOT NULL,
  `value` varchar(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupName` (`groupname`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radsourcereply`
--

DROP TABLE IF EXISTS `radsourcereply`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radsourcereply` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `describe` char(255) NOT NULL,
  `groupname` char(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `radwmkey`
--

DROP TABLE IF EXISTS `radwmkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `radwmkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_index` varchar(60) DEFAULT NULL,
  `isused` tinyint(1) NOT NULL,
  `limittime` date NOT NULL,
  `keyid` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `random`
--

DROP TABLE IF EXISTS `random`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `random` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `username` varchar(200) NOT NULL,
  `time` datetime NOT NULL,
  `luser` varchar(200) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `inputusername` varchar(200) DEFAULT NULL,
  `inputpassword` varchar(200) DEFAULT NULL,
  `logincommit` int(11) NOT NULL DEFAULT '0',
  `report` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61794 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratedaylist`
--

DROP TABLE IF EXISTS `ratedaylist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratedaylist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuemin` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `maxstatus` tinyint(1) NOT NULL DEFAULT '0',
  `averagestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratehourlist`
--

DROP TABLE IF EXISTS `ratehourlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratehourlist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuemin` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `maxstatus` tinyint(1) NOT NULL DEFAULT '0',
  `averagestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratelastlist`
--

DROP TABLE IF EXISTS `ratelastlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratelastlist` (
  `value` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratelist`
--

DROP TABLE IF EXISTS `ratelist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratelist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuelast` double NOT NULL,
  `list_host_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ratemonthlist`
--

DROP TABLE IF EXISTS `ratemonthlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratemonthlist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuemin` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `maxstatus` tinyint(1) NOT NULL DEFAULT '0',
  `averagestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rateweeklist`
--

DROP TABLE IF EXISTS `rateweeklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rateweeklist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuemin` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `maxstatus` tinyint(1) NOT NULL DEFAULT '0',
  `averagestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rateyearlist`
--

DROP TABLE IF EXISTS `rateyearlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rateyearlist` (
  `value` double NOT NULL,
  `valuemax` double NOT NULL,
  `valuemin` double NOT NULL,
  `list_host_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `maxstatus` tinyint(1) NOT NULL DEFAULT '0',
  `averagestatus` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_host_id`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdp`
--

DROP TABLE IF EXISTS `rdp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdp` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `proxy_addr` char(20) DEFAULT NULL,
  `cli_addr` varchar(20) NOT NULL,
  `addr` varchar(20) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `replayfile` varchar(300) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `dangerous` int(11) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2029 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdphttp`
--

DROP TABLE IF EXISTS `rdphttp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdphttp` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `proxy_addr` char(20) DEFAULT NULL,
  `cli_addr` varchar(20) DEFAULT NULL,
  `addr` char(255) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `user` char(255) CHARACTER SET gb2312 DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `window_size` char(16) DEFAULT NULL,
  `replayfile` varchar(300) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `rdp_runnig` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5332 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdpinput`
--

DROP TABLE IF EXISTS `rdpinput`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdpinput` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `at` datetime NOT NULL,
  `cmd` text NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdpmouse`
--

DROP TABLE IF EXISTS `rdpmouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdpmouse` (
  `sid` int(11) DEFAULT NULL,
  `clicktime` char(64) DEFAULT NULL,
  `position_x` int(11) DEFAULT NULL,
  `position_y` int(11) DEFAULT NULL,
  `button` char(10) DEFAULT NULL,
  `stat` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdpsessions`
--

DROP TABLE IF EXISTS `rdpsessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdpsessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `proxy_addr` char(20) DEFAULT NULL,
  `cli_addr` varchar(20) DEFAULT NULL,
  `addr` char(255) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `user` char(255) CHARACTER SET gb2312 DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `window_size` char(16) DEFAULT NULL,
  `replayfile` varchar(300) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `rdp_runnig` int(8) NOT NULL DEFAULT '1',
  `packetnum` int(16) DEFAULT NULL,
  `keydir` varchar(300) DEFAULT NULL,
  `login_template` varchar(10) NOT NULL,
  `threadid` int(32) DEFAULT NULL,
  `clipboarddir` varchar(300) DEFAULT NULL,
  `jump_play` tinyint(1) NOT NULL DEFAULT '0',
  `backup` tinyint(2) DEFAULT '0',
  `num_channels` int(11) DEFAULT NULL,
  `logincommit` int(11) DEFAULT NULL,
  `sport` char(10) NOT NULL DEFAULT '0',
  `dport` char(10) NOT NULL DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  `bpp` int(11) NOT NULL DEFAULT '16',
  `report` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `luser` (`luser`),
  KEY `login_template` (`login_template`),
  KEY `rdp_runnig` (`rdp_runnig`)
) ENGINE=MyISAM AUTO_INCREMENT=48608 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rdptoapp`
--

DROP TABLE IF EXISTS `rdptoapp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rdptoapp` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `apptable` char(20) DEFAULT NULL,
  `number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5332 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `replay_progress`
--

DROP TABLE IF EXISTS `replay_progress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replay_progress` (
  `sid` int(11) NOT NULL,
  `rate` float NOT NULL,
  `speed` float NOT NULL,
  `stop` int(1) NOT NULL DEFAULT '0',
  `read_arg` int(1) NOT NULL DEFAULT '0',
  `seek_replay` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_1`
--

DROP TABLE IF EXISTS `report_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `protocol` varchar(20) DEFAULT NULL,
  `local_user` varchar(50) DEFAULT NULL,
  `fort_user` varchar(50) DEFAULT NULL,
  `login_times` int(11) DEFAULT NULL,
  `run_command_times` int(11) DEFAULT NULL,
  `report_cycle` varchar(200) DEFAULT NULL,
  `report_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_2`
--

DROP TABLE IF EXISTS `report_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `protocol` varchar(20) NOT NULL,
  `local_user` varchar(50) NOT NULL,
  `fort_user` varchar(50) NOT NULL,
  `commands` varchar(200) NOT NULL DEFAULT '',
  `cmd_times` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_3`
--

DROP TABLE IF EXISTS `report_3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `protocol` varchar(20) NOT NULL,
  `local_user` varchar(50) NOT NULL,
  `fort_user` varchar(50) NOT NULL,
  `file_operation` varchar(200) NOT NULL DEFAULT '',
  `operation_times` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_4`
--

DROP TABLE IF EXISTS `report_4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) NOT NULL,
  `protocol` varchar(20) NOT NULL,
  `local_user` varchar(50) NOT NULL,
  `fort_user` varchar(50) NOT NULL,
  `sql_cmd` mediumtext NOT NULL,
  `cmd_times` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_5`
--

DROP TABLE IF EXISTS `report_5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `protocol` varchar(20) DEFAULT NULL,
  `local_user` varchar(50) DEFAULT NULL,
  `fort_user` varchar(50) DEFAULT NULL,
  `sql_cmd` text,
  `cmd_times` int(11) DEFAULT NULL,
  `report_cycle` varchar(200) DEFAULT NULL,
  `report_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `report_diy`
--

DROP TABLE IF EXISTS `report_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` char(255) NOT NULL,
  `type` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `applytime` datetime DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sgroupid` int(11) NOT NULL DEFAULT '0',
  `ugroupid` int(11) NOT NULL DEFAULT '0',
  `server` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resourcegroup`
--

DROP TABLE IF EXISTS `resourcegroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resourcegroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) NOT NULL,
  `devicesid` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `desc` varchar(500) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14736 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `restrictacl`
--

DROP TABLE IF EXISTS `restrictacl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restrictacl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aclname` char(255) DEFAULT NULL,
  `year` char(10) DEFAULT NULL,
  `month` char(255) DEFAULT NULL,
  `day` char(255) DEFAULT NULL,
  `time` char(255) DEFAULT NULL,
  `week` char(255) DEFAULT NULL,
  `ip` char(255) DEFAULT NULL,
  `lifetime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `restrictpolicy`
--

DROP TABLE IF EXISTS `restrictpolicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `restrictpolicy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT '0',
  `usergroupid` int(11) DEFAULT '0',
  `serverid` int(11) DEFAULT '0',
  `resourceid` int(11) DEFAULT '0',
  `aclid` int(11) DEFAULT '0',
  `devicesid` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rra`
--

DROP TABLE IF EXISTS `rra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rra` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `x_files_factor` double NOT NULL DEFAULT '0.1',
  `steps` mediumint(8) DEFAULT '1',
  `rows` int(12) NOT NULL DEFAULT '600',
  `timespan` int(12) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rra_cf`
--

DROP TABLE IF EXISTS `rra_cf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rra_cf` (
  `rra_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `consolidation_function_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`rra_id`,`consolidation_function_id`),
  KEY `rra_id` (`rra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rrdfile_backup_log`
--

DROP TABLE IF EXISTS `rrdfile_backup_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rrdfile_backup_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `backup_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=607 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_html`
--

DROP TABLE IF EXISTS `search_html`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_html` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_user` char(64) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `device_ip` char(30) DEFAULT NULL,
  `user` char(64) DEFAULT NULL,
  `luser` char(64) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `logfile` char(255) DEFAULT NULL,
  `line_num` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_rdp`
--

DROP TABLE IF EXISTS `search_rdp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_rdp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search_user` char(64) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `device_ip` char(30) DEFAULT NULL,
  `user` char(64) DEFAULT NULL,
  `luser` char(64) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `secserver`
--

DROP TABLE IF EXISTS `secserver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `keyid` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servergroup`
--

DROP TABLE IF EXISTS `servergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) NOT NULL,
  `count` int(11) NOT NULL,
  `description` varchar(200) NOT NULL DEFAULT '',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `snmpsyspolicy` int(11) DEFAULT '0',
  `snmpintpolicy` int(11) DEFAULT '0',
  `loadbalance` int(11) DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `ug_id` int(11) NOT NULL DEFAULT '0',
  `child` varchar(1024) NOT NULL DEFAULT '',
  `mcount` int(11) NOT NULL DEFAULT '0',
  `attribute` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=424 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servers`
--

DROP TABLE IF EXISTS `servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `device_type` int(11) NOT NULL,
  `hostname` varchar(255) DEFAULT NULL,
  `port` int(10) NOT NULL,
  `login_method` int(11) NOT NULL,
  `month` char(4) NOT NULL,
  `week` char(4) NOT NULL,
  `user_define` char(4) NOT NULL,
  `groupid` int(11) NOT NULL,
  `superpassword` varchar(50) DEFAULT NULL,
  `transport` tinyint(1) NOT NULL DEFAULT '0',
  `sshport` int(11) NOT NULL DEFAULT '0',
  `telnetport` int(11) NOT NULL DEFAULT '0',
  `ftpport` int(11) NOT NULL DEFAULT '0',
  `rdpport` int(11) NOT NULL DEFAULT '0',
  `vncport` int(11) NOT NULL DEFAULT '0',
  `asset_id` int(11) NOT NULL DEFAULT '0',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_specification` varchar(255) DEFAULT NULL,
  `asset_department` varchar(255) DEFAULT NULL,
  `asset_location` varchar(255) DEFAULT NULL,
  `asset_company` varchar(255) DEFAULT NULL,
  `asset_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asset_usedtime` varchar(255) DEFAULT NULL,
  `asset_warrantdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `asset_status` varchar(255) NOT NULL DEFAULT '',
  `monitor` tinyint(1) NOT NULL DEFAULT '0',
  `snmpkey` varchar(255) NOT NULL DEFAULT '',
  `oracle_name` varchar(255) NOT NULL DEFAULT '',
  `ipv6` varchar(50) DEFAULT NULL,
  `snmpnet` tinyint(1) NOT NULL DEFAULT '0',
  `port_monitor` varchar(255) DEFAULT NULL,
  `port_monitor_time` int(11) NOT NULL,
  `snmpdesc` varchar(255) DEFAULT NULL,
  `snmptime` bigint(20) DEFAULT NULL,
  `asset_desc` varchar(255) DEFAULT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `x11port` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL,
  `yunstatus` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `device_ip` (`device_ip`),
  KEY `device_ip_2` (`device_ip`),
  KEY `groupid` (`groupid`),
  KEY `device_ip_3` (`device_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=1917 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `servers_nmap`
--

DROP TABLE IF EXISTS `servers_nmap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servers_nmap` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `device_type` varchar(1024) NOT NULL,
  `scan_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `device_ip` (`ip`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessiondesc`
--

DROP TABLE IF EXISTS `sessiondesc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessiondesc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `recordtime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `username` varchar(50) NOT NULL DEFAULT '',
  `content` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cli_addr` varchar(50) DEFAULT NULL,
  `addr` char(255) NOT NULL,
  `type` enum('telnet','ssh','n/a') NOT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `logfile` varchar(255) NOT NULL,
  `replayfile` varchar(300) DEFAULT NULL,
  `s_bytes` float DEFAULT '0',
  `server_addr` varchar(50) DEFAULT NULL,
  `dangerous` int(11) DEFAULT NULL,
  `jump_total` int(11) DEFAULT '0',
  `total_cmd` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `sport` char(10) NOT NULL DEFAULT '0',
  `dport` char(10) NOT NULL DEFAULT '0',
  `backup` tinyint(2) DEFAULT '0',
  `logincommit` int(11) NOT NULL DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  `report` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `luser` (`luser`)
) ENGINE=MyISAM AUTO_INCREMENT=76582 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sessionsrun`
--

DROP TABLE IF EXISTS `sessionsrun`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessionsrun` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cli_addr` varchar(50) DEFAULT NULL,
  `addr` char(255) NOT NULL,
  `type` enum('telnet','ssh','n/a') NOT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `logfile` varchar(255) NOT NULL,
  `replayfile` varchar(300) DEFAULT NULL,
  `s_bytes` float DEFAULT '0',
  `server_addr` varchar(50) DEFAULT NULL,
  `dangerous` int(11) DEFAULT NULL,
  `jump_total` int(11) DEFAULT '0',
  `total_cmd` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `sport` char(10) NOT NULL DEFAULT '0',
  `dport` char(10) NOT NULL DEFAULT '0',
  `backup` tinyint(2) DEFAULT '0',
  `logincommit` int(11) NOT NULL DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  `report` int(11) DEFAULT '0',
  `realname` varchar(255) NOT NULL DEFAULT '',
  `baoleiip` char(255) NOT NULL,
  PRIMARY KEY (`sid`),
  KEY `luser` (`luser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) NOT NULL,
  `svalue` varchar(1024) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_graphs`
--

DROP TABLE IF EXISTS `settings_graphs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_graphs` (
  `user_id` smallint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings_tree`
--

DROP TABLE IF EXISTS `settings_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings_tree` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `graph_tree_item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`graph_tree_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpcomm`
--

DROP TABLE IF EXISTS `sftpcomm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpcomm` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `comm` char(255) NOT NULL,
  `at` datetime NOT NULL,
  `filename` varchar(300) DEFAULT NULL,
  `successed` tinyint(1) DEFAULT '1',
  `backupflag` tinyint(1) NOT NULL DEFAULT '0',
  `backupsize` int(11) NOT NULL DEFAULT '0',
  `backup` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`cid`),
  KEY `sid` (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpreport_day`
--

DROP TABLE IF EXISTS `sftpreport_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpreport_day` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpreport_diy`
--

DROP TABLE IF EXISTS `sftpreport_diy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpreport_diy` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `createid` int(11) NOT NULL DEFAULT '0',
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpreport_month`
--

DROP TABLE IF EXISTS `sftpreport_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpreport_month` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpreport_week`
--

DROP TABLE IF EXISTS `sftpreport_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpreport_week` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `radius_user` varchar(255) DEFAULT NULL,
  `realname` varchar(40) DEFAULT NULL,
  `groupname` varchar(40) NOT NULL,
  `sftp_user` varchar(100) NOT NULL,
  `putct` int(11) NOT NULL DEFAULT '0',
  `getct` int(11) NOT NULL DEFAULT '0',
  `ct` int(11) NOT NULL DEFAULT '0',
  `mstart` datetime DEFAULT NULL,
  `mend` datetime DEFAULT NULL,
  `serverip` varchar(255) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sftpsessions`
--

DROP TABLE IF EXISTS `sftpsessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sftpsessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `cliaddr` char(255) NOT NULL,
  `audit_addr` varchar(50) DEFAULT NULL,
  `svraddr` char(255) NOT NULL,
  `radius_user` char(255) DEFAULT NULL,
  `sftp_user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `replayfile` varchar(300) DEFAULT NULL,
  `total_cmd` int(11) NOT NULL DEFAULT '0',
  `sport` char(10) NOT NULL DEFAULT '0',
  `dport` char(10) NOT NULL DEFAULT '0',
  `logincommit` int(11) NOT NULL DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  `report` int(11) DEFAULT '0',
  PRIMARY KEY (`sid`),
  KEY `radius_user` (`radius_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sgroup_owner`
--

DROP TABLE IF EXISTS `sgroup_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sgroup_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` varchar(50) DEFAULT NULL,
  `servergroup` int(11) NOT NULL,
  `memberids` varchar(1024) DEFAULT NULL,
  `user1` varchar(255) NOT NULL DEFAULT '',
  `pass1` varchar(255) NOT NULL DEFAULT '',
  `linuxpass` varchar(255) NOT NULL DEFAULT '',
  `winpass` varchar(255) NOT NULL DEFAULT '',
  `sshport` int(11) NOT NULL DEFAULT '0',
  `rdpport` int(11) NOT NULL DEFAULT '0',
  `root` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `rootpass` varchar(255) NOT NULL DEFAULT '',
  `adminpass` varchar(255) NOT NULL DEFAULT '',
  `masteruser` tinyint(1) NOT NULL DEFAULT '0',
  `adminpri` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sgroup_tmp`
--

DROP TABLE IF EXISTS `sgroup_tmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sgroup_tmp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `child_0` varchar(255) NOT NULL DEFAULT '',
  `child_2` varchar(255) NOT NULL DEFAULT '',
  `child` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sgrouptmp`
--

DROP TABLE IF EXISTS `sgrouptmp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sgrouptmp` (
  `id` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `mcount` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_alert`
--

DROP TABLE IF EXISTS `snmp_alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_alert` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `groupid` int(11) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `period` int(5) NOT NULL DEFAULT '9',
  `alarmitem` varchar(50) NOT NULL DEFAULT '',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_alert_user`
--

DROP TABLE IF EXISTS `snmp_alert_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_alert_user` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `snmp_alert_id` int(11) NOT NULL DEFAULT '0',
  `memberid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_app_config`
--

DROP TABLE IF EXISTS `snmp_app_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_app_config` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_get` varchar(20) DEFAULT NULL,
  `url` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `port` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_app_status`
--

DROP TABLE IF EXISTS `snmp_app_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_app_status` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_type` varchar(20) DEFAULT NULL,
  `value` smallint(8) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `alarm` tinyint(1) NOT NULL DEFAULT '0',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_check_port`
--

DROP TABLE IF EXISTS `snmp_check_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_check_port` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port` int(8) DEFAULT NULL,
  `port_status` smallint(8) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_check_port_warning_log`
--

DROP TABLE IF EXISTS `snmp_check_port_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_check_port_warning_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port` int(8) DEFAULT NULL,
  `val` tinyint(2) DEFAULT NULL,
  `context` text COLLATE utf8_unicode_ci,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `sms_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32806 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_check_process`
--

DROP TABLE IF EXISTS `snmp_check_process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_check_process` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `process` varchar(50) DEFAULT NULL,
  `process_status` smallint(8) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_check_process_warning_log`
--

DROP TABLE IF EXISTS `snmp_check_process_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_check_process_warning_log` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `process` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `val` tinyint(2) DEFAULT NULL,
  `context` text COLLATE utf8_unicode_ci,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `sms_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22561 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_day_report_cpu`
--

DROP TABLE IF EXISTS `snmp_day_report_cpu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_day_report_cpu` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=1843 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_day_report_disk`
--

DROP TABLE IF EXISTS `snmp_day_report_disk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_day_report_disk` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=1497 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_day_report_memory`
--

DROP TABLE IF EXISTS `snmp_day_report_memory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_day_report_memory` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=1819 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_day_report_swap`
--

DROP TABLE IF EXISTS `snmp_day_report_swap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_day_report_swap` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=703 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_doc`
--

DROP TABLE IF EXISTS `snmp_doc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_doc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(255) DEFAULT NULL,
  `device_type` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) DEFAULT NULL,
  `html` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `member` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_interface`
--

DROP TABLE IF EXISTS `snmp_interface`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_interface` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `port_describe` varchar(40) DEFAULT NULL,
  `port_type` varchar(20) DEFAULT NULL,
  `port_speed` bigint(20) DEFAULT NULL,
  `normal_status` varchar(20) DEFAULT NULL,
  `cur_status` varchar(20) DEFAULT NULL,
  `traffic_in` bigint(20) DEFAULT NULL,
  `traffic_out` bigint(20) DEFAULT NULL,
  `packet_in` bigint(20) DEFAULT NULL,
  `packet_out` bigint(20) DEFAULT NULL,
  `err_packet_in` int(10) DEFAULT NULL,
  `err_packet_out` int(10) DEFAULT NULL,
  `trafffic_rrdfile` varchar(255) DEFAULT NULL,
  `packet_rrdfile` varchar(255) DEFAULT NULL,
  `err_packet_rrdfile` varchar(255) DEFAULT NULL,
  `traffic_RRD` tinyint(2) DEFAULT '1',
  `packet_RRD` tinyint(2) DEFAULT '1',
  `err_packet_RRD` tinyint(2) DEFAULT '1',
  `enable` tinyint(1) DEFAULT '1',
  `connectdevice` int(11) DEFAULT NULL,
  `connectport` varchar(255) DEFAULT NULL,
  `connectdesc` varchar(255) DEFAULT NULL,
  `connectdeviceport` varchar(255) DEFAULT NULL,
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `traffic_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `traffic_rrdfile` varchar(255) DEFAULT NULL,
  `mail_last_sendtime` datetime DEFAULT NULL,
  `sms_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=785 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_interface_cache`
--

DROP TABLE IF EXISTS `snmp_interface_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_interface_cache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `traffic_in` bigint(20) DEFAULT NULL,
  `traffic_out` bigint(20) DEFAULT NULL,
  `packet_in` bigint(20) DEFAULT NULL,
  `packet_out` bigint(20) DEFAULT NULL,
  `err_packet_in` int(10) DEFAULT NULL,
  `err_packet_out` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=270 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_interface_errlog`
--

DROP TABLE IF EXISTS `snmp_interface_errlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_interface_errlog` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `context` mediumtext,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=207251 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_interface_log`
--

DROP TABLE IF EXISTS `snmp_interface_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_interface_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `context` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3288227 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_interface_warning_log`
--

DROP TABLE IF EXISTS `snmp_interface_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_interface_warning_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `port_describe` varchar(40) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `cur_val` varchar(20) DEFAULT NULL,
  `thold` varchar(20) DEFAULT NULL,
  `context` mediumtext,
  `mail_status` tinyint(2) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22885723 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_month_report_cpu`
--

DROP TABLE IF EXISTS `snmp_month_report_cpu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_month_report_cpu` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_month_report_disk`
--

DROP TABLE IF EXISTS `snmp_month_report_disk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_month_report_disk` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_month_report_memory`
--

DROP TABLE IF EXISTS `snmp_month_report_memory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_month_report_memory` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_month_report_swap`
--

DROP TABLE IF EXISTS `snmp_month_report_swap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_month_report_swap` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_network_policy`
--

DROP TABLE IF EXISTS `snmp_network_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_network_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `trfficinhigh` int(11) NOT NULL,
  `trfficinlow` int(11) NOT NULL,
  `trfficouthigh` int(11) NOT NULL,
  `trfficoutlow` int(11) NOT NULL,
  `packetinhigh` int(11) NOT NULL,
  `packetinlow` int(11) NOT NULL,
  `packetouthigh` int(11) NOT NULL,
  `packetoutlow` int(11) NOT NULL,
  `errorinhigh` int(11) NOT NULL,
  `errorinlow` int(11) NOT NULL,
  `errorouthigh` int(11) NOT NULL,
  `erroroutlow` int(11) NOT NULL,
  `trfficrrd` tinyint(1) NOT NULL DEFAULT '1',
  `packetrrd` tinyint(1) NOT NULL DEFAULT '1',
  `errorrrd` tinyint(1) NOT NULL DEFAULT '1',
  `enable` tinyint(1) DEFAULT '1',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_nm_other`
--

DROP TABLE IF EXISTS `snmp_nm_other`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_nm_other` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `licenses_time` date DEFAULT NULL,
  `licenses_num` int(10) DEFAULT NULL,
  `startonlinetime` datetime DEFAULT NULL,
  `licenses_SN` varchar(25) DEFAULT NULL,
  `servers_num` int(10) DEFAULT NULL,
  `member_num` int(10) DEFAULT NULL,
  `devices_num` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_query`
--

DROP TABLE IF EXISTS `snmp_query`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_query` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `xml_path` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(255) DEFAULT NULL,
  `graph_template_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `data_input_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_query_graph`
--

DROP TABLE IF EXISTS `snmp_query_graph`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_query_graph` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `snmp_query_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `graph_template_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_query_graph_rrd`
--

DROP TABLE IF EXISTS `snmp_query_graph_rrd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_query_graph_rrd` (
  `snmp_query_graph_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `data_template_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `data_template_rrd_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `snmp_field_name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`snmp_query_graph_id`,`data_template_id`,`data_template_rrd_id`),
  KEY `data_template_rrd_id` (`data_template_rrd_id`),
  KEY `snmp_query_graph_id` (`snmp_query_graph_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_query_graph_rrd_sv`
--

DROP TABLE IF EXISTS `snmp_query_graph_rrd_sv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_query_graph_rrd_sv` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `snmp_query_graph_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `data_template_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sequence` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `snmp_query_graph_id` (`snmp_query_graph_id`),
  KEY `data_template_id` (`data_template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_query_graph_sv`
--

DROP TABLE IF EXISTS `snmp_query_graph_sv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_query_graph_sv` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL DEFAULT '',
  `snmp_query_graph_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `sequence` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `field_name` varchar(100) NOT NULL DEFAULT '',
  `text` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `snmp_query_graph_id` (`snmp_query_graph_id`)
) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_report_interface_day`
--

DROP TABLE IF EXISTS `snmp_report_interface_day`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_report_interface_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `policy_name` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `port_describe` varchar(40) DEFAULT NULL,
  `port_type` varchar(20) DEFAULT NULL,
  `port_speed` bigint(20) DEFAULT NULL,
  `traffic_in` bigint(20) DEFAULT NULL,
  `traffic_out` bigint(20) DEFAULT NULL,
  `packet_in` bigint(20) DEFAULT NULL,
  `packet_out` bigint(20) DEFAULT NULL,
  `err_packet_in` int(10) DEFAULT NULL,
  `err_packet_out` int(10) DEFAULT NULL,
  `connectdesc` varchar(255) DEFAULT NULL,
  `traffic_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=785 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_report_interface_month`
--

DROP TABLE IF EXISTS `snmp_report_interface_month`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_report_interface_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `policy_name` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `port_describe` varchar(40) DEFAULT NULL,
  `port_type` varchar(20) DEFAULT NULL,
  `port_speed` bigint(20) DEFAULT NULL,
  `traffic_in` bigint(20) DEFAULT NULL,
  `traffic_out` bigint(20) DEFAULT NULL,
  `packet_in` bigint(20) DEFAULT NULL,
  `packet_out` bigint(20) DEFAULT NULL,
  `err_packet_in` int(10) DEFAULT NULL,
  `err_packet_out` int(10) DEFAULT NULL,
  `connectdesc` varchar(255) DEFAULT NULL,
  `traffic_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=785 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_report_interface_policy`
--

DROP TABLE IF EXISTS `snmp_report_interface_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_report_interface_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policyname` varchar(30) DEFAULT NULL,
  `snmp_interface_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_report_interface_week`
--

DROP TABLE IF EXISTS `snmp_report_interface_week`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_report_interface_week` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `policy_name` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `port_index` int(10) DEFAULT NULL,
  `port_describe` varchar(40) DEFAULT NULL,
  `port_type` varchar(20) DEFAULT NULL,
  `port_speed` bigint(20) DEFAULT NULL,
  `traffic_in` bigint(20) DEFAULT NULL,
  `traffic_out` bigint(20) DEFAULT NULL,
  `packet_in` bigint(20) DEFAULT NULL,
  `packet_out` bigint(20) DEFAULT NULL,
  `err_packet_in` int(10) DEFAULT NULL,
  `err_packet_out` int(10) DEFAULT NULL,
  `connectdesc` varchar(255) DEFAULT NULL,
  `traffic_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `traffic_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_in_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_highvalue` bigint(20) NOT NULL DEFAULT '0',
  `err_packet_out_lowvalue` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=785 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_server_policy`
--

DROP TABLE IF EXISTS `snmp_server_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_server_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `cpuhigh` int(11) NOT NULL,
  `cpulow` int(11) NOT NULL,
  `memoryhigh` int(11) NOT NULL,
  `memorylow` int(11) NOT NULL,
  `swaphigh` int(11) NOT NULL,
  `swaplow` int(11) NOT NULL,
  `diskhigh` int(11) NOT NULL,
  `disklow` int(11) NOT NULL,
  `cpurrd` tinyint(1) NOT NULL DEFAULT '1',
  `memoryrrd` tinyint(1) NOT NULL DEFAULT '1',
  `swaprrd` tinyint(1) NOT NULL DEFAULT '1',
  `diskrrd` tinyint(1) NOT NULL DEFAULT '1',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '1',
  `cpuiohigh` int(11) NOT NULL,
  `cpuiolow` int(11) NOT NULL,
  `cpuiorrd` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_status`
--

DROP TABLE IF EXISTS `snmp_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_status` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `value` smallint(8) DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `enable` tinyint(1) NOT NULL DEFAULT '1',
  `rrdfile` varchar(255) NOT NULL DEFAULT '',
  `highvalue` int(11) NOT NULL DEFAULT '0',
  `lowvalue` int(11) NOT NULL DEFAULT '0',
  `alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_alarm` tinyint(1) NOT NULL DEFAULT '0',
  `mail_last_sendtime` datetime DEFAULT NULL,
  `send_interval` smallint(8) DEFAULT '30',
  `sms_last_sendtime` datetime DEFAULT NULL,
  `sms_alarm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_status_cache`
--

DROP TABLE IF EXISTS `snmp_status_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_status_cache` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `value` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2306 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_status_warning_log`
--

DROP TABLE IF EXISTS `snmp_status_warning_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_status_warning_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `mail_status` tinyint(2) DEFAULT NULL,
  `context` mediumtext,
  `monitor` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `cur_val` smallint(8) DEFAULT NULL,
  `thold` smallint(8) DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `sms_status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=661393 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_week_report_cpu`
--

DROP TABLE IF EXISTS `snmp_week_report_cpu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_week_report_cpu` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=293 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_week_report_disk`
--

DROP TABLE IF EXISTS `snmp_week_report_disk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_week_report_disk` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `disk` varchar(50) DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=255 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_week_report_memory`
--

DROP TABLE IF EXISTS `snmp_week_report_memory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_week_report_memory` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=290 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snmp_week_report_swap`
--

DROP TABLE IF EXISTS `snmp_week_report_swap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snmp_week_report_swap` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `avg_val` double NOT NULL,
  `high_val` double NOT NULL,
  `low_val` double NOT NULL,
  `novalue` int(10) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sourceip`
--

DROP TABLE IF EXISTS `sourceip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sourceip` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` char(255) DEFAULT NULL,
  `sourceip` char(255) DEFAULT NULL,
  `creatorid` int(11) NOT NULL DEFAULT '0',
  `description` varchar(255) NOT NULL,
  `ipv6` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=121 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sourceiplist`
--

DROP TABLE IF EXISTS `sourceiplist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sourceiplist` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `ip` char(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sqloptions`
--

DROP TABLE IF EXISTS `sqloptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sqloptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `optionsname` char(255) DEFAULT NULL,
  `sql_cmd` char(255) DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sqlserver_commands`
--

DROP TABLE IF EXISTS `sqlserver_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sqlserver_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` text,
  `danger` int(1) DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=866 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sqlserver_sessions`
--

DROP TABLE IF EXISTS `sqlserver_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sqlserver_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2259 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sshkey`
--

DROP TABLE IF EXISTS `sshkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sshkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `sshpublickey` varchar(255) DEFAULT NULL,
  `sshprivatekey` varchar(255) DEFAULT NULL,
  `keypassword` varchar(255) DEFAULT NULL,
  `sshkeyname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `memberid` (`memberid`,`devicesid`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sshkeyname`
--

DROP TABLE IF EXISTS `sshkeyname`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sshkeyname` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sshkeyname` varchar(255) DEFAULT NULL,
  `sshpublickey` varchar(255) DEFAULT NULL,
  `sshprivatekey` varchar(255) DEFAULT NULL,
  `keypassword` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sshprivatekey`
--

DROP TABLE IF EXISTS `sshprivatekey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sshprivatekey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memberid` int(11) DEFAULT NULL,
  `devicesid` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=285 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sshpublickey`
--

DROP TABLE IF EXISTS `sshpublickey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sshpublickey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line` int(11) NOT NULL DEFAULT '0',
  `privatekey` varchar(300) NOT NULL,
  `memberid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth0_inall` bigint(15) DEFAULT NULL,
  `net_eth0_outall` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  `net_eth1_inall` bigint(15) DEFAULT NULL,
  `net_eth1_outall` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=188143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_abnormal`
--

DROP TABLE IF EXISTS `status_abnormal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_abnormal` (
  `name` varchar(32) DEFAULT NULL,
  `value` int(10) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `mail_stat` tinyint(4) DEFAULT NULL,
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=18344 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_day_count`
--

DROP TABLE IF EXISTS `status_day_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_day_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=655 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_log`
--

DROP TABLE IF EXISTS `status_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_log` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `host` varchar(20) DEFAULT NULL,
  `result` int(8) DEFAULT NULL,
  `reason` mediumtext,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_month_count`
--

DROP TABLE IF EXISTS `status_month_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_month_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_warning`
--

DROP TABLE IF EXISTS `status_warning`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_warning` (
  `name` varchar(32) DEFAULT NULL,
  `thold` int(10) DEFAULT NULL,
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status_week_count`
--

DROP TABLE IF EXISTS `status_week_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_week_count` (
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `ssh_conn` int(4) DEFAULT NULL,
  `telnet_conn` int(4) DEFAULT NULL,
  `graph_conn` int(4) DEFAULT NULL,
  `ftp_conn` int(4) DEFAULT NULL,
  `db_conn` int(4) DEFAULT NULL,
  `cpu` int(4) DEFAULT NULL,
  `memory` int(4) DEFAULT NULL,
  `swap` int(4) DEFAULT NULL,
  `disk` int(4) DEFAULT NULL,
  `net_eth0_in` bigint(15) DEFAULT NULL,
  `net_eth0_out` bigint(15) DEFAULT NULL,
  `net_eth1_in` bigint(15) DEFAULT NULL,
  `net_eth1_out` bigint(15) DEFAULT NULL,
  `week_num` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `strategy`
--

DROP TABLE IF EXISTS `strategy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `strategy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `strategy_name` varchar(20) NOT NULL,
  `device_ip` varchar(20) NOT NULL,
  `month` char(2) NOT NULL,
  `week` char(2) NOT NULL,
  `user_define` char(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sub_sessions`
--

DROP TABLE IF EXISTS `sub_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_sessions` (
  `sub_sid` int(11) NOT NULL AUTO_INCREMENT,
  `parent_sid` bigint(20) DEFAULT NULL,
  `parent_cmd` text,
  `addr` varchar(255) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a') DEFAULT NULL,
  PRIMARY KEY (`sub_sid`)
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sub_template`
--

DROP TABLE IF EXISTS `sub_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_template` (
  `stid` int(11) DEFAULT NULL,
  `fid` int(11) DEFAULT NULL,
  `fpath` char(255) DEFAULT NULL,
  `new` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sybase_commands`
--

DROP TABLE IF EXISTS `sybase_commands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sybase_commands` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `sid` int(11) DEFAULT NULL,
  `at` datetime DEFAULT NULL,
  `cmd` text,
  `danger` int(1) DEFAULT '0',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=554 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sybase_sessions`
--

DROP TABLE IF EXISTS `sybase_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sybase_sessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `s_addr` char(255) DEFAULT NULL,
  `d_addr` char(255) DEFAULT NULL,
  `user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `logfile` varchar(255) DEFAULT NULL,
  `danger` int(1) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2211 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog`
--

DROP TABLE IF EXISTS `syslog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog` (
  `facility_id` int(10) DEFAULT NULL,
  `priority_id` int(10) DEFAULT NULL,
  `host_id` int(10) DEFAULT NULL,
  `logtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` varchar(1024) NOT NULL DEFAULT '',
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `logtime` (`logtime`),
  KEY `host_id` (`host_id`),
  KEY `priority_id` (`priority_id`),
  KEY `facility_id` (`facility_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44844 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_alarm_log`
--

DROP TABLE IF EXISTS `syslog_alarm_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_alarm_log` (
  `alert_id` int(10) unsigned NOT NULL DEFAULT '0',
  `logtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logmsg` varchar(1024) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_alert`
--

DROP TABLE IF EXISTS `syslog_alert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_alert` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `severity` int(10) unsigned NOT NULL DEFAULT '0',
  `method` int(10) unsigned NOT NULL DEFAULT '0',
  `num` int(10) unsigned NOT NULL DEFAULT '1',
  `type` varchar(16) NOT NULL DEFAULT '',
  `enabled` char(2) DEFAULT 'on',
  `repeat_alert` int(10) unsigned NOT NULL DEFAULT '0',
  `open_ticket` char(2) DEFAULT '',
  `message` varchar(128) NOT NULL DEFAULT '',
  `user` varchar(32) NOT NULL DEFAULT '',
  `date` int(16) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `command` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_facilities`
--

DROP TABLE IF EXISTS `syslog_facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_facilities` (
  `facility_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `facility` varchar(10) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`facility`),
  KEY `facility_id` (`facility_id`),
  KEY `last_updates` (`last_updated`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_host_facilities`
--

DROP TABLE IF EXISTS `syslog_host_facilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_host_facilities` (
  `host_id` int(10) unsigned NOT NULL,
  `facility_id` int(10) unsigned NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`host_id`,`facility_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_hosts`
--

DROP TABLE IF EXISTS `syslog_hosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_hosts` (
  `host_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `host` varchar(128) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`host`),
  KEY `host_id` (`host_id`),
  KEY `last_updated` (`last_updated`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Contains all hosts currently in the syslog table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_incoming`
--

DROP TABLE IF EXISTS `syslog_incoming`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_incoming` (
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `host` varchar(128) DEFAULT NULL,
  `message` varchar(1024) NOT NULL DEFAULT '',
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`seq`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=44844 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_logs`
--

DROP TABLE IF EXISTS `syslog_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_logs` (
  `alert_id` int(10) unsigned NOT NULL DEFAULT '0',
  `logseq` bigint(20) unsigned NOT NULL,
  `logtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logmsg` varchar(1024) DEFAULT NULL,
  `host` varchar(32) DEFAULT NULL,
  `facility` varchar(10) DEFAULT NULL,
  `priority` varchar(10) DEFAULT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `html` blob,
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `logseq` (`logseq`),
  KEY `alert_id` (`alert_id`),
  KEY `host` (`host`),
  KEY `seq` (`seq`),
  KEY `logtime` (`logtime`),
  KEY `priority` (`priority`),
  KEY `facility` (`facility`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_priorities`
--

DROP TABLE IF EXISTS `syslog_priorities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_priorities` (
  `priority_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` varchar(10) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`priority`),
  KEY `priority_id` (`priority_id`),
  KEY `last_updated` (`last_updated`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_remove`
--

DROP TABLE IF EXISTS `syslog_remove`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_remove` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(16) NOT NULL DEFAULT '',
  `enabled` char(2) DEFAULT 'on',
  `method` char(5) DEFAULT 'del',
  `message` varchar(128) NOT NULL DEFAULT '',
  `user` varchar(32) NOT NULL DEFAULT '',
  `date` int(16) NOT NULL DEFAULT '0',
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_removed`
--

DROP TABLE IF EXISTS `syslog_removed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_removed` (
  `facility_id` int(10) DEFAULT NULL,
  `priority_id` int(10) DEFAULT NULL,
  `host_id` int(10) DEFAULT NULL,
  `logtime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` varchar(1024) NOT NULL DEFAULT '',
  `seq` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`seq`),
  KEY `logtime` (`logtime`),
  KEY `host_id` (`host_id`),
  KEY `priority_id` (`priority_id`),
  KEY `facility_id` (`facility_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_reports`
--

DROP TABLE IF EXISTS `syslog_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_reports` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(16) NOT NULL DEFAULT '',
  `enabled` char(2) DEFAULT 'on',
  `timespan` int(16) NOT NULL DEFAULT '0',
  `timepart` char(5) NOT NULL DEFAULT '00:00',
  `lastsent` int(16) NOT NULL DEFAULT '0',
  `body` varchar(1024) DEFAULT NULL,
  `message` varchar(128) DEFAULT NULL,
  `user` varchar(32) NOT NULL DEFAULT '',
  `date` int(16) NOT NULL DEFAULT '0',
  `email` varchar(255) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `syslog_statistics`
--

DROP TABLE IF EXISTS `syslog_statistics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `syslog_statistics` (
  `host_id` int(10) unsigned NOT NULL,
  `facility_id` int(10) unsigned NOT NULL,
  `priority_id` int(10) unsigned NOT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `records` int(10) unsigned NOT NULL,
  PRIMARY KEY (`host_id`,`facility_id`,`priority_id`,`insert_time`),
  KEY `host_id` (`host_id`),
  KEY `facility_id` (`facility_id`),
  KEY `priority_id` (`priority_id`),
  KEY `insert_time` (`insert_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Maintains High Level Statistics';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tcp_port`
--

DROP TABLE IF EXISTS `tcp_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcp_port` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `tcpport` smallint(8) DEFAULT NULL,
  `timeout` smallint(8) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tcp_port_alarm`
--

DROP TABLE IF EXISTS `tcp_port_alarm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcp_port_alarm` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `tcpport` int(8) unsigned DEFAULT NULL,
  `time` smallint(8) DEFAULT NULL,
  `alarm` tinyint(2) DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `context` mediumtext,
  `port_time` int(11) DEFAULT NULL,
  `port_thold` int(11) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tcp_port_err`
--

DROP TABLE IF EXISTS `tcp_port_err`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcp_port_err` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `tcpport` smallint(8) DEFAULT NULL,
  `time_err` smallint(8) DEFAULT NULL,
  `time_thold` smallint(8) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tcp_port_errlog`
--

DROP TABLE IF EXISTS `tcp_port_errlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcp_port_errlog` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_ip` varchar(20) DEFAULT NULL,
  `port` varchar(50) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `context` mediumtext,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=24257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tcp_port_value`
--

DROP TABLE IF EXISTS `tcp_port_value`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tcp_port_value` (
  `seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `tcpport` int(8) unsigned DEFAULT NULL,
  `time` float(6,3) DEFAULT NULL,
  `rrdfile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `ip` char(20) DEFAULT NULL,
  `device_type` int(11) DEFAULT NULL,
  `audit_item` int(11) DEFAULT NULL,
  `normal` int(11) DEFAULT NULL,
  `error` text,
  `output` text,
  `audit_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '0',
  `realm` mediumint(8) NOT NULL DEFAULT '0',
  `full_name` varchar(100) DEFAULT '0',
  `must_change_password` char(2) DEFAULT NULL,
  `show_tree` char(2) DEFAULT 'on',
  `show_list` char(2) DEFAULT 'on',
  `show_preview` char(2) NOT NULL DEFAULT 'on',
  `graph_settings` char(2) DEFAULT NULL,
  `login_opts` tinyint(1) NOT NULL DEFAULT '1',
  `policy_graphs` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `policy_trees` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `policy_hosts` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `policy_graph_templates` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `enabled` char(2) NOT NULL DEFAULT 'on',
  `email` varchar(255) NOT NULL DEFAULT '',
  `mobile` varchar(255) NOT NULL DEFAULT '',
  `host_group` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `realm` (`realm`),
  KEY `enabled` (`enabled`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_auth_perms`
--

DROP TABLE IF EXISTS `user_auth_perms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth_perms` (
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `item_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`item_id`,`type`),
  KEY `user_id` (`user_id`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_auth_realm`
--

DROP TABLE IF EXISTS `user_auth_realm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_auth_realm` (
  `realm_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`realm_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `username` varchar(50) NOT NULL DEFAULT '0',
  `user_id` mediumint(8) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `result` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(40) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`,`user_id`,`time`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usergroup`
--

DROP TABLE IF EXISTS `usergroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(64) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '1',
  `UserName` varchar(64) NOT NULL,
  `ldapid` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `snmpsyspolicy` int(11) DEFAULT '0',
  `snmpintpolicy` int(11) DEFAULT '0',
  `loadbalance` int(11) DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `sg_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `version`
--

DROP TABLE IF EXISTS `version`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(30) NOT NULL,
  `version` varchar(30) NOT NULL,
  `start` datetime DEFAULT NULL,
  `md5` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vncserver`
--

DROP TABLE IF EXISTS `vncserver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vncserver` (
  `port` int(11) NOT NULL,
  `ip` varchar(48) DEFAULT NULL,
  `lock_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`port`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vncsessions`
--

DROP TABLE IF EXISTS `vncsessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vncsessions` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `proxy_addr` char(20) DEFAULT NULL,
  `cli_addr` varchar(20) DEFAULT NULL,
  `addr` char(255) DEFAULT NULL,
  `type` enum('telnet','ssh','n/a','rdp') NOT NULL,
  `user` char(255) CHARACTER SET gb2312 DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `luser` char(255) DEFAULT NULL,
  `window_size` char(16) DEFAULT NULL,
  `replayfile` varchar(300) NOT NULL,
  `filesize` int(11) DEFAULT NULL,
  `vnc_runnig` int(8) NOT NULL DEFAULT '1',
  `packetnum` int(16) DEFAULT NULL,
  `keydir` varchar(300) DEFAULT NULL,
  `login_template` varchar(10) NOT NULL,
  `threadid` int(32) DEFAULT NULL,
  `desc` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vpn_log`
--

DROP TABLE IF EXISTS `vpn_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vpn_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(128) NOT NULL,
  `src_ip` varchar(32) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `in_time` datetime DEFAULT NULL,
  `out_time` datetime DEFAULT NULL,
  `isactive` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2351 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vpndynamicpassword`
--

DROP TABLE IF EXISTS `vpndynamicpassword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vpndynamicpassword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authtime` datetime NOT NULL,
  `nasipaddress` varchar(16) NOT NULL,
  `callingstationid` varchar(16) NOT NULL,
  `username` varchar(64) NOT NULL,
  `dynamicpassword` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `weektime`
--

DROP TABLE IF EXISTS `weektime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weektime` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `policyname` char(255) DEFAULT NULL,
  `start_time1` time NOT NULL DEFAULT '00:00:00',
  `end_time1` time NOT NULL DEFAULT '23:59:59',
  `start_time2` time NOT NULL DEFAULT '00:00:00',
  `end_time2` time NOT NULL DEFAULT '23:59:59',
  `start_time3` time NOT NULL DEFAULT '00:00:00',
  `end_time3` time NOT NULL DEFAULT '23:59:59',
  `start_time4` time NOT NULL DEFAULT '00:00:00',
  `end_time4` time NOT NULL DEFAULT '23:59:59',
  `start_time5` time NOT NULL DEFAULT '00:00:00',
  `end_time5` time NOT NULL DEFAULT '23:59:59',
  `start_time6` time NOT NULL DEFAULT '00:00:00',
  `end_time6` time NOT NULL DEFAULT '23:59:59',
  `start_time7` time NOT NULL DEFAULT '00:00:00',
  `end_time7` time NOT NULL DEFAULT '23:59:59',
  `creatorid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `weixin`
--

DROP TABLE IF EXISTS `weixin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weixin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sumAttentnum` int(11) NOT NULL DEFAULT '0',
  `sumRegnum` int(11) NOT NULL DEFAULT '0',
  `sumBindnum` int(11) NOT NULL DEFAULT '0',
  `sumpaynum` int(11) NOT NULL DEFAULT '0',
  `summoneynum` int(11) NOT NULL DEFAULT '0',
  `sumpaymoneynum` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `winservers`
--

DROP TABLE IF EXISTS `winservers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `winservers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow`
--

DROP TABLE IF EXISTS `workflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `contant` int(11) NOT NULL,
  `devicesid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL,
  `desc` char(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `sessionid` int(11) NOT NULL,
  `islogin` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `operator` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_contant`
--

DROP TABLE IF EXISTS `workflow_contant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_contant` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(255) NOT NULL,
  `desc` char(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `workflow_log`
--

DROP TABLE IF EXISTS `workflow_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workflow_log` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `wid` int(11) NOT NULL,
  `member` char(255) NOT NULL,
  `apply_date` datetime DEFAULT NULL,
  `apply_status` tinyint(1) DEFAULT '0',
  `desc` char(255) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `x11sessions`
--

DROP TABLE IF EXISTS `x11sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `x11sessions` (
  `xid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `cliaddr` char(255) NOT NULL,
  `svraddr` char(255) NOT NULL,
  `auditaddr` char(255) NOT NULL,
  `radius_user` char(255) DEFAULT NULL,
  `server_user` char(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `keyboardfile` varchar(300) DEFAULT NULL,
  `SMAC` char(255) DEFAULT NULL,
  `DMAC` char(255) DEFAULT NULL,
  `subsessionid` int(11) DEFAULT '0',
  `desc` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`xid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-19 22:30:27
