-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: idm
-- ------------------------------------------------------
-- Server version	5.7.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accesses`
--

DROP TABLE IF EXISTS `accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesses` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `status` int(11) NOT NULL,
  `resources_resource_id` int(11) NOT NULL,
  `users_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`access_id`,`resources_resource_id`),
  KEY `fk_accesses_resources1_idx` (`resources_resource_id`),
  KEY `fk_accesses_users1_idx` (`users_user_id`),
  CONSTRAINT `fk_accesses_resources1` FOREIGN KEY (`resources_resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_accesses_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18638 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizations` (
  `organization_id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(45) NOT NULL,
  `name` varchar(60) NOT NULL,
  `type` int(11) NOT NULL,
  `employer_number` varchar(60) NOT NULL,
  `created_on` datetime NOT NULL,
  `expires_on` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`organization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `organizations_owners`
--

DROP TABLE IF EXISTS `organizations_owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizations_owners` (
  `organization_owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `organizations_organization_id` int(11) NOT NULL,
  `users_user_id` int(11) NOT NULL,
  PRIMARY KEY (`organization_owner_id`,`organizations_organization_id`,`users_user_id`),
  KEY `fk_organizations_has_users_users1_idx` (`users_user_id`),
  KEY `fk_organizations_has_users_organizations1_idx` (`organizations_organization_id`),
  CONSTRAINT `fk_organizations_has_users_organizations1` FOREIGN KEY (`organizations_organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_organizations_has_users_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `description` tinytext,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resources_owners`
--

DROP TABLE IF EXISTS `resources_owners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources_owners` (
  `owner_id` int(11) NOT NULL AUTO_INCREMENT,
  `resources_resource_id` int(11) NOT NULL,
  `users_user_id` int(11) NOT NULL,
  PRIMARY KEY (`owner_id`,`resources_resource_id`,`users_user_id`),
  KEY `fk_resources_has_users_users1_idx` (`users_user_id`),
  KEY `fk_resources_has_users_resources1_idx` (`resources_resource_id`),
  CONSTRAINT `fk_resources_has_users_resources1` FOREIGN KEY (`resources_resource_id`) REFERENCES `resources` (`resource_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_has_users_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) DEFAULT NULL,
  `full_name` varchar(120) DEFAULT NULL,
  `birthday_date` date DEFAULT NULL,
  `personal_id` varchar(45) DEFAULT NULL,
  `work_id` varchar(45) DEFAULT NULL,
  `hiring_date` date DEFAULT NULL,
  `resignation_date` date DEFAULT NULL,
  `position` varchar(120) DEFAULT NULL,
  `supervisor_name` varchar(120) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime DEFAULT NULL,
  `organizations_organization_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`organizations_organization_id`),
  KEY `fk_users_organizations_idx` (`organizations_organization_id`),
  CONSTRAINT `fk_users_organizations` FOREIGN KEY (`organizations_organization_id`) REFERENCES `organizations` (`organization_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8414 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-24 19:33:47
