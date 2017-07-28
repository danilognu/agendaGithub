/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.5-10.1.13-MariaDB : Database - agenda_lets
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`agenda_lets` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `agenda_lets`;

/*Table structure for table `grid_consulta` */

DROP TABLE IF EXISTS `grid_consulta`;

CREATE TABLE `grid_consulta` (
  `id_grid_consulta` int(11) NOT NULL AUTO_INCREMENT,
  `campo_bd` varchar(200) DEFAULT NULL,
  `campo_visual` varchar(200) DEFAULT NULL,
  `nome_tela` varchar(200) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `ind_padrao` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_grid_consulta`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

/*Data for the table `grid_consulta` */

insert  into `grid_consulta`(`id_grid_consulta`,`campo_bd`,`campo_visual`,`nome_tela`,`id_menu`,`ind_padrao`) values (1,'id_pessoa','Codigo','CLIENTE',4,1),(2,'nome','Nome','CLIENTE',4,1),(3,'nome_fantasia','Nome Fantasia','CLIENTE',4,NULL),(4,'cnpj','CNPJ','CLIENTE',4,1),(5,'cep','CEP','CLIENTE',4,NULL),(6,'endereco','Endereço','CLIENTE',4,1),(7,'bairro','Bairro','CLIENTE',4,1),(8,'numero','Numero','CLIENTE',4,NULL),(9,'nome_cidade','Cidade','CLIENTE',4,NULL),(10,'uf','Estado','CLIENTE',4,NULL),(11,'complemento','Complemento','CLIENTE',4,NULL),(12,'telefone','Telefone','CLIENTE',4,NULL),(13,'email','E-mail','CLIENTE',4,NULL),(14,'ativo','Status','CLIENTE',4,NULL),(15,'dt_cadastro','Data Cadastro','CLIENTE',4,NULL),(16,'nome','Nome','MOTORISTA',8,1),(17,'cpf','Cpf','MOTORISTA',8,1),(18,'cep','Cep','MOTORISTA',8,1),(19,'endereco','Endereço','MOTORISTA',8,1),(20,'bairro','Bairro','MOTORISTA',8,1),(21,'numero','Numero','MOTORISTA',8,NULL),(22,'nome_cidade','Cidade','MOTORISTA',8,NULL),(23,'uf','Estado','MOTORISTA',8,NULL),(24,'complemento','Complemento','MOTORISTA',8,NULL),(25,'telefone','Telefone','MOTORISTA',8,NULL),(26,'celular','celular','MOTORISTA',8,NULL),(27,'email','E-mail','MOTORISTA',8,NULL),(28,'ativo','Status','MOTORISTA',8,NULL),(29,'num_habilitacao','Num Habilitação','MOTORISTA',8,NULL),(30,'orgao_habilitacao','Orgão Habilitação','MOTORISTA',8,NULL),(31,'categoria_habilitacao','Categoria Habilitação','MOTORISTA',8,NULL),(32,'validade_habilitacao','Validade Habilitação','MOTORISTA',8,NULL),(33,'dt_cadastro','Data Cadastro','MOTORISTA',8,NULL),(34,'id_pessoa','Codigo','MOTORISTA',8,NULL),(35,'id_localidade','Codigo','LOCALIDADE',11,1),(36,'nome','Nome','LOCALIDADE',11,1),(37,'nome_categoria','Categoria','LOCALIDADE',11,1),(38,'longitude','Longitude','LOCALIDADE',11,NULL),(39,'latitude','Latitude','LOCALIDADE',11,NULL),(41,'cep','Cep','LOCALIDADE',11,NULL),(42,'endereco','Endereço','LOCALIDADE',11,1),(43,'bairro','Bairro','LOCALIDADE',11,1),(44,'numero','Numero','LOCALIDADE',11,1),(45,'complemento','Complemento','LOCALIDADE',11,NULL),(46,'nome_cidade','Cidade','LOCALIDADE',11,NULL),(47,'uf','Estado','LOCALIDADE',11,NULL),(48,'telefone','Telefone','LOCALIDADE',11,NULL),(49,'garagem','Garagem','LOCALIDADE',11,NULL),(50,'cod_rastreamento','Cod Rastreamento','LOCALIDADE',11,NULL),(51,'ativo','Status','LOCALIDADE',11,NULL),(52,'dt_cad','Data Cadastro','LOCALIDADE',11,NULL),(53,'id_veiculo','Codigo','VEICULO',5,NULL),(54,'nomeModelo','Modelo','VEICULO',5,NULL),(55,'nomeCombustivel','Combustivel','VEICULO',5,NULL),(56,'nomeCor','Cor','VEICULO',5,NULL),(57,'placa','Placa','VEICULO',5,1),(58,'chassi','Chassi','VEICULO',5,1),(59,'renavam','Renavam','VEICULO',5,1),(60,'ano_veiculo','Ano Veiculo','VEICULO',5,NULL),(61,'ano_modelo','Ano Modelo','VEICULO',5,NULL),(62,'ativo','Status','VEICULO',5,NULL),(63,'id_nivel_combustivel','Nivel Combustivel','VEICULO',5,NULL),(64,'portas','Portas','VEICULO',5,NULL),(65,'km','KM','VEICULO',5,NULL),(66,'exclusivo','Exclusivo','VEICULO',5,NULL),(67,'data_substituidoDev','Substituido/Devl','VEICULO',5,NULL),(68,'id_pessoa','Codigo','EMPRESA',24,1),(69,'nome','Nome','EMPRESA',24,1),(70,'nome_fantasia','Nome Fantasia','EMPRESA',24,NULL),(71,'cnpj','CNPJ','EMPRESA',24,1),(72,'cep','CEP','EMPRESA',24,NULL),(73,'endereco','Endereço','EMPRESA',24,1),(74,'bairro','Bairro','EMPRESA',24,1),(75,'numero','Numero','EMPRESA',24,1),(76,'nome_cidade','Cidade','EMPRESA',24,NULL),(77,'uf','Estado','EMPRESA',24,NULL),(78,'complemento','Complemento','EMPRESA',24,NULL),(79,'telefone','Telefone','EMPRESA',24,NULL),(80,'email','E-mail','EMPRESA',24,NULL),(81,'ativo','Status','EMPRESA',24,NULL),(82,'id_solicitacao','Codigo','SOLICITACAO',12,1),(83,'id_pessoa_matriz','Codigo Unidade','SOLICITACAO',12,0),(84,'nome_pessoa_matriz','Nome Unidade','SOLICITACAO',12,0),(85,'id_pessoa_mot_pass','Codigo Requisitante','SOLICITACAO',12,0),(86,'nome_requisitante','Nome Requisitante','SOLICITACAO',12,1),(87,'nome_setor','Nome Setor','SOLICITACAO',12,0),(88,'nome_projeto','Nome Projeto','SOLICITACAO',12,1),(89,'dt_evento','Data Evento','SOLICITACAO',12,0),(90,'dt_saida','Data Saida','SOLICITACAO',12,1),(91,'dt_retorno_prev','Data Retorno Prev','SOLICITACAO',12,1),(92,'finalidade','Finalidade','SOLICITACAO',12,0),(93,'ind_viagem','Viagem','SOLICITACAO',12,0),(94,'ind_com_motorista','Com Motorista','SOLICITACAO',12,0),(95,'ind_pernoite','Pernoite','SOLICITACAO',12,0),(96,'ind_retorno_previsto','Retorno Previsto','SOLICITACAO',12,0),(97,'nome_localidade','Nome Localidade','SOLICITACAO',12,0),(98,'nome_localidade','Nome Localidade','SOLICITACAO',12,0),(99,'dt_cad','Data Cadastro','SOLICITACAO',12,0),(100,'dt_alt','Data Alteração','SOLICITACAO',12,0),(101,'nome_status','Situação','SOLICITACAO',12,0),(103,'id_solicitacao','Codigo','MAPASOLICITACAO',13,0),(104,'id_pessoa_mot_pass','Codigo Requisitante','MAPASOLICITACAO',13,0),(105,'nome_requisitante','Nome Requisitante','MAPASOLICITACAO',13,1),(106,'nome_setor','Nome Setor','MAPASOLICITACAO',13,1),(107,'nome_projeto','Nome Projeto','MAPASOLICITACAO',13,0),(108,'dt_evento','Data Evento','MAPASOLICITACAO',13,1),(109,'dt_saida','Data Saida','MAPASOLICITACAO',13,0),(110,'dt_retorno_prev','Data Retorno Prev','MAPASOLICITACAO',13,1),(111,'ind_viagem','Viagem','MAPASOLICITACAO',13,0),(112,'ind_com_motorista','Com Motorista','MAPASOLICITACAO',13,0),(113,'ind_pernoite','Pernoite','MAPASOLICITACAO',13,0),(114,'ind_retorno_previsto','Retorno Previsto','MAPASOLICITACAO',13,0),(115,'nome_status','Situação','MAPASOLICITACAO',13,0),(116,'placa','Placa','MAPASOLICITACAO',13,0),(117,'nome_motorista','Nome Motorista','MAPASOLICITACAO',13,0),(118,'km_saida','Km Saida','MAPASOLICITACAO',13,0),(119,'km_retorno','Km Retorno','MAPASOLICITACAO',13,0),(120,'dt_partida','Data Partida','MAPASOLICITACAO',13,0),(121,'km_partida','Km Partida','MAPASOLICITACAO',13,0),(122,'km_chegada','Km Chegada','MAPASOLICITACAO',13,0),(123,'ind_realizado','Realizado','MAPASOLICITACAO',13,0),(124,'nome_nao_planejamento','Nome Planejamento','MAPASOLICITACAO',13,0),(125,'nome_localidade','Nome Origem','MAPASOLICITACAO',13,1),(126,'ultimo_destino','Destino','MAPASOLICITACAO',13,1),(127,'nome_gestor','Gestor','MAPASOLICITACAO',13,NULL);

/*Table structure for table `grupo_acesso` */

DROP TABLE IF EXISTS `grupo_acesso`;

CREATE TABLE `grupo_acesso` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `dt_cad` datetime DEFAULT NULL,
  `dt_alt` datetime DEFAULT NULL,
  `id_usuario_cad` int(11) DEFAULT NULL,
  `id_usuario_alt` int(11) DEFAULT NULL,
  `id_pessoa_matriz` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `grupo_acesso` */

insert  into `grupo_acesso`(`id_grupo`,`nome`,`dt_cad`,`dt_alt`,`id_usuario_cad`,`id_usuario_alt`,`id_pessoa_matriz`) values (1,'Administração',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu_mae` int(11) DEFAULT NULL,
  `nome` varchar(100) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `dt_cadastro` datetime DEFAULT NULL,
  `dt_alt` datetime DEFAULT NULL,
  `id_usuario_cad` int(11) DEFAULT NULL,
  `id_usuario_alt` int(11) DEFAULT NULL,
  `ind_ativo` int(11) DEFAULT NULL,
  `css_icon` varchar(100) DEFAULT NULL,
  `ordenacao` int(11) DEFAULT NULL,
  `grid_dinamico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `menu` */

insert  into `menu`(`id_menu`,`id_menu_mae`,`nome`,`url`,`dt_cadastro`,`dt_alt`,`id_usuario_cad`,`id_usuario_alt`,`ind_ativo`,`css_icon`,`ordenacao`,`grid_dinamico`) values (1,NULL,'Administração','','2016-10-10 10:29:46',NULL,1,NULL,1,'fa fa-cogs',6,NULL),(2,1,'Usuarios','../../usuario/apresentacao/consulta-usuario.php','2016-10-10 10:30:43',NULL,1,NULL,1,'fa fa-user',NULL,NULL),(3,NULL,'Cadastros','','2016-10-10 10:31:21',NULL,1,NULL,1,'fa fa-folder-open',3,NULL),(4,3,'Cliente','../../pessoa/apresentacao/consulta-cliente.php','2016-10-14 11:37:56',NULL,1,NULL,0,'',3,1),(5,3,'Veiculos','../../veiculo/apresentacao/consulta-veiculo.php','2016-10-14 11:38:52',NULL,1,NULL,1,'fa fa-automobile',4,1),(6,NULL,'Operações',NULL,'2016-10-14 11:39:29',NULL,1,NULL,1,'fa fa-automobile',1,NULL),(7,3,'Modelo','../../veiculo/apresentacao/consulta-modelo.php','2016-10-18 16:12:49',NULL,1,NULL,1,NULL,7,NULL),(8,3,'Pessoa','../../pessoa/apresentacao/consulta-motorista-passageiro.php','2016-10-18 16:55:20',NULL,1,NULL,1,NULL,1,1),(9,3,'Combustivel','../../veiculo/apresentacao/consulta-combustivel.php',NULL,NULL,NULL,NULL,1,NULL,6,NULL),(10,3,'Cor','../../veiculo/apresentacao/consulta-cor.php','2016-10-21 14:51:31',NULL,1,NULL,1,NULL,8,NULL),(11,3,'Localidade','../../localidade/apresentacao/consulta-localidade.php','2016-10-25 16:38:42',NULL,1,NULL,1,NULL,2,1),(12,6,'Solicitação','../../solicitacao/apresentacao/consulta-solicitacao.php','2016-11-16 20:43:18',NULL,NULL,NULL,1,NULL,1,1),(13,6,'Mapa das Solicitações','../../solicitacao/apresentacao/consulta-mapa-solicitacao.php','2016-11-16 20:48:12',NULL,NULL,NULL,1,NULL,3,1),(14,3,'Importação Euroit','../../importacao/apresentacao/importacao-euroit.php','2016-11-16 20:51:21',NULL,NULL,NULL,1,NULL,10,NULL),(15,1,'Grupo Acesso','../../usuario/apresentacao/consulta-grupo-acesso.php',NULL,NULL,NULL,NULL,1,NULL,2,NULL),(17,NULL,'Tabelas','',NULL,NULL,NULL,NULL,1,'fa fa-database',4,NULL),(18,17,'Setores','../../gerenciaCadastros/apresentacao/consulta-setor.php',NULL,NULL,NULL,NULL,1,'',1,NULL),(19,17,'Projetos','../../gerenciaCadastros/apresentacao/consulta-projetos.php',NULL,NULL,NULL,NULL,1,'',2,NULL),(20,17,'Regiões','../../gerenciaCadastros/apresentacao/consulta-regioes.php',NULL,NULL,NULL,NULL,1,'',3,NULL),(21,17,'Categoria Localidade','../../gerenciaCadastros/apresentacao/consulta-categoria-localidades.php',NULL,NULL,NULL,NULL,1,'',5,NULL),(22,17,'Motivo Cancelamento','../../gerenciaCadastros/apresentacao/consulta-motivo-cancelamento.php',NULL,NULL,NULL,NULL,1,'',6,NULL),(23,17,'Motivo Não Panejamento','../../gerenciaCadastros/apresentacao/consulta-motivo-nao-planejamento.php',NULL,NULL,NULL,NULL,1,'',7,NULL),(24,1,'Empresa','../../pessoa/apresentacao/consulta-empresa.php',NULL,NULL,NULL,NULL,1,NULL,3,1),(25,6,'Mapa das Atendimento','../../solicitacao/apresentacao/consulta-mapa-atendimento.php',NULL,NULL,NULL,NULL,1,NULL,4,1),(26,17,'Tipo Logradouro','../../gerenciaCadastros/apresentacao/consulta-tipo-logradouro.php',NULL,NULL,NULL,NULL,1,NULL,8,NULL),(27,NULL,'Relatorios','',NULL,NULL,NULL,NULL,1,'fa fa-bar-chart',2,NULL),(28,NULL,'DIsplay Motorista','../../solicitacao/apresentacao/display-motorista.php',NULL,NULL,NULL,NULL,1,'fa fa-desktop',5,NULL),(29,1,'Tempo Display Mot.','../../configuracoes/apresentacao/consulta-display-motoristas.php',NULL,NULL,NULL,NULL,1,NULL,4,NULL),(30,6,'Atendimentos','../../solicitacao/apresentacao/consulta-atencimentos.php',NULL,NULL,NULL,NULL,1,NULL,2,NULL);

/*Table structure for table `usuario_consulta` */

DROP TABLE IF EXISTS `usuario_consulta`;

CREATE TABLE `usuario_consulta` (
  `id_usuario_consulta` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `Itens_consulta` varchar(500) DEFAULT NULL,
  `itens_visual` varchar(500) DEFAULT NULL,
  `id_grid_consulta` varchar(100) DEFAULT NULL,
  `id_pessoa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_consulta`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=latin1;

/*Data for the table `usuario_consulta` */

insert  into `usuario_consulta`(`id_usuario_consulta`,`id_usuario`,`id_menu`,`Itens_consulta`,`itens_visual`,`id_grid_consulta`,`id_pessoa`) values (95,28,4,NULL,NULL,'1,2,4,6,7',NULL),(96,28,5,NULL,NULL,'57,58,59',NULL),(97,28,8,NULL,NULL,'16,17,18,19,20',NULL),(98,28,11,NULL,NULL,'35,36,37,42,43,44',NULL),(99,28,12,NULL,NULL,'82,86,88,90,91',NULL),(100,28,13,NULL,NULL,'105,106,108,110,125,126',NULL),(101,28,24,NULL,NULL,'68,69,71,73,74,75',NULL),(102,28,25,NULL,NULL,'',NULL),(103,29,4,NULL,NULL,'1,2,4,6,7',NULL),(104,29,5,NULL,NULL,'57,58,59',NULL),(105,29,8,NULL,NULL,'16,17,18,19,20',NULL),(106,29,11,NULL,NULL,'35,36,37,42,43,44',NULL),(107,29,12,NULL,NULL,'82,86,88,90,91',NULL),(108,29,13,NULL,NULL,'105,106,108,110,125,126',NULL),(109,29,24,NULL,NULL,'68,69,71,73,74,75',NULL),(110,29,25,NULL,NULL,'',NULL),(111,30,4,NULL,NULL,'1,2,4,6,7',NULL),(112,30,5,NULL,NULL,'57,58,59',NULL),(113,30,8,NULL,NULL,'16,17,18,19,20',NULL),(114,30,11,NULL,NULL,'35,36,37,42,43,44',NULL),(115,30,12,NULL,NULL,'82,86,88,90,91',NULL),(116,30,13,NULL,NULL,'105,106,108,110,125,126',NULL),(117,30,24,NULL,NULL,'68,69,71,73,74,75',NULL),(118,30,25,NULL,NULL,'',NULL),(119,31,4,NULL,NULL,'1,2,4,6,7',NULL),(120,31,5,NULL,NULL,'57,58,59',NULL),(121,31,8,NULL,NULL,'16,17,18,19,20,22,23,27',NULL),(122,31,11,NULL,NULL,'35,36,37,42,43,44,48,49,51',NULL),(123,31,12,NULL,NULL,'82,86,88,89,90,91,101',NULL),(124,31,13,NULL,NULL,'103,105,106,108,110,125,126,127',NULL),(125,31,24,NULL,NULL,'68,69,71,73,74,75',NULL),(126,31,25,NULL,NULL,'',NULL),(127,32,4,NULL,NULL,'1,2,4,6,7',NULL),(128,32,5,NULL,NULL,'57,58,59',NULL),(129,32,8,NULL,NULL,'16,17,18,19,20',NULL),(130,32,11,NULL,NULL,'35,36,37,42,43,44',NULL),(131,32,12,NULL,NULL,'82,86,88,90,91',NULL),(132,32,13,NULL,NULL,'105,106,108,110,125,126',NULL),(133,32,24,NULL,NULL,'68,69,71,73,74,75',NULL),(134,32,25,NULL,NULL,'',NULL),(135,NULL,4,NULL,NULL,'1,2,4,6,7',32),(136,NULL,5,NULL,NULL,'57,58,59',32),(137,NULL,8,NULL,NULL,'16,17,18,19,20',32),(138,NULL,11,NULL,NULL,'35,36,37,42,43,44',32),(139,NULL,12,NULL,NULL,'82,86,88,90,91',32),(140,NULL,13,NULL,NULL,'105,106,108,110,125,126',32),(141,NULL,24,NULL,NULL,'68,69,71,73,74,75',32),(142,NULL,25,NULL,NULL,'',32),(143,NULL,4,NULL,NULL,'1,2,4,6,7',32),(144,NULL,5,NULL,NULL,'57,58,59',32),(145,NULL,8,NULL,NULL,'16,17,18,19,20',32),(146,NULL,11,NULL,NULL,'35,36,37,42,43,44',32),(147,NULL,12,NULL,NULL,'82,86,88,90,91',32),(148,NULL,13,NULL,NULL,'105,106,108,110,125,126',32),(149,NULL,24,NULL,NULL,'68,69,71,73,74,75',32),(150,NULL,25,NULL,NULL,'',32),(151,NULL,4,NULL,NULL,'1,2,4,6,7',32),(152,NULL,5,NULL,NULL,'57,58,59',32),(153,NULL,8,NULL,NULL,'16,17,18,19,20',32),(154,NULL,11,NULL,NULL,'35,36,37,42,43,44',32),(155,NULL,12,NULL,NULL,'82,86,88,90,91',32),(156,NULL,13,NULL,NULL,'105,106,108,110,125,126',32),(157,NULL,24,NULL,NULL,'68,69,71,73,74,75',32),(158,NULL,25,NULL,NULL,'',32),(159,NULL,4,NULL,NULL,'1,2,4,6,7',32),(160,NULL,5,NULL,NULL,'57,58,59',32),(161,NULL,8,NULL,NULL,'16,17,18,19,20',32),(162,NULL,11,NULL,NULL,'35,36,37,42,43,44',32),(163,NULL,12,NULL,NULL,'82,86,88,90,91',32),(164,NULL,13,NULL,NULL,'105,106,108,110,125,126',32),(165,NULL,24,NULL,NULL,'68,69,71,73,74,75',32),(166,NULL,25,NULL,NULL,'',32),(167,NULL,4,NULL,NULL,'1,2,4,6,7',71),(168,NULL,5,NULL,NULL,'57,58,59',71),(169,NULL,8,NULL,NULL,'16,17,18,19,20',71),(170,NULL,11,NULL,NULL,'35,36,37,42,43,44',71),(171,NULL,12,NULL,NULL,'82,86,88,90,91',71),(172,NULL,13,NULL,NULL,'105,106,108,110,125,126',71),(173,NULL,24,NULL,NULL,'68,69,71,73,74,75',71),(174,NULL,25,NULL,NULL,'',71),(175,NULL,4,NULL,NULL,'1,2,4,6,7',71),(176,NULL,5,NULL,NULL,'57,58,59',71),(177,NULL,8,NULL,NULL,'16,17,18,19,20',71),(178,NULL,11,NULL,NULL,'35,36,37,42,43,44',71),(179,NULL,12,NULL,NULL,'82,86,88,90,91',71),(180,NULL,13,NULL,NULL,'105,106,108,110,125,126',71),(181,NULL,24,NULL,NULL,'68,69,71,73,74,75',71),(182,NULL,25,NULL,NULL,'',71),(183,NULL,4,NULL,NULL,'1,2,4,6,7',71),(184,NULL,5,NULL,NULL,'57,58,59',71),(185,NULL,8,NULL,NULL,'16,17,18,19,20',71),(186,NULL,11,NULL,NULL,'35,36,37,42,43,44',71),(187,NULL,12,NULL,NULL,'82,86,88,90,91',71),(188,NULL,13,NULL,NULL,'105,106,108,110,125,126',71),(189,NULL,24,NULL,NULL,'68,69,71,73,74,75',71),(190,NULL,25,NULL,NULL,'',71),(191,NULL,4,NULL,NULL,'1,2,4,6,7',72),(192,NULL,5,NULL,NULL,'57,58,59',72),(193,NULL,8,NULL,NULL,'16,17,18,19,20',72),(194,NULL,11,NULL,NULL,'35,36,37,42,43,44',72),(195,NULL,12,NULL,NULL,'82,86,88,90,91',72),(196,NULL,13,NULL,NULL,'105,106,108,110,125,126',72),(197,NULL,24,NULL,NULL,'68,69,71,73,74,75',72),(198,NULL,25,NULL,NULL,'',72);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
