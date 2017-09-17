set names utf8;
use blog;
CREATE TABLE `blog_upwork_console` (
  con_id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  con_switch enum("off","on") DEFAULT "off" COMMENT '是否开启功能:on 打开,off 关闭',
  con_grade varchar(32) DEFAULT NULL COMMENT  "年级:如2015级",
  con_major varchar(32) DEFAULT NULL COMMENT  '专业:如软件工程',
  con_course varchar(32) DEFAULT NULL COMMENT  "课程名称:如数据库",
  con_course_type varchar(32) DEFAULT NULL COMMENT "作业类型:如实验报告/课时作业/平时作业/读书报告",
  con_date INT UNSIGNED DEFAULT NULL COMMENT '作业规定提交日期',
  con_save_path varchar(45) DEFAULT NULL COMMENT '文件保存路径',
  con_request varchar(122) DEFAULT "" COMMENT "作业要求",
  PRIMARY KEY (con_id)
)CHARSET UTF8 COMMENT "作业控制台表";



INSERT INTO `blog_upwork_console` VALUES(1, 1, '2015级', '软件工程', '数据库', '实验报告', 1500882132, './170723/', '暂时没有要求');


CREATE TABLE blog_user(
  user_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT "id",
  user_email VARCHAR(32) NOT NULL COMMENT "邮箱",
  user_stu_num VARCHAR(32) NOT NULL COMMENT "学号",
  user_pwd VARCHAR(32) NOT NULL COMMENT "密码",
  user_name VARCHAR(5) NOT NULL COMMENT "姓名",
  user_is_active ENUM('0','1') DEFAULT "0" COMMENT '激活标志:0-没有激活 1-激活',
  user_add_date INT UNSIGNED NOT NULL COMMENT "用户添加时间",
  user_is_vip ENUM("0",'1') DEFAULT '0' COMMENT "是否是vip:0-不是-不允许下载 1-是-允许下载",
  PRIMARY KEY (user_id),
  KEY (user_email),
  KEY (user_stu_num),
  key (user_pwd)
)CHARSET utf8;

CREATE TABLE blog_upwork(
  work_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT "id",
  work_name VARCHAR(64) NOT NULL COMMENT "作业名字",
  work_stu_num VARCHAR(32) NOT NULL COMMENT "作业上传者学号",
  work_add_date INT UNSIGNED NOT NULL COMMENT "作业上传日期",
  work_is_del ENUM('已删除','未删除') DEFAULT "未删除" COMMENT '作业状态',
  work_save_path VARCHAR(64) NOT NULL DEFAULT "" COMMENT "作业保存路径",
  work_course VARCHAR(32) NOT NULL DEFAULT "" COMMENT "作业科目",
  work_course_type VARCHAR(32) NOT NULL DEFAULT "" COMMENT "作业类别:实验/读书报告...",
  PRIMARY KEY (work_id)
 )CHARSET utf8;

CREATE TABLE blog_upwork(
  work_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT "id",
  work_name VARCHAR(64) NOT NULL COMMENT "作业名字",
  work_stu_num VARCHAR(32) NOT NULL COMMENT "作业上传者学号",
  work_add_date INT UNSIGNED NOT NULL COMMENT "作业上传日期",
  work_is_del ENUM('已删除','未删除') DEFAULT "未删除" COMMENT '作业状态',
  work_save_path VARCHAR(64) NOT NULL DEFAULT "" COMMENT "作业保存路径",
  work_course VARCHAR(32) NOT NULL DEFAULT "" COMMENT "作业科目",
  work_course_type VARCHAR(32) NOT NULL DEFAULT "" COMMENT "作业类别:实验/读书报告...",
  PRIMARY KEY (work_id)
 )CHARSET utf8;