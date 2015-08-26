-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 22, 2010 at 07:47 AM
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
-- Table structure for table `mesPerguntaAlternativa`
--

CREATE TABLE IF NOT EXISTS `mesPerguntaAlternativa` (
  `CodPergunta` int(10) unsigned NOT NULL COMMENT 'Código da pergunta',
  `GrupoAlternativa` varchar(100) NOT NULL COMMENT 'Grupo das alternativas',
  PRIMARY KEY  (`CodPergunta`,`GrupoAlternativa`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relação entre as perguntas e as alternativas';

--
-- Dumping data for table `mesPerguntaAlternativa`
--

