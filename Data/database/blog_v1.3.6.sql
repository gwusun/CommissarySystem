-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2017-08-28 04:57:07
-- 服务器版本： 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- 表的结构 `blog_upwork`
--

CREATE TABLE `blog_upwork` (
  `work_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `work_name` varchar(128) NOT NULL COMMENT '作业名字',
  `work_stu_num` varchar(32) NOT NULL COMMENT '作业上传者学号',
  `work_add_date` int(10) UNSIGNED NOT NULL COMMENT '作业上传日期',
  `work_is_del` enum('已删除','未删除') DEFAULT '未删除' COMMENT '作业状态',
  `work_save_path` varchar(128) NOT NULL DEFAULT '' COMMENT '作业保存路径',
  `work_course` varchar(32) NOT NULL DEFAULT '' COMMENT '作业科目',
  `work_course_type` varchar(32) NOT NULL DEFAULT '' COMMENT '作业类别:实验/读书报告...'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `blog_upwork`
--

INSERT INTO `blog_upwork` (`work_id`, `work_name`, `work_stu_num`, `work_add_date`, `work_is_del`, `work_save_path`, `work_course`, `work_course_type`) VALUES
(1, '2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '20150107030131', 1503189782, '已删除', './Uploads/data/2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '数据库', '实验报告'),
(2, '2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '20150107030131', 1503189782, '已删除', './Uploads/data/2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '数据库', '实验报告'),
(3, '2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '20150107030131', 1503189782, '已删除', './Uploads/data/2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '数据库', '实验报告'),
(4, '2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '20150107030131', 1503189782, '已删除', './Uploads/data/2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '数据库', '实验报告'),
(5, '2015级软件工程11数据库实验报告20170817.bat', '1', 1503058274, '已删除', './Uploads/data/2015级软件工程11数据库实验报告20170817.bat', '数据库', '实验报告'),
(6, '2015级软件工程22数据库实验报告20170817.bat', '2', 1503058293, '已删除', './Uploads/data/2015级软件工程22数据库实验报告20170817.bat', '数据库', '实验报告'),
(7, '2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '20150107030131', 1503189782, '已删除', './Uploads/data/2015级软件工程孙武20150107030131数据库实验报告20170817.jpg', '数据库', '实验报告'),
(8, '2015级软件工程孙武20150107030131数据库实验报告20170820.jpg', '20150107030131', 1503194703, '已删除', './Uploads/88/2015级软件工程孙武20150107030131数据库实验报告20170820.jpg', '数据库', '实验报告'),
(9, '2015级软件工程孙武20150107030131数据库实验报告20170820.jpg', '20150107030131', 1503194789, '已删除', './Uploads/数据库作业/2015级软件工程孙武20150107030131数据库实验报告20170820.jpg', '数据库', '实验报告'),
(10, '2015级软件工程孙武20150107030131数据库实验报告20170820.txt', '20150107030131', 1503197159, '已删除', './Uploads/数据库作业/2015级软件工程孙武20150107030131数据库实验报告20170820.txt', '数据库', '实验报告'),
(11, '2015级软件工程孙武20150107030131数据库实验报告20170820.gz', '20150107030131', 1503270490, '已删除', './Uploads/数据库作业/2015级软件工程孙武20150107030131数据库实验报告20170820.gz', '数据库', '实验报告'),
(12, '2015级软件工程孙武20150107030131数据库实验报告20170820.dll', '20150107030131', 1503630149, '未删除', './Uploads/数据库作业/2015级软件工程孙武20150107030131数据库实验报告20170820.dll', '数据库', '实验报告');

-- --------------------------------------------------------

--
-- 表的结构 `blog_upwork_console`
--

CREATE TABLE `blog_upwork_console` (
  `con_id` tinyint(3) UNSIGNED NOT NULL,
  `con_switch` enum('off','on') DEFAULT 'off' COMMENT '是否开启功能:on 打开,off 关闭',
  `con_grade` varchar(32) DEFAULT NULL COMMENT '年级:如2015级',
  `con_major` varchar(32) DEFAULT NULL COMMENT '专业:如软件工程',
  `con_course` varchar(32) DEFAULT NULL COMMENT '课程名称:如数据库',
  `con_course_type` varchar(32) DEFAULT NULL COMMENT '作业类型:如实验报告/课时作业/平时作业/读书报告',
  `con_date` int(10) UNSIGNED DEFAULT NULL COMMENT '作业规定提交日期',
  `con_save_path` varchar(45) DEFAULT NULL COMMENT '文件保存路径',
  `con_request` varchar(122) DEFAULT '' COMMENT '作业要求',
  `con_save_root` varchar(32) DEFAULT '/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='作业控制台表';

--
-- 转存表中的数据 `blog_upwork_console`
--

INSERT INTO `blog_upwork_console` (`con_id`, `con_switch`, `con_grade`, `con_major`, `con_course`, `con_course_type`, `con_date`, `con_save_path`, `con_request`, `con_save_root`) VALUES
(1, 'on', '2015级', '软件工程', '数据库', '实验报告', 1503630225, './数据库作业/', '快点交交交', './Uploads/');

-- --------------------------------------------------------

--
-- 表的结构 `blog_user`
--

CREATE TABLE `blog_user` (
  `user_id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `user_email` varchar(32) NOT NULL COMMENT '邮箱',
  `user_stu_num` varchar(32) NOT NULL COMMENT '学号',
  `user_pwd` varchar(32) NOT NULL COMMENT '密码',
  `user_name` varchar(5) NOT NULL COMMENT '姓名',
  `user_is_active` enum('0','1') DEFAULT '0' COMMENT '激活标志:0-没有激活 1-激活',
  `user_add_date` int(10) UNSIGNED NOT NULL COMMENT '用户添加时间',
  `user_is_vip` enum('0','1') DEFAULT '0' COMMENT '是否是vip:0-不是-不允许下载 1-是-允许下载',
  `user_check_code` varchar(32) DEFAULT '',
  `user_is_stu` enum('1','0') NOT NULL DEFAULT '0' COMMENT '是否是学生:1-是 0-不是',
  `user_download_count` mediumint(9) NOT NULL DEFAULT '0' COMMENT '作业下载次数统计',
  `user_login_times` mediumint(9) DEFAULT '0' COMMENT '登陆次数',
  `user_usertitle` enum('普通用户','vip','svip') DEFAULT '普通用户'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `blog_user`
--

INSERT INTO `blog_user` (`user_id`, `user_email`, `user_stu_num`, `user_pwd`, `user_name`, `user_is_active`, `user_add_date`, `user_is_vip`, `user_check_code`, `user_is_stu`, `user_download_count`, `user_login_times`, `user_usertitle`) VALUES
(1, '1228746736@qq.com', '20150107030131', '1', '孙武', '1', 1423432, '1', '', '1', 85, 8, 'svip');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_upwork`
--
ALTER TABLE `blog_upwork`
  ADD PRIMARY KEY (`work_id`);

--
-- Indexes for table `blog_upwork_console`
--
ALTER TABLE `blog_upwork_console`
  ADD PRIMARY KEY (`con_id`);

--
-- Indexes for table `blog_user`
--
ALTER TABLE `blog_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_stu_num` (`user_stu_num`),
  ADD KEY `user_pwd` (`user_pwd`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `blog_upwork`
--
ALTER TABLE `blog_upwork`
  MODIFY `work_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=13;
--
-- 使用表AUTO_INCREMENT `blog_upwork_console`
--
ALTER TABLE `blog_upwork_console`
  MODIFY `con_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- 使用表AUTO_INCREMENT `blog_user`
--
ALTER TABLE `blog_user`
  MODIFY `user_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
