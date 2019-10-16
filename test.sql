CREATE DATABASE IF NOT EXISTS `test`;

USE `test`;

SET foreign_key_checks = 0;

DROP TABLE IF EXISTS `crud`;

CREATE TABLE `crud` (
  `id` int(11) DEFAULT NULL,
  `codigo` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `crud` VALUES (1,"Seguridad"),
(2,"blanca");


SET foreign_key_checks = 1;
