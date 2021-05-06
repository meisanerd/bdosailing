-- MariaDB dump 10.18  Distrib 10.4.17-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: bdo
-- ------------------------------------------------------
-- Server version	10.4.17-MariaDB-log

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
-- Table structure for table `ship_building_materials`
--

DROP TABLE IF EXISTS `ship_building_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ship_building_materials` (
  `user_id` int(10) unsigned NOT NULL,
  `materials` text DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ship_building_materials`
--

LOCK TABLES `ship_building_materials` WRITE;
/*!40000 ALTER TABLE `ship_building_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `ship_building_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trade_items`
--

DROP TABLE IF EXISTS `trade_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trade_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `weight` decimal(7,2) DEFAULT NULL,
  `record_trade` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_items`
--

LOCK TABLES `trade_items` WRITE;
/*!40000 ALTER TABLE `trade_items` DISABLE KEYS */;
INSERT INTO `trade_items` VALUES (1,'Ancient Urn Piece',1,800.00,1),(2,'Cherry Tree Seed Pouch',1,800.00,1),(3,'Chewy Raw Gizzard',1,800.00,1),(4,'Dried Blue Rose',1,800.00,1),(5,'Fertile Soil',1,800.00,1),(6,'Giant Fish Bone',1,800.00,1),(7,'Golden Sand',1,800.00,1),(8,'Naval Ration',1,800.00,1),(9,'Pirates Gunpowder',1,800.00,1),(10,'Raft Toy',1,800.00,1),(11,'Rakeflower Seed Pouch',1,800.00,1),(12,'Roa Flower Seed Pouch',1,800.00,1),(13,'Stained Seagull Figurine',1,800.00,1),(14,'Unidentified Ancient Mural',1,800.00,1),(15,'Conch Shell Ornament',2,800.00,1),(16,'Cron Castle Gold Coin',2,800.00,1),(17,'Filtered Drinking Water',2,800.00,1),(18,'Narvo Sea Cucumber',2,800.00,1),(19,'Opulent Marble',2,800.00,1),(20,'Pirate Gold Coin',2,800.00,1),(21,'Sea Survival Kit',2,800.00,1),(22,'Supreme Oyster Box',2,800.00,1),(23,'Gooey Monster Blood',3,900.00,1),(24,'Lopsters Fishnet',3,900.00,1),(25,'Old Hourglass',3,900.00,1),(26,'Rare Herb Pile',3,900.00,1),(27,'Scout Binoculars',3,900.00,1),(28,'Skull Symbol Carpet',3,900.00,1),(29,'Torn Pirate Treasure Map',3,900.00,1),(30,'Weasel Leather Coat',3,900.00,1),(31,'Amethyst Fragment',4,1000.00,1),(32,'Boatsman\'s Manual',4,1000.00,1),(33,'Marine Knight\'s Helm',4,1000.00,1),(34,'Old Chest with Gold Coins',4,1000.00,1),(35,'Solidified Lava',4,1000.00,1),(36,'37 Year Old Herbal Wine',5,1000.00,1),(37,'102 Year Old Golden Herb',5,1000.00,1),(39,'Azure Quartz',5,1000.00,1),(40,'Elixer of Youth',5,1000.00,1),(41,'Faded Gold Dragon Figurine',5,1000.00,1),(42,'Golden Fish Scale',5,1000.00,1),(43,'Luxury Patterned Fabric',5,1000.00,1),(44,'Mysterious Rock',5,1000.00,1),(45,'Octagonal Box',5,1000.00,1),(46,'Portrait of the Ancient',5,1000.00,1),(47,'Statues Tear',5,1000.00,1),(48,'Taxidermied White Caterpillar',5,1000.00,1),(49,'Marine Knight\'s Spear',4,1000.00,1),(50,'Crow Coins',0,0.00,1),(51,'Stolen Pirate Dagger',4,1000.00,1),(52,'Pirates\' Supply Box',3,900.00,1),(53,'Pirate Ship Mast',2,800.00,1),(54,'Beer',0,0.10,1),(55,'Offload Trade Items',0,0.00,0),(56,'Islanders\' Lunchbox',2,800.00,1),(57,'Big Stone Slab',2,800.00,1),(58,'Balanced Stone Pagoda',2,800.00,1),(59,'Monster Tentacle',2,800.00,1),(60,'Urchin Spine',2,800.00,1),(61,'Blue Candle Bundle',3,900.00,1),(62,'Ancient Orders',3,900.00,1),(63,'Round Knife',3,900.00,1),(64,'Stalactite Fragment',3,900.00,1),(65,'Pirate\'s Key',4,1000.00,1),(66,'Bronze Candlestick',4,1000.00,1),(67,'Headless Dragon Figurine',4,1000.00,1),(68,'Panacea',4,1000.00,1),(69,'Seashell Deco',4,1000.00,1),(70,'Green Salt Lump',4,1000.00,1),(71,'Opulent Thread Spool',4,1000.00,1),(72,'Taxidermied Morpho Butterfly',5,1000.00,1),(73,'Supreme Gold Candlestick',5,1000.00,1),(74,'Sinner\'s Blood',0,0.10,1),(75,'Rough Stone',0,0.30,1),(76,'Cox Pirates\' Journal',0,1000.00,1),(77,'Opulent Coral Trinket',0,1000.00,1),(78,'Rust Repair Tool',0,1000.00,1),(79,'Otters Fish Hook',0,1000.00,1),(80,'Knitting Yarn',0,0.10,1),(81,'Powder of Crevice',0,0.10,1),(82,'Noc Ore',0,0.10,1),(83,'Rough Black Crystal',0,0.10,1),(84,'Brilliant Pearl Shard',0,0.10,1),(85,'Brilliant Rock Salt Ingot',0,0.10,1),(86,'Oquilla\'s Flower',0,0.00,1),(87,'Skull Decorated Teacup',3,900.00,1),(88,'Lead Ore',0,0.30,1),(89,'Loopy Tree Plank',0,0.50,1),(90,'Flax',0,0.10,1),(91,'Flax Fabric',0,0.10,1),(92,'Cactus Rind',0,0.50,1),(93,'Crow Merchants Guild\'s Barter Voucher',0,0.00,0),(94,'Essence of Liquor',0,0.01,1),(95,'Grilled Bird Meat',0,0.10,1),(96,'Fortune Teller Mushroom',0,0.10,1),(97,'Fruit of Abundance',0,0.10,1),(98,'Cobalt Ingot',0,0.30,1),(99,'Rough Blue Crystal',0,0.30,1),(100,'Powder of Darkness',0,0.10,1),(101,'Rough Mud Crystal',0,0.30,1),(102,'Spirit\'s Leaf',0,0.10,1),(103,'Rough Green Crystal',0,0.30,1),(104,'Load Trade Items',0,0.00,0),(105,'Noc Ingot',0,0.30,0),(106,'Great Ocean Dark Iron',0,0.30,0),(107,'Bloody Tree Knot',0,0.10,1),(108,'Monk\'s Branch',0,0.10,1),(109,'Vinegar',0,0.01,1),(110,'Bag of Muddy Water',0,0.10,1),(111,'Powder of Time',0,0.10,1),(112,'Old Tree Bark',0,0.10,1),(113,'Enhanced Island Tree Coated Plywood',0,0.50,1),(114,'Ruddy Manganese Nodule',0,0.30,1),(115,'Cox Pirates\' Artifact (Parley Expert)',0,0.10,1),(116,'Star Anise',0,0.10,1),(117,'Fruit of Magic Power',0,0.10,1);
/*!40000 ALTER TABLE `trade_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trade_location_item_map`
--

DROP TABLE IF EXISTS `trade_location_item_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trade_location_item_map` (
  `location_id` int(10) unsigned NOT NULL,
  `input_id` int(10) unsigned NOT NULL,
  `output_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`location_id`,`input_id`,`output_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_location_item_map`
--

LOCK TABLES `trade_location_item_map` WRITE;
/*!40000 ALTER TABLE `trade_location_item_map` DISABLE KEYS */;
INSERT INTO `trade_location_item_map` VALUES (3,80,9),(3,91,5),(3,97,8),(3,110,1),(4,53,98),(5,67,76),(6,32,37),(6,32,42),(6,33,46),(6,33,50),(7,36,50),(7,39,50),(8,40,50),(9,39,50),(9,45,50),(9,46,50),(10,39,50),(10,42,50),(10,47,50),(11,49,39),(12,31,44),(12,31,50),(12,34,50),(12,71,39),(13,29,32),(13,29,51),(14,17,63),(15,1,17),(15,12,57),(16,74,7),(16,83,7),(16,102,8),(16,109,11),(16,117,13),(17,33,43),(19,46,85),(21,80,7),(21,90,11),(21,101,10),(21,107,7),(22,82,11),(22,89,14),(22,111,13),(22,112,3),(23,29,31),(23,30,68),(24,9,57),(26,88,5),(26,90,12),(26,94,13),(26,97,10),(26,116,12),(27,53,64),(27,57,26),(29,27,31),(29,87,32),(30,16,23),(30,20,61),(30,22,29),(30,56,29),(30,58,29),(31,2,59),(33,26,33),(34,52,71),(34,87,49),(35,31,42),(35,31,45),(35,34,73),(36,7,22),(37,3,20),(37,10,21),(37,12,17),(39,49,50),(39,67,72),(40,58,63),(41,26,65),(41,29,69),(42,21,26),(43,1,56),(45,11,20),(46,10,58),(46,12,16),(47,16,28),(47,18,30),(48,34,47),(48,65,39),(48,69,50),(49,14,18),(49,14,58),(50,32,37),(50,68,42),(50,69,50),(50,70,50),(51,17,23),(51,18,26),(51,53,52),(51,60,29),(52,32,78),(54,34,79),(55,51,77),(56,46,50),(57,81,6),(57,81,12),(57,92,10),(57,109,14),(58,71,37),(59,83,2),(59,88,6),(59,94,2),(59,99,7),(59,102,2),(59,108,13),(60,34,115),(60,54,2),(60,80,12),(60,99,12),(60,103,3),(60,110,8),(61,42,84),(62,17,87),(63,54,10),(65,33,114),(65,54,4),(66,28,67),(66,29,32),(66,52,49),(67,2,60),(67,8,53),(68,68,76),(69,29,34),(69,63,34),(70,99,1),(70,99,12),(70,103,14),(70,107,3),(71,3,16),(71,8,60),(72,8,21),(72,12,20),(73,21,52),(73,60,52),(74,61,34),(74,63,31),(74,64,33),(75,23,51),(75,26,68),(75,29,70),(75,52,65),(76,28,71),(77,70,41),(78,27,67);
/*!40000 ALTER TABLE `trade_location_item_map` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trade_locations`
--

DROP TABLE IF EXISTS `trade_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trade_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trade_locations`
--

LOCK TABLES `trade_locations` WRITE;
/*!40000 ALTER TABLE `trade_locations` DISABLE KEYS */;
INSERT INTO `trade_locations` VALUES (1,'Velia'),(2,'Port Epheria'),(3,'Randis Island'),(4,'Netnume Island'),(5,'Shipwrecked Cargo Ship'),(6,'Orffs Island'),(7,'Derko Island'),(8,'Kashuma Island'),(9,'Halmad Island'),(10,'Hakoven Island'),(11,'Narvo Island'),(12,'Oben Island'),(13,'Shasha Island'),(14,'Arakil Island'),(15,'Lerao Island'),(16,'Luivano Island'),(17,'Iliya Island'),(18,'Ancado Inner Harbor'),(19,'Marka Island'),(20,'Marlene Island'),(21,'Duch Island'),(22,'Ephde Rune Island'),(23,'Tulu Island'),(24,'Tashu Island'),(25,'Weita Island'),(26,'Paratama Island'),(27,'Taramura Island'),(28,'Delinghart Island'),(29,'Lisz Island'),(30,'Louruve Island'),(31,'Sokota Island'),(32,'Rameda Island'),(33,'Teyamal Island'),(34,'Almai Island'),(35,'Padix Island'),(36,'Tinberra Island'),(37,'Esfah Island'),(38,'Old Moon Guild Carrack'),(39,'Baremi Island'),(40,'Ginburrey Island'),(41,'Shirna Island'),(42,'Ostra Island'),(43,'Kuit Islands'),(44,'Modric Island'),(45,'Portanen Island'),(46,'Lema Island'),(47,'Angie Island'),(48,'Ajir Island'),(49,'Teste Island'),(50,'Balvege Island'),(51,'Dunde Island'),(52,'Shipwrecked Ancient Relic Transport Vessel'),(54,'Cholace Chico\'s Pirate Union'),(55,'Incomplete Ship'),(56,'Crow Merchant Ship'),(57,'Barater Island'),(58,'Pujara Island'),(59,'Eveto Island'),(60,'Mariveno Island'),(61,'Invernen Island'),(62,'Albresser Island'),(63,'Staren Island'),(64,'Serca Island'),(65,'Baeza Island'),(66,'Rosevan Island'),(67,'Arita Island'),(68,'Lantinia\'s Combat Raft'),(69,'Daton Island'),(70,'Beiruwa Island'),(71,'Racid Island'),(72,'Boa Island'),(73,'Kanvera Island'),(74,'Riyed Island'),(75,'Al-Naha Island'),(76,'Tigris Island'),(77,'Theonil Island'),(78,'Orisha Island');
/*!40000 ALTER TABLE `trade_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trades`
--

DROP TABLE IF EXISTS `trades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `location_id` int(10) unsigned DEFAULT NULL,
  `input_id` int(10) unsigned DEFAULT NULL,
  `input_qty` int(10) unsigned DEFAULT NULL,
  `output_id` int(10) unsigned DEFAULT NULL,
  `output_qty` int(10) unsigned DEFAULT NULL,
  `pos` int(10) unsigned DEFAULT NULL,
  `parley` int(10) unsigned DEFAULT NULL,
  `num` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=524 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trades`
--

LOCK TABLES `trades` WRITE;
/*!40000 ALTER TABLE `trades` DISABLE KEYS */;
/*!40000 ALTER TABLE `trades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_trade_items`
--

DROP TABLE IF EXISTS `user_trade_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_trade_items` (
  `user_id` int(10) unsigned NOT NULL,
  `trade_item_id` int(10) unsigned NOT NULL,
  `num` int(10) unsigned DEFAULT NULL,
  `notes` mediumtext DEFAULT NULL,
  PRIMARY KEY (`user_id`,`trade_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_trade_items`
--

LOCK TABLES `user_trade_items` WRITE;
/*!40000 ALTER TABLE `user_trade_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_trade_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `parley` int(10) unsigned DEFAULT NULL,
  `default_parley` int(10) unsigned DEFAULT NULL,
  `weight` decimal(7,2) DEFAULT NULL,
  `current_weight` decimal(7,2) DEFAULT NULL,
  `show_suggestions` tinyint(1) DEFAULT 0,
  `admin` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','12345',1000000,1,0.00,0.00,1));
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-16 11:04:58
