CREATE DATABASE  IF NOT EXISTS `pdo_quest` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pdo_quest`;

DROP TABLE IF EXISTS `friend`;

CREATE TABLE `friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


LOCK TABLES `friend` WRITE;

INSERT INTO `friend` VALUES (1,'Ross','Geller'),(2,'Monica','Geller'),(3,'Phoebe','Buffay'),(4,'Joey','Tribbiani');

UNLOCK TABLES;
