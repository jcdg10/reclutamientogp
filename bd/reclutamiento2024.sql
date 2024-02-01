-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: 164.90.152.137    Database: reclutamiento
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `candidatos`
--

DROP TABLE IF EXISTS `candidatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidatos` (
  `idcandidato` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `correo` varchar(80) DEFAULT NULL,
  `ciudad` int(11) DEFAULT NULL,
  `pretensiones` decimal(10,2) DEFAULT NULL,
  `perfil` varchar(45) DEFAULT NULL,
  `especialidad` int(11) DEFAULT NULL,
  `fechaalta` datetime DEFAULT NULL,
  `fechamod` datetime DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  `estatus_candidatos` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`idcandidato`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidatos`
--

LOCK TABLES `candidatos` WRITE;
/*!40000 ALTER TABLE `candidatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `candidatos_proceso`
--

DROP TABLE IF EXISTS `candidatos_proceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `candidatos_proceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidatos_id` int(11) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  `entrevista` tinyint(4) DEFAULT NULL,
  `pruebatecnica` tinyint(4) DEFAULT NULL,
  `pruebapsicometrica` tinyint(4) DEFAULT NULL,
  `referencias` tinyint(4) DEFAULT NULL,
  `entrevista_tecnica` tinyint(4) DEFAULT NULL,
  `estudio_socioeconomico` tinyint(4) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT 2,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `candidatos_proceso`
--

LOCK TABLES `candidatos_proceso` WRITE;
/*!40000 ALTER TABLE `candidatos_proceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `candidatos_proceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cargo`
--

DROP TABLE IF EXISTS `cargo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cargo` (
  `id` int(3) NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cargo`
--

LOCK TABLES `cargo` WRITE;
/*!40000 ALTER TABLE `cargo` DISABLE KEYS */;
INSERT INTO `cargo` VALUES (1,'vendedor'),(2,'coordinador'),(3,'reclutador');
/*!40000 ALTER TABLE `cargo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `calle` varchar(80) DEFAULT NULL,
  `num_int` int(11) DEFAULT NULL,
  `num_ext` varchar(8) DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  `ciudad` varchar(80) DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `estatus` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datoadicional`
--

DROP TABLE IF EXISTS `datoadicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datoadicional` (
  `idadicional` int(11) NOT NULL,
  `razoncontra` varchar(30) NOT NULL,
  `fechacontra` date NOT NULL,
  PRIMARY KEY (`idadicional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datoadicional`
--

LOCK TABLES `datoadicional` WRITE;
/*!40000 ALTER TABLE `datoadicional` DISABLE KEYS */;
/*!40000 ALTER TABLE `datoadicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosacademicos`
--

DROP TABLE IF EXISTS `datosacademicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosacademicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `escolaridad` varchar(100) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosacademicos_vacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datosacademicos_vacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosacademicos`
--

LOCK TABLES `datosacademicos` WRITE;
/*!40000 ALTER TABLE `datosacademicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosacademicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosacademicos_certificados`
--

DROP TABLE IF EXISTS `datosacademicos_certificados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosacademicos_certificados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `certificado` varchar(100) DEFAULT NULL,
  `datosacademicos_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosacademicos_certificados_datosacademicos_id_idx` (`datosacademicos_id`),
  CONSTRAINT `datosacademicos_certificados_datosacademicos_id` FOREIGN KEY (`datosacademicos_id`) REFERENCES `datosacademicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosacademicos_certificados`
--

LOCK TABLES `datosacademicos_certificados` WRITE;
/*!40000 ALTER TABLE `datosacademicos_certificados` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosacademicos_certificados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosacademicos_idiomas`
--

DROP TABLE IF EXISTS `datosacademicos_idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosacademicos_idiomas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idioma` varchar(100) DEFAULT NULL,
  `datosacademicos_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosacademicos_idiomas_datosacademicos_id_idx` (`datosacademicos_id`),
  CONSTRAINT `datosacademicos_idiomas_datosacademicos_id` FOREIGN KEY (`datosacademicos_id`) REFERENCES `datosacademicos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosacademicos_idiomas`
--

LOCK TABLES `datosacademicos_idiomas` WRITE;
/*!40000 ALTER TABLE `datosacademicos_idiomas` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosacademicos_idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosadicionales`
--

DROP TABLE IF EXISTS `datosadicionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosadicionales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desplazarse` int(11) DEFAULT NULL,
  `desplazarse_motivo` varchar(50) DEFAULT NULL,
  `viajar` int(11) DEFAULT NULL,
  `viajar_motivo` varchar(50) DEFAULT NULL,
  `disponibilidad_horario` int(11) DEFAULT NULL,
  `disponibilidad_horario_motivo` varchar(50) DEFAULT NULL,
  `personal_cargo` int(11) DEFAULT NULL,
  `num_personas_cargo` int(11) DEFAULT NULL,
  `persona_reporta` varchar(100) DEFAULT NULL,
  `equipo_computo` int(11) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosadicionalesvacates_id_idx` (`vacantes_id`),
  CONSTRAINT `datosadicionalesvacates_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosadicionales`
--

LOCK TABLES `datosadicionales` WRITE;
/*!40000 ALTER TABLE `datosadicionales` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosadicionales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datoscliente`
--

DROP TABLE IF EXISTS `datoscliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datoscliente` (
  `idcliente` int(2) NOT NULL,
  `empresa` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `direccion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `refeubicacion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `resproceso` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `teloficina` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `coelectronico` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idcliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datoscliente`
--

LOCK TABLES `datoscliente` WRITE;
/*!40000 ALTER TABLE `datoscliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `datoscliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datoseconomicos`
--

DROP TABLE IF EXISTS `datoseconomicos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datoseconomicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `esquemacontratacion` varchar(100) DEFAULT NULL,
  `tiposalario` varchar(100) DEFAULT NULL,
  `montominimo` double DEFAULT NULL,
  `montomaximo` double DEFAULT NULL,
  `jornadalaboral` varchar(100) DEFAULT NULL,
  `prestaciones_beneficios` text DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datoseconomicos_vacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datoseconomicos_vacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datoseconomicos`
--

LOCK TABLES `datoseconomicos` WRITE;
/*!40000 ALTER TABLE `datoseconomicos` DISABLE KEYS */;
/*!40000 ALTER TABLE `datoseconomicos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosfinales`
--

DROP TABLE IF EXISTS `datosfinales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosfinales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razonnocontratacion` varchar(100) DEFAULT NULL,
  `fechacontratacion` date DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosfinales_vacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datosfinales_vacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosfinales`
--

LOCK TABLES `datosfinales` WRITE;
/*!40000 ALTER TABLE `datosfinales` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosfinales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosgenerales`
--

DROP TABLE IF EXISTS `datosgenerales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosgenerales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `puesto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `novacantes` int(11) DEFAULT NULL,
  `fechasolicitud` date DEFAULT NULL,
  `serviciore` int(11) DEFAULT NULL,
  `tiemasignacion` int(11) DEFAULT NULL,
  `cantidadtiempo` int(11) DEFAULT NULL,
  `modalidad` int(11) DEFAULT NULL,
  `horario_inicio` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `horario_fin` varchar(10) DEFAULT NULL,
  `ejecutivoen` int(11) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosgenerales_vacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datosgenerales_vacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosgenerales`
--

LOCK TABLES `datosgenerales` WRITE;
/*!40000 ALTER TABLE `datosgenerales` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosgenerales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datospersonal`
--

DROP TABLE IF EXISTS `datospersonal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datospersonal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rangoedad` varchar(100) DEFAULT NULL,
  `sexo` int(11) DEFAULT NULL,
  `estadocivil` int(11) DEFAULT NULL,
  `lugarresidencia` varchar(100) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datospersonal`
--

LOCK TABLES `datospersonal` WRITE;
/*!40000 ALTER TABLE `datospersonal` DISABLE KEYS */;
/*!40000 ALTER TABLE `datospersonal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datosproceso`
--

DROP TABLE IF EXISTS `datosproceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datosproceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duracion` varchar(100) DEFAULT NULL,
  `cantidadfiltros` int(11) DEFAULT NULL,
  `niveles_flitro` varchar(100) DEFAULT NULL,
  `entrevista` tinyint(4) DEFAULT NULL,
  `pruebatecnica` tinyint(4) DEFAULT NULL,
  `pruebapsicometrica` tinyint(4) DEFAULT NULL,
  `referencias` tinyint(4) DEFAULT NULL,
  `entrevista_tecnica` tinyint(4) DEFAULT NULL,
  `estudio_socioeconomico` tinyint(4) DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datosproceso_vacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datosproceso_vacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datosproceso`
--

LOCK TABLES `datosproceso` WRITE;
/*!40000 ALTER TABLE `datosproceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `datosproceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datospuesto`
--

DROP TABLE IF EXISTS `datospuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datospuesto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `experiencia` varchar(100) DEFAULT NULL,
  `actividades` text DEFAULT NULL,
  `conocimientos_tecnicos` text DEFAULT NULL,
  `competencias_necesarias` text DEFAULT NULL,
  `vacantes_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `datospuestovacantes_id_idx` (`vacantes_id`),
  CONSTRAINT `datospuestovacantes_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datospuesto`
--

LOCK TABLES `datospuesto` WRITE;
/*!40000 ALTER TABLE `datospuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `datospuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `despuesto`
--

DROP TABLE IF EXISTS `despuesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `despuesto` (
  `idpuesto` int(11) NOT NULL,
  `experiencia` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `actividades` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `conocimientotec` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `compenecesaria` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idpuesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `despuesto`
--

LOCK TABLES `despuesto` WRITE;
/*!40000 ALTER TABLE `despuesto` DISABLE KEYS */;
/*!40000 ALTER TABLE `despuesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escolaridad`
--

DROP TABLE IF EXISTS `escolaridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `escolaridad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nivel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escolaridad`
--

LOCK TABLES `escolaridad` WRITE;
/*!40000 ALTER TABLE `escolaridad` DISABLE KEYS */;
INSERT INTO `escolaridad` VALUES (1,'Secundaria'),(2,'Bachillerato'),(3,'Técnico'),(4,'Universitario - Trunco'),(5,'Universitario - No titulado'),(6,'Universitario - Titulado'),(7,'Diplomado'),(8,'Maestría'),(9,'Doctorado');
/*!40000 ALTER TABLE `escolaridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidad`
--

DROP TABLE IF EXISTS `especialidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `especialidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `especialidad` varchar(100) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidad`
--

LOCK TABLES `especialidad` WRITE;
/*!40000 ALTER TABLE `especialidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `especialidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_civiles`
--

DROP TABLE IF EXISTS `estados_civiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_civiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estados_civiles` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_civiles`
--

LOCK TABLES `estados_civiles` WRITE;
/*!40000 ALTER TABLE `estados_civiles` DISABLE KEYS */;
INSERT INTO `estados_civiles` VALUES (1,'Soltero'),(2,'Casado'),(3,'Viudo'),(4,'Separado'),(5,'Divorciado'),(6,'Concubinato'),(7,'Indiferente');
/*!40000 ALTER TABLE `estados_civiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_federales`
--

DROP TABLE IF EXISTS `estados_federales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estados_federales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_federales`
--

LOCK TABLES `estados_federales` WRITE;
/*!40000 ALTER TABLE `estados_federales` DISABLE KEYS */;
INSERT INTO `estados_federales` VALUES (1,'Aguascalientes'),(2,'Baja California'),(3,'Baja California Sur'),(4,'Campeche'),(5,'Chiapas'),(6,'Chihuahua'),(7,'Ciudad de México'),(8,'Coahuila'),(9,'Colima'),(10,'Durango'),(11,'Guanajuato'),(12,'Guerrero'),(13,'Hidalgo'),(14,'Jalisco'),(15,'Estado de México'),(16,'Michoacán'),(17,'Morelos'),(18,'Nayarit'),(19,'Nuevo León'),(20,'Oaxaca'),(21,'Puebla'),(22,'Querétaro'),(23,'Quintana Roo'),(24,'San Luis Potosí'),(25,'Sinaloa'),(26,'Sonora'),(27,'Tabasco'),(28,'Tamaulipas'),(29,'Tlaxcala'),(30,'Veracruz'),(31,'Yucatán'),(32,'Zacatecas');
/*!40000 ALTER TABLE `estados_federales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatus_candidatos`
--

DROP TABLE IF EXISTS `estatus_candidatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatus_candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estatus` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  `seleccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatus_candidatos`
--

LOCK TABLES `estatus_candidatos` WRITE;
/*!40000 ALTER TABLE `estatus_candidatos` DISABLE KEYS */;
INSERT INTO `estatus_candidatos` VALUES (2,'En proceso','warning',0),(3,'Contratado','success',1),(4,'Descartado','danger',1),(5,'En cartera','primary',1);
/*!40000 ALTER TABLE `estatus_candidatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estatus_vacantes`
--

DROP TABLE IF EXISTS `estatus_vacantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estatus_vacantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estatus` varchar(45) DEFAULT NULL,
  `color` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estatus_vacantes`
--

LOCK TABLES `estatus_vacantes` WRITE;
/*!40000 ALTER TABLE `estatus_vacantes` DISABLE KEYS */;
INSERT INTO `estatus_vacantes` VALUES (1,'Pendiente de revisión','info'),(2,'Rechazado','danger'),(3,'En búsqueda','warning'),(4,'Cubierto','success');
/*!40000 ALTER TABLE `estatus_vacantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencia_candidatos`
--

DROP TABLE IF EXISTS `experiencia_candidatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiencia_candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `puesto` varchar(80) DEFAULT NULL,
  `empresa` varchar(80) DEFAULT NULL,
  `detalles_puesto` mediumtext DEFAULT NULL,
  `fechaini` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `puesto_actual` tinyint(4) DEFAULT NULL,
  `candidato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencia_candidatos`
--

LOCK TABLES `experiencia_candidatos` WRITE;
/*!40000 ALTER TABLE `experiencia_candidatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencia_candidatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidad`
--

DROP TABLE IF EXISTS `modalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modalidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modalidad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidad`
--

LOCK TABLES `modalidad` WRITE;
/*!40000 ALTER TABLE `modalidad` DISABLE KEYS */;
INSERT INTO `modalidad` VALUES (1,'Home office'),(2,'Presencial'),(3,'Híbrido');
/*!40000 ALTER TABLE `modalidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT 1 COMMENT '1 activo\n0 Inactivo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'Usuarios',1),(2,'Clientes',1),(3,'Candidatos',1),(4,'Requerimientos',1),(5,'Reportes',1),(6,'Contratos',0),(7,'Ciudad',1),(8,'Especialidad',1),(9,'Servicios requeridos',1),(10,'Roles y permisos',1);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parametros`
--

DROP TABLE IF EXISTS `parametros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parametros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_sistema` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valor` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` VALUES (1,'LOGIN_INTENTO','Cantidad de intentos en login','5'),(2,'LIMITE_TIEMPO_LOGIN','Tiempo para volver a intentar loguearse (en minutos)','60');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('karla.grato@hotmail.com','OKpuafG0U3FbCPKihSSKaG6GnW84qPHzKvdst26nzOEjD36tCyTN6mnCaSVpa7rl','2023-08-07 23:32:58'),('jcdg10@gmail.com','LhmJolgmW90BUHpqW0DF0j0mjvWDgVZWXL31eIjbGPhpvv3cRlSc7ZQVeyhtet0A','2023-08-08 16:57:56'),('jcdg10@gmail.com','R4xS9QOJHiXyupoQUSspEnkqjtzkciNszwfOU6dB3t26v4clwFLOwGOxnFd9yqSH','2024-01-31 22:26:52');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol_id` int(11) DEFAULT NULL,
  `modulo_id` int(11) DEFAULT NULL,
  `permiso` int(11) DEFAULT NULL COMMENT 'CONSULTA 1\nAGREGAR   2\nEDITAR       3 \nELIMINAR   4',
  `permitido` tinyint(4) DEFAULT NULL COMMENT '1 permitido\n0 no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,1,1,1,1),(2,1,1,2,1),(3,1,1,3,1),(4,1,1,4,1),(5,1,2,1,1),(6,1,2,2,1),(7,1,2,3,1),(8,1,2,4,1),(9,1,3,1,1),(10,1,3,2,1),(11,1,3,3,1),(12,1,3,4,1),(13,1,4,1,1),(14,1,4,2,1),(15,1,4,3,1),(16,1,4,4,1),(17,1,5,1,1),(18,1,5,2,1),(19,1,5,3,1),(20,1,5,4,1),(21,1,6,1,1),(22,1,6,2,1),(23,1,6,3,1),(24,1,6,4,1),(25,2,1,1,0),(26,2,1,2,0),(27,2,1,3,0),(28,2,1,4,0),(29,2,2,1,1),(30,2,2,2,1),(31,2,2,3,1),(32,2,2,4,1),(33,2,3,1,0),(34,2,3,2,0),(35,2,3,3,0),(36,2,3,4,0),(37,2,4,1,1),(38,2,4,2,1),(39,2,4,3,1),(40,2,4,4,1),(41,2,5,1,0),(42,2,5,2,0),(43,2,5,3,0),(44,2,5,4,0),(45,2,6,1,1),(46,2,6,2,1),(47,2,6,3,0),(48,2,6,4,0),(49,3,1,1,0),(50,3,1,2,0),(51,3,1,3,0),(52,3,1,4,0),(53,3,2,1,0),(54,3,2,2,0),(55,3,2,3,0),(56,3,2,4,0),(57,3,3,1,1),(58,3,3,2,1),(59,3,3,3,1),(60,3,3,4,1),(61,3,4,1,1),(62,3,4,2,1),(63,3,4,3,1),(64,3,4,4,1),(65,3,5,1,0),(66,3,5,2,0),(67,3,5,3,0),(68,3,5,4,0),(69,3,6,1,0),(70,3,6,2,0),(71,3,6,3,0),(72,3,6,4,0),(73,4,1,1,0),(74,4,1,2,0),(75,4,1,3,0),(76,4,1,4,0),(77,4,2,1,1),(78,4,2,2,1),(79,4,2,3,1),(80,4,2,4,1),(81,4,3,1,1),(82,4,3,2,1),(83,4,3,3,1),(84,4,3,4,1),(85,4,4,1,1),(86,4,4,2,1),(87,4,4,3,1),(88,4,4,4,1),(89,4,5,1,1),(90,4,5,2,1),(91,4,5,3,1),(92,4,5,4,1),(93,4,6,1,0),(94,4,6,2,0),(95,4,6,3,0),(96,4,6,4,0),(97,1,7,1,1),(98,1,7,2,1),(99,1,7,3,1),(100,1,7,4,1),(101,2,7,1,0),(102,2,7,2,0),(103,2,7,3,0),(104,2,7,4,0),(105,3,7,1,0),(106,3,7,2,0),(107,3,7,3,0),(108,3,7,4,0),(109,4,7,1,0),(110,4,7,2,0),(111,4,7,3,0),(112,4,7,4,0),(113,1,8,1,1),(114,1,8,2,1),(115,1,8,3,1),(116,1,8,4,1),(117,2,8,1,0),(118,2,8,2,0),(119,2,8,3,0),(120,2,8,4,0),(121,3,8,1,0),(122,3,8,2,0),(123,3,8,3,0),(124,3,8,4,0),(125,4,8,1,0),(126,4,8,2,0),(127,4,8,3,0),(128,4,8,4,0),(129,1,9,1,1),(130,1,9,2,1),(131,1,9,3,1),(132,1,9,4,1),(133,2,9,1,0),(134,2,9,2,0),(135,2,9,3,0),(136,2,9,4,0),(137,3,9,1,0),(138,3,9,2,0),(139,3,9,3,0),(140,3,9,4,0),(141,4,9,1,0),(142,4,9,2,0),(143,4,9,3,0),(144,4,9,4,0),(145,1,10,1,1),(146,2,10,1,0),(147,3,10,1,0),(148,4,10,1,0),(149,1,1,5,1),(150,2,1,5,0),(151,3,1,5,0),(152,4,1,5,0),(153,1,2,5,1),(154,2,2,5,1),(155,3,2,5,0),(156,4,2,5,1),(157,1,3,5,1),(158,2,3,5,0),(159,3,3,5,1),(160,4,3,5,1),(165,1,4,5,1),(166,2,4,5,1),(167,3,4,5,1),(168,4,4,5,1),(169,1,4,6,1),(170,2,4,6,0),(171,3,4,6,0),(172,4,4,6,1),(173,1,5,5,1),(174,2,5,5,0),(175,3,5,5,0),(176,4,5,5,1),(177,1,7,5,1),(178,2,7,5,0),(179,3,7,5,0),(180,4,7,5,0),(181,1,8,5,1),(182,2,8,5,0),(183,3,8,5,0),(184,4,8,5,0),(185,1,9,5,1),(186,2,9,5,0),(187,3,9,5,0),(188,4,9,5,0),(189,1,10,6,0),(190,2,10,6,0),(191,3,10,6,0),(192,4,10,6,0);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proceso`
--

DROP TABLE IF EXISTS `proceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proceso` (
  `idproceso` int(11) NOT NULL,
  `duraestimada` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `canfiltros` int(11) NOT NULL,
  `nivelesfiltro` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `procesos` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idproceso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proceso`
--

LOCK TABLES `proceso` WRITE;
/*!40000 ALTER TABLE `proceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `proceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proeconomica`
--

DROP TABLE IF EXISTS `proeconomica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proeconomica` (
  `id` int(11) NOT NULL,
  `esquemacon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo_salario_id` int(11) NOT NULL,
  `montomin` decimal(16,2) NOT NULL,
  `montomax` decimal(16,2) NOT NULL,
  `jornalaboral` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `prestaciones` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proeconomica`
--

LOCK TABLES `proeconomica` WRITE;
/*!40000 ALTER TABLE `proeconomica` DISABLE KEYS */;
/*!40000 ALTER TABLE `proeconomica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reclutador`
--

DROP TABLE IF EXISTS `reclutador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reclutador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL COMMENT '0 inactivo  1 activo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reclutador`
--

LOCK TABLES `reclutador` WRITE;
/*!40000 ALTER TABLE `reclutador` DISABLE KEYS */;
/*!40000 ALTER TABLE `reclutador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reporte`
--

DROP TABLE IF EXISTS `reporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reporte` varchar(80) DEFAULT NULL,
  `ruta` varchar(120) DEFAULT NULL,
  `fechalta` datetime DEFAULT NULL,
  `fechamod` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reporte`
--

LOCK TABLES `reporte` WRITE;
/*!40000 ALTER TABLE `reporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `reporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reqacademico`
--

DROP TABLE IF EXISTS `reqacademico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reqacademico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `escolaridad_id` int(11) NOT NULL,
  `institucion` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `titulo_carrera` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `anioini` int(11) DEFAULT NULL,
  `aniofin` int(11) DEFAULT NULL,
  `estudio` int(11) DEFAULT NULL,
  `candidato_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reqacademico`
--

LOCK TABLES `reqacademico` WRITE;
/*!40000 ALTER TABLE `reqacademico` DISABLE KEYS */;
/*!40000 ALTER TABLE `reqacademico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reqadicional`
--

DROP TABLE IF EXISTS `reqadicional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reqadicional` (
  `idreadicional` int(11) NOT NULL,
  `disdesplazarse` varchar(2) NOT NULL,
  `especificardes` varchar(30) NOT NULL,
  `disviajar` varchar(2) NOT NULL,
  `especificarvia` varchar(30) NOT NULL,
  `dishorario` varchar(2) NOT NULL,
  `especificarho` varchar(30) NOT NULL,
  `cuentaper` varchar(2) NOT NULL,
  `numpersonas` int(11) NOT NULL,
  `repordirecto` varchar(20) NOT NULL,
  PRIMARY KEY (`idreadicional`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reqadicional`
--

LOCK TABLES `reqadicional` WRITE;
/*!40000 ALTER TABLE `reqadicional` DISABLE KEYS */;
/*!40000 ALTER TABLE `reqadicional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int(3) NOT NULL,
  `rol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Administrador'),(2,'Vendedor'),(3,'Reclutador'),(4,'Coordinador');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `servicio_requerido`
--

DROP TABLE IF EXISTS `servicio_requerido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `servicio_requerido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `servicio` varchar(100) DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servicio_requerido`
--

LOCK TABLES `servicio_requerido` WRITE;
/*!40000 ALTER TABLE `servicio_requerido` DISABLE KEYS */;
INSERT INTO `servicio_requerido` VALUES (1,'Servicios especializados',1),(2,'RYS',1),(3,'Administración de personal',1),(4,'Internos',1);
/*!40000 ALTER TABLE `servicio_requerido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_salario`
--

DROP TABLE IF EXISTS `tipo_salario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_salario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_salario`
--

LOCK TABLES `tipo_salario` WRITE;
/*!40000 ALTER TABLE `tipo_salario` DISABLE KEYS */;
INSERT INTO `tipo_salario` VALUES (1,'Fijo'),(2,'Variable'),(3,'Mixto'),(4,'En especie');
/*!40000 ALTER TABLE `tipo_salario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `roles_id` int(3) DEFAULT NULL,
  `status` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Julio Cesar Delgado Garcia','jcdg10@gmail.com','4545454',NULL,'$2y$10$i8lWDsyBIwj4hoNpvlQvWODgmEtKQOI18GVw4isv3gZVxlCCjDrx6',NULL,'2022-12-16 03:41:41','2023-08-04 00:15:17',1,1),(2,'Julio Cesar','jcdg101@gmail.com',NULL,NULL,'$2y$10$xXPZud0KoSZjiAeWvmW3ZuLiPtwaUKBibM.LQVEwujAMuUFC5O/Xq',NULL,'2022-12-15 22:45:32','2023-06-28 23:05:06',4,1),(3,'Julio Delgado Alonso','jcdg1044@gmail.com',NULL,NULL,'$2y$10$/0om55e6DapHEGQLlJdkne5/b6dOiWKNqmLZegfN0mP4KHCm///Ru',NULL,'2022-12-15 22:47:30','2023-08-17 20:17:34',3,1),(4,'Alonso Sandoval','jcdg104@gmail.com',NULL,NULL,'$2y$10$G.YUVib8Or8IhrFe1/is1.s1D4YLasVdQ6ljxpZDBYMQcs6sQSoEG',NULL,'2022-12-15 22:49:18','2024-01-26 18:44:17',3,1),(5,'Alejandra Sosa','sosa112@gmail.com','4432852633',NULL,'$2y$10$Vt5eTJQ2Eh2QqRA8GnoU2.MO9n44AOtHxzUQBS6V61th.nJZC4p2e',NULL,'2023-01-02 18:53:46','2024-01-26 18:37:11',2,1),(6,'Pedro Lopez','vanfanel471@hotmail.com','333457186',NULL,'$2y$10$0SBByipfZKqDvvEEq1AC2.vjvk8iWZbRRmZhXVf8fHDT22ptv/38e',NULL,'2023-06-22 17:49:46','2023-08-16 18:26:18',1,1),(7,'Gabriela Granados','gabriela.granados@grupoperti.com.mx','4420704236',NULL,'$2y$10$oYF/Niir2LqFF5XjhaUqoOmIEG/XUpoDdq/qxrA8vewNtTyyV86AW',NULL,'2023-07-31 22:10:21','2024-01-24 23:25:45',1,1),(8,'Getsemani Rivero','getsemani.rivero@grupoperti.com.mx','4421526302',NULL,'$2y$10$2cQUiY1AwFcYYOwgmj50JeiJYoQy1DPNUlfBpWhPsB6LncATeI8h6',NULL,'2023-07-31 22:29:34','2023-07-31 22:29:34',1,1),(9,'Ventas Mendez','karlagrato@gmail.com',NULL,NULL,'$2y$10$24psqwZhBOVLigrQiKmlb.pkZ949jPBZgk0XnlTCMgh/oIE89sm3y',NULL,'2023-08-03 19:12:20','2023-08-07 23:38:47',2,1),(19,'Reclutador Granados','karla.grato@hotmail.com',NULL,NULL,'$2y$10$J0rJ383bdjTYgp.oruIAW.SpD9BfKLavaZfdFt2W4KH08Pnw5fjXO',NULL,'2023-08-04 17:03:43','2023-08-07 23:43:23',3,1),(20,'Coordinador Gabs','angi.gonzalez45@hotmail.com',NULL,NULL,'$2y$10$3h237as9pd3cq9F90y4UTe2WAsRh0KshfZ3cyl8JkAKopZogJOwgO',NULL,'2023-08-07 23:40:21','2023-08-07 23:46:25',4,1),(21,'Julio Cesar Delgado Garcia','juliofubuki10@gmail.com','3330472186',NULL,'$2y$10$sy2h5A3Ut2aYGtkXb4UwhOGY5gx56kvAkt9N45SAYBBvKvig7FvLe',NULL,'2023-08-16 18:25:11','2023-08-16 18:25:11',1,1),(22,'Leo','vanfanel47@hotmail.com','3330472186',NULL,'$2y$10$mPcQoJvEyC0cLNz7g7qdO.RThhS/qRwLA1qSlUqMYzciT9dMGPCXC',NULL,'2023-08-16 18:26:22','2023-08-17 16:48:43',1,1),(23,'Alfonso Martinez','alfonso@gmail.com','4485209315',NULL,'$2y$10$vezOIPdGRMYWkD2Xbdl6ZOZk64nw270.ZKEGY9RKBJBuPdkHsE5wO',NULL,'2023-08-23 20:20:28','2023-08-23 20:20:43',3,1),(24,'Julio Cesar Delgado Garcia','juliobelanova10@gmail.com',NULL,NULL,'$2y$10$tHI3gB2.UM/DziQQlMI8EuMQr9SD.tzGKrjRqPOKlev0gTOqWPWDy',NULL,'2024-01-31 23:09:44','2024-01-31 23:09:44',1,1),(25,'Julio Cesar Delgado Garcia','juliocazares100@gmail.com',NULL,NULL,'$2y$10$uVKbWzqbwjacOym4AaWNQuPALbx/HbTmJT4tuK/I93CjV.kpbL/tS',NULL,'2024-01-31 23:11:26','2024-01-31 23:11:26',1,1),(26,'Julio Cesar Delgado Garcia','julio.turkey01@gmail.com',NULL,NULL,'$2y$10$BQ02S.TCWDQtRpn6TqOr0eF76PD2krVySwSCETNTlUoF1Tp60TZvm',NULL,'2024-01-31 23:19:30','2024-01-31 23:19:30',1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacantes`
--

DROP TABLE IF EXISTS `vacantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) DEFAULT NULL,
  `fechaalta` datetime DEFAULT NULL,
  `fechamod` datetime DEFAULT NULL,
  `estatus` int(11) DEFAULT NULL,
  `estatus_vacante` int(11) DEFAULT NULL,
  `reclutador_id` int(11) DEFAULT NULL,
  `fecha_vacante_cubierta` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vancantes_cliente_id_idx` (`cliente_id`),
  CONSTRAINT `vancantes_cliente_id` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacantes`
--

LOCK TABLES `vacantes` WRITE;
/*!40000 ALTER TABLE `vacantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacantes_candidatos`
--

DROP TABLE IF EXISTS `vacantes_candidatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vacantes_candidatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vacantes_id` int(11) DEFAULT NULL,
  `candidato_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vacantes_candidatos_id_idx` (`vacantes_id`),
  KEY `candidatos_vacantes_id_idx` (`candidato_id`),
  CONSTRAINT `candidatos_vacantes_id` FOREIGN KEY (`candidato_id`) REFERENCES `candidatos` (`idcandidato`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `vacantes_candidatos_id` FOREIGN KEY (`vacantes_id`) REFERENCES `vacantes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacantes_candidatos`
--

LOCK TABLES `vacantes_candidatos` WRITE;
/*!40000 ALTER TABLE `vacantes_candidatos` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacantes_candidatos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-31 21:41:01
