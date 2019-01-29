-- MySQL Script generated by MySQL Workbench
-- mar. 29 janv. 2019 10:29:39 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema quizcodac
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema quizcodac
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `quizcodac` DEFAULT CHARACTER SET utf8 ;
USE `quizcodac` ;

-- -----------------------------------------------------
-- Table `quizcodac`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`users` (
  `idusers` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `genre` VARCHAR(45) NOT NULL,
  `mail` VARCHAR(50) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `QPV` TINYINT(1) NULL,
  `RQTH` TINYINT(1) NULL,
  `actif` TINYINT(1) NULL,
  `tiers_temps` TINYINT(1) NULL,
  `is_admin` TINYINT(1) NULL,
  PRIMARY KEY (`idusers`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`quiz` (
  `idquiz` INT NOT NULL AUTO_INCREMENT,
  `duree` VARCHAR(45) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idquiz`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`questions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`questions` (
  `idquestions` INT NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(255) NOT NULL,
  `reponse1` VARCHAR(255) NOT NULL,
  `reponse2` VARCHAR(255) NOT NULL,
  `reponse3` VARCHAR(255) NOT NULL,
  `reponse4` VARCHAR(255) NOT NULL,
  `bonnerep` VARCHAR(255) NOT NULL,
  `quiz_idquiz` INT NOT NULL,
  PRIMARY KEY (`idquestions`, `quiz_idquiz`),
  INDEX `fk_questions_quiz1_idx` (`quiz_idquiz` ASC),
  CONSTRAINT `fk_questions_quiz1`
    FOREIGN KEY (`quiz_idquiz`)
    REFERENCES `quizcodac`.`quiz` (`idquiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`tags` (
  `idtags` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idtags`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`scores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`scores` (
  `idscores` INT NOT NULL AUTO_INCREMENT,
  `score` INT NOT NULL,
  `temps` VARCHAR(45) NOT NULL,
  `users_idusers` INT NOT NULL,
  `quiz_idquiz` INT NOT NULL,
  `tags_idtags` INT NOT NULL,
  PRIMARY KEY (`idscores`, `users_idusers`, `quiz_idquiz`, `tags_idtags`),
  INDEX `fk_scores_users1_idx` (`users_idusers` ASC),
  INDEX `fk_scores_quiz1_idx` (`quiz_idquiz` ASC),
  INDEX `fk_scores_tags1_idx` (`tags_idtags` ASC),
  CONSTRAINT `fk_scores_users1`
    FOREIGN KEY (`users_idusers`)
    REFERENCES `quizcodac`.`users` (`idusers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_scores_quiz1`
    FOREIGN KEY (`quiz_idquiz`)
    REFERENCES `quizcodac`.`quiz` (`idquiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_scores_tags1`
    FOREIGN KEY (`tags_idtags`)
    REFERENCES `quizcodac`.`tags` (`idtags`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`commentaires`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`commentaires` (
  `idcommentaires` INT NOT NULL AUTO_INCREMENT,
  `commentaire` TEXT NOT NULL,
  `users_idusers` INT NOT NULL,
  `quiz_idquiz` INT NOT NULL,
  PRIMARY KEY (`idcommentaires`, `users_idusers`, `quiz_idquiz`),
  INDEX `fk_commentaires_users1_idx` (`users_idusers` ASC),
  INDEX `fk_commentaires_quiz1_idx` (`quiz_idquiz` ASC),
  CONSTRAINT `fk_commentaires_users1`
    FOREIGN KEY (`users_idusers`)
    REFERENCES `quizcodac`.`users` (`idusers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaires_quiz1`
    FOREIGN KEY (`quiz_idquiz`)
    REFERENCES `quizcodac`.`quiz` (`idquiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`users_has_quiz`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`users_has_quiz` (
  `users_idusers` INT NOT NULL,
  `quiz_idquiz` INT NOT NULL,
  `quiz_done` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`users_idusers`, `quiz_idquiz`),
  INDEX `fk_users_has_quiz_quiz1_idx` (`quiz_idquiz` ASC),
  INDEX `fk_users_has_quiz_users_idx` (`users_idusers` ASC),
  CONSTRAINT `fk_users_has_quiz_users`
    FOREIGN KEY (`users_idusers`)
    REFERENCES `quizcodac`.`users` (`idusers`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_quiz_quiz1`
    FOREIGN KEY (`quiz_idquiz`)
    REFERENCES `quizcodac`.`quiz` (`idquiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizcodac`.`tags_has_questions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quizcodac`.`tags_has_questions` (
  `tags_idtags` INT NOT NULL,
  `questions_idquestions` INT NOT NULL,
  `questions_quiz_idquiz` INT NOT NULL,
  PRIMARY KEY (`tags_idtags`, `questions_idquestions`, `questions_quiz_idquiz`),
  INDEX `fk_tags_has_questions_questions1_idx` (`questions_idquestions` ASC, `questions_quiz_idquiz` ASC),
  INDEX `fk_tags_has_questions_tags1_idx` (`tags_idtags` ASC),
  CONSTRAINT `fk_tags_has_questions_tags1`
    FOREIGN KEY (`tags_idtags`)
    REFERENCES `quizcodac`.`tags` (`idtags`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tags_has_questions_questions1`
    FOREIGN KEY (`questions_idquestions` , `questions_quiz_idquiz`)
    REFERENCES `quizcodac`.`questions` (`idquestions` , `quiz_idquiz`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
