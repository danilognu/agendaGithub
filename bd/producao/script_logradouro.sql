/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.5-10.1.16-MariaDB : Database - agenda_lets
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`agenda_lets` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `agenda_lets`;

/*Table structure for table `tipo_logradouro` */

DROP TABLE IF EXISTS `tipo_logradouro`;

CREATE TABLE `tipo_logradouro` (
  `id_tipo_logradouro` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_logradouro`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `tipo_logradouro` */

insert  into `tipo_logradouro`(`id_tipo_logradouro`,`nome`) values (1,'Acesso'),(2,'Alamenda'),(3,'Área'),(4,'Avenida'),(5,'Beco'),(6,'Calçada'),(7,'Chacara'),(8,'Conjunto'),(9,'Corredor'),(10,'Escada'),(11,'Estação'),(12,'Estrada'),(13,'Estrada Venha'),(14,'Fazenda'),(15,'Ferrovia'),(16,'Galeria'),(17,'Ladeira'),(18,'Lagoa'),(19,'Largo'),(20,'Localidade'),(21,'Mina'),(22,'Nucleo'),(23,'Parque'),(24,'Passagem'),(25,'Passarela'),(26,'Praça'),(27,'Ponte'),(28,'Quadra'),(29,'Rodovia'),(30,'Rua');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

ALTER TABLE localidade ADD id_tipo_logradouro INT

