-- CREATE TABLE user
DROP TABLE IF EXISTS `user`; 
CREATE TABLE `user` (
  `id`       int(10) UNSIGNED AUTO_INCREMENT,
  `email`    varchar(64) NOT NULL,
  `name`     varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY  (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='RSS feed authorized users';