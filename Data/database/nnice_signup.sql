CREATE TABLE nice_signup(
  n_id MEDIUMINT UNSIGNED AUTO_INCREMENT COMMENT "id",
  n_name VARCHAR(10) NOT NULL DEFAULT "" COMMENT "姓名",
  n_tel VARCHAR(20) NOT NULL  DEFAULT "" COMMENT "电话",
  n_grade VARCHAR(10) NOT NULL  DEFAULT "" COMMENT "意向年级",
  n_subject VARCHAR(10) NOT NULL  DEFAULT "" COMMENT "科目",
  n_level VARCHAR(10) NOT NULL  DEFAULT "" COMMENT "当前水平",
  PRIMARY KEY (n_id)
)CHARSET utf8 COMMENT "话筒教育花溪分校报名表";

alter TABLE nice_signup add n_time INT UNSIGNED AFTER  n_level;