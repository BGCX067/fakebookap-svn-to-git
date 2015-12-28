-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.1.37


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema fakebook
--

CREATE DATABASE IF NOT EXISTS fakebook;
USE fakebook;

--
-- Definition of table `benutzer`
--

DROP TABLE IF EXISTS `benutzer`;
CREATE TABLE `benutzer` (
  `idBenutzer` int(11) NOT NULL AUTO_INCREMENT,
  `Vorname` varchar(40) NOT NULL,
  `Nachname` varchar(40) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Passwort` varchar(30) NOT NULL,
  PRIMARY KEY (`idBenutzer`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `benutzer`
--

/*!40000 ALTER TABLE `benutzer` DISABLE KEYS */;
INSERT INTO `benutzer` (`idBenutzer`,`Vorname`,`Nachname`,`Email`,`Passwort`) VALUES 
 (1,'Markus','Meier','markus@meier.ch','c4ca4238a0b923820dcc509a6f7584'),
 (2,'Alessio','Romagnolo','alessio@romagnolo.ch','c4ca4238a0b923820dcc509a6f7584'),
 (3,'Philippe','Defuns','philippe@defuns.ch','c4ca4238a0b923820dcc509a6f7584');
/*!40000 ALTER TABLE `benutzer` ENABLE KEYS */;


--
-- Definition of table `benutzerinformation`
--

DROP TABLE IF EXISTS `benutzerinformation`;
CREATE TABLE `benutzerinformation` (
  `idBenutzerinformation` int(11) NOT NULL AUTO_INCREMENT,
  `idBenutzer` int(11) NOT NULL,
  `Wert` text NOT NULL,
  `idInformationsname` int(11) NOT NULL,
  PRIMARY KEY (`idBenutzerinformation`),
  KEY `fk_Benutzerinformation_Benutzer1` (`idBenutzer`),
  KEY `fk_Benutzerinformation_Informationsname1` (`idInformationsname`),
  CONSTRAINT `fk_Benutzerinformation_Benutzer1` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Benutzerinformation_Informationsname1` FOREIGN KEY (`idInformationsname`) REFERENCES `informationsname` (`idInformationsname`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `benutzerinformation`
--

/*!40000 ALTER TABLE `benutzerinformation` DISABLE KEYS */;
INSERT INTO `benutzerinformation` (`idBenutzerinformation`,`idBenutzer`,`Wert`,`idInformationsname`) VALUES 
 (8,1,'M&auml;nnlich',1),
 (9,1,'1. Januar 1980',2),
 (10,1,'Z&uuml;rich, Schweiz',3),
 (11,1,'Technik',4),
 (12,1,'Ich heisse Markus Meier',7),
 (14,1,'BZZ',9),
 (15,2,'M&auml;nnlich',1),
 (16,2,'2. April 1992',2),
 (17,2,'Z&uuml;rich, Schweiz',3),
 (18,2,'Katholisch',6),
 (19,2,'Ich heisse Alessio Romagnolo',7),
 (20,2,'Bildungs Zentrum Z&uuml;richsee',8),
 (21,2,'UBS',9),
 (22,3,'M&auml;nnlich',1),
 (23,3,'23. Oktober 1991',2),
 (24,3,'Z&uuml;rich, Schweiz',3),
 (25,3,'Ich heisse Philippe Defuns',7);
/*!40000 ALTER TABLE `benutzerinformation` ENABLE KEYS */;


--
-- Definition of table `beziehung`
--

DROP TABLE IF EXISTS `beziehung`;
CREATE TABLE `beziehung` (
  `idBeziehung` int(11) NOT NULL AUTO_INCREMENT,
  `idBeziehungstyp` int(11) NOT NULL,
  `idBenutzerFrom` int(11) NOT NULL,
  `idBenutzerTo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idBeziehung`),
  KEY `fk_Beziehung_Beziehungstyp` (`idBeziehungstyp`),
  KEY `fk_Beziehung_BenutzerFrom` (`idBenutzerFrom`),
  KEY `fk_Beziehung_BenutzerTo` (`idBenutzerTo`),
  CONSTRAINT `fk_Beziehung_BenutzerFrom` FOREIGN KEY (`idBenutzerFrom`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Beziehung_BenutzerTo` FOREIGN KEY (`idBenutzerTo`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Beziehung_Beziehungstyp` FOREIGN KEY (`idBeziehungstyp`) REFERENCES `beziehungstyp` (`idBeziehungstyp`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beziehung`
--

/*!40000 ALTER TABLE `beziehung` DISABLE KEYS */;
/*!40000 ALTER TABLE `beziehung` ENABLE KEYS */;


--
-- Definition of table `beziehungstyp`
--

DROP TABLE IF EXISTS `beziehungstyp`;
CREATE TABLE `beziehungstyp` (
  `idBeziehungstyp` int(11) NOT NULL AUTO_INCREMENT,
  `Beziehung` varchar(50) NOT NULL,
  PRIMARY KEY (`idBeziehungstyp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `beziehungstyp`
--

/*!40000 ALTER TABLE `beziehungstyp` DISABLE KEYS */;
/*!40000 ALTER TABLE `beziehungstyp` ENABLE KEYS */;


--
-- Definition of table `freundschaft`
--

DROP TABLE IF EXISTS `freundschaft`;
CREATE TABLE `freundschaft` (
  `idFreundschaft` int(11) NOT NULL AUTO_INCREMENT,
  `idBenutzerFrom` int(11) NOT NULL,
  `idBenutzerTo` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`idFreundschaft`),
  KEY `fk_Freundschaft_BenutzerFrom` (`idBenutzerFrom`),
  KEY `fk_Freundschaft_BenutzerTo` (`idBenutzerTo`),
  CONSTRAINT `fk_Freundschaft_BenutzerFrom` FOREIGN KEY (`idBenutzerFrom`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Freundschaft_BenutzerTo` FOREIGN KEY (`idBenutzerTo`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `freundschaft`
--

/*!40000 ALTER TABLE `freundschaft` DISABLE KEYS */;
INSERT INTO `freundschaft` (`idFreundschaft`,`idBenutzerFrom`,`idBenutzerTo`,`Status`) VALUES 
 (1,1,3,1),
 (2,2,1,0),
 (3,2,3,1);
/*!40000 ALTER TABLE `freundschaft` ENABLE KEYS */;


--
-- Definition of table `gruppe`
--

DROP TABLE IF EXISTS `gruppe`;
CREATE TABLE `gruppe` (
  `idGruppe` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(60) NOT NULL,
  `Beschreibung` text,
  `idGruppentyp` int(11) NOT NULL,
  PRIMARY KEY (`idGruppe`),
  KEY `fk_Gruppe_Gruppentyp1` (`idGruppentyp`),
  CONSTRAINT `fk_Gruppe_Gruppentyp1` FOREIGN KEY (`idGruppentyp`) REFERENCES `gruppentyp` (`idGruppentyp`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gruppe`
--

/*!40000 ALTER TABLE `gruppe` DISABLE KEYS */;
INSERT INTO `gruppe` (`idGruppe`,`Name`,`Beschreibung`,`idGruppentyp`) VALUES 
 (1,'Bildungs Zentrum Z&uuml;richsee','Die ist die offizielle Gruppe vom Bildungs Zentrum Z&uuml;richsee.',8),
 (2,'UBS','F&uuml;r alle UBS Fans!',6);
/*!40000 ALTER TABLE `gruppe` ENABLE KEYS */;


--
-- Definition of table `gruppenmitglied`
--

DROP TABLE IF EXISTS `gruppenmitglied`;
CREATE TABLE `gruppenmitglied` (
  `idGruppenmitglied` int(11) NOT NULL AUTO_INCREMENT,
  `idGruppe` int(11) NOT NULL,
  `idBenutzer` int(11) NOT NULL,
  `idGruppenrecht` int(11) NOT NULL,
  PRIMARY KEY (`idGruppenmitglied`),
  KEY `fk_Gruppenmitglied_Gruppe` (`idGruppe`),
  KEY `fk_Gruppenmitglied_Benutzer` (`idBenutzer`),
  KEY `fk_Gruppenmitglied_Gruppenrecht` (`idGruppenrecht`),
  CONSTRAINT `fk_Gruppenmitglied_Benutzer` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gruppenmitglied_Gruppe` FOREIGN KEY (`idGruppe`) REFERENCES `gruppe` (`idGruppe`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gruppenmitglied_Gruppenrecht` FOREIGN KEY (`idGruppenrecht`) REFERENCES `gruppenrecht` (`idGruppenrecht`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gruppenmitglied`
--

/*!40000 ALTER TABLE `gruppenmitglied` DISABLE KEYS */;
INSERT INTO `gruppenmitglied` (`idGruppenmitglied`,`idGruppe`,`idBenutzer`,`idGruppenrecht`) VALUES 
 (1,1,1,1),
 (2,2,2,1),
 (3,2,1,4),
 (4,2,3,3);
/*!40000 ALTER TABLE `gruppenmitglied` ENABLE KEYS */;


--
-- Definition of table `gruppenrecht`
--

DROP TABLE IF EXISTS `gruppenrecht`;
CREATE TABLE `gruppenrecht` (
  `idGruppenrecht` int(11) NOT NULL AUTO_INCREMENT,
  `Recht` varchar(30) NOT NULL,
  PRIMARY KEY (`idGruppenrecht`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gruppenrecht`
--

/*!40000 ALTER TABLE `gruppenrecht` DISABLE KEYS */;
INSERT INTO `gruppenrecht` (`idGruppenrecht`,`Recht`) VALUES 
 (1,'Gr&uuml;nder'),
 (2,'Admin'),
 (3,'User'),
 (4,'Eingeladen');
/*!40000 ALTER TABLE `gruppenrecht` ENABLE KEYS */;


--
-- Definition of table `gruppentyp`
--

DROP TABLE IF EXISTS `gruppentyp`;
CREATE TABLE `gruppentyp` (
  `idGruppentyp` int(11) NOT NULL AUTO_INCREMENT,
  `Typ` varchar(50) NOT NULL,
  PRIMARY KEY (`idGruppentyp`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gruppentyp`
--

/*!40000 ALTER TABLE `gruppentyp` DISABLE KEYS */;
INSERT INTO `gruppentyp` (`idGruppentyp`,`Typ`) VALUES 
 (1,'Wirtschaft'),
 (2,'Gemeinsame Interessen'),
 (3,'Unterhaltung & Kunst'),
 (4,'Geographie'),
 (5,'Internet & Technologie'),
 (6,'Nur zum Spass'),
 (7,'Musik'),
 (8,'Organisationen'),
 (9,'Sport & Freizeit'),
 (10,'Studentengruppen');
/*!40000 ALTER TABLE `gruppentyp` ENABLE KEYS */;


--
-- Definition of table `informationsname`
--

DROP TABLE IF EXISTS `informationsname`;
CREATE TABLE `informationsname` (
  `idInformationsname` int(11) NOT NULL AUTO_INCREMENT,
  `Bezeichnung` varchar(50) NOT NULL,
  PRIMARY KEY (`idInformationsname`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `informationsname`
--

/*!40000 ALTER TABLE `informationsname` DISABLE KEYS */;
INSERT INTO `informationsname` (`idInformationsname`,`Bezeichnung`) VALUES 
 (1,'Geschlecht'),
 (2,'Geburtstag'),
 (3,'Heimatstadt'),
 (4,'Interessiert an'),
 (5,'Politische Einstellung'),
 (6,'Religi&ouml;se Ansichten'),
 (7,'&Uuml;ber mich'),
 (8,'Schule'),
 (9,'Arbeitgeber');
/*!40000 ALTER TABLE `informationsname` ENABLE KEYS */;


--
-- Definition of table `kommentar`
--

DROP TABLE IF EXISTS `kommentar`;
CREATE TABLE `kommentar` (
  `idKommentar` int(11) NOT NULL AUTO_INCREMENT,
  `idBenutzer` int(11) NOT NULL,
  `Kommentar` text NOT NULL,
  `Datum` datetime NOT NULL,
  `idMeldung` int(11) NOT NULL,
  PRIMARY KEY (`idKommentar`),
  KEY `fk_Kommentar_Benutzer` (`idBenutzer`),
  KEY `fk_Kommentar_Meldung1` (`idMeldung`),
  CONSTRAINT `fk_Kommentar_Benutzer` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kommentar_Meldung1` FOREIGN KEY (`idMeldung`) REFERENCES `meldung` (`idMeldung`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kommentar`
--

/*!40000 ALTER TABLE `kommentar` DISABLE KEYS */;
INSERT INTO `kommentar` (`idKommentar`,`idBenutzer`,`Kommentar`,`Datum`,`idMeldung`) VALUES 
 (1,3,'Find ich guet :)','2010-01-20 20:01:14',1);
/*!40000 ALTER TABLE `kommentar` ENABLE KEYS */;


--
-- Definition of table `meldung`
--

DROP TABLE IF EXISTS `meldung`;
CREATE TABLE `meldung` (
  `idMeldung` int(11) NOT NULL AUTO_INCREMENT,
  `Meldung` varchar(200) NOT NULL,
  `idBenutzer` int(11) NOT NULL,
  `Datum` datetime NOT NULL,
  PRIMARY KEY (`idMeldung`),
  KEY `fk_Meldung_Benutzer1` (`idBenutzer`),
  CONSTRAINT `fk_Meldung_Benutzer1` FOREIGN KEY (`idBenutzer`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meldung`
--

/*!40000 ALTER TABLE `meldung` DISABLE KEYS */;
INSERT INTO `meldung` (`idMeldung`,`Meldung`,`idBenutzer`,`Datum`) VALUES 
 (1,'Ich bin grad am Testdate erstelle ;)',2,'2010-01-20 19:53:53'),
 (2,'Philippe hat <a href=\"/fakebook/index.php?site=profil&id=2\" >Alessio Romagnolo</a>s Meldung kommentiert.',3,'2010-01-20 20:01:14');
/*!40000 ALTER TABLE `meldung` ENABLE KEYS */;


--
-- Definition of table `nachricht`
--

DROP TABLE IF EXISTS `nachricht`;
CREATE TABLE `nachricht` (
  `idNachricht` int(11) NOT NULL AUTO_INCREMENT,
  `idBenutzerFrom` int(11) NOT NULL,
  `idBenutzerTo` int(11) NOT NULL,
  `Nachricht` text NOT NULL,
  `Betreff` varchar(100) DEFAULT NULL,
  `Datum` datetime NOT NULL,
  `idParent` int(11) DEFAULT NULL,
  `Gelesen` tinyint(1) NOT NULL DEFAULT '0',
  `HiddenFrom` tinyint(1) NOT NULL DEFAULT '0',
  `HiddenTo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idNachricht`),
  KEY `fk_Nachricht_BenutzerFrom` (`idBenutzerFrom`),
  KEY `fk_Nachricht_BenutzerTo` (`idBenutzerTo`),
  KEY `fk_Nachricht_idParent` (`idParent`),
  CONSTRAINT `fk_Nachricht_BenutzerFrom` FOREIGN KEY (`idBenutzerFrom`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nachricht_BenutzerTo` FOREIGN KEY (`idBenutzerTo`) REFERENCES `benutzer` (`idBenutzer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nachricht_idParent` FOREIGN KEY (`idParent`) REFERENCES `nachricht` (`idNachricht`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nachricht`
--

/*!40000 ALTER TABLE `nachricht` DISABLE KEYS */;
INSERT INTO `nachricht` (`idNachricht`,`idBenutzerFrom`,`idBenutzerTo`,`Nachricht`,`Betreff`,`Datum`,`idParent`,`Gelesen`,`HiddenFrom`,`HiddenTo`) VALUES 
 (1,3,1,'Guten Tag Herr Meier,\r\n\r\nWir haben das Projekt nun fertiggestellt und es kann getestet werden. Wir hoffen es gef&auml;llt Ihnen und nat&uuml;rlich, dass es eine gute Note gibt.\r\n\r\nGruss\r\nPhilippe Defuns\r\nAlessio Romagnolo','Modulpr&uuml;fung','2010-01-20 20:04:03',NULL,0,0,0),
 (2,2,3,'Hoi Phippi,\r\n\r\nMir sind fertig mit de Modulpr&uuml;efig und ch&ouml;nds abg&auml;.\r\n\r\nGruess\r\nAlessio','Modulpr&uuml;efig','2010-01-20 20:05:05',NULL,0,0,0),
 (3,3,2,'Ok find ich guet :)',NULL,'2010-01-20 20:05:33',2,0,0,0);
/*!40000 ALTER TABLE `nachricht` ENABLE KEYS */;


--
-- Definition of procedure `sps_acceptFriend`
--

DROP PROCEDURE IF EXISTS `sps_acceptFriend`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_acceptFriend`(
  IN IN_idBenutzer INT,
  IN IN_idFriend INT
)
BEGIN

UPDATE
  freundschaft
SET
  Status=1
WHERE
  idBenutzerFrom=IN_idFriend AND idBenutzerTo=IN_idBenutzer;

SELECT
  idBenutzerFrom,
  idBenutzerTo,
  `status`
FROM
  freundschaft
WHERE
  (idBenutzerFrom=IN_idBenutzer AND idBenutzerTo=IN_idFriend) OR
  (idBenutzerFrom=IN_idFriend AND idBenutzerTo=IN_idBenutzer);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_addFriend`
--

DROP PROCEDURE IF EXISTS `sps_addFriend`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_addFriend`(
  IN IN_idBenutzer INT,
  IN IN_idFriend INT
)
BEGIN

DECLARE DEC_exists TINYINT(1) DEFAULT 0;

SELECT
  1
INTO
  DEC_exists
FROM
  freundschaft
WHERE
  (idBenutzerFrom=IN_idBenutzer AND idBenutzerTo=IN_idFriend) OR
  (idBenutzerFrom=IN_idFriend AND idBenutzerTo=IN_idBenutzer);

IF DEC_exists != 1 THEN
  IF IN_idBenutzer != IN_idFriend THEN
    INSERT INTO freundschaft (idBenutzerFrom, idBenutzerTo) VALUES (IN_idBenutzer, IN_idFriend);
    SELECT
      idBenutzerFrom,
      idBenutzerTo,
      `status`
    FROM
      freundschaft
    WHERE
      (idBenutzerFrom=IN_idBenutzer AND idBenutzerTo=IN_idFriend) OR
      (idBenutzerFrom=IN_idFriend AND idBenutzerTo=IN_idBenutzer);

  END IF;
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_addKommentar`
--

DROP PROCEDURE IF EXISTS `sps_addKommentar`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_addKommentar`(
  IN IN_idBenutzer INT,
  IN IN_kommentar TEXT,
  IN IN_datum DATETIME,
  IN IN_idMeldung INT
)
BEGIN

INSERT INTO kommentar
  (idBenutzer, Kommentar, Datum, idMeldung)
  VALUES (IN_idBenutzer, IN_kommentar, IN_datum, IN_idMeldung);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_checkLogin`
--

DROP PROCEDURE IF EXISTS `sps_checkLogin`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_checkLogin`(
  IN IN_email CHAR(100),
  IN IN_passwort CHAR(30)
)
BEGIN

DECLARE v_idBenutzer INT;

SELECT
  idBenutzer,
  vorname,
  nachname
FROM
  Benutzer
WHERE
  email=IN_email AND
  passwort=IN_passwort;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_createGroup`
--

DROP PROCEDURE IF EXISTS `sps_createGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_createGroup`(IN_name CHAR(60), IN_beschreibung TEXT, IN_gruppentyp INT, IN_admin INT)
BEGIN

DECLARE rechtID INT;
DECLARE gruppenID INT;

INSERT INTO gruppe (name, beschreibung, idGruppentyp) VALUES (IN_name, IN_beschreibung, IN_gruppentyp);

SELECT idGruppenrecht INTO rechtID FROM gruppenrecht WHERE Recht = 'Gr&uuml;nder';
SELECT LAST_INSERT_ID() INTO gruppenID;

INSERT INTO gruppenmitglied (idGruppe, idBenutzer, idGruppenrecht) VALUES (gruppenID, IN_admin, rechtID);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_createMeldung`
--

DROP PROCEDURE IF EXISTS `sps_createMeldung`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_createMeldung`(
  IN IN_idBenutzer INT,
  IN IN_meldung VARCHAR(200),
  IN IN_datum DATETIME
)
BEGIN

INSERT INTO meldung (Meldung, idBenutzer, Datum) VALUES(IN_meldung, IN_idBenutzer, IN_datum);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_createMessage`
--

DROP PROCEDURE IF EXISTS `sps_createMessage`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_createMessage`(
  IN_idBenutzer INT,
  IN_idBenutzerTo INT,
  IN_Nachricht TEXT,
  IN_Betreff VARCHAR(100),
  IN_Datum DATETIME
)
BEGIN

IF IN_idBenutzer != IN_idBenutzerTo THEN
  INSERT INTO nachricht
    (idBenutzerFrom, idBenutzerTo, Nachricht, Betreff, Datum)
    VALUES(IN_idBenutzer, IN_idBenutzerTo, IN_Nachricht, IN_Betreff, IN_Datum);
  SELECT 'done';
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_createMessageAnswer`
--

DROP PROCEDURE IF EXISTS `sps_createMessageAnswer`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_createMessageAnswer`(
  IN_idBenutzer INT,
  IN_idBenutzerTo INT,
  IN_Nachricht TEXT,
  IN_Datum DATETIME,
  IN_idParent INT
)
BEGIN

DECLARE DEC_idBenutzerFrom INT;
DECLARE DEC_idBenutzerTo INT;

SELECT
  idBenutzerFrom, idBenutzerTo
INTO
  DEC_idBenutzerFrom, DEC_idBenutzerTo
FROM
  nachricht
WHERE
  idNachricht=IN_idParent;

IF (IN_idBenutzer != IN_idBenutzerTo)
  AND (DEC_idBenutzerFrom=IN_idBenutzer OR DEC_idBenutzerTo=IN_idBenutzer)
  AND (DEC_idBenutzerFrom=IN_idBenutzerTo OR DEC_idBenutzerTo=IN_idBenutzerTo) THEN
  INSERT INTO nachricht
    (idBenutzerFrom, idBenutzerTo, Nachricht, Datum, idParent)
    VALUES(IN_idBenutzer, IN_idBenutzerTo, IN_Nachricht, IN_Datum, IN_idParent);
  UPDATE
    nachricht
  SET
    HiddenFrom=0,
    HiddenTo=0,
    Gelesen=0
  WHERE
    idNachricht=IN_idParent AND
    (idBenutzerFrom=IN_idBenutzer OR idBenutzerTo=IN_idBenutzer);
  SELECT 'done';
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_deleteFriend`
--

DROP PROCEDURE IF EXISTS `sps_deleteFriend`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_deleteFriend`(
  IN IN_idBenutzer INT,
  IN IN_idFriend INT
)
BEGIN

DELETE FROM
  freundschaft
WHERE
  (idBenutzerFrom=IN_idFriend AND idBenutzerTo=IN_idBenutzer) OR
  (idBenutzerFrom=IN_idBenutzer AND idBenutzerTo=IN_idFriend);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_deleteGroup`
--

DROP PROCEDURE IF EXISTS `sps_deleteGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_deleteGroup`(IN_idGruppe INT)
BEGIN

DELETE FROM gruppenmitglied WHERE idGruppe=IN_idGruppe;
DELETE FROM gruppe WHERE idGruppe=IN_idGruppe;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_deleteMessages`
--

DROP PROCEDURE IF EXISTS `sps_deleteMessages`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_deleteMessages`(
  IN IN_idBenutzer INT,
  IN IN_idNachricht INT
)
BEGIN

DECLARE DEC_idBenutzerFrom INT;
DECLARE DEC_idBenutzerTo INT;

SELECT
  idBenutzerFrom,
  idBenutzerTo
INTO
  DEC_idBenutzerFrom,
  DEC_idBenutzerTo
FROM
  nachricht
WHERE
  idNachricht=IN_idNachricht AND
  (idBenutzerFrom=IN_idBenutzer OR idBenutzerTo=IN_idBenutzer);

IF DEC_idBenutzerFrom = IN_idBenutzer THEN
  UPDATE
    nachricht
  SET
    HiddenFrom=1
  WHERE
    idNachricht=IN_idNachricht AND
    (idBenutzerFrom=IN_idBenutzer OR idBenutzerTo=IN_idBenutzer);
  SELECT 'done';
ELSEIF DEC_idBenutzerTo = IN_idBenutzer THEN
  UPDATE
    nachricht
  SET
    HiddenTo=1
  WHERE
    idNachricht=IN_idNachricht AND
    (idBenutzerFrom=IN_idBenutzer OR idBenutzerTo=IN_idBenutzer);
  SELECT 'done';
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_deleteUserFromGroup`
--

DROP PROCEDURE IF EXISTS `sps_deleteUserFromGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_deleteUserFromGroup`(IN_idGruppe INT, IN_idBenutzer INT)
BEGIN

DELETE FROM gruppenmitglied WHERE idGruppe=IN_idGruppe AND idBenutzer=IN_idBenutzer;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_editGroup`
--

DROP PROCEDURE IF EXISTS `sps_editGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_editGroup`(
  IN IN_idGruppe INT,
  IN IN_name CHAR(60),
  IN IN_beschreibung TEXT,
  IN IN_gruppentyp INT
)
BEGIN

UPDATE
  gruppe
SET
  Name=IN_name,
  Beschreibung=IN_beschreibung,
  idGruppentyp=IN_gruppentyp
WHERE
  idGruppe=IN_idGruppe;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getAnfragen`
--

DROP PROCEDURE IF EXISTS `sps_getAnfragen`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getAnfragen`(
  IN IN_idBenutzer INT
)
BEGIN

(
  SELECT
    bz.idBenutzer AS idAnfrage,
    CONCAT(bz.Vorname, ' ', bz.Nachname) AS Name,
    'f' AS Typ
  FROM
    Freundschaft fs
  LEFT OUTER JOIN
    Benutzer bz ON bz.idBenutzer=fs.idBenutzerFrom
  WHERE
    fs.idBenutzerTo=IN_idBenutzer AND
    Status=0
)
UNION ALL
(
  SELECT
    g.idGruppe AS idAnfrage,
    g.Name AS Name,
    'g' AS Typ
  FROM
    Gruppenmitglied gm
  LEFT OUTER JOIN
    Gruppe g ON g.idGruppe=gm.idGruppe
  LEFT OUTER JOIN
    Gruppenrecht gr ON gr.idGruppenrecht=gm.idGruppenrecht
  WHERE
    gm.idBenutzer=IN_idBenutzer AND gr.Recht='Eingeladen'
);


END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getFriends`
--

DROP PROCEDURE IF EXISTS `sps_getFriends`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getFriends`(
  IN IN_idBenutzer INT,
  IN IN_idActual INT
)
BEGIN

SELECT
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.idBenutzer, bzf.idBenutzer) AS idFriend,
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Vorname, bzf.Vorname) AS Vorname,
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Nachname, bzf.Nachname) AS Nachname,
  IF(fs2.idFreundschaft IS NOT NULL, IF(fs2.status=1, 1, IF(fs2.idBenutzerTo=IN_idActual, 2, 1)), IF(IN_idActual=fs.idBenutzerTo OR IN_idActual=fs.idBenutzerFrom, 1, 0)) AS isFriend
FROM
  freundschaft fs
LEFT OUTER JOIN
  Benutzer bzf ON bzf.idBenutzer=fs.idBenutzerFrom
LEFT OUTER JOIN
  Benutzer bzt ON bzt.idBenutzer=fs.idBenutzerTo
LEFT OUTER JOIN
  freundschaft fs2 ON
    (fs2.idBenutzerTo=IN_idActual AND fs2.idBenutzerFrom=IF(bzf.idBenutzer=IN_idBenutzer, bzt.idBenutzer, bzf.idBenutzer)) OR
    (fs2.idBenutzerFrom=IN_idActual AND fs2.idBenutzerTo=IF(bzf.idBenutzer=IN_idBenutzer, bzt.idBenutzer, bzf.idBenutzer))
WHERE
  (fs.idBenutzerFrom=IN_idBenutzer OR fs.idBenutzerTo=IN_idBenutzer) AND
  fs.status=1
GROUP BY
  idFriend
ORDER BY
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Nachname, bzf.Nachname) ASC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getFriendship`
--

DROP PROCEDURE IF EXISTS `sps_getFriendship`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getFriendship`(
  IN IN_idProfil INT,
  IN IN_idUser INT
)
BEGIN

SELECT
  idBenutzerFrom,
  idBenutzerTo,
  `status`
FROM
  freundschaft
WHERE
  (idBenutzerFrom=IN_idProfil AND idBenutzerTo=IN_idUser) OR
  (idBenutzerFrom=IN_idUser AND idBenutzerTo=IN_idProfil);

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getFriendsMeldungen`
--

DROP PROCEDURE IF EXISTS `sps_getFriendsMeldungen`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getFriendsMeldungen`(
  IN IN_idBenutzer INT
)
BEGIN

SELECT
  m.idMeldung,
  m.Meldung,
  m.Datum,
  b.Nachname AS Nachname,
  b.Vorname AS Vorname,
  m.idBenutzer
FROM
  meldung m
LEFT OUTER JOIN
  Benutzer b ON b.idBenutzer=m.idBenutzer
LEFT OUTER JOIN
  Freundschaft f ON
    ((f.idBenutzerFrom=IN_idBenutzer AND f.idBenutzerTo=m.idBenutzer) OR
    (f.idBenutzerTo=IN_idBenutzer AND f.idBenutzerFrom=m.idBenutzer)) AND
    f.status=1
WHERE
  f.idFreundschaft IS NOT NULL
  OR m.idBenutzer=IN_idBenutzer
ORDER BY
  m.Datum DESC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getGroupInformations`
--

DROP PROCEDURE IF EXISTS `sps_getGroupInformations`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getGroupInformations`(
  IN IN_idGruppe INT
)
BEGIN

SELECT
  g.name,
  g.beschreibung,
  t.typ
FROM
  gruppe g,
  gruppentyp t
WHERE
  idGruppe=IN_idGruppe AND
  t.idGruppentyp=g.idGruppentyp;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getGroupMembers`
--

DROP PROCEDURE IF EXISTS `sps_getGroupMembers`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getGroupMembers`(
  IN IN_idGruppe INT
)
BEGIN

SELECT
  b.idBenutzer,
  b.vorname,
  b.nachname
FROM
  gruppenmitglied gm,
  benutzer b,
  gruppenrecht gr
WHERE
  gm.idGruppe=IN_idGruppe AND
  b.idBenutzer=gm.idBenutzer AND
  gr.idGruppenrecht=gm.idGruppenrecht AND
  gr.Recht!='Eingeladen';

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getGruppentyp`
--

DROP PROCEDURE IF EXISTS `sps_getGruppentyp`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getGruppentyp`()
BEGIN

SELECT
  idGruppentyp,
  typ
FROM
  gruppentyp;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getKommentare`
--

DROP PROCEDURE IF EXISTS `sps_getKommentare`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getKommentare`(
  IN IN_idMeldung INT
)
BEGIN

SELECT
  k.Kommentar,
  k.Datum,
  b.Vorname AS Vorname,
  b.Nachname AS Nachname,
  k.idBenutzer
FROM
  kommentar k
LEFT OUTER JOIN
  Benutzer b ON b.idBenutzer=k.idBenutzer
WHERE
  k.idMeldung=IN_idMeldung
ORDER BY
  k.Datum DESC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getMessages`
--

DROP PROCEDURE IF EXISTS `sps_getMessages`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getMessages`(
  IN IN_BenutzerId INT
)
BEGIN

(
  SELECT * FROM
  (
    SELECT
      n.idNachricht,
      n.idBenutzerFrom,
      n.idBenutzerTo,
      f.Vorname AS VornameFrom,
      t.Vorname AS VornameTo,
      f.Nachname AS NachnameFrom,
      t.Nachname AS NachnameTo,
  	  n.Nachricht,
  	  n2.Betreff,
  	  n.Datum,
      n.idParent,
      IF(n.idBenutzerFrom=IN_BenutzerId, 1, 0) AS Geantwortet,
      IF(n.idBenutzerTo=IN_BenutzerId, n2.Gelesen, 1) AS Gelesen
    FROM
  	  nachricht n
    LEFT OUTER JOIN
      Benutzer f ON f.idBenutzer=n.idBenutzerFrom
    LEFT OUTER JOIN
      Benutzer t ON t.idBenutzer=n.idBenutzerTo
    LEFT OUTER JOIN
      Nachricht n2 ON n2.idNachricht=n.idParent
    WHERE
      (n2.idBenutzerFrom=IN_BenutzerId AND n2.HiddenFrom!=1) OR (n2.idBenutzerTO=IN_BenutzerId AND n2.HiddenTo!=1)
    ORDER BY
      n.Datum DESC
  ) AS tableTmp
  WHERE
    idParent IS NOT NULL
  GROUP BY
    idParent
)
UNION ALL
(
  SELECT
    n.idNachricht,
    n.idBenutzerFrom,
    n.idBenutzerTo,
    f.Vorname VornameFrom,
    t.Vorname VornameTo,
    f.Nachname NachnameFrom,
    t.Nachname NachnameTo,
	  n.Nachricht,
	  n.Betreff,
	  n.Datum,
    n.idParent,
    0 AS Geantwortet,
    IF(n.idBenutzerTo=IN_BenutzerId, n.Gelesen, 1) AS Gelesen
  FROM
	  nachricht n
  LEFT OUTER JOIN
    Benutzer f ON f.idBenutzer=n.idBenutzerFrom
  LEFT OUTER JOIN
    Benutzer t ON t.idBenutzer=n.idBenutzerTo
  WHERE
    (n.idParent IS NULL) AND
    ((n.idBenutzerFrom=IN_BenutzerId AND n.HiddenFrom!=1) OR (n.idBenutzerTO=IN_BenutzerId AND n.HiddenTo!=1))
) ORDER BY Datum DESC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getMessagesOfParent`
--

DROP PROCEDURE IF EXISTS `sps_getMessagesOfParent`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getMessagesOfParent`(
  IN IN_BenutzerId INT,
  IN IN_ParentId INT
)
BEGIN

DECLARE DEC_id INT;
DECLARE DEC_idBenutzerToCheck INT;
DECLARE DEC_isHidden TINYINT(1);
DECLARE DEC_idActual INT;

SELECT IF(idBenutzerTo=IN_BenutzerId, HiddenTo, HiddenFrom) INTO DEC_isHidden FROM nachricht WHERE idNachricht=IN_ParentId;
SELECT idNachricht INTO DEC_idActual FROM nachricht WHERE idParent=IN_ParentId ORDER BY Datum DESC LIMIT 1;

IF DEC_idActual IS NULL THEN
  SELECT idNachricht INTO DEC_idActual FROM nachricht WHERE idNachricht=IN_ParentId;
END IF;

IF DEC_isHidden != TRUE THEN
  /* Setzt das Gelesen-Flag auf true */
  SELECT idBenutzerTo INTO DEC_idBenutzerToCheck FROM nachricht WHERE idNachricht=DEC_idActual;

  IF DEC_idBenutzerToCheck=IN_BenutzerId THEN
    UPDATE
      nachricht
    SET
      Gelesen=1
    WHERE
      idNachricht=IN_ParentId AND
      (idBenutzerTo=IN_BenutzerId OR idBenutzerFrom=IN_BenutzerId);
  END IF;

  /* Holen der Nachrichten */
  SELECT
    IF(idParent IS NOT NULL,idParent,idNachricht) INTO DEC_id
  FROM
    nachricht
  WHERE
    (idBenutzerFrom=IN_BenutzerId OR idBenutzerTo=IN_BenutzerId) AND
    (idNachricht=IN_ParentId OR idParent=IN_ParentId)
  ORDER BY
    Datum ASC
  LIMIT 1;

  SELECT
    n.idNachricht,
    n.idBenutzerFrom AS idBenutzer,
    f.Vorname AS Vorname,
    f.Nachname AS Nachname,
    n.Nachricht,
    IF(n.Betreff IS NULL, n2.Betreff, n.Betreff) AS Betreff,
    n.Datum
  FROM
    nachricht n
  LEFT OUTER JOIN
    Benutzer f ON f.idBenutzer=n.idBenutzerFrom
  LEFT OUTER JOIN
    Nachricht n2 ON n2.idNachricht=n.idParent
  WHERE
    (n.idBenutzerFrom=IN_BenutzerId OR n.idBenutzerTO=IN_BenutzerId) AND
    (n.idNachricht=DEC_id OR n.idParent=DEC_id)
  ORDER BY
    n.Datum DESC;
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getOwnFriends`
--

DROP PROCEDURE IF EXISTS `sps_getOwnFriends`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getOwnFriends`(
  IN IN_idBenutzer INT
)
BEGIN

SELECT
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.idBenutzer, bzf.idBenutzer) AS idFriend,
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Vorname, bzf.Vorname) AS Vorname,
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Nachname, bzf.Nachname) AS Nachname,
  IF(fs.status=1, 1, IF(fs.idBenutzerTo=IN_idBenutzer, 2, 0)) as status
FROM
  freundschaft fs
LEFT OUTER JOIN
  Benutzer bzf ON bzf.idBenutzer=fs.idBenutzerFrom
LEFT OUTER JOIN
  Benutzer bzt ON bzt.idBenutzer=fs.idBenutzerTo
WHERE
  (fs.idBenutzerFrom=IN_idBenutzer OR fs.idBenutzerTo=IN_idBenutzer)
GROUP BY
  idFriend
ORDER BY
  IF(bzf.idBenutzer=IN_idBenutzer, bzt.Nachname, bzf.Nachname) ASC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getUserData`
--

DROP PROCEDURE IF EXISTS `sps_getUserData`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getUserData`(
IN IN_idBenutzer INT
)
BEGIN

SELECT vorname, nachname, email FROM benutzer WHERE idBenutzer = IN_idBenutzer;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getUserGroups`
--

DROP PROCEDURE IF EXISTS `sps_getUserGroups`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getUserGroups`(
  IN IN_idBenutzer INT
)
BEGIN

SELECT
  g.idGruppe,
  g.name
FROM
  gruppe g,
  gruppenmitglied m
WHERE
  m.idBenutzer=IN_idBenutzer AND
  m.idGruppe=g.idGruppe;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getUserInformations`
--

DROP PROCEDURE IF EXISTS `sps_getUserInformations`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getUserInformations`(
  IN IN_idBenutzer INT
)
BEGIN

SELECT
  i.wert,
  n.bezeichnung
FROM
  benutzerinformation i,
  informationsname n
WHERE
  i.idBenutzer=IN_idBenutzer AND
  i.idInformationsname=n.idInformationsname
ORDER BY
  n.bezeichnung ASC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_getUserMeldungen`
--

DROP PROCEDURE IF EXISTS `sps_getUserMeldungen`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_getUserMeldungen`(
  IN IN_idBenutzer INT
)
BEGIN

SELECT
  m.idMeldung,
  m.Meldung,
  m.Datum,
  b.Nachname AS Nachname,
  b.Vorname AS Vorname,
  m.idBenutzer
FROM
  meldung m
LEFT OUTER JOIN
  Benutzer b ON b.idBenutzer=m.idBenutzer
WHERE
  m.idBenutzer=IN_idBenutzer
ORDER BY
  m.Datum DESC;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_hideMessages`
--

DROP PROCEDURE IF EXISTS `sps_hideMessages`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_hideMessages`(
  IN IN_BenutzerId INT,
  IN IN_ParentId INT
)
BEGIN

UPDATE
  nachricht
SET
  HiddenFrom=1
WHERE
  idBenutzerFrom=IN_BenutzerId AND idNachricht=IN_ParentId;

UPDATE
  nachricht
SET
  HiddenTo=1
WHERE
  idBenutzerTo=IN_BenutzerId AND idNachricht=IN_ParentId;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_isUserInGroup`
--

DROP PROCEDURE IF EXISTS `sps_isUserInGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_isUserInGroup`(
  IN IN_idBenutzer INT,
  IN IN_idGruppe INT
)
BEGIN

SELECT
  idGruppenmitglied
FROM
  gruppenmitglied
WHERE
  idGruppe=IN_idGruppe AND
  idBenutzer=IN_idBenutzer;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_registerUser`
--

DROP PROCEDURE IF EXISTS `sps_registerUser`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_registerUser`(
  IN IN_vorname CHAR(40),
  IN IN_nachname CHAR(40),
  IN IN_email CHAR(100),
  IN IN_passwort CHAR(30)
)
BEGIN

DECLARE anzahl INT;

SELECT
  COUNT(idBenutzer) INTO anzahl
FROM
  benutzer
WHERE
  email=IN_email;

IF anzahl <= 0 THEN
  INSERT INTO benutzer (vorname, nachname, email, passwort) VALUES (IN_vorname, IN_nachname, IN_email, IN_passwort);
  SELECT 'done';
END IF;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;

--
-- Definition of procedure `sps_setUserRightsInGroup`
--

DROP PROCEDURE IF EXISTS `sps_setUserRightsInGroup`;

DELIMITER $$

/*!50003 SET @TEMP_SQL_MODE=@@SQL_MODE, SQL_MODE='' */ $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sps_setUserRightsInGroup`(
  IN IN_idGruppe INT,
  IN IN_idBenutzer INT,
  IN IN_idGruppenrecht INT
)
BEGIN

DECLARE anzahl INT;
DECLARE rechtid INT;

SELECT
  SQL_CALC_FOUND_ROWS idBenutzer
FROM
  gruppenmitglied
WHERE
  idGruppe=IN_idGruppe AND
  idBenutzer=IN_idBenutzer;

SELECT FOUND_ROWS() INTO anzahl;

IF IN_idGruppenrecht = 0 THEN
  SELECT idGruppenrecht INTO rechtid FROM gruppenrecht WHERE recht='User';
ELSEIF IN_idGruppenrecht = -1 THEN
  SELECT idGruppenrecht INTO rechtid FROM gruppenrecht WHERE recht='Eingeladen';
ELSE
  SET rechtid = idGruppenrecht;
END IF;

IF anzahl > 0 THEN
  UPDATE gruppenmitglied SET idGruppenrecht=rechtid WHERE idGruppe=IN_idGruppe AND idBenutzer=IN_idBenutzer;
ELSE
  INSERT INTO gruppenmitglied (idGruppe, idBenutzer, idGruppenrecht) VALUES (IN_idGruppe, IN_idBenutzer, rechtid);
END IF;

SELECT anzahl;

END $$
/*!50003 SET SESSION SQL_MODE=@TEMP_SQL_MODE */  $$

DELIMITER ;



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
