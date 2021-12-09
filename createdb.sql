-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema neo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema neo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `neo` DEFAULT CHARACTER SET utf8mb4 ;
USE `neo` ;

-- -----------------------------------------------------
-- Table `neo`.`activity`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`activity` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(16) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `date` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 23
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`activityParticipant`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`activityParticipant` (
  `memberId` INT(11) NOT NULL,
  `activityId` INT(11) NOT NULL,
  PRIMARY KEY (`memberId`, `activityId`),
  INDEX `activity_id_fk` (`activityId` ASC) VISIBLE,
  CONSTRAINT `activity_id_fk`
    FOREIGN KEY (`activityId`)
    REFERENCES `neo`.`activity` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`activityType`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`activityType` (
  `activityId` INT(11) NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`activityId`),
  UNIQUE INDEX `type` (`type` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`adress`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`adress` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `street` VARCHAR(255) NOT NULL,
  `postalCode` INT(11) NOT NULL,
  `city` VARCHAR(255) NOT NULL,
  UNIQUE INDEX `id` (`id` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 58
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`member`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`member` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(255) NOT NULL,
  `lastname` VARCHAR(255) NOT NULL,
  `phonenumber` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `gender` ENUM('male', 'female') NULL DEFAULT NULL,
  `adressId` INT(11) NOT NULL,
  `dateCreated` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  INDEX `member_ibfk_1` (`adressId` ASC) VISIBLE,
  CONSTRAINT `member_ibfk_1`
    FOREIGN KEY (`adressId`)
    REFERENCES `neo`.`adress` (`id`)
    ON DELETE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 24
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`admin` (
  `memberId` INT(11) NOT NULL,
  PRIMARY KEY (`memberId`),
  CONSTRAINT `admin_ibfk_1`
    FOREIGN KEY (`memberId`)
    REFERENCES `neo`.`member` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`contingencyStatus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`contingencyStatus` (
  `memberId` INT(11) NOT NULL,
  `date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `status` ENUM('PAID', 'UNPAID') NOT NULL,
  PRIMARY KEY (`memberId`, `date`, `status`),
  CONSTRAINT `contingencyStatus_ibfk_1`
    FOREIGN KEY (`memberId`)
    REFERENCES `neo`.`member` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`interest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`interest` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`memberInterest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`memberInterest` (
  `memberId` INT(11) NOT NULL,
  `interestId` INT(11) NOT NULL,
  PRIMARY KEY (`memberId`, `interestId`),
  INDEX `memberInterest_ibfk_2` (`interestId` ASC) VISIBLE,
  CONSTRAINT `memberInterest_ibfk_1`
    FOREIGN KEY (`memberId`)
    REFERENCES `neo`.`member` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `memberInterest_ibfk_2`
    FOREIGN KEY (`interestId`)
    REFERENCES `neo`.`interest` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `neo`.`pastMember`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `neo`.`pastMember` (
  `memberId` INT(11) NOT NULL,
  PRIMARY KEY (`memberId`),
  CONSTRAINT `pastMember_ibfk_1`
    FOREIGN KEY (`memberId`)
    REFERENCES `neo`.`member` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;