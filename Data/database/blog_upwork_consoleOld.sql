CREATE TABLE `blog_upwork_console` (
  `con_id` int(10) UNSIGNED NOT NULL,
  `con_switch` tinyint(3) UNSIGNED NOT NULL COMMENT '0 -关   1-开',
  `grade` varchar(32) DEFAULT NULL,
  `major` varchar(32) DEFAULT NULL COMMENT '作业名称',
  `course` varchar(32) DEFAULT NULL,
  `course_type` varchar(32) DEFAULT NULL,
  `date` int(10) UNSIGNED DEFAULT NULL COMMENT '日期',
  `save_path` varchar(45) DEFAULT NULL,
  `request` varchar(122) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sw_work_console`
--

INSERT INTO `sw_work_console` (`con_id`, `con_switch`, `grade`, `major`, `course`, `course_type`, `date`, `save_path`, `request`) VALUES
(1, 1, '2015级', '软件工程', '数据库', '实验报告', 1500882132, './170723/', '哈哈哈哈哈哈');


CREATE TABLE if NOT  EXISTS blog_upwork_console()charset ut