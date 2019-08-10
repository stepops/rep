CREATE DATABASE IF NOT EXISTS test;
USE test;
CREATE TABLE IF NOT EXISTS `people` (

  `id` int(11) NOT NULL auto_increment,
  `name` varchar(250)  NOT NULL default '',
  `salary`  int(11) NULL,
  `birthday` date,
   PRIMARY KEY  (`id`)

);

INSERT IGNORE INTO people
    (id, name, salary, birthday)
VALUES
    (1, 'John Smith', 100, 19910131);
