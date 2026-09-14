-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: deposito2
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrador` (
  `id_administrador` bigint(20) NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(50) NOT NULL,
  `ds_senha` varchar(255) NOT NULL,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_administrador`),
  UNIQUE KEY `nm_usuario` (`nm_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'admin','$2y$10$37tzDPvrSMPTfPVpvsNA0.8FHAH7ZXwMOkKJuBALWW2zl0jpVYbPa',1);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda` (
  `id_venda` bigint(20) NOT NULL AUTO_INCREMENT,
  `dt_venda` date NOT NULL,
  `nr_valor` bigint(20) NOT NULL,
  `id_cliente` bigint(20) NOT NULL,
  PRIMARY KEY (`id_venda`),
  KEY `cliente_venda` (`id_cliente`),
  CONSTRAINT `cliente_venda` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` VALUES (1,'2025-01-10',290,1),(2,'2025-01-15',56,2),(3,'2025-02-02',1950,3);
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `produto` (
  `id_produto` bigint(20) NOT NULL AUTO_INCREMENT,
  `nm_produto` varchar(100) NOT NULL,
  `nr_preco` decimal(10,2) NOT NULL,
  `nr_estoque` int(11) NOT NULL,
  `id_categoria` bigint(20) NOT NULL,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  `ds_descricao` text DEFAULT NULL,
  `ds_imagem` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_produto`),
  KEY `categoria_produto` (`id_categoria`),
  CONSTRAINT `categoria_produto` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (7,'Fio Elétrico 2.5mm (rolo 100m)',145.00,70,1,1,'Rolo de fio elétrico flexível de 2,5mm², ideal para instalações residenciais em tomadas e iluminação. Isolamento em PVC antichama, atende à norma NBR NM 247-3. Rolo com 100 metros.',NULL),(8,'Disjuntor Bipolar 40A',28.00,90,1,1,'Dispositivo de proteção elétrica destinado a interromper automaticamente o circuito em situações de sobrecarga ou curto-circuito. Possui dois polos e corrente nominal de 40 amperes, sendo indicado para instalações elétricas que exigem proteção simultânea dos dois condutores.','produto_6a94eda79c735.jpg'),(9,'Tubo PVC Esgoto 100mm (barra 6m)',65.00,110,2,1,'Tubo de PVC para rede de esgoto, diâmetro de 100mm, barra com 6 metros. Alta resistência a impactos e produtos químicos, indicado para tubulações prediais.',NULL),(10,'Torneira Cromada Bancada',45.90,85,2,1,'Torneira de bancada cromada, acabamento resistente a manchas e corrosão. Design compacto, ideal para banheiros e lavabos. Instalação simples com rosca padrão.',NULL),(11,'Furadeira de Impacto 550W',210.00,25,3,1,'Furadeira de impacto com potência de 550W, ideal para perfurar concreto, madeira e metal. Possui seletor de função (furar/impacto) e velocidade variável no gatilho.',NULL),(12,'Trena 5m',15.90,130,3,1,'Trena manual de 5 metros com trava automática e fita revestida contra ferrugem. Estrutura emborrachada para maior resistência a quedas no dia a dia da obra.',NULL),(13,'Porca',0.10,100,6,1,NULL,NULL),(14,'Porca',0.20,400,7,1,NULL,NULL);
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER vld_produto_negativo
BEFORE UPDATE ON PRODUTO
FOR EACH ROW
BEGIN
	IF NEW.nr_preco < 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'O Preco do Produto NAO pode ser negativo';
	END IF;
	IF NEW.nr_estoque < 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'O Estoque do Produto NAO pode ser negativo';
	END IF;
end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `venda_produto`
--

DROP TABLE IF EXISTS `venda_produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `venda_produto` (
  `id_venda_produto` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_produto` bigint(20) NOT NULL,
  `id_venda` bigint(20) NOT NULL,
  `nr_quantidade` int(11) NOT NULL,
  PRIMARY KEY (`id_venda_produto`),
  KEY `produto_vendaProduto` (`id_produto`),
  KEY `venda_vendaProduto` (`id_venda`),
  CONSTRAINT `produto_vendaProduto` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  CONSTRAINT `venda_vendaProduto` FOREIGN KEY (`id_venda`) REFERENCES `venda` (`id_venda`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda_produto`
--

LOCK TABLES `venda_produto` WRITE;
/*!40000 ALTER TABLE `venda_produto` DISABLE KEYS */;
INSERT INTO `venda_produto` VALUES (7,7,1,2),(8,8,2,2),(9,9,3,30);
/*!40000 ALTER TABLE `venda_produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `id_categoria` bigint(20) NOT NULL AUTO_INCREMENT,
  `nm_categoria` varchar(100) NOT NULL,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Elétrica',1),(2,'Hidráulica',1),(3,'Ferramentas',1),(4,'Elétrica',0),(5,'asasas',0),(6,'Pregos',0),(7,'Pregos',0);
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-14 13:37:30
