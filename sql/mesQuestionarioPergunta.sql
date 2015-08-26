-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:48 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `graebinn_regisls`
--

-- --------------------------------------------------------

--
-- Table structure for table `mesQuestionarioPergunta`
--

CREATE TABLE IF NOT EXISTS `mesQuestionarioPergunta` (
  `CodQuestionario` int(10) unsigned NOT NULL COMMENT 'Código do questionário',
  `CodPergunta` int(10) unsigned NOT NULL COMMENT 'Código da pergunta',
  PRIMARY KEY  (`CodQuestionario`,`CodPergunta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relação entre os questionarios e as perguntas';

--
-- Dumping data for table `mesQuestionarioPergunta`
--

