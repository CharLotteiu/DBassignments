-- phpMyAdmin SQL Dump
-- version 4.0.10.11
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2020-06-30 12:32:23
-- 服务器版本: 5.7.17-log
-- PHP 版本: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `todolist`
--

-- --------------------------------------------------------

--
-- 表的结构 `list`
--

CREATE TABLE IF NOT EXISTS `list` (
  `lid` int(100) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL,
  `list_name` varchar(100) NOT NULL,
  PRIMARY KEY (`lid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- 表的结构 `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `tid` int(100) NOT NULL AUTO_INCREMENT,
  `uid` int(100) NOT NULL,
  `ddl` varchar(100) NOT NULL,
  `create_date` varchar(100) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `importance` int(100) NOT NULL,
  `lid` int(100) DEFAULT NULL,
  `status` int(100) NOT NULL,
  PRIMARY KEY (`tid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(100) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(1) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`uid`, `email`, `user_name`, `password`, `role`) VALUES
(0, 'admin@123.com', 'ADMIN', '123', 0);

--
-- 限制导出的表
--

--
-- 限制表 `list`
--
ALTER TABLE `list`
  ADD CONSTRAINT `list_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `todo`
--
ALTER TABLE `todo`
  ADD CONSTRAINT `todo_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
