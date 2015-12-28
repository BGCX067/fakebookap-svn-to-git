SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `fakebook` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `fakebook`;

-- -----------------------------------------------------
-- Table `fakebook`.`Benutzer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Benutzer` (
  `idBenutzer` INT NOT NULL AUTO_INCREMENT ,
  `Vorname` VARCHAR(40) NOT NULL ,
  `Nachname` VARCHAR(40) NOT NULL ,
  `Email` VARCHAR(100) NOT NULL ,
  `Passwort` VARCHAR(30) NOT NULL ,
  PRIMARY KEY (`idBenutzer`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Informationsname`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Informationsname` (
  `idInformationsname` INT NOT NULL AUTO_INCREMENT ,
  `Bezeichnung` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idInformationsname`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Benutzerinformation`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Benutzerinformation` (
  `idBenutzerinformation` INT NOT NULL AUTO_INCREMENT ,
  `idBenutzer` INT NOT NULL ,
  `Wert` TEXT NOT NULL ,
  `idInformationsname` INT NOT NULL ,
  PRIMARY KEY (`idBenutzerinformation`) ,
  INDEX `fk_Benutzerinformation_Benutzer1` (`idBenutzer` ASC) ,
  INDEX `fk_Benutzerinformation_Informationsname1` (`idInformationsname` ASC) ,
  CONSTRAINT `fk_Benutzerinformation_Benutzer1`
    FOREIGN KEY (`idBenutzer` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Benutzerinformation_Informationsname1`
    FOREIGN KEY (`idInformationsname` )
    REFERENCES `fakebook`.`Informationsname` (`idInformationsname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Nachricht`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Nachricht` (
  `idNachricht` INT NOT NULL AUTO_INCREMENT ,
  `idBenutzerFrom` INT NOT NULL ,
  `idBenutzerTo` INT NOT NULL ,
  `Nachricht` TEXT NOT NULL ,
  `Betreff` VARCHAR(100) NULL ,
  `Datum` DATETIME NOT NULL ,
  `idParent` INT NULL ,
  `Gelesen` TINYINT(1) NOT NULL DEFAULT false ,
  `HiddenFrom` TINYINT(1) NOT NULL DEFAULT false ,
  `HiddenTo` TINYINT(1) NOT NULL DEFAULT false ,
  PRIMARY KEY (`idNachricht`) ,
  INDEX `fk_Nachricht_BenutzerFrom` (`idBenutzerFrom` ASC) ,
  INDEX `fk_Nachricht_BenutzerTo` (`idBenutzerTo` ASC) ,
  INDEX `fk_Nachricht_idParent` (`idParent` ASC) ,
  CONSTRAINT `fk_Nachricht_BenutzerFrom`
    FOREIGN KEY (`idBenutzerFrom` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nachricht_BenutzerTo`
    FOREIGN KEY (`idBenutzerTo` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Nachricht_idParent`
    FOREIGN KEY (`idParent` )
    REFERENCES `fakebook`.`Nachricht` (`idNachricht` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Meldung`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Meldung` (
  `idMeldung` INT NOT NULL AUTO_INCREMENT ,
  `Meldung` VARCHAR(200) NOT NULL ,
  `idBenutzer` INT NOT NULL ,
  `Datum` DATETIME NOT NULL ,
  PRIMARY KEY (`idMeldung`) ,
  INDEX `fk_Meldung_Benutzer1` (`idBenutzer` ASC) ,
  CONSTRAINT `fk_Meldung_Benutzer1`
    FOREIGN KEY (`idBenutzer` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Beziehungstyp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Beziehungstyp` (
  `idBeziehungstyp` INT NOT NULL AUTO_INCREMENT ,
  `Beziehung` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idBeziehungstyp`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Beziehung`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Beziehung` (
  `idBeziehung` INT NOT NULL AUTO_INCREMENT ,
  `idBeziehungstyp` INT NOT NULL ,
  `idBenutzerFrom` INT NOT NULL ,
  `idBenutzerTo` INT NULL ,
  PRIMARY KEY (`idBeziehung`) ,
  INDEX `fk_Beziehung_Beziehungstyp` (`idBeziehungstyp` ASC) ,
  INDEX `fk_Beziehung_BenutzerFrom` (`idBenutzerFrom` ASC) ,
  INDEX `fk_Beziehung_BenutzerTo` (`idBenutzerTo` ASC) ,
  CONSTRAINT `fk_Beziehung_Beziehungstyp`
    FOREIGN KEY (`idBeziehungstyp` )
    REFERENCES `fakebook`.`Beziehungstyp` (`idBeziehungstyp` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Beziehung_BenutzerFrom`
    FOREIGN KEY (`idBenutzerFrom` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Beziehung_BenutzerTo`
    FOREIGN KEY (`idBenutzerTo` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Kommentar`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Kommentar` (
  `idKommentar` INT NOT NULL AUTO_INCREMENT ,
  `idBenutzer` INT NOT NULL ,
  `Kommentar` TEXT NOT NULL ,
  `Datum` DATETIME NOT NULL ,
  `idMeldung` INT NOT NULL ,
  PRIMARY KEY (`idKommentar`) ,
  INDEX `fk_Kommentar_Benutzer` (`idBenutzer` ASC) ,
  INDEX `fk_Kommentar_Meldung1` (`idMeldung` ASC) ,
  CONSTRAINT `fk_Kommentar_Benutzer`
    FOREIGN KEY (`idBenutzer` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Kommentar_Meldung1`
    FOREIGN KEY (`idMeldung` )
    REFERENCES `fakebook`.`Meldung` (`idMeldung` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Gruppentyp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Gruppentyp` (
  `idGruppentyp` INT NOT NULL AUTO_INCREMENT ,
  `Typ` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idGruppentyp`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Gruppe`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Gruppe` (
  `idGruppe` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(60) NOT NULL ,
  `Beschreibung` TEXT NULL ,
  `idGruppentyp` INT NOT NULL ,
  PRIMARY KEY (`idGruppe`) ,
  INDEX `fk_Gruppe_Gruppentyp1` (`idGruppentyp` ASC) ,
  CONSTRAINT `fk_Gruppe_Gruppentyp1`
    FOREIGN KEY (`idGruppentyp` )
    REFERENCES `fakebook`.`Gruppentyp` (`idGruppentyp` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Gruppenrecht`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Gruppenrecht` (
  `idGruppenrecht` INT NOT NULL AUTO_INCREMENT ,
  `Recht` VARCHAR(30) NOT NULL ,
  PRIMARY KEY (`idGruppenrecht`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Gruppenmitglied`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Gruppenmitglied` (
  `idGruppenmitglied` INT NOT NULL AUTO_INCREMENT ,
  `idGruppe` INT NOT NULL ,
  `idBenutzer` INT NOT NULL ,
  `idGruppenrecht` INT NOT NULL ,
  PRIMARY KEY (`idGruppenmitglied`) ,
  INDEX `fk_Gruppenmitglied_Gruppe` (`idGruppe` ASC) ,
  INDEX `fk_Gruppenmitglied_Benutzer` (`idBenutzer` ASC) ,
  INDEX `fk_Gruppenmitglied_Gruppenrecht` (`idGruppenrecht` ASC) ,
  CONSTRAINT `fk_Gruppenmitglied_Gruppe`
    FOREIGN KEY (`idGruppe` )
    REFERENCES `fakebook`.`Gruppe` (`idGruppe` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gruppenmitglied_Benutzer`
    FOREIGN KEY (`idBenutzer` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Gruppenmitglied_Gruppenrecht`
    FOREIGN KEY (`idGruppenrecht` )
    REFERENCES `fakebook`.`Gruppenrecht` (`idGruppenrecht` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fakebook`.`Freundschaft`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `fakebook`.`Freundschaft` (
  `idFreundschaft` INT NOT NULL AUTO_INCREMENT ,
  `idBenutzerFrom` INT NOT NULL ,
  `idBenutzerTo` INT NOT NULL ,
  `Status` TINYINT(1) NOT NULL ,
  PRIMARY KEY (`idFreundschaft`) ,
  INDEX `fk_Freundschaft_BenutzerFrom` (`idBenutzerFrom` ASC) ,
  INDEX `fk_Freundschaft_BenutzerTo` (`idBenutzerTo` ASC) ,
  CONSTRAINT `fk_Freundschaft_BenutzerFrom`
    FOREIGN KEY (`idBenutzerFrom` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Freundschaft_BenutzerTo`
    FOREIGN KEY (`idBenutzerTo` )
    REFERENCES `fakebook`.`Benutzer` (`idBenutzer` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
